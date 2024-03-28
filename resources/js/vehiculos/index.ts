import { Vehiculo } from "../interfaces";

declare const vehiculos: Vehiculo[];
declare const postUrl: string;
declare const updateUrl: string;

const $form = document.getElementById("form") as HTMLFormElement;
const $addButton = document.getElementById("btn-add") as HTMLButtonElement;
const $editButtons = document.querySelectorAll(
  ".btn-edit"
) as NodeListOf<HTMLButtonElement>;

let vehiculo: Vehiculo | undefined = undefined;

if (!$form) {
  throw new Error("Element not found");
}

$form.addEventListener("submit", async (event) => {
  try {
    event.preventDefault();
    const formData = new FormData($form);
    const data = Object.fromEntries(formData);
    data["categoria_m1_l"] = data["categoria_m1_l"] === "on" ? "1" : "0";

    if (vehiculo) {
      // Update
      const resp = await fetch(
        updateUrl.replace(":id", vehiculo.id.toString()),
        {
          method: "PUT",
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          body: JSON.stringify(data),
        }
      );
      const json = await resp.json();
      if (resp.ok) {
        location.reload();
      } else {
        window.alert(json.message);
      }
    } else {
      // Create
      const resp = await fetch(postUrl, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify(data),
      });
      const json = await resp.json();
      if (resp.ok) {
        location.reload();
      } else {
        window.alert(json.message);
      }
    }
  } catch (error) {
    window.alert(error.message);
  }
});

$addButton.addEventListener("click", () => {
  $form["placa"].value = "";
  $form["modelo"].value = "";
  $form["marca"].value = "";
  $form["categoria_m1_l"].checked = false;
});

$editButtons.forEach(($button) => {
  $button.addEventListener("click", () => {
    const id = $button.dataset.id;
    vehiculo = vehiculos.find((v) => v.id == Number(id));

    if (!vehiculo) {
      throw new Error("Vehiculo not found");
    }

    $form["placa"].value = vehiculo.placa;
    $form["modelo"].value = vehiculo.modelo;
    $form["marca"].value = vehiculo.marca;
    $form["categoria_m1_l"].checked = vehiculo.categoria_m1_l;
  });
});
