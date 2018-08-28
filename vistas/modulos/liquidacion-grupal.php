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
                        <h4 class="m-b-10">Liquidación grupal</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="inicio">
                                <i class="ti-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#!">Payment</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    

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
                                            <h5 class="card-header-text p-t-15">Listado de liquidaciones confeccionadas</h5>
                                        </div>
                                        <div class="col-lg-6 text-right">
                                            <button type="button" class="btn waves-effect waves-light btn-primary btnLiquidarGrupal"><i class="icofont icofont-printer"></i>Liquidar</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="md-card-block">
                                        <form role="form" id="formLiquidacionGrupal" method="post">
                                            <table class="table table-bordered table-striped dt-responsive tablaLiquidacionGrupal" width="100%">
                                                <thead>
                                                    <th style="text-align: center;">#</th>
                                                    <th style="text-align: center;">Tipo</th>
                                                    <th style="text-align: center;">Periodo</th>
                                                    <th style="text-align: center;">Empleado</th>
                                                    <th style="text-align: center;">Fecha de confección</th>
                                                    <th style="text-align: center;">Total</th>
                                                </thead>
                                            </table>
                                            <div class="text-right p-t-15">
                                                <a href="liquidaciones">
                                                    <button type="button" class="btn waves-effect waves-light btn-primary">Cancelar</button>
                                                </a>
                                            </div>
                                        </form>
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

<script type="text/javascript" src="vistas/js/payment.js"></script>