<!-- CLIENTE -->
<div class="mb-3">

  <label for="cliente" class="form-label">Cliente</label>
  <div class="d-flex gap-2">
    {{-- Autocomplete --}}
    <div id="autocomplete-entidades" class="autocomplete" data-name="entidad_id">
    </div>
    @if (!$ver)
      <div class="d-flex gap-2">
        <button id="btn_quitar_cliente" class="btn btn-danger d-none">
          <i class="align-middle" data-feather="user-x"></i>
        </button>
        <a href="{{ route('entidades.create') }}" class="btn btn-primary">Nuevo</a>
      </div>
    @endif
  </div>

  <!-- Informacion del cliente -->

  <div id="cliente"
       class="mt-3 d-none">
    <div class="d-flex gap-2 mb-3">
      <i class="align-middle" data-feather="user"></i>
      <label style="min-width: 140px;">Nombre: </label>
      <input type="text" class="nombre flex-grow-1" style="all: unset;" readonly>
    </div>
    <div class="d-flex gap-2 mb-3">
      <i class="align-middle" data-feather="file-text"></i>
      <label style="min-width: 140px;">Documento: </label>
      <input type="text" class="documento flex-grow-1" style="all: unset;" readonly>
    </div>
    <div class="d-flex gap-2 mb-3">
      <i class="align-middle" data-feather="map-pin"></i>
      <label style="min-width: 140px;">Direccion: </label>
      <input type="text" class="direccion flex-grow-1" style="all: unset;" readonly>
    </div>
    <div class="d-flex gap-2 mb-3">
      <i class="align-middle" data-feather="percent"></i>
      <label style="min-width: 140px;">Descuento: </label>
      <input type="text" class="descuento flex-grow-1" style="all: unset;" readonly>
    </div>
    <div class="d-flex gap-2 mb-3">
      <i class="align-middle" data-feather="info"></i>
      <label style="min-width: 140px;">Agente de retención: </label>
      <input type="text" class="retencion flex-grow-1" style="all: unset;" readonly>
    </div>
  </div>
</div>
