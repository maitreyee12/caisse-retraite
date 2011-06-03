<?php

class Application_Form_DemandeModifierEtat extends Zend_Form
{

    public function init()
    {		
		$etat = new Zend_Form_Element_Select('Etat');
		$etat
				->setLabel('Etat : ')
				->addMultiOption(0 , "En attente")
				->addMultiOption(1 , "En cours")
				->addMultiOption(2 , "Traité");
				
		$envoyer = new Zend_Form_Element_Submit('envoyer');
		$envoyer
					->setAttrib('id', 'boutonenvoyer')
					->setLabel('Modifier');
					
		$this->addElements(array(
											$etat, 
											$envoyer
								));
				
	}


}

