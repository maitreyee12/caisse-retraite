<?php

class Application_Model_DbTable_Caisse extends Zend_Db_Table_Abstract
{

    protected $_name = 'caisse';

	public function obtenirCaisse($Id_utilisateur)
	{
		$Id_utilisateur = (int)$Id_utilisateur;
		$row = $this->fetchRow('Id_utilisateur = ' . $Id_utilisateur);
		if (!$row) {
			throw new Exception("Impossible de trouver l'enregistrement $Id_utilisateur");
		}
		return $row->toArray();
	}
}

