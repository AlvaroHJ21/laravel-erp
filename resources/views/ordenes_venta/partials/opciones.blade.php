@if (isset($ordenVenta))
  <div class="dropdown dropstart">
    <button class="btn dropdown-toggle btn-sm"
            type="button"
            id="dropdownMenuButton1"
            data-bs-toggle="dropdown"
            aria-expanded="false">
      <!-- <i class="" data-feather="settings"></i> -->
    </button>
    <ul class="dropdown-menu"
        aria-labelledby="dropdownMenuButton1">
      <li>
        <a class="dropdown-item" href="{{ route('ordenes_venta.show', $ordenVenta) }}">Ver</a>
      </li>
      <li>
        <a class="dropdown-item"
           href="{{ route('ordenes_venta.pdf', $ordenVenta) }}"
           target="_blank">
          Ver PDF
        </a>
      </li>
      <li>
        <a class="dropdown-item"
           {{-- TODO --}}
           {{-- href="{{ route('ventas.ordenes_venta.nuevo', $cotizacion) }}" --}}>
          Generar venta
        </a>
      </li>
      <li>
        <a class="dropdown-item"
           href="{{ route('ordenes_venta.create', ['cotizacionId' => $ordenVenta->id]) }}">
          Duplicar cotización
        </a>
      </li>
      <li>
        <a class="dropdown-item btn_generar_recordatorio"
           href="#"
           data-tipo-documento="1"
           data-documento="{{ $ordenVenta->id }}"
           {{-- TODO --}}
           {{-- data-url="{{ route('ventas.cotizaciones.ver', $cotizacion) }}" --}}>
          Generar Recordatorio
        </a>
      </li>
      <li>
        <a class="dropdown-item"
           href="{{ route('ordenes_venta.pdf', $ordenVenta) }}">
          Descargar
        </a>
      </li>
      <li>
        <a class="dropdown-item"
           href="{{ route('ordenes_venta.pdf', $ordenVenta) }}">
          Enviar por email
        </a>
      </li>
    </ul>
  </div>
@endif
