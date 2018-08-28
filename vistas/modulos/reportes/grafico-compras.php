<?php 

    if (isset($_GET["fechaInicial"])) {

        $fechaInicial = $_GET["fechaInicial"];
        $fechaFinal = $_GET["fechaFinal"];

    } else {

        $fechaInicial = "1900-01-01";
        $fechaFinal = "2090-01-01";

    }

    $respuesta = ControladorCompras::ctrRangoFechaComprasGrafico($fechaInicial, $fechaFinal);


?>

<!--=======================================
=            GRAFICO DE COMPRAS            =
========================================-->

<div class="card" style="background: #39cccc !important; background: -webkit-gradient(linear, left bottom, left top, color-stop(0, #39cccc), color-stop(1, #7adddd)) !important; background: -ms-linear-gradient(bottom, #39cccc, #7adddd) !important;  background: -moz-linear-gradient(center bottom, #39cccc 0, #7adddd 100%) !important;  background: -o-linear-gradient(#7adddd, #39cccc) !important; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#7adddd', endColorstr='#39cccc', GradientType=0) !important;color: #fff">

    <div class="card-header">
        <i class="icofont icofont-chart-histogram" style="color: #fff"></i> <h5 class="card-header-text" style="color: #fff">Gráfico de compras</h5>
    </div>
    <div class="card-block nuevoGraficoVentas">
        <div id="line-chart-compras" style="height: 250px;"></div>
    </div>
</div>

<script>

	var line = new Morris.Line({
    element          : 'line-chart-compras',
    resize           : true,
    data             : [
      
    <?php 

        if ($respuesta != null) {

            foreach ($respuesta as $key => $value) {
            
                echo "{ y: '".$value["Periodo"]."', compras: ".$value["TotalCompras"]." },";

            }

            echo "{ y: '".$value["Periodo"]."', compras: ".$value["TotalCompras"]." }";

        } else {

            echo "{ y: '0', compras: '0' }";

        }
         
    ?>
         
    
    ],
    xkey             : 'y',
    ykeys            : ['compras'],
    labels           : ['compras'],
    lineColors       : ['#efefef'],
    lineWidth        : 2,
    hideHover        : 'auto',
    gridTextColor    : '#fff',
    gridStrokeWidth  : 0.4,
    pointSize        : 4,
    pointStrokeColors: ['#efefef'],
    gridLineColor    : '#efefef',
    gridTextFamily   : 'Open Sans',
    preUnits		 : '$',
    gridTextSize     : 10
  });


</script>