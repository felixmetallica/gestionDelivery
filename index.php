<?php

require_once "controladores/plantilla.controlador.php";
require_once "controladores/ingreso.controlador.php";
require_once "controladores/personas.controlador.php";
require_once "controladores/usuarios.controlador.php";
require_once "controladores/empleados.controlador.php";
require_once "controladores/grupoFamiliar.controlador.php";
require_once "controladores/clientes.controlador.php";
require_once "controladores/proveedores.controlador.php";
require_once "controladores/configuracion.controlador.php";
require_once "controladores/productos.controlador.php";
require_once "controladores/insumos.controlador.php";
require_once "controladores/ventas.controlador.php";
require_once "controladores/compras.controlador.php";
require_once "controladores/payment.controlador.php";
require_once "controladores/recetas.controlador.php";
require_once "controladores/almacen.controlador.php";
require_once "controladores/payment.controlador.php";
require_once "controladores/moneda.controlador.php";
require_once "controladores/notificaciones.controlador.php";

require_once "modelos/conexion.php";
require_once "modelos/ingreso.modelo.php";
require_once "modelos/usuarios.modelo.php";
require_once "modelos/personas.modelo.php";
require_once "modelos/empleados.modelo.php";
require_once "modelos/grupoFamiliar.modelo.php";
require_once "modelos/clientes.modelo.php";
require_once "modelos/proveedores.modelo.php";
require_once "modelos/configuracion.modelo.php";
require_once "modelos/productos.modelo.php";
require_once "modelos/insumos.modelo.php";
require_once "modelos/ventas.modelo.php";
require_once "modelos/compras.modelo.php";
require_once "modelos/payment.modelo.php";
require_once "modelos/recetas.modelo.php";
require_once "modelos/almacen.modelo.php";
require_once "modelos/payment.modelo.php";
require_once "modelos/notificaciones.modelo.php";

$plantilla = new ControladorPlantilla();
$plantilla -> ctrPlantilla();
