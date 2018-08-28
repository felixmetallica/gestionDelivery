<?php

require_once "conexion.php";

class ModeloProductos{

/*=============================================
        MOSTRAR PRODUCTOS
=============================================*/

    static public function mdlMostrarProductos($tabla1, $tabla2, $item, $valor, $orden){

        if($item != null){

			       if ($item !="RubroID") {

				           $stmt = Conexion::conectar()->prepare("SELECT Producto.ProductoID, Producto.Tipo, Producto.Ventas, Producto.Imagen, Producto.Codigo, Producto.Nombre, Producto.PrecioVenta, Producto.Activo, Producto.PrecioCompra, Producto.Stock, Producto.StockMinimo, Producto.RestaStock, Rubro.RubroID , Rubro.Nombre AS Rubro, Producto.Tipo FROM $tabla1 INNER JOIN $tabla2 ON Producto.RubroID = Rubro.RubroID WHERE $item = :$item ORDER BY $orden DESC");

				           $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

				           $stmt -> execute();

				           return $stmt -> fetch();

			       } else {

				           //LO UTILIZO PARA GENERAR EL CODIGO DEL PRODUCTO

				           $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla1 WHERE $item = :$item ORDER BY $orden DESC");

				           $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

				           $stmt -> execute();

				           return $stmt -> fetch();

			        }


		}else{

			//CARGO LA TABLA PRODUCTOS COMPLETA

			$stmt = Conexion::conectar()->prepare("SELECT Producto.ProductoID, Producto.Ventas, Producto.Imagen, Producto.Codigo, Producto.Nombre, Producto.PrecioVenta, Producto.PrecioCompra, Producto.Activo, Producto.Stock, Rubro.Nombre AS Rubro, Producto.Tipo FROM $tabla1 INNER JOIN $tabla2 ON Producto.RubroID = Rubro.RubroID ORDER BY $orden DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

    }

/*=============================================
        MOSTRAR PRODUCTOS DISPONIBLES
=============================================*/

    static public function mdlMostrarProductosDisponibles($tabla1, $tabla2){

		$stmt = Conexion::conectar()->prepare("SELECT Producto.ProductoID, Producto.Imagen, Producto.Codigo, Producto.Nombre, Producto.PrecioVenta, Producto.Activo, Producto.Stock, Rubro.Nombre AS Rubro FROM $tabla1 INNER JOIN $tabla2 ON Producto.RubroID = Rubro.RubroID WHERE Producto.Activo = 'S' ORDER BY Producto.ProductoID ASC");

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;

    }

/*=============================================
        LISTAR PRODUCTOS
=============================================*/

    static public function mdlListarProductos($tabla1, $tabla2, $item, $valor, $orden){

        if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT Producto.ProductoID, Producto.Ventas, Producto.Imagen, Producto.Codigo, Producto.Nombre, Producto.PrecioVenta, Producto.Activo, Rubro.RubroID , Rubro.Nombre AS Rubro FROM $tabla1 INNER JOIN $tabla2 ON Producto.RubroID = Rubro.RubroID WHERE $item = :$item ORDER BY $orden DESC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		} else {

			//CARGO LA TABLA PRODUCTOS COMPLETA

			$stmt = Conexion::conectar()->prepare("SELECT Producto.ProductoID, Producto.Ventas, Producto.Imagen, Producto.Codigo, Producto.Nombre, Producto.PrecioVenta, Producto.Activo, Rubro.Nombre AS Rubro FROM $tabla1 INNER JOIN $tabla2 ON Producto.RubroID = Rubro.RubroID ORDER BY $orden DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

    }

/*=============================================
        LISTADO DE RUBROS
=============================================*/

	static public function mdlListarRubros($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT RubroID, Nombre FROM $tabla WHERE Tipo = 'Producto' ORDER BY RubroID ASC");
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->close();

	}

/*=============================================
        LISTADO DE PRODUCTOS RECETAS
=============================================*/

	static public function mdlListarProductosReceta($tabla1, $tabla2){

		$stmt = Conexion::conectar()->prepare("SELECT Producto.ProductoID, Producto.Nombre FROM $tabla1 LEFT JOIN $tabla2 ON Receta.ProductoID = Producto.ProductoID WHERE Receta.ProductoID IS NULL AND Producto.Tipo = 'Compuesto'");
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->close();

	}

/*=============================================
        REGISTRAR PRODUCTO
=============================================*/

	static public function mdlRegistrarProducto($tabla, $datosModel){

		$link = Conexion::conectar();

		$activo = "S";

		$stmt = $link ->prepare("INSERT INTO $tabla (Codigo, Nombre, Imagen, PrecioVenta, PrecioCompra, Activo, RubroID, Tipo, StockMinimo, RestaStock) VALUES (:codigo, :nombre, :imagen, :precio, :precioCompra, :activo, :rubro, :tipo, :stockMinimo, :restaStock)");
		$stmt -> bindParam(":codigo", $datosModel["codigo"], PDO::PARAM_INT);
		$stmt -> bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":imagen", $datosModel["imagen"], PDO::PARAM_STR);
        $stmt -> bindParam(":precio", $datosModel["precio"], PDO::PARAM_STR);
        $stmt -> bindParam(":precioCompra", $datosModel["precioCompra"], PDO::PARAM_STR);
        $stmt -> bindParam(":activo", $activo, PDO::PARAM_STR);
        $stmt -> bindParam(":rubro", $datosModel["rubro"], PDO::PARAM_INT);
        $stmt -> bindParam(":tipo", $datosModel["tipo"], PDO::PARAM_STR);
        $stmt -> bindParam(":stockMinimo", $datosModel["stockMinimo"], PDO::PARAM_INT);
        $stmt -> bindParam(":restaStock", $datosModel["afectaStock"], PDO::PARAM_STR);

			if($stmt -> execute()){

				return 'ok';

			} else {

				return 'error ';

			}

            $stmt->close();
            $stmt = null;

    }

/*=============================================
        EDITAR PRODUCTO
=============================================*/

	static public function mdlEditarProducto($datosModel, $tabla){

		$link = Conexion::conectar();

		$stmt = $link ->prepare("UPDATE $tabla SET Nombre = :nombre, Imagen = :imagen, PrecioVenta = :precio, PrecioCompra = :precioCompra, Tipo = :tipo, StockMinimo = :stockMinimo, RestaStock = :restaStock WHERE ProductoID = :idProducto");

		$stmt -> bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":imagen", $datosModel["imagen"], PDO::PARAM_STR);
        $stmt -> bindParam(":precio", $datosModel["precio"], PDO::PARAM_STR);
        $stmt -> bindParam(":precioCompra", $datosModel["precioCompra"], PDO::PARAM_STR);
        $stmt -> bindParam(":tipo", $datosModel["tipo"], PDO::PARAM_STR);
        $stmt -> bindParam(":stockMinimo", $datosModel["stockMinimo"], PDO::PARAM_INT);
        $stmt -> bindParam(":restaStock", $datosModel["afectaStock"], PDO::PARAM_STR);
        $stmt -> bindParam(":idProducto", $datosModel["idProducto"], PDO::PARAM_INT);

			if($stmt -> execute()){

				return 'ok';

			} else {

				return 'error ';

			}
            $stmt->close();

    }

/*=============================================
        ELIMINAR PRODUCTO
=============================================*/

	static public function mdlEliminarProducto($tabla, $datosModel){

		$link = Conexion::conectar();
		$stmt = $link ->prepare("DELETE FROM $tabla WHERE ProductoID = :idProducto");
		$stmt -> bindParam(":idProducto", $datosModel["idProducto"], PDO::PARAM_INT);

			if($stmt -> execute()){

				return 'ok';

			} else {

				return 'error';

			}

            $stmt->close();

    }

/*=============================================
        ACTIVAR PRODUCTO
=============================================*/

	static public function mdlActivarProducto($tabla, $item1, $valor1, $item2, $valor2){

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
        ACTUALIZAR PRODUCTO
=============================================*/

	static public function mdlActualizarProducto($tabla, $item1, $valor1, $valor2){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE ProductoID = :idproducto");
		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":idproducto", $valor2, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt -> close();

		$stmt = null;

	}

/*=============================================
        MOSTRAR SUMA VENTAS
=============================================*/

    static public function mdlMostrarSumaVentas($tabla){

        $stmt = Conexion::conectar()->prepare("SELECT SUM(Ventas) AS total FROM $tabla");

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

    }

/*=============================================
        MOSTRAR RECETA PRODUCTO
=============================================*/

    static public function mdlMostrarRecetaProducto($tabla1, $tabla2, $tabla3, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT Producto.Nombre, Insumos.InsumosID, Insumos.Nombre AS Insumo, RecetaDetalle.Cantidad FROM $tabla1 INNER JOIN $tabla2 ON Receta.ProductoID = Producto.ProductoID INNER JOIN $tabla3 ON Receta.RecetaID = RecetaDetalle.RecetaID INNER JOIN Insumos ON RecetaDetalle.InsumosID = Insumos.InsumosID WHERE Producto.ProductoID = :item");

		$stmt -> bindParam(":item", $valor, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;

    }



}
