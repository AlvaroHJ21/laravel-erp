import { Entidad } from "./Entidad";
import { Producto } from "./Producto";
export interface Cotizacion {
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
  cliente: Entidad;
  moneda: {
    id: number;
    nombre: "Dólares";
    abreviado: "dol";
    abrstandar: "USD";
    simbolo: "$";
    activo: number;
  };
  detalles: [CotizacionDetalle];
}

export interface CotizacionDetalle {
  id: number;
  cotizacion_id: number;
  producto_id: number;
  producto: Producto;
  descripcion_adicional?: string;
  codigo: "P002";
  cantidad: number;
  valor_venta: number;
  subtotal: number;
  tipo_igv_id: number;
  porcentaje_descuento: number;
  created_at: string;
  updated_at: string;
}