﻿<?php

class Application_Model_DbTable_Entreprise extends Zend_Db_Table_Abstract
{

    protected $_name = 'entreprise';

	public function obtenirEntreprise($Id_utilisateur)
	{
		$Id_utilisateur = (int)$Id_utilisateur;
		$row = $this->fetchRow('Id_utilisateur = ' . $Id_utilisateur);
		if (!$row) {
			throw new Exception("Impossible de trouver l'enregistrement $Id_utilisateur");
		}
		return $row->toArray();
	}
	public function modifierEntreprise($Id_utilisateur, $num_siret, $nom_entreprise, $nombre_salarie, $nombre_cadre, $adresse, $telephone, $e_mail){
		$data = array(
		'Num_siret' => $num_siret,
		'Nom_entreprise' => $nom_entreprise,
		'Nombre_salarie' => $nombre_salarie,
		'Nombre_cadre' => $nombre_cadre,
		'Telephone' => $telephone,
		'Adresse' => $adresse,
		'E_mail' => $e_mail,
		);
		
		$this->update($data, 'Id_utilisateur = '. (int)$Id_utilisateur);
	}
	public function rechercheEntreprise($id, $num_siret, $nom_ent, $adresse, $mail, $tel)
		{
			$query = $this->select(); 
				if($id != null && $id != "")
					{
						$query->where('Id_utilisateur = ?', $id);
					}
				if($num_siret != null && $num_siret != "") 
					{
						$query->where('Num_siret = ?', $num_siret);
					}
				if($nom_ent != null && $nom_ent != "")
					{
						$query->where('Nom_entreprise LIKE ?', '%'.$nom_ent.'%');
					}
				if($adresse != null && $adresse != "")
					{
						 $query->where('Adresse LIKE ?', '%'.$adresse.'%');
					}		
				if($tel  != null && $tel  != "")
					{
						 $query->where('Num_tel  = ?', $tel );
					}		
				if($mail != null && $mail != "")
					{
						 $query->where('E_mail = ?', $mail);
					}				
			return $this->fetchAll($query);
		}
}

