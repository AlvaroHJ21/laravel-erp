import type { Item, Producto } from "../interfaces";

interface Props {
  id: string;
  items?: Item[];
  disabled?: boolean;
  limited?: boolean;
  unidades?: any[];
  tiposIGV?: any[];
  tipoCambioDolar?: number;
}

export class TableItems {
  private $table: HTMLElement | null;
  private items: Item[];
  private tiposIGV: any[];
  private totalGravada: number = 0;
  private totalImpuesto: number = 0;
  private totalPago: number = 0;
  private tipoCambioDolar: number;
  private monedaId: number;

  constructor(props: Props) {
    const { id, items, tiposIGV, tipoCambioDolar } = props;

    this.$table = document.getElementById(id);
    this.items = items || [];
    this.tiposIGV = tiposIGV || [];

    if (!tipoCambioDolar) {
      console.error("No se encontró el tipo de cambio del dolar");
      return;
    }

    this.tipoCambioDolar = tipoCambioDolar;
    this.monedaId = 1;

    this.render();
  }

  public addItem(producto: Producto) {
    const exitItem = this.items.find((item) => item.id == producto.id);

    if (exitItem) {
      this.updateItem(producto.id, {
        cantidad: exitItem.cantidad + 1,
      });
    } else {
      this.items.push({
        cantidad: 1,
        descripcion_adicional: "",
        id: producto.id,
        impuesto_id: 1,
        impuesto_portcentaje: 18,
        inventario: null,
        producto,
        precio_venta: producto.precio_venta,
        subtotal: producto.precio_venta,
      });
    }
    this.calcMontos();
    this.render();
  }

  public quitItem(id: number) {
    this.items = this.items.filter((item) => item.id != id);
    this.calcMontos();
    this.render();
  }

  public updateItem(id: number, data: Partial<Item>) {
    this.items = this.items.map((item) => {
      if (item.id == id) {
        return { ...item, ...data };
      }
      return item;
    });
  }

  public calcMontos() {
    this.calcMontosItems();
    this.calcMontosTotales();
  }

  public calcMontosItems() {
    // Recalcular los precios de venta
    this.items = this.items.map((item) => {
      // si el producto está en dolares y la moneda es soles
      if (item.producto.moneda_id == 2 && this.monedaId == 1) {
        return {
          ...item,
          precio_venta: item.producto.precio_venta * this.tipoCambioDolar,
        };
      }

      // si el producto está en soles y la moneda es dolares
      if (item.producto.moneda_id == 1 && this.monedaId == 2) {
        return {
          ...item,
          precio_venta: item.producto.precio_venta / this.tipoCambioDolar,
        };
      }

      // si son la misma moneda
      return {
        ...item,
        precio_venta: item.producto.precio_venta,
      };
    });

    // calcular los subtotales
    this.items = this.items.map((item) => {
      return {
        ...item,
        subtotal:
          item.cantidad *
          item.precio_venta *
          (1 + Number(item.impuesto_portcentaje) / 100),
      };
    });
  }

  public calcMontosTotales() {
    this.totalGravada = this.items.reduce(
      (acc, item) => acc + item.precio_venta * item.cantidad,
      0
    );
    this.totalImpuesto = this.items.reduce(
      (acc, item) =>
        acc +
        item.precio_venta *
          item.cantidad *
          (Number(item.impuesto_portcentaje) / 100),
      0
    );
    this.totalPago = this.totalGravada + this.totalImpuesto;
  }

  public render() {
    if (this.$table instanceof HTMLTableElement) {
      this.$table.innerHTML = `
        <thead>
          <tr>
            <th class="col-sm-2">Producto</th>
            <th class="" style="width: 100px;">Imagen</th>
            <th class="" style="width: 100px;">Código</th>
            <th style="width: 80px;">Cantidad</th>
            <th class="">Impuesto</th>
            <th class="" style="text-align: end; width: 80px;">Valor Venta</th>
            <th class="" style="text-align: end; width: 60px;">Desc (%)</th>
            <th class="" style="text-align: end; width: 80px;">Sub Total</th>
          </tr>
        </thead>
        <tbody>
          ${this.items.map((item) => this.renderItem(item)).join("")}
        </tbody>
      `;

      this.events();
    }

    this.renderMontosTotales();
  }

  public renderItem(item: Item) {
    const image = item.producto.imagen
      ? `/storage/productos/${item.producto.imagen}`
      : "/img/default-image.png";

    return `
    <tr data-id="${item.id}">
      <td>
        <div>
          <input type="text" value="${
            item.producto.nombre
          }" class="form-control" />
          <textarea class="descripcion-adicional form-control text-sm mt-1" placeholder="Descripción Adicional">${
            item.descripcion_adicional
          }</textarea>
        </div>
      </td>
      <td>
        <button data-bs-toggle="modal" data-bs-target="#modal-imagen" type="button" data-image="${image}">
          <img class="img-thumbnail" src="${image}" alt="producto" width="100px"/>
        </button>
      </td>
      <td>
        <input type="text" class="form-control text-sm" style="max-width: 100px;" placeholder="T001" value="${
          item.producto.codigo
        }">
      </td>
      <td>
        <input
          type="number"
          class="cantidad form-control text-sm"
          style="max-width: 80px;"
          placeholder="Ej. 1"
          min="1"
          value="${item.cantidad}"
        >
        <span class="form-text" style="position:absolute;"></span>
      </td>
      <td>
        <select class="tipo-igv form-select text-sm">
      ${this.tiposIGV
        .map((tipo) => {
          return `
          <option value="${tipo.id}" ${
            tipo.id == item.impuesto_id ? "selected" : ""
          }>
          ${tipo.porcentaje}% ${tipo.tipo_igv}
          </option>`;
        })
        .join("")}
        </select>
      </td>
      <td>
        <input type="number" class="form-control text-sm" style="text-align: right; width: 80px" placeholder="" step="0.01" min="0" value="${Number(
          item.precio_venta
        ).toFixed(2)}" disabled>
      </td>
      <td>
        <input type="number" class="form-control text-sm" style="text-align: right; width: 60px" placeholder="" step="0.01" min="0" value="0" disabled>
      </td>
      <td>
        <input type="number" class="form-control text-sm" style="text-align: right; width: 80px" placeholder="" step="0.01" min="0" value="${Number(
          item.subtotal
        ).toFixed(2)}" disabled>
      </td>
      <td>
        <button class="btn btn-outline-danger btn-quitar" data-id=${
          item.id
        } type="button">x</button>
      </td>
    </tr>
    `;
  }

  public events() {
    const $rows = this.$table!.querySelectorAll("tr");

    $rows.forEach(($row) => {
      const id = $row.dataset.id;

      if (!id) return;

      // Descripcion Adicional
      const $descipcionAdd = $row.querySelector(
        ".descripcion-adicional"
      ) as HTMLInputElement;

      $descipcionAdd.addEventListener("keyup", (e) => {
        this.updateItem(+id, {
          descripcion_adicional: $descipcionAdd.value,
        });
      });

      // Imagen
      const $image = $row.querySelector("img") as HTMLImageElement;
      $image.addEventListener("click", () => {
        const $img = document.querySelector(
          ".modal-content #imagen"
        ) as HTMLImageElement;
        $img?.setAttribute("src", $image.src);
      });

      // Cantidad
      const $cantidad = $row.querySelector(".cantidad") as HTMLInputElement;
      $cantidad.addEventListener("change", (e) => {
        const value = parseInt($cantidad.value);

        if (isNaN(value)) {
          $cantidad.value = "1";
          return;
        }

        this.updateItem(+id, {
          cantidad: value,
        });

        this.calcMontos();
        this.render();
      });

      // Tipo de IGV
      const $tipoIGV = $row.querySelector(".tipo-igv") as HTMLSelectElement;
      $tipoIGV.addEventListener("change", (e) => {
        const impuestoId = parseInt($tipoIGV.value);

        const impuesto = this.tiposIGV.find((tipo) => tipo.id == impuestoId);

        this.updateItem(+id, {
          impuesto_id: impuestoId,
          impuesto_portcentaje: impuesto.porcentaje,
        });

        this.calcMontos();
        this.render();
      });

      // Eliminar item
      const $btnQuitar = $row.querySelector(".btn-quitar") as HTMLButtonElement;
      $btnQuitar.addEventListener("click", () => {
        this.quitItem(+id);
      });
    });
  }

  public renderMontosTotales() {
    const $totalGravada = document.getElementById(
      "total_gravada"
    ) as HTMLInputElement;
    const $total_igv = document.getElementById("total_igv") as HTMLInputElement;
    const $total = document.getElementById("total") as HTMLInputElement;

    if (!$totalGravada || !$total_igv || !$total) return;

    $totalGravada.value = this.totalGravada.toFixed(2);
    $total_igv.value = this.totalImpuesto.toFixed(2);
    $total.value = this.totalPago.toFixed(2);
  }

  public setMonedaId(id: number) {
    this.monedaId = id;
    this.calcMontos();
    this.render();
  }

  public getItems() {
    return this.items;
  }
}
