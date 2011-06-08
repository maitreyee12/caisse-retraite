<?php

class Application_Form_RechercheAdherent extends Zend_Form
{

    public function init()
    {
		//ID
		$id = new Zend_Form_Element_Text('ID');
		$id
				->setLabel('ID : ')
				->addFilter('StripTags')
				->addFilter('StringTrim');
	
		//NOM
		$nom = new Zend_Form_Element_Text('Nom');
		$nom
				->setLabel('Nom : ')
				->addFilter('StripTags')
				->addFilter('StringTrim');
		
		//PRENOM
		$prenom = new Zend_Form_Element_Text('Prenom');
		$prenom
				->setLabel('Prénom : ')
				->addFilter('StripTags')
				->addFilter('StringTrim');
				
		//NUM SS
		$num_ss = new Zend_Form_Element_Text('Num_ss');
		$num_ss
				->setLabel('Numéro de SS : ')
				->addFilter('StripTags')
				->addFilter('StringTrim');
				
		//TEL
		$tel = new Zend_Form_Element_Text('Tel');
		$tel
				->setLabel('Numéro de téléphone : ')
				->addFilter('StripTags')
				->addFilter('StringTrim');		
				
		//EMAIL
		$email = new Zend_Form_Element_Text('Email');
		$email
				->setLabel('Adress email : ')
				->addFilter('StripTags')
				->addFilter('StringTrim');		
				
		//ADRESSE
		$adresse = new Zend_Form_Element_Text('Adresse');
		$adresse
				->setLabel('Adresse postale : ')
				->addFilter('StripTags')
				->addFilter('StringTrim');		
		
		//STATUS
		$status = new Zend_Form_Element_Select('Status');
		$status
				->setLabel('Staus : ')
				->addMultiOption("salarie" , "salarie")
				->addMultiOption("retraite" , "retraite");
				
		$envoyer = new Zend_Form_Element_Submit('Envoyer');
		$envoyer
					->setAttrib('id', 'boutonenvoyer')
					->setLabel('Recherche');
				
		$this->addElements(array(
											$id, 
											$nom,
											$prenom,
											$num_ss,
											$tel,
											$email,
											$adresse,
											$status,
											$envoyer
								));
    }


}

