<div class="pcoded-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h4 class="m-b-10">Bienvenidos al sistema Gestión Delivery</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="inicio">
                                <i class="feather icon-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#!">Panel de control</a>
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
                        <?php 
                    
                            if ($_SESSION["rol"] == "Administrador") {
                            
                                include "inicio/cajas-superiores.php";

                               echo '<div class="col-sm-12">';
                                        
                                        include "reportes/grafico-ventas.php"; 
                                
                               echo '</div>
                            
                                    <div class="col-sm-6">';
                                        
                                        include "reportes/productos-mas-vendidos.php";
                               
                               echo '</div>';

                               echo '<div class="col-sm-6">';
                                        include "inicio/productos-recientes.php";
                               
                               echo '</div>';

                            } else {

                                 echo '<div class="col-sm-6">
                                         <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-header-text">Bienvenido '.$_SESSION["Nombre"].' '.$_SESSION["Apellido"].'</h4>
                                            </div>
                                            <div class="card-block">
                                                <div class="tada animated">
                                                    <div class="text-center animation-image">
                                                        <img class="img-thumbnail" src="'.$_SESSION["foto"].'" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                     
                                    <div class="col-sm-6">';

                                            include "inicio/productos-recientes.php";

                                 echo '</div>';

                            }
                        
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>