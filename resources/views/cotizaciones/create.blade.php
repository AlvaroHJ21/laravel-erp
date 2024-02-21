@extends('layouts.app')

@section('title', 'Crear Cotización')

@section('content_header')
  <h1>Crear Cotización</h1>
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
          <div class="mb-3">
            <label for="cliente" class="form-label">Cliente</label>
            <div class="d-flex gap-2">
              {{-- <input type="text" class="form-control flex-grow-1" name="cliente" id="cliente"
                     placeholder="Ej. John Doe" autocomplete="off" value="{{ old('cliente') }}"> --}}
              <div id="autocomplete-entidades" class="autocomplete" data-data="{{ $entidadesACD }}"
                   data-name="entidad_id"></div>
              @if (!$ver)
                <div class="d-flex gap-2">
                  <button class="d-none"></button>
                  <button id="btn_quitar_cliente" class="btn btn-danger d-none"><i class="align-middle"
                       data-feather="user-x"></i></button>
                  <a href="{{ route('entidades.create') }}"
                     class="btn btn-primary">Nuevo</a>
                </div>
              @endif
            </div>
            <!-- Informacion del nuevo cliente -->
            <div id="seccion_cliente_seleccionado"
                 class="mt-3 @if (old('cliente_seleccionado')) d-flex @else d-none @endif">
              <input id="id_cliente_seleccionado" type="hidden" name="">
              <div class="d-flex gap-2 mb-3">
                <i class="align-middle" data-feather="user"></i>
                <label style="min-width: 140px;">Nombre: </label>
                <input id="nombre_cliente_seleccionado" type="text" class="flex-grow-1" style="all: unset;" readonly
                       value="{{ old('nombre_cliente_seleccionado') }}">
              </div>
              <div class="d-flex gap-2 mb-3">
                <i class="align-middle" data-feather="file-text"></i>
                <label style="min-width: 140px;">Documento: </label>
                <input id="documento_cliente_seleccionado" type="text" class="flex-grow-1" style="all: unset;" readonly
                       value="{{ old('documento_cliente_seleccionado') }}">
              </div>
              <div class="d-flex gap-2 mb-3">
                <i class="align-middle" data-feather="map-pin"></i>
                <label style="min-width: 140px;">Direccion: </label>
                <input id="direccion_cliente_seleccionado" type="text" class="flex-grow-1" style="all: unset;" readonly
                       value="{{ old('direccion_cliente_seleccionado') }}">
              </div>
              <div class="d-flex gap-2 mb-3">
                <i class="align-middle" data-feather="percent"></i>
                <label style="min-width: 140px;">Descuento: </label>
                <input id="porcentaje_descuento_cliente_seleccionado" type="text" class="flex-grow-1"
                       style="all: unset;" readonly value="{{ old('porcentaje_descuento_cliente_seleccionado') }}">
              </div>
              <div class="d-flex gap-2 mb-3">
                <i class="align-middle" data-feather="info"></i>
                <label style="min-width: 140px;">Agente de retención: </label>
                <input id="agente_retencion_texto" type="text" class="flex-grow-1" style="all: unset;" readonly
                       value="{{ old('agente_retencion_texto') }}">
                <input type="hidden" id="agente_retencion_cliente_seleccionado"
                       value="{{ old('agente_retencion_cliente_seleccionado') }}">
              </div>
            </div>
          </div>
          <!-- Moneda -->
          <div class="col-12 col-md-3">
            <label for="moneda" class="form-label">Moneda</label>
            <select name="moneda" id="moneda" class="form-select mb-3">
              @foreach ($monedas as $moneda)
                <option value="{{ $moneda->id }}" data-simbolo="{{ $moneda->simbolo }}"
                        {{ old('moneda') == $moneda->id ? 'selected' : '' }}>
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
        @include('ventas.partials.items', ['ver' => $ver])
      </div>
    </div>
    <!-- MONTOS-->
    @include('ventas.partials.montos')
    <!-- NOTAS DEL COMPROBANTE -->
    <div class="card flex-fill">
      <div class="card-header d-flex gap-2">
        <label class="card-title mb-0" for="check_nota_comprobante">
          NOTAS DEL COMPROBANTE
        </label>
        <div class="form-check form-switch">
          <input type="checkbox" id="check_nota_comprobante" class="form-check-input">
        </div>
      </div>
      <div id="nota_comprobante_body" class="card-body d-none">
        <textarea name="nota" id="nota" class="form-control">{{ old('nota') }}</textarea>
      </div>
    </div>
    <!-- SUBMIT -->
    @if (!$ver)
      <div class="card flex-fill">
        <button id="btn_generar" class="btn btn-success">Generar cotizacion</button>
      </div>
    @endif
  </form>

  <!-- Modal para visualizar imagen #modal-imagen-->
  <div class="modal fade" id="modal-imagen" tabindex="-1" aria-labelledby="modal-imagen-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg justify-content-center">
      <div class="modal-content" style="width: 500px;">
        <!-- <h1>Hola</h1> -->
        <img id="imagen" src="" alt="" width="">
      </div>
    </div>
  </div>


@stop

@section('js')

  <script>
    const baseUrl = "{{ url('/') }}";

    const unidades = @json($unidades);

    // const productosACD = @json($productosACD);
    window.productosACD = @json($productosACD);

    const tiposIGV = @json($tiposIGV);

    const ver = {{ $ver ? 'true' : 'false' }};

    const currentDate = "{{ date('Y-m-d') }}";

    const tipoCambioDolar = @json(isset($tipoCambioDolar) ? $tipoCambioDolar : null);
    const tipoCambioSunat = @json(isset($tipoCambioSunat) ? $tipoCambioSunat : null);

    const cotizacionActual = @json(isset($cotizacionActual) ? $cotizacionActual : null);
    const cotizacionItems = @json(isset($cotizacionItems) ? $cotizacionItems : []);

    const cotizacionCliente = @json(isset($cotizacionCliente) ? $cotizacionCliente : null);

    const cotizacionBase = @json(isset($cotizacionBase) ? $cotizacionBase : null);
    const cotizacionBaseCliente = @json(isset($cotizacionBaseCliente) ? $cotizacionBaseCliente : null);
    const cotizacionBaseItems = @json(isset($cotizacionBaseItems) ? $cotizacionBaseItems : []);
  </script>

  @vite(['resources/js/cotizaciones/create.ts'])

@stop
