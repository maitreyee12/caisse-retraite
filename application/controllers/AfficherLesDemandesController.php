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
		//on r�cup�re l'id
		$id =  $this->_getParam("id");
		
		//puis on r�cup�re les infos de la demande_affiliation dans afficher_demande_affiliation
        $afficher_demande_affiliation = new Application_Model_DbTable_DemandeAffiliation();
		$this->view->afficher_demande_affiliation = $afficher_demande_affiliation->getDemande($id);
		
    }

    public function demandeInformationsAction()
    {
        //on r�cup�re l'id
		$id =  $this->_getParam("id");
		
        //on r�cup�re les infos de la demande dans afficher_demande
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
		//on r�cup�re l'id
		$id =  $this->_getParam("id");
		
        //on r�cup�re les infos de la demande dans afficher_demande
		$afficher_demande = new Application_Model_DbTable_Demande();
		$this->view->afficher_demande = $afficher_demande->getDemande($id);
    }

}