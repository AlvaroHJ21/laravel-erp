import { Entidad } from "./Entidad";
import { Moneda } from "./Moneda";
import { Producto } from "./Producto";
import { TipoIgv } from "./TipoIgv";

export interface OrdenVenta {
  id: number;
  entidad_id: number;
  moneda_id: number;
  total_gravada: number;
  total_igv: number;
  total_pagar: number;
  nota?: string;
  estado: null;
  enviado_cliente: number;
  user_id: number;
  created_at: string;
  updated_at: string;
  entidad: Entidad;
  moneda: Moneda;
  detalles: [OrdenVentaDetalle];

  numero_orden_compra: string;
}

export interface OrdenVentaDetalle {
  id: number;
  cotizacion_id: number;
  producto_id: number;
  inventario_id: number;
  producto: Producto;
  tipo_igv: TipoIgv;
  descripcion_adicional?: string;
  codigo: string;
  cantidad: number;
  valor_venta: number;
  subtotal: number;
  tipo_igv_id: number;
  porcentaje_descuento: number;
  created_at: string;
  updated_at: string;
}
