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





