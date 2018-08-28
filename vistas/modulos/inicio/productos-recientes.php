<?php

    $item = null;
    $valor = null;
    $orden = "ProductoID";

    $productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);

?>
<div class="card">
    <div class="card-header">
        <h4 class="card-header-text">Productos recientes</h4>
    </div>
    <div class="table-responsive">
        <div class="table-content">
            <div class="project-table p-20">
                <table id="product-list" class="table dt-responsive cell-border table-hover" width="100%" cellspacing="0">
                    <tbody>
                        <?php

                            for ($i=0; $i < 10; $i++) { 

                                echo '<tr>
                                        <td class="img-pro">
                                            <img src="'.$productos[$i]["Imagen"].'" class="img-thumbnail img-60" alt="'.$productos[$i]["Nombre"].'">
                                        </td>
                                        <td class="pro-name text-left">
                                            <h6>'.$productos[$i]["Nombre"].'</h6>
                                        </td>
                                        <td><label class="label bg-primary text-right">$'.$productos[$i]["PrecioVenta"].'</label></td>
                                    </tr>';
                                        
                            }

                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php 

        if ($_SESSION["rol"] == "Administrador") {

            echo '<div class="card-footer">
                    <a href="productos" class="week-sales text-center">Ver todos los productos <i class="icofont icofont-circled-right"></i></a>
                 </div>';
        }
    ?>
</div>
