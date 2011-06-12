<?php

class Application_Form_DemandeDepartRetraite extends ZendX_JQuery_Form
{

    public function init()
    {
         //Titre du formulaire
		$this->setName('demande_depart_retraite');

		//ID
		$id = new Zend_Form_Element_Hidden('Num_demande');
		$id
				->addFilter('Int');

		//DATE				
		$date = new ZendX_JQuery_Form_Element_DatePicker('Date',
						array('jQueryParams' => array('dateFormat' => 'dd/mm/yy',
                                                  'changeMonth' => 'true',
                                                  'changeYear' => 'true',
                                                  'yearRange' => '-20:0',
                                                  'minDate' => '-20Y',
                                                  'maxDate' => '0')));
		$date ->setLabel('Date de départ souhaitée :');
		
		
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
		
		$this->addElements(array(
											$id,
											$date,
											$commentaire,
											$envoyer)
								);
		
    }


}

