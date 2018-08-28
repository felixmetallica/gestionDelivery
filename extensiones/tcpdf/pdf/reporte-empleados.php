<?php

require_once "../../../controladores/empleados.controlador.php";
require_once "../../../modelos/empleados.modelo.php";

require_once "../../../controladores/personas.controlador.php";
require_once "../../../modelos/personas.modelo.php";

class imprimirReporte{

public function traerReporte(){

//DATOS DE LA FECHA ACTUAL
date_default_timezone_set("America/Argentina/Tucuman");
$fechaReporte= date('d/m/Y');

//TRAEMOS LA INFORMACION DE LOS EMPLEADOS

$item = null;
$valor = null;
$listar = ControladorEmpleados::ctrMostrarEmpleados($item, $valor);

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

			REPORTE DE EMPLEADOS - $fechaReporte


		</td>
		
	</tr>

</table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

//---------------------------------------------------------------------------------------------------

$bloque2 = <<<EOF

<table style="background-color:#EE4242; padding:5px; font-size: 6px;">
		
	<tr>
		
		<td style="width: 10%; text-align:left; border: 0.5px solid black">

			NOMBRE

		</td>

		<td style="width: 7%; text-align:left; border: 0.5px solid black">

			DNI

		</td>

		<td style="width: 8%; text-align:left; border: 0.5px solid black">

			FECH.NACI

		</td>

		<td style="width: 13%; text-align:left; border: 0.5px solid black">

			EMAIL

		</td>

		<td style="width: 10%; text-align:left; border: 0.5px solid black">

			TELEFONO

		</td>

		<td style="width: 12%; text-align:center; border: 0.5px solid black">

			DOMICILIO

		</td>

		<td style="width: 5%; text-align:left; border: 0.5px solid black">

			LEG

		</td>

		<td style="width: 8%; text-align:center; border: 0.5px solid black">

			INGRESO

		</td>

		<td style="width: 9%; text-align:center; border: 0.5px solid black">

			PUESTO

		</td>

		<td style="width: 10%; text-align:center; border: 0.5px solid black">

			CUIL

		</td>

		<td style="width: 8%; text-align:center; border: 0.5px solid black">

			SUELDO

		</td>
		
	</tr>

</table>

EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');

//---------------------------------------------------------------------------------------------------

foreach ($listar as $key => $empleados) {
	



$bloque3 = <<<EOF

<table style="background-color:#FEFCCC; padding:5px; font-size: 5px;">
		
	<tr>
		
		<td style="width: 10%; text-align:left; border: 0.5px solid black">

			$empleados[Nombre] $empleados[Apellido]

		</td>

		<td style="width: 7%; text-align:left; border: 0.5px solid black">

			$empleados[DNI]

		</td>

		<td style="width: 8%; text-align:left; border: 0.5px solid black">

			$empleados[Nacimiento]

		</td>

		<td style="width: 13%; text-align:left; border: 0.5px solid black">

			$empleados[Email]

		</td>

		<td style="width: 10%; text-align:left; border: 0.5px solid black">

			($empleados[Prefijo]) - $empleados[NroTelefono]

		</td>

		<td style="width: 12%; text-align:left; border: 0.5px solid black">

			$empleados[Calle] $empleados[Nro] $empleados[Piso] $empleados[Dpto]
 
		</td>

		<td style="width: 5%; text-align:left; border: 0.5px solid black">

			$empleados[Legajo]

		</td>

		<td style="width: 8%; text-align:center; border: 0.5px solid black">

			$empleados[Ingreso]

		</td>

		<td style="width: 9%; text-align:left; border: 0.5px solid black">

			$empleados[Puesto]

		</td>

		<td style="width: 10%; text-align:center; border: 0.5px solid black">

			$empleados[CUIL]

		</td>

		<td style="width: 8%; text-align:center; border: 0.5px solid black">

			$$empleados[SueldoBasico]

		</td>
		
	</tr>

</table>

EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

}

//---------------------------------------------------------------------------------------------------

$pdf->Output('reporte.proveedores.pdf');

}

}

$reporte = new imprimirReporte();
$reporte -> traerReporte();

?>