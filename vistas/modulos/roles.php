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
                        <h4 class="m-b-10">Administración de Roles</h4>
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
            LISTADO ROLES
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
                                            <h5 class="card-header-text p-t-15">Listado de roles</h5>
                                        </div>
                                        <div class="col-lg-6 text-right">
                                            <button class="btn btn-mat waves-effect waves-light btn-primary" data-toggle="modal" data-target="#modalAgregarRol"><i class="icofont icofont-plus m-r-5"></i>Nuevo rol</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="md-card-block">
                                        <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
                                            <thead>
                                                <th style="text-align: center;">#</th>
                                                <th style="text-align: center;">Nombre</th>
                                                <th style="text-align: center;">Acciones</th>
                                            </thead>
                                            <tbody>
                                                <?php

                                                $item = null;
                                                $valor = null;
                                                $listar = ControladorConfiguracion::ctrMostrarRoles($item, $valor);

                                                foreach ($listar as $key => $value) {

                                                    echo '<tr>
                                                            <td style="text-align: center;">'.($key+1).'</td>
                                                            <td style="text-align: center;">'.$value["Nombre"].'</td>
                                                            <td style="text-align: center;">
                                                                <div class="btn-group">
                                                                    <button class="btn btn-warning waves-effect waves-ligh" onclick="editarRol('.$value["RolesID"].')" data-toggle="modal" data-target="#modalEditarRol"><i class="icofont icofont-ui-edit"></i></button>
                                                                </div>
                                                                <div class="btn-group">
                                                                    <button class="btn btn-danger waves-effect waves-ligh"  onclick="eliminarRol(\''.$value["RolesID"].'\', \''.$value["Nombre"].'\')"><i class="icofont icofont-ui-delete"></i></button>
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
            AGREGAR ROL
======================================-->

    <div class="modal fade" id="modalAgregarRol" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h4 class="modal-title">Nuevo rol</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="formAgregarRol" method="post" class="form-material">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-worker"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="rol" id="rol" minlength="3" maxlength="20">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Rol</label>
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
                    $crearRol = new ControladorConfiguracion();
                    $crearRol -> ctrRegistrarRol();
                ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!--=====================================
            EDITAR ROL
======================================-->

    <div class="modal fade" id="modalEditarRol" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h4 class="modal-title" id="editoNombre"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="formEditarRol" method="post" class="form-material">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-worker"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <input type="text" class="form-control" name="erol" id="erol" minlength="3" maxlength="20">
                                    <input type="hidden" id="idRol" name="idRol" >
                                    <span class="form-bar"></span>
                                    <label class="float-label">Rol</label>
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
                    $editarRol = new ControladorConfiguracion();
                    $editarRol -> ctrModificarRol();
                ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript" src="vistas/js/roles.js"></script>
