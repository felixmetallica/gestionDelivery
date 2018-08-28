<?php 

require_once "conexion.php";

class ModeloInsumos{

/*=============================================
        MOSTRAR INSUMOS
=============================================*/

    static public function mdlMostrarInsumos($tabla1, $tabla2, $item, $valor){

        if($item != null){

			if ($item !="RubroID") {
				
				$stmt = Conexion::conectar()->prepare("SELECT Insumos.InsumosID, Insumos.Codigo, Insumos.Nombre, Insumos.Medida, Insumos.StockMinimo, Insumos.Stock, Insumos.PrecioCompra, Rubro.RubroID, Rubro.Nombre AS Rubro FROM $tabla1 INNER JOIN $tabla2 ON Insumos.RubroID = Rubro.RubroID WHERE $item = :$item ORDER BY InsumosID DESC");

				$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

				$stmt -> execute();

				return $stmt -> fetch();

			} else {

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla1 WHERE $item = :$item ORDER BY InsumosID DESC");

				$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

				$stmt -> execute();

				return $stmt -> fetch();

			}
			

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT Insumos.InsumosID, Insumos.Codigo, Insumos.Nombre, Insumos.Medida, Insumos.StockMinimo, Insumos.Stock, Insumos.PrecioCompra, Rubro.Nombre AS Rubro FROM $tabla1 INNER JOIN $tabla2 ON Insumos.RubroID = Rubro.RubroID ORDER BY Insumos.InsumosID ASC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

    }

/*=============================================
        MOSTRAR INSUMOS/PRODUCTOS COMPRA
=============================================*/

    static public function mdlMostrarInsumosCompra($tabla1, $tabla2, $item, $valor){

        if($item != null){

        	$stmt = Conexion::conectar()->prepare("SELECT Insumos.InsumosID AS Id, Insumos.Codigo, Insumos.Nombre, Insumos.Medida, CompraDetalle.Cantidad, CompraDetalle.PrecioUnitario, 'Insumo' AS Tipo FROM $tabla1 INNER JOIN CompraDetalle ON CompraDetalle.InsumosID = Insumos.InsumosID WHERE $item = :$item UNION ALL SELECT Producto.ProductoID AS Id, Producto.Codigo, Producto.Nombre,'Unidades' AS Medida, CompraDetalle.Cantidad, CompraDetalle.PrecioUnitario, 'Producto' AS Tipo FROM $tabla2 INNER JOIN CompraDetalle ON CompraDetalle.ProductoID = Producto.ProductoID WHERE $item = :$item ORDER BY 'Nombre'");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();


        } else {

        	$stmt = Conexion::conectar()->prepare("SELECT Insumos.InsumosID AS Id, Insumos.Codigo, Insumos.Nombre, 'Insumo' AS Tipo FROM $tabla1 UNION ALL SELECT Producto.ProductoID AS Id, Producto.Codigo, Producto.Nombre, 'Producto' AS Tipo FROM $tabla2 WHERE Producto.Tipo = 'Entero' AND Producto.Activo = 'S' ORDER BY 'Nombre'");

			$stmt -> execute();

			return $stmt -> fetchAll();

        }
	

    }

/*=============================================
        MOSTRAR INSUMOS DISPONIBLES
=============================================*/

    static public function mdlMostrarInsumosDisponibles($tabla1, $tabla2){

		$stmt = Conexion::conectar()->prepare("SELECT Insumos.InsumosID, Insumos.Codigo, Insumos.Nombre, Insumos.Nombre, Insumos.PrecioCompra, Insumos.Medida, Insumos.Stock, Insumos.StockMinimo, Rubro.RubroID, Rubro.Nombre AS Rubro FROM $tabla1 INNER JOIN $tabla2 ON Insumos.RubroID = Rubro.RubroID");

		$stmt -> execute();

		return $stmt -> fetchAll();
		
		$stmt -> close();

		$stmt = null;

    }

/*=============================================
        LISTADO DE RUBROS            
=============================================*/

	static public function mdlListarRubros($tabla){
		
		$stmt = Conexion::conectar()->prepare("SELECT RubroID, Nombre FROM $tabla WHERE Tipo = 'Insumo' ORDER BY RubroID ASC");
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->close();

	}

/*=============================================
        LISTADO DE INSUMOS            
=============================================*/

	static public function mdlListarInsumos($tabla){
		
		$stmt = Conexion::conectar()->prepare("SELECT InsumosID, Nombre FROM $tabla ORDER BY InsumosID ASC");
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->close();

	}

/*=============================================
        REGISTRAR INSUMO
=============================================*/

	static public function mdlRegistrarInsumo($tabla, $datosModel){

		$link = Conexion::conectar();

		var_dump($datosModel);

		$stmt = $link ->prepare("INSERT INTO $tabla (Codigo, Nombre, Medida, StockMinimo, PrecioCompra, RubroID) VALUES (:codigo, :nombre, :medida, :stock, :precio, :rubro)");
		

		$stmt -> bindParam(":codigo", $datosModel["codigo"], PDO::PARAM_STR);
		$stmt -> bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":medida", $datosModel["medida"], PDO::PARAM_STR);
		$stmt -> bindParam(":stock", $datosModel["sMinimo"], PDO::PARAM_INT);
        $stmt -> bindParam(":precio", $datosModel["precio"], PDO::PARAM_STR);
        $stmt -> bindParam(":rubro", $datosModel["rubro"], PDO::PARAM_INT);

        var_dump($stmt);

			if($stmt -> execute()){

				return 'ok';

			} else {

				return 'error ';

			}

            $stmt->close();
            $stmt = null;

    }

/*=============================================
        EDITAR INSUMO
=============================================*/

	static public function mdlEditarInsumo($tabla, $datosModel){

		$link = Conexion::conectar();

		$stmt = $link ->prepare("UPDATE $tabla SET Nombre = :nombre, Medida = :medida, StockMinimo = :stock, PrecioCompra = :precio, RubroID = :rubro WHERE InsumosID = :idInsumo");

		
		$stmt -> bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":medida", $datosModel["medida"], PDO::PARAM_STR);
        $stmt -> bindParam(":stock", $datosModel["sMinimo"], PDO::PARAM_INT);
        $stmt -> bindParam(":precio", $datosModel["precio"], PDO::PARAM_INT);
        $stmt -> bindParam(":rubro", $datosModel["rubro"], PDO::PARAM_INT);
        $stmt -> bindParam(":idInsumo", $datosModel["idInsumo"], PDO::PARAM_INT);

			if($stmt -> execute()){

				return 'ok';

			} else {

				return 'error ';

			}
            $stmt->close();

    }

/*=============================================
        ELIMINAR INSUMO
=============================================*/

	static public function mdlEliminarInsumo($tabla, $datosModel){

		$link = Conexion::conectar();
		$stmt = $link ->prepare("DELETE FROM $tabla WHERE InsumosID = :idInsumo");
		$stmt -> bindParam(":idInsumo", $datosModel, PDO::PARAM_INT);

			if($stmt -> execute()){

				return 'ok';

			} else {

				return 'error';

			}

            $stmt->close();

    }

/*=============================================
        ACTUALIZAR INSUMO
=============================================*/

	static public function mdlActualizarInsumo($tabla, $item1, $valor1, $valor2){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE InsumosID = :idinsumo");
		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":idinsumo", $valor2, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt -> close();

		$stmt = null;

	}


}