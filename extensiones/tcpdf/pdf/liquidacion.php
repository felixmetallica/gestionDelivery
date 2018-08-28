<?php
error_reporting(0);
require_once "../../../controladores/payment.controlador.php";
require_once "../../../modelos/payment.modelo.php";

require_once "../../../controladores/empleados.controlador.php";
require_once "../../../modelos/empleados.modelo.php";

require_once "../../../controladores/moneda.controlador.php";


class imprimirLiquidacion{

public $LiquidacionID;

public function traerImpresionLiquidacion(){

//TRAEMOS LA INFORMACION DE LA LIQUIDACION

$itemLiquidacion = "LiquidacionID";
$valorLiquidacion = $this->LiquidacionID;

$liquidacion = ControladorPayment::ctrMostrarLiquidacion($itemLiquidacion, $valorLiquidacion);

if ($liquidacion["TotalNoRemunerativos"] == 0) {
$totalNoRemunerativos = '';
}else{
$totalNoRemunerativos = $liquidacion["TotalNoRemunerativos"];
}

//ACTUALIZAMOS LOS DATOS DE LA LIQUIDACION

if (isset($_GET["fechaPago"])) {
//ESTADO
$itemLiquidacionEstado1 = "Estado";
$valorLiquidacion1 = "L";
$actualizoEstado = ControladorPayment::ctrActualizarLiquidacion($itemLiquidacionEstado1, $valorLiquidacion1, $valorLiquidacion);
//FECHA DE LIQUIDACION
date_default_timezone_set("America/Argentina/Tucuman");
$itemLiquidacionFechaConfeccion = "FechaLiquidacion";
$valorLiquidacionFechaConfeccion = date('Y-m-d');
$actualizoEstado2 = ControladorPayment::ctrActualizarLiquidacion($itemLiquidacionFechaConfeccion, $valorLiquidacionFechaConfeccion, $valorLiquidacion);
//FECHA DE PAGO
$itemLiquidacionFechaPago = "FechaPago";
$valorLiquidacionFechaPago = $_GET["fechaPago"];
$actualizoEstado3 = ControladorPayment::ctrActualizarLiquidacion($itemLiquidacionFechaPago, $valorLiquidacionFechaPago, $valorLiquidacion);

}

if ($liquidacion["FechaPago"]==null) {
$fechaPago = date('d/m/Y', strtotime($_GET['fechaPago']));
}else{
$fechaPago = $liquidacion["FechaPago"];
}

//TRAEMOS LA INFORMACION DEL EMPLEADO

$itemEmpleado = "EmpleadoID";
$valorEmpleado = $liquidacion["EmpleadoID"];

$empleado = ControladorEmpleados::ctrMostrarEmpleados($itemEmpleado, $valorEmpleado);

//TRAEMOS LOS CONCEPTOS DE LA LIQUIDACION

$listarConceptos = ControladorPayment::ctrMostrarConceptosDeBoleta($itemLiquidacion, $valorLiquidacion);

//CONSTRUIMOS EL PDF

require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->startPageGroup();

$pdf->AddPage();

//---------------------------------------------------------------------------------------------------

$bloque1 = <<<EOF

<table style="border-style: solid; border-top-width: 0.5px; border-left-width: 0.5px; border-right-width: 0.5px; border-bottom-width: 0.5px; border-color: #000000; padding: 5px">
		
	<tr>
		
		<td style="width:100%; text-align:right; font-size:8px">

			RECIBO DE REMUNERACIONES

		</td>
	
	</tr>
	<tr>
		
		<td style="width:100%; text-align:left; font-size:10px">

			PIZZERIA 4QUESOS<br>
			AYACHUCHO 55 - (4000) SAN MIGUEL DE TUCUMAN<br>
			CUITT : 30-78931752-9


		</td>
	
	</tr>
	<tr>
		
		<td style="width:100%; text-align:right; font-size:10px">

			Periodo: $liquidacion[Tipo] $liquidacion[Mes]/$liquidacion[Anio]

		</td>
	
	</tr>

</table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

//---------------------------------------------------------------------------------------------------

$bloque2 = <<<EOF

<table style="border-style: solid; border-left-width: 0.5px; border-top-width: 0px; border-right-width: 0.5px; border-bottom-width: 0.5px; border-color: #000000; padding: 5px">
		
	<tr>
		
		<td style="width:8%; text-align:left; font-size:10px; border-style: solid; border-right-width: 0.5px;">

			Legajo<br>
			$empleado[Legajo]

		</td>
		<td style="width:25%; text-align:left; font-size:10px; border-style: solid; border-right-width: 0.5px;">

			Apellido y Nombres<br>
			$empleado[Nombre] $empleado[Apellido]

		</td>

		<td style="width:25%; text-align:left; font-size:10px; border-style: solid; border-right-width: 0.5px;">

			C.U.I.L<br>
			$empleado[CUIL]

		</td>

		<td style="width:23%; text-align:left; font-size:10px; border-style: solid; border-right-width: 0.5px;">

			Fecha de ingreso<br>
			$empleado[Ingreso]

		</td>

		<td style="width:19%; text-align:left; font-size:10px; border-style: solid; border-right-width: 0.5px;">

			Sueldo/Jornal<br>
			$$empleado[Basico]

		</td>
	
	</tr>
	

</table>

EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');

//---------------------------------------------------------------------------------------------------

$bloque3 = <<<EOF

<table style="border-style: solid; border-left-width: 0.5px; border-top-width: 0px; border-right-width: 0.5px; border-bottom-width: 0.5px; border-color: #000000; padding: 5px">
		
	<tr>
		
		<td style="width:100%; text-align:center; font-size:10px; border-style: solid; border-right-width: 0.5px;">

			Liquidación

		</td>
			
	</tr>
	

</table>

EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

//---------------------------------------------------------------------------------------------------

$bloque4 = <<<EOF

<table style="border-style: solid; border-left-width: 0.5px; border-top-width: 0px; border-right-width: 0.5px; border-bottom-width: 0.5px; border-color: #000000; padding: 5px">
		
	<tr>
		
		<td style="width:50%; text-align:center; font-size:10px; border-style: solid; border-right-width: 0.5px;">

			Categoría<br>
			$empleado[Categoria]

		</td>

		<td style="width:50%; text-align:center; font-size:10px; border-style: solid; border-right-width: 0.5px;">

			Puesto<br>
			$empleado[Puesto]

		</td>
			
	</tr>
	

</table>

EOF;

$pdf->writeHTML($bloque4, false, false, false, false, '');

//---------------------------------------------------------------------------------------------------

$bloque5 = <<<EOF

<table style="border-style: solid; border-left-width: 0.5px; border-top-width: 0px; border-right-width: 0.5px; border-bottom-width: 0.5px;  border-color: #000000; padding: 5px">
		
	<tr>
		
		<td style="width:7%; text-align:center; font-size:8px; border-style: solid; border-right-width: 0.5px;">

			Codigo
			
		</td>

		<td style="width:35%; text-align:left; font-size:8px; border-style: solid; border-right-width: 0.5px;">

			Concepto
			
		</td>

		<td style="width:10%; text-align:center; font-size:8px; border-style: solid; border-right-width: 0.5px;">

			Unidades
			
		</td>

		<td style="width:16%; text-align:center; font-size:8px; border-style: solid; border-right-width: 0.5px;">

			Haberes C/Desc
			
		</td>

		<td style="width:16%; text-align:center; font-size:8px; border-style: solid; border-right-width: 0.5px;">

			Haberes S/Desc
			
		</td>

		<td style="width:16%; text-align:center; font-size:8px; border-style: solid; border-right-width: 0.5px;">

			Deducciones
			
		</td>

		
			
	</tr>
	

</table>

EOF;

$pdf->writeHTML($bloque5, false, false, false, false, '');

//---------------------------------------------------------------------------------------------------

foreach ($listarConceptos as $key => $value) {

switch ($value["Tipo"]) {
		
case '1':
$mostrar = '<td style="width:16%; text-align:right; font-size:8px; border-right-width: 0.5px;">

			'.$value["Total"].'
			
		</td>

		<td style="width:16%; text-align:right; font-size:8px; border-right-width: 0.5px;">

			
			
		</td>

		<td style="width:16%; text-align:right; font-size:8px; border-right-width: 0.5px;">

						
		</td>';
break;

case '2':
$mostrar = '<td style="width:16%; text-align:right; font-size:8px; border-right-width: 0.5px;">
			</td>
			<td style="width:16%; text-align:right; font-size:8px; border-right-width: 0.5px;">
			'.$value["Total"].'
			</td>
			<td style="width:16%; text-align:right; font-size:8px; border-right-width: 0.5px;">
			</td>';
break;

case '3':
$mostrar = '<td style="width:16%; text-align:right; font-size:8px; border-right-width: 0.5px;">
			</td>
			<td style="width:16%; text-align:right; font-size:8px; border-right-width: 0.5px;">
			</td>
			<td style="width:16%; text-align:right; font-size:8px; border-right-width: 0.5px;">
			'.$value["Total"].'
			</td>';
break;
		

}

$bloque6 = <<<EOF

<table style="padding: 5px; border:none;">
		
	<tr>
		
		<td style="width:7%; text-align:center; font-size:8px; border:none; border-right-width: 0.5px; border-left-width: 0.5px;">

			$value[Codigo]
			
		</td>

		<td style="width:35%; text-align:left; font-size:8px; border-right-width: 0.5px;">

			$value[Descripcion]
			
		</td>

		<td style="width:10%; text-align:right; font-size:8px; border-right-width: 0.5px;">

			$value[Unidades]
			
		</td>

		$mostrar
		
			
	</tr>

	
</table>

EOF;

$pdf->writeHTML($bloque6, false, false, false, false, '');

}

//---------------------------------------------------------------------------------------------------


$bloque7 = <<<EOF

<table style="padding: 5px">
		
	<tr>
		
		<td style="width:7%; text-align:center; font-size:8px; border-style: solid; border-left-width: 0.5px;">

			
			
		</td>

		<td style="width:35%; text-align:left; font-size:8px; border-style: solid;">

			
			
		</td>

		<td style="width:10%; text-align:left; font-size:8px; border-style: solid; border-right-width: 0.5px;">

			TOTALES:
			
		</td>

		<td style="width:16%; text-align:right; font-size:8px; border-style: solid; border-right-width: 0.5px;">

			$liquidacion[TotalRemunerativos]
			
		</td>

		<td style="width:16%; text-align:right; font-size:8px; border-style: solid; border-right-width: 0.5px;">

			$totalNoRemunerativos
			
		</td>

		<td style="width:16%; text-align:right; font-size:8px; border-style: solid; border-right-width: 0.5px;">

			$liquidacion[TotalRetenciones]
			
		</td>

	</tr>
	

</table>

EOF;

$pdf->writeHTML($bloque7, false, false, false, false, '');

//---------------------------------------------------------------------------------------------------

$bloque8 = <<<EOF

<table style="padding: 5px">
		
	<tr>
		
		<td style="width:7%; text-align:center; font-size:8px; border-style: solid; border-left-width: 0.5px;">

			
			
		</td>

		<td style="width:35%; text-align:left; font-size:8px; border-style: solid;">

			
			
		</td>

		<td style="width:10%; text-align:left; font-size:8px; border-style: solid;">

			
			
		</td>

		<td style="width:16%; text-align:left; font-size:8px; border-style: solid;">

			
			
		</td>

		<td style="width:16%; text-align:right; font-size:8px; border-style: solid; border-right-width: 0.5px;">

			NETO:
			
		</td>

		<td style="width:16%; text-align:right; font-size:8px; border-style: solid; border-right-width: 0.5px;">

			$$liquidacion[TotalNeto]
			
		</td>

	</tr>
	

</table>

EOF;

$pdf->writeHTML($bloque8, false, false, false, false, '');

//---------------------------------------------------------------------------------------------------

$bloque9 = <<<EOF

<table style="padding: 5px">
		
	<tr>
		
		<td style="width:100%; text-align:left; font-size:8px; border-style: solid; border-left-width: 0.5px; border-right-width: 0.5px;">

			Lugar y fecha de pago : Ayacucho 55 - San Miguel de Tucumán - $fechaPago
			
		</td>

		

	</tr>
	

</table>

EOF;

$pdf->writeHTML($bloque9, false, false, false, false, '');

//---------------------------------------------------------------------------------------------------
//PASAMOS A LETRAS EL VALOR TOTAL NETO

$total=$liquidacion["TotalNeto"]; 
$V=new EnLetras(); 
$letras = $V->ValorEnLetras($total,"con");



$bloque10 = <<<EOF

<table style="padding: 5px">
		
	<tr>
		
		<td style="width:100%; text-align:left; font-size:8px; border-style: solid; border-left-width: 0.5px; border-right-width: 0.5px;  border-bottom-width: 0.5px;">

			Son pesos: $letras *****************************************************************<br>
			*******************************************************************************************************************************************************************
			
		</td>

		

	</tr>
	

</table>

EOF;

$pdf->writeHTML($bloque10, false, false, false, false, '');

//---------------------------------------------------------------------------------------------------

$bloque11 = <<<EOF

<table style="padding: 5px">
		
	<tr>
		
		<td style="width:60%; text-align:left; font-size:8px;  border-style: solid; border-left-width: 0.5px; border-right-width: 0.5px;">

			Recibo Leyes 17250, 20744 y 21297<br>
			Recibí el importe neto y duplicado de la presente<br>
			liquidación en pago de mi remuneración<br>
			correspondiente al periodo indicado
			
		</td>

		<td style="width:40%; text-align:center; font-size:8px; border-right-width: 0.5px;">
						
		</td>

	</tr>

	<tr>
		
		<td style="width:60%; text-align:left; font-size:8px; border-left-width: 0.5px; border-right-width: 0.5px; border-bottom-width: 0.5px;">

			
			
		</td>

		<td style="width:40%; text-align:center; font-size:8px; border-right-width: 0.5px; border-bottom-width: 0.5px;">
			<br>
			------------------------------<br>
			Firma del Empleador
			
		</td>

	</tr>

	
</table>

EOF;

$pdf->writeHTML($bloque11, false, false, false, false, '');

//---------------------------------------------------------------------------------------------------

$pdf->AddPage();

//---------------------------------------------------------------------------------------------------

$bloque1 = <<<EOF

<table style="border-style: solid; border-top-width: 0.5px; border-left-width: 0.5px; border-right-width: 0.5px; border-bottom-width: 0.5px; border-color: #000000; padding: 5px">
		
	<tr>
		
		<td style="width:100%; text-align:right; font-size:8px">

			RECIBO DE REMUNERACIONES

		</td>
	
	</tr>
	<tr>
		
		<td style="width:100%; text-align:left; font-size:10px">

			PIZZERIA 4QUESOS<br>
			AYACHUCHO 55 - (4000) SAN MIGUEL DE TUCUMAN<br>
			CUITT : 30-78931752-9


		</td>
	
	</tr>
	<tr>
		
		<td style="width:100%; text-align:right; font-size:10px">

			Periodo: $liquidacion[Tipo] $liquidacion[Mes]/$liquidacion[Anio]

		</td>
	
	</tr>

</table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

//---------------------------------------------------------------------------------------------------

$bloque2 = <<<EOF

<table style="border-style: solid; border-left-width: 0.5px; border-top-width: 0px; border-right-width: 0.5px; border-bottom-width: 0.5px; border-color: #000000; padding: 5px">
		
	<tr>
		
		<td style="width:8%; text-align:left; font-size:10px; border-style: solid; border-right-width: 0.5px;">

			Legajo<br>
			$empleado[Legajo]

		</td>
		<td style="width:25%; text-align:left; font-size:10px; border-style: solid; border-right-width: 0.5px;">

			Apellido y Nombres<br>
			$empleado[Nombre] $empleado[Apellido]

		</td>

		<td style="width:25%; text-align:left; font-size:10px; border-style: solid; border-right-width: 0.5px;">

			C.U.I.L<br>
			$empleado[CUIL]

		</td>

		<td style="width:23%; text-align:left; font-size:10px; border-style: solid; border-right-width: 0.5px;">

			Fecha de ingreso<br>
			$empleado[Ingreso]

		</td>

		<td style="width:19%; text-align:left; font-size:10px; border-style: solid; border-right-width: 0.5px;">

			Sueldo/Jornal<br>
			$$empleado[Basico]

		</td>
	
	</tr>
	

</table>

EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');

//---------------------------------------------------------------------------------------------------

$bloque3 = <<<EOF

<table style="border-style: solid; border-left-width: 0.5px; border-top-width: 0px; border-right-width: 0.5px; border-bottom-width: 0.5px; border-color: #000000; padding: 5px">
		
	<tr>
		
		<td style="width:100%; text-align:center; font-size:10px; border-style: solid; border-right-width: 0.5px;">

			Liquidación

		</td>
			
	</tr>
	

</table>

EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

//---------------------------------------------------------------------------------------------------

$bloque4 = <<<EOF

<table style="border-style: solid; border-left-width: 0.5px; border-top-width: 0px; border-right-width: 0.5px; border-bottom-width: 0.5px; border-color: #000000; padding: 5px">
		
	<tr>
		
		<td style="width:50%; text-align:center; font-size:10px; border-style: solid; border-right-width: 0.5px;">

			Categoría<br>
			$empleado[Categoria]

		</td>

		<td style="width:50%; text-align:center; font-size:10px; border-style: solid; border-right-width: 0.5px;">

			Puesto<br>
			$empleado[Puesto]

		</td>
			
	</tr>
	

</table>

EOF;

$pdf->writeHTML($bloque4, false, false, false, false, '');

//---------------------------------------------------------------------------------------------------

$bloque5 = <<<EOF

<table style="border-style: solid; border-left-width: 0.5px; border-top-width: 0px; border-right-width: 0.5px; border-bottom-width: 0.5px;  border-color: #000000; padding: 5px">
		
	<tr>
		
		<td style="width:7%; text-align:center; font-size:8px; border-style: solid; border-right-width: 0.5px;">

			Codigo
			
		</td>

		<td style="width:35%; text-align:left; font-size:8px; border-style: solid; border-right-width: 0.5px;">

			Concepto
			
		</td>

		<td style="width:10%; text-align:center; font-size:8px; border-style: solid; border-right-width: 0.5px;">

			Unidades
			
		</td>

		<td style="width:16%; text-align:center; font-size:8px; border-style: solid; border-right-width: 0.5px;">

			Haberes C/Desc
			
		</td>

		<td style="width:16%; text-align:center; font-size:8px; border-style: solid; border-right-width: 0.5px;">

			Haberes S/Desc
			
		</td>

		<td style="width:16%; text-align:center; font-size:8px; border-style: solid; border-right-width: 0.5px;">

			Deducciones
			
		</td>

		
			
	</tr>
	

</table>

EOF;

$pdf->writeHTML($bloque5, false, false, false, false, '');

//---------------------------------------------------------------------------------------------------

foreach ($listarConceptos as $key => $value) {

switch ($value["Tipo"]) {
		
case '1':
$mostrar = '<td style="width:16%; text-align:right; font-size:8px; border-right-width: 0.5px;">

			'.$value["Total"].'
			
		</td>

		<td style="width:16%; text-align:right; font-size:8px; border-right-width: 0.5px;">

			
			
		</td>

		<td style="width:16%; text-align:right; font-size:8px; border-right-width: 0.5px;">

						
		</td>';
break;

case '2':
$mostrar = '<td style="width:16%; text-align:right; font-size:8px; border-right-width: 0.5px;">
			</td>
			<td style="width:16%; text-align:right; font-size:8px; border-right-width: 0.5px;">
			'.$value["Total"].'
			</td>
			<td style="width:16%; text-align:right; font-size:8px; border-right-width: 0.5px;">
			</td>';
break;

case '3':
$mostrar = '<td style="width:16%; text-align:right; font-size:8px; border-right-width: 0.5px;">
			</td>
			<td style="width:16%; text-align:right; font-size:8px; border-right-width: 0.5px;">
			</td>
			<td style="width:16%; text-align:right; font-size:8px; border-right-width: 0.5px;">
			'.$value["Total"].'
			</td>';
break;
		

}

$bloque6 = <<<EOF

<table style="padding: 5px; border:none;">
		
	<tr>
		
		<td style="width:7%; text-align:center; font-size:8px; border:none; border-right-width: 0.5px; border-left-width: 0.5px;">

			$value[Codigo]
			
		</td>

		<td style="width:35%; text-align:left; font-size:8px; border-right-width: 0.5px;">

			$value[Descripcion]
			
		</td>

		<td style="width:10%; text-align:right; font-size:8px; border-right-width: 0.5px;">

			$value[Unidades]
			
		</td>

		$mostrar
		
			
	</tr>

	
</table>

EOF;

$pdf->writeHTML($bloque6, false, false, false, false, '');

}

//---------------------------------------------------------------------------------------------------


$bloque7 = <<<EOF

<table style="padding: 5px">
		
	<tr>
		
		<td style="width:7%; text-align:center; font-size:8px; border-style: solid; border-left-width: 0.5px;">

			
			
		</td>

		<td style="width:35%; text-align:left; font-size:8px; border-style: solid;">

			
			
		</td>

		<td style="width:10%; text-align:left; font-size:8px; border-style: solid; border-right-width: 0.5px;">

			TOTALES:
			
		</td>

		<td style="width:16%; text-align:right; font-size:8px; border-style: solid; border-right-width: 0.5px;">

			$liquidacion[TotalRemunerativos]
			
		</td>

		<td style="width:16%; text-align:right; font-size:8px; border-style: solid; border-right-width: 0.5px;">

			$totalNoRemunerativos
			
		</td>

		<td style="width:16%; text-align:right; font-size:8px; border-style: solid; border-right-width: 0.5px;">

			$liquidacion[TotalRetenciones]
			
		</td>

	</tr>
	

</table>

EOF;

$pdf->writeHTML($bloque7, false, false, false, false, '');

//---------------------------------------------------------------------------------------------------

$bloque8 = <<<EOF

<table style="padding: 5px">
		
	<tr>
		
		<td style="width:7%; text-align:center; font-size:8px; border-style: solid; border-left-width: 0.5px;">

			
			
		</td>

		<td style="width:35%; text-align:left; font-size:8px; border-style: solid;">

			
			
		</td>

		<td style="width:10%; text-align:left; font-size:8px; border-style: solid;">

			
			
		</td>

		<td style="width:16%; text-align:left; font-size:8px; border-style: solid;">

			
			
		</td>

		<td style="width:16%; text-align:right; font-size:8px; border-style: solid; border-right-width: 0.5px;">

			NETO:
			
		</td>

		<td style="width:16%; text-align:right; font-size:8px; border-style: solid; border-right-width: 0.5px;">

			$$liquidacion[TotalNeto]
			
		</td>

	</tr>
	

</table>

EOF;

$pdf->writeHTML($bloque8, false, false, false, false, '');

//---------------------------------------------------------------------------------------------------

$bloque9 = <<<EOF

<table style="padding: 5px">
		
	<tr>
		
		<td style="width:100%; text-align:left; font-size:8px; border-style: solid; border-left-width: 0.5px; border-right-width: 0.5px;">

			Lugar y fecha de pago : Ayacucho 55 - San Miguel de Tucumán - $fechaPago
			
		</td>

		

	</tr>
	

</table>

EOF;

$pdf->writeHTML($bloque9, false, false, false, false, '');

//---------------------------------------------------------------------------------------------------
//PASAMOS A LETRAS EL VALOR TOTAL NETO

$total=$liquidacion["TotalNeto"]; 
$V=new EnLetras(); 
$letras = $V->ValorEnLetras($total,"con");



$bloque10 = <<<EOF

<table style="padding: 5px">
		
	<tr>
		
		<td style="width:100%; text-align:left; font-size:8px; border-style: solid; border-left-width: 0.5px; border-right-width: 0.5px;  border-bottom-width: 0.5px;">

			Son pesos: $letras *****************************************************************<br>
			*******************************************************************************************************************************************************************
			
		</td>

		

	</tr>
	

</table>

EOF;

$pdf->writeHTML($bloque10, false, false, false, false, '');

//---------------------------------------------------------------------------------------------------

$bloque11 = <<<EOF

<table style="padding: 5px">
		
	<tr>
		
		<td style="width:60%; text-align:left; font-size:8px;  border-style: solid; border-left-width: 0.5px; border-right-width: 0.5px;">

			Recibo Leyes 17250, 20744 y 21297<br>
			Recibí el importe neto y duplicado de la presente<br>
			liquidación en pago de mi remuneración<br>
			correspondiente al periodo indicado
			
		</td>

		<td style="width:40%; text-align:center; font-size:8px; border-right-width: 0.5px;">
						
		</td>

	</tr>

	<tr>
		
		<td style="width:60%; text-align:left; font-size:8px; border-left-width: 0.5px; border-right-width: 0.5px; border-bottom-width: 0.5px;">

			
			
		</td>

		<td style="width:40%; text-align:center; font-size:8px; border-right-width: 0.5px; border-bottom-width: 0.5px;">
			<br>
			------------------------------<br>
			Firma del Empleado
			
		</td>

	</tr>

	
</table>

EOF;

$pdf->writeHTML($bloque11, false, false, false, false, '');

//-------------------------------------------FIN --------------------------------------------------------

$pdf->Output('recibo.pdf');

}

}

$factura = new imprimirLiquidacion();
$factura -> LiquidacionID = $_GET["liquidacion"];
$factura -> traerImpresionLiquidacion();


?>