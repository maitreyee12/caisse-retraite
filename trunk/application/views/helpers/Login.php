<?php
class Zend_View_Helper_Login extends Zend_View_Helper_Abstract {
	public function login() {
		$helperUrl = new Zend_View_Helper_Url ( );
		$auth = Zend_Auth::getInstance ();
		if ($auth->hasIdentity ()) {
			$username = $auth->getIdentity ()->Login;
			$logoutLink = $helperUrl->url ( array ('action' => 'logout', 'controller' => 'Connexion' ) );
			return $username . ' (<a href="' . $logoutLink . '">Logout</a>)';
		}
		$loginLink = $helperUrl->url ( array ('action' => 'login', 'controller' => 'Connexion' ) );
		return '<a href="' . $loginLink . '">S\'authentifier</a>';
	}
}