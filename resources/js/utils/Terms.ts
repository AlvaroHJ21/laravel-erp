export class Terms {
  private $plazo: HTMLSelectElement;
  private $fechaEmision: HTMLInputElement;
  private $fechaVencimiento: HTMLInputElement;

  constructor() {
    this.$plazo = document.getElementById("plazo") as HTMLSelectElement;
    this.$fechaEmision = document.getElementById(
      "fecha_emision"
    ) as HTMLInputElement;
    this.$fechaVencimiento = document.getElementById(
      "fecha_vencimiento"
    ) as HTMLInputElement;

    this.$plazo.addEventListener("input", this.calcFechaVencimiento.bind(this));
    this.$fechaEmision.addEventListener(
      "input",
      this.calcFechaVencimiento.bind(this)
    );

    this.calcFechaVencimiento();
  }

  private calcFechaVencimiento() {
    const plazo = parseInt(this.$plazo.value);
    const fechaEmision = new Date(this.$fechaEmision.value);
    const fechaVencimiento = new Date(fechaEmision);

    fechaVencimiento.setDate(fechaVencimiento.getDate() + plazo);

    this.$fechaVencimiento.value = fechaVencimiento.toISOString().slice(0, 10);
  }
}
