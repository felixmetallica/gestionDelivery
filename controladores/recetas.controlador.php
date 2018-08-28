<?php 

class ControladorRecetas{

/*=============================================
        MOSTRAR RECETA
=============================================*/

    static public function ctrMostrarRecetas($item, $valor){

        $tabla1 = "Receta";

        $tabla2 = "Producto";

        $respuesta = ModeloRecetas::mdlMostrarRecetas($tabla1, $tabla2, $item, $valor);

        return $respuesta;

    }

/*=============================================
        REGISTRAR RECETA
=============================================*/

    static public function ctrRegistrarReceta(){

       if(isset($_POST["productoReceta"])){

            if (preg_match('/^[0-9]+$/', $_POST["productoReceta"])){

                $tabla = "Receta";
                $idProducto = $_POST["productoReceta"];
                $listaInsumos = json_decode($_POST["listadoInsumos"], true);

                $idReceta = ModeloRecetas::mdlRegistrarReceta($tabla, $idProducto);

                if ($idReceta != "error") {
                
                $tablaRecetaDetalle = "RecetaDetalle";

                foreach ($listaInsumos as $key => $value) {
                    
                    $idInsumo = $value["idInsumo"]; 
                    $Cantidad = $value["cantidadInsumo"];
                    
                    $respuesta = ModeloRecetas::mdlRegistrarDetalleReceta($tablaRecetaDetalle, $idReceta, $idInsumo, $Cantidad);

                }

                if($respuesta = "ok"){

                    echo'<script>
                            swal({
                                title:"¡Registro Exitoso!",
                                text:"¡La receta se registró correctamente!",
                                type:"success",
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                            },
                                function(isConfirm){
                                    if(isConfirm){
                                        window.location="recetas";
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

            }// fin if receta error


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
                            window.location="recetas";
                            }
                            });
                            </script>';

            }

        } //if isset
                
    }

/*=============================================
        EDITAR RECETA
=============================================*/

    static public function ctrEditarReceta(){

       if(isset($_POST["idProductoReceta"])){

            if (preg_match('/^[0-9]+$/', $_POST["idProductoReceta"])){

                $tabla = "Receta";
                $idProducto = $_POST["idProductoReceta"];
                $idReceta = $_POST["idReceta"];
                $listaInsumos = json_decode($_POST["listadoInsumos"], true);

                $tablaRecetaDetalle = "RecetaDetalle";

                $eliminoDetalle = ModeloRecetas::mdlEliminarDetalleReceta($tablaRecetaDetalle, $idReceta);

                foreach ($listaInsumos as $key => $value) {
                    
                    $idInsumo = $value["idInsumo"]; 
                    $Cantidad = $value["cantidadInsumo"];
                    
                    $respuesta = ModeloRecetas::mdlRegistrarDetalleReceta($tablaRecetaDetalle, $idReceta, $idInsumo, $Cantidad);

                }

                if($respuesta = "ok"){

                    echo'<script>
                            swal({
                                title:"¡Registro Exitoso!",
                                text:"¡La receta se modificó correctamente!",
                                type:"success",
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                            },
                                function(isConfirm){
                                    if(isConfirm){
                                        window.location="recetas";
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
                            window.location="recetas";
                            }
                            });
                            </script>';

            }

        } //if isset
                
    }

/*=============================================
        LISTADO DE INSUMOS DE RECETA         
=============================================*/

    static public function ctrListadoInsumos($valor){

        $tabla1 = "Receta";

        $tabla2 = "RecetaDetalle";

        $tabla3 = "Insumos";

        $respuesta = ModeloRecetas::mdlListadoInsumos($tabla1, $tabla2, $tabla3, $valor);

        return $respuesta;
        
    }

/*=============================================
        ELIMINAR RECETA            
=============================================*/

    static public function ctrEliminarReceta($receta){

        $idReceta = $receta;
        $tabla = "Receta";
        $tablaRecetaDetalle = "RecetaDetalle";

        //ELIMINAMOS PRIMERO EL DETALLE DE LA VENTA

        $eliminoDetalle = ModeloRecetas::mdlEliminarDetalleReceta($tablaRecetaDetalle, $idReceta);

        //ELIMINAMOS LA RECETA

        $respuesta = ModeloRecetas::mdlEliminarReceta($tabla, $idReceta);    

        if($respuesta=="ok"){

            echo 0;

        }else{

            echo 1;

        }
    }







}