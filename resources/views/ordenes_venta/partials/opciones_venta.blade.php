@if (count($ordenVenta->ventas) > 0)
  @php
    $venta = $ordenVenta->ventas->last();
  @endphp
  <div class="dropdown dropstart">
    <button class="btn dropdown-toggle btn-sm btn-info"
            type="button"
            id="dropdownGuia"
            data-bs-toggle="dropdown"
            aria-expanded="false">
      {{ $venta->serie->serie }}-{{ $venta->numero }}
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownGuia">
      <li>
        <a class="dropdown-item" href="{{ route('ventas.show', $venta) }}">Ver</a>
      </li>
      <li>
        <a class="dropdown-item" href="{{ route('ventas.pdf', $venta) }}" target="_blank">Ver PDF</a>
      </li>
      <li>
        <a class="dropdown-item" href="{{ route('ventas.create_by_orden_venta', $ordenVenta) }}">Generar otro</a>
      </li>
    </ul>
  </div>
@else
  <a href="{{ route('ventas.create_by_orden_venta', $ordenVenta) }}" class="btn btn-secondary btn-sm">
    Generar
  </a>
@endif
