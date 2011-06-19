<?php

class DocumentController extends Zend_Controller_Action
{

	public $tab_all_adh = null;

	public function init()
	{
		$this->_redirector = $this->_helper->getHelper('Redirector');
	}

	public function indexAction()
	{
		// action body
	}

	public function afficherDocumentsAction()
	{
		$id_demande =  $this->_getParam("id");

		$documents = new Application_Model_DbTable_Documents();
		$this->view->listeDocuments = $documents->afficherDocumentsParDemande($id_demande);
	}

	public function ajouterDocumentAction()
	{
		$id =  $this->_getParam("id");
		$prov =  $this->_getParam("prov");

		$model_Demande = new Application_Model_DbTable_Demande();
		$this->getDemande = $model_Demande->getDemande($id);

		if($this->getDemande->Etat == 2)
		{
			$this->render('document-verouille');
		}
		else
		{

			$form_Demande = new Application_Form_Document();
			$this->view->form = $form_Demande;
			if ($this->getRequest()->isPost())
			{
				$formData = $this->getRequest()->getPost();
				if ($form_Demande->isValid($formData))
				{
						
					$id_demande =  $this->_getParam("id");
					$description = $form_Demande->getValue('Description');

					/* Uploading Document File on Server */
					$upload = new Zend_File_Transfer_Adapter_Http();
					$upload->setDestination("C:\wamp\www\caisse-retraite\uploads\\");
					try
					{
						$upload->receive();
					}
					catch (Zend_File_Transfer_Exception $e)
					{
						$e->getMessage();
					}

					$lien = $upload->getFileName('Doc');
					$id_courrier = $form_Demande->getValue('Id_courrier');
						

					//redirection  en fonction de la provenance
					$model_Document = new Application_Model_DbTable_Documents();
					$model_Document->ajouterDocument($id_courrier, $id_demande, $description, $lien);

					if(md5("Application_Form_DemandeReversion") == $prov)
					{
						$this->_helper->redirector('accepte','Demande', null, array());
					}
					else if(md5("demandeAffiliation") == $prov)
					{
						$this->_helper->redirector('demande-affiliation','AfficherLesDemandes', null, array('id' => ($id_demande)));
					}
					else if(md5("demandeInformations") == $prov)
					{
						$this->_helper->redirector('demande-informations','AfficherLesDemandes', null, array('id' => ($id_demande)));
					}
					else if(md5("demandeReversion") == $prov)
					{
						$this->_helper->redirector('demande-reversion','AfficherLesDemandes', null, array('id' => ($id_demande)));
					}

				}
				else
				{
					// this line will be called if data was not submited
					$form_Demande->populate($formData);
				}
			}
		}
	}

	public function documentVerouilleAction()
	{
		// action body
	}

	public function traiterDadsAction()
	{
		$form_dads = new Application_Form_TraiterDads();

		$id_demande =  $this->_getParam("id");
		$id_ent =  $this->_getParam("id_ent");

		$formData['Id_ent'] = $id_ent;
		$form_dads->populate($formData);

		$this->view->form = $form_dads;
		if ($this->getRequest()->isPost())
		{
			$formData = $this->getRequest()->getPost();
			if ($form_dads->isValid($formData))
			{
				$id_doc = $form_dads->getValue('Id_doc');

				$model_Document = new Application_Model_DbTable_Documents();
				if($document = $model_Document->getDdocument($id_doc))
				{
					$model_Entreprise = new Application_Model_DbTable_Entreprise();
					if($entreprise = $model_Entreprise->getEntreprise($id_ent))
					{
						$tab_adh = array();
						$tab_all_adh = array();
						$tab_utilisateur_add = array();
						$row = 0;

						if (($handle = fopen($_SERVER['DOCUMENT_ROOT'].$document->Lien, "r")) !== FALSE)
						{
							while (($ligne = fgetcsv($handle, 1000, ";")) !== FALSE) {
								for ($occurence=0; $occurence < count($ligne); $occurence++) {
									if(($ligne[$occurence] == "[NOUVEAU PROFIL]") && $row != 0)
									{
										array_push($tab_all_adh, $tab_adh);
										$tab_adh = array();
									}
									else if($ligne[$occurence] == "NOM")
									{
										$tab_adh["NOM"] = $ligne[$occurence+1];
									}
									else if($ligne[$occurence] == "PRENOM")
									{
										$tab_adh["PRENOM"] = $ligne[$occurence+1];
									}
									else if($ligne[$occurence] == "DATE NAISSANCE")
									{
										$tab_adh["DATE_NAISSANCE"] = $ligne[$occurence+1];
									}
									else if($ligne[$occurence] == "NUMERO SECURITE SOCIALE")
									{
										$tab_adh["NUM_SS"] = $ligne[$occurence+1];
									}
									else if($ligne[$occurence] == "TELEPHONE")
									{
										$tab_adh["TELEPHONE"] = $ligne[$occurence+1];
									}
									else if($ligne[$occurence] == "EMAIL")
									{
										$tab_adh["EMAIL"] = $ligne[$occurence+1];
									}
									else if($ligne[$occurence] == "ADRESSE")
									{
										$tab_adh["ADRESSE"] = $ligne[$occurence+1];
									}
									else if($ligne[$occurence] == "SALAIRE")
									{
										$tab_adh["SALAIRE"] = $ligne[$occurence+1];
									}
									else if($ligne[$occurence] == "DATE DEBUT")
									{
										$tab_adh["DATE_DEBUT"] = $ligne[$occurence+1];
									}
									else if($ligne[$occurence] == "DATE FIN")
									{
										$tab_adh["DATE_FIN"] = $ligne[$occurence+1];
									}
									else if($ligne[$occurence] == "CADRE")
									{
										$tab_adh["TYPE_CADRE"] = $ligne[$occurence+1];
									}
									else if($ligne[$occurence] == "SALARIE")
									{
										$tab_adh["TYPE_SALARIE"] = $ligne[$occurence+1];
									}
								}
								$row ++;
							}
							array_push($tab_all_adh, $tab_adh);
							fclose($handle);
								
							for($i = 0; $i < sizeof($tab_all_adh); $i++)
							{
								//on regarde si l'utilisateur existe deja
								$model_Utilisateur = new Application_Model_DbTable_Utilisateur();
								$utilisateur = $model_Utilisateur->getUtilisateurByName($tab_all_adh[$i]["NOM"]);
									
								//on definit tout de suite le type
								if($tab_all_adh[$i]["TYPE_CADRE"] == "oui")
								{
									$type = "cadre";
								}
								else
								{
									$type = "salarie";
								}
									
								//existe
								if(isset($utilisateur->Id_utilisateur))
								{
									//instanciation des modeles
									$model_periode = new Application_Model_DbTable_Periode();
									$model_Carriere = new Application_Model_DbTable_Carriere();
									$model_Adherent = new Application_Model_DbTable_Adherent();
									$model_Entreprise = new Application_Model_DbTable_Entreprise();
										
									//compare le debut et la fin de la periode
									//ajoute le bon nombre de trimestres
									$date_debut = explode("-", $tab_all_adh[$i]["DATE_DEBUT"]);
									$date_fin = explode("-", $tab_all_adh[$i]["DATE_FIN"]);
									$nb_mois = $date_fin[1]-$date_debut[1];
									$nb_trimestres = ($nb_mois+1)/3;
									$nb_trimestres = (int)$nb_trimestres;
										
									//on reformate les dates sinon elles ne passent pas...
									$date_debut = $date_debut[0]."-".$date_debut[1]."-".$date_debut[2];
									$date_fin = $date_fin[0]."-".$date_fin[1]."-".$date_fin[2];

									//pour ajouter en base
									//on a besoin de son num de carriere
									$carriere = $model_Carriere->getCarriere($utilisateur->Id_utilisateur);
									//on a besoin de l'adherent
									$adherent = $model_Adherent->getAdherent($utilisateur->Id_utilisateur);
									//on a besoin de nom de l'entreprise
									$entreprise = $model_Entreprise->getEntreprise($adherent->Id_entreprise);
										
										
									////////////////////////////////////////////////////////////////////////////////////
									//ICI ON DEVRA CALCULE LES POINTS POUR LA PERIODE C LES DEUX DERNIERS ARGUMENTS DE LA FONCTION addPeriode()
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
											$points_agirc_tranche_c = $part_salaire_AGIRC_tranche_c*($taux_acquisition_tranche_c/100)/$salaire_reference_agirc;;
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
									////////////////////////////////////////////////////////////////////////////////////
										
										
									//finalement on ajoute la periode en base
									$id_periode = $model_periode->getDerniereId();
									$model_periode->addPeriode(($id_periode+1), $carriere->Id_carriere, $date_debut, $date_fin, $entreprise->Nom_entreprise, $tab_all_adh[$i]["SALAIRE"], $points_arrco, $points_agirc);
									//et on met à jour la carrière
									$model_Carriere->modifierCarriereEnFonctionDesPerdiodes($carriere->Id_carriere, (($carriere->Trimestre_cumul)+($nb_trimestres)), (($carriere->Points_ARRCO_cumul)+($points_arrco)), (($carriere->Points_AGIRC_cumul)+($points_agirc)));
										
									//stack des vues pour l'affichage
										
										
									//periode
									$request = clone $this->getRequest();
									$request->setActionName('afficher-periode-add')
									->setControllerName('Adherent')
									->setParams(array('id_periode' => ($id_periode+1)));
									$this->_helper->actionStack($request);
										
									//carriere
									$request = clone $this->getRequest();
									$request->setActionName('afficher-carriere-maj')
									->setControllerName('Adherent')
									->setParams(array('id_util' => $utilisateur->Id_utilisateur));
									$this->_helper->actionStack($request);

									//adhérent
									$request = clone $this->getRequest();
									$request->setActionName('afficher-adherent-maj')
									->setControllerName('Adherent')
									->setParams(array('id_util' => $utilisateur->Id_utilisateur));
									$this->_helper->actionStack($request);
										
									//Separation
									$request = clone $this->getRequest();
									$request->setActionName('afficher-dads')
									->setParams(array('nom' => $adherent->Nom, 'prenom' => $adherent->Prenom));
									$this->_helper->actionStack($request);

								}
								//existe pas
								else
								{
									//instanciation des modeles
									$model_periode = new Application_Model_DbTable_Periode();
									$model_Carriere = new Application_Model_DbTable_Carriere();
									$model_Adherent = new Application_Model_DbTable_Adherent();
									$model_Entreprise = new Application_Model_DbTable_Entreprise();
										
										
									//compare le debut et la fin de la periode
									//ajoute le bon nombre de trimestres
									$date_debut = explode("-", $tab_all_adh[$i]["DATE_DEBUT"]);
									$date_fin = explode("-", $tab_all_adh[$i]["DATE_FIN"]);
									$nb_mois = $date_fin[1]-$date_debut[1];
									$nb_trimestres = ($nb_mois+1)/3;
									$nb_trimestres = (int)$nb_trimestres;
										
									//on reformate les dates sinon elles ne passent pas...
									$date_debut = $date_debut[0]."-".$date_debut[1]."-".$date_debut[2];
									$date_fin = $date_fin[0]."-".$date_fin[1]."-".$date_fin[2];
										
									////////////////////////////////////////////////////////////////////////////////////
									//ICI ON DEVRA CALCULE LES POINTS POUR LA PERIODE C LES DEUX DERNIERS ARGUMENTS DE LA FONCTION addPeriode()
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
											$points_agirc_tranche_c = $part_salaire_AGIRC_tranche_c*($taux_acquisition_tranche_c/100)/$salaire_reference_agirc;;
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
									////////////////////////////////////////////////////////////////////////////////////
										
									//creation de l'utilisateur
									$id_utilisateur = $model_Utilisateur->getDerniereId();
									$model_Utilisateur->addUtilisateur(($id_utilisateur+1), $tab_all_adh[$i]["NOM"], 0);
									$id_utilisateur = $model_Utilisateur->getDerniereId();
										
									//on cherche la dernière id de carrière
									$id_carriere = $model_Carriere->getDerniereId();
										
									$date_naissance = explode("-", $tab_all_adh[$i]["DATE_NAISSANCE"]);
									$date_naissance = $date_naissance[0]."-".$date_naissance[1]."-".$date_naissance[2];
										
									//ajout dans la table Adherent
									$model_Adherent = new Application_Model_DbTable_Adherent();
									$model_Adherent->addAdherent($id_utilisateur, ($id_carriere+1),$id_ent, $tab_all_adh[$i]["NOM"], $tab_all_adh[$i]["PRENOM"], $date_naissance, $tab_all_adh[$i]["NUM_SS"], $tab_all_adh[$i]["TELEPHONE"], $tab_all_adh[$i]["EMAIL"], $tab_all_adh[$i]["ADRESSE"]);

									//ajout de la carriere
									$model_Carriere->addcarriere(($id_carriere+1), $id_utilisateur, $nb_trimestres, $points_arrco, $points_agirc);
										
									//on a besoin de nom de l'entreprise
									$entreprise = $model_Entreprise->getEntreprise($id_ent);
										
									//finalement on ajoute la periode en base
									$id_periode = $model_periode->getDerniereId();
									$model_periode->addPeriode(($id_periode+1), ($id_carriere+1), $date_debut, $date_fin, $entreprise->Nom_entreprise, $tab_all_adh[$i]["SALAIRE"], $points_arrco, $points_agirc);
										
									$adherent = $model_Adherent->getAdherent($id_utilisateur);
										
									//periode
									$request = clone $this->getRequest();
									$request->setActionName('afficher-periode-add')
									->setControllerName('Adherent')
									->setParams(array('id_periode' => ($id_periode+1)));
									$this->_helper->actionStack($request);
										
									//carriere
									$request = clone $this->getRequest();
									$request->setActionName('afficher-carriere-add')
									->setControllerName('Adherent')
									->setParams(array('id_util' => $id_utilisateur));
									$this->_helper->actionStack($request);

									//adhérent
									$request = clone $this->getRequest();
									$request->setActionName('afficher-adherent-add')
									->setControllerName('Adherent')
									->setParams(array('id_util' => $id_utilisateur));
									$this->_helper->actionStack($request);

									//utilisateur
									$request = clone $this->getRequest();
									$request->setActionName('afficher-utilisateur-add')
									->setControllerName('Adherent')
									->setParams(array('id_util' => $id_utilisateur));
									$this->_helper->actionStack($request);
										
									//Separation
									$request = clone $this->getRequest();
									$request->setActionName('afficher-dads')
									->setParams(array('nom' => $adherent->Nom, 'prenom' => $adherent->Prenom));
									$this->_helper->actionStack($request);
								}
							}
							//retour
							$request = clone $this->getRequest();
							$request->setActionName('dads-accepte');
							$this->_helper->actionStack($request);
						}
					}
					else
					{
						echo "<b>ID de l'entreprise introuvable, vous devez modifier la valeur saisie.</b>";
						$form_dads->populate($formData);
					}
				}
				else
				{
					echo "<b>ID du document introuvable, vous devez modifier la valeur saisie.</b>";
					$form_dads->populate($formData);
				}
			}
			else
			{
				// this line will be called if data was not submited
				$form_dads->populate($formData);
			}
		}
	}

	public function afficherDadsAction()
	{
		$this->view->adherentnom = $this->getRequest()->getParam('nom');
		$this->view->adherentprenom = $this->getRequest()->getParam('prenom');
	}

	public function dadsAccepteAction()
	{
		// action body
	}


}















