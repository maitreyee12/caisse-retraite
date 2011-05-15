<?php
/*Formulaire d'authentification*/
class Application_Form_UserLogin extends Zend_Form
{

    public function init()
    {
        $this->setName('authentification');
        //Création des champs d'authentification (E-mail, mot de passe)
        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Identifiant : ')
        	  ->setRequired(true);
        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Mot de pase : ')
           		 ->setRequired(true)
           		 ->addFilter('StripTags')
            	 ->addFilter('StringTrim');

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton')
           	   ->setLabel('Se connecter');
		//Ajout des éléments au formulaire
        $elements = array($email,$password, $submit);
        $this->addElements($elements);

        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'dl', 'class' => 'zend_form')),
            array('Errors', array('placement' => 'apend')),
            'Form'
        ));

    }


}

