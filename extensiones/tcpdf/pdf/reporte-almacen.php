<?php

require_once "../../../controladores/almacen.controlador.php";
require_once "../../../modelos/almacen.modelo.php";


class imprimirReporte{

public function traerReporte(){

//DATOS DE LA FECHA ACTUAL

date_default_timezone_set("America/Argentina/Tucuman");
$fechaReporte= date('d/m/Y');

//TRAEMOS LA INFORMACION DE LOS MOVIMIENTOS DEL ALMACEN

$tabla1 = "Almacen";
$tabla2 = "Usuario";
$tabla3 = "Persona";

if (isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])) {

$almacen = ModeloAlmacen::mdlRangoFechaAlmacen($tabla1, $tabla2, $tabla3, $_GET["fechaInicial"], $_GET["fechaFinal"]);

} else {

$item = null;
$valor = null;

$almacen = ModeloAlmacen::mdlMostrarMovimientos($tabla1, $tabla2, $tabla3, $item, $valor);

}


//CONSTRUIMOS EL PDF

require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->startPageGroup();

$pdf->AddPage();

//---------------------------------------------------------------------------------------------------

$bloque1 = <<<EOF

<table style="background-color:#A9E3B4; padding:5px; border: 1px solid black">

	<tr>

		<td style="width: 100%; text-align:center; border: 0.5px solid black">

			REPORTE DE ALMACEN - $fechaReporte


		</td>

	</tr>

</table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

//---------------------------------------------------------------------------------------------------

$bloque2 = <<<EOF

<table style="background-color:#EE4242; padding:5px;">

	<tr>

		<td style="width: 10%; text-align:left;font-size: 8px; border: 0.5px solid black">

			FECHA


		</td>

		<td style="width: 12%; text-align:left;font-size: 8px; border: 0.5px solid black">

			TIPO


		</td>

		<td style="width: 25%; text-align:left;font-size: 8px; border: 0.5px solid black">

			PRODUCTO


		</td>

		<td style="width: 23%; text-align:left;font-size: 8px; border: 0.5px solid black">

			DESCRIPCION


		</td>

		<td style="width: 10%; text-align:left;font-size: 8px; border: 0.5px solid black">

			CANTIDAD


		</td>

		<td style="width: 20%; text-align:left;font-size: 8px; border: 0.5px solid black">

			RESPONSABLE


		</td>

	</tr>

</table>

EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');

//---------------------------------------------------------------------------------------------------

foreach ($almacen as $key => $value) {

if ($value["Tipo"] == "I") {
$tipo = "Ingreso";
}else{
$tipo="Egreso";
}

$bloque3 = <<<EOF

<table style="background-color:#FEFCCC; padding:5px; border: 1px solid black;">

	<tr>

		<td style="width: 10%; text-align:left;font-size: 8px; border: 0.5px solid black">

			$value[Fecha]

		</td>

		<td style="width: 12%; text-align:left;font-size: 8px; border: 0.5px solid black">

			$tipo

		</td>

		<td style="width: 25%; text-align:left;font-size: 8px; border: 0.5px solid black">

			$value[Nombre]

		</td>

		<td style="width: 23%; text-align:left;font-size: 8px; border: 0.5px solid black">

			$value[Descripcion]

		</td>

		<td style="width: 10%; text-align:left;font-size: 8px; border: 0.5px solid black">

			$value[Cantidad]

		</td>

		<td style="width: 20%; text-align:left;font-size: 8px; border: 0.5px solid black">

			$value[NombrePersona] $value[ApellidoPersona]


		</td>

	</tr>

</table>



EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

}
//---------------------------------------------------------------------------------------------------

$pdf->Output('reporte.almacen.pdf');

}

}

$reporte = new imprimirReporte();
$reporte -> traerReporte();

?>
