<?php

require_once "../../../controladores/proveedores.controlador.php";
require_once "../../../modelos/proveedores.modelo.php";

require_once "../../../controladores/personas.controlador.php";
require_once "../../../modelos/personas.modelo.php";

class imprimirReporte{

public function traerReporte(){

//DATOS DE LA FECHA ACTUAL
date_default_timezone_set("America/Argentina/Tucuman");
$fechaReporte= date('d/m/Y');

//TRAEMOS LA INFORMACION DEL PROVEEDOR

$item = null;
$valor = null;
$listar = ControladorProveedores::ctrMostrarProveedores($item, $valor);
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

			REPORTE DE PROVEEDORES - $fechaReporte


		</td>
		
	</tr>

</table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

//---------------------------------------------------------------------------------------------------

$bloque2 = <<<EOF

<table style="background-color:#EE4242; padding:5px; font-size: 6px;">
		
	<tr>
		
		<td style="width: 14%; text-align:left; border: 0.5px solid black">

			RAZON SOCIAL

		</td>

		<td style="width: 10%; text-align:left; border: 0.5px solid black">

			CUIT

		</td>

		<td style="width: 10%; text-align:left; border: 0.5px solid black">

			IVA

		</td>

		<td style="width: 10%; text-align:left; border: 0.5px solid black">

			RUBRO

		</td>

		<td style="width: 12%; text-align:left; border: 0.5px solid black">

			EMAIL

		</td>

		<td style="width: 12%; text-align:center; border: 0.5px solid black">

			TELÉFONO

		</td>

		<td style="width: 8%; text-align:left; border: 0.5px solid black">

			ALTA

		</td>

		<td style="width: 14%; text-align:center; border: 0.5px solid black">

			DOMICILIO

		</td>

		<td style="width: 10%; text-align:center; border: 0.5px solid black">

			REFERENTE

		</td>
		
	</tr>

</table>

EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');

//---------------------------------------------------------------------------------------------------

foreach ($listar as $key => $proveedor) {
	
$domicilio = ControladorProveedores::ctrTraerDomicilioProveedores($proveedor["ProveedorID"]);

$referente = ControladorProveedores::ctrTraerReferenteProveedor($proveedor["ProveedorID"]);

if ($referente =="") {
	
$telefono = "";
$persona = "";
$email = "";

} else {

$telefono = '('.$referente["Prefijo"].') - '.$referente["NroTelefono"];
$persona = $referente["Nombre"].' '.$referente["Apellido"];
$email = $referente["Email"];

}


$bloque3 = <<<EOF

<table style="background-color:#FEFCCC; padding:5px; font-size: 6px;">
		
	<tr>
		
		<td style="width: 14%; text-align:left; border: 0.5px solid black">

			$proveedor[RazonSocial]

		</td>

		<td style="width: 10%; text-align:left; border: 0.5px solid black">

			$proveedor[CUITT]

		</td>

		<td style="width: 10%; text-align:left; border: 0.5px solid black">

			$proveedor[IVA]

		</td>

		<td style="width: 10%; text-align:left; border: 0.5px solid black">

			$proveedor[Rubro]

		</td>

		<td style="width: 12%; text-align:left; border: 0.5px solid black">

			$proveedor[Email]

		</td>

		<td style="width: 12%; text-align:center; border: 0.5px solid black">

			($proveedor[Prefijo]) - $proveedor[NroTelefono]

		</td>

		<td style="width: 8%; text-align:left; border: 0.5px solid black">

			$proveedor[Alta]

		</td>

		<td style="width: 14%; text-align:center; border: 0.5px solid black">

			$domicilio[Calle] $domicilio[Nro] $domicilio[Piso] $domicilio[Dpto]

		</td>

		<td style="width: 10%; text-align:center; border: 0.5px solid black">

			$persona
			$telefono
			$email

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