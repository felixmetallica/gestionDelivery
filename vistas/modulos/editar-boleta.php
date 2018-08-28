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
                        <h4 class="m-b-10">Editar liquidación</h4>
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
            LIQUIDACION
======================================-->

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form class="form-material" role="form" id="fornNuevaBoleta" method="post">
                                <input type="hidden" name="idBoletaLiquidacion" id="idBoletaLiquidacion" value="<?php echo $_GET["idBoleta"];?>">
                                <div class="card">
                                    <div class="card-block">
                                        <div class="row">
                                            <div class="col-lg-3 col-xs-12"><!--COLUMNA 1-->
                                                <div class="card">
                                                    <div class="card-header bg-success p-1">
                                                    </div>
                                                    <div class="card-block"><!--CONTENIDO COLUMNA EMPLEADOS-->
                                                        <h6 class="p-b-10">Liquidación</h6>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="material-group material-group-primary material-group-sm">
                                                                    <div class="material-addone">
                                                                        <i class="icofont icofont-document-folder"></i>
                                                                    </div>
                                                                    <div class="form-group form-primary form-static-label">
                                                                        <?php

                                                                            $item = "EmpleadoID";
                                                                            $valor= $_GET["idEmpleado"];

                                                                            $traigoEmpleado = ControladorEmpleados::ctrMostrarEmpleados($item, $valor);

                                                                        ?>
                                                                        <input type="text" name="nombreEmpleadoBoleta" id="nombreEmpleadoBoleta" class="form-control" value="<?php echo $traigoEmpleado["Nombre"].' '.$traigoEmpleado["Apellido"] ;?>" required="" readonly>
                                                                        <input type="hidden" name="empleadoBoleta" id="empleadoBoleta" value="<?php echo $_GET["idEmpleado"]; ?>">
                                                                        <span class="form-bar"></span>
                                                                        <label class="float-label">Empleado</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="material-group material-group-primary material-group-sm">
                                                                    <div class="material-addone">
                                                                        <i class="icofont icofont-document-folder"></i>
                                                                    </div>
                                                                    <div class="form-group form-primary form-static-label">
                                                                        <?php

                                                                            $item = null;
                                                                            $valor = null;

                                                                            $listarTiposLiquidacion = ControladorPayment::ctrMostrarTipoLiquidacion($item, $valor);

                                                                            foreach ($listarTiposLiquidacion as $key => $value) {

                                                                                if ($value["TipoLiquidacionID"] == $_GET["tipoLiquidacion"]) {

                                                                                    echo '<input type="text" name="tipoBoleta" id="tipoBoleta" class="form-control" value="'.$value["Descripcion"].'" required="" readonly>';

                                                                                }

                                                                            }

                                                                        ?>
                                                                        <input type="hidden" name="tipoLiquidacionBoleta" id="tipoLiquidacionBoleta" value="<?php echo $_GET["tipoLiquidacion"]; ?>">
                                                                        <span class="form-bar"></span>
                                                                        <label class="float-label">Tipo liquidación</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <?php

                                                            if (isset($_GET["idEmpleado"])) {

                                                                $item = "EmpleadoID";
                                                                $valor = $_GET["idEmpleado"];
                                                                $traerEmpleado = ControladorEmpleados::ctrMostrarEmpleados($item, $valor);
                                                                setlocale(LC_ALL,"es_ES");
                                                                $año = date("Y");
                                                                $añoSiguiente = ($año+1);

                                                                $itemB = "LiquidacionID";
                                                                $valorB = $_GET["idBoleta"];

                                                                $listarB = ControladorPayment::ctrMostrarLiquidacion($itemB, $valorB);

                                                                $listaMeses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                                                                $listarAnios = array("$año", "$añoSiguiente");

                                                                echo '<hr>
                                                                    <h6>Periodo a liquidar</h6>
                                                                    <div class="row p-t-15">
                                                                        <div class="col-sm-6 p-t-5">
                                                                            <div class="material-group material-group-primary material-group-sm">
                                                                                <div class="material-addone">
                                                                                    <i class="icofont icofont-calendar"></i>
                                                                                </div>
                                                                                <div class="form-group form-primary form-static-label">
                                                                                    <select class="form-control mesPeriodo" name="mesPeriodo" id="mesPeriodo" required>';

                                                                                        foreach ($listaMeses as $item => $valor) {

                                                                                            if ($valor == $listarB["Mes"]) {

                                                                                                echo '<option value="'.$listarB["Mes"].'" selected>'.$valor.'</option>';

                                                                                            } else {

                                                                                                echo '<option value="'.$valor.'">'.$valor.'</option>';

                                                                                            }
                                                                                        }

                                                                                    echo '</select>
                                                                                    <span class="form-bar"></span>
                                                                                    <label class="float-label">Mes</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6 p-t-5">
                                                                            <div class="material-group material-group-primary material-group-sm">
                                                                                <div class="material-addone">
                                                                                    <i class="icofont icofont-calendar"></i>
                                                                                </div>
                                                                                <div class="form-group form-primary form-static-label">
                                                                                    <select class="form-control anioPeriodo" name="anioPeriodo" id="anioPeriodo" required>';
                                                                                    foreach ($listarAnios as $item => $valor) {

                                                                                        if ($valor == $listarB["Anio"]) {

                                                                                            echo '<option value="'.$listarB["Anio"].'" selected>'.$valor.'</option>';

                                                                                        } else {

                                                                                            echo '<option value="'.$valor.'">'.$valor.'</option>';

                                                                                        }
                                                                                    }

                                                                                echo '</select>
                                                                                    <span class="form-bar"></span>
                                                                                    <label class="float-label">Año</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <hr>
                                                                    <h6>Datos de '.$traerEmpleado["Nombre"].' '.$traerEmpleado["Apellido"].'</h6>
                                                                    <div class="row p-t-15">
                                                                        <div class="col-sm-6">
                                                                            <div class="material-group material-group-primary material-group-sm">
                                                                                <div class="material-addone">
                                                                                   <i class="icofont icofont-user-alt-7"></i>
                                                                                </div>
                                                                                <div class="form-group form-primary form-static-label">
                                                                                    <input type="text" name="legajoEmpleadoBoleta" id="legajoEmpleadoBoleta" class="form-control" value="'.$traerEmpleado["Legajo"].'" maxlength="20" required="" readonly>
                                                                                    <span class="form-bar"></span>
                                                                                    <label class="float-label">Legajo</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="material-group material-group-primary material-group-sm">
                                                                                <div class="material-addone">
                                                                                    <i class="icofont icofont-user-alt-7"></i>
                                                                                </div>
                                                                                <div class="form-group form-primary form-static-label">
                                                                                    <input type="text" class="form-control" sueldoBasico="" name="puestoEmpleadoBoleta" id="puestoEmpleadoBoleta" value="'.$traerEmpleado["Puesto"].'" maxlength="30" required="" readonly>
                                                                                    <span class="form-bar"></span>
                                                                                    <label class="float-label">Puesto</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row p-t-15">
                                                                        <div class="col-sm-6">
                                                                            <div class="material-group material-group-primary material-group-sm">
                                                                                <div class="material-addone">
                                                                                   <i class="icofont icofont-user-alt-7"></i>
                                                                                </div>
                                                                                <div class="form-group form-primary form-static-label">
                                                                                    <input type="text" name="fechaIngresoEmpleadoBoleta" id="fechaIngresoEmpleadoBoleta" class="form-control" value="'.$traerEmpleado["Ingreso"].'" required="" readonly>
                                                                                    <span class="form-bar"></span>
                                                                                    <label class="float-label">Ingreso</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="material-group material-group-primary material-group-sm">
                                                                                <div class="material-addone">
                                                                                    <i class="icofont icofont-user-alt-7"></i>
                                                                                </div>
                                                                                <div class="form-group form-primary form-static-label">
                                                                                    <input type="text" class="form-control" sueldoBasico="" name="cuilEmpleadoBoleta" id="cuilEmpleadoBoleta" value="'.$traerEmpleado["CUIL"].'" required="" readonly>
                                                                                    <span class="form-bar"></span>
                                                                                    <label class="float-label">CUIL</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    ';

                                                            }

                                                        ?>
                                                        <hr>
                                                        <!--BTN AGREGAR AGREGAR CONCEPTO-->
                                                        <div class="row">
                                                            <div class="col-sm-12 text-center p-b-15">

                                                               <?php

                                                                    if (isset($_GET["idEmpleado"])) {

                                                                        switch ($_GET["tipoLiquidacion"]) {

                                                                            case '3':


                                                                                break;

                                                                            default:

                                                                                 echo '<button type="button" class="btn waves-effect waves-light btn-primary btn-sm btnAgregarConcepto" data-toggle="modal" data-target="#modalAgregarConceptoBoleta"><i class="icofont icofont-plus"></i>Agregar concepto</button>';

                                                                                break;
                                                                        }

                                                                    } else {

                                                                        echo '<button type="button" class="btn waves-effect waves-light btn-primary btn-sm btn-disabled disabled"><i class="icofont icofont-plus"></i>Agregar concepto</button>';
                                                                    }

                                                                ?>

                                                            </div>
                                                        </div>

                                                    </div><!--FIN CONTENIDO COLUMNA EMPLEADOS-->
                                                </div>
                                            </div><!--FIN COLUMNA 1-->
                                            <div class="col-lg-9 d-none d-sm-none d-lg-block"><!--COLUMNA 2-->
                                                <div class="card">
                                                    <div class="card-header bg-danger p-1"></div>
                                                    <div class="card-block table-border-style"><!--CONTENIDO COLUMNA CONCEPTOS-->
                                                        <h6>Conceptos</h6>
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-xs" id="tablaConceptos">
                                                                <thead>
                                                                    <tr class="table-success">
                                                                        <th class="text-center" style="width: 10%">Código</th>
                                                                        <th class="text-center">Concepto</th>
                                                                        <th class="text-center">Unidades</th>
                                                                        <th class="text-center">Hab.C/Desc</th>
                                                                        <th class="text-center">Hab.S/Desc</th>
                                                                        <th class="text-center">Deducciónes</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    <?php

                                                                        if (isset($_GET["idEmpleado"])) {

                                                                            $item = "EmpleadoID";
                                                                            $valor = $_GET["idEmpleado"];

                                                                            $traerEmpleado = ControladorEmpleados::ctrMostrarEmpleados($item, $valor);

                                                                            $sueldoBasico = $traerEmpleado["Basico"];
                                                                            $antiguedad = $traerEmpleado["Antiguedad"];

                                                                            switch ($_GET["tipoLiquidacion"]) {

                                                                                case '1':
                                                                                    include "liquidaciones/editar-mensual.php";
                                                                                    break;
                                                                                case '2':
                                                                                    include "liquidaciones/editar-parcial.php";
                                                                                    break;
                                                                                case '3':
                                                                                    include "liquidaciones/editar-aguinaldo.php";
                                                                                    break;
                                                                                case '4':
                                                                                    include "liquidaciones/editar-vacaciones.php";
                                                                                    break;
                                                                                                                                                            }

                                                                        }
                                                                    ?>

                                                                    <input type="hidden" name="listadoConceptos" id="listadoConceptos" value='<?php echo $todoConceptos; ?>'>
                                                                    <input type="hidden" name="totalHaberesCdesc" id="totalHaberesCdesc" value="<?php echo $TotalRemu;?>">
                                                                    <input type="hidden" name="totalHaberesSdesc" id="totalHaberesSdesc" value="<?php echo $TotalNoRemu;?>">
                                                                    <input type="hidden" name="totalRetencion" id="totalRetencion" value="<?php echo $totalReten;?>">
                                                                    <input type="hidden" name="totalNetoBoleta" id="totalNetoBoleta" value="<?php echo $totalNeto;?>">

                                                                </tbody>
                                                            </table>
                                                        </div>


                                                    </div><!-- FIN CONTENIDO COLUMNA CONCEPTOS-->
                                                    <div class="card-footer">
                                                        <?php

                                                            if (isset($_GET["dias"])) {

                                                                echo '<div class="row text-center">
                                                                        <div class="col-sm-12">
                                                                            <button type="button" class="btn waves-effect waves-light btn-success btnCalcularVacaciones btn-disabled disabled" deactivado="1" recalcula="1">Calcular vacaciones</button>
                                                                        </div>
                                                                    </div>';
                                                            }

                                                        ?>
                                                        <div class="row text-right">
                                                            <div class="col-sm-12">
                                                                <a href="liquidaciones"><button type="button" class="btn waves-effect waves-light btn-primary">Cancelar</button></a>

                                                                <?php

                                                                    if (isset($_GET["dias"])) {

                                                                        echo '<button type="submit" class="btn waves-effect waves-light btn-primary btnConfirmarLiquidacion">Comfirmar</button>';

                                                                    } else {

                                                                        echo '<button type="submit" class="btn waves-effect waves-light btn-primary btnConfirmarLiquidacion">Comfirmar</button>';

                                                                    }

                                                                ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!--FIN TABLA DE CONCEPTOS-->
                                        </div>
                                    </div>
                                </div>
                                <?php
                                    $editarBoleta = new ControladorPayment();
                                    $editarBoleta -> ctrEditarBoleta();
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div><!--CONTENIDO PAGINA-->


<!--=====================================
            AGREGAR CONCEPTO
======================================-->

    <div class="modal fade" id="modalAgregarConceptoBoleta" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h4 class="modal-title">Listado de conceptos</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form class="form-material" role="form" id="formAgregarConceptoBoleta" method="post">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="material-group material-group-primary">
                                    <div class="material-addone">
                                        <i class="icofont icofont-calculator-alt-2"></i>
                                    </div>
                                    <div class="form-group form-primary form-static-label">
                                        <select class="form-control" name="conceptoAgregar" id="conceptoAgregar">
                                            <option value="">Selecione una opcion</option>
                                        </select>
                                        <span class="form-bar"></span>
                                        <label class="float-label">Concepto</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="material-group material-group-primary">
                                    <div class="material-addone">
                                        <i class="icofont icofont-label"></i>
                                    </div>
                                    <div class="form-group form-primary">
                                        <input type="text" class="form-control" name="unidadesConcepto" id="unidadesConcepto" minlength="1" maxlength="4">
                                        <span class="form-bar"></span>
                                        <label class="float-label">Unidades</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary waves-effect waves-light btnAgregarConceptoBoleta">Agregar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

<script type="text/javascript" src="vistas/js/payment.js"></script>
