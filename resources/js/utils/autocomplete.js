export class Autocomplete {
    constructor(props) {
        const { target, data, onSelect, onDiselect, selected = null } = props;

        this.target = document.querySelector(target);

        if (!this.target) {
            console.error(
                `No se encontró el elemento con el selector ${target}`
            );
        }

        this.data = data;
        this.results = [];
        this.value = "";
        this.selected = selected;
        this.onSelect = onSelect;
        this.onDiselect = onDiselect;

        this.name = this.target.getAttribute("data-name") || "";
        this.placeholder = this.target.getAttribute("data-placeholder") || "";
        this.oldValue = this.target.getAttribute("data-old-value") || "";

        if (this.oldValue) {
            this.selected = this.data.find(
                (item) => item.value == this.oldValue
            );
        }
    }

    render() {
        if (!this.target) return;

        this.target.innerHTML = "";

        //renderizar un input
        const div = document.createElement("div");
        div.innerHTML = `

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
            <button class="btn btn-outline-danger btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
            </div>`
              : `
              <input type="text" class="form-control" placeholder="${this.placeholder}" style="min-width:120px">
              `
      }

            <div class="dropdown-menu" style="display:none; width:92%">
                <div class="dropdown-menu-body d-flex flex-column">
                </div>
            </div>
    `;
        this.target.appendChild(div);

        const input = div.querySelector("input");
        const dropdown = div.querySelector(".dropdown-menu");
        const dropdownBody = div.querySelector(".dropdown-menu-body");

        input.addEventListener("keyup", (e) => {
            const value = e.target.value;

            if (value.length < 1) {
                this.results = [];
                this.renderResults(dropdownBody);
                dropdown.style.display = "none";
                return;
            }

            this.results = this.data.filter((item) => {
                return item.text.toLowerCase().includes(value.toLowerCase());
            });

            this.renderResults(dropdownBody);
            dropdown.style.display = "block";
        });

        document.addEventListener("click", (e) => {
            if (e.target !== input) {
                dropdown.style.display = "none";
            }
        });

        const btnDiselect = div.querySelector("button");
        if (btnDiselect) {
            btnDiselect.addEventListener("click", () => {
                this.value = "";
                this.selected = null;
                this.target.querySelector("input").value = this.value;
                this.target.querySelector(".dropdown-menu").style.display =
                    "none";

                this.onDiselect();
                this.render();
            });
        }
    }

    renderResults(target) {
        target.innerHTML = "";

        if (this.results.length === 0) {
            const btn = document.createElement("button");

            btn.className = "dropdown-menu-item btn";
            btn.style.textAlign = "left";
            btn.type = "button";

            btn.innerHTML = `No se encontraron resultados`;

            target.appendChild(btn);
        }

        this.results.forEach((result) => {
            const btn = document.createElement("button");

            btn.className = "dropdown-menu-item btn";
            btn.style.textAlign = "left";
            btn.type = "button";

            btn.innerHTML = `${result.text}`;

            btn.addEventListener("click", () => {
                this.value = result.name;
                this.selected = result;
                this.target.querySelector("input").value = this.value;
                this.target.querySelector(".dropdown-menu").style.display =
                    "none";

                this.onSelect(result);
                this.render();
            });

            target.appendChild(btn);
        });
    }
}
