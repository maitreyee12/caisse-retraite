<?php

class DeclarationController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $id_utilisateur =  $this->_getParam("id");

		$model_declaration = new Application_Model_DbTable_Declaration();
		$this->view->liste_declaration = $model_declaration->getDeclarationByIdUtilisateur($id_utilisateur);
		
		$this->view->id_utilisateur = $id_utilisateur;
		
		//adhérent
		$request = clone $this->getRequest();
		$request->setActionName('ajouter-declaration-dads');
		$this->_helper->actionStack($request);
		


    }

    public function ajouterDeclarationDadsAction()
    {
		$id_utilisateur =  $this->_getParam("id");
	
       $form_Declaration_Doc = new Application_Form_Document();
		$this->view->form = $form_Declaration_Doc;
		if ($this->getRequest()->isPost())
		{
			$formData = $this->getRequest()->getPost();
			if ($form_Declaration_Doc->isValid($formData))
				{
					$id_demande =  null;
					$description = $form_Declaration_Doc->getValue('Description');

					/* Uploading Document File on Server */
					$upload = new Zend_File_Transfer_Adapter_Http();
					$upload->setDestination("C:\wamp\www\caisse-retraite\uploads\\");
					try
						{
							$upload->receive();
						}
					catch (Zend_File_Transfer_Exception $e)
						{
							$e->getMessage();
						}

					$lien = $upload->getFileName('Doc');
					$id_courrier = null;
						

					//redirection  en fonction de la provenance
					$model_Document = new Application_Model_DbTable_Documents();
					$model_Document->ajouterDocument($id_courrier, $id_demande, $description, $lien);
					$id_document = $model_Document->getDerniereId();
					
					$model_declaration = new Application_Model_DbTable_Declaration();
					$model_declaration->addDeclaration($id_utilisateur, $id_document);
					
				}
			else
				{
					// this line will be called if data was not submited
					$form_Declaration_Doc->populate($formData);
				}
		}
    }

    public function afficherDeclarationDadsAction()
    {
        
    }


}





