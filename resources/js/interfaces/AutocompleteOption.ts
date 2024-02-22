export interface AutocompleteOption<T = any> {
  value: string | number;
  text: string;
  filter?: string | number;
  data: T;
}
