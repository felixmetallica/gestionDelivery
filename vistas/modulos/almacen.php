<div class="pcoded-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h4 class="m-b-10">Administración de Almacen</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="inicio">
                                <i class="ti-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#!">Almacen</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<!--=====================================
        LISTADO ALMACEN
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
                                        <div class="col-lg-6 text-left">
                                            <button type="button" class="btn waves-effect waves-light btn-primary" id="daterange-btn4">
                                                <span><i class="fa fa-calendar"></i> Rango de fecha</span>
                                            </button>
                                        </div>
                                        <div class="col-lg-6 text-right">

                                            <?php

                                                if (isset($_GET["fechaInicial"])) {

                                                    echo '<a href="extensiones/tcpdf/pdf/reporte-almacen.php?reporte=reporteA&fechaInicial='.$_GET["fechaInicial"].'&fechaFinal='.$_GET["fechaFinal"].'" target="_blank">';

                                                }else{

                                                   echo '<a href="extensiones/tcpdf/pdf/reporte-almacen.php?reporte=reporteA" target="_blank">';

                                                }


                                            ?>

                                            <img class="img-40" src="vistas/img/plantilla/pdf.png"></a>

                                            <?php

                                                if (isset($_GET["fechaInicial"])) {

                                                    echo '<a href="vistas/modulos/reportes.php?reporte=reporteA&fechaInicial='.$_GET["fechaInicial"].'&fechaFinal='.$_GET["fechaFinal"].'">';

                                                }else{

                                                   echo '<a href="vistas/modulos/reportes.php?reporte=reporteA">';

                                                }


                                            ?>

                                            <img class="img-40" src="vistas/img/plantilla/xls.png"></a>

                                        </div>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="md-card-block">
                                        <table class="table table-bordered table-striped dt-responsive nowrap tablas tablaMovimientos" width="100%">
                                            <thead>
                                                <th style="text-align: center; width: 10px">#</th>
                                                <th style="text-align: center;">Fecha</th>
                                                <th style="text-align: center;">Tipo</th>
                                                <th style="text-align: center;">Nombre</th>
                                                <th style="text-align: center;">Descripción</th>
                                                <th style="text-align: center;">Cantidad</th>
                                                <th style="text-align: center;">Responsable</th>
                                                <th style="text-align: center;">Acciones</th>
                                            </thead>
                                            <tbody>
                                                 <?php

                                                    if (isset($_GET["fechaInicial"])) {

                                                        $fechaInicial = $_GET["fechaInicial"];
                                                        $fechaFinal = $_GET["fechaFinal"];

                                                    } else {

                                                        $fechaInicial = null;
                                                        $fechaFinal = null;

                                                    }

                                                    $listar = ControladorAlmacen::ctrRangoFechaAlmacen($fechaInicial, $fechaFinal);

                                                    foreach ($listar as $key => $value) {

                                                        if ($value["InsumosID"] != null) {

                                                            $idInsProd = $value["InsumosID"];
                                                            $tipoInsProd = "Insumo";

                                                        } else {

                                                            $idInsProd = $value["ProductoID"];
                                                            $tipoInsProd = "Producto";

                                                        }

                                                        echo '<tr>
                                                                <td class="text-center">'.($key + 1).'</td>
                                                                <td class="text-center">'.$value["Fecha"].'</td>';

                                                                if ($value["Tipo"] =="I") {

                                                                    echo '<td style="text-align: center;"><button class="btn btn-success btn-sm waves-effect waves-ligh">Ingreso</button></td>';

                                                                } else {

                                                                    echo '<td style="text-align: center;"><button class="btn btn-danger btn-sm waves-effect waves-ligh">Egreso</button></td>';

                                                                }
                                                                echo '<td class="text-left">'.$value["Nombre"].'</td>
                                                                <td class="text-left">'.$value["Descripcion"].'</td>
                                                                <td class="text-right">'.$value["Cantidad"].'</td>
                                                                <td class="text-center">'.$value["NombrePersona"].' '.$value["ApellidoPersona"].'</td>
                                                                <td style="text-align: center;">
                                                                            <div class="btn-group">
                                                                            <button class="btn btn-warning waves-effect waves-ligh btnEditarMovimiento" idMovimiento="'.$value["AlmacenID"].'" data-toggle="modal" data-target="#modalEditarMovimiento"><i class="icofont icofont-ui-edit"></i></button></div>
                                                                            <div class="btn-group">
                                                                            <button class="btn btn-danger waves-effect waves-ligh btnEliminarMovimiento" tipoInsProd="'.$tipoInsProd.'" idInsProd="'.$idInsProd.'" tipoMov="'.$value["Tipo"].'" cantidad="'.$value["Cantidad"].'" idMovimiento="'.$value["AlmacenID"].'"><i class="icofont icofont-ui-delete"></i></button>
                                                                            </div>
                                                                </td>
                                                              </tr>';

                                                    }

                                                ?>
                                            </tbody>
                                        </table>
                                        <div class="text-right p-t-15">
                                            <button class="btn waves-effect waves-light btn-primary" data-toggle="modal" data-target="#modalAgregarMovimiento"><i class="icofont icofont-plus m-r-5"></i>Nuevo movimiento</button>
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


</div>

<!--=====================================
            NUEVO MOVIMIENTO
======================================-->

    <div class="modal fade" id="modalAgregarMovimiento" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h4 class="modal-title">Nuevo movimiento</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="formMovimiento" method="post" class="form-material">
                    <input type="hidden" name="idUsuarioMovimiento" value="<?php echo $_SESSION["idUser"]; ?>">
                    <div class="row p-t-10">
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-shopping-cart"></i>
                                </div>
                                <div class="form-group form-primary form-static-label p-t-5">
                                    <select class="form-control insumoProdMovimiento" name="insumoProdMovimiento" id="insumoProdMovimiento">
                                        <option value="">Seleccionar producto/insumo</option>

                                        <?php

                                            $item = null;
                                            $valor = null;

                                            $listar = ControladorAlmacen::ctrMostrarProductosInsumos($item, $valor);

                                            foreach ($listar as $key => $value) {

                                                echo '<option value="'.$value["Codigo"].'">'.$value["Nombre"].'</option>';
                                            }
                                        ?>
                                    </select>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Producto / Insumo</label>
                                    <input type="hidden" name="idProdInsMovimiento" id="idProdInsMovimiento">
                                    <input type="hidden" name="nombreProdInsMovimiento" id="nombreProdInsMovimiento">
                                    <input type="hidden" name="tipoProdInsMovimiento" id="tipoProdInsMovimiento">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary  ">
                                <div class="material-addone">
                                    <i class="icofont icofont-calendar"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <input type="text" class="form-control date" name="fechaMovimiento" id="fechaMovimiento" data-mask="99/99/9999" required="" />
                                    <span class="form-bar"></span>
                                    <label class="float-label">Fecha</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary ">
                                <div class="material-addone">
                                    <i class="icofont icofont-sign-in"></i>
                                </div>
                                <div class="form-group form-primary form-static-label p-t-5">
                                    <select class="form-control" name="tipoMovimiento" id="tipoMovimiento">
                                        <option value="">Seleccionar tipo</option>
                                        <option value="I">Ingreso</option>
                                        <option value="E">Egreso</option>
                                    </select>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Tipo</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary ">
                                <div class="material-addone">
                                    <i class="icofont icofont-abacus"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="cantidadMovimiento" id="cantidadMovimiento" required="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Ingresar cantidad</label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="material-group material-group-primary ">
                                <div class="material-addone">
                                    <i class="icofont icofont-comment"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <textarea id="descripcionMovimiento" name="descripcionMovimiento" class="form-control"></textarea>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Descripción</label>
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
                    $registrarMovimiento = new ControladorAlmacen();
                    $registrarMovimiento -> ctrRegistroMovimiento();
                ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!--=====================================
            EDITAR MOVIMIENTO
======================================-->

    <div class="modal fade" id="modalEditarMovimiento" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h4 class="modal-title">Editar movimiento</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="formEditarMovimiento" method="post" class="form-material">
                    <input type="hidden" name="idMovimiento" id="idMovimiento">
                    <input type="hidden" name="eidUsuarioMovimiento" value="<?php echo $_SESSION["idUser"]; ?>">
                    <input type="hidden" name="valoresActuales" id="valoresActuales">
                    <div class="row p-t-10">
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-shopping-cart"></i>
                                </div>
                                <div class="form-group form-primary form-static-label p-t-5">
                                    <select class="form-control einsumoProdMovimiento" name="einsumoProdMovimiento" >
                                        <option id="einsumoProdMovimiento" value="">Seleccionar producto/insumo</option>

                                        <?php

                                            $item = null;
                                            $valor = null;

                                            $listar = ControladorAlmacen::ctrMostrarProductosInsumos($item, $valor);

                                            foreach ($listar as $key => $value) {

                                                echo '<option value="'.$value["Codigo"].'">'.$value["Nombre"].'</option>';
                                            }
                                        ?>
                                    </select>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Producto / Insumo</label>
                                    <input type="hidden" name="eidProdInsMovimiento" id="eidProdInsMovimiento">
                                    <input type="hidden" name="enombreProdInsMovimiento" id="enombreProdInsMovimiento">
                                    <input type="hidden" name="etipoProdInsMovimiento" id="etipoProdInsMovimiento">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary  ">
                                <div class="material-addone">
                                    <i class="icofont icofont-calendar"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <input type="text" class="form-control date" name="efechaMovimiento" id="efechaMovimiento" data-mask="99/99/9999" required="" />
                                    <span class="form-bar"></span>
                                    <label class="float-label">Fecha</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary ">
                                <div class="material-addone">
                                    <i class="icofont icofont-sign-in"></i>
                                </div>
                                <div class="form-group form-primary form-static-label p-t-5">
                                    <select class="form-control" name="etipoMovimiento">
                                        <option  id="etipoMovimiento" value="">Seleccionar tipo</option>
                                        <option value="I">Ingreso</option>
                                        <option value="E">Egreso</option>
                                    </select>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Tipo</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary ">
                                <div class="material-addone">
                                    <i class="icofont icofont-abacus"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <input type="text" class="form-control" name="ecantidadMovimiento" id="ecantidadMovimiento" required="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Ingresar cantidad</label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="material-group material-group-primary ">
                                <div class="material-addone">
                                    <i class="icofont icofont-comment"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <textarea id="edescripcionMovimiento" name="edescripcionMovimiento" class="form-control"></textarea>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Descripción</label>
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
                    $editarMovimiento = new ControladorAlmacen();
                    $editarMovimiento -> ctrEditarMovimiento();
                ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- bootstrap range picker -->
<script type="text/javascript" src="vistas/bower_components/bootstrap-daterangepicker/js/daterangepicker.js"></script>
<script type="text/javascript" src="vistas/bower_components/bootstrap-daterangepicker/js/moment.js"></script>
<script type="text/javascript" src="vistas/js/almacen.js"></script>
