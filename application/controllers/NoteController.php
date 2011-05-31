<?php

class NoteController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function ajouterNoteAction()
    {
        $form_Note = new Application_Form_Note();
		$this->view->form = $form_Note;
		if ($this->getRequest()->isPost()) 
			{
				$formData = $this->getRequest()->getPost();
				if ($form_Note->isValid($formData)) 
					{
						 $upload = new Zend_File_Transfer_Adapter_Http();
						 $upload->setDestination(APPLICATION_PATH."/uploads/dads/");
						 try 
							{
								// upload received file(s)
								$upload->receive();
							} 
						catch (Zend_File_Transfer_Exception $e) 
							{
								$e->getMessage();
							}
						
						// so, Finally lets See the Data that we received on Form Submit
						$uploadedData = $form->getValues();
						Zend_Debug::dump($uploadedData, 'Form Data:');
						 
						// you MUST use following functions for knowing about uploaded file
						# Returns the file name for 'doc_path' named file element
						$name = $upload->getFileName('doc_path');

						# Returns the size for 'doc_path' named file element
						# Switches of the SI notation to return plain numbers
						$upload->setOption(array('useByteString' => false));
						$size = $upload->getFileSize('doc_path');

						# Returns the mimetype for the 'doc_path' form element
						$mimeType = $upload->getMimeType('doc_path');
					
						//following lines are just for being sure that we got data
						 print "Name of uploaded file: $name
						";
						 print "File Size: $size
						";
						 print "File's Mime Type: $mimeType";
											
					
					
						$auth = Zend_Auth::getInstance();
						$id_utilisateur = $auth->getIdentity()->Id_utilisateur;
						$id =  $this->_getParam("id");
						$date_soumission = date("Y-m-d H:i:s");
						$note = $form_Note->getValue('Note');
						
						$model_Note = new Application_Model_DbTable_Note();
						$model_Note->ajouterDemande($id, $id_utilisateur, $date_soumission, $note);
						
						$this->_helper->redirector('demande-affiliation','AfficherLesDemandes', null, array('id' => ($id)));
					} 
				else 
					{
						$form_Note->populate($formData);
					}
			}
    }

    public function afficherNotesAction()
    {
		$id_demande =  $this->_getParam("id");
	
        $notes = new Application_Model_DbTable_Note();
		$this->view->afficherNote = $notes->afficherNote($id_demande);
    }


}





