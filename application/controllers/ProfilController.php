<?php

class ProfilController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    	// Chargmenent du formulaire profil Adherent
		$form = new Application_Form_ProfilAdherent();
		$this->view->form = $form;
		
		//Récupération des droits de l'utilisateur
		$droits = Zend_Auth::getInstance ()->getIdentity()->Droits;
		
		//Si le formulaire est validé en post
		if ($this->getRequest()->isPost()) {
			
			//Récupération des valeurs POST
			$formData = $this->getRequest()->getPost();
			
			//Si les valeurs sont valides
			if ($form->isValid($formData)) {
				
				//Cas d'un Adhérent
				if($droits == 1){
					$id = $form->getValue('Id_utilisateur');
					$nom = $form->getValue('nom');
					$prenom = $form->getValue('prenom');
					$num_SS = $form->getValue('numSS');
					$telephone = $form->getValue('telephone');
					$adresse = $form->getValue('adresse');
					$e_mail = $form->getValue('e_mail');

					//Mise à jour des données de l'Adhérent
					$albums = new Application_Model_DbTable_Albums();
					$albums->modifierAlbum($id, $artiste, $titre);
				
					$this->_helper->redirector('index');
				}
				
				
			} else {
				$form->populate($formData);
			}
		} else {
			$id = $this->_getParam('id', -1);
			if ($id > -1) {
				
				
				//Affichage du formulaire correspondant au type d'utilisateur
				if($droits == 0){
					//Si l'utilisateur est un adhérent
					$form = new Application_Form_ProfilAdherent();
					$this->view->form = $form;
					$adhérent = new  Application_Model_DbTable_Adherent();
					$form->populate($adhérent->obtenirAdherent($id));
				}elseif($droits == 2){
					//Si l'utilisateur est une entreprise
					$form = new Application_Form_ProfilEntreprise();
					$this->view->form = $form;
					$entreprise = new  Application_Model_DbTable_Entreprise();
					$form->populate($entreprise->obtenirEntreprise($id));
				}elseif($droits == 3){
					//Si l'utilisateur est une Employé caisse
					/*$form = new Application_Form_ProfilEntreprise();
					$this->view->form = $form;
					$entreprise = new  Application_Model_DbTable_Entreprise();
					$form->populate($entreprise->obtenirEntreprise($id));*/
				}elseif($droits == 4){
					//Si l'utilisateur est une autre Caisse
					/*$form = new Application_Form_ProfilEntreprise();
					$this->view->form = $form;
					$entreprise = new  Application_Model_DbTable_Entreprise();
					$form->populate($entreprise->obtenirEntreprise($id));*/
				}elseif($droits == 5){
					//Si l'utilisateur est une CNAV
					/*$form = new Application_Form_ProfilEntreprise();
					$this->view->form = $form;
					$entreprise = new  Application_Model_DbTable_Entreprise();
					$form->populate($entreprise->obtenirEntreprise($id));*/
				}
			}
		}
    }


}

