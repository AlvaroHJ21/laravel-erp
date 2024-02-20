import { Autocomplete } from "./utils/autocomplete";

const inventarioAutocomplete = document.getElementById(
    "inventario-autocomplete"
);

const selectAlmacenOrigen = document.getElementById("almacen_origen_id");
selectAlmacenOrigen?.addEventListener("change", (e) => {
    const inventarios = JSON.parse(inventarioAutocomplete.dataset.inventarios);

    renderAutocomplete(inventarios);
});

renderAutocomplete(JSON.parse(inventarioAutocomplete.dataset.inventarios));

function renderAutocomplete(inventarios) {
    const almacenOrigenId = selectAlmacenOrigen?.value;

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
