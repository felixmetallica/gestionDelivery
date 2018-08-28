<?php

require_once "../../../controladores/compras.controlador.php";
require_once "../../../modelos/compras.modelo.php";
require_once "../../../controladores/proveedores.controlador.php";
require_once "../../../modelos/proveedores.modelo.php";
require_once "../../../controladores/productos.controlador.php";
require_once "../../../modelos/productos.modelo.php";
require_once "../../../controladores/usuarios.controlador.php";
require_once "../../../modelos/usuarios.modelo.php";
require_once "../../../controladores/insumos.controlador.php";
require_once "../../../modelos/insumos.modelo.php";


class imprimirReporte{

public function traerReporte(){

//TRAEMOS LA INFORMACION DE COMPRA

$tabla = "Compra";

if (isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])) {

$compras = ModeloCompras::mdlRangoFechaCompras($tabla, $_GET["fechaInicial"], $_GET["fechaFinal"]);

} else {

$item = null;
$valor = null;

$compras = ModeloCompras::mdlMostrarCompras($tabla, $item, $valor);

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

			REPORTE DE COMPRAS


		</td>
		
	</tr>

</table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

//---------------------------------------------------------------------------------------------------

$bloque2 = <<<EOF

<table style="background-color:#EE4242; padding:5px; font-size: 5px;">
		
	<tr>
		
		<td style="width: 8%; text-align:left; border: 0.5px solid black">

			FECHA

		</td>

		<td style="width: 10%; text-align:left; border: 0.5px solid black">

			N° ORDEN

		</td>

		<td style="width: 17%; text-align:left; border: 0.5px solid black">

			PROVEEDOR

		</td>

		<td style="width: 11%; text-align:left; border: 0.5px solid black">

			USUARIO

		</td>

		<td style="width: 17%; text-align:left; border: 0.5px solid black">

			PRODUCTOS 

		</td>

		<td style="width: 8%; text-align:right; border: 0.5px solid black">

			IMPUESTO

		</td>

		<td style="width: 8%; text-align:right; border: 0.5px solid black">

			NETO

		</td>

		<td style="width: 7%; text-align:right; border: 0.5px solid black">

			TOTAL

		</td>

		<td style="width: 6%; text-align:left; border: 0.5px solid black">

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

foreach ($compras as $key => $value) {

$proveedor = ControladorProveedores::ctrMostrarProveedores("ProveedorID", $value["ProveedorID"]);
$usuario = ControladorUsuarios::ctrMostrarUsuarios("UsuarioID", $value["UsuarioID"]);
$insumosVenta = ControladorCompras::ctrListadoInsumos($value["CompraID"]);

if ($value["Estado"]!= "Z") {
$estado= "Registrada";
}else{
$estado = "Anulada";
}

$impuesto = number_format($value["Impuesto"],2);
$neto = number_format($value["Neto"],2);
$total = number_format($value["Total"],2);

$listarCompra =ControladorCompras::ctrListadoCompra($value["CompraID"]);

$html = '<table>';

foreach ($listarCompra as $key => $itemP) {

if ($itemP["InsumosID"] == null) {
    
    $item = "ProductoID";

    $valor = $itemP["ProductoID"];

    $orden = "ProductoID";

    $productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);

    $html .= '<tr>
	<td>' . $itemP['Cantidad'] . ' ' . $productos['Nombre'] . '</td>
	</tr>';


}else{

$item = "InsumosID";

$valor = $itemP["InsumosID"];

$insumos = ControladorInsumos::ctrMostrarInsumos($item, $valor);

$html .= '<tr>
	<td>' . $itemP['Cantidad'] . ' ' . $insumos['Medida'] . ' ' . $insumos['Nombre'] . '</td>
	</tr>';

}

}

$html .= '</table>';

$bloque3 = <<<EOF

<table style="background-color:#FEFCCC; padding:5px; font-size: 5px;">
		
	<tr>
		
		<td style="width: 8%; text-align:left; border: 0.5px solid black">

			$value[fechaFormateada]

		</td>

		<td style="width: 10%; text-align:left; border: 0.5px solid black">

			$value[NroCompra]

		</td>

		<td style="width: 17%; text-align:left; border: 0.5px solid black">

			$proveedor[RazonSocial]

		</td>

		<td style="width: 11%; text-align:left; border: 0.5px solid black">

			$usuario[nombrePersona] $usuario[Apellido]

		</td>

		<td style="width: 17%; text-align:left; border: 0.5px solid black">

			$html 

		</td>

		<td style="width: 8%; text-align:right; border: 0.5px solid black">

			$impuesto

		</td>

		<td style="width: 8%; text-align:right; border: 0.5px solid black">

			$neto

		</td>

		<td style="width: 7%; text-align:right; border: 0.5px solid black">

			$total

		</td>

		<td style="width: 6%; text-align:right; border: 0.5px solid black">

			$value[MDP]

		</td>

		<td style="width: 8%; text-align:right; border: 0.5px solid black">

			$estado

		</td>
		
	</tr>

</table>

EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

}
//---------------------------------------------------------------------------------------------------



$pdf->Output('reporte.compras.pdf');

}

}

$reporte = new imprimirReporte();
$reporte -> traerReporte();

?>