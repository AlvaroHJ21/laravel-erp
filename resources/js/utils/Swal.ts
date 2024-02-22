import Swal from "sweetalert2";

export function showError(error: [string] | string) {
  Swal.fire({
    icon: "error",
    title: "Error",
    html: Array.isArray(error) ? error.join("<br>") : error,
  });
}

export function showSuccess(message: string, onConfirm?: () => void) {
  Swal.fire({
    icon: "success",
    title: "Correcto",
    text: message,
  }).then((e) => {
    console.log(e);
    if (e.isConfirmed || e.isDismissed) {
      onConfirm?.();
    }
  });
}
