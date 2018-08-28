<?php

require_once "conexion.php";

class ModeloEmpleados{

/*=====================================
			MOSTRAR EMPLEADOS
=====================================*/

	static public function mdlMostrarEmpleados($tabla1, $tabla2, $tabla3, $tabla4, $tabla5, $tabla6, $tabla7, $tabla8 , $tabla9 , $tabla10, $item, $valor){

		if ($item != null) {

			$stmt = Conexion::conectar()->prepare("SELECT Persona.PersonaID, Persona.Nombre, Persona.Apellido, Persona.DNI, date_format(Persona.FechaNacimiento,'%d/%m/%Y') AS Nacimiento, Persona.Sexo, Empleado.EmpleadoID, Empleado.Legajo, date_format(Empleado.FechaIngreso,'%d/%m/%Y') AS Ingreso, TIMESTAMPDIFF(YEAR,Empleado.FechaIngreso,CURDATE()) AS Antiguedad, Empleado.CUIL, Empleado.Activo, Empleado.Imagen, Puesto.Nombre AS Puesto, Puesto.PuestoID, Categorias.Nombre AS Categoria, Categorias.CategoriasID, Categorias.SueldoBasico AS Basico, Domicilio.Calle, Domicilio.Nro, Domicilio.Piso, Domicilio.Dpto, Domicilio.CP, Localidad.Nombre AS Localidad, Localidad.LocalidadID, Barrio.Nombre AS Barrio, Barrio.BarrioID, Email.Email, Telefono.Prefijo, Telefono.NroTelefono FROM (((((((($tabla1 INNER JOIN $tabla2 ON Persona.PersonaID = Empleado.PersonaID) INNER JOIN $tabla3 ON Empleado.PuestoID = Puesto.PuestoID) INNER JOIN $tabla4 ON Empleado.CategoriasID = Categorias.CategoriasID) INNER JOIN $tabla5 ON Persona.PersonaID = Domicilio.PersonaID) INNER JOIN $tabla6 ON Domicilio.LocalidadID = Localidad.LocalidadID) INNER JOIN $tabla7 ON Domicilio.BarrioID = Barrio.BarrioID) INNER JOIN $tabla8 ON Persona.PersonaID = Email.PersonaID) INNER JOIN $tabla9 ON Persona.PersonaID = Telefono.PersonaID) WHERE $item = :$item ORDER BY EmpleadoID ASC");

			$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetch();

		} else {

			$stmt = Conexion::conectar()->prepare("SELECT Persona.PersonaID, TIMESTAMPDIFF(YEAR,Empleado.FechaIngreso,CURDATE()) AS Antiguedad, Persona.Nombre, Persona.Apellido, Persona.DNI, date_format(Persona.FechaNacimiento,'%d/%m/%Y') AS Nacimiento, Persona.Sexo, Empleado.EmpleadoID, Empleado.Legajo, date_format(Empleado.FechaIngreso,'%d/%m/%Y') AS Ingreso, Empleado.FechaIngreso, Puesto.PuestoID, Empleado.CUIL, Empleado.Activo, Empleado.Imagen AS ImagenEmpleado, Puesto.Nombre AS Puesto, Categorias.Nombre AS Categoria, Categorias.SueldoBasico, Domicilio.Calle, Domicilio.Nro, Domicilio.Piso, Domicilio.Dpto, Domicilio.CP, Localidad.Nombre AS Localidad, Barrio.Nombre AS Barrio, Email.Email, Telefono.Prefijo, Telefono.NroTelefono, Categorias.CategoriasID, Usuario.NombreUsuario, Usuario.UsuarioID, Usuario.Imagen FROM ((((((((($tabla1 INNER JOIN $tabla2 ON Persona.PersonaID = Empleado.PersonaID) INNER JOIN $tabla3 ON Empleado.PuestoID = Puesto.PuestoID) INNER JOIN $tabla4 ON Empleado.CategoriasID = Categorias.CategoriasID) INNER JOIN $tabla5 ON Persona.PersonaID = Domicilio.PersonaID) INNER JOIN $tabla6 ON Domicilio.LocalidadID = Localidad.LocalidadID) INNER JOIN $tabla7 ON Domicilio.BarrioID = Barrio.BarrioID) INNER JOIN $tabla8 ON Persona.PersonaID = Email.PersonaID) INNER JOIN $tabla9 ON Persona.PersonaID = Telefono.PersonaID)LEFT JOIN $tabla10 ON Persona.PersonaID = Usuario.PersonaID) ORDER BY EmpleadoID DESC");

			$stmt-> execute();

			return $stmt-> fetchAll();
		}


	}

	/*=====================================
				MOSTRAR EMPLEADOS ACTIVOS
	=====================================*/

		static public function mdlMostrarEmpleadosActivos($tabla1, $tabla2, $tabla3, $tabla4, $tabla5, $tabla6, $tabla7, $tabla8 , $tabla9 , $tabla10, $item, $valor){

			if ($item != null) {

				$stmt = Conexion::conectar()->prepare("SELECT Persona.PersonaID, Persona.Nombre, Persona.Apellido, Persona.DNI, date_format(Persona.FechaNacimiento,'%d/%m/%Y') AS Nacimiento, Persona.Sexo, Empleado.EmpleadoID, Empleado.Legajo, date_format(Empleado.FechaIngreso,'%d/%m/%Y') AS Ingreso, TIMESTAMPDIFF(YEAR,Empleado.FechaIngreso,CURDATE()) AS Antiguedad, Empleado.CUIL, Empleado.Activo, Empleado.Imagen, Puesto.Nombre AS Puesto, Puesto.PuestoID, Categorias.Nombre AS Categoria, Categorias.CategoriasID, Categorias.SueldoBasico AS Basico, Domicilio.Calle, Domicilio.Nro, Domicilio.Piso, Domicilio.Dpto, Domicilio.CP, Localidad.Nombre AS Localidad, Localidad.LocalidadID, Barrio.Nombre AS Barrio, Barrio.BarrioID, Email.Email, Telefono.Prefijo, Telefono.NroTelefono FROM (((((((($tabla1 INNER JOIN $tabla2 ON Persona.PersonaID = Empleado.PersonaID) INNER JOIN $tabla3 ON Empleado.PuestoID = Puesto.PuestoID) INNER JOIN $tabla4 ON Empleado.CategoriasID = Categorias.CategoriasID) INNER JOIN $tabla5 ON Persona.PersonaID = Domicilio.PersonaID) INNER JOIN $tabla6 ON Domicilio.LocalidadID = Localidad.LocalidadID) INNER JOIN $tabla7 ON Domicilio.BarrioID = Barrio.BarrioID) INNER JOIN $tabla8 ON Persona.PersonaID = Email.PersonaID) INNER JOIN $tabla9 ON Persona.PersonaID = Telefono.PersonaID) WHERE $item = :$item ORDER BY EmpleadoID ASC");

				$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

				$stmt->execute();

				return $stmt->fetchAll();

			} else {

				$stmt = Conexion::conectar()->prepare("SELECT Persona.PersonaID, TIMESTAMPDIFF(YEAR,Empleado.FechaIngreso,CURDATE()) AS Antiguedad, Persona.Nombre, Persona.Apellido, Persona.DNI, date_format(Persona.FechaNacimiento,'%d/%m/%Y') AS Nacimiento, Persona.Sexo, Empleado.EmpleadoID, Empleado.Legajo, date_format(Empleado.FechaIngreso,'%d/%m/%Y') AS Ingreso, Empleado.FechaIngreso, Puesto.PuestoID, Empleado.CUIL, Empleado.Activo, Empleado.Imagen AS ImagenEmpleado, Puesto.Nombre AS Puesto, Categorias.Nombre AS Categoria, Categorias.SueldoBasico, Domicilio.Calle, Domicilio.Nro, Domicilio.Piso, Domicilio.Dpto, Domicilio.CP, Localidad.Nombre AS Localidad, Barrio.Nombre AS Barrio, Email.Email, Telefono.Prefijo, Telefono.NroTelefono, Categorias.CategoriasID, Usuario.NombreUsuario, Usuario.UsuarioID, Usuario.Imagen FROM ((((((((($tabla1 INNER JOIN $tabla2 ON Persona.PersonaID = Empleado.PersonaID) INNER JOIN $tabla3 ON Empleado.PuestoID = Puesto.PuestoID) INNER JOIN $tabla4 ON Empleado.CategoriasID = Categorias.CategoriasID) INNER JOIN $tabla5 ON Persona.PersonaID = Domicilio.PersonaID) INNER JOIN $tabla6 ON Domicilio.LocalidadID = Localidad.LocalidadID) INNER JOIN $tabla7 ON Domicilio.BarrioID = Barrio.BarrioID) INNER JOIN $tabla8 ON Persona.PersonaID = Email.PersonaID) INNER JOIN $tabla9 ON Persona.PersonaID = Telefono.PersonaID)LEFT JOIN $tabla10 ON Persona.PersonaID = Usuario.PersonaID) ORDER BY EmpleadoID DESC");

				$stmt-> execute();

				return $stmt-> fetchAll();
			}


		}

/*=====================================
            REGISTRAR EMPLEADO
=======================================*/

		static public function mdlRegistroEmpleado($datosModel, $tabla1, $tabla2, $tabla3, $tabla4, $tabla5, $tabla6, $tabla7){

			#PRIMERO INSERTAMOS LOS DATOS DE LA PERSONA EN LA TABLA PERSONA

			$link = Conexion::conectar();

			$stmt = $link ->prepare("INSERT INTO $tabla1 (Nombre, Apellido, DNI, FechaNacimiento, Sexo) VALUES (:nombre, :apellido, :dni, :fecha, :sexo)");
			$fecha_temp= explode('/', $datosModel["fecha"]);
			$fechaok= $fecha_temp[2].'-'.$fecha_temp[1].'-'.$fecha_temp[0];
			$stmt -> bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);
			$stmt -> bindParam(":apellido", $datosModel["apellido"], PDO::PARAM_STR);
			$stmt -> bindParam(":dni", $datosModel["dni"], PDO::PARAM_INT);
			$stmt -> bindParam(":fecha", $fechaok, PDO::PARAM_STR);
			$stmt -> bindParam(":sexo", $datosModel["sexo"], PDO::PARAM_STR);

			if($stmt -> execute()){

				#OBTENEMOS EL ID DEL ULTIMO REGISTRO INSERTADO
				$ultimoIdPersona = $link->lastInsertId();

			}else{

				return "error persona";

			}

			#CREAMOS EL EMPLEADO

			$activo = "S";
			$imagen="";
			$fechaIngreso_temp= explode('/', $datosModel["fechaIngreso"]);
			$fechaIngresoOk= $fechaIngreso_temp[2].'-'.$fechaIngreso_temp[1].'-'.$fechaIngreso_temp[0];

			$stmt = $link->prepare("INSERT INTO $tabla2 (PersonaID, Legajo, FechaIngreso, PuestoID, CategoriasID, CUIL, Activo, Imagen) VALUES (:personaId, :legajo, :fechaAlta, :puesto, :categoria, :cuil, :activo, :imagen)");
			$stmt -> bindParam(":personaId", $ultimoIdPersona, PDO::PARAM_INT);
			$stmt -> bindParam(":legajo", $datosModel["legajo"], PDO::PARAM_STR);
			$stmt -> bindParam(":fechaAlta", $fechaIngresoOk, PDO::PARAM_STR);
			$stmt -> bindParam(":puesto", $datosModel["puesto"], PDO::PARAM_INT);
			$stmt -> bindParam(":categoria", $datosModel["categoria"], PDO::PARAM_INT);
			$stmt -> bindParam(":cuil", $datosModel["cuil"], PDO::PARAM_STR);
			$stmt -> bindParam(":activo", $activo, PDO::PARAM_INT);
			$stmt -> bindParam(":imagen", $imagen, PDO::PARAM_STR);

			if($stmt->execute()){

					#OBTENEMOS EL ID DEL ULTIMO REGISTRO INSERTADO
					$ultimoIdEmpleado = $link->lastInsertId();

				}else{

					#ERROR EN LA CREACION DEL EMPLEADO, SE BORRARAN DATOS DE LA PERSONA
					$stmt = $link->prepare("DELETE FROM $tabla1 WHERE PersonaID = :persona ");
					$stmt -> bindParam(":persona", $ultimoIdPersona, PDO::PARAM_INT);
					$stmt -> execute();

					return 'error empleado';

			}

			#CREACION EXITOSA DE PERSONA Y EMPLEADO, AHORA REGISTRAMOS EL EMAIL
			$stmt= $link->prepare("INSERT INTO $tabla3 (Email, Tipo, PersonaID) VALUES (:email, 'Personal', :idpersona)");
			$stmt -> bindParam(":email", $datosModel['email'], PDO::PARAM_STR);
			$stmt -> bindParam(":idpersona", $ultimoIdPersona, PDO::PARAM_INT);


			if($stmt -> execute()){

					#OBTENEMOS EL ID DEL ULTIMO REGISTRO INSERTADO
					$ultimoIdEmail = $link->lastInsertId();

				}else{

					#ERROR EN LA CREACION DEL EMAIL, SE BORRARAN DATOS DEL EMPLEADO Y LA PERSONA

					$stmt = $link->prepare("DELETE FROM $tabla2 WHERE EmpleadoID = :empleado ");
					$stmt -> bindParam(":empleado", $ultimoIdEmpleado, PDO::PARAM_INT);
					$stmt -> execute();

					$stmt = $link->prepare("DELETE FROM $tabla1 WHERE PersonaID = :persona ");
					$stmt -> bindParam(":persona", $ultimoIdPersona, PDO::PARAM_INT);
					$stmt -> execute();

					return "error mail";

			}

			#INSERTAMOS EL NUMERO DE TELEFONO
			$tipo = 'Personal';

			$stmt = $link->prepare("INSERT INTO $tabla4 (Prefijo, NroTelefono, Tipo, PersonaID) VALUES (:prefijo, :numero, :tipo, :personaId)");
			$stmt -> bindParam(":prefijo", $datosModel["codArea"], PDO::PARAM_INT);
			$stmt -> bindParam(":numero", $datosModel["telefono"], PDO::PARAM_INT);
			$stmt -> bindParam(":tipo", $tipo, PDO::PARAM_STR);
			$stmt -> bindParam(":personaId", $ultimoIdPersona, PDO::PARAM_INT);


				if($stmt -> execute()){

					#OBTENEMOS EL ID DEL ULTIMO REGISTRO INSERTADO
					$ultimoIdTelefono = $link->lastInsertId();

					} else {

						#BORRAMOS EMPLEADO Y PERSONA

						$stmt = $link->prepare("DELETE FROM $tabla3 WHERE EmailID = :mail ");
						$stmt -> bindParam(":mail", $ultimoIdEmail, PDO::PARAM_INT);
						$stmt -> execute();

						$stmt = $link->prepare("DELETE FROM $tabla2 WHERE EmpleadoID = :empleado ");
						$stmt -> bindParam(":empleado", $ultimoIdEmpleado, PDO::PARAM_INT);
						$stmt -> execute();

						$stmt = $link->prepare("DELETE FROM $tabla1 WHERE PersonaID = :persona ");
						$stmt -> bindParam(":persona", $ultimoIdPersona, PDO::PARAM_INT);
						$stmt -> execute();

						return 'error telefono';

				}

			#ANTES DE INGRESAR LA LOCALIDAD VERIFICAMOS SU EXISTENCIA

			$stmt = $link->prepare("SELECT * FROM $tabla5 WHERE Nombre = :buscar");
			$stmt -> bindParam(":buscar", $datosModel["localidad"], PDO::PARAM_STR);

				if ($stmt -> execute()) {

					$respuesta= $stmt->fetch();

						if (!empty($respuesta)) {

							#LA LOCALIDAD EXISTE
							$ultimoIdLocalidad = $respuesta["LocalidadID"];


							} else {

								#LA LOCALIDAD NO EXISTE, INSERTAMOS LA LOCALIDAD

								$stmt = $link->prepare("INSERT INTO $tabla5 (Nombre) VALUES (:nombre)");
								$stmt -> bindParam(":nombre", $datosModel["localidad"], PDO::PARAM_STR);

									if ($stmt -> execute()) {

										#OBTENEMOS EL ID DEL ULTIMO REGISTRO INSERTADO
										$ultimoIdLocalidad = $link->lastInsertId();

										$borroLocalidad = $ultimoIdLocalidad;

										} else {

											#BORRAMOS TELEFONO MAIL EMPLEADO Y PERSONA

											$stmt = $link->prepare("DELETE FROM $tabla4 WHERE TelefonoID = :telefono ");
											$stmt -> bindParam(":telefono", $ultimoIdTelefono, PDO::PARAM_INT);
											$stmt -> execute();

											$stmt = $link->prepare("DELETE FROM $tabla3 WHERE EmailID = :mail ");
											$stmt -> bindParam(":mail", $ultimoIdEmail, PDO::PARAM_INT);
											$stmt -> execute();

											$stmt = $link->prepare("DELETE FROM $tabla2 WHERE EmpleadoID = :empleado ");
											$stmt -> bindParam(":empleado", $ultimoIdEmpleado, PDO::PARAM_INT);
											$stmt -> execute();

											$stmt = $link->prepare("DELETE FROM $tabla1 WHERE PersonaID = :persona ");
											$stmt -> bindParam(":persona", $ultimoIdPersona, PDO::PARAM_INT);
											$stmt -> execute();

											return 'error crear localidad';

									}


							}

					} else {

						#BORRAMOS TELEFONO MAIL EMPLEADO Y PERSONA

						$stmt = $link->prepare("DELETE FROM $tabla4 WHERE TelefonoID = :telefono ");
						$stmt -> bindParam(":telefono", $ultimoIdTelefono, PDO::PARAM_INT);
						$stmt -> execute();

						$stmt = $link->prepare("DELETE FROM $tabla3 WHERE EmailID = :mail ");
						$stmt -> bindParam(":mail", $ultimoIdEmail, PDO::PARAM_INT);
						$stmt -> execute();

						$stmt = $link->prepare("DELETE FROM $tabla2 WHERE EmpleadoID = :empleado ");
						$stmt -> bindParam(":empleado", $ultimoIdEmpleado, PDO::PARAM_INT);
						$stmt -> execute();

						$stmt = $link->prepare("DELETE FROM $tabla1 WHERE PersonaID = :persona ");
						$stmt -> bindParam(":persona", $ultimoIdPersona, PDO::PARAM_INT);
						$stmt -> execute();

						return 'error verificar localidad';

				}

				#ANTES DE INGRESAR EL BARRIO VERIFICAMOS SU EXISTENCIA

				$stmt = $link->prepare("SELECT * FROM $tabla6 WHERE Nombre = :barrio");
				$stmt -> bindParam(":barrio", $datosModel["barrio"], PDO::PARAM_STR);

					if ($stmt -> execute()) {

						$respuesta= $stmt->fetch();

							if (!empty($respuesta)) {

								#EL BARRIO EXISTE
								$ultimoIdBarrio = $respuesta["BarrioID"];


							} else {

								#EL BARIO NO EXISTE, INSERTAMOS LA LOCALIDAD

								$stmt = $link->prepare("INSERT INTO $tabla6 (Nombre) VALUES (:nombre)");
								$stmt -> bindParam(":nombre", $datosModel["barrio"], PDO::PARAM_STR);

									if ($stmt -> execute()) {

										#OBTENEMOS EL ID DEL ULTIMO REGISTRO INSERTADO
										$ultimoIdBarrio = $link->lastInsertId();
										$borroBarrio = $ultimoIdBarrio;

									} else {

										#BORRAMOS LOCALIDAD TELEFONO MAIL EMPLEADO Y PERSONA

										$stmt = $link->prepare("DELETE FROM $tabla5 WHERE LocalidadID = :localidad ");
										$stmt -> bindParam(":localidad", $borroLocalidad, PDO::PARAM_INT);
										$stmt -> execute();

										$stmt = $link->prepare("DELETE FROM $tabla4 WHERE TelefonoID = :telefono ");
										$stmt -> bindParam(":telefono", $ultimoIdTelefono, PDO::PARAM_INT);
										$stmt -> execute();

										$stmt = $link->prepare("DELETE FROM $tabla3 WHERE EmailID = :mail ");
										$stmt -> bindParam(":mail", $ultimoIdEmail, PDO::PARAM_INT);
										$stmt -> execute();

										$stmt = $link->prepare("DELETE FROM $tabla2 WHERE EmpleadoID = :empleado ");
										$stmt -> bindParam(":empleado", $ultimoIdEmpleado, PDO::PARAM_INT);
										$stmt -> execute();

										$stmt = $link->prepare("DELETE FROM $tabla1 WHERE PersonaID = :persona ");
										$stmt -> bindParam(":persona", $ultimoIdPersona, PDO::PARAM_INT);
										$stmt -> execute();

										return 'error crear barrio';

									}


								}

						} else {

							#BORRAMOS LOCALIDAD TELEFONO MAIL EMPLEADO Y PERSONA

							$stmt = $link->prepare("DELETE FROM $tabla5 WHERE LocalidadID = :localidad ");
							$stmt -> bindParam(":localidad", $borroLocalidad, PDO::PARAM_INT);
							$stmt -> execute();

							$stmt = $link->prepare("DELETE FROM $tabla4 WHERE TelefonoID = :telefono ");
							$stmt -> bindParam(":telefono", $ultimoIdTelefono, PDO::PARAM_INT);
							$stmt -> execute();

							$stmt = $link->prepare("DELETE FROM $tabla3 WHERE EmailID = :mail ");
							$stmt -> bindParam(":mail", $ultimoIdEmail, PDO::PARAM_INT);
							$stmt -> execute();

							$stmt = $link->prepare("DELETE FROM $tabla2 WHERE EmpleadoID = :empleado ");
							$stmt -> bindParam(":empleado", $ultimoIdEmpleado, PDO::PARAM_INT);
							$stmt -> execute();

							$stmt = $link->prepare("DELETE FROM $tabla1 WHERE PersonaID = :persona ");
							$stmt -> bindParam(":persona", $ultimoIdPersona, PDO::PARAM_INT);
							$stmt -> execute();

							return 'error verificar barrio';

					}

					#INSERTAMOS EL DOMICILIO

					$stmt = $link->prepare("INSERT INTO $tabla7 (Calle, Nro, Piso, Dpto,CP, BarrioID, LocalidadID, PersonaID) VALUES (:calle, :nro, :piso, :depto, :cp, :barrioID, :localidadID, :PersonaID)");
					$stmt -> bindParam(":calle", $datosModel["calle"], PDO::PARAM_STR);
					$stmt -> bindParam(":nro", $datosModel["numeroCalle"], PDO::PARAM_INT);
					$stmt -> bindParam(":piso", $datosModel["piso"], PDO::PARAM_INT);
					$stmt -> bindParam(":depto", $datosModel["depto"], PDO::PARAM_STR);
					$stmt -> bindParam(":cp", $datosModel["codPostal"], PDO::PARAM_STR);
					$stmt -> bindParam(":barrioID", $ultimoIdBarrio, PDO::PARAM_INT);
					$stmt -> bindParam(":localidadID", $ultimoIdLocalidad, PDO::PARAM_INT);
					$stmt -> bindParam(":PersonaID", $ultimoIdPersona, PDO::PARAM_INT);

						if($stmt -> execute()){

								return "ok";

							} else{

							#BORRAMOS BARRIO LOCALIDAD TELEFONO EMAIL EMPLEADO Y PERSONA

							$stmt = $link->prepare("DELETE FROM $tabla6 WHERE BarrioID = :barrio ");
							$stmt -> bindParam(":barrio", $borroBarrio, PDO::PARAM_INT);
							$stmt -> execute();

							$stmt = $link->prepare("DELETE FROM $tabla5 WHERE LocalidadID = :localidad ");
							$stmt -> bindParam(":localidad", $borroLocalidad, PDO::PARAM_INT);
							$stmt -> execute();

							$stmt = $link->prepare("DELETE FROM $tabla4 WHERE TelefonoID = :telefono ");
							$stmt -> bindParam(":telefono", $ultimoIdTelefono, PDO::PARAM_INT);
							$stmt -> execute();

							$stmt = $link->prepare("DELETE FROM $tabla3 WHERE EmailID = :mail ");
							$stmt -> bindParam(":mail", $ultimoIdEmail, PDO::PARAM_INT);
							$stmt -> execute();

							$stmt = $link->prepare("DELETE FROM $tabla2 WHERE EmpleadoID = :empleado ");
							$stmt -> bindParam(":empleado", $ultimoIdEmpleado, PDO::PARAM_INT);
							$stmt -> execute();

							$stmt = $link->prepare("DELETE FROM $tabla1 WHERE PersonaID = :persona ");
							$stmt -> bindParam(":persona", $ultimoIdPersona, PDO::PARAM_INT);
							$stmt -> execute();

							return 'error domicilio';

						}

					#CERRAMOS LAS CONEXIONES CREADAS
					$stmt -> close();



		}

/*=====================================
			MODIFICAR EMPLEADO
======================================*/

		static public function mdlModificarEmpleado($datosModel, $tabla1, $tabla2, $tabla3, $tabla4, $tabla5, $tabla6, $tabla7){

			#EDITAMOS LOS DATOS DE LA TABLA PERSONA
			$link = Conexion::conectar();
			$stmt = $link ->prepare("UPDATE $tabla1 SET Nombre = :nombre, Apellido = :apellido, DNI = :dni, FechaNacimiento = :fecha, Sexo = :sexo WHERE PersonaID = :idPersona");

			$fecha_temp= explode('/', $datosModel["fecha"]);
			$fechaok= $fecha_temp[2].'-'.$fecha_temp[1].'-'.$fecha_temp[0];
			$stmt -> bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);
			$stmt -> bindParam(":apellido", $datosModel["apellido"], PDO::PARAM_STR);
			$stmt -> bindParam(":dni", $datosModel["dni"], PDO::PARAM_INT);
			$stmt -> bindParam(":fecha", $fechaok, PDO::PARAM_STR);
			$stmt -> bindParam(":sexo", $datosModel["sexo"], PDO::PARAM_STR);
			$stmt -> bindParam(":idPersona", $datosModel["idPersona"], PDO::PARAM_INT);

			if($stmt -> execute()){


				}else{

					return "error persona";

			}


			#EDITAMOS LOS DATOS DE LA TABLA EMPLEADO

			$stmt = $link->prepare("UPDATE $tabla2 SET FechaIngreso = :fecha, PuestoID = :puesto, CategoriasID = :categoria, CUIL = :cuil WHERE EmpleadoID = :empleado");

			$fechaIng_temp= explode('/', $datosModel["fechaIngreso"]);
			$fechaIngOk= $fechaIng_temp[2].'-'.$fechaIng_temp[1].'-'.$fechaIng_temp[0];

			$stmt -> bindParam(":fecha", $fechaIngOk, PDO::PARAM_STR);
			$stmt -> bindParam(":puesto", $datosModel["puesto"], PDO::PARAM_INT);
			$stmt -> bindParam(":categoria", $datosModel["categoria"], PDO::PARAM_INT);
			$stmt -> bindParam(":cuil", $datosModel["cuil"], PDO::PARAM_INT);
			$stmt -> bindParam(":empleado", $datosModel["idEmpleado"], PDO::PARAM_INT);


				if($stmt -> execute()){


					} else {

						return 'error empleado';

				}

			#EDITAMOS EL EMAIL

			$stmt = $link->prepare("UPDATE $tabla3 SET Email = :mail WHERE PersonaID = :idPersona");
			$stmt -> bindParam(":mail", $datosModel["email"], PDO::PARAM_STR);
			$stmt -> bindParam(":idPersona", $datosModel["idPersona"], PDO::PARAM_INT);


				if($stmt -> execute()){


					} else {

						return 'error email';

				}


			#EDITAMOS EL NUMERO DE TELEFONO

			$stmt = $link->prepare("UPDATE $tabla4 SET Prefijo = :prefijo, NroTelefono = :numero WHERE PersonaID = :idPersona");
			$stmt -> bindParam(":prefijo", $datosModel["codArea"], PDO::PARAM_INT);
			$stmt -> bindParam(":numero", $datosModel["telefono"], PDO::PARAM_INT);
			$stmt -> bindParam(":idPersona", $datosModel["idPersona"], PDO::PARAM_INT);


				if($stmt -> execute()){


					} else {

						return 'error telefono';

				}

				#ANTES DE MODIFICAR LA LOCALIDAD VERIFICAMOS SU EXISTENCIA

					$stmt = $link->prepare("SELECT * FROM $tabla5 WHERE Nombre = :localidad");
					$stmt -> bindParam(":localidad", $datosModel["localidad"], PDO::PARAM_STR);

						if ($stmt -> execute()) {

							$respuesta= $stmt->fetch();

								if (!empty($respuesta)) {

									#LA LOCALIDAD EXISTE
									$ultimoIdLocalidad = $respuesta["LocalidadID"];


									} else {

										#LA LOCALIDAD NO EXISTE, INSERTAMOS LA LOCALIDAD

										$stmt = $link->prepare("INSERT INTO $tabla5 (Nombre) VALUES (:nombre)");
										$stmt -> bindParam(":nombre", $datosModel["localidad"], PDO::PARAM_STR);

											if ($stmt -> execute()) {

												#OBTENEMOS EL ID DEL ULTIMO REGISTRO INSERTADO
												$ultimoIdLocalidad = $link->lastInsertId();

												} else {

													return 'error crear localidad';

											}


									}

							} else {


								return 'error verificar localidad';

						}


					#ANTES DE MODIFICAR EL BARRIO VERIFICAMOS SU EXISTENCIA

					$stmt = $link->prepare("SELECT * FROM $tabla6 WHERE Nombre = :barrio");
					$stmt -> bindParam(":barrio", $datosModel["barrio"], PDO::PARAM_STR);

						if ($stmt -> execute()) {

							$respuesta= $stmt->fetch();

								if (!empty($respuesta)) {

									#LA LOCALIDAD EXISTE
									$ultimoIdBarrio = $respuesta["BarrioID"];


									} else {

										#LA LOCALIDAD NO EXISTE, INSERTAMOS LA LOCALIDAD

										$stmt = $link->prepare("INSERT INTO $tabla6 (Nombre) VALUES (:nombre)");
										$stmt -> bindParam(":nombre", $datosModel["barrio"], PDO::PARAM_STR);

											if ($stmt -> execute()) {

												#OBTENEMOS EL ID DEL ULTIMO REGISTRO INSERTADO
												$ultimoIdBarrio = $link->lastInsertId();

												} else {

													return 'error crear barrio';

											}


									}

							} else {

								return 'error verificar barrio';
						}



			#MODIFICAMOS EL DOMICILIO

				$stmt = $link->prepare("UPDATE $tabla7 SET Calle = :calle, Nro = :nro, Piso = :piso, Dpto = :depto, CP = :cp, BarrioID = :barrioID, LocalidadID = :localidadID WHERE PersonaID = :PersonaID");

				$stmt -> bindParam(":calle", $datosModel["calle"], PDO::PARAM_STR);
				$stmt -> bindParam(":nro", $datosModel["numeroCalle"], PDO::PARAM_INT);
				$stmt -> bindParam(":piso", $datosModel["piso"], PDO::PARAM_INT);
				$stmt -> bindParam(":depto", $datosModel["depto"], PDO::PARAM_STR);
				$stmt -> bindParam(":cp", $datosModel["codPostal"], PDO::PARAM_INT);
				$stmt -> bindParam(":barrioID", $ultimoIdBarrio, PDO::PARAM_INT);
				$stmt -> bindParam(":localidadID", $ultimoIdLocalidad, PDO::PARAM_INT);
				$stmt -> bindParam(":PersonaID", $datosModel["idPersona"], PDO::PARAM_INT);

					if($stmt -> execute()){

							return "ok";

						} else{

						return 'error domicilio';

					}

					#CERRAMOS LAS CONEXIONES CREADAS
					$stmt -> close();

		}

/*=====================================
			ELIMINAR EMPLEADO
======================================*/

	static public function mdlEliminarEmpleado($datosModel, $tabla1, $tabla2, $tabla3, $tabla4, $tabla5, $tabla6, $tabla7){

		$link = Conexion::conectar();

		#PREGUNTAMOS SI EL EMPLEADO POSEE UN USUARIO SI ES ASI TAMBIEN LO ELIMINAMOS
		if (!empty($datosModel["UsuarioID"])) {

			if ($datosModel["fotoUsuario"] !="") {

            	unlink('../'.$datosModel["fotoUsuario"]);
            	rmdir('../vistas/img/usuarios/'.$datosModel["nombreUsuario"]);

        	}

			$stmt = $link ->prepare("DELETE FROM $tabla2 WHERE UsuarioID = :id ");
			$stmt ->bindParam(":id", $datosModel["UsuarioID"], PDO::PARAM_INT);

				if ($stmt->execute()) {

					} else {

						return 'error error usuario';
				}
		}

		#ELIMINAMOS LAS PERSONAS DEL GRUPO FAMILIAR DEL EMPLEADO

		$stmt = $link ->prepare("SELECT PersonaID FROM $tabla7 WHERE EmpleadoID = :id ");
		$stmt ->bindParam(":id", $datosModel["EmpleadoID"], PDO::PARAM_INT);

		if ($stmt->execute()) {

			#obtenemos los id de las personas que forman el grupo familiar
			$todoGrupo = $stmt->fetchAll();

			#Eliminamos el grupo familiar primero
			$stmt = $link ->prepare("DELETE FROM $tabla7 WHERE EmpleadoID = :id ");
			$stmt ->bindParam(":id", $datosModel["EmpleadoID"], PDO::PARAM_INT);

				if ($stmt->execute()) {

					if ($todoGrupo!="") {

						foreach ($todoGrupo as $key => $value) {

							#Eliminamos todas las personas que pertenecen al grupo familiar
							$stmt = $link ->prepare("DELETE FROM $tabla6 WHERE PersonaID = :id ");
							$stmt ->bindParam(":id", $value["PersonaID"], PDO::PARAM_INT);

							if ($stmt->execute()) {


								} else {

									return 'error eliminar personas grupo empleado';
							}

						}

					}

					} else {

						return 'error grupo empleado';
				}

			} else {

				return 'error buscar personas grupo empleado';
		}


		#ELIMINAMOS EL MAIL DEL EMPLEADO

		$stmt = $link ->prepare("DELETE FROM $tabla3 WHERE PersonaID = :id ");
		$stmt ->bindParam(":id", $datosModel["PersonaID"], PDO::PARAM_INT);

				if ($stmt->execute()) {

					} else {

						return 'error error email';
				}

		#ELIMINAMOS EL TELEFONO DEL EMPLEADO

		$stmt = $link ->prepare("DELETE FROM $tabla4 WHERE PersonaID = :id ");
		$stmt ->bindParam(":id", $datosModel["PersonaID"], PDO::PARAM_INT);

				if ($stmt->execute()) {

					} else {

						return 'error error telefono';
				}

		#ELIMINAMOS EL DOMICILIO DEL EMPLEADO

		$stmt = $link ->prepare("DELETE FROM $tabla5 WHERE PersonaID = :id ");
		$stmt ->bindParam(":id", $datosModel["PersonaID"], PDO::PARAM_INT);

				if ($stmt->execute()) {

					} else {

						return 'error error telefono';
				}

		#ELIMINAMOS EL EMPLEADO
		$stmt = $link ->prepare("DELETE FROM $tabla1 WHERE EmpleadoID = :id ");
		$stmt ->bindParam(":id", $datosModel["EmpleadoID"], PDO::PARAM_INT);

		if ($stmt->execute()) {

			if ($datosModel["fotoEmpleado"] !="") {

            	unlink('../'.$datosModel["fotoEmpleado"]);

        	}

			} else {

				return 'error empleado';
		}

		#ELIMINAMOS LA PERSONA
		$stmt = $link ->prepare("DELETE FROM $tabla6 WHERE PersonaID = :id ");
		$stmt ->bindParam(":id", $datosModel["PersonaID"], PDO::PARAM_INT);

				if ($stmt->execute()) {

						return 'ok';

					} else {

						return 'error error persona';
				}


		$stmt->close();



	}

/*=====================================
			TRAER PUESTOS
=====================================*/

		static public function mdlTraerPuestos($tabla){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY PuestoID ASC");
			$stmt->execute();
			return $stmt->fetchAll();
			$stmt->close();

		}

/*=====================================
			TRAER CATEGORIAS
=====================================*/

		static public function mdlTraerCategorias($tabla){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY CategoriasID ASC");
			$stmt->execute();
			return $stmt->fetchAll();
			$stmt->close();

		}

/*=====================================
			ACTIVAR EMPLEADO
=====================================*/

		static public function mdlActualizarEmpleado($tabla1, $tabla2, $item1, $valor1, $item2, $valor2){

		#Activar / Desactivar Empleado
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla1 SET $item1 = :$item1 WHERE $item2 = :$item2");
		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

		if($stmt -> execute()){

			$stmt = Conexion::conectar()->prepare("UPDATE $tabla2 SET $item1 = :$item1 WHERE $item2 = :$item2");
			$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
			$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

			if($stmt -> execute()){

				return "ok";

			}else{

				return "error usuario/empleado";

			}

		}else{

			return "error empleado";

		}

		$stmt -> close();

		$stmt = null;

		}

/*=====================================
			VALIDAR NO REPETIR CUIL
=====================================*/

	static public function mdlValidarCuil($datosModel, $tabla){

		$link = Conexion::conectar();

		$stmt = $link ->prepare("SELECT CUIL FROM $tabla WHERE CUIL = :cuil ");
		$stmt ->bindParam(":cuil", $datosModel, PDO::PARAM_STR);
		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();

	}

/*=====================================
			CREAR USUARIO
======================================*/

	static public function mdlCrearUsuario($datosModel, $tabla){

		#CREAMOS EL USUARIO CON EL ID DEL EMPLEADO Y DE LA PERSONA
		$link = Conexion::conectar();

		date_default_timezone_set("America/Argentina/Tucuman");

		$fechaAltaUser= date('Y-m-d');
		$hora = date('H:i:s');
		$fechaAltaOK = $fechaAltaUser.' '.$hora;
		$activo = "S";
		$intentos = 0;
		$stmt = $link->prepare("INSERT INTO $tabla (PersonaID, FechaAlta, NombreUsuario, Clave, Imagen, Activo, EmpleadoID, RolesID, Intentos) VALUES (:personaId, :fechaAlta, :usuario, :clave, :ruta, :activo, :empleadoId, :rolId, :intentos)");
		$stmt -> bindParam(":personaId", $datosModel["idPersona"], PDO::PARAM_INT);
		$stmt -> bindParam(":fechaAlta", $fechaAltaOK, PDO::PARAM_STR);
		$stmt -> bindParam(":usuario", $datosModel["user"], PDO::PARAM_STR);
		$stmt -> bindParam(":clave", $datosModel["pass"], PDO::PARAM_STR);
		$stmt -> bindParam(":activo", $activo, PDO::PARAM_STR);
		$stmt -> bindParam(":empleadoId", $datosModel["idEmpleado"], PDO::PARAM_INT);
		$stmt -> bindParam(":ruta", $datosModel["ruta"], PDO::PARAM_INT);
		$stmt -> bindParam(":rolId", $datosModel["rol"], PDO::PARAM_INT);
		$stmt -> bindParam(":intentos", $intentos, PDO::PARAM_INT);

		if($stmt ->execute()){

				return "ok";

			}else{


				return "error";

			}

		#CERRAMOS LAS CONEXIONES CREADAS
		$stmt -> close();

	}

/*=====================================
			FOTO EMPLEADO
======================================*/

	static public function mdlFotoEmpleado($datosModel, $tabla){

		#CREAMOS EL USUARIO CON EL ID DEL EMPLEADO Y DE LA PERSONA
		$link = Conexion::conectar();

		$stmt = $link ->prepare("UPDATE $tabla SET Imagen = :imagen WHERE EmpleadoID = :empleado");
		$stmt -> bindParam(":empleado", $datosModel["empleado"], PDO::PARAM_INT);
		$stmt -> bindParam(":imagen", $datosModel["imagen"], PDO::PARAM_STR);

		if($stmt ->execute()){

				return "ok";

			}else{


				return "error";

			}

		#CERRAMOS LAS CONEXIONES CREADAS
		$stmt -> close();

	}

/*=============================================
        	MOSTRAR CATEGORIAS PUESTOS
=============================================*/

    static public function mdlMostrarCategoriasPuestos($tabla1, $tabla2, $valor){

        $stmt = Conexion::conectar()->prepare("SELECT Categorias.CategoriasID, Categorias.Nombre AS NombreCategoria, Categorias.SueldoBasico, Puesto.PuestoID, Puesto.Nombre AS NombrePuesto FROM Categorias INNER JOIN Puesto ON Categorias.PuestoID = Puesto.PuestoID WHERE Puesto.PuestoID = :item");
        $stmt -> bindParam(":item", $valor, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt->close();

    }


}
