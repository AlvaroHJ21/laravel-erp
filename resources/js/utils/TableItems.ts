import type { TableRow as TableRow, Producto, Inventario } from "../interfaces";

interface Props {
  id: string;
  items?: TableRow[];
  disabled?: boolean;
  limited?: boolean;
  unidades?: any[];
  tiposIGV?: any[];
  tipoCambioDolar?: number;
}

export class TableItems {
  private $table: HTMLElement | null;
  private items: TableRow[];
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

  public addItem(inventario: Inventario) {
    const exitItem = this.items.find((item) => item.id == inventario.id);

    if (exitItem) {
      this.updateItem(inventario.id, {
        cantidad: exitItem.cantidad + 1,
      });
    } else {
      this.items.push({
        id: inventario.id,
        codigo: inventario.producto.codigo,
        cantidad: 1,
        descripcion_adicional: "",
        tipo_igv_id: 1,
        tipo_igv_porcentaje: 18,
        producto: inventario.producto,
        valor_venta: inventario.producto.precio_venta,
        subtotal: inventario.producto.precio_venta,
        producto_id: inventario.id,
        porcentaje_descuento: 0,
        inventario_id: inventario.id,
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

  public updateItem(id: number, data: Partial<TableRow>) {
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
          valor_venta: item.producto.valor_venta * this.tipoCambioDolar,
        };
      }

      // si el producto está en soles y la moneda es dolares
      if (item.producto.moneda_id == 1 && this.monedaId == 2) {
        return {
          ...item,
          valor_venta: item.producto.valor_venta / this.tipoCambioDolar,
        };
      }

      // si son la misma moneda
      return {
        ...item,
        valor_venta: item.producto.valor_venta,
      };
    });

    // calcular los subtotales
    this.items = this.items.map((item) => {
      return {
        ...item,
        subtotal:
          item.cantidad *
          item.valor_venta *
          (1 + Number(item.tipo_igv_porcentaje) / 100),
      };
    });
  }

  public calcMontosTotales() {
    this.totalGravada = this.items.reduce(
      (acc, item) => acc + item.valor_venta * item.cantidad,
      0
    );
    this.totalImpuesto = this.items.reduce(
      (acc, item) =>
        acc +
        item.valor_venta *
          item.cantidad *
          (Number(item.tipo_igv_porcentaje) / 100),
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
            <th class="" style="width: 50px;"></th>
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

  public renderItem(item: TableRow) {
    const image = item.producto.imagen
      ? `/storage/productos/${item.producto.imagen}`
      : "/img/default-image.png";

    return `
    <tr data-id="${item.id}">
      <td>
        <div>
          <input type="text" value="${
            item.producto.nombre
          }" class="form-control" readOnly/>
          <textarea class="descripcion-adicional form-control text-sm mt-1" placeholder="Descripción Adicional">${
            item.descripcion_adicional
          }</textarea>
        </div>
      </td>
      <td>
        <button data-bs-toggle="modal" data-bs-target="#modal-imagen" type="button" data-image="${image}">
          <img class="img-thumbnail image" src="${image}" alt="producto" width="100px"/>
        </button>
      </td>
      <td>
        <input type="text" class="codigo form-control text-sm" style="max-width: 100px;" placeholder="T001" value="${
          item.codigo
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
            tipo.id == item.tipo_igv_id ? "selected" : ""
          }>
          ${tipo.porcentaje}% ${tipo.tipo_igv}
          </option>`;
        })
        .join("")}
        </select>
      </td>
      <td>
        <input type="number" class="form-control text-sm" style="text-align: right; width: 80px" placeholder="" step="0.01" min="0" value="${Number(
          item.valor_venta
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
      const $descripcionAdd = $row.querySelector(
        ".descripcion-adicional"
      ) as HTMLInputElement;

      $descripcionAdd.addEventListener("keyup", (e) => {
        this.updateItem(+id, {
          descripcion_adicional: $descripcionAdd.value,
        });
      });

      // Imagen
      const $image = $row.querySelector(".image") as HTMLImageElement;
      $image.addEventListener("click", () => {
        const $img = document.querySelector(
          ".modal-content img"
        ) as HTMLImageElement;
        $img?.setAttribute("src", $image.src);
      });

      // Codigo
      const $codigo = $row.querySelector(".codigo") as HTMLInputElement;
      $codigo.addEventListener("keyup", (e) => {
        this.updateItem(+id, {
          codigo: $codigo.value,
        });
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
          tipo_igv_id: impuestoId,
          tipo_igv_porcentaje: impuesto.porcentaje,
        });

        this.calcMontos();
        this.render();
      });

      // Eliminar item
      const $btnQuitar = $row.querySelector(".btn-quitar") as HTMLButtonElement;
      $btnQuitar.addEventListener("click", () => {
        this.quitItem(+id);
      });

      //TODO: completar
    });
  }

  public renderMontosTotales() {
    const $totalGravada = document.getElementById(
      "total_gravada"
    ) as HTMLInputElement;
    const $total_igv = document.getElementById("total_igv") as HTMLInputElement;
    const $total = document.getElementById("total_pagar") as HTMLInputElement;

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

  public setItems(items: TableRow[]) {
    this.items = items;
    this.calcMontos();
    this.render();
  }
}
