<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="{{ public_path('css/pdf.utils.css') }}">
  <link rel="stylesheet" href="{{ public_path('css/pdf.css') }}">
</head>

<body>

  {{-- Header --}}
  <header class="header">
    <table class="w-full">
      <tr>
        <td class="logo-td" style="width: 160px">
          <div class="logo" style="max-width: 160px">
            <img src="{{ $logo }}" alt="logo">
          </div>
        </td>
        <td>
          <table class="text-sm table-empresa">
            <tr>
              <td colspan="3">
                <div class="font-bold uppercase">{{ $empresa->razon_social }}</div>
              </td>
            </tr>
            <tr>
              <td>WhatsApp</td>
              <td style="width: 10px">:</td>
              <td>{{ $empresa->telefono_movil }}</td>
            </tr>
            <tr>
              <td>E-Mail</td>
              <td>:</td>
              <td>{{ $empresa->correo }}</td>
            </tr>
            <tr>
              <td>Webside</td>
              <td>:</td>
              <td>{{ $empresa->web }}</td>
            </tr>
          </table>
        </td>
        <td class="" style="width: 160px">
          <div class="inline-block border py-2 font-bold text-center" style="width: 160px">
            <div>COTIZACIÓN</div>
            <div>#{{ $cotizacion->id }}</div>
            <div> RUC:{{ $empresa->ruc }}</div>
          </div>
        </td>
      </tr>
    </table>
  </header>

  {{-- Datos del documento --}}
  <table class="table-document-info">
    <tr>
      <td>Fecha de Emisión </td>
      <td>:</td>
      <td>{{ date('d/m/Y', strtotime($cotizacion->created_at)) }}</td>
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
        <th>Imagen Referencial</th>
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
          <td>{{ $item->producto->nombre . " " . $item->producto->codigo . " " . $item->descripcion_adicional }}</td>
          <td>
            @if ($item->producto->imagen == null)
              <img src="{{ public_path('img/default-image.png') }}" width="100">
            @else
              <img src="{{ public_path('storage/productos/' . $item->producto->imagen) }}" width="100">
            @endif
          </td>
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
          {{ $cotizacion->total_gravada }}
        </td>
      </tr>
      <tr>
        <td>IGV</td>
        <td>:</td>
        <td>{{ $moneda->simbolo }} {{ $cotizacion->total_igv }}</td>

      </tr>
      <tr>
        <td>Total</td>
        <td>:</td>
        <td>{{ $moneda->simbolo }} {{ $cotizacion->total_pagar }}</td>
      </tr>
    </table>
    <div class="text-amount absolute bottom-0 uppercase">
      {{ $totalLetras }}
    </div>
  </div>

  {{-- <pre>
        {{ json_encode($empresa, JSON_PRETTY_PRINT) }}
        {{ public_path('storage/' . $empresa->logo) }}
    </pre> --}}
</body>

</html>
