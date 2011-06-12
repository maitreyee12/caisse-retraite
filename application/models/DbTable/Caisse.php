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
	public function modifierCaisse($Id_utilisateur, $nom, $adresse, $telephone){
		
		$data = array(
			'Nom_caisse' => $nom,
			'Adresse' => $adresse,
			'Telephone' => $telephone,
		);
		
		$this->update($data, 'Id_utilisateur = '. (int)$Id_utilisateur);
	}
}

