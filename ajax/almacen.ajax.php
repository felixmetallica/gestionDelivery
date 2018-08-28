<?php

require_once "../controladores/almacen.controlador.php";
require_once "../modelos/almacen.modelo.php";

require_once "../controladores/insumos.controlador.php";
require_once "../modelos/insumos.modelo.php";

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

class AjaxAlmacen{

/*=============================================
		SELECCIONAR INSUMO/PRODUCTO
=============================================*/

	public $datosInsProd;
		
	public function seleccionarProdInsAjax(){

		$item = "Codigo";
		$valor = $this->datosInsProd;
				
		$respuesta = ControladorAlmacen::ctrMostrarProductosInsumos($item, $valor);

		echo json_encode($respuesta);
	}

/*=============================================
		EDITAR MOVIMIENTO
=============================================*/

	public $idMovimiento;
		
	public function editarMovimientoAjax(){

		$item = "AlmacenID";
		$valor = $this->idMovimiento;
				
		$respuesta = ControladorAlmacen::ctrMostrarMovimientos($item, $valor);

		echo json_encode($respuesta);
	}

/*=============================================
		ELIMINAR MOVIMIENTO
=============================================*/

	public $eliminarMovimiento;
	public $tipoMovimiento;
	public $idInsProd;
	public $tipoInsProd;
	public $Cantidad;
	
	public function eliminarMovimientoAjax(){

		$idMov = $this->eliminarMovimiento;

		$datos = array("tipoMov"=>$this->tipoMovimiento,
					   "id"=>$this->idInsProd,
					   "tipo"=>$this->tipoInsProd,
					   "cantidad"=>$this->Cantidad);

		$respuesta = ControladorAlmacen::ctrEliminarMovimiento($idMov, $datos);

		echo $respuesta;
	}

	
} //fin class AjaxAlmacen

/*==================================================================================================================================*/

/*=============================================
		SELECCIONAR INSUMO/PRODUCTO
==============================================*/

	if (isset($_POST["Codigo"])) {
		
		$datosInsProd = new AjaxAlmacen();
		$datosInsProd -> datosInsProd = $_POST["Codigo"];
		$datosInsProd -> seleccionarProdInsAjax();

	}

/*=============================================
		EDITAR MOVIMIENTO
==============================================*/

	if (isset($_POST["idMovimiento"])) {
		
		$editarMovimiento = new AjaxAlmacen();
		$editarMovimiento -> idMovimiento = $_POST["idMovimiento"];
		$editarMovimiento -> editarMovimientoAjax();

	}

/*=============================================
		ELIMINAR MOVIMIENTO
==============================================*/

	if (isset($_POST["eliminarMovimiento"])) {
		
		$eliminoMovimiento = new AjaxAlmacen();
		$eliminoMovimiento -> eliminarMovimiento = $_POST["eliminarMovimiento"];
		$eliminoMovimiento -> tipoMovimiento = $_POST["tipoMovimiento"];
		$eliminoMovimiento -> idInsProd = $_POST["idInsProd"];
		$eliminoMovimiento -> tipoInsProd = $_POST["tipoInsProd"];
		$eliminoMovimiento -> Cantidad = $_POST["Cantidad"];
		$eliminoMovimiento -> eliminarMovimientoAjax();

	}

	


