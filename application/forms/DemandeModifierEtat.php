﻿<?php

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
				//->setValue(array(1, "En cours"));

				
		$envoyer = new Zend_Form_Element_Submit('envoyer_demande_modif_etat');
		$envoyer
					->setAttrib('id', 'boutonenvoyer')
					->setLabel('Modifier');
					
		$this->addElements(array(
											$etat, 
											$envoyer
								));
				
	}


}

