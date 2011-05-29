<?php

class Application_Model_DbTable_Periode extends Zend_Db_Table_Abstract
{

    protected $_name = 'periode';
    
	public function obtenirPeriodes($id_carriere)
    {
		return $this->fetchAll($this->select()->where('Id_carriere = ?', $id_carriere));
	}


}

