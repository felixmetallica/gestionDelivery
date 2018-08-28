<?php

require_once "conexion.php";

class ModeloGrupoFamiliar{

/*=============================================
            TRAER EMPLEADO				      
=============================================*/

	static public function mdlTraerEmpleados($tabla1, $tabla2){
		
		$stmt = Conexion::conectar()->prepare("SELECT Empleado.EmpleadoID, Persona.Nombre, Persona.Apellido FROM $tabla1 INNER JOIN $tabla2 ON Empleado.PersonaID = Persona.PersonaID");
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->close();

	}

/*=============================================
			REGISTRAR FAMILIAR 		      
=============================================*/

	static public function mdlRegistroFamiliar($datosModel, $tabla1, $tabla2){

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
			$idPersona = $link->lastInsertId();

		}else{

			return "error persona";

		}

		$stmt = $link ->prepare("INSERT INTO $tabla2 (EmpleadoID, PersonaID, Parentesco) VALUES (:idEmpleado, :idPersona, :parentesco)");
		
		$stmt -> bindParam(":idEmpleado", $datosModel["idEmpleado"], PDO::PARAM_INT);
		$stmt -> bindParam(":idPersona", $idPersona, PDO::PARAM_INT);
		$stmt -> bindParam(":parentesco", $datosModel["parentezco"], PDO::PARAM_STR);
		

		if($stmt -> execute()){

			return 'ok';

		}else{

			return "error familiar";

		}

		

		#CERRAMOS LAS CONEXIONES CREADAS
		$stmt -> close();
		
	}

/*=============================================
			MODIFICAR FAMILIAR 		      
=============================================*/

	static public function mdlModificoFamiliar($datosModel, $tabla1, $tabla2){

		#PRIMERO INSERTAMOS LOS DATOS DE LA PERSONA EN LA TABLA PERSONA

		$link = Conexion::conectar();

		$stmt = $link->prepare("UPDATE $tabla1 SET Nombre = :nombre, Apellido = :apellido, DNI = :dni, FechaNacimiento = :fecha, Sexo = :sexo WHERE PersonaID = :idPersona");
		
		$fecha_temp= explode('/', $datosModel["fecha"]);
		$fechaok= $fecha_temp[2].'-'.$fecha_temp[1].'-'.$fecha_temp[0];
		$stmt -> bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":apellido", $datosModel["apellido"], PDO::PARAM_STR);
		$stmt -> bindParam(":dni", $datosModel["dni"], PDO::PARAM_INT);
		$stmt -> bindParam(":fecha", $fechaok, PDO::PARAM_STR);
		$stmt -> bindParam(":sexo", $datosModel["sexo"], PDO::PARAM_STR);
		$stmt -> bindParam(":idPersona", $datosModel["idPersonaEditar"], PDO::PARAM_INT);
		

		if($stmt -> execute()){

			
		}else{

			return "error persona";

		}

		$stmt = $link->prepare("UPDATE $tabla2 SET Parentesco = :parentesco WHERE GrupoFamiliarID = :idFamiliar");
		
		$stmt -> bindParam(":parentesco", $datosModel["parentezco"], PDO::PARAM_STR);
		$stmt -> bindParam(":idFamiliar", $datosModel["idFamiliarEditar"], PDO::PARAM_INT);
		

		if($stmt -> execute()){

			return 'ok';

		}else{

			return "error familiar";

		}

		

		#CERRAMOS LAS CONEXIONES CREADAS
		$stmt -> close();
		
	}

/*=============================================
        	ELIMINAR FAMILIAR
=============================================*/

    static public function mdlEliminarFamiliar($datosModel, $tabla1, $tabla2){

        $link = Conexion::conectar();

        $stmt = $link ->prepare("DELETE FROM $tabla2 WHERE GrupoFamiliarID = :idFamiliar");
        $stmt -> bindParam(":idFamiliar", $datosModel["FamiliarID"], PDO::PARAM_INT);

            if($stmt -> execute()){

                
            } else {

                return 'error grupo';

            }

        $stmt = $link ->prepare("DELETE FROM $tabla1 WHERE PersonaID = :idPersona");
        $stmt -> bindParam(":idPersona", $datosModel["PersonaID"], PDO::PARAM_INT);

            if($stmt -> execute()){

                return 'ok';

            } else {

                return 'error persona';

            }

            $stmt->close();

    }

/*=============================================
            TRAER FAMILIARES				      
=============================================*/

	static public function mdlTraerFamiliares($datos, $tabla1, $tabla2, $tabla3){
		
		$stmt = Conexion::conectar()->prepare("SELECT GrupoFamiliar.GrupoFamiliarID, GrupoFamiliar.Parentesco, Empleado.EmpleadoID, Persona.PersonaID, Persona.Nombre, Persona.Apellido, Persona.DNI, date_format(Persona.FechaNacimiento,'%d/%m/%Y') AS Nacimiento, Persona.Sexo FROM $tabla1 INNER JOIN $tabla2 ON GrupoFamiliar.EmpleadoID = Empleado.EmpleadoID INNER JOIN $tabla3 ON GrupoFamiliar.PersonaID = Persona.PersonaID WHERE Empleado.EmpleadoID = :idEmpleado");
		$stmt -> bindParam(":idEmpleado", $datos, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->close();

	}

/*=============================================
            TRAER FAMILIAR				      
=============================================*/

	static public function mdlTraerFamiliar($datos, $tabla1, $tabla2, $tabla3){
		
		$stmt = Conexion::conectar()->prepare("SELECT GrupoFamiliar.GrupoFamiliarID, GrupoFamiliar.Parentesco, Empleado.EmpleadoID, Persona.PersonaID, Persona.Nombre, Persona.Apellido, Persona.DNI, date_format(Persona.FechaNacimiento,'%d/%m/%Y') AS Nacimiento, Persona.Sexo FROM $tabla1 INNER JOIN $tabla2 ON GrupoFamiliar.EmpleadoID = Empleado.EmpleadoID INNER JOIN $tabla3 ON GrupoFamiliar.PersonaID = Persona.PersonaID WHERE Empleado.EmpleadoID = :idEmpleado AND GrupoFamiliar.GrupoFamiliarID = :IdFramiliar");
		$stmt -> bindParam(":idEmpleado", $datos["idEmpleado"], PDO::PARAM_INT);
		$stmt -> bindParam(":IdFramiliar", $datos["IdFramiliar"], PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch();
		$stmt->close();

	}


}