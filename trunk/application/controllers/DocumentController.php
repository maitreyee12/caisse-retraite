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
															$points_arrco = "0";
															$points_agirc = "0";
															$nb_points = $points_arrco+$points_agirc;
															////////////////////////////////////////////////////////////////////////////////////
															
															
															//finalement on ajoute la periode en base
															$id_periode = $model_periode->getDerniereId();
															$model_periode->addPeriode(($id_periode+1), $carriere->Id_carriere, $date_debut, $date_fin, $entreprise->Nom_entreprise, $tab_all_adh[$i]["SALAIRE"], $points_arrco, $points_agirc);
															//et on met à jour la carrière
															$model_Carriere->modifierCarriereEnFonctionDesPerdiodes($carriere->Id_carriere, (($carriere->Trimestre_cumul)+($nb_trimestres)), (($carriere->Points_cumul)+($nb_points)));
															
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
															$points_arrco = "0";
															$points_agirc = "0";
															$nb_points = $points_arrco+$points_agirc;
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
															$model_Carriere->addcarriere(($id_carriere+1), $id_utilisateur, $nb_trimestres, $nb_points);
															
															//on a besoin de nom de l'entreprise
															$entreprise = $model_Entreprise->getEntreprise($adherent->Id_entreprise);
															
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















