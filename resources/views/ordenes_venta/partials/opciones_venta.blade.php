@if ($ordenVenta->venta_id)
  <div class="dropdown dropstart">
    <button class="btn dropdown-toggle btn-sm btn-info"
            type="button"
            id="dropdownGuia"
            data-bs-toggle="dropdown"
            aria-expanded="false">
      {{ $ordenVenta->guia->serie }}-{{ $ordenVenta->guia->numero }}
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownGuia">
      <li>
        <a class="dropdown-item" href="#">Ver</a>
      </li>
      <li>
        <a class="dropdown-item" href="#" target="_blank">Ver PDF</a>
      </li>
      <li>
        <a class="dropdown-item" href="#">Generar otro</a>
      </li>
    </ul>
  </div>
@else
  <a href="#" class="btn btn-secondary btn-sm">
    Generar
  </a>
@endif
