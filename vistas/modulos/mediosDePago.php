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
                        <h4 class="m-b-10">Administración de medios de pago</h4>
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
            LISTADO MDPS
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
                                            <h5 class="card-header-text p-t-15">Listado de medios de pago</h5>
                                        </div>
                                        <div class="col-lg-6 text-right">
                                            <button class="btn btn-mat waves-effect waves-light btn-primary" data-toggle="modal" data-target="#modalCrearMDP"><i class="icofont icofont-plus m-r-5"></i>Nuevo Mdp</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="md-card-block">
                                        <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
                                            <thead>
                                                <th style="text-align: center;">#</th>
                                                <th style="text-align: center;">Nombre</th>
                                                <th style="text-align: center;">Activo</th>
                                                <th style="text-align: center;">Acciones</th>
                                            </thead>
                                            <tbody>
                                                <?php

                                                    $item = null;
                                                    $valor = null;
                                                    $listar = ControladorConfiguracion::ctrMostrarMdPs($item, $valor);

                                                    foreach ($listar as $key => $value) {


                                                        echo '<tr>
                                                                <td style="text-align: center;">'.($key+1).'</td>
                                                                <td style="text-align: center;">'.$value["Nombre"].'</td>';

                                                        if($value["Activo"] =="S"){

                                                                      echo '<td style="text-align: center;"><button  class="btn btn-success waves-effect waves-ligh" onclick="activarDesactivarMdp(\''.$value["MedioPagoID"].'\' , \''.$value["Nombre"].'\', \''.$value["Activo"].'\')">Si</button></td>';

                                                                      } else {

                                                                      echo '<td style="text-align: center;"><button  class="btn btn-danger waves-effect waves-ligh" onclick="activarDesactivarMdp(\''.$value["MedioPagoID"].'\' , \''.$value["Nombre"].'\', \''.$value["Activo"].'\')">No</button></td>';
                                                                  }

                                                        echo '<td style="text-align: center;">
                                                                    <div class="btn-group">
                                                                        <button class="btn btn-warning waves-effect waves-ligh" onclick="editarMdp('.$value["MedioPagoID"].')" data-toggle="modal" data-target="#modalEditarMDP"><i class="icofont icofont-ui-edit"></i></button>
                                                                    </div>
                                                                    <div class="btn-group">
                                                                        <button class="btn btn-danger waves-effect waves-ligh"  onclick="eliminarMdp(\''.$value["MedioPagoID"].'\', \''.$value["Nombre"].'\')"><i class="icofont icofont-ui-delete"></i></button>
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
            AGREGAR MDP
======================================-->

    <div class="modal fade" id="modalCrearMDP" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h4 class="modal-title">Nuevo medio de pago</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="formAgregarMdP" method="post" class="form-material">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-money"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="mdpNombre" id="mdpNombre">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Nombre</label>
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
                    $crearPDV = new ControladorConfiguracion();
                    $crearPDV -> ctrRegistrarMdP();
                ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!--=====================================
            EDITAR MDP
======================================-->

    <div class="modal fade" id="modalEditarMDP" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h4 class="modal-title" id="nombreMedio"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="formEditarMdP" method="post" class="form-material">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-money"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <input type="text" class="form-control" name="emdpNombre" id="emdpNombre">
                                    <input type="hidden" id="idMedio" name="idMedio">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Nombre</label>
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
                    $modificarPDV = new ControladorConfiguracion();
                    $modificarPDV -> ctrModificarMdp();
                ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript" src="vistas/js/mediosDePago.js"></script>
