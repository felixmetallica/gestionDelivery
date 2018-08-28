<?php

require_once "../../../controladores/ventas.controlador.php";
require_once "../../../modelos/ventas.modelo.php";
require_once "../../../controladores/clientes.controlador.php";
require_once "../../../modelos/clientes.modelo.php";
require_once "../../../controladores/productos.controlador.php";
require_once "../../../modelos/productos.modelo.php";
require_once "../../../controladores/usuarios.controlador.php";
require_once "../../../modelos/usuarios.modelo.php";


class imprimirReporte{

public function traerReporte(){

//TRAEMOS LA INFORMACION DE VENTA

$tabla = "Venta";

if (isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])) {

$ventas = ModeloVentas::mdlRangoFechaVentas($tabla, $_GET["fechaInicial"], $_GET["fechaFinal"]);

} else {

$item = null;
$valor = null;

$ventas = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);

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

			REPORTE DE VENTAS


		</td>
		
	</tr>

</table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

//---------------------------------------------------------------------------------------------------

$bloque2 = <<<EOF

<table style="background-color:#EE4242; padding:5px; font-size: 6px;">
		
	<tr>
		
		<td style="width: 8%; text-align:left; border: 0.5px solid black">

			FECHA

		</td>

		<td style="width: 10%; text-align:left; border: 0.5px solid black">

			N° FACTURA

		</td>

		<td style="width: 13%; text-align:left; border: 0.5px solid black">

			CLIENTE

		</td>

		<td style="width: 13%; text-align:left; border: 0.5px solid black">

			VENDEDOR

		</td>

		<td style="width: 17%; text-align:left; border: 0.5px solid black">

			PRODUCTOS 

		</td>

		<td style="width: 6%; text-align:right; border: 0.5px solid black">

			DESC

		</td>

		<td style="width: 6%; text-align:right; border: 0.5px solid black">

			RECAR

		</td>

		<td style="width: 6%; text-align:right; border: 0.5px solid black">

			NETO

		</td>

		<td style="width: 6%; text-align:left; border: 0.5px solid black">

			TOTAL

		</td>

		<td style="width: 7%; text-align:left; border: 0.5px solid black">

			PAGO

		</td>

		<td style="width: 8%; text-align:left; border: 0.5px solid black">

			ESTADO

		</td>
		
	</tr>

</table>

EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');

//---------------------------------------------------------------------------------------------------

foreach ($ventas as $key => $item) {

$cliente = ControladorClientes::ctrMostrarClientes("ClienteID", $item["ClienteID"]);
$vendedor = ControladorUsuarios::ctrMostrarUsuarios("UsuarioID", $item["UsuarioRegistraID"]);
$productosVenta = ControladorVentas::ctrListadoProductos($item["VentaID"]);

if ($item["Estado"]!= "Z") {
$estado= "Registrada";
}else{
$estado = "Anulada";
}

$html = '<table>';
foreach($productosVenta as $key => $current) {
$html .= '<tr>
<td>' . $current['Cantidad'] . ' ' . $current['Nombre'] . '</td>
</tr>';
}
$html .= '</table>';

$desc = number_format($item["MontoDescuento"],2);
$rec = number_format($item["MontoRecargo"],2);
$neto = number_format($item["Neto"],2);
$total = number_format($item["Total"],2);
			
$bloque3 = <<<EOF

<table style="background-color:#FEFCCC; padding:5px; font-size: 6px;">
		
	<tr>
		
		<td style="width: 8%; text-align:left; border: 0.5px solid black">

			$item[fechaFormateada]

		</td>

		<td style="width: 10%; text-align:left; border: 0.5px solid black">

			$item[NroFactura]

		</td>

		<td style="width: 13%; text-align:left; border: 0.5px solid black">

			$cliente[Nombre] $cliente[Apellido]

		</td>

		<td style="width: 13%; text-align:left; border: 0.5px solid black">

			$vendedor[nombrePersona] $vendedor[Apellido]

		</td>

		<td style="width: 17%; text-align:left; border: 0.5px solid black">

			$html 

		</td>

		<td style="width: 6%; text-align:right; border: 0.5px solid black">

			$$desc

		</td>

		<td style="width: 6%; text-align:right; border: 0.5px solid black">

			$$rec

		</td>

		<td style="width: 6%; text-align:right; border: 0.5px solid black">

			$$neto

		</td>

		<td style="width: 6%; text-align:left; border: 0.5px solid black">

			$$total

		</td>

		<td style="width: 7%; text-align:left; border: 0.5px solid black">

			$item[MDP]

		</td>

		<td style="width: 8%; text-align:left; border: 0.5px solid black">

			$estado

		</td>
		
	</tr>

</table>

EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

}
//---------------------------------------------------------------------------------------------------

$pdf->Output('reporte.ventas.pdf');

}

}

$reporte = new imprimirReporte();
$reporte -> traerReporte();

?>