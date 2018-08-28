<?php 

require_once "conexion.php";

class ModeloCompras{

/*=============================================
			MOSTRAR COMPRAS   		  
=============================================*/

	static public function mdlMostrarCompras($tabla, $item, $valor){

		if ($item != null) {
			
			$stmt = Conexion::conectar()->prepare("SELECT Compra.CompraID, Compra.Nota, Compra.MotivoAnula, Compra.MedioPagoID, date_format(Compra.Fecha, '%d/%m/%Y') AS fechaFormateada, Compra.UsuarioRegistraID, Compra.NroCompra, Compra.Impuesto, Compra.Neto, Compra.Estado, Compra.Total, Proveedor.ProveedorID, Proveedor.RazonSocial, Usuario.UsuarioID, Usuario.NombreUsuario, Persona.PersonaID, Persona.Nombre, Persona.Apellido FROM $tabla INNER JOIN Proveedor ON Compra.ProveedorID = Proveedor.ProveedorID INNER JOIN Usuario ON Compra.UsuarioRegistraID = Usuario.UsuarioID INNER JOIN Persona ON Usuario.PersonaID = Persona.PersonaID  WHERE $item = :$item ORDER BY CompraID ASC");

			$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetch();
		
		} else {

			$stmt = Conexion::conectar()->prepare("SELECT Compra.CompraID, Compra.UsuarioAnulaID, Compra.Nota, Compra.Impuesto, Compra.MedioPagoID, Compra.Fecha, date_format(Compra.Fecha, '%d/%m/%Y') AS fechaFormateada, Compra.NroCompra, Compra.Estado, Compra.Total, Compra.Neto, Proveedor.ProveedorID, Proveedor.RazonSocial, Usuario.UsuarioID, Usuario.NombreUsuario, Persona.PersonaID, Persona.Nombre, Persona.Apellido, MedioPago.MedioPagoID, MedioPago.Nombre AS MDP FROM Compra INNER JOIN Proveedor ON Compra.ProveedorID = Proveedor.ProveedorID INNER JOIN Usuario ON Compra.UsuarioRegistraID = Usuario.UsuarioID INNER JOIN Persona ON Usuario.PersonaID = Persona.PersonaID INNER JOIN MedioPago ON Compra.MedioPagoID = MedioPago.MedioPagoID ORDER BY Compra.CompraID DESC");

			$stmt-> execute();

			return $stmt-> fetchAll();
		}


	}

/*=============================================
            TRAER MEDIOS DE PAGO				      
=============================================*/

	static public function mdlTraerMediosPagos($tabla){
		
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY MedioPagoID ASC");
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->close();

	}

/*=============================================
            REGISTRAR COMPRA				      
=============================================*/

	static public function mdlRegistrarCompra($tabla, $datos){
		
		date_default_timezone_set("America/Argentina/Tucuman");
		$fechaCompraTemp = date('Y-m-d');
		$hora = date('H:i:s');
		$fechaCompraOK = $fechaCompraTemp.' '.$hora;
		$puntoVenta = 2;
		$estado = "Registrada";
		$nota = "N";

		$link = Conexion::conectar();
		$stmt = $link->prepare("INSERT INTO $tabla (ProveedorID, UsuarioRegistraID, Fecha, NroCompra, MedioPagoID, Nota, Estado, Impuesto, Neto, Total) VALUES (:proveedor, :usuario, :fecha, :orden, :medio, :nota, :estado, :impuesto, :neto, :total)");

		$stmt->bindParam(":proveedor", $datos["ProveedorID"], PDO::PARAM_INT);
		$stmt->bindParam(":usuario", $datos["UsuarioRegistraID"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha", $fechaCompraOK, PDO::PARAM_STR);
		$stmt->bindParam(":orden", $datos["NroCompra"], PDO::PARAM_STR);
		$stmt->bindParam(":medio", $datos["MedioPagoID"], PDO::PARAM_INT);
		$stmt->bindParam(":nota", $nota, PDO::PARAM_STR);
		$stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
		$stmt->bindParam(":impuesto", $datos["MontoImpuesto"], PDO::PARAM_STR);
		$stmt->bindParam(":neto", $datos["Neto"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["Total"], PDO::PARAM_STR);
		
					
		if ($stmt->execute()) {
			
			$compra = $link->lastInsertId();

			return $compra;

		} else {

			return "error";
		}

	}

/*=============================================
            REGISTRAR DETALLE COMPRA				      
=============================================*/

	static public function mdlRegistrarDetalleCompra($tabla, $idCompra, $idInsumo, $idProducto, $Cantidad, $Precio){

		$link = Conexion::conectar();
	    
	    $stmt = $link->prepare("INSERT INTO $tabla (CompraID, InsumosID, ProductoID, Cantidad, PrecioUnitario) VALUES (:compra, :insumoId, :productoId, :cantidad, :precio)");

	    $stmt->bindParam(":compra", $idCompra, PDO::PARAM_INT);
	    $stmt->bindParam(":insumoId", $idInsumo, PDO::PARAM_INT);
	    $stmt->bindParam(":productoId", $idProducto, PDO::PARAM_INT);
	    $stmt->bindParam(":cantidad", $Cantidad, PDO::PARAM_INT);
	    $stmt->bindParam(":precio", $Precio, PDO::PARAM_STR);
	    
	    if ($stmt->execute()) {
			
			return "ok";

		} else {

			return "error";
		}

	}

/*=============================================
            EDITAR COMPRA				      
=============================================*/

	static public function mdlEditarCompra($tabla, $datos){
		
		date_default_timezone_set("America/Argentina/Tucuman");
		$fechaCompraTemp = date('Y-m-d');
		$hora = date('H:i:s');
		$fechaCompraOK = $fechaCompraTemp.' '.$hora;
				
		$link = Conexion::conectar();
		$stmt = $link->prepare("UPDATE $tabla SET ProveedorID = :proveedor, UsuarioRegistraID = :usuario, Fecha = :fecha, NroCompra = :compra, MedioPagoID = :medio, Impuesto = :impuesto, Neto = :neto, Total = :total WHERE CompraID = :compraId");

		
		$stmt->bindParam(":proveedor", $datos["ProveedorID"], PDO::PARAM_INT);
		$stmt->bindParam(":usuario", $datos["UsuarioRegistraID"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha", $fechaCompraOK, PDO::PARAM_STR);
		$stmt->bindParam(":compra", $datos["NroCompra"], PDO::PARAM_STR);
		$stmt->bindParam(":medio", $datos["MedioPagoID"], PDO::PARAM_INT);
		$stmt->bindParam(":impuesto", $datos["Impuesto"], PDO::PARAM_STR);
		$stmt->bindParam(":neto", $datos["Neto"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["Total"], PDO::PARAM_STR);
		$stmt->bindParam(":compraId", $datos["CompraID"], PDO::PARAM_INT);

		if ($stmt->execute()) {
			
			return "ok";

		} else {

			return "error";
		}

	}

/*=============================================
            ELIMINAR DETALLE COMPRA				      
=============================================*/

	static public function mdlEliminarDetalleCompra($tabla, $idCompra){

		$link = Conexion::conectar();
	    
	    $stmt = $link->prepare("DELETE FROM $tabla WHERE CompraID = :compra");

	    $stmt->bindParam(":compra", $idCompra, PDO::PARAM_INT);
	    
	    
	    if ($stmt->execute()) {
			
			return "ok";

		} else {

			return "error";
		}

	}

/*=============================================
            ANULAR COMPRA				      
=============================================*/

	static public function mdlAnularCompra($tabla, $datos){

		date_default_timezone_set("America/Argentina/Tucuman");
		$fechaAnulaCompraTemp = date('Y-m-d');
		$hora = date('H:i:s');
		$fechaAnulaVentaOK = $fechaAnulaCompraTemp.' '.$hora;
		$estado = "Z";
				
		$link = Conexion::conectar();
		$stmt = $link->prepare("UPDATE $tabla SET Estado = :estado, UsuarioAnulaID = :userId, FechaAnula = :fecha, MotivoAnula = :motivo WHERE CompraID = :compraId");

		$stmt->bindParam(":compraId", $datos["compraID"], PDO::PARAM_INT);
		$stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
		$stmt->bindParam(":userId", $datos["UsuarioAnulaID"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha", $fechaAnulaVentaOK, PDO::PARAM_STR);
		$stmt->bindParam(":motivo", $datos["motivo"], PDO::PARAM_INT);
								
		if ($stmt->execute()) {
			
			return "ok";

		} else {

			return "error";
		}		

		
	}

/*=============================================
			RANGO DE FECHAS  		  
=============================================*/

	static public function mdlRangoFechaCompras($tabla, $fechaInicial, $fechaFinal){

		if ($fechaInicial == null) {
			
			$stmt = Conexion::conectar()->prepare("SELECT Compra.CompraID, Compra.UsuarioAnulaID, Compra.Nota, Compra.Impuesto, Compra.MedioPagoID, Compra.Fecha, date_format(Compra.Fecha, '%d/%m/%Y') AS fechaFormateada, Compra.NroCompra, Compra.Estado, Compra.Total, Compra.Neto, Proveedor.ProveedorID, Proveedor.RazonSocial, Usuario.UsuarioID, Usuario.NombreUsuario, Persona.PersonaID, Persona.Nombre, Persona.Apellido, MedioPago.MedioPagoID, MedioPago.Nombre AS MDP FROM Compra INNER JOIN Proveedor ON Compra.ProveedorID = Proveedor.ProveedorID INNER JOIN Usuario ON Compra.UsuarioRegistraID = Usuario.UsuarioID INNER JOIN Persona ON Usuario.PersonaID = Persona.PersonaID INNER JOIN MedioPago ON Compra.MedioPagoID = MedioPago.MedioPagoID ORDER BY Compra.CompraID DESC");

			$stmt-> execute();

			return $stmt-> fetchAll();

		} elseif ($fechaInicial == $fechaFinal) {
			
			$stmt = Conexion::conectar()->prepare("SELECT Compra.CompraID, Compra.UsuarioAnulaID, Compra.Nota, Compra.Impuesto, Compra.MedioPagoID, Compra.Fecha, date_format(Compra.Fecha, '%d/%m/%Y') AS fechaFormateada, Compra.NroCompra, Compra.Estado, Compra.Total, Compra.Neto, Proveedor.ProveedorID, Proveedor.RazonSocial, Usuario.UsuarioID, Usuario.NombreUsuario, Persona.PersonaID, Persona.Nombre, Persona.Apellido, MedioPago.MedioPagoID, MedioPago.Nombre AS MDP FROM Compra INNER JOIN Proveedor ON Compra.ProveedorID = Proveedor.ProveedorID INNER JOIN Usuario ON Compra.UsuarioRegistraID = Usuario.UsuarioID INNER JOIN Persona ON Usuario.PersonaID = Persona.PersonaID INNER JOIN MedioPago ON Compra.MedioPagoID = MedioPago.MedioPagoID WHERE DATE(Compra.Fecha) like '%$fechaInicial%' ORDER BY Compra.CompraID DESC");

			$stmt-> execute();

			return $stmt-> fetchAll();



		}else{

			$stmt = Conexion::conectar()->prepare("SELECT Compra.CompraID, Compra.UsuarioAnulaID, Compra.Nota, Compra.Impuesto, Compra.MedioPagoID, Compra.Fecha, date_format(Compra.Fecha, '%d/%m/%Y') AS fechaFormateada, Compra.NroCompra, Compra.Estado, Compra.Total, Compra.Neto, Proveedor.ProveedorID, Proveedor.RazonSocial, Usuario.UsuarioID, Usuario.NombreUsuario, Persona.PersonaID, Persona.Nombre, Persona.Apellido, MedioPago.MedioPagoID, MedioPago.Nombre AS MDP FROM Compra INNER JOIN Proveedor ON Compra.ProveedorID = Proveedor.ProveedorID INNER JOIN Usuario ON Compra.UsuarioRegistraID = Usuario.UsuarioID INNER JOIN Persona ON Usuario.PersonaID = Persona.PersonaID INNER JOIN MedioPago ON Compra.MedioPagoID = MedioPago.MedioPagoID WHERE DATE(Compra.Fecha) BETWEEN '$fechaInicial' AND '$fechaFinal' ORDER BY Compra.CompraID DESC");

			$stmt-> execute();

			return $stmt-> fetchAll();


		}



	}

/*=============================================
		RANGO DE FECHAS GRAFICO		  
=============================================*/

	static public function mdlRangoFechaComprasGrafico($tabla, $fechaInicial, $fechaFinal){

		
			$stmt = Conexion::conectar()->prepare("SELECT DATE_FORMAT(Fecha, '%Y-%m') AS Periodo, ROUND(SUM(Total),2) AS TotalCompras FROM $tabla WHERE Estado <> 'Z' AND CONVERT(Fecha, DATE) BETWEEN  CAST('$fechaInicial' AS DATE) AND CAST('$fechaFinal' AS DATE) GROUP BY EXTRACT(YEAR FROM Fecha), EXTRACT(MONTH FROM Fecha) ORDER BY Fecha");

			
			$stmt-> execute();

			return $stmt-> fetchAll();

		
		}

/*=============================================
			LISTADO DE INSUMOS   		  
=============================================*/

	static public function mdlListadoInsumos($tabla1, $tabla2, $tabla3, $idCompra){

		$stmt = Conexion::conectar()->prepare("SELECT Compra.CompraID, CompraDetalle.CompraID, CompraDetalle.InsumosID, CompraDetalle.Cantidad, CompraDetalle.PrecioUnitario, Insumos.Nombre, Insumos.Stock, Insumos.Codigo, Insumos.Medida FROM $tabla1 INNER JOIN $tabla2 ON CompraDetalle.CompraID = Compra.CompraID INNER JOIN $tabla3 ON CompraDetalle.InsumosID = Insumos.InsumosID WHERE Compra.CompraID = :idCompra");
		$stmt->bindParam(":idCompra", $idCompra, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->close();


	}

/*=============================================
			LISTADO DE DE COMPRA   		  
=============================================*/

	static public function mdlListadoCompra($tabla, $idCompra){

		$stmt = Conexion::conectar()->prepare("SELECT InsumosID, ProductoID, Cantidad FROM $tabla WHERE CompraID = :idCompra");
		$stmt->bindParam(":idCompra", $idCompra, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->close();


	}

/*=============================================
            TIPO DE NOTA				      
=============================================*/

	static public function mdlTipoNota($tabla, $compra, $tipo){
		
		$link = Conexion::conectar();
		$stmt = $link->prepare("UPDATE $tabla SET Nota = :tipo WHERE CompraID = :compraId");

		$stmt->bindParam(":tipo", $tipo, PDO::PARAM_STR);
		$stmt->bindParam(":compraId", $compra, PDO::PARAM_INT);
						
		if ($stmt->execute()) {
			
			return 'ok';

		} else {

			return "error";
		}

	}


}