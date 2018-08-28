<?php

require_once "conexion.php";

class ModeloIngreso{

/*===============================
=            INGRESO            =
===============================*/

static public function mdlIngreso($datosModel, $tabla1, $tabla2, $tabla3){

	$stmt = Conexion::conectar()->prepare("SELECT Usuario.UsuarioID, Usuario.NombreUsuario, Usuario.Clave, Usuario.Imagen, Usuario.Activo, Usuario.Intentos, Persona.Nombre, Persona.Apellido, Roles.Nombre AS Rol, Roles.RolesID as IdRol FROM $tabla1 INNER JOIN $tabla2 ON Usuario.PersonaID = Persona.PersonaID INNER JOIN $tabla3 ON Usuario.RolesID = Roles.RolesID WHERE Usuario.NombreUsuario = :usuario");
	$stmt -> bindParam(":usuario", $datosModel["usuario"], PDO::PARAM_STR);
	$stmt -> execute();

	return $stmt -> fetch();

	$stmt -> close();
	
}

/*===============================
=            INTENTOS           =
===============================*/

static public function mdlIntentos($datosModel, $tabla){

	$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET Intentos = :intentos WHERE NombreUsuario = :usuario");
	$stmt -> bindParam(":intentos", $datosModel["actualizarIntentos"], PDO::PARAM_INT);
	$stmt -> bindParam(":usuario", $datosModel["usuarioActual"], PDO::PARAM_STR);

	if($stmt -> execute()){

		return "ok";

	}else{

		return "error";
	}

	$stmt -> close();

}

/*===============================
=        BLOQUEO CUENTA         =
===============================*/

static public function mdlBloqueoCuenta($datosModel, $tabla){

	$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET Intentos = :intentos, Activo = :activo WHERE NombreUsuario = :usuario");
	$activo = "N";
	$stmt -> bindParam(":intentos", $datosModel["actualizarIntentos"], PDO::PARAM_INT);
	$stmt -> bindParam(":usuario", $datosModel["usuarioActual"], PDO::PARAM_STR);
	$stmt -> bindParam(":activo", $activo, PDO::PARAM_STR);

	if($stmt -> execute()){

		return "ok";

	} else {

		return "error";

	}

	$stmt -> close();

}

}
