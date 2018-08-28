<?php 

require_once "conexion.php";

class ModeloPersonas{

/*=============================================
			MOSTRAR PERSONA   		  
=============================================*/

	static public function mdlMostrarPersona($tabla, $item, $valor){

		if ($item != null) {
			
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY PersonaID DESC");

			$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetch();
		
		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY PersonaID DESC");
				$stmt->execute();
				return $stmt->fetchAll();
				$stmt->close();
			}


	}

/*=============================================
			REGISTRAR PERSONA 		      
=============================================*/

	static public function mdlRegistroPersona($tabla, $datos){

		if ($datos["fechaNacimiento"] !=null) {
			
			$fecha_temp= explode('/', $datos["fechaNacimiento"]);
			$fechaok = $fecha_temp[2].'-'.$fecha_temp[1].'-'.$fecha_temp[0];

		} else {

			$fechaok = null;

		}
		$link = Conexion::conectar();
		$stmt = $link->prepare("INSERT INTO $tabla (Nombre, Apellido, DNI, FechaNacimiento, Sexo) VALUES (:nombre, :apellido, :dni, :fecha, :sexo)");
		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":apellido", $datos["apellido"], PDO::PARAM_STR);
		$stmt -> bindParam(":dni", $datos["dni"], PDO::PARAM_INT);
		$stmt -> bindParam(":fecha", $fechaok, PDO::PARAM_STR);
		$stmt -> bindParam(":sexo", $datos["sexo"], PDO::PARAM_STR);

		if($stmt -> execute()){

			$id = $link->lastInsertId();

			return $id;

		}else{

			return "error";

		}
	}

/*=============================================
			EDITAR PERSONA 		      
=============================================*/

	static public function mdlModificoPersona($tabla, $datos){

		$fecha_temp= explode('/', $datos["fecha"]);
		$fechaok= $fecha_temp[2].'-'.$fecha_temp[1].'-'.$fecha_temp[0];

		$stmt = Conexion::conectar() ->prepare("UPDATE $tabla SET Nombre = :nombre, Apellido = :apellido, DNI = :dni, FechaNacimiento = :fecha, Sexo = :sexo WHERE PersonaID = :idPersona");
				
		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":apellido", $datos["apellido"], PDO::PARAM_STR);
		$stmt -> bindParam(":dni", $datos["dni"], PDO::PARAM_INT);
		$stmt -> bindParam(":fecha", $fechaok, PDO::PARAM_STR);
		$stmt -> bindParam(":sexo", $datos["sexo"], PDO::PARAM_STR);
		$stmt -> bindParam(":idPersona", $datos["idPersona"], PDO::PARAM_INT);

		if($stmt -> execute()){

			return 'ok';
			
		}else{

			return "error persona";

		}

	}

/*=============================================
			MOSTRAR EMAIL   		  
=============================================*/

	static public function mdlMostrarEmail($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY EmailID DESC");

		$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt->execute();

		return $stmt->fetch();
		
		$stmt->close();
		
	}

/*=============================================
			REGISTRAR EMAIL 		      
=============================================*/

	static public function mdlRegistroEmail($tabla, $id, $email, $valor){

		if ($valor == "Personal") {
			
			$stmt= Conexion::conectar()->prepare("INSERT INTO $tabla (Email, Tipo, PersonaID) VALUES (:email, :tipo, :idpersona)");
			$stmt -> bindParam(":email", $email, PDO::PARAM_STR);
			$stmt -> bindParam(":tipo", $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":idpersona", $id, PDO::PARAM_INT);

			if($stmt -> execute()){

				return "ok";

			} else {

				return "error";

			}

		} else {

			$stmt= $link->prepare("INSERT INTO $tabla (Email, Tipo, ProveedorID) VALUES (:email, :tipo, :idProveedor)");
			$stmt -> bindParam(":email", $email, PDO::PARAM_STR);
			$stmt -> bindParam(":tipo", $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":idProveedor", $id, PDO::PARAM_INT);

			if($stmt -> execute()){

				return "ok";

			} else {

				return "error";

			}

		}

	}

/*=============================================
			EDITAR EMAIL 		      
=============================================*/

	static public function mdlModificoEmail($tabla, $id, $email, $valor){

		if ($valor == "Personal") {
			
			$stmt= Conexion::conectar()->prepare("UPDATE $tabla SET Email = :email WHERE PersonaID = :idpersona");
			$stmt -> bindParam(":email", $email, PDO::PARAM_STR);
			$stmt -> bindParam(":idpersona", $id, PDO::PARAM_INT);

			if($stmt -> execute()){

				return "ok";

			} else {

				return "error";

			}

		} else {

			$stmt= Conexion::conectar()->prepare("UPDATE $tabla SET Email = :email WHERE ProveedorID = :idProveedor");
			$stmt -> bindParam(":email", $email, PDO::PARAM_STR);
			$stmt -> bindParam(":idProveedor", $id, PDO::PARAM_INT);

			if($stmt -> execute()){

				return "ok";

			} else {

				return "error";

			}

		}

	}

/*=============================================
			ELIMIAR DATOS 		      
=============================================*/

	static public function mdlEliminoDatos($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $item = :$item");
		$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);		
		
		if($stmt -> execute()){

			return 'ok';
			
		}else{

			return "error eliminar";

		}

	}

/*=============================================
        VALIDAR DNI EXISTENTE		      
=============================================*/

	static public function mdlValidarDNI($datosModel, $tabla){

		$link = Conexion::conectar();
		$stmt = $link ->prepare("SELECT DNI FROM $tabla WHERE DNI = :documento ");
		$stmt ->bindParam(":documento", $datosModel, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch();
		$stmt->close();

	}

/*=============================================
        VALIDAR EMAIL EXISTENTE	      
=============================================*/

	static public function mdlValidarEmail($datosModel, $tabla){

		$link = Conexion::conectar();
		
		$stmt = $link ->prepare("SELECT Email FROM $tabla WHERE Email = :email ");
		$stmt ->bindParam(":email", $datosModel, PDO::PARAM_STR);
		$stmt->execute();
	
		return $stmt->fetch();
	
		$stmt->close();

	}

/*=============================================
        LISTADO DE BARRIOS            
=============================================*/

	static public function mdlListarBarrios($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT BarrioID, Nombre AS value FROM $tabla ORDER BY BarrioID ASC");
		
		if ($stmt->execute()) {

			while ($resultado = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$data[] = $resultado;
			}

			return ($data);
					
		}else{

			"error";
		}

		$stmt->close();
	
	}

/*=============================================
        LISTADO DE LOCALIDADES        
=============================================*/
	static public function mdlListarLocalidades($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT LocalidadID, Nombre AS value FROM $tabla ORDER BY LocalidadID ASC");
		
		if ($stmt->execute()) {

			while ($resultado = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$data[] = $resultado;
			}

			return ($data);
					
		}else{

			"error";
		}

		$stmt->close();

		$stmt = null;
	
	}

/*=============================================
		MOSTRAR DOMICILIO 	      
=============================================*/

	static public function mdlMostrarDomicilio($tabla1, $tabla2, $tabla3, $item, $valor){

		if ($item != null) {
			
			$stmt = Conexion::conectar()->prepare("SELECT Domicilio.DomicilioID, Domicilio.Calle, Domicilio.Nro, Domicilio.Piso, Domicilio.Dpto, Domicilio.CP, Domicilio.Comentario, Localidad.Nombre AS Localidad, Barrio.Nombre AS Barrio FROM $tabla1 INNER JOIN $tabla2 ON Domicilio.LocalidadID = Localidad.LocalidadID INNER JOIN $tabla3 ON Domicilio.BarrioID = Barrio.BarrioID WHERE $item = :$item ORDER BY DomicilioID DESC");
			$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetch();
		
		} else {

			$stmt = Conexion::conectar()->prepare("SELECT Domicilio.DomicilioID, Domicilio.Calle, Domicilio.Nro, Domicilio.Piso, Domicilio.Dpto, Domicilio.CP, Domicilio.Comentario, Localidad.Nombre AS Localidad, Barrio.Nombre AS Barrio FROM $tabla1 INNER JOIN $tabla2 ON Domicilio.LocalidadID = Localidad.LocalidadID INNER JOIN $tabla3 ON Domicilio.BarrioID = Barrio.BarrioID ORDER BY DomicilioID DESC");
			$stmt->execute();
			
			return $stmt->fetchAll();

			$stmt->close();

		}

	}	

/*=============================================
		MOSTRAR TELEFONO 	      
=============================================*/

	static public function mdlMostrarTelefono($tabla, $item, $valor){

		if ($item != null) {
			
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY TelefonoID DESC");
			$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetch();
		
		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY TelefonoID DESC");
			$stmt->execute();
			
			return $stmt->fetchAll();

			$stmt->close();

		}

	}	

}