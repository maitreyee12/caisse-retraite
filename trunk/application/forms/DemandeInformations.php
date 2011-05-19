<?php

class Application_Form_DemandeInformations extends Zend_Form
{

    public function init()
    {
        //Titre du formulaire
		$this->setName('demande_affiliation');

		//ID
		$id = new Zend_Form_Element_Hidden('Num_demande');
		$id
				->addFilter('Int');
				
		//COMMENTAIRE
		$commentaire = new Zend_Form_Element_Textarea('Commentaires');
		$commentaire
				->setLabel('Votre demande :')
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->setAttrib('cols', '40')
				->setAttrib('rows', '4')
				->setRequired(true)
				->setAttrib('maxlength', '2048');
		
		$envoyer = new Zend_Form_Element_Submit('envoyer');
		$envoyer
					->setAttrib('id', 'boutonenvoyer')
					->setLabel('Envoyer la demande');
					
		$this->addElements(array(
											$id, 
											$commentaire,
											$envoyer)
								);
											
    }


}

