<?php

class ControladorCompras{

/*=============================================
			MOSTRAR COMPRAS
=============================================*/

	static public function ctrMostrarCompras($item, $valor){

		$tabla = "Compra";

		$respuesta = ModeloCompras::mdlMostrarCompras($tabla, $item, $valor);

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
			REGISTRAR COMPRA
=============================================*/

	static public function ctrCrearCompra(){

		if (isset($_POST["nuevaCompra"])) {

			//ACTUALIZAMOS LAS COMPRAS DE LOS INSUMOS EL STOCK

			$listaInsumos = json_decode($_POST["listadoInsumos"], true);

			foreach ($listaInsumos as $key => $value) {

				if ($value["tipo"] != "Producto") {

					//ACTUALIZAMOS STOCK DE INSUMOS

					$tablaInsumos = "Insumos";
					$tabla2 = "Rubro";

					$item = "InsumosID";
					$valor = $value["idInProd"];

					$traerInsumos = ModeloInsumos::mdlMostrarInsumos($tablaInsumos, $tabla2, $item, $valor);

					$item1a = "Stock";
					$valor1a = $value["cantidad"] + $traerInsumos["Stock"];

					$nuevoStockInsumo = ModeloInsumos::mdlActualizarInsumo($tablaInsumos, $item1a, $valor1a, $valor);

				} else {

					//ACTUALIZAMOS STOCK DE PRODUCTOS

					$tablaProductos = "Producto";
					$tabla2p = "Rubro";

					$itemp = "ProductoID";
					$valorp = $value["idInProd"];
					$orden = "ProductoID";

					$traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $tabla2p, $itemp, $valorp, $orden);

					$item1b = "Stock";
					$valor1b = $value["cantidad"] + $traerProducto["Stock"];

					$nuevoStockProducto = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valorp);

				}

			}

			//GUARDAMOS LA COMPRA

			$tabla = "Compra";

			$numeroOrden = str_replace("-", "", $_POST["nuevaCompra"]);

			$datos = array("UsuarioRegistraID" => $_POST["idUsuarioCompra"],
						   "ProveedorID" => $_POST["idProveedorCompra"],
						   "MedioPagoID" => $_POST["fPagoCompra"],
						   "MontoImpuesto" => $_POST["nuevoPrecioImpuesto"],
						   "NroCompra" => $numeroOrden,
						   "Neto" => $_POST["precioNetoCompra"],
						   "Total" => $_POST["totalCompraFinal"]);

			$idCompra = ModeloCompras::mdlRegistrarCompra($tabla, $datos);

			if ($idCompra != "error") {

				$tablaCompraDetalle = "CompraDetalle";

				foreach ($listaInsumos as $key => $value) {

					if ($value["tipo"] != "Producto") {

						//es insumo
						$idProducto = null;
						$idInsumo = $value["idInProd"];
						$Cantidad = $value["cantidad"];
						$Precio = $value["precio"];

						$respuesta = ModeloCompras::mdlRegistrarDetalleCompra($tablaCompraDetalle, $idCompra, $idInsumo, $idProducto, $Cantidad, $Precio);

					} else {

						$idProducto = $value["idInProd"];
						$idInsumo = null;
						$Cantidad = $value["cantidad"];
						$Precio = $value["precio"];

						$respuesta = ModeloCompras::mdlRegistrarDetalleCompra($tablaCompraDetalle, $idCompra, $idInsumo, $idProducto, $Cantidad, $Precio);

					}



				}

				if($respuesta == "ok"){

					echo'<script>
							swal({
								title:"¡Registro Exitoso!",
								text:"¡La compra se registró correctamente!",
								type:"success",
								confirmButtonText: "Cerrar",
								closeOnConfirm: false
							},
								function(isConfirm){
									if(isConfirm){
										window.location="compras";
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

			}// else if

		}

	}

/*=============================================
			EDITAR COMPRA
=============================================*/

	static public function ctrEditarCompra(){

		if (isset($_POST["editarCompra"])) {

			//FORMATEAR EL STOCK DE LOS INSUMOS Y DE PRODUCTOS

			$tablaCompraDetalle = "CompraDetalle";

			$idComprae = $_POST["idCompra"];

			$listarCompra =ModeloCompras::mdlListadoCompra($tablaCompraDetalle, $idComprae);

    	    foreach ($listarCompra as $key => $value) {

         	   if ($value["InsumosID"] == null) {

         	   		//STOCK DE PRODUCTOS

         	   		$tablaProductos = "Producto";
        			$tabla2 = "Rubro";

        			$item = "ProductoID";
        			$valor = $value["ProductoID"];
        			$orden = "ProductoID";

        			$traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $tabla2, $item, $valor, $orden);

        			$item1b = "Stock";
					$valor1b = $traerProducto["Stock"] - $value["Cantidad"];

					$actualizoProducto = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);



         	   } else {

         	   		//STOCK DE INSUMOS

         	   		$tablaInsumos = "Insumos";
					$tabla2 = "Rubro";

					$item = "InsumosID";
					$valor = $value["InsumosID"];

					$traerInsumos = ModeloInsumos::mdlMostrarInsumos($tablaInsumos, $tabla2, $item, $valor);

					$item1a = "Stock";
					$valor1a = $traerInsumos["Stock"] - $value["Cantidad"];

					$actualizoInsumo = ModeloInsumos::mdlActualizarInsumo($tablaInsumos, $item1a, $valor1a, $valor);

         	   }

         	}

         	//ACTUALIZAMOS EL STOCK DE PRODUCTOS E INSUMOS

			$listaInsumos = json_decode($_POST["listadoInsumos"], true);

			foreach ($listaInsumos as $key => $value) {

				if ($value["tipo"] != "Producto") {

					//ACTUALIZAMOS STOCK DE INSUMOS

					$tablaInsumos = "Insumos";
					$tabla2 = "Rubro";

					$item = "InsumosID";
					$valor = $value["idInProd"];

					$traerInsumos = ModeloInsumos::mdlMostrarInsumos($tablaInsumos, $tabla2, $item, $valor);

					$item1a = "Stock";
					$valor1a = $value["cantidad"] + $traerInsumos["Stock"];

					$nuevoStockInsumo = ModeloInsumos::mdlActualizarInsumo($tablaInsumos, $item1a, $valor1a, $valor);

				} else {

					//ACTUALIZAMOS STOCK DE PRODUCTOS

					$tablaProductos = "Producto";
					$tabla2p = "Rubro";

					$itemp = "ProductoID";
					$valorp = $value["idInProd"];
					$orden = "ProductoID";

					$traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $tabla2p, $itemp, $valorp, $orden);

					$item1b = "Stock";
					$valor1b = $value["cantidad"] + $traerProducto["Stock"];

					$nuevoStockProducto = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valorp);

				}

			}

			$nomOrden = str_replace("-", "", $_POST["editarCompra"]);

			$datos = array("CompraID" => $_POST["idCompra"],
						   "ProveedorID" => $_POST["idProveedorCompra"],
						   "UsuarioRegistraID" => $_POST["idUsuarioCompra"],
						   "MedioPagoID" => $_POST["fPagoCompra"],
						   "Impuesto" => $_POST["nuevoPrecioImpuesto"],
						   "NroCompra" => $nomOrden,
						   "Neto" => $_POST["precioNetoCompra"],
						   "Total" => $_POST["totalCompraFinal"]);

			$tabla = "Compra";

			$editoCompra = ModeloCompras::mdlEditarCompra($tabla, $datos);

			if ($editoCompra != "error") {

				$eliminoDetalle = ModeloCompras::mdlEliminarDetalleCompra($tablaCompraDetalle, $idComprae);

				foreach ($listaInsumos as $key => $value) {

					if ($value["tipo"] != "Producto") {

						//es insumo
						$idProducto = null;
						$idInsumo = $value["idInProd"];
						$Cantidad = $value["cantidad"];
						$Precio = $value["precio"];

						$respuesta = ModeloCompras::mdlRegistrarDetalleCompra($tablaCompraDetalle, $idComprae, $idInsumo, $idProducto, $Cantidad, $Precio);

					} else {

						$idProducto = $value["idInProd"];
						$idInsumo = null;
						$Cantidad = $value["cantidad"];
						$Precio = $value["precio"];

						$respuesta = ModeloCompras::mdlRegistrarDetalleCompra($tablaCompraDetalle, $idComprae, $idInsumo, $idProducto, $Cantidad, $Precio);

					}

				}

			}//fin respuesta editoCompra

			if($respuesta == "ok"){

					echo'<script>
							swal({
								title:"¡Modificación Exitosa!",
								text:"¡La compra se modificó correctamente!",
								type:"success",
								confirmButtonText: "Cerrar",
								closeOnConfirm: false
							},
								function(isConfirm){
									if(isConfirm){
										window.location="compras";
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



		} //fin isset

	}

/*=============================================
			ANULAR COMPRA
=============================================*/

	static public function ctrAnularCompra(){

		if (isset($_POST["motivoAnula"])) {

			$tabla = "Compra";
			$tablaVentaDetalle = "CompraDetalle";
			$item = "CompraID";
			$valor = $_POST["idCompraA"];

			//FORMATEAR EL STOCK DE LOS INSUMOS

			$traigoDetalle = ControladorInsumos::ctrMostrarInsumosCompra($item, $valor);

			foreach ($traigoDetalle as $key => $value) {

				if ($value["Tipo"] !="Producto") {

					//STOCK DE INSUMOS

         	   		$tablaInsumos = "Insumos";
					$tabla2 = "Rubro";

					$item = "InsumosID";
					$valor = $value["Id"];

					$traerInsumos = ModeloInsumos::mdlMostrarInsumos($tablaInsumos, $tabla2, $item, $valor);

					$item1a = "Stock";
					$valor1a = $traerInsumos["Stock"] - $value["Cantidad"];

					$actualizoInsumo = ModeloInsumos::mdlActualizarInsumo($tablaInsumos, $item1a, $valor1a, $valor);

				} else {

					//STOCK DE PRODUCTOS

         	   		$tablaProductos = "Producto";
        			$tabla2 = "Rubro";

        			$item = "ProductoID";
        			$valor = $value["Id"];
        			$orden = "ProductoID";

        			$traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $tabla2, $item, $valor, $orden);

        			$item1b = "Stock";
					$valor1b = $traerProducto["Stock"] - $value["Cantidad"];

					$actualizoProducto = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);

				}


			}

			//ANULAMOS LA COMPRA

			$datos = array("UsuarioAnulaID" => $_POST["idUsuarioAnula"],
						   		"compraID" => $_POST["idCompraA"],
						   		"motivo" => $_POST["motivoAnula"]);

			$respuesta = ModeloCompras::mdlAnularCompra($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>
						swal({
							title:"¡Anulación Exitosa!",
							text:"¡La compra se anuló correctamente!",
							type:"success",
							confirmButtonText: "Cerrar",
							closeOnConfirm: false
						},
							function(isConfirm){
								if(isConfirm){
									window.location="compras";
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
			RANGO DE FECHAS
=============================================*/

	static public function ctrRangoFechaCompras($fechaInicial, $fechaFinal){

		$tabla = "Compra";

		$respuesta = ModeloCompras::mdlRangoFechaCompras($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;

	}

/*=============================================
			RANGO DE FECHAS GRAFICO
=============================================*/

	static public function ctrRangoFechaComprasGrafico($fechaInicial, $fechaFinal){

		$tabla = "Compra";

		$respuesta = ModeloCompras::mdlRangoFechaComprasGrafico($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;

	}

/*=============================================
			LISTADO DE INSUMOS
=============================================*/

	static public function ctrListadoInsumos($idCompra){

		$tabla1 = "Compra";

		$tabla2 = "CompraDetalle";

		$tabla3 = "Insumos";

		$respuesta = ModeloCompras::mdlListadoInsumos($tabla1, $tabla2, $tabla3, $idCompra);

		return $respuesta;

	}

/*=============================================
			LISTADO DE DE COMPRA
=============================================*/

	static public function ctrListadoCompra($idCompra){

		$tabla = "CompraDetalle";

		$respuesta = ModeloCompras::mdlListadoCompra($tabla, $idCompra);

		return $respuesta;

	}

/*=============================================
			TIPO DE NOTA
=============================================*/

	static public function ctrTipoNota($compra, $tipo){

		$tabla = "Compra";

		$respuesta = ModeloCompras::mdlTipoNota($tabla, $compra, $tipo);

		return $respuesta;

	}

/*=============================================
        	DESCARGAR REPORTE
=============================================*/

    static public function ctrDescararReporteC(){

        if (isset($_GET["reporte"])) {

        	$tabla = "Compra";

        	if (isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])) {

        		$compras = ModeloCompras::mdlRangoFechaCompras($tabla, $_GET["fechaInicial"], $_GET["fechaFinal"]);

        	} else {

        		$item = null;
        		$valor = null;

        		$compras = ModeloCompras::mdlMostrarCompras($tabla, $item, $valor);

        	}

        	//CREAMOS EL ARCHIVO DE EXCEL

        	$name = 'reporte-compras.xls';
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
						<td colspan=11 align='center' bgcolor='#9DD1A7'>REPORTE DE COMPRAS</td>
					</tr>
					<tr>
						<th align='center' bgcolor='#88C1E3'>FECHA</th>
						<th align='center' bgcolor='#88C1E3'>N° ORDEN</th>
						<th align='center' bgcolor='#88C1E3'>PROVEEDOR</th>
						<th align='center' bgcolor='#88C1E3'>USUARIO COMPRA</th>
						<th align='center' bgcolor='#88C1E3'>CANTIDAD</th>
						<th align='center' bgcolor='#88C1E3'>INSUMOS</th>
						<th align='center' bgcolor='#88C1E3'>IMPUESTO</th>
						<th align='center' bgcolor='#88C1E3'>NETO</th>
						<th align='center' bgcolor='#88C1E3'>TOTAL</th>
						<th align='center' bgcolor='#88C1E3'>METODO DE PAGO</th>
						<th align='center' bgcolor='#88C1E3'>ESTADO</th>
					</tr>");

			foreach ($compras as $row => $item){

				$proveedor = ControladorProveedores::ctrMostrarProveedores("ProveedorID", $item["ProveedorID"]);
				$usuario = ControladorUsuarios::ctrMostrarUsuarios("UsuarioID", $item["UsuarioID"]);
				$insumosVenta = ControladorCompras::ctrListadoInsumos($item["CompraID"]);

				if ($item["Estado"]!= "Z") {

					$estado= "Registrada";

				}else{

					$estado = "Anulada";
				}

			 echo utf8_decode("<tr>
			 						 			<td bgcolor='#FAEDB1'>".$item["fechaFormateada"]."</td>
			 									<td bgcolor='#FAEDB1'>".$item["NroCompra"]."</td>
			 									<td bgcolor='#FAEDB1'>".$proveedor["RazonSocial"]."</td>
			 									<td bgcolor='#FAEDB1'>".$usuario["nombrePersona"]." ".$usuario["Apellido"]."</td>
			 									<td bgcolor='#FAEDB1'>");

			 	//$productos =  json_decode($item["productos"], true);

			 	foreach ($insumosVenta as $key => $valueInsumos) {

			 			echo utf8_decode($valueInsumos["Cantidad"]."<br>");
			 		}

			 	echo utf8_decode("</td><td bgcolor='#FAEDB1'>");

		 		foreach ($insumosVenta as $key => $valueInsumos) {

		 			echo utf8_decode($valueInsumos["Nombre"]."<br>");

		 		}

		 		echo utf8_decode("</td>
														<td bgcolor='#FAEDB1'>$ ".number_format($item["Impuesto"],2)."</td>
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
