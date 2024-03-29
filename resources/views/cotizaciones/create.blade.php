@extends('layouts.app')

@section('title', 'Crear Cotización')

@section('content_header')
  <div class="d-flex align-items-center">
    <button onclick="window.history.back()" class="btn">
      <i data-feather="arrow-left" style="scale: 1.5"></i>
    </button>
    <h1>Crear Cotización</h1>
  </div>
@stop

@section('content')

  <form id="form" method="post">
    @csrf

    <div class="row">
      <div class="col col-lg-8">

        <!-- DETALLES -->
        <div class="card flex-fill">
          <div class="card-header d-flex">
            <h5 class="card-title mb-0">
              DETALLES
            </h5>
          </div>
          <div class="card-body">

            <div id="autocomplete-inventarios" data-placeholder="Buscar producto por nombre, código, almacen"
                 class="mb-3"></div>
            <div class="table-responsive">
              <table id="tabla-items" class="table table-hover table-sm mb-3"></table>
            </div>
            @include('partials.montos')
          </div>
        </div>
        <!-- NOTAS -->
        <div class="card" x-data="{ open: {{ $base?->nota ? 'true' : 'false' }} }">
          <div class="card-header d-flex gap-2">
            <h5 class="card-title mb-0 d-flex gap-2">
              NOTA
            </h5>
            <div class="form-check form-switch">
              <input type="checkbox" class="form-check-input" x-model="open">
            </div>
          </div>
          <div class="card-body" x-show="open">
            <textarea name="nota" id="nota" class="form-control">{{ old('nota') }}</textarea>
          </div>
        </div>

        <div class="d-flex">
          <div class="flex-fill"></div>
          <button id="btn_generar" class="btn btn-success">Generar</button>
        </div>

      </div>
      <div class="col col-lg-4">

        <!-- DATOS DEL COMPROBANTE -->
        <div class="card">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="card-title mb-0">
              DATOS DEL LA COTIZACION
            </h5>
          </div>
          <div class="card-body">
            <div class="row">
              <!-- Moneda -->
              <div class="col-12">
                @include('partials.moneda')
              </div>
            </div>
          </div>
        </div>
        <!-- DATOS DEL CLIENTE -->
        @include('entidades.partials.autocomplete')
      </div>
    </div>

  </form>

  @include('partials.image-modal')


@stop

@section('js')

  <script>
    const entidades = @json($entidades);
    const inventarios = @json($inventarios);
    const tiposIGV = @json($tiposIGV);
    const tipoCambioDolar = @json($tipoCambioDolar->tipo_cambio_venta);
    const base = @json($base);
    const postUrl = @json(route('cotizaciones.store'));
    const redirectUrl = @json(route('cotizaciones.index'));
  </script>

  @vite(['resources/js/cotizaciones/create.ts'])

@stop
