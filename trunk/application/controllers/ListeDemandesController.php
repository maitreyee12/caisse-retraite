﻿<?php

class ListeDemandesController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    	//on récupère l'id s'il y en a un
		$id = $this->_getParam("id");
		$this->view->id_demandeur = $id;
		
        $demandes = new Application_Model_DbTable_Demande();
		$this->view->demandes = $demandes->fetchAll();
    }

    public function ficheReversionAction()
    {
        // action body
    }

    public function ficheRachatTrimestresAction()
    {
        // action body
    }

    public function ficheDepartRetraiteAction()
    {
        // action body
    }

    public function ficheInformationsAction()
    {
        // action body
    }

    public function ficheDemandeModificationAction()
    {
        // action body
    }


}











