import { Inventario } from "../interfaces";
import { Autocomplete } from "./Autocomplete";

interface Options {
  onSelect?(data: Inventario): void;
}

export class InventarioAutocomplete {
  constructor(inventarios: Inventario[], { onSelect }: Options = {}) {
    new Autocomplete<Inventario>({
      id: "autocomplete-inventarios",
      preserve: false,
      allOptions: inventarios.map((inventario) => ({
        value: inventario.id,
        text: ` ${inventario.producto.codigo} - ${inventario.producto.nombre} - ${inventario.almacen.nombre} - ${inventario.cantidad}`,
        data: inventario,
      })),
      onSelect,
    });
  }
}
