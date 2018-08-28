<?php 

	require_once "../controladores/personas.controlador.php";
	require_once "../modelos/personas.modelo.php";

class AjaxPersonas{

/*=============================================
	        MOSTRAR PERSONA 		          
=============================================*/
	
	public $idPersona;

		public function ajaxMostrarPersona(){

			$item = "PersonaID";

			$valor = $this ->idPersona;
		
			$respuesta = ControladorPersonas::ctrMostrarPersona($item, $valor);

			echo json_encode($respuesta);

	}

/*=============================================
	        MOSTRAR DOMICILIO 		          
=============================================*/
	
	public $domicilio;
	public $tipo1;

		public function ajaxMostrarDomicilio(){

			$traer = $this ->tipo1;

			if ($traer == "Persona") {
				
				$item = "PersonaID";

			} elseif ($traer == "Proveedor") {
				
				$item = "ProveedorID";

			}else{
				
				$item = "PuntoVentaID";

			}

			$valor = $this ->domicilio;
		
			$respuesta = ControladorPersonas::ctrMostrarDomicilio($item, $valor);

			echo json_encode($respuesta);

	}

/*=============================================
	        MOSTRAR TELEFONO 		          
=============================================*/
	
	public $telefono;
	public $tipo2;

		public function ajaxMostrarTelefono(){

			$traer = $this ->tipo2;

			if ($traer == "Persona") {
				
				$item = "PersonaID";

			} elseif ($traer == "Proveedor") {
				
				$item = "ProveedorID";

			}else{
				
				$item = "PuntoVentaID";

			}

			$valor = $this ->telefono;
		
			$respuesta = ControladorPersonas::ctrMostrarTelefono($item, $valor);

			echo json_encode($respuesta);

	}

} 

/*==================================================================================================================

/*=============================================
			MOSTRAR PERSONA
=============================================*/	

	if (isset($_POST["idPersona"])) {
		
		$editar = new AjaxPersonas();
		$editar -> idPersona = $_POST["idPersona"];
		$editar -> ajaxMostrarPersona();
	}

/*=============================================
			MOSTRAR DOMICILIO
=============================================*/	

	if (isset($_POST["Domicilio"])) {
		
		$mostrarDomicilio = new AjaxPersonas();
		$mostrarDomicilio -> domicilio = $_POST["Domicilio"];
		$mostrarDomicilio -> tipo1 = $_POST["Tipo"];
		$mostrarDomicilio -> ajaxMostrarDomicilio();
	}

/*=============================================
			MOSTRAR TELEFONO
=============================================*/	

	if (isset($_POST["Telefono"])) {
		
		$editar = new AjaxPersonas();
		$editar -> telefono = $_POST["Telefono"];
		$editar -> tipo2 = $_POST["Tipo"];
		$editar -> ajaxMostrarTelefono();
	}