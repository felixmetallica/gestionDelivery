<?php 

//EDITAR LIQUIDACION

	$valorC = $_GET["idBoleta"];
	$itemC = "LiquidacionID";
	$listarConceptos = ControladorPayment::ctrMostrarConceptosDeBoleta($itemC, $valorC);
	$listaDeConceptos = array();

	foreach ($listarConceptos as $key => $value) {

		//LISTAMOS LOS CONCEPTOS EN UN ARRAY
		
		$dtConceptos = array("ConceptoID" => $value["ConceptoID"],
			                 "Descripcion" => $value["Descripcion"],
			                 "Tipo" => $value["Tipo"],
			                 "Fijo" => $value["Fijo"],
			                 "Unidades" => $value["Unidades"],
			                 "Total" => $value["Total"]);

							array_push($listaDeConceptos, $dtConceptos);
		
		switch ($value["Tipo"]) {
			
			case '1':
				
				//CONCEPTOS REMUNERATIVOS FIJOS

				if ($value["Fijo"] == 'S') {
					
					switch ($value["Descripcion"]) {
						
						case 'Sueldo Basico':
							
							echo '<tr id="agregarConcepto">
						 			<th scope="row" class="text-center">'.$value["Codigo"].'</th>
							  		<td><span id="nuevaDescripcionConcepto" class="nuevaDescripcionConcepto" idConcepto="'.$value["ConceptoID"].'" descripcionConcepto="'.$value["Descripcion"].'" tipoConcepto="'.$value["Tipo"].'" fijoConcepto="'.$value["Fijo"].'">'.$value["Descripcion"].'</span></td>
							  		<td class="text-center"><span id="unidades" class="unidades" unidadesConcepto="'.$value["Unidades"].'">'.$value["Unidades"].'</span></td>
							  		<td class="text-center SueldoBasico" sueldo="'.$sueldoBasico.'"><span id="sumarSueldo" class="sumarSueldo valorConcepto" valorConcepto="'.$value["Total"].'">'.number_format((float)$value["Total"], 2, '.', '').'</span></td>
							  		<td></td>
							  		<td></td>
							  </tr>';
							
							break;

						case 'Antigüedad':
							
							echo '<tr>
						 			<th scope="row" class="text-center">'.$value["Codigo"].'</th>
							  		<td><span id="nuevaDescripcionConcepto" class="nuevaDescripcionConcepto" idConcepto="'.$value["ConceptoID"].'" descripcionConcepto="'.$value["Descripcion"].'" tipoConcepto="'.$value["Tipo"].'" fijoConcepto="'.$value["Fijo"].'">'.$value["Descripcion"].'</span></td>
							  		<td class="text-center"><span id="unidades" class="unidades" unidadesConcepto="'.$value["Unidades"].'">'.$value["Unidades"].'</span></td>
							  		<td class="text-center SueldoBasico Anti" sueldo="'.$sueldoBasico.'" valorAntiguedad="'.$value["Total"].'"><span id="sumarSueldo" class="sumarSueldo valorConcepto" valorConcepto="'.$value["Total"].'">'.number_format((float)$value["Total"], 2, '.', '').'</span></td>
							  		<td></td>
							  		<td></td>
							  </tr>';
							
							break;
						
						default:

							if ($value["Descripcion"] != "Vacaciones") {
								
								echo '<tr>
							 			<th scope="row" class="text-center">'.$value["Codigo"].'</th>
								  		<td><span id="nuevaDescripcionConcepto" class="nuevaDescripcionConcepto" idConcepto="'.$value["ConceptoID"].'" descripcionConcepto="'.$value["Descripcion"].'" tipoConcepto="'.$value["Tipo"].'" fijoConcepto="'.$value["Fijo"].'">'.$value["Descripcion"].'</span></td>
								  		<td class="text-center"><span id="unidades" class="unidades" unidadesConcepto="'.$value["Unidades"].'">'.$value["Unidades"].'</span></td>
								  		<td class="text-center SueldoBasico" sueldo="'.$sueldoBasico.'"><span id="sumarSueldo" class="sumarSueldo valorConcepto" valorConcepto="'.$value["Total"].'">'.number_format((float)$value["Total"], 2, '.', '').'</span></td>
								  		<td></td>
								  		<td></td>
								  </tr>';
							

							} else {

								
							}

							break;
					}


				} else {

					//CONCEPTOS REMUNERATIVOS NO FIJOS

					echo '<tr>
	                        <th scope="row"><div class="material-addone"><button type="button" class="btn btn-mini btn-danger p-1 quitarConcepto" idConcepto="'.$value["ConceptoID"].'"><i class="icofont icofont-close"></i></button> '.$value["Codigo"].' </div></th>
	                        <td><span id="nuevaDescripcionConcepto" class="nuevaDescripcionConcepto" idConcepto="'.$value["ConceptoID"].'" descripcionConcepto="'.$value["Descripcion"].'" tipoConcepto="'.$value["Tipo"].'" fijoConcepto="'.$value["Fijo"].'">'.$value["Descripcion"].'</span></td>
	                        <td class="text-center"><span id="unidades" class="unidades" unidadesConcepto="'.$value["Unidades"].'">'.$value["Unidades"].'</span></td>
	                        <td class="text-center"><span id="sumarSueldo" class="sumarSueldo valorConcepto" valorConcepto="'.$value["Total"].'">'.$value["Total"].'</spam></td>
	                        <td class="text-center"></span></td>
	                        <td class="text-center"></td>
	                    </tr>';

				}
				
				break;
//-------------------------------------------------------------------------------------------------------------------------------------------	
			case '2':
			
				//CONCEPTOS NO REMUNERATIVOS 

				if ($value["Fijo"] == 'S') {

					echo '<tr>
	                        <th scope="row"><div class="material-addone"><button type="button" class="btn btn-mini btn-danger p-1 quitarConcepto" idConcepto="'.$value["ConceptoID"].'"><i class="icofont icofont-close"></i></button>'. $value["Codigo"].' </div></th>
	                        <td><span id="nuevaDescripcionConcepto" class="nuevaDescripcionConcepto" idConcepto="'.$value["ConceptoID"].'" descripcionConcepto="'.$value["Descripcion"].'" tipoConcepto="'.$value["Tipo"].'" fijoConcepto="'.$value["Fijo"].'">'.$value["Descripcion"].'</span></td>
	                        
	                        <td class="text-center"><span id="unidades" class="unidades" unidadesConcepto="'.$value["Unidades"].'">'.$value["Unidades"].'</span></td>
	                        <td></td>
	                        <td class="text-center"><span id="sumarNoRemunerativos" class="sumarNoRemunerativos valorConcepto" valorConcepto="'.$value["Total"].'">'.$value["Total"].'</span></td>
	                        <td></td>
	                    </tr>';
				
				} else {

					//CONCEPTOS NO REMUNERATIVOS NO FIJOS

					echo '<tr>
	                        <th scope="row"><div class="material-addone"><button type="button" class="btn btn-mini btn-danger p-1 quitarConcepto" idConcepto="'.$value["ConceptoID"].'"><i class="icofont icofont-close"></i></button>'. $value["Codigo"].' </div></th>
	                        <td><span id="nuevaDescripcionConcepto" class="nuevaDescripcionConcepto" idConcepto="'.$value["ConceptoID"].'" descripcionConcepto="'.$value["Descripcion"].'" tipoConcepto="'.$value["Tipo"].'" fijoConcepto="'.$value["Fijo"].'">'.$value["Descripcion"].'</span></td>
	                        
	                        <td class="text-center"><span id="unidades" class="unidades" unidadesConcepto="'.$value["Unidades"].'">'.$value["Unidades"].'</span></td>
	                        <td></td>
	                        <td class="text-center"><span id="sumarNoRemunerativos" class="sumarNoRemunerativos valorConcepto" valorConcepto="'.$value["Total"].'">'.$value["Total"].'</span></td>
	                        <td></td>
	                    </tr>';

				}

				break;
//-------------------------------------------------------------------------------------------------------------------------------------------				
			case '3':

				$concepto = $value["Descripcion"];
				$trimed = substr($concepto, 0, 3);

				if ($value["Fijo"] == 'S') {

					echo '<tr id="agregarConceptoRetencion">
				            <th scope="row" class="text-center">'.$value["Codigo"].'</th>
				            <td><span id="nuevaDescripcionConcepto" class="nuevaDescripcionConcepto" idConcepto="'.$value["ConceptoID"].'" descripcionConcepto="'.$value["Descripcion"].'" tipoConcepto="'.$value["Tipo"].'" fijoConcepto="'.$value["Fijo"].'">'.$value["Descripcion"].'</span></td>
				            <td class="text-center"><span id="unidades" class="unidades" unidadesConcepto="'.$value["Unidades"].'">'.$value["Unidades"].'</span></td>
				            <td></td>
				            <td></td>
				            <td class="text-center"><span id="sumarRetencion" class="sumarRetencion valorConcepto retencion'.$trimed.'" valorConcepto="'.number_format((float)$value["Total"], 2, '.', '').'">'. number_format((float)$value["Total"], 2, '.', '').'</span></td>
				        </tr>';

				} else {

					echo '<tr id="agregarConceptoRetencion">
				            <th scope="row"><div class="material-addone"><button type="button" class="btn btn-mini btn-danger p-1 quitarConcepto" idConcepto="'.$value["ConceptoID"].'"><i class="icofont icofont-close"></i></button>'. $value["Codigo"].' </div></th>
				            <td><span id="nuevaDescripcionConcepto" class="nuevaDescripcionConcepto" idConcepto="'.$value["ConceptoID"].'" descripcionConcepto="'.$value["Descripcion"].'" tipoConcepto="'.$value["Tipo"].'" fijoConcepto="'.$value["Fijo"].'">'.$value["Descripcion"].'</span></td>
				            <td class="text-center"><span id="unidades" class="unidades" unidadesConcepto="'.$value["Unidades"].'">'.$value["Unidades"].'</span></td>
				            <td></td>
				            <td></td>
				            <td class="text-center"><span id="sumarRetencion" class="sumarRetencion valorConcepto retencion'.$trimed.'" valorConcepto="'.number_format((float)$value["Total"], 2, '.', '').'">'. number_format((float)$value["Total"], 2, '.', '').'</span></td>
				        </tr>';

				}
				break;			
			
		}
	

	}

	$TotalRemu = number_format((float)$value["TotalRemunerativos"], 2, '.', '');
	$TotalNoRemu = number_format((float)$value["TotalNoRemunerativos"], 2, '.', '');
	$totalReten = number_format((float)$value["TotalRetenciones"], 2, '.', '');
	$totalNeto = number_format((float)$value["TotalNeto"], 2, '.', '');



	echo '<tr>
	        <th scope="row" colspan="3" class="table-success text-right">TOTALES:</th>
	        <td class="table-warning text-center"><span id="sumarNeto" class="sumarNeto HaberesRemunerativos" totalR="'.$TotalRemu.'">'.$TotalRemu.'</span></td>
	        <td class="table-warning text-center">';
		        
		        if ($TotalNoRemu !=0) {
		        	
		        	echo '<span id="sumarNeto" class="sumarNeto HaberesNoRemunerativos" totalNoR="'.$TotalNoRemu.'">'.$TotalNoRemu.'</span>';
		        
		        } else {

		        	echo '<span id="sumarNeto" class="sumarNeto HaberesNoRemunerativos" totalNoR="0"></span>';

		        }

	  echo '</td>
	        <td class="table-warning text-center"><span id="sumarNeto" class="sumarNeto Retenciones" totalRetenciones="'.$totalReten.'">'.$totalReten.'</span></td>
	    </tr>
	    <tr>
	        <th scope="row" colspan="5" class="table-success text-right">NETO:</th>
	        <td class="table-primary text-center"><span id="valorNeto" class="valorNeto" totalNeto="'.$totalNeto.'">$'.$totalNeto.'</span></td>
	    </tr>';

	$todoConceptos = json_encode($listaDeConceptos, JSON_UNESCAPED_UNICODE);

 
?>
