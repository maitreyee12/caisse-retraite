<?php

class Application_Model_DbTable_Retraite extends Zend_Db_Table_Abstract
{

    protected $_name = 'retraite';

	public function addRetraite($Montant, $Date_debut)
	{
		$data = array(
			'Montant_mensuel' => $Montant,
			'Date_debut' => $Date_debut	
			);
		$this->insert($data);
	}
	public function getDerniereRetraite()
	{
		$row =  $this->fetchRow(
									$this->select()
									->order('Id_retraite DESC'));
			return $row->Id_retraite;
	}
}

