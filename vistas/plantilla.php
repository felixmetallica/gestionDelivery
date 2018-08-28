<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    
    <title>Gestión Delivery</title>
    <!--==================================
    =            ARCHIVOS CSS            =
    ===================================-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <!-- Favicon icon -->
    <link rel="icon" href="vistas/img/plantilla/favicon.ico" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    
    <!--==================================
    =            ARCHIVOS CSS            =
    ===================================-->

    <!-- Font Awesome -->
    <link href="vistas/assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- framework -->
    <link rel="stylesheet" type="text/css" href="vistas/bower_components/bootstrap/css/bootstrap.min.css">
    <!-- waves.css -->
    <link rel="stylesheet" href="vistas/assets/pages/waves/css/waves.min.css" type="text/css" media="all">
    <!-- Data Table Css -->
    <link rel="stylesheet" type="text/css" href="vistas/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="vistas/assets/pages/data-table/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="vistas/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="vistas/bower_components/jquery-datatables-checkboxes/css/dataTables.checkboxes.css">

    <!-- sweet alert framework -->
    <link rel="stylesheet" type="text/css" href="vistas/bower_components/sweetalert/css/sweetalert.css">
    <!-- Bootstrap Date-Picker css -->
    <link rel="stylesheet" href="vistas/assets/pages/bootstrap-datepicker/css/bootstrap-datetimepicker.css" />
    <link rel="stylesheet" type="text/css" href="vistas/bower_components/bootstrap-daterangepicker/css/daterangepicker.css" />
    <!-- morris chart -->
    <link rel="stylesheet" type="text/css" href="vistas/bower_components/morris.js/css/morris.css">
    <!-- animation nifty modal window effects css -->
    <link rel="stylesheet" type="text/css" href="vistas/assets/css/component.css">
    <!-- animation css -->
    <link rel="stylesheet" type="text/css" href="vistas/bower_components/animate.css/css/animate.css">
    <!--forms-wizard css-->
    <link rel="stylesheet" type="text/css" href="vistas/bower_components/jquery.steps/css/jquery.steps.css">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="vistas/assets/icon/icofont/css/icofont.css">
    <!-- simple line icon -->
    <link rel="stylesheet" type="text/css" href="vistas/assets/icon/simple-line-icons/css/simple-line-icons.css">
    <!-- feather icon -->
    <link rel="stylesheet" type="text/css" href="vistas/assets/icon/feather/css/feather.css">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="vistas/assets/icon/themify-icons/themify-icons.css">
    <!-- Switch component css -->
    <link rel="stylesheet" type="text/css" href="vistas/bower_components/switchery/css/switchery.min.css">
    <!-- main style -->
    <link rel="stylesheet" type="text/css" href="vistas/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="vistas/assets/css/pages.css">
    <link rel="stylesheet" type="text/css" href="vistas/assets/css/widget.css">


    <!--==================================
    =            ARCHIVOS JS             =
    ===================================-->

    <!-- Required Jquery -->
    <script type="text/javascript" src="vistas/bower_components/jquery/js/jquery.min.js"></script>
    <script type="text/javascript" src="vistas/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="vistas/bower_components/popper.js/js/popper.min.js"></script>
    <script type="text/javascript" src="vistas/bower_components/bootstrap/js/bootstrap.min.js"></script>
    <!-- waves js -->
    <script src="vistas/assets/pages/waves/js/waves.min.js"></script>
    <!--Forms - Wizard js-->
    <script src="vistas/bower_components/jquery.cookie/js/jquery.cookie.js"></script>
    <script src="vistas/bower_components/jquery.steps/js/jquery.steps.js"></script>
    <script src="vistas/bower_components/jquery-validation/js/jquery.validate.js"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="vistas/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
    <!-- modalEffects js nifty modal window effects -->
    <script src="vistas/assets/js/classie.js"></script>
    <!-- data-table js -->
    <script src="vistas/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="vistas/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="vistas/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="vistas/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <script src="vistas/bower_components/jquery-datatables-checkboxes/js/dataTables.checkboxes.js"></script>
    <!-- Masking js -->
    <script src="vistas/assets/pages/form-masking/inputmask.js"></script>
    <script src="vistas/assets/pages/form-masking/jquery.inputmask.js"></script>
    <!-- sweet alert js -->
    <script type="text/javascript" src="vistas/bower_components/sweetalert2/js/sweetalert.js"></script>
    <!-- Redirect js -->
    <script src="vistas/bower_components/jqueryRedirect/jquery.redirect.js"></script>
    <!-- jQuery Number -->
    <script src="vistas/bower_components/jquery-number/jquery.number.js"></script>
    <!-- bootstrap range picker -->
    <script type="text/javascript" src="vistas/bower_components/bootstrap-daterangepicker/js/daterangepicker.js"></script>
    <script type="text/javascript" src="vistas/bower_components/bootstrap-daterangepicker/js/moment.js"></script>
    <!-- Morris Chart js -->
    <script src="vistas/bower_components/raphael/js/raphael.min.js"></script>
    <script src="vistas/bower_components/morris.js/js/morris.js"></script>
    <!-- Chart js -->
    <script type="text/javascript" src="vistas/bower_components/chart.js/Chart.js"></script>
    <!--Forms - Validate js-->
    <script src="vistas/bower_components/jquery-validation/js/jquery.validate.js"></script>
    <!-- Switch component js -->
    <script type="text/javascript" src="vistas/bower_components/switchery/js/switchery.min.js"></script>

    <!-- Custom js -->
    <script src="vistas/assets/js/pcoded.js"></script>
    <script src="vistas/assets/js/vertical/horizontal-layout.js"></script>
    <script type="text/javascript" src="vistas/assets/js/script.js"></script>
    

</head>

<?php

      if (isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok") {

        echo '<body">';
?>

<div class="loader-bg">
    <div class="loader-bar"></div>
</div>
<div id="pcoded" class="pcoded">
<div class="pcoded-overlay-box"></div>
    <div class="pcoded-container navbar-wrapper">
        
        <?php

            /*==============================
             =            HEADER            =
            ==============================*/
            
            include "modulos/head.php"; 
        ?>

        <div class="pcoded-main-container">
            <div class="pcoded-wrapper">
                
                <?php

                    /*==============================
                    =            MENU              =
                    ==============================*/
                    include "modulos/menu.php";

                    /*==============================
                    =            CONTENIDO         =
                    ==============================*/ 
                
                    if (isset($_GET["ruta"])) {

                        if ($_GET["ruta"] == "inicio" ||
                            $_GET["ruta"] == "ingreso" ||
                            $_GET["ruta"] == "salir" ||
                            $_GET["ruta"] == "usuarios" ||
                            $_GET["ruta"] == "empleados" ||
                            $_GET["ruta"] == "grupoFamiliar" ||
                            $_GET["ruta"] == "clientes" ||
                            $_GET["ruta"] == "detalleUsuario" ||
                            $_GET["ruta"] == "proveedores" ||
                            $_GET["ruta"] == "rubros" ||
                            $_GET["ruta"] == "roles" ||
                            $_GET["ruta"] == "puestos" ||
                            $_GET["ruta"] == "categorias" ||
                            $_GET["ruta"] == "iva" ||
                            $_GET["ruta"] == "puntoVenta" ||
                            $_GET["ruta"] == "mediosDePago" ||
                            $_GET["ruta"] == "productos" ||
                            $_GET["ruta"] == "insumos" ||
                            $_GET["ruta"] == "recetas" ||
                            $_GET["ruta"] == "crear-receta" ||
                            $_GET["ruta"] == "editar-receta" ||
                            $_GET["ruta"] == "ventas" ||
                            $_GET["ruta"] == "crear-venta" ||
                            $_GET["ruta"] == "editar-venta" ||
                            $_GET["ruta"] == "reportes-ventas" ||
                            $_GET["ruta"] == "compras" ||
                            $_GET["ruta"] == "crear-compra" ||
                            $_GET["ruta"] == "editar-compra" ||
                            $_GET["ruta"] == "reportes-compras" ||
                            $_GET["ruta"] == "almacen" ||
                            $_GET["ruta"] == "stock" ||
                            $_GET["ruta"] == "liquidaciones"||
                            $_GET["ruta"] == "conceptos" ||
                            $_GET["ruta"] == "crear-boleta" ||
                            $_GET["ruta"] == "editar-boleta" ||
                            $_GET["ruta"] == "liquidacion-grupal") {

                                include "modulos/".$_GET["ruta"].".php";

                        } else {

                            include "modulos/404.php";

                        }

                    } else {

                        include "modulos/inicio.php";

                    } 

                ?>
                
            </div>
        </div>
    </div>
</div>

<?php

    }else{

        include "modulos/login.php";

    }

?>
<script type="text/javascript" src="vistas/js/plantilla.js"></script>
<script type="text/javascript" src="vistas/js/notificaciones.js"></script>
</body>
</html>