<?php

class ControladorGrupoFamiliar{

/*=============================================
            TRAER EMPLEADOS 				  
=============================================*/

	static public function 	ctrTraerEmpleados(){

		$respuesta = ModeloGrupoFamiliar::mdlTraerEmpleados("Empleado", "Persona");

		return $respuesta;
	
	}

/*=============================================
			REGISTRAR FAMILIAR 		      
=============================================*/

	static public function ctrRegistroFamiliar(){

		if(isset($_POST["nombreFamiliar"])){

			#REALIZAMOS LA VALIDACION DEL LADO DEL SERVIDOR

			if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/', $_POST["nombreFamiliar"])&&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/', $_POST["apellidoFamiliar"])&&
				preg_match('/^[0-9]+$/', $_POST["dniFamiliar"])&&
				//preg_match('/^[a-zA-Z0-9]+$/', $_POST["sexoFamiliar"])&&
				preg_match('/^[a-zA-Z0-9]+$/', $_POST["parentezcoFamiliar"])){

				
				$datosController = array("idEmpleado" => $_POST["idEmpleadoCrear"],
										 "nombre"=>ucwords($_POST["nombreFamiliar"]),
										 "apellido"=>ucwords($_POST["apellidoFamiliar"]),
										 "dni"=>$_POST["dniFamiliar"],
										 "parentezco"=>$_POST["parentezcoFamiliar"],
										 "sexo"=>$_POST["sexoFamiliar"],
										 "fecha"=>$_POST["fechaFamiliar"]);

				
				$respuesta = ModeloGrupoFamiliar::mdlRegistroFamiliar($datosController, "Persona", "GrupoFamiliar");

				if($respuesta == "ok"){

					echo'<script>
						swal({
							title:"¡Registro Exitoso!",
							text:"¡El familiar se agregó correctamente!",
							type:"success",
							confirmButtonText: "Cerrar",
							closeOnConfirm: false
							},
							function(isConfirm){
							if(isConfirm){
													
								$.redirect("grupoFamiliar",{ empleado: '.$datosController["idEmpleado"].'},"POST");

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
							window.location="grupoFamiliar";
							}
						});
						</script>';
			

			}
		}
	
	}

/*=============================================
			MODIFICAR FAMILIAR 		      
=============================================*/

	static public function ctrModificoFamiliar(){

		if(isset($_POST["enombreFamiliar"])){

			#REALIZAMOS LA VALIDACION DEL LADO DEL SERVIDOR

			if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/', $_POST["enombreFamiliar"])&&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/', $_POST["eapellidoFamiliar"])&&
				preg_match('/^[0-9]+$/', $_POST["edniFamiliar"])&&
				preg_match('/^[a-zA-Z0-9]+$/', $_POST["eparentezcoFamiliar"])){

				
				$datosController = array("idFamiliarEditar" => $_POST["idFamiliarEditar"],
										 "idEmpleadoEditar" => $_POST["idEmpleadoEditar"],
										 "idPersonaEditar" => $_POST["idPersonaEditar"],
										 "nombre"=>ucwords($_POST["enombreFamiliar"]),
										 "apellido"=>ucwords($_POST["eapellidoFamiliar"]),
										 "dni"=>$_POST["edniFamiliar"],
										 "parentezco"=>$_POST["eparentezcoFamiliar"],
										 "sexo"=>$_POST["esexoFamiliar"],
										 "fecha"=>$_POST["efechaFamiliar"]);

				
				$respuesta = ModeloGrupoFamiliar::mdlModificoFamiliar($datosController, "Persona", "GrupoFamiliar");

				if($respuesta == "ok"){

					echo'<script>
						swal({
						title:"Modificación Exitosa!",
						text:"¡El familiar se modificó correctamente!",
						type:"success",
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						},
						function(isConfirm){
						if(isConfirm){
												
							$.redirect("grupoFamiliar",{ empleado: '.$datosController["idEmpleadoEditar"].'},"POST");

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
						window.location="grupoFamiliar";
						}
						});
						</script>';
			

			}
		}
	
	}

/*=============================================
            ELIMINAR FAMILIAR 				  
=============================================*/

	static public function ctrEliminarFamiliar($familiar, $persona){

		$datosController = array("FamiliarID"=>$familiar,
								 "PersonaID"=>$persona);
		
		$respuesta = ModeloGrupoFamiliar::mdlEliminarFamiliar($datosController, "Persona", "GrupoFamiliar");

		if($respuesta=="ok"){

			echo 0;

		}else{

			echo 1;

		}
		
	}

/*=============================================
            TRAER FAMILIARES 				  
=============================================*/

	static public function 	ctrTraerFamiliares($valor){

		$idEmpleado = $valor;

		$respuesta = ModeloGrupoFamiliar::mdlTraerFamiliares($idEmpleado, "GrupoFamiliar", "Empleado", "Persona");

		return $respuesta;
	
	}

/*=============================================
            TRAER FAMILIAR 				  
=============================================*/

	static public function 	ctrTraerFamiliar($valor1, $valor2){

		$datosController = array('IdFramiliar' => $valor1 ,
								 'idEmpleado' => $valor2);

		$respuesta = ModeloGrupoFamiliar::mdlTraerFamiliar($datosController, "GrupoFamiliar", "Empleado", "Persona");

		return $respuesta;
	
	}

}