<!-- Modal Inventarios-->
<div class="modal fade" id="formAlmacenInventarios{{ $almacen->id }}" tabindex="-1" aria-labelledby="formUserModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formUserModalLabel">Inventarios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover my-0" id="tabla">
                        <thead>
                            <tr>
                                <th>N.</th>
                                <th>Nombre</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($almacen->inventarios as $inventario)
                                <tr>
                                    <td>
                                        {{ $inventario->id }}
                                    </td>
                                    <td>{{ $inventario->almacen->nombre }}</td>
                                    <td>{{ $inventario->producto->nombre }}</td>
                                    <td>
                                        {{ $inventario->cantidad }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
