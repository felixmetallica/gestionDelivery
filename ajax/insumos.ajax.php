<?php 

require_once "../controladores/insumos.controlador.php";
require_once "../modelos/insumos.modelo.php";

class AjaxInsumos{

/*==========================================
        ASIGNAR CODIGO A INSUMO
==========================================*/

	public $idRubro;

		public function ajaxCrearCodigoInsumo(){

			$item = "RubroID";
  			$valor = $this->idRubro;
  			
			$respuesta = ControladorInsumos::ctrMostrarInsumos($item, $valor);

			echo json_encode($respuesta);

		}

/*=============================================
        EDITAR INSUMO
=============================================*/

    public $idEditarInsumo;
    public $traerInsumos;

        public function ajaxEditarInsumo(){

           if ($this->traerInsumos == "ok") {
        	   
        		$respuesta = ControladorInsumos::ctrMostrarInsumosDisponibles();

            	echo json_encode($respuesta);

        	} else {

        	$item = "InsumosID";

            $valor = $this ->idEditarInsumo;

            $respuesta = ControladorInsumos::ctrMostrarInsumos($item, $valor);

            echo json_encode($respuesta);

        	}   

        }

/*=============================================
		ELIMINAR INSUMO
=============================================*/

	public $eliminarinsumo;
			
	public function eliminarInsumoAjax(){

		$insumo = $this->eliminarinsumo;
		
		$respuesta = ControladorInsumos::ctrEliminarInsumo($insumo);

		echo $respuesta;


	}


}

/*==========================================
        ASIGNAR CODIGO A INSUMO
==========================================*/

	if (isset($_POST["idRubro"])) {
		
		$codigoProducto = new AjaxInsumos();
		$codigoProducto -> idRubro = $_POST["idRubro"];
		$codigoProducto -> ajaxCrearCodigoInsumo();
		
	}
/*=============================================
        EDITAR INSUMO
=============================================*/

	if (isset($_POST["idEditarInsumo"])) {

		$editoInsumo = new AjaxInsumos();
		$editoInsumo -> idEditarInsumo = $_POST["idEditarInsumo"];
		$editoInsumo -> ajaxEditarInsumo();
	}

/*=============================================
		ELIMINAR INSUMO
==============================================*/

	if (isset($_POST["eliminarinsumo"])) {
		
		$eliminoInsumo = new AjaxInsumos();
		$eliminoInsumo -> eliminarinsumo = $_POST["eliminarinsumo"];
		$eliminoInsumo -> eliminarInsumoAjax();

	}

/*=============================================
		MOSTRAR INSUMOS DISPONIBLES
=============================================*/	

	if(isset($_POST["traerInsumos"])){

		$traerInsumosDisponibles = new AjaxInsumos();
		$traerInsumosDisponibles -> traerInsumos = $_POST["traerInsumos"];
		$traerInsumosDisponibles -> ajaxEditarInsumo();
	}