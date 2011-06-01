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
        // action body
    }

    public function ajouterDocumentAction()
    {
		$form = new Application_Form_Document();
		$this->view->form = $form;
		if ($this->getRequest()->isPost()) 
			{
				$formData = $this->getRequest()->getPost();
				if ($form->isValid($formData)) 
					{

						/* Uploading Document File on Server */
						$upload = new Zend_File_Transfer_Adapter_Http();
						$upload->setDestination("C:\wamp\www\caisse-retraite\uploads\\");
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
						$upload->setOptions(array('useByteString' => false));
						$size = $upload->getFileSize('doc_path');

						# Returns the mimetype for the 'doc_path' form element
						$mimeType = $upload->getMimeType('doc_path');

						// following lines are just for being sure that we got data
						print "Name of uploaded file: $name";
						print "File Size: $size";
						print "File's Mime Type: $mimeType";

						// New Code For Zend Framework :: Rename Uploaded File
						$renameFile = 'newName.jpg';
						$fullFilePath = 'C:\wamp\www\caisse-retraite\uploads\dads\\'.$renameFile;

						// Rename uploaded file using Zend Framework
						$filterFileRename = new Zend_Filter_File_Rename(array('target' => $fullFilePath, 'overwrite' => true));

						$filterFileRename -> filter($name);
					} 
				else 
					{
						// this line will be called if data was not submited
						$form->populate($formData);
					}
			}
    }


}





