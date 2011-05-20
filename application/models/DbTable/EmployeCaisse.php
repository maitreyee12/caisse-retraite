<?php

class Application_Model_DbTable_EmployeCaisse extends Zend_Db_Table_Abstract
{

    protected $_name = 'employe_caisse';

	public function obtenirEmployeCaisse($Id_utilisateur)
	{
		$Id_utilisateur = (int)$Id_utilisateur;
		$row = $this->fetchRow('Id_utilisateur = ' . $Id_utilisateur);
		if (!$row) {
			throw new Exception("Impossible de trouver l'enregistrement $Id_utilisateur");
		}
		return $row->toArray();
	}
}

