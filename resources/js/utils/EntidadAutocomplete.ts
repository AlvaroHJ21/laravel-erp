import { Entidad } from "../interfaces";
import { Autocomplete } from "./Autocomplete";

export class EntidadAutocomplete {
  private autocomplete: Autocomplete<Entidad>;

  constructor(entidades: Entidad[]) {
    const entidadAutocomplete = new Autocomplete<Entidad>({
      id: "autocomplete-entidades",
      allOptions: entidades.map((entidad) => ({
        value: entidad.id,
        text: entidad.nombre + " - " + entidad.numero_documento,
        data: entidad,
      })),
      onSelect(data) {
        const $cliente = document.getElementById("cliente") as HTMLDivElement;
        $cliente.classList.remove("d-none");

        const $nombre = $cliente.querySelector(".nombre") as HTMLLabelElement;
        const $documento = $cliente.querySelector(
          ".documento"
        ) as HTMLLabelElement;
        const $direccion = $cliente.querySelector(
          ".direccion"
        ) as HTMLLabelElement;
        const $descuento = $cliente.querySelector(
          ".descuento"
        ) as HTMLLabelElement;
        const $retencion = $cliente.querySelector(
          ".retencion"
        ) as HTMLLabelElement;

        $nombre.innerHTML = data.nombre;
        $documento.innerHTML = data.numero_documento;
        $direccion.innerHTML = data.direccion;
        $descuento.innerHTML = data.porcentaje_descuento;
        $retencion.innerHTML = data.retencion ? "Sí" : "No";
      },
      onDiselect() {
        const $cliente = document.getElementById("cliente") as HTMLDivElement;

        $cliente.classList.add("d-none");
      },
    });

    this.autocomplete = entidadAutocomplete;
  }

  public getEntidad(): Entidad {
    const data = this.autocomplete.getSelectedData();
    if (!data) {
      throw new Error("El cliente es requerido");
    }
    return data;
  }

  public setEntidad(entidad: Entidad) {
    this.autocomplete.handleSelect({
      data: entidad,
      text: entidad.nombre + " - " + entidad.numero_documento,
      value: entidad.id,
    });
  }
}
