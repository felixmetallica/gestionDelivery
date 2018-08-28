<?php 

error_reporting(0);

	if (isset($_GET["fechaInicial"])) {

		$fechaInicial = $_GET["fechaInicial"];
		$fechaFinal = $_GET["fechaFinal"];

	} else {

		$fechaInicial = null;
		$fechaFinal = null;

	}

	$respuesta = ControladorVentas::ctrRangoFechaVentas($fechaInicial, $fechaFinal);

	$arrayFechas = array();
	$arrayVentas = array();
	$sumaPagosMes = array();

	foreach ($respuesta as $key => $value) {

		#capturamos solo el año, el mes de la venta
		$fecha = substr($value["FechaVenta"], 0,7);

		#Introducimos las fechas en el array
		array_push($arrayFechas, $fecha);

		#Capturamos las ventas
		$arrayVentas = array($fecha => $value["Total"]);;

		#Sumamos las ventas que ocurrieron en el mismo mes

		foreach ($arrayVentas as $key => $value) {
			
			$sumaPagosMes[$key] += $value;

		}

	}

	$noRepetirFechas = array_unique($arrayFechas);
	
?>

<!--=======================================
=            GRAFICO DE VENTAS            =
========================================-->

<div class="card" style="background: #39cccc !important; background: -webkit-gradient(linear, left bottom, left top, color-stop(0, #39cccc), color-stop(1, #7adddd)) !important; background: -ms-linear-gradient(bottom, #39cccc, #7adddd) !important;  background: -moz-linear-gradient(center bottom, #39cccc 0, #7adddd 100%) !important;  background: -o-linear-gradient(#7adddd, #39cccc) !important; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#7adddd', endColorstr='#39cccc', GradientType=0) !important;color: #fff">

    <div class="card-header">
        <i class="icofont icofont-chart-histogram" style="color: #fff"></i> <h5 class="card-header-text" style="color: #fff">Gráfico de Ventas</h5>
    </div>
    <div class="card-block nuevoGraficoVentas">
        <div id="line-chart-ventas" style="height: 250px;"></div>
    </div>
</div>

<script>

	var line = new Morris.Line({
    element          : 'line-chart-ventas',
    resize           : true,
    data             : [
      
    <?php 

    	if ($noRepetirFechas != null) {

    		foreach ($noRepetirFechas as $key) {
    		
    			echo "{ y: '".$key."', ventas: ".$sumaPagosMes[$key]." },";

    		}

    		echo "{ y: '".$key."', ventas: ".$sumaPagosMes[$key]." }";

    	} else {

    		echo "{ y: '0', ventas: '0' }";

    	}
         
    ?>

    ],
    xkey             : 'y',
    ykeys            : ['ventas'],
    labels           : ['ventas'],
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