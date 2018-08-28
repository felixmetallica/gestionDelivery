<div class="pcoded-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h4 class="m-b-10">Administración de Ventas</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="inicio">
                                <i class="ti-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#!">Ventas</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
<!--=====================================
        LISTADO VENTAS
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
                                            <h5 class="card-header-text p-t-15">Listado de ventas</h5>
                                        </div>
                                        <div class="col-lg-6 text-right">
                                            <button type="button" class="btn waves-effect waves-light btn-primary" id="daterange-btn">
                                                <span><i class="fa fa-calendar"></i> Rango de fecha</span>
                                            </button>
                                        </div>
                                    </div>   
                                </div>
                                <div class="card-block">
                                    <div class="md-card-block">  
                                        <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
                                            <thead>
                                                <th style="text-align: center; width: 10px;">#</th>
                                                <th style="text-align: center;">Nro Factura</th>
                                                <th style="text-align: center;">Cliente</th>
                                                <th style="text-align: center;">Vendedor</th>
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

                                                    $respuesta = ControladorVentas::ctrRangoFechaVentas($fechaInicial, $fechaFinal);

                                                    foreach ($respuesta as $key => $value) {

                                                        $numbFactura1 = substr($value["NroFactura"], 0, -8);
                                                        $numbFactura2 = substr($value["NroFactura"], -8);

                                                        echo '<tr>
                                                                <td class="text-center">'.($key + 1).'</td>
                                                                <td class="text-center">'.$numbFactura1.'-'.$numbFactura2.'</td>
                                                                <td class="text-center">'.$value["NombreC"].' '.$value["ApellidoC"].'</td>
                                                                <td class="text-center">'.$value["Nombre"].' '.$value["Apellido"].'</td>
                                                                <td class="text-center">'.$value["fechaFormateada"].'</td>';
                                                                
                                                                if($value["Estado"] =="R"){

                                                                    echo '<td style="text-align: center;"><label class="label label-lg label-success">Registrada</label></td>';

                                                                } else {

                                                                    echo '<td style="text-align: center;"><label class="label label-lg label-danger">Anulada</label></td>';

                                                                }    

                                                                echo '<td class="text-center">$'.number_format($value["Total"],2).'</td>
                                                                <td>
                                                                    <div class="btn-group">
                                                                    <button class="btn btn-primary waves-effect waves-ligh btnImprimirFactura" idVenta="'.$value["VentaID"].'" data-toggle="modal" data-target="#modalSeleccionarComprobante" ><i class="icofont icofont-printer"></i></button>
                                                                    </div>';
                                                                    
                                                                    if ($value["Estado"] == "R") {
                                                                        
                                                                        if ($value["FacturaTipo"] == null) {
                                                                           
                                                                            echo ' <div class="btn-group">
                                                                                        <button class="btn btn-warning waves-effect waves-ligh btnEditarVenta" idVenta="'.$value["VentaID"].'"><i class="icofont icofont-ui-edit"></i></button>
                                                                                   </div> ';

                                                                        }else{

                                                                            echo ' <div class="btn-group">
                                                                                        <button class="btn btn-danger waves-effect waves-ligh btnEliminarVenta" idVenta="'.$value["VentaID"].'" factura="'.$value["NroFactura"].'" userId="'.$_SESSION["idUser"].'" data-toggle="modal" data-target="#modalAnularFactura"><i class="icofont icofont-close"></i></button>
                                                                                  </div> ';

                                                                        }
                                                                    
                                                                    }else{
                                                                    
                                                                        echo '';
                                                                    
                                                                    }
                                                                        
                                                                echo ' <div class="btn-group">
                                                                        <button class="btn btn-success waves-effect waves-ligh btnDetalleVenta" idVenta="'.$value["VentaID"].'" idCliente="'.$value["ClienteID"].'" idUsuarioCancela="'.$value["UsuarioCancelaID"].'" data-toggle="modal" data-target="#modalDetalleDeVenta" ><i class="icofont icofont-eye-alt"></i></button>
                                                                        </div>
                                                                    </td>
                                                            </tr>';

                                                        }
                                                  
                                                    ?>
                                            </tbody>
                                        </table>
                                        <div class="text-right p-t-15">
                                            <a href="crear-venta">
                                                <button class="btn waves-effect waves-light btn-primary"><i class="icofont icofont-plus m-r-5"></i>Nueva venta</button>
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
        SELECCIONAR COMPROBANTE
======================================-->

    <div class="modal fade" id="modalSeleccionarComprobante" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h5 class="modal-title">Seleccionar comprobante</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form role="form" id="formSeleccionarComprobante" method="post" class="form-material">
                <div class="modal-body">
                        <input type="hidden" name="idVentaC" id="idVentaC">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                   <i class="icofont icofont-page"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <select class="form-control" name="TipoComprobante" id="TipoComprobante">
                                        <option value="">Seleccione una opción</option>
                                        <option value="X">X</option>
                                        <option value="C">C</option>
                                    </select>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Tipo comprobante</label>
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
                    $imprimirComprobante = new ControladorVentas();
                    $imprimirComprobante -> ctrImprimirCombrobante();
                ?>
                </form>
                </div>
            </div>
        </div>
    </div>

<!--=====================================
        ANULAR FACTURA
======================================-->

    <div class="modal fade" id="modalAnularFactura" tabindex="-1" role="dialog">
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
                        <input type="hidden" name="idVentaA" id="idVentaA">
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
                    $anularVenta = new ControladorVentas();
                    $anularVenta -> ctrAnularVenta();
                ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!--=====================================
        DETALLE DE VENTA
======================================-->

    <div class="modal fade" id="modalDetalleDeVenta" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h5 class="modal-title tituloDetalleVenta"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row invoive-info">
                        <div class="col-md-6 col-sm-8 invoice-client-info">
                            <h6 class="text-dark f-w-100">Informacion del cliente :</h6>
                            <h6 class="m-0" id="nombreClienteDetalle"></h6>
                            <p class="m-0 m-t-10" id="direccionClienteDetalle"></p>
                            <p class="m-0" id="telefonoClienteDetalle"></p>
                            <hr>
                            <img src="vistas/img/plantilla/logo.png" alt="logo.png">
                        </div>
                        <div class="col-md-6 col-sm-8">
                            <h6 class="text-dark">Información de la venta :</h6>
                            <table class="table table-responsive invoice-table invoice-order table-borderless">
                                <tbody>
                                    <tr>
                                        <th>Fecha :</th>
                                        <td id="fechaDetalleVenta">November 14</td>
                                    </tr>
                                    <tr>
                                        <th>N° Factura : </th>
                                        <td id="facturaDetalleVenta"></td>
                                    </tr>
                                    <tr>
                                        <th>Vendedor :</th>
                                        <td id="vendedorVentaDetalle"></td>
                                    </tr>
                                    <tr>
                                        <th>Estado :</th>
                                        <td id="estadoVentaDetalle"></td>
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
                            <h6 class="m-b-20 text-dark">Productos</h6>
                            <div class="listadoProductosDetalle">
                                
                            </div>
                            <hr>
                            
                            <h6 class="text-uppercase text-primary" id="tituloDesRecDetalleVenta">
                                                        
                            </h6>
                            <h6 class="text-uppercase text-primary">Total venta :
                            <span id="totalVentaDetalle"></span>
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
<script type="text/javascript" src="vistas/js/ventas.js"></script>