<?php

require_once "../controladores/empleados.controlador.php";
require_once "../modelos/empleados.modelo.php";
require_once "../controladores/personas.controlador.php";
require_once "../modelos/personas.modelo.php";
require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";
require_once "../controladores/configuracion.controlador.php";
require_once "../modelos/configuracion.modelo.php";

class AjaxEmpleados{

/*=============================================
			CREAR EMPLEADO			         
=============================================*/
	
	public $nombreEmpleado;
	public $apellidoEmpleado;
	public $dniEmpleado;
	public $emailEmpleado;
	public $fechaEmpleado;
	public $sexoEmpleado;
	public $calleEmpleado;
	public $numCalleEmpleado;
	public $pisoEmpleado;
	public $deptoEmpleado;
	public $localidadEmpleado;
	public $barrioEmpleado;
	public $codPostalEmpleado;
	public $codAreaTelefonoEmpleado;
	public $numeroTeléfonoEmpleado;
	public $legajoEmpleado;
	public $fechaIngresoEmpleado;
	public $puestoEmpleado;
	public $categoriaEmpleado;
	public $cuilEmpleado;

	public function ajaxCrearEmpleado(){

		$nombre = $this ->nombreEmpleado;
		$apellido = $this ->apellidoEmpleado;
		$dni = $this ->dniEmpleado;
		$email = $this ->emailEmpleado;
		$fecha = $this ->fechaEmpleado;
		$sexo = $this ->sexoEmpleado;
		$calle = $this ->calleEmpleado;
		$numeroCalle = $this ->numCalleEmpleado;
		$piso = $this ->pisoEmpleado;
		$depto = $this ->deptoEmpleado;
		$localidad = $this ->localidadEmpleado;
		$barrio = $this ->barrioEmpleado;
		$codPostal = $this ->codPostalEmpleado;
		$codArea = $this ->codAreaTelefonoEmpleado;
		$telefono = $this ->numeroTeléfonoEmpleado;
		$fechaIngreso = $this ->fechaIngresoEmpleado;
		$legajo = $this ->legajoEmpleado;
		$puesto = $this ->puestoEmpleado;
		$categoria = $this ->categoriaEmpleado;
		$cuil = $this ->cuilEmpleado;

		$datos = array("nombre"=> ucwords($nombre),
					 "apellido" =>ucwords($apellido),
					 "dni"=> $dni,
					 "email"=> $email,
					 "fecha"=> $fecha,
					 "sexo"=> $sexo,
					 "calle" => ucwords($calle),
					 "numeroCalle"=> $numeroCalle,
					 "piso"=> $piso,
					 "depto"=> ucwords($depto),
					 "localidad" =>ucwords($localidad),
					 "barrio"=> ucwords($barrio),
					 "codPostal" =>$codPostal,
					 "codArea"=> $codArea,
					 "telefono"=> $telefono,
					 "legajo"=> $legajo,
					 "fechaIngreso"=> $fechaIngreso,
					 "puesto"=> $puesto,
					 "categoria"=> $categoria,
					 "cuil"=> $cuil);
	
		$respuesta = ControladorEmpleados::ctrRegistrarEmpleado($datos);

		echo json_encode ($respuesta);

	}

/*=============================================
			MODIFICAR EMPLEADO			     
=============================================*/
	
	public $eidEmpleado;
	public $eidPersona;
	public $enombreEmpleado;
	public $eapellidoEmpleado;
	public $edniEmpleado;
	public $eEmailEmpleado;
	public $efechaEmpleado;
	public $esexoEmpleado;
	public $ecalleEmpleado;
	public $enumCalleEmpleado;
	public $episoEmpleado;
	public $edeptoEmpleado;
	public $elocalidadEmpleado;
	public $ebarrioEmpleado;
	public $ecodPostalEmpleado;
	public $ecodAreaTelefonoEmpleado;
	public $enumeroTeléfonoEmpleado;
	public $efechaIngresoEmpleado;
	public $epuestoEmpleado;
	public $ecategoriaEmpleado;
	public $ecuilEmpleado;

	public function ajaxModidicarEmpleado(){

		$idEmp = $this->eidEmpleado;
		$idPer = $this ->eidPersona;
		$nombre = $this ->enombreEmpleado;
		$apellido = $this ->eapellidoEmpleado;
		$dni = $this ->edniEmpleado;
		$email = $this ->eEmailEmpleado;
		$fecha = $this ->efechaEmpleado;
		$sexo = $this ->esexoEmpleado;
		$calle = $this ->ecalleEmpleado;
		$numeroCalle = $this ->enumCalleEmpleado;
		$piso = $this ->episoEmpleado;
		$depto = $this ->edeptoEmpleado;
		$localidad = $this ->elocalidadEmpleado;
		$barrio = $this ->ebarrioEmpleado;
		$codPostal = $this ->ecodPostalEmpleado;
		$codArea = $this ->ecodAreaTelefonoEmpleado;
		$telefono = $this ->enumeroTeléfonoEmpleado;
		$fechaIngreso = $this ->efechaIngresoEmpleado;
		$puesto = $this ->epuestoEmpleado;
		$categoria = $this ->ecategoriaEmpleado;
		$cuil = $this ->ecuilEmpleado;

		$datos = array("idEmpleado"=>($idEmp),
						"idPersona"=>($idPer),
						"nombre"=> ucwords($nombre),
						"apellido" =>ucwords($apellido),
						"dni"=> $dni,
						"email"=> $email,
						"fecha"=> $fecha,
						"sexo"=> $sexo,
						"calle" => ucwords($calle),
						"numeroCalle"=> $numeroCalle,
						"piso"=> $piso,
						"depto"=> ucwords($depto),
						"localidad" =>ucwords($localidad),
						"barrio"=> ucwords($barrio),
						"codPostal" =>$codPostal,
						"codArea"=> $codArea,
						"telefono"=> $telefono,
						"fechaIngreso"=> $fechaIngreso,
						"puesto"=> $puesto,
						"categoria"=> $categoria,
						"cuil"=> $cuil);
	
		$respuesta = ControladorEmpleados::ctrModificarEmpleado($datos);

		echo json_encode ($respuesta);

		

	}

/*=============================================
			ELIMINAR EMPLEADO
=============================================*/

	public $eliminarEmpleado;
	public $eliminarPersona;
	public $eliminarUsuario;
	public $eliminarUserImagen;
	public $eliminarUserName;
	public $eliminarEmpleadoImagen;
	
	public function eliminarEmpleadoAjax(){

		$empleado = $this->eliminarEmpleado;
		$persona = $this->eliminarPersona;
		$usuario = $this->eliminarUsuario;
		$imagen = $this->eliminarUserImagen;
		$nombreUser = $this->eliminarUserName;
		$imagenEm = $this->eliminarEmpleadoImagen;
		
		$respuesta = ControladorEmpleados::ctrEliminarEmpleado($empleado, $persona, $usuario, $imagen, $nombreUser, $imagenEm);

		echo $respuesta;
	}

/*=============================================
			TRAER EMPLEADO 		          
=============================================*/
	
	public $idEmpleado;

		public function ajaxTraerEmpleado(){

			$item = "EmpleadoID";

			$valor = $this ->idEmpleado;

			$respuesta = ControladorEmpleados::ctrMostrarEmpleados($item, $valor);

			echo json_encode($respuesta);

	}

/*=============================================
			ACTIVAR/DESACTIVAR EMPLEADO
=============================================*/	

	public $estadoEmpleado;
	public $activarId;


	public function ajaxActivarEmpleado(){

		$tabla1 = "Empleado";
		$tabla2 = "Usuario";

		$item1 = "Activo";
		$valor1 = $this->estadoEmpleado;

		$item2 = "EmpleadoID";
		$valor2 = $this->activarId;

				
		$respuesta = ModeloEmpleados::mdlActualizarEmpleado($tabla1, $tabla2, $item1, $valor1, $item2, $valor2);

		

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
				
	public function validarEmailAjax(){

		$valor = $this->validarEmail;
						
		$respuesta = ControladorPersonas::ctrValidarEmail($valor);

		echo $respuesta;
		
	}

/*=============================================
			VALIDAR NO REPETIR CUIL
=============================================*/

	public $validarCuil;
				
	public function validarCuilAjax(){

		$valor = $this->validarCuil;
						
		$respuesta = ControladorEmpleados::ctrValidarCuil($valor);

		echo $respuesta;
		
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
			TRAER CATEGORIAS SEGUN PUESTO
=============================================*/	

	public $traerCatPuesto;
	public $traerCatPuestoSel;
	
	public function ajaxTraerCategoriaPuesto(){

		$valor = $this->traerCatPuesto;
		$valorSel = $this->traerCatPuestoSel;
		
		$respuesta = ControladorEmpleados::ctrMostrarCategoriasPuestos($valor, $valorSel);

		echo $respuesta;

		
	}


}
/*==================================================================================================================================*/

/*=============================================
			CREAR EMPLEADO
=============================================*/

	if (isset($_POST["nombreEmpleado"])) {
		
		$nuevoEmpleado = new AjaxEmpleados();
		$nuevoEmpleado -> nombreEmpleado = $_POST["nombreEmpleado"];
		$nuevoEmpleado -> apellidoEmpleado = $_POST["apellidoEmpleado"];
		$nuevoEmpleado -> dniEmpleado = $_POST["dniEmpleado"];
		$nuevoEmpleado -> emailEmpleado = $_POST["emailEmpleado"];
		$nuevoEmpleado -> fechaEmpleado = $_POST["fechaEmpleado"];
		$nuevoEmpleado -> sexoEmpleado = $_POST["sexoEmpleado"];
		$nuevoEmpleado -> calleEmpleado = $_POST["calleEmpleado"];
		$nuevoEmpleado -> numCalleEmpleado = $_POST["numCalleEmpleado"];
		$nuevoEmpleado -> pisoEmpleado = $_POST["pisoEmpleado"];
		$nuevoEmpleado -> deptoEmpleado = $_POST["deptoEmpleado"];
		$nuevoEmpleado -> localidadEmpleado = $_POST["localidadEmpleado"];
		$nuevoEmpleado -> barrioEmpleado = $_POST["barrioEmpleado"];
		$nuevoEmpleado -> codPostalEmpleado = $_POST["codPostalEmpleado"];
		$nuevoEmpleado -> codAreaTelefonoEmpleado = $_POST["codAreaTelefonoEmpleado"];
		$nuevoEmpleado -> numeroTeléfonoEmpleado = $_POST["numeroTeléfonoEmpleado"];
		$nuevoEmpleado -> legajoEmpleado = $_POST["legajoEmpleado"];
		$nuevoEmpleado -> fechaIngresoEmpleado = $_POST["fechaIngresoEmpleado"];
		$nuevoEmpleado -> puestoEmpleado = $_POST["puestoEmpleado"];
		$nuevoEmpleado -> categoriaEmpleado = $_POST["categoriaEmpleado"];
		$nuevoEmpleado -> cuilEmpleado = $_POST["cuilEmpleado"];

		$nuevoEmpleado -> ajaxCrearEmpleado();

	}

/*=============================================
			MODIFICAR EMPLEADO
=============================================*/

	if (isset($_POST["eidPersona"])) {


		$editarEmpleado = new AjaxEmpleados();
		$editarEmpleado -> eidEmpleado = $_POST["eidEmpleado"];
		$editarEmpleado -> eidPersona = $_POST["eidPersona"];
		$editarEmpleado -> enombreEmpleado = $_POST["enombreEmpleado"];
		$editarEmpleado -> eapellidoEmpleado = $_POST["eapellidoEmpleado"];
		$editarEmpleado -> edniEmpleado = $_POST["edniEmpleado"];
		$editarEmpleado -> eEmailEmpleado = $_POST["eEmailEmpleado"];
		$editarEmpleado -> efechaEmpleado = $_POST["efechaEmpleado"];
		$editarEmpleado -> esexoEmpleado = $_POST["esexoEmpleado"];
		$editarEmpleado -> ecalleEmpleado = $_POST["ecalleEmpleado"];
		$editarEmpleado -> enumCalleEmpleado = $_POST["enumCalleEmpleado"];
		$editarEmpleado -> episoEmpleado = $_POST["episoEmpleado"];
		$editarEmpleado -> edeptoEmpleado = $_POST["edeptoEmpleado"];
		$editarEmpleado -> elocalidadEmpleado = $_POST["elocalidadEmpleado"];
		$editarEmpleado -> ebarrioEmpleado = $_POST["ebarrioEmpleado"];
		$editarEmpleado -> ecodPostalEmpleado = $_POST["ecodPostalEmpleado"];
		$editarEmpleado -> ecodAreaTelefonoEmpleado = $_POST["ecodAreaTelefonoEmpleado"];
		$editarEmpleado -> enumeroTeléfonoEmpleado = $_POST["enumeroTeléfonoEmpleado"];
		$editarEmpleado -> efechaIngresoEmpleado = $_POST["efechaIngresoEmpleado"];
		$editarEmpleado -> epuestoEmpleado = $_POST["epuestoEmpleado"];
		$editarEmpleado -> ecategoriaEmpleado = $_POST["ecategoriaEmpleado"];
		$editarEmpleado -> ecuilEmpleado = $_POST["ecuilEmpleado"];

		$editarEmpleado -> ajaxModidicarEmpleado();

	}

/*=============================================
			ELIMINAR EMPLEADO
=============================================*/

	if (isset($_POST["eliminarEmpleado"])) {
		
		$eliminoEmpleado = new AjaxEmpleados();
		$eliminoEmpleado -> eliminarEmpleado = $_POST["eliminarEmpleado"];
		$eliminoEmpleado -> eliminarPersona = $_POST["eliminarPersona"];
		$eliminoEmpleado -> eliminarUsuario = $_POST["eliminarUsuario"];
		$eliminoEmpleado -> eliminarUserName = $_POST["eliminarUserName"];
		$eliminoEmpleado -> eliminarUserImagen = $_POST["eliminarUserImagen"];
		$eliminoEmpleado -> eliminarEmpleadoImagen = $_POST["eliminarEmpleadoImagen"];
		$eliminoEmpleado -> eliminarEmpleadoAjax();

	}

/*=============================================
			TRAER EMPLEADO
=============================================*/

	if (isset($_POST["idEmpleado"])) {

		$traerEmpleado = new AjaxEmpleados();
		$traerEmpleado -> idEmpleado = $_POST["idEmpleado"];
		$traerEmpleado -> ajaxTraerEmpleado();

	}

/*=============================================
			ACTIVAR/DESACTIVAR EMPLEADO
=============================================*/	

	if(isset($_POST["estadoEmpleado"])){

		$activarUsuario = new AjaxEmpleados();
		$activarUsuario -> estadoEmpleado = $_POST["estadoEmpleado"];
		$activarUsuario -> activarId = $_POST["activarEmpleado"];
		$activarUsuario -> ajaxActivarEmpleado();
	}

/*=============================================
			VALIDAR NO REPETIR DNI
=============================================*/

	if (isset($_POST["dniUsuario"])) {
		
		$valDniUsuario = new AjaxEmpleados();
		$valDniUsuario -> validarDNI = $_POST["dniUsuario"];
		$valDniUsuario -> validarDNIAjax();

	}

/*=============================================
			VALIDAR NO REPETIR EMAIL
=============================================*/

	if (isset($_POST["mail"])) {
		
		$valEmail = new AjaxEmpleados();
		$valEmail -> validarEmail = $_POST["mail"];
		$valEmail -> validarEmailAjax();

	}

/*=============================================
			VALIDAR NO REPETIR CUIL
=============================================*/

	if (isset($_POST["cuil"])) {

				
		$valEmail = new AjaxEmpleados();
		$valEmail -> validarCuil = $_POST["cuil"];
		$valEmail -> validarCuilAjax();

	}

/*=============================================
			TRAER BARRIOS
=============================================*/

	if (isset($_POST["TablaB"])) {
		
		$traerB = new AjaxEmpleados();
		$traerB -> traerBarrio = $_POST["TablaB"];
		$traerB -> traerBarrioAjax();

	}

/*=============================================
			TRAER LOCALIDADES
=============================================*/

	if (isset($_POST["TablaL"])) {
		
		$traerB = new AjaxEmpleados();
		$traerB -> traerLocalidaes = $_POST["TablaL"];
		$traerB -> traerLocalidadesAjax();

	}

/*=============================================
			VALIDAR NO REPETIR USUARIO
=============================================*/

	if(isset( $_POST["user"])){

		$valUsuario = new AjaxEmpleados();
		$valUsuario -> validarUsuario = $_POST["user"];
		$valUsuario -> ajaxValidarUsuario();

	}

/*=============================================
			TRAER CATEGORIAS SEGUN PUESTO
=============================================*/

	
	if(isset( $_POST["idPuesto"])){

		$traerCategoriaPuesto = new AjaxEmpleados();
		$traerCategoriaPuesto -> traerCatPuesto = $_POST["idPuesto"];
		$traerCategoriaPuesto -> traerCatPuestoSel = $_POST["idCate"];
		$traerCategoriaPuesto -> ajaxTraerCategoriaPuesto();

	}