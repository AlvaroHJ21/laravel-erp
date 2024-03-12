interface Payment {
  id: number;
  fecha: string;
  monto: number;
}

export class TablePayments {
  private $selectFormapagoId: HTMLSelectElement;
  private $pagosContainer: HTMLDivElement;
  private $pagosList: HTMLDivElement;
  private $pagosbtnAdd: HTMLButtonElement;
  private cuotas: Payment[] = [];

  constructor() {
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

    this.init();
    this.startListeners();
    this.render();
  }

  init() {
    if (this.$selectFormapagoId.value == "1") {
      this.$pagosContainer.style.display = "none";
    }
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
      this.cuotas.push({ id: 0, fecha: "", monto: 0 });
      this.render();
    });
  }

  render() {
    this.$pagosList.innerHTML = this.cuotas
      .map((cuota) => {
        const today = new Date().toISOString().split("T")[0];

        if (cuota.fecha.length === 0) cuota.fecha = today;

        return `
              <div class="d-flex gap-2 mb-3">
                <input type="date" class="form-control fecha" value="${cuota.fecha}" />
                <input type="number" class="form-control monto" value="${cuota.monto}"/>
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
        this.cuotas[index].fecha = $fechaInput.value;
      });
    });
    $montoInputs.forEach(($montoInput, index) => {
      $montoInput.addEventListener("change", (e) => {
        this.cuotas[index].monto = +$montoInput.value;
      });
    });
    $removeBtns.forEach(($removeBtn, index) => {
      $removeBtn.addEventListener("click", (e) => {
        this.cuotas.splice(index, 1);
        this.render();
      });
    });
  }

  getPayments() {
    return this.cuotas;
  }
}
