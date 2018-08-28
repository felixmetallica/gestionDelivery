<?php

require_once "../../../controladores/clientes.controlador.php";
require_once "../../../modelos/clientes.modelo.php";


class imprimirReporte{

public function traerReporte(){

//DATOS DE LA FECHA ACTUAL
date_default_timezone_set("America/Argentina/Tucuman");
$fechaReporte= date('d/m/Y');

//TRAEMOS LA INFORMACION DEL CLIENTE

$item = null;
$valor = null;
$listar = ControladorClientes::ctrMostrarClientes($item, $valor);

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

			REPORTE DE CLIENTES - $fechaReporte


		</td>
		
	</tr>

</table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

//---------------------------------------------------------------------------------------------------

$bloque2 = <<<EOF

<table style="background-color:#EE4242; padding:5px; font-size: 6px;">
		
	<tr>
		
		<td style="width: 16%; text-align:left; border: 0.5px solid black">

			NOMBRE


		</td>

		<td style="width: 18%; text-align:left; border: 0.5px solid black">

			DOMICILIO


		</td>

		<td style="width: 14%; text-align:left; border: 0.5px solid black">

			TELEFONO


		</td>

		<td style="width: 15%; text-align:left; border: 0.5px solid black">

			LOCALIDAD


		</td>

		<td style="width: 13%; text-align:left; border: 0.5px solid black">

			BARRIO


		</td>

		<td style="width: 8%; text-align:center; border: 0.5px solid black">

			ALTA


		</td>

		<td style="width: 6%; text-align:left; border: 0.5px solid black">

			C/PEDI


		</td>

		<td style="width: 10%; text-align:center; border: 0.5px solid black">

			U.PEDI


		</td>
		
	</tr>

</table>

EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');

//---------------------------------------------------------------------------------------------------

foreach ($listar as $key => $cliente) {
	


$bloque3 = <<<EOF

<table style="background-color:#FEFCCC; padding:5px; font-size: 6px;">
		
	<tr>
		
		<td style="width: 16%; text-align:left; border: 0.5px solid black">

			$cliente[Nombre] $cliente[Apellido]

		</td>

		<td style="width: 18%; text-align:left; border: 0.5px solid black">

			$cliente[Calle] $cliente[Nro] $cliente[Piso] $cliente[Dpto]

		</td>

		<td style="width: 14%; text-align:left; border: 0.5px solid black">

			($cliente[Prefijo]) - $cliente[NroTelefono]

		</td>

		<td style="width: 15%; text-align:left; border: 0.5px solid black">

			$cliente[Localidad]

		</td>

		<td style="width: 13%; text-align:left; border: 0.5px solid black">

			$cliente[Barrio]

		</td>

		<td style="width: 8%; text-align:center; border: 0.5px solid black">

			$cliente[FechaAlta]

		</td>

		<td style="width: 6%; text-align:right; border: 0.5px solid black">

			$cliente[Compras]

		</td>

		<td style="width: 10%; text-align:center; border: 0.5px solid black">

			$cliente[UltimaCompra]

		</td>
		
	</tr>

</table>

EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

}

//---------------------------------------------------------------------------------------------------

$pdf->Output('reporte.clientes.pdf');

}

}

$reporte = new imprimirReporte();
$reporte -> traerReporte();

?>