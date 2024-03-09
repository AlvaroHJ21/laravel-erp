@if ($ordenVenta->guia_id)
  <div class="dropdown dropstart">
    <button class="btn dropdown-toggle btn-sm btn-info"
            type="button"
            id="dropdownGuia"
            data-bs-toggle="dropdown"
            aria-expanded="false">
      {{ $ordenVenta->guia->serie }}-{{ $ordenVenta->guia->numero }}
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownGuia">
      <li>
        <a class="dropdown-item" href="<?= base_url('guias/guias_remision/ver/' . $orden['guia_id']) ?>">Ver</a>
      </li>
      <li>
        <a class="dropdown-item" href="<?= base_url('guia/pdf/' . $orden['guia_id']) ?>" target="_blank">Ver PDF</a>
      </li>
      <li>
        <a class="dropdown-item"
           href="<?= base_url('guias/guias_remision/nuevo?ordenVentaId=' . $orden['id']) ?>">Generar otro</a>
      </li>
    </ul>
  </div>
@else
  <a href="#" class="btn btn-secondary btn-sm">
    Generar
  </a>
@endif
