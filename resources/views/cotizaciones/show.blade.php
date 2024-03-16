@extends('layouts.app')

@section('title', 'Cotizacion')

@section('content_header')
  <div class="d-flex align-items-center">
    <button onclick="window.history.back()" class="btn">
      <i data-feather="arrow-left" style="scale: 1.5"></i>
    </button>
    <h1>Cotización #{{ $cotizacion->id }}</h1>
    <div class="flex-fill"></div>
    @include('cotizaciones.partials.opciones')
  </div>
@stop

@section('content')

  <div class="row">
    <div class="col col-lg-8">
      {{-- DETALLES --}}
      @include('partials.details-preview', [
          'detalles' => $cotizacion->detalles,
          'moneda' => $cotizacion->moneda,
          'total_gravada' => $cotizacion->total_gravada,
          'total_igv' => $cotizacion->total_igv,
          'total_pagar' => $cotizacion->total_pagar,
      ])

      {{-- NOTA --}}
      @if ($cotizacion->nota)
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">NOTA</h5>
          </div>
          <div class="card-body">
            <textarea name="nota" id="nota" class="form-control" readonly>{{ $cotizacion->nota }}</textarea>
          </div>
        </div>
      @endif
    </div>
    <div class="col col-lg-4">

      {{-- CLIENTE --}}
      @include('partials.entidad-preview', [
          'entidad' => $cotizacion->cliente,
      ])

    </div>
  </div>




  @include('partials.image-modal')
@stop
