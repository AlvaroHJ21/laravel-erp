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
          <div>
            {{ $tipoDocumento }}
          </div>
          <div>
            {{ $identificadorDocumento }}
          </div>
          <div> RUC:{{ $empresa->ruc }}</div>
        </div>
      </td>
    </tr>
  </table>
</header>
