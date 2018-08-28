<?php

$item = null;
$valor = null;

$clientes = ControladorClientes::ctrMostrarClientes($item, $valor);

?>
<!--=====================================
        COMPRADORES
======================================-->
<div class="card">
    <div class="card-header">
        <h3 class="card-header-text">Clientes con más pedidos</h3>
    </div>
    <div class="card-block">
        <div class="box-body chart-responsive">
            <div class="chart" id="bar-chart2" style="height: 300px;"></div>
        </div>
    </div>
</div>

<script>
	
    //BAR CHART
    
    var bar = new Morris.Bar({
    element: 'bar-chart2',
    resize: true,
    data: [

    <?php
    
        foreach($clientes as $key => $value){

            if ($value["Compras"] > 0) {

                echo "{y: '".$value["Nombre"]." ".$value["Apellido"]."', a: '".$value["Compras"]."'},";
        
            }
        }

    ?>
    ],
    barColors: ['#FB6843'],
    xkey: 'y',
    ykeys: ['a'],
    labels: ['Pedidos'],
    hideHover: 'auto'
    });

</script>