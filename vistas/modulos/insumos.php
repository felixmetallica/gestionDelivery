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
                        <h4 class="m-b-10">Administración de insumos</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="inicio">
                                <i class="ti-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#!">Insumos</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

<!--=====================================
            LISTADO INSUMOS
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
                                            <h5 class="card-header-text p-t-15">Listado de insumos</h5>
                                        </div>
                                        <div class="col-lg-6 text-right">
                                            <a href="extensiones/tcpdf/pdf/reporte-insumos.php" target="_blank"><img class="img-40" src="vistas/img/plantilla/pdf.png"></a>
                                            <a href="vistas/modulos/reportes.php?reporte=reporteInsumos"><img class="img-40" src="vistas/img/plantilla/xls.png"></a>
                                            <button class="btn btn-mat waves-effect waves-light btn-primary" data-toggle="modal" data-target="#modalAgregarInsumo"><i class="icofont icofont-plus m-r-5"></i>Nuevo insumo</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="md-card-block">
                                        <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
                                            <thead>
                                                <th style="text-align: center;">#</th>
                                                <th style="text-align: center;">Cod</th>
                                                <th style="text-align: center;">Rubro</th>
                                                <th style="text-align: center;">Nombre</th>
                                                <th style="text-align: center;">Medida</th>
                                                <th style="text-align: center;">Stock</th>
                                                <th style="text-align: center;">Stock mínimo</th>
                                                <th style="text-align: center;">Precio de compra</th>
                                                <th style="text-align: center;">Acciones</th>
                                            </thead>
                                            <tbody>
                                                <?php

                                                    $item = null;
                                                    $valor = null;
                                                    $orden = "ProductoID";

                                                    $listaInsumos = ControladorInsumos::ctrMostrarInsumos($item, $valor, $orden);

                                                    foreach ($listaInsumos as $key => $value) {

                                                        echo '<tr>
                                                                <td style="text-align: center;">'.($key+1).'</td>
                                                                <td style="text-align: center;">'.$value["Codigo"].'</td>
                                                                <td style="text-align: center;">'.$value["Rubro"].'</td>
                                                                <td style="text-align: center;">'.$value["Nombre"].'</td>
                                                                <td style="text-align: center;">'.$value["Medida"].'</td>
                                                                <td style="text-align: center;">'.$value["Stock"].'</td>
                                                                <td style="text-align: center;">'.$value["StockMinimo"].'</td>
                                                                <td style="text-align: center;">$'.$value["PrecioCompra"].'</td>
                                                                <td style="text-align: center;">
                                                                <div class="btn-group">
                                                                    <button class="btn btn-warning waves-effect waves-ligh btnEditarInsumo" data-toggle="modal" data-target="#modalEditarInsumo" idInsumo="'.$value["InsumosID"].'" codActual="'.$value["Codigo"].'"><i class="icofont icofont-ui-edit"></i></button>
                                                                </div>
                                                                <div class="btn-group">
                                                                    <button class="btn btn-danger waves-effect waves-ligh btnEliminarInsumo" idInsumo="'.$value["InsumosID"].'" Nombre="'.$value["Nombre"].'" Codigo="'.$value["Codigo"].'"><i class="icofont icofont-ui-delete"></i></button>
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
            AGREGAR INSUMO
======================================-->

    <div class="modal fade" id="modalAgregarInsumo" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h4 class="modal-title">Nuevo insumo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="formAgregarInsumo" method="post" class="form-material">
                    <div class="row">
                       <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-shopping-cart"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <select class="form-control" name="rubroInsumo" id="rubroInsumo">
                                        <option value="">Seleccione el rubro</option>
                                            <?php
                                                $traerRubro = new ControladorInsumos();
                                                $traerRubro -> ctrListarRubros();
                                            ?>
                                    </select>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Rubro</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-barcode"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <input type="text" class="form-control" name="codigoInsumo" id="codigoInsumo" readonly>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Código</label>
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
                                    <input type="text" class="form-control" name="nombreInsumo" id="nombreInsumo" minlength="3" maxlength="20">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Nombre</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-soup-bowl"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <select class="form-control" name="medidaInsumo" id="medidaInsumo">
                                        <option value="">Seleccione la medida</option>
                                        <option value="Kilogramo">Kilogramo</option>
                                        <option value="Gramos">Gramos</option>
                                        <option value="Unidades">Unidades</option>
                                        <option value="Litros">Litros</option>
                                        <option value="Latas">Latas</option>
                                        <option value="Cajas">Cajas</option>
                                    </select>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Medida</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-shopping-cart"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="sMinimoInsumo" id="sMinimoInsumo" minlength="1" maxlength="4">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Stock mínimo</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-money"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="pCompra" id="pCompra" minlength="2" maxlength="4">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Precio de compra</label>
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
                    $registrarInsumo = new ControladorInsumos();
                    $registrarInsumo -> ctrRegistrarInsumo();
                ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!--=====================================
            EDITAR INSUMO
======================================-->

    <div class="modal fade" id="modalEditarInsumo" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h4 id="nombreIsumoModal" class="modal-title">Editar insumo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="formEditarInsumo" method="post" class="form-material">
                        <input type="hidden" id="idInsumo" name="idInsumo">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-shopping-cart"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <input type="text" class="form-control" name="erubroInsumo" id="erubroInsumo" readonly>
                                    <input type="hidden" name="idRubro" id="idRubro">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Rubro</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-barcode"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <input type="text" class="form-control" name="ecodigoInsumo" id="ecodigoInsumo" readonly>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Código</label>
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
                                    <input type="text" class="form-control" name="enombreInsumo" id="enombreInsumo" minlength="3" maxlength="20">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Nombre</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-soup-bowl"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <select class="form-control" name="emedidaInsumo">
                                        <option id="emedidaInsumo" value=""></option>
                                        <option value="Kilogramo">Kilogramo</option>
                                        <option value="Gramos">Gramos</option>
                                        <option value="Unidades">Unidades</option>
                                        <option value="Litros">Litros</option>
                                        <option value="Latas">Latas</option>
                                        <option value="Cajas">Cajas</option>
                                    </select>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Medida</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-shopping-cart"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <input type="text" class="form-control" name="esMinimoInsumo" id="esMinimoInsumo" minlength="1" maxlength="4">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Stock mínimo</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-money"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <input type="text" class="form-control" name="epCompra" id="epCompra" minlength="2" maxlength="4">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Precio de compra</label>
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
                    $editarInsumo = new ControladorInsumos();
                    $editarInsumo -> ctrEditarInsumo();
                ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript" src="vistas/js/insumos.js"></script>
