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
        $id_utilisateur =  $this->_getParam("id");
        
        //On récupère la carrière du salarié
        $carriere = new Application_Model_DbTable_Carriere();
        $id_carriere = $carriere->getCarriere($id_utilisateur)->Id_carriere;
	
        //On récupére les périodes
        $periodes = new Application_Model_DbTable_Periode();
		$this->view->Periodes = $periodes->obtenirPeriodes($id_carriere);
		
    }


}



