<?php

class Application_Model_DbTable_Utilisateur extends Zend_Db_Table_Abstract
{

    protected $_name = 'utilisateur';
    
	public function obtenirDroits($Id_utilisateur)
	{
		$row =  $this->fetchRow($this->select(array('Droits'))
									 ->where('Id_utilisateur = '.$Id_utilisateur));
		return $row->Droits;
	}
	public function exist($Id_utilisateur)
	{
		$row = $this->fetchRow('Id_utilisateur = ' . $Id_utilisateur);
		if (!$row) {
			return false;
		}else {
			return true;
		}
	}


}

