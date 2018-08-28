<?php

//require_once "../controladores/notifiaciones.controlador.php";
require_once "../modelos/notificaciones.modelo.php";

class AjaxNotificaciones{

/*==========================================
        ACTUALIZAR NOTIFICACIONES
==========================================*/

	public $item;

		public function ajaxActualizarNotificaciones(){

			$item = $this->item;
  			$valor = 0;
  			$tabla ="Notificaciones";
  			
			$respuesta = ModeloNotificaciones::mdlActualizarNotificaciones($tabla, $item, $valor);

			echo $respuesta;

		}


} //fin class AjaxNotificaciones

/*==================================================================================================================================*/

/*=============================================
		ACTUALIZAR NOTIFICACIONES
==============================================*/

	if (isset($_POST["item"])) {
		
		$actualizar = new AjaxNotificaciones();
		$actualizar -> item = $_POST["item"];
		$actualizar -> ajaxActualizarNotificaciones();

	}