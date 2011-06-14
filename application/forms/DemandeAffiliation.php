<?php

class Application_Form_DemandeAffiliation extends Zend_Form
{

    public function init()
    {
		//Titre du formulaire
		$this->setName('demande_affiliation');

		//ID
		$id = new Zend_Form_Element_Hidden('Num_demande');
		$id
				->addFilter('Int');
				
		if($droit_user = Zend_Auth::getInstance()->getIdentity())
			{
				$droit_user = Zend_Auth::getInstance()->getIdentity()->Droits;
			}
		else
			{
				$droit_user = 0;
			}
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
	
		
		//NOM
		$nom = new Zend_Form_Element_Text('Nom');
		$nom
				->setLabel('Raison sociale : ')
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('StringLength', false, array(3, 200))
				->addValidator('Alnum', false, array('allowWhiteSpace' => true))
				->setRequired(true)
				//->setDescription('Minimum de 3 caractères')
				->addErrorMessages(array('Le nom de la société doit comprendre au moins 3 caractères', 'Ne peut pas comprendre de caractères spéciaux'));
		
		

		//NUM_SIRET
		$num_siret = new Zend_Form_Element_Text('Num_siret');
		$num_siret
				->setLabel('Numéro de SIRET : ')
				->addFilter('StripTags')
				->addValidator('regex', false, array('([0-9]{14})'))
				->setRequired(true)
				->setAttrib('maxlength', '14')
				->addErrorMessages(array('Le numéro de SIRET ne comporte pas les 14 chiffres'));
		
		

		//E_MAIL
		$e_mail = new Zend_Form_Element_Text('E_mail');
		$e_mail
				->setLabel('Adresse email : ')
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
				
		

		//PASSWORD
		$password = new Zend_Form_Element_Password('Password');
		$password
				->setLabel('Mot de passe : ')
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('StringLength', false, array(6))
				->setRequired(true)
				->addErrorMessages(array('Le mot de passe doit contenir au moins 6 caractères'));
		
		$password1 = new Zend_Form_Element_Password('password1');
		$password1
				->setLabel('Confirmer mot de passe : ')
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('StringLength', false, array(6))
				->addValidator('identical', false, array('token' => 'Password', 'strict' => true))
				->setRequired(true)
				->addErrorMessages(array('Mot de passe différent'));		

				
		//ADRESSE
		$adresse = new Zend_Form_Element_Textarea('Adresse');
		$adresse
				->setLabel('Adresse :')
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('StringLength', false, array(5))
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
		

		$nombre_employes = new Zend_Form_Element_Text('Nombre_employes');
		$nombre_employes
				->setLabel('Nombre employes : ')	
				->addFilter('Int')
				->addFilter('StripTags')
				->addValidator('Between',false, array(1, 100000))
				->setRequired(true)
				->addErrorMessages(array('Vous devez déclarer au moins 1 salarié'));
				
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
											$id, 
											$num_courrier,
											$nom, 
											$num_siret,
											$e_mail, 
											$e_mail1, 
											$password, 
											$password1, 
											$adresse, 
											$telephone, 
											$nombre_employes,
											$commentaire,
											$envoyer)
										);
			}
		else
			{
				$this->addElements(array(
											$id, 
											$nom, 
											$num_siret,
											$e_mail, 
											$e_mail1, 
											$password, 
											$password1, 
											$adresse, 
											$telephone, 
											$nombre_employes,
											$commentaire,
											$envoyer)
										);
			}
    }


}

