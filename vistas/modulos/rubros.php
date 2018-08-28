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
                        <h4 class="m-b-10">Administración de Rubros</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="inicio">
                                <i class="ti-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#!">Configuración</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

<!--=====================================
            LISTADO RUBROS
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
                                            <h5 class="card-header-text p-t-15">Listado de rubros</h5>
                                        </div>
                                        <div class="col-lg-6 text-right">
                                            <button class="btn btn-mat waves-effect waves-light btn-primary" data-toggle="modal" data-target="#modalAgregarRubro"><i class="icofont icofont-plus m-r-5"></i>Nuevo rubro</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="md-card-block">
                                        <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
                                            <thead>
                                                <th style="text-align: center;">#</th>
                                                <th style="text-align: center;">Nombre</th>
                                                <th style="text-align: center;">Tipo</th>
                                                <th style="text-align: center;">Acciones</th>
                                            </thead>
                                            <tbody>
                                                <?php

                                                $item = null;
                                                $valor = null;

                                                $listar = ControladorConfiguracion::ctrMostrarRubros($item, $valor);

                                                foreach ($listar as $key => $value) {

                                                    echo '<tr>
                                                            <td style="text-align: center;">'.($key+1).'</td>
                                                            <td style="text-align: center;">'.$value["Nombre"].'</td>
                                                            <td style="text-align: center;">'.$value["Tipo"].'</td>
                                                            <td style="text-align: center;">
                                                                <div class="btn-group">
                                                                    <button class="btn btn-warning waves-effect waves-ligh" onclick="editarRubro('.$value["RubroID"].')" data-toggle="modal" data-target="#modalEditarRubro"><i class="icofont icofont-ui-edit"></i></button>
                                                                </div>
                                                                <div class="btn-group">
                                                                    <button class="btn btn-danger waves-effect waves-ligh"  onclick="eliminarRubro(\''.$value["RubroID"].'\', \''.$value["Nombre"].'\')"><i class="icofont icofont-ui-delete"></i></button>
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
            AGREGAR RUBRO
======================================-->

    <div class="modal fade" id="modalAgregarRubro" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h4 class="modal-title">Nuevo rubro</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="formAgregarRubro" method="post" class="form-material">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-worker"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="rubro" id="rubro">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Rubro</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-users-alt-2"></i>
                                </div>
                                <div class="form-group form-primary form-static-label p-t-5">
                                    <select class="form-control" name="tipoRubro" id="tipoRubro">
                                        <option value="">Seleccione Tipo</option>
                                        <option value="Insumo">Insumo</option>
                                        <option value="Producto">Producto</option>
                                        <option value="Proveedor">Proveedor</option>
                                    </select>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Tipo</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light ">Aceptar</button>
                </div>
                <?php
                    $crearUsuario = new ControladorConfiguracion();
                    $crearUsuario -> ctrRegistrarRubro();
                ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!--=====================================
            EDITAR RUBRO
======================================-->

    <div class="modal fade" id="modalEditarRubro" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h4 class="modal-title" id="nombreEdito"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="formEditarRubro" method="post" class="form-material">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-worker"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <input type="text" class="form-control" name="erubro" id="erubro">
                                    <input type="hidden" id="idRubro" name="idRubro" >
                                    <span class="form-bar"></span>
                                    <label class="float-label">Rubro</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-users-alt-2"></i>
                                </div>
                                <div class="form-group form-primary form-static-label p-t-5">
                                    <select class="form-control" name="etipoRubro">
                                        <option id="etipoRubro" value=""></option>
                                        <option value="Insumo">Insumo</option>
                                        <option value="Producto">Producto</option>
                                        <option value="Proveedor">Proveedor</option>
                                    </select>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Tipo</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light ">Aceptar</button>
                </div>
                <?php
                    $editarRubro = new ControladorConfiguracion();
                    $editarRubro -> ctrModificarRubro();
                ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript" src="vistas/js/rubros.js"></script>
