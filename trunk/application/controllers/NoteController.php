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
		$id =  $this->_getParam("id");
		$prov =  $this->_getParam("prov");
		
		$model_Demande = new Application_Model_DbTable_Demande();
		$this->getDemande = $model_Demande->getDemande($id);
	
		if($this->getDemande->Etat == 2)
			{
				$this->render('note-verouille');
			}
		else
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
								$date_soumission = date("Y-m-d H:i:s");
								$note = $form_Note->getValue('Note');
							
								$model_Note = new Application_Model_DbTable_Note();
								$model_Note->ajouterDemande($id, $id_utilisateur, $date_soumission, $note);
								
								if(md5("demandeAffiliation") == $prov)
									{
										$this->_helper->redirector('demande-affiliation','AfficherLesDemandes', null, array('id' => ($id)));
									}
								else if(md5("demandeInformations") == $prov)
									{
										$this->_helper->redirector('demande-informations','AfficherLesDemandes', null, array('id' => ($id)));
									}
								else if(md5("demandeReversion") == $prov)
									{
										$this->_helper->redirector('demande-reversion','AfficherLesDemandes', null, array('id' => ($id)));
									}
									
							} 
						else 
							{
								$form_Note->populate($formData);
							}	
					}
			}
    }

    public function afficherNotesAction()
    {
		$id_demande =  $this->_getParam("id");
	
        $notes = new Application_Model_DbTable_Note();
		$this->view->afficherNote = $notes->afficherNote($id_demande);
    }

    public function noteVerouilleAction()
    {
        // action body
    }


}







