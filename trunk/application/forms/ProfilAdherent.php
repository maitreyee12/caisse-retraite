<?php

class Application_Form_ProfilAdherent extends Zend_Form
{

    public function init()
    {
        //Titre du formulaire
		$this->setName('profiladherent');
		
		$id = new Zend_Form_Element_Hidden('id');
		$id->addFilter('Int');
	
		//NOM
		$nom = new Zend_Form_Element_Text('Nom');
		$nom
				->setLabel('Nom : ')
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('StringLength', false, array(3, 200))
				->addValidator('Alnum', false, array('allowWhiteSpace' => true))
				->setRequired(true)
				//->setDescription('Minimum de 3 caractères')
				->addErrorMessages(array('Nom invalide'));
		
		//PRENOM
		$prenom = new Zend_Form_Element_Text('Prenom');
		$prenom
				->setLabel('Prénom : ')
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('StringLength', false, array(3, 200))
				->addValidator('Alnum', false, array('allowWhiteSpace' => true))
				->setRequired(true)
				//->setDescription('Minimum de 3 caractères')
				->addErrorMessages(array('Prénom invalide'));
		
		//NUM SECURITE SOCIALE
		$numSS= new Zend_Form_Element_Text('NumSS');
		$numSS
				->setLabel('Numéro S.S. : ')
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('StringLength', false, array(3, 200))
				->addValidator('regex', false, array('([0-9]{10})'))
				->setRequired(true)
				->setDescription('format : 188099400011122')
				->addErrorMessages(array('Numéro de sécurité sociale invalide'));
		
		//TEL
		$telephone = new Zend_Form_Element_Text('Telephone');
		$telephone
				->setLabel('Numéro de téléphone : ')
				->addFilter('StripTags')
				->addValidator('regex', false, array('([0-9]{10})'))
				->setRequired(true)
				->setAttrib('maxlength', '10')
				->setDescription('format : 0142179352')
				->addErrorMessages(array('Le numéro de téléphone ne comporte pas les 10 chiffres'));
		
				
		//ADRESSE
		$adresse = new Zend_Form_Element_Textarea('Adresse');
		$adresse
				->setLabel('Adresse :')
				->addFilter('StripTags')
				->addFilter('StringTrim')
				
				->setRequired(true)
				->setAttrib('cols', '40')
				->setAttrib('rows', '4')
				->setErrorMessages(array('Adresse invalide'));	
				
		//E_MAIL
		$e_mail = new Zend_Form_Element_Text('E_mail');
		$e_mail
				->setLabel('Adresse email : ')
				->addFilter('StripTags')
				->addValidator('regex', false, array('/^[-_a-z0-9\'+*$^&%=~!?{}]++(?:\.[-_a-z0-9\'+*$^&%=~!?{}]+)*+@(?:(?![-.])[-a-z0-9.]+(?<![-.])\.[a-z]{2,6}|\d{1,3}(?:\.\d{1,3}){3})(?::\d++)?$/iD'))
				->setRequired(true)
				->setAttrib('size', 30)
				->addErrorMessages(array('Adresse email invalide'));
		
		
		$modifier = new Zend_Form_Element_Submit('modifier');
		$modifier
					->setAttrib('id', 'boutonmodifier')
					->setLabel('Enregistrer les modifications');;
	
		$this->addElements(array(
									$id,
									$nom,
									$prenom,
									$numSS,
									$telephone,
									$adresse,
									$e_mail,
									$modifier)
								);
    }


}

