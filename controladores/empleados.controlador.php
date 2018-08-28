<?php

class ControladorEmpleados{

/*==========================================
			MOSTRAR EMPLEADOS
==========================================*/

	static public function ctrMostrarEmpleados($item, $valor){

		$tabla1 = "Persona";
		$tabla2 = "Empleado";
		$tabla3 = "Puesto";
		$tabla4 = "Categorias";
		$tabla5 = "Domicilio";
		$tabla6 = "Localidad";
		$tabla7 = "Barrio";
		$tabla8 = "Email";
		$tabla9 = "Telefono";
		$tabla10 = "Usuario";

		$respuesta = ModeloEmpleados::mdlMostrarEmpleados($tabla1, $tabla2, $tabla3, $tabla4, $tabla5, $tabla6, $tabla7, $tabla8 , $tabla9 , $tabla10, $item, $valor);

		return $respuesta;

	}

	/*==========================================
				MOSTRAR EMPLEADOS ACTIVOS
	==========================================*/

		static public function ctrMostrarEmpleadosActivos($item, $valor){

			$tabla1 = "Persona";
			$tabla2 = "Empleado";
			$tabla3 = "Puesto";
			$tabla4 = "Categorias";
			$tabla5 = "Domicilio";
			$tabla6 = "Localidad";
			$tabla7 = "Barrio";
			$tabla8 = "Email";
			$tabla9 = "Telefono";
			$tabla10 = "Usuario";

			$respuesta = ModeloEmpleados::mdlMostrarEmpleadosActivos($tabla1, $tabla2, $tabla3, $tabla4, $tabla5, $tabla6, $tabla7, $tabla8 , $tabla9 , $tabla10, $item, $valor);

			return $respuesta;

		}

/*==========================================
			REGISTRAR EMPLEADO
==========================================*/

	static public function ctrRegistrarEmpleado($datos){

		if(isset($datos["nombre"])){

			#REALIZAMOS LA VALIDACION DEL LADO DEL SERVIDOR

			if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/', $datos["nombre"])&&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/', $datos["apellido"])&&
				preg_match('/^[0-9]+$/', $datos["dni"])&&
				preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $datos["email"])&&
				preg_match('/^[a-zA-Z]+$/', $datos["sexo"]) &&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/', $datos["calle"])&&
				preg_match('/^[0-9]+$/', $datos["numeroCalle"])&&
				preg_match('/^[0-9]*$/', $datos["piso"]) &&
				preg_match('/^[a-zA-Z0-9_]*$/', $datos["depto"]) &&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/', $datos["localidad"]) &&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/', $datos["barrio"]) &&
				preg_match('/^[0-9]*$/', $datos["codPostal"])&&
				preg_match('/^[0-9]+$/', $datos["codArea"]) &&
				preg_match('/^[0-9]+$/', $datos["telefono"])&&
				preg_match('/^[0-9]+$/', $datos["puesto"]) &&
				preg_match('/^[0-9]+$/', $datos["categoria"]) &&
				preg_match('/^[0-9-]+$/', $datos["cuil"])){


				#ENVIAMOS LOS DATOS EN UN ARRAY AL MODELO


				$respuesta = ModeloEmpleados::mdlRegistroEmpleado($datos, 'Persona', 'Empleado', 'Email', 'Telefono', 'Localidad', 'Barrio', 'Domicilio');

					if($respuesta == "ok"){

							return 'ok';

						}else{

							return $respuesta;

					}

			}else{

				return 'error validar';

			}
		}

	}

/*==========================================
            MODIFICAR EMPLEADO
==========================================*/

	static public function ctrModificarEmpleado($datos){

		if(isset($datos["nombre"])){

			#REALIZAMOS LA VALIDACION DEL LADO DEL SERVIDOR

			if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/', $datos["nombre"])&&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/', $datos["apellido"])&&
				preg_match('/^[0-9]+$/', $datos["dni"])&&
				preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $datos["email"])&&
				preg_match('/^[a-zA-Z]+$/', $datos["sexo"]) &&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/', $datos["calle"])&&
				preg_match('/^[0-9]+$/', $datos["numeroCalle"])&&
				preg_match('/^[0-9]*$/', $datos["piso"]) &&
				preg_match('/^[a-zA-Z0-9_]*$/', $datos["depto"]) &&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/', $datos["localidad"]) &&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/', $datos["barrio"]) &&
				preg_match('/^[0-9]*$/', $datos["codPostal"]) &&
				preg_match('/^[0-9]+$/', $datos["codArea"]) &&
				preg_match('/^[0-9]+$/', $datos["telefono"])&&
				preg_match('/^[0-9]+$/', $datos["puesto"]) &&
				preg_match('/^[0-9]+$/', $datos["categoria"]) &&
				preg_match('/^[0-9-]+$/', $datos["cuil"])){

				#ENVIAMOS LOS DATOS EN UN ARRAY AL MODELO

				$respuesta = ModeloEmpleados::mdlModificarEmpleado($datos, 'Persona', 'Empleado', 'Email', 'Telefono', 'Localidad', 'Barrio', 'Domicilio');

					if($respuesta == "ok"){

							return 'ok';

						}else{

							return 'error';

					}

			}else{

				return 'error';

			}
		}

	}

/*==========================================
            ELIMINAR EMPLEADO
==========================================*/

	static public function ctrEliminarEmpleado($empleado, $persona, $usuario, $foto, $nombre, $imagenEm){

		$imagen = $foto;
		$nombUser = $nombre;
		$borrarImgEmp = $imagenEm;

		$datosController = array("EmpleadoID"=>$empleado,
								 "PersonaID"=>$persona,
								 "UsuarioID"=>$usuario,
								 "nombreUsuario"=>$nombUser,
								 "fotoUsuario"=>$imagen,
								 "fotoEmpleado"=>$borrarImgEmp);

		$respuesta = ModeloEmpleados::mdlEliminarEmpleado($datosController, 'Empleado', 'Usuario', 'Email', 'Telefono', 'Domicilio', 'Persona', 'GrupoFamiliar');

		if($respuesta=="ok"){

			echo 0;

		}else{

			echo $respuesta;

		}

	}

/*=========================================
            TRAER PUESTOS
=========================================*/

	static public function ctrTraerPuestos(){

		$respuesta = ModeloEmpleados::mdlTraerPuestos("Puesto");

		foreach ($respuesta as $row => $item){

			echo '<option value="'.$item["PuestoID"].'">'.$item["Nombre"].'</option>';
		}

	}

/*=========================================
            TRAER CATEGORIAS
=========================================*/

	static public function ctrTraerCategorias(){

		$respuesta = ModeloEmpleados::mdlTraerCategorias("Categorias");

		foreach ($respuesta as $row => $item){

			echo '<option value="'.$item["CategoriasID"].'">'.$item["Nombre"].'</option>';
		}

	}

/*=========================================
			VALIDAR NO REPETIR CUIL
=========================================*/

	static public function ctrValidarCuil($validarCuil){

		$datosController = $validarCuil;

		$respuesta = ModeloEmpleados::mdlValidarCuil($datosController, "Empleado");

		if(count($respuesta["CUIL"]) > 0){
			#EL CUIL EXISTE POR LO TANTO NO ESTA DISPONIBLE
			echo "false";

		}else{
			#EL CUIL NO EXISTE Y POR LO TANTO ESTARA DISPONIBLE

			echo "true";
		}

	}

/*=========================================
            CREAR USUARIO
=========================================*/

	static public function ctrCrearUsuario(){

		if(isset($_POST["userUsuario"])){

			#REALIZAMOS LA VALIDACION DEL LADO DEL SERVIDOR

			if (preg_match('/^[a-zA-Z0-9_]+$/', $_POST["userUsuario"]) &&
				preg_match('/^[a-zA-Z0-9]+$/', $_POST["passUsuario"]) &&
				preg_match('/^[0-9]+$/', $_POST["rolUsuario"])){

				#VALIDAMOS LA IMAGEN

				$ruta ="";

				if(isset($_FILES["nuevaFoto"]["tmp_name"])){

					list($ancho, $alto) = getimagesize($_FILES["nuevaFoto"]["tmp_name"]);

					#REDIMENSIONAMOS LA IMAGEN
					$nuevoAncho = 500;
					$nuevoAlto = 500;

					#CREAMOS EL DIRECTORIO DONDE SE GUARDARA LA IMAGEN
					$directorio = "vistas/img/usuarios/".$_POST["userUsuario"];

					mkdir($directorio, 0755);

					#DEPENDIENDO DEL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					if ($_FILES["nuevaFoto"]["type"] == "image/jpeg") {

						#GUARDAMOS LA IMAGEN EN EL DIRECTORIO

						$aleatorio = mt_rand(100,999);
						$ruta = "vistas/img/usuarios/".$_POST["userUsuario"]."/".$aleatorio.".jpg";

						$origen = imagecreatefromjpeg($_FILES["nuevaFoto"]["tmp_name"]);
						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagejpeg($destino, $ruta);
					}

					if ($_FILES["nuevaFoto"]["type"] == "image/png") {

						#GUARDAMOS LA IMAGEN EN EL DIRECTORIO

						$aleatorio = mt_rand(100,999);
						$ruta = "vistas/img/usuarios/".$_POST["userUsuario"]."/".$aleatorio.".png";

						$origen = imagecreatefrompng($_FILES["nuevaFoto"]["tmp_name"]);
						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagepng($destino, $ruta);
					}


				}

				#ENCRIPTAMOS EL PASS

				$encriptar = crypt($_POST["passUsuario"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

				#ENVIAMOS LOS DATOS EN UN ARRAY AL MODELO

				$datosController = array("user"=>$_POST["userUsuario"],
										 "pass"=>$encriptar,
										 "idEmpleado"=>$_POST["iEmpleado"],
										 "idPersona"=>$_POST["iPersona"],
										 "ruta"=>$ruta,
										 "rol"=>$_POST["rolUsuario"]);
				var_dump($datosController);

				$respuesta = ModeloEmpleados::mdlCrearUsuario($datosController, "Usuario");

				if($respuesta == "ok"){

					echo'<script>
						swal({
						title:"¡Registro Exitoso!",
						text:"¡El usuario ha sido creado correctamente!",
						type:"success",
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						},
						function(isConfirm){
						if(isConfirm){
						window.location="usuarios";
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
						window.location="empleados";
						}
						});
						</script>';


			}
		}

	}

/*==========================================
			FOTO EMPLEADO
==========================================*/

	static public function ctrFotoEmpleado(){

		if(isset($_FILES["nuevaFotoEmpleado"]["tmp_name"])){



			/*=============================================
								VALIDAR IMAGEN
				=============================================*/

				$ruta = $_POST["fotoActual"];

				if(isset($_FILES["nuevaFotoEmpleado"]["tmp_name"]) && !empty($_FILES["nuevaFotoEmpleado"]["tmp_name"])){

					list($ancho, $alto) = getimagesize($_FILES["nuevaFotoEmpleado"]["tmp_name"]);

					$nuevoAncho = 500;
					$nuevoAlto = 500;

					/*==============================================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					================================================================*/

					$directorio = "vistas/img/empleados/";

					/*===============================================================
					PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
					================================================================*/

					if(!empty($_POST["fotoActual"])){

						unlink($_POST["fotoActual"]);

					}else{

						//mkdir($directorio, 0755);

					}

					/*======================================================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					========================================================================*/

					if($_FILES["nuevaFotoEmpleado"]["type"] == "image/jpeg"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999999);

						$ruta = "vistas/img/empleados/".$aleatorio.".jpg";

						$origen = imagecreatefromjpeg($_FILES["nuevaFotoEmpleado"]["tmp_name"]);

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagejpeg($destino, $ruta);

					}

					if($_FILES["nuevaFotoEmpleado"]["type"] == "image/png"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999999);

						$ruta = "vistas/img/empleados/".$aleatorio.".png";

						$origen = imagecreatefrompng($_FILES["nuevaFotoEmpleado"]["tmp_name"]);

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagepng($destino, $ruta);

					}

				}

				$datosController = array("empleado" =>$_POST["empleadoIdFoto"],
											"imagen"=>$ruta);

				$respuesta = ModeloEmpleados::mdlFotoEmpleado($datosController, "Empleado");

				if($respuesta == "ok"){

					echo'<script>
						swal({
						title:"¡Registro Exitoso!",
						text:"¡La imagen se subio correctamente!",
						type:"success",
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						},
						function(isConfirm){
						if(isConfirm){
						window.location="empleados";
						}
						});
						</script>';

				}else{

					echo'<script>
						swal({
						title:"¡Registro Fallido!",
						text:"¡Ocurrio un error, revise los datos!'.$ruta.'",
						type:"error",
						confirmButtonText:"Cerrar",
						closeOnConfirm: false
						});
						</script>';

				}

		}

	}


/*==========================================
        MOSTRAR CATEGORIAS PUESTOS
==========================================*/

    static public function ctrMostrarCategoriasPuestos($valor, $valorSel){

        $tabla1 = "Categorias";
        $tabla2 = "Puesto";

        $respuesta = ModeloEmpleados::mdlMostrarCategoriasPuestos($tabla1, $tabla2, $valor);

        if ($valorSel != null) {

        	foreach ($respuesta as $row => $item){

				if ($item["CategoriasID"] == $valorSel) {

					echo '<option value="'.$item["CategoriasID"].'" selected>'.$item["NombreCategoria"].'</option>';

				} else {

					echo '<option value="'.$item["CategoriasID"].'">'.$item["NombreCategoria"].'</option>';
				}

			}


        } else {

        	foreach ($respuesta as $row => $item){

				echo '<option value="'.$item["CategoriasID"].'">'.$item["NombreCategoria"].'</option>';

			}

        }

    }

/*=============================================
        	DESCARGAR REPORTE
=============================================*/

	static public function ctrDescararReporte(){

			if (isset($_GET["reporte"])) {

		    	$tabla1 = "Persona";
					$tabla2 = "Empleado";
					$tabla3 = "Puesto";
					$tabla4 = "Categorias";
					$tabla5 = "Domicilio";
					$tabla6 = "Localidad";
					$tabla7 = "Barrio";
					$tabla8 = "Email";
					$tabla9 = "Telefono";
					$tabla10 = "Usuario";

					$item = null;
		      $valor = null;
					$empleados = ModeloEmpleados::mdlMostrarEmpleados($tabla1, $tabla2, $tabla3, $tabla4, $tabla5, $tabla6, $tabla7, $tabla8 , $tabla9 , $tabla10, $item, $valor);

		      //CREAMOS EL ARCHIVO DE EXCEL

		      $name = 'reporte-empleados.xls';
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
								<td colspan=11 align='center' bgcolor='#9DD1A7'>Reporte de empleados</td>
							</tr>
							<tr>
								<th align='center' bgcolor='#88C1E3'>NOMBRE</th>
								<th align='center' bgcolor='#88C1E3'>DNI</th>
								<th align='center' bgcolor='#88C1E3'>FECHA DE NACIMIENTO</th>
								<th align='center' bgcolor='#88C1E3'>EMAIL</th>
								<th align='center' bgcolor='#88C1E3'>TELEFONO</th>
								<th align='center' bgcolor='#88C1E3'>DOMICILIO</th>
								<th align='center' bgcolor='#88C1E3'>LEGAJO</th>
								<th align='center' bgcolor='#88C1E3'>FECHA DE INGRESO</th>
								<th align='center' bgcolor='#88C1E3'>PUESTO</th>
								<th align='center' bgcolor='#88C1E3'>CUIL</th>
								<th align='center' bgcolor='#88C1E3'>SUELDO</th>
							</tr>");

					foreach ($empleados as $row => $item){

						$empleado = ControladorEmpleados::ctrMostrarEmpleados("EmpleadoID", $item["EmpleadoID"]);

					 	echo utf8_decode("<tr>
								 			<td bgcolor='#FAEDB1'>".$item["Nombre"]." ".$item["Apellido"]."</td>
											<td bgcolor='#FAEDB1'>".$item["DNI"]."</td>
											<td bgcolor='#FAEDB1'>".$item["Nacimiento"]."</td>
											<td bgcolor='#FAEDB1'>".$item["Email"]."</td>
											<td bgcolor='#FAEDB1'>(".$item["Prefijo"].") - ".$item["NroTelefono"]."</td>
											<td bgcolor='#FAEDB1'>".$item["Calle"]." ".$item["Nro"]." ".$item["Piso"]." ".$item["Dpto"]."</td>
											<td bgcolor='#FAEDB1'>000".$item["Legajo"]."</td>
											<td bgcolor='#FAEDB1'>".$item["Ingreso"]."</td>
											<td bgcolor='#FAEDB1'>".$item["Puesto"]."</td>
											<td bgcolor='#FAEDB1'>".$item["CUIL"]."</td>
											<td bgcolor='#FAEDB1'>".$item["SueldoBasico"]."</td>
								 		</tr>");
					}

					echo "</table>";

		        }

		    }



}
