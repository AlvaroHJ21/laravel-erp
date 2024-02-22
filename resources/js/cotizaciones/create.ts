import { TableItems } from "../utils/TableItems";
import { Autocomplete } from "../utils/Autocomplete";
import { showError, showSuccess } from "../utils/Swal";
import type { Entidad, Producto } from "../interfaces";

//Funcion de agregar nuevos items
declare global {
  interface Window {
    productos: [Producto];
    tiposIGV: [any];
    tipoCambioDolar: string;
    entidades: [Entidad];
  }
}

console.log(window.entidades);

//Entidades
new Autocomplete<Entidad>({
  id: "autocomplete-entidades",
  allOptions: window.entidades.map((entidad) => ({
    value: entidad.id,
    text: entidad.nombre,
    data: entidad,
  })),
  onSelect(data) {
    console.log(data);

    const $cliente = document.getElementById("cliente") as HTMLDivElement;
    $cliente.classList.remove("d-none");

    const $nombre = $cliente.querySelector(".nombre") as HTMLInputElement;
    const $documento = $cliente.querySelector(".documento") as HTMLInputElement;
    const $direccion = $cliente.querySelector(".direccion") as HTMLInputElement;
    const $descuento = $cliente.querySelector(".descuento") as HTMLInputElement;
    const $retencion = $cliente.querySelector(".retencion") as HTMLInputElement;

    $nombre.value = data.nombre;
    $documento.value = data.numero_documento;
    $direccion.value = data.direccion;
    $descuento.value = data.porcentaje_descuento;
    $retencion.value = data.retencion ? "Sí" : "No";
  },
  onDiselect() {
    const $cliente = document.getElementById("cliente") as HTMLDivElement;

    $cliente.classList.add("d-none");
  },
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

// Moneda
const $moneda = document.getElementById("moneda_id") as HTMLSelectElement;
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
$form.addEventListener("submit", async (e) => {
  e.preventDefault();

  const formData = new FormData($form);

  const data = {
    ...Object.fromEntries(formData),
    items: tableItems.getItems(),
  };

  const resp = await fetch("/cotizaciones", {
    method: "POST",
    body: JSON.stringify(data),
    headers: {
      "Content-Type": "application/json",
    },
  });
  const json = await resp.json();

  if (json.ok) {
    showSuccess(json.message, () => {
      window.location.href = "/ventas/cotizaciones";
    });
  } else {
    showError(json.error);
  }
});
