import { renderAutocomplete } from "../utils/renderAutocomplete";

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
  renderAutocomplete({
    id: "inventario-autocomplete",
    filter: almacenId,
    onSelect(selected) {
      const cantidadInput = document.getElementById(
        "cantidad_actual"
      ) as HTMLInputElement;
      cantidadInput.value = selected.meta;
    },
    onDiselect() {},
  });
}
