<!-- TABLA DE ITEMS -->
<table id="tabla-items" class="table table-hover table-sm mb-3">
  <thead>
    <tr>
      <th class="col-sm-2">Producto</th>
      <th class="" style="width: 100px;">Imagen</th>
      <th class="" style="width: 100px;">Código</th>
      <th class="">Unid. Medida</th>
      <th style="width: 80px;">Cantidad</th>
      <th class="">Impuesto</th>
      <th class="" style="text-align: end; width: 80px;">Valor Venta</th>
      <th class="" style="text-align: end; width: 60px;">Desc (%)</th>
      <th class="" style="text-align: end; width: 80px;">Sub Total</th>
    </tr>
  </thead>
  <tbody id="tabla-items-body">

  </tbody>
</table>

@unless ($ver)
  <div>
    <button id="btn-add-item" class="btn btn-primary btn-sm" type="button">Agregar Item</button>
    <a href="{{ route('productos.create') }}" class="btn btn-success btn-sm">Nuevo Producto</a>
  </div>
@endunless
