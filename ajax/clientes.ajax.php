<?php 

	require_once "../controladores/clientes.controlador.php";
	require_once "../modelos/clientes.modelo.php";
	require_once "../controladores/personas.controlador.php";
	require_once "../modelos/personas.modelo.php";

class AjaxClientes{

/*=============================================
	        EDITAR CLIENTE 		          
=============================================*/
	
	public $idCliente;

		public function ajaxEditarCliente(){

			$item = "ClienteID";

			$valor = $this ->idCliente;
		
			$respuesta = ControladorClientes::ctrMostrarClientes($item, $valor);

			echo json_encode($respuesta);

	}

/*=============================================
			ELIMINAR CLIENTE
=============================================*/

	public $eliminarCliente;
	public $eliminarPersona;
	
	public function eliminarClienteAjax(){

		$cliente = $this->eliminarCliente;
				
		$respuesta = ControladorClientes::ctrEliminarCliente($cliente);

		echo $respuesta;
	}

/*=============================================
			ACTIVAR/DESACTIVAR CLIENTE
=============================================*/	

	public $estadoCliente;
	public $activarId;


	public function ajaxActivarCliente(){

		$tabla = "Cliente";

		$item1 = "Activo";
		$valor1 = $this->estadoCliente;

		$item2 = "ClienteID";
		$valor2 = $this->activarId;

				
		$respuesta = ModeloClientes::mdlActivarCliente($tabla, $item1, $valor1, $item2, $valor2);

		
		}

/*=============================================
            TRAER BARRIOS            
=============================================*/

	public $traerBarrio;
		
		public function traerBarrioAjax(){

			$datos = $this->traerBarrio;

			$respuesta = ControladorPersonas::ctrListarBarrios($datos);

			echo json_encode($respuesta);

		}

/*=============================================
	        TRAER LOCALIDADES        
=============================================*/

	public $traerLocalidaes;
		
		public function traerLocalidadesAjax(){

			$datos = $this->traerLocalidaes;

			$respuesta = ControladorPersonas::ctrListarLocalidades($datos);

			echo json_encode($respuesta);

		}

} 

/*==================================================================================================================

/*=============================================
			EDITAR CLIENTE
=============================================*/	

	if (isset($_POST["idCliente"])) {
		
		$editar = new AjaxClientes();
		$editar -> idCliente = $_POST["idCliente"];
		$editar -> ajaxEditarCliente();
	}

/*=============================================
			ELIMINAR CLIENTE
==============================================*/

	if (isset($_POST["eliminarCliente"])) {
		
		$eliminoCliente = new AjaxClientes();
		$eliminoCliente -> eliminarCliente = $_POST["eliminarCliente"];
		$eliminoCliente -> eliminarClienteAjax();

	}

/*=============================================
			ACTIVAR/DESACTIVAR CLIENTE
=============================================*/	

	if(isset($_POST["estadoCliente"])){

		$actiCliente = new AjaxClientes();
		$actiCliente -> estadoCliente = $_POST["estadoCliente"];
		$actiCliente -> activarId = $_POST["activarCliente"];
		$actiCliente -> ajaxActivarCliente();
	}	

/*=============================================
			TRAER BARRIOS
=============================================*/

	if (isset($_POST["TablaB"])) {
		
		$traerB = new AjaxClientes();
		$traerB -> traerBarrio = $_POST["TablaB"];
		$traerB -> traerBarrioAjax();

	}

/*=============================================
			TRAER LOCALIDADES
=============================================*/

	if (isset($_POST["TablaL"])) {
		
		$traerB = new AjaxClientes();
		$traerB -> traerLocalidaes = $_POST["TablaL"];
		$traerB -> traerLocalidadesAjax();

	}
