import { Inventario } from "./Inventario";
import { Producto } from "./Producto";

export interface TableRow {
  id: number;
  codigo: string;
  producto_id: number;
  inventario_id: number;
  descripcion_adicional: string;
  cantidad: number;
  tipo_igv_id: number;
  tipo_igv_porcentaje: number;
  valor_venta: number;
  subtotal: number;
  porcentaje_descuento: number;
  producto: Producto;
  inventario?: Inventario;
}
