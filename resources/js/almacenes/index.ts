import type { Inventario } from "../interfaces";
import { Autocomplete } from "../utils/Autocomplete";

declare const inventarios: Inventario[];

//AUTOCOMPLETE ALMACEN
const $almacenOrigenSelect = document.getElementById(
  "almacen_origen_id"
) as HTMLSelectElement;

renderAutocompleteByAlmacenId($almacenOrigenSelect?.value);

$almacenOrigenSelect?.addEventListener("change", (e) => {
  const almacenId = $almacenOrigenSelect.value;

  renderAutocompleteByAlmacenId(almacenId);
});

function renderAutocompleteByAlmacenId(almacenId) {
  new Autocomplete<Inventario>({
    id: "inventario-autocomplete",
    filter: almacenId,
    allOptions: inventarios.map((inventario) => ({
      value: inventario.id,
      text: inventario.producto.nombre,
      filter: inventario.almacen_id,
      data: inventario,
    })),
    onSelect(data) {
      const $cantidad = document.getElementById(
        "cantidad_actual"
      ) as HTMLInputElement;
      $cantidad.value = data.cantidad.toString();
    },
    onDiselect() {
      const $cantidad = document.getElementById(
        "cantidad_actual"
      ) as HTMLInputElement;
      $cantidad.value = "";
    },
  });
}
