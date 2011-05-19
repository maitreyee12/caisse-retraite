<?php

class ProfilController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    	// Chargmenent du profil
		$form = new Application_Form_Profil();
		$this->view->form = $form;
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();
			if ($form->isValid($formData)) {
				$id = $form->getValue('id');
				$nom = $form->getValue('nom');
				$prenom = $form->getValue('prenom');
				$num_SS = $form->getValue('num_SS');
				$telephone = $form->getValue('telephone');
				$adresse = $form->getValue('adresse');
				$e_mail = $form->getValue('e_mail');
									
				$this->_helper->redirector('index');
			} else {
				$form->populate($formData);
			}
		} 
    }


}

