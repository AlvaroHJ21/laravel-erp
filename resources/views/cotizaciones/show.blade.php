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
      <div class="card">
        <div class="card-header">
          <h5 class="card-title">
            DETALLES
          </h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
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
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $detalle->codigo }}</td>
                    <td>{{ $detalle->producto->nombre }}
                      - {{ $detalle->producto->codigo }}.
                      {{ $detalle->descripcion_adicional }}</td>
                    <td>
                      @php
                        $image = $detalle->producto->imagen
                            ? '/storage/productos/' . $detalle->producto->imagen
                            : '/img/default-image.png';
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

          <div class="d-flex justify-content-end">
            <div>
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
    </div>
    <div class="col col-lg-4">

      {{-- CLIENTE --}}
      <div class="card">
        <div class="card-header">
          <h5 class="card-title">
            CLIENTE
          </h5>
        </div>
        <div class="card-body">
          <div class="d-flex flex-column gap-1">
            <div class="row">
              <div class="col-1">
                <i data-feather="user"></i>
              </div>
              <div class="col-4">
                <label>Nombre: </label>
              </div>
              <div class="col">
                <label class="nombre">
                  {{ $cotizacion->cliente->nombre }}
                </label>
              </div>
            </div>

            <div class="row">
              <div class="col-1">
                <i data-feather="file-text"></i>
              </div>
              <div class="col-4">
                <label>Documento: </label>
              </div>
              <div class="col">
                <label class="documento">
                  {{ $cotizacion->cliente->numero_documento }}
                </label>
              </div>
            </div>

            <div class="row">
              <div class="col-1">
                <i data-feather="map-pin"></i>
              </div>
              <div class="col-4">
                <label>Direccion: </label>
              </div>
              <div class="col">
                <label class="direccion">
                  {{ $cotizacion->cliente->direccion }}
                </label>
              </div>
            </div>

            <div class="row">
              <div class="col-1">
                <i data-feather="percent"></i>
              </div>
              <div class="col-4">
                <label>Descuento: </label>
              </div>
              <div class="col">
                <label class="descuento">
                  {{ $cotizacion->cliente->porcentaje_descuento }}
                </label>
              </div>
            </div>

            <div class="row">
              <div class="col-1">
                <i data-feather="info"></i>
              </div>
              <div class="col-4">
                <label>Agente de retención: </label>
              </div>
              <div class="col">
                <label class="retencion">
                  {{ $cotizacion->cliente->retencion ? 'Sí' : 'No' }}
                </label>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>




  @include('partials.image-modal')
@stop
