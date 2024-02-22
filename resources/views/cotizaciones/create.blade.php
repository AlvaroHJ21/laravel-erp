@extends('layouts.app')

@section('title', 'Crear Cotización')

@section('content_header')
  <div class="d-flex align-items-center">
    <a href="{{ route('cotizaciones.index') }}"
       class="btn">
      <i data-feather="arrow-left" style="scale: 1.5"></i>
    </a>
    <h1>Crear Cotización</h1>
  </div>
@stop

@section('content')

  @php
    $ver = isset($cotizacionActual);
  @endphp

  <form id="form" method="post">
    @csrf
    <!-- DATOS DEL COMPROBANTE -->
    <div class="card flex-fill">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">
          DATOS DEL LA COTIZACION {{ $ver ? '#' . $cotizacionActual->id : '' }}
        </h5>
        @include('cotizaciones.partials.opciones')
      </div>
      <div class="card-body">
        <div class="row">
          <!-- CLIENTE -->

          @include('entidades.partials.autocomplete', ['ver' => $ver])

          <!-- Moneda -->
          <div class="col-12 col-md-3">
            <label for="moneda_id" class="form-label">Moneda
              <span>({{ $tipoCambioDolar->tipo_cambio_venta }})</span>
            </label>
            <select name="moneda_id" id="moneda_id" class="form-select mb-3">
              @foreach ($monedas as $moneda)
                <option value="{{ $moneda->id }}" data-simbolo="{{ $moneda->simbolo }}"
                        {{ old('moneda_id') == $moneda->id ? 'selected' : '' }}>
                  {{ $moneda->abrstandar }} - {{ $moneda->nombre }}
                </option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
    </div>
    <!-- CONCEPTOS DEL COMPROBANTE -->
    <div class="card flex-fill">
      <div class="card-header d-flex">
        <h5 class="card-title mb-0">
          CONCEPTOS DEL COMPROBANTE
        </h5>
      </div>
      <div class="card-body">

        <div id="autocomplete-productos" data-placeholder="Buscar producto por nombre o código" class="mb-3"></div>
        <table id="tabla-items" class="table table-hover table-sm mb-3"></table>

      </div>
    </div>
    <!-- MONTOS-->
    @include('partials.montos')
    <!-- NOTAS DEL COMPROBANTE -->
    <div class="card flex-fill" x-data="{ open: false }">
      <div class="card-header d-flex gap-2">
        <label class="card-title mb-0 d-flex gap-2">
          NOTAS DEL COMPROBANTE
          <div class="form-check form-switch">
            <input type="checkbox" class="form-check-input" x-model="open">
          </div>
        </label>
      </div>
      <div class="card-body" x-show="open">
        <textarea name="nota" id="nota" class="form-control">{{ old('nota') }}</textarea>
      </div>
    </div>
    <!-- SUBMIT -->
    @if (!$ver)
      <div class="card flex-fill">
        <button id="btn_generar" class="btn btn-success">Generar</button>
      </div>
    @endif
  </form>

  <!-- Imagen Modal-->
  <div class="modal fade" id="modal-imagen" tabindex="-1" aria-labelledby="modal-imagen-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg justify-content-center">
      <div class="modal-content" style="width: 500px;">
        <img id="imagen" src="" alt="" width="">
      </div>
    </div>
  </div>


@stop

@section('js')

  <script>
    window.entidades = @json($entidades);
    window.productos = @json($productos);
    window.tiposIGV = @json($tiposIGV);
    window.tipoCambioDolar = @json($tipoCambioDolar->tipo_cambio_venta);
  </script>

  @vite(['resources/js/cotizaciones/create.ts'])

@stop
