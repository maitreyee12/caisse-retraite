<?php

class Application_Model_DbTable_DemandeModificationCarriere extends Zend_Db_Table_Abstract
{

    protected $_name = 'demande_modification_carriere';

	public function addModificationCarriere($id_demande, $Date_debut, $Date_fin, $Salaire)
	{
		 $data = array(
		'Id_demande' => $id_demande,
		'Date_debut' => $Date_debut,
		'Date_fin' => $Date_fin,
		'Salaire' => $Salaire
		);
		$this->insert($data);
	
	return true;
	}
	
	public function getDemande($id_demande)
    {
		return $this->fetchRow($this->select()->where('Id_demande = ?', $id_demande));
	}
}

