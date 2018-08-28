<?php 

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

class TablaProductosAjax{

/*=========================================
        CARGAR TABLA PRODUCTOS
=========================================*/

	public function mostrarTablaAjax(){

		
        $productos = ControladorProductos::ctrMostrarProductosDisponibles();

        echo '{
				  "data": [';

				  for ($i=0; $i < count($productos)-1 ; $i++) { 


			echo   '[
				      "'.($i+1).'",
				      "'.$productos[$i]["Imagen"].'",
				      "'.$productos[$i]["Codigo"].'",
				      "'.$productos[$i]["Nombre"].'",
				      "'.$productos[$i]["Stock"].'",
				      "'.$productos[$i]["ProductoID"].'"
				    ],';

				  }
				    
			echo '[
				      "'.count($productos).'",
				      "'.$productos[count($productos)-1]["Imagen"].'",
				      "'.$productos[count($productos)-1]["Codigo"].'",
				      "'.$productos[count($productos)-1]["Nombre"].'",
				      "'.$productos[count($productos)-1]["Nombre"].'",
				      "'.$productos[count($productos)-1]["ProductoID"].'"
				    ]
				    				    
				  ]

				}';

	}

}

/*=========================================
        CARGAR TABLA PRODUCTOS
=========================================*/

	$activar = new TablaProductosAjax();
	$activar -> mostrarTablaAjax();