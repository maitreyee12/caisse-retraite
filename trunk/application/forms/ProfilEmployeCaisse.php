<?php

class Application_Form_ProfilEmployeCaisse extends Zend_Form
{

    public function init()
    {
        $this->setName('profilemployecaisse');
		
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
		$modifier = new Zend_Form_Element_Submit('modifier');
		$modifier
					->setAttrib('id', 'boutonmodifier')
					->setLabel('Enregistrer les modifications');;
	
		$this->addElements(array(
									$id,
									$nom,
									$prenom,
									$modifier)
								);
    }


}

