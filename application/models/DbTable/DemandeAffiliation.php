<?php

class Application_Model_DbTable_DemandeAffiliation extends Zend_Db_Table_Abstract
{

    protected $_name = 'demande_affiliation';

	public function ajouterDemande($identifiant, $num_siret, $e_mail, $password, $adresse, $telephone, $nombre_employes)
    {
        $data = array(
            'Identifiant' => $identifiant,
            'Num_siret' => $num_siret,
            'E_mail' => $e_mail,
            'Password' => $password,
            'Adresse' => $adresse,
            'Telephone' => $telephone,
            'Nombre_employes' => $nombre_employes,
        );
        $this->insert($data);
    }
	
}

