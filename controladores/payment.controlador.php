<?php

class ControladorPayment{

/*=============================================
        MOSTRAR CONCEPTOS
=============================================*/

    static public function ctrMostrarConceptos($item, $valor){

        $tabla = "Concepto";

        $respuesta = ModeloPayment::mdlMostrarConceptos($tabla, $item, $valor);

        return $respuesta;

    }

/*=============================================
        MOSTRAR CONCEPTOS LIQUIDAR
=============================================*/

    static public function ctrMostrarConceptosLiquidar($item, $valor){

        $tabla = "Concepto";

        $respuesta = ModeloPayment::mdlMostrarConceptosLiquidar($tabla, $item, $valor);

        return $respuesta;

    }

/*=============================================
        MOSTRAR CONCEPTOS DE BOLETA
=============================================*/

    static public function ctrMostrarConceptosDeBoleta($item, $valor){

        $tabla1 = "Liquidacion";
        $tabla2 = "LiquidacionDetalle";
        $tabla3 = "Concepto";

        $respuesta = ModeloPayment::mdlMostrarConceptosDeBoleta($tabla1, $tabla2, $tabla3, $item, $valor);

        return $respuesta;

    }

/*=============================================
        MOSTRAR CONCEPTOS DISTINTOS
=============================================*/

    static public function ctrMostrarConceptosLiquidarDistintos($item, $valor, $datos, $tipo){

        $tabla = "Concepto";

        $listaConceptos = json_decode($datos, true);

        $nuevaLista = array();

        $nuevosValores = array();

        $conceptosSelect = array();

        foreach ($listaConceptos as $key => $value) {
            
            //if ($value["Fijo"] == "N") {
            
               array_push($nuevaLista, $value["Descripcion"]);

           // }

        }

        //var_dump($nuevaLista);

        $traerTodosConceptos = ModeloPayment::mdlMostrarConceptosLiquidar($tabla, $item, $valor);

        foreach ($traerTodosConceptos as $key2 => $value2) {
            
            array_push($nuevosValores, $value2["Descripcion"]);
        
        }

        //var_dump($nuevosValores);

        $diferencia = array_diff($nuevosValores, $nuevaLista);

        //var_dump($diferencia);

        if ($tipo == "Vacaciones") {
            
            $resultado = $diferencia;
        
        } else {

            $resultado = array_diff($diferencia, array('Vacaciones'));
        }

        foreach ($resultado as $key => $value) {
            
            //saco el valor de cada elemento
            $valorS = $value;
            $itemS = "Descripcion";
            
            $traerConceptosSelect = ModeloPayment::mdlMostrarConceptos($tabla, $itemS, $valorS);

            $dtConceptos = array("ConceptoID" => $traerConceptosSelect["ConceptoID"],
                                 "Descripcion" => $traerConceptosSelect["Descripcion"]);    
            
            
            array_push($conceptosSelect, $dtConceptos);
        }

        return $conceptosSelect;

    }            

/*=============================================
        MOSTRAR TIPOS LIQUIDACION
=============================================*/

    static public function ctrMostrarTipoLiquidacion($item, $valor){

        $tabla = "TipoLiquidacion";

        $respuesta = ModeloPayment::mdlMostrarTipoLiquidacion($tabla, $item, $valor);

        return $respuesta;

    }

/*=============================================
        REGISTRAR CONCEPTO
=============================================*/

    static public function ctrRegistrarConcepto(){

    		if(isset($_POST["descConcepto"])){

    			#REALIZAMOS LA VALIDACION DEL LADO DEL SERVIDOR

    			if (preg_match('/^[0-9a-zA-ZñÑáéíóúüÁÉÍÓÚÜ\s\.]+$/', $_POST["descConcepto"])){

    				$datosController = array('codigo' =>ucwords($_POST["codConcepto"]),
                                             'descripcion' =>ucwords($_POST["descConcepto"]),
    										 'porcentaje' =>$_POST["porcentajeConcepto"],
    										 'tipo' =>ucwords($_POST["tipoConcepto"]),
    										 'fijo' =>$_POST["fijoConcepto"],
                                             'unidades' =>$_POST["unidadesConcepto"]);
    				$tabla = "Concepto";

                    $respuesta = ModeloPayment::mdlRegistrarConcepto($tabla, $datosController);

    				if($respuesta == "ok"){

    					echo'<script>
    						swal({
        						title:"¡Registro Exitoso!",
        						text:"¡El concepto se creo correctamente!",
        						type:"success",
        						confirmButtonText: "Cerrar",
        						closeOnConfirm: false
        						},
        						function(isConfirm){
        						if(isConfirm){
        						window.location="conceptos";
        						}
        						});
    						</script>';

    				} else {

    					echo'<script>
    						swal({
        						title:"¡Registro Fallido!",
        						text:"¡Ocurrio un error, revise los datos!",
        						type:"error",
        						confirmButtonText:"Cerrar",
        						closeOnConfirm: false
    						});
    						</script>';

    				}


    			} else {

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
    						window.location="conceptos";
    						}
    						});
    						</script>';


    			}
    		}

    	}

/*=============================================
        EDITAR CONCEPTO
=============================================*/

    static public function ctrEditarConcepto(){

            if(isset($_POST["descConceptoE"])){

                #REALIZAMOS LA VALIDACION DEL LADO DEL SERVIDOR

                if (preg_match('/^[0-9a-zA-ZñÑáéíóúüÁÉÍÓÚÜ\s\.]+$/', $_POST["descConceptoE"])){

                    $datosController = array('id' =>$_POST["idConceptoE"],
                                             'codigo' =>ucwords($_POST["codConceptoE"]),
                                             'descripcion' =>ucwords($_POST["descConceptoE"]),
                                             'porcentaje' =>$_POST["porcentajeConceptoE"],
                                             'tipo' =>ucwords($_POST["tipoConceptoE"]),
                                             'fijo' =>$_POST["fijoConceptoE"],
                                             'unidades' =>$_POST["eunidadesConcepto"]);
                    $tabla = "Concepto";

                    $respuesta = ModeloPayment::mdlEditarConcepto($tabla, $datosController);

                    if($respuesta == "ok"){

                        echo'<script>
                            swal({
                                title:"Modificación Exitosa!",
                                text:"¡El concepto ha sido creado correctamente!",
                                type:"success",
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                                },
                                function(isConfirm){
                                if(isConfirm){
                                window.location="conceptos";
                                }
                            });
                            </script>';

                    } else {

                        echo'<script>
                                swal({
                                title:"¡Registro Fallido!",
                                text:"¡Ocurrio un error, revise los datos!",
                                type:"error",
                                confirmButtonText:"Cerrar",
                                closeOnConfirm: false
                            });
                            </script>';

                    }


                } else {

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
                                window.location="conceptos";
                                }
                            });
                            </script>';


                }
            }

        }

/*=============================================
        ELIMINAR CONCEPTOS
=============================================*/

    static public function ctrEliminarConcepto($valor){

        $tabla = "Concepto";

        $respuesta = ModeloPayment::mdlEliminarConcepto($tabla, $valor);

        return $respuesta;

    }

/*=============================================
        TRAER CONCEPTOS 				  
=============================================*/

	static public function ctrTraerConceptos(){

		$respuesta = ModeloPayment::mdlTraerConceptos("Concepto");

		foreach ($respuesta as $row => $item){

			echo '<option value="'.$item["ConceptoID"].'">'.$item["Descripcion"].'</option>';
		}
	
	}

/*=============================================
        MEJOR SUELDO                   
=============================================*/

    static public function crtMejorSueldo($idEmpleado){

        $tabla = "Liquidacion";

        $respuesta = ModeloPayment::mdlMejorSueldo($tabla, $idEmpleado);

        return $respuesta;    
    }

/*=============================================
        MOSTRAR LIQUIDACION
=============================================*/

    static public function ctrMostrarLiquidacion($item, $valor){

        $tabla = "Liquidacion";

        $respuesta = ModeloPayment::mdlMostrarLiquidacion($tabla, $item, $valor);

        return $respuesta;

    }

/*=============================================
        MOSTRAR LIQUIDACIONES CONFECCIONADAS
=============================================*/

    static public function ctrMostrarLiquidacionesConfeccionadas(){

        $tabla = "Liquidacion";

        $respuesta = ModeloPayment::mdlMostrarLiquidacionesConfeccionadas($tabla);

        return $respuesta;

    }

/*=============================================
        REGISTRAR BOLETA LIQUIDACION
=============================================*/

    static public function ctrRegistrarBoleta(){

            if(isset($_POST["tipoLiquidacionBoleta"])){

                #REALIZAMOS LA VALIDACION DEL LADO DEL SERVIDOR

                if (preg_match('/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s\.]+$/', $_POST["tipoLiquidacionBoleta"])){

                    
                    $listaConceptos = json_decode($_POST["listadoConceptos"], true);

                    date_default_timezone_set("America/Argentina/Tucuman");
                    $fechaVentaTemp = date('Y-m-d');
                    $hora = date('H:i:s');
                    $FechaConfeccion = $fechaVentaTemp.' '.$hora;
                    
                    $datosController = array('Tipo' =>$_POST["tipoLiquidacionBoleta"],
                                             'EmpleadoID' =>$_POST["empleadoBoleta"],
                                             'Estado' =>"Confeccionada",
                                             'FechaConfeccion' =>$FechaConfeccion,
                                             'Mes' =>$_POST["mesPeriodo"],
                                             'Anio' =>$_POST["anioPeriodo"],
                                             'TotalRemunerativos' =>$_POST["totalHaberesCdesc"],
                                             'TotalNoRemunerativos' =>$_POST["totalHaberesSdesc"],
                                             'TotalRetenciones' =>$_POST["totalRetencion"],
                                             'TotalNeto' =>$_POST["totalNetoBoleta"]);
                    
                    $tabla = "Liquidacion";

                    $tablaLiquidacionDetalle = "LiquidacionDetalle";
                    
                    $idLiquidacion = ModeloPayment::mdlRegistrarBoleta($tabla, $datosController);

                    if ($idLiquidacion != "error") {
                        
                        foreach ($listaConceptos as $key => $value) {
                            
                            $conceptoID = $value["ConceptoID"];
                            $total = $value["Total"];
                            $unidades = $value["Unidades"];

                            //REGISTRAMOS EL PRODUCTO EN EL DETALLE
                            $registroDetalle = ModeloPayment::mdlRegistrarDetalleLiquidacion($tablaLiquidacionDetalle, $idLiquidacion, $conceptoID, $total, $unidades);
                        
                        }

                        if($registroDetalle == "ok"){

                            echo'<script>
                                swal({
                                    title:"¡Registro Exitoso!",
                                    text:"¡La boleta se creo correctamente!",
                                    type:"success",
                                    confirmButtonText: "Cerrar",
                                    closeOnConfirm: false
                                    },
                                    function(isConfirm){
                                    if(isConfirm){
                                    window.location="liquidaciones";
                                    }
                                    });
                                </script>';

                        } else {

                            echo'<script>
                                swal({
                                    title:"¡Registro Fallido!",
                                    text:"¡Ocurrio un error, revise los datos!",
                                    type:"error",
                                    confirmButtonText:"Cerrar",
                                    closeOnConfirm: false
                                });
                                </script>';

                        }
                    

                    } else {

                        echo'<script>
                                swal({
                                    title:"¡Registro Fallido!",
                                    text:"¡Ocurrio un error, revise los datos!",
                                    type:"error",
                                    confirmButtonText:"Cerrar",
                                    closeOnConfirm: false
                                });
                                </script>';


                    } // FIN INSERTAR LIQUIDACION
                    
                } else {

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
                            window.location="liquidaciones";
                            }
                            });
                            </script>';


                }
            }

        }

/*=============================================
        EDITAR BOLETA LIQUIDACION
=============================================*/

    static public function ctrEditarBoleta(){

            if(isset($_POST["idBoletaLiquidacion"])){

                #REALIZAMOS LA VALIDACION DEL LADO DEL SERVIDOR

                if (preg_match('/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s\.]+$/', $_POST["idBoletaLiquidacion"])){

                    $tabla = "Liquidacion";
                    $tablaLiquidacionDetalle = "LiquidacionDetalle";
                    $idLiquidacion = $_POST["idBoletaLiquidacion"];

                    //ELIMINAMOS PRIMERO EL DETALLE DE LA LIQUIDACION

                    $eliminoDetalle = ModeloPayment::mdlEliminarDetalleLiquidacion($tablaLiquidacionDetalle, $idLiquidacion);

                    $listaConceptos = json_decode($_POST["listadoConceptos"], true);

                    date_default_timezone_set("America/Argentina/Tucuman");
                    $fechaVentaTemp = date('Y-m-d');
                    $hora = date('H:i:s');
                    $FechaConfeccion = $fechaVentaTemp.' '.$hora;
                    
                    $datosController = array('LiquidacionID' =>$_POST["idBoletaLiquidacion"],
                                             'Tipo' =>$_POST["tipoLiquidacionBoleta"],
                                             'EmpleadoID' =>$_POST["empleadoBoleta"],
                                             'Estado' =>"Confeccionada",
                                             'FechaConfeccion' =>$FechaConfeccion,
                                             'Mes' =>$_POST["mesPeriodo"],
                                             'Anio' =>$_POST["anioPeriodo"],
                                             'TotalRemunerativos' =>$_POST["totalHaberesCdesc"],
                                             'TotalNoRemunerativos' =>$_POST["totalHaberesSdesc"],
                                             'TotalRetenciones' =>$_POST["totalRetencion"],
                                             'TotalNeto' =>$_POST["totalNetoBoleta"]);


                    $editoLiquidacion = ModeloPayment::mdlEditarBoleta($tabla, $datosController);

                    if ($editoLiquidacion != "error") {
                        
                        foreach ($listaConceptos as $key => $value) {
                            
                            $conceptoID = $value["ConceptoID"];
                            $total = $value["Total"];
                            $unidades = $value["Unidades"];

                            //REGISTRAMOS EL PRODUCTO EN EL DETALLE
                            $registroDetalle = ModeloPayment::mdlRegistrarDetalleLiquidacion($tablaLiquidacionDetalle, $idLiquidacion, $conceptoID, $total, $unidades);
                        
                        }

                        if($registroDetalle == "ok"){

                            echo'<script>
                                swal({
                                    title:"Modificacion Exitosa!",
                                    text:"¡La boleta se modificó correctamente!",
                                    type:"success",
                                    confirmButtonText: "Cerrar",
                                    closeOnConfirm: false
                                    },
                                    function(isConfirm){
                                    if(isConfirm){
                                    window.location="liquidaciones";
                                    }
                                    });
                                </script>';

                        } else {

                            echo'<script>
                                swal({
                                    title:"¡Registro Fallido!",
                                    text:"¡Ocurrio un error, revise los datos!",
                                    type:"error",
                                    confirmButtonText:"Cerrar",
                                    closeOnConfirm: false
                                });
                                </script>';

                        }
                    

                    } else {

                        echo'<script>
                                swal({
                                    title:"¡Registro Fallido!",
                                    text:"¡Ocurrio un error, revise los datos!",
                                    type:"error",
                                    confirmButtonText:"Cerrar",
                                    closeOnConfirm: false
                                });
                                </script>';


                    } // FIN INSERTAR LIQUIDACION
                    
                } else {

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
                            window.location="liquidaciones";
                            }
                            });
                            </script>';


                }
            }

        }

/*=============================================
        ELIMINAR LIQUIDACION
=============================================*/

    static public function ctrEliminarLiquidacion($idLiquidacion){

        $tabla = "Liquidacion";
        $tablaLiquidacionDetalle = "LiquidacionDetalle";

        //ELIMINAMOS PRIMERO EL DETALLE DE LA LIQUIDACION

        $eliminoDetalle = ModeloPayment::mdlEliminarDetalleLiquidacion($tablaLiquidacionDetalle, $idLiquidacion);

        //ELIMINAMOS LA LIQUIDACION

        $respuesta = ModeloPayment::mdlEliminarLiquidacion($tabla, $idLiquidacion);    

        if($respuesta=="ok"){

            echo 0;

        }else{

            echo 1;

        }

    }

/*=============================================
        ACTUALIZAR LIQUIDACION           
=============================================*/

    static public function ctrActualizarLiquidacion($item1, $valor1, $valor2){

        $tabla = "Liquidacion";

        $respuesta = ModeloPayment::mdlActualizarLiquidacion($tabla, $item1, $valor1, $valor2);

        return $respuesta;

    }


}