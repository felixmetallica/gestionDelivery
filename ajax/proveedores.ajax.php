<?php

require_once "../controladores/proveedores.controlador.php";
require_once "../modelos/proveedores.modelo.php";
require_once "../controladores/personas.controlador.php";
require_once "../modelos/personas.modelo.php";


class AjaxProveedores{

/*=============================================
			CREAR PROVEEDOR			         
=============================================*/
	
	public $razonProveedor;
	public $cuitProveedor;
	public $ivaProveedor;
	public $emailProveedor;
	public $rubroProveedor;
	public $calleProveedor;
	public $numCalleProveedor;
	public $pisoProveedor;
	public $deptoProveedor;
	public $localidadProveedor;
	public $barrioProveedor;
	public $codPostalProveedor;
	public $codAreaTelefonoProveedor;
	public $numeroTeléfonoProveedor;
	public $nombreRefProveedor;
	public $apellidoRefProveedor;
	public $emailRefProveedor;
	public $codArRefProveedor;
	public $numTelRefProveedor;

	public function ajaxCrearProveedor(){

		$razon = $this ->razonProveedor;
		$cuit = $this ->cuitProveedor;
		$iva = $this ->ivaProveedor;
		$emailProv = $this ->emailProveedor;
		$rubro = $this ->rubroProveedor;
		$calle = $this ->calleProveedor;
		$numCalle = $this ->numCalleProveedor;
		$piso = $this ->pisoProveedor;
		$depto = $this ->deptoProveedor;
		$localidad = $this ->localidadProveedor;
		$barrio = $this ->barrioProveedor;
		$codPostal = $this ->codPostalProveedor;
		$codAreaProveedor = $this ->codAreaTelefonoProveedor;
		$numTelProveedor = $this ->numeroTeléfonoProveedor;
		$nombreRefPro = $this ->nombreRefProveedor;
		$apellidoRefPro = $this ->apellidoRefProveedor;
		$mailRefPro = $this ->emailRefProveedor;
		$codAreaRef = $this ->codArRefProveedor;
		$numTelRef = $this ->numTelRefProveedor;

		$datos = array("razon"=>ucwords($razon), 
						"emailProveedor" =>$emailProv,
						"cuit"=>$cuit,
						"iva"=>$iva,
						"rubro"=>$rubro,
						"codAreaProveedor"=>$codAreaProveedor,
						"numTelProveedor"=>$numTelProveedor, 
						"calle"=>ucwords($calle),
						"numCalle"=>$numCalle,
						"piso"=>ucwords($piso),
						"depto"=>ucwords($depto),
						"localidad"=>ucwords($localidad),
						"barrio"=>ucwords($barrio), 
						"codPostal"=>$codPostal, 
						"nombreRefPro"=>ucwords($nombreRefPro), 
						"apellidoRefPro"=>ucwords($apellidoRefPro),
						"mailReferente"=>$mailRefPro,
						"codAreaRef"=>$codAreaRef,
						"numTelRef"=>$numTelRef);

		
		$respuesta = ControladorProveedores::ctrRegistrarProveedor($datos);

		echo json_encode($respuesta);

		
	}

/*=============================================
			MODIFICAR PROVEEDOR			         
=============================================*/
	
	public $eidProveedor;
	public $idPersonaRef;
	public $erazonProveedor;
	public $ecuitProveedor;
	public $eivaProveedor;
	public $eemailProveedor;
	public $erubroProveedor;

	public $ecalleProveedor;
	public $enumCalleProveedor;
	public $episoProveedor; 
	public $edeptoProveedor;
	public $elocalidadProveedor;
	public $ebarrioProveedor;
	public $ecodPostalProveedor;

	public $ecodAreaTelefonoProveedor;
	public $enumeroTeléfonoProveedor;

	public $enombreRefProveedor;
	public $eapellidoRefProveedor;
	public $eemailRefProveedor;
	public $ecodArRefProveedor;
	public $enumTelRefProveedor;

	public function ajaxModificarProveedor(){

		$idProv = $this ->eidProveedor;
		$idPerRef = $this ->idPersonaRef;
		$razon = $this ->erazonProveedor;
		$cuit = $this ->ecuitProveedor;
		$iva = $this ->eivaProveedor;
		$emailProv = $this ->eemailProveedor;
		$rubro = $this ->erubroProveedor;
		
		$calle = $this ->ecalleProveedor;
		$numCalle = $this ->enumCalleProveedor;
		$piso = $this ->episoProveedor;
		$depto = $this ->edeptoProveedor;
		$localidad = $this ->elocalidadProveedor;
		$barrio = $this ->ebarrioProveedor;
		$codPostal = $this ->ecodPostalProveedor;

		$codAreaProveedor = $this ->ecodAreaTelefonoProveedor;
		$numTelProveedor = $this ->enumeroTeléfonoProveedor;

		$nombreRefPro = $this ->enombreRefProveedor;
		$apellidoRefPro = $this ->eapellidoRefProveedor;
		$mailRefPro = $this ->eemailRefProveedor;
		$codAreaRef = $this ->ecodArRefProveedor;
		$numTelRef = $this ->enumTelRefProveedor;

		$datos = array("idProv"=>$idProv,
						"idRef"=>$idPerRef,
						"razon"=>ucwords($razon), 
						"emailProveedor" =>$emailProv,
						"cuit"=>$cuit,
						"iva"=>$iva,
						"rubro"=>$rubro,
						"codAreaProveedor"=>$codAreaProveedor,
						"numTelProveedor"=>$numTelProveedor, 
						"calle"=>ucwords($calle),
						"numCalle"=>$numCalle,
						"piso"=>ucwords($piso),
						"depto"=>ucwords($depto),
						"localidad"=>ucwords($localidad),
						"barrio"=>ucwords($barrio), 
						"codPostal"=>$codPostal, 
						"nombreRefPro"=>ucwords($nombreRefPro), 
						"apellidoRefPro"=>ucwords($apellidoRefPro),
						"mailReferente"=>$mailRefPro,
						"codAreaRef"=>$codAreaRef,
						"numTelRef"=>$numTelRef);


		$respuesta = ControladorProveedores::ctrModificarProveedor($datos);

		echo json_encode($respuesta);

		
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
			VALIDAR NO REPETIR EMAIL
=============================================*/

	public $validarEmail;
				
	public function validarEmailAjax(){

		$valor = $this->validarEmail;
						
		$respuesta = ControladorPersonas::ctrValidarEmail($valor);

		echo $respuesta;
		
	}

/*=============================================
			VALIDAR NO REPETIR CUIT
=============================================*/

	public $validarCuit;
				
	public function validarCuitAjax(){

		$valor = $this->validarCuit;
						
		$respuesta = ControladorProveedores::ctrValidarCuit($valor);

		echo $respuesta;
		
	}

/*=============================================
	        TRAER PROVEEDOR        
=============================================*/

	public $traerDatosProveedor;
		
		public function traerDatosProveedorAjax(){

			$item = "ProveedorID";

			$valor = $this->traerDatosProveedor;

			$respuesta = ControladorProveedores::ctrMostrarProveedores($item, $valor);

			echo json_encode($respuesta);

		}

/*=============================================
	        TRAER DOMICILIO        
=============================================*/

	public $traerDomicilio;
		
		public function traerDomicilioAjax(){

			$datos = $this->traerDomicilio;

			$respuesta = ControladorProveedores::ctrTraerDomicilioProveedores($datos);

			echo json_encode($respuesta);

		}

/*=============================================
	        TRAER REFERENTE        
=============================================*/

	public $traerReferente;
		
		public function traerReferenteAjax(){

			$datos = $this->traerReferente;

			$respuesta = ControladorProveedores::ctrTraerReferenteProveedor($datos);

			echo json_encode($respuesta);

		}

/*=============================================
		    ACTIVAR PROVEEDOR
=============================================*/	
	
	public $estadoProveedor;
	public $activarId;

	public function ajaxActivarProveedor(){

		$tabla = "Proveedor";
		$item1 = "Activo";
		$valor1 = $this->estadoProveedor;
		$item2 = "ProveedorID";
		$valor2 = $this->activarId;

		$respuesta = ModeloProveedores::mdlActualizarProveedor($tabla, $item1, $valor1, $item2, $valor2);

		echo json_encode($respuesta);

	}

/*=============================================
			ELIMINAR PROVEEDOR
=============================================*/

	public $eliminarProveedor;
	public $eliminarPersona;
	
	public function eliminarProveedorAjax(){

		$proveedor = $this->eliminarProveedor;
		$persona = $this->eliminarPersona;
		
		$respuesta = ControladorProveedores::ctrEliminarProveedor($proveedor, $persona);

		echo $respuesta;

		}

} //fin class AjaxProveedores


/*==================================================================================================================================*/

/*=============================================
			CREAR PROVEEDOR
=============================================*/

	if (isset($_POST["razonProveedor"])) {
		
		$nuevoProveedor = new AjaxProveedores();
		$nuevoProveedor -> razonProveedor = $_POST["razonProveedor"];
		$nuevoProveedor -> cuitProveedor = $_POST["cuitProveedor"];
		$nuevoProveedor -> ivaProveedor = $_POST["ivaProveedor"];
		$nuevoProveedor -> emailProveedor = $_POST["emailProveedor"];
		$nuevoProveedor -> rubroProveedor = $_POST["rubroProveedor"];
		$nuevoProveedor -> calleProveedor = $_POST["calleProveedor"];
		$nuevoProveedor -> numCalleProveedor = $_POST["numCalleProveedor"];
		$nuevoProveedor -> pisoProveedor = $_POST["pisoProveedor"];
		$nuevoProveedor -> deptoProveedor = $_POST["deptoProveedor"];
		$nuevoProveedor -> localidadProveedor = $_POST["localidadProveedor"];
		$nuevoProveedor -> barrioProveedor = $_POST["barrioProveedor"];
		$nuevoProveedor -> codPostalProveedor = $_POST["codPostalProveedor"];
		$nuevoProveedor -> codAreaTelefonoProveedor = $_POST["codAreaTelefonoProveedor"];
		$nuevoProveedor -> numeroTeléfonoProveedor = $_POST["numeroTeléfonoProveedor"];
		$nuevoProveedor -> nombreRefProveedor = $_POST["nombreRefProveedor"];
		$nuevoProveedor -> apellidoRefProveedor = $_POST["apellidoRefProveedor"];
		$nuevoProveedor -> emailRefProveedor = $_POST["emailRefProveedor"];
		$nuevoProveedor -> codArRefProveedor = $_POST["codArRefProveedor"];
		$nuevoProveedor -> numTelRefProveedor = $_POST["numTelRefProveedor"];
		$nuevoProveedor -> ajaxCrearProveedor();

	}

/*=============================================
			MODIFICAR PROVEEDOR
=============================================*/

	if (isset($_POST["erazonProveedor"])) {
		
		$editarProveedor = new AjaxProveedores();
		
		$editarProveedor -> eidProveedor = $_POST["idProveedorEditar"];
		$editarProveedor -> idPersonaRef = $_POST["idPersona"];
		$editarProveedor -> erazonProveedor = $_POST["erazonProveedor"];
		$editarProveedor -> ecuitProveedor = $_POST["ecuitProveedor"];
		$editarProveedor -> eivaProveedor = $_POST["eivaProveedor"];
		$editarProveedor -> eemailProveedor = $_POST["eemailProveedor"];
		$editarProveedor -> erubroProveedor = $_POST["erubroProveedor"];

		$editarProveedor -> ecalleProveedor = $_POST["ecalleProveedor"];
		$editarProveedor -> enumCalleProveedor = $_POST["enumCalleProveedor"];
		$editarProveedor -> episoProveedor = $_POST["episoProveedor"];
		$editarProveedor -> edeptoProveedor = $_POST["edeptoProveedor"];
		$editarProveedor -> elocalidadProveedor = $_POST["elocalidadProveedor"];
		$editarProveedor -> ebarrioProveedor = $_POST["ebarrioProveedor"];
		$editarProveedor -> ecodPostalProveedor = $_POST["ecodPostalProveedor"];

		$editarProveedor -> ecodAreaTelefonoProveedor = $_POST["ecodAreaTelefonoProveedor"];
		$editarProveedor -> enumeroTeléfonoProveedor = $_POST["enumeroTeléfonoProveedor"];

		$editarProveedor -> enombreRefProveedor = $_POST["enombreRefProveedor"];
		$editarProveedor -> eapellidoRefProveedor = $_POST["eapellidoRefProveedor"];
		$editarProveedor -> eemailRefProveedor = $_POST["eemailRefProveedor"];
		$editarProveedor -> ecodArRefProveedor = $_POST["ecodArRefProveedor"];
		$editarProveedor -> enumTelRefProveedor = $_POST["enumTelRefProveedor"];
		
		$editarProveedor -> ajaxModificarProveedor();

	}

/*=============================================
			TRAER BARRIOS
=============================================*/

	if (isset($_POST["TablaB"])) {
		
		$traerB = new AjaxProveedores();
		$traerB -> traerBarrio = $_POST["TablaB"];
		$traerB -> traerBarrioAjax();

	}

/*=============================================
			TRAER LOCALIDADES
=============================================*/

	if (isset($_POST["TablaL"])) {
		
		$traerB = new AjaxProveedores();
		$traerB -> traerLocalidaes = $_POST["TablaL"];
		$traerB -> traerLocalidadesAjax();

	}

/*=============================================
			VALIDAR NO REPETIR EMAIL
=============================================*/

	if (isset($_POST["mail"])) {
		
		$valEmail = new AjaxProveedores();
		$valEmail -> validarEmail = $_POST["mail"];
		$valEmail -> validarEmailAjax();

	}

/*=============================================
			VALIDAR NO REPETIR CUIT
=============================================*/

	if (isset($_POST["cuit"])) {
				
		$valEmail = new AjaxProveedores();
		$valEmail -> validarCuit = $_POST["cuit"];
		$valEmail -> validarCuitAjax();

	}

/*=============================================
			TRAER PROVEEDOR
=============================================*/

	if (isset($_POST["traigoProveedor"])) {
				
		$traigoProv = new AjaxProveedores();
		$traigoProv -> traerDatosProveedor = $_POST["traigoProveedor"];
		$traigoProv -> traerDatosProveedorAjax();

	}

/*=============================================
			TRAER DOMICILIO
=============================================*/

	if (isset($_POST["traigoDomicilio"])) {
				
		$traigoDom = new AjaxProveedores();
		$traigoDom -> traerDomicilio = $_POST["traigoDomicilio"];
		$traigoDom -> traerDomicilioAjax();
	
	}

/*=============================================
			TRAER REFERENTE
=============================================*/

	if (isset($_POST["traigoReferente"])) {
				
		$traigoRef = new AjaxProveedores();
		$traigoRef -> traerReferente = $_POST["traigoReferente"];
		$traigoRef -> traerReferenteAjax();
	}

/*=============================================
			ACTIVAR PROVEEDOR
=============================================*/	

	if(isset($_POST["estadoProveedor"])){

		$activarUsuario = new AjaxProveedores();
		$activarUsuario -> estadoProveedor = $_POST["estadoProveedor"];
		$activarUsuario -> activarId = $_POST["activarProveedor"];
		$activarUsuario -> ajaxActivarProveedor();

	}

/*=============================================
			ELIMINAR PROVEEDOR
=============================================*/

	if (isset($_POST["eliminarProveedor"])) {
		
		$eliminoProveedor = new AjaxProveedores();
		$eliminoProveedor -> eliminarProveedor = $_POST["eliminarProveedor"];
		$eliminoProveedor -> eliminarPersona = $_POST["eliminarPersona"];
		$eliminoProveedor -> eliminarProveedorAjax();

	}