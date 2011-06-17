<?php

class Application_Model_DbTable_Rib extends Zend_Db_Table_Abstract
{

    protected $_name = 'rib';

	public function obtenirListeRib($Id_utilisateur){
		return $this->fetchAll($this->select()
									->where('Id_utilisateur = ?',$Id_utilisateur));
	}
	public function obtenirRib($Id_rib){
		$row = $this->fetchRow($this->select()
									->where('Id_RIB = ?',$Id_rib));
		return $row->toArray();
	}
	public function creerRib($id_utilisateur, $Num_compte, $ID_banque, $Num_guichet, $Nom_banque, $Nom_titulaire, $date){
		$data = array(
				'Id_utilisateur' => $id_utilisateur,
				'Num_compte' => $Num_compte,
				'ID_banque' => $ID_banque,
				'Num_guichet' => $Num_guichet,
				'Nom_banque' => $Nom_banque,
				'Nom_titulaire' => $Nom_titulaire,
				'Date' => $date,
			);
			$this->insert($data);
	}
	public function modifierRib($id_rib, $id_utilisateur, $Num_compte, $ID_banque, $Num_guichet, $Nom_banque, $Nom_titulaire, $date){
		$data = array(
				'Id_utilisateur' => $id_utilisateur,
				'Num_compte' => $Num_compte,
				'ID_banque' => $ID_banque,
				'Num_guichet' => $Num_guichet,
				'Nom_banque' => $Nom_banque,
				'Nom_titulaire' => $Nom_titulaire,
				'Date' => $date,
			);
			$this->update($data, 'Id_RIB = '. (int)$id_rib);
	}
}

