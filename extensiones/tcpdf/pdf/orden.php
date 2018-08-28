<?php

require_once "../../../controladores/compras.controlador.php";
require_once "../../../modelos/compras.modelo.php";

require_once "../../../controladores/usuarios.controlador.php";
require_once "../../../modelos/usuarios.modelo.php";

require_once "../../../controladores/proveedores.controlador.php";
require_once "../../../modelos/proveedores.modelo.php";

require_once "../../../controladores/configuracion.controlador.php";
require_once "../../../modelos/configuracion.modelo.php";

require_once "../../../controladores/insumos.controlador.php";
require_once "../../../modelos/insumos.modelo.php";

class imprimirOrden{

public $ordenID;

public function traerImpresionOrden(){

//TRAER INFORMACION DE LA COMPRA

$itemCompra = "CompraID";
$valorCompra= $this->ordenID;
$valorNota = "S";

$respuestaCompra = ControladorCompras::ctrMostrarCompras($itemCompra, $valorCompra);

if ($respuestaCompra["Nota"] == "N") {

$respuestaNota = ControladorCompras::ctrTipoNota($valorCompra, $valorNota);

}else{

$respuestaNota = "";

}

//TRAEMOR MDP
$itemMDP = "MedioPagoID";
$valorMDP = $respuestaCompra["MedioPagoID"];

$medioPago = ControladorConfiguracion::ctrMostrarMdps($itemMDP, $valorMDP);

//TRAIGO PDV
$PDV = ControladorConfiguracion::ctrMostrarPdvActivo();

//NUMERO DE ORDEN
$numbOrden1 = substr($respuestaCompra["NroCompra"], 0, -8);
$numbOrden2 = substr($respuestaCompra["NroCompra"], -8);

$nroOrden = $numbOrden1.'-'.$numbOrden2;

$fecha = $respuestaCompra["fechaFormateada"];

$neto = number_format($respuestaCompra["Neto"],2);
$total = number_format($respuestaCompra["Total"],2);
$impuesto = number_format($respuestaCompra["Impuesto"],2);

$porcentajeImpuesto = $respuestaCompra["Impuesto"]* 100 / $respuestaCompra["Neto"];
$redondeo = round($porcentajeImpuesto);

//TRAEMOS LA INFORMACIÓN DEL PROVEEDOR

$itemProveedor = "ProveedorID";
$valorProveedor = $respuestaCompra["ProveedorID"];

$respuestaProveedor = ControladorProveedores::ctrMostrarProveedores($itemProveedor, $valorProveedor);

$domProveedores = ControladorProveedores::ctrTraerDomicilioProveedores($respuestaProveedor["ProveedorID"]);

if ($domProveedores["Piso"]!="") {

$piso = "Piso: ".$domProveedores["Piso"];

}else{

$piso="";

}

if ($domProveedores["Dpto"]!="") {

$dpto = "Dpto: ".$domProveedores["Dpto"];

}else{

$dpto="";

}

//TRAIGO INFORMACION DEL USUARIO QUE CARGA LA COMPRA

$itemUsuario = "UsuarioID";
$valorUsuario = $respuestaCompra["UsuarioRegistraID"];

$respuestaComprador = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);

//TRAIGO LOS INSUMOS Y LOS PRODUCTOS

$respuestaInsumos = ControladorInsumos::ctrMostrarInsumosCompra($itemCompra, $valorCompra);

//CONSTRUIMOS EL PDF

require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->startPageGroup();

$pdf->AddPage();

//---------------------------------------------------------------------------------------------------

$bloque1 = <<<EOF

<table style="border-style: solid; border-top-width: 1px; border-color: #FFFFFF; padding:5px">
		
	<tr>
		
		<td style="width: 200px; text-align:center">

			<br><img src="images/logo.png" style="width: 120px">
		
			<br><span style="font-size: 7px">$PDV[Calle] $PDV[Nro] $PDV[Piso] $PDV[Dpto]</span>

			<br><span style="font-size: 7px">$PDV[CP] - $PDV[Localidad]</span>

			<br><span style="font-size: 7px">Telefono : ($PDV[Prefijo]) - $PDV[NroTelefono]</span>

			<br><span style="font-weight: bold; font-size: 9px">RESPONSABLE MONOTRIBUTO</span>
			<br>


		</td>
		
		<td style="width:140px; text-align:center">
			
			<br><br><span style="font-weight: bold;	font-size: 34px;"></span>
			
			<br><br><span style="font-size: 8px;"></span>
				
		</td>

		<td style="width:200px; text-align:left">
			
			<br><br><span style="font-weight: bold; font-size: 17px">Orden de Compra</span>
			
			<br><span style="font-size: 16px">N° $nroOrden</span>
			
			<br><br><span style="font-weight: bold; font-size: 9px">Fecha: </span><span style="font-size: 9px">$fecha</span> 
		
			<br><span style="font-weight: bold; font-size: 9px">CUIT: </span><span style="font-size: 9px">$PDV[CUITT]</span>

			<br><span style="font-weight: bold; font-size: 9px">ING BRUTOS: </span><span style="font-size: 9px">$PDV[IngresosBrutos]</span>

			<br><span style="font-weight: bold; font-size: 9px">INIC ACT: </span><span style="font-size: 9px">$PDV[Inicio]</span>

		</td>

	</tr>

</table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

//---------------------------------------------------------------------------------------------------

$bloque2 = <<<EOF


<table style="border-style: solid; border-top-width: 0.5px; border-left-width: 0.5px; border-right-width: 0.5px; border-bottom-width: 0.5px; border-color: #D3D3D3; padding: 5px">
		
	<tr>
		
		<td style="width:100%">

			<span style="font-weight: bold; font-size: 10px">PROVEEDOR: </span><span style="font-size: 10px">$respuestaProveedor[RazonSocial]</span><br>
			
			<span style="font-weight: bold; font-size: 10px">DOMICILIO: </span><span style="font-size: 10px">$domProveedores[Calle] N° $domProveedores[Nro] $piso $dpto - $domProveedores[Barrio] - $domProveedores[Localidad]</span><br>
			
			<span style="font-weight: bold; font-size: 10px">COND. COMPRA: </span><span style="font-size: 10px">$medioPago[Nombre]</span><br>
			
			<span style="font-weight: bold; font-size: 10px">COND. IVA: </span><span style="font-size: 10px">$respuestaProveedor[IVA]</span>

		</td>

	</tr>

</table>

EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');

//---------------------------------------------------------------------------------------------------

$bloque3 = <<<EOF

<table style="border-style: solid; border-top-width: 0.5px; border-left-width: 0.5px; border-right-width: 0.5px; border-bottom-width: 0.5px; border-color: #D3D3D3; padding: 5px;  text-align:center; font-weight: bold; font-size: 11px">
		
	<tr>
		
		<td style="width:50px">Cod</td>

		<td style="width:50px">Cant</td>
		
		<td style="width:280px">Descripción</td>
		
		<td style="width:80px">P.Unitario</td>
		
		<td style="width:79px">Importe</td>

	</tr>

</table>

EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

//---------------------------------------------------------------------------------------------------

foreach ($respuestaInsumos as $key => $value) {

$importe = $value["PrecioUnitario"] * $value["Cantidad"];

$imp = number_format($importe,2);
	
$bloque4 = <<<EOF

<table style="border-style: solid; border-top-width: 0.5px; border-left-width: 0.5px; border-right-width: 0.5px; border-bottom-width: 0.5px; border-color: #D3D3D3; padding: 7px;  text-align:center; font-size: 10px">
		
	<tr>
		
		<td style="width:50px">$value[Codigo]</td>

		<td style="width:50px">$value[Cantidad]</td>
		
		<td style="width:280px">$value[Nombre]</td>
		
		<td style="width:80px">$ $value[PrecioUnitario]</td>
		
		<td style="width:79px">$ $imp</td>

	</tr>

</table>

EOF;

$pdf->writeHTML($bloque4, false, false, false, false, '');

}

//---------------------------------------------------------------------------------------------------

if ($respuestaCompra["Estado"]== "Z") {
	
$bloque5 = <<<EOF

	<table style="border-style: solid; border-top-width: 1px; border-color: #FFFFFF; padding:5px; text-align:center; font-weight: bold; font-size: 50px; color:red" >
		
		<tr>
		
			<td style="width:100%"></td>
			
		</tr>

		<tr>
		
			<td style="width:100%">ANULADA</td>
			
		</tr>
		
	</table>

EOF;

}else{

$bloque5 = <<<EOF

	
EOF;

}

$pdf->writeHTML($bloque5, false, false, false, false, '');

//---------------------------------------------------------------------------------------------------

$bloque6 = <<<EOF

<table style="padding: 5px; text-align:center">
		
	<tr>
		
		<td style="width:50px"></td>

		<td style="width:50px"></td>
		
		<td style="width:280px"></td>
		
		<td style="width:80px"></td>
		
		<td style="width:79px"></td>

	</tr>

	<tr>
		
		<td style="width:50px"></td>

		<td style="width:50px"></td>
		
		<td style="width:280px"></td>
		
		<td style="width:80px"></td>
		
		<td style="width:79px"></td>

	</tr>

	<tr>
		
		<td style="width:50px"></td>

		<td style="width:50px"></td>
		
		<td style="width:280px"></td>
		
		<td style="width:80px"></td>
		
		<td style="width:79px"></td>

	</tr>

	<tr>
		
		<td style="width:50px"></td>

		<td style="width:50px"></td>
		
		<td style="width:280px"></td>
		
		<td style="width:80px"></td>
		
		<td style="width:79px"></td>


	</tr>

	<tr>
		
		<td style="width:50px"></td>

		<td style="width:50px"></td>
		
		<td style="width:280px"></td>
		
		<td style="width:80px"></td>
		
		<td style="width:79px"></td>

	</tr>

	<tr>
		
		<td style="width:50px"></td>

		<td style="width:50px"></td>
		
		<td style="width:280px"></td>
		
		<td style="width:80px"></td>
		
		<td style="width:79px"></td>

		
	</tr>

	<tr>
		
		<td style="width:50px"></td>

		<td style="width:50px"></td>
		
		<td style="width:280px"></td>
		
		<td style="width:80px; font-weight: bold; font-size: 11px; background-color: #DCDCDC;">Subtotal</td>
		
		<td style="width:79px; background-color: #DCDCDC;">$ $neto</td>

	</tr>

	<tr>
		
		<td style="width:50px"></td>

		<td style="width:50px"></td>
		
		<td style="width:280px"></td>
		
		<td style="width:80px; font-weight: bold; font-size: 11px; background-color: #DCDCDC;">IVA (%$redondeo)</td>
		
		<td style="width:79px; background-color: #DCDCDC;">$ $impuesto</td>

	</tr>

	<tr>
		
		<td style="width:50px"></td>

		<td style="width:50px"></td>
		
		<td style="width:280px"></td>
		
		<td style="width:80px; border-top: 1px dashed #808080; font-weight: bold; font-size: 11px; background-color: #DCDCDC;">Total</td>
		
		<td style="width:79px; border-top: 1px dashed #808080; background-color: #DCDCDC;">$ $total</td>

	</tr>

</table>

EOF;

$pdf->writeHTML($bloque6, false, false, false, false, '');
//---------------------------------------------------------------------------------------------------

$pdf->Output('compra -'.$nroOrden.'-'.$fecha.'.pdf');

}

}


$factura = new imprimirOrden();
$factura -> ordenID = $_GET["compra"];
$factura -> traerImpresionOrden();


?>