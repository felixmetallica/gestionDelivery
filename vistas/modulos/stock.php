<div class="pcoded-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h4 class="m-b-10">Stock</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="inicio">
                                <i class="ti-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#!">Almacen</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<!--=====================================
            LISTADO
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
                                            <h5 class="card-header-text p-t-15">Estado actual de stock</h5>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="md-card-block">
                                        <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
                                              <thead>
                                                  <th style="text-align: center;">#</th>
                                                  <th style="text-align: center;">Codigo</th>
                                                  <th style="text-align: center;">Nombre</th>
                                                  <th style="text-align: center;">Stock</th>
                                                  <th style="text-align: center;">Estado</th>

                                              </thead>
                                              <tbody>
                                                <?php

                                                    $item = null;
                                                    $valor = null;
                                                    $i=1;
                                                    $listar = ControladorAlmacen::ctrMostrarProductosInsumos($item, $valor);

                                                    foreach ($listar as $key => $value) {

                                                        if ($value["Stock"] > $value["StockMinimo"]) {

                                                            $estado = '<button type="button" class="btn waves-effect waves-light btn-success">
                                                                            <span><i class="icofont icofont-checked"></i> Stock suficiente</span>
                                                                        </button>';

                                                        }else{

                                                            $estado = '<button type="button" class="btn waves-effect waves-light btn-danger">
                                                                            <span><i class="icofont icofont-warning"></i> Reponer stock</span>
                                                                        </button>';

                                                        }

                                                        echo '<tr>
                                                              <td style="text-align: center;">'.$i.'</td>
                                                              <td style="text-align: center;">'.$value["Codigo"].'</td>
                                                              <td style="text-align: center;">'.$value["Nombre"].'</td>
                                                              <td style="text-align: center;">'.$value["Stock"].' '.$value["Medida"].'</td>
                                                              <td style="text-align: center;">'.$estado.'</td>

                                                        </tr>';

                                                        $i++;
                                                    }
                                                ?>
                                              </tbody>
                                            </table>
                                            <div class="text-right p-t-15">
                                            <a href="almacen">
                                                <button class="btn waves-effect waves-light btn-primary"><i class="icofont icofont-stock-search"></i>Almacen</button>
                                            </a>
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
