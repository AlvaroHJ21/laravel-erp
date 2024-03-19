@extends('layouts.pdf')

@section('content')
  {{-- Header --}}
  @include('partials.pdf-header', [
      'tipoDocumento' => $venta->tipo_documento_id == 1 ? 'FACTURA ELECTRÓNICA' : 'BOLETA ELECTRÓNICA',
      'identificadorDocumento' => $venta->serie->serie . '-' . $venta->numero,
  ])

  {{-- Datos del documento --}}
  <table class="table-document-info">
    <tr>
      <td>Fecha de Emisión </td>
      <td>:</td>
      <td>{{ date('d/m/Y', strtotime($venta->created_at)) }}</td>
    </tr>
    <tr>
      <td>Señor(es)</td>
      <td>:</td>
      <td>{{ $entidad->nombre }}</td>
    </tr>
    <tr>
      <td>Dirección del Cliente</td>
      <td>:</td>
      <td>{{ $entidad->direccion }}</td>
    </tr>
    <tr>
      <td>Tipo de Moneda</td>
      <td>:</td>
      <td class="uppercase">{{ $moneda->nombre }}</td>
    </tr>
  </table>

  {{-- Tabla de detalles --}}
  <table class="table-details">
    <thead>
      <tr>
        <th>Pos</th>
        <th>Código</th>
        <th>Descripción</th>
        <th>Cantidad</th>
        <th>Unidad de Medida</th>
        <th class="text-right">Valor Unitario</th>
        <th class="text-right">Sub Total</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($items as $item)
        <tr>
          <td>1</td>
          <td>{{ $item->codigo }}</td>
          <td>{{ $item->producto->nombre . ' ' . $item->producto->codigo . ' ' . $item->descripcion_adicional }}</td>
          <td>{{ $item->cantidad }}</td>
          <td>{{ $item->producto->unidad->unidad }}</td>
          <td class="text-right">{{ number_format($item->valor_venta, 2) }}</td>
          <td class="text-right">{{ number_format($item->valor_venta * $item->cantidad, 2) }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  {{-- Totales --}}
  <div class="relative" style="height: 90px;">
    <table class="absolute right-0 table-amounts">
      <tr>
        <td>Total gravada</td>
        <td>:</td>
        <td>{{ $moneda->simbolo }}
          {{ $venta->total_gravada }}
        </td>
      </tr>
      <tr>
        <td>IGV</td>
        <td>:</td>
        <td>{{ $moneda->simbolo }} {{ $venta->total_igv }}</td>

      </tr>
      <tr>
        <td>Total</td>
        <td>:</td>
        <td>{{ $moneda->simbolo }} {{ $venta->total_pagar }}</td>
      </tr>
    </table>
    <div class="text-amount absolute bottom-0 uppercase">
      {{ $totalLetras }}
    </div>
  </div>

  {{-- QR --}}
  @if ($venta->estado == 1)
    <div class="text-center py-8">
      <img src="data:image/png;base64, {!! base64_encode($qr) !!} " style="margin: 0 auto">
      <p>{{ $venta->firma_sunat }}</p>
    </div>
  @endif
@endsection
