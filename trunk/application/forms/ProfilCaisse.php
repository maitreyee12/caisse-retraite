<?php

class Application_Form_ProfilCaisse extends Zend_Form
{

    public function init()
    {
        $this->setName('profilcaisse');
		
		$id = new Zend_Form_Element_Hidden('Id_utilisateur');
		$id->addFilter('Int');
	
		//NOM
		$nom = new Zend_Form_Element_Text('Nom_caisse');
		$nom
				->setLabel('Nom : ')
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('StringLength', false, array(3, 200))
				->addValidator('Alnum', false, array('allowWhiteSpace' => true))
				->setRequired(true)
				//->setDescription('Minimum de 3 caractères')
				->addErrorMessages(array('Nom invalide'));
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
		$modifier = new Zend_Form_Element_Submit('modifier');
		$modifier
					->setAttrib('id', 'boutonmodifier')
					->setLabel('Enregistrer les modifications');;
	
		$this->addElements(array(
									$id,
									$nom,
									$telephone,
									$adresse,
									$modifier)
								);
    }


}

