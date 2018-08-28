<?php

require_once "../../../controladores/ventas.controlador.php";
require_once "../../../modelos/ventas.modelo.php";

require_once "../../../controladores/clientes.controlador.php";
require_once "../../../modelos/clientes.modelo.php";

require_once "../../../controladores/usuarios.controlador.php";
require_once "../../../modelos/usuarios.modelo.php";

require_once "../../../controladores/configuracion.controlador.php";
require_once "../../../modelos/configuracion.modelo.php";

class imprimirFactura{

public $ventaID;

public function traerImpresionFactura(){

//TRAER INFORMACION DE LA VENTA

$itemVenta = "VentaID";
$valorVenta= $this->ventaID;
$valorFactura = "C";

$respuestaVenta = ControladorVentas::ctrMostrarVentas($itemVenta, $valorVenta);

if ($respuestaVenta["FacturaTipo"] == null) {

$respuestaFactura = ControladorVentas::ctrTipoFactura($valorVenta, $valorFactura);

}else{

$respuestaFactura = "";

}
//TRAEMOS MEDIO DE PAGO
$valorMDP = $respuestaVenta["MedioPagoID"];
$itemMDP = "MedioPagoID";

$medioPago = ControladorConfiguracion::ctrMostrarMdPs($itemMDP, $valorMDP);

//TRAIGO PDV
$PDV = ControladorConfiguracion::ctrMostrarPdvActivo();

//NUMERO RECIBO
$numbFactura1 = substr($respuestaVenta["NroFactura"], 0, -8);
$numbFactura2 = substr($respuestaVenta["NroFactura"], -8);

$nroFactura = $numbFactura1.'-'.$numbFactura2;
$fecha = $respuestaVenta["fechaFormateada"];
$neto = number_format($respuestaVenta["Neto"],2);
$total = number_format($respuestaVenta["Total"],2);

//RECARGO DESCUENTO

$recarTemp = intval($respuestaVenta["MontoRecargo"]);
$descaTemp = intval($respuestaVenta["MontoDescuento"]);

$recargo = $respuestaVenta["MontoRecargo"];
$descuento = $respuestaVenta["MontoDescuento"];               

if ($recarTemp!=0) {

    $valor = "$".$recargo;
                    
} else if($descaTemp!=0){

    $valor = "$".$descuento;

} else {

    $valor = "-------";
}


//TRAEMOS LA INFORMACIÓN DEL CLIENTE

$itemCliente = "ClienteID";
$valorCliente = $respuestaVenta["ClienteID"];

$respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

if ($respuestaCliente["Piso"]!="") {

$piso = "Piso: ".$respuestaCliente["Piso"];

}else{

$piso="";

}

if ($respuestaCliente["Dpto"]!="") {

$dpto = "Dpto: ".$respuestaCliente["Dpto"];

}else{

$dpto="";

}

//TRAIGO INFORMACION DEL VENDEDOR

$itemUsuario = "UsuarioID";
$valorUsuario = $respuestaVenta["UsuarioRegistraID"];

$respuestaVendedor = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);

//TRAIGO LOS PRODUCTOS

$respuestaProductos = ControladorVentas::ctrListadoProductos($valorVenta);

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
			
			<br><br><span style="font-weight: bold;	font-size: 34px;">C</span>
			
			<br><br><span style="font-size: 8px;">Código 01</span>
				
		</td>

		<td style="width:200px; text-align:left">
			
			<br><br><span style="font-weight: bold; font-size: 17px">FACTURA</span>
			
			<br><span style="font-size: 16px">N° $nroFactura</span>
			
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

			<span style="font-weight: bold; font-size: 10px">SEÑOR (ES): </span><span style="font-size: 10px">$respuestaCliente[Nombre] $respuestaCliente[Apellido]</span><br>
			
			<span style="font-weight: bold; font-size: 10px">DOMICILIO: </span><span style="font-size: 10px">$respuestaCliente[Calle] N° $respuestaCliente[Nro] $piso $dpto - $respuestaCliente[Barrio] - $respuestaCliente[Localidad]</span><br>
			
			<span style="font-weight: bold; font-size: 10px">COND. VENTA: </span><span style="font-size: 10px">$medioPago[Nombre]</span>
			
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


foreach ($respuestaProductos as $key => $value) {

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

if ($recarTemp!=0) {

$bloque5 = <<<EOF

	<table style="border-style: solid; border-top-width: 0.5px; border-left-width: 0.5px; border-right-width: 0.5px; border-bottom-width: 0.5px; border-color: #D3D3D3; padding: 7px;  text-align:center; font-size: 10px">
		
		<tr>
		
			<td style="width:50px">000</td>

			<td style="width:50px">1</td>
		
			<td style="width:280px">Recargo</td>
		
			<td style="width:80px">$ $recargo</td>
		
			<td style="width:79px">$ $recargo</td>

		</tr>

	</table>

EOF;
                    
}else if($descaTemp!=0){

$bloque5 = <<<EOF

	<table style="border-style: solid; border-top-width: 0.5px; border-left-width: 0.5px; border-right-width: 0.5px; border-bottom-width: 0.5px; border-color: #D3D3D3; padding: 7px;  text-align:center; font-size: 10px">
		
		<tr>
		
			<td style="width:50px">000</td>

			<td style="width:50px">1</td>
		
			<td style="width:280px">Descuento</td>
		
			<td style="width:80px">$ $descuento</td>
		
			<td style="width:79px">$ $descuento</td>

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
		
		<td style="width:80px; font-weight: bold; font-size: 11px; background-color: #DCDCDC;">Otros</td>
		
		<td style="width:79px; background-color: #DCDCDC;">$valor</td>

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

$pdf->Output('recibo'.$nroFactura.'.pdf');

}

}

$factura = new imprimirFactura();
$factura -> ventaID = $_GET["venta"];
$factura -> traerImpresionFactura();


?>