<?php
/*Controller du module d'Authentification
 * 
 * Pour récupérer les infos sur l'utilisateur connecter, utiliser:
 * 
 * $login = Zend_Auth::getInstance ()->getIdentity()->Login; pour le login
 * $droits = Zend_Auth::getInstance ()->getIdentity()->Droits; pour les droits
 * 
 * 
 * */
class ConnexionController extends Zend_Controller_Action
{

    public function init()
    {
        //On vide toute authentification
        Zend_Auth::getInstance ()->clearIdentity ();

    }

    public function indexAction()
    {
        $this->_forward ( 'login' );
    	
    }

    public function loginAction()
    {
    	//On créé un formulaire de login
        $form = new Application_Form_UserLogin ( );
        //On l'affecte à la vue formLogin
        $this->view->form = $form;

        //S'il y a une authentification
        if ($this->_request->isPost ()) {
        	//On récupère les données
            $formData = $this->_request->getPost ();
            //On vérifie qu'elles soient valides
            if ($form->isValid ( $formData )) {
            	//Récupération de l'e-mail et du mot de passe
                $email = $form->getValue ( 'email' );
                $password = $form->getValue ( 'password' );
                //Création d'un adaptater à la base de données
                $authAdapter = new Zend_Auth_Adapter_DbTable ( Zend_Db_Table::getDefaultAdapter () );
                //Paramètres de connexion à la table des utilisateurq
                $authAdapter->setTableName ( 'utilisateur' )
                    		->setIdentityColumn ( 'Login' )
                    		->setCredentialColumn ( 'Password' )
                    		//->setCredentialTreatment ( 'MD5(?)' )
                    		->setIdentity ( $email )
                    		->setCredential ( $password );

                //Tentative d'authentification
                $authAuthenticate = $authAdapter->authenticate ();

                //Si l'authentification réussi
                if ($authAuthenticate->isValid ()) {
                	//On stock dans le Storage de l'application les info de l'utilisateur
                    $storage = Zend_Auth::getInstance ()->getStorage ();
                    $storage->write ( $authAdapter->getResultRowObject ( null, 'password' ) );
                    //Redirection vers la page principale
                    $this->_helper->redirector ( 'index', 'index' );
                } else {
                	//On affiche une erreur si besoin
                    $form->addError ("Login ou mot de passe incorrecte");
                }
            }
        }
        $this->render ( 'login' );
    }

    public function logoutAction()
    {
    	//On vide le Storage d'authentification
        Zend_Auth::getInstance ()->clearIdentity ();
        //Redirection vers la page principale
        $this->_helper->redirector ( 'index', 'index' );
    	
    }

    public function preDispatchAction()
    {
		if (Zend_Auth::getInstance ()->hasIdentity ()) {
			if ('logout' != $this->getRequest ()->getActionName ()) {
				$this->_helper->redirector ( 'index', 'index' );
			}
		} else {
			if ('logout' == $this->getRequest ()->getActionName ()) {
				$this->_helper->redirector ( 'index' );
			}
		}
    }


}









