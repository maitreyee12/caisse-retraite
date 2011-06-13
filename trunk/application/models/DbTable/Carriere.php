<?php

class Application_Model_DbTable_Carriere extends Zend_Db_Table_Abstract
{

    protected $_name = 'carriere';
    
	public function getCarriere($id_utilisateur)
    {
		return $this->fetchRow($this->select()->where('Id_utilisateur = ?', $id_utilisateur));
	}
	public function getNombreTrimestre($Id_utilisateur)
	{
		$row = $this->fetchRow($this->select(array('Trimestre_cumul'))->where('Id_utilisateur = ?', $Id_utilisateur));
		return $row->Trimestre_cumul;
	}


}

