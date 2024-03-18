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
              <th>SUNNAT</th>
              <th>Estado</th>
              <th>Más</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($ventas as $index => $venta)
              <tr>
                <td>{{ $venta->serie->serie }}-{{ $venta->numero }}</td>
                <td>
                  <button class="btn btn-sm">
                    {{ $venta->entidad->nombre }} -
                    {{ $venta->entidad->numero_documento }}
                  </button>
                </td>
                <td>
                  {{ $venta->tipo_documento->nombre }}
                </td>
                <td class="text-sm"
                    style="white-space: nowrap;">{{ $venta->fecha_emision }}
                </td>
                <td style="white-space: nowrap;">{{ $venta->moneda->simbolo }}
                  {{ $venta->total_pagar }}</td>
                <td>
                  <a href="{{ route('ventas.pdf', $venta) }}"
                     target="_blank"
                     class="btn btn-secondary btn-sm">
                    PDF
                  </a>
                </td>
                <td>
                  <a href="{{ route('ventas.show', $venta) }}"
                     class="btn btn-sm">
                    <i class="" data-feather="eye"></i>
                  </a>
                </td>
                <td>
                  <form action="{{ route('ventas.send_sunnat', $venta) }}" method="POST">
                    @csrf
                    <button class="btn btn-sm">
                      <img src="{{ asset('img/icons/logo_sunat.png') }}" alt="" width="24">
                    </button>
                  </form>
                </td>
                <td>
                  @include('ventas.partials.estados')
                </td>
                <td>
                  @include('ventas.partials.opciones')
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
