<?php

class ControladorIngreso{

/*===============================
=            INGRESO            =
===============================*/

static public function ctrIngreso(){

	if (isset($_POST["ingUsuario"])) {


		#SE VERIFICA QUE NO SE INGRESARON CARACTERES NO PERMITIDOS Y SE REALIZA EL LOGUEO
		if (preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"]) &&	preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingPassword"])){

			$encriptar = crypt($_POST["ingPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
			$datosController = array("usuario" => $_POST["ingUsuario"], "password" => $encriptar);
						

			$respuesta = ModeloIngreso::mdlIngreso($datosController, "Usuario", "Persona", "Roles");

					
			$intentos = $respuesta["Intentos"];
			$usuarioActual = $_POST["ingUsuario"];
			$maximoIntentos = 2;

			if($intentos < $maximoIntentos){

				if($respuesta["NombreUsuario"] == $_POST["ingUsuario"] && $respuesta["Clave"] == $encriptar){

					if($respuesta["Activo"] == "S") {

						$intentos=0;
						$datosController = array("usuarioActual"=>$usuarioActual, "actualizarIntentos"=>$intentos);
					
						$respuestaActualizarIntentos = ModeloIngreso::mdlIntentos($datosController, "Usuario");

						#INICIO DE SESION

						$_SESSION["iniciarSesion"] = "ok";
						$_SESSION["usuario"] = $usuarioActual;
						$_SESSION["idUser"] = $respuesta["UsuarioID"];
						$_SESSION["Nombre"] = $respuesta["Nombre"];
						$_SESSION["Apellido"] = $respuesta["Apellido"];
						$_SESSION["rol"] = $respuesta["Rol"];
						$_SESSION["idRol"] = $respuesta["IdRol"];
						$_SESSION["foto"] = $respuesta["Imagen"];

						echo '<script> window.location = "inicio"; </script>';

					} else {

						#CUENTA DESACTIVADA - EL USUARIO NO ESTA ACTIVO
						echo '<div class="col-sm-12 text-center">
				                  <div class="alert alert-danger background-danger">
				                    <strong>Usuario bloqueado! </strong> Comuniquese con el administrador
				                  </div>
				                </div>';
					}
				} else {

					#INTENTO DE INGRESO FALLIDO
					$intentos++;
					$datosController = array("usuarioActual"=>$usuarioActual, "actualizarIntentos"=>$intentos);
					
					$respuestaActualizarIntentos = ModeloIngreso::mdlIntentos($datosController, "Usuario");
					echo '<div class="col-sm-12 text-center">
			                  <div class="alert alert-danger background-danger">
			                    <strong>Error! </strong> Por favor verifique sus datos
			                  </div>
			              </div>';
				}
			} else {

				#SUPERO LOS INTENTOS DE INGRESO - SE BLOQUEA LA CUENTA
				$intentos = 0;
				$datosController = array("usuarioActual"=>$usuarioActual, "actualizarIntentos"=>$intentos);
				$respuestaActualizarIntentos = ModeloIngreso::mdlBloqueoCuenta($datosController, "Usuario");
				echo '<div class="col-sm-12 text-center">
		                  <div class="alert alert-danger background-danger">
		                    Superó la cantidad de intentos. Usuario bloqueado
		                  </div>
		                </div>';

			}

		}

	}

}

}