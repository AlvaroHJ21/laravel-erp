<label for="moneda_id" class="form-label">Moneda
  <span>({{ $tipoCambioDolar->tipo_cambio_venta }})</span>
</label>
<select name="moneda_id" id="moneda_id" class="form-select mb-3">
  @foreach ($monedas as $moneda)
    <option
            value="{{ $moneda->id }}"
            data-simbolo="{{ $moneda->simbolo }}"
            {{ $base?->moneda_id == $moneda->id ? 'selected' : '' }}>
      {{ $moneda->abrstandar }} - {{ $moneda->nombre }}
    </option>
  @endforeach
</select>
