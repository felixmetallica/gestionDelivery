<?php

require_once "../controladores/configuracion.controlador.php";
require_once "../modelos/configuracion.modelo.php";
require_once "../controladores/personas.controlador.php";
require_once "../modelos/personas.modelo.php";

class AjaxConfiguracion{

/*=============================================
        EDITAR RUBRO
=============================================*/

    public $idRubro;

        public function ajaxEditarRubro(){

            $item = "RubroID";
            $valor = $this ->idRubro;

            $respuesta = ControladorConfiguracion::ctrMostrarRubros($item, $valor);

            echo json_encode($respuesta);

        }

/*=============================================
        ELIMINAR RUBRO
=============================================*/

    public $eliminarRubro;

        public function ajaxEliminarrRubro(){

            $valor = $this ->eliminarRubro;

            $respuesta = ControladorConfiguracion::ctrEliminarRubro($valor);

            echo ($respuesta);

        }

/* ===========================================================================================================================================================*/

/*=============================================
        EDITAR ROL
=============================================*/

    public $idRol;

        public function ajaxEditarRol(){

            $item = "RolesID";
            $valor = $this ->idRol;

            $respuesta = ControladorConfiguracion::ctrMostrarRoles($item, $valor);

            echo json_encode($respuesta);

        }

/*=============================================
        ELIMINAR ROL
=============================================*/

    public $eliminarRol;

        public function ajaxEliminarRol(){

            $valor = $this ->eliminarRol;

            $respuesta = ControladorConfiguracion::ctrEliminarRol($valor);

            echo ($respuesta);

        }

/* ===========================================================================================================================================================*/

/*=============================================
        EDITAR PUESTO
=============================================*/

    public $idPuesto;

        public function ajaxEditarPuesto(){

            $item = "PuestoID";
            $valor = $this ->idPuesto;

            $respuesta = ControladorConfiguracion::ctrMostrarPuestos($item, $valor);

            echo json_encode($respuesta);

        }

/*=============================================
        ELIMINAR PUESTO
=============================================*/

    public $eliminarPuesto;

        public function ajaxEliminarPuesto(){

            $valor = $this ->eliminarPuesto;

            $respuesta = ControladorConfiguracion::ctrEliminarPuesto($valor);

            echo ($respuesta);

        }

/* ===========================================================================================================================================================*/

/*=============================================
        EDITAR CATEGORIA
=============================================*/

    public $idCategoria;

        public function ajaxEditarCategoria(){

            $item = "CategoriasID";
            $valor = $this ->idCategoria;

            $respuesta = ControladorConfiguracion::ctrMostrarCategorias($item, $valor);

            echo json_encode($respuesta);

        }

/*=============================================
        ELIMINAR CATEGORIA
=============================================*/

    public $eliminarCategoria;

        public function ajaxEliminarCategoria(){

            $valor = $this ->eliminarCategoria;

            $respuesta = ControladorConfiguracion::ctrEliminarCategoria($valor);

            echo ($respuesta);

        }

/* ===========================================================================================================================================================*/

/*=============================================
        EDITAR IVA
=============================================*/

    public $idIva;

        public function ajaxEditarIva(){

            $item = "IVAID";
            $valor = $this ->idIva;

            $respuesta = ControladorConfiguracion::ctrMostrarIva($item, $valor);

            echo json_encode($respuesta);

        }

/*=============================================
        ELIMINAR IVA
=============================================*/

    public $eliminarIva;

        public function ajaxEliminarIva(){

            $valor = $this ->eliminarIva;

            $respuesta = ControladorConfiguracion::ctrEliminaIva($valor);

            echo ($respuesta);

        }

/* ===========================================================================================================================================================*/

/*=============================================
        TRAER BARRIOS PDV            
=============================================*/

    public $traerBarrio;
        
        public function traerBarrioAjax(){

            $datos = $this->traerBarrio;

            $respuesta = ControladorPersonas::ctrListarBarrios($datos);

            echo json_encode($respuesta);

        }

/*=============================================
        TRAER LOCALIDADES PDV       
=============================================*/

    public $traerLocalidaes;
        
        public function traerLocalidadesAjax(){

            $datos = $this->traerLocalidaes;

            $respuesta = ControladorPersonas::ctrListarLocalidades($datos);

            echo json_encode($respuesta);

        }

/*=============================================
        EDITAR PDV
=============================================*/

    public $idPdv;

        public function ajaxEditarPdv(){

            $item = "PuntoVentaID";
            $valor = $this ->idPdv;

            $respuesta = ControladorConfiguracion::ctrMostrarPdvs($item, $valor);

            echo json_encode($respuesta);

        }

/*=============================================
        ELIMINAR PDV
=============================================*/

    public $eliminarPdv;
    
        public function ajaxEliminarPdv(){

            $valor1 = $this ->eliminarPdv;
            
            $respuesta = ControladorConfiguracion::ctrEliminarPdv($valor1);

            echo ($respuesta);

        }

/*=============================================
        ACTIVAR/DESACTIVAR PDV
=============================================*/ 

    public $estadoPdv;
    public $activarPdv;


    public function ajaxActivarPdv(){

        $tabla = "PuntoVenta";

        $item1 = "Activo";
        $valor1 = $this->estadoPdv;

        $item2 = "PuntoVentaID";
        $valor2 = $this->activarPdv;

                
        $respuesta = ModeloConfiguracion::mdlActivarPdv($tabla, $item1, $valor1, $item2, $valor2);

        

        }

/* ===========================================================================================================================================================*/

/*=============================================
        EDITAR MDP
=============================================*/

    public $idMdp;

        public function ajaxEditarMdp(){

            $item = "MedioPagoID";
            $valor = $this ->idMdp;

            $respuesta = ControladorConfiguracion::ctrMostrarMdPs($item, $valor);

            echo json_encode($respuesta);

        }

/*=============================================
        ELIMINAR MDP
=============================================*/

    public $eliminarMdp;
    
        public function ajaxEliminarMdp(){

            $valor1 = $this ->eliminarMdp;
           
            $respuesta = ControladorConfiguracion::ctrEliminarMdp($valor1);

            echo ($respuesta);

        }

/*=============================================
        ACTIVAR/DESACTIVAR MDP
=============================================*/ 

    public $estadoMdp;
    public $activarMdp;


    public function ajaxActivarMdp(){

        $tabla = "MedioPago";

        $item1 = "Activo";
        $valor1 = $this->estadoMdp;

        $item2 = "MedioPagoID";
        $valor2 = $this->activarMdp;

                
        $respuesta = ModeloConfiguracion::mdlActivarMdp($tabla, $item1, $valor1, $item2, $valor2);

        

        }


}



/* ===========================================================================================================================================================*/

/*=============================================
        EDITAR RUBRO
=============================================*/

	if (isset($_POST["idRubro"])) {

		$editarRubro = new AjaxConfiguracion();
		$editarRubro -> idRubro = $_POST["idRubro"];
		$editarRubro -> ajaxEditarRubro();
	}

/*=============================================
        ELIMINAR RUBRO
=============================================*/

	if (isset($_POST["eliminarRubro"])) {

		$eliminarRubro = new AjaxConfiguracion();
		$eliminarRubro -> eliminarRubro = $_POST["eliminarRubro"];
		$eliminarRubro -> ajaxEliminarrRubro();
	}

/* ===========================================================================================================================================================*/

/*=============================================
        EDITAR ROL
=============================================*/

	if (isset($_POST["idRol"])) {

		$editarRol = new AjaxConfiguracion();
		$editarRol -> idRol = $_POST["idRol"];
		$editarRol -> ajaxEditarRol();
	}

/*=============================================
        ELIMINAR ROL
=============================================*/

	if (isset($_POST["eliminarRol"])) {

		$eliminarRol = new AjaxConfiguracion();
		$eliminarRol -> eliminarRol = $_POST["eliminarRol"];
		$eliminarRol -> ajaxEliminarRol();
	}

/* ===========================================================================================================================================================*/

/*=============================================
        EDITAR PUESTO
=============================================*/

	if (isset($_POST["idPuesto"])) {

		$editarPuesto = new AjaxConfiguracion();
		$editarPuesto -> idPuesto = $_POST["idPuesto"];
		$editarPuesto -> ajaxEditarPuesto();
	}

/*=============================================
        ELIMINAR PUESTO
=============================================*/

	if (isset($_POST["eliminarPuesto"])) {

		$eliminarPuesto = new AjaxConfiguracion();
		$eliminarPuesto -> eliminarPuesto = $_POST["eliminarPuesto"];
		$eliminarPuesto -> ajaxEliminarPuesto();
	}

/* ===========================================================================================================================================================*/

/*=============================================
        EDITAR CATEGORIA
=============================================*/

	if (isset($_POST["idCategoria"])) {

		$editarCategoria = new AjaxConfiguracion();
		$editarCategoria -> idCategoria = $_POST["idCategoria"];
		$editarCategoria -> ajaxEditarCategoria();
	}

/*=============================================
        ELIMINAR CATEGORIA
=============================================*/

	if (isset($_POST["eliminarCategoria"])) {

		$eliminarCategoria = new AjaxConfiguracion();
		$eliminarCategoria -> eliminarCategoria = $_POST["eliminarCategoria"];
		$eliminarCategoria -> ajaxEliminarCategoria();
	}

/* ===========================================================================================================================================================*/

/*=============================================
        EDITAR IVA
=============================================*/

	if (isset($_POST["idIva"])) {

		$editarIva = new AjaxConfiguracion();
		$editarIva -> idIva = $_POST["idIva"];
		$editarIva -> ajaxEditarIva();
	}

/*=============================================
        ELIMINAR IVA
=============================================*/

	if (isset($_POST["eliminarIva"])) {

		$eliminarIva = new AjaxConfiguracion();
		$eliminarIva -> eliminarIva = $_POST["eliminarIva"];
		$eliminarIva -> ajaxEliminarIva();
	}

/* ===========================================================================================================================================================*/

/*=============================================
        TRAER BARRIOS PDV
=============================================*/

    if (isset($_POST["TablaB"])) {
        
        $traerB = new AjaxConfiguracion();
        $traerB -> traerBarrio = $_POST["TablaB"];
        $traerB -> traerBarrioAjax();

    }

/*=============================================
        TRAER LOCALIDADES PDV
=============================================*/

    if (isset($_POST["TablaL"])) {
        
        $traerB = new AjaxConfiguracion();
        $traerB -> traerLocalidaes = $_POST["TablaL"];
        $traerB -> traerLocalidadesAjax();

    }

/*=============================================
        EDITAR PDV
=============================================*/

    if (isset($_POST["idPdv"])) {

        $editarPdv = new AjaxConfiguracion();
        $editarPdv -> idPdv = $_POST["idPdv"];
        $editarPdv -> ajaxEditarPdv();
    }

/*=============================================
        ELIMINAR PDV
=============================================*/

    if (isset($_POST["eliminarPdv"])) {

        $eliminarPdv = new AjaxConfiguracion();
        $eliminarPdv -> eliminarPdv = $_POST["eliminarPdv"];
        $eliminarPdv -> ajaxEliminarPdv();
    }

/*=============================================
        ACTIVAR/DESACTIVAR PDV
=============================================*/ 

    if(isset($_POST["estadoPdv"])){

        $activarUsuario = new AjaxConfiguracion();
        $activarUsuario -> estadoPdv = $_POST["estadoPdv"];
        $activarUsuario -> activarPdv = $_POST["activarPdv"];
        $activarUsuario -> ajaxActivarPdv();
    }   

/* ===========================================================================================================================================================*/

/*=============================================
        EDITAR MDP
=============================================*/

    if (isset($_POST["idMdp"])) {

        $editarPdv = new AjaxConfiguracion();
        $editarPdv -> idMdp = $_POST["idMdp"];
        $editarPdv -> ajaxEditarMdp();
    }

/*=============================================
        ELIMINAR MDP
=============================================*/

    if (isset($_POST["eliminarMdp"])) {

        $editarPdv = new AjaxConfiguracion();
        $editarPdv -> eliminarMdp = $_POST["eliminarMdp"];
        $editarPdv -> ajaxEliminarMdp();
    }

/*=============================================
        ACTIVAR/DESACTIVAR MDP
=============================================*/ 

    if(isset($_POST["estadoMdp"])){

        $activarUsuario = new AjaxConfiguracion();
        $activarUsuario -> estadoMdp = $_POST["estadoMdp"];
        $activarUsuario -> activarMdp = $_POST["activarMdp"];
        $activarUsuario -> ajaxActivarMdp();
    }   