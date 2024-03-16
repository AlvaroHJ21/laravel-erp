@extends('layouts.app')

@section('title', 'Cotizacion')

@section('content_header')
  <div class="d-flex align-items-center">
    <button onclick="window.history.back()" class="btn">
      <i data-feather="arrow-left" style="scale: 1.5"></i>
    </button>
    <h1>Venta {{ $venta->serie->serie }}-{{ $venta->numero }}</h1>
    <div class="flex-fill"></div>
    @include('ventas.partials.opciones')
  </div>
@stop

@section('content')

  <div class="row">
    <div class="col col-lg-8">
      {{-- DETALLES --}}
      @include('partials.details-preview', [
          'detalles' => $venta->detalles,
          'moneda' => $venta->moneda,
          'total_gravada' => $venta->total_gravada,
          'total_igv' => $venta->total_igv,
          'total_pagar' => $venta->total_pagar,
      ])

      {{-- NOTA --}}
      @if ($venta->nota)
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">NOTA</h5>
          </div>
          <div class="card-body">
            <textarea name="nota" id="nota" class="form-control" readonly>{{ $venta->nota }}</textarea>
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
            <label class="">Numero de orden de compra: <strong>{{ $venta->numero_orden_compra }}</strong></label>
            <label class="">Moneda: <strong>{{ $venta->moneda->nombre }}</strong></label>
            <label class="">Fecha de emisión: <strong>{{ $venta->fecha_emision }}</strong></label>
            <label class="">Fecha de vencimiento: <strong>{{ $venta->fecha_vencimiento }}</strong></label>
          </div>

        </div>
      </div>

      {{-- CLIENTE --}}
      @include('partials.entidad-preview', [
          'entidad' => $venta->entidad,
      ])

      {{-- DATOS DE PAGO --}}
      <div class="card">
        <div class="card-header">
          <h5 class="card-title">DATOS DEL PAGO</h5>
        </div>
        <div class="card-body">
          <div class="d-flex flex-column">
            <label>Forma de pago: <strong>{{ $venta->forma_pago->nombre }}</strong></label>
            <label>Modo de pago: <strong>{{ $venta->modo_pago->nombre }}</strong></label>
          </div>
          {{-- Coutas --}}
          @if (count($venta->pagos) > 0)
            <div class="d-flex flex-column gap-1 mt-3">
              <h5 class="card-title">CUOTAS</h5>
              @foreach ($venta->pagos as $pago)
                <div class="d-flex justify-content-between">
                  <label>{{ $pago->fecha_pago }}</label>
                  <label>{{ $pago->monto }}</label>
                </div>
              @endforeach
            </div>
          @endif
          <div>

          </div>
        </div>
      </div>

    </div>
  </div>




  @include('partials.image-modal')
@stop
