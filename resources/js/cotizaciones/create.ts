import { renderAutocomplete } from "../utils/renderAutocomplete";
import { addItem } from "../utils/addItem";

// Autocomplete Entidades
renderAutocomplete({
  id: "autocomplete-entidades",
});

//Funcion de agregar nuevos items
declare global {
  interface Window {
    productosACD: [any];
  }
}
const $btnAddItem = document.getElementById("btn-add-item");
$btnAddItem?.addEventListener("click", function () {
  addItem({
    autocompleteData: window.productosACD,
  });
});
