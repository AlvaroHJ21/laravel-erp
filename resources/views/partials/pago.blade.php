<!-- CLIENTE -->
<div class="card">
  <div class="card-header">
    <h5 class="card-title">DATOS DE PAGO</h5>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-12 mb-3">
        <label class="form-label">
          Forma / Modo de pago
        </label>
        <div class="d-flex gap-2">
          <select name="forma_pago_id" id="forma_pago_id" class="form-select">
            @foreach ($formasPago as $forma)
              <option value="{{ $forma->id }}">
                {{ $forma->nombre }}
              </option>
            @endforeach
          </select>
          <select name="modo_pago_id" id="modo_pago_id" class="form-select">
            @foreach ($modosPago as $modo)
              <option value="{{ $modo->id }}">
                {{ $modo->nombre }}
              </option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="col-12" id="pagos_container">
        <label class="form-label">Cuotas</label>
        <div id="pagos_list">
          {{-- <div class="d-flex gap-2 mb-3">
            <input type="date" name="fecha_pago[]" class="form-control" value="{{ date('Y-m-d') }}" />
            <input type="number" name="monto_pago[]" class="form-control" />
            <button class="btn btn-outline-danger" type="button">
              x
            </button>
          </div> --}}
        </div>
        <div>
          <button id="pagos_btn_add" class="btn btn-sm btn-outline-secondary" type="button" style="width: 100%">
            <i data-feather="plus"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
