<?php

class DemandeController extends Zend_Controller_Action
{

    public function init()
    {
          $this->_redirector = $this->_helper->getHelper('Redirector');
    }

    public function indexAction()
    {
        // action body
    }

    public function departRetraiteAction()
    {
        // action body
    }

    public function affiliationAction()
    {

		$form_DemandeAffiliation = new Application_Form_DemandeAffiliation();
		$this->view->form = $form_DemandeAffiliation;
		if ($this->getRequest()->isPost()) 
			{
				$formData = $this->getRequest()->getPost();
				if ($form_DemandeAffiliation->isValid($formData)) 
					{
								
						$nom = $form_DemandeAffiliation->getValue('Nom');
						$num_siret  = $form_DemandeAffiliation->getValue('Num_siret');
						$e_mail = $form_DemandeAffiliation->getValue('E_mail');
						$password = $form_DemandeAffiliation->getValue('Password');
						$adresse = $form_DemandeAffiliation->getValue('Adresse');
						$telephone = $form_DemandeAffiliation->getValue('Telephone');
						$nombre_employes = $form_DemandeAffiliation->getValue('Nombre_employes');
						$commentaires = $form_DemandeAffiliation->getValue('Commentaires');
						
						
						
						$auth = Zend_Auth::getInstance();
						if($auth->getIdentity())
							{
								$id_courrier = $form_DemandeAffiliation->getValue('Id_courrier');
								$id_utilisateur = $auth->getIdentity()->Id_utilisateur;
							}
							
						$date_demande = date("Y-m-d H:i:s");
						$etat = 0;
						$type = "demande affiliation";
						
						$model_Demande = new Application_Model_DbTable_Demande();
						$model_Demande->ajouterDemande($id_courrier, $id_utilisateur, $commentaires, $date_demande, $etat, $type);
						
						$appli_model_db_demande = new Application_Model_DbTable_Demande();
						$id_demande = $appli_model_db_demande->getDerniereId();				
						
						$model_DemandeAffiliation = new Application_Model_DbTable_DemandeAffiliation();
						$model_DemandeAffiliation->ajouterDemande($id_demande, $nom, $num_siret, $e_mail, $password, $adresse, $telephone, $nombre_employes);
						$this->_helper->redirector('accepte');
					} 
				else 
					{
						$form_DemandeAffiliation->populate($formData);
					}
			}
    }

    public function modificationDossierAction()
    {
        // action body
    }

    public function reversionAction()
    {
        $form_Demandereversion = new Application_Form_DemandeReversion();
		$this->view->form = $form_Demandereversion;
		if ($this->getRequest()->isPost()) 
			{
				$formData = $this->getRequest()->getPost();
				if ($form_Demandereversion->isValid($formData)) 
					{
						$auth = Zend_Auth::getInstance();
						
						$nom_dcd = $form_Demandereversion->getValue('Nom_dcd');
						$prenom_dcd = $form_Demandereversion->getValue('Prenom_dcd');
						$num_ss_dcd = $form_Demandereversion->getValue('Num_ss_dcd');
						$nom_benef = $form_Demandereversion->getValue('Nom_benef');
						$prenom_benef = $form_Demandereversion->getValue('Prenom_benef');
						$num_ss_benef = $form_Demandereversion->getValue('Num_ss_benef');
						$lien_parente = $form_Demandereversion->getValue('Lien_parente');
						$adresse  = $form_Demandereversion->getValue('Adresse');
						$telephone = $form_Demandereversion->getValue('Telephone');
						$e_mail = $form_Demandereversion->getValue('E_mail');
						$commentaires = $form_Demandereversion->getValue('Commentaires');
						

						$droit_user = Zend_Auth::getInstance ()->getIdentity()->Droits;
						if($droit_user == 3)
							{
								$id_courrier = $form_Demandereversion->getValue('Id_courrier');
								$id_utilisateur = $auth->getIdentity()->Id_utilisateur;
							}
							
						$date_demande = date("Y-m-d H:i:s");
						$etat = 0;
						$type = "demande reversion";
						
						$model_Demande = new Application_Model_DbTable_Demande();
						$model_Demande->ajouterDemande($id_courrier, $id_utilisateur, $commentaires, $date_demande, $etat, $type);
						
						$id_demande = $model_Demande->getDerniereId();				
						
						$model_DemandeReversion = new Application_Model_DbTable_DemandeReversion();
						$model_DemandeReversion->ajouterDemande($id_demande, $nom_dcd, $prenom_dcd, $num_ss_dcd, $nom_benef, $prenom_benef, $num_ss_benef, $lien_parente, $adresse,  $telephone, $e_mail);
						
						//on encode la provenance
						$redirect = md5("Application_Form_DemandeReversion");
						
						//on l'ajoute à l'url pour la vue ajouter-document du controlleur document
						$url = '/document/ajouter-document/id/'.$id_demande."/prov/".$redirect;
						$this->_redirector->gotoUrl($url); 
						
					} 
				else 
					{
						$form_Demandereversion->populate($formData);
					}
			}
    }

    public function rachatTrimestresAction()
    {
        $form = new Application_Form_DemanderachatTrimestres();

		$this->view->form = $form;
    }

    public function informationsAction()
    {
		$form_DemandeInformations = new Application_Form_DemandeInformations();
		$this->view->form = $form_DemandeInformations;
		if ($this->getRequest()->isPost())
			{
				$formData = $this->getRequest()->getPost();
				if ($form_DemandeInformations->isValid($formData))
					{
						$auth = Zend_Auth::getInstance();
						$commentaires = $form_DemandeInformations->getValue('Commentaires');
						$id_utilisateur = $auth->getIdentity()->Id_utilisateur;
						$date_demande = date("Y-m-d H:i:s");
						$etat = 0;
						$type = "demande informations";
						
						if($auth->getIdentity()->Droits == 3)
							{
								$id_courrier = $form_DemandeInformations->getValue('Id_courrier');
							}
						
						$model_Demande = new Application_Model_DbTable_Demande();
						$model_Demande->ajouterDemande($id_courrier, $id_utilisateur, $commentaires, $date_demande, $etat, $type);
	
						$this->_helper->redirector('accepte');
					} 
				else 
					{
						$form_DemandeInformations->populate($formData);
					}
			}
    }

    public function accepteAction()
    {
        // action body
    }

    public function modifierEtatDemandeAction()
    {
		//recupération de l'id dans l'url
		$id_demande =  $this->_getParam("id");
		$prov =  $this->_getParam("prov");
		
		//on affiche le formulaire de modification d'état de la demande
		$form_modifierEtatDemande = new Application_Form_DemandeModifierEtat();
		$this->view->form = $form_modifierEtatDemande;
		
		//on va chercher l'état de la demande en cours
		$get_etat_demande = new Application_Model_DbTable_Demande();
		$etat_demande = $get_etat_demande->getDemande($id_demande);
		//puis en fonction de son etat on definit quelle est la selection par defaut dans la liste
		$data = array(
								'Etat' => $etat_demande->Etat
						); 
		//on pousse dans le formulaire
		$form_modifierEtatDemande->populate($data);
						
		//si on reçoit une requete de type post
		if ($this->getRequest()->isPost())
			{
				//si le formulaire respecte tout les filtres
				$formData = $this->getRequest()->getPost();
				if ($form_modifierEtatDemande->isValid($formData))
					{
						//on récupère le ou les arguments
						$etat = $form_modifierEtatDemande->getValue('Etat');
						
						//on met a jour en base
						$model_Demande = new Application_Model_DbTable_Demande();
						$model_Demande->modifierEtatDemande($id_demande, $etat);
						
						
					} 
				else 
					{
						$form_modifierEtatDemande->populate($formData);
					}
			}
    }

    public function getDemandeAction()
    {
        // action body
    }


}



















