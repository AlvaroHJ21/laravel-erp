@extends('layouts.app')

@section('title', 'Crear Cotización')

@section('content_header')
  <div class="d-flex align-items-center">
    <button onclick="window.history.back()" class="btn">
      <i data-feather="arrow-left" style="scale: 1.5"></i>
    </button>
    <h1>Crear venta</h1>
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

            <div id="autocomplete-inventarios" data-placeholder="Buscar producto por nombre o código" class="mb-3">
            </div>
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
        <!-- NUMERO ORDEN COMPRA -->
        <div class="card">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="card-title mb-0">
              DATOS DE COMPROBANTE
            </h5>
          </div>
          <div class="card-body">
            <div class="row">
              <!-- Tipo documento / Serie -->
              <div class="col-12 mb-3">
                @include('partials.tipo-documento')
              </div>

              <!-- Número de orden de compra -->
              <div class="col-12 mb-3">
                <label for="moneda_id" class="form-label">
                  Número de orden de compra
                </label>
                <input type="text" name="numero_orden_compra" class="form-control" />
              </div>

              <!-- Moneda -->
              <div class="col-12 mb-3">
                @include('partials.moneda')
              </div>

              <!-- Fecha Emisión / Vencimiento -->
              <div class="col-12">
                <label for="fecha_emision" class="form-label">
                  Fecha de Emisión / Vencimiento
                </label>
                <div class="d-flex gap-2">
                  <input type="date" name="fecha_emision" class="form-control" value="{{ date('Y-m-d') }}" />
                  <input type="date" name="fecha_vencimiento" class="form-control" value="{{ date('Y-m-d') }}" />
                </div>
              </div>

            </div>
          </div>
        </div>
        <!-- DATOS DEL CLIENTE -->
        @include('entidades.partials.autocomplete')

        <!-- DATOS DE PAGO -->
        @include('partials.pago')

      </div>
    </div>

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
    const entidades = @json($entidades);
    const inventarios = @json($inventarios);
    const tiposIGV = @json($tiposIGV);
    const tipoCambioDolar = @json($tipoCambioDolar->tipo_cambio_venta);
    const base = @json($base);
    const urlPost = @json(route('ventas.store'));
    const urlRedirect = @json(route('ventas.index'));
    const tiposDocumento = @json($tiposDocumento);
  </script>

  @vite(['resources/js/ventas/create.ts'])

@stop
