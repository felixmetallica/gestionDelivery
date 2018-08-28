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
                        <h4 class="m-b-10">Administración de Clientes</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="inicio">
                                <i class="ti-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#!">Clientes</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
<!--=====================================
            LISTADO CLIENTE
======================================-->

    <div class="pcoded-inner-content" id="listadoClientes">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h5 class="card-header-text p-t-15">Listado de clientes</h5>
                                        </div>
                                        <div class="col-lg-6 text-right">
                                            <a href="extensiones/tcpdf/pdf/reporte-clientes.php" target="_blank"><img class="img-40" src="vistas/img/plantilla/pdf.png"></a>
                                            <a href="vistas/modulos/reportes.php?reporte=reporteClientes"><img class="img-40" src="vistas/img/plantilla/xls.png"></a>
                                            <button class="btn waves-effect waves-light btn-primary" data-toggle="modal" data-target="#modalAgregarCliente"><i class="icofont icofont-plus"></i>Nuevo cliente</button>
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
                                                  <th style="text-align: center;">Domicilio</th>
                                                  <th style="text-align: center;">Pedidos</th>
                                                  <th style="text-align: center;">Teléfono</th>
                                                  <th style="text-align: center;">Activo</th>
                                                  <th style="text-align: center;">Acciones</th>
                                              </thead>
                                              <tbody>
                                                <?php
                                                    
                                                    $item = null;
                                                    $valor = null;
                                                    $cliente = ControladorClientes::ctrMostrarClientes($item, $valor);

                                                    foreach ($cliente as $key => $value) {

                                                        if ($value["Piso"] == "") {
                                                            
                                                            $piso =  "";
                                                        
                                                        } else {

                                                             $piso =  "Piso ".$value["Piso"];
                                                        }

                                                        if ($value["Dpto"] == "") {
                                                            
                                                            $dpto =  "";
                                                        
                                                        } else {

                                                             $dpto =  "Dpto ".$value["Dpto"];
                                                        }

                                                        echo '<tr>
                                                              <td class="text-center">'.($key+1).'</td>
                                                              <td class="text-left">'.$value["Nombre"].'</td>
                                                              <td class="text-left">'.$value["Apellido"].'</td>
                                                              <td class="text-left">'.$value["Calle"].' '. $value["Nro"].' '. $piso.' '.$dpto.'</td>
                                                              <td class="text-center">'.$value["Compras"].'</td>
                                                              <td class="text-center">('.$value["Prefijo"].')-'.$value["NroTelefono"].'</td>';
                                                              
                                                           if($value["Activo"] =="S"){

                                                               echo '<td style="text-align: center;"><button  class="btn btn-success waves-effect waves-ligh btnActivarCliente" idCliente="'.$value["ClienteID"].'" nombre="'.$value["Nombre"].'" apellido="'.$value["Apellido"].'" valor="'.$value["Activo"].'">Si</button></td>';

                                                            } else {

                                                                echo '<td style="text-align: center;"><button  class="btn btn-danger waves-effect waves-ligh btnActivarCliente" idCliente="'.$value["ClienteID"].'" nombre="'.$value["Nombre"].'" apellido="'.$value["Apellido"].'" valor="'.$value["Activo"].'">No</button></td>';

                                                            }

                                                           echo '<td style="text-align: center;">
                                                                    <div class="btn-group">
                                                                        <button class="btn btn-warning waves-effect waves-ligh btnEditarCliente" data-toggle="modal" data-target="#modalEditarCliente" idCliente="'.$value["ClienteID"].'" idPersona="'.$value["PersonaID"].'"><i class="icofont icofont-ui-edit"></i></button></div>
                                                                    <div class="btn-group">
                                                                        <button class="btn btn-danger waves-effect waves-ligh btnEliminarCliente" idCliente='.$value["ClienteID"].' NombreCliente ='.$value["Nombre"].' ApellidoCliente='.$value["Nombre"].'><i class="icofont icofont-ui-delete"></i></button>
                                                                    </div>
                                                                    <div class="btn-group">
                                                                        <button class="btn btn-success waves-effect waves-ligh btnDetalleCliente" idCliente="'.$value["ClienteID"].'" idPersona="'.$value["PersonaID"].'"><i class="icofont icofont-eye-alt"></i></button>
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

<!--=====================================
            DETALLE CLIENTE
======================================-->

    <div class="pcoded-inner-content" id="detallesCliente" style="display: none;">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-xl-3 col-lg-4">
                            <div class="card faq-left">
                                <div class="social-profile">
                                    <img class="img-fluid" id="imagenDetalle" src="vistas/assets/images/social/profile.jpg" alt="">
                                </div>
                                <div class="card-block">
                                    <h4 class="f-18 f-normal m-b-10 txt-primary" id="detalleNombreApellido"></h4>
                                    <ul>
                                        <li class="faq-contact-card" id="detalleTelefonoClienteP"></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-9 col-lg-8">
                            <div class="tab-content">
                                <div class="tab-pane active" id="personal" role="tabpanel">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <h5 class="card-header-text p-t-15" id="tituloDetalleCliente"></h5>
                                                </div>
                                                <div class="col-lg-6 text-right">
                                                    <button class="btn btn-mat waves-effect waves-light btn-primary" onclick="volveraListas();"><i class="icofont icofont-simple-left"></i>Volver</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-block">
                                            <div class="view-info">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="general-info">
                                                            <div class="row">
                                                                <div class="col-lg-12 col-xl-6">
                                                                    <table class="table m-0">
                                                                        <tbody>
                                                                            <tr>
                                                                                <th scope="row">Nombre</th>
                                                                                <td id="detalleNombreCliente"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Calle</th>
                                                                                <td id="detalleCalleCliente"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Piso</th>
                                                                                <td id="detallePisoCliente"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Localidad</th>
                                                                                <td id="detalleLocalidadCliente"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Telefono</th>
                                                                                <td id="detalleTelefonoCliente"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Fecha de alta</th>
                                                                                <td id="detalleFechaAltaCliente"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Cantidad de pedidos</th>
                                                                                <td id="detallePedidoCliente"></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="col-lg-12 col-xl-6">
                                                                    <table class="table">
                                                                        <tbody>
                                                                            <tr>
                                                                                <th scope="row">Apellido</th>
                                                                                <td id="detalleApellidoCliente"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Número de calle</th>
                                                                                <td id="detalleNumCalleCliente"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Departamento</th>
                                                                                <td id="detalleDepartamentoCliente"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Barrio</th>
                                                                                <td id="detalleBarrioCliente"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Estado actual</th>
                                                                                <td id="detalleEstadoCliente"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Comentario</th>
                                                                                <td id="detalleComentarioCliente"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Ultimo pedido</th>
                                                                                <td id="detalleUltimoPedido"></td>
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
            AGREGAR CLIENTE
======================================-->
    
    <div class="modal fade" id="modalAgregarCliente" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h4 class="modal-title">Nuevo cliente</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="formRegistroCliente" method="post" class="form-material">
                        <h6>Datos personales</h6>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                   <i class="icofont icofont-user-alt-7"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" name="nombreCliente" id="nombreCliente" class="form-control" minlength="3" maxlength="20" required="">
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
                                    <input type="text" class="form-control" name="apellidoCliente" id="apellidoCliente" minlength="3" maxlength="30" required="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Apellido</label>
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
                                    <input type="text" class="form-control" name="calleCliente" id="calleCliente" required="">
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
                                    <input type="text" class="form-control" name="numCalleCliente" id="numCalleCliente" maxlength="4" required="">
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
                                    <input type="text" class="form-control" name="pisoCliente" id="pisoCliente" maxlength="2" required="">
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
                                    <input type="text" class="form-control" name="deptoCliente" id="deptoCliente" maxlength="2" required="">
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
                                     <input type="text" class="form-control" name="localidadCliente" id="localidadCliente" onkeyup="aLocalidad('Nuevo');">
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
                                    <input type="text" class="form-control" name="barrioCliente" id="barrioCliente" onkeyup="aBarrio('Nuevo');" required="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Barrio</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-ui-cell-phone"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="codAreaTelefono" id="codAreaTelefono" maxlength="4" minlength="3" required="">
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
                                    <input type="text" class="form-control" name="numeroTeléfono" id="numeroTeléfono" maxlength="9" required="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Teléfono</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-comment"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <textarea id="comentarioCliente" name="comentarioCliente" class="form-control"></textarea>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Comentario</label>
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
                    $nuevoCliente = new ControladorClientes();
                    $nuevoCliente -> ctrRegistroCliente();
                ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!--=====================================
            EDITAR CLIENTE
======================================-->
    
    <div class="modal fade" id="modalEditarCliente" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h4 class="modal-title">Editar cliente</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="formRegistroCliente" method="post" class="form-material">
                        <h6>Datos personales</h6>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                   <i class="icofont icofont-user-alt-7"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" name="eNombreCliente" id="eNombreCliente" class="form-control" minlength="3" maxlength="20" required="">
                                    <input type="hidden" name="idCliente" id="idCliente" value="">
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
                                    <input type="text" class="form-control" name="eApellidoCliente" id="eApellidoCliente" minlength="3" maxlength="30" required="">
                                    <input type="hidden" name="idPersona" id="idPersona" value="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Apellido</label>
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
                                    <input type="text" class="form-control" name="eCalleCliente" id="eCalleCliente" required="">
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
                                    <input type="text" class="form-control" name="eNumCalleCliente" id="eNumCalleCliente" maxlength="4" required="">
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
                                    <input type="text" class="form-control" name="ePisoCliente" id="ePisoCliente" maxlength="2">
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
                                    <input type="text" class="form-control" name="eDeptoCliente" id="eDeptoCliente" maxlength="2" >
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
                                     <input type="text" class="form-control" name="eLocalidadCliente" id="eLocalidadCliente" onkeyup="aLocalidad('Editar');">
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
                                    <input type="text" class="form-control" name="eBarrioCliente" id="eBarrioCliente" onkeyup="aBarrio('Editar');" required="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Barrio</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-ui-cell-phone"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="eCodAreaCliente" id="eCodAreaCliente" maxlength="4" minlength="3" required="">
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
                                    <input type="text" class="form-control" name="eNumeroTelefonoCliente" id="eNumeroTelefonoCliente" maxlength="9" required="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Teléfono</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-comment"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <textarea id="eComentarioCliente" name="eComentarioCliente" class="form-control"></textarea>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Comentario</label>
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
                    $editarCliente = new ControladorClientes();
                    $editarCliente -> ctrEditarCliente();
                ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript" src="vistas/js/clientes.js"></script>