<?php

class ControladorPlantilla{

/*=============================================
	LLAMAMOS LA PLANTILLA
=============================================*/	

	public function ctrPlantilla(){

		include "vistas/plantilla.php";

	}

/*=============================================
	RUTA LADO DEL SERVIDOR
=============================================*/	

	public function ctrRutaServidor(){

		return "http://localhost/GESTION/";
	
	}

}