<?php

class ControladorInsumos{

/*=============================================
        MOSTRAR INSUMOS
=============================================*/

    static public function ctrMostrarInsumos($item, $valor){

        $tabla1 = "Insumos";

        $tabla2 = "Rubro";

        $respuesta = ModeloInsumos::mdlMostrarInsumos($tabla1, $tabla2, $item, $valor);

        return $respuesta;

    }

/*=============================================
        MOSTRAR INSUMOS/PRODUCTOS COMPRA
=============================================*/

    static public function ctrMostrarInsumosCompra($item, $valor){

        $tabla1 = "Insumos";

        $tabla2 = "Producto";

        $respuesta = ModeloInsumos::mdlMostrarInsumosCompra($tabla1, $tabla2, $item, $valor);

        return $respuesta;

    }

/*=============================================
        MOSTRAR INSUMOS DISPONIBLES
=============================================*/

    static public function ctrMostrarInsumosDisponibles(){

        $tabla1 = "Insumos";

        $tabla2 = "Rubro";

        $respuesta = ModeloInsumos::mdlMostrarInsumosDisponibles($tabla1, $tabla2);

        return $respuesta;

    }

/*=============================================
		LISTADO DE RUBROS
=============================================*/

	static public function 	ctrListarRubros(){

		$respuesta = ModeloInsumos::mdlListarRubros("Rubro");

		foreach ($respuesta as $row => $item){

			echo '<option value="'.$item["RubroID"].'">'.$item["Nombre"].'</option>';
		}

	}

/*=============================================
        LISTADO DE INSUMOS
=============================================*/

    static public function  ctrListarInsumos(){

        $respuesta = ModeloInsumos::mdlListarInsumos("Insumos");

        foreach ($respuesta as $row => $item){

            echo '<option value="'.$item["InsumosID"].'">'.$item["Nombre"].'</option>';
        }

    }

/*=============================================
        REGISTRAR INSUMO
=============================================*/

    static public function ctrRegistrarInsumo(){

    		if(isset($_POST["nombreInsumo"])){

    			#REALIZAMOS LA VALIDACION DEL LADO DEL SERVIDOR

    			if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s.]+$/', $_POST["nombreInsumo"]) &&
    				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s.]+$/', $_POST["rubroInsumo"]) &&
    				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s.]+$/', $_POST["medidaInsumo"]) &&
    				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s.]+$/', $_POST["sMinimoInsumo"]) &&
    				preg_match('/^[0-9]+$/', $_POST["pCompra"])){

    				$datosController = array('nombre' =>ucwords($_POST["nombreInsumo"]),
                                             'codigo' =>ucwords($_POST["codigoInsumo"]),
                                             'rubro' =>$_POST["rubroInsumo"],
                                             'medida' => $_POST["medidaInsumo"],
                                             'sMinimo' =>$_POST["sMinimoInsumo"],
                                             'precio' =>$_POST["pCompra"]);

                    $tabla = "Insumos";

                    $respuesta = ModeloInsumos::mdlRegistrarInsumo($tabla, $datosController);

    				if($respuesta == "ok"){

    					echo'<script>
        						swal({
            						title:"¡Registro Exitoso!",
            						text:"¡El insumo se agregó correctamente!",
            						type:"success",
            						confirmButtonText: "Cerrar",
            						closeOnConfirm: false
            						},
            						function(isConfirm){
            						  if(isConfirm){
            						  window.location="insumos";
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
        						  window.location="insumos";
        						}
    						});
    						</script>';


    			}
    		}

    	}

/*=============================================
        EDITAR INSUMO
=============================================*/

    static public function ctrEditarInsumo(){

    		if(isset($_POST["enombreInsumo"])){

    			#REALIZAMOS LA VALIDACION DEL LADO DEL SERVIDOR

    			if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s.]+$/', $_POST["enombreInsumo"]) &&
    				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s.]+$/', $_POST["erubroInsumo"]) &&
    				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s.]+$/', $_POST["emedidaInsumo"]) &&
    				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s.]+$/', $_POST["esMinimoInsumo"])
    				){

    				$datosController = array('idInsumo' =>$_POST["idInsumo"],
    										 'nombre' =>ucwords($_POST["enombreInsumo"]),
                                             'rubro' =>$_POST["idRubro"],
                                             'medida' => $_POST["emedidaInsumo"],
                                             'sMinimo' =>$_POST["esMinimoInsumo"],
                                             'precio' =>$_POST["epCompra"]);

    				$tabla = "Insumos";

                    $respuesta = ModeloInsumos::mdlEditarInsumo($tabla, $datosController);

    				if($respuesta == "ok"){

    					echo'<script>
    						swal({
        						title:"Modificación Exitosa!",
        						text:"¡El insumo se modificó correctamente!",
        						type:"success",
        						confirmButtonText: "Cerrar",
        						closeOnConfirm: false
        						},
        						function(isConfirm){
        						if(isConfirm){
        						window.location="insumos";
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
    						window.location="insumos";
    						}
    						});
    						</script>';


    			}
    		}

    	}

/*=============================================
        ELIMINAR INSUMO
=============================================*/

	static public function ctrEliminarInsumo($datos){

		$tabla = "Insumos";

        $respuesta = ModeloInsumos::mdlEliminarInsumo($tabla, $datos);

		if($respuesta=="ok"){

			echo 0;

		}else{

			echo 1;

		}

	}

  /*=============================================
          	DESCARGAR REPORTE
  =============================================*/

    static public function ctrDescararReporte(){

        if (isset($_GET["reporte"])) {

          $tabla1 = "Insumos";
          $tabla2 = "Rubro";

          $item = null;
        	$valor = null;

  		    $insumos = ModeloInsumos::mdlMostrarInsumos($tabla1, $tabla2, $item, $valor);

        	//CREAMOS EL ARCHIVO DE EXCEL

        	$name = 'reporte-insumos.xls';
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
  					<td colspan=7 align='center' bgcolor='#9DD1A7'>Reporte de insumos</td>
  				</tr>
  				<tr>
  					<th align='center' bgcolor='#88C1E3'>CÓDIGO</th>
  					<th align='center' bgcolor='#88C1E3'>NOMBRE</th>
  					<th align='center' bgcolor='#88C1E3'>MEDIDA</th>
  					<th align='center' bgcolor='#88C1E3'>STOCK</th>
  					<th align='center' bgcolor='#88C1E3'>STOCK MINIMO</th>
  					<th align='center' bgcolor='#88C1E3'>PRECIO DE COMPRA</th>
  					<th align='center' bgcolor='#88C1E3'>RUBRO</th>
  				</tr>");

  		foreach ($insumos as $row => $item){

  			$insumo = ControladorInsumos::ctrMostrarInsumos("InsumosID", $item["InsumosID"]);

  		 	echo utf8_decode("<tr>
            					 			<td bgcolor='#FAEDB1'align='center'>".$item["Codigo"]."</td>
            								<td bgcolor='#FAEDB1'align='left'>".$item["Nombre"]."</td>
            								<td bgcolor='#FAEDB1'align='left'>".$item["Medida"]."</td>
            								<td bgcolor='#FAEDB1'align='right'>".$item["Stock"]."</td>
            								<td bgcolor='#FAEDB1'align='right'>".$item["StockMinimo"]."</td>
            								<td bgcolor='#FAEDB1'align='right'>$".$item["PrecioCompra"]."</td>
            								<td bgcolor='#FAEDB1'align='left'>".$item["Rubro"]."</td>
            							</tr>");
  		}

  		echo "</table>";

        }

    }

}
