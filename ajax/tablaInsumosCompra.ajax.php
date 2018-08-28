<?php 

require_once "../controladores/insumos.controlador.php";
require_once "../modelos/insumos.modelo.php";

class TablaIsumosAjax{

/*=========================================
        CARGAR TABLA INSUMOS
=========================================*/

	public function mostrarTablaAjax(){

		$item = null;
		$valor = null;
		
		$insumos = ControladorInsumos::ctrMostrarInsumosCompra($item, $valor);

		
        echo '{
				  "data": [';

				  for ($i=0; $i < count($insumos)-1 ; $i++) { 

			echo   '[
				      "'.($i+1).'",
				      "'.$insumos[$i]["Codigo"].'",
				      "'.$insumos[$i]["Nombre"].'",
				     
				      "'.$insumos[$i]["Id"].'.'.$insumos[$i]["Tipo"].'"
				    ],';

				  }
				    
			echo '[
				      "'.count($insumos).'",
				      "'.$insumos[count($insumos)-1]["Codigo"].'",
				      "'.$insumos[count($insumos)-1]["Nombre"].'",
				     
				      "'.$insumos[count($insumos)-1]["Id"].'.'.$insumos[$i]["Tipo"].'"

				    ]
				    				    
				  ]

				}';

	}


}


/*=========================================
        CARGAR TABLA INSUMOS
=========================================*/

	$activar = new TablaIsumosAjax();
	$activar -> mostrarTablaAjax();