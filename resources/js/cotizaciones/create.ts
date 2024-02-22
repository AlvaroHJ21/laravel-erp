import { TableItems } from "../utils/TableItems";
import { Autocomplete } from "../utils/Autocomplete";
import type { Entidad, Producto } from "../interfaces";

//Funcion de agregar nuevos items
declare global {
  interface Window {
    entidades: [Entidad];
    productos: [Producto];
    tiposIGV: [any];
    tipoCambioDolar: string;
  }
}

//Entidades
new Autocomplete<Entidad>({
  id: "autocomplete-entidades",
  allOptions: window.entidades.map((entidad) => ({
    value: entidad.id,
    text: entidad.nombre,
    data: entidad,
  })),
});

// Tabla de items
const tableItems = new TableItems({
  id: "tabla-items",
  tiposIGV: window.tiposIGV,
  tipoCambioDolar: parseFloat(window.tipoCambioDolar),
});

new Autocomplete<Producto>({
  id: "autocomplete-productos",
  preserve: false,
  allOptions: window.productos.map((producto) => ({
    value: producto.id,
    text: ` ${producto.codigo} - ${producto.nombre}`,
    data: producto,
  })),
  onSelect(data) {
    tableItems.addItem(data);
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
