<?php

class Application_Model_DbTable_DemandeAffiliation extends Zend_Db_Table_Abstract
{

    protected $_name = 'demande_affiliation';
	protected $_primary = 'Id_demande';

	public function ajouterDemande($id_demande, $nom, $num_siret, $e_mail, $password, $adresse, $telephone, $nombre_employes)
    {
        $data = array(
			'Id_demande' => $id_demande,
            'Nom' => $nom,
            'Num_siret' => (int)$num_siret,
            'E_mail' => $e_mail,
            'Password' => md5($password),
            'Adresse' => $adresse,
            'Telephone' => (int)$telephone,
            'Nombre_employes' => (int)$nombre_employes,
        );
        $this->insert($data);
		
		return true;
    }
	
	public function getDemande($id_demande)
    {
		return $this->fetchRow($this->select()->where('Id_demande = ?', $id_demande));
	}
	
}

