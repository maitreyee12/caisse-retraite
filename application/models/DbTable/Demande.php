<?php

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
	public function ajouterDemande()
	{
		//$data = array('artiste' => $artiste,'titre' => $titre,);
		//$this->insert($data);
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

	public function ajouterDemandeInformation($identifiant, $num_siret, $e_mail, $password, $adresse, $telephone, $nombre_employes)
    {
        $data = array(
            'Identifiant' => $identifiant,
            'Num_siret' => (int)$num_siret,
            'E_mail' => $e_mail,
            'Password' => md5($password),
            'Adresse' => $adresse,
            'Telephone' => (int)$telephone,
            'Nombre_employes' => (int)$nombre_employes,
        );
        $this->insert($data);
    }
}

