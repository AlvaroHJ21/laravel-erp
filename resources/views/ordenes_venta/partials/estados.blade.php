@php
  switch ($ordenVenta->estado) {
      case 0: // Creado
          $estado = 'Creado';
          $clase = 'bg-primary';
          break;
      case 1: // O\V generada
          $estado = 'O\V generada';
          $clase = 'bg-success';
          break;
      default:
          $estado = 'Desconocido';
          $clase = 'bg-secondary';
          break;
  }
@endphp

<span class="badge {{ $clase }}">{{ $estado }}</span>
