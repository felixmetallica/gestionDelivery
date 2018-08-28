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
                        <h4 class="m-b-10">Administración de Compras</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="inicio">
                                <i class="ti-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#!">Compras</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
<!--=====================================
        LISTADO COMPRAS
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
                                            <h5 class="card-header-text p-t-15">Listado de compras</h5>
                                        </div>
                                        <div class="col-lg-6 text-right">
                                            <button type="button" class="btn waves-effect waves-light btn-primary" id="daterange-btn3">
                                                <span><i class="fa fa-calendar"></i> Rango de fecha</span>
                                            </button>
                                        </div>
                                    </div>   
                                </div>
                                <div class="card-block">
                                    <div class="md-card-block">  
                                        <table class="table table-bordered table-striped dt-responsive nowrap tablas" width="100%">
                                            <thead>
                                                <th style="text-align: center; width: 10px">#</th>
                                                <th style="text-align: center;">Nro Orden</th>
                                                <th style="text-align: center;">Proveedor</th>
                                                <th style="text-align: center;">Usuario</th>
                                                <th style="text-align: center;">Fecha</th>
                                                <th style="text-align: center;">Estado</th>
                                                <th style="text-align: center;">Total</th>
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

                                                    $respuesta = ControladorCompras::ctrRangoFechaCompras($fechaInicial, $fechaFinal);

                                                    foreach ($respuesta as $key => $value) {

                                                        $numbOrden1 = substr($value["NroCompra"], 0, -8);
                                                        $numbOrden2 = substr($value["NroCompra"], -8);

                                                        echo '<tr>
                                                                    <td class="text-center">'.($key + 1).'</td>
                                                                    <td class="text-center">'.$numbOrden1.'-'.$numbOrden2.'</td>
                                                                    <td class="text-center">'.$value["RazonSocial"].'</td>
                                                                    <td class="text-center">'.$value["Nombre"].' '.$value["Apellido"].'</td>
                                                                    <td class="text-center">'.$value["fechaFormateada"].'</td>';
                                                                    
                                                                    if($value["Estado"] =="R"){

                                                                        echo '<td style="text-align: center;"><button class="btn btn-mini btn-success waves-effect waves-ligh">Registrada</button></td>';

                                                                    } else {

                                                                        echo '<td style="text-align: center;"><button class="btn btn-mini btn-danger waves-effect waves-ligh">Anulada</button></td>';

                                                                    }    


                                                                    echo '<td class="text-center">$'.number_format($value["Total"],2).'</td>
                                                                    <td style="white-space: nowrap;">
                                                                        <div class="btn-group">
                                                                        <button class="btn btn-primary waves-effect waves-ligh btnImprimirOrden" idCompra="'.$value["CompraID"].'" OrdenCompra="'.$value["NroCompra"].'"><i class="icofont icofont-printer"></i></button>
                                                                        </div>';
                                                                        
                                                                        if ($value["Estado"] == "R") {
                                                                            
                                                                            if ($value["Nota"] == "N") {
                                                                                
                                                                                 echo ' <div class="btn-group">
                                                                                            <button class="btn btn-warning waves-effect waves-ligh btnEditarCompra" idCompra="'.$value["CompraID"].'"><i class="icofont icofont-ui-edit"></i></button>
                                                                                        </div> ';
                                                                            
                                                                            } else {

                                                                                echo ' <div class="btn-group">
                                                                                            <button class="btn btn-danger waves-effect waves-ligh btnAnularCompra" idCompra="'.$value["CompraID"].'" orden="'.$value["NroCompra"].'" userId="'.$_SESSION["idUser"].'" data-toggle="modal" data-target="#modalAnularCompra"><i class="icofont icofont-close"></i></button>
                                                                                       </div>';
                                                                            }

                                                                        }else{

                                                                           echo '';

                                                                        }

                                                                     echo ' <div class="btn-group">
                                                                        <button class="btn btn-success waves-effect waves-ligh btnDetalleCompra" idCompra="'.$value["CompraID"].'" idProveedor="'.$value["ProveedorID"].'" idUsuarioCancela="'.$value["UsuarioAnulaID"].'" data-toggle="modal" data-target="#modalDetalleDeCompra" ><i class="icofont icofont-eye-alt"></i></button>
                                                                        </div></td>
                                                                </tr>';

                                                    }
                                                  
                                                ?>
                                            </tbody>
                                        </table>
                                        

                                        <div class="text-right p-t-15">
                                            <a href="crear-compra">
                                                <button class="btn waves-effect waves-light btn-primary"><i class="icofont icofont-plus m-r-5"></i>Nueva compra</button>
                                            </a>
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
        ANULAR ORDEN DE COMPRA
======================================-->

    <div class="modal fade" id="modalAnularCompra" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h5 class="modal-title ventaTituloAnular"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="formAnularFactura" method="post" class="form-material">
                         <input type="hidden" name="idCompraA" id="idCompraA">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                   <i class="icofont icofont-user"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <input type="text" class="form-control md-static form-control-sm" id="nombreUsuarioAnula" value="<?php echo $_SESSION["Nombre"].' '.$_SESSION["Apellido"]; ?>" readonly>
                                    <input type="hidden" name="idUsuarioAnula" value="<?php echo $_SESSION["idUser"]; ?>">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Usuario</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-comment"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <textarea id="motivoAnula" name="motivoAnula" class="form-control"></textarea>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Motivo de anulación</label>
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
                    $anularComra = new ControladorCompras();
                    $anularComra -> ctrAnularCompra();
                ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!--=====================================
        DETALLE DE COMPRA
======================================-->

    <div class="modal fade" id="modalDetalleDeCompra" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h5 class="modal-title tituloDetalleCompra"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row invoive-info">
                        <div class="col-md-6 col-sm-8 invoice-client-info">
                            <h6 class="text-dark f-w-100">Informacion del proveedor :</h6>
                            <h6 class="m-0" id="nombreProveedorCompraDetalle"></h6>
                            <p class="m-0 m-t-10" id="direccionProveedorDetalle"></p>
                            <p class="m-0" id="telefonoProveedorDetalle"></p>
                            <p class="m-0" id="mailProveedorDetalle"></p>
                            <hr>
                            <img src="vistas/img/proveedores/proveedores.jpeg" alt="proveedor" style="width: 100%;">
                        </div>
                        <div class="col-md-6 col-sm-8">
                            <h6 class="text-dark">Información de la compra :</h6>
                            <table class="table table-responsive invoice-table invoice-order table-borderless">
                                <tbody>
                                    <tr>
                                        <th>Fecha :</th>
                                        <td id="fechaDetalleCompra"></td>
                                    </tr>
                                    <tr>
                                        <th>N° Orden : </th>
                                        <td id="ordenDetalleCompra"></td>
                                    </tr>
                                    <tr>
                                        <th>Usuario :</th>
                                        <td id="usuarioCompraDetalle"></td>
                                    </tr>
                                    <tr>
                                        <th>Estado :</th>
                                        <td id="estadoCompraDetalle"></td>
                                    </tr>
                                    <tr>
                                        <th id="tituloMotivoDetalleVenta"></th>
                                        <td id="motivoDetalleVenta"></td>
                                    </tr>
                                    <tr>
                                        <th id="tituloUsuarioAnulaDetalleVenta"></th>
                                        <td id="usuarioAnulaDetalleVenta"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr>
                            <h6 class="m-b-20 text-dark">Detalle de compra</h6>
                            <div class="listadoProductosDetalle">
                                
                            </div>
                            <hr>
                            
                            <h6 class="text-uppercase text-primary"> 
                                <span id="impuestoDetalleCompra"></span>                            
                            </h6>
                            <h6 class="text-uppercase text-primary">Total compra :
                                <span id="totalCompraDetalle"></span>
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Salir</button>
                </div>
            </div>
        </div>
    </div>
    
<!-- bootstrap range picker -->
<script type="text/javascript" src="vistas/bower_components/bootstrap-daterangepicker/js/daterangepicker.js"></script>
<script type="text/javascript" src="vistas/bower_components/bootstrap-daterangepicker/js/moment.js"></script>
<script type="text/javascript" src="vistas/js/compras.js"></script>