<?php

require_once "../../../controladores/productos.controlador.php";
require_once "../../../modelos/productos.modelo.php";

class imprimirReporte{

public function traerReporte(){

//DATOS DE LA FECHA ACTUAL
date_default_timezone_set("America/Argentina/Tucuman");
$fechaReporte= date('d/m/Y');

//TRAEMOS LA INFORMACION DE LOS PRODUCTOS
$item = null;
$valor = null;
$orden = "ProductoID";
$listar = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);

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
			REPORTE DE PRODUCTOS - $fechaReporte
		</td>
	</tr>
</table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');
//---------------------------------------------------------------------------------------------------
$bloque2 = <<<EOF

<table style="background-color:#EE4242; padding:5px; font-size: 8px;">

	<tr>

		<td style="width: 9%; text-align:center; border: 0.5px solid black">

			CÓDIGO

		</td>

		<td style="width: 12%; text-align:left; border: 0.5px solid black">

			RUBRO

		</td>

		<td style="width: 32%; text-align:left; border: 0.5px solid black">

			NOMBRE

		</td>

		<td style="width: 10%; text-align:left; border: 0.5px solid black">

			P.VENTA

		</td>

		<td style="width: 10%; text-align:left; border: 0.5px solid black">

			P.COMPRA

		</td>

		<td style="width: 10%; text-align:left; border: 0.5px solid black">

			VENDIDOS

		</td>

		<td style="width: 8%; text-align:center; border: 0.5px solid black">

			ESTADO

		</td>

		<td style="width: 9%; text-align:center; border: 0.5px solid black">

			STOCK

		</td>

	</tr>

</table>

EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');

//---------------------------------------------------------------------------------------------------

foreach ($listar as $key => $productos) {

$bloque3 = <<<EOF
<table style="background-color:#FEFCCC; padding:5px; font-size: 8px;">

<tr>

	<td style="width: 9%; text-align:center; border: 0.5px solid black">

		$productos[Codigo]

	</td>

	<td style="width: 12%; text-align:left; border: 0.5px solid black">

		$productos[Rubro]

	</td>

	<td style="width: 32%; text-align:left; border: 0.5px solid black">

		$productos[Nombre]

	</td>

	<td style="width: 10%; text-align:right; border: 0.5px solid black">

		$$productos[PrecioVenta]

	</td>

	<td style="width: 10%; text-align:right; border: 0.5px solid black">

		$$productos[PrecioCompra]

	</td>

	<td style="width: 10%; text-align:right; border: 0.5px solid black">

		$productos[Ventas]

	</td>

	<td style="width: 8%; text-align:center; border: 0.5px solid black">

		$productos[Activo]

	</td>

	<td style="width: 9%; text-align:right; border: 0.5px solid black">

		$productos[Stock]

	</td>

</tr>

</table>

EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

}
//---------------------------------------------------------------------------------------------------
$pdf->Output('reporte.productos.pdf');
}
}

$reporte = new imprimirReporte();
$reporte -> traerReporte();

?>
