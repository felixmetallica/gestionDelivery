<?php

require_once "../controladores/proveedores.controlador.php";
require_once "../modelos/proveedores.modelo.php";
require_once "../controladores/personas.controlador.php";
require_once "../modelos/personas.modelo.php";
require_once "../controladores/compras.controlador.php";
require_once "../modelos/compras.modelo.php";
require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";
require_once "../controladores/insumos.controlador.php";
require_once "../modelos/insumos.modelo.php";


class AjaxCompras{

/*=============================================
		DETALLE COMPRA
=============================================*/

	public $detalleCompra;
		
	public function detalleCompraAjax(){

		$item = "CompraID";
		$valor = $this->detalleCompra;
				
		$respuesta = ControladorCompras::ctrMostrarCompras($item, $valor);

		echo json_encode($respuesta);
	}

/*=============================================
		DETALLE PRODUCTOS COMPRA
=============================================*/

	public $productosCompra;
		
	public function detalleCompraProductosAjax(){

		$item = "CompraID";
		$valor = $this->productosCompra;
				
		$respuesta = ControladorInsumos::ctrMostrarInsumosCompra($item, $valor);

		echo json_encode($respuesta);
	}

/*=============================================
		TRAER PRODUCTO/INSUMO A COMPRA
==============================================*/

	public $prodInsCompra;
	public $tipoProdInsCompra;
	public $traerInsumosPord;
	
	public function traerPordInsCompraAjax(){

		$idProdIns = $this->prodInsCompra;
		$tipo = $this->tipoProdInsCompra;

		if ($this->traerInsumosPord == "ok") {
			
			$item = null;
			$valor = null;

			$respuesta = ControladorInsumos::ctrMostrarInsumosCompra($item, $valor);

			echo json_encode($respuesta);
			

		
		} else {


			if ($tipo !="Insumo") {
				
				$item = "ProductoID";

		        $valor = $idProdIns;

		        $orden = "ProductoID";

		        $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);

		        echo json_encode($respuesta);

			} else {

				$item = "InsumosID";

	            $valor = $idProdIns;

	            $respuesta = ControladorInsumos::ctrMostrarInsumos($item, $valor);

	            echo json_encode($respuesta);

			}

		}
				
	}

	
} //fin class AjaxCompras

/*==================================================================================================================================*/

/*=============================================
		DETALLE COMPRA
==============================================*/

	if (isset($_POST["detalleCompra"])) {
		
		$detalleCompra = new AjaxCompras();
		$detalleCompra -> detalleCompra = $_POST["detalleCompra"];
		$detalleCompra -> detalleCompraAjax();

	}

/*=============================================
		DETALLE PRODUCTOS COMPRA
==============================================*/

	if (isset($_POST["productosCompra"])) {
		
		$productosCompra = new AjaxCompras();
		$productosCompra -> productosCompra = $_POST["productosCompra"];
		$productosCompra -> detalleCompraProductosAjax();

	}

/*=============================================
		TRAER PRODUCTO/INSUMO A COMPRA
==============================================*/

	if (isset($_POST["idInProd"])) {
		
		$prodInsCompra = new AjaxCompras();
		$prodInsCompra -> prodInsCompra = $_POST["idInProd"];
		$prodInsCompra -> tipoProdInsCompra = $_POST["tipo"];
		$prodInsCompra -> traerPordInsCompraAjax();

	}

/*=============================================
		TRAER PRODUCTO/INSUMO A COMPRA SELECT
==============================================*/

	if (isset($_POST["traerInsumosPord"])) {
		
		$prodInsCompra = new AjaxCompras();
		$prodInsCompra -> traerInsumosPord = $_POST["traerInsumosPord"];
		$prodInsCompra -> traerPordInsCompraAjax();

	}

