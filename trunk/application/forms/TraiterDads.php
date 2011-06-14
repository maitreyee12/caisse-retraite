<?php

class Application_Form_TraiterDads extends Zend_Form
{

    public function init()
    {
        //ID DOC
		$id_doc = new Zend_Form_Element_Text('Id_doc');
		$id_doc
				->setLabel('ID Document : ')
				->addFilter('StripTags')
				->addValidator('regex', false, array('([0-9]*)'))
				->setRequired(true)
				->setAttrib('maxlength', '10')
				->addErrorMessages(array('ID de document invalide'));
				
		$id_ent = new Zend_Form_Element_Text('Id_ent');
		$id_ent
				->setLabel('ID Entreprise : ')
				->addFilter('StripTags')
				->addValidator('regex', false, array('([0-9]*)'))
				->setRequired(true)
				->setAttrib('maxlength', '10')
				->addErrorMessages(array('ID d\'entreprise invalide'));
				
		$envoyer = new Zend_Form_Element_Submit('envoyer');
		$envoyer
					->setAttrib('id', 'boutonenvoyer')
					->setLabel('Traiter la DADS');
					
		$this->addElements(array(
									$id_doc, 
									$id_ent, 
									$envoyer
								));
    }


}

