<div class="pcoded-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h4 class="m-b-10">Editar venta</h4>
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
        EDITAR VENTA
======================================-->

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-lg-5 col-xs-12">
                                            <div class="card">
                                                <div class="card-header bg-success p-1"></div>
                                                    <div class="card-block">
                                                    <form class="form-material" role="form" id="formNuevaVenta" method="post">
                                                        <?php

                                                            $item = "VentaID";
                                                            $valor = $_GET["idVenta"];
                                                            $orden = "ProductoID";

                                                            $venta = ControladorVentas::ctrMostrarVentas($item, $valor, $orden);

                                                            $myd = number_format($venta["MontoRecargo"]);

                                                            if ($myd == 0) {

                                                                //$RegargoDescuento = $venta["MontoDescuento"] * 100 / $venta["Neto"];
                                                                $RegargoDescuento = $venta["Total"] - $venta["Neto"];

                                                            } else {

                                                                //$RegargoDescuento = $venta["MontoRecargo"] * 100 / $venta["Neto"];
                                                                $RegargoDescuento = $venta["Total"] - $venta["Neto"];

                                                            }

                                                            $numbFactura1 = substr($venta["NroFactura"], 0, -8);
                                                            $numbFactura2 = substr($venta["NroFactura"], -8);

                                                            $nroFactura = $numbFactura1.'-'.$numbFactura2;

                                                        ?>
                                                        <div class="row">
                                                            <!--VENDEDOR-->
                                                            <div class="col-sm-12">
                                                                <div class="material-group">
                                                                    <div class="material-addone">
                                                                        <i class="icofont icofont-ui-user"></i>
                                                                    </div>
                                                                    <div class="form-group form-default form-static-label">
                                                                        <input type="text" name="nombreUsuarioVenta" class="form-control" id="nombreUsuarioVenta" value="<?php echo $venta["Nombre"].' '.$venta["Apellido"]; ?>" readonly>
                                                                        <input type="hidden" name="idUsuarioVenta" value="<?php echo $venta["UsuarioRegistraID"]; ?>">
                                                                        <span class="form-bar"></span>
                                                                        <label class="float-label text-dark">Vendedor</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <!--NUMERO DE BOLETA-->
                                                            <div class="col-sm-12">
                                                                <div class="material-group">
                                                                    <div class="material-addone">
                                                                        <i class="icofont icofont-file-document"></i>
                                                                    </div>
                                                                    <div class="form-group form-default  form-static-label">
                                                                        <input type="text" class="form-control md-static" name="editarVenta" id="editarVenta" value="<?php echo $nroFactura; ?>" readonly>
                                                                        <input type="hidden" name="idVenta" id="idVenta" value="<?php echo $venta["VentaID"];?>">
                                                                        <span class="form-bar"></span>
                                                                        <label class="float-label text-dark">Factura N°</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <!--CLIENTE-->

                                                                <div class="col col-md-8">
                                                                    <div class="material-group">
                                                                        <div class="material-addone">
                                                                            <i class="icofont icofont-ui-user"></i>
                                                                        </div>
                                                                        <div class="form-group form-default form-static-label">
                                                                            <input type="text" class="form-control" name="clienteVenta" id="clienteVenta" value="<?php echo $venta["NombreC"].' '.$venta["ApellidoC"]; ?>" required>
                                                                            <input type="hidden" name="idClienteVenta" id="idClienteVenta" value="<?php echo $venta["ClienteID"]; ?>">
                                                                            <span class="form-bar"></span>
                                                                            <label class="float-label text-dark">Cliente</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col col-md-4">
                                                                    <button type="button" class="btn waves-effect waves-light btn-primary" data-toggle="modal" data-target="#modalBuscarCliente"><i class="icofont icofont-search"></i> Buscar</button>
                                                                </div>

                                                        </div>
                                                        <!--AGREGAR PRODUCTO-->
                                                        <h6>Listado de productos</h6>
                                                        <div class="nuevoProducto p-t-20">
                                                            <?php

                                                               $listaProductos =ControladorVentas::ctrListadoProductos($valor);

                                                               $losProductos = array();

                                                               foreach ($listaProductos as $key => $value) {

                                                                    $item = "ProductoID";

                                                                    $valor = $value["ProductoID"];

                                                                    $orden = "ProductoID";

                                                                    $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);

                                                                    if ($respuesta["Stock"]!=null) {

                                                                        $Stock = $respuesta["Stock"];
                                                                        $nuevoStock = $Stock;

                                                                    } else {

                                                                        $nuevoStock = "no";
                                                                        $Stock = "no";

                                                                    }

                                                                    $precioActual = $value["Cantidad"] * $respuesta["PrecioVenta"];

                                                                    $dtProductos = array("idProducto" => $value["ProductoID"],
                                                                                       "nombreProducto" => $value["Nombre"],
                                                                                       "cantidadProducto" => $value["Cantidad"],
                                                                                       "precioProducto" => $respuesta["PrecioVenta"],
                                                                                       "total" => $precioActual);

                                                                    array_push($losProductos, $dtProductos);

                                                                   echo '<div class="row">
                                                                            <div class="col-sm-7">
                                                                                <div class="material-group">
                                                                                    <div class="material-addone">
                                                                                        <button  type="button" class="btn btn-danger btn-mini waves-effect waves-light p-1 quitarProducto" idProducto="'.$value["ProductoID"].'"><i class="icofont icofont-close m-0"></i></button>
                                                                                    </div>
                                                                                    <div class="form-group form-default form-static-label">
                                                                                        <input type="text" class="form-control nuevaDescripcionProducto" name="descProdVenta" id="descProdVenta" idProducto="'.$value["ProductoID"].'" value="'.$value["Nombre"].'" nombreProducto="'.$respuesta["Nombre"].'" readonly required>
                                                                                        <span class="form-bar"></span>
                                                                                        <label class="float-label text-dark">Descripción</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-2 ingresoCantidad">
                                                                                <div class="material-group">
                                                                                    <div class="form-group form-default form-static-label">
                                                                                        <input type="number" class="form-control form-control-right cantidadVenta" name="cantidadVenta" min="1" value="'.$value["Cantidad"].'" stock="'.$Stock.'" nuevoStock="'.$nuevoStock.'">
                                                                                        <span class="form-bar"></span>
                                                                                        <label class="float-label text-dark">Cantidad</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-3 ingresoPrecio">
                                                                                <div class="material-group">
                                                                                    <div class="material-addone">
                                                                                        <i class="icofont icofont-cur-dollar"></i>
                                                                                    </div>
                                                                                    <div class="form-group form-default form-static-label">
                                                                                        <input type="text" min="1" class="form-control form-control-right precioProducto" name="precioProducto" precioReal="'.$respuesta["PrecioVenta"].'" readonly value="'.$precioActual.'" />
                                                                                        <span class="form-bar"></span>
                                                                                        <label class="float-label text-dark">Precio</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                         </div>';

                                                               }

                                                               $todoProducto = json_encode($losProductos, JSON_UNESCAPED_UNICODE);

                                                            ?>
                                                        </div>
                                                        <input type="hidden" name="listadoProductos" id="listadoProductos" value='<?php echo $todoProducto; ?>'>
                                                        <!--BTN AGREGAR PRODUCTO-->
                                                        <button type="button" class="btn btn-mini btn-default d-lg-none btnAgregarProducto">Agregar producto</button>
                                                        <hr>

                                                        <div class="row">
                                                            <div class="col-sm-7 ml-auto">
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="text-right">Desc/Rec</th>
                                                                            <th class="text-right">Total</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="width: 50%" class="text-right p-0">
                                                                                <div class="material-group material-group-lg m-0">
                                                                                    <div class="material-addone">
                                                                                        <i class="icofont icofont-cur-dollar"></i>
                                                                                    </div>
                                                                                    <div class="form-group form-default">
                                                                                        <input type="number" class="form-control form-control-right" id="desRegargoVenta" name="desRegargoVenta" value="<?php echo $RegargoDescuento; ?>" />
                                                                                        <input type="hidden" id="precioNetoVenta" name="precioNetoVenta" value="<?php echo $venta["Neto"] ?>">
                                                                                        <input type="hidden" id="montoRecargo" name="montoRecargo" value="<?php echo $venta["MontoRecargo"] ?>">
                                                                                        <input type="hidden" id="montoDescuento" name="montoDescuento" value="<?php echo $venta["MontoDescuento"] ?>">
                                                                                        <span class="form-bar text-dark"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td style="width: 50%" class="text-right p-0">
                                                                                <div class="material-group material-group-lg m-0">
                                                                                    <div class="material-addone">
                                                                                        <i class="icofont icofont-cur-dollar"></i>
                                                                                    </div>
                                                                                    <div class="form-group form-default">
                                                                                        <input type="text" min="1" class="form-control form-control-right totalVenta" value="<?php echo $venta["Total"];?>" id="totalVenta" name="totalVenta" total="<?php echo $venta["Neto"];?>" readonly required />
                                                                                        <input type="hidden" name="totalVentaFinal" id="totalVentaFinal" value="<?php echo $venta["Total"];?>">
                                                                                        <span class="form-bar text-dark"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                        </div>
                                                        <!--FORMA DE PAGO-->
                                                        <div class="row p-t-15">
                                                            <div class="col-sm-6">
                                                                <div class="material-group material-group-sm p-t-5">
                                                                    <div class="material-addone">
                                                                        <i class="icofont icofont-credit-card"></i>
                                                                    </div>
                                                                    <div class="form-group form-default form-static-label">
                                                                        <select class="form-control mama" name="fPagoVenta" id="fPagoVenta" required>
                                                                            <option value="">Selecionar forma de pago</option>
                                                                            <?php
                                                                                $medioPago = new ControladorVentas();
                                                                                $medioPago -> ctrTraerMediosPagos();
                                                                            ?>
                                                                        </select>
                                                                        <span class="form-bar"></span>
                                                                        <label class="float-label text-dark">F. de pago</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="cajasMetodoPago col-sm-8">

                                                            </div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <div class="row text-right">
                                                                <div class="col-lg-12 text-right">
                                                                    <a href="ventas"><button type="button" class="btn btn-primary">Cancelar</button></a>
                                                                    <button type="submit" class="btn btn-primary">Comfirmar</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <?php
                                                        $editarVenta =  new ControladorVentas();
                                                        $editarVenta -> ctrEditarVenta();
                                                    ?>
                                                    </div>
                                            </div>
                                        </div>
                                        <!--TABLA DE PRODUCTOS-->
                                        <div class="col-lg-7 d-none d-sm-none d-lg-block">
                                            <div class="card">
                                                <div class="card-header bg-danger p-1">
                                                </div>
                                                <div class="card-block">

                                                    <div class="table-responsive dt-responsive ">
                                                        <table class="display compact table-striped table-bordered tablaProductosVenta" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 15px" class="text-center">#</th>
                                                                    <th class="text-center">Imagen</th>
                                                                    <th>Código</th>
                                                                    <th>Descripción</th>
                                                                    <th>Stock</th>
                                                                    <th>Acciones</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!--FIN TABLA DE PRODUCTOS-->
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
            BUSCAR CLIENTE
======================================-->

   <div class="modal fade" id="modalBuscarCliente" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h4 class="modal-title">Nuevo rubro</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive dt-responsive ">
                        <table class="display compact table-striped table-bordered tablaBuscarClientes" style="width:100%">
                            <thead>
                                <tr>
                                  <th style="text-align: center;">#</th>
                                  <th style="text-align: center;">Nombre</th>
                                  <th style="text-align: center;">Apellido</th>
                                  <th style="text-align: center;">Calle</th>
                                  <th style="text-align: center;">N°</th>
                                  <th style="text-align: center;">Piso</th>
                                  <th style="text-align: center;">Depto</th>
                                  <th style="text-align: center;">Teléfono</th>
                                  <th style="text-align: center;">Accion</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="text-right">
                        <a data-toggle="modal" href="#modalAgregarCliente" class="btn btn-primary">Nuevo Cliente</a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancelar</button>
                </div>
                <?php
                    $crearUsuario = new ControladorConfiguracion();
                    $crearUsuario -> ctrRegistrarRubro();
                ?>
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
                    $nuevoCliente = new ControladorVentas();
                    $nuevoCliente -> ctrRegistroCliente();
                ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript" src="vistas/js/ventas.js"></script>
