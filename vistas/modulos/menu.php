<nav class="pcoded-navbar">
    <div class="pcoded-inner-navbar">
        <ul class="pcoded-item">

            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="icon-rocket"></i></span>
                    <span class="pcoded-mtext">Inicio</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="">
                        <a href="inicio" class="waves-effect waves-dark">
                            <span class="pcoded-mtext" data-i18n="nav.navigate.main">Dashboard</span>
                        </a>
                    </li>
                </ul>
            </li>

            <?php

                if ($_SESSION["rol"] == "Administrador") {

                    echo '<li class="pcoded-hasmenu">
                                <a href="javascript:void(0)" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="icon-people"></i></span>
                                    <span class="pcoded-mtext">Usuarios</span>
                                </a>
                                <ul class="pcoded-submenu">
                                    <li class="">
                                        <a href="usuarios" class="waves-effect waves-dark">
                                            <span class="pcoded-mtext" data-i18n="nav.navigate.main">Administración</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="pcoded-hasmenu">
                                <a href="javascript:void(0)" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="icon-people"></i></span>
                                    <span class="pcoded-mtext">Clientes</span>
                                </a>
                                <ul class="pcoded-submenu">
                                    <li class="">
                                        <a href="clientes" class="waves-effect waves-dark">
                                            <span class="pcoded-mtext" data-i18n="nav.navigate.main">Administración</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="pcoded-hasmenu">
                                <a href="javascript:void(0)" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="icon-people"></i></span>
                                    <span class="pcoded-mtext">Proveedores</span>
                                </a>
                                <ul class="pcoded-submenu">
                                    <li class="">
                                        <a href="proveedores" class="waves-effect waves-dark">
                                            <span class="pcoded-mtext" data-i18n="nav.navigate.main">Administración</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="pcoded-hasmenu">
                                <a href="javascript:void(0)" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="icon-people"></i></span>
                                    <span class="pcoded-mtext">Empleados</span>
                                </a>
                                <ul class="pcoded-submenu">
                                    <li class="">
                                        <a href="empleados" class="waves-effect waves-dark">
                                            <span class="pcoded-mtext" data-i18n="nav.navigate.main">Administración</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="grupoFamiliar" class="waves-effect waves-dark">
                                            <span class="pcoded-mtext" data-i18n="nav.navigate.main">Grupo familiar</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="pcoded-hasmenu">
                                <a href="javascript:void(0)" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="icon-wrench"></i></span>
                                    <span class="pcoded-mtext">Configuración</span>
                                </a>
                                <ul class="pcoded-submenu">
                                    <li class="">
                                        <a href="rubros" class="waves-effect waves-dark">
                                            <span class="pcoded-mtext" data-i18n="nav.navigate.main">Rubros</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="roles" class="waves-effect waves-dark">
                                            <span class="pcoded-mtext" data-i18n="nav.navigate.main">Roles</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="puestos" class="waves-effect waves-dark">
                                            <span class="pcoded-mtext" data-i18n="nav.navigate.main">Puestos</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="categorias" class="waves-effect waves-dark">
                                            <span class="pcoded-mtext" data-i18n="nav.navigate.main">Categorias</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="iva" class="waves-effect waves-dark">
                                            <span class="pcoded-mtext" data-i18n="nav.navigate.main">Iva</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="puntoVenta" class="waves-effect waves-dark">
                                            <span class="pcoded-mtext" data-i18n="nav.navigate.main">Punto de venta</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="mediosDePago" class="waves-effect waves-dark">
                                            <span class="pcoded-mtext" data-i18n="nav.navigate.main">Medios de pago</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>';
                }

            ?>

            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="icon-present"></i></span>
                    <span class="pcoded-mtext">Ventas</span>
                </a>
                <ul class="pcoded-submenu">

                    <li class="">
                        <a href="ventas" class="waves-effect waves-dark">
                            <span class="pcoded-mtext" data-i18n="nav.navigate.main">Administración</span>
                        </a>
                    </li>
                    <li class="">
                        <a href="crear-venta" class="waves-effect waves-dark">
                            <span class="pcoded-mtext" data-i18n="nav.navigate.main">Nueva venta</span>
                        </a>
                    </li>

                    <?php

                        if ($_SESSION["rol"] == "Administrador") {

                            echo' <li class="">
                                    <a href="reportes-ventas" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext" data-i18n="nav.navigate.main">Reporte de ventas</span>
                                    </a>
                                </li>';
                        }
                    ?>

                </ul>
            </li>
            <?php

                if ($_SESSION["rol"] == "Administrador") {

                    echo '<li class="pcoded-hasmenu">
                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="icon-basket"></i></span>
                                <span class="pcoded-mtext">Productos</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li class="">
                                    <a href="productos" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext" data-i18n="nav.navigate.main">Administración</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="insumos" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext" data-i18n="nav.navigate.main">Insumos</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="recetas" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext" data-i18n="nav.navigate.main">Recetas</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="pcoded-hasmenu">
                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="icon-present"></i></span>
                                <span class="pcoded-mtext">Compras</span>
                            </a>
                            <ul class="pcoded-submenu">

                                <li class="">
                                    <a href="compras" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext" data-i18n="nav.navigate.main">Administración</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="crear-compra" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext" data-i18n="nav.navigate.main">Nueva compra</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="reportes-compras" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext" data-i18n="nav.navigate.main">Reporte de compras</span>
                                    </a>
                                </li>
                            </ul>
                        </li>';
                }

            ?>
                        <li class="pcoded-hasmenu">
                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="icofont icofont-stock-search"></i></span>
                                <span class="pcoded-mtext">Almacen</span>
                            </a>
                            <ul class="pcoded-submenu">

                                <?php

                                    if ($_SESSION["rol"] == "Administrador") {

                                    echo '<li class="">
                                        <a href="almacen" class="waves-effect waves-dark">
                                            <span class="pcoded-mtext" data-i18n="nav.navigate.main">Administración</span>
                                        </a>
                                    </li>';

                                    }
                                ?>

                                <li class="">
                                    <a href="stock" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext" data-i18n="nav.navigate.main">Stock</span>
                                    </a>
                                </li>

                            </ul>
                        </li>

                    <?php

                        if ($_SESSION["rol"] == "Administrador") {

                        echo '<li class="pcoded-hasmenu">
                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="ti-money"></i></span>
                                <span class="pcoded-mtext">Payment</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li class="">
                                    <a href="conceptos" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext" data-i18n="nav.navigate.main">Conceptos</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="liquidaciones" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext" data-i18n="nav.navigate.main">Liquidaciones</span>
                                    </a>
                                </li>
                            </ul>
                        </li>';
                    }

                    ?>

        </ul>
    </div>
</nav>
