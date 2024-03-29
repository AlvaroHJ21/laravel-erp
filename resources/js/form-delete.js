const forms = document.querySelectorAll(".form-delete");
const btnsDelete = document.querySelectorAll(".btn-delete");

forms.forEach((form) => {
    form.addEventListener("submit", (e) => {
        e.preventDefault();
        Swal.fire({
            title: "¿Estás seguro?",
            text: "No podrás revertir esto",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});

btnsDelete.forEach((btn) => {
    btn.addEventListener("click", () => {
        Swal.fire({
            title: "¿Estás seguro?",
            text: "No podrás revertir esto",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                const url = btn.getAttribute("data-url");

                if (!url) {
                    console.log("No se encontró el atributo data-url");
                    return;
                }

                const csrf = document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content");

                if (!csrf) {
                    console.log("No se encontró el token csrf");
                    return;
                }

                fetch(url, {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrf,
                    },
                }).then((e) => {
                    if (e.ok) {
                        location.reload();
                    }
                });
            }
        });
    });
});
