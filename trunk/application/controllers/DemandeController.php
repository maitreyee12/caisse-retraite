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
		$form_DemandeAffiliation = new Application_Form_DemandeAffiliation();
		$this->view->form = $form_DemandeAffiliation;
		if ($this->getRequest()->isPost()) 
			{
				$formData = $this->getRequest()->getPost();
				if ($form_DemandeAffiliation->isValid($formData)) 
					{
						$identifiant = $form_DemandeAffiliation->getValue('Identifiant');
						$num_siret  = $form_DemandeAffiliation->getValue('Num_siret');
						$e_mail = $form_DemandeAffiliation->getValue('E_mail');
						$password = $form_DemandeAffiliation->getValue('Password');
						$adresse = $form_DemandeAffiliation->getValue('Adresse');
						$telephone = $form_DemandeAffiliation->getValue('Telephone');
						$nombre_employes = $form_DemandeAffiliation->getValue('Nombre_employes');
						$commentaires = $form_DemandeAffiliation->getValue('Commentaires');
						
						$model_DemandeAffiliation = new Application_Model_DbTable_DemandeAffiliation();
						$model_DemandeAffiliation->ajouterDemande($identifiant, $num_siret, $e_mail, $password, $adresse, $telephone, $nombre_employes, $commentaires);
						$this->_helper->redirector('accepte');
					} 
				else 
					{
						$form_DemandeAffiliation->populate($formData);
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

    public function accepteAction()
    {
        // action body
    }


}















