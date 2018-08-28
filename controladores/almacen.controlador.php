<?php

class ControladorAlmacen{

/*==========================================
		MOSTRAR PRODUCTOS/INSUMOS
==========================================*/

	public function ctrMostrarProductosInsumos($item, $valor){

		$tabla1 = "Insumos";

        $tabla2 = "Producto";

        $respuesta = ModeloAlmacen::mdlMostrarProductosInsumos($tabla1, $tabla2, $item, $valor);

        return $respuesta;


	}

/*==========================================
		MOSTRAR MOVIMIENTOS
==========================================*/

	public function ctrMostrarMovimientos($item, $valor){

		$tabla1 = "Almacen";
		$tabla2 = "Usuario";
		$tabla3 = "Persona";

        $respuesta = ModeloAlmacen::mdlMostrarMovimientos($tabla1, $tabla2, $tabla3, $item, $valor);

        return $respuesta;


	}

/*==========================================
        REGISTRAR MOVIMIENTO
==========================================*/

	static public function ctrRegistroMovimiento(){

		if(isset($_POST["insumoProdMovimiento"])){

			#REALIZAMOS LA VALIDACION DEL LADO DEL SERVIDOR

			if (preg_match('/^[0-9]+$/', $_POST["insumoProdMovimiento"])&&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/', $_POST["tipoMovimiento"])&&
				preg_match('/^[0-9]+$/', $_POST["cantidadMovimiento"])&&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/', $_POST["descripcionMovimiento"])){

				#ACTUALIZAMOS STOCK

				if ($_POST["tipoProdInsMovimiento"] == "Insumo") {

					//ACTUALIZAMOS STOCK DE INSUMOS

					$tablaInsumos = "Insumos";
					$tabla2 = "Rubro";

					$item = "InsumosID";
					$valor = $_POST["idProdInsMovimiento"];

					$traerInsumos = ModeloInsumos::mdlMostrarInsumos($tablaInsumos, $tabla2, $item, $valor);

					$item1a = "Stock";

					if ($_POST["tipoMovimiento"] == "I") {

						$valor1a = $_POST["cantidadMovimiento"] + $traerInsumos["Stock"];

					} else {

						$valor1a = $traerInsumos["Stock"] - $_POST["cantidadMovimiento"];
					}

					$nuevoStockInsumo = ModeloInsumos::mdlActualizarInsumo($tablaInsumos, $item1a, $valor1a, $valor);

				} else {

					//ACTUALIZAMOS STOCK DE PRODUCTOS

					$tablaProductos = "Producto";
					$tabla2p = "Rubro";

					$itemp = "ProductoID";
					$valorp = $_POST["idProdInsMovimiento"];
					$orden = "ProductoID";

					$traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $tabla2p, $itemp, $valorp, $orden);

					$item1b = "Stock";

					if ($_POST["tipoMovimiento"] == "I") {

						$tablaReceta = "Receta";
						$tablaRecetaDetalle = "RecetaDetalle";

						$traigoReceta = ModeloProductos::mdlMostrarRecetaProducto($tablaReceta, $tablaProductos, $tablaRecetaDetalle, $valorp);

						if ($traigoReceta !="") {

							//RESTAMOS LOS INSUMOS DE LA RECETA

							foreach ($traigoReceta as $key => $value) {

								$tablaInsumos = "Insumos";
								$tabla2 = "Rubro";

								$item = "InsumosID";
								$idInsumo = $value["InsumosID"];

								$item1a = "Stock";

								//TRAIGO EL INSUMO
								$traerInsumos = ModeloInsumos::mdlMostrarInsumos($tablaInsumos, $tabla2, $item, $idInsumo);
								//CALCULAMOS EL NUEVO STOCK
								$nuevoValorInsumo = $traerInsumos["Stock"] - ($_POST["cantidadMovimiento"] * $value["Cantidad"]);
								//ACTUALIZAMOS EL STOCK
								$nuevoStockInsumo = ModeloInsumos::mdlActualizarInsumo($tablaInsumos, $item1a, $nuevoValorInsumo, $idInsumo);

							}

							$valor1b = $_POST["cantidadMovimiento"] + $traerProducto["Stock"];

						} else {

							$valor1b = $_POST["cantidadMovimiento"] + $traerProducto["Stock"];

						}


					} else {

						$valor1b = $traerProducto["Stock"] - $_POST["cantidadMovimiento"];
					}

					$nuevoStockProducto = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valorp);

				}

				#ENVIAMOS LOS DATOS EN UN ARRAY AL MODELO

				$tabla = "Almacen";

				if ($_POST["tipoProdInsMovimiento"] =="Producto") {

					$idProducto = $_POST["idProdInsMovimiento"];
					$idInsumo = NULL;

				} else {

					$idInsumo = $_POST["idProdInsMovimiento"];
					$idProducto = NULL;

				}

				$datosController = array("idInsumo"=>$idInsumo,
										 "idProducto"=>$idProducto,
										 "nombre"=>$_POST["nombreProdInsMovimiento"],
										 "fecha"=>$_POST["fechaMovimiento"],
										 "tipoMovimiento"=>$_POST["tipoMovimiento"],
										 "cantidad"=>$_POST["cantidadMovimiento"],
										 "descripcion"=>$_POST["descripcionMovimiento"],
										 "idUsuario"=>$_POST["idUsuarioMovimiento"]);


				$respuesta = ModeloAlmacen::mdlRegistroMovimiento($tabla, $datosController);

				if($respuesta == "ok"){

					echo'<script>
							swal({
								title:"¡Registro Exitoso!",
								text:"¡Los datos del movimiento se registraron correctamente!",
								type:"success",
								confirmButtonText: "Cerrar",
								closeOnConfirm: false
							},
								function(isConfirm){
									if(isConfirm){
										window.location="almacen";
								}
							});
						</script>';

				}else{

					echo'<script>
							swal({
								title:"¡Registro Fallido!",
								text:"¡Ocurrio un error, revise los datos!'.print_r($respuesta).'",
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
									window.location="almacen";
							}
						});
					 </script>';

			}
		}

	}

/*==========================================
        EDITAR MOVIMIENTO
==========================================*/

	static public function ctrEditarMovimiento(){

		if(isset($_POST["idMovimiento"])){

			#REALIZAMOS LA VALIDACION DEL LADO DEL SERVIDOR

			if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/', $_POST["etipoMovimiento"])){

				$actual = json_decode($_POST["valoresActuales"], true);

				#FORMATEAMOS EL STOCK AFECTADO

				if ($actual[0]["tipo"] == "Insumo") {

					//RESTAURAMOS STOCK DE INSUMOS

					$tablaInsumos = "Insumos";
					$tabla2 = "Rubro";

					$item = "InsumosID";
					$valor = $actual[0]["id"];

					$traerInsumos = ModeloInsumos::mdlMostrarInsumos($tablaInsumos, $tabla2, $item, $valor);

					$item1a = "Stock";

					if ($actual[0]["tipoMov"] == "I") {

						$valor1a = $traerInsumos["Stock"] - $actual[0]["cantidad"];

					} else {

						$valor1a = $actual[0]["cantidad"] + $traerInsumos["Stock"];

					}

					$nuevoStockInsumo = ModeloInsumos::mdlActualizarInsumo($tablaInsumos, $item1a, $valor1a, $valor);

				} else {

					//RESTAURAMOS STOCK DE PRODUCTOS

					$tablaProductos = "Producto";
					$tabla2p = "Rubro";

					$itemp = "ProductoID";
					$valorp = $actual[0]["id"];
					$orden = "ProductoID";

					$traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $tabla2p, $itemp, $valorp, $orden);

					$item1b = "Stock";

					if ($actual[0]["tipoMov"] == "I") {

						$tablaReceta = "Receta";
						$tablaRecetaDetalle = "RecetaDetalle";

						$traigoReceta = ModeloProductos::mdlMostrarRecetaProducto($tablaReceta, $tablaProductos, $tablaRecetaDetalle, $valorp);

						if ($traigoReceta !="") {

							//RESTAMOS LOS INSUMOS DE LA RECETA

							foreach ($traigoReceta as $key => $value) {

								$tablaInsumos = "Insumos";
								$tabla2 = "Rubro";

								$item = "InsumosID";
								$idInsumo = $value["InsumosID"];

								$item1a = "Stock";

								//TRAIGO EL INSUMO
								$traerInsumos = ModeloInsumos::mdlMostrarInsumos($tablaInsumos, $tabla2, $item, $idInsumo);
								//CALCULAMOS EL NUEVO STOCK
								$nuevoValorInsumo = ($actual[0]["cantidad"] * $value["Cantidad"] + $traerInsumos["Stock"]);
								//ACTUALIZAMOS EL STOCK
								$nuevoStockInsumo = ModeloInsumos::mdlActualizarInsumo($tablaInsumos, $item1a, $nuevoValorInsumo, $idInsumo);

							}

							$valor1b = $traerProducto["Stock"] - $actual[0]["cantidad"];

						} else {

							$valor1b = $traerProducto["Stock"] - $actual[0]["cantidad"];

						}


					} else {

						$valor1b = $actual[0]["cantidad"] + $traerProducto["Stock"];
					}

					$nuevoStockProducto = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valorp);

				}

				#ACTUALIZAMOS EL NUEVO STOCK AFECTADO

				if ($_POST["etipoProdInsMovimiento"] == "Insumo") {

					//ACTUALIZAMOS STOCK DE INSUMOS

					$tablaInsumos = "Insumos";
					$tabla2 = "Rubro";

					$itemI = "InsumosID";
					$valorI = $_POST["eidProdInsMovimiento"];

					$traerInsumosb = ModeloInsumos::mdlMostrarInsumos($tablaInsumos, $tabla2, $itemI, $valorI);

					$itemIa = "Stock";

					if ($_POST["etipoMovimiento"] == "I") {

						$valorIa = $_POST["ecantidadMovimiento"] + $traerInsumosb["Stock"];

					} else {

						$valorIa = $traerInsumosb["Stock"] - $_POST["ecantidadMovimiento"];

					}

					$nuevoStockInsumob = ModeloInsumos::mdlActualizarInsumo($tablaInsumos, $itemIa, $valorIa, $valorI);

				} else {

					//ACTUALIZAMOS STOCK DE PRODUCTOS

					$tablaProductos = "Producto";
					$tabla2p = "Rubro";

					$itempb = "ProductoID";
					$valorpb = $_POST["eidProdInsMovimiento"];
					$orden = "ProductoID";

					$traerProductob = ModeloProductos::mdlMostrarProductos($tablaProductos, $tabla2p, $itempb, $valorpb, $orden);

					$itempc = "Stock";

					if ($_POST["etipoMovimiento"] == "I") {

						$tablaReceta = "Receta";
						$tablaRecetaDetalle = "RecetaDetalle";

						$traigoReceta = ModeloProductos::mdlMostrarRecetaProducto($tablaReceta, $tablaProductos, $tablaRecetaDetalle, $valorpb);

						if ($traigoReceta !="") {

							//RESTAMOS LOS INSUMOS DE LA RECETA

							foreach ($traigoReceta as $key => $value) {

								$tablaInsumos = "Insumos";
								$tabla2 = "Rubro";

								$item = "InsumosID";
								$idInsumo = $value["InsumosID"];

								$item1a = "Stock";

								//TRAIGO EL INSUMO
								$traerInsumos = ModeloInsumos::mdlMostrarInsumos($tablaInsumos, $tabla2, $item, $idInsumo);
								//CALCULAMOS EL NUEVO STOCK
								$nuevoValorInsumo = $traerInsumos["Stock"] - ($_POST["ecantidadMovimiento"] * $value["Cantidad"]);
								//ACTUALIZAMOS EL STOCK
								$nuevoStockInsumo = ModeloInsumos::mdlActualizarInsumo($tablaInsumos, $item1a, $nuevoValorInsumo, $idInsumo);

							}

							$valorpc = $_POST["ecantidadMovimiento"] + $traerProductob["Stock"];

						} else {

							$valorpc = $_POST["ecantidadMovimiento"] + $traerProductob["Stock"];

						}


					} else {

						echo $traerProductob["Stock"];

						$valorpc = $traerProductob["Stock"] - $_POST["ecantidadMovimiento"];

					}

					$nuevoStockProductob = ModeloProductos::mdlActualizarProducto($tablaProductos, $itempc, $valorpc, $valorpb);

				}


				#ENVIAMOS LOS DATOS EN UN ARRAY AL MODELO

				$tabla = "Almacen";

				if ($_POST["etipoProdInsMovimiento"] =="Producto") {

					$idProducto = $_POST["eidProdInsMovimiento"];
					$idInsumo = NULL;

				} else {

					$idInsumo = $_POST["eidProdInsMovimiento"];
					$idProducto = NULL;

				}

				$datosController = array("idMovimiento"=>$_POST["idMovimiento"],
										 "idInsumo"=>$idInsumo,
										 "idProducto"=>$idProducto,
										 "nombre"=>$_POST["enombreProdInsMovimiento"],
										 "fecha"=>$_POST["efechaMovimiento"],
										 "tipoMovimiento"=>$_POST["etipoMovimiento"],
										 "cantidad"=>$_POST["ecantidadMovimiento"],
										 "descripcion"=>$_POST["edescripcionMovimiento"],
										 "idUsuario"=>$_POST["eidUsuarioMovimiento"]);


				$respuesta = ModeloAlmacen::mdlEditarMovimiento($tabla, $datosController);

				if($respuesta == "ok"){

					echo'<script>
							swal({
								title:"¡Modificación Exitosa!",
								text:"¡Los datos del movimiento se modificaron correctamente!",
								type:"success",
								confirmButtonText: "Cerrar",
								closeOnConfirm: false
							},
								function(isConfirm){
									if(isConfirm){
										window.location="almacen";
								}
							});
						</script>';

				}else{

					echo'<script>
							swal({
								title:"¡Registro Fallido!",
								text:"¡Ocurrio un error, revise los datos!'.print_r($respuesta).'",
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
									window.location="almacen";
							}
						});
					 </script>';

			}
		}

	}

/*==========================================
		ELIMINAR MOVIMIENTOS
==========================================*/

	public function ctrEliminarMovimiento($idMov, $datos){

		$tabla = "Almacen";

		$actual = $datos;

		#FORMATEAMOS EL STOCK AFECTADO

		if ($actual["tipo"] == "Insumo") {

			//RESTAURAMOS STOCK DE INSUMOS

			$tablaInsumos = "Insumos";
			$tabla2 = "Rubro";

			$item = "InsumosID";
			$valor = $actual["id"];

			$traerInsumos = ModeloInsumos::mdlMostrarInsumos($tablaInsumos, $tabla2, $item, $valor);

			$item1a = "Stock";

			if ($actual["tipoMov"] == "I") {

				$valor1a = $traerInsumos["Stock"] - $actual["cantidad"];

			} else {

				$valor1a = $actual["cantidad"] + $traerInsumos["Stock"];

			}

			$nuevoStockInsumo = ModeloInsumos::mdlActualizarInsumo($tablaInsumos, $item1a, $valor1a, $valor);

		} else {

			//RESTAURAMOS STOCK DE PRODUCTOS

			$tablaProductos = "Producto";
			$tabla2p = "Rubro";

			$itemp = "ProductoID";
			$valorp = $actual["id"];
			$orden = "ProductoID";

			$traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $tabla2p, $itemp, $valorp, $orden);

			$item1b = "Stock";

			if ($actual["tipoMov"] == "I") {

				$tablaReceta = "Receta";
				$tablaRecetaDetalle = "RecetaDetalle";

				$traigoReceta = ModeloProductos::mdlMostrarRecetaProducto($tablaReceta, $tablaProductos, $tablaRecetaDetalle, $valorp);

				if ($traigoReceta !="") {

					//RESTAMOS LOS INSUMOS DE LA RECETA

					foreach ($traigoReceta as $key => $value) {

						$tablaInsumos = "Insumos";
						$tabla2 = "Rubro";

						$item = "InsumosID";
						$idInsumo = $value["InsumosID"];

						$item1a = "Stock";

						//TRAIGO EL INSUMO
						$traerInsumos = ModeloInsumos::mdlMostrarInsumos($tablaInsumos, $tabla2, $item, $idInsumo);
						//CALCULAMOS EL NUEVO STOCK
						$nuevoValorInsumo = $traerInsumos["Stock"] - ($actual["cantidad"] * $value["Cantidad"]);
						//ACTUALIZAMOS EL STOCK
						$nuevoStockInsumo = ModeloInsumos::mdlActualizarInsumo($tablaInsumos, $item1a, $nuevoValorInsumo, $idInsumo);

					}

					$valor1b = $actual["cantidad"] + $traerProducto["Stock"];

				} else {

					$valor1b = $actual["cantidad"] + $traerProducto["Stock"];

				}

				$valor1b = $traerProducto["Stock"] - $actual["cantidad"];

			} else {

				$valor1b = $actual["cantidad"] + $traerProducto["Stock"];
			}

			$nuevoStockProducto = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valorp);

		}

		$respuesta = ModeloAlmacen::mdlEliminarMovimientos($tabla, $idMov);

        return $respuesta;


	}

/*=============================================
		RANGO DE FECHAS
=============================================*/

	static public function ctrRangoFechaAlmacen($fechaInicial, $fechaFinal){

		$tabla1 = "Almacen";
		$tabla2 = "Usuario";
		$tabla3 = "Persona";

		$respuesta = ModeloAlmacen::mdlRangoFechaAlmacen($tabla1, $tabla2, $tabla3, $fechaInicial, $fechaFinal);

		return $respuesta;

	}

/*=============================================
        	DESCARGAR REPORTE
=============================================*/

    static public function ctrDescararReporteAlmacen(){

        if (isset($_GET["reporte"])) {

        	$tabla1 = "Almacen";
			$tabla2 = "Usuario";
			$tabla3 = "Persona";

        	if (isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])) {

        		$almacen = ModeloAlmacen::mdlRangoFechaAlmacen($tabla1, $tabla2, $tabla3, $_GET["fechaInicial"], $_GET["fechaFinal"]);

        	} else {

        		$item = null;
        		$valor = null;

        		$almacen = ModeloAlmacen::mdlMostrarMovimientos($tabla1, $tabla2, $tabla3, $item, $valor);

        	}

        	//CREAMOS EL ARCHIVO DE EXCEL

        	$name = 'reporte-almacen.xls';
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
						<td colspan=6 align='center' bgcolor='#9DD1A7'>Reporte de movimientos de almacen</td>
					</tr>
					<tr>
						<th align='center' bgcolor='#88C1E3'>FECHA</th>
						<th align='center' bgcolor='#88C1E3'>TIPO</th>
						<th align='center' bgcolor='#88C1E3'>NOMBRE</th>
						<th align='center' bgcolor='#88C1E3'>DESCRIPCION</th>
						<th align='center' bgcolor='#88C1E3'>CANTIDAD</th>
						<th align='center' bgcolor='#88C1E3'>RESPONSABLE</th>
					</tr>");

			foreach ($almacen as $row => $item){

			if ($item["Tipo"] =="I") {

				$tipo = "Ingreso";

			} else {

				$tipo = "Egreso";
			}

			echo utf8_decode("<tr>
										 			<td bgcolor='#FAEDB1'>".$item["Fecha"]."</td>
										 			<td bgcolor='#FAEDB1'>".$tipo."</td>
										 			<td bgcolor='#FAEDB1'>".$item["Nombre"]."</td>
										 			<td bgcolor='#FAEDB1'>".$item["Descripcion"]."</td>
										 			<td bgcolor='#FAEDB1'>".$item["Cantidad"]."</td>
										 			<td bgcolor='#FAEDB1'>".$item["NombrePersona"]." ".$item["ApellidoPersona"]."</td>
										 	</tr>");

			}

			echo "</table>";

        }

    }


}
