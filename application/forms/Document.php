<?php

class Application_Form_Document extends Zend_Form
{

    public function __construct($options = null)
	 {
		 parent::__construct($options);
		// setting Form name, Form action and Form Ecryption type
		$this->setName('Fichier :');
		$this->setAttrib('enctype', 'multipart/form-data');
		 
		$description = new Zend_Form_Element_Text('Description');
		$description
				->setLabel('Nom du document :')
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('StringLength', false, array(3, 200))
				->setRequired(true)
				//->setDescription('Minimum de 3 caractères')
				->addErrorMessages(array('Le nom du document doit comprendre au moins 3 caractères'));
		 
		 // creating object for Zend_Form_Element_File
		 $doc_file = new Zend_Form_Element_File('Doc');
		 $doc_file->setLabel('Document : ')
				  ->setRequired(true);

		 // creating object for submit button
		 $submit = new Zend_Form_Element_Submit('envoyer_document');
		 $submit->setLabel('Ajouter')
				 ->setAttrib('id', 'envoyer_document');

		// adding elements to form Object
		$this->addElements(array($description, $doc_file, $submit));
	 }


}

