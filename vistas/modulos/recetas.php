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
                        <h4 class="m-b-10">Administración de recetas</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="inicio">
                                <i class="ti-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#!">Recetas</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

<!--=====================================
            LISTADO RECETAS
======================================--> 

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h5 class="card-header-text p-t-15">Listado de recetas</h5>
                                        </div>
                                        <div class="col-lg-6 text-right">
                                            <a href="crear-receta"><button class="btn btn-mat waves-effect waves-light btn-primary"><i class="icofont icofont-plus m-r-5"></i>Nueva receta</button></a>
                                        </div>
                                    </div>
                                </div>   
                                <div class="card-block">
                                    <div class="md-card-block">
                                        <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
			                                <thead>
			                                    <th style="text-align: center;">#</th>
			                                    <th style="text-align: center;">Receta</th>
			                                    <th style="text-align: center;">Acciones</th>
			                                </thead>
			                                <tbody>

			                                    <?php

			                                    $item = null;
			                                    $valor = null;

			                                    $listar = ControladorRecetas::ctrMostrarRecetas($item, $valor);

			                                    foreach ($listar as $key => $value) {

			                                       echo '<tr>
			                                                <td style="text-align: center;">'.($key + 1).'</td>
			                                                <td style="text-align: center;">'.$value["Nombre"].'</td>
			                                                <td style="text-align: center;">
			                                                    <div class="btn-group">
			                                                        <button class="btn btn-warning waves-effect waves-ligh btnEditarReceta" idReceta="'.$value["RecetaID"].'"><i class="icofont icofont-ui-edit"></i></button>
			                                                        </div>
			                                                    <div class="btn-group">
			                                                        <button class="btn btn-danger waves-effect waves-ligh btnEliminarReceta" idReceta="'.$value["RecetaID"].'" nombre="'.$value["Nombre"].'"><i class="icofont icofont-ui-delete"></i></button>
			                                                    </div>
                                                                <div class="btn-group">
                                                                    <button class="btn btn-success waves-effect waves-ligh btnDetalleReceta" data-toggle="modal" data-target="#modalDetalleDeReceta" idReceta="'.$value["RecetaID"].'" ><i class="icofont icofont-eye-alt"></i></button>
                                                                </div>
			                                                </td>
			                                            </tr>';
			                                    }
			                                    ?>
			                                </tbody>
			                            </table>
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

<!--=====================================
        DETALLE DE RECETA
======================================-->

    <div class="modal fade" id="modalDetalleDeReceta" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h5 class="modal-title tituloDetalleReceta"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row invoive-info">
                        <div class="col-md-6 col-sm-8 invoice-client-info">
                            <img class="img-receta" alt="proveedor" style="width: 100%;">
                        </div>
                        <div class="col-md-6 col-sm-8">
                            <h6 class="text-dark">Detalle de la receta :</h6>
                            <hr>
                            <h6 class="m-b-20 text-dark">Insumos</h6>
                            <div class="listadoProductosDetalle">
                                
                            </div>
                            <hr>
                            
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Salir</button>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript" src="vistas/js/recetas.js"></script>