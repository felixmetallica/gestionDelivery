<?php

	require_once "../controladores/ventas.controlador.php";
	require_once "../modelos/ventas.modelo.php";
	require_once "../controladores/clientes.controlador.php";
	require_once "../modelos/clientes.modelo.php";
	require_once "../controladores/productos.controlador.php";
	require_once "../modelos/productos.modelo.php";

class AjaxVentas{

/*=============================================
			ELIMINAR VENTA
=============================================*/

	public $eliminarVenta;
		
	public function eliminarVentaAjax(){

		$venta = $this->eliminarVenta;
				
		$respuesta = ControladorVentas::ctrEliminarVenta($venta);

		echo $respuesta;
	}

/*=============================================
			DETALLE VENTA
=============================================*/

	public $detalleVenta;
		
	public function detalleVentaAjax(){

		$item = "VentaID";
		$valor = $this->detalleVenta;
				
		$respuesta = ControladorVentas::ctrMostrarVentas($item, $valor);

		echo json_encode($respuesta);
	}

/*=============================================
			DETALLE PRODUCTOS VENTA
=============================================*/

	public $productosVenta;
		
	public function detalleVentaProductosAjax(){

		$valor = $this->productosVenta;
				
		$respuesta = ControladorVentas::ctrListadoProductos($valor);

		echo json_encode($respuesta);
	}



}

/*=============================================
			ELIMINAR VENTA
==============================================*/

	if (isset($_POST["eliminarVenta"])) {
		
		$eliminoVenta = new AjaxVentas();
		$eliminoVenta -> eliminarVenta = $_POST["eliminarVenta"];
		$eliminoVenta -> eliminarVentaAjax();

	}

/*=============================================
			DETALLE VENTA
==============================================*/

	if (isset($_POST["detalleVenta"])) {
		
		$detalleVenta = new AjaxVentas();
		$detalleVenta -> detalleVenta = $_POST["detalleVenta"];
		$detalleVenta -> detalleVentaAjax();

	}

/*=============================================
			DETALLE PRODUCTOS VENTA
==============================================*/

	if (isset($_POST["productosVenta"])) {
		
		$productosVenta = new AjaxVentas();
		$productosVenta -> productosVenta = $_POST["productosVenta"];
		$productosVenta -> detalleVentaProductosAjax();

	}

