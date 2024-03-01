import { Cotizacion, Entidad, Inventario, OrdenVenta, Producto } from "./interfaces";

declare global {
  interface Window {
    productos: [Producto];
    inventarios: [Inventario];
    tiposIGV: [any];
    tipoCambioDolar: string;
    entidades: [Entidad];
    ordenVentaBase?: OrdenVenta;
    urlStore: string;
    urlIndex: string;
    cotizacionBase?: Cotizacion;
  }
}
