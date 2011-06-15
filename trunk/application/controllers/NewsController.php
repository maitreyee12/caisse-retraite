<?php

class NewsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function ajouterNewsAction()
    {
        $form_News = new Application_Form_News();
		$this->view->form = $form_News;
		if ($this->getRequest()->isPost()) 
			{
				$formData = $this->getRequest()->getPost();
				if ($form_News->isValid($formData)) 
					{
						$categorie = $form_News->getValue('Categorie');
						$titre = $form_News->getValue('Titre');
						$resume = $form_News->getValue('Resume');
						$texte = $form_News->getValue('Texte');

						/* Uploading Document File on Server */
						$upload = new Zend_File_Transfer_Adapter_Http();
						if($upload->getFileName('Image_lien'))
							{
								$lien = $upload->getFileName('Image_lien');
								$upload->setDestination("C:\wamp\www\caisse-retraite\public\images\site\\");
								try 
									{
										$upload->receive();
									} 
								catch (Zend_File_Transfer_Exception $e) 
									{
										$e->getMessage();
									}
							
								$lien = $upload->getFileName('Image_lien');
								$renameFile = md5($titre).'.jpg';
								$fullFilePath = 'images/site/'.$renameFile;
								$filterFileRename = new Zend_Filter_File_Rename(array('target' => $fullFilePath, 'overwrite' => true));
								$filterFileRename->filter($lien);

								$lien = $fullFilePath;
							}
						else
							{
								$lien = null;
							}
						
						$date = date("Y-m-d");
						
						//redirection  en fonction de la provenance
						$model_news = new Application_Model_DbTable_News();
						$model_news->addNews($categorie, $date, $titre, $resume, $texte, $lien);
						
						return $this->_helper->redirector('accepte');
						
					} 
				else 
					{
						// this line will be called if data was not submited
						$form_News->populate($formData);
					}
			}
    }

    public function accepteAction()
    {
        // action body
    }


}





