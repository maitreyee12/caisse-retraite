<?php

class NoteController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function ajouterNoteAction()
    {
		$id =  $this->_getParam("id");
		$prov =  $this->_getParam("prov");
		
		$model_Demande = new Application_Model_DbTable_Demande();
		$this->getDemande = $model_Demande->getDemande($id);
	
		if($this->getDemande->Etat == 2)
			{
				$this->render('note-verouille');
			}
		else
			{
				$form_Note = new Application_Form_Note();
				$this->view->form = $form_Note;
				if ($this->getRequest()->isPost()) 
					{
						$formData = $this->getRequest()->getPost();
						if ($form_Note->isValid($formData)) 
							{
								 
								$auth = Zend_Auth::getInstance();
								$id_utilisateur = $auth->getIdentity()->Id_utilisateur;
								$date_soumission = date("Y-m-d H:i:s");
								$note = $form_Note->getValue('Note');
							
								$model_Note = new Application_Model_DbTable_Note();
								$model_Note->ajouterDemande($id, $id_utilisateur, $date_soumission, $note);
								
								if(md5("demandeAffiliation") == $prov)
									{
										$this->_helper->redirector('demande-affiliation','AfficherLesDemandes', null, array('id' => ($id)));
									}
								else if(md5("demandeInformations") == $prov)
									{
										$this->_helper->redirector('demande-informations','AfficherLesDemandes', null, array('id' => ($id)));
									}
								else if(md5("demandeReversion") == $prov)
									{
										$this->_helper->redirector('demande-reversion','AfficherLesDemandes', null, array('id' => ($id)));
									}
									
							} 
						else 
							{
								$form_Note->populate($formData);
							}	
					}
			}
    }

    public function afficherNotesAction()
    {
		$id_demande =  $this->_getParam("id");
	
        $notes = new Application_Model_DbTable_Note();
		$this->view->afficherNote = $notes->afficherNote($id_demande);
		
		//on recupere la demande
		$model_demande = new Application_Model_DBtable_Demande();
		$demande = $model_demande->getDemande($id_demande);
		
		//si la demande est attribué à un utilisateur
		if($demande->Id_utilisateur != null)
			{
				//on regarde quel est l'utilisateur titulaire de la demande
				$model_utilisateur  = new Application_Model_DBtable_Utilisateur();
				$utilisateur = $model_utilisateur->getUtilisateurNotArray($demande->Id_utilisateur);
				//c'est un salarie
				if($utilisateur->Droits == 0)
					{
						$model_adherent = new Application_Model_DbTable_Adherent();
						$salarie = getAdherent($utilisateur->Id_utilisateur);
						
						$dest = $salarie->Nom." ".$salarie->Prenom;
						
						$this->view->Nom_destinataire = $dest;
						$this->view->Adresse_destinataire = $salarie->Adresse;
					}
				//c'est un retraité
				else if($utilisateur->Droits == 1)
					{
						$model_adherent = new Application_Model_DbTable_Adherent();
						$retraite = getAdherent($utilisateur->Id_utilisateur);
						
						$dest = $retraite->Nom." ".$salarie->Prenom;
						
						$this->view->Nom_destinataire = $dest;
						$this->view->Adresse_destinataire = $salarie->Adresse;
					}
				//c'est une entreprise
				else if($utilisateur->Droits == 2)
					{
						$model_entreprise = new Application_Model_DbTable_Entreprise();
						$entreprise = $model_entreprise->getEntreprise($utilisateur->Id_utilisateur);
						
						$this->view->Nom_destinataire = $entreprise->Nom_entreprise;
						$this->view->Adresse_destinataire = $entreprise->Adresse;
					}
			}
		//si elle n'est pas attribué à un utilisateur et que c'est une demande d'affiliation
		else if(($demande->Id_utilisateur == null) && ($demande->Type == "demande affiliation"))
			{
				//alors on cherche les infos dans la demande d'affiliation
				$model_affiliation = new Application_Model_DbTable_DemandeAffiliation();
				$affiliation = $model_affiliation->getDemande($demande->Id_demande);
			
				$this->view->Nom_destinataire = $affiliation->Nom;
				$this->view->Adresse_destinataire = $affiliation->Adresse;				
			}
		//si elle n'est pas attribué à un utilisateur et que c'est une demande de reversion
		else if(($demande->Id_utilisateur == null) && ($demande->Type == "demande reversion"))
			{
				//alors on cherche les infos dans la demande de reversion
				$model_reversion = new Application_Model_DbTable_DemandeReversion();
				$reversion = $model_reversion->getDemande($demande->Id_demande);
			
				$dest = $reversion->Nom_beneficiare." ".$reversion->Prenom_beneficiare;
			
				$this->view->Nom_destinataire = $dest;
				$this->view->Adresse_destinataire = $reversion->Adresse;
			}
    }

    public function noteVerouilleAction()
    {
        // action body
    }


}







