﻿<?php

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

	public function rechercheAdherent($id, $nom, $prenom, $num_ss, $tel, $email, $adresse, $status)
		{
			$query = $this->select(); 
				if($id != null && $id != "")
					{
						$query->where('Id_utilisateur = ?', $id);
					}
				if($nom != null && $nom != "")
					{
						 $query->where('Nom LIKE ?', '%'.$nom.'%');
					}
				if($prenom != null && $prenom != "")
					{
						 $query->where('Prenom LIKE ?', '%'.$prenom.'%');
					}
				if($num_ss != null && $num_ss != "")
					{
						 $query->where('Num_SS = ?', $num_ss);
					}		
				if($tel != null && $tel != "")
					{
						 $query->where('Telephone = ?', $tel);
					}		
				if($email != null && $email != "")
					{
						 $query->where('E_mail = ?', $email);
					}		
				if($adresse != null && $adresse != "")
					{
						 $query->where('Adresse LIKE ?', '%'.$adresse.'%');
					}		
				if($status != null && $status != "")
					{
						 $query->where('Statut = ?', $status);
					}							
			return $this->fetchAll($query);
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
	public function getAge($Id_utilisateur){
		
		$Id_utilisateur = (int)$Id_utilisateur;
		$row = $this->fetchRow('Id_utilisateur = ' . $Id_utilisateur);
		if (!$row) {
			throw new Exception("Impossible de trouver l'enregistrement $Id_utilisateur");
		}
		$value = $row->toArray();
		
		$datetime1 = new DateTime($value['Date_naissance']);
		$datetime2 = new DateTime();
		$interval = $datetime1->diff($datetime2);
  
		return $interval->format('%y');
	}
	
	public function addAdherent($Id_utilisateur, $Id_carriere, $Id_entreprise, $Nom, $Prenom, $Date_naissance, $NumSS, $Telephone, $E_mail, $Adresse)
		{
			$data = array(
				'Id_utilisateur' => $Id_utilisateur,
				'Id_carriere' => $Id_carriere,
				'Id_entreprise' => $Id_entreprise,
				'Nom' => $Nom,
				'Prenom' => $Prenom,
				'Date_naissance' => $Date_naissance,
				'NumSS' => $NumSS,
				'Telephone' => $Telephone,
				'E_mail' => $E_mail,
				'Adresse' => $Adresse,
				'Statut' => "salarie"	
				);

			$this->insert($data);
		}
	
	public function retraiteAdherent($Id_utilisateur)
	{
		$data = array(
			'Statut' => "retraite"
		);
		
		$this->update($data, 'Id_utilisateur = '. (int)$Id_utilisateur);
	}
		
	public function getAdherent($id_utilisateur)
		{
			return $this->fetchRow($this->select()->where('Id_utilisateur  = ?', $id_utilisateur));
		}
}

