<?php

    $item = null;
    $valor = null;
    $orden = "ProductoID";

    $ventas = ControladorVentas::ctrSumaTotalVentas();
    
    $pedidos =ControladorClientes::ctrSumaTotalPedidos();

    $clientes = ControladorClientes::ctrMostrarClientes($item, $valor);
    $totalClientes = count($clientes);

    $productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);
    $totalProductos = count($productos);

?>
<div class="col-md-6 col-xl-3">
    <div class="card bg-c-blue order-card">
        <div class="card-block">
            <h6>Total de Ventas</h6>
            <h2>$<?php echo number_format($ventas["total"],2);  ?></h2>
            <i class="card-icon icofont icofont-cur-dollar"></i>
        </div>
    </div>
</div>
<div class="col-md-6 col-xl-3">
    <div class="card bg-c-green order-card">
        <div class="card-block">
            <h6>Total de pedidos</h6>
            <h2><?php echo $pedidos["pedidos"]; ?></h2>
            <i class="card-icon icofont icofont-spoon-and-fork"></i>
        </div>
    </div>
</div>

<div class="col-md-6 col-xl-3">
    <div class="card bg-c-red order-card">
        <div class="card-block">
            <h6>Total de clientes</h6>
            <h2><?php echo $totalClientes ?></h2>
            <i class="card-icon feather icon-users"></i>
        </div>
    </div>
</div>

<div class="col-md-6 col-xl-3">
    <div class="card bg-c-yellow order-card">
        <div class="card-block">
            <h6>Total de productos</h6>
            <h2><?php echo $totalProductos; ?></h2>
            <i class="card-icon icofont icofont-cart-alt"></i>
        </div>
    </div>
</div>

