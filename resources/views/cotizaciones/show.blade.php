@extends('layouts.app')

@section('title', 'Cotizacion')

@section('content_header')
  <div class="d-flex align-items-center">
    <button onclick="window.history.back()" class="btn">
      <i data-feather="arrow-left" style="scale: 1.5"></i>
    </button>
    <h1>Cotización #{{ $cotizacion->id }}</h1>
    <div class="flex-fill"></div>
    @include("cotizaciones.partials.opciones")
  </div>
@stop

@section('content')

  {{-- CLIENTE --}}
  <div class="card">
    <div class="card-header">
      <h5 class="card-title">
        CLIENTE
      </h5>
    </div>
    <div class="card-body">
      <div class="mt-3">
        <div class="d-flex gap-2 mb-3">
          <i class="align-middle" data-feather="user"></i>
          <label style="min-width: 140px;">Nombre: </label>
          <input type="text" class="nombre flex-grow-1" style="all: unset;"
                 value="{{ $cotizacion->cliente->nombre }}"
                 readonly>
        </div>
        <div class="d-flex gap-2 mb-3">
          <i class="align-middle" data-feather="file-text"></i>
          <label style="min-width: 140px;">Documento: </label>
          <input type="text" class="documento flex-grow-1" style="all: unset;"
                 value="{{ $cotizacion->cliente->numero_documento }}"
                 readonly>
        </div>
        <div class="d-flex gap-2 mb-3">
          <i class="align-middle" data-feather="map-pin"></i>
          <label style="min-width: 140px;">Direccion: </label>
          <input type="text" class="direccion flex-grow-1" style="all: unset;"
                 value="{{ $cotizacion->cliente->direccion }}"
                 readonly>
        </div>
        <div class="d-flex gap-2 mb-3">
          <i class="align-middle" data-feather="percent"></i>
          <label style="min-width: 140px;">Descuento: </label>
          <input type="text" class="descuento flex-grow-1" style="all: unset;"
                 value="{{ $cotizacion->cliente->porcentaje_descuento }}"
                 readonly>
        </div>
        <div class="d-flex gap-2 mb-3">
          <i class="align-middle" data-feather="info"></i>
          <label style="min-width: 140px;">Agente de retención: </label>
          <input type="text" class="retencion flex-grow-1" style="all: unset;"
                 value="{{ $cotizacion->cliente->retencion ? 'Sí' : 'No' }}"
                 readonly>
        </div>
      </div>
    </div>
  </div>
  {{-- DETALLES --}}
  <div class="card">
    <div class="card-header">
      <h5 class="card-title">
        DETALLES
      </h5>
    </div>
    <div class="card-body">
      <table class="table table-hover table-sm mb-3">
        <thead>
          <tr>
            <th>Pos</th>
            <th>Código</th>
            <th>Descripción</th>
            <th>Imagen Referencial</th>
            <th>Cantidad</th>
            <th>Unidad de Medida</th>
            <th class="text-right">Valor Unitario</th>
            <th class="text-right">Sub Total</th>
          </tr>
        </thead>
        <tbody>

          @foreach ($cotizacion->detalles as $index => $detalle)
            <tr>
              <td>{{ $index }}</td>
              <td>{{ $detalle->codigo }}</td>
              <td>{{ $detalle->producto->nombre }}</td>
              <td>
                @php
                  $image = $detalle->producto->imagen ? '/storage/productos/' . $detalle->producto->imagen : '/img/default-image.png';
                @endphp
                <button data-bs-toggle="modal" data-bs-target="#modal-imagen" type="button">
                  <img class="img-thumbnail" src="{{ $image }}" alt="producto" width="100px" />
                </button>
              </td>
              <td>{{ $detalle->cantidad }}</td>
              <td>{{ $detalle->producto->unidad->unidad }}</td>
              <td>{{ $detalle->valor_venta }}</td>
              <td>{{ $detalle->subtotal }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  {{-- TOTALES --}}
  <div class="d-flex justify-content-end">
    <div class="card" style="width: fit-content">
      <div class="card-header">
        <h5 class="card-title">
          TOTALES
        </h5>
      </div>
      <div class="card-body">

        <div class="row">
          <label class="col">Total Gravado:</label>
          <label class="col-1">{{ $cotizacion->moneda->simbolo }}</label>
          <div class="col">
            <input type="text" class="form-control" readonly value="{{ $cotizacion->total_gravada }}">
          </div>
        </div>

        <div class="row">
          <label class="col">Total IGV:</label>
          <label class="col-1">{{ $cotizacion->moneda->simbolo }}</label>
          <div class="col">
            <input type="text" class="form-control" readonly value="{{ $cotizacion->total_igv }}">
          </div>
        </div>

        <div class="row">
          <label class="col">Total a Pagar:</label>
          <label class="col-1">{{ $cotizacion->moneda->simbolo }}</label>
          <div class="col">
            <input type="text" class="form-control" readonly value="{{ $cotizacion->total_pagar }}">
          </div>
        </div>
      </div>
    </div>
  </div>

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


  <!-- Imagen Modal-->
  <div class="modal fade" id="modal-imagen" tabindex="-1" aria-labelledby="modal-imagen-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg justify-content-center">
      <div class="modal-content" style="width: 500px;">
        <img id="imagen" src="" alt="" width="">
      </div>
    </div>
  </div>

  <pre>
    @json($cotizacion, JSON_PRETTY_PRINT)
  </pre>
@stop

@section('js')

  <script>
    const $images = document.querySelectorAll('.img-thumbnail');
    $images.forEach($image => {
      $image.addEventListener('click', (e) => {
        const src = e.target.src;
        const $imagen = document.querySelector('#imagen');
        $imagen.src = src;
      });
    });
  </script>
@stop
