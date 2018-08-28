<?php

require_once "../controladores/grupoFamiliar.controlador.php";
require_once "../modelos/grupoFamiliar.modelo.php";
require_once "../controladores/personas.controlador.php";
require_once "../modelos/personas.modelo.php";

class AjaxGrupoFamiliar{

/*===========================================================================================================================
=            												METODOS 												        =
===========================================================================================================================*/

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
			TRAER FAMILIARES
=============================================*/

	public $traerFamiliares;

	public function traerFamiliaresAjax(){

		$valor = $this->traerFamiliares;

		$respuesta = ControladorGrupoFamiliar::ctrTraerFamiliares($valor);

		echo $respuesta;
	}

/*=============================================
=            EDITAR FAMILIAR 		          =
=============================================*/
	public $idFamiliar;
	public $idEmpleado;
	
	public function ajaxEditarFamiliar(){

		$valor1 = $this ->idFamiliar;
		$valor2 = $this ->idEmpleado;
		
		$respuesta = ControladorGrupoFamiliar::ctrTraerFamiliar($valor1, $valor2);

		echo json_encode($respuesta);

	}

/*=============================================
        	ELIMINAR FAMILIAR
=============================================*/

    public $eliminarFamiliar;
    public $eliminarPersona;
    //public $eliminarEmpleado;

        public function ajaxEliminarFamiliar(){

            $valor1 = $this ->eliminarFamiliar;
            $valor2 = $this ->eliminarPersona;
           // $valor3 = $this ->eliminarEmpleado;

            $respuesta = ControladorGrupoFamiliar::ctrEliminarFamiliar($valor1, $valor2);

            echo ($respuesta);

        }

}

/*===========================================================================================================================
=            												PETICIONES 												        =
===========================================================================================================================*/

/*=============================================
			VALIDAR NO REPETIR DNI
=============================================*/

	if (isset($_POST["dniFamiliar"])) {
		
		$valdniFamiliar = new AjaxGrupoFamiliar();
		$valdniFamiliar -> validarDNI = $_POST["dniFamiliar"];
		$valdniFamiliar -> validarDNIAjax();

	}

/*=============================================
			TRAER FAMILIARES
=============================================*/

	if (isset($_POST["traerFamiliares"])) {
		
		$traigoFamilia = new AjaxGrupoFamiliar();
		$traigoFamilia -> traerFamiliares = $_POST["traerFamiliares"];
		$traigoFamilia -> traerFamiliaresAjax();

	}

/*=============================================
			EDITAR FAMILIAR
=============================================*/	

	if (isset($_POST["idFamiliar"])) {
		
		$editar = new AjaxGrupoFamiliar();
		$editar -> idFamiliar = $_POST["idFamiliar"];
		$editar -> idEmpleado = $_POST["idEmpleado"];
		$editar -> ajaxEditarFamiliar();
	}

/*=============================================
			ELIMINAR FAMILIAR
=============================================*/	

	if (isset($_POST["eliminarFamiliar"])) {
		
		$eliminar = new AjaxGrupoFamiliar();
		$eliminar -> eliminarFamiliar = $_POST["eliminarFamiliar"];
		$eliminar -> eliminarPersona = $_POST["eliminarPersona"];
		//$eliminar -> eliminarEmpleado = $_POST["eliminarEmpleado"];
		$eliminar -> ajaxEliminarFamiliar();
	}
