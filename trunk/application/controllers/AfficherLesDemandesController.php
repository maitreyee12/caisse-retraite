<?php

class AfficherLesDemandesController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function demandeAffiliationAction()
    {
		//on récupére l'id
		$id =  $this->_getParam("id");

		
		//puis on récupére les infos de la demande_affiliation dans afficher_demande_affiliation
        $afficher_demande_affiliation = new Application_Model_DbTable_DemandeAffiliation();
		$demande = $afficher_demande_affiliation->getDemande($id);
		$this->view->afficher_demande_affiliation = $afficher_demande_affiliation->getDemande($id);
		
		$model_entreprise = new Application_Model_DbTable_Entreprise();
		$this->view->entrepriseExiste = $model_entreprise->getEntrepriseByName($demande->Nom);
		
    }

    public function demandeInformationsAction()
    {
        //on récupére l'id
		$id =  $this->_getParam("id");
		
        //on récupére les infos de la demande dans afficher_demande
		$afficher_demande = new Application_Model_DbTable_Demande();
		$this->view->afficher_demande = $afficher_demande->getDemande($id);
    }

    public function demandeDepartRetraiteAction()
    {
        // action body
    }

    public function demandeRachatTrimestresAction()
    {
        // action body
    }

    public function demandeAction()
    {
		//on récupére l'id
		$id =  $this->_getParam("id");
		
        //on récupére les infos de la demande dans afficher_demande
		$afficher_demande = new Application_Model_DbTable_Demande();
		$this->view->afficher_demande = $afficher_demande->getDemande($id);
    }

    public function demandeReversionAction()
    {
        //on récupére l'id
		$id =  $this->_getParam("id");
		
		//on récupére les infos de la demande dans afficher_demande
		$afficher_demande_reversion = new Application_Model_DbTable_DemandeReversion();
		$this->view->afficher_demande_reversion = $afficher_demande_reversion->getDemande($id);
    }


}

