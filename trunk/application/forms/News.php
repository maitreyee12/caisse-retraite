<?php

class Application_Form_News extends Zend_Form
{

    public function init()
    {
		$this->setAttrib('enctype', 'multipart/form-data');
		
		//CATEGORIE
		$categorie = new Zend_Form_Element_Select('Categorie');
		$categorie
				->setLabel('Publier dans la rubrique : ')
				->addMultiOption("adherent_employe" , "Salarié")
				->addMultiOption("adherent_retraite" , "Retraité")
				->addMultiOption("entreprise" , "Entreprise")
				->addMultiOption("groupe" , "Groupe");
	
        //TITRE
		$titre = new Zend_Form_Element_Textarea('Titre');
		$titre
				->setLabel('Titre : ')
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('StringLength', false, array(5, 512))
				->setRequired(true)
				->setAttrib('cols', '80')
				->setAttrib('rows', '2')
				->addErrorMessages(array('Le titre est mal formaté ou trop long.'));
				
		//RESUME
		$resume = new Zend_Form_Element_Textarea('Resume');
		$resume
				->setLabel('Résumé : ')
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('StringLength', false, array(5, 1000))
				->setRequired(true)
				->setAttrib('cols', '80')
				->setAttrib('rows', '4')
				->addErrorMessages(array('Le résumé est mal formaté ou trop long.'));
				
		//TEXTE
		$texte = new Zend_Form_Element_Textarea('Texte');
		$texte
				->setLabel('Contenu du document : ')
				->addValidator('StringLength', false, array(5, 10000))
				->setRequired(true)
				->setAttrib('cols', '80')
				->setAttrib('rows', '10')
				->setDescription('Vous pouvez intégrer des balises XHTML dans cette partie.')
				->addErrorMessages(array('Le texte est mal formaté ou trop long.'));
				
		//IMAGE
		$doc_file = new Zend_Form_Element_File('Image_lien');
		$doc_file->setLabel('Image : ')
		->setDescription('L\'image est optionelle');
		
				
		$envoyer = new Zend_Form_Element_Submit('envoyer');
		$envoyer
					->setAttrib('id', 'boutonenvoyer')
					->setLabel('Ajouter la news');
					
		$this->addElements(array(
											$categorie, 
											$titre, 
											$resume, 
											$texte, 
											$doc_file, 
											$envoyer
								));
		
    }


}

