<?php

require_once "conexion.php";

class ModeloAlmacen{

/*=======================================
        MOSTRAR INSUMOS/PRODUCTOS
=======================================*/

    static public function mdlMostrarProductosInsumos($tabla1, $tabla2, $item, $valor){

        if($item != null){

        	$stmt = Conexion::conectar()->prepare("SELECT Insumos.InsumosID AS Id, Insumos.Codigo, Insumos.Nombre, 'Insumo' AS Tipo FROM $tabla1 WHERE $item = :$item UNION ALL SELECT Producto.ProductoID AS Id, Producto.Codigo, Producto.Nombre, 'Producto' AS Tipo FROM $tabla2 WHERE Producto.RestaStock = 'S' AND $item = :$item ORDER BY 'Nombre'");

    			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

    			$stmt -> execute();

    			return $stmt -> fetch();


        } else {

        	$stmt = Conexion::conectar()->prepare("SELECT Insumos.InsumosID AS Id, Insumos.Codigo, Insumos.Medida AS Medida, Insumos.Nombre AS Nombre, ROUND(Insumos.Stock,2) AS Stock, Insumos.StockMinimo AS StockMinimo, 'Insumo' AS Tipo FROM Insumos UNION ALL SELECT Producto.ProductoID AS Id, Producto.Codigo, 'Unidades' AS Medida, Producto.Nombre AS Nombre, ROUND(Producto.Stock,2) AS Stock, Producto.StockMinimo AS StockMinimo, 'Producto' AS Tipo FROM Producto WHERE Producto.RestaStock = 'S' ORDER BY Nombre ASC");

    			$stmt -> execute();

    			return $stmt -> fetchAll();

        }


    }

/*=======================================
        MOSTRAR MOVIMIENTOS
=======================================*/

    static public function mdlMostrarMovimientos($tabla1, $tabla2, $tabla3, $item, $valor){

        if($item != null){

        	$stmt = Conexion::conectar()->prepare("SELECT Almacen.AlmacenID, date_format(Almacen.Fecha,'%d/%m/%Y') AS Fecha, Almacen.Nombre, Almacen.Descripcion, Almacen.Tipo, Almacen.InsumosID, Almacen.ProductoID, Almacen.Cantidad, Almacen.UsuarioID, Persona.Nombre AS NombrePersona, Persona.Apellido AS ApellidoPersona FROM $tabla1 INNER JOIN $tabla2 ON Almacen.UsuarioID = Usuario.UsuarioID INNER JOIN $tabla3 ON Usuario.PersonaID = Persona.PersonaID WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();


        } else {

        	$stmt = Conexion::conectar()->prepare("SELECT Almacen.AlmacenID, date_format(Almacen.Fecha,'%d/%m/%Y') AS Fecha, Almacen.Nombre, Almacen.Descripcion, Almacen.Tipo, Almacen.InsumosID, Almacen.ProductoID, Almacen.Cantidad, Almacen.UsuarioID, Persona.Nombre AS NombrePersona, Persona.Apellido AS ApellidoPersona FROM $tabla1 INNER JOIN $tabla2 ON Almacen.UsuarioID = Usuario.UsuarioID INNER JOIN $tabla3 ON Usuario.PersonaID = Persona.PersonaID ORDER BY AlmacenID DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

        }


    }

/*=======================================
        REGISTRAR MOVIMIENTO
=======================================*/

	static public function mdlRegistroMovimiento($tabla, $datos){

		date_default_timezone_set("America/Argentina/Tucuman");

		$fecha_temp= explode('/', $datos["fecha"]);
		$fechaok= $fecha_temp[2].'-'.$fecha_temp[1].'-'.$fecha_temp[0];

		$link = Conexion::conectar();

		$stmt = $link->prepare("INSERT INTO $tabla (Fecha, Nombre, Descripcion, Tipo, InsumosID, ProductoID, Cantidad, UsuarioID) VALUES (:fecha, :nombre, :descripcion, :tipo, :idInsumo, :idProducto, :cantidad, :idUsuario)");

		$stmt->bindParam(":fecha", $fechaok, PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo", $datos["tipoMovimiento"], PDO::PARAM_STR);
		$stmt->bindParam(":idInsumo", $datos["idInsumo"], PDO::PARAM_STR);
		$stmt->bindParam(":idProducto", $datos["idProducto"], PDO::PARAM_STR);
		$stmt->bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_STR);
		$stmt->bindParam(":idUsuario", $datos["idUsuario"], PDO::PARAM_INT);



		if ($stmt->execute()) {

			return "ok";

		} else {

			return "error";
		}

		$stmt->close();

	}

/*=======================================
        EDITAR MOVIMIENTO
=======================================*/

	static public function mdlEditarMovimiento($tabla, $datos){

		date_default_timezone_set("America/Argentina/Tucuman");

		$fecha_temp= explode('/', $datos["fecha"]);
		$fechaok= $fecha_temp[2].'-'.$fecha_temp[1].'-'.$fecha_temp[0];

		$link = Conexion::conectar();

		$stmt = $link->prepare("UPDATE $tabla SET Fecha = :fecha, Nombre = :nombre, Descripcion = :descripcion, Tipo = :tipo, InsumosID = :idInsumo, ProductoID = :idProducto, Cantidad = :cantidad, UsuarioID = :idUsuario WHERE AlmacenID = :almacenId");

		$stmt->bindParam(":fecha", $fechaok, PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo", $datos["tipoMovimiento"], PDO::PARAM_STR);
		$stmt->bindParam(":idInsumo", $datos["idInsumo"], PDO::PARAM_STR);
		$stmt->bindParam(":idProducto", $datos["idProducto"], PDO::PARAM_STR);
		$stmt->bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_STR);
		$stmt->bindParam(":idUsuario", $datos["idUsuario"], PDO::PARAM_INT);
		$stmt->bindParam(":almacenId", $datos["idMovimiento"], PDO::PARAM_INT);



		if ($stmt->execute()) {

			return "ok";

		} else {

			return "error";
		}

		$stmt->close();

	}

/*=======================================
        ELIMINAR MOVIMIENTO
=======================================*/

	static public function mdlEliminarMovimientos($tabla, $idMov){

		$link = Conexion::conectar();

		$stmt = $link ->prepare("DELETE FROM $tabla WHERE AlmacenID = :id ");
		$stmt ->bindParam(":id", $idMov, PDO::PARAM_INT);

		if ($stmt->execute()) {

			return 'ok';

		} else {

			return 'error';

		}

		$stmt->close();

	}

/*=======================================
		RANGO DE FECHAS
=======================================*/

	static public function mdlRangoFechaAlmacen($tabla1, $tabla2, $tabla3, $fechaInicial, $fechaFinal){

		if ($fechaInicial == null) {

			$stmt = Conexion::conectar()->prepare("SELECT Almacen.AlmacenID, date_format(Almacen.Fecha,'%d/%m/%Y') AS Fecha, Almacen.Nombre, Almacen.Descripcion, Almacen.Tipo, Almacen.InsumosID, Almacen.ProductoID, Almacen.Cantidad, Almacen.UsuarioID, Persona.Nombre AS NombrePersona, Persona.Apellido AS ApellidoPersona FROM $tabla1 INNER JOIN $tabla2 ON Almacen.UsuarioID = Usuario.UsuarioID INNER JOIN $tabla3 ON Usuario.PersonaID = Persona.PersonaID ORDER BY AlmacenID DESC");

			$stmt-> execute();

			return $stmt-> fetchAll();

		} elseif ($fechaInicial == $fechaFinal) {

			$stmt = Conexion::conectar()->prepare("SELECT Almacen.AlmacenID, date_format(Almacen.Fecha,'%d/%m/%Y') AS Fecha, Almacen.Nombre, Almacen.Descripcion, Almacen.Tipo, Almacen.InsumosID, Almacen.ProductoID, Almacen.Cantidad, Almacen.UsuarioID, Persona.Nombre AS NombrePersona, Persona.Apellido AS ApellidoPersona FROM $tabla1 INNER JOIN $tabla2 ON Almacen.UsuarioID = Usuario.UsuarioID INNER JOIN $tabla3 ON Usuario.PersonaID = Persona.PersonaID WHERE DATE(Almacen.Fecha) like '%$fechaInicial%' ORDER BY Almacen.AlmacenID DESC");

			$stmt-> execute();

			return $stmt-> fetchAll();


		}else{

			$stmt = Conexion::conectar()->prepare("SELECT Almacen.AlmacenID, date_format(Almacen.Fecha,'%d/%m/%Y') AS Fecha, Almacen.Nombre, Almacen.Descripcion, Almacen.Tipo, Almacen.InsumosID, Almacen.ProductoID, Almacen.Cantidad, Almacen.UsuarioID, Persona.Nombre AS NombrePersona, Persona.Apellido AS ApellidoPersona FROM Almacen INNER JOIN Usuario ON Almacen.UsuarioID = Usuario.UsuarioID INNER JOIN Persona ON Usuario.PersonaID = Persona.PersonaID WHERE DATE(Almacen.Fecha) BETWEEN '$fechaInicial' AND '$fechaFinal' ORDER BY Almacen.AlmacenID DESC");

			$stmt-> execute();

			return $stmt-> fetchAll();


		}

	}





}
