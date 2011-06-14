﻿<?php

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
		$this->view->form = $form_dads;
		if ($this->getRequest()->isPost()) 
			{
				$formData = $this->getRequest()->getPost();
				if ($form_dads->isValid($formData)) 
					{
						$id_demande =  $this->_getParam("id");
						$id_doc = $form_dads->getValue('Id_doc');
						$id_ent = $form_dads->getValue('Id_ent');
						
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
													else if($ligne[$occurence] == "SALARIE")
														{
															$tab_adh["SALARIE"] = $ligne[$occurence+1];
														}
													else if($ligne[$occurence] == "NOMBRE TRIMESTRES")
														{
															$tab_adh["NB_TRIMESTRES"] = $ligne[$occurence+1];
														}
												}
												$row ++;
											}
											array_push($tab_all_adh, $tab_adh);
											fclose($handle);
											
											for($i = 0; $i < sizeof($tab_all_adh); $i++)
												{
													//ajout dans la table Utilisateur
													$model_Utilisateur = new Application_Model_DbTable_Utilisateur();
													$id_utilisateur = $model_Utilisateur->getDerniereId();
													$model_Utilisateur->addUtilisateur(($id_utilisateur+1), $tab_all_adh[$i]["NOM"], 0);
													$id_utilisateur = $model_Utilisateur->getDerniereId();
													
													array_push($tab_utilisateur_add, $id_utilisateur);
													
													//on cherche la dernière id de carrière
													$model_Carriere = new Application_Model_DbTable_Carriere();
													$id_carriere = $model_Carriere->getDerniereId();
													
													//ajout dans la table Adherent
													$model_Adherent = new Application_Model_DbTable_Adherent();
													$model_Adherent->addAdherent($id_utilisateur, ($id_carriere+1), $tab_all_adh[$i]["NOM"], $tab_all_adh[$i]["PRENOM"], $tab_all_adh[$i]["NUM_SS"], "0".$tab_all_adh[$i]["TELEPHONE"], $tab_all_adh[$i]["EMAIL"], $tab_all_adh[$i]["ADRESSE"]);
													
													//ajout dans la table salaire
													$model_Salarie = new Application_Model_DbTable_Salarie();
													$model_Salarie->addSalarie($id_utilisateur, $id_ent, $tab_all_adh[$i]["SALARIE"], $tab_all_adh[$i]["NB_TRIMESTRES"]);
													
													//ajout de la carriere
													$model_Carriere->addcarriere(($id_carriere+1), $id_utilisateur, null, null);
													
												}
	
											for($i = 0; $i < sizeof($tab_utilisateur_add); $i++)
												{			
													$request = clone $this->getRequest();
													$request->setActionName('afficher-dads')
															->setParams(array('id' => $tab_utilisateur_add[$i]));
													$this->_helper->actionStack($request);
												}
											
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
		$id = $this->getRequest()->getParam('id');
	  
		$model_Adherent = new Application_Model_DbTable_Adherent();
		$this->view->afficherAdherent = $model_Adherent->obtenirAdherent($id);
    }

    public function dadsAccepteAction()
    {
        // action body
    }


}















