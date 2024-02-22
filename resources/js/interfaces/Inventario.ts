import { Almacen } from "./Almacen";
import { Producto } from "./Producto";

export interface Inventario {
  almacen_id: number;
  cantidad: number;
  created_at: string;
  id: number;
  producto_id: number;
  updated_at: string;
  producto: Producto;
  almacen: Almacen;
}
