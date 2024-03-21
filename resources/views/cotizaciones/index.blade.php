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
                    {{ $cotizacion->entidad->nombre }} -
                    {{ $cotizacion->entidad->numero_documento }}
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
                  @include('cotizaciones.partials.opciones')
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
