<?php

class Application_Form_DemandeInformations extends Zend_Form
{
    public function init()
    {
        //Titre du formulaire
		$this->setName('demande_informations');

		//ID
		$id = new Zend_Form_Element_Hidden('Num_demande');
		$id
				->addFilter('Int');
		
		$auth = Zend_Auth::getInstance();
		if($auth->getIdentity()->Droits == 3)
			{
				//NUM_COURRIER
				$num_courrier = new Zend_Form_Element_Text('Id_courrier');
				$num_courrier
						->setLabel('Numéro de courrier : ')
						->addFilter('StripTags')
						->addValidator('regex', false, array('([0-9]*)'))
						->setRequired(true)
						->setDescription('Numéro du courrier qui contient la demande écrite.');
			}
				
		//COMMENTAIRE
		$commentaire = new Zend_Form_Element_Textarea('Commentaires');
		$commentaire
				->setLabel('Votre demande :')
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->setAttrib('cols', '80')
				->setAttrib('rows', '10')
				->setRequired(true)
				->setAttrib('maxlength', '2048');
		
		$envoyer = new Zend_Form_Element_Submit('envoyer');
		$envoyer
					->setAttrib('id', 'boutonenvoyer')
					->setLabel('Envoyer la demande');
		
		if($auth->getIdentity()->Droits == 3)
			{
				$this->addElements(array(
											$id,
											$num_courrier,
											$commentaire,
											$envoyer)
								);
			}
		else
			{
				$this->addElements(array(
											$id,
											$commentaire,
											$envoyer)
								);
			}
    }


}

