<?php

require_once "../controladores/payment.controlador.php";
require_once "../modelos/payment.modelo.php";

require_once "../controladores/empleados.controlador.php";
require_once "../modelos/empleados.modelo.php";

class AjaxPayment{

/*=============================================
        EDITAR CONCEPTO
=============================================*/

    public $idConcepto;
    
        public function ajaxEditarConcepto(){

        	$item = "ConceptoID";

            $valor = $this ->idConcepto;

            $respuesta = ControladorPayment::ctrMostrarConceptos($item, $valor);

            echo json_encode($respuesta);

        	   
		}

/*=============================================
        ELIMINAR CONCEPTO
=============================================*/

    public $eliminarConcepto;
    
        public function ajaxEliminarConcepto(){

        	$valor = $this ->eliminarConcepto;

            $respuesta = ControladorPayment::ctrEliminarConcepto($valor);

            echo $respuesta;

        	   
		}

/*=============================================
        TRAER CONCEPTOS
=============================================*/

    public $traerConceptos;
    public $traerRetenciones;
    
        public function ajaxTraerConceptos(){

        	if ($this->traerRetenciones == "ok") {
                
                $item = "Tipo"; 

                $valor = "3";

                $respuesta = ControladorPayment::ctrMostrarConceptosLiquidar($item, $valor);

                echo json_encode($respuesta);

            } else {

                $item = "Fijo";	

                $valor = "S";

                $respuesta = ControladorPayment::ctrMostrarConceptosLiquidar($item, $valor);

                echo json_encode($respuesta);

            }   

        	   
		}

/*=============================================
        AGREGAR CONCEPTO
=============================================*/

    public $idConceptoAgregar;
    
        public function ajaxAgregarConcepto(){

            $item = "ConceptoID"; 

            $valor = $this ->idConceptoAgregar;

            $respuesta = ControladorPayment::ctrMostrarConceptos($item, $valor);

            echo json_encode($respuesta);

               
        }

/*=============================================
        TRAER CONCEPTOS PARA AGREGAR
=============================================*/

    public $traerConceptosLiquidar;
    public $tipoBoleta;
        
        public function ajaxTraerConceptosLiquidar(){

            $item = "Fijo"; 

            $valor = "N";

            $datos = $this ->traerConceptosLiquidar;

            $tipo = $this ->tipoBoleta;

            $respuesta = ControladorPayment::ctrMostrarConceptosLiquidarDistintos($item, $valor, $datos, $tipo);

            echo json_encode($respuesta);
              
        }

/*=============================================
        ELIMINAR BOLETA
=============================================*/

    public $eliminarBoleta;
    
        public function ajaxEliminarBoleta(){

            $valor = $this ->eliminarBoleta;

            $respuesta = ControladorPayment::ctrEliminarLiquidacion($valor);

            echo $respuesta;

               
        }

/*=============================================
        TRAER CONCEPTO LIQUIDACION
=============================================*/

    public $traigoConcepto;
    
        public function ajaxTraerConceptoLiquidacion(){

            $valor = $this ->traigoConcepto;

            $item = "LiquidacionID";

            $respuesta = ControladorPayment::ctrMostrarConceptosDeBoleta($item, $valor);

            echo json_encode($respuesta);

               
        }

/*=============================================
        DETALLE LIQUIDACION
=============================================*/

    public $detalleLiquidacion;
    
        public function ajaxDetalleLiquidacion(){

            $valor = $this ->detalleLiquidacion;

            $item = "LiquidacionID";

            $respuesta = ControladorPayment::ctrMostrarLiquidacion($item, $valor);

            echo json_encode($respuesta);

               
        }

}//final clase ajax


/*=============================================
        EDITAR CONCEPTO
=============================================*/

	if (isset($_POST["idConcepto"])) {

		$editarContepto = new AjaxPayment();
		$editarContepto -> idConcepto = $_POST["idConcepto"];
		$editarContepto -> ajaxEditarConcepto();
	}

/*=============================================
        ELIMINAR CONCEPTO
=============================================*/

	if (isset($_POST["eliminarConcepto"])) {

		$editarContepto = new AjaxPayment();
		$editarContepto -> eliminarConcepto = $_POST["eliminarConcepto"];
		$editarContepto -> ajaxEliminarConcepto();
	}

/*=============================================
        TRAER CONCEPTOS
=============================================*/

	if (isset($_POST["traerConceptos"])) {

		$conceptos = new AjaxPayment();
		$conceptos -> traerConceptos = $_POST["traerConceptos"];
		$conceptos -> ajaxTraerConceptos();
	}

/*=============================================
        AGREGAR CONCEPTO
=============================================*/

    if (isset($_POST["idConceptoAgregar"])) {

        $agregar = new AjaxPayment();
        $agregar -> idConceptoAgregar = $_POST["idConceptoAgregar"];
        $agregar -> ajaxAgregarConcepto();
    }

/*=============================================
        TRAER RETENCIONES
=============================================*/

    if (isset($_POST["traerRetenciones"])) {

        $conceptos = new AjaxPayment();
        $conceptos -> traerRetenciones = $_POST["traerRetenciones"];
        $conceptos -> ajaxTraerConceptos();
    }

/*=============================================
        TRAER CONCEPTOS PARA AGREGAR
=============================================*/

    if (isset($_POST["traerConceptosLiquidar"])) {

            $conceptos = new AjaxPayment();
            $conceptos -> traerConceptosLiquidar = $_POST["traerConceptosLiquidar"];
            $conceptos -> tipoBoleta = $_POST["tipoBoleta"];
            $conceptos -> ajaxTraerConceptosLiquidar();
        }

/*=============================================
        ELIMINAR BOLETA
=============================================*/

    if (isset($_POST["eliminarBoleta"])) {

        $eliminarBoleta = new AjaxPayment();
        $eliminarBoleta -> eliminarBoleta = $_POST["eliminarBoleta"];
        $eliminarBoleta -> ajaxEliminarBoleta();
    }

/*=============================================
        TRAER CONCEPTO LIQUIDACION
=============================================*/

    if (isset($_POST["traigoConcepto"])) {

        $traigoConcepto = new AjaxPayment();
        $traigoConcepto -> traigoConcepto = $_POST["traigoConcepto"];
        $traigoConcepto -> ajaxTraerConceptoLiquidacion();
    }

/*=============================================
        DETALLE LIQUIDACION
=============================================*/

    if (isset($_POST["detalle"])) {

        $detalleLiquidacion = new AjaxPayment();
        $detalleLiquidacion -> detalleLiquidacion = $_POST["detalle"];
        $detalleLiquidacion -> ajaxDetalleLiquidacion();
    }