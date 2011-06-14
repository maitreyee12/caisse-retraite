<?php

class EntrepriseController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function ajouterEntrepriseAction()
    {

		$Num_siret = $this->getRequest()->getParam('Num_siret');
		$Nom_entreprise = $this->getRequest()->getParam('Nom_entreprise');
		$Nombre_employes = $this->getRequest()->getParam('Nombre_employes');
		$Adresse = $this->getRequest()->getParam('Adresse');
		$Num_tel = $this->getRequest()->getParam('Num_tel');
		$E_mail = $this->getRequest()->getParam('E_mail');
		$Id_demande = $this->getRequest()->getParam('id');
		
		//on ajoute l'entreprise dans la base CRC
		//ajout dans la table Utilisateur
		$model_Utilisateur = new Application_Model_DbTable_Utilisateur();
		$id_utilisateur = $model_Utilisateur->getDerniereId();
		$model_Utilisateur->addUtilisateur(($id_utilisateur+1), $Nom_entreprise, 2);
		$id_utilisateur = $model_Utilisateur->getDerniereId();
													
		$model_Entreprise = new Application_Model_DbTable_Entreprise();
		$model_Entreprise->ajouterEntreprise($id_utilisateur, $Num_siret, $Nom_entreprise, $Adresse, $Num_tel, $E_mail, $Nombre_employes);
		
		//puis on modifie la demande pour qu'elle soit affecté à l'entreprise
		$model_Demande = new Application_Model_DbTable_Demande();
		$model_Demande->modifierDemande($id_utilisateur, $Id_demande);
		
		$this->view->id = $Id_demande;
		
		$request = clone $this->getRequest();
		$request->setActionName('afficher-entreprise')
				->setParams(array('id' => $id_utilisateur));
		$this->_helper->actionStack($request);
		
    }

    public function afficherEntrepriseAction()
    {
		$id = $this->getRequest()->getParam('id');
	  
		$model_Entreprise = new Application_Model_DbTable_Entreprise();
		$this->view->afficherEntreprise = $model_Entreprise->obtenirEntreprise($id);
    }
}





