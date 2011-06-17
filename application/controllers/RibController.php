<?php

class RibController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function afficherRibAction()
    {
    	$Id_utilisateur = $this->_getParam('id',-1);
        $this->view->Id_utilisateur = $Id_utilisateur;
        if($Id_utilisateur != -1){
        	$rib = new Application_Model_DbTable_Rib();
        	$liste_ribs = $rib->obtenirListeRib($Id_utilisateur);
        	$this->view->liste_ribs = $liste_ribs;
        }
    }

    public function editerRibAction()
    {
    	//Si le formulaire est validé en post
		if ($this->getRequest()->isPost()) {
			
			$form = new Application_Form_Rib();
			$this->view->form = $form;
							
			//Récupération des valeurs POST
			$formData = $this->getRequest()->getPost();
			
			//	Si les valeurs sont valides
			if ($form->isValid($formData)) 
			{
				$id_rib = $form->getValue('Id_RIB');
				$id_utilisateur = $form->getValue('Id_utilisateur');
				$Num_compte = $form->getValue('Num_compte');
				$ID_banque = $form->getValue('ID_banque');
				$Num_guichet = $form->getValue('Num_guichet');
				$Nom_banque = $form->getValue('Nom_banque');
				$Nom_titulaire = $form->getValue('Nom_titulaire');
				
				//Mise à jour des données rib
				if($id_rib != ""){
					$rib = new Application_Model_DbTable_Rib();
					$rib->modifierRib($id_rib, $id_utilisateur, $Num_compte, $ID_banque, $Num_guichet, $Nom_banque, $Nom_titulaire, date('Y-m-d'));
				}else{
					$rib = new Application_Model_DbTable_Rib();
					$rib->creerRib($id_utilisateur, $Num_compte, $ID_banque, $Num_guichet, $Nom_banque, $Nom_titulaire, date('Y-m-d'));
				}
				$this->_helper->redirector('accepte','profil',null,array('id' => $id_utilisateur));
			}
			else {
				$form->populate($formData);
			}
		} else {
			$id_rib = $this->_getParam('id_rib', -1);
			$id_utilisateur = $this->_getParam('id_utilisateur', -1);
			if ($id_rib > -1) {
				$form = new Application_Form_Rib();
				$rib = new  Application_Model_DbTable_Rib();
				$form->populate($rib->obtenirRib($id_rib));
				$this->view->form = $form;
			}else if($id_utilisateur > -1){
				$form = new Application_Form_Rib();
				$formData['Id_utilisateur'] = $id_utilisateur;
				$form->populate($formData);
				$this->view->form = $form;
			}
		}				
    }


}





