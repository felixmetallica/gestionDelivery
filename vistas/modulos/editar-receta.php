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
                        <h4 class="m-b-10">Editar receta</h4>
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
        EDITAR RECETA
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
                                        <?php

                                            $item = "RecetaID";
                                            $valor = $_GET["idReceta"];

                                            $receta = ControladorRecetas::ctrMostrarRecetas($item, $valor);


                                        ?>
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
                                                                        <input type="text" class="form-control" name="productoReceta" id="productoReceta" value="<?php echo $receta["Nombre"] ?>" readonly required>
                                                                        <input type="hidden" name="idProductoReceta" id="idProductoReceta" value="<?php echo $receta["ProductoID"] ?>">
                                                                        <input type="hidden" name="idReceta" id="idReceta" value="<?php echo $valor; ?>">
                                                                        <span class="form-bar"></span>
                                                                        <label class="float-label text-dark">Producto</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <!--AGREGAR INSUMO-->
                                                        <h6>Listado de insumos</h6>
                                                        <div class="nuevoInsumo p-t-20">
                                                            <?php

                                                               $listarInsumos =ControladorRecetas::ctrListadoInsumos($valor);

                                                               $losInsumos = array();

                                                               foreach ($listarInsumos as $key => $value) {

                                                                    $item = "InsumosID";

                                                                    $valor = $value["InsumosID"];

                                                                    $respuesta = ControladorInsumos::ctrMostrarInsumos($item, $valor);

                                                                    $dtInsumos = array("idInsumo" => $value["InsumosID"],
                                                                                       "nombreInsumo" => $value["Nombre"],
                                                                                       "cantidadInsumo" => $value["Cantidad"]);

                                                                    array_push($losInsumos, $dtInsumos);


                                                                    echo '<div class="row">
                                                                            <div class="col-sm-8">
                                                                                <div class="material-group">
                                                                                    <div class="material-addone">
                                                                                        <button type="button" class="btn btn-danger btn-mini waves-effect waves-light p-1 quitarInsumo" idInsumo="'.$value["InsumosID"].'"><i class="icofont icofont-close m-0"></i></button>
                                                                                    </div>
                                                                                    <div class="form-group form-default form-static-label">
                                                                                        <input type="text" class="form-control md-static nuevaDescripcionInsumo" name="descInsumoCompra" id="descInsumoCompra" idInsumo="'.$value["InsumosID"].'" value="'.$value["Nombre"].'" nombreInsumo="'.$value["Nombre"].'" readonly required>
                                                                                        <span class="form-bar"></span>
                                                                                        <label class="float-label text-dark">Descripción</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-2 ingresoCantidad">
                                                                                <div class="material-group">
                                                                                    <div class="form-group form-default form-static-label">
                                                                                        <input type="text" class="form-control form-control-right cantidadInsumo" name="cantidadInsumo" value="'.$value["Cantidad"].'">
                                                                                        <span class="form-bar"></span>
                                                                                        <label class="float-label text-dark">Cantidad</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-2 muestroMedidaInsumo">
                                                                                <label class="text-dark medidaInsumo p-t-20">'.$value["Medida"].'</label>
                                                                            </div>
                                                                        </div>';



                                                               }

                                                               $todoInsumo = json_encode($losInsumos, JSON_UNESCAPED_UNICODE);

                                                            ?>

                                                        </div>
                                                        <input type="hidden" name="listadoInsumos" id="listadoInsumos" value='<?php echo $todoInsumo; ?>'>
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
                                                       $crearReceta -> ctrEditarReceta();
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
