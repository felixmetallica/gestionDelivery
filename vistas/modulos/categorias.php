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
                        <h4 class="m-b-10">Administración de Categorías</h4>
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
            LISTADO CATEGORIAS
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
                                            <h5 class="card-header-text p-t-15">Listado de categorías</h5>
                                        </div>
                                        <div class="col-lg-6 text-right">
                                            <button class="btn btn-mat waves-effect waves-light btn-primary" data-toggle="modal" data-target="#modalAgregarCategoria"><i class="icofont icofont-plus m-r-5"></i>Nueva categoría</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="md-card-block">
                                        <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
                                            <thead>
                                                <th style="text-align: center;">#</th>
                                                <th style="text-align: center;">Puesto</th>
                                                <th style="text-align: center;">Categoría</th>
                                                <th style="text-align: center;">Sueldo básico</th>
                                                <th style="text-align: center;">Acciones</th>
                                            </thead>
                                            <tbody>
                                                <?php

                                                $item = null;
                                                $valor = null;

                                                $listar = ControladorConfiguracion::ctrMostrarCategorias($item, $valor);

                                                foreach ($listar as $key => $value) {

                                                    echo '<tr>
                                                            <td style="text-align: center;">'.($key+1).'</td>
                                                            <td style="text-align: center;">'.$value["NombrePuesto"].'</td>
                                                            <td style="text-align: center;">'.$value["NombreCategoria"].'</td>
                                                            <td style="text-align: center;">$ '.$value["SueldoBasico"].'</td>
                                                            <td style="text-align: center;">
                                                                <div class="btn-group">
                                                                    <button class="btn btn-warning waves-effect waves-ligh" onclick="editarCategoria('.$value["CategoriasID"].')" data-toggle="modal" data-target="#modalEditarCategoria"><i class="icofont icofont-ui-edit"></i></button>
                                                                </div>
                                                                <div class="btn-group">
                                                                    <button class="btn btn-danger waves-effect waves-ligh"  onclick="eliminarCategoria(\''.$value["CategoriasID"].'\', \''.$value["NombreCategoria"].'\')"><i class="icofont icofont-ui-delete"></i></button>
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
            AGREGAR CATEGORÍA
======================================-->

    <div class="modal fade" id="modalAgregarCategoria" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h4 class="modal-title">Nueva categoría</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="formAgregarCategoria" method="post" class="form-material">
                    <div class="row">
                       <div class="col-sm-12">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-worker"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <select class="form-control" name="puesto" id="puesto">
                                        <option value="">Selecionar puesto</option>
                                            <?php

                                                $item = null;
                                                $valor = null;

                                                $puestos = ControladorConfiguracion::ctrMostrarPuestos($item, $valor);

                                                foreach ($puestos as $key => $value) {

                                                    echo '<option value="'.$value["PuestoID"].'">'.$value["Nombre"].'</option>';
                                                }
                                            ?>
                                    </select>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Puesto</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-label"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="categoria" id="categoria" minlength="3" maxlength="20">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Nombre</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-money"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="sueldoBasico" id="sueldoBasico" minlength="3" maxlength="20">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Sueldo básico</label>
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
                    $crearCategoria = new ControladorConfiguracion();
                    $crearCategoria -> ctrRegistrarCategoria();
                ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!--=====================================
            EDITAR CATEGORÍA
======================================-->

    <div class="modal fade" id="modalEditarCategoria" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h4 class="modal-title" id="nombreCategoria"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="formEditarCategoria" method="post" class="form-material">
                    <input type="hidden" id="idCategoria" name="idCategoria" >
                    <div class="row">
                       <div class="col-sm-12">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-worker"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <select class="form-control" name="epuesto">
                                        <option id="epuesto" value="">Selecionar puesto</option>
                                            <?php

                                                $item = null;
                                                $valor = null;

                                                $puestos = ControladorConfiguracion::ctrMostrarPuestos($item, $valor);

                                                foreach ($puestos as $key => $value) {

                                                    echo '<option value="'.$value["PuestoID"].'">'.$value["Nombre"].'</option>';
                                                }
                                            ?>
                                    </select>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Puesto</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-label"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <input type="text" class="form-control" name="ecategoria" id="ecategoria" minlength="3" maxlength="20">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Nombre</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-money"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <input type="text" class="form-control" name="esueldoBasico" id="esueldoBasico" minlength="3" maxlength="20">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Sueldo básico</label>
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
                    $editarCategoria = new ControladorConfiguracion();
                    $editarCategoria -> ctrModificarCategoria();
                ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript" src="vistas/js/categorias.js"></script>
