<?php

class Application_Form_DemandeModificationDossier extends Zend_Form
{

    public function init()
    {
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
		
		//SALAIRE
		$salaire = new Zend_Form_Element_Text('Salaire');
		$salaire
				->setLabel('Salaire : ')
				->addFilter('StripTags')
				->addValidator('regex', false, array('([0-9])'))
				->setRequired(true)
				->setAttrib('maxlength', '10')
				->addErrorMessages(array('Le salaire n\'est pas valide'));
				
		//DATE DEBUT
		$date_debut = new Zend_Form_Element_Text('from');
		$date_debut
				->setLabel('Date début de la période : ')
				->addFilter('StripTags')
				->addValidator('regex', false, array('([0-9]{4}-[0-9]{2}-[0-9]{2})'))
				->setRequired(true)
				->addErrorMessages(array('Format de date invalide.'));
		
		//DATE FIN
		$date_fin = new Zend_Form_Element_Text('to');
		$date_fin
				->setLabel('Date de fin de période : ')
				->addFilter('StripTags')
				->addValidator('regex', false, array('([0-9]{4}-[0-9]{2}-[0-9]{2})'))
				->setRequired(true)
				->addErrorMessages(array('Format de date invalide.'));	
		
		
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
											$salaire,
											$date_debut, 
											$date_fin,
											$commentaire, 
											$envoyer)
										);
			}
		else
			{
				$this->addElements(array(
											$salaire,
											$date_debut, 
											$date_fin,
											$commentaire, 
											$envoyer)
										);
			}
		
    }


}

