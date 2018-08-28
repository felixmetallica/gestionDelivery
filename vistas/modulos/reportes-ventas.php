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
                        <h4 class="m-b-10">Reportes de ventas</h4>
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
            REPORTES VENTAS
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
                                        <div class="col-lg-6 text-left">
                                            <button type="button" class="btn waves-effect waves-light btn-primary" id="daterange-btn2">
                                                <span><i class="fa fa-calendar"></i> Rango de fecha</span>
                                            </button>
                                        </div>
                                        <div class="col-lg-6 text-right">
                                            <?php

                                                if (isset($_GET["fechaInicial"])) {
                                                    
                                                    echo '<a href="extensiones/tcpdf/pdf/reporte-ventas.php?reporte=reporteA&fechaInicial='.$_GET["fechaInicial"].'&fechaFinal='.$_GET["fechaFinal"].'" target="_blank">'; 
                                                                                                        
                                                }else{

                                                   echo '<a href="extensiones/tcpdf/pdf/reporte-ventas.php?reporte=reporteA" target="_blank">'; 
                                                    
                                                }


                                            ?>
                                            
                                            <img class="img-40" src="vistas/img/plantilla/pdf.png"></a>
                                            <?php

                                                if (isset($_GET["fechaInicial"])) {
                                                    
                                                    echo '<a href="vistas/modulos/reportes.php?reporte=reporteVentas&fechaInicial='.$_GET["fechaInicial"].'&fechaFinal='.$_GET["fechaFinal"].'">'; 
                                                                                                        
                                                }else{

                                                   echo '<a href="vistas/modulos/reportes.php?reporte=reporteVentas">'; 
                                                    
                                                }


                                            ?>
                                            
                                            <img class="img-40" src="vistas/img/plantilla/xls.png"></a>
                                        </div>
                                    </div> 
                                </div>
                                <div class="card-block">
                                    <?php
                                        include "reportes/grafico-ventas.php";
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-7">
                            <div class="col-sm-12">
                                <?php
                                    include "reportes/productos-mas-vendidos.php";
                                ?>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-7">
                            <div class="col-sm-12">
                                <?php
                                    include "reportes/vendedores.php";
                                ?>
                            </div>
                            <div class="col-sm-12">
                                <?php
                                    include "reportes/compradores.php";
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<!-- bootstrap range picker -->
<script type="text/javascript" src="vistas/bower_components/bootstrap-daterangepicker/js/daterangepicker.js"></script>
<script type="text/javascript" src="vistas/bower_components/bootstrap-daterangepicker/js/moment.js"></script>
<script type="text/javascript" src="vistas/js/reportes-ventas.js"></script>