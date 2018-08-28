<?php

require_once "../../controladores/almacen.controlador.php";
require_once "../../modelos/almacen.modelo.php";
require_once "../../controladores/usuarios.controlador.php";
require_once "../../modelos/usuarios.modelo.php";
require_once "../../controladores/ventas.controlador.php";
require_once "../../modelos/ventas.modelo.php";
require_once "../../controladores/clientes.controlador.php";
require_once "../../modelos/clientes.modelo.php";
require_once "../../controladores/compras.controlador.php";
require_once "../../modelos/compras.modelo.php";
require_once "../../controladores/proveedores.controlador.php";
require_once "../../modelos/proveedores.modelo.php";
require_once "../../controladores/insumos.controlador.php";
require_once "../../modelos/insumos.modelo.php";
require_once "../../controladores/empleados.controlador.php";
require_once "../../modelos/empleados.modelo.php";
require_once "../../controladores/productos.controlador.php";
require_once "../../modelos/productos.modelo.php";


$reporte = $_GET["reporte"];

switch ($reporte) {

	case 'reporteC':
		$generar = new ControladorCompras();
		$generar -> ctrDescararReporteC();
		break;
	case 'reporteVentas':
		$generar = new ControladorVentas();
		$generar -> ctrDescararReporte();
		break;
	case 'reporteA':
		$generar = new ControladorAlmacen();
		$generar -> ctrDescararReporteAlmacen();
		break;
	case 'reporteClientes':
		$generar = new ControladorClientes();
		$generar -> ctrDescararReporte();
		break;
	case 'reporteProveedores':
		$generar = new ControladorProveedores();
		$generar -> ctrDescararReporte();
		break;
	case 'reporteEmpleados':
		$generar = new ControladorEmpleados();
		$generar -> ctrDescararReporte();
		break;
	case 'reporteProductos':
		$generar = new ControladorProductos();
		$generar -> ctrDescararReporte();
		break;
	case 'reporteInsumos':
		$generar = new ControladorInsumos();
		$generar -> ctrDescararReporte();
		break;

}
