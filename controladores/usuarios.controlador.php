<?php

class ControladorUsuarios{

/*=============================================
			MOSTRAR USUARIOS   		  
=============================================*/

	static public function ctrMostrarUsuarios($item, $valor){

		$tabla1 = "Persona";
		$tabla2 = "Usuario";
		$tabla3 = "Roles";
		$tabla4 = "Email";

		$respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla1, $tabla2, $tabla3, $tabla4, $item, $valor);

		return $respuesta;

	}

/*=============================================
			REGISTRAR USUARIO 		      
=============================================*/

	static public function ctrRegistroUsuario(){

		if(isset($_POST["nombreUsuario"])){

			#REALIZAMOS LA VALIDACION DEL LADO DEL SERVIDOR
			if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/', $_POST["nombreUsuario"])&&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/', $_POST["apellidoUsuario"])&&
				preg_match('/^[0-9]+$/', $_POST["dniUsuario"])&&
				preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $_POST["emailUsuario"])&&
				preg_match('/^[a-zA-Z]+$/', $_POST["sexoUsuario"]) &&
				preg_match('/^[a-zA-Z0-9_]+$/', $_POST["userUsuario"]) &&
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

				#CREAMOS ARRAY CON LOS DATOS DE LA PERSONA
				$datosPersona = array("nombre"=>ucwords($_POST["nombreUsuario"]),
									  "apellido"=>ucwords($_POST["apellidoUsuario"]),
									  "dni"=>$_POST["dniUsuario"],
									  "fechaNacimiento"=>$_POST["fechaUsuario"],
									  "sexo"=>$_POST["sexoUsuario"]);
				
				#INSERTAMOS LA PERSONA
				$tablaPersona = "Persona";
				$respuestaPersona = ModeloPersonas::mdlRegistroPersona($tablaPersona, $datosPersona);

				$idPersona = $respuestaPersona;

				#CREAMOS ARRAY CON LOS DATOS DEL USUARIO
				$datosUsuario = array("persona"=>$idPersona,
									  "fechaAlta"=>$_POST["fechaUsuario"],
									   "user"=>$_POST["userUsuario"],
									   "pass"=>$encriptar,
									   "ruta"=>$ruta,
									   "rol"=>$_POST["rolUsuario"]);
				
				#INSERTAMOS EL EMAIL
				$tablaEmail = "Email";
				$email = $_POST["emailUsuario"];
				$valorEmail = "Personal";
				$respuestaEmail = ModeloPersonas::mdlRegistroEmail($tablaEmail, $idPersona, $email, $valorEmail);

				#INSERTAMOS EL USUARIO
				$tablaUsuarios = "Usuario";
				$respuestaUsuario = ModeloUsuarios::mdlRegistroUsuario($tablaUsuarios, $datosUsuario);
				

				if($respuestaUsuario == "ok"){

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
							text:"¡Ocurrio un error, revise los datos!'.$respuestaUsuario.'",
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
							window.location="usuarios";
							}
						});
						</script>';
			

			}
		}
	
	}

/*=============================================
            EDITAR USUARIO		      	  
=============================================*/

	static public function ctrEditarUsuario(){

		if(isset($_POST["enombreUsuario"])){

			if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/', $_POST["enombreUsuario"])&&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/', $_POST["eapellidoUsuario"])&&
				preg_match('/^[0-9]+$/', $_POST["edniUsuario"])&&
				preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $_POST["eemailUsuario"])&&
				preg_match('/^[a-zA-Z]+$/', $_POST["esexoUsuario"]) &&
				preg_match('/^[0-9]+$/', $_POST["erolUsuario"])){

				/*=============================================
				VALIDAR IMAGEN
				=============================================*/

				$ruta = $_POST["fotoActual"];

				if(isset($_FILES["editarFoto"]["tmp_name"]) && !empty($_FILES["editarFoto"]["tmp_name"])){

					list($ancho, $alto) = getimagesize($_FILES["editarFoto"]["tmp_name"]);

					$nuevoAncho = 500;
					$nuevoAlto = 500;

					/*==============================================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					================================================================*/

					$directorio = "vistas/img/usuarios/".$_POST["euserUsuario"];

					/*=================================================
					PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
					==================================================*/

					if(!empty($_POST["fotoActual"])){

						unlink($_POST["fotoActual"]);

					}else{

						mkdir($directorio, 0755);

					}	

					/*======================================================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					========================================================================*/

					if($_FILES["editarFoto"]["type"] == "image/jpeg"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/usuarios/".$_POST["euserUsuario"]."/".$aleatorio.".jpg";

						if ($_SESSION["idUser"] == $_POST["idUser"]) {
							
							unset($_SESSION["foto"]);

							$_SESSION["foto"] = $ruta;

						}

						

						$origen = imagecreatefromjpeg($_FILES["editarFoto"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagejpeg($destino, $ruta);

					}

					if($_FILES["editarFoto"]["type"] == "image/png"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/usuarios/".$_POST["euserUsuario"]."/".$aleatorio.".png";

						if ($_SESSION["idUser"] == $_POST["idUser"]) {
							
							unset($_SESSION["foto"]);

							$_SESSION["foto"] = $ruta;

						}

						$origen = imagecreatefrompng($_FILES["editarFoto"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagepng($destino, $ruta);

					}

				}

				if($_POST["epassUsuario"] != ""){

					if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["epassUsuario"])){

						$encriptar = crypt($_POST["epassUsuario"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

					}else{

						echo'<script>
							swal({
							title:"¡Registro Fallido!",
							text:"¡La contraseña no puede ir vacia o llevar caracteres especiales!",
							type:"error",
							confirmButtonText:"Cerrar",
							closeOnConfirm: false
						});
						</script>';

					}

				}else{

					$encriptar = $_POST["passwordActual"];

				}

				#MODIFICAMOS LOS DATOS DE LA PERSONA
				$datosPersona = array("idPersona"=>$_POST["idPersona"],
									  "nombre"=>ucwords($_POST["enombreUsuario"]),
									  "apellido"=>ucwords($_POST["eapellidoUsuario"]),
									  "dni"=>$_POST["edniUsuario"],
									  "fecha"=>$_POST["efechaUsuario"],
									  "sexo"=>$_POST["esexoUsuario"]);

				$tablaPersona = "Persona";
				$respuestaPersona = ModeloPersonas::mdlModificoPersona($tablaPersona,$datosPersona);

				#MODIFICAMOS EL EMAIL
				$tablaEmail = "Email";
				$email = $_POST["eemailUsuario"];
				$valorEmail = "Personal";
				$idPersona = $_POST["idPersona"];
				$respuestaEmail = ModeloPersonas::mdlModificoEmail($tablaEmail, $idPersona, $email, $valorEmail);

				#MODIFICAMOS EL USUARIO
				$datosUsuario = array("idUsuario"=>$_POST["idUser"],
				                      "user"=>$_POST["euserUsuario"],
									  "pass"=>$encriptar,
									  "foto"=>$ruta,
									  "rol"=>$_POST["erolUsuario"]);
				
				$tablaUsuarios = "Usuario";
				$respuestaUsuario = ModeloUsuarios::mdlEditarUsuario($tablaUsuarios, $datosUsuario);

				if($respuestaUsuario == "ok"){

				   echo'<script>
						swal({
							title:"Modificación Exitosa!",
							text:"¡El usuario se modifico correctamente!",
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
							window.location="usuarios";
							}
						});
						</script>';

			}

		}

	}

/*=============================================
            ELIMINAR USUARIO 				  
=============================================*/

	static public function ctrEliminarUsuario($datos){

		$imagen = $datos["foto"];
		$nombUser = $datos["nombre"];
		
		#PRIMERO VERIFICAMOS QUE EL USUARIO PERTENEZCA A UN EMPLEADO

		if ($datos["empleadoID"] != "") {
			
			#ELIMINAMOS EL USUARIO
			$tablaUsuario = "Usuario";
			$datoUsuario = $datos["usuarioID"];

			$eliminoUsuario = ModeloUsuarios::mdlEliminarUsuario($tablaUsuario, $datoUsuario);

			if($eliminoUsuario == "ok"){

				if ($imagen !="") {
			
					unlink('../'.$imagen);
					rmdir('../vistas/img/usuarios/'.$nombUser);

				}
		
					echo 0;

			} else {

				echo 1;

			}


		} else {

			#ELIMINAMOS EL USUARIO
			$tablaUsuario = "Usuario";
			$datoUsuario = $datos["usuarioID"];

			$eliminoUsuario = ModeloUsuarios::mdlEliminarUsuario($tablaUsuario, $datoUsuario);

			#ELIMINAMOS EL EMAIL
			$tablaEmail = "Email";
			$itemEmail = "PersonaID";
			$valorEmail = $datos["personaID"];

			$eliminoEmail = ModeloPersonas::mdlEliminoDatos($tablaEmail, $itemEmail, $valorEmail);

			#ELIMINAMOS LA PERSONA
			$tablaPersona = "Persona";
			$itemPersona = "PersonaID";
			$valorPersona = $datos["personaID"];

			$eliminoPersona = ModeloPersonas::mdlEliminoDatos($tablaPersona, $itemPersona, $valorPersona);

			if($eliminoPersona == "ok"){

				if ($imagen !="") {
			
					unlink('../'.$imagen);
					rmdir('../vistas/img/usuarios/'.$nombUser);

				}
		
					echo 0;

			} else {

				echo 1;

			}


		}
		
	}

/*=============================================
            VALIDAR USUARIO EXISTENTE   	  
=============================================*/

	static public function ctrValidarUsuario($usuario){

		$datosController = $usuario;
		
		$respuesta = ModeloUsuarios::mdlValidarUsuario($datosController, "Usuario");

		if(count($respuesta["NombreUsuario"]) > 0){
			#EL DNI EXISTE POR LO TANTO NO ESTA DISPONIBLE
			echo "false";
		}else{
			#EL DNI NO EXISTE Y POR LO TANTO ESTARA DISPONIBLE
			echo "true";
		}
	
	}


}