@extends('layouts.app')

@section('title', 'Title')

@section('content_header')
  <h1>Ventas</h1>
@stop

@section('content')

  <div class="card flex-fill">
    <div class="card-header d-flex justify-content-between">
      <h5 class="card-title mb-0">
        Ventas
      </h5>
      <a href="{{ route('ventas.create') }}" class="btn btn-primary btn-sm btnAdd">Nuevo</a>
    </div>
    <div class="card-body">
      <div class="table-responsive" style="min-height: calc(100vh - 360px);">
        <table id="table-ordenes-venta" class="table table-hover my-0">
          <thead>
            <tr>
              <th>Venta</th>
              <th>Cliente</th>
              <th>Tipo</th>
              <th>F. Emisión</th>
              <th>Total</th>
              <th>PDF</th>
              <th>Ver</th>
              <th>Sunnat</th>
              <th>Estado</th>
              <th>Más</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($ventas as $index => $venta)
              <tr>
                <td>{{ $venta->id }}</td>
                <td>
                  <button class="btn btn-sm">
                    {{ $venta->cliente->nombre }} -
                    {{ $venta->cliente->numero_documento }}
                  </button>
                </td>
                <td class="text-sm"
                    style="white-space: nowrap;">{{ $venta->created_at }}
                </td>
                <td style="white-space: nowrap;">{{ $venta->moneda->simbolo }}
                  {{ $venta->total_gravada }}</td>
                <td style="white-space: nowrap;">{{ $venta->moneda->simbolo }}
                  {{ $venta->total_igv }}</td>
                <td style="white-space: nowrap;">{{ $venta->moneda->simbolo }}
                  {{ $venta->total_pagar }}</td>
                <td>
                  @include('ordenes_venta.partials.opciones_guia')
                </td>
                <td>
                  @include('ordenes_venta.partials.opciones_venta')
                </td>
                <td>
                  <a href="{{ route('ordenes_venta.show', $venta) }}"
                     class="btn btn-sm"><i class=""
                       data-feather="eye"></i></a>
                </td>
                <td>
                  @include('ordenes_venta.partials.estados')
                </td>
                <td>
                  @include('ordenes_venta.partials.opciones')
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
