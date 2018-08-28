<?php

    if ($_SESSION["rol"] != "Administrador") {

       echo '<script> window.location = "inicio"; </script>';

    }

?>
<div class="pcoded-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h4 class="m-b-10">Nueva receta</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="inicio">
                                <i class="ti-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#!">Productos</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


<!--=====================================
        NUEVA RECETA
======================================-->

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-lg-5 col-xs-12">
                                            <div class="card">
                                                <div class="card-header bg-success p-1"></div>
                                                    <div class="card-block">
                                                    <form class="form-material" role="form" id="formNuevaReceta" method="post">
                                                        <div class="row">
                                                            <!--PRODUCTO-->
                                                            <div class="col col-md-12">
                                                                <div class="material-group">
                                                                    <div class="material-addone">
                                                                        <i class="icofont icofont-shopping-cart"></i>
                                                                    </div>
                                                                    <div class="form-group form-default form-static-label">
                                                                        <select class="form-control" name="productoReceta" id="productoReceta">
                                                                            <option value="">Seleccione el producto</option>
                                                                                <?php
                                                                                    $productosReceta = new ControladorProductos();
                                                                                    $productosReceta -> ctrListarProductosReceta();
                                                                                ?>
                                                                        </select>
                                                                        <span class="form-bar"></span>
                                                                        <label class="float-label text-dark">Producto</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <!--AGREGAR INSUMO-->
                                                        <h6>Listado de insumos</h6>
                                                        <div class="nuevoInsumo p-t-20">

                                                        </div>
                                                        <input type="hidden" name="listadoInsumos" id="listadoInsumos">
                                                        <!--BTN AGREGAR INSUMO-->
                                                        <button type="button" class="btn btn-mini btn-default d-lg-none btnAgregarInsumo">Agregar insumo</button>

                                                        <div class="card-footer">
                                                            <div class="row">
                                                                <div class="col-lg-12 text-right">
                                                                    <a href="recetas"><button type="button" class="btn btn-primary">Cancelar</button></a>
                                                                    <button type="submit" class="btn btn-primary">Comfirmar</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <?php
                                                        $crearReceta = new ControladorRecetas();
                                                        $crearReceta -> ctrRegistrarReceta();
                                                    ?>
                                                    </div>
                                            </div>
                                        </div>
                                        <!--TABLA DE INSUMOS-->
                                        <div class="col-lg-7 d-none d-sm-none d-lg-block">
                                            <div class="card">
                                                <div class="card-header bg-danger p-1">
                                                </div>
                                                <div class="card-block">

                                                    <div class="table-responsive dt-responsive ">
                                                        <table class="display compact table-striped table-bordered tablaInsumosReceta" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 10px" class="text-center">#</th>
                                                                    <th class="text-center">Código</th>
                                                                    <th class="text-center">Nombre</th>
                                                                    <th class="text-center">Acciones</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!--FIN TABLA DE INSUMOS-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<script type="text/javascript" src="vistas/js/recetas.js"></script>
