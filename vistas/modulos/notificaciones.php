<?php 

    if ($_SESSION["rol"] != "Administrador") {
        
       return;
    
    } 
$notificaciones = ControladorNotificaciones::ctrMostrarNotificaciones();

?>
<li class="header-notification">
    <div class="dropdown-primary dropdown">
        <div class="dropdown-toggle" data-toggle="dropdown">
            <i class="feather icon-bell"></i>
            <?php 
                if ($notificaciones["NuevasVentas"] > 0) {
                    echo '<span class="badge bg-c-red">!</span>';
                }
            ?>
        </div>
        <ul class="show-notification notification-view dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
            <li>
                <h6>Notificaciónes</h6>
                <label class="label label-danger">Nuevas ventas</label>
            </li>
            <li>
                <div class="media">
                    <div class="media-body">
                      <a href="" style="background-color: inherit;" class="actualizarNotificaciones" id="actualizarNotificaciones" item="NuevasVentas"><i class="icofont icofont-cur-dollar-plus text-primary"></i><?php echo $notificaciones["NuevasVentas"]; ?> nuevas ventas registradas</a>
                    </div>
                </div>
            </li>
          </ul>
    </div>
</li>

