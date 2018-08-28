<nav class="navbar header-navbar pcoded-header">
    <div class="navbar-wrapper">
        <div class="navbar-logo">
            <a class="mobile-menu waves-effect waves-light" id="mobile-collapse" href="#!">
                <i class="feather icon-toggle-right"></i>
            </a>
            <a href="inicio">
                <img class="img-fluid" src="vistas/img/plantilla/logo1.png" alt="Theme-Logo" />
            </a>
            <a class="mobile-options waves-effect waves-light">
                <i class="feather icon-more-horizontal"></i>
            </a>
        </div>
        <div class="navbar-container container-fluid">
            <ul class="nav-left">
                
            </ul>
            <ul class="nav-right">
                <?php include "vistas/modulos/notificaciones.php"; ?>
                <li class="user-profile header-notification">
                    <div class="dropdown-primary dropdown">
                        <div class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?php echo $_SESSION["foto"]; ?>" class="img-radius" alt="User-Profile-Image">
                            <span><?php echo $_SESSION["Nombre"]. ' <b>'.$_SESSION["Apellido"].' </b>'; ?></span>
                            <i class="feather icon-chevron-down"></i>
                        </div>
                        <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                            <li>
                                <a href="salir">
                                    <i class="feather icon-log-out"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>