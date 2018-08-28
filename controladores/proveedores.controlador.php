<?php 

class ControladorProveedores{

/*==========================================
            MOSTRAR PROVEEDORES 				
==========================================*/

	static public function ctrMostrarProveedores($item, $valor){

		$tabla1 = "Proveedor";

		$tabla2 = "Rubro";

		$tabla3 = "Email";

		$tabla4 = "Telefono";

		$tipo = "Proveedor";

		$respuesta = ModeloProveedores::mdlMostrarProveedores($tabla1, $tabla2, $tabla3, $tabla4, $tipo, $item, $valor);

		return $respuesta;
	}	

/*==========================================
            MOSTRAR PROVEEDORES ACTIVOS 				
==========================================*/

	static public function ctrMostrarProveedoresAc(){

		$tabla1 = "Proveedor";

		$tabla2 = "Rubro";

		$tabla3 = "Email";

		$tabla4 = "Telefono";

		$respuesta = ModeloProveedores::mdlMostrarProveedoresAc($tabla1, $tabla2, $tabla3, $tabla4);

		return $respuesta;
	}	

/*=========================================
			REGISTRAR PROVEEDOR            
==========================================*/

	static public function ctrRegistrarProveedor($datos){	

		if(isset($datos["razon"])){

			#REALIZAMOS LA VALIDACION DEL LADO DEL SERVIDOR

			if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/', $datos["razon"])&& 
				preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $datos["emailProveedor"])&&
				preg_match('/^[0-9-]+$/', $datos["cuit"])&&
				preg_match('/^[0-9]+$/', $datos["iva"])&&
				preg_match('/^[0-9-]+$/', $datos["rubro"])&&
				preg_match('/^[0-9]+$/', $datos["codAreaProveedor"])&&
				preg_match('/^[0-9]+$/', $datos["numTelProveedor"])&& 
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/', $datos["calle"])&&
				preg_match('/^[0-9]+$/', $datos["numCalle"])&&
				preg_match('/^[0-9]*$/', $datos["piso"])&&
				preg_match('/^[a-zA-Z0-9_]*$/', $datos["depto"])&&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/', $datos["localidad"])&&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/', $datos["barrio"])&&
				preg_match('/^[0-9]*$/', $datos["codPostal"])&&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]*$/', $datos["nombreRefPro"])&& 
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]*$/', $datos["apellidoRefPro"])&&
				preg_match('/^[0-9]*$/', $datos["codAreaRef"])&&
				preg_match('/^[0-9]*$/', $datos["numTelRef"])){

				#ENVIAMOS LOS DATOS EN UN ARRAY AL MODELO
				$respuesta = ModeloProveedores::mdlRegistrarProveedor($datos, 'Persona', 'Proveedor', 'Email', 'Telefono', 'Localidad', 'Barrio', 'Domicilio');

					if($respuesta == "ok"){
				
							return 'ok';
					
						} else {

							return 'error';

					}
			
			} else {

				return 'error sin validar';

			}

		}
	
	}

/*=========================================
			MODIFICAR PROVEEDOR            
==========================================*/

	static public function ctrModificarProveedor($datos){	

		if(isset($datos["razon"])){

			#REALIZAMOS LA VALIDACION DEL LADO DEL SERVIDOR

			if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/', $datos["razon"])&& 
				preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $datos["emailProveedor"])&&
				preg_match('/^[0-9-]+$/', $datos["cuit"])&&
				preg_match('/^[0-9]+$/', $datos["iva"])&&
				preg_match('/^[0-9-]+$/', $datos["rubro"])&&
				preg_match('/^[0-9]+$/', $datos["codAreaProveedor"])&&
				preg_match('/^[0-9]+$/', $datos["numTelProveedor"])&& 
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/', $datos["calle"])&&
				preg_match('/^[0-9]+$/', $datos["numCalle"])&&
				preg_match('/^[0-9]*$/', $datos["piso"])&&
				preg_match('/^[a-zA-Z0-9_]*$/', $datos["depto"])&&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/', $datos["localidad"])&&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/', $datos["barrio"])&&
				preg_match('/^[0-9]*$/', $datos["codPostal"])&&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]*$/', $datos["nombreRefPro"])&& 
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]*$/', $datos["apellidoRefPro"])&&
				preg_match('/^[0-9]*$/', $datos["codAreaRef"])&&
				preg_match('/^[0-9]*$/', $datos["numTelRef"])){

				#ENVIAMOS LOS DATOS EN UN ARRAY AL MODELO
				$respuesta = ModeloProveedores::mdlModificarProveedor($datos, 'Persona', 'Proveedor', 'Email', 'Telefono', 'Localidad', 'Barrio', 'Domicilio');

					if($respuesta == "ok"){
				
							return 'ok';
					
						} else {

							return $respuesta;

					}
			
			} else {

				return 'error sin validar';

			}

		}
	
	}

/*=============================================
            ELIMINAR PROVEEDOR 				  
=============================================*/

	static public function ctrEliminarProveedor($proveedor, $persona){

		$datosController = array("ProveedorID"=>$proveedor,
								 "PersonaID"=>$persona);
		
		$respuesta = ModeloProveedores::mdlEliminarProveedor($datosController, 'Persona', 'Proveedor', 'Email', 'Telefono', 'Domicilio');

		if($respuesta=="ok"){

			echo 0;

		}else{

			echo 1;

		}
		
	}

/*=========================================
			LISTADO DE RUBROS            
=========================================*/

	static public function 	ctrListarRubros(){

		$respuesta = ModeloProveedores::mdlListarRubros("Rubro");

		foreach ($respuesta as $row => $item){

			echo '<option value="'.$item["RubroID"].'">'.$item["Nombre"].'</option>';
		}
	
	}

/*=========================================
			LISTADO DE IVA            
=========================================*/

	static public function 	ctrListarIva(){

		$respuesta = ModeloProveedores::mdlListarIva("IVA");

		foreach ($respuesta as $row => $item){

			echo '<option value="'.$item["IVAID"].'">'.$item["Descripcion"].'</option>';
		}
	
	}

/*=========================================
			VALIDAR NO REPETIR CUIT  		  
=========================================*/

	static public function ctrValidarCuit($validarCuit){

		$datosController = $validarCuit;
		
		$respuesta = ModeloProveedores::mdlValidarCuit($datosController, "Proveedor");

		if(count($respuesta["CUITT"]) > 0){
			
			#EL CUIT EXISTE POR LO TANTO NO ESTA DISPONIBLE
			echo "false";
		
		}else{
			
			#EL CUIT NO EXISTE Y POR LO TANTO ESTARA DISPONIBLE
		
			echo "true";
		}
	
	}

/*==========================================
            TRAER DOMICILIO 			   
==========================================*/

	static public function ctrTraerDomicilioProveedores($datos){

		$idProveedor = $datos;

		$respuesta = ModeloProveedores::mdlTraerDomicilioProveedores($idProveedor, "Domicilio");

		return $respuesta;

	}

/*==========================================
            TRAER REFERENTE 			   
==========================================*/

	static public function ctrTraerReferenteProveedor($datos){

		$idProveedor = $datos;

		$respuesta = ModeloProveedores::mdlTraerReferenteProveedor($idProveedor, "Persona");

		return $respuesta;

	}

/*=============================================
        	DESCARGAR REPORTE
=============================================*/

    static public function ctrDescararReporte(){

        if (isset($_GET["reporte"])) {

        	$tabla1 = "Proveedor";
			$tabla2 = "Rubro";
			$tabla3 = "Email";
			$tabla4 = "Telefono";
			$tipo = "Proveedor";

		   	$item = null;
        	$valor = null;
			$proveedores = ModeloProveedores::mdlMostrarProveedores($tabla1, $tabla2, $tabla3, $tabla4, $tipo, $item, $valor);
        	
        	//CREAMOS EL ARCHIVO DE EXCEL

        	$name = 'reporte-proveedores.xls';
        	header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
			header("Cache-Control: cache, must-revalidate"); 
			header('Content-Description: File Transfer');
			header('Last-Modified: '.date('D, d M Y H:i:s'));
			header("Pragma: public"); 
			header('Content-Disposition:; filename="'.$name.'"');
			header("Content-Transfer-Encoding: binary");

			echo utf8_decode("<table border='0' width='950'> 

					<tr>
						<td colspan=8 align='center' bgcolor='#9DD1A7'>REPORTE DE PROVEEDORES</td>
					</tr>
					<tr> 
						<th align='center' bgcolor='#88C1E3'>RAZON SOCIAL</th>		
						<th align='center' bgcolor='#88C1E3'>CUIT</th> 
						<th align='center' bgcolor='#88C1E3'>IVA</th>
						<th align='center' bgcolor='#88C1E3'>RUBRO</th>
						<th align='center' bgcolor='#88C1E3'>EMAIL</th>
						<th align='center' bgcolor='#88C1E3'>TELÉFONO</th>
						<th align='center' bgcolor='#88C1E3'>ALTA</th>
						<th align='center' bgcolor='#88C1E3'>DOMICILIO</th>
						
					</tr>");

			foreach ($proveedores as $row => $item){

				$cliente = ModeloProveedores::mdlMostrarProveedores($tabla1, $tabla2, $tabla3, $tabla4, $tipo, "ProveedorID", $item["ProveedorID"]);
				$domicilio = ModeloProveedores::mdlTraerDomicilioProveedores($item["ProveedorID"], $tabla1);
				$referente = ModeloProveedores::mdlTraerReferenteProveedor($item["ProveedorID"], $tabla1);

								
			 	echo utf8_decode("<tr> 
						 			<td bgcolor='#FAEDB1'>".$item["RazonSocial"]."</td>		
									<td bgcolor='#FAEDB1'>".$item["CUITT"]."</td> 
									<td bgcolor='#FAEDB1'>".$item["IVA"]."</td>
									<td bgcolor='#FAEDB1'>".$item["Rubro"]."</td>
									<td bgcolor='#FAEDB1'>".$item["Email"]."</td>
									<td bgcolor='#FAEDB1'>(".$item["Prefijo"].") - ".$item["NroTelefono"]."</td>
									<td bgcolor='#FAEDB1'>".$item["Alta"]."</td>
									<td bgcolor='#FAEDB1'>".$domicilio["Calle"]." ".$domicilio["Nro"]." ".$domicilio["Piso"]." ".$domicilio["Dpto"]."</td>
									
						 		</tr>");
			}

			echo "</table>";

        }

    }

}//fin clase ControladorProveedores