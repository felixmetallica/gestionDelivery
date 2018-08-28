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
                        <h4 class="m-b-10">Administración de Empleados</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="inicio">
                                <i class="ti-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#!">Empleados</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

<!--============================================
        LISTADO DE EMPLEADOS
=============================================-->    

    <div class="pcoded-inner-content" id="listadoEmpleados">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            
                            <div class="card">

                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h5 class="card-header-text p-t-15">Listado de empleados</h5>
                                        </div>
                                        <div class="col-lg-6 text-right">
                                            <a href="extensiones/tcpdf/pdf/reporte-empleados.php" target="_blank"><img class="img-40" src="vistas/img/plantilla/pdf.png"></a>
                                            <a href="vistas/modulos/reportes.php?reporte=reporteEmpleados"><img class="img-40" src="vistas/img/plantilla/xls.png"></a>
                                            <button class="btn btn-mat waves-effect waves-light btn-primary" data-toggle="modal" data-target="#modalAgregarEmpleado"><i class="icofont icofont-plus m-r-5"></i>nuevo empleado</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="md-card-block">
                                        <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
                                            <thead>
                                                <th style="text-align: center;">#</th>
                                                <th style="text-align: center;">Nombre</th>
                                                <th style="text-align: center;">Apellido</th>
                                                <th style="text-align: center;">Teléfono</th>
                                                <th style="text-align: center;">CUIL</th>
                                                <th style="text-align: center;">Activo</th>
                                                <th style="text-align: center;">Acciones</th>
                                            </thead>
                                            <tbody>
                                                <?php

                                                    $item = null;

                                                    $valor = null;

                                                    $listar = ControladorEmpleados::ctrMostrarEmpleados($item, $valor);


                                                        foreach ($listar as $key => $value) {

                                                            echo '<tr>
                                                                    <td style="text-align: center;">'.($key+1).'</td>
                                                                    <td style="text-align: center;">'.$value["Nombre"].'</td>
                                                                    <td style="text-align: center;">'.$value["Apellido"].'</td>
                                                                    <td style="text-align: center;">'.$value["Prefijo"].'-'.$value["NroTelefono"].'</td>
                                                                    <td style="text-align: center;">'.$value["CUIL"].'</td>';

                                                            if($value["Activo"] =="S"){

                                                                echo '<td style="text-align: center;"><button  class="btn btn-success waves-effect waves-ligh btnDesactivarEmpleado" idEmpleado="'.$value["EmpleadoID"].'" nombreEmpleado="'.$value["Nombre"].'" apellidoEmpleado="'.$value["Apellido"].'" valor="'.$value["Activo"].'">Si</button></td>';

                                                            } else {

                                                                echo '<td style="text-align: center;"><button  class="btn btn-danger waves-effect waves-ligh btnDesactivarEmpleado" idEmpleado="'.$value["EmpleadoID"].'" nombreEmpleado="'.$value["Nombre"].'" apellidoEmpleado="'.$value["Apellido"].'" valor="'.$value["Activo"].'">No</button></td>';
                                                            }

                                                                echo '<td style="text-align: center;">
                                                                        <div class="btn-group">
                                                                            <button class="btn btn-warning waves-effect waves-ligh btnEditarEmpleado" data-toggle="modal" data-target="#modalEditarEmpleado" onclick="editarEmpleado(\''.$value["EmpleadoID"].'\', \''.$value["CategoriasID"].'\' , \''.$value["PuestoID"].'\');" ><i class="icofont icofont-ui-edit"></i></button>
                                                                        </div>
                                                                        <div class="btn-group">
                                                                            <button class="btn btn-danger waves-effect waves-ligh btnEliminarEmpleado"  onclick="eliminarEmpleado(\''.$value["EmpleadoID"].'\', \''.$value["PersonaID"].'\', \''.$value["Nombre"].'\', \''.$value["Apellido"].'\', \''.$value["UsuarioID"].'\', \''.$value["Imagen"].'\', \''.$value["NombreUsuario"].'\', \''.$value["ImagenEmpleado"].'\')"><i class="icofont icofont-ui-delete"></i></button>
                                                                        </div>
                                                                        <div class="btn-group">
                                                                            <button class="btn btn-success waves-effect waves-ligh" onclick="detalleEmpleado(\''.$value["EmpleadoID"].'\')"><i class="icofont icofont-eye-alt"></i></button>
                                                                        </div>';

                                                                if (empty($value["UsuarioID"])) {

                                                                    echo ' <div class="btn-group">
                                                                            <button class="btn waves-effect waves-light btn-primary btnCrearUsuario" data-toggle="modal" data-target="#crearUsuario" idEmpleadoCrearUsuario="'.$value["EmpleadoID"].'" idPersonaCrearUsuario="'.$value["PersonaID"].'" nombreCuser="'.$value["Nombre"].'" apeCuser="'.$value["Apellido"].'"><i class="icofont icofont-ui-user"></i></button>
                                                                            </div>';
                                                                }
                                                                echo '</td>
                                                                </tr> ';

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
        DETALLE DE EMPLEADO
=============================================-->   

    <div class="pcoded-inner-content" id="detalleEmpleado" style="display: none;">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-xl-3 col-lg-4">
                            <div class="card faq-left">
                                <div class="social-profile">
                                    <img class="img-fluid previsualizar" id="imagenDetalle" src="vistas/img/usuarios/default/User_ring.png" alt="" width="400px">
                                </div>
                                <div class="card-block">
                                    <form role="form" id="formFotoEmpleado" method="post" enctype="multipart/form-data">
                                        <div class="EditfotoEmpleado" style="padding-left: 2px;">
                                            <input type="hidden" name="empleadoIdFoto" id="empleadoIdFoto">
                                            <input type="hidden" name="fotoActual" id="fotoActual">
                                            

                                            <div class="md-group-add-on form-group form-primary material-group-sm">
                                                <span class="md-add-on-file">
                                                    <button class="btn btn-primary waves-effect waves-light">Seleccionar</button>
                                                </span>
                                                <div class="md-input-file">
                                                    <input type="file" class="nuevaFotoEmpleado" name="nuevaFotoEmpleado">
                                                    <input type="text" class="md-form-control md-form-file form-control foto" placeholder="No se elijio archivo">
                                                    <span class="form-bar">Peso máximo de la foto 2MB</span>
                                                </div>
                                            </div>

                                            <div class="faq-profile-btn">
                                                <button type="button" id="edit-cancel" class="btn btn-primary waves-effect waves-light">Cancelar</button>
                                                <button type="submit" class="btn btn-success waves-effect waves-light">Aceptar</button>
                                                <?php
                                                    $suboFoto = new ControladorEmpleados();
                                                    $suboFoto -> ctrFotoEmpleado();
                                                ?>
                                            </div> 
                                        </div>
                                    </form>
                                    <h4 class="f-18 f-normal m-b-10 txt-primary" id="detalleNombreApellido"></h4>
                                    <h5 class="f-14" id="detallePuestoD"></h5>
                                        <div class="text-right">
                                            <button id="edit-btn" type="button" class="btn btn-primary waves-effect waves-light f-right" ><i  class="icofont icofont-edit"></i></button>

                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-9 col-lg-8">
                            <div class="card product-detail-page">
                                <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active f-18 p-b-0" data-toggle="tab" href="#infoPersonal" role="tab">Informacion personal</a>
                                        <div class="slide"></div>
                                    </li>
                                    <li class="nav-item m-b-0">
                                        <a class="nav-link f-18 p-b-0" data-toggle="tab" href="#domicilio" role="tab">Domicilio</a>
                                        <div class="slide"></div>
                                    </li>
                                    <li class="nav-item m-b-0">
                                        <a class="nav-link f-18 p-b-0" data-toggle="tab" href="#infoLaboral" role="tab">Datos laborales</a>
                                        <div class="slide"></div>
                                    </li>
                                </ul>
                            </div>
                            <div class="card">
                                <div class="card-block">
                                    <!-- Tab panes -->
                                    <div class="tab-content bg-white">
                                        <div class="tab-pane active" id="infoPersonal" role="tabpanel">
                                            <div class="row">
                                                <div class="col-lg-12 col-xl-6">
                                                    <table class="table m-0">
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">Nombre</th>
                                                                <td id="detalleNombreEmpleado"></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">DNI</th>
                                                                <td id="detalleDNIEmpleado"></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Email</th>
                                                                <td id="detalleEmailD"></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Sexo</th>
                                                                <td id="detalleSexoEmpleado"></td>
                                                            </tr>
                                                        </tbody>
                                                   </table>
                                                </div>
                                                <div class="col-lg-12 col-xl-6">
                                                    <table class="table">
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">Apellido</th>
                                                                <td id="detalleApellidoEmpleado"></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Fecha de nacimiento</th>
                                                                <td id="detalleFechaNacimientoEmpleado"></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Teléfono</th>
                                                                <td id="detalleTelefonoD"></td>
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
                                                                            <td id="detalleCalleEmpleado"></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Piso</th>
                                                                            <td id="detallePisoEmpleado"></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Localidad</th>
                                                                            <td id="detalleLocalidadEmpleado"></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Código Postal</th>
                                                                            <td id="detalleCodPostalEmpleado"></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="col-lg-12 col-xl-6">
                                                                <table class="table">
                                                                    <tbody>
                                                                        <tr>
                                                                            <th scope="row">Número</th>
                                                                            <td id="detalleNumeroEmpleado"></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Departamento</th>
                                                                            <td id="detalleDeptoEmpleado"></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Barrio</th>
                                                                            <td id="detalleBarrioEmpleado"></td>
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
                                        <div class="tab-pane" id="infoLaboral" role="tabpanel">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="general-info">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-xl-6">
                                                                <table class="table m-0">
                                                                    <tbody>
                                                                        <tr>
                                                                            <th scope="row">Legajo</th>
                                                                            <td id="detalleLegajoEmpleado"></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Puesto</th>
                                                                            <td id="detallePuestoEmpleado"></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Sueldo básico</th>
                                                                            <td id="detalleSueldoEmpleado"></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Estado</th>
                                                                            <td id="detalleEstadoEmpleado"></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="col-lg-12 col-xl-6">
                                                                <table class="table">
                                                                    <tbody>
                                                                        <tr>
                                                                            <th scope="row">Fecha de Ingreso</th>
                                                                            <td id="detalleFechaIngresoEmpleado"></td>
                                                                        </tr>
                                                                         <tr>
                                                                            <th scope="row">Categoría</th>
                                                                            <td id="detalleCategoriaEmpleado"></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">CUIL</th>
                                                                            <td id="detalleCuilEmpleado"></td>
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
        AGREGAR EMPLEADO
======================================-->

    <div class="modal fade" id="modalAgregarEmpleado" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h4 class="modal-title">Nuevo empleado</h4>
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
                                            <form class="form-material" id="registrarEmpleado" method="post">
                                                <h3> Datos personales </h3>
                                                <fieldset>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                   <i class="icofont icofont-user-alt-7"></i>
                                                                </div>
                                                                <div class="form-group form-primary">
                                                                    <input type="text" name="nombreEmpleado" id="nombreEmpleado" class="form-control" minlength="3" maxlength="20" required="">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Nombre</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-user-alt-7"></i>
                                                                </div>
                                                                <div class="form-group form-primary">
                                                                    <input type="text" class="form-control" name="apellidoEmpleado" id="apellidoEmpleado" minlength="3" maxlength="30" required="">
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
                                                                    <i class="icofont icofont-gavel"></i>
                                                                </div>
                                                                <div class="form-group form-primary">
                                                                    <input type="text" class="form-control" name="dniEmpleado" id="dniEmpleado" minlength="7" maxlength="8" required="">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Dni</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-ui-email"></i>
                                                                </div>
                                                                <div class="form-group form-primary">
                                                                    <input type="email" class="form-control" name="emailEmpleado" id="emailEmpleado" required="">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Email</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm ">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-calendar"></i>
                                                                </div>
                                                                <div class="form-group form-primary form-static-label">
                                                                    <input type="text" class="form-control date" name="fechaEmpleado" id="fechaEmpleado" data-mask="99/99/9999" required="" />
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Fecha de nacimiento</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-users-alt-2"></i>
                                                                </div>
                                                                <div class="form-group form-primary form-static-label p-t-5">
                                                                    <select class="form-control" name="sexoEmpleado" id="sexoEmpleado">
                                                                        <option value="">Seleccione el sexo</option>
                                                                        <option value="M">Masculino</option>
                                                                        <option value="F">Femenino</option>
                                                                    </select>
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Sexo</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-ui-cell-phone"></i>
                                                                </div>
                                                                <div class="form-group form-primary">
                                                                    <input type="text" class="form-control" name="codAreaTelefonoEmpleado" id="codAreaTelefonoEmpleado" maxlength="4" minlength="3" required>
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Código de area</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-ui-cell-phone"></i>
                                                                </div>
                                                                <div class="form-group form-primary">
                                                                    <input type="text" class="form-control" name="numeroTeléfonoEmpleado" id="numeroTeléfonoEmpleado" maxlength="9" required>
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
                                                                    <input type="text" class="form-control" name="calleEmpleado" id="calleEmpleado" required>
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
                                                                    <input type="text" class="form-control" name="numCalleEmpleado" id="numCalleEmpleado" maxlength="4" required>
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
                                                                    <input type="text" class="form-control" name="pisoEmpleado" id="pisoEmpleado" maxlength="2" >
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
                                                                    <input type="text" class="form-control" name="deptoEmpleado" id="deptoEmpleado" maxlength="2" >
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
                                                                     <input type="text" class="form-control autocomplete" name="localidadEmpleado" id="localidadEmpleado" onkeyup="aLocalidad('Nuevo');" required>
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
                                                                    <input type="text" class="form-control autocomplete" name="barrioEmpleado" id="barrioEmpleado" onkeyup="aBarrio('Nuevo');" required>
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
                                                                    <input type="text" class="form-control" name="codPostalEmpleado" id="codPostalEmpleado" maxlength="4" minlength="3">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Código postal</label>
                                                                </div>
                                                            </div>
                                                        </div>                                                        
                                                    </div>
                                                </fieldset>
                                                <h3> Datos laborales </h3>
                                                <fieldset>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                   <i class="icofont icofont-archive"></i>
                                                                </div>
                                                                <div class="form-group form-primary form-static-label">
                                                                   <?php 

                                                                        $item = null;
                                                                        $valor = null;

                                                                        $empleado = ControladorEmpleados::ctrMostrarEmpleados($item, $valor);

                                                                        if (!$empleado) {
                                                                                
                                                                            echo '<input type="text" class="form-control" name="legajoEmpleado" id="legajoEmpleado" value="0001" readonly/>';

                                                                        } else {

                                                                            $legajotemp = $empleado[0]["Legajo"] + 1;
                                                                            $legajo = str_pad($legajotemp, 4, "0", STR_PAD_LEFT);
                                                                                
                                                                            echo '<input type="text" class="form-control" name="legajoEmpleado" id="legajoEmpleado" value="'.$legajo.'" readonly/>';
                                                                    
                                                                            }

                                                                    ?>
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">N° Legajo</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm ">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-calendar"></i>
                                                                </div>
                                                                <div class="form-group form-primary form-static-label">
                                                                    <input type="text" class="form-control date" name="fechaIngresoEmpleado" id="fechaIngresoEmpleado" data-mask="99/99/9999" required />
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Fecha de ingreso</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm ">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-worker"></i>
                                                                </div>
                                                                <div class="form-group form-primary form-static-label">
                                                                    <select class="form-control puestoEmpleado" name="puestoEmpleado" id="puestoEmpleado">
                                                                        <option value="" >Selecione el puesto</option>
                                                                        <?php
                                                                            $puestos = new ControladorEmpleados();
                                                                            $puestos -> ctrTraerPuestos();
                                                                        ?>
                                                                    </select>
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Puesto</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm ">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-worker"></i>
                                                                </div>
                                                                <div class="form-group form-primary form-static-label">
                                                                    <select class="form-control categoriaEmpleado" name="categoriaEmpleado" id="categoriaEmpleado">
                                                                        <option value="">Selecionar categoria</option>
                                                                        
                                                                    </select>
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Categoría</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-card"></i>
                                                                </div>
                                                                <div class="form-group form-primary">
                                                                    <input type="text" class="form-control cuil" name="cuilEmpleado" id="cuilEmpleado" minlength="13" maxlength="13" required />
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">CUIL</label>
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
        EDITAR EMPLEADO
======================================-->

    <div class="modal fade" id="modalEditarEmpleado" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h4 class="modal-title tituloEditoEmpleado">Editar empleado</h4>
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
                                            <form class="form-material" id="modificarEmpleado" method="post">
                                                <h3> Datos personales </h3>
                                                <fieldset>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                   <i class="icofont icofont-user-alt-7"></i>
                                                                </div>
                                                                <div class="form-group form-primary">
                                                                    <input type="text" name="enombreEmpleado" id="enombreEmpleado" class="form-control" minlength="3" maxlength="20" required="">
                                                                    <input type="hidden" id="eidEmpleado" name="eidEmpleado">
                                                                    <input type="hidden" id="eidPersona" name="eidPersona">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Nombre</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-user-alt-7"></i>
                                                                </div>
                                                                <div class="form-group form-primary">
                                                                    <input type="text" class="form-control" name="eapellidoEmpleado" id="eapellidoEmpleado" minlength="3" maxlength="30" required="">
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
                                                                    <i class="icofont icofont-gavel"></i>
                                                                </div>
                                                                <div class="form-group form-primary">
                                                                    <input type="text" class="form-control" name="edniEmpleado" id="edniEmpleado" minlength="7" maxlength="8" required="">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Dni</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-ui-email"></i>
                                                                </div>
                                                                <div class="form-group form-primary">
                                                                    <input type="email" class="form-control" name="eEmailEmpleado" id="eEmailEmpleado" required="">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Email</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm ">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-calendar"></i>
                                                                </div>
                                                                <div class="form-group form-primary form-static-label">
                                                                    <input type="text" class="form-control date" name="efechaEmpleado" id="efechaEmpleado" data-mask="99/99/9999" required="" />
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Fecha de nacimiento</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-users-alt-2"></i>
                                                                </div>
                                                                <div class="form-group form-primary form-static-label p-t-5">
                                                                    <select class="form-control" name="esexoEmpleado">
                                                                        <option value="" id="esexoEmpleado"></option>
                                                                        <option value="M">Masculino</option>
                                                                        <option value="F">Femenino</option>
                                                                    </select>
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Sexo</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-ui-cell-phone"></i>
                                                                </div>
                                                                <div class="form-group form-primary">
                                                                    <input type="text" class="form-control" name="ecodAreaTelefonoEmpleado" id="ecodAreaTelefonoEmpleado" maxlength="4" minlength="3" required>
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Código de area</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-ui-cell-phone"></i>
                                                                </div>
                                                                <div class="form-group form-primary">
                                                                    <input type="text" class="form-control" name="enumeroTeléfonoEmpleado" id="enumeroTeléfonoEmpleado" maxlength="8" required>
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
                                                                    <input type="text" class="form-control" name="ecalleEmpleado" id="ecalleEmpleado" required>
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
                                                                    <input type="text" class="form-control" name="enumCalleEmpleado" id="enumCalleEmpleado" maxlength="4" required>
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
                                                                    <input type="text" class="form-control" name="episoEmpleado" id="episoEmpleado" maxlength="2" >
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
                                                                    <input type="text" class="form-control" name="edeptoEmpleado" id="edeptoEmpleado" maxlength="2" >
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
                                                                     <input type="text" class="form-control autocomplete" name="elocalidadEmpleado" id="elocalidadEmpleado" onkeyup="aLocalidad('Editar');" required>
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
                                                                    <input type="text" class="form-control autocomplete" name="ebarrioEmpleado" id="ebarrioEmpleado" onkeyup="aBarrio('Editar');" required>
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
                                                                    <input type="text" class="form-control" name="ecodPostalEmpleado" id="ecodPostalEmpleado" maxlength="4" minlength="3">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Código postal</label>
                                                                </div>
                                                            </div>
                                                        </div>                                                        
                                                    </div>
                                                </fieldset>
                                                <h3> Datos laborales </h3>
                                                <fieldset>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                   <i class="icofont icofont-archive"></i>
                                                                </div>
                                                                <div class="form-group form-primary form-static-label">
                                                                    <input type="text" class="form-control" name="elegajoEmpleado" id="elegajoEmpleado" readonly/>
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">N° Legajo</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm ">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-calendar"></i>
                                                                </div>
                                                                <div class="form-group form-primary form-static-label">
                                                                    <input type="text" class="form-control date" name="efechaIngresoEmpleado" id="efechaIngresoEmpleado" data-mask="99/99/9999" required />
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Fecha de ingreso</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm ">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-worker"></i>
                                                                </div>
                                                                <div class="form-group form-primary form-static-label">
                                                                    <select class="form-control epuestoEmpleado" name="epuestoEmpleado">
                                                                        <option value="" id="epuestoEmpleado"></option>
                                                                        <?php
                                                                            $puestos = new ControladorEmpleados();
                                                                            $puestos -> ctrTraerPuestos();
                                                                        ?>
                                                                    </select>
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Puesto</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm ">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-worker"></i>
                                                                </div>
                                                                <div class="form-group form-primary form-static-label">
                                                                    <select class="form-control ecategoriaEmpleado" name="ecategoriaEmpleado">
                                                                         <option value="" id="ecategoriaEmpleado"></option>
                                                                        
                                                                    </select>
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Categoría</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="material-group material-group-primary material-group-sm">
                                                                <div class="material-addone">
                                                                    <i class="icofont icofont-card"></i>
                                                                </div>
                                                                <div class="form-group form-primary form-static-label">
                                                                    <input type="text" class="form-control cuil" name="ecuilEmpleado" id="ecuilEmpleado" minlength="13" maxlength="13" required />
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">CUIL</label>
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
        AGREGAR USUARIO
======================================-->

    <div class="modal fade" id="crearUsuario" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h4 class="modal-title" id="tituloCrear"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="formCrearUsuario" method="post" class="form-material" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-ui-user"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="userUsuario" id="userUsuario" required="">
                                    <input type="hidden" id="iEmpleado" name="iEmpleado">
                                    <input type="hidden" id="iPersona" name="iPersona">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Usuario</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-ui-unlock"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="password" class="form-control"  name="passUsuario" id="passUsuario" title="Minimo 8 caracteres. Debe contener al menos
                            un número, una minúscula y una mayúscula" data-placement="right" required="" autocomplete="new-password" #password>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Contraseña</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                       <div class="col-sm-12">
                            <div class="material-group material-group-primary material-group-sm ">
                                <div class="material-addone">
                                    <i class="icofont icofont-users-alt-1"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <select class="form-control" name="rolUsuario" id="rolUsuario">
                                        <option value="">Selecionar rol</option>
                                        <?php
                                            $item = null;
                                            $valor = null;

                                            $roles = ControladorConfiguracion::ctrMostrarRoles($item, $valor);

                                            foreach ($roles as $row => $item){

                                                echo '<option value="'.$item["RolesID"].'">'.$item["Nombre"].'</option>';
                                            }
                                        ?>
                                    </select>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Rol</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="md-group-add-on form-group form-primary material-group-sm">
                                <span class="md-add-on-file">
                                    <button class="btn btn-primary waves-effect waves-light">Seleccionar archivo</button>
                                </span>
                                <div class="md-input-file">
                                    <input type="file" class="nuevaFoto" name="nuevaFoto">
                                    <input type="text" class="md-form-control md-form-file form-control foto" placeholder="No se elijio archivo">
                                    <span class="form-bar">Peso máximo de la foto 2MB</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                             <img src="vistas/img/usuarios/default/User_ring.png" class="img-thumbnail previsualizar" width="100px">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light ">Aceptar</button>
                </div>
                <?php
                    $crearUsuario = new ControladorEmpleados();
                    $crearUsuario -> ctrCrearUsuario();
                ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript" src="vistas/js/empleados.js"></script>