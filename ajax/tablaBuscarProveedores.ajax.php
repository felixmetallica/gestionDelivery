<?php 

require_once "../controladores/proveedores.controlador.php";
require_once "../modelos/proveedores.modelo.php";

class TablaProveedoresAjax{

/*=========================================
        CARGAR TABLA PROVEEDORES
=========================================*/

	public function mostrarTablaAjax(){

		$item = null;

        $valor = null;

        $proveedores = ControladorProveedores::ctrMostrarProveedores($item, $valor);

        
        echo '{
				  "data": [';

				  for ($i=0; $i < count($proveedores)-1 ; $i++) { 


			echo   '[
				      "'.($i+1).'",
				      "'.$proveedores[$i]["RazonSocial"].'",
				      "'.$proveedores[$i]["CUITT"].'",
				      "'.$proveedores[$i]["Rubro"].'",
				      "'.$proveedores[$i]["Prefijo"].' - '.$proveedores[$i]["NroTelefono"].'",
				      "'.$proveedores[$i]["ProveedorID"].'"

				    ],';



				  }
				    
			echo '[
				      "'.count($proveedores).'",
				      "'.$proveedores[count($proveedores)-1]["RazonSocial"].'",
				      "'.$proveedores[count($proveedores)-1]["CUITT"].'",
				      "'.$proveedores[count($proveedores)-1]["Rubro"].'",
				      "'.$proveedores[count($proveedores)-1]["Prefijo"].' - '.$proveedores[$i]["NroTelefono"].'",
				      "'.$proveedores[count($proveedores)-1]["ProveedorID"].'"
				    ]
				    				    
				  ]

				}';


	}




}


/*=========================================
         CARGAR TABLA PROVEEDORES
=========================================*/

	$activar = new TablaProveedoresAjax();
	$activar -> mostrarTablaAjax();