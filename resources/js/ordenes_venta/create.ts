import { TableItems } from "../utils/TableItems";
import { Autocomplete } from "../utils/Autocomplete";
import { showError, showSuccess } from "../utils/Swal";
import type { Entidad, OrdenVenta, Producto } from "../interfaces";

//Funcion de agregar nuevos items
declare global {
  interface Window {
    productos: [Producto];
    tiposIGV: [any];
    tipoCambioDolar: string;
    entidades: [Entidad];
    base?: OrdenVenta;
    urlStore: string;
    urlIndex: string;
  }
}

//* ENTIDAD
const entidadAutocomplete = new Autocomplete<Entidad>({
  id: "autocomplete-entidades",
  allOptions: window.entidades.map((entidad) => ({
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

//* FORMULARIO
const $form = document.getElementById("form") as HTMLFormElement;
$form.addEventListener("submit", async (e) => {
  e.preventDefault();

  const formData = new FormData($form);

  const data = {
    ...Object.fromEntries(formData),
    items: tableItems.getItems(),
  };

  const resp = await fetch(window.urlStore, {
    method: "POST",
    body: JSON.stringify(data),
    headers: {
      "Content-Type": "application/json",
    },
  });
  const json = await resp.json();

  if (json.ok) {
    showSuccess(json.message, () => {
      window.location.href = window.urlIndex;
    });
  } else {
    showError(json.error);
  }
});

//* CARGAR BASE
if (window.base) {
  const cliente = window.base.cliente;
  entidadAutocomplete.handleSelect({
    value: cliente.id,
    text: cliente.nombre + " - " + cliente.numero_documento,
    data: cliente,
  });

  tableItems.setItems(
    window.base.detalles.map((detalle) => ({
      id: detalle.producto_id,
      cantidad: detalle.cantidad,
      codigo: detalle.codigo,
      descripcion_adicional: detalle.descripcion_adicional ?? "",
      inventario_id: 0,
      porcentaje_descuento: detalle.porcentaje_descuento,
      producto: detalle.producto,
      producto_id: detalle.producto_id,
      subtotal: detalle.subtotal,
      tipo_igv_id: detalle.tipo_igv_id,
      tipo_igv_porcentaje: 18,
      valor_venta: detalle.valor_venta,
    }))
  );

  if (window.base.nota) {
    const $nota = document.getElementById("nota") as HTMLTextAreaElement;
    $nota.value = window.base.nota;
  }
}
