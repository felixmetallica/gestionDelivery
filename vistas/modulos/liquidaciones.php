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
                        <h4 class="m-b-10">Administración de Liquidaciones</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="inicio">
                                <i class="ti-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#!">Payment</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

<!--=====================================
            LISTADO LIQUIDACIONES
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
                                            <h5 class="card-header-text p-t-15">Listado de liquidaciones</h5>
                                        </div>
                                        <div class="col-lg-6 text-right">
                                            <a href="liquidacion-grupal">
                                                <button class="btn waves-effect waves-light btn-primary btnCrearBoleta"><i class="icofont icofont-printer"></i>Liquidación grupal</button>
                                            </a>
                                            <a href="crear-boleta">
                                                <button class="btn waves-effect waves-light btn-primary btnCrearBoleta"><i class="icofont icofont-plus m-r-5"></i>confeccionar boleta</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="md-card-block">
                                        <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
                                            <thead>
                                                <th style="text-align: center;">#</th>
                                                <th style="text-align: center;">Tipo</th>
                                                <th style="text-align: center;">Periodo</th>
                                                <th style="text-align: center;">Estado</th>
                                                <th style="text-align: center;">Empleado</th>
                                                <th style="text-align: center;">Fecha de confección</th>
                                                <th style="text-align: center;">Fecha de liquidación</th>
                                                <th style="text-align: center;">Fecha de pago</th>
                                                <th style="text-align: center;">Total</th>
                                                <th style="text-align: center;">Acciones</th>
                                            </thead>
                                            <tbody>

                                                <?php

                                                    $item = null;
                                                    $valor = null;

                                                    $listar = ControladorPayment::ctrMostrarLiquidacion($item, $valor);

                                                    foreach ($listar as $key => $value) {

                                                        switch ($value["Estado"]) {
                                                            case 'C':
                                                                $estado = '<label class="label label-warning">Confeccionada</label>';
                                                                break;
                                                            case 'L':
                                                                $estado = '<label class="label label-success">Liquidada</label>';
                                                                break;


                                                        }

                                                        echo '<tr>
                                                                <td style="text-align: center;">'.($key+1).'</td>
                                                                <td style="text-align: center;">'.$value["Tipo"].'</td>
                                                                <td style="text-align: center;">'.$value["Mes"].' '.$value["Anio"].'</td>
                                                                <td style="text-align: center;">'.$estado.'</td>
                                                                <td style="text-align: center;">'.$value["Nombre"].' '.$value["Apellido"].'</td>
                                                                <td style="text-align: center;">'.$value["FechaConfeccion"].'</td>
                                                                <td style="text-align: center;">'.$value["FechaLiquidacion"].'</td>
                                                                <td style="text-align: center;">'.$value["FechaPago"].'</td>
                                                                <td style="text-align: center;">$'.$value["TotalNeto"].'</td>
                                                                <td style="text-align: center;">';

                                                                    if ($value["Estado"] == "C") {

                                                                        echo '<div class="btn-group">
                                                                        <button class="btn btn-warning waves-effect waves-ligh btnEditarBoleta" idBoleta="'.$value["LiquidacionID"].'" tipoBoleta="'.$value["TipoLiquidacionID"].'" empleadoID="'.$value["EmpleadoID"].'" liquidacion="'.$value["Tipo"].'"><i class="icofont icofont-ui-edit"></i></button>

                                                                    </div> ';

                                                                    }

                                                                   echo '<div class="btn-group">
                                                                        <button class="btn btn-danger waves-effect waves-ligh btnEliminarBoleta" idBoleta='.$value["LiquidacionID"].' NombreBoleta ='.$value["Nombre"].' ApellidoBoleta='.$value["Apellido"].' mes='.$value["Mes"].' anio='.$value["Anio"].' tipo='.$value["Tipo"].'><i class="icofont icofont-ui-delete"></i></button>
                                                                    </div>
                                                                    <div class="btn-group">
                                                                        <button class="btn btn-success waves-effect waves-ligh btnDetalleBoleta" data-toggle="modal" data-target="#modalDetalleDeBoleta" idBoleta='.$value["LiquidacionID"].'><i class="icofont icofont-eye-alt"></i></button>
                                                                    </div>
                                                                    <div class="btn-group">
                                                                        <button class="btn btn-primary waves-effect waves-ligh btnImprimirBoleta" idBoleta="'.$value["LiquidacionID"].'" estado="'.$value["Estado"].'"><i class="icofont icofont-printer"></i></button>
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
        DETALLE DE LIQUIDACION
======================================-->

    <div class="modal fade" id="modalDetalleDeBoleta" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h5 class="modal-title tituloBoletaDetalle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row invoive-info">
                        <div class="col-md-6 col-sm-8 invoice-client-info">
                            <img src="vistas/img/plantilla/logo.png" alt="logo.png">
                        </div>
                        <div class="col-md-6 col-sm-8">
                            <table class="table table-responsive invoice-table invoice-order table-borderless">
                                <tbody>
                                    <tr>
                                        <th class="f-12">Tipo :</th>
                                        <td id="tipoBoletaDetalle" class="f-12"></td>
                                    </tr>
                                    <tr>
                                        <th class="f-12">Empleado : </th>
                                        <td id="empleadoBoletaDetalle" class="f-12"></td>
                                    </tr>
                                    <tr>
                                        <th class="f-12">Periodo :</th>
                                        <td id="periodoBoletaDetalle" class="f-12"></td>
                                    </tr>
                                    <tr>
                                        <th class="f-12">Estado :</th>
                                        <td id="estadoBoletaDetalle" class="f-12"></td>
                                    </tr>
                                    <tr>
                                        <th class="f-12">Fecha de confección:</th>
                                        <td id="fechaConfeccionBoletaDetalle" class="f-12"></td>
                                    </tr>
                                    <tr>
                                        <th class="f-12">Fecha de liquidación:</th>
                                        <td id="fechaLiquidacionBoletaDetalle" class="f-12"></td>
                                    </tr>
                                    <tr>
                                        <th class="f-12">Fecha de pago:</th>
                                        <td id="fechaPagoBoletaDetalle" class="f-12"></td>
                                    </tr>
                                </tbody>
                            </table>


                        </div>
                    </div>
                    <div class="row invoive-info">

                        <div class="col-md-12 col-sm-8">

                                <table class="table table-bordered table-xs" id="tablaConceptos">
                                    <thead>
                                        <tr class="table-success">
                                            <th class="text-center f-10" style="width: 10%">Código</th>
                                            <th class="text-center f-10">Concepto</th>
                                            <th class="text-center f-10">Unidades</th>
                                            <th class="text-center f-10">Hab.C/Desc</th>
                                            <th class="text-center f-10">Hab.S/Desc</th>
                                            <th class="text-center f-10">Deducciónes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="ingresar">
                                            <th scope="row" colspan="3" class="table-success text-right f-10">TOTALES:</th>
                                            <td class="table-warning text-right f-10" id="totalRemunerativosBoletaDetalle"></td>
                                            <td class="table-warning text-right f-10" id="totalNoRemunerativosBoletaDetalle"></td>
                                            <td class="table-warning text-right f-10" id="totalRetencionesBoletaDetalle"></td>
                                            </tr>
                                            <tr>
                                            <th scope="row" colspan="5" class="table-success text-right f-10">NETO:</th>
                                            <td class="table-warning text-right f-12" id="totalNetoBoletaDetalle"></td>
                                        </tr>
                                    </tbody>
                                </table>

                        </div>


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Salir</button>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript" src="vistas/js/payment.js"></script>
