<div class="modal fade" id="formModalMove" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="id1"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="form-movimiento" method="post" action="{{ route('almacenes.move') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <div class="form-group row mb-3">
                        <div class="col-sm-6">
                            <label for="almacen_origen_id" class="col-form-label">Seleccionar Almacen origen</label>
                            <select name="almacen_origen_id" class="form-select" id="almacen_origen_id">
                                {{-- <option value="">Selecciona almacen de origen</option> --}}
                                @foreach ($almacenes as $almacen)
                                    @if ($almacen->activo)
                                        <option value="{{ $almacen->id }}"
                                            {{ old('almacen_origen_id') == $almacen->id ? 'selected' : '' }}>
                                            {{ $almacen->nombre }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label for="almacen_destino_id" class="col-form-label">Seleccionar Almacen destino</label>
                            <select name="almacen_destino_id" class="form-select" id="almacen_destino_id">
                                {{-- <option value="">Selecciona almacen de destino</option> --}}
                                @foreach ($almacenes as $almacen)
                                    @if ($almacen->activo)
                                        <option value="{{ $almacen->id }}"
                                            {{ old('almacen_destino_id') == $almacen->id ? 'selected' : '' }}>
                                            {{ $almacen->nombre }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-form-label">Inventario</label>
                        <div id="inventario-autocomplete"
                            data-name="inventario_id"
                            data-placeholder="Buscar inventario"
                            data-old-value="{{ old('inventario_id') }}">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <div class="col-sm-6">
                            <label for="cantidad_actual" class="col-form-label">Cantidad actual</label>
                            <input type="number" id="cantidad_actual" class="form-control" readonly
                                name="cantidad_actual"
                                value="{{ old('cantidad_actual') }}">
                        </div>
                        <div class="col-sm-6">
                            <label for="cantidad" class="col-form-label">Cantidad </label>
                            <input type="number" name="cantidad" id="cantidad" class="form-control"
                                value="{{ old('cantidad') }}">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btn_mover">Mover</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
