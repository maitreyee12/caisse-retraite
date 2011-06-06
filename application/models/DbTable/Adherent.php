<?php

class Application_Model_DbTable_Adherent extends Zend_Db_Table_Abstract
{

    protected $_name = 'adherent';

	public function obtenirAdherent($Id_utilisateur)
	{
		$Id_utilisateur = (int)$Id_utilisateur;
		$row = $this->fetchRow('Id_utilisateur = ' . $Id_utilisateur);
		if (!$row) {
			throw new Exception("Impossible de trouver l'enregistrement $Id_utilisateur");
		}
		return $row->toArray();
	}
	public function modifierAdhérent($Id_utilisateur, $nom, $prenom, $num_SS, $telephone, $adresse, $e_mail){
		
		$data = array(
		'Nom' => $nom,
		'Prenom' => $prenom,
		'NumSS' => $num_SS,
		'Telephone' => $telephone,
		'Adresse' => $adresse,
		'E_mail' => $e_mail,
		);
		
		$this->update($data, 'Id_utilisateur = '. (int)$Id_utilisateur);
	}
}

