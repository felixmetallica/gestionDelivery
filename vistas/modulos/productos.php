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
                        <h4 class="m-b-10">Administración de productos</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="inicio">
                                <i class="ti-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#!">Productos</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

<!--=====================================
            LISTADO PRODUCTOS
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
                                            <h5 class="card-header-text p-t-15">Listado de productos</h5>
                                        </div>
                                        <div class="col-lg-6 text-right">
                                            <a href="extensiones/tcpdf/pdf/reporte-productos.php" target="_blank"><img class="img-40" src="vistas/img/plantilla/pdf.png"></a>
                                            <a href="vistas/modulos/reportes.php?reporte=reporteProductos"><img class="img-40" src="vistas/img/plantilla/xls.png"></a>
                                            <button class="btn btn-mat waves-effect waves-light btn-primary" data-toggle="modal" data-target="#modalAgregarProducto"><i class="icofont icofont-plus"></i>Nuevo producto</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="md-card-block">
                                        <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
                                            <thead>
                                                <th style="text-align: center;">#</th>
                                                <th style="text-align: center;">Imagen</th>
                                                <th style="text-align: center;">Cod</th>
                                                <th style="text-align: center;">Rubro</th>
                                                <th style="text-align: center;">Nombre</th>
                                                <th style="text-align: center;">P.venta</th>
                                                <th style="text-align: center;">Vendidos</th>
                                                <th style="text-align: center;">Activo</th>
                                                <th style="text-align: center;">Acciones</th>
                                            </thead>
                                            <tbody>
                                                <?php

                                                    $item = null;
                                                    $valor = null;
                                                    $orden = "ProductoID";

                                                    $listaProductos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);

                                                    foreach ($listaProductos as $key => $value) {

                                                        echo '<tr>
                                                                <td style="text-align: center;">'.($key+1).'</td>
                                                                <td style="text-align: center;"><img src="'.$value["Imagen"].'" class="img-thumbnail img-60" width="40px"></td>
                                                                <td style="text-align: center;">'.$value["Codigo"].'</td>
                                                                <td style="text-align: center;">'.$value["Rubro"].'</td>
                                                                <td style="text-align: center;">'.$value["Nombre"].'</td>
                                                                <td style="text-align: center;">$'.$value["PrecioVenta"].'</td>
                                                                <td style="text-align: center;">'.$value["Ventas"].'</td>';

                                                                if($value["Activo"] =="S"){

                                                                    echo '<td style="text-align: center;"><button class="btn btn-success waves-effect waves-ligh btnActivarProducto" idProducto="'.$value["ProductoID"].'" estado="'.$value["Activo"].'" nombreproducto="'.$value["Nombre"].'")">Si</button></td>';

                                                                } else {

                                                                    echo '<td style="text-align: center;"><button class="btn btn-danger waves-effect waves-ligh btnActivarProducto" idProducto="'.$value["ProductoID"].'" estado="'.$value["Activo"].'" nombreproducto="'.$value["Nombre"].'")">No</button></td>';
                                                                }


                                                        echo '<td style="text-align: center;">
                                                                <div class="btn-group">
                                                                    <button class="btn btn-warning waves-effect waves-ligh btnEditarProducto" data-toggle="modal" data-target="#modalEditarProducto" idProducto="'.$value["ProductoID"].'" codActual="'.$value["Codigo"].'"><i class="icofont icofont-ui-edit"></i></button>
                                                                </div>
                                                                <div class="btn-group">
                                                                    <button class="btn btn-danger waves-effect waves-ligh btnEliminarProducto" idProducto="'.$value["ProductoID"].'" nombreproducto="'.$value["Nombre"].'" Imagen="'.$value["Imagen"].'" Codigo="'.$value["Codigo"].'"><i class="icofont icofont-ui-delete"></i></button>
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
            AGREGAR PRODUCTO
======================================-->

    <div class="modal fade" id="modalAgregarProducto" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h4 class="modal-title">Nuevo producto</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="formAgregarProducto" method="post" class="form-material" enctype="multipart/form-data">
                    <div class="row">
                       <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-shopping-cart"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <select class="form-control" name="rubroProducto" id="rubroProducto">
                                        <option value="">Seleccione el rubro</option>
                                            <?php
                                                $traerRubro = new ControladorProductos();
                                                $traerRubro -> ctrListarRubros();
                                            ?>
                                    </select>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Rubro</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-barcode"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <input type="text" class="form-control" name="codigoProducto" id="codigoProducto" readonly>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Código</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-label"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="nombreProducto" id="nombreProducto" minlength="3" maxlength="30">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Nombre</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-money"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="precioProducto" id="precioProducto" minlength="3" maxlength="4">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Precio de venta</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-soup-bowl"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <select class="form-control tipoProducto" name="tipoProducto" id="tipoProducto">
                                        <option value="">Seleccione el tipo</option>
                                        <option value="Entero">Entero</option>
                                        <option value="Compuesto">Compuesto</option>
                                    </select>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Tipo</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-chart-line-alt"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <select class="form-control controlStock" name="afectaStockProducto" id="afectaStockProducto">
                                        <option value="">Afecta stock</option>
                                        <option value="S">Si</option>
                                        <option value="N">No</option>
                                    </select>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Afecta Stock</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 precioCompra">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-money"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="precioProductoCompra" id="precioProductoCompra" minlength="2" maxlength="20">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Precio de compra</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 stockMinimo">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-chart-line-alt"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="stockMinimoCompra" id="stockMinimoCompra" minlength="2" maxlength="20">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Stock mínimo</label>
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
                                    <input type="file" class="nuevaImagen" name="nuevaImagen">
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
                    $registrarProducto = new ControladorProductos();
                    $registrarProducto -> ctrRegistrarProducto();
                ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!--=====================================
            EDITAR PRODUCTO
======================================-->

    <div class="modal fade" id="modalEditarProducto" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h4 class="modal-title" id="nombreProductoModal"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="formEditarProducto" method="post" class="form-material" enctype="multipart/form-data">
                    <div class="row">
                       <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-shopping-cart"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <input type="text" class="form-control" name="erubroProducto" id="erubroProducto" readonly>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Rubro</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-barcode"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <input type="text" class="form-control" name="ecodigoProducto" id="ecodigoProducto" readonly>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Código</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-label"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <input type="text" class="form-control" name="enombreProducto" id="enombreProducto" minlength="3" maxlength="30">
                                    <input type="hidden" id="idProductoE" name="idProductoE">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Nombre</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-money"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <input type="text" class="form-control" name="eprecioProducto" id="eprecioProducto" minlength="3" maxlength="4">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Precio</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-soup-bowl"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <select class="form-control eTipoProductosel" name="eTipoProducto">
                                        <option value ="" id="eTipoProducto"></option>
                                        <option value="Entero">Entero</option>
                                        <option value="Compuesto">Compuesto</option>
                                    </select>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Tipo</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-chart-line-alt"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <select class="form-control eControlStock" name="eafectaStockProducto">
                                        <option id="eafectaStockProducto" value="">Afecta stock</option>
                                        <option value="S">Si</option>
                                        <option value="N">No</option>
                                    </select>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Afecta Stock</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 eprecioCompra">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-money"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <input type="text" class="form-control" name="ePrecioProductoCompra" id="ePrecioProductoCompra" minlength="2" maxlength="20">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Precio de compra</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 estockMinimo">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-chart-line-alt"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <input type="text" class="form-control" name="eStockMinimoCompra" id="eStockMinimoCompra" minlength="2" maxlength="20">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Stock mínimo</label>
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
                                    <input type="file" class="nuevaImagen" name="editarImagen">
                                    <input type="text" class="md-form-control md-form-file form-control foto" placeholder="No se elijio archivo">
                                    <span class="form-bar">Peso máximo de la foto 2MB</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                             <img src="vistas/img/usuarios/default/User_ring.png" class="img-thumbnail previsualizar" width="100px">
                             <input type="hidden" name="imagenActual" id="imagenActual">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light ">Aceptar</button>
                </div>
                <?php
                    $editarProducto = new ControladorProductos();
                    $editarProducto -> ctrEditarProducto();
                ?>
                    </form>
                </div>
            </div>
        </div>
    </div>


<script type="text/javascript" src="vistas/js/productos.js"></script>
