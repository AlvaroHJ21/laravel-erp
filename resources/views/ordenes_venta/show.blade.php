@extends('layouts.app')

@section('title', 'Cotizacion')

@section('content_header')
  <div class="d-flex align-items-center">
    <button onclick="window.history.back()" class="btn">
      <i data-feather="arrow-left" style="scale: 1.5"></i>
    </button>
    <h1>Orden de venta #{{ $ordenVenta->id }}</h1>
    <div class="flex-fill"></div>
    @include('ordenes_venta.partials.opciones')
  </div>
@stop

@section('content')

  <div class="row">
    <div class="col col-lg-8">
      {{-- DETALLES --}}
      @include('partials.details-preview', [
          'detalles' => $ordenVenta->detalles,
          'moneda' => $ordenVenta->moneda,
          'total_gravada' => $ordenVenta->total_gravada,
          'total_igv' => $ordenVenta->total_igv,
          'total_pagar' => $ordenVenta->total_pagar,
      ])

      {{-- NOTA --}}
      @if ($ordenVenta->nota)
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">NOTA</h5>
          </div>
          <div class="card-body">
            <textarea name="nota" id="nota" class="form-control" readonly>{{ $ordenVenta->nota }}</textarea>
          </div>
        </div>
      @endif
    </div>
    <div class="col col-lg-4">


      {{-- DATOS DEL COMPROBANTE --}}
      <div class="card">
        <div class="card-header">
          <h5 class="card-title">DATOS DEL COMPROBANTE</h5>
        </div>
        <div class="card-body">
          <div class="d-flex flex-column gap-1">
            <label class="">Numero de orden de compra:
              <strong>{{ $ordenVenta->numero_orden_compra }}</strong></label>
            <label class="">Moneda: <strong>{{ $ordenVenta->moneda->nombre }}</strong></label>
          </div>
        </div>
      </div>

      {{-- CLIENTE --}}
      @include('partials.entidad-preview', ['entidad' => $ordenVenta->entidad])

      {{-- VENTA --}}

    </div>
  </div>

  {{-- IMAGE MODAL --}}
  @include('partials.image-modal')
  {{-- <pre>
    @json($cotizacion, JSON_PRETTY_PRINT)
  </pre> --}}
@stop
