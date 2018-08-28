<?php

	//CREAR LIQUIDACION

	$valorC = "S";
	$itemC = "Fijo";
	$listarConceptos = ControladorPayment::ctrMostrarConceptosLiquidar($itemC, $valorC);

	$listaDeConceptos = array();

	$totalHaberesRemunerativos = 0;
	$totalHaberesNoRemunerativos= 0;
	$totalRetenciones = 0;

	foreach ($listarConceptos as $key => $value) {

		switch ($value["Tipo"]) {

			case '1':

				//HABERES REMUNERATIVOS

				switch ($value["Descripcion"]) {

					case 'Sueldo Basico':

						//SUELDO BASICO
						$concepto = $value["Descripcion"];
						$valorConcepto = $sueldoBasico;
						$totalHaberesRemunerativos = $sueldoBasico;
						$unidades = $value["Unidades"];

						break;

					case 'Antigüedad':

						//ANTIGUEDAD

						$concepto = $value["Descripcion"];

						if ($antiguedad > 0) {

							if ($value["Porcentaje"] =="N") {

								$unidades = number_format((float)$antiguedad, 2, '.', '');
								$valorConcepto = $unidades * $value["Unidades"];
								$totalHaberesRemunerativos = $totalHaberesRemunerativos + $valorConcepto;

							} else {

								$porcentaje = ($sueldoBasico * $value["Unidades"])/100;
								$valorConcepto = $porcentaje * $antiguedad;
								$unidades = number_format((float)$antiguedad, 2, '.', '');
								$totalHaberesRemunerativos = $totalHaberesRemunerativos + $valorConcepto;

							}

						} else {

							$valorConcepto = 0;
							$unidades = 0;
							$totalHaberesRemunerativos = $totalHaberesRemunerativos;

						}

					break;

					default:

						$concepto = $value["Descripcion"];

						if ($concepto != "Aguinaldo") {

							if ($value["Porcentaje"] =="N") {

								$unidades = 0;
								$valorConcepto = $value["Unidades"];

							} else {

								$unidades = $value["Unidades"];
								$valorConcepto = ($totalHaberesRemunerativos * $unidades)/100;

							}

						} else {

							if ($value["Porcentaje"] =="N") {

								$unidades = 0;
								$valorConcepto = 0;

							} else {

								$unidades = 0;
								$valorConcepto = ($totalHaberesRemunerativos * $unidades)/100;

							}

						}

						$totalHaberesRemunerativos = $totalHaberesRemunerativos + $valorConcepto;


					break;

				} // FIN SWITCH HABERES REMUNERATIVOS


					if ($concepto !="Antigüedad") {

						if ($concepto == "Sueldo Basico") {

							echo '<tr id="agregarConcepto">';

						} else {

							echo '<tr>';

						}

						if ($concepto != "Vacaciones") {

							if ($concepto != "Aguinaldo") {

								echo '
							 			<th scope="row" class="text-center">'.$value["Codigo"].'</th>
								  		<td><span id="nuevaDescripcionConcepto" class="nuevaDescripcionConcepto" idConcepto="'.$value["ConceptoID"].'" descripcionConcepto="'.$value["Descripcion"].'" tipoConcepto="'.$value["Tipo"].'" fijoConcepto="'.$value["Fijo"].'">'.$value["Descripcion"].'</span></td>
								  		<td class="text-center"><span id="unidades" class="unidades" unidadesConcepto="'.$unidades.'">'.$unidades.'</span></td>
								  		<td class="text-center SueldoBasico" sueldo="'.$sueldoBasico.'"><span id="sumarSueldo" class="sumarSueldo valorConcepto" valorConcepto="'.$valorConcepto.'">'.number_format((float)$valorConcepto, 2, '.', '').'</span></td>
								  		<td></td>
								  		<td></td>
								  </tr>';

								$dtConceptos = array("ConceptoID" => $value["ConceptoID"],
								                 "Descripcion" => $value["Descripcion"],
								                 "Tipo" => $value["Tipo"],
								                 "Fijo" => $value["Fijo"],
								                 "Unidades" => $value["Unidades"],
								                 "Total" => $valorConcepto);

								array_push($listaDeConceptos, $dtConceptos);

							}

						}

					} else {

						if ($antiguedad > 0) {

							echo '<tr>
						 			<th scope="row" class="text-center">'.$value["Codigo"].'</th>
							  		<td><span id="nuevaDescripcionConcepto" class="nuevaDescripcionConcepto" idConcepto="'.$value["ConceptoID"].'" descripcionConcepto="'.$value["Descripcion"].'" tipoConcepto="'.$value["Tipo"].'" fijoConcepto="'.$value["Fijo"].'">'.$value["Descripcion"].'</span></td>
							  		<td class="text-center"><span id="unidades" class="unidades" unidadesConcepto="'.$unidades.'">'.$unidades.'</span></td>
							  		<td class="text-center SueldoBasico Anti" sueldo="'.$sueldoBasico.'" valorAntiguedad="'.$valorConcepto.'"><span id="sumarSueldo" class="sumarSueldo valorConcepto" valorConcepto="'.$valorConcepto.'">'.number_format((float)$valorConcepto, 2, '.', '').'</span></td>
							  		<td></td>
							  		<td></td>
							  </tr>';

							$dtConceptos = array("ConceptoID" => $value["ConceptoID"],
							                 "Descripcion" => $value["Descripcion"],
							                 "Tipo" => $value["Tipo"],
							                 "Fijo" => $value["Fijo"],
							                 "Unidades" => $value["Unidades"],
							                 "Total" => number_format((float)$valorConcepto, 2, '.', ''));

							array_push($listaDeConceptos, $dtConceptos);
						}
					}

			break;
	//-------------------------------------------------------------------------------------------------------------------------------------------
			case '2':

				//HABERES NO REMUNERATIVOS

				$concepto = $value["Descripcion"];

				if ($value["Porcentaje"] =="N") {

					$unidades = 1;
					$valorConcepto = $value["Unidades"];
					$totalHaberesNoRemunerativos = $totalHaberesNoRemunerativos+$valorConcepto;

				} else {

					$unidades = $value["Unidades"];
					$valorConcepto = ($sueldoBasico * $unidades)/100;
					$totalHaberesNoRemunerativos = $totalHaberesNoRemunerativos+$valorConcepto;

				}

				echo '<tr id="agregarConcepto">
			    	    <th scope="row" class="text-center">'.$value["Codigo"].'</th>
			        	<td><span id="nuevaDescripcionConcepto" class="nuevaDescripcionConcepto" idConcepto="'.$value["ConceptoID"].'" descripcionConcepto="'.$value["Descripcion"].'" tipoConcepto="'.$value["Tipo"].'" fijoConcepto="'.$value["Fijo"].'">'.$value["Descripcion"].'</span></td>
			            <td class="text-center"><span id="unidades" class="unidades" unidadesConcepto="'.$unidades.'">'.$unidades.'</span></td>
			            <td></td>
			            <td class="text-center"><span id="sumarNoRemunerativos" class="sumarNoRemunerativos valorConcepto" valorConcepto="'.$valorConcepto.'">'.number_format((float)$valorConcepto, 2, '.', '').'</span></td>
			            <td></td>
			         </tr>';

		        $dtConceptos = array("ConceptoID" => $value["ConceptoID"],
							                 "Descripcion" => $value["Descripcion"],
							                 "Tipo" => $value["Tipo"],
							                 "Fijo" => $value["Fijo"],
							                 "Unidades" => $value["Unidades"],
							                 "Total" => number_format((float)$valorConcepto, 2, '.', ''));

				array_push($listaDeConceptos, $dtConceptos);


			break;
	//-------------------------------------------------------------------------------------------------------------------------------------------
			case '3':

				//HABERES QUE SON TIPO RETENCION

				$concepto = $value["Descripcion"];
				$trimed = substr($concepto, 0, 3);

				if ($value["Porcentaje"] =="N") {

					$unidades = 1;
					$valorConcepto = $value["Unidades"];
					$totalRetenciones = $totalRetenciones + $valorConcepto;

				} else {

					$unidades = $value["Unidades"];
					$valorConcepto = ($totalHaberesRemunerativos*$value["Unidades"])/100;
					$totalRetenciones = $totalRetenciones + $valorConcepto;

				}

				echo '<tr id="agregarConceptoRetencion">
			            <th scope="row" class="text-center">'.$value["Codigo"].'</th>
			            <td><span id="nuevaDescripcionConcepto" class="nuevaDescripcionConcepto" idConcepto="'.$value["ConceptoID"].'" descripcionConcepto="'.$value["Descripcion"].'" tipoConcepto="'.$value["Tipo"].'" fijoConcepto="'.$value["Fijo"].'">'.$value["Descripcion"].'</span></td>
			            <td class="text-center"><span id="unidades" class="unidades" unidadesConcepto="'.$unidades.'">'.$unidades.'</span></td>
			            <td></td>
			            <td></td>
			            <td class="text-center"><span id="sumarRetencion" class="sumarRetencion valorConcepto retencion'.$trimed.'" valorConcepto="'.number_format((float)$valorConcepto, 2, '.', '').'">'. number_format((float)$valorConcepto, 2, '.', '').'</span></td>
			        </tr>';



			    $dtConceptos = array("ConceptoID" => $value["ConceptoID"],
				                     "Descripcion" => $value["Descripcion"],
				                     "Tipo" => $value["Tipo"],
				                     "Fijo" => $value["Fijo"],
				                     "Unidades" => $value["Unidades"],
				                     "Total" => number_format((float)$valorConcepto, 2, '.', ''));

				array_push($listaDeConceptos, $dtConceptos);

			break;

			}

	}



	$TotalRemu = number_format((float)$totalHaberesRemunerativos, 2, '.', '');
	$TotalNoRemu = number_format((float)$totalHaberesNoRemunerativos, 2, '.', '');
	$totalReten = number_format((float)$totalRetenciones, 2, '.', '');
	$totalNeto = number_format((float)$TotalRemu + $TotalNoRemu - $totalReten, 2, '.', '');

	echo '<tr>
	        <th scope="row" colspan="3" class="table-success text-right">TOTALES:</th>
	        <td class="table-warning text-center"><span id="sumarNeto" class="sumarNeto HaberesRemunerativos" totalR="'.$TotalRemu.'">'.$TotalRemu.'</span></td>
	        <td class="table-warning text-center">';

		        if ($totalHaberesNoRemunerativos !=0) {

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
