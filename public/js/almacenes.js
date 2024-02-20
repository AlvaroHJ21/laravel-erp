import { Autocomplete } from "./autocomplete.js";

// if (typeof inventarios === "undefined") {
//     var inventarios = [];
// }

// console.log(typeof inventarios);
const selectAlmacenOrigen = document.getElementById("almacen_origen_id");

selectAlmacenOrigen?.addEventListener("change", (e) => {
    renderAutocomplete();
});

renderAutocomplete();

function renderAutocomplete() {
    const almacenOrigenId = document.getElementById("almacen_origen_id")?.value;

    if (!almacenOrigenId) {
        return;
    }

    const filteredInventarios = inventarios.filter(
        (inventario) => inventario.almacen_id == almacenOrigenId
    );

    const autocomplete = new Autocomplete({
        target: "#inventario-autocomplete",
        data: filteredInventarios.map((inventario) => ({
            value: inventario.id,
            text: `${inventario.producto.nombre} - ${inventario.almacen.nombre} - ${inventario.cantidad}`,
        })),
        onSelect(selected) {
            const inventarioSeleccionado = inventarios.find(
                (inventario) => inventario.id == selected.value
            );

            const inputCantidadActual =
                document.getElementById("cantidad_actual");
            inputCantidadActual.value = inventarioSeleccionado.cantidad;
        },
        onDiselect() {},
    });

    autocomplete.render();
}
