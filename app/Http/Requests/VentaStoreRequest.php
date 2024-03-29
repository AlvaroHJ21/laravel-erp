<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VentaStoreRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      "items" => "required|array",
      "items.*.producto_id" => "required",
      "items.*.inventario_id" => "required",
      "items.*.descripcion_adicional" => "nullable|string",
      "items.*.codigo" => "required",
      "items.*.cantidad" => "required",
      "items.*.valor_venta" => "required",
      "items.*.subtotal" => "required",
      "items.*.tipo_igv_id" => "required",
      "items.*.porcentaje_descuento" => "required",

      "serie_id" => "required",
      "tipo_documento_id" => "required",

      "numero_orden_compra" => "nullable",
      "entidad_id" => "required",
      "moneda_id" => "required",
      "total_gravada" => "required",
      "total_igv" => "required",

      "total_pagar" => "required",
      "pagos" => "nullable|array",
      "pagos.*.fecha" => "required",
      "pagos.*.monto" => "required",
    ];
  }
}
