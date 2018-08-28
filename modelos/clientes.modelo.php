<?php

require_once "conexion.php";

class ModeloClientes{

/*=============================================
			MOSTRAR CLIENTE   		  
=============================================*/

	static public function mdlMostrarClientes($tabla1, $tabla2, $tabla3, $tabla4, $tabla5, $tabla6, $item, $valor){

		if ($item != null) {
			
			$stmt = Conexion::conectar()->prepare("SELECT Cliente.ClienteID, Cliente.Compras, date_format(Cliente.UltimaCompra, '%d/%m/%Y %H:%i %p') AS UltimaCompra, Cliente.Activo, date_format(Cliente.FechaAlta, '%d/%m/%Y') AS FechaAlta, Persona.PersonaID, Persona.Nombre, Persona.Apellido, Domicilio.Calle, Domicilio.Nro, Domicilio.Piso, Domicilio.Dpto, Domicilio.CP, Domicilio.Comentario, Localidad.Nombre AS Localidad, Barrio.Nombre AS Barrio, Telefono.Prefijo, Telefono.NroTelefono FROM $tabla1 INNER JOIN $tabla2 ON Cliente.PersonaID = Persona.PersonaID INNER JOIN $tabla3 ON Persona.PersonaID = Domicilio.PersonaID INNER JOIN $tabla4 ON Domicilio.LocalidadID = Localidad.LocalidadID INNER JOIN $tabla5 ON Domicilio.BarrioID = Barrio.BarrioID INNER JOIN $tabla6 ON Persona.PersonaID = Telefono.PersonaID WHERE $item = :$item ORDER BY Cliente.ClienteID ASC");

			$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetch();
		
		} else {

			$stmt = Conexion::conectar()->prepare("SELECT Cliente.ClienteID, Cliente.Compras, date_format(Cliente.UltimaCompra, '%d/%m/%Y %H:%i %p') AS UltimaCompra, Cliente.Activo, date_format(Cliente.FechaAlta, '%d/%m/%Y') AS FechaAlta, Persona.PersonaID, Persona.Nombre, Persona.Apellido, Domicilio.Calle, Domicilio.Nro, Domicilio.Piso, Domicilio.Dpto, Domicilio.CP, Localidad.Nombre AS Localidad, Barrio.Nombre AS Barrio, Telefono.Prefijo, Telefono.NroTelefono FROM $tabla1 INNER JOIN $tabla2 ON Cliente.PersonaID = Persona.PersonaID INNER JOIN $tabla3 ON Persona.PersonaID = Domicilio.PersonaID INNER JOIN $tabla4 ON Domicilio.LocalidadID = Localidad.LocalidadID INNER JOIN $tabla5 ON Domicilio.BarrioID = Barrio.BarrioID INNER JOIN $tabla6 ON Persona.PersonaID = Telefono.PersonaID ORDER BY Cliente.ClienteID ASC");

			$stmt-> execute();

			return $stmt-> fetchAll();
		}


	}

/*=============================================
        	REGISTRAR CLIENTE
=============================================*/

	static public function mdlRegistroCliente($datosModel, $tabla1, $tabla2, $tabla3, $tabla4, $tabla5, $tabla6){

		#PRIMERO INSERTAMOS LOS DATOS DE LA PERSONA EN LA TABLA PERSONA

		$link = Conexion::conectar();
		$stmt = $link ->prepare("INSERT INTO $tabla1 (Nombre, Apellido) VALUES (:nombre, :apellido)");
		$stmt -> bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":apellido", $datosModel["apellido"], PDO::PARAM_STR);

			if($stmt -> execute()){

				#OBTENEMOS EL ID DEL ULTIMO REGISTRO INSERTADO
				$ultimoIdPersona = $link->lastInsertId();

				} else {

					return 'error persona';

			}

		#CREAMOS EL CLIENTE CON EL ULTIMO ID INSERTADO DE LA PERSONA
		date_default_timezone_set("America/Argentina/Tucuman");

		$fechaAltaCliente= date('Y-m-d');
		$hora = date('H:i:s');
		$fechaAltaOK = $fechaAltaCliente.' '.$hora;
		$activo = "S";

		$stmt = $link->prepare("INSERT INTO $tabla2 (PersonaID, FechaAlta, Activo) VALUES (:personaId, :fechaAlta, :activo)");
		$stmt -> bindParam(":personaId", $ultimoIdPersona, PDO::PARAM_INT);
		$stmt -> bindParam(":fechaAlta", $fechaAltaOK, PDO::PARAM_STR);
		$stmt -> bindParam(":activo", $activo, PDO::PARAM_STR);

			if($stmt -> execute()){

				#OBTENEMOS EL ID DEL ULTIMO REGISTRO INSERTADO
				$ultimoIdCliente = $link->lastInsertId();


				} else {

					#BORRAMOS PERSONA

					$stmt = $link->prepare("DELETE FROM $tabla1 WHERE PersonaID = :persona ");
					$stmt -> bindParam(":persona", $ultimoIdPersona, PDO::PARAM_INT);
					$stmt -> execute();

					return 'error cliente';

				}


		#INSERTAMOS EL NUMERO DE TELEFONO
		$tipo = 'Personal';

		$stmt = $link->prepare("INSERT INTO $tabla3 (Prefijo, NroTelefono, Tipo, PersonaID) VALUES (:prefijo, :numero, :tipo, :personaId)");
		$stmt -> bindParam(":prefijo", $datosModel["codArea"], PDO::PARAM_INT);
		$stmt -> bindParam(":numero", $datosModel["telefono"], PDO::PARAM_INT);
		$stmt -> bindParam(":tipo", $tipo, PDO::PARAM_STR);
		$stmt -> bindParam(":personaId", $ultimoIdPersona, PDO::PARAM_INT);


			if($stmt -> execute()){

				#OBTENEMOS EL ID DEL ULTIMO REGISTRO INSERTADO
				$ultimoIdTelefono = $link->lastInsertId();

				} else {

					#BORRAMOS CLIENTE Y PERSONA

					$stmt = $link->prepare("DELETE FROM $tabla2 WHERE PersonaID = :persona ");
					$stmt -> bindParam(":persona", $ultimoIdPersona, PDO::PARAM_INT);
					$stmt -> execute();

					$stmt = $link->prepare("DELETE FROM $tabla1 WHERE PersonaID = :persona ");
					$stmt -> bindParam(":persona", $ultimoIdPersona, PDO::PARAM_INT);
					$stmt -> execute();

					return 'error telefono';

			}

		#ANTES DE INGRESAR LA LOCALIDAD VERIFICAMOS SU EXISTENCIA

		$stmt = $link->prepare("SELECT * FROM $tabla4 WHERE Nombre = :localidad");
		$stmt -> bindParam(":localidad", $datosModel["localidad"], PDO::PARAM_STR);

			if ($stmt -> execute()) {

				$respuesta= $stmt->fetch();

					if (!empty($respuesta)) {

						#LA LOCALIDAD EXISTE
						$ultimoIdLocalidad = $respuesta["LocalidadID"];


						} else {

							#LA LOCALIDAD NO EXISTE, INSERTAMOS LA LOCALIDAD

							$stmt = $link->prepare("INSERT INTO $tabla4 (Nombre) VALUES (:nombre)");
							$stmt -> bindParam(":nombre", $datosModel["localidad"], PDO::PARAM_STR);

								if ($stmt -> execute()) {

									#OBTENEMOS EL ID DEL ULTIMO REGISTRO INSERTADO
									$ultimoIdLocalidad = $link->lastInsertId();

									} else {

										#BORRAMOS TELEFONO CLIENTE Y PERSONA

										$stmt = $link->prepare("DELETE FROM $tabla3 WHERE PersonaID = :persona ");
										$stmt -> bindParam(":persona", $ultimoIdPersona, PDO::PARAM_INT);
										$stmt -> execute();

										$stmt = $link->prepare("DELETE FROM $tabla2 WHERE PersonaID = :persona ");
										$stmt -> bindParam(":persona", $ultimoIdPersona, PDO::PARAM_INT);
										$stmt -> execute();

										$stmt = $link->prepare("DELETE FROM $tabla1 WHERE PersonaID = :persona ");
										$stmt -> bindParam(":persona", $ultimoIdPersona, PDO::PARAM_INT);
										$stmt -> execute();

										return 'error crear localidad';

								}


						}

				} else {

				#BORRAMOS TELEFONO CLIENTE Y PERSONA

				$stmt = $link->prepare("DELETE FROM $tabla3 WHERE PersonaID = :persona ");
				$stmt -> bindParam(":persona", $ultimoIdPersona, PDO::PARAM_INT);
				$stmt -> execute();

				$stmt = $link->prepare("DELETE FROM $tabla2 WHERE PersonaID = :persona ");
				$stmt -> bindParam(":persona", $ultimoIdPersona, PDO::PARAM_INT);
				$stmt -> execute();

				$stmt = $link->prepare("DELETE FROM $tabla1 WHERE PersonaID = :persona ");
				$stmt -> bindParam(":persona", $ultimoIdPersona, PDO::PARAM_INT);
				$stmt -> execute();

				return 'error verificar localidad';

			}

		#ANTES DE INGRESAR EL BARRIO VERIFICAMOS SU EXISTENCIA

		$stmt = $link->prepare("SELECT * FROM $tabla5 WHERE Nombre = :barrio");
		$stmt -> bindParam(":barrio", $datosModel["barrio"], PDO::PARAM_STR);

			if ($stmt -> execute()) {

				$respuesta= $stmt->fetch();

					if (!empty($respuesta)) {

						#EL BARRIO EXISTE
						$ultimoIdBarrio = $respuesta["BarrioID"];


					} else {

						#EL BARIO NO EXISTE, INSERTAMOS LA LOCALIDAD

						$stmt = $link->prepare("INSERT INTO $tabla5 (Nombre) VALUES (:nombre)");
						$stmt -> bindParam(":nombre", $datosModel["barrio"], PDO::PARAM_STR);

							if ($stmt -> execute()) {

								#OBTENEMOS EL ID DEL ULTIMO REGISTRO INSERTADO
								$ultimoIdBarrio = $link->lastInsertId();

							} else {

								#BORRAMOS LOCALIDAD TELEFONO CLIENTE Y PERSONA

								$stmt = $link->prepare("DELETE FROM $tabla4 WHERE LocalidadID = :localidad ");
								$stmt -> bindParam(":localidad", $ultimoIdLocalidad, PDO::PARAM_INT);
								$stmt -> execute();

								$stmt = $link->prepare("DELETE FROM $tabla3 WHERE PersonaID = :persona ");
								$stmt -> bindParam(":persona", $ultimoIdPersona, PDO::PARAM_INT);
								$stmt -> execute();

								$stmt = $link->prepare("DELETE FROM $tabla2 WHERE PersonaID = :persona ");
								$stmt -> bindParam(":persona", $ultimoIdPersona, PDO::PARAM_INT);
								$stmt -> execute();

								$stmt = $link->prepare("DELETE FROM $tabla1 WHERE PersonaID = :persona ");
								$stmt -> bindParam(":persona", $ultimoIdPersona, PDO::PARAM_INT);
								$stmt -> execute();

								return 'error crear barrio';

							}


						}

				} else {

					#BORRAMOS LOCALIDAD TELEFONO CLIENTE Y PERSONA

					$stmt = $link->prepare("DELETE FROM $tabla4 WHERE LocalidadID = :localidad ");
					$stmt -> bindParam(":localidad", $ultimoIdLocalidad, PDO::PARAM_INT);
					$stmt -> execute();

					$stmt = $link->prepare("DELETE FROM $tabla3 WHERE PersonaID = :persona ");
					$stmt -> bindParam(":persona", $ultimoIdPersona, PDO::PARAM_INT);
					$stmt -> execute();

					$stmt = $link->prepare("DELETE FROM $tabla2 WHERE PersonaID = :persona ");
					$stmt -> bindParam(":persona", $ultimoIdPersona, PDO::PARAM_INT);
					$stmt -> execute();

					$stmt = $link->prepare("DELETE FROM $tabla1 WHERE PersonaID = :persona ");
					$stmt -> bindParam(":persona", $ultimoIdPersona, PDO::PARAM_INT);
					$stmt -> execute();

					return 'error verificar barrio';

			}


			#INSERTAMOS EL DOMICILIO

			$stmt = $link->prepare("INSERT INTO $tabla6 (Calle, Nro, Piso, Dpto, Comentario, BarrioID, LocalidadID, PersonaID) VALUES (:calle, :nro, :piso, :depto, :comentario, :barrioID, :localidadID, :PersonaID)");
			$stmt -> bindParam(":calle", $datosModel["calle"], PDO::PARAM_STR);
			$stmt -> bindParam(":nro", $datosModel["numeroCalle"], PDO::PARAM_INT);
			$stmt -> bindParam(":piso", $datosModel["piso"], PDO::PARAM_INT);
			$stmt -> bindParam(":depto", $datosModel["depto"], PDO::PARAM_STR);
			$stmt -> bindParam(":comentario", $datosModel["comentario"], PDO::PARAM_STR);
			$stmt -> bindParam(":barrioID", $ultimoIdBarrio, PDO::PARAM_INT);
			$stmt -> bindParam(":localidadID", $ultimoIdLocalidad, PDO::PARAM_INT);
			$stmt -> bindParam(":PersonaID", $ultimoIdPersona, PDO::PARAM_INT);

				if($stmt -> execute()){

						return "ok";

					} else{

					#BORRAMOS BARRIO LOCALIDAD TELEFONO CLIENTE Y PERSONA

					$stmt = $link->prepare("DELETE FROM $tabla5 WHERE BarrioID = :barrio ");
					$stmt -> bindParam(":barrio", $ultimoIdBarrio, PDO::PARAM_INT);
					$stmt -> execute();

					$stmt = $link->prepare("DELETE FROM $tabla4 WHERE LocalidadID = :localidad ");
					$stmt -> bindParam(":localidad", $ultimoIdLocalidad, PDO::PARAM_INT);
					$stmt -> execute();

					$stmt = $link->prepare("DELETE FROM $tabla3 WHERE PersonaID = :persona ");
					$stmt -> bindParam(":persona", $ultimoIdPersona, PDO::PARAM_INT);
					$stmt -> execute();

					$stmt = $link->prepare("DELETE FROM $tabla2 WHERE PersonaID = :persona ");
					$stmt -> bindParam(":persona", $ultimoIdPersona, PDO::PARAM_INT);
					$stmt -> execute();

					$stmt = $link->prepare("DELETE FROM $tabla1 WHERE PersonaID = :persona ");
					$stmt -> bindParam(":persona", $ultimoIdPersona, PDO::PARAM_INT);
					$stmt -> execute();

					return 'error domicilio';

				}

				#CERRAMOS LAS CONEXIONES CREADAS
				$stmt -> close();

	}

/*=============================================
	        EDITAR CLIENTE
=============================================*/

	static public function mdlEditoCliente($datosModel, $tabla1, $tabla2, $tabla3, $tabla4, $tabla5, $tabla6){

		#PRIMERO EDITAMOS LOS DATOS DE LA PERSONA EN LA TABLA PERSONA

		$link = Conexion::conectar();
		$stmt = $link ->prepare("UPDATE $tabla1 SET Nombre = :nombre, Apellido = :apellido WHERE PersonaID = :idPersona");

		$stmt -> bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":apellido", $datosModel["apellido"], PDO::PARAM_STR);
		$stmt -> bindParam(":idPersona", $datosModel["personaID"], PDO::PARAM_INT);

			if($stmt -> execute()){


				} else {


					return 'error persona';

			}


		#EDITAMOS EL NUMERO DE TELEFONO

		$stmt = $link->prepare("UPDATE $tabla3 SET Prefijo = :prefijo, NroTelefono = :numero WHERE PersonaID = :idPersona");
		$stmt -> bindParam(":prefijo", $datosModel["codArea"], PDO::PARAM_INT);
		$stmt -> bindParam(":numero", $datosModel["telefono"], PDO::PARAM_INT);
		$stmt -> bindParam(":idPersona", $datosModel["personaID"], PDO::PARAM_INT);


			if($stmt -> execute()){


				} else {

					return 'error telefono';

			}

			#ANTES DE MODIFICAR LA LOCALIDAD VERIFICAMOS SU EXISTENCIA

				$stmt = $link->prepare("SELECT * FROM $tabla4 WHERE Nombre = :localidad");
				$stmt -> bindParam(":localidad", $datosModel["localidad"], PDO::PARAM_STR);

					if ($stmt -> execute()) {

						$respuesta= $stmt->fetch();

							if (!empty($respuesta)) {

								#LA LOCALIDAD EXISTE
								$ultimoIdLocalidad = $respuesta["LocalidadID"];


								} else {

									#LA LOCALIDAD NO EXISTE, INSERTAMOS LA LOCALIDAD

									$stmt = $link->prepare("INSERT INTO $tabla4 (Nombre) VALUES (:nombre)");
									$stmt -> bindParam(":nombre", $datosModel["localidad"], PDO::PARAM_STR);

										if ($stmt -> execute()) {

											#OBTENEMOS EL ID DEL ULTIMO REGISTRO INSERTADO
											$ultimoIdLocalidad = $link->lastInsertId();

											} else {

												return 'error crear localidad';

										}


								}

						} else {

						#BORRAMOS TELEFONO CLIENTE Y PERSONA

							return 'error verificar localidad';

					}


				#ANTES DE MODIFICAR EL BARRIO VERIFICAMOS SU EXISTENCIA

				$stmt = $link->prepare("SELECT * FROM $tabla5 WHERE Nombre = :barrio");
				$stmt -> bindParam(":barrio", $datosModel["barrio"], PDO::PARAM_STR);

					if ($stmt -> execute()) {

						$respuesta= $stmt->fetch();

							if (!empty($respuesta)) {

								#LA LOCALIDAD EXISTE
								$ultimoIdBarrio = $respuesta["BarrioID"];


								} else {

									#LA LOCALIDAD NO EXISTE, INSERTAMOS LA LOCALIDAD

									$stmt = $link->prepare("INSERT INTO $tabla5 (Nombre) VALUES (:nombre)");
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

			$stmt = $link->prepare("UPDATE $tabla6 SET Calle = :calle, Nro = :nro, Piso = :piso, Dpto = :depto, BarrioID = :barrioID, Comentario = :comentario, LocalidadID = :localidadID WHERE PersonaID = :PersonaID");

			$stmt -> bindParam(":calle", $datosModel["calle"], PDO::PARAM_STR);
			$stmt -> bindParam(":nro", $datosModel["numeroCalle"], PDO::PARAM_INT);
			$stmt -> bindParam(":piso", $datosModel["piso"], PDO::PARAM_INT);
			$stmt -> bindParam(":depto", $datosModel["depto"], PDO::PARAM_STR);
			$stmt -> bindParam(":comentario", $datosModel["comentario"], PDO::PARAM_STR);
			$stmt -> bindParam(":barrioID", $ultimoIdBarrio, PDO::PARAM_INT);
			$stmt -> bindParam(":localidadID", $ultimoIdLocalidad, PDO::PARAM_INT);
			$stmt -> bindParam(":PersonaID", $datosModel["personaID"], PDO::PARAM_INT);

				if($stmt -> execute()){

						return "ok";

					} else{

					return 'error domicilio';

				}

				#CERRAMOS LAS CONEXIONES CREADAS
				$stmt -> close();

	}

/*=============================================
        	ACTIVAR CLIENTE
=============================================*/

	static public function mdlActivarCliente($tabla, $item1, $valor1, $item2, $valor2){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");
		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt -> close();

		$stmt = null;

	}

/*=============================================
        	ELIMINAR CLIENTE
=============================================*/

	static public function mdlEliminarCliente($datosModel, $tabla1, $tabla2, $tabla3, $tabla4){

		$link = Conexion::conectar();

		$stmt = $link ->prepare("DELETE FROM $tabla4 WHERE PersonaID = :id ");
		$stmt ->bindParam(":id", $datosModel["PersonaID"], PDO::PARAM_INT);

		if ($stmt->execute()) {

			$stmt = $link ->prepare("DELETE FROM $tabla3 WHERE PersonaID = :id ");
			$stmt ->bindParam(":id", $datosModel["PersonaID"], PDO::PARAM_INT);

				if ($stmt->execute()) {

					$stmt = $link ->prepare("DELETE FROM $tabla2 WHERE ClienteID = :id ");
					$stmt ->bindParam(":id", $datosModel["ClienteID"], PDO::PARAM_INT);

						if ($stmt->execute()) {

							$stmt = $link ->prepare("DELETE FROM $tabla1 WHERE PersonaID = :id ");
							$stmt ->bindParam(":id", $datosModel["PersonaID"], PDO::PARAM_INT);

								if ($stmt->execute()) {

									return 'ok';

								}else{

									return 'error persona';

								}

						}else{

							return 'error cliente';
						}

					}else{

						return 'error domicilio';
				}

			} else {

				return 'error telefono';
		}

		$stmt->close();

	}

/*=============================================
        	TRAER ID PERSONA 
=============================================*/

	static public function mdlTraerIdPersona($datosModel, $tabla){

		$link = Conexion::conectar();
		$stmt = $link ->prepare("SELECT PersonaID FROM $tabla WHERE ClienteID = :cliente");
		$stmt ->bindParam(":cliente", $datosModel, PDO::PARAM_INT);

		if ($stmt->execute()) {

			return $stmt->fetch();
		
		} else {

			return 'error';
			
		}

		$stmt->close();


	}

/*=============================================
        	ACTUALIZAR CLIENTE
=============================================*/

	static public function mdlActualizarCliente($tabla, $item1, $valor1, $valor2){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE ClienteID = :idcliente");
		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":idcliente", $valor2, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt -> close();

		$stmt = null;

	}

/*=============================================
			SUMA TOTAL DE LAS VENTAS   		  
=============================================*/

	static public function mdlSumaTotalPedidos($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT SUM(Compras) AS pedidos FROM $tabla");
		$stmt->execute();
		
		return $stmt -> fetch();

		$stmt = null;
		

	}

}
