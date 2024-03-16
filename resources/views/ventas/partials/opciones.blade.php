@if (isset($venta))
  <div class="dropdown dropstart">
    <button class="btn dropdown-toggle btn-sm"
            type="button"
            id="dropdownMenuButton1"
            data-bs-toggle="dropdown"
            aria-expanded="false">
    </button>
    <ul class="dropdown-menu"
        aria-labelledby="dropdownMenuButton1">
      <li>
        <a class="dropdown-item" href="{{ route('ventas.show', $venta) }}">Ver</a>
      </li>
      <li>
        <a class="dropdown-item" href="{{ route('ventas.pdf', $venta) }}">Ver PDF</a>
      </li>
      <li>
        <a class="dropdown-item" href="{{ route('ventas.pdf', $venta) }}">Ver XML</a>
      </li>
      <li>
        <a class="dropdown-item" href="{{ route('ventas.pdf', $venta) }}">Ver CDR</a>
      </li>
      <li>
        <a class="dropdown-item"
           href="{{ route('ordenes_venta.pdf', $venta) }}">
          Enviar por email
        </a>
      </li>
      <li>
        <a class="dropdown-item btn_generar_recordatorio"
           href="#"
           data-tipo-documento="1"
           data-documento="{{ $venta->id }}">
          Generar Recordatorio
        </a>
      </li>
    </ul>
  </div>
@endif
