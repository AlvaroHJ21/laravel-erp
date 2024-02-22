export interface Producto {
  id: number;
  codigo: string;
  nombre: string;
  imagen: null;
  categoria_id: number;
  moneda_id: number;
  unidad_id: number;
  tipo_igv_id: number;
  precio_compra: number;
  precio_venta: number;
  valor_venta: number;
  user_id: number;
  updated_at: string;
  created_at: string;
}
