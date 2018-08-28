<?php

class ControladorVentas{

/*=============================================
			MOSTRAR VENTAS
=============================================*/

	static public function ctrMostrarVentas($item, $valor){

		$tabla = "Venta";

		$respuesta = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);

		return $respuesta;

	}

/*=============================================
			TRAER MEDIOS DE PAGO
=============================================*/

	static public function ctrTraerMediosPagos(){

		$respuesta = ModeloVentas::mdlTraerMediosPagos("MedioPago");

		foreach ($respuesta as $row => $item){

			if ($item["Activo"] =="S") {

				echo '<option metodo="'.$item["MedioPagoID"].'" value="'.$item["MedioPagoID"].'">'.$item["Nombre"].'</option>';

			}

		}

	}

/*=============================================
			REGISTRAR VENTA
=============================================*/

	static public function ctrRegistrarVenta(){

		if (isset($_POST["nuevaVenta"])) {

			//ACTUALIZAMOS LAS VENTAS DE LOS PRODUCTOS

			$listaProductos = json_decode($_POST["listadoProductos"], true);

			foreach ($listaProductos as $key => $value) {

				$tablaProductos = "Producto";
				$tabla2 = "Rubro";

				$item = "ProductoID";
				$valor = $value["idProducto"];
				$orden = "ProductoID";

				$traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $tabla2, $item, $valor, $orden);

				$item1a = "Ventas";
				$valor1a = $value["cantidadProducto"] + $traerProducto["Ventas"];

				$nuevasVentas = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1a, $valor1a, $valor);


			}

			//ACTUALIZAR LAS COMPRAS DEL CLIENTE

			$tablaClientes = "Cliente";

			$tabla2 = "Persona";

			$tabla3 = "Domicilio";

			$tabla4 = "Localidad";

			$tabla5 = "Barrio";

			$tabla6 = "Telefono";

			$item = "ClienteID";

			$valor = $_POST["idClienteVenta"];

			$traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $tabla2, $tabla3, $tabla4, $tabla5, $tabla6, $item, $valor);

			$item1 = "Compras";

			$valor1 = $traerCliente["Compras"] + 1;

			$compraCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1, $valor1, $valor);

			$item1b = "UltimaCompra";

			date_default_timezone_set("America/Argentina/Tucuman");

			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$valor1b = $fecha.' '.$hora;

			$fechaCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1b, $valor1b, $valor);

			//GUARDAMOS LA VENTA

			$tabla = "Venta";

			if (isset($_POST["codTransVenta"])) {

				$codTrans = $_POST["codTransVenta"];

			} else {

				$codTrans = "";

			}

			$numFactura = str_replace("-", "", $_POST["nuevaVenta"]);

			$datos = array("UsuarioRegistraID" => $_POST["idUsuarioVenta"],
						   "ClienteID" => $_POST["idClienteVenta"],
						   "MedioPagoID" => $_POST["fPagoVenta"],
						   "CodTransaccion" => $codTrans,
						   "MontoDescuento" => $_POST["montoDescuento"],
						   "MontoRecargo" => $_POST["montoRecargo"],
						   "NroFactura" => $numFactura,
						   "Neto" => $_POST["precioNetoVenta"],
						   "Total" => $_POST["totalVentaFinal"]);

			$idVenta = ModeloVentas::mdlRegistrarVenta($tabla, $datos);

			if ($idVenta != "error") {

				$tablaVentaDetalle = "VentaDetalle";

				foreach ($listaProductos as $key => $value) {

					$Cantidad = $value["cantidadProducto"];
					$Precio = $value["precioProducto"];

					$tablaProductos = "Producto";
					$tabla2p = "Rubro";

					$itemp = "ProductoID";
					$valorp = $value["idProducto"];
					$orden = "ProductoID";

					$item1b = "Stock";

					$traerProd = ModeloProductos::mdlMostrarProductos($tablaProductos, $tabla2p, $itemp, $valorp, $orden);

					if ($traerProd["RestaStock"] == "S") {

						if ($traerProd["Tipo"] =="Entero") {

							//CALCULAMOS EL NUEVO STOCK, AL NO TENER RECETA NO SE RESTA RECETA
							$valor1b = $traerProd["Stock"] - $Cantidad;

						} else {

							//CALCULAMOS EL NUEVO STOCK
							$valor1b = $traerProd["Stock"] - $Cantidad;

						}

						//ACTUALIZAMOS STOCK DEL PRODUCTO
						$nuevoStockProducto = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valorp);

					} else {

						//RESTAMOS DE LA RECETA

						$tablaReceta = "Receta";
						$tablaRecetaDetalle = "RecetaDetalle";

						$traigoReceta = ModeloProductos::mdlMostrarRecetaProducto($tablaReceta, $tablaProductos, $tablaRecetaDetalle, $valorp);

						//RESTAMOS LOS INSUMOS DE LA RECETA

						foreach ($traigoReceta as $key => $value) {

							$tablaInsumos = "Insumos";
							$tabla2 = "Rubro";

							$item = "InsumosID";
							$idInsumo = $value["InsumosID"];

							$item1a = "Stock";

							//TRAIGO EL INSUMO
							$traerInsumos = ModeloInsumos::mdlMostrarInsumos($tablaInsumos, $tabla2, $item, $idInsumo);
							//CALCULAMOS EL NUEVO STOCK DE LOS INSUMOS DE LA RECETA
							$nuevoValorInsumo = $traerInsumos["Stock"] - ($Cantidad * $value["Cantidad"]);
							//ACTUALIZAMOS EL STOCK
							$nuevoStockInsumo = ModeloInsumos::mdlActualizarInsumo($tablaInsumos, $item1a, $nuevoValorInsumo, $idInsumo);

						}

					}

					//REGISTRAMOS EL PRODUCTO EN EL DETALLE
					$registroDetalle = ModeloVentas::mdlRegistrarDetalleVenta($tablaVentaDetalle, $idVenta, $valorp, $Cantidad, $Precio);

					//TRAEMOS LAS NOTIFICACIONES
					$notificaciones = ControladorNotificaciones::ctrMostrarNotificaciones();
					$valorActualNotificacion = $notificaciones["NuevasVentas"];
					$tablaNotificiones = "Notificaciones";

				}

				if($registroDetalle == "ok"){

					//ACTUALIZO LAS NOTIFICACIONES

					$itemN = "NuevasVentas";
					$valorN =$valorActualNotificacion+1;

					ModeloNotificaciones::mdlActualizarNotificaciones($tablaNotificiones, $itemN, $valorN);

					echo'<script>
							swal({
								title:"¡Registro Exitoso!",
								text:"¡La venta se registró correctamente!",
								type:"success",
								confirmButtonText: "Cerrar",
								closeOnConfirm: false
							},
								function(isConfirm){
									if(isConfirm){
										window.location="ventas";
								}
							});
						</script>';

				}else{

					echo'<script>
							swal({
								title:"¡Registro Fallido!",
								text:"¡Ocurrio un error, revise los datos!'.$respuesta.'",
								type:"error",
								confirmButtonText:"Cerrar",
								closeOnConfirm: false
							});
						</script>';

				}

			}// FIN ID VENTA

		}

	}

/*=============================================
			EDITAR VENTA
=============================================*/

	static public function ctrEditarVenta(){

		if (isset($_POST["editarVenta"])) {

			//FORMATEAR TABLA DE PRODUCTOS Y DE CLIENTES

			$tabla = "Venta";

			$itemv = "VentaID";

			$tablavd = "VentaDetalle";

			$tablap = "Producto";

			$idVentae = $_POST["idVenta"];

			$traigoVenta = ModeloVentas::mdlMostrarVentas($tabla, $itemv, $idVentae);

			$guardarFechas = array();

			//ACTUALIZAR FECHA ULTIMA COMPRA DEL CLIENTE

			$tablaClientes = "Cliente";
			$itemVentas = null;
			$valorVentas = null;

			$traerVentas = ModeloVentas::mdlMostrarVentas($tabla, $itemVentas, $valorVentas);

			foreach ($traerVentas as $key => $value) {

				if ($value["ClienteID"] == $traigoVenta["ClienteID"]) {

					array_push($guardarFechas, $value["FechaVenta"]);

				}

			}

			if (count($guardarFechas) > 1) {


				if ($traigoVenta["FechaVenta"] > $guardarFechas[count($guardarFechas)-2]) {

					$item = "UltimaCompra";
					$valor = $guardarFechas[count($guardarFechas)-2];
					$valorCliente = $traigoVenta["ClienteID"];
					$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item, $valor, $valorCliente);


				} else {

					$item = "UltimaCompra";
					$valor = $guardarFechas[count($guardarFechas)-1];
					$valorCliente = $traigoVenta["ClienteID"];
					$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item, $valor, $valorCliente);
				}

			} else {

				$item = "UltimaCompra";
				$valor = "0000-00-00 00:00:00";
				$valorCliente = $traigoVenta["ClienteID"];
				$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item, $valor, $valorCliente);

			}


			$clienteActual = $traigoVenta["ClienteID"];

			//REGRESAMOS AL ESTADO ANTERIOR LA CANTIDAD DE VENTAS DEL PRODUCTO Y SU STOCK

			$traerProductosVenta = ModeloVentas::mdlListadoProductos($tabla, $tablavd, $tablap, $idVentae);

			foreach ($traerProductosVenta as $key => $value) {

				$tablaProductos = "Producto";
				$tabla2 = "Rubro";

				$item = "ProductoID";
				$valor = $value["ProductoID"];
				$orden = "ProductoID";

				$item1b = "Stock";
				$cantidadProducto = $value["Cantidad"];

				//TRAEMOS EL LISTADO DE PRODUCTOS DE LA VENTA
				$traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $tabla2, $item, $valor, $orden);

				//REGRESAMOS LA CANTIDAD ANTERIOR DE VENTAS DEL PRODUCTO
				$item1a = "Ventas";
				$valor1a = $traerProducto["Ventas"] - $cantidadProducto;

				$nuevasVentas = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1a, $valor1a, $valor);

				//REGRESAMOS EL STOCK ANTERIOR DE LOS PRODUCTOS

				if ($traerProducto["RestaStock"] == "S") {

					if ($traerProducto["Tipo"] =="Entero") {

						//CALCULAMOS EL NUEVO STOCK, AL NO TENER RECETA NO SE RESTA RECETA
						$valor1b = $traerProducto["Stock"] + $cantidadProducto;

					} else {

						//CALCULAMOS EL NUEVO STOCK
						$valor1b = $traerProducto["Stock"] + $cantidadProducto;

					}

					//ACTUALIZAMOS STOCK DEL PRODUCTO
					$nuevoStockProducto = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);

				} else {

					//RESTAMOS DE LA RECETA

					$tablaReceta = "Receta";
					$tablaRecetaDetalle = "RecetaDetalle";

					$traigoReceta = ModeloProductos::mdlMostrarRecetaProducto($tablaReceta, $tablaProductos, $tablaRecetaDetalle, $valor);

					//RESTAMOS LOS INSUMOS DE LA RECETA

					foreach ($traigoReceta as $key => $valoraso) {

						$tablaInsumos = "Insumos";
						$tabla2 = "Rubro";

						$item = "InsumosID";
						$idInsumo = $valoraso["InsumosID"];

						$item1a = "Stock";

						//TRAIGO EL INSUMO
						$traerInsumos = ModeloInsumos::mdlMostrarInsumos($tablaInsumos, $tabla2, $item, $idInsumo);
						//CALCULAMOS EL NUEVO STOCK DE LOS INSUMOS DE LA RECETA
						$nuevoValorInsumo = $traerInsumos["Stock"] + ($cantidadProducto * $valoraso["Cantidad"]);
						//ACTUALIZAMOS EL STOCK
						$nuevoStockInsumo = ModeloInsumos::mdlActualizarInsumo($tablaInsumos, $item1a, $nuevoValorInsumo, $idInsumo);

					}

				}


			}

			//VOLVEMOS AL ESTADO ANTERIOR LA CANTIDAD DE PEDIDOS DEL CLIENTE

			$tablaClientes = "Cliente";

			$tablac2 = "Persona";

			$tablac3 = "Domicilio";

			$tablac4 = "Localidad";

			$tablac5 = "Barrio";

			$tablac6 = "Telefono";

			$itemCliente = "ClienteID";

			$valorCliente = $clienteActual;

			$traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $tablac2, $tablac3, $tablac4, $tablac5, $tablac6, $itemCliente, $valorCliente);

			$item1 = "Compras";

			$valor1 = $traerCliente["Compras"] - 1;

			$compraCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1, $valor1, $valorCliente);


			//ACTUALIZAMOS LAS VENTAS DE LOS PRODUCTOS

			$listaProductosE = json_decode($_POST["listadoProductos"], true);

			foreach ($listaProductosE as $key => $value2) {

				$tablaProductos_2 = "Producto";
				$tabla2_2 = "Rubro";

				$item_2 = "ProductoID";
				$valor_2 = $value2["idProducto"];
				$orden = "ProductoID";

				$traerProducto_2 = ModeloProductos::mdlMostrarProductos($tablaProductos_2, $tabla2_2, $item_2, $valor_2, $orden);

				$item1a_2 = "Ventas";
				$valor1a_2 = $value2["cantidadProducto"] + $traerProducto_2["Ventas"];

				$nuevasVentas_2 = ModeloProductos::mdlActualizarProducto($tablaProductos_2, $item1a_2, $valor1a_2, $valor_2);


			}

			//ACTUALIZAR LAS COMPRAS DEL CLIENTE

			$valorCliente_2 = $_POST["idClienteVenta"];

			$traerCliente_2 = ModeloClientes::mdlMostrarClientes($tablaClientes, $tablac2, $tablac3, $tablac4, $tablac5, $tablac6, $itemCliente, $valorCliente_2);

			$item1_2 = "Compras";

			$valor1_2 = $traerCliente_2["Compras"] + 1;

			$compraCliente_2 = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1_2, $valor1_2, $valorCliente_2);


			$item1b = "UltimaCompra";

			date_default_timezone_set("America/Argentina/Tucuman");

			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$valor1b = $fecha.' '.$hora;

			$fechaCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1b, $valor1b, $valorCliente_2);

			//GUARDAMOS LA VENTA

			if (isset($_POST["codTransVenta"])) {

				$codTrans = $_POST["codTransVenta"];

			} else {

				$codTrans = "";

			}

			$numFactura = str_replace("-", "", $_POST["editarVenta"]);

			$datos = array("VentaID" => $_POST["idVenta"],
						   "UsuarioRegistraID" => $_POST["idUsuarioVenta"],
						   "ClienteID" => $_POST["idClienteVenta"],
						   "MedioPagoID" => $_POST["fPagoVenta"],
						   "CodTransaccion" => $codTrans,
						   "MontoDescuento" => $_POST["montoDescuento"],
						   "MontoRecargo" => $_POST["montoRecargo"],
						   "NroFactura" => $numFactura,
						   "Neto" => $_POST["precioNetoVenta"],
						   "Total" => $_POST["totalVentaFinal"]);

			$editoVenta = ModeloVentas::mdlEditarVenta($tabla, $datos);


			if ($editoVenta != "error") {

				$tablaVentaDetalle = "VentaDetalle";

				$eliminoDetalle = ModeloVentas::mdlEliminarDetalleVenta($tablaVentaDetalle, $idVentae);

				foreach ($listaProductosE as $key => $value) {

					$Cantidad = $value["cantidadProducto"];
					$Precio = $value["precioProducto"];

					$tablaProductos = "Producto";
					$tabla2p = "Rubro";

					$itemp = "ProductoID";
					$valorp = $value["idProducto"];
					$orden = "ProductoID";

					$item1b = "Stock";

					$traerProd = ModeloProductos::mdlMostrarProductos($tablaProductos, $tabla2p, $itemp, $valorp, $orden);

					if ($traerProd["RestaStock"] == "S") {

						if ($traerProd["Tipo"] =="Entero") {

							//CALCULAMOS EL NUEVO STOCK, AL NO TENER RECETA NO SE RESTA RECETA
							$valor1b = $traerProd["Stock"] - $Cantidad;

						} else {

							//CALCULAMOS EL NUEVO STOCK
							$valor1b = $traerProd["Stock"] - $Cantidad;

						}

						//ACTUALIZAMOS STOCK DEL PRODUCTO
						$nuevoStockProducto = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valorp);

					} else {

						//RESTAMOS DE LA RECETA

						$tablaReceta = "Receta";
						$tablaRecetaDetalle = "RecetaDetalle";

						$traigoReceta = ModeloProductos::mdlMostrarRecetaProducto($tablaReceta, $tablaProductos, $tablaRecetaDetalle, $valorp);

						//RESTAMOS LOS INSUMOS DE LA RECETA

						foreach ($traigoReceta as $key => $value) {

							$tablaInsumos = "Insumos";
							$tabla2 = "Rubro";

							$item = "InsumosID";
							$idInsumo = $value["InsumosID"];

							$item1a = "Stock";

							//TRAIGO EL INSUMO
							$traerInsumos = ModeloInsumos::mdlMostrarInsumos($tablaInsumos, $tabla2, $item, $idInsumo);
							//CALCULAMOS EL NUEVO STOCK DE LOS INSUMOS DE LA RECETA
							$nuevoValorInsumo = $traerInsumos["Stock"] - ($Cantidad * $value["Cantidad"]);
							//ACTUALIZAMOS EL STOCK
							$nuevoStockInsumo = ModeloInsumos::mdlActualizarInsumo($tablaInsumos, $item1a, $nuevoValorInsumo, $idInsumo);

						}

					}

					//REGISTRAMOS EL PRODUCTO EN EL DETALLE
					$registroDetalle = ModeloVentas::mdlRegistrarDetalleVenta($tablaVentaDetalle, $idVentae, $valorp, $Cantidad, $Precio);


				}

				if($registroDetalle == "ok"){

					echo'<script>
							swal({
								title:"¡Modificación Exitosa!",
								text:"¡La venta se modificó correctamente!",
								type:"success",
								confirmButtonText: "Cerrar",
								closeOnConfirm: false
							},
								function(isConfirm){
									if(isConfirm){
										window.location="ventas";
								}
							});
						</script>';

				}else{

					echo'<script>
							swal({
								title:"¡Registro Fallido!",
								text:"¡Ocurrio un error, revise los datos!'.$registroDetalle.'",
								type:"error",
								confirmButtonText:"Cerrar",
								closeOnConfirm: false
							});
						</script>';

				}

			}// else if




			} // fin de if isset editar venta

	}

/*=============================================
			ELIMINAR VENTA
=============================================*/

	static public function ctrEliminarVenta($venta){

		$tabla = "Venta";
		$tablaVentaDetalle = "VentaDetalle";
		$item = "VentaID";
		$valor = $venta;

		$traerVenta = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);

		$guardarFechas = array();

		//ACTUALIZAR FECHA ULTIMA COMPRA DEL CLIENTE

		$tablaClientes = "Cliente";
		$itemVentas = null;
		$valorVentas = null;

		$traerVentas = ModeloVentas::mdlMostrarVentas($tabla, $itemVentas, $valorVentas);

		foreach ($traerVentas as $key => $value) {

			if ($value["ClienteID"] == $traerVenta["ClienteID"]) {

				array_push($guardarFechas, $value["FechaVenta"]);

			}

		}

		if (count($guardarFechas) > 1) {


			if ($traerVenta["FechaVenta"] > $guardarFechas[count($guardarFechas)-2]) {

				$item = "UltimaCompra";
				$valor = $guardarFechas[count($guardarFechas)-2];
				$valorCliente = $traerVenta["ClienteID"];
				$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item, $valor, $valorCliente);


			} else {

				$item = "UltimaCompra";
				$valor = $guardarFechas[count($guardarFechas)-1];
				$valorCliente = $traerVenta["ClienteID"];
				$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item, $valor, $valorCliente);
			}

		} else {

			$item = "UltimaCompra";
			$valor = "0000-00-00 00:00:00";
			$valorCliente = $traerVenta["ClienteID"];
			$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item, $valor, $valorCliente);

		}


			//FORMATEAMOS LAS TABLAS DE PRODUCTOS Y DE CLIENTES


			$tablavd = "VentaDetalle";

			$tablap = "Producto";

			$clienteActual = $traerVenta["ClienteID"];

			$traerProductosVenta = ModeloVentas::mdlListadoProductos($tabla, $tablavd, $tablap, $venta);

			foreach ($traerProductosVenta as $key => $value) {

				$tablaProductos = "Producto";
				$tabla2 = "Rubro";

				$item = "ProductoID";
				$valor = $value["ProductoID"];

				$traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $tabla2, $item, $valor);

				$item1a = "Ventas";
				$valor1a = $traerProducto["Ventas"] - $value["Cantidad"];

				$nuevasVentas = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1a, $valor1a, $valor);

			}

			$tablaClientes = "Cliente";

			$tablac2 = "Persona";

			$tablac3 = "Domicilio";

			$tablac4 = "Localidad";

			$tablac5 = "Barrio";

			$tablac6 = "Telefono";

			$itemCliente = "ClienteID";

			$valorCliente = $clienteActual;

			$traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $tablac2, $tablac3, $tablac4, $tablac5, $tablac6, $itemCliente, $valorCliente);

			$item1 = "Compras";

			$valor1 = $traerCliente["Compras"] - 1;

			$compraCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1, $valor1, $valorCliente);

			//ELIMINAMOS LA VENTA

			$respuesta = ModeloVentas::mdlEliminarVenta($tabla, $tablaVentaDetalle, $venta);

			if($respuesta=="ok"){

				echo 0;

			}else{

				echo 1;

			}
	}

/*=============================================
			ANULAR VENTA
=============================================*/

	static public function ctrAnularVenta(){

		if (isset($_POST["motivoAnula"])) {

			$tabla = "Venta";
			$tablaVentaDetalle = "VentaDetalle";
			$item = "VentaID";
			$valor = $_POST["idVentaA"];
			$venta = $_POST["idVentaA"];

			$traerVenta = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);

			$guardarFechas = array();

			//ACTUALIZAR FECHA ULTIMA COMPRA DEL CLIENTE

			$tablaClientes = "Cliente";
			$itemVentas = null;
			$valorVentas = null;

			$traerVentas = ModeloVentas::mdlMostrarVentas($tabla, $itemVentas, $valorVentas);

			foreach ($traerVentas as $key => $value) {

				if ($value["ClienteID"] == $traerVenta["ClienteID"]) {

					array_push($guardarFechas, $value["FechaVenta"]);

				}

			}

			if (count($guardarFechas) > 1) {

				if ($traerVenta["FechaVenta"] > $guardarFechas[count($guardarFechas)-2]) {

					$item = "UltimaCompra";
					$valor = $guardarFechas[count($guardarFechas)-2];
					$valorCliente = $traerVenta["ClienteID"];
					$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item, $valor, $valorCliente);

				} else {

					$item = "UltimaCompra";
					$valor = $guardarFechas[count($guardarFechas)-1];
					$valorCliente = $traerVenta["ClienteID"];
					$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item, $valor, $valorCliente);
				}

			} else {

				$item = "UltimaCompra";
				$valor = "0000-00-00 00:00:00";
				$valorCliente = $traerVenta["ClienteID"];
				$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item, $valor, $valorCliente);

			}

			//FORMATEAMOS LAS TABLAS DE PRODUCTOS Y DE CLIENTES

			$tablavd = "VentaDetalle";

			$tablap = "Producto";

			$clienteActual = $traerVenta["ClienteID"];

			$traerProductosVenta = ModeloVentas::mdlListadoProductos($tabla, $tablavd, $tablap, $venta);

			foreach ($traerProductosVenta as $key => $value) {

				$tablaProductos = "Producto";
				$tabla2 = "Rubro";

				$item = "ProductoID";
				$valorX = $value["ProductoID"];
				$orden = "ProductoID";

				$item1b = "Stock";
				$cantidadProducto = $value["Cantidad"];

				//TRAEMOS EL LISTADO DE PRODUCTOS DE LA VENTA
				$traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $tabla2, $item, $valorX, $orden);

				//REGRESAMOS LA CANTIDAD ANTERIOR DE VENTAS DEL PRODUCTO
				$item1a = "Ventas";
				$valor1a = $traerProducto["Ventas"] - $cantidadProducto;

				$nuevasVentas = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1a, $valor1a, $valorX);

				//REGRESAMOS EL STOCK ANTERIOR DE LOS PRODUCTOS

				if ($traerProducto["RestaStock"] == "S") {

					if ($traerProducto["Tipo"] =="Entero") {

						//CALCULAMOS EL NUEVO STOCK, AL NO TENER RECETA NO SE RESTA RECETA
						$valor1b = $traerProducto["Stock"] + $cantidadProducto;

					} else {

						//CALCULAMOS EL NUEVO STOCK
						$valor1b = $traerProducto["Stock"] + $cantidadProducto;

					}

					//ACTUALIZAMOS STOCK DEL PRODUCTO
					$nuevoStockProducto = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valorX);

				} else {

					//RESTAMOS DE LA RECETA

					$tablaReceta = "Receta";
					$tablaRecetaDetalle = "RecetaDetalle";

					$traigoReceta = ModeloProductos::mdlMostrarRecetaProducto($tablaReceta, $tablaProductos, $tablaRecetaDetalle, $valorX);

					//RESTAMOS LOS INSUMOS DE LA RECETA

					foreach ($traigoReceta as $key => $valoraso) {

						$tablaInsumos = "Insumos";
						$tabla2 = "Rubro";

						$item = "InsumosID";
						$idInsumo = $valoraso["InsumosID"];

						$item1a = "Stock";

						//TRAIGO EL INSUMO
						$traerInsumos = ModeloInsumos::mdlMostrarInsumos($tablaInsumos, $tabla2, $item, $idInsumo);
						//CALCULAMOS EL NUEVO STOCK DE LOS INSUMOS DE LA RECETA
						$nuevoValorInsumo = $traerInsumos["Stock"] + ($cantidadProducto * $valoraso["Cantidad"]);
						//ACTUALIZAMOS EL STOCK
						$nuevoStockInsumo = ModeloInsumos::mdlActualizarInsumo($tablaInsumos, $item1a, $nuevoValorInsumo, $idInsumo);

					}

				}

			}

				$tablaClientes = "Cliente";

				$tablac2 = "Persona";

				$tablac3 = "Domicilio";

				$tablac4 = "Localidad";

				$tablac5 = "Barrio";

				$tablac6 = "Telefono";

				$itemCliente = "ClienteID";

				$valorCliente = $clienteActual;

				$traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $tablac2, $tablac3, $tablac4, $tablac5, $tablac6, $itemCliente, $valorCliente);

				$item1 = "Compras";

				$valor1 = $traerCliente["Compras"] - 1;

				$compraCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1, $valor1, $valorCliente);

				//ANULAMOS LA VENTA

				$datos = array("UsuarioAnulaID" => $_POST["idUsuarioAnula"],
						   		"ventaID" => $_POST["idVentaA"],
						   		"motivo" => $_POST["motivoAnula"]);

				$respuesta = ModeloVentas::mdlAnularVenta($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>
							swal({
								title:"¡Anulación Exitosa!",
								text:"¡La venta se anuló correctamente!",
								type:"success",
								confirmButtonText: "Cerrar",
								closeOnConfirm: false
							},
								function(isConfirm){
									if(isConfirm){
										window.location="ventas";
								}
							});
						</script>';

				}else{

					echo'<script>
							swal({
								title:"¡Registro Fallido!",
								text:"¡Ocurrio un error, revise los datos!'.$respuesta.'",
								type:"error",
								confirmButtonText:"Cerrar",
								closeOnConfirm: false
							});
						</script>';

				}




		} // FIN IF

	}

/*=============================================
			LISTADO DE PRODUCTOS
=============================================*/

	static public function ctrListadoProductos($idVenta){

		$tabla1 = "Venta";

		$tabla2 = "VentaDetalle";

		$tabla3 = "Producto";

		$respuesta = ModeloVentas::mdlListadoProductos($tabla1, $tabla2, $tabla3, $idVenta);

		return $respuesta;

	}

/*==========================================
        	REGISTRAR CLIENTES
==========================================*/

	static public function ctrRegistroCliente(){

		if(isset($_POST["nombreCliente"])){

			#REALIZAMOS LA VALIDACION DEL LADO DEL SERVIDOR

			if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/', $_POST["nombreCliente"])&&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/', $_POST["apellidoCliente"])&&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/', $_POST["calleCliente"])&&
				preg_match('/^[0-9]+$/', $_POST["numCalleCliente"])&&
				preg_match('/^[0-9]*$/', $_POST["pisoCliente"]) &&
				preg_match('/^[a-zA-Z0-9_]*$/', $_POST["deptoCliente"]) &&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/', $_POST["barrioCliente"]) &&
				preg_match('/^[0-9]+$/', $_POST["codAreaTelefono"]) &&
				preg_match('/^[0-9]+$/', $_POST["numeroTeléfono"])){

				#ENVIAMOS LOS DATOS EN UN ARRAY AL MODELO

				$datosController = array("nombre"=>ucwords($_POST["nombreCliente"]),
										 "apellido"=>ucwords($_POST["apellidoCliente"]),
										 "calle"=>ucwords($_POST["calleCliente"]),
										 "numeroCalle"=>$_POST["numCalleCliente"],
										 "piso"=>$_POST["pisoCliente"],
										 "depto"=>ucwords($_POST["deptoCliente"]),
										 "localidad"=>ucwords($_POST["localidadCliente"]),
										 "barrio"=>ucwords($_POST["barrioCliente"]),
										 "codArea"=>$_POST["codAreaTelefono"],
										 "telefono"=>$_POST["numeroTeléfono"],
										 "comentario"=>$_POST["comentarioCliente"]);


				$respuesta = ModeloClientes::mdlRegistroCliente($datosController, "Persona", "Cliente", "Telefono", "Localidad", "Barrio", "Domicilio");

				if($respuesta == "ok"){

					echo'<script>
							swal({
								title:"¡Registro Exitoso!",
								text:"¡Los datos del cliente se registraron correctamente!",
								type:"success",
								confirmButtonText: "Cerrar",
								closeOnConfirm: false
							},
								function(isConfirm){
									if(isConfirm){
										window.location="crear-venta";
								}
							});
						</script>';

				}else{

					echo'<script>
							swal({
								title:"¡Registro Fallido!",
								text:"¡Ocurrio un error, revise los datos!'.$respuesta.'",
								type:"error",
								confirmButtonText:"Cerrar",
								closeOnConfirm: false
							});
						</script>';

				}


			}else{

				echo '<script>
						swal({
							title:"¡Error!",
							text:"¡No ingrese caracteres especiales!",
							type:"warning",
							confirmButtonText:"Cerrar",
							closeOnConfirm:false
						},
							function(isConfirm){
								if(isConfirm){
									window.location="crear-venta";
							}
						});
					 </script>';

			}
		}

	}

/*=============================================
			IMPRIMIR COMPROBANTE
=============================================*/

	static public function ctrImprimirCombrobante(){

		if (isset($_POST["TipoComprobante"])) {

			$idVenta = $_POST["idVentaC"];

			$comprobante = $_POST["TipoComprobante"];

			switch ($comprobante) {

				case 'C':
					echo '<script>
					 			window.open("extensiones/tcpdf/pdf/factura.php?venta='.$idVenta.'", "_blank");
					 			window.location = "ventas";
					 		</script>';
					break;
				case 'X':
					echo '<script>
					 			window.open("extensiones/tcpdf/pdf/recibo.php?venta='.$idVenta.'", "_blank");
					 			window.location = "ventas";
					 		</script>';
					break;

				default:
					# code...
					break;
			}

		}

	}

/*=============================================
			RANGO DE FECHAS
=============================================*/

	static public function ctrRangoFechaVentas($fechaInicial, $fechaFinal){

		$tabla = "Venta";

		$respuesta = ModeloVentas::mdlRangoFechaVentas($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;

	}

/*=============================================
			RANGO DE FECHAS GRAFICO
=============================================*/

	static public function ctrRangoFechaVentasGrafico($fechaInicial, $fechaFinal){

		$tabla = "Venta";

		$respuesta = ModeloVentas::mdlRangoFechaVentasGrafico($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;

	}

/*=============================================
			TIPO DE FACTURA
=============================================*/

	static public function ctrTipoFactura($venta, $tipo){

		$tabla = "Venta";

		$respuesta = ModeloVentas::mdlTipoFactura($tabla, $venta, $tipo);

		return $respuesta;

	}

/*=============================================
			SUMA TOTAL DE LAS VENTAS
=============================================*/

	static public function ctrSumaTotalVentas(){

		$tabla = "Venta";

		$respuesta = ModeloVentas::mdlSumaTotalVentas($tabla);

		return $respuesta;

	}

/*=============================================
        	TRAER INSUMOS
=============================================*/

    static public function ctrTraerInsumo($valor){

        $tabla = "Insumos";

        $respuesta = ModeloVentas::mdlTraerInsumo($tabla1, $valor);

        return $respuesta;

    }

/*=============================================
        	DESCARGAR REPORTE
=============================================*/

    static public function ctrDescararReporte(){

        if (isset($_GET["reporte"])) {

        	$tabla = "Venta";

        	if (isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])) {

        		$ventas = ModeloVentas::mdlRangoFechaVentas($tabla, $_GET["fechaInicial"], $_GET["fechaFinal"]);

        	} else {

        		$item = null;
        		$valor = null;

        		$ventas = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);

        	}

        	//CREAMOS EL ARCHIVO DE EXCEL

        	$name = 'reporte-ventas.xls';
        	header('Expires: 0');
					header('Cache-control: private');
					header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
					header("Cache-Control: cache, must-revalidate");
					header('Content-Description: File Transfer');
					header('Last-Modified: '.date('D, d M Y H:i:s'));
					header("Pragma: public");
					header('Content-Disposition:; filename="'.$name.'"');
					header("Content-Transfer-Encoding: binary");

					echo utf8_decode("<table border='0'>

					<tr>
						<td colspan=12 align='center' bgcolor='#9DD1A7'>REPORTE DE VENTAS</td>
					</tr>
					<tr>
						<th align='center' bgcolor='#88C1E3'>FECHA</th>
						<th align='center' bgcolor='#88C1E3'>N° Factura</th>
						<th align='center' bgcolor='#88C1E3'>CLIENTE</th>
						<th align='center' bgcolor='#88C1E3'>VENDEDOR</th>
						<th align='center' bgcolor='#88C1E3'>CANTIDAD</th>
						<th align='center' bgcolor='#88C1E3'>PRODUCTOS</th>
						<th align='center' bgcolor='#88C1E3'>DESCUENTO</th>
						<th align='center' bgcolor='#88C1E3'>RECARGO</th>
						<th align='center' bgcolor='#88C1E3'>NETO</th>
						<th align='center' bgcolor='#88C1E3'>TOTAL</th>
						<th align='center' bgcolor='#88C1E3'>METODO DE PAGO</th>
						<th align='center' bgcolor='#88C1E3'>ESTADO</th>
					</tr>");

			foreach ($ventas as $row => $item){

				$cliente = ControladorClientes::ctrMostrarClientes("ClienteID", $item["ClienteID"]);
				$vendedor = ControladorUsuarios::ctrMostrarUsuarios("UsuarioID", $item["UsuarioRegistraID"]);
				$productosVenta = ControladorVentas::ctrListadoProductos($item["VentaID"]);

				if ($item["Estado"]!= "Z") {

					$estado= "Registrada";

				}else{

					$estado = "Anulada";
				}

			 echo utf8_decode("<tr>
			 			<td bgcolor='#FAEDB1'>".substr($item["FechaVenta"],0,10)."</td>
			 			<td bgcolor='#FAEDB1'>".$item["NroFactura"]."</td>
			 			<td bgcolor='#FAEDB1'>".$cliente["Nombre"]." ".$cliente["Apellido"]."</td>
			 			<td bgcolor='#FAEDB1'>".$vendedor["nombrePersona"]." ".$vendedor["Apellido"]."</td>
			 			<td bgcolor='#FAEDB1'>");

			 	//$productos =  json_decode($item["productos"], true);

			 	foreach ($productosVenta as $key => $valueProductos) {

			 			echo utf8_decode($valueProductos["Cantidad"]."<br>");
			 		}

			 	echo utf8_decode("</td><td bgcolor='#FAEDB1'>");

		 		foreach ($productosVenta as $key => $valueProductos) {

		 			echo utf8_decode($valueProductos["Nombre"]."<br>");

		 		}

		 		echo utf8_decode("</td>
					<td bgcolor='#FAEDB1'>$ ".number_format($item["MontoDescuento"],2)."</td>
					<td bgcolor='#FAEDB1'>$ ".number_format($item["MontoRecargo"],2)."</td>
					<td bgcolor='#FAEDB1'>$ ".number_format($item["Neto"],2)."</td>
					<td bgcolor='#FAEDB1'>$ ".number_format($item["Total"],2)."</td>
					<td bgcolor='#FAEDB1'>".$item["MDP"]."</td>
					<td bgcolor='#FAEDB1'>".$estado."</td>
					</tr>");


			}


			echo "</table>";

        }

    }


}
