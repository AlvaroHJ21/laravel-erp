@php
  switch ($venta->estado) {
      case 0: // Creado
          $estado = 'Creado';
          $clase = 'bg-primary';
          break;
      case 1: // O\V generada
          $estado = 'Enviado y Aceptado';
          $clase = 'bg-success';
          break;
      case 2: // O\V generada
          $estado = 'Enviado y Rechazado';
          $clase = 'bg-error';
          break;
      default:
          $estado = 'Desconocido';
          $clase = 'bg-secondary';
          break;
  }
@endphp

<span class="badge {{ $clase }}">{{ $estado }}</span>
