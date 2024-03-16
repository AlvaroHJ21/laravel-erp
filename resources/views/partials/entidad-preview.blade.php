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
            {{ $entidad->nombre }}
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
            {{ $entidad->numero_documento }}
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
            {{ $entidad->direccion }}
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
            {{ $entidad->porcentaje_descuento }}
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
            {{ $entidad->retencion ? 'Sí' : 'No' }}
          </label>
        </div>
      </div>
    </div>
  </div>
</div>
