﻿<?php

class Application_Model_DbTable_Demande extends Zend_Db_Table_Abstract
{

    protected $_name = 'demande';
    
    public function obtenirDemande($id)
	{
		$id = (int)$id;
		$row = $this->fetchRow('Num_demande= ' . $id);
		if (!$row) {
			throw new Exception("Impossible de trouver l'enregistrement $id");
		}
		return $row->toArray();
	}

	public function modifierDemande()
	{
		//$data = array('artiste' => $artiste,'titre' => $titre,);
		//$this->update($data, 'id = '. (int)$id);
	}
	public function supprimerDemande($id)
	{
		$this->delete('Num_demande =' . (int)$id);
	}

	public function ajouterDemande($id_courrier, $id_utilisateur, $commentaires, $date_demande, $etat, $type)
    {
        $data = array(
            'Id_courrier' => $id_courrier,
            'Id_utilisateur' => $id_utilisateur,
            'Commentaires' => $commentaires,
            'Date_demande' => $date_demande,
            'Etat' => $etat,
            'Type' => $type			
        );
        $this->insert($data);
    }
}
