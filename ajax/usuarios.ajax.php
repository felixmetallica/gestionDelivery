<?php

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";
require_once "../controladores/personas.controlador.php";
require_once "../modelos/personas.modelo.php";

class AjaxUsuarios{

/*===========================================================================================================================
=            												METODOS 												        =
===========================================================================================================================*/

/*=============================================
=            EDITAR USUARIO 		          =
=============================================*/
	public $idUsuario;

	public function ajaxEditarUsuario(){

		 $item = "UsuarioID";
		 $valor = $this ->idUsuario;

		$respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

		echo json_encode($respuesta);

	}

/*=============================================
			ELIMINAR USUARIO
=============================================*/

	public $eliminarUsuario;
	public $eliminarPersona;
	public $eliminarFoto;
	public $eliminarNombre;
	public $idEmpleado;

	public function eliminarUsuarioAjax(){

		$datos = array("usuarioID"=>$this->eliminarUsuario,
					   "personaID"=>$this->eliminarPersona,
					   "foto"=>$this->eliminarFoto,
					   "nombre"=>$this->eliminarNombre,
					   "empleadoID"=>$this->idEmpleado);

		$respuesta = ControladorUsuarios::ctrEliminarUsuario($datos);

		echo $respuesta;

		}

/*=============================================
		     ACTIVAR USUARIO
=============================================*/	
	
	public $estadoUsuario;
	public $activarId;

	public function ajaxActivarUsuario(){

		$tabla1 = "Usuario";
		$tabla2 = "Empleado";

		$item1 = "Activo";
		$valor1 = $this->estadoUsuario;
		$item2 = "UsuarioID";
		$valor2 = $this->activarId;
		$item3 = "EmpleadoID";

		$respuesta = ModeloUsuarios::mdlActualizarUsuario($tabla1, $tabla2, $item1, $valor1, $item2, $valor2, $item3);

		echo ($respuesta);

	}

/*=============================================
			VALIDAR NO REPETIR USUARIO
=============================================*/	

	public $validarUsuario;

	public function ajaxValidarUsuario(){

		$valor = $this->validarUsuario;

		$respuesta = ControladorUsuarios::ctrValidarUsuario($valor);

		echo $respuesta;

		
	}

/*=============================================
			VALIDAR NO REPETIR DNI
=============================================*/

	public $validarDNI;

	public function validarDNIAjax(){

		$valor = $this->validarDNI;

		$respuesta = ControladorPersonas::ctrValidarDNI($valor);

		echo $respuesta;
	}

/*=============================================
			VALIDAR NO REPETIR EMAIL
=============================================*/

	public $validarEmail;
	public $editoEmail;
				
	public function validarEmailAjax(){

		$valor = $this->validarEmail;
		$valor2 = $this->editoEmail;
						
		$respuesta = ControladorPersonas::ctrValidarEmail($valor , $valor2);

		echo $respuesta;
		
	}


}

/*===========================================================================================================================
=            												PETICIONES 												        =
===========================================================================================================================*/

/*=============================================
			EDITAR USUARIO
=============================================*/	

	if (isset($_POST["idUsuario"])) {
		
		$editar = new AjaxUsuarios();
		$editar -> idUsuario = $_POST["idUsuario"];
		$editar -> ajaxEditarUsuario();
	}

/*=============================================
			ELIMINAR USUARIO
=============================================*/

	if (isset($_POST["eliminarUsuario"])) {
		
		$eliminarUsuario = new AjaxUsuarios();
		$eliminarUsuario -> eliminarUsuario = $_POST["eliminarUsuario"];
		$eliminarUsuario -> eliminarPersona = $_POST["eliminarPersona"];
		$eliminarUsuario -> eliminarFoto = $_POST["eliminarFoto"];
		$eliminarUsuario -> eliminarNombre = $_POST["eliminarNombre"];
		$eliminarUsuario -> idEmpleado = $_POST["idEmpleado"];
		$eliminarUsuario -> eliminarUsuarioAjax();

	}

/*=============================================
			ACTIVAR USUARIO
=============================================*/	

	if(isset($_POST["estadoUsuario"])){

		$activarUsuario = new AjaxUsuarios();
		$activarUsuario -> estadoUsuario = $_POST["estadoUsuario"];
		$activarUsuario -> activarId = $_POST["acvivarUsuario"];
		$activarUsuario -> ajaxActivarUsuario();

	}

/*=============================================
			VALIDAR NO REPETIR USUARIO
=============================================*/

	if(isset( $_POST["user"])){

		$valUsuario = new AjaxUsuarios();
		$valUsuario -> validarUsuario = $_POST["user"];
		$valUsuario -> ajaxValidarUsuario();

	}

/*=============================================
			VALIDAR NO REPETIR DNI
=============================================*/

	if (isset($_POST["dniUsuario"])) {
		
		$valDniUsuario = new AjaxUsuarios();
		$valDniUsuario -> validarDNI = $_POST["dniUsuario"];
		$valDniUsuario -> validarDNIAjax();

	}

/*=============================================
			VALIDAR NO REPETIR EMAIL
=============================================*/

	if (isset($_POST["mail"])) {
		
		
		$valEmail = new AjaxUsuarios();
		$valEmail -> validarEmail = $_POST["mail"];
		$valEmail -> editoEmail = "";
		$valEmail -> validarEmailAjax();

	
	}
