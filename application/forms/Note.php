<?php

class Application_Form_Note extends Zend_Form
{

	protected $_name = 'note';

	public function init()
    {
		//Titre du formulaire
		$this->setName('Déposer une note');
				
		//NOTE
		$note = new Zend_Form_Element_Textarea('Note');
		$note
				->setLabel('Ajouter une note')
				->addValidator('StringLength', false, array(1))
				->setRequired(true)
				->setAttrib('cols', '40')
				->setAttrib('rows', '4')
				->setErrorMessages(array('Vous devez compléter la note avant de l\'envoyer'));	
				
		//ENVOYER		
		$envoyer = new Zend_Form_Element_Submit('envoyer');
		$envoyer
					->setAttrib('id', 'boutonenvoyer')
					->setLabel('Ajouter la note');
				
		$this->addElements(array(
									$note,
									$envoyer
								));
			
	}

}

