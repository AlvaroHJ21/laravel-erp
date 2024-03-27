import {
  EntidadAutocomplete,
  InventarioAutocomplete,
  MonedaSelector,
  TableItems,
  TablePayments,
  Terms,
  TypeDocumentSelector,
  showError,
  showSuccess,
} from "../utils";

import type {
  Entidad,
  Inventario,
  OrdenVenta,
  TipoDocumento,
  Venta,
} from "../interfaces";

declare const entidades: Entidad[];
declare const tiposIGV: any[];
declare const tipoCambioDolar: string;
declare const inventarios: Inventario[];
declare const urlPost: string;
declare const urlRedirect: string;
declare const tiposDocumento: TipoDocumento[];
declare const base: Venta | null;
declare const ordenVenta: OrdenVenta | null;

//* ENTIDAD
const entidadAutocomplete = new EntidadAutocomplete(entidades);

//* ITEMS
const tableItems = new TableItems({
  tiposIGV: tiposIGV,
  tipoCambioDolar: parseFloat(tipoCambioDolar),
});

//* INVENTARIOS
new InventarioAutocomplete(inventarios, {
  onSelect(data) {
    tableItems.addItem(data);
  },
});

//* MONEDA
new MonedaSelector({
  onChangeMoneda(monedaId) {
    tableItems.setMonedaId(monedaId);
  },
});

//* FECHAS Y PLAZO
const terms = new Terms();

//* TIPO DOCUMENTO
const tipoDocumentoSelector = new TypeDocumentSelector(tiposDocumento);

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

    const entidad = entidadAutocomplete.getEntidad();
    const tipoDocumentoId = tipoDocumentoSelector.getTipoDocumentoId();

    if (entidad.tipo_documento_id == 1 && tipoDocumentoId == 1) {
      throw new Error("No se puede emitir una factura a un cliente con DNI");
    }

    const data = {
      ...Object.fromEntries(formData),
      entidad_id: entidad.id,
      items: tableItems.getItems(),
      pagos: tablePayments.getPayments(),
    };

    if (ordenVenta) {
      data["orden_venta_id"] = ordenVenta.id;
    }

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

//* CARGAR VENTA BASE
if (base) {
  // Cargar los items
  tableItems.setItems(
    base.detalles.map((detalle) => ({
      cantidad: detalle.cantidad,
      codigo: detalle.codigo,
      descripcion_adicional: detalle.descripcion_adicional ?? "",
      id: detalle.inventario_id,
      inventario_id: detalle.producto_id,
      porcentaje_descuento: detalle.porcentaje_descuento,
      producto: detalle.producto,
      producto_id: detalle.producto_id,
      subtotal: detalle.subtotal,
      tipo_igv_id: detalle.tipo_igv_id,
      tipo_igv_porcentaje: detalle.tipo_igv.porcentaje,
      valor_venta: detalle.valor_venta,
    }))
  );

  // Cargar el cliente
  entidadAutocomplete.setEntidad(base.entidad);

  // Cargar los pagos
  if (base.pagos) {
    tablePayments.setPayments(base.pagos);
  }
}

//* CARGAR ORDEN DE VENTA
if (ordenVenta) {
  // Cargar el numero de orden de compra
  const $ordenCompra = document.getElementById(
    "numero_orden_compra"
  ) as HTMLInputElement;
  $ordenCompra.value = ordenVenta.numero_orden_compra;

  // Cargar los items
  tableItems.setItems(
    ordenVenta.detalles.map((detalle) => ({
      cantidad: detalle.cantidad,
      codigo: detalle.codigo,
      descripcion_adicional: detalle.descripcion_adicional ?? "",
      id: detalle.inventario_id,
      inventario_id: detalle.producto_id,
      porcentaje_descuento: detalle.porcentaje_descuento,
      producto: detalle.producto,
      producto_id: detalle.producto_id,
      subtotal: detalle.subtotal,
      tipo_igv_id: detalle.tipo_igv_id,
      tipo_igv_porcentaje: detalle.tipo_igv.porcentaje,
      valor_venta: detalle.valor_venta,
    }))
  );

  // Cargar el cliente
  entidadAutocomplete.setEntidad(ordenVenta.entidad);
}
