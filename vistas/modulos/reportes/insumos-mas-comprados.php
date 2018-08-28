<?php

    $item = null;
    $valor = null;
    $orden = "Ventas";

    $productos = ControladorInsumos::ctrListarProductos($item, $valor, $orden);

    $colores = array('red','green','yellow','aqua','purple','blue','pink','magenta','orange','gold');

    $totalVentas = ControladorProductos::ctrMostrarSumaVentas();
    
?>
<!--=====================================
        INSUMOS MAS COMPRADOS
======================================-->
<div class="card">
    <div class="card-header">
        <h4 class="card-header-text">Insumos más Comprados</h4>
    </div>
    <div class="card-block">
		<div class="row">
			<div class="col-md-7">
				<div class="chart-responsive">
					<canvas id="pieChart" height="312"></canvas>
				</div>
			</div>
			<div class="col-md-5">
			    <ul class="chart-legend clearfix">
				
                    <?php

                        for ($i=0; $i < 10; $i++) { 
                    
                            echo '<li><i class="fa fa-circle-o text-'.$colores[$i].'"></i> '.$productos[$i]["Nombre"].'</li>';

                        }

                    ?>	
					
				</ul>
			</div>
		</div>
	</div>
	<div class="card-footer no-padding">
		<div class="table-responsive">
            <div class="table-content">
                <div class="project-table">
                    <table id="product-list" class="table dt-responsive cell-border table-hover" width="100%" cellspacing="0">
                        <tbody>
                            
                            <?php

                                for ($i=0; $i < 5; $i++) { 

                                  echo '<tr>
                                            <td class="img-pro">
                                                <img src="'.$productos[$i]["Imagen"].'" class="img-thumbnail img-60" alt="'.$productos[$i]["Nombre"].'">
                                            </td>
                                            <td class="pro-name">
                                                <h6>'.$productos[$i]["Nombre"].'</h6>
                                            </td>
                                            <td>
                                                <span class="pull-right text-'.$colores[$i].'"><i class="fa fa-angle-up"></i> '.ceil($productos[$i]["Ventas"]*100/$totalVentas["total"]).'%</span>
                                            </td>
                                        </tr>';  

                                }

                            ?>
                    
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
	</div>
</div>

<script>
// -------------
  // - PIE CHART -
  // -------------
  // Get context with jQuery - using jQuery's .get() method.
  var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
  var pieChart       = new Chart(pieChartCanvas);
  var PieData        = [
    
    <?php

        for ($i=0; $i < 10; $i++) { 
            
            echo"{
                  value    : ".$productos[$i]["Ventas"].",
                  color    : '".$colores[$i]."',
                  highlight: '".$colores[$i]."',
                  label    : '".$productos[$i]["Nombre"]."'
                },";

        }

    ?>

  ];
  var pieOptions     = {
    // Boolean - Whether we should show a stroke on each segment
    segmentShowStroke    : true,
    // String - The colour of each segment stroke
    segmentStrokeColor   : '#fff',
    // Number - The width of each segment stroke
    segmentStrokeWidth   : 1,
    // Number - The percentage of the chart that we cut out of the middle
    percentageInnerCutout: 50, // This is 0 for Pie charts
    // Number - Amount of animation steps
    animationSteps       : 100,
    // String - Animation easing effect
    animationEasing      : 'easeOutBounce',
    // Boolean - Whether we animate the rotation of the Doughnut
    animateRotate        : true,
    // Boolean - Whether we animate scaling the Doughnut from the centre
    animateScale         : false,
    // Boolean - whether to make the chart responsive to window resizing
    responsive           : true,
    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    maintainAspectRatio  : false,
    // String - A legend template
    legendTemplate       : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<segments.length; i++){%><li><span style=\'background-color:<%=segments[i].fillColor%>\'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
    // String - A tooltip template
    tooltipTemplate      : '<%=value %> <%=label%>'
  };
  // Create pie or douhnut chart
  // You can switch between pie and douhnut using the method below.
  pieChart.Doughnut(PieData, pieOptions);
  // -----------------
  // - END PIE CHART -
  // -----------------	

</script>
