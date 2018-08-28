<?php 

require_once "../controladores/payment.controlador.php";
require_once "../modelos/payment.modelo.php";

class TablaLiquidacionGrupalAjax{

/*=========================================
        CARGAR TABLA LIQUIDACION GRUPAL
=========================================*/

	public function mostrarTablaAjax(){

		$liquidaciones = ControladorPayment::ctrMostrarLiquidacionesConfeccionadas();

		if (count($liquidaciones) > 0) {
			
		    echo '{
				  "data": [';

				  for ($i=0; $i < count($liquidaciones)-1 ; $i++) { 


			echo   '[
				      
					  "'.$liquidaciones[$i]["LiquidacionID"].'",
				      "'.$liquidaciones[$i]["Tipo"].'",
				      "'.$liquidaciones[$i]["Mes"].' '.$liquidaciones[$i]["Anio"].'",
				      "'.$liquidaciones[$i]["Nombre"].' '.$liquidaciones[$i]["Apellido"].'",
				      "'.$liquidaciones[$i]["FechaConfeccion"].'",
				      "$'.$liquidaciones[$i]["TotalNeto"].'",
				      "'.$liquidaciones[$i]["LiquidacionID"].'"
				      
				    ],';



				  }
				    
			echo '[
				      "'.$liquidaciones[count($liquidaciones)-1]["LiquidacionID"].'",
				      "'.$liquidaciones[count($liquidaciones)-1]["Tipo"].'",
				      "'.$liquidaciones[count($liquidaciones)-1]["Mes"].' '.$liquidaciones[$i]["Anio"].'",
				      "'.$liquidaciones[count($liquidaciones)-1]["Nombre"].' '.$liquidaciones[$i]["Apellido"].'",
				      "'.$liquidaciones[count($liquidaciones)-1]["FechaConfeccion"].'",
				      "$'.$liquidaciones[count($liquidaciones)-1]["TotalNeto"].'"
				      
				      
				    ]
				    				    
				  ]

				}';

		} else {

			echo '{
				  "data": [] }';


		}


	}




}


/*=========================================
        CARGAR TABLA LIQUIDACION GRUPAL
=========================================*/

	$activar = new TablaLiquidacionGrupalAjax();
	$activar -> mostrarTablaAjax();