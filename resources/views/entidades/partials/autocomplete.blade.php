<!-- CLIENTE -->
<div class="card">
  <div class="card-header">
    <h5 class="card-title">CLIENTE</h5>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="mb-3">

        <label for="cliente" class="form-label">Cliente</label>
        <div class="d-flex gap-2">
          {{-- Autocomplete --}}
          <div id="autocomplete-entidades" class="autocomplete" data-name="entidad_id" data-placeholder="Buscar cliente">
          </div>

          <div class="d-flex gap-2">
            <button id="btn_quitar_cliente" class="btn btn-danger d-none">
              <i data-feather="user-x"></i>
            </button>
            <a href="{{ route('entidades.create') }}" class="btn btn-sm btn-primary">
              <i data-feather="plus"></i>
            </a>
          </div>
        </div>

        <!-- Informacion del cliente -->

        <div id="cliente" class="mt-3 d-none">

          <div class="row">
            <div class="col-1">
              <i data-feather="user"></i>
            </div>
            <div class="col-4">
              <label>Nombre: </label>
            </div>
            <div class="col">
              <label class="nombre"></label>
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
              <label class="documento"></label>
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
              <label class="direccion"></label>
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
              <label class="descuento"></label>
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
              <label class="retencion"></label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
