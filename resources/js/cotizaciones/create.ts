import { TableItems } from "../utils/TableItems";
import { Autocomplete } from "../utils/Autocomplete";

//Funcion de agregar nuevos items
declare global {
  interface Window {
    productosACD: [any];
    tiposIGV: [any];
    tipoCambioDolar: string;
  }
}

//Entidades
new Autocomplete({
  id: "autocomplete-entidades",
});

// Tabla de items
const tableItems = new TableItems({
  id: "tabla-items",
  tiposIGV: window.tiposIGV,
  tipoCambioDolar: parseFloat(window.tipoCambioDolar),
});

new Autocomplete({
  id: "autocomplete-productos",
  preserve: false,
  data: window.productosACD,
  onSelect(item) {
    tableItems.addItem(item.data);
  },
});

const $moneda = document.getElementById("moneda") as HTMLSelectElement;
const $simboloMoneda = document.querySelectorAll(
  ".simbolo_moneda"
) as NodeListOf<HTMLElement>;
tableItems.setMonedaId(parseInt($moneda.value));
$moneda?.addEventListener("change", () => {
  tableItems.setMonedaId(parseInt($moneda.value));
  $simboloMoneda.forEach((el) => {
    el.innerHTML = $moneda.value === "1" ? "S/." : "$";
  });
});

// Formulario
const $form = document.getElementById("form") as HTMLFormElement;
$form.addEventListener("submit", (e) => {
  e.preventDefault();

  const formData = new FormData($form);

  const data = {
    ...Object.fromEntries(formData),
    items: tableItems.getItems(),
  };

  console.log(data);
  //TODO: Enviar los datos al backend
});
