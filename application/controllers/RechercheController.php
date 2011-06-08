<?php

class RechercheController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function listeEntreprisesAction()
    {
        $form_RechercheEntreprise = new Application_Form_RechercheEntreprise();
		$this->view->form = $form_RechercheEntreprise;
		if ($this->getRequest()->isPost()) 
			{
				$formData = $this->getRequest()->getPost();
				if ($form_RechercheEntreprise->isValid($formData)) 
					{
						$id = $form_RechercheEntreprise->getValue('ID');
						$num_siret = $form_RechercheEntreprise->getValue('Num_siret');
						$nom_ent = $form_RechercheEntreprise->getValue('Nom_entreprise');
						$adresse = $form_RechercheEntreprise->getValue('Adresse');
						$mail = $form_RechercheEntreprise->getValue('Email');
						$tel = $form_RechercheEntreprise->getValue('Telephone');
					
						$model_RechercheEntreprise = new Application_Model_DbTable_Entreprise();
						$this->view->listeEntreprises = $model_RechercheEntreprise->rechercheEntreprise($id, $num_siret, $nom_ent, $adresse, $mail, $tel);
						
						
						$form_RechercheEntreprise->populate($formData);
							
					} 
				else 
					{
						$form_RechercheEntreprise->populate($formData);
					}
			}
    }

    public function listeAdherentsAction()
    {
		$form_RechercheAdherent = new Application_Form_RechercheAdherent();
		$this->view->form = $form_RechercheAdherent;
		if ($this->getRequest()->isPost()) 
			{
				$formData = $this->getRequest()->getPost();
				if ($form_RechercheAdherent->isValid($formData)) 
					{
						$id = $form_RechercheAdherent->getValue('ID');
						$nom = $form_RechercheAdherent->getValue('Nom');
						$prenom = $form_RechercheAdherent->getValue('prenom');
						$num_ss = $form_RechercheAdherent->getValue('Num_SS');
						$tel = $form_RechercheAdherent->getValue('Tel');
						$email = $form_RechercheAdherent->getValue('Email');
						$adresse = $form_RechercheAdherent->getValue('Adresse');
						$status = $form_RechercheAdherent->getValue('Status');
					
						$model_RechercheAdherent = new Application_Model_DbTable_Adherent();
						$this->view->listeAdherents = $model_RechercheAdherent->rechercheAdherent($id, $nom, $prenom, $num_ss, $tel, $email, $adresse, $status);
						
						
						$form_RechercheAdherent->populate($formData);
							
					} 
				else 
					{
						$form_RechercheAdherent->populate($formData);
					}
			}
	}


}





