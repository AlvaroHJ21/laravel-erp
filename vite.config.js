import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
  plugins: [
    laravel({
      input: [
        // 'resources/sass/app.scss',
        // 'resources/js/app.js',
        "resources/css/app.css",
        "resources/js/app.js",
        "resources/js/almacenes/index.ts",
        "resources/js/cotizaciones/create.ts",
        "resources/js/entidades/autocomplete.ts",
      ],
      refresh: ["resources/views/**/*.blade.php", "config/adminlte.php"],
    }),
  ],
});
