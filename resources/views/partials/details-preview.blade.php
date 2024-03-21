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

          @foreach ($detalles as $index => $detalle)
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
                <button data-bs-toggle="modal" data-bs-target="#modal-imagen" type="button" class="btn">
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
          <label class="col-1">{{ $moneda->simbolo }}</label>
          <div class="col">
            <input type="text" class="form-control" readonly value="{{ $total_gravada }}">
          </div>
        </div>

        <div class="row">
          <label class="col">Total IGV:</label>
          <label class="col-1">{{ $moneda->simbolo }}</label>
          <div class="col">
            <input type="text" class="form-control" readonly value="{{ $total_igv }}">
          </div>
        </div>

        <div class="row">
          <label class="col">Total a Pagar:</label>
          <label class="col-1">{{ $moneda->simbolo }}</label>
          <div class="col">
            <input type="text" class="form-control" readonly value="{{ $total_pagar }}">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
