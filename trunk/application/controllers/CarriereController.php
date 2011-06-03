<?php

class CarriereController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function afficherCarriereAction()
    {
        $id_utilisateur = $this->_getParam('id');
        
        $carriere = new Application_Model_DbTable_Carriere();
        $this->view->carriere = $carriere->getCarriere($id_utilisateur);
    }


}







