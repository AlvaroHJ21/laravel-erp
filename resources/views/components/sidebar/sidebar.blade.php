<?php

$current = request()->route() ? explode('/', request()->route()->uri) : [''];

$options = [
    [
        'id' => 'entidades',
        'name' => 'Entidades',
        'expanded' => $current[0] == 'entidades', // Si el menu esta expandido o no
        'active' => $current[0] == 'entidades', // Si el menu esta activo o no
        'icon' => 'user',
        'items' => [
            [
                'name' => 'Clientes/Proveedores',
                'url' => 'entidades/clientes_proveedores',
                'route' => 'entidades.index',
            ],
            [
                'name' => 'Empleados',
                'url' => 'entidades/empleados',
            ],
        ],
    ],
    [
        'id' => 'ventas',
        'name' => 'Ventas',
        'expanded' => $current[0] == 'ventas',
        'active' => $current[0] == 'ventas',
        'icon' => 'dollar-sign',
        'items' => [
            [
                'name' => 'Cotizaciones',
                'url' => 'ventas/cotizaciones',
            ],
            [
                'name' => 'Órdenes de venta',
                'url' => 'ventas/ordenes_venta',
            ],
            [
                'name' => 'Venta',
                'url' => 'ventas/cpe',
            ],
            [
                'name' => 'Notas',
                'url' => 'ventas/notas',
            ],
        ],
    ],
    [
        'id' => 'guias',
        'name' => 'Guias',
        'expanded' => $current[0] == 'guias',
        'active' => $current[0] == 'guias',
        'icon' => 'truck',
        'items' => [
            [
                'name' => 'Guías de Remisión',
                'url' => 'guias/guias_remision',
            ],
            [
                'name' => 'Vehículos',
                'url' => 'guias/vehiculos',
            ],
            [
                'name' => 'Conductores',
                'url' => 'guias/conductores',
            ],
            [
                'name' => 'Transportistas',
                'url' => 'guias/transportistas',
            ],
        ],
    ],
    [
        'id' => 'compras',
        'name' => 'Compras',
        'expanded' => $current[0] == 'compras',
        'active' => $current[0] == 'compras',
        'icon' => 'shopping-bag',
        'items' => [
            [
                'name' => 'Órdenes de compras',
                'url' => 'compras/ordenes_compra',
            ],
            [
                'name' => 'Compra',
                'url' => 'compras/cpe',
            ],
        ],
    ],
    [
        'id' => 'almacen',
        'name' => 'Almacén',
        'expanded' => $current[0] == 'almacen',
        'active' => $current[0] == 'almacen',
        'icon' => 'package',
        'items' => [
            [
                'name' => 'Unidades',
                'url' => 'almacen/unidades',
                'route' => 'unidades.index',
            ],
            [
                'name' => 'Categorías',
                'url' => 'almacen/categorias',
            ],
            [
                'name' => 'Productos',
                'url' => 'almacen/productos',
            ],
            [
                'name' => 'Impuestos',
                'url' => 'almacen/impuestos',
            ],
            [
                'name' => 'Almacenes',
                'url' => 'almacen/inventario',
            ],
        ],
    ],
    [
        'id' => 'reportes',
        'name' => 'Reportes',
        'expanded' => $current[0] == 'reportes', // Si el menu esta expandido o no
        'active' => $current[0] == 'reportes', // Si el menu esta activo o no
        'icon' => 'bar-chart-2',
        'items' => [
            [
                'name' => 'Ventas',
                'url' => 'reportes/ventas',
            ],
            [
                'name' => 'Compras',
                'url' => 'reportes/compras',
            ],
            [
                'name' => 'Clientes',
                'url' => 'reportes/clientes',
            ],
            [
                'name' => 'Proveedores',
                'url' => 'reportes/proveedores',
            ],
        ],
    ],
    [
        'id' => 'configuracion',
        'name' => 'Configuración',
        'expanded' => $current[0] == 'configuracion',
        'active' => $current[0] == 'configuracion',
        'icon' => 'settings',
        'items' => [
            [
                'name' => 'Series',
                'url' => 'configuracion/series',
                'route' => 'series.index',
            ],
            [
                'name' => 'Empresas',
                'url' => 'configuracion/empresas',
                'route' => 'empresas.index',
            ],
            [
                'name' => 'Monedas',
                'url' => 'configuracion/monedas',
                'route' => 'monedas.index',
            ],
            [
                'name' => 'Tipo de cambio',
                'url' => 'configuracion/tipos_cambio',
                'route' => 'tipos_cambio.index',
            ],
        ],
    ],
];

?>

<nav id="sidebar" class="sidebar js-sidebar">

    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="#">
            <span class="align-middle">Mini ERP</span>
        </a>



        <ul class="sidebar-nav">

            <?php foreach ($options as $option) : ?>

            <li class="sidebar-item <?= $option['active'] ? 'active' : '' ?>">

                <a data-bs-target="#<?= $option['id'] ?>" data-bs-toggle="collapse" class="sidebar-link "
                    aria-expanded="false">
                    <i class="align-middle" data-feather="<?= $option['icon'] ?>"></i> <span
                        class="align-middle"><?= $option['name'] ?></span>
                </a>

                <ul id="<?= $option['id'] ?>"
                    class="sidebar-dropdown list-unstyled collapse <?= $option['expanded'] ? 'show' : '' ?>"
                    data-bs-parent="#sidebar">

                    <?php foreach ($option['items'] as $item) : ?>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ isset($item['route']) ? route($item['route']) : '' }}">
                            <?= $item['name'] ?>
                        </a>
                    </li>

                    <?php endforeach; ?>

                </ul>
            </li>

            <?php endforeach; ?>

        </ul>
    </div>
</nav>
