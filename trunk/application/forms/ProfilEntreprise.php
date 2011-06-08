<?php

class Application_Form_ProfilEntreprise extends Zend_Form
{

    public function init()
    {
        //Titre du formulaire
		$this->setName('profilentreprise');
		
		$id = new Zend_Form_Element_Hidden('Id_utilisateur');
		$id->addFilter('Int');
	
		//NUMERO DE SIRET
		$num_siret = new Zend_Form_Element_Text('Num_siret');
		$num_siret
				->setLabel('Numéro de SIRET : ')
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('StringLength', false, array(3, 200))
				->addValidator('Alnum', false, array('allowWhiteSpace' => true))
				->setRequired(true)
				//->setDescription('Minimum de 3 caractères')
				->addErrorMessages(array('Numéro de SIRET invalide'));
		
		//NOM ENTREPRISE
		$nom_entreprise = new Zend_Form_Element_Text('Nom_entreprise');
		$nom_entreprise
				->setLabel('Raison Sociale : ')
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('StringLength', false, array(3, 200))
				->addValidator('Alnum', false, array('allowWhiteSpace' => true))
				->setRequired(true)
				//->setDescription('Minimum de 3 caractères')
				->addErrorMessages(array('Raison Sociale invalide'));
		
		//NOMBRE EMPLOYES
		$nombre_salarie= new Zend_Form_Element_Text('Nombre_salarie');
		$nombre_salarie
				->setLabel('Nombre de salariés : ')
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('Alnum', false, array('allowWhiteSpace' => true))
				->setRequired(true)
				->addErrorMessages(array('Nombre de salariés invalide'));
		
		//NOMBRE CADRES
		$nombre_cadre = new Zend_Form_Element_Text('Nombre_cadre');
		$nombre_cadre
				->setLabel('Nombre de cadres : ')
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('Alnum', false, array('allowWhiteSpace' => true))
				->setRequired(true)
				->addErrorMessages(array('Nombre de cadres invalide'));
		
				
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
									$num_siret,
									$nom_entreprise,
									$nombre_salarie,
									$nombre_cadre,
									$adresse,
									$telephone,
									$e_mail,
									$modifier)
								);
    }


}

