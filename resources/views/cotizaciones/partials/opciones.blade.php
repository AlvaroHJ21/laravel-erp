@if (isset($cotizacion))
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
        <a class="dropdown-item" href="{{ route('cotizaciones.show', $cotizacion) }}">Ver</a>
      </li>
      <li>
        <a class="dropdown-item"
           href="{{ route('cotizaciones.pdf', $cotizacion) }}"
           target="_blank">
          Ver PDF
        </a>
      </li>
      <li>
        <a class="dropdown-item"
           href="{{ route('ordenes_venta.create_by_cotizacion', $cotizacion) }}">
          Generar orden de venta
        </a>
      </li>
      <li>
        <a class="dropdown-item"
           href="{{ route('cotizaciones.create', ['cotizacionId' => $cotizacion->id]) }}">
          Duplicar cotización
        </a>
      </li>
      <li>
        <a class="dropdown-item btn_generar_recordatorio"
           href="#"
           data-tipo-documento="1"
           data-documento="{{ $cotizacion->id }}"
           {{-- TODO --}}
           {{-- data-url="{{ route('ventas.cotizaciones.ver', $cotizacion) }}" --}}>
          Generar Recordatorio
        </a>
      </li>
      <li>
        <a class="dropdown-item"
           href="{{ route('cotizaciones.pdf', $cotizacion) }}">
          Descargar
        </a>
      </li>
      <li>
        <a class="dropdown-item"
           href="{{ route('cotizaciones.pdf', $cotizacion) }}">
          Enviar por email
        </a>
      </li>
    </ul>
  </div>
@endif
