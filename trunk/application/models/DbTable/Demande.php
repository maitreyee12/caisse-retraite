<?php

class Application_Model_DbTable_Demande extends Zend_Db_Table_Abstract
{

    protected $_name = 'demande';
	protected $_primary = 'Id_demande';
    
    public function getDemande($id_demande)
    {
		return $this->fetchRow($this->select()->where('Id_demande = ?', $id_demande));
	}

	public function modifierDemande()
	{
		//$data = array('artiste' => $artiste,'titre' => $titre,);
		//$this->update($data, 'id = '. (int)$id);
	}
	public function supprimerDemande()
	{
		//$this->delete('Num_demande =' . (int)$id);
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
	
	public function getDerniereId(){		
		$row =  $this->fetchRow(
									$this->select(array('MAX(Id_demande)'))
											->order('Id_demande DESC')
								);
		return $row->Id_demande;
	}
	
	public function modifierEtatDemande($id_demande, $etat)
	{
		$data = array(
            'Etat' => $etat,
        );
        $this->update($data, 'Id_demande = '. (int)$id_demande);
		
	}
}

