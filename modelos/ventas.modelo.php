<?php 

require_once "conexion.php";

class ModeloVentas{

/*=============================================
		MOSTRAR VENTAS   		  
=============================================*/

	static public function mdlMostrarVentas($tabla, $item, $valor){

		if ($item != null) {
			
			$stmt = Conexion::conectar()->prepare("SELECT Venta.VentaID, Venta.UsuarioRegistraID, Venta.UsuarioCancelaID, Venta.ClienteID, Venta.PuntoVentaID, Venta.FechaVenta, date_format(Venta.FechaVenta, '%d/%m/%Y') AS fechaFormateada, Venta.Estado, Venta.MedioPagoID, Venta.CodTransaccion, Venta.MotivoCancela, Venta.MontoDescuento, Venta.MontoRecargo, Venta.NroFactura, Venta.FacturaTipo, Venta.Neto, Venta.Total, Usuario.UsuarioID, Usuario.PersonaID, Usuario.NombreUsuario, Persona.Nombre, Persona.Apellido, Cliente.ClienteID, PersonaC.PersonaID AS PersonaCID, PersonaC.Nombre AS NombreC, PersonaC.Apellido AS ApellidoC, MedioPago.MedioPagoID, MedioPago.Nombre AS MDP FROM $tabla INNER JOIN Usuario ON Venta.UsuarioRegistraID = Usuario.UsuarioID INNER JOIN Persona ON Usuario.PersonaID = Persona.PersonaID INNER JOIN Cliente ON Venta.ClienteID = Cliente.ClienteID INNER JOIN Persona AS PersonaC ON Cliente.PersonaID = PersonaC.PersonaID INNER JOIN MedioPago ON Venta.MedioPagoID = MedioPago.MedioPagoID  WHERE $item = :$item ORDER BY VentaID ASC");

			$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetch();
		
		} else {

			$stmt = Conexion::conectar()->prepare("SELECT Venta.VentaID, Venta.UsuarioRegistraID, Venta.ClienteID, Venta.PuntoVentaID, Venta.FechaVenta, date_format(Venta.FechaVenta, '%d/%m/%Y') AS fechaFormateada, Venta.Estado, Venta.MedioPagoID, Venta.CodTransaccion, Venta.MontoDescuento, Venta.MontoRecargo, Venta.UsuarioCancelaID, Venta.NroFactura, Venta.FacturaTipo, Venta.Neto, Venta.Total, Usuario.UsuarioID, Usuario.PersonaID, Usuario.NombreUsuario, Persona.Nombre, Persona.Apellido, Cliente.ClienteID, PersonaC.PersonaID AS PersonaCID, PersonaC.Nombre AS NombreC, PersonaC.Apellido AS ApellidoC, MedioPago.MedioPagoID, MedioPago.Nombre AS MDP FROM $tabla INNER JOIN Usuario ON Venta.UsuarioRegistraID = Usuario.UsuarioID INNER JOIN Persona ON Usuario.PersonaID = Persona.PersonaID INNER JOIN Cliente ON Venta.ClienteID = Cliente.ClienteID INNER JOIN Persona AS PersonaC ON Cliente.PersonaID = PersonaC.PersonaID INNER JOIN MedioPago ON Venta.MedioPagoID = MedioPago.MedioPagoID ORDER BY Venta.VentaID DESC");

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
        REGISTRAR VENTA				      
=============================================*/

	static public function mdlRegistrarVenta($tabla, $datos){
		
		date_default_timezone_set("America/Argentina/Tucuman");
		$fechaVentaTemp = date('Y-m-d');
		$hora = date('H:i:s');
		$fechaVentaOK = $fechaVentaTemp.' '.$hora;
		$puntoVenta = 1;
		$estado = "Registrada";
		
		$link = Conexion::conectar();
		$stmt = $link->prepare("INSERT INTO $tabla (UsuarioRegistraID, ClienteID, PuntoVentaID, FechaVenta, Estado, MedioPagoID, CodTransaccion, MontoDescuento, MontoRecargo, NroFactura, Neto, Total) VALUES (:usuario, :cliente, :puntoVenta, :fecha, :estado, :medio, :codTransaccion, :descuento, :recargo, :factura, :neto, :total)");

		$stmt->bindParam(":usuario", $datos["UsuarioRegistraID"], PDO::PARAM_INT);
		$stmt->bindParam(":cliente", $datos["ClienteID"], PDO::PARAM_INT);
		$stmt->bindParam(":puntoVenta", $puntoVenta, PDO::PARAM_INT);
		$stmt->bindParam(":fecha", $fechaVentaOK, PDO::PARAM_STR);
		$stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
		$stmt->bindParam(":medio", $datos["MedioPagoID"], PDO::PARAM_INT);
		$stmt->bindParam(":codTransaccion", $datos["CodTransaccion"], PDO::PARAM_STR);
		$stmt->bindParam(":descuento", $datos["MontoDescuento"], PDO::PARAM_STR);
		$stmt->bindParam(":recargo", $datos["MontoRecargo"], PDO::PARAM_STR);
		$stmt->bindParam(":factura", $datos["NroFactura"], PDO::PARAM_STR);
		$stmt->bindParam(":neto", $datos["Neto"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["Total"], PDO::PARAM_STR);
				
		if ($stmt->execute()) {
			
			$venta = $link->lastInsertId();

			return $venta;

		} else {

			return "error";
		}

	}

/*=============================================
        REGISTRAR DETALLE VENTA				      
=============================================*/

	static public function mdlRegistrarDetalleVenta($tabla, $idVenta, $idProducto, $Cantidad, $Precio){

		$link = Conexion::conectar();
	    
	    $stmt = $link->prepare("INSERT INTO $tabla (PedidoID, ProductoID, Cantidad, PrecioUnitario) VALUES (:venta, :productoId, :cantidad, :precio)");

	    $stmt->bindParam(":venta", $idVenta, PDO::PARAM_INT);
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
        EDITAR VENTA				      
=============================================*/

	static public function mdlEditarVenta($tabla, $datos){
		
		date_default_timezone_set("America/Argentina/Tucuman");
		$fechaVentaTemp = date('Y-m-d');
		$hora = date('H:i:s');
		$fechaVentaOK = $fechaVentaTemp.' '.$hora;
		$puntoVenta = 1;
		$estado = "Registrada";
		
		$link = Conexion::conectar();
		$stmt = $link->prepare("UPDATE $tabla SET UsuarioRegistraID = :usuario, ClienteID = :cliente, PuntoVentaID = :puntoVenta, FechaVenta = :fecha, Estado = :estado, MedioPagoID = :medio, CodTransaccion = :codTransaccion, MontoDescuento = :descuento, MontoRecargo = :recargo, NroFactura = :factura, Neto = :neto, Total = :total WHERE VentaID = :ventaId");

		
		$stmt->bindParam(":ventaId", $datos["VentaID"], PDO::PARAM_INT);
		$stmt->bindParam(":usuario", $datos["UsuarioRegistraID"], PDO::PARAM_INT);
		$stmt->bindParam(":cliente", $datos["ClienteID"], PDO::PARAM_INT);
		$stmt->bindParam(":puntoVenta", $puntoVenta, PDO::PARAM_INT);
		$stmt->bindParam(":fecha", $fechaVentaOK, PDO::PARAM_STR);
		$stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
		$stmt->bindParam(":medio", $datos["MedioPagoID"], PDO::PARAM_INT);
		$stmt->bindParam(":codTransaccion", $datos["CodTransaccion"], PDO::PARAM_STR);
		$stmt->bindParam(":descuento", $datos["MontoDescuento"], PDO::PARAM_STR);
		$stmt->bindParam(":recargo", $datos["MontoRecargo"], PDO::PARAM_STR);
		$stmt->bindParam(":factura", $datos["NroFactura"], PDO::PARAM_STR);
		$stmt->bindParam(":neto", $datos["Neto"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["Total"], PDO::PARAM_STR);
				
		if ($stmt->execute()) {
			
			return "ok";

		} else {

			return print_r($stmt->errorInfo());

			
		}

	}

/*=============================================
        ELIMINAR DETALLE VENTA				      
=============================================*/

	static public function mdlEliminarDetalleVenta($tabla, $idVenta){

		$link = Conexion::conectar();
	    
	    $stmt = $link->prepare("DELETE FROM $tabla WHERE PedidoID = :venta");

	    $stmt->bindParam(":venta", $idVenta, PDO::PARAM_INT);
	    
	    
	    if ($stmt->execute()) {
			
			return "ok";

		} else {

			return "error";
		}

	}

/*=============================================
        ANULAR VENTA				      
=============================================*/

	static public function mdlAnularVenta($tabla, $datos){

		date_default_timezone_set("America/Argentina/Tucuman");
		$fechaAnulaVentaTemp = date('Y-m-d');
		$hora = date('H:i:s');
		$fechaAnulaVentaOK = $fechaAnulaVentaTemp.' '.$hora;
		$estado = "Z";
		$tipo = "C";
		
		$link = Conexion::conectar();
		$stmt = $link->prepare("UPDATE $tabla SET Estado = :estado, UsuarioCancelaID = :userId, FechaCancela = :fecha, MotivoCancela = :motivo, FacturaTipo = :tipo WHERE VentaID = :ventaId");

		$stmt->bindParam(":ventaId", $datos["ventaID"], PDO::PARAM_INT);
		$stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
		$stmt->bindParam(":userId", $datos["UsuarioAnulaID"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha", $fechaAnulaVentaOK, PDO::PARAM_STR);
		$stmt->bindParam(":motivo", $datos["motivo"], PDO::PARAM_INT);
		$stmt->bindParam(":tipo", $tipo, PDO::PARAM_STR);
						
		if ($stmt->execute()) {
			
			return "ok";

		} else {

			return "error";
		}		

		
	}

/*=============================================
		LISTADO DE PRODUCTOS   		  
=============================================*/

	static public function mdlListadoProductos($tabla1, $tabla2, $tabla3, $idVenta){

		$stmt = Conexion::conectar()->prepare("SELECT Venta.VentaID, VentaDetalle.PedidoID, VentaDetalle.ProductoID, VentaDetalle.Cantidad, VentaDetalle.PrecioUnitario, Producto.Nombre, Producto.Ventas, Producto.Codigo FROM $tabla1 INNER JOIN $tabla2 ON VentaDetalle.PedidoID = Venta.VentaID INNER JOIN $tabla3 ON VentaDetalle.ProductoID = Producto.ProductoID WHERE Venta.VentaID = :idVenta");
		$stmt->bindParam(":idVenta", $idVenta, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->close();


	}

/*=============================================
		TRAER PRODUCTO TIPO  		  
=============================================*/

	static public function mdlTraerTipoProducto($tabla, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT Tipo FROM Producto WHERE ProductoID = :producto");
		$stmt->bindParam(":producto", $valor, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch();
		$stmt->close();


	}

/*=============================================
		RANGO DE FECHAS  		  
=============================================*/

	static public function mdlRangoFechaVentas($tabla, $fechaInicial, $fechaFinal){

		if ($fechaInicial == null) {
			
			$stmt = Conexion::conectar()->prepare("SELECT Venta.VentaID, Venta.UsuarioRegistraID, date_format(Venta.FechaVenta, '%d/%m/%Y') AS fechaFormateada, Venta.UsuarioCancelaID, Venta.ClienteID, Venta.PuntoVentaID, Venta.FechaVenta, Venta.Estado, Venta.MedioPagoID, Venta.CodTransaccion, Venta.MontoDescuento, Venta.MontoRecargo, Venta.NroFactura, Venta.FacturaTipo, Venta.Neto, Venta.Total, Usuario.UsuarioID, Usuario.PersonaID, Usuario.NombreUsuario, Persona.Nombre, Persona.Apellido, Cliente.ClienteID, PersonaC.PersonaID AS PersonaCID, PersonaC.Nombre AS NombreC, PersonaC.Apellido AS ApellidoC, MedioPago.MedioPagoID, MedioPago.Nombre AS MDP FROM $tabla INNER JOIN Usuario ON Venta.UsuarioRegistraID = Usuario.UsuarioID INNER JOIN Persona ON Usuario.PersonaID = Persona.PersonaID INNER JOIN Cliente ON Venta.ClienteID = Cliente.ClienteID INNER JOIN Persona AS PersonaC ON Cliente.PersonaID = PersonaC.PersonaID INNER JOIN MedioPago ON Venta.MedioPagoID = MedioPago.MedioPagoID ORDER BY Venta.VentaID DESC");

			$stmt-> execute();

			return $stmt-> fetchAll();

		} elseif ($fechaInicial == $fechaFinal) {
			
			$stmt = Conexion::conectar()->prepare("SELECT Venta.VentaID, Venta.UsuarioRegistraID, date_format(Venta.FechaVenta, '%d/%m/%Y') AS fechaFormateada, Venta.UsuarioCancelaID, Venta.ClienteID, Venta.PuntoVentaID, Venta.FechaVenta, Venta.Estado, Venta.MedioPagoID, Venta.CodTransaccion, Venta.MontoDescuento, Venta.MontoRecargo, Venta.NroFactura, Venta.FacturaTipo, Venta.Neto, Venta.Total, Usuario.UsuarioID, Usuario.PersonaID, Usuario.NombreUsuario, Persona.Nombre, Persona.Apellido, Cliente.ClienteID, PersonaC.PersonaID AS PersonaCID, PersonaC.Nombre AS NombreC, PersonaC.Apellido AS ApellidoC, MedioPago.MedioPagoID, MedioPago.Nombre AS MDP FROM $tabla INNER JOIN Usuario ON Venta.UsuarioRegistraID = Usuario.UsuarioID INNER JOIN Persona ON Usuario.PersonaID = Persona.PersonaID INNER JOIN Cliente ON Venta.ClienteID = Cliente.ClienteID INNER JOIN Persona AS PersonaC ON Cliente.PersonaID = PersonaC.PersonaID INNER JOIN MedioPago ON Venta.MedioPagoID = MedioPago.MedioPagoID WHERE DATE(Venta.FechaVenta) like '%$fechaInicial%' ORDER BY Venta.VentaID DESC");

			$stmt-> execute();

			return $stmt-> fetchAll();



		}else{

			$stmt = Conexion::conectar()->prepare("SELECT Venta.VentaID, Venta.UsuarioRegistraID, date_format(Venta.FechaVenta, '%d/%m/%Y') AS fechaFormateada, Venta.UsuarioCancelaID, Venta.ClienteID, Venta.PuntoVentaID, Venta.FechaVenta, Venta.Estado, Venta.MedioPagoID, Venta.CodTransaccion, Venta.MontoDescuento, Venta.MontoRecargo, Venta.NroFactura, Venta.FacturaTipo, Venta.Neto, Venta.Total, Usuario.UsuarioID, Usuario.PersonaID, Usuario.NombreUsuario, Persona.Nombre, Persona.Apellido, Cliente.ClienteID, PersonaC.PersonaID AS PersonaCID, PersonaC.Nombre AS NombreC, PersonaC.Apellido AS ApellidoC, MedioPago.MedioPagoID, MedioPago.Nombre AS MDP FROM $tabla INNER JOIN Usuario ON Venta.UsuarioRegistraID = Usuario.UsuarioID INNER JOIN Persona ON Usuario.PersonaID = Persona.PersonaID INNER JOIN Cliente ON Venta.ClienteID = Cliente.ClienteID INNER JOIN Persona AS PersonaC ON Cliente.PersonaID = PersonaC.PersonaID INNER JOIN MedioPago ON Venta.MedioPagoID = MedioPago.MedioPagoID WHERE DATE(Venta.FechaVenta) BETWEEN '$fechaInicial' AND '$fechaFinal' ORDER BY Venta.VentaID DESC");

			$stmt-> execute();

			return $stmt-> fetchAll();


		}



	}

/*=============================================
		RANGO DE FECHAS GRAFICO		  
=============================================*/

	static public function mdlRangoFechaVentasGrafico($tabla, $fechaInicial, $fechaFinal){

		
			$stmt = Conexion::conectar()->prepare("SELECT DATE_FORMAT(FechaVenta, '%Y-%m') AS Periodo, SUM(Total) AS TotalVentas FROM $tabla WHERE Estado <> 'Z' AND CONVERT(FechaVenta, DATE) BETWEEN  CAST('$fechaInicial' AS DATE) AND CAST('$fechaFinal' AS DATE) GROUP BY EXTRACT(YEAR FROM FechaVenta), EXTRACT(MONTH FROM FechaVenta) ORDER BY FechaVenta");

			
			$stmt-> execute();

			return $stmt-> fetchAll();

		
		}

/*=============================================
        TIPO DE FACTURA				      
=============================================*/

	static public function mdlTipoFactura($tabla, $venta, $tipo){
		
		$link = Conexion::conectar();
		$stmt = $link->prepare("UPDATE $tabla SET FacturaTipo = :tipo WHERE VentaID = :ventaId");

		$stmt->bindParam(":tipo", $tipo, PDO::PARAM_STR);
		$stmt->bindParam(":ventaId", $venta, PDO::PARAM_INT);
						
		if ($stmt->execute()) {
			
			return 'ok';

		} else {

			return "error";
		}

	}

/*=============================================
		SUMA TOTAL DE LAS VENTAS   		  
=============================================*/

	static public function mdlSumaTotalVentas($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT SUM(Total) AS total FROM $tabla");
		$stmt->execute();
		
		return $stmt -> fetch();

		$stmt = null;
		

	}

/*=============================================
		ACTUALIZAR STOCK   		  
=============================================*/

	static public function mdlActualizarStock($tabla, $id, $stock){

		$link = Conexion::conectar();
	    
	    $stmt = $link->prepare("UPDATE $tabla SET Stock = :stock WHERE InsumosID = :insumos");

	    $stmt->bindParam(":insumos", $id, PDO::PARAM_INT);
	    $stmt->bindParam(":stock", $stock, PDO::PARAM_INT);
	    	    
	    if ($stmt->execute()) {
			
			return "ok";

		} else {

			return "error";
		}
			
		
		

	}

/*=============================================
        TRAER INSUMOS
=============================================*/

    static public function mdlTraerInsumo($tabla, $valor){

        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE InsumosID = :valor");
		$stmt->bindParam(":valor", $valor, PDO::PARAM_INT);
		$stmt -> execute();
		
		return $stmt -> fetch();
		
		$stmt -> close();
		$stmt = null;

    }

} // fin de clase ModeloVentas