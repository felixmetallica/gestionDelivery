<?php

require_once "conexion.php";

class ModeloPayment{

/*=============================================
        MOSTRAR CONCEPTOS
=============================================*/

    static public function mdlMostrarConceptos($tabla, $item, $valor){

        if($item != null){

        	$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
        	$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();
					

		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

    }

/*=============================================
        MOSTRAR CONCEPTOS LIQUIDAR
=============================================*/

    static public function mdlMostrarConceptosLiquidar($tabla, $item, $valor){

        if($item != null){

        	$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY Tipo ASC");
        	$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();
					

		} else {

			$stmt = Conexion::conectar()->prepare("SELECT Concepto.ConceptoID, Concepto.Codigo, Concepto.Porcentaje, Concepto.Tipo, Concepto.Fijo, Concepto.Descripcion, LiquidacionDetalle.Unidades, LiquidacionDetalle.Total, Liquidacion.Mes, Liquidacion.Anio, Liquidacion.TotalRemunerativos, Liquidacion.TotalNoRemunerativos, Liquidacion.TotalRetenciones, Liquidacion.TotalNeto FROM Liquidacion INNER JOIN LiquidacionDetalle ON Liquidacion.LiquidacionID = LiquidacionDetalle.LiquidacionID INNER JOIN Concepto ON LiquidacionDetalle.ConceptoID = Concepto.ConceptoID WHERE Liquidacion.LiquidacionID = 1");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

    }

/*=============================================
        MOSTRAR CONCEPTOS DE BOLETA
=============================================*/

    static public function mdlMostrarConceptosDeBoleta($tabla1, $tabla2, $tabla3, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT Concepto.ConceptoID, Concepto.Codigo, Concepto.Porcentaje, Concepto.Tipo, Concepto.Fijo, Concepto.Descripcion, LiquidacionDetalle.Unidades, LiquidacionDetalle.Total, Liquidacion.Mes, Liquidacion.Anio, Liquidacion.TotalRemunerativos, Liquidacion.TotalNoRemunerativos, Liquidacion.TotalRetenciones, Liquidacion.TotalNeto FROM $tabla1 INNER JOIN $tabla2 ON Liquidacion.LiquidacionID = LiquidacionDetalle.LiquidacionID INNER JOIN $tabla3 ON LiquidacionDetalle.ConceptoID = Concepto.ConceptoID WHERE Liquidacion.LiquidacionID = :idLiquidacion");

		$stmt -> bindParam(":idLiquidacion", $valor, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetchAll();
		
		$stmt -> close();

		$stmt = null;

	}

/*=============================================
        MOSTRAR TIPOS LIQUIDACION
=============================================*/

    static public function mdlMostrarTipoLiquidacion($tabla, $item, $valor){

        if($item != null){

        	$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
        	$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();
					

		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

    }

/*=============================================
        REGISTRAR CONCEPTO
=============================================*/

	static public function mdlRegistrarConcepto($tabla, $datosModel){

		$link = Conexion::conectar();
		
		$stmt = $link ->prepare("INSERT INTO $tabla (Codigo, Descripcion, Porcentaje, Tipo, Fijo, Unidades) VALUES (:codigo, :descuento, :porcentaje, :tipo, :fijo, :unidades)");
		
		$stmt -> bindParam(":codigo", $datosModel["codigo"], PDO::PARAM_STR);
		$stmt -> bindParam(":descuento", $datosModel["descripcion"], PDO::PARAM_STR);
        $stmt -> bindParam(":porcentaje", $datosModel["porcentaje"], PDO::PARAM_STR);
        $stmt -> bindParam(":tipo", $datosModel["tipo"], PDO::PARAM_STR);
        $stmt -> bindParam(":fijo", $datosModel["fijo"], PDO::PARAM_STR);
        $stmt -> bindParam(":unidades", $datosModel["unidades"], PDO::PARAM_INT);
                
			if($stmt -> execute()){

				return 'ok';

			} else {

				return 'error ';

			}
        
            $stmt->close();

    }

/*=============================================
        EDITAR CONCEPTO
=============================================*/

	static public function mdlEditarConcepto($tabla, $datosModel){

		$link = Conexion::conectar();
		
		$stmt = $link ->prepare("UPDATE $tabla SET Codigo = :codigo, Descripcion = :descripcion, Porcentaje = :porcentaje, Tipo = :tipo, Fijo = :fijo, Unidades = :unidades WHERE ConceptoID = :idConcepto");

		$stmt -> bindParam(":codigo", $datosModel["codigo"], PDO::PARAM_STR);
		$stmt -> bindParam(":descripcion", $datosModel["descripcion"], PDO::PARAM_STR);
        $stmt -> bindParam(":porcentaje", $datosModel["porcentaje"], PDO::PARAM_STR);
        $stmt -> bindParam(":tipo", $datosModel["tipo"], PDO::PARAM_STR);
        $stmt -> bindParam(":fijo", $datosModel["fijo"], PDO::PARAM_STR);
        $stmt -> bindParam(":unidades", $datosModel["unidades"], PDO::PARAM_INT);
        $stmt -> bindParam(":idConcepto", $datosModel["id"], PDO::PARAM_INT);
                
			if($stmt -> execute()){

				return 'ok';

			} else {

				return 'error ';

			}
        
            $stmt->close();

    }

/*=============================================
        ELIMINAR CONCEPTO				  
=============================================*/

	static public function mdlEliminarConcepto($tabla, $valor){

		$link = Conexion::conectar();
		$stmt = $link ->prepare("DELETE FROM $tabla WHERE ConceptoID = :id ");
		$stmt ->bindParam(":id", $valor, PDO::PARAM_INT);

		if ($stmt->execute()) {
	
				return 'ok';
		
			} else{

				return 'error';
		}

	}

/*=============================================
        TRAER CONCEPTOS				      
=============================================*/

	static public function mdlTraerConceptos($tabla){
		
		$stmt = Conexion::conectar()->prepare("SELECT ConceptoID, Descripcion FROM $tabla ORDER BY ConceptoID ASC");
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->close();

	}

/*=============================================
        MEJOR SUELDO				      
=============================================*/

	static public function mdlMejorSueldo($tabla, $idEmpleado){
		
		$stmt = Conexion::conectar()->prepare("SELECT MAX(TotalNeto) AS Sueldo FROM $tabla WHERE EmpleadoID = :idEmpleado AND Estado <> 'Liquidada'  AND Tipo = 1 ORDER BY LiquidacionID DESC LIMIT 6");
		$stmt -> bindParam(":idEmpleado", $idEmpleado, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch();
		$stmt->close();

	}

/*=============================================
        MOSTRAR LIQUIDACION
=============================================*/

    static public function mdlMostrarLiquidacion($tabla, $item, $valor){

        if($item != null){

        	$stmt = Conexion::conectar()->prepare("SELECT Liquidacion.LiquidacionID, Liquidacion.Estado, Liquidacion.Mes, Liquidacion.Anio, date_format(Liquidacion.FechaPago,'%d/%m/%Y') AS FechaPago, date_format(Liquidacion.FechaConfeccion,'%d/%m/%Y') AS FechaConfeccion, date_format(Liquidacion.FechaLiquidacion,'%d/%m/%Y') AS FechaLiquidacion, Liquidacion.TotalRemunerativos, Liquidacion.TotalNoRemunerativos, Liquidacion.TotalRetenciones, Liquidacion.TotalNeto, TipoLiquidacion.Descripcion AS Tipo, TipoLiquidacion.TipoLiquidacionID, Empleado.EmpleadoID, Persona.Nombre, Persona.Apellido FROM `Liquidacion` INNER JOIN TipoLiquidacion ON Liquidacion.Tipo = TipoLiquidacion.TipoLiquidacionID INNER JOIN Empleado ON Liquidacion.EmpleadoID = Empleado.EmpleadoID INNER JOIN Persona ON Empleado.PersonaID = Persona.PersonaID WHERE $item = :$item");
        	$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();
					

		} else {

			$stmt = Conexion::conectar()->prepare("SELECT Liquidacion.LiquidacionID, Liquidacion.Estado, Liquidacion.Mes, Liquidacion.Anio, date_format(Liquidacion.FechaPago,'%d/%m/%Y') AS FechaPago, date_format(Liquidacion.FechaConfeccion,'%d/%m/%Y') AS FechaConfeccion, date_format(Liquidacion.FechaLiquidacion,'%d/%m/%Y') AS FechaLiquidacion, Liquidacion.TotalRemunerativos, Liquidacion.TotalNoRemunerativos, Liquidacion.TotalRetenciones, Liquidacion.TotalNeto, TipoLiquidacion.Descripcion AS Tipo, TipoLiquidacion.TipoLiquidacionID, Empleado.EmpleadoID, Persona.Nombre, Persona.Apellido FROM `Liquidacion` INNER JOIN TipoLiquidacion ON Liquidacion.Tipo = TipoLiquidacion.TipoLiquidacionID INNER JOIN Empleado ON Liquidacion.EmpleadoID = Empleado.EmpleadoID INNER JOIN Persona ON Empleado.PersonaID = Persona.PersonaID ORDER BY Liquidacion.LiquidacionID DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

    }

/*=============================================
        MOSTRAR LIQUIDACIONES CONFECCIONADAS
=============================================*/

    static public function mdlMostrarLiquidacionesConfeccionadas($tabla){

        $stmt = Conexion::conectar()->prepare("SELECT Liquidacion.LiquidacionID, Liquidacion.Estado, Liquidacion.Mes, Liquidacion.Anio, date_format(Liquidacion.FechaPago,'%d/%m/%Y') AS FechaPago, date_format(Liquidacion.FechaConfeccion,'%d/%m/%Y') AS FechaConfeccion, date_format(Liquidacion.FechaLiquidacion,'%d/%m/%Y') AS FechaLiquidacion, Liquidacion.TotalRemunerativos, Liquidacion.TotalNoRemunerativos, Liquidacion.TotalRetenciones, Liquidacion.TotalNeto, TipoLiquidacion.Descripcion AS Tipo, TipoLiquidacion.TipoLiquidacionID, Empleado.EmpleadoID, Persona.Nombre, Persona.Apellido FROM $tabla INNER JOIN TipoLiquidacion ON Liquidacion.Tipo = TipoLiquidacion.TipoLiquidacionID INNER JOIN Empleado ON Liquidacion.EmpleadoID = Empleado.EmpleadoID INNER JOIN Persona ON Empleado.PersonaID = Persona.PersonaID WHERE Liquidacion.Estado = 'C' ORDER BY Liquidacion.LiquidacionID DESC");
        
		$stmt -> execute();

		return $stmt -> fetchAll();
		
		$stmt -> close();

		$stmt = null;

    }

/*=============================================
        REGISTRAR BOLETA LIQUIDACION
=============================================*/

	static public function mdlRegistrarBoleta($tabla, $datosModel){

		$link = Conexion::conectar();
		
		$stmt = $link ->prepare("INSERT INTO $tabla (Tipo, EmpleadoID, Estado, FechaConfeccion, Mes, Anio, TotalRemunerativos, TotalNoRemunerativos, TotalRetenciones, TotalNeto) VALUES (:tipo, :empleadoId, :estado, :fechaConfeccion, :mes, :anio, :totalRemunerativos, :totalNoRemunerativos, :totalRetenciones, :totalNeto)");
		
		$stmt -> bindParam(":tipo", $datosModel["Tipo"], PDO::PARAM_INT);
		$stmt -> bindParam(":empleadoId", $datosModel["EmpleadoID"], PDO::PARAM_INT);
        $stmt -> bindParam(":estado", $datosModel["Estado"], PDO::PARAM_STR);
        $stmt -> bindParam(":fechaConfeccion", $datosModel["FechaConfeccion"], PDO::PARAM_STR);
        $stmt -> bindParam(":mes", $datosModel["Mes"], PDO::PARAM_STR);
        $stmt -> bindParam(":anio", $datosModel["Anio"], PDO::PARAM_STR);
        $stmt -> bindParam(":totalRemunerativos", $datosModel["TotalRemunerativos"], PDO::PARAM_STR);
        $stmt -> bindParam(":totalNoRemunerativos", $datosModel["TotalNoRemunerativos"], PDO::PARAM_STR);
        $stmt -> bindParam(":totalRetenciones", $datosModel["TotalRetenciones"], PDO::PARAM_STR);
        $stmt -> bindParam(":totalNeto", $datosModel["TotalNeto"], PDO::PARAM_STR);
                
			if($stmt -> execute()){

				$liquidacionId = $link->lastInsertId();

				return $liquidacionId;

			} else {

				return 'error ';

			}
        
            $stmt->close();

    }

/*=============================================
        EDITAR BOLETA LIQUIDACION
=============================================*/

	static public function mdlEditarBoleta($tabla, $datosModel){

		$link = Conexion::conectar();
		
		$stmt = $link ->prepare("UPDATE $tabla SET Tipo = :tipo, EmpleadoID = :empleadoId, Estado = :estado, FechaConfeccion = :fechaConfeccion, Mes = :mes, Anio = :anio, TotalRemunerativos = :totalRemunerativos, TotalNoRemunerativos = :totalNoRemunerativos, TotalRetenciones = :totalRetenciones, TotalNeto = :totalNeto WHERE LiquidacionID = :idLiquidacion");
					
		$stmt -> bindParam(":tipo", $datosModel["Tipo"], PDO::PARAM_INT);
		$stmt -> bindParam(":empleadoId", $datosModel["EmpleadoID"], PDO::PARAM_INT);
        $stmt -> bindParam(":estado", $datosModel["Estado"], PDO::PARAM_STR);
        $stmt -> bindParam(":fechaConfeccion", $datosModel["FechaConfeccion"], PDO::PARAM_STR);
        $stmt -> bindParam(":mes", $datosModel["Mes"], PDO::PARAM_STR);
        $stmt -> bindParam(":anio", $datosModel["Anio"], PDO::PARAM_STR);
        $stmt -> bindParam(":totalRemunerativos", $datosModel["TotalRemunerativos"], PDO::PARAM_STR);
        $stmt -> bindParam(":totalNoRemunerativos", $datosModel["TotalNoRemunerativos"], PDO::PARAM_STR);
        $stmt -> bindParam(":totalRetenciones", $datosModel["TotalRetenciones"], PDO::PARAM_STR);
        $stmt -> bindParam(":totalNeto", $datosModel["TotalNeto"], PDO::PARAM_STR);
        $stmt -> bindParam(":idLiquidacion", $datosModel["LiquidacionID"], PDO::PARAM_INT);
                
			if($stmt -> execute()){

				$liquidacionId = $link->lastInsertId();

				return $liquidacionId;

			} else {

				return 'error ';

			}
        
            $stmt->close();

    }

/*=============================================
        REGISTRAR DETALLE BOLETA LIQUIDACION				      
=============================================*/

	static public function mdlRegistrarDetalleLiquidacion($tabla, $idLiquidacion, $conceptoID, $total, $unidades){

		$link = Conexion::conectar();
	    
	    $stmt = $link->prepare("INSERT INTO $tabla (LiquidacionID, ConceptoID, Unidades, Total) VALUES (:liquidacionID, :conceptoId, :unidades, :total)");

	    $stmt->bindParam(":liquidacionID", $idLiquidacion, PDO::PARAM_INT);
	    $stmt->bindParam(":conceptoId", $conceptoID, PDO::PARAM_INT);
	    $stmt->bindParam(":unidades", $unidades, PDO::PARAM_INT);
	    $stmt->bindParam(":total", $total, PDO::PARAM_STR);
	    
	    if ($stmt->execute()) {
			
			return "ok";

		} else {

			return "error";
		}

	}

/*=============================================
        ELIMINAR DETALLE LIQUIDACION				      
=============================================*/

	static public function mdlEliminarDetalleLiquidacion($tablaLiquidacionDetalle, $idLiquidacion){

		$link = Conexion::conectar();
	    
	    $stmt = $link->prepare("DELETE FROM $tablaLiquidacionDetalle WHERE LiquidacionID = :liquidacion");

	    $stmt->bindParam(":liquidacion", $idLiquidacion, PDO::PARAM_INT);
	    
	    
	    if ($stmt->execute()) {
			
			return "ok";

		} else {

			return "error";
		}

	}

/*=============================================
        ELIMINAR LIQUIDACION				      
=============================================*/

	static public function mdlEliminarLiquidacion($tabla, $idLiquidacion){

			$link = Conexion::conectar();
		    
		    $stmt = $link->prepare("DELETE FROM $tabla WHERE LiquidacionID = :liquidacion");

		    $stmt->bindParam(":liquidacion", $idLiquidacion, PDO::PARAM_INT);
		    
		    
		    if ($stmt->execute()) {
				
				return "ok";

			} else {

				return "error";
			}

		}

/*=============================================
        ACTUALIZAR LIQUIDACION
=============================================*/

	static public function mdlActualizarLiquidacion($tabla, $item1, $valor1, $valor2){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE LiquidacionID = :idLiquidacion");
		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":idLiquidacion", $valor2, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt -> close();

		$stmt = null;

	}
}