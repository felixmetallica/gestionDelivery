<?php

require_once "../controladores/recetas.controlador.php";
require_once "../modelos/recetas.modelo.php";

class AjaxRecetas{

/*=============================================
        EDITAR RECETA
=============================================*/

    public $idReceta;
    
        public function ajaxEditarReceta(){

        	$item = "RecetaID";

            $valor = $this ->idReceta;

            $respuesta = ControladorRecetas::ctrMostrarRecetas($item, $valor);

            echo json_encode($respuesta);

        	   
		}

/*=============================================
        DETALLE RECETA
=============================================*/

    public $idRecetaDetalle;
        
        public function ajaxRecetaDetalle(){

        	$valor = $this ->idRecetaDetalle;
        	
        	$respuesta = ControladorRecetas::ctrListadoInsumos($valor);

            echo json_encode($respuesta);
            
        }

/*=============================================
		ELIMINAR RECETA
=============================================*/

	public $eliminarReceta;
			
	public function eliminarRecetaAjax(){

		$valor = $this->eliminarReceta;
		
		$respuesta = ControladorRecetas::ctrEliminarReceta($valor);

		echo $respuesta;


	}


}//final clase ajax


/*=============================================
        EDITAR RECETA
=============================================*/

	if (isset($_POST["idReceta"])) {

		$editarReceta = new AjaxRecetas();
		$editarReceta -> idReceta = $_POST["idReceta"];
		$editarReceta -> ajaxEditarReceta();
	}

/*=============================================
        DETALLE RECETA
=============================================*/

	if (isset($_POST["idRecetaDetalle"])) {

		$detalleReceta = new AjaxRecetas();
		$detalleReceta -> idRecetaDetalle = $_POST["idRecetaDetalle"];
		$detalleReceta -> ajaxRecetaDetalle();
	}

/*=============================================
		ELIMINAR RECETA
==============================================*/

	if (isset($_POST["eliminarReceta"])) {
		
		$eliminoReceta = new AjaxRecetas();
		$eliminoReceta -> eliminarReceta = $_POST["eliminarReceta"];
		$eliminoReceta -> eliminarRecetaAjax();

	}

