<?php

class ControladorClientes{

/*==========================================
            MOSTRAR CLIENTES
==========================================*/

	static public function ctrMostrarClientes($item, $valor){

		$tabla1 = "Cliente";

		$tabla2 = "Persona";

		$tabla3 = "Domicilio";

		$tabla4 = "Localidad";

		$tabla5 = "Barrio";

		$tabla6 = "Telefono";

		$respuesta = ModeloClientes::mdlMostrarClientes($tabla1, $tabla2, $tabla3, $tabla4, $tabla5, $tabla6, $item, $valor);

		return $respuesta;
	}

/*==========================================
        	REGISTRAR CLIENTES
==========================================*/

	static public function ctrRegistroCliente(){

		if(isset($_POST["nombreCliente"])){

			#REALIZAMOS LA VALIDACION DEL LADO DEL SERVIDOR

			if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/', $_POST["nombreCliente"])&&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/', $_POST["apellidoCliente"])&&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/', $_POST["calleCliente"])&&
				preg_match('/^[0-9]+$/', $_POST["numCalleCliente"])&&
				preg_match('/^[0-9]*$/', $_POST["pisoCliente"]) &&
				preg_match('/^[a-zA-Z0-9_]*$/', $_POST["deptoCliente"]) &&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/', $_POST["barrioCliente"]) &&
				preg_match('/^[0-9]+$/', $_POST["codAreaTelefono"]) &&
				preg_match('/^[0-9]+$/', $_POST["numeroTeléfono"])){

				#ENVIAMOS LOS DATOS EN UN ARRAY AL MODELO

				$datosController = array("nombre"=>ucwords($_POST["nombreCliente"]),
										 "apellido"=>ucwords($_POST["apellidoCliente"]),
										 "calle"=>ucwords($_POST["calleCliente"]),
										 "numeroCalle"=>$_POST["numCalleCliente"],
										 "piso"=>$_POST["pisoCliente"],
										 "depto"=>ucwords($_POST["deptoCliente"]),
										 "localidad"=>ucwords($_POST["localidadCliente"]),
										 "barrio"=>ucwords($_POST["barrioCliente"]),
										 "codArea"=>$_POST["codAreaTelefono"],
										 "telefono"=>$_POST["numeroTeléfono"],
										 "comentario"=>$_POST["comentarioCliente"]);


				$respuesta = ModeloClientes::mdlRegistroCliente($datosController, "Persona", "Cliente", "Telefono", "Localidad", "Barrio", "Domicilio");

				if($respuesta == "ok"){

					echo'<script>
							swal({
								title:"¡Registro Exitoso!",
								text:"¡Los datos del cliente se registraron correctamente!",
								type:"success",
								confirmButtonText: "Cerrar",
								closeOnConfirm: false
							},
								function(isConfirm){
									if(isConfirm){
										window.location="clientes";
								}
							});
						</script>';

				}else{

					echo'<script>
							swal({
								title:"¡Registro Fallido!",
								text:"¡Ocurrio un error, revise los datos!'.$respuesta.'",
								type:"error",
								confirmButtonText:"Cerrar",
								closeOnConfirm: false
							});
						</script>';

				}


			}else{

				echo '<script>
						swal({
							title:"¡Error!",
							text:"¡No ingrese caracteres especiales!",
							type:"warning",
							confirmButtonText:"Cerrar",
							closeOnConfirm:false
						},
							function(isConfirm){
								if(isConfirm){
									window.location="clientes";
							}
						});
					 </script>';

			}
		}

	}

/*==========================================
            EDITAR CLIENTES
==========================================*/

	static public function ctrEditarCliente(){

		if(isset($_POST["eNombreCliente"])){

			#REALIZAMOS LA VALIDACION DEL LADO DEL SERVIDOR

			if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/', $_POST["eNombreCliente"])&&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/', $_POST["eApellidoCliente"])&&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/', $_POST["eCalleCliente"])&&
				preg_match('/^[0-9]+$/', $_POST["eNumCalleCliente"])&&
				preg_match('/^[0-9]*$/', $_POST["ePisoCliente"]) &&
				preg_match('/^[a-zA-Z0-9_]*$/', $_POST["eDeptoCliente"]) &&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/', $_POST["eLocalidadCliente"]) &&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/', $_POST["eBarrioCliente"]) &&
				preg_match('/^[0-9]+$/', $_POST["eCodAreaCliente"]) &&
				preg_match('/^[0-9]+$/', $_POST["eNumeroTelefonoCliente"])){

				#ENVIAMOS LOS DATOS EN UN ARRAY AL MODELO

				$datosController = array("clienteID"=>$_POST["idCliente"],
										 "nombre"=>ucwords($_POST["eNombreCliente"]),
										 "apellido"=>ucwords($_POST["eApellidoCliente"]),
										 "personaID"=>$_POST["idPersona"],
										 "calle"=>ucwords($_POST["eCalleCliente"]),
										 "numeroCalle"=>$_POST["eNumCalleCliente"],
										 "piso"=>$_POST["ePisoCliente"],
										 "depto"=>ucwords($_POST["eDeptoCliente"]),
										 "localidad"=>ucwords($_POST["eLocalidadCliente"]),
										 "barrio"=>ucwords($_POST["eBarrioCliente"]),
										 "codArea"=>$_POST["eCodAreaCliente"],
										 "telefono"=>$_POST["eNumeroTelefonoCliente"],
										 "comentario"=>$_POST["eComentarioCliente"]);

				$respuesta = ModeloClientes::mdlEditoCliente($datosController, "Persona", "Cliente", "Telefono", "Localidad", "Barrio", "Domicilio");

				if($respuesta == "ok"){

					echo'<script>
						swal({
						title:"¡Modificación Exitosa!",
						text:"¡Los datos del cliente se modificaron correctamente!",
						type:"success",
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						},
						function(isConfirm){
						if(isConfirm){
						window.location="clientes";
						}
						});
						</script>';

				}else{

					echo'<script>
						swal({
						title:"¡Registro Fallido!",
						text:"¡Ocurrio un error, revise los datos!'.$respuesta.'",
						type:"error",
						confirmButtonText:"Cerrar",
						closeOnConfirm: false
						});
						</script>';

				}


			}else{

				echo '<script>
						swal({
						title:"¡Error!",
						text:"¡No ingrese caracteres especiales!",
						type:"warning",
						confirmButtonText:"Cerrar",
						closeOnConfirm:false
						},
						function(isConfirm){
						if(isConfirm){
						window.location="clientes";
						}
						});
						</script>';


			}
		}

	}

/*==========================================
            ELIMINAR CLIENTE
==========================================*/

	static public function ctrEliminarCliente($cliente){

		$tabla = "Cliente";

		$traigo = ModeloClientes::mdlTraerIdPersona($cliente, $tabla);

		$persona = $traigo["PersonaID"];

		$datosController = array('PersonaID' => $persona,
								 'ClienteID' => $cliente);

		$respuesta = ModeloClientes::mdlEliminarCliente($datosController, "Persona", "Cliente", "Domicilio", "Telefono");

		if($respuesta=="ok"){

			echo 0;

		}else{

			echo 1;

		}

	}

/*=============================================
			SUMA TOTAL DE PEDIDOS
=============================================*/

	static public function ctrSumaTotalPedidos(){

		$tabla = "Cliente";

		$respuesta = ModeloClientes::mdlSumaTotalPedidos($tabla);

		return $respuesta;

	}

/*=============================================
        	DESCARGAR REPORTE
=============================================*/

    static public function ctrDescararReporte(){

        if (isset($_GET["reporte"])) {

        	$tabla1 = "Cliente";
					$tabla2 = "Persona";
					$tabla3 = "Domicilio";
					$tabla4 = "Localidad";
					$tabla5 = "Barrio";
					$tabla6 = "Telefono";

        	$item = null;
        	$valor = null;
					$clientes = ModeloClientes::mdlMostrarClientes($tabla1, $tabla2, $tabla3, $tabla4, $tabla5, $tabla6, $item, $valor);

        	//CREAMOS EL ARCHIVO DE EXCEL

        	$name = 'reporte-clientes.xls';
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
						<td colspan=8 align='center' bgcolor='#9DD1A7'>Reporte de clientes</td>
					</tr>
					<tr>
						<th align='center' bgcolor='#88C1E3'>NOMBRE</th>
						<th align='center' bgcolor='#88C1E3'>DOMICILIO</th>
						<th align='center' bgcolor='#88C1E3'>TELEFONO</th>
						<th align='center' bgcolor='#88C1E3'>LOCALIDAD</th>
						<th align='center' bgcolor='#88C1E3'>BARRIO</th>
						<th align='center' bgcolor='#88C1E3'>ALTA</th>
						<th align='center' bgcolor='#88C1E3'>C/PEDIDOS</th>
						<th align='center' bgcolor='#88C1E3'>U/PEDIDOS</th>
					</tr>");

			foreach ($clientes as $row => $item){

				$cliente = ControladorClientes::ctrMostrarClientes("ClienteID", $item["ClienteID"]);


			 	echo utf8_decode("<tr>
						 			<td bgcolor='#FAEDB1'>".$item["Nombre"]." ".$item["Apellido"]."</td>
									<td bgcolor='#FAEDB1'>".$item["Calle"]." ".$item["Nro"]." ".$item["Piso"]." ".$item["Dpto"]."</td>
									<td bgcolor='#FAEDB1'>(".$item["Prefijo"].") - ".$item["NroTelefono"]."</td>
									<td bgcolor='#FAEDB1'>".$item["Localidad"]."</td>
									<td bgcolor='#FAEDB1'>".$item["Barrio"]."</td>
									<td bgcolor='#FAEDB1'>".$item["FechaAlta"]."</td>
									<td bgcolor='#FAEDB1'>".$item["Compras"]."</td>
									<td bgcolor='#FAEDB1'>".$item["UltimaCompra"]."</td>
						 		</tr>");
			}

			echo "</table>";

        }

    }

}
