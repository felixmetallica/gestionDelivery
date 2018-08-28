<?php

class ControladorProductos{

/*=============================================
        MOSTRAR PRODUCTOS
=============================================*/

    static public function ctrMostrarProductos($item, $valor, $orden){

        $tabla1 = "Producto";

        $tabla2 = "Rubro";

        $respuesta = ModeloProductos::mdlMostrarProductos($tabla1, $tabla2, $item, $valor, $orden);

        return $respuesta;

    }

/*=============================================
        MOSTRAR PRODUCTOS DISPONIBLES
=============================================*/

    static public function ctrMostrarProductosDisponibles(){

        $tabla1 = "Producto";

        $tabla2 = "Rubro";

        $respuesta = ModeloProductos::mdlMostrarProductosDisponibles($tabla1, $tabla2);

        return $respuesta;

    }

/*=============================================
        LISTAR PRODUCTOS
=============================================*/

    static public function ctrListarProductos($item, $valor, $orden){

        $tabla1 = "Producto";

        $tabla2 = "Rubro";

        $respuesta = ModeloProductos::mdlListarProductos($tabla1, $tabla2, $item, $valor, $orden);

        return $respuesta;

    }

/*=============================================
		LISTADO DE RUBROS
=============================================*/

	static public function 	ctrListarRubros(){

		$respuesta = ModeloProductos::mdlListarRubros("Rubro");

		foreach ($respuesta as $row => $item){

			echo '<option value="'.$item["RubroID"].'">'.$item["Nombre"].'</option>';
		}

	}

/*=============================================
        LISTADO DE PRODUCTOS RECETAS
=============================================*/

    static public function  ctrListarProductosReceta(){

        $tabla1 = "Producto";
        $tabla2 = "Receta";

        $respuesta = ModeloProductos::mdlListarProductosReceta($tabla1, $tabla2);

        foreach ($respuesta as $row => $item){

            echo '<option value="'.$item["ProductoID"].'">'.$item["Nombre"].'</option>';
        }

    }

/*=============================================
        REGISTRAR PRODUCTO
=============================================*/

    static public function ctrRegistrarProducto(){

    		if(isset($_POST["nombreProducto"])){

    			#REALIZAMOS LA VALIDACION DEL LADO DEL SERVIDOR

    			if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s.]+$/', $_POST["nombreProducto"]) &&
    				preg_match('/^[0-9]+$/', $_POST["precioProducto"])){

    				#VALIDAR IMAGEN

                    $ruta = "vistas/img/productos/default/anonymous.png";

                    if(isset($_FILES["nuevaImagen"]["tmp_name"])){

                        list($ancho, $alto) = getimagesize($_FILES["nuevaImagen"]["tmp_name"]);

                        #REDIMENSIONAMOS LA IMAGEN
                        $nuevoAncho = 500;
                        $nuevoAlto = 500;

                        #CREAMOS EL DIRECTORIO DONDE SE GUARDARA LA IMAGEN
                        $directorio = "vistas/img/productos/".$_POST["codigoProducto"];

                        mkdir($directorio, 0755);

                        #DEPENDIENDO DEL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
                        if ($_FILES["nuevaImagen"]["type"] == "image/jpeg") {

                            #GUARDAMOS LA IMAGEN EN EL DIRECTORIO

                            $aleatorio = mt_rand(100,999);
                            $ruta = "vistas/img/productos/".$_POST["codigoProducto"]."/".$aleatorio.".jpg";

                            $origen = imagecreatefromjpeg($_FILES["nuevaImagen"]["tmp_name"]);
                            $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                            imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                            imagejpeg($destino, $ruta);
                        }

                        if ($_FILES["nuevaImagen"]["type"] == "image/png") {

                            #GUARDAMOS LA IMAGEN EN EL DIRECTORIO

                            $aleatorio = mt_rand(100,999);
                            $ruta = "vistas/img/productos/".$_POST["codigoProducto"]."/".$aleatorio.".png";

                            $origen = imagecreatefrompng($_FILES["nuevaImagen"]["tmp_name"]);
                            $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                            imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                            imagepng($destino, $ruta);
                        }


                    }

                    $datosController = array('codigo' =>$_POST["codigoProducto"],
                                             'nombre' =>ucwords($_POST["nombreProducto"]),
                                             'imagen' => $ruta,
                                             'precio' =>$_POST["precioProducto"],
                                             'rubro' =>$_POST["rubroProducto"],
                                             'tipo' =>$_POST["tipoProducto"],
                                             'afectaStock' =>$_POST["afectaStockProducto"],
                                             'precioCompra' =>$_POST["precioProductoCompra"],
                                             'stockMinimo' =>$_POST["stockMinimoCompra"]);

                    $tabla = "Producto";

                    $respuesta = ModeloProductos::mdlRegistrarProducto($tabla, $datosController);

    				if($respuesta == "ok"){

    					echo'<script>
    						swal({
    						title:"¡Registro Exitoso!",
    						text:"¡El producto se agregó correctamente!",
    						type:"success",
    						confirmButtonText: "Cerrar",
    						closeOnConfirm: false
    						},
    						function(isConfirm){
    						if(isConfirm){
    						window.location="productos";
    						}
    						});
    						</script>';

    				} else {

    					echo'<script>
    						swal({
    						title:"¡Registro Fallido!",
    						text:"¡Ocurrio un error, revise los datos!",
    						type:"error",
    						confirmButtonText:"Cerrar",
    						closeOnConfirm: false
    						});
    						</script>';

    				}

    			} else {

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
    						window.location="productos";
    						}
    						});
    						</script>';


    			}
    		}

    	}

/*=============================================
        EDITAR PRODUCTO
=============================================*/

    static public function ctrEditarProducto(){

    		if(isset($_POST["enombreProducto"])){

    			#REALIZAMOS LA VALIDACION DEL LADO DEL SERVIDOR

    			if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s.]+$/', $_POST["enombreProducto"]) &&
    				preg_match('/^[0-9.]+$/', $_POST["eprecioProducto"])){

    				#VALIDAR IMAGEN

                    $ruta = $_POST["imagenActual"];

                    if(isset($_FILES["editarImagen"]["tmp_name"]) && !empty($_FILES["editarImagen"]["tmp_name"])){

                        list($ancho, $alto) = getimagesize($_FILES["editarImagen"]["tmp_name"]);

                        #REDIMENSIONAMOS LA IMAGEN
                        $nuevoAncho = 500;
                        $nuevoAlto = 500;

                        #CREAMOS EL DIRECTORIO DONDE SE GUARDARA LA IMAGEN
                        $directorio = "vistas/img/productos/".$_POST["ecodigoProducto"];

                        #PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BASE DE DATOS
                        if (!empty($_POST["imagenActual"]) && $_POST["imagenActual"] !="vistas/img/productos/default/anonymous.png") {

                            unlink($_POST["imagenActual"]);

                        } else {

                            mkdir($directorio, 0755);

                        }


                        #DEPENDIENDO DEL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
                        if ($_FILES["editarImagen"]["type"] == "image/jpeg") {

                            #GUARDAMOS LA IMAGEN EN EL DIRECTORIO

                            $aleatorio = mt_rand(100,999);
                            $ruta = "vistas/img/productos/".$_POST["ecodigoProducto"]."/".$aleatorio.".jpg";

                            $origen = imagecreatefromjpeg($_FILES["editarImagen"]["tmp_name"]);
                            $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                            imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                            imagejpeg($destino, $ruta);
                        }

                        if ($_FILES["editarImagen"]["type"] == "image/png") {

                            #GUARDAMOS LA IMAGEN EN EL DIRECTORIO

                            $aleatorio = mt_rand(100,999);
                            $ruta = "vistas/img/productos/".$_POST["ecodigoProducto"]."/".$aleatorio.".png";

                            $origen = imagecreatefrompng($_FILES["editarImagen"]["tmp_name"]);
                            $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                            imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                            imagepng($destino, $ruta);
                        }


                    }

                    $datosController = array('idProducto' =>$_POST["idProductoE"],
                                             'nombre' =>ucwords($_POST["enombreProducto"]),
                                             'imagen' =>$ruta,
                                             'precio' =>$_POST["eprecioProducto"],
                                             'rubro' =>$_POST["erubroProducto"],
                                             'tipo' =>$_POST["eTipoProducto"],
                                             'afectaStock' =>$_POST["eafectaStockProducto"],
                                             'precioCompra' =>$_POST["ePrecioProductoCompra"],
                                             'stockMinimo' =>$_POST["eStockMinimoCompra"]);

                    $respuesta = ModeloProductos::mdlEditarProducto($datosController, "Producto");

    				if($respuesta == "ok"){

    					echo'<script>
    						swal({
    						title:"Modifiación Exitosa!",
    						text:"¡El producto se modificó correctamente!",
    						type:"success",
    						confirmButtonText: "Cerrar",
    						closeOnConfirm: false
    						},
    						function(isConfirm){
    						if(isConfirm){
    						window.location="productos";
    						}
    						});
    						</script>';

    				} else {

    					echo'<script>
    						swal({
    						title:"Modificación Fallida!",
    						text:"¡Ocurrio un error, revise los datos!",
    						type:"error",
    						confirmButtonText:"Cerrar",
    						closeOnConfirm: false
    						});
    						</script>';

    				}


    			} else {

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
    						window.location="productos";
    						}
    						});
    						</script>';


    			}
    		}

    	}

/*=============================================
        ELIMINAR PRODUCTO
=============================================*/

	static public function ctrEliminarProducto($datos){

		$tabla = "Producto";

        $imagen = $datos["imagen"];

        $codigo = $datos["codigo"];

        if($imagen != "" && $imagen != "vistas/img/productos/default/anonymous.png"){

                unlink('../'.$imagen);
                rmdir('../vistas/img/productos/'.$codigo);

            }


		$respuesta = ModeloProductos::mdlEliminarProducto($tabla, $datos);

		if($respuesta=="ok"){

			echo 0;

		}else{

			echo 1;

		}

	}

/*=============================================
        MOSTRAR SUMA VENTAS
=============================================*/

    static public function ctrMostrarSumaVentas(){

        $tabla = "Producto";

        $respuesta = ModeloProductos::mdlMostrarSumaVentas($tabla);

        return $respuesta;

    }

/*=============================================
        MOSTRAR RECETA PRODUCTO
=============================================*/

    static public function ctrMostrarRecetaProducto($valor){

        $tabla1 = "Receta";
        $tabla2 = "Producto";
        $tabla3 = "Insumos";

        $respuesta = ModeloVentas::mdlMostrarRecetaProducto($tabla1, $tabla2, $tabla3, $valor);

        return $respuesta;

    }

/*=============================================
        	DESCARGAR REPORTE
=============================================*/

    static public function ctrDescararReporte(){

        if (isset($_GET["reporte"])) {

          $tabla1 = "Producto";
          $tabla2 = "Rubro";

        	$item = null;
        	$valor = null;
          $orden = "ProductoID";
			    $productos = ModeloProductos::mdlMostrarProductos($tabla1, $tabla2, $item, $valor, $orden);

        	//CREAMOS EL ARCHIVO DE EXCEL

        	$name = 'reporte-productos.xls';
        	header('Expires: 0');
    			header('Cache-control: private');
    			header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
    			header("Cache-Control: cache, must-revalidate");
    			header('Content-Description: File Transfer');
    			header('Last-Modified: '.date('D, d M Y H:i:s'));
    			header("Pragma: public");
    			header('Content-Disposition:; filename="'.$name.'"');
    			header("Content-Transfer-Encoding: binary");

			    echo utf8_decode("<table border='0' width='950'>

					<tr>
						<td colspan=8 align='center' bgcolor='#9DD1A7'>Reporte de productos</td>
					</tr>
					<tr>
						<th align='center' bgcolor='#88C1E3'>CÓDIGO</th>
						<th align='center' bgcolor='#88C1E3'>RUBRO</th>
						<th align='center' bgcolor='#88C1E3'>NOMBRE</th>
						<th align='center' bgcolor='#88C1E3'>PRECIO DE VENTA</th>
						<th align='center' bgcolor='#88C1E3'>PRECIO DE COMPRA</th>
						<th align='center' bgcolor='#88C1E3'>CANTIDAD VENDIDA</th>
						<th align='center' bgcolor='#88C1E3'>ESTADO</th>
						<th align='center' bgcolor='#88C1E3'>STOCK</th>
					</tr>");

			foreach ($productos as $row => $item){

				$producto = ControladorProductos::ctrMostrarProductos("ProductoID", $item["ProductoID"], "ProductoID");


			 	echo utf8_decode("<tr>
						 			<td bgcolor='#FAEDB1'align='center'>".$item["Codigo"]."</td>
									<td bgcolor='#FAEDB1'align='left'>".$item["Rubro"]."</td>
									<td bgcolor='#FAEDB1'align='left'>".$item["Nombre"]."</td>
									<td bgcolor='#FAEDB1'align='right'>$".$item["PrecioVenta"]."</td>
									<td bgcolor='#FAEDB1'align='right'>$".$item["PrecioCompra"]."</td>
									<td bgcolor='#FAEDB1'align='center'>".$item["Ventas"]."</td>
									<td bgcolor='#FAEDB1'align='center'>".$item["Activo"]."</td>
									<td bgcolor='#FAEDB1'align='right'>".$item["Stock"]."</td>
						 		</tr>");
			}

			echo "</table>";

        }

    }


}
