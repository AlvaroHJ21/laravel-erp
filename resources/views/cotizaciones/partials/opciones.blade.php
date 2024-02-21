@php
  $editando = isset($cotizacionActual);
@endphp

@if ($editando)
  <div class="d-flex gap-2">
    <a href="{{ route('cotizacion.pdf', $cotizacionActual->id) }}" target="_blank" class="btn btn-secondary btn-sm">PDF</a>
    <div class="dropdown dropstart">
      <button class="btn dropdown-toggle btn-sm" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
              aria-expanded="false">
        Opciones
      </button>
      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
        <li><a class="dropdown-item"
             href="{{ route('ventas.ordenes_venta.nuevo', ['cotizacionId' => $cotizacionActual->id]) }}">Generar orden
            de venta</a></li>
        <li><a class="dropdown-item"
             href="{{ route('ventas.cotizaciones.nuevo', ['cotizacionId' => $cotizacionActual->id]) }}">Duplicar
            cotizacion</a></li>
        <li>
          <a class="dropdown-item btn_generar_recordatorio" href="#" data-tipo-documento="1"
             data-documento="{{ $cotizacionActual->id }}"
             data-url="{{ route('ventas.cotizaciones.ver', $cotizacionActual->id) }}">Generar Recordatorio</a>
        </li>
        <li><a class="dropdown-item" href="#">Descargar</a></li>
        <li><a class="dropdown-item" href="#">Enviar por email</a></li>
        <li><a class="dropdown-item text-danger" href="#">Eliminar</a></li>
      </ul>
    </div>
  </div>
@endif
