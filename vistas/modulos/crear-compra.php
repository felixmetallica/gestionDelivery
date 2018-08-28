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
                        <h4 class="m-b-10">Nueva compra</h4>
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
        NUEVA COMPRA
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
                                                    <form class="form-material" role="form" id="formNuevaCompra" method="post">
                                                        <div class="row">
                                                            <!--USUARIO-->
                                                            <div class="col-sm-12">
                                                                <div class="material-group">
                                                                    <div class="material-addone">
                                                                        <i class="icofont icofont-ui-user"></i>
                                                                    </div>
                                                                    <div class="form-group form-default form-static-label">
                                                                        <input type="text" class="form-control md-static" id="nombreUsuarioCompra" value="<?php echo $_SESSION["Nombre"].' '.$_SESSION["Apellido"]; ?>" readonly>
                                                                        <input type="hidden" name="idUsuarioCompra" value="<?php echo $_SESSION["idUser"]; ?>">
                                                                        <span class="form-bar"></span>
                                                                        <label class="float-label text-dark">Usuario</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <!--NUMERO DE ORDEN-->
                                                            <div class="col-sm-12">
                                                                <div class="material-group">
                                                                    <div class="material-addone">
                                                                        <i class="icofont icofont-file-document"></i>
                                                                    </div>
                                                                    <div class="form-group form-default  form-static-label">
                                                                        <?php

                                                                            $item = null;
                                                                            $valor = null;

                                                                            $compras = ControladorCompras::ctrMostrarCompras($item, $valor);

                                                                            if (!$compras) {

                                                                                echo '<input type="text" class="form-control" name="nuevaCompra" id="nuevaCompra" value="0001-00000001" readonly>';

                                                                            } else {

                                                                                $codigo = $compras[0]["NroCompra"];

                                                                                $numtemp = str_pad($codigo, 4, "0", STR_PAD_LEFT);

                                                                                $numbFactura1 = substr($codigo,0,-8);
                                                                                $numbFactura2 = substr($codigo, -8)+1;

                                                                                $numtemp2= str_pad($numbFactura2, 8, "0", STR_PAD_LEFT);

                                                                                $nroFactura = $numbFactura1.'-'.$numtemp2;


                                                                                echo '<input type="text" class="form-control md-static" name="nuevaCompra" id="nuevaCompra" value="'.$nroFactura.'" readonly>';
                                                                            }

                                                                        ?>
                                                                        <span class="form-bar"></span>
                                                                        <label class="float-label text-dark">Orden N°</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <!--PROVEEDOR-->
                                                            <div class="col col-md-8">
                                                                <div class="material-group">
                                                                    <div class="material-addone">
                                                                        <i class="icofont icofont-businessman"></i>
                                                                    </div>
                                                                    <div class="form-group form-default form-static-label">
                                                                        <input type="text" class="form-control md-static" name="proveedorCompra" id="proveedorCompra" required>
                                                                        <input type="hidden" name="idProveedorCompra" id="idProveedorCompra">
                                                                        <span class="form-bar"></span>
                                                                        <label class="float-label text-dark">Proveedor</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col col-md-4">
                                                                <button type="button" class="btn waves-effect waves-light btn-primary" data-toggle="modal" data-target="#modalBuscarProveedor"><i class="icofont icofont-search"></i> Buscar</button>
                                                            </div>
                                                        </div>
                                                        <!--AGREGAR INSUMO-->
                                                        <h6>Listado de compra</h6>
                                                        <div class="nuevoInsumo p-t-20">

                                                        </div>
                                                        <input type="hidden" name="listadoInsumos" id="listadoInsumos">
                                                        <!--BTN AGREGAR INSUMO-->
                                                        <button type="button" class="btn btn-mini btn-default d-lg-none btnAgregarInsumo">Agregar insumo</button>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-sm-7 ml-auto">
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="text-right">%Impuesto</th>
                                                                            <th class="text-right">Total</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="width: 50%" class="text-right p-0">
                                                                                <div class="material-group material-group-lg m-0">
                                                                                    <div class="material-addone">
                                                                                        <i class="icofont icofont-sale-discount"></i>
                                                                                    </div>
                                                                                    <div class="form-group form-default">
                                                                                        <input type="number" class="form-control" id="nuevoImpuestoCompra" name="nuevoImpuestoCompra" />
                                                                                        <input type="hidden" name="nuevoPrecioImpuesto" id="nuevoPrecioImpuesto" required>
                                                                                        <input type="hidden" id="precioNetoCompra" name="precioNetoCompra">
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
                                                                                        <input type="text" min="1" class="form-control totalCompra" placeholder="00000" id="totalCompra" name="totalCompra" total="" readonly required />
                                                                                        <input type="hidden" name="totalCompraFinal" id="totalCompraFinal">
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
                                                                        <select class="form-control mama" name="fPagoCompra" id="fPagoCompra" required>
                                                                            <option value="">Selecionar forma de pago</option>
                                                                            <?php
                                                                                $medioPago = new ControladorCompras();
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
                                                            <div class="row">
                                                                <div class="col-lg-12 text-right">
                                                                    <a href="compras"><button type="button" class="btn btn-primary">Cancelar</button></a>
                                                                    <button type="submit" class="btn btn-primary">Comfirmar</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <?php
                                                        $crearCompra =  new ControladorCompras();
                                                        $crearCompra -> ctrCrearCompra();
                                                    ?>
                                                    </div>
                                            </div>
                                        </div>
                                        <!--TABLA DE INSUMOS-->
                                        <div class="col-lg-7 d-none d-sm-none d-lg-block">
                                            <div class="card">
                                                <div class="card-header bg-danger p-1">
                                                </div>
                                                <div class="card-block">

                                                    <div class="table-responsive dt-responsive ">
                                                        <table class="display compact table-striped table-bordered tablaInsumosCompra" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Código</th>
                                                                    <th>Nombre</th>
                                                                    <th>Acciones</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!--FIN TABLA DE INSUMOS-->
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
        BUSCAR PROVEEDOR
======================================-->

   <div class="modal fade" id="modalBuscarProveedor" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h4 class="modal-title">Seleccionar Proveedor</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive dt-responsive ">
                        <table class="display compact table-striped table-bordered dt-responsive tablaBuscarProveedores" style="width:100%">
                            <thead>
                                <tr>
                                  <th style="text-align: center;">#</th>
                                  <th style="text-align: center;">Razon Social</th>
                                  <th style="text-align: center;">CUITT</th>
                                  <th style="text-align: center;">Rubro</th>
                                  <th style="text-align: center;">Teléfono</th>
                                  <th style="text-align: center;">Accion</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                    $listarProve = ControladorProveedores::ctrMostrarProveedoresAc();

                                    foreach ($listarProve as $key => $value) {
                                       echo '<tr>
                                                <td class="text-center">'.($key+1).'</td>
                                                <td class="text-center">'.$value["RazonSocial"].'</td>
                                                <td class="text-center">'.$value["CUITT"].'</td>
                                                <td class="text-center">'.$value["Rubro"].'</td>
                                                <td class="text-center">('.$value["Prefijo"].') - '.$value["NroTelefono"].'</td>
                                                <td class="text-center"><div class="btn-group"><button class="btn btn-success waves-effect waves-ligh btnSeleccionarProveedor" idProveedor="'.$value["ProveedorID"].'" RazonSocial="'.$value["RazonSocial"].'"><i class="icofont icofont-check"></i></button></div></td>
                                            </tr>';
                                    }


                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-right">
                        <a data-toggle="modal" href="#modalAgregarProveedor" class="btn btn-primary">Nuevo Proveedor</a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancelar</button>
                </div>
                <?php
                   // $crearUsuario = new ControladorConfiguracion();
                   // $crearUsuario -> ctrRegistrarRubro();
                ?>
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
                                                                    <label class="float-label">CUITT</label>
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
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light ">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript" src="vistas/js/compras.js"></script>
