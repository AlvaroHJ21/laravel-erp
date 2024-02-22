interface Props {
  id: string;
  data?: any[];
  filter?: string;
  onSelect?: (item: any, data: any[]) => void;
  onDiselect?: () => void;
  selected?: any;
  preserve?: boolean;
}

export class Autocomplete {
  private $component: HTMLElement | null;
  private $input: HTMLInputElement | null;
  private $dropdown: HTMLElement | null;
  private $dropdownBody: HTMLElement | null;
  public data: any[];
  private results: any[];
  private value: string;
  private selected: any;
  private onSelect?: (item: any, data: any[]) => void;
  private onDiselect?: () => void;
  private name: string;
  private placeholder: string;
  private oldValue: string;
  private preserve: boolean;

  constructor(props: Props) {
    const {
      id,
      data,
      onSelect,
      onDiselect,
      selected = null,
      preserve = true,
      filter,
    } = props;

    this.$component = document.getElementById(id);

    if (!this.$component) {
      console.error(`No se encontró el componente con el id ${id}`);
      return;
    }

    this.data = data
      ? data
      : this.$component?.dataset.data
      ? JSON.parse(this.$component?.dataset.data)
      : [];

    if (filter) {
      this.data = this.data.filter((item) => item.filter == filter);
    }

    this.results = [];
    this.value = "";
    this.selected = selected;
    this.onSelect = onSelect;
    this.onDiselect = onDiselect;
    this.preserve = preserve;

    this.name = this.$component.getAttribute("data-name") || "";
    this.placeholder = this.$component.getAttribute("data-placeholder") || "";
    this.oldValue = this.$component.getAttribute("data-old-value") || "";

    if (this.oldValue) {
      this.selected = this.data.find((item) => item.value == this.oldValue);
    }

    this.render();
  }

  private handleSelect(item: any) {
    if (this.preserve) {
      this.value = item.name;
      this.selected = item;
    }

    if (!this.$input) return;
    if (!this.$dropdown) return;
    this.$input.value = this.value;
    this.$dropdown.style.display = "none";

    this.onSelect?.(item, this.data);
    this.render();
  }

  private handleDiselect() {
    console.log("clcik");
    this.value = "";
    this.selected = null;

    console.log(this.$input);
    console.log(this.$dropdown);

    if (!this.$input) return;
    if (!this.$dropdown) return;

    this.$input.value = this.value;
    this.$dropdown.style.display = "none";

    this.onDiselect?.();
    this.render();
  }

  private render() {
    if (!this.$component) return;

    this.$component.innerHTML = "";
    this.$component.style.width = "100%";

    this.$component.innerHTML = `

      ${
        this.selected
          ? `
          <div class="d-flex" >
            <input
              type="text"
              class="form-control"
              style="min-width:120px"
              value="${this.selected.text}"
              disabled
            >
            <input type="hidden" name="${this.name}" value="${this.selected.value}">
            <button class="btn btn-outline-danger btn-sm" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
            </div>`
          : `
              <input type="text" class="form-control" placeholder="${this.placeholder}" style="min-width:120px">
              `
      }

            <div class="dropdown-menu" style="display:none">
                <div class="dropdown-menu-body d-flex flex-column">
                </div>
            </div>
    `;
    // this.target.appendChild(div);

    this.$input = this.$component.querySelector("input");
    this.$dropdown = this.$component.querySelector(
      ".dropdown-menu"
    ) as HTMLElement;
    this.$dropdownBody = this.$component.querySelector(
      ".dropdown-menu-body"
    ) as HTMLElement;

    this.$input?.addEventListener("keyup", (e) => {
      const value = this.$input?.value;

      if (!value) return;
      if (!this.$dropdown) return;

      if (value.length < 1) {
        this.results = [];
        this.renderResults();

        this.$dropdown.style.display = "none";
        return;
      }

      this.results = this.data.filter((item) => {
        return item.text.toLowerCase().includes(value.toLowerCase());
      });

      this.renderResults();
      this.$dropdown.style.display = "block";
    });

    document.addEventListener("click", (e) => {
      if (e.target !== this.$input) {
        if (!this.$dropdown) return;
        this.$dropdown.style.display = "none";
      }
    });

    const btnDiselect = this.$component.querySelector("button");

    btnDiselect?.addEventListener("click", () => this.handleDiselect());
  }

  private renderResults() {
    if (!this.$dropdownBody) return;

    this.$dropdownBody.innerHTML = "";

    if (this.results.length === 0) {
      const btn = document.createElement("button");

      btn.className = "dropdown-menu-item btn";
      btn.style.textAlign = "left";
      btn.type = "button";

      btn.innerHTML = `No se encontraron resultados`;

      this.$dropdownBody?.appendChild(btn);
    }

    this.results.forEach((result) => {
      const btn = document.createElement("button");

      btn.className = "dropdown-menu-item btn";
      btn.style.textAlign = "left";
      btn.type = "button";

      btn.innerHTML = `${result.text}`;

      btn.addEventListener("click", () => this.handleSelect(result));

      this.$dropdownBody?.appendChild(btn);
    });
  }
}
