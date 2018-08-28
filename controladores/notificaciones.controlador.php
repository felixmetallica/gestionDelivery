<?php

Class ControladorNotificaciones{

/*==========================================
            MOSTRAR NOTIFICACIONES 				
==========================================*/

	static public function ctrMostrarNotificaciones(){

		$tabla = "Notificaciones";

		$respuesta = ModeloNotificaciones::mdlMostrarNotificaciones($tabla);

		return $respuesta;
	}	


}