<?php

class Application_Form_Rib extends Zend_Form
{

    public function init()
{
        //Titre du formulaire
		$this->setName('rib');
		
		$Id_utilisateur = new Zend_Form_Element_Hidden('Id_utilisateur');
		$Id_utilisateur->addFilter('Int');
		
		$Id_RIB = new Zend_Form_Element_Hidden('Id_RIB');
		$Id_RIB->addFilter('Int');
	
		//Numéro de compte
		$Num_compte = new Zend_Form_Element_Text('Num_compte');
		$Num_compte
				->setLabel('Numéro de compte : ')
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('StringLength', false, array(3, 200))
				->addValidator('Alnum', false, array('allowWhiteSpace' => true))
				->setRequired(true)
				//->setDescription('Minimum de 3 caractères')
				->addErrorMessages(array('Numéro de compte invalide'));
		
		//Identifiant banque
		$ID_banque = new Zend_Form_Element_Text('ID_banque');
		$ID_banque
				->setLabel('Id banque : ')
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('regex', false, array('([0-9]{10})'))
				->setRequired(true)
				//->setDescription('Minimum de 3 caractères')
				->addErrorMessages(array('Id banque invalide'));
		
		//Numéro de guichet
		$Num_guichet= new Zend_Form_Element_Text('Num_guichet');
		$Num_guichet
				->setLabel('Numéro Guichet : ')
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->setRequired(true)
				->addErrorMessages(array('Numéro de guichet invalide'));
		
		//nom banque
		$Nom_banque = new Zend_Form_Element_Text('Nom_banque');
		$Nom_banque
				->setLabel('Nom de banque : ')
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('StringLength', false, array(3, 200))
				->addValidator('Alnum', false, array('allowWhiteSpace' => true))
				->setRequired(true)
				//->setDescription('Minimum de 3 caractères')
				->addErrorMessages(array('Nom de la banque invalide'));
		
		//Nom du titulaire
		$Nom_titulaire = new Zend_Form_Element_Text('Nom_titulaire');
		$Nom_titulaire
				->setLabel('Nom du titulaire du compte : ')
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('StringLength', false, array(3, 200))
				->addValidator('Alnum', false, array('allowWhiteSpace' => true))
				->setRequired(true)
				//->setDescription('Minimum de 3 caractères')
				->addErrorMessages(array('Nom de titulaire invalide'));
		
				
		$Modifier = new Zend_Form_Element_Submit('modifier');
		$Modifier
					->setAttrib('id', 'boutonmodifier')
					->setLabel('Enregistrer les modifications');;
	
		$this->addElements(array(
									$Id_RIB,
									$Id_utilisateur,
									$Num_compte,
									$ID_banque,
									$Num_guichet,
									$Nom_banque,
									$Nom_titulaire,
									$Modifier)
								);
    }


}

