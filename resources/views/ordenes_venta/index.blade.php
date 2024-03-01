@extends('layouts.app')

@section('title', 'Ordenes de venta')

@section('content_header')
  <h1>Ordenes de venta</h1>
@stop

@section('content')

  <div class="card flex-fill">
    <div class="card-header d-flex justify-content-between">
      <h5 class="card-title mb-0">
        Ordenes de venta
      </h5>
      <a href="{{ route('ordenes_venta.create') }}" class="btn btn-primary btn-sm btnAdd">Nuevo</a>
    </div>
    <div class="card-body">
      <div class="table-responsive" style="min-height: calc(100vh - 360px);">
        <table id="table-ordenes-venta" class="table table-hover my-0">
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
            @foreach ($ordenesVenta as $index => $ordenVenta)
              <tr>
                <td>{{ $ordenVenta->id }}</td>
                <td>
                  <button class="btn btn-sm">
                    {{ $ordenVenta->cliente->nombre }} -
                    {{ $ordenVenta->cliente->numero_documento }}
                  </button>
                </td>
                <td class="text-sm"
                    style="white-space: nowrap;">{{ $ordenVenta->created_at }}
                </td>
                <td style="white-space: nowrap;">{{ $ordenVenta->moneda->simbolo }}
                  {{ $ordenVenta->total_gravada }}</td>
                <td style="white-space: nowrap;">{{ $ordenVenta->moneda->simbolo }}
                  {{ $ordenVenta->total_igv }}</td>
                <td style="white-space: nowrap;">{{ $ordenVenta->moneda->simbolo }}
                  {{ $ordenVenta->total_pagar }}</td>
                <td>
                  <a href="{{ route('ordenes_venta.pdf', $ordenVenta) }}"
                     target="_blank"
                     class="btn btn-secondary btn-sm">PDF</a>
                </td>
                <td>
                  <a href="{{ route('ordenes_venta.show', $ordenVenta) }}"
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
