<?php

require_once "conexion.php";

class ModeloUsuarios{

/*=============================================
			MOSTRAR USUARIOS   		  
=============================================*/

	static public function mdlMostrarUsuarios($tabla1, $tabla2, $tabla3, $tabla4, $item, $valor){

		if ($item != null) {
			
			$stmt = Conexion::conectar()->prepare("SELECT Persona.PersonaID, Persona.Nombre AS nombrePersona, Persona.Apellido, Persona.DNI, date_format(Persona.FechaNacimiento,'%d/%m/%Y') AS Nacimiento, Persona.Sexo, Email.Email, Usuario.UsuarioID, date_format(Usuario.FechaAlta,'%d/%m/%Y') AS Alta, Usuario.NombreUsuario, Usuario.Clave, Usuario.Imagen, Usuario.Activo, Usuario.RolesID, Roles.Nombre AS rol FROM $tabla1 INNER JOIN $tabla2 ON Persona.PersonaID = Usuario.PersonaID LEFT JOIN $tabla4 ON Email.PersonaID = Persona.PersonaID INNER JOIN $tabla3 ON Usuario.RolesID = Roles.RolesID WHERE $item = :$item ORDER BY UsuarioID ASC");

			$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetch();
		
		} else {

			$stmt = Conexion::conectar()->prepare("SELECT Usuario.UsuarioID, Usuario.NombreUsuario, Persona.Nombre, Persona.Apellido, Usuario.FechaAlta, Usuario.Activo, Usuario.Imagen, Usuario.EmpleadoID, Roles.Nombre AS Rol, Email.Email, Persona.PersonaID FROM ((($tabla1 INNER JOIN $tabla2 ON Persona.PersonaID = Usuario.PersonaID) INNER JOIN $tabla3 ON Usuario.RolesID = Roles.RolesID) LEFT JOIN $tabla4 ON Persona.PersonaID = Email.PersonaID) ORDER BY UsuarioID ASC");
				$stmt->execute();
				return $stmt->fetchAll();
				$stmt->close();
			}


	}

/*=============================================
			REGISTRAR USUARIO 		      
=============================================*/

	static public function mdlRegistroUsuario($tabla, $datos){

		date_default_timezone_set("America/Argentina/Tucuman");

		$fechaAltaUser= date('Y-m-d');
		$hora = date('H:i:s');
		$fechaAltaOK = $fechaAltaUser.' '.$hora;
				
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (PersonaID, FechaAlta, NombreUsuario, Clave, Imagen, RolesID) VALUES (:personaId, :fechaAlta, :usuario, :clave, :ruta, :rolId)");

		$stmt -> bindParam(":personaId", $datos["persona"], PDO::PARAM_INT);
		$stmt -> bindParam(":fechaAlta", $fechaAltaOK, PDO::PARAM_STR);
		$stmt -> bindParam(":usuario", $datos["user"], PDO::PARAM_STR);
		$stmt -> bindParam(":clave", $datos["pass"], PDO::PARAM_STR);
		$stmt -> bindParam(":ruta", $datos["ruta"], PDO::PARAM_INT);
		$stmt -> bindParam(":rolId", $datos["rol"], PDO::PARAM_INT);
		
		if($stmt ->execute()){

			return 'ok';

		} else {

				
			return "error usuario";

		}

		#CERRAMOS LAS CONEXIONES CREADAS
		$stmt -> close();
		
	}

/*=============================================
            EDITAR USUARIO    		      
=============================================*/

	static public function mdlEditarUsuario($tabla, $datos){

		$activo = "S";
		$intentos = 0;

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET Clave = :clave, Imagen = :imagen, RolesID = :rolId WHERE UsuarioID = :idUser");
		
		$stmt -> bindParam(":clave", $datos["pass"], PDO::PARAM_STR);
		$stmt -> bindParam(":imagen", $datos["foto"], PDO::PARAM_STR);
		$stmt -> bindParam(":rolId", $datos["rol"], PDO::PARAM_INT);
		$stmt -> bindParam(":idUser", $datos["idUsuario"], PDO::PARAM_INT);

		if($stmt ->execute()){

			return 'ok';

		}else{

			
			return "error usuario";

		}
		
	}

/*=============================================
            ELIMINAR USUARIO				  
=============================================*/

	static public function mdlEliminarUsuario($tabla, $datos){

		$stmt = Conexion::conectar() ->prepare("DELETE FROM $tabla WHERE UsuarioID = :id ");
		$stmt ->bindParam(":id", $datos, PDO::PARAM_INT);

		if ($stmt->execute()) {
			
			return 'ok';
	
		} else {

			return "error mail";
		}
		
		$stmt->close();

	}

/*=============================================
            VALIDAR USUARIO EXISTENTE	      
=============================================*/

	static public function mdlValidarUsuario($datosModel, $tabla){

		$link = new PDO("mysql:host=localhost;dbname=db_delivery","root","");
		$stmt = $link ->prepare("SELECT NombreUsuario FROM $tabla WHERE NombreUsuario = :nombreusuario ");
		$stmt ->bindParam(":nombreusuario", $datosModel, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetch();
		$stmt->close();

	}

/*=============================================
            ACTIVAR USUARIO				  
=============================================*/

	static public function mdlActualizarUsuario($tabla1, $tabla2, $item1, $valor1, $item2, $valor2, $item3){

		$stmt = Conexion::conectar()->prepare("SELECT EmpleadoID FROM $tabla1 WHERE $item2 = :$item2");
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

		if($stmt -> execute()){

			$idEmpleado = $stmt-> fetch();

			if ($idEmpleado[0]!="") {
				
				$stmt = Conexion::conectar()->prepare("SELECT Activo FROM $tabla2 WHERE $item3 = :idEmpleado");
				$stmt -> bindParam(":idEmpleado", $idEmpleado[0], PDO::PARAM_INT);
				
				if($stmt -> execute()){

					$estadoEmpleado = $stmt ->fetch();

					//echo $estadoEmpleado["Activo"];

					if ($estadoEmpleado["Activo"] == "N") {
						
						return "no";	
					
					}else{

						#Activar/Desactivar usuario
						$stmt = Conexion::conectar()->prepare("UPDATE $tabla1 SET $item1 = :$item1 WHERE $item2 = :$item2");
						$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
						$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

						if($stmt -> execute()){

							return "ok";
						
						}else{

							return "error";	

						}

					}
				
				}else{

					return "error";	

				}
				


			}else{

				#Activar/Desactivar usuario
				$stmt = Conexion::conectar()->prepare("UPDATE $tabla1 SET $item1 = :$item1 WHERE $item2 = :$item2");
				$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
				$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

				if($stmt -> execute()){

					return "ok";
				
				}else{

					return "error";	

				}

			}
		
		}else{

			return "error empleado/usuario";	

		}


	}


}