<?php

class Application_Model_DbTable_DemandeAffiliation extends Zend_Db_Table_Abstract
{

    protected $_name = 'demande_affiliation';

	public function ajouterDemande($identifiant, $num_siret, $e_mail, $password, $adresse, $telephone, $nombre_employes)
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

