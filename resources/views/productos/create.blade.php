@extends('layouts.app')

@section('title', 'Crear Producto')

@section('content_header')
  <div class="d-flex align-items-center">
    <button onclick="window.history.back()" class="btn">
      <i data-feather="arrow-left" style="scale: 1.5"></i>
    </button>
    <h1>Crear Producto</h1>
  </div>
@stop

@section('content')

  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Agregar Producto</h5>
      <p class="card-text">
      <form method="post" action="{{ route('productos.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="row">
          <div class="col-8 mb-3">
            <label for="nombre" class="form-label">Nombre del producto</label>
            <input id="nombre" class="form-control" type="text" name="nombre"
                   placeholder="Ej. Detector inductivo" value="{{ old('nombre') }}">
          </div>
          <div class="col-4 mb-3">
            <label for="codigo" class="form-label">Código del producto</label>
            <input id="codigo" class="form-control" type="text" name="codigo" placeholder="Ej. IFS240"
                   value="{{ old('codigo') }}">
          </div>
          <div class="col-4 mb-3">
            <label for="unidad_id" class="form-label">Unidad</label>
            <select name="unidad_id" class="form-select">
              <option value="" selected>Seleccione un tipo de unidad</option>
              @foreach ($unidades as $unidad)
                @if ($unidad->activo)
                  <option value="{{ $unidad->id }}"
                          {{ old('unidad_id') == $unidad->id ? 'selected' : '' }}>{{ $unidad->unidad }}
                  </option>
                @endif
              @endforeach
            </select>
          </div>
          <div class="col-4 mb-3">
            <label for="categoria_id" class="form-label">Categoría</label>
            <select name="categoria_id" class="form-select">
              <option value="">Seleccione una categoría</option>
              @foreach ($categorias as $categoria)
                @if ($categoria->activo)
                  <option value="{{ $categoria->id }}"
                          {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                    {{ $categoria->nombre }}
                  </option>
                @endif
              @endforeach
            </select>
          </div>
          <div class="col-4 mb-3">
            <label for="moneda_id" class="form-label">Seleccione tipo de moneda</label>
            <select name="moneda_id" class="form-select">
              <option value="1" selected>(S/.)Soles</option>
              <option value="2">($/.)Dólares</option>
            </select>
          </div>
          <div class="col-3 mb-3">
            <label for="precio_compra" class="form-label">Precio de compra</label>
            <input id="precio_compra" class="form-control" type="number" name="precio_compra"
                   value="{{ old('precio_compra') }}">
          </div>
          <div class="col-3 mb-3">
            <label for="valor_venta" class="form-label">Valor de venta</label>
            <input id="valor_venta" class="form-control" type="number" name="valor_venta" step="0.000001"

                   value="{{ old('valor_venta') }}">
          </div>
          <div class="col-3 mb-3">
            <label for="tipo_igv_id" class="form-label">Tipo de impuesto</label>
            <select name="tipo_igv_id" id="tipo_igv_id" class="form-select">
              <option value="" selected>Seleccione un tipo de impuesto</option>
              @foreach ($tiposIgv as $tipo)
                @if ($tipo->activo == '1')
                  <option value="{{ $tipo->id }}"
                          data-porcentaje="{{ $tipo->porcentaje }}"
                          {{ old('tipo_igv_id') == $tipo->id ? 'selected' : '' }}>
                    {{ number_format($tipo->porcentaje, 2) }}% -
                    {{ $tipo->tipo_igv }}
                  </option>
                @endif
              @endforeach
            </select>
          </div>
          <div class="col-3 mb-3">
            <label for="precio_venta" class="form-label">Precio de venta</label>
            <input id="precio_venta" class="form-control" type="number" name="precio_venta" readonly
                   value="{{ old('precio_venta') }}">
          </div>

          <div class="col-sm-12 mb-3">

            <label for="imagen" class="d-block form-label">Cambiar Imagen</label>

            <img width="160" src="{{ asset('img/default-image.png') }}"
                 alt="avatar" id="img" class="cursor-pointer">

            <input id="imagen" class="form-control" type="file" name="imagen" hidden>
          </div>
        </div>

        <button class="btn btn-success" type="submit">GUARDAR</button>
      </form>
      </p>
    </div>
  </div>


@stop

@section('js')
  <script>
    const valor_venta = document.querySelector('#valor_venta'); //captura el valor venta
    const selectTipoIgv = document.querySelector('#tipo_igv_id');

    selectTipoIgv.addEventListener('change', () => {
      calc()
    });

    valor_venta.addEventListener('input', () => {
      calc()
    });

    function calc() {
      const porcentaje = selectTipoIgv.options[selectTipoIgv.selectedIndex].dataset.porcentaje;

      if (!porcentaje) return

      if (valor_venta.value.length == 0) return

      const valorVenta = parseFloat(valor_venta.value);

      const resultado = valorVenta * (1 + parseFloat(porcentaje) / 100);

      document.querySelector('#precio_venta').value = resultado.toFixed(3);
    }
  </script>
  <script>
    const file = document.getElementById('imagen');
    const img = document.getElementById('img');

    img.addEventListener('click', () => {
      file.click();
    });

    file.addEventListener('change', e => {
      if (e.target.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
          img.src = e.target.result;
        }
        reader.readAsDataURL(e.target.files[0])
      }
    });
  </script>
@stop
