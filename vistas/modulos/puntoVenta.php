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
                        <h4 class="m-b-10">Administración de punto de ventas</h4>
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
            LISTADO PDVS
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
                                            <h5 class="card-header-text p-t-15">Listado de punto de ventas</h5>
                                        </div>
                                        <div class="col-lg-6 text-right">
                                            <button class="btn btn-mat waves-effect waves-light btn-primary" data-toggle="modal" data-target="#modalCrearPDV"><i class="icofont icofont-plus m-r-5"></i>Nuevo PDV</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="md-card-block">
                                        <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
                                            <thead>
                                                <th style="text-align: center;">#</th>
                                                <th style="text-align: center;">Nombre</th>
                                                <th style="text-align: center;">Domicilio</th>
                                                <th style="text-align: center;">Localidad</th>
                                                <th style="text-align: center;">Cuitt</th>
                                                <th style="text-align: center;">Ingresos brutos</th>
                                                <th style="text-align: center;">Inicio actividades</th>
                                                <th style="text-align: center;">Activo</th>
                                                <th style="text-align: center;">Acciones</th>
                                            </thead>
                                            <tbody>
                                                <?php

                                                $item = null;
                                                $valor = null;

                                                $listar = ControladorConfiguracion::ctrMostrarPdvs($item, $valor);

                                                foreach ($listar as $key => $value) {

                                                   if (!empty($value["Piso"])) {

                                                        $piso = "- Piso ".$value["Piso"];

                                                   } else {

                                                        $piso = "";

                                                   }

                                                   if (!empty($value["Dpto"])) {

                                                        $dpto = "- Dpto ".$value["Dpto"];

                                                   } else {

                                                        $dpto = "";

                                                   }

                                                    echo '<tr>
                                                            <td style="text-align: center;">'.($key+1).'</td>
                                                            <td style="text-align: center;">'.$value["Nombre"].'</td>
                                                            <td style="text-align: center;">'.$value["Calle"].' '.$value["Nro"].''.$piso.''.$dpto.'</td>
                                                            <td style="text-align: center;">'.$value["Localidad"].'</td>
                                                            <td style="text-align: center;">'.$value["CUITT"].'</td>
                                                            <td style="text-align: center;">'.$value["IngresosBrutos"].'</td>
                                                            <td style="text-align: center;">'.$value["Inicio"].'</td>';

                                                    if($value["Activo"] =="S"){

                                                                  echo '<td style="text-align: center;"><button  class="btn btn-success waves-effect waves-ligh" onclick="activarDesactivarPdv(\''.$value["PuntoVentaID"].'\' , \''.$value["Nombre"].'\', \''.$value["Activo"].'\')">Si</button></td>';

                                                                  } else {

                                                                  echo '<td style="text-align: center;"><button  class="btn btn-danger waves-effect waves-ligh" onclick="activarDesactivarPdv(\''.$value["PuntoVentaID"].'\' , \''.$value["Nombre"].'\', \''.$value["Activo"].'\')">No</button></td>';
                                                              }

                                                    echo '<td style="text-align: center;">
                                                                <div class="btn-group">
                                                                    <button class="btn btn-warning waves-effect waves-ligh btnEditarPDV" idPDV="'.$value["PuntoVentaID"].'" data-toggle="modal" data-target="#modalEditarPDV"><i class="icofont icofont-ui-edit"></i></button>
                                                                </div>
                                                                <div class="btn-group">
                                                                    <button class="btn btn-danger waves-effect waves-ligh btnEliminarPDV" idPDV="'.$value["PuntoVentaID"].'" nombrePDV="'.$value["Nombre"].'"><i class="icofont icofont-ui-delete"></i></button>
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
            AGREGAR PDV
======================================-->

    <div class="modal fade" id="modalCrearPDV" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h4 class="modal-title">Nuevo Punto de Venta</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="formAgregarPdv" method="post" class="form-material">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-briefcase-alt-2"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="pdvNombre" id="pdvNombre" minlength="3" maxlength="20" required>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Nombre</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-briefcase-alt-2"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control cuit" name="pdvCUIT" id="pdvCUIT" minlength="3" maxlength="20" required>
                                    <span class="form-bar"></span>
                                    <label class="float-label">CUITT</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-briefcase-alt-2"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control cuit" name="pdvIngresosBrutos" id="pdvIngresosBrutos" minlength="3" maxlength="20" required>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Ingresos brutos</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-briefcase-alt-2"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control date" name="pdvInicioActividades" id="pdvInicioActividades" minlength="3" maxlength="20" required>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Inicio actividades</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-ui-dial-phone"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="pdvCodArea" id="pdvCodArea" minlength="3" maxlength="4" required>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Código de area</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-ui-dial-phone"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="pdvTelefono" id="pdvTelefono" minlength="3" maxlength="7" required>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Teléfono</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h6>Datos del domicilio</h6>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-address-book"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="callePdv" id="callePdv" required="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Calle</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-address-book"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="numCallePdv" id="numCallePdv" maxlength="4" required="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Número</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-building-alt"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="pisoPdv" id="pisoPdv" maxlength="2" required="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Piso</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-building-alt"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="deptoPdv" id="deptoPdv" maxlength="2" required="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Departamento</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-building-alt"></i>
                                </div>
                                <div class="form-group form-primary">
                                     <input type="text" class="form-control" name="localidadPdv" id="localidadPdv" onkeyup="aLocalidad('Nuevo');">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Localidad</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-building-alt"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control autocomplete" name="barrioPdv" id="barrioPdv" onkeyup="aBarrio('Nuevo');" >
                                    <span class="form-bar"></span>
                                    <label class="float-label">Barrio</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-building-alt"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="codPostalPdv" id="codPostalPdv" maxlength="4" minlength="3">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Código postal</label>
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
                    $crearPDV -> ctrRegistrarPdv();
                ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!--=====================================
            EDITAR PDV
======================================-->

    <div class="modal fade" id="modalEditarPDV" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h4 class="modal-title" id="NombrePuntoVenta"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="formEditarPdv" method="post" class="form-material">
                    <input type="hidden" name="idPdv" id="idPdv">
                    <input type="hidden" name="estadoPDV" id="estadoPDV">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-briefcase-alt-2"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="epdvNombre" id="epdvNombre" minlength="3" maxlength="20" required>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Nombre</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-briefcase-alt-2"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control cuit" name="epdvCUIT" id="epdvCUIT" minlength="3" maxlength="20" required>
                                    <span class="form-bar"></span>
                                    <label class="float-label">CUITT</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-briefcase-alt-2"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control cuit" name="epdvIngresosBrutos" id="epdvIngresosBrutos" minlength="3" maxlength="20" required>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Ingresos brutos</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-briefcase-alt-2"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control date" name="epdvInicioActividades" id="epdvInicioActividades" minlength="3" maxlength="20" required>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Inicio actividades</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-ui-dial-phone"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="epdvCodArea" id="epdvCodArea" minlength="3" maxlength="4" required>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Código de area</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-ui-dial-phone"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="epdvTelefono" id="epdvTelefono" minlength="3" maxlength="7" required>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Teléfono</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h6>Datos del domicilio</h6>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-address-book"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="ecallePdv" id="ecallePdv" required="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Calle</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-address-book"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="enumCallePdv" id="enumCallePdv" maxlength="4" required="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Número</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-building-alt"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="episoPdv" id="episoPdv" maxlength="2" required="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Piso</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-building-alt"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="edeptoPdv" id="edeptoPdv" maxlength="2" required="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Departamento</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-building-alt"></i>
                                </div>
                                <div class="form-group form-primary">
                                     <input type="text" class="form-control" name="elocalidadPdv" id="elocalidadPdv" onkeyup="aLocalidad('Editar');">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Localidad</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-building-alt"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control autocomplete" name="ebarrioPdv" id="ebarrioPdv" onkeyup="aBarrio('Editar');" >
                                    <span class="form-bar"></span>
                                    <label class="float-label">Barrio</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-building-alt"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="ecodPostalPdv" id="ecodPostalPdv" maxlength="4" minlength="3">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Código postal</label>
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
                    $modificarPDV -> ctrModificarPdv();
                ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript" src="vistas/js/puntoVenta.js"></script>
