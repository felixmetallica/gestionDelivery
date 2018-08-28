<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

class AjaxProductos{

/*==========================================
        ASIGNAR CODIGO A PRODUCTO
==========================================*/

	public $idRubro;

		public function ajaxCrearCodigoProducto(){

			$item = "RubroID";
  			$valor = $this->idRubro;
  			$orden = "ProductoID";

			$respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);

			echo json_encode($respuesta);

		}

/*=============================================
        EDITAR PRODUCTO
=============================================*/

    public $idEditarProducto;
    public $traerProductos;

        public function ajaxEditarProducto(){

        	if ($this->traerProductos == "ok") {
        	   
        		$respuesta = ControladorProductos::ctrMostrarProductosDisponibles();

            	echo json_encode($respuesta);

        	} else {

        		$item = "ProductoID";

	            $valor = $this ->idEditarProducto;

	            $orden = "ProductoID";

	            $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);

	            echo json_encode($respuesta);

        	}   
		}

/*=============================================
		ELIMINAR PRODUCTO
=============================================*/

	public $eliminarProducto;
	public $eliminarImagen;
	public $eliminarCodigo;
		
	public function eliminarProductoAjax(){

		$producto = $this->eliminarProducto;
		$imagen = $this->eliminarImagen;
		$codigo = $this->eliminarCodigo;

		$datos = array('idProducto' => $producto,
						'imagen' => $imagen,
						'codigo' => $codigo);

		$respuesta = ControladorProductos::ctrEliminarProducto($datos);

		echo $respuesta;


	}

/*=============================================
		ACTIVAR/DESACTIVAR PRODUCTO
=============================================*/	

	public $estadoProducto;
	public $activarId;


	public function ajaxActivarProducto(){

		$tabla = "Producto";

		$item1 = "Activo";
		$valor1 = $this->estadoProducto;

		$item2 = "ProductoID";
		$valor2 = $this->activarId;

				
		$respuesta = ModeloProductos::mdlActivarProducto($tabla, $item1, $valor1, $item2, $valor2);

		

		}


}//final clase ajax


/*==========================================
        ASIGNAR CODIGO A PRODUCTO
==========================================*/

	if (isset($_POST["idRubro"])) {
		
		$codigoProducto = new AjaxProductos();
		$codigoProducto -> idRubro = $_POST["idRubro"];
		$codigoProducto -> ajaxCrearCodigoProducto();
		
	}

/*=============================================
        EDITAR PRODUCTO
=============================================*/

	if (isset($_POST["idEditarProducto"])) {

		$editarProducto = new AjaxProductos();
		$editarProducto -> idEditarProducto = $_POST["idEditarProducto"];
		$editarProducto -> ajaxEditarProducto();
	}

/*=============================================
		ELIMINAR PRODUCTO
==============================================*/

	if (isset($_POST["eliminarProducto"])) {
		
		$eliminoProducto = new AjaxProductos();
		$eliminoProducto -> eliminarProducto = $_POST["eliminarProducto"];
		$eliminoProducto -> eliminarImagen = $_POST["eliminarImagen"];
		$eliminoProducto -> eliminarCodigo = $_POST["eliminarCodigo"];
		$eliminoProducto -> eliminarProductoAjax();

	}

/*=============================================
		ACTIVAR/DESACTIVAR PRODUCTO
=============================================*/	

	if(isset($_POST["estadoProducto"])){

		$activarProducto = new AjaxProductos();
		$activarProducto -> estadoProducto = $_POST["estadoProducto"];
		$activarProducto -> activarId = $_POST["activarProducto"];
		$activarProducto -> ajaxActivarProducto();
	}	

/*=============================================
		MOSTRAR PRODUCTOS DISPONIBLES
=============================================*/	

	if(isset($_POST["traerProductos"])){

		$traerProductosDisponibles = new AjaxProductos();
		$traerProductosDisponibles -> traerProductos = $_POST["traerProductos"];
		$traerProductosDisponibles -> ajaxEditarProducto();
	}

