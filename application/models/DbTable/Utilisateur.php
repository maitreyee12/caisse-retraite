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
		if($Id_utilisateur != null){
			$row = $this->fetchRow('Id_utilisateur = ' . $Id_utilisateur);
			if (!$row) {
				return false;
			}else {
				return true;
			}
		}
		else{
			return false;
		}
	}
	
	public function addUtilisateur($id_utilisateur, $Nom, $Droits)
		{
			$data = array(
				'id_utilisateur' => $id_utilisateur,
				'Login' => $Nom,
				'Password' => $Nom.$Nom,
				'Droits' => $Droits	
				);
			$this->insert($data);
		}
		
	public function getDerniereId()
		{
			$row =  $this->fetchRow(
									$this->select(array('MAX(Id_utilisateur)'))
											->order('Id_utilisateur DESC')
								);
			return $row->Id_utilisateur;
		}
		
	public function getUtilisateur($Id_utilisateur)
		{
			$Id_utilisateur = (int)$Id_utilisateur;
			$row = $this->fetchRow('Id_utilisateur = ' . $Id_utilisateur);
			if (!$row) {
				throw new Exception("Impossible de trouver l'enregistrement $Id_utilisateur");
			}
			return $row->toArray();
		}
		
	public function getUtilisateurByName($name)
		{
			return $this->fetchRow($this->select()->where('Login  = ?', $name));
		}
	public function editDroit($Id_utilisateur, $Droits){
			$data = array(
				'Droits' => $Droits,
				);
			$this->update($data,'Id_utilisateur = '. (int)$Id_utilisateur);
	}

		
	public function getUtilisateurNotArray($id_utilisateur)
		{
			return $this->fetchRow($this->select()->where('Id_utilisateur  = ?', $id_utilisateur));
		}
		

}

