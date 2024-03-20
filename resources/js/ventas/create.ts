import { Entidad, Inventario } from "../interfaces";
import { Autocomplete } from "../utils/Autocomplete";
import { TablePayments } from "../utils/TablePayments";
import { TableItems } from "../utils/TableItems";
import { showError, showSuccess } from "../utils/Swal";
import { TipoDocumento } from "../interfaces/TipoDocumento";
import { TypeDocumentSelector } from "../utils/TypeDocumentSelector";
import { Terms } from "../utils/Terms";

declare const entidades: Entidad[];
declare const tiposIGV: any[];
declare const tipoCambioDolar: string;
declare const inventarios: Inventario[];
declare const urlPost: string;
declare const urlRedirect: string;
declare const tiposDocumento: TipoDocumento[];

//* ENTIDAD
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
    const $documento = $cliente.querySelector(".documento") as HTMLLabelElement;
    const $direccion = $cliente.querySelector(".direccion") as HTMLLabelElement;
    const $descuento = $cliente.querySelector(".descuento") as HTMLLabelElement;
    const $retencion = $cliente.querySelector(".retencion") as HTMLLabelElement;

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

//* ITEMS
const tableItems = new TableItems({
  id: "tabla-items",
  tiposIGV: tiposIGV,
  tipoCambioDolar: parseFloat(tipoCambioDolar),
});

new Autocomplete<Inventario>({
  id: "autocomplete-inventarios",
  preserve: false,
  allOptions: inventarios.map((inventario) => ({
    value: inventario.id,
    text: ` ${inventario.producto.codigo} - ${inventario.producto.nombre} - ${inventario.almacen.nombre} - ${inventario.cantidad}`,
    data: inventario,
  })),
  onSelect(data) {
    tableItems.addItem(data);
  },
});

//* MONEDA
const $moneda = document.getElementById("moneda_id") as HTMLSelectElement;
handleChangeMoneda();
$moneda?.addEventListener("change", () => {
  handleChangeMoneda();
});
function handleChangeMoneda() {
  tableItems.setMonedaId(parseInt($moneda.value));
  const simbolo = $moneda.options[$moneda.selectedIndex].dataset.simbolo;
  const $simbolos = document.querySelectorAll(
    ".simbolo_moneda"
  ) as NodeListOf<HTMLElement>;
  $simbolos.forEach((el) => {
    el.innerHTML = simbolo ?? "";
  });
}

//* FECHAs Y PLAZO

const terms = new Terms();

//* TIPO DOCUMENTO

new TypeDocumentSelector(tiposDocumento);

//* PAGOS
const tablePayments = new TablePayments({
  getTotalPagar: () => tableItems.getTotal(),
  getFechaEmision: () => terms.getFechaEmision(),
});

//* FORMULARIO
const $form = document.getElementById("form") as HTMLFormElement;
$form.addEventListener("submit", async (e) => {
  try {
    e.preventDefault();

    const formData = new FormData($form);

    const data = {
      ...Object.fromEntries(formData),
      items: tableItems.getItems(),
      pagos: tablePayments.getPayments(),
    };

    console.log(data);

    const resp = await fetch(urlPost, {
      method: "POST",
      body: JSON.stringify(data),
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
      },
    });
    const json = await resp.json();

    console.log(json);

    if (resp.ok) {
      showSuccess(json.message, () => {
        window.location.href = urlRedirect;
      });
    } else {
      showError(json.message);
    }
  } catch (error) {
    console.log(error);
    showError(error.message);
  }
});
