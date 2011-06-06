<?php

class PeriodeController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function afficherPeriodeAction()
    {
    	//On récupère l'id de l'utilisateur
        $id_carriere =  $this->_getParam("id",-1);
        
        if ($id_carriere != -1){
        	//On récupére les périodes
        	$periodes = new Application_Model_DbTable_Periode();
			$this->view->Periodes = $periodes->obtenirPeriodes($id_carriere);
        }
    }


}



