<?php

class ControladorPersonas{

/*=============================================
			MOSTRAR PERSONA   		  
=============================================*/

	static public function ctrMostrarPersona($item, $valor){

		$tabla = "Persona";
		
		$respuesta = ModeloPersonas::mdlMostrarPersona($tabla, $item, $valor);

		return $respuesta;

	}

/*=============================================
			MOSTRAR EMAIL   		  
=============================================*/

	static public function ctrMostrarEmail($item, $valor){

		$tabla = "Email";
		
		$respuesta = ModeloPersonas::mdlMostrarEmail($tabla, $item, $valor);

		return $respuesta;

	}

/*=============================================
			VALIDAR DNI EXISTENTE   		  
=============================================*/

	static public function ctrValidarDNI($validarDNI){

		$datosController = $validarDNI;
		$respuesta = ModeloPersonas::mdlValidarDNI($datosController, "Persona");

		if(count($respuesta["DNI"]) > 0){
			#EL DNI EXISTE POR LO TANTO NO ESTA DISPONIBLE
			echo "false";
		}else{
			#EL DNI NO EXISTE Y POR LO TANTO ESTARA DISPONIBLE
			echo "true";
		}
	
	}

/*=============================================
			VALIDAR EMAIL EXISTENTE  		  
=============================================*/

	static public function ctrValidarEmail($validarEMAIL){

		$datosController = $validarEMAIL;
		$respuesta = ModeloPersonas::mdlValidarEmail($datosController, "Email");

		if(count($respuesta["Email"]) > 0){
			#EL EMAIL EXISTE POR LO TANTO NO ESTA DISPONIBLE
			echo "false";
		}else{
			#EL EMAIL NO EXISTE Y POR LO TANTO ESTARA DISPONIBLE
			echo "true";
		}
	
	}

/*=============================================
			LISTADO DE BARRIOS            
=============================================*/

	static public function ctrListarBarrios($datos){

		$tabla = $datos;

		$respuesta = ModeloPersonas::mdlListarBarrios($tabla);
			
			 $array= $respuesta;
						 
			 return $array;

	}

/*=============================================
	        LISTADO DE LOCALIDADES        
=============================================*/

	static public function ctrListarLocalidades($datos){

		$tabla = $datos;

		$respuesta = ModeloPersonas::mdlListarLocalidades($tabla);
			
			 $array= $respuesta;
						 
			 return $array;
	}

/*==========================================
            MOSTRAR DOMICILIO 			   
==========================================*/

	static public function ctrMostrarDomicilio($item, $valor){

		$tabla1 = "Domicilio";
		$tabla2= "Localidad";
		$tabla3 = "Barrio";

		$respuesta = ModeloPersonas::mdlMostrarDomicilio($tabla1, $tabla2, $tabla3, $item, $valor);

		return $respuesta;

	}

/*==========================================
            MOSTRAR TELEFONO 			   
==========================================*/

	static public function ctrMostrarTelefono($item, $valor){

		$tabla = "Telefono";
		
		$respuesta = ModeloPersonas::mdlMostrarTelefono($tabla, $item, $valor);

		return $respuesta;

	}

}