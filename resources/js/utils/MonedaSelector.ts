interface Options {
  onChangeMoneda?(monedaId: number): void;
}

export class MonedaSelector {
  constructor({ onChangeMoneda }: Options = {}) {
    const $moneda = document.getElementById("moneda_id") as HTMLSelectElement;

    handleChangeMoneda();

    $moneda?.addEventListener("change", () => {
      handleChangeMoneda();
    });

    function handleChangeMoneda() {

      onChangeMoneda?.(parseInt($moneda.value));

      const simbolo = $moneda.options[$moneda.selectedIndex].dataset.simbolo;

      const $simbolos = document.querySelectorAll(
        ".simbolo_moneda"
      ) as NodeListOf<HTMLElement>;
      $simbolos.forEach((el) => {
        el.innerHTML = simbolo ?? "";
      });
    }
  }
}
