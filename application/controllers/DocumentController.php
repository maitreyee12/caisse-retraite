<?php

class DocumentController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function afficherDocumentsAction()
    {
		$id_demande =  $this->_getParam("id");
	
        $documents = new Application_Model_DbTable_Documents();
		$this->view->listeDocuments = $documents->afficherDocumentsParDemande($id_demande);
    }

    public function ajouterDocumentAction()
    {
		$id =  $this->_getParam("id");
		
		$model_Demande = new Application_Model_DbTable_Demande();
		$this->getDemande = $model_Demande->getDemande($id);
	
		if($this->getDemande->Etat == 2)
			{
				$this->render('document-verouille');
			}
		else
			{
	
				$form_Demande = new Application_Form_Document();
				$this->view->form = $form_Demande;
				if ($this->getRequest()->isPost()) 
					{
						$formData = $this->getRequest()->getPost();
						if ($form_Demande->isValid($formData)) 
							{
							
								$id_demande =  $this->_getParam("id");
								$description = $form_Demande->getValue('Description');

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
								$id_courrier = $form_Demande->getValue('Id_courrier');
									
								
								$model_Document = new Application_Model_DbTable_Documents();
								$model_Document->ajouterDocument($id_courrier, $id_demande, $description, $lien);
								
								$this->_helper->redirector('demande-affiliation','AfficherLesDemandes', null, array('id' => ($id_demande)));
							} 
						else 
							{
								// this line will be called if data was not submited
								$form_Demande->populate($formData);
							}
					}
			}
    }

    public function documentVerouilleAction()
    {
        // action body
    }


}







