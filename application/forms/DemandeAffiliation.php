<?php

class Application_Form_DemandeAffiliation extends Zend_Form
{

    public function init()
    {
		$this->setName('demande_affiliation');
		
		$id = new Zend_Form_Element_Hidden('Num_demande');
		$id->addFilter('Int');
		
		$identifiant = new Zend_Form_Element_Text('Identifiant');
		$identifiant->setLabel('Nom de la société')
		->setRequired(true)
		->addFilter('StripTags')
		->addFilter('StringTrim')
		->addValidator('NotEmpty');
		
		$num_siret = new Zend_Form_Element_Text('Num_siert');
		$num_siret->setLabel('Num_siert')
		->setRequired(true)
		->addFilter('Int')
		->addValidator('NotEmpty');
		
		$e_mail = new Zend_Form_Element_Text('E_mail');
		$e_mail->setLabel('E_mail')
		->setRequired(true)
		->addFilter('StripTags')
		->addFilter('StringTrim')
		->addValidator('NotEmpty');
		
		$password = new Zend_Form_Element_Text('Password');
		$password->setLabel('Password')
		->setRequired(true)
		->addFilter('StripTags')
		->addFilter('StringTrim')
		->addValidator('NotEmpty');
		
		$adresse = new Zend_Form_Element_Text('Adresse');
		$adresse->setLabel('Adresse')
		->setRequired(true)
		->addFilter('StripTags')
		->addFilter('StringTrim')
		->addValidator('NotEmpty');
		
		$telephone = new Zend_Form_Element_Text('Telephone');
		$telephone->setLabel('Telephone')
		->setRequired(true)
		->addFilter('Int')
		->addValidator('NotEmpty');
		
		$nombre_employes = new Zend_Form_Element_Text('Nombre_employes');
		$nombre_employes->setLabel('Nombre_employes')
		->setRequired(true)
		->addFilter('Int')
		->addValidator('NotEmpty');
		
		$envoyer = new Zend_Form_Element_Submit('envoyer');
		$envoyer->setAttrib('id', 'boutonenvoyer');
		$this->addElements(array($id, $identifiant, $num_siret, $e_mail, $password, $adresse, $telephone, $nombre_employes, $envoyer));
    }


}

