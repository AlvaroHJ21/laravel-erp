interface Payment {
  id: number;
  fecha: string;
  monto: number;
}

interface Props {
  getTotalPagar?: () => number;
}

export class TablePayments {
  private $selectFormapagoId: HTMLSelectElement;
  private $pagosContainer: HTMLDivElement;
  private $pagosList: HTMLDivElement;
  private $pagosbtnAdd: HTMLButtonElement;
  private $total: HTMLLabelElement;
  private $pagosBtnBalancear: HTMLButtonElement;
  private payments: Payment[] = [];
  private getTotalPagar: () => number;

  constructor({ getTotalPagar }: Props) {
    this.$selectFormapagoId = document.getElementById(
      "forma_pago_id"
    ) as HTMLSelectElement;

    this.$pagosContainer = document.getElementById(
      "pagos_container"
    ) as HTMLDivElement;

    this.$pagosList = document.getElementById("pagos_list") as HTMLDivElement;

    this.$pagosbtnAdd = document.getElementById(
      "pagos_btn_add"
    ) as HTMLButtonElement;

    this.$pagosBtnBalancear = document.getElementById(
      "pagos_btn_balancear"
    ) as HTMLButtonElement;

    this.$total = document.getElementById("pagos_total") as HTMLLabelElement;

    this.getTotalPagar = getTotalPagar ?? (() => 0);

    this.init();
    this.startListeners();
    this.render();
  }

  init() {
    if (this.$selectFormapagoId.value == "1") {
      this.$pagosContainer.style.display = "none";
    }

    this.payments = [
      {
        id: 0,
        fecha: new Date().toISOString().split("T")[0],
        monto: this.getTotalPagar(),
      },
    ];
  }

  startListeners() {
    this.$selectFormapagoId.addEventListener("change", (e) => {
      if (this.$selectFormapagoId.value == "1") {
        this.$pagosContainer.style.display = "none";
      } else {
        this.$pagosContainer.style.display = "block";
      }
    });

    this.$pagosbtnAdd.addEventListener("click", (e) => {
      e.preventDefault();
      this.payments.push({ id: 0, fecha: "", monto: 0 });
      this.render();
    });

    this.$pagosBtnBalancear.addEventListener("click", (e) => {
      e.preventDefault();
      const total = this.getTotalPagar();
      const monto = parseFloat((total / this.payments.length).toFixed(2));
      const cuotas = this.payments.map((cuota) => ({ ...cuota, monto }));
      const totalCuotas = cuotas.reduce((acc, cuota) => acc + cuota.monto, 0);
      const diferencia = total - totalCuotas;
      cuotas[0].monto += diferencia;
      this.payments = cuotas;
      this.render();
      this.renderTotal();
    });
  }

  render() {
    this.$pagosList.innerHTML = this.payments
      .map((cuota) => {
        const today = new Date().toISOString().split("T")[0];

        if (cuota.fecha.length === 0) cuota.fecha = today;

        return `
              <div class="d-flex gap-2 mb-3">
                <input type="date" class="form-control fecha" value="${cuota.fecha}" />
                <input type="number" class="form-control monto" value="${cuota.monto}" min="0" step="0.01"/>
                <button class="btn btn-outline-danger remove" type="button">
                  x
                </button>
              </div>
              `;
      })
      .join("");

    const $fechaInputs = document.querySelectorAll(
      ".fecha"
    ) as NodeListOf<HTMLInputElement>;
    const $montoInputs = document.querySelectorAll(
      ".monto"
    ) as NodeListOf<HTMLInputElement>;
    const $removeBtns = document.querySelectorAll(
      ".remove"
    ) as NodeListOf<HTMLButtonElement>;

    $fechaInputs.forEach(($fechaInput, index) => {
      $fechaInput.addEventListener("change", (e) => {
        this.payments[index].fecha = $fechaInput.value;
      });
    });
    $montoInputs.forEach(($montoInput, index) => {
      $montoInput.addEventListener("change", (e) => {
        this.payments[index].monto = +$montoInput.value;
        this.renderTotal();
      });
    });
    $removeBtns.forEach(($removeBtn, index) => {
      $removeBtn.addEventListener("click", (e) => {
        this.payments.splice(index, 1);
        this.render();
      });
    });
  }

  renderTotal() {
    this.$total.innerHTML = `Total ${this.payments
      .reduce((acc, cuota) => acc + cuota.monto, 0)
      .toFixed(2)}`;
  }

  getFormaPagoId() {
    return +this.$selectFormapagoId.value;
  }

  getTotal() {
    return this.payments.reduce((acc, cuota) => acc + cuota.monto, 0);
  }

  getPayments() {
    if (this.getFormaPagoId() == 2) {
      // Validar que haya al menos un pago
      if (this.payments.length == 0) {
        throw new Error("Debe agregar al menos un pago");
      }

      const totalPagos = this.getTotal();
      const totalPagar = this.getTotalPagar();

      // Validar que el monto total de los pagos no sea menor al total a pagar
      if (totalPagos < totalPagar) {
        throw new Error(
          "El monto total de los pagos no puede ser menor al total a pagar"
        );
      }

      // Validar que no haya pagos con monto 0
      if (this.payments.some((p) => p.monto == 0)) {
        throw new Error("No puede haber pagos con monto 0");
      }
    }

    return this.payments;
  }
}
