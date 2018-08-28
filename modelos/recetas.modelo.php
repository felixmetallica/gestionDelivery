<?php 

require_once "conexion.php";

class ModeloRecetas{

/*=============================================
        MOSTRAR RECETAS
=============================================*/

    static public function mdlMostrarRecetas($tabla1, $tabla2, $item, $valor){

        if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT Receta.RecetaID, Producto.ProductoID, Producto.Nombre, Producto.Imagen FROM $tabla1 INNER JOIN $tabla2 ON Receta.ProductoID = Producto.ProductoID WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		} else {

			//CARGO LA TABLA RECETA COMPLETA

			$stmt = Conexion::conectar()->prepare("SELECT Receta.RecetaID, Producto.ProductoID, Producto.Nombre FROM $tabla1 INNER JOIN $tabla2 ON Receta.ProductoID = Producto.ProductoID ORDER BY RecetaID DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

    }

/*=============================================
        REGISTRAR RECETA				      
=============================================*/

	static public function mdlRegistrarReceta($tabla, $producto){
		
		$link = Conexion::conectar();
		$stmt = $link->prepare("INSERT INTO $tabla (ProductoID) VALUES (:producto)");

		$stmt->bindParam(":producto", $producto, PDO::PARAM_INT);
						
		if ($stmt->execute()) {
			
			$venta = $link->lastInsertId();

			return $venta;

		} else {

			return "error";
		}

	}

/*=============================================
        REGISTRAR DETALLE RECETA				      
=============================================*/

	static public function mdlRegistrarDetalleReceta($tabla, $idReceta, $idInsumo, $Cantidad){

		$link = Conexion::conectar();
	    
	    $stmt = $link->prepare("INSERT INTO $tabla (RecetaID, InsumosID, Cantidad) VALUES (:receta, :insumoId, :cantidad)");

	    $stmt->bindParam(":receta", $idReceta, PDO::PARAM_INT);
	    $stmt->bindParam(":insumoId", $idInsumo, PDO::PARAM_INT);
	    $stmt->bindParam(":cantidad", $Cantidad, PDO::PARAM_INT);
	    	    
	    if ($stmt->execute()) {
			
			return "ok";

		} else {

			return "error";
		}

	}

/*=============================================
		LISTADO DE INSUMOS DE RECETA 		  
=============================================*/

	static public function mdlListadoInsumos($tabla1, $tabla2, $tabla3, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT Receta.RecetaID, Receta.ProductoID, RecetaDetalle.InsumosID, RecetaDetalle.Cantidad, Insumos.Nombre, Insumos.Medida FROM $tabla1 INNER JOIN $tabla2 ON Receta.RecetaID = RecetaDetalle.RecetaID INNER JOIN $tabla3 ON RecetaDetalle.InsumosID = Insumos.InsumosID WHERE Receta.RecetaID = :item");
		
		$stmt->bindParam(":item", $valor, PDO::PARAM_INT);
		
		$stmt->execute();
		
		return $stmt->fetchAll();
		
		$stmt->close();


	}

/*=============================================
        ELIMINAR DETALLE RECETA				      
=============================================*/

	static public function mdlEliminarDetalleReceta($tabla, $idReceta){

		$link = Conexion::conectar();
	    
	    $stmt = $link->prepare("DELETE FROM $tabla WHERE RecetaID = :receta");

	    $stmt->bindParam(":receta", $idReceta, PDO::PARAM_INT);
	    
	    
	    if ($stmt->execute()) {
			
			return "ok";

		} else {

			return "error";
		}

	}

/*=============================================
        ELIMINAR RECETA				      
=============================================*/

	static public function mdlEliminarReceta($tabla, $idReceta){

			$link = Conexion::conectar();
		    
		    $stmt = $link->prepare("DELETE FROM $tabla WHERE RecetaID = :receta");

		    $stmt->bindParam(":receta", $idReceta, PDO::PARAM_INT);
		    
		    
		    if ($stmt->execute()) {
				
				return "ok";

			} else {

				return "error";
			}

		}


}