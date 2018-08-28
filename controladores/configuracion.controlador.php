<?php

class ControladorConfiguracion{

//////////////////////////////////////////////////////////////////////////  RUBROS ////////////////////////////////////////////////////////////////

/*==========================================
        MOSTRAR RUBROS
==========================================*/

    static public function ctrMostrarRubros($item, $valor){

        $tabla = "Rubro";

        $respuesta = ModeloConfiguracion::mdlMostrarRubros($tabla, $item, $valor);

        return $respuesta;

    }

/*=============================================
        REGISTRAR RUBRO
=============================================*/

    static public function ctrRegistrarRubro(){

    		if(isset($_POST["rubro"])){

    			#REALIZAMOS LA VALIDACION DEL LADO DEL SERVIDOR

    			if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/', $_POST["rubro"])){

    				$datosController = array('rubro' =>ucwords($_POST["rubro"]),
                                             'tipo' =>$_POST["tipoRubro"] );

                    $respuesta = ModeloConfiguracion::mdlRegistrarRubro($datosController, "Rubro");

    				if($respuesta == "ok"){

    					echo'<script>
    						swal({
        						title:"¡Registro Exitoso!",
        						text:"¡El rubro ha sido creado correctamente!",
        						type:"success",
        						confirmButtonText: "Cerrar",
        						closeOnConfirm: false
        						},
        						function(isConfirm){
        						if(isConfirm){
        						window.location="rubros";
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
        						window.location="rubros";
        						}
    						});
    						</script>';


    			}
    		}

    	}

/*=============================================
        MODIFICAR RUBRO
=============================================*/

    static public function ctrModificarRubro(){

		if(isset($_POST["erubro"])){

			#REALIZAMOS LA VALIDACION DEL LADO DEL SERVIDOR

			if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/', $_POST["erubro"])){

				$datosController = array('IdRubro' => $_POST["idRubro"],
                                         'Rubro' => ucwords($_POST["erubro"]),
                                         'Tipo' => ucwords($_POST["etipoRubro"]));

                $respuesta = ModeloConfiguracion::mdlModificarRubro($datosController, "Rubro");

				if($respuesta == "ok"){

					echo'<script>
						swal({
    						title:"¡Registro Exitoso!",
    						text:"¡El rubro se modificó correctamente!",
    						type:"success",
    						confirmButtonText: "Cerrar",
    						closeOnConfirm: false
    						},
    						function(isConfirm){
    						if(isConfirm){
    						window.location="rubros";
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
    						window.location="rubros";
    						}
						});
						</script>';


			}
		}

	}

/*=============================================
        ELIMINAR RUBRO
=============================================*/

    static public function ctrEliminarRubro($valor){

        $idRubro = $valor;

        $respuesta = ModeloConfiguracion::mdlEliminarRubro($idRubro, "Rubro");

        if($respuesta=="ok"){

			echo 0;

		} else {

			echo 1;

		}

    }

//////////////////////////////////////////////////////////////////////////  ROLES ////////////////////////////////////////////////////////////////

/*==========================================
        MOSTRAR ROLES
==========================================*/

    static public function ctrMostrarRoles($item, $valor){

        $tabla = "Roles";

        $respuesta = ModeloConfiguracion::mdlMostrarRoles($tabla, $item, $valor);

        return $respuesta;

    }

/*=============================================
        REGISTRAR ROL
=============================================*/

    static public function ctrRegistrarRol(){

    		if(isset($_POST["rol"])){

    			#REALIZAMOS LA VALIDACION DEL LADO DEL SERVIDOR

    			if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/', $_POST["rol"])){

    				$rol = ucwords($_POST["rol"]);

                    $respuesta = ModeloConfiguracion::mdlRegistrarRol($rol, "Roles");

    				if($respuesta == "ok"){

    					echo'<script>
    						swal({
        						title:"¡Registro Exitoso!",
        						text:"¡El rol ha sido creado correctamente!",
        						type:"success",
        						confirmButtonText: "Cerrar",
        						closeOnConfirm: false
        						},
        						function(isConfirm){
        						if(isConfirm){
        						window.location="roles";
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
        						window.location="roles";
        						}
    						});
    						</script>';


    			}
    		}

    	}

/*=============================================
        MODIFICAR ROL
=============================================*/

    static public function ctrModificarRol(){

		if(isset($_POST["erol"])){

			#REALIZAMOS LA VALIDACION DEL LADO DEL SERVIDOR

			if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/', $_POST["erol"])){

				$datosController = array('idRol' => $_POST["idRol"],
                                         'Rol' => ucwords($_POST["erol"]));

                $respuesta = ModeloConfiguracion::mdlModificarRol($datosController, "Roles");

				if($respuesta == "ok"){

					echo'<script>
						swal({
    						title:"¡Registro Exitoso!",
    						text:"¡El rol se modificó correctamente!",
    						type:"success",
    						confirmButtonText: "Cerrar",
    						closeOnConfirm: false
    						},
    						function(isConfirm){
    						if(isConfirm){
    						window.location="roles";
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
    						window.location="roles";
    						}
						});
						</script>';


			}
		}

	}

/*=============================================
        ELIMINAR ROL
=============================================*/

    static public function ctrEliminarRol($valor){

        $idRubro = $valor;

        $respuesta = ModeloConfiguracion::mdlEliminarRol($idRubro, "Roles");

        if($respuesta=="ok"){

			echo 0;

		} else {

			echo 1;

		}

    }

//////////////////////////////////////////////////////////////////////////  PUESTOS ////////////////////////////////////////////////////////////////

/*==========================================
        MOSTRAR PUESTOS
==========================================*/

    static public function ctrMostrarPuestos($item, $valor){

        $tabla = "Puesto";

        $respuesta = ModeloConfiguracion::mdlMostrarPuestos($tabla, $item, $valor);

        return $respuesta;

    }

/*=============================================
        REGISTRAR PUESTO
=============================================*/

    static public function ctrRegistrarPuesto(){

    		if(isset($_POST["puesto"])){

    			#REALIZAMOS LA VALIDACION DEL LADO DEL SERVIDOR

    			if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/', $_POST["puesto"])){

    				$puesto = ucwords($_POST["puesto"]);

                    $respuesta = ModeloConfiguracion::mdlRegistrarPuesto($puesto, "Puesto");

    				if($respuesta == "ok"){

    					echo'<script>
    						swal({
        						title:"¡Registro Exitoso!",
        						text:"¡El puesto ha sido creado correctamente!",
        						type:"success",
        						confirmButtonText: "Cerrar",
        						closeOnConfirm: false
        						},
        						function(isConfirm){
        						if(isConfirm){
        						window.location="puestos";
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
        						window.location="puestos";
        						}
    						});
    						</script>';


    			}
    		}

    	}

/*=============================================
        MODIFICAR PUESTO
=============================================*/

    static public function ctrModificarPuesto(){

		if(isset($_POST["epuesto"])){

			#REALIZAMOS LA VALIDACION DEL LADO DEL SERVIDOR

			if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/', $_POST["epuesto"])){

				$datosController = array('idPuesto' => $_POST["idPuesto"],
                                         'Puesto' => ucwords($_POST["epuesto"]));

                $respuesta = ModeloConfiguracion::mdlModificarPuesto($datosController, "Puesto");

				if($respuesta == "ok"){

					echo'<script>
						swal({
    						title:"¡Registro Exitoso!",
    						text:"¡El puesto se modificó correctamente!",
    						type:"success",
    						confirmButtonText: "Cerrar",
    						closeOnConfirm: false
    						},
    						function(isConfirm){
    						if(isConfirm){
    						window.location="puestos";
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
    						window.location="puestos";
    						}
						});
						</script>';


			}
		}

	}

/*=============================================
        ELIMINAR PUESTO
=============================================*/

    static public function ctrEliminarPuesto($valor){

        $idPuesto = $valor;

        $respuesta = ModeloConfiguracion::mdlEliminarPuesto($idPuesto, "Puesto");

        if($respuesta=="ok"){

			echo 0;

		} else {

			echo 1;

		}

    }

//////////////////////////////////////////////////////////////////////////  CATEGORIAS ////////////////////////////////////////////////////////////////

/*==========================================
        MOSTRAR CATEGORIAS
==========================================*/

    static public function ctrMostrarCategorias($item, $valor){

        $tabla1 = "Categorias";
        $tabla2 = "Puesto";

        $respuesta = ModeloConfiguracion::mdlMostrarCategorias($tabla1, $tabla2, $item, $valor);

        return $respuesta;

    }

/*=============================================
        REGISTRAR CATEGORIA
=============================================*/

    static public function ctrRegistrarCategoria(){

            if(isset($_POST["categoria"])){

                #REALIZAMOS LA VALIDACION DEL LADO DEL SERVIDOR

                if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/', $_POST["categoria"])&&
                    preg_match('/^[0-9.]+$/', $_POST["sueldoBasico"])){

                    $datosController = array('categoria' => ucwords($_POST["categoria"]),
                                             'puesto' => $_POST["puesto"],
                                             'sueldo' =>$_POST["sueldoBasico"]);

                    $respuesta = ModeloConfiguracion::mdlRegistrarCategoria($datosController, "Categorias");

                    if($respuesta == "ok"){

                        echo'<script>
                            swal({
                                title:"¡Registro Exitoso!",
                                text:"¡La categoría se creó correctamente!",
                                type:"success",
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                                },
                                function(isConfirm){
                                if(isConfirm){
                                window.location="categorias";
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
                                text:"¡Solo se permiten números!",
                                type:"warning",
                                confirmButtonText:"Cerrar",
                                closeOnConfirm:false
                                },
                                function(isConfirm){
                                if(isConfirm){
                                window.location="categorias";
                                }
                            });
                            </script>';


                }
            }

        }

/*=============================================
        MODIFICAR CATEGORIA
=============================================*/

    static public function ctrModificarCategoria(){

        if(isset($_POST["ecategoria"])){

            #REALIZAMOS LA VALIDACION DEL LADO DEL SERVIDOR

            if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/', $_POST["ecategoria"])&&
                preg_match('/^[0-9.]+$/', $_POST["esueldoBasico"])){

                $datosController = array('idCategoria' => $_POST["idCategoria"],
                                         'Categoria' => ucwords($_POST["ecategoria"]),
                                         'Puesto' => ucwords($_POST["epuesto"]),
                                         'Sueldo' =>$_POST["esueldoBasico"]);


                $respuesta = ModeloConfiguracion::mdlModificarCategoria($datosController, "Categorias");

                if($respuesta == "ok"){

                    echo'<script>
                        swal({
                            title:"¡Registro Exitoso!",
                            text:"¡La categoria se modificó correctamente!",
                            type:"success",
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                            },
                            function(isConfirm){
                            if(isConfirm){
                            window.location="categorias";
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
                            window.location="categorias";
                            }
                        });
                        </script>';


            }
        }

    }

/*=============================================
        ELIMINAR CATEGORIA
=============================================*/

    static public function ctrEliminarCategoria($valor){

        $idCategoria = $valor;

        $tabla = "Categorias";

        $respuesta = ModeloConfiguracion::mdlEliminarCategoria($idCategoria, $tabla);

        if($respuesta=="ok"){

            echo 0;

        } else {

            echo 1;

        }

    }


//////////////////////////////////////////////////////////////////////////  IVA ////////////////////////////////////////////////////////////////

/*==========================================
        MOSTRAR IVA
==========================================*/

    static public function ctrMostrarIva($item, $valor){

        $tabla = "IVA";

        $respuesta = ModeloConfiguracion::mdlMostrarIva($tabla, $item, $valor);

        return $respuesta;

    }

/*=============================================
        REGISTRAR IVA
=============================================*/

    static public function ctrRegistraIva(){

            if(isset($_POST["iva"])){

                #REALIZAMOS LA VALIDACION DEL LADO DEL SERVIDOR

                if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9-°.\s]+$/', $_POST["iva"])){

                    $iva = ucwords($_POST["iva"]);

                    $respuesta = ModeloConfiguracion::mdlRegistrarIva($iva, "IVA");

                    if($respuesta == "ok"){

                        echo'<script>
                            swal({
                                title:"¡Registro Exitoso!",
                                text:"¡El iva ha sido creado correctamente!",
                                type:"success",
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                                },
                                function(isConfirm){
                                if(isConfirm){
                                window.location="iva";
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
                            window.location="iva";
                            }
                            });
                            </script>';


                }
            }

        }

/*=============================================
        MODIFICAR IVA
=============================================*/

    static public function ctrModificarIva(){

        if(isset($_POST["eiva"])){

            #REALIZAMOS LA VALIDACION DEL LADO DEL SERVIDOR

            if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9-°.\s]+$/', $_POST["eiva"])){

                $datosController = array('idIva' => $_POST["idIva"],
                                         'Descripcion' => ucwords($_POST["eiva"]));


                $respuesta = ModeloConfiguracion::mdlModificarIva($datosController, "IVA");

                if($respuesta == "ok"){

                    echo'<script>
                        swal({
                            title:"¡Registro Exitoso!",
                            text:"¡El impuesto se modificó correctamente!",
                            type:"success",
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                            },
                            function(isConfirm){
                            if(isConfirm){
                            window.location="iva";
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
                            window.location="iva";
                            }
                        });
                        </script>';


            }
        }

    }

/*=============================================
        ELIMINAR IVA
=============================================*/

    static public function ctrEliminaIva($valor){

        $idPuesto = $valor;

        $respuesta = ModeloConfiguracion::mdlEliminarIva($idPuesto, "IVA");

        if($respuesta=="ok"){

            echo 0;

        } else {

            echo 1;

        }

    }

//////////////////////////////////////////////////////////////////////////  PDV ////////////////////////////////////////////////////////////////

/*==========================================
        MOSTRAR PDV
==========================================*/

    static public function ctrMostrarPdvs($item, $valor){

        $tabla1 = "PuntoVenta";
        $tabla2 = "Domicilio";
        $tabla3 = "Localidad";
        $tabla4 = "Barrio";
        $tabla5 = "Telefono";

        $respuesta = ModeloConfiguracion::mdlMostrarPdvs($tabla1, $tabla2, $tabla3, $tabla4, $tabla5, $item, $valor);

        return $respuesta;

    }

/*==========================================
        MOSTRAR PDV ACTIVO
==========================================*/

    static public function ctrMostrarPdvActivo(){

        $tabla1 = "PuntoVenta";
        $tabla2 = "Domicilio";
        $tabla3 = "Localidad";
        $tabla4 = "Barrio";
        $tabla5 = "Telefono";

        $respuesta = ModeloConfiguracion::mdlMostrarPdvActivo($tabla1, $tabla2, $tabla3, $tabla4, $tabla5);

        return $respuesta;

    }

/*=============================================
        REGISTRAR PDV
=============================================*/

    static public function ctrRegistrarPdv(){

            if(isset($_POST["pdvNombre"])){

                #REALIZAMOS LA VALIDACION DEL LADO DEL SERVIDOR

                if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/', $_POST["pdvNombre"])&&
                    preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/', $_POST["callePdv"])&&
                    preg_match('/^[0-9]+$/', $_POST["numCallePdv"])&&
                    preg_match('/^[0-9]*$/', $_POST["pisoPdv"]) &&
                    preg_match('/^[a-zA-Z0-9_]*$/', $_POST["deptoPdv"]) &&
                    preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/', $_POST["localidadPdv"]) &&
                    preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/', $_POST["barrioPdv"]) &&
                    preg_match('/^[0-9]*$/', $_POST["codPostalPdv"])){

                    $datosController = array('pdvNombre' => ucwords($_POST["pdvNombre"]),
                                             'cuit' =>$_POST["pdvCUIT"],
                                             'ingresos' =>$_POST["pdvIngresosBrutos"],
                                             'inicio' =>$_POST["pdvInicioActividades"],
                                             'calle' =>ucwords($_POST["callePdv"]),
                                             'numCalle' =>$_POST["numCallePdv"],
                                             'piso' =>$_POST["pisoPdv"],
                                             'depto' =>ucwords($_POST["deptoPdv"]),
                                             'localidad' =>ucwords($_POST["localidadPdv"]),
                                             'barrio' =>ucwords($_POST["barrioPdv"]),
                                             'codPostal' =>$_POST["codPostalPdv"],
                                             'codArea' =>$_POST["pdvCodArea"],
                                             'telefono' =>$_POST["pdvTelefono"]);

                    $tabla1 = "PuntoVenta";
                    $tabla2 = "Domicilio";
                    $tabla3 = "Localidad";
                    $tabla4 = "Barrio";
                    $tabla5 = "Telefono";

                    $respuesta = ModeloConfiguracion::mdlRegistrarPdv($datosController, $tabla1, $tabla2, $tabla3, $tabla4, $tabla5);

                    if($respuesta == "ok"){

                        echo'<script>
                            swal({
                                title:"¡Registro Exitoso!",
                                text:"¡El Punto de venta se creó correctamente!",
                                type:"success",
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                                },
                                function(isConfirm){
                                if(isConfirm){
                                window.location="puntoVenta";
                                }
                            });
                            </script>';

                    } else {

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


                } else {

                    echo '<script>
                            swal({
                            title:"¡Error!",
                            text:"¡No se permiten caracteres especiales!",
                            type:"warning",
                            confirmButtonText:"Cerrar",
                            closeOnConfirm:false
                            },
                            function(isConfirm){
                            if(isConfirm){
                            window.location="puntoVenta";
                            }
                            });
                            </script>';


                }
            }

        }

/*=============================================
        MODIFICAR PDV
=============================================*/

    static public function ctrModificarPdv(){

            if(isset($_POST["epdvNombre"])){

                #REALIZAMOS LA VALIDACION DEL LADO DEL SERVIDOR

                if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/', $_POST["epdvNombre"])&&
                    preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/', $_POST["ecallePdv"])&&
                    preg_match('/^[0-9]+$/', $_POST["enumCallePdv"])&&
                    preg_match('/^[0-9]*$/', $_POST["episoPdv"]) &&
                    preg_match('/^[a-zA-Z0-9_]*$/', $_POST["edeptoPdv"]) &&
                    preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/', $_POST["elocalidadPdv"]) &&
                    preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/', $_POST["ebarrioPdv"]) &&
                    preg_match('/^[0-9]*$/', $_POST["ecodPostalPdv"])){

                    
                    $datosController = array('idPdv' => $_POST["idPdv"],
                                             'pdvNombre' => ucwords($_POST["epdvNombre"]),
                                             'activo' =>$_POST["estadoPDV"],
                                             'cuit' =>$_POST["epdvCUIT"],
                                             'ingresos' =>$_POST["epdvIngresosBrutos"],
                                             'inicio' =>$_POST["epdvInicioActividades"],
                                             'calle' =>ucwords($_POST["ecallePdv"]),
                                             'numCalle' =>$_POST["enumCallePdv"],
                                             'piso' =>$_POST["episoPdv"],
                                             'depto' =>ucwords($_POST["edeptoPdv"]),
                                             'localidad' =>ucwords($_POST["elocalidadPdv"]),
                                             'barrio' =>ucwords($_POST["ebarrioPdv"]),
                                             'codPostal' =>$_POST["ecodPostalPdv"],
                                             'codArea' =>$_POST["epdvCodArea"],
                                             'telefono' =>$_POST["epdvTelefono"]);

                    $tabla1 = "PuntoVenta";
                    $tabla2 = "Domicilio";
                    $tabla3 = "Localidad";
                    $tabla4 = "Barrio";
                    $tabla5 = "Telefono";

                   $respuesta = ModeloConfiguracion::mdlModificarPdv($datosController, $tabla1, $tabla2, $tabla3, $tabla4, $tabla5);

                    if($respuesta == "ok"){

                        echo'<script>
                            swal({
                                title:"¡Registro Exitoso!",
                                text:"¡El Punto de venta se modificó correctamente!",
                                type:"success",
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                                },
                                function(isConfirm){
                                if(isConfirm){
                                window.location="puntoVenta";
                                }
                            });
                            </script>';

                    } else {

                        echo'<script>
                            swal({
                                title:"¡Registro Fallido!",
                                text:"¡Ocurrio un error, revise los datos! '.$respuesta.'",
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
                                text:"¡No se permiten caracteres especiales!",
                                type:"warning",
                                confirmButtonText:"Cerrar",
                                closeOnConfirm:false
                                },
                                function(isConfirm){
                                if(isConfirm){
                                window.location="puntoVenta";
                                }
                            });
                            </script>';


                }
            }

        }

/*=============================================
        ELIMINAR PDV
=============================================*/

    static public function ctrEliminarPdv($idPDV){

        $tabla1 = "PuntoVenta";
        $tabla2 = "Domicilio";
        $tabla3 = "Telefono";

        //ELIMINAMOS EL TELEFONO
        $telefono = ModeloConfiguracion::mdlEliminarPdv($tabla3, $idPDV);

        if($telefono=="ok"){

            //ELIMINAMOS EL DOMICILIO
            $domicilio = ModeloConfiguracion::mdlEliminarPdv($tabla2, $idPDV);

            if($domicilio=="ok"){

                //ELIMINAMOS EL DOMICILIO
                $pdv = ModeloConfiguracion::mdlEliminarPdv($tabla1, $idPDV);

                if($domicilio=="ok"){

                    echo 0;

                } else {

                    echo 1;

                }
            
            } else {

               echo 1;
                
            }

        } else {

            echo 1;

        }

    }

//////////////////////////////////////////////////////////////////////////  MEDIOS DE PAGO ////////////////////////////////////////////////////////////////

/*==========================================
        MOSTRAR MDP
==========================================*/

    static public function ctrMostrarMdPs($item, $valor){

        $tabla = "MedioPago"; 

        $respuesta = ModeloConfiguracion::mdlMostrarMdPs($tabla, $item, $valor);

        return $respuesta;

    }

/*=============================================
        REGISTRAR MDP
=============================================*/

    static public function ctrRegistrarMdp(){

            if(isset($_POST["mdpNombre"])){

                #REALIZAMOS LA VALIDACION DEL LADO DEL SERVIDOR

                if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/', $_POST["mdpNombre"])){

                    $datosController = ucwords($_POST["mdpNombre"]);

                    $respuesta = ModeloConfiguracion::mdlRegistrarMdp($datosController, "MedioPago");

                    if($respuesta == "ok"){

                        echo'<script>
                            swal({
                            title:"¡Registro Exitoso!",
                            text:"¡El Medio de pago se creó correctamente!",
                            type:"success",
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                            },
                            function(isConfirm){
                            if(isConfirm){
                            window.location="mediosDePago";
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
                            text:"¡No se permiten caracteres especiales!",
                            type:"warning",
                            confirmButtonText:"Cerrar",
                            closeOnConfirm:false
                            },
                            function(isConfirm){
                            if(isConfirm){
                            window.location="mediosDePago";
                            }
                            });
                            </script>';


                }
            }

        }

/*=============================================
        MODIFICAR MDP
=============================================*/

    static public function ctrModificarMdp(){

            if(isset($_POST["emdpNombre"])){

                #REALIZAMOS LA VALIDACION DEL LADO DEL SERVIDOR

                if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/', $_POST["emdpNombre"])){

                    $datosController = array('nombre' => ucwords($_POST["emdpNombre"]),
                                             'idMdp' => $_POST["idMedio"]);

                    $respuesta = ModeloConfiguracion::mdlModificarMdp($datosController, "MedioPago");

                    if($respuesta == "ok"){

                        echo'<script>
                            swal({
                            title:"¡Modificación Exitosa!",
                            text:"¡El Medio de pago se modificó correctamente!",
                            type:"success",
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                            },
                            function(isConfirm){
                            if(isConfirm){
                            window.location="mediosDePago";
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
                            text:"¡No se permiten caracteres especiales!",
                            type:"warning",
                            confirmButtonText:"Cerrar",
                            closeOnConfirm:false
                            },
                            function(isConfirm){
                            if(isConfirm){
                            window.location="mediosDePago";
                            }
                            });
                            </script>';


                }
            }

        }

/*=============================================
        ELIMINAR MDP
=============================================*/

    static public function ctrEliminarMdp($valor){

        $idMdp = $valor;

        $respuesta = ModeloConfiguracion::mdlEliminarMdp($idMdp, "MedioPago");

        if($respuesta=="ok"){

            echo 0;

        } else {

            echo 1;

        }

    }


}
