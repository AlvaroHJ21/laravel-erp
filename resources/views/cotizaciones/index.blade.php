@extends('layouts.app')

@section('title', 'Cotizaciones')

@section('content_header')
  <h1>Cotizaciones</h1>
@stop

@section('content')

  <div class="card flex-fill">
    <div class="card-header d-flex justify-content-between">
      <h5 class="card-title mb-0">
        Cotizaciones
      </h5>
      <a href="{{ route('cotizaciones.create') }}" class="btn btn-primary btn-sm btnAdd">Nuevo</a>
    </div>
    <div class="card-body">
      <div class="table-responsive" style="min-height: calc(100vh - 360px);">
        <table id="table-cotizaciones" class="table table-hover my-0">
          <thead>
            <tr>
              <th>N.</th>
              <th>Cliente</th>
              <th>Fecha</th>
              <th>T.Gravado</th>
              <th>Impuesto</th>
              <th>Total</th>
              <th>PDF</th>
              <th>Ver</th>
              <th>Estado</th>
              <th>Más</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($cotizaciones as $index => $cotizacion)
              <tr>
                <td>{{ $cotizacion->id }}</td>
                <td>
                  <button class="btn btn-sm">
                    {{ $cotizacion->cliente->nombre }} -
                    {{ $cotizacion->cliente->numero_documento }}
                  </button>
                </td>
                <td class="text-sm"
                    style="white-space: nowrap;">{{ $cotizacion->created_at }}
                </td>
                <td style="white-space: nowrap;">{{ $cotizacion->moneda->simbolo }}
                  {{ $cotizacion->total_gravada }}</td>
                <td style="white-space: nowrap;">{{ $cotizacion->moneda->simbolo }}
                  {{ $cotizacion->total_igv }}</td>
                <td style="white-space: nowrap;">{{ $cotizacion->moneda->simbolo }}
                  {{ $cotizacion->total_pagar }}</td>
                <td>
                  <a href="{{ route('cotizaciones.pdf', $cotizacion) }}"
                     target="_blank"
                     class="btn btn-secondary btn-sm">PDF</a>
                </td>
                <td>
                  <a href="{{ route('cotizaciones.show', $cotizacion) }}"
                     class="btn btn-sm"><i class=""
                       data-feather="eye"></i></a>
                </td>
                <td>
                  @include('cotizaciones.partials.estados')
                </td>
                <td>
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
                           {{-- TODO --}}
                           {{-- href="{{ route('ventas.ordenes_venta.nuevo', $cotizacion) }}" --}}>
                          Generar orden de venta
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item"
                           href="{{ route('cotizaciones.create', $cotizacion) }}">
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
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>


@stop

@section('js')
@stop
