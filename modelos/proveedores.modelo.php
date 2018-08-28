<?php 

require_once "conexion.php";

class ModeloProveedores{

/*=============================================
		MOSTRAR PROVEEDOR   		  
=============================================*/

	static public function mdlMostrarProveedores($tabla1, $tabla2, $tabla3, $tabla4, $tipo, $item, $valor){

		if ($item != null) {
			
			$stmt = Conexion::conectar()->prepare("SELECT Proveedor.ProveedorID, Proveedor.RazonSocial, date_format(Proveedor.FechaAlta,'%d/%m/%Y') AS Alta, Proveedor.CUITT, Proveedor.Activo, Rubro.RubroID, Rubro.Nombre AS Rubro, Email.EmailID, Email.Email, Email.Tipo, Telefono.TelefonoID, Telefono.Prefijo, Telefono.NroTelefono, Telefono.Tipo, IVA.IVAID, IVA.Descripcion AS IVA, Persona.PersonaID FROM Proveedor INNER JOIN Rubro ON Proveedor.RubroID = Rubro.RubroID INNER JOIN Email ON Email.ProveedorID = Proveedor.ProveedorID INNER JOIN Telefono ON Telefono.ProveedorID = Proveedor.ProveedorID INNER JOIN IVA ON Proveedor.TipoIVA = IVA.IVAID LEFT JOIN Persona ON Proveedor.PersonaReferente = Persona.PersonaID WHERE Email.Tipo = 'Proveedor' AND Telefono.Tipo = 'Proveedor' AND Proveedor.$item = :$item");

			$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetch();
		
		} else {

			$stmt = Conexion::conectar()->prepare("SELECT Proveedor.ProveedorID, Proveedor.RazonSocial, date_format(Proveedor.FechaAlta,'%d/%m/%Y') AS Alta, Proveedor.CUITT, Proveedor.Activo, Rubro.RubroID, Rubro.Nombre AS Rubro, Email.EmailID, Email.Email, Email.Tipo, Telefono.TelefonoID, Telefono.Prefijo, Telefono.NroTelefono, Telefono.Tipo, IVA.IVAID, IVA.Descripcion AS IVA, Persona.PersonaID FROM Proveedor INNER JOIN Rubro ON Proveedor.RubroID = Rubro.RubroID INNER JOIN Email ON Email.ProveedorID = Proveedor.ProveedorID INNER JOIN Telefono ON Telefono.ProveedorID = Proveedor.ProveedorID INNER JOIN IVA ON Proveedor.TipoIVA = IVA.IVAID LEFT JOIN Persona ON Proveedor.PersonaReferente = Persona.PersonaID WHERE Email.Tipo = 'Proveedor' AND Telefono.Tipo = 'Proveedor'");

			$stmt-> execute();

			return $stmt-> fetchAll();
		}


	}

/*=============================================
		MOSTRAR PROVEEDORES ACTIVOS   		  
=============================================*/

	static public function mdlMostrarProveedoresAc($tabla1, $tabla2, $tabla3, $tabla4){

		$stmt = Conexion::conectar()->prepare("SELECT Proveedor.ProveedorID, Proveedor.RazonSocial, date_format(Proveedor.FechaAlta,'%d/%m/%Y') AS Alta, Proveedor.CUITT, Proveedor.Activo, Rubro.RubroID, Rubro.Nombre AS Rubro, Email.EmailID, Email.Email, Email.Tipo, Telefono.TelefonoID, Telefono.Prefijo, Telefono.NroTelefono, Telefono.Tipo, IVA.IVAID, IVA.Descripcion AS IVA, Persona.PersonaID FROM Proveedor INNER JOIN Rubro ON Proveedor.RubroID = Rubro.RubroID INNER JOIN Email ON Email.ProveedorID = Proveedor.ProveedorID INNER JOIN Telefono ON Telefono.ProveedorID = Proveedor.ProveedorID INNER JOIN IVA ON Proveedor.TipoIVA = IVA.IVAID LEFT JOIN Persona ON Proveedor.PersonaReferente = Persona.PersonaID WHERE Email.Tipo = 'Proveedor' AND Telefono.Tipo = 'Proveedor' AND Proveedor.Activo = 'S'");

		$stmt-> execute();

		return $stmt-> fetchAll();
		


	}

/*=====================================
		REGISTRAR PROVEEDOR
=====================================*/

		static public function mdlRegistrarProveedor($datosModel, $tabla1, $tabla2, $tabla3, $tabla4, $tabla5, $tabla6, $tabla7){

			$link = Conexion::conectar();
			
			$idReferente = NULL;

			#VERIFICAMOS SI SE INGRESO UN REFERENTE

			if (!empty($datosModel["nombreRefPro"])) {
				
				$stmt = $link ->prepare("INSERT INTO $tabla1 (Nombre, Apellido) VALUES (:nombre, :apellido)");
				$stmt -> bindParam(":nombre", $datosModel["nombreRefPro"], PDO::PARAM_STR);
				$stmt -> bindParam(":apellido", $datosModel["apellidoRefPro"], PDO::PARAM_STR);
				

				if($stmt -> execute()){

					#OBTENEMOS EL ID DEL ULTIMO REGISTRO INSERTADO
					
					$idReferente = $link->lastInsertId();

				} else {

					return "error persona";

				}


			}

			#CREAMOS EL PROVEEDOR

			$activo = "S";
			$fechaAltaProv= date('Y-m-d');
			$hora = date('H:i:s');
			$fechaAltaOK = $fechaAltaProv.' '.$hora;
			
			$stmt = $link->prepare("INSERT INTO $tabla2 (FechaAlta, RazonSocial, CUITT, TipoIVA, PersonaReferente, Activo, RubroID) VALUES (:fechaAlta, :razon, :cuitt, :iva, :referente, :activo, :rubro)");
			
			$stmt -> bindParam(":fechaAlta", $fechaAltaProv, PDO::PARAM_STR);
			$stmt -> bindParam(":razon", $datosModel["razon"], PDO::PARAM_STR);
			$stmt -> bindParam(":cuitt", $datosModel["cuit"], PDO::PARAM_STR);
			$stmt -> bindParam(":iva", $datosModel["iva"], PDO::PARAM_INT);
			$stmt -> bindParam(":referente", $idReferente, PDO::PARAM_INT);
			$stmt -> bindParam(":activo", $activo, PDO::PARAM_INT);
			$stmt -> bindParam(":rubro", $datosModel["rubro"], PDO::PARAM_INT);
			
			if($stmt->execute()){

					#OBTENEMOS EL ID DEL ULTIMO REGISTRO INSERTADO
					
					$idProveedor = $link->lastInsertId();

				} else { 

					#ERROR EN LA CREACION DEL PROVEEDOR, SE BORRARAN DATOS DE LA PERSONA 
					$stmt = $link->prepare("DELETE FROM $tabla1 WHERE PersonaID = :persona ");
					$stmt -> bindParam(":persona", $idReferente, PDO::PARAM_INT);
					$stmt -> execute();

					return 'error proveedor';

			}

			#CREACION EXITOSA DE PROVEEDOR, AHORA REGISTRAMOS EL EMAIL DEL PROVEEDOR
			
			$stmt= $link->prepare("INSERT INTO $tabla3 (Email, Tipo, ProveedorID) VALUES (:email, 'Proveedor', :idProveedor)");
			$stmt -> bindParam(":email", $datosModel['emailProveedor'], PDO::PARAM_STR);
			$stmt -> bindParam(":idProveedor", $idProveedor, PDO::PARAM_INT);

			
			if($stmt -> execute()){

					#OBTENEMOS EL ID DEL ULTIMO REGISTRO INSERTADO
					
					$idEmailProv = $link->lastInsertId();

				}else{

					#ERROR EN LA CREACION DEL EMAIL, SE BORRARAN DATOS DEL PROVEEDOR Y LA PERSONA 

					$stmt = $link->prepare("DELETE FROM $tabla2 WHERE ProveedorID = :proveedor");
					$stmt -> bindParam(":proveedor", $idProveedor, PDO::PARAM_INT);
					$stmt -> execute();

					$stmt = $link->prepare("DELETE FROM $tabla1 WHERE PersonaID = :persona ");
					$stmt -> bindParam(":persona", $idReferente, PDO::PARAM_INT);
					$stmt -> execute();

					return "error mail proveedor";

			}

			#SI EL PROVEEDOR POSEE UN REFERENTE INSERTAMOS SU EMAIL

			if (!empty($datosModel["nombreRefPro"])) {
				
				$stmt= $link->prepare("INSERT INTO $tabla3 (Email, Tipo, ProveedorID) VALUES (:email, 'Referente', :idProveedor)");
				$stmt -> bindParam(":email", $datosModel['mailReferente'], PDO::PARAM_STR);
				$stmt -> bindParam(":idProveedor", $idProveedor, PDO::PARAM_INT);

			
				if($stmt -> execute()){

					#OBTENEMOS EL ID DEL ULTIMO REGISTRO INSERTADO
					$idEmailRef = $link->lastInsertId();

				} else {

					#ERROR EN LA CREACION DEL EMAIL DEL REFERENTE, SE BORRARAN DATOS DEL MAIL PROVEEDOR Y LA PERSONA 

					$stmt = $link->prepare("DELETE FROM $tabla3 WHERE EmailID = :mail");
					$stmt -> bindParam(":mail", $idEmailProv, PDO::PARAM_INT);
					$stmt -> execute();

					$stmt = $link->prepare("DELETE FROM $tabla2 WHERE ProveedorID = :proveedor");
					$stmt -> bindParam(":proveedor", $idProveedor, PDO::PARAM_INT);
					$stmt -> execute();

					$stmt = $link->prepare("DELETE FROM $tabla1 WHERE PersonaID = :persona ");
					$stmt -> bindParam(":persona", $idReferente, PDO::PARAM_INT);
					$stmt -> execute();

					return "error mail referente";

				}

			}

			#INSERTAMOS EL NUMERO DE TELEFONO DEL PROVEEDOR
			$tipo = 'Proveedor';
			
			$stmt = $link->prepare("INSERT INTO $tabla4 (Prefijo, NroTelefono, Tipo, ProveedorID) VALUES (:prefijo, :numero, :tipo, :idProveedor)");
			$stmt -> bindParam(":prefijo", $datosModel["codAreaProveedor"], PDO::PARAM_INT);
			$stmt -> bindParam(":numero", $datosModel["numTelProveedor"], PDO::PARAM_INT);
			$stmt -> bindParam(":tipo", $tipo, PDO::PARAM_STR);
			$stmt -> bindParam(":idProveedor", $idProveedor, PDO::PARAM_INT);


				if($stmt -> execute()){

					#OBTENEMOS EL ID DEL ULTIMO REGISTRO INSERTADO
					
					$idTelefonoProv = $link->lastInsertId();

				} else { 

					#BORRAMOS MAIL PROVEEDOR Y PERSONA

					$stmt = $link->prepare("DELETE FROM $tabla3 WHERE EmailID = :mail");
					$stmt -> bindParam(":mail", $idEmailProv, PDO::PARAM_INT);
					$stmt -> execute();

						if (isset($idEmailRef)) {
							
							$stmt = $link->prepare("DELETE FROM $tabla3 WHERE EmailID = :mail");
							$stmt -> bindParam(":mail", $idEmailRef, PDO::PARAM_INT);
							$stmt -> execute();
						
						}

					$stmt = $link->prepare("DELETE FROM $tabla2 WHERE ProveedorID = :proveedor");
					$stmt -> bindParam(":proveedor", $idProveedor, PDO::PARAM_INT);
					$stmt -> execute();

					$stmt = $link->prepare("DELETE FROM $tabla1 WHERE PersonaID = :persona ");
					$stmt -> bindParam(":persona", $idReferente, PDO::PARAM_INT);
					$stmt -> execute();

					return 'error telefono';

				}

			#SI EL PROVEEDOR POSEE UN REFERENTE INSERTAMOS SU TELEFONO

			if (!empty($datosModel["nombreRefPro"])) {

				#INSERTAMOS EL NUMERO DE TELEFONO DEL REFERENTE
				$tipo = 'Referente';
				
				$stmt = $link->prepare("INSERT INTO $tabla4 (Prefijo, NroTelefono, Tipo, ProveedorID) VALUES (:prefijo, :numero, :tipo, :idProveedor)");
				$stmt -> bindParam(":prefijo", $datosModel["codAreaRef"], PDO::PARAM_INT);
				$stmt -> bindParam(":numero", $datosModel["numTelRef"], PDO::PARAM_INT);
				$stmt -> bindParam(":tipo", $tipo, PDO::PARAM_STR);
				$stmt -> bindParam(":idProveedor", $idProveedor, PDO::PARAM_INT);


					if($stmt -> execute()){

						#OBTENEMOS EL ID DEL ULTIMO REGISTRO INSERTADO
						
						$idTelefonoProv = $link->lastInsertId();

					} else { 

						#BORRAMOS TELEFONO MAIL PROVEEDOR Y PERSONA

						$stmt = $link->prepare("DELETE FROM $tabla4 WHERE ProveedorID = :proveedor");
						$stmt -> bindParam(":proveedor", $idProveedor, PDO::PARAM_INT);
						$stmt -> execute();

						$stmt = $link->prepare("DELETE FROM $tabla3 WHERE EmailID = :mail");
						$stmt -> bindParam(":mail", $idEmailProv, PDO::PARAM_INT);
						$stmt -> execute();

							if (isset($idEmailRef)) {
								
								$stmt = $link->prepare("DELETE FROM $tabla3 WHERE EmailID = :mail");
								$stmt -> bindParam(":mail", $idEmailRef, PDO::PARAM_INT);
								$stmt -> execute();
							
							}

						$stmt = $link->prepare("DELETE FROM $tabla2 WHERE ProveedorID = :proveedor");
						$stmt -> bindParam(":proveedor", $idProveedor, PDO::PARAM_INT);
						$stmt -> execute();

						$stmt = $link->prepare("DELETE FROM $tabla1 WHERE PersonaID = :persona ");
						$stmt -> bindParam(":persona", $idReferente, PDO::PARAM_INT);
						$stmt -> execute();

						return 'error telefono referente';

					}


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

												#BORRAMOS TELEFONO MAIL PROVEEDOR Y PERSONA

												$stmt = $link->prepare("DELETE FROM $tabla4 WHERE ProveedorID = :proveedor");
												$stmt -> bindParam(":proveedor", $idProveedor, PDO::PARAM_INT);
												$stmt -> execute();

												if (isset($idEmailRef)) {
													
													$stmt = $link->prepare("DELETE FROM $tabla4 WHERE PersonaID = :persona");
													$stmt -> bindParam(":persona", $idReferente, PDO::PARAM_INT);
													$stmt -> execute();
												
												}

												$stmt = $link->prepare("DELETE FROM $tabla3 WHERE EmailID = :mail");
												$stmt -> bindParam(":mail", $ultimoIdEmailProv, PDO::PARAM_INT);
												$stmt -> execute();

												if (isset($idEmailRef)) {
													
													$stmt = $link->prepare("DELETE FROM $tabla3 WHERE EmailID = :mail");
													$stmt -> bindParam(":mail", $idEmailRef, PDO::PARAM_INT);
													$stmt -> execute();
												
												}

												$stmt = $link->prepare("DELETE FROM $tabla2 WHERE ProveedorID = :proveedor");
												$stmt -> bindParam(":proveedor", $idProveedor, PDO::PARAM_INT);
												$stmt -> execute();

												$stmt = $link->prepare("DELETE FROM $tabla1 WHERE PersonaID = :persona ");
												$stmt -> bindParam(":persona", $idReferente, PDO::PARAM_INT);
												$stmt -> execute();

											return 'error crear localidad';

									}
							

							}

					} else {

						#BORRAMOS TELEFONO MAIL PROVEEDOR Y PERSONA

						$stmt = $link->prepare("DELETE FROM $tabla4 WHERE ProveedorID = :proveedor");
						$stmt -> bindParam(":proveedor", $idProveedor, PDO::PARAM_INT);
						$stmt -> execute();

						if (isset($idEmailRef)) {
							
							$stmt = $link->prepare("DELETE FROM $tabla4 WHERE PersonaID = :persona");
							$stmt -> bindParam(":persona", $idReferente, PDO::PARAM_INT);
							$stmt -> execute();
						
						}

						$stmt = $link->prepare("DELETE FROM $tabla3 WHERE EmailID = :mail");
						$stmt -> bindParam(":mail", $ultimoIdEmailProv, PDO::PARAM_INT);
						$stmt -> execute();

						if (isset($idEmailRef)) {
							
							$stmt = $link->prepare("DELETE FROM $tabla3 WHERE EmailID = :mail");
							$stmt -> bindParam(":mail", $idEmailRef, PDO::PARAM_INT);
							$stmt -> execute();
						
						}

						$stmt = $link->prepare("DELETE FROM $tabla2 WHERE ProveedorID = :proveedor");
						$stmt -> bindParam(":proveedor", $idProveedor, PDO::PARAM_INT);
						$stmt -> execute();

						$stmt = $link->prepare("DELETE FROM $tabla1 WHERE PersonaID = :persona ");
						$stmt -> bindParam(":persona", $idReferente, PDO::PARAM_INT);
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

										#BORRAMOS TELEFONO MAIL PROVEEDOR Y PERSONA

										$stmt = $link->prepare("DELETE FROM $tabla4 WHERE ProveedorID = :proveedor");
										$stmt -> bindParam(":proveedor", $idProveedor, PDO::PARAM_INT);
										$stmt -> execute();

										if (isset($idEmailRef)) {
											
											$stmt = $link->prepare("DELETE FROM $tabla4 WHERE PersonaID = :persona");
											$stmt -> bindParam(":persona", $idReferente, PDO::PARAM_INT);
											$stmt -> execute();
										
										}

										$stmt = $link->prepare("DELETE FROM $tabla3 WHERE EmailID = :mail");
										$stmt -> bindParam(":mail", $ultimoIdEmailProv, PDO::PARAM_INT);
										$stmt -> execute();

										if (isset($idEmailRef)) {
											
											$stmt = $link->prepare("DELETE FROM $tabla3 WHERE EmailID = :mail");
											$stmt -> bindParam(":mail", $idEmailRef, PDO::PARAM_INT);
											$stmt -> execute();
										
										}

										$stmt = $link->prepare("DELETE FROM $tabla2 WHERE ProveedorID = :proveedor");
										$stmt -> bindParam(":proveedor", $idProveedor, PDO::PARAM_INT);
										$stmt -> execute();

										$stmt = $link->prepare("DELETE FROM $tabla1 WHERE PersonaID = :persona ");
										$stmt -> bindParam(":persona", $idReferente, PDO::PARAM_INT);
										$stmt -> execute();

										return 'error crear barrio';

									}
								

								}

						} else {

							#BORRAMOS TELEFONO MAIL PROVEEDOR Y PERSONA

							$stmt = $link->prepare("DELETE FROM $tabla4 WHERE ProveedorID = :proveedor");
							$stmt -> bindParam(":proveedor", $idProveedor, PDO::PARAM_INT);
							$stmt -> execute();

							if (isset($idEmailRef)) {
								
								$stmt = $link->prepare("DELETE FROM $tabla4 WHERE PersonaID = :persona");
								$stmt -> bindParam(":persona", $idReferente, PDO::PARAM_INT);
								$stmt -> execute();
							
							}

							$stmt = $link->prepare("DELETE FROM $tabla3 WHERE EmailID = :mail");
							$stmt -> bindParam(":mail", $ultimoIdEmailProv, PDO::PARAM_INT);
							$stmt -> execute();

							if (isset($idEmailRef)) {
								
								$stmt = $link->prepare("DELETE FROM $tabla3 WHERE EmailID = :mail");
								$stmt -> bindParam(":mail", $idEmailRef, PDO::PARAM_INT);
								$stmt -> execute();
							
							}

							$stmt = $link->prepare("DELETE FROM $tabla2 WHERE ProveedorID = :proveedor");
							$stmt -> bindParam(":proveedor", $idProveedor, PDO::PARAM_INT);
							$stmt -> execute();
							
							$stmt = $link->prepare("DELETE FROM $tabla1 WHERE PersonaID = :persona ");
							$stmt -> bindParam(":persona", $idReferente, PDO::PARAM_INT);
							$stmt -> execute();

							return 'error verificar barrio';
					
					}

					#INSERTAMOS EL DOMICILIO

					$stmt = $link->prepare("INSERT INTO $tabla7 (Calle, Nro, Piso, Dpto,CP, BarrioID, LocalidadID, ProveedorID) VALUES (:calle, :nro, :piso, :depto, :cp, :barrioID, :localidadID, :ProveedorID)");
					$stmt -> bindParam(":calle", $datosModel["calle"], PDO::PARAM_STR);
					$stmt -> bindParam(":nro", $datosModel["numCalle"], PDO::PARAM_INT);
					$stmt -> bindParam(":piso", $datosModel["piso"], PDO::PARAM_INT);
					$stmt -> bindParam(":depto", $datosModel["depto"], PDO::PARAM_STR);
					$stmt -> bindParam(":cp", $datosModel["codPostal"], PDO::PARAM_STR);
					$stmt -> bindParam(":barrioID", $ultimoIdBarrio, PDO::PARAM_INT);
					$stmt -> bindParam(":localidadID", $ultimoIdLocalidad, PDO::PARAM_INT);
					$stmt -> bindParam(":ProveedorID", $idProveedor, PDO::PARAM_INT);

						if($stmt -> execute()){

								return "ok";

							} else{

							#BORRAMOS TELEFONO MAIL PROVEEDOR Y PERSONA

							$stmt = $link->prepare("DELETE FROM $tabla4 WHERE ProveedorID = :proveedor");
							$stmt -> bindParam(":proveedor", $idProveedor, PDO::PARAM_INT);
							$stmt -> execute();

							if (isset($idEmailRef)) {
								
								$stmt = $link->prepare("DELETE FROM $tabla4 WHERE PersonaID = :persona");
								$stmt -> bindParam(":persona", $idReferente, PDO::PARAM_INT);
								$stmt -> execute();
							
							}

							$stmt = $link->prepare("DELETE FROM $tabla3 WHERE EmailID = :mail");
							$stmt -> bindParam(":mail", $ultimoIdEmailProv, PDO::PARAM_INT);
							$stmt -> execute();

							if (isset($idEmailRef)) {
								
								$stmt = $link->prepare("DELETE FROM $tabla3 WHERE EmailID = :mail");
								$stmt -> bindParam(":mail", $idEmailRef, PDO::PARAM_INT);
								$stmt -> execute();
							
							}

							$stmt = $link->prepare("DELETE FROM $tabla2 WHERE ProveedorID = :proveedor");
							$stmt -> bindParam(":proveedor", $idProveedor, PDO::PARAM_INT);
							$stmt -> execute();
							
							$stmt = $link->prepare("DELETE FROM $tabla1 WHERE PersonaID = :persona ");
							$stmt -> bindParam(":persona", $idReferente, PDO::PARAM_INT);
							$stmt -> execute();

							return 'error domicilio';

						}

					#CERRAMOS LAS CONEXIONES CREADAS
					$stmt -> close();


		
		}

/*=====================================
		MODIFICAR PROVEEDOR
=====================================*/

		static public function mdlModificarProveedor($datosModel, $tabla1, $tabla2, $tabla3, $tabla4, $tabla5, $tabla6, $tabla7){

			$link = Conexion::conectar();
			
			$idReferente = NULL;

			#VERIFICAMOS EXISTE UN REFERENTE

			if (!empty($datosModel["idRef"])) {
				
				#EL REFERENTE EXISTE, POR LO TANTO MODIFICAMOS SUS DATOS

				$stmt = $link->prepare("UPDATE $tabla1 SET Nombre = :nombre, Apellido = :apellido WHERE PersonaID = :idPersona");
				$stmt -> bindParam(":nombre", $datosModel["nombreRefPro"], PDO::PARAM_STR);
				$stmt -> bindParam(":apellido", $datosModel["apellidoRefPro"], PDO::PARAM_STR);
				$stmt -> bindParam(":idPersona", $datosModel["idRef"], PDO::PARAM_INT);

				if($stmt -> execute()){

					$idReferente = $datosModel["idRef"];

				} else {

					return "referror";

				}


			} elseif (!empty($datosModel["nombreRefPro"])) {
				
				#EL REFERENTE NO EXISTE, POR LO TANTO INSERTAMOS LOS DATOS EN LA TABLA PERSONA

				$stmt = $link ->prepare("INSERT INTO $tabla1 (Nombre, Apellido) VALUES (:nombre, :apellido)");
				$stmt -> bindParam(":nombre", $datosModel["nombreRefPro"], PDO::PARAM_STR);
				$stmt -> bindParam(":apellido", $datosModel["apellidoRefPro"], PDO::PARAM_STR);

				if($stmt -> execute()){

					#OBTENEMOS EL ID DEL ULTIMO REGISTRO INSERTADO
					$idReferente = $link->lastInsertId();

				} else {

					return "error persona";

				}

				
			}


			#MODIFICAMOS LOS DATOS DE LA TABLA PROVEEDOR

			$stmt = $link->prepare("UPDATE $tabla2 SET RazonSocial = :razon, CUITT = :cuitt, PersonaReferente = :referente, RubroID = :rubro, TipoIVA = :iva WHERE ProveedorID = :idProveedor");

			$stmt -> bindParam(":razon", $datosModel["razon"], PDO::PARAM_STR);
			$stmt -> bindParam(":cuitt", $datosModel["cuit"], PDO::PARAM_STR);
			$stmt -> bindParam(":referente", $idReferente, PDO::PARAM_STR);
			$stmt -> bindParam(":rubro", $datosModel["rubro"], PDO::PARAM_STR);
			$stmt -> bindParam(":iva", $datosModel["iva"], PDO::PARAM_STR);
			$stmt -> bindParam(":idProveedor", $datosModel["idProv"], PDO::PARAM_INT);

			if($stmt -> execute()){

				
			} else {

				return "error proveedor";

			}


			#MODIFICAMOS LA TABLA DE EMAIL CON LOS DATOS DEL EMAIL DEL PROVEEDOR

			$stmt = $link->prepare("UPDATE $tabla3 SET Email = :email WHERE ProveedorID = :idProveedor AND Tipo = 'Proveedor'");

			$stmt -> bindParam(":email", $datosModel["emailProveedor"], PDO::PARAM_STR);
			$stmt -> bindParam(":idProveedor", $datosModel["idProv"], PDO::PARAM_INT);

			if($stmt -> execute()){

				
			} else {

				return "error email proveedor";

			}

				
			#MODIFICAMOS EL EMAIL DEL REFERENTE

			if (!empty($datosModel["idRef"])) {

				$stmt = $link->prepare("UPDATE $tabla3 SET Email = :email WHERE ProveedorID = :idProveedor AND Tipo = 'Referente'");

				$stmt -> bindParam(":email", $datosModel["mailReferente"], PDO::PARAM_STR);
				$stmt -> bindParam(":idProveedor", $datosModel["idProv"], PDO::PARAM_INT);

				if($stmt -> execute()){

				
				} else {

					return "error email referente";

				}


			} elseif (!empty($datosModel["mailReferente"])) {

				#EL REFERENTE NO EXISTE, POR LO TANTO INSERTAMOS LOS DATOS EN LA TABLA EMAIL
				$tipo = 'Referente';
				$stmt = $link ->prepare("INSERT INTO $tabla3 (Email, Tipo, ProveedorID) VALUES (:mail, :tipo, :idProveedor)");
				$stmt -> bindParam(":mail", $datosModel["mailReferente"], PDO::PARAM_STR);
				$stmt -> bindParam(":tipo", $tipo, PDO::PARAM_STR);
				$stmt -> bindParam(":idProveedor", $datosModel["idProv"], PDO::PARAM_INT);

				if($stmt -> execute()){


				} else {

					return "error creo mail ref";

				}


			} 	

			#MODIFICAMOS LA TABLA DE TELEFONO DEL PROVEEDOR

			$stmt = $link->prepare("UPDATE $tabla4 SET Prefijo = :prefijo, NroTelefono = :telefono WHERE ProveedorID = :idProveedor AND Tipo = 'Proveedor'");
			$stmt -> bindParam(":prefijo", $datosModel["codAreaProveedor"], PDO::PARAM_STR);
			$stmt -> bindParam(":telefono", $datosModel["numTelProveedor"], PDO::PARAM_STR);
			$stmt -> bindParam(":idProveedor", $datosModel["idProv"], PDO::PARAM_INT);

			if($stmt -> execute()){

				
			} else {

				return "error telefono proveedor";

			}



			if (!empty($datosModel["idRef"])) {

				#MODIFICAMOS LA TABLA DE TELEFONO DEL REFERENTE

				$stmt = $link->prepare("UPDATE $tabla4 SET Prefijo = :prefijo, NroTelefono = :telefono WHERE ProveedorID = :idProveedor AND Tipo = 'Referente'");
				$stmt -> bindParam(":prefijo", $datosModel["codAreaRef"], PDO::PARAM_STR);
				$stmt -> bindParam(":telefono", $datosModel["numTelRef"], PDO::PARAM_STR);
				$stmt -> bindParam(":idProveedor", $datosModel["idProv"], PDO::PARAM_INT);

				if($stmt -> execute()){

					
				} else {

					return "error telefono referente";

				}


			} elseif (!empty($datosModel["codAreaRef"])) {

				#EL REFERENTE NO EXISTE, POR LO TANTO INSERTAMOS LOS DATOS EN LA TABLA TELEFONO

				$tipo = 'Referente';
				$stmt = $link ->prepare("INSERT INTO $tabla4 (Prefijo, NroTelefono, Tipo, ProveedorID) VALUES (:prefijo, :numero, :tipo, :idProveedor)");

				$stmt -> bindParam(":prefijo", $datosModel["codAreaRef"], PDO::PARAM_STR);
				$stmt -> bindParam(":numero", $datosModel["numTelRef"], PDO::PARAM_STR);
				$stmt -> bindParam(":tipo", $tipo, PDO::PARAM_STR);
				$stmt -> bindParam(":idProveedor", $datosModel["idProv"], PDO::PARAM_INT);

				if($stmt -> execute()){


				} else {

					return "error creo tel ref";

				}

			}


			#ANTES DE INGRESAR LA LOCALIDAD VERIFICAMOS SU EXISTENCIA
				
			$stmt = $link->prepare("SELECT * FROM $tabla5 WHERE Nombre = :buscar");
			$stmt -> bindParam(":buscar", $datosModel["localidad"], PDO::PARAM_STR);

			if ($stmt -> execute()) {
						
				$respuesta= $stmt->fetch();

					if (!empty($respuesta)) {
							
						#LA LOCALIDAD EXISTE
						$idLocalidad = $respuesta["LocalidadID"];
						

						} else {

							#LA LOCALIDAD NO EXISTE, INSERTAMOS LA LOCALIDAD

							$stmt = $link->prepare("INSERT INTO $tabla5 (Nombre) VALUES (:nombre)");
							$stmt -> bindParam(":nombre", $datosModel["localidad"], PDO::PARAM_STR);
							
								if ($stmt -> execute()) {

									#OBTENEMOS EL ID DEL ULTIMO REGISTRO INSERTADO
									$idLocalidad = $link->lastInsertId();

									} else {

										return 'error crear localidad';

								}
				
						}

				} else {

					
						
					return 'error verificar localidad';
			
			}


			#ANTES DE INGRESAR EL BARRIO VERIFICAMOS SU EXISTENCIA

			$stmt = $link->prepare("SELECT * FROM $tabla6 WHERE Nombre = :barrio");
			$stmt -> bindParam(":barrio", $datosModel["barrio"], PDO::PARAM_STR);

				if ($stmt -> execute()) {
							
					$respuesta= $stmt->fetch();

						if (!empty($respuesta)) {
								
							#EL BARRIO EXISTE
							$idBarrio = $respuesta["BarrioID"];
							

						} else {

							#EL BARIO NO EXISTE, INSERTAMOS LA LOCALIDAD

							$stmt = $link->prepare("INSERT INTO $tabla6 (Nombre) VALUES (:nombre)");
							$stmt -> bindParam(":nombre", $datosModel["barrio"], PDO::PARAM_STR);
							
								if ($stmt -> execute()) {

									#OBTENEMOS EL ID DEL ULTIMO REGISTRO INSERTADO
									$idBarrio = $link->lastInsertId();
									
								} else {

									return 'error crear barrio';

								}
							

							}

					} else {

						return 'error verificar barrio';
				
				}

			#POR ULTIMO MODIFICAMOS LOS DATOS DEL DOMICILIO

			$stmt = $link->prepare("UPDATE $tabla7 SET Calle = :calle, Nro = :numero, Piso = :piso, Dpto = :depto, CP = :cp, BarrioID = :barrio, LocalidadID = :localidad WHERE ProveedorID = :idProveedor");
			
			$stmt -> bindParam(":calle", $datosModel["calle"], PDO::PARAM_STR);
			$stmt -> bindParam(":numero", $datosModel["numCalle"], PDO::PARAM_INT);
			$stmt -> bindParam(":piso", $datosModel["piso"], PDO::PARAM_INT);

			$stmt -> bindParam(":depto", $datosModel["depto"], PDO::PARAM_STR);
			$stmt -> bindParam(":cp", $datosModel["codPostal"], PDO::PARAM_STR);
			$stmt -> bindParam(":barrio", $idBarrio, PDO::PARAM_STR);

			$stmt -> bindParam(":localidad", $idLocalidad, PDO::PARAM_STR);
			
			$stmt -> bindParam(":idProveedor", $datosModel["idProv"], PDO::PARAM_INT);

			if($stmt -> execute()){

				return 'ok';
				
			} else {

				return "error domicilio";

			}

				
			#CERRAMOS LAS CONEXIONES CREADAS
			$stmt -> close();


		
		}

/*=====================================
		ELIMINAR PROVEEDOR
=====================================*/

		static public function mdlEliminarProveedor($datosModel, $tabla1, $tabla2, $tabla3, $tabla4, $tabla5){

			$link = Conexion::conectar();
			
			#BORRAMOS EL DOMICILIO

			$stmt = $link ->prepare("DELETE FROM $tabla5 WHERE ProveedorID = :id ");
			$stmt ->bindParam(":id", $datosModel["ProveedorID"], PDO::PARAM_INT);

			if ($stmt->execute()) {
		
					
			
				} else{

					return 'error dom';
			}

			#BORRAMOS EL TELEFONO DEL PROVEEDOR

			$stmt = $link ->prepare("DELETE FROM $tabla4 WHERE ProveedorID = :id AND Tipo = 'Proveedor' ");
			$stmt ->bindParam(":id", $datosModel["ProveedorID"], PDO::PARAM_INT);

			if ($stmt->execute()) {
		
					
			
				} else{

					return 'error tel prov';
			}
				
			
			#SI EXISTE UN REFERENTE BORRAMOS SU TELEFONO

			if (!empty($datosModel["PersonaID"])) {
				
				$stmt = $link ->prepare("DELETE FROM $tabla4 WHERE ProveedorID = :id AND Tipo = 'Referente' ");
				$stmt ->bindParam(":id", $datosModel["ProveedorID"], PDO::PARAM_INT);

				if ($stmt->execute()) {
			
						
				
					} else{

						return 'error tel ref';
				}

			}

			#BORRAMOS EL EMAIL DEL PROVEEDOR

			$stmt = $link ->prepare("DELETE FROM $tabla3 WHERE ProveedorID = :id AND Tipo = 'Proveedor' ");
			$stmt ->bindParam(":id", $datosModel["ProveedorID"], PDO::PARAM_INT);

			if ($stmt->execute()) {
		
					
			
				} else{

					return 'error email prov';
			}


			#SI EXISTE UN REFERENTE BORRAMOS SU EMAIL

			if (!empty($datosModel["PersonaID"])) {
				
				$stmt = $link ->prepare("DELETE FROM $tabla3 WHERE ProveedorID = :id AND Tipo = 'Referente' ");
				$stmt ->bindParam(":id", $datosModel["ProveedorID"], PDO::PARAM_INT);

				if ($stmt->execute()) {
			
						
				
					} else{

						return 'error tel ref';
				}

			}

			
			#BORRAMOS EL PROVEEDOR

			$stmt = $link ->prepare("DELETE FROM $tabla2 WHERE ProveedorID = :id ");
			$stmt ->bindParam(":id", $datosModel["ProveedorID"], PDO::PARAM_INT);

			if ($stmt->execute()) {
		
					
			
				} else{

					return 'error prov';
			}


			#SI EXISTE UNA PERSONA LA BORRAMOS

			if (!empty($datosModel["PersonaID"])) {
				
				$stmt = $link ->prepare("DELETE FROM $tabla1 WHERE PersonaID = :id ");
				$stmt ->bindParam(":id", $datosModel["PersonaID"], PDO::PARAM_INT);

				if ($stmt->execute()) {
			
					return 'ok';	
				
					} else{

						return 'error persona';
				}

			} else {


				return 'ok';

			}


			#CERRAMOS LAS CONEXIONES CREADAS
			$stmt -> close();
		
		}

/*=====================================
        LISTADO DE RUBROS            
=====================================*/

	static public function mdlListarRubros($tabla){
		
		$stmt = Conexion::conectar()->prepare("SELECT RubroID, Nombre FROM $tabla WHERE Tipo = 'Proveedor' ORDER BY RubroID ASC");
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->close();

	}

/*=====================================
        LISTADO DE IVA            
=====================================*/

	static public function mdlListarIva($tabla){
		
		$stmt = Conexion::conectar()->prepare("SELECT IVAID, Descripcion FROM $tabla ORDER BY IVAID ASC");
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->close();

	}

/*=====================================
		VALIDAR NO REPETIR CUIL 	      
=====================================*/

	static public function mdlValidarCuit($datosModel, $tabla){

		$link = Conexion::conectar();
		
		$stmt = $link ->prepare("SELECT CUITT FROM $tabla WHERE CUITT = :cuit ");
		$stmt ->bindParam(":cuit", $datosModel, PDO::PARAM_STR);
		$stmt->execute();
	
		return $stmt->fetch();
	
		$stmt->close();

	}

/*=====================================
		TRAER DOMICILIO 	      
=====================================*/

	static public function mdlTraerDomicilioProveedores($datosModel, $tabla){

		$link = Conexion::conectar();
		
		$stmt = $link ->prepare("SELECT Domicilio.Calle, Domicilio.Nro, Domicilio.Piso, Domicilio.Dpto, Domicilio.CP, Localidad.Nombre AS Localidad, Barrio.Nombre AS Barrio FROM Domicilio INNER JOIN Localidad ON Domicilio.LocalidadID = Localidad.LocalidadID INNER JOIN Barrio ON Barrio.BarrioID = Domicilio.BarrioID WHERE Domicilio.ProveedorID = :proveedor");
		$stmt ->bindParam(":proveedor", $datosModel, PDO::PARAM_INT);
		$stmt->execute();
	
		return $stmt->fetch();
	
		$stmt->close();

	}

/*=====================================
		TRAER REFERENTE 	      
=====================================*/

	static public function mdlTraerReferenteProveedor($datosModel, $tabla){

		$link = Conexion::conectar();
		
		$stmt = $link ->prepare("SELECT Persona.PersonaID, Persona.Nombre, Persona.Apellido, Email.Email, Telefono.Prefijo, Telefono.NroTelefono FROM Proveedor INNER JOIN Persona ON Proveedor.PersonaReferente = Persona.PersonaID INNER JOIN Email ON Email.ProveedorID = Proveedor.ProveedorID INNER JOIN Telefono ON Proveedor.ProveedorID = Telefono.ProveedorID WHERE Proveedor.ProveedorID = :proveedor AND Email.Tipo = 'Referente' AND Telefono.Tipo = 'Referente'");
		$stmt ->bindParam(":proveedor", $datosModel, PDO::PARAM_INT);
		$stmt->execute();
	
		return $stmt->fetch();
	
		$stmt->close();

	}

/*=============================================
        ACTIVAR PROVEEDOR				  
=============================================*/

	static public function mdlActualizarProveedor($tabla, $item1, $valor1, $item2, $valor2){

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

}//fin class ModeloProveedores