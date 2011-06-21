///Init/////
	//Création des périodes de tilendier
		$periode = new Application_Model_DbTable_Periode();
		$tab_all_adh[0]["SALAIRE"] = 20000;
		$type = "salarie";
		for($i=0;$i<62;++$i){
			$last = $periode->getDerniereId();
			
		
	$dom = new DomDocument;
									$dom->load(APPLICATION_PATH."/configs/param.xml");
									//Récupération Plafond sécurité sociale
									$plafond_secu = $dom->getElementsByTagName('plafond')->item(0)->nodeValue*12;
									$valeur_point_ARRCO = $dom->getElementsByTagName('point_arrco')->item(0)->nodeValue;
									$valeur_point_AGIRC = $dom->getElementsByTagName('point_agirc')->item(0)->nodeValue;
									$salaire_reference_arrco = $dom->getElementsByTagName('salaire_reference_arrco')->item(0)->nodeValue;
									$salaire_reference_agirc = $dom->getElementsByTagName('salaire_reference_agirc')->item(0)->nodeValue;

									//Calcul tranche
									if($type == "salarie")
									{
										////////////////////////////////////////////////////////////////////////////////////////////
										///////////////////////////////Cas d'un SALARIE///////////////////////////////////////////////
										////////////////////////////////////////////////////////////////////////////////////////////
										$part_salaire_ARRCO = $tab_all_adh[0]["SALAIRE"];
										$part_salaire_AGIRC = 0;

										//On répartie la part du salaire ARRCO sur les différente tranche
										if($tab_all_adh[0]["SALAIRE"] < $plafond_secu)
										{
											$part_salaire_ARRCO_tranche_1 = $tab_all_adh[0]["SALAIRE"];
											$part_salaire_ARRCO_tranche_2 = 0;
										}else{
											$part_salaire_ARRCO_tranche_1 = $plafond_secu;
											$part_salaire_ARRCO_tranche_2 = $tab_all_adh[0]["SALAIRE"] - $plafond_secu;
										}

										// Récupération des informations de cotisation
										$arrco = $dom->getElementsByTagName('arrco')->item(0);
										$liste_taux_cotisation = $arrco->getElementsByTagName('taux_cotisation')->item(0);
										$liste_tranche_cotisation = $liste_taux_cotisation->getElementsByTagName('tranche');

										// Récupération des informations d'acquisition
										$arrco = $dom->getElementsByTagName('arrco')->item(0);
										$liste_taux_acquisition = $arrco->getElementsByTagName('taux_acquisition')->item(0);
										$liste_tranche_acquisition = $liste_taux_acquisition->getElementsByTagName('tranche');

										// Calcul de la tranche
										$tranche_plafond = round($tab_all_adh[0]["SALAIRE"]/$plafond_secu);

										//Récupération des taux de cotisation
										foreach($liste_tranche_cotisation as $tranche_cotisation)
										{
											if ($tranche_cotisation->getAttribute("type") == "1") {
												$taux_cotisation_tranche_1 = $tranche_cotisation->firstChild->nodeValue;
											}
											if ($tranche_cotisation->getAttribute("type") == "2") {
												$taux_cotisation_tranche_2 = $tranche_cotisation->firstChild->nodeValue;
											}

										}
										//Récupération des taux d'acquisition
										foreach($liste_tranche_acquisition as $tranche_acquisition)
										{
											if ($tranche_acquisition->getAttribute("type") == "1") {
												$taux_acquisition_tranche_1 = $tranche_acquisition->firstChild->nodeValue;
											}
											if ($tranche_acquisition->getAttribute("type") == "2") {
												$taux_acquisition_tranche_2 = $tranche_acquisition->firstChild->nodeValue;
											}

										}

										//Calcul des cotisations
										$cotisations_tranche_1 = $taux_cotisation_tranche_1/100*$part_salaire_ARRCO;
										$cotisations_tranche_2 = $taux_cotisation_tranche_2/100*$part_salaire_ARRCO;
										//Nombre de points
										$points_arrco_tranche_1 = $part_salaire_ARRCO_tranche_1*($taux_acquisition_tranche_1/100)/$salaire_reference_arrco;
										$points_arrco_tranche_2 = $part_salaire_ARRCO_tranche_2*($taux_acquisition_tranche_2/100)/$salaire_reference_arrco;
										$points_arrco = round($points_arrco_tranche_1 + $points_arrco_tranche_2,2);
										$points_agirc = 0;
									}else{
										////////////////////////////////////////////////////////////////////////////////////////////
										///////////////////////////////Cas d'un CADRE///////////////////////////////////////////////
										////////////////////////////////////////////////////////////////////////////////////////////
										if($tab_all_adh[0]["SALAIRE"]>$plafond_secu){
											///////////////Cadre ayant un salaire supérieur au plafond de la sécu///////////////////
											$part_salaire_ARRCO = $plafond_secu;
											$part_salaire_AGIRC = $tab_all_adh[0]["SALAIRE"]-$plafond_secu;
												
											//On répartie la part du salaire AGIRC sur les différente tranche
											if($tab_all_adh[0]["SALAIRE"] < $plafond_secu*4)
											{
												//Le salaire du cadre est inférieur à 4 fois le plafond de la sécu:
												//il ne cotise que dans la tranche b
												$part_salaire_AGIRC_tranche_b = $part_salaire_AGIRC;
												$part_salaire_AGIRC_tranche_c = 0;
											}else{
												//Le salaire du cadre est supérieur à 4 fois le plafond de la sécu:
												//il cotise dans la tranche b la partie de son salaire comprise entre 1 et 4 plafond de la sécu
												//il cotise dans la tranche c la partie de son salaire supérieure à 3 fois le plafond de la sécu
												$part_salaire_AGIRC_tranche_b = $plafond_secu*3;
												$part_salaire_AGIRC_tranche_c = $part_salaire_AGIRC - $plafond_secu*3;
											}
												
											/////////////ARRCO//////////////////////
											// Récupération des informations de cotisation
											$arrco = $dom->getElementsByTagName('arrco')->item(0);
											$liste_taux_cotisation = $arrco->getElementsByTagName('taux_cotisation')->item(0);
											$liste_tranche_cotisation = $liste_taux_cotisation->getElementsByTagName('tranche');

											// Récupération des informations d'acquisition
											$arrco = $dom->getElementsByTagName('arrco')->item(0);
											$liste_taux_acquisition = $arrco->getElementsByTagName('taux_acquisition')->item(0);
											$liste_tranche_acquisition = $liste_taux_acquisition->getElementsByTagName('tranche');

											//Le salaire de l'adhérent est dans la tranche 1
											//Récupération des taux de cotisation
											foreach($liste_tranche_cotisation as $tranche_cotisation)
											{
												if ($tranche_cotisation->getAttribute("type") == "1") {
													$taux_cotisation_tranche_1 = $tranche_cotisation->firstChild->nodeValue;
												}
											}
											//Récupération des taux d'acquisition
											foreach($liste_tranche_acquisition as $tranche_acquisition)
											{
												if ($tranche_acquisition->getAttribute("type") == "1") {
													$taux_acquisition_tranche_1 = $tranche_acquisition->firstChild->nodeValue;
												}
											}
											/////////////////////////////////////////////////////////////////////////////
											///////////////////AGIRC/////////////////////////////////////////////////////
											$agirc = $dom->getElementsByTagName('agirc')->item(0);
											$liste_taux_cotisation = $agirc->getElementsByTagName('taux_cotisation')->item(0);
											$liste_tranche_cotisation = $liste_taux_cotisation->getElementsByTagName('tranche');

											// Récupération des informations d'acquisition
											$agirc = $dom->getElementsByTagName('agirc')->item(0);
											$liste_taux_acquisition = $agirc->getElementsByTagName('taux_acquisition')->item(0);
											$liste_tranche_acquisition = $liste_taux_acquisition->getElementsByTagName('tranche');

											//Le salaire de l'adhérent est dans la tranche 1
											//Récupération des taux de cotisation
											foreach($liste_tranche_cotisation as $tranche_cotisation)
											{
												if ($tranche_cotisation->getAttribute("type") == "B") {
													$taux_cotisation_tranche_b = $tranche_cotisation->firstChild->nodeValue;
												}
												if ($tranche_cotisation->getAttribute("type") == "C") {
													$taux_cotisation_tranche_c = $tranche_cotisation->firstChild->nodeValue;
												}
											}
											//Récupération des taux d'acquisition
											foreach($liste_tranche_acquisition as $tranche_acquisition)
											{
												if ($tranche_acquisition->getAttribute("type") == "B") {
													$taux_acquisition_tranche_b = $tranche_acquisition->firstChild->nodeValue;
												}
												if ($tranche_acquisition->getAttribute("type") == "C") {
													$taux_acquisition_tranche_c = $tranche_acquisition->firstChild->nodeValue;
												}
											}
											/////////////////////////////////////////////////////////////////////////////

											//Calcul des cotisations
											$cotisations_tranche_1 = $taux_cotisation_tranche_1/100*$part_salaire_ARRCO;
											$cotisations_tranche_b = $taux_cotisation_tranche_b/100*$part_salaire_AGIRC_tranche_b;
											$cotisations_tranche_c = $taux_cotisation_tranche_c/100*$part_salaire_AGIRC_tranche_c;

											//Nombre de points ARCCO
											$points_arrco_tranche_1 = $part_salaire_ARRCO*($taux_acquisition_tranche_1/100)/$salaire_reference_arrco;
											$points_arrco = round($points_arrco_tranche_1,2);

											//Nombre de points AGIRC
											$points_agirc_tranche_b = $part_salaire_AGIRC_tranche_b*($taux_acquisition_tranche_b/100)/$salaire_reference_agirc;
											$points_agirc_tranche_c = $part_salaire_AGIRC_tranche_c*($taux_acquisition_tranche_c/100)/$salaire_reference_agirc;
											$points_agirc = round($points_agirc_tranche_b + $points_agirc_tranche_c,2);
										}else{
											///////////////Cadre ayant un salaire inférieur au plafond de la sécu///////////////////
											$part_salaire_ARRCO = $plafond_secu;
												
											/////////////ARRCO//////////////////////
											// Récupération des informations de cotisation
											$arrco = $dom->getElementsByTagName('arrco')->item(0);
											$liste_taux_cotisation = $arrco->getElementsByTagName('taux_cotisation')->item(0);
											$liste_tranche_cotisation = $liste_taux_cotisation->getElementsByTagName('tranche');

											// Récupération des informations d'acquisition
											$arrco = $dom->getElementsByTagName('arrco')->item(0);
											$liste_taux_acquisition = $arrco->getElementsByTagName('taux_acquisition')->item(0);
											$liste_tranche_acquisition = $liste_taux_acquisition->getElementsByTagName('tranche');

											//Le salaire de l'adhérent est dans la tranche 1
											//Récupération des taux de cotisation
											foreach($liste_tranche_cotisation as $tranche_cotisation)
											{
												if ($tranche_cotisation->getAttribute("type") == "1") {
													$taux_cotisation_tranche_1 = $tranche_cotisation->firstChild->nodeValue;
												}
											}
											//Récupération des taux d'acquisition
											foreach($liste_tranche_acquisition as $tranche_acquisition)
											{
												if ($tranche_acquisition->getAttribute("type") == "1") {
													$taux_acquisition_tranche_1 = $tranche_acquisition->firstChild->nodeValue;
												}
											}
											/////////////////////////////////////////////////////////////////////////////


											//Calcul des cotisations
											$cotisations_tranche_1 = $taux_cotisation_tranche_1/100*$part_salaire_ARRCO;

											//Nombre de points ARCCO
											$points_arrco_tranche_1 = $part_salaire_ARRCO*($taux_acquisition_tranche_1/100)/$salaire_reference_arrco;
											$points_arrco = round($points_arrco_tranche_1,2);

											//Nombre de points AGIRC
											$points_agirc = round(120,2);

										}
									}
			$date_debut = 1947+$i.'-01-01';
			$date_fin = 1947+$i.'-12-31';
			
			$periode->addPeriode($last+1, 1, $date_debut, $date_fin, "Mairie de Paris",$tab_all_adh[0]["SALAIRE"] , $points_arrco, $points_agirc);
			$tab_all_adh[0]["SALAIRE"]+=250.00;
			
		}
		/////////////////////////////////////////////////////////////////////////////////////////
