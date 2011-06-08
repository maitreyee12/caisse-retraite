<?php

class Application_Form_RechercheEntreprise extends Zend_Form
{

    public function init()
    {
		//ID
		$id = new Zend_Form_Element_Text('ID');
		$id
				->setLabel('ID : ')
				->addFilter('StripTags')
				->addFilter('StringTrim');
	
		//NUM SIRET
		$num_siret = new Zend_Form_Element_Text('Num_siret');
		$num_siret
				->setLabel('Numéro de siret : ')
				->addFilter('StripTags')
				->addFilter('StringTrim');
		
		//NOM ENT
		$nom_ent = new Zend_Form_Element_Text('Nom_entreprise');
		$nom_ent
				->setLabel('Nom : ')
				->addFilter('StripTags')
				->addFilter('StringTrim');
				
		//ADRESSE
		$adresse = new Zend_Form_Element_Text('Adresse');
		$adresse
				->setLabel('Adresse postale : ')
				->addFilter('StripTags')
				->addFilter('StringTrim');		
				
		//EMAIL
		$email = new Zend_Form_Element_Text('Email');
		$email
				->setLabel('Adresse email : ')
				->addFilter('StripTags')
				->addFilter('StringTrim');		
				
		//TEL
		$tel = new Zend_Form_Element_Text('Telephone');
		$tel
				->setLabel('Téléphone : ')
				->addFilter('StripTags')
				->addFilter('StringTrim');		

				
		$envoyer = new Zend_Form_Element_Submit('Envoyer');
		$envoyer
					->setAttrib('id', 'boutonenvoyer')
					->setLabel('Recherche');
				
		$this->addElements(array(
											$id, 
											$num_siret,
											$nom_ent,
											$adresse,
											$email,
											$tel,
											$envoyer
								));
    }


}

