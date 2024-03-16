import { Serie } from "./Serie";

export interface TipoDocumento {
  id: number;
  codigo: number;
  nombre: string;
  abreviado: string;
  series: Serie[];
}
