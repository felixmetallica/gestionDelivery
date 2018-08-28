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
                        <h4 class="m-b-10">Administración de Proveedores</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="inicio">
                                <i class="ti-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#!">Proveedores</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

<!--============================================
        LISTADO DE PROVEEDORES
=============================================-->

    <div class="pcoded-inner-content" id="tablaProveedor">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h5 class="card-header-text p-t-15">Listado de proveedores</h5>
                                        </div>
                                        <div class="col-lg-6 text-right">
                                            <a href="extensiones/tcpdf/pdf/reporte-proveedores.php" target="_blank"><img class="img-40" src="vistas/img/plantilla/pdf.png"></a>
                                            <a href="vistas/modulos/reportes.php?reporte=reporteProveedores"><img class="img-40" src="vistas/img/plantilla/xls.png"></a>
                                            <button class="btn btn-mat waves-effect waves-light btn-primary" data-toggle="modal" data-target="#modalAgregarProveedor"><i class="icofont icofont-plus"></i>Nuevo proveedor</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="md-card-block">
                                        <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
                                            <thead>
                                                <th style="text-align: center;">#</th>
                                                <th style="text-align: center;">Razon Social</th>
                                                <th style="text-align: center;">CUITT</th>
                                                <th style="text-align: center;">Rubro</th>
                                                <th style="text-align: center;">Teléfono</th>
                                                <th style="text-align: center;">Activo</th>
                                                <th style="text-align: center;">Acciones</th>
                                            </thead>
                                            <tbody>
                                                <?php

                                                    $item = null;
                                                    $valor = null;
                                                    $listar = ControladorProveedores::ctrMostrarProveedores($item, $valor);

                                                    foreach ($listar as $key => $value) {

                                                        echo' <tr>
                                                                <td style="text-align: center;">'.($key+1).'</td>
                                                                <td style="text-align: left;">'.$value["RazonSocial"].'</td>
                                                                <td style="text-align: center;">'.$value["CUITT"].'</td>
                                                                <td style="text-align: center;">'.$value["Rubro"].'</td>
                                                                <td style="text-align: center;">('.$value["Prefijo"].') - '.$value["NroTelefono"].'</td>';
                                                                if($value["Activo"] =="S"){

                                                                        echo '<td style="text-align: center;"><button  class="btn btn-success waves-effect waves-ligh" onclick="activarDesactivarProveedor(\''.$value["ProveedorID"].'\' , \''.$value["RazonSocial"].'\', \''.$value["Activo"].'\')">Si</button></td>';

                                                                        }else{

                                                                        echo '<td style="text-align: center;"><button  class="btn btn-danger waves-effect waves-ligh" onclick="activarDesactivarProveedor(\''.$value["ProveedorID"].'\' , \''.$value["RazonSocial"].'\', \''.$value["Activo"].'\')">No</button></td>';
                                                                        }
                                                                        echo '<td style="text-align: center;"><div class="btn-group">
                                                                                                    <div class="btn-group">
                                                                                <button class="btn btn-warning waves-effect waves-ligh btnEditarProveedor" data-toggle="modal" data-target="#modalEditarProveedor" onclick="editoProveedor(\''.$value["ProveedorID"].'\');" ><i class="icofont icofont-ui-edit"></i></button>
                                                                            </div></div>
                                                                                                <div class="btn-group">
                                                                                                    <button class="btn btn-danger waves-effect waves-ligh btnEliminarProveedor"
                                                                                                    onclick="eliminarProveedor(\''.$value["ProveedorID"].'\', \''.$value["PersonaID"].'\', \''.$value["RazonSocial"].'\');" ><i class="icofont icofont-ui-delete"></i></button>
                                                                                                </div>
                                                                                                <div class="btn-group">
                                                                                                    <button class="btn btn-success waves-effect waves-ligh" onclick="detalleProveeodr(\''.$value["ProveedorID"].'\')"><i class="icofont icofont-eye-alt"></i></button>
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

<!--============================================
        DETALLE DE PROVEEDORES
=============================================-->

    <div class="pcoded-inner-content" id="tablaProveedor">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row" id="detalleProveedor" style="display: none;">
                        <div class="col-xl-3 col-lg-4">
                            <div class="card faq-left">
                                <div class="social-profile">
                                    <img class="img-fluid" src="vistas/img/proveedores/proveedores.jpeg" alt="">
                                </div>
                                <div class="card-block">
                                    <h4 id="detalleRazonP" class="f-18 f-normal m-b-10 txt-primary"></h4>
                                    <ul>
                                        <li class="faq-contact-card" id="detalleTelefonoProveedorP"></li>
                                        <li class="faq-contact-card" id="detalleEmailProveedorP"></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-9 col-lg-8">
                            <div class="card product-detail-page">
                                <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active f-18 p-b-0" data-toggle="tab" href="#proveedor" role="tab">Proveedor</a>
                                        <div class="slide"></div>
                                    </li>
                                    <li class="nav-item m-b-0">
                                        <a class="nav-link f-18 p-b-0" data-toggle="tab" href="#domicilio" role="tab">Domicilio</a>
                                        <div class="slide"></div>
                                    </li>
                                    <li class="nav-item m-b-0">
                                        <a class="nav-link f-18 p-b-0" data-toggle="tab" href="#referente" role="tab">Referente</a>
                                        <div class="slide"></div>
                                    </li>
                                </ul>
                            </div>
                            <div class="card">
                                <div class="card-block">
                                    <!-- Tab panes -->
                                    <div class="tab-content bg-white">
                                        <div class="tab-pane active" id="proveedor" role="tabpanel">
                                            <div class="row">
                                                <div class="col-lg-12 col-xl-6">
                                                    <table class="table m-0">
                                                        <tbody>
                                                        <tr>
                                                            <th scope="row">Razon social</th>
                                                            <td id="detalleRazon"></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Iva</th>
                                                            <td id="detalleIva"></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Email</th>
                                                            <td id="detalleEmail"></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Fecha de alta</th>
                                                            <td id="detalleFechaAlta"></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-lg-12 col-xl-6">
                                                    <table class="table">
                                                        <tbody>
                                                        <tr>
                                                            <th scope="row">Cuit</th>
                                                            <td id="detalleCuit"></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Rubro</th>
                                                            <td id="detalleRubro"></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Teléfono</th>
                                                            <td id="detalleTelefono"></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Estado actual</th>
                                                            <td id="detalleEstado"></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="domicilio" role="tabpanel">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="general-info">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-xl-6">
                                                                <table class="table m-0">
                                                                    <tbody>
                                                                        <tr>
                                                                            <th scope="row">Calle</th>
                                                                            <td id="detalleCalle"></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Piso</th>
                                                                            <td id="detallePiso"></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Localidad</th>
                                                                            <td id="detalleLocalidad"></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Código Postal</th>
                                                                            <td id="detalleCP"></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="col-lg-12 col-xl-6">
                                                                <table class="table">
                                                                    <tbody>
                                                                        <tr>
                                                                            <th scope="row">Número de calle</th>
                                                                            <td id="detalleNumCalle"></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Departamento</th>
                                                                            <td id="detalleDpto"></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Barrio</th>
                                                                            <td id="detalleBarrio"></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row"></th>
                                                                            <td></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="referente" role="tabpanel">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="general-info">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-xl-6">
                                                                <table class="table m-0">
                                                                    <tbody>
                                                                    <tr>
                                                                        <th scope="row">Nombre</th>
                                                                        <td id="detalleNombreRef"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Email</th>
                                                                        <td id="detalleEmailRef"></td>
                                                                    </tr>
                                                                </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="col-lg-12 col-xl-6">
                                                                <table class="table">
                                                                    <tbody>
                                                                        <tr>
                                                                            <th scope="row">Apellido</th>
                                                                            <td id="detalleApellidoRef"></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Teléfono</th>
                                                                            <td id="detalleTelRef"></td>
                                                                        </tr>
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
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h5 class="card-footer-text p-t-15"></h5>
                                        </div>
                                        <div class="col-lg-6 text-right">
                                            <button class="btn btn-mat waves-effect waves-light btn-primary" onclick="volveraListas();"><i class="icofont icofont-simple-left"></i>Volver</button>
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
        AGREGAR PROVEEDOR
======================================-->

    <div class="modal fade" id="modalAgregarProveedor" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h4 class="modal-title">Nuevo Proveedor</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-block">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="wizard">
                                        <section>
                                            <form class="form-material" id="registrarProveedor" method="post">
                                                <h3> Datos del Proveedor </h3>
                                                <fieldset>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                   <i class="icofont icofont-briefcase-alt-2"></i>
                                                                </div>
                                                                <div class="form-group form-primary">
                                                                    <input type="text" name="razonProveedor" id="razonProveedor" class="form-control" minlength="3" maxlength="70">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Razón Social</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-stamp"></i>
                                                                </div>
                                                                <div class="form-group form-primary">
                                                                    <input type="text" class="form-control cuit" name="cuitProveedor" id="cuitProveedor" minlength="3" maxlength="30">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">CUIT</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-ui-email"></i>
                                                                </div>
                                                                <div class="form-group form-primary">
                                                                    <input type="email" class="form-control" name="emailProveedor" id="emailProveedor">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Email</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-money-bag"></i>
                                                                </div>
                                                                <div class="form-group form-primary form-static-label p-t-5">
                                                                    <select class="form-control" name="ivaProveedor" id="ivaProveedor">
                                                                        <option value="">Seleccione el iva</option>
                                                                        <?php
                                                                            $listarIva = new ControladorProveedores();
                                                                            $listarIva -> ctrListarIva();
                                                                        ?>
                                                                    </select>
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">IVA</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-cart-alt"></i>
                                                                </div>
                                                                <div class="form-group form-primary form-static-label p-t-5">
                                                                    <select class="form-control" name="rubroProveedor" id="rubroProveedor">
                                                                        <option value="">Seleccione el rubro</option>
                                                                        <?php
                                                                            $listarRubros = new ControladorProveedores();
                                                                            $listarRubros -> ctrListarRubros();
                                                                        ?>
                                                                    </select>
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Rubro</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-ui-cell-phone"></i>
                                                                </div>
                                                                <div class="form-group form-primary">
                                                                    <input type="text" class="form-control" name="codAreaTelefonoProveedor" id="codAreaTelefonoProveedor" maxlength="4" minlength="3">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Código de area</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-ui-cell-phone"></i>
                                                                </div>
                                                                <div class="form-group form-primary">
                                                                    <input type="text" class="form-control" name="numeroTeléfonoProveedor" id="numeroTeléfonoProveedor" maxlength="8">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Teléfono</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                <h3> Domicilio </h3>
                                                <fieldset>
                                                   <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-address-book"></i>
                                                                </div>
                                                                <div class="form-group form-primary">
                                                                    <input type="text" class="form-control" name="calleProveedor" id="calleProveedor">
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
                                                                    <input type="text" class="form-control" name="numCalleProveedor" id="numCalleProveedor" maxlength="4">
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
                                                                    <input type="text" class="form-control" name="pisoProveedor" id="pisoProveedor" maxlength="2" >
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
                                                                    <input type="text" class="form-control" name="deptoProveedor" id="deptoProveedor" maxlength="2" >
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
                                                                     <input type="text" class="form-control autocomplete" name="localidadProveedor" id="localidadProveedor" onkeyup="aLocalidad('Nuevo');">
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
                                                                    <input type="text" class="form-control autocomplete" name="barrioProveedor" id="barrioProveedor" onkeyup="aBarrio('Nuevo');" >
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
                                                                    <input type="text" class="form-control" name="codPostalProveedor" id="codPostalProveedor" maxlength="4" minlength="3">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Código postal</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                <h3> Referente </h3>
                                                <fieldset>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                   <i class="icofont icofont-briefcase-alt-2"></i>
                                                                </div>
                                                                <div class="form-group form-primary">
                                                                    <input type="text" name="nombreRefProveedor" id="nombreRefProveedor" class="form-control" minlength="3" maxlength="20">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Nombre</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-stamp"></i>
                                                                </div>
                                                                <div class="form-group form-primary">
                                                                    <input type="text" class="form-control" name="apellidoRefProveedor" id="apellidoRefProveedor" minlength="3" maxlength="30">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Apellido</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-ui-email"></i>
                                                                </div>
                                                                <div class="form-group form-primary">
                                                                    <input type="email" class="form-control" name="emailRefProveedor" id="emailRefProveedor">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Email</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-ui-cell-phone"></i>
                                                                </div>
                                                                <div class="form-group form-primary">
                                                                    <input type="text" class="form-control" name="codArRefProveedor" id="codArRefProveedor" maxlength="4" minlength="3">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Código de area</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-ui-cell-phone"></i>
                                                                </div>
                                                                <div class="form-group form-primary">
                                                                    <input type="text" class="form-control" name="numTelRefProveedor" id="numTelRefProveedor" maxlength="9">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Teléfono</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </form>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Salir</button>
                </div>
            </div>
        </div>
    </div>

<!--=====================================
        EDITAR PROVEEDOR
======================================-->

    <div class="modal fade" id="modalEditarProveedor" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h4 class="modal-title" id="NombreProveedorEditar"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-block">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="wizard">
                                        <section>
                                            <form class="form-material" id="editarProveedor" method="post">
                                                <h3> Datos del Proveedor </h3>
                                                <fieldset>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                   <i class="icofont icofont-briefcase-alt-2"></i>
                                                                </div>
                                                                <div class="form-group form-primary">
                                                                    <input type="text" name="erazonProveedor" id="erazonProveedor" class="form-control" minlength="3" maxlength="70">
                                                                    <input type="hidden" name="idProveedorEditar" id="idProveedorEditar">
                                                                    <input type="hidden" name="idPersona" id="idPersona">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Razón Social</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-stamp"></i>
                                                                </div>
                                                                <div class="form-group form-primary">
                                                                    <input type="text" class="form-control cuit" name="ecuitProveedor" id="ecuitProveedor" minlength="3" maxlength="30">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">CUIT</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-ui-email"></i>
                                                                </div>
                                                                <div class="form-group form-primary">
                                                                    <input type="email" class="form-control" name="eemailProveedor" id="eemailProveedor">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Email</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-money-bag"></i>
                                                                </div>
                                                                <div class="form-group form-primary form-static-label p-t-5">
                                                                    <select class="form-control" name="eivaProveedor">
                                                                        <option id="eivaProveedor" value="">Seleccione el iva</option>
                                                                        <?php
                                                                            $listarIva = new ControladorProveedores();
                                                                            $listarIva -> ctrListarIva();
                                                                        ?>
                                                                    </select>
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">IVA</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-cart-alt"></i>
                                                                </div>
                                                                <div class="form-group form-primary form-static-label p-t-5">
                                                                    <select class="form-control" name="erubroProveedor">
                                                                        <option id="erubroProveedor" value="">Seleccione el rubro</option>
                                                                        <?php
                                                                            $listarRubros = new ControladorProveedores();
                                                                            $listarRubros -> ctrListarRubros();
                                                                        ?>
                                                                    </select>
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Rubro</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-ui-cell-phone"></i>
                                                                </div>
                                                                <div class="form-group form-primary">
                                                                    <input type="text" class="form-control" name="ecodAreaTelefonoProveedor" id="ecodAreaTelefonoProveedor" maxlength="4" minlength="3">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Código de area</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-ui-cell-phone"></i>
                                                                </div>
                                                                <div class="form-group form-primary">
                                                                    <input type="text" class="form-control" name="enumeroTeléfonoProveedor" id="enumeroTeléfonoProveedor" maxlength="8">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Teléfono</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                <h3> Domicilio </h3>
                                                <fieldset>
                                                   <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-address-book"></i>
                                                                </div>
                                                                <div class="form-group form-primary">
                                                                    <input type="text" class="form-control" name="ecalleProveedor" id="ecalleProveedor">
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
                                                                    <input type="text" class="form-control" name="enumCalleProveedor" id="enumCalleProveedor" maxlength="4">
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
                                                                    <input type="text" class="form-control" name="episoProveedor" id="episoProveedor" maxlength="2" >
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
                                                                    <input type="text" class="form-control" name="edeptoProveedor" id="edeptoProveedor" maxlength="2" >
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
                                                                     <input type="text" class="form-control autocomplete" name="elocalidadProveedor" id="elocalidadProveedor" onkeyup="aLocalidad('Editar');">
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
                                                                    <input type="text" class="form-control autocomplete" name="ebarrioProveedor" id="ebarrioProveedor" onkeyup="aBarrio('Editar');" >
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
                                                                    <input type="text" class="form-control" name="ecodPostalProveedor" id="ecodPostalProveedor" maxlength="4" minlength="3">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Código postal</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                <h3> Referente </h3>
                                                <fieldset>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                   <i class="icofont icofont-briefcase-alt-2"></i>
                                                                </div>
                                                                <div class="form-group form-primary">
                                                                    <input type="text" name="enombreRefProveedor" id="enombreRefProveedor" class="form-control" minlength="3" maxlength="20">
                                                                    <input type="hidden" name="idPerRef" id="idPerRef">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Nombre</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-stamp"></i>
                                                                </div>
                                                                <div class="form-group form-primary">
                                                                    <input type="text" class="form-control" name="eapellidoRefProveedor" id="eapellidoRefProveedor" minlength="3" maxlength="30">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Apellido</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-ui-email"></i>
                                                                </div>
                                                                <div class="form-group form-primary">
                                                                    <input type="email" class="form-control" name="eemailRefProveedor" id="eemailRefProveedor">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Email</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-ui-cell-phone"></i>
                                                                </div>
                                                                <div class="form-group form-primary">
                                                                    <input type="text" class="form-control" name="ecodArRefProveedor" id="ecodArRefProveedor" maxlength="4" minlength="3">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Código de area</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-ui-cell-phone"></i>
                                                                </div>
                                                                <div class="form-group form-primary">
                                                                    <input type="text" class="form-control" name="enumTelRefProveedor" id="enumTelRefProveedor" maxlength="9">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Teléfono</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </form>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Salir</button>
                </div>
            </div>
        </div>
    </div>



<script type="text/javascript" src="vistas/js/proveedores.js"></script>
