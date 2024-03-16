import { Serie } from "../interfaces/Serie";
import { TipoDocumento } from "../interfaces/TipoDocumento";

export class TypeDocumentSelector {
  private tiposDocumento: TipoDocumento[];
  private $tipoDocumentoId: HTMLSelectElement;
  private $serieId: HTMLSelectElement;
  private $numero: HTMLInputElement;

  constructor(tiposDocumento: TipoDocumento[]) {
    this.tiposDocumento = tiposDocumento;

    this.$tipoDocumentoId = document.getElementById(
      "tipo_documento_id"
    ) as HTMLSelectElement;

    this.$serieId = document.getElementById("serie_id") as HTMLSelectElement;

    this.$numero = document.getElementById("numero") as HTMLInputElement;

    this.init();
    this.addListener();
    this.renderTipos();
  }

  init() {
    this.renderSeries(this.tiposDocumento[0].series);
  }

  addListener() {
    this.$tipoDocumentoId.addEventListener("change", () => {
      const tipo = this.tiposDocumento.find(
        (t) => t.id === parseInt(this.$tipoDocumentoId.value)
      );

      if (tipo) {
        this.renderSeries(tipo.series);
      }
    });
  }

  renderTipos() {
    this.$tipoDocumentoId.innerHTML = this.tiposDocumento
      .map((tipoDocumento) => {
        return `<option value="${tipoDocumento.id}">${tipoDocumento.nombre}</option>`;
      })
      .join("");
  }

  renderSeries(series: Serie[]) {
    this.$serieId.innerHTML = series
      .map((serie) => {
        return `<option value="${serie.id}">${serie.serie}</option>`;
      })
      .join("");

    this.renderNumero(series[0].ultimo_numero + 1);
    this.$serieId.addEventListener("change", () => {
      const serie = series.find((s) => s.id === parseInt(this.$serieId.value));
      if (serie) {
        this.renderNumero(serie.ultimo_numero + 1);
      }
    });
  }

  renderNumero(numero: number) {
    this.$numero.value = numero.toString();
  }
}
