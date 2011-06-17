<?php

class AdherentController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function afficherAdherentMajAction()
    {
        $id_util = $this->_getParam("id_util");
		
		$model_Adherent = new Application_Model_DbTable_Adherent();
		$this->view->afficherAdherent = $model_Adherent->getAdherent($id_util);
    }

    public function afficherCarriereMajAction()
    {
        $id_util = $this->_getParam("id_util");
		
		$model_Carriere = new Application_Model_DbTable_Carriere();
		$this->view->afficherCarriere = $model_Carriere->getCarriere($id_util);
    }

    public function afficherPeriodeAddAction()
    {
        $id_periode = (int)$this->_getParam("id_periode");
		
		$model_periode = new Application_Model_DbTable_Periode();
		$this->view->afficherPeriode = $model_periode->getPeriode($id_periode);

    }

    public function afficherAdherentAddAction()
    {
        $id_util = $this->_getParam("id_util");
		
		$model_Adherent = new Application_Model_DbTable_Adherent();
		$this->view->afficherAdherent = $model_Adherent->getAdherent($id_util);
    }

    public function afficherCarriereAddAction()
    {
        $id_util = $this->_getParam("id_util");
		
		$model_Carriere = new Application_Model_DbTable_Carriere();
		$this->view->afficherCarriere = $model_Carriere->getCarriere($id_util);
    }

    public function afficherUtilisateurAddAction()
    {
        $id_util = (int)$this->_getParam("id_util");

		$model_utilisateur = new Application_Model_DbTable_Utilisateur();
		$this->view->afficherUtilisateur = $model_utilisateur->getUtilisateurNotArray($id_util);
    }


}













