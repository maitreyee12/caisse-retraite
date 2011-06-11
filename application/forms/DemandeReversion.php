<?php

class Application_Form_DemandeReversion extends Zend_Form
{

    public function init()
    {
		$droit_user = Zend_Auth::getInstance ()->getIdentity()->Droits;
		if($droit_user == 3)
			{
				//NUM_COURRIER
				$num_courrier = new Zend_Form_Element_Text('Id_courrier');
				$num_courrier
						->setLabel('Numéro de courrier : ')
						->addFilter('StripTags')
						->addValidator('regex', false, array('([0-9]*)'))
						->setRequired(true)
						->setDescription('Numéro du courrier qui contient la demande écrite.');
			}
	
		
		//NOM ADH DCD
		$nom_dcd = new Zend_Form_Element_Text('Nom_dcd');
		$nom_dcd
				->setLabel('Nom du défunt : ')
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('StringLength', false, array(3, 200))
				->setRequired(true)
				->addErrorMessages(array('Le nom de la personne défunte n\'est pas valide'));
				
		//PRENOM ADH DCD
		$prenom_dcd = new Zend_Form_Element_Text('Prenom_dcd');
		$prenom_dcd
				->setLabel('Prénom du défunt : ')
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('StringLength', false, array(3, 200))
				->setRequired(true)
				->addErrorMessages(array('Le prénom de la personne défunte n\'est pas valide'));
		
		

		//NUM SS DCD
		$num_ss_dcd = new Zend_Form_Element_Text('Num_ss_dcd');
		$num_ss_dcd
				->setLabel('Numéro de Sécurité Sociale du défunt : ')
				->addFilter('StripTags')
				->addValidator('regex', false, array('([0-9]{15})'))
				->setRequired(true)
				->setAttrib('maxlength', '15')
				->addErrorMessages(array('Le numéro de Sécurité Sociale ne comporte pas les 15 chiffres'));
		
		//NOM ADH BENEF
		$nom_benef = new Zend_Form_Element_Text('Nom_benef');
		$nom_benef
				->setLabel('Nom du demandeur : ')
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('StringLength', false, array(3, 200))
				->setRequired(true)
				->addErrorMessages(array('Le nom de la personne demandeur n\'est pas valide'));
				
		//PRENOM ADH BENEF
		$prenom_benef = new Zend_Form_Element_Text('Prenom_benef');
		$prenom_benef
				->setLabel('Prénom du défunt : ')
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('StringLength', false, array(3, 200))
				->setRequired(true)
				->addErrorMessages(array('Le prénom de la personne demandeur n\'est pas valide'));
		
		

		//NUM SS BENEF
		$num_ss_benef = new Zend_Form_Element_Text('Num_ss_benef');
		$num_ss_benef
				->setLabel('Numéro de Sécurité Sociale du défunt : ')
				->addFilter('StripTags')
				->addValidator('regex', false, array('([0-9]{15})'))
				->setRequired(true)
				->setAttrib('maxlength', '15')
				->addErrorMessages(array('Le numéro de Sécurité Sociale ne comporte pas les 15 chiffres'));
		
		//LIEN PARENTE		
		$lien_parente = new Zend_Form_Element_Select('Lien_parente');
		$lien_parente
				->setLabel('Lien de parenté : ')
				->addMultiOption(0 , "Conjoint")
				->addMultiOption(1 , "Mari")
				->addMultiOption(2 , "Femme")
				->addMultiOption(3 , "Parent")
				->addMultiOption(4 , "Enfant");

		//ADRESSE BENEF
		$adresse = new Zend_Form_Element_Textarea('Adresse');
		$adresse
				->setLabel('Adresse du demandeur :')
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('StringLength', false, array(5))
				->setRequired(true)
				->setAttrib('cols', '40')
				->setAttrib('rows', '4')
				->setErrorMessages(array('Adresse invalide'));	
				
		
		//TEL BENEF
		$telephone = new Zend_Form_Element_Text('Telephone');
		$telephone
				->setLabel('Numéro de téléphone demandeur : ')
				->addFilter('StripTags')
				->addValidator('regex', false, array('([0-9]{10})'))
				->setRequired(true)
				->setAttrib('maxlength', '10')
				->setDescription('format : 0142179352')
				->addErrorMessages(array('Le numéro de téléphone ne comporte pas les 10 chiffres'));
		
		
		//E_MAIL BENEF
		$e_mail = new Zend_Form_Element_Text('E_mail');
		$e_mail
				->setLabel('Adresse email demandeur : ')
				->addFilter('StripTags')
				->addValidator('regex', false, array('/^[-_a-z0-9\'+*$^&%=~!?{}]++(?:\.[-_a-z0-9\'+*$^&%=~!?{}]+)*+@(?:(?![-.])[-a-z0-9.]+(?<![-.])\.[a-z]{2,6}|\d{1,3}(?:\.\d{1,3}){3})(?::\d++)?$/iD'))
				->setRequired(true)
				->addErrorMessages(array('Adresse email invalide'));
				
		$e_mail1 = new Zend_Form_Element_Text('e_mail1');
		$e_mail1
				->setLabel('Confirmer adresse email : ')
				->addFilter('StripTags')
				->addValidator('regex', false, array('/^[-_a-z0-9\'+*$^&%=~!?{}]++(?:\.[-_a-z0-9\'+*$^&%=~!?{}]+)*+@(?:(?![-.])[-a-z0-9.]+(?<![-.])\.[a-z]{2,6}|\d{1,3}(?:\.\d{1,3}){3})(?::\d++)?$/iD'))
				->addValidator('identical', false, array('token' => 'E_mail', 'strict' => true))
				->setRequired(true)
				->addErrorMessages(array('Adresse email différente'));
		
		//COMMENTAIRE
		$commentaire = new Zend_Form_Element_Textarea('Commentaires');
		$commentaire
				->setLabel('Commentaire')
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->setAttrib('cols', '40')
				->setAttrib('rows', '4')
				->setDescription('Vous pouvez déposer un commentaire pour aider les administrateurs à traiter votre demande.');
		
		$envoyer = new Zend_Form_Element_Submit('envoyer');
		$envoyer
					->setAttrib('id', 'boutonenvoyer')
					->setLabel('Envoyer la demande');
		
		
		if($droit_user == 3)
			{	
				$this->addElements(array(
											$num_courrier, 
											$nom_dcd,
											$prenom_dcd, 
											$num_ss_dcd,
											$nom_benef, 
											$prenom_benef, 
											$num_ss_benef, 
											$lien_parente, 
											$adresse, 
											$telephone, 
											$e_mail,
											$e_mail1,
											$commentaire,
											$envoyer)
										);
			}
		else
			{
				$this->addElements(array(
											$nom_dcd,
											$prenom_dcd, 
											$num_ss_dcd,
											$nom_benef, 
											$prenom_benef, 
											$num_ss_benef, 
											$lien_parente, 
											$adresse, 
											$telephone, 
											$e_mail,
											$e_mail1,
											$commentaire,
											$envoyer)
										);
			}
		
    }


}

