<?php 

require_once "../controladores/almacen.controlador.php";
require_once "../modelos/almacen.modelo.php";

class TablaAlmacenAjax{

/*=========================================
        CARGAR TABLA CLIENTES
=========================================*/

	public function mostrarTablaAjax(){

		$item = null;

        $valor = null;

        $clientes = ControladorAlmacen::ctrMostrarMovimientos($item, $valor);


        echo '{
				  "data": [';

				  for ($i=0; $i < count($clientes)-1 ; $i++) { 


			echo   '[
				      "'.($i+1).'",
				      "'.$clientes[$i]["Nombre"].'",
				      "'.$clientes[$i]["Apellido"].'",
				      "'.$clientes[$i]["Calle"].'",
				      "'.$clientes[$i]["Nro"].'",
				      "'.$clientes[$i]["Piso"].'",
				      "'.$clientes[$i]["Dpto"].'",
				      "'.$clientes[$i]["Prefijo"].' - '.$clientes[$i]["NroTelefono"].'",
				     
				      "'.$clientes[$i]["ClienteID"].'"

				    ],';



				  }
				    
			echo '[
				      "'.count($clientes).'",
				      "'.$clientes[count($clientes)-1]["Nombre"].'",
				      "'.$clientes[count($clientes)-1]["Apellido"].'",
				      "'.$clientes[count($clientes)-1]["Calle"].'",
				      "'.$clientes[count($clientes)-1]["Nro"].'",
				      "'.$clientes[count($clientes)-1]["Piso"].'",
				      "'.$clientes[count($clientes)-1]["Dpto"].'",
				      "'.$clientes[count($clientes)-1]["Prefijo"].' - '.$clientes[$i]["NroTelefono"].'",
				      
				      "'.$clientes[count($clientes)-1]["ClienteID"].'"
				    ]
				    				    
				  ]

				}';


	}




}


/*=========================================
        CARGAR TABLA CLIENTES
=========================================*/

	$activar = new TablaAlmacenAjax();
	$activar -> mostrarTablaAjax();