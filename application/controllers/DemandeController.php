<?php

class DemandeController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function departRetraiteAction()
    {
        // action body
    }

    public function affiliationAction()
    {
		$form = new Application_Form_DemandeAffiliation();
		$form->envoyer->setLabel('Envoyer la demande');
		$this->view->form = $form;
		if ($this->getRequest()->isPost()) 
			{
				$formData = $this->getRequest()->getPost();
				if ($form->isValid($formData)) 
					{
						$identifiant = $form->getValue('Identifiant');
						$num_siret  = $form->getValue('Num_siret ');
						$e_mail = $form->getValue('E_mail');
						$password = $form->getValue('Password');
						$adresse = $form->getValue('Adresse');
						$telephone = $form->getValue('Telephone');
						$nombre_employes = $form->getValue('Nombre_employes');
						
						$albums = new Application_Model_DbTable_DemandeAffiliation();
						$albums->ajouterDemande($identifiant, $num_siret, $e_mail, $password, $adresse, $telephone, $nombre_employes);
						$this->_helper->redirector('index');
					} 
				else 
					{
						$form->populate($formData);
					}
			}
    }

    public function modificationDossierAction()
    {
        // action body
    }

    public function reversionAction()
    {
        // action body
    }

    public function rachatTrimestresAction()
    {
        // action body
    }

    public function informationsAction()
    {
        // action body
    }


}













