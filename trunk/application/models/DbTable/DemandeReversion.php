<?php

class Application_Model_DbTable_DemandeReversion extends Zend_Db_Table_Abstract
{

    protected $_name = 'demande_reversion';

	public function ajouterDemande($id_demande, $nom_dcd, $prenom_dcd, $num_ss_dcd, $nom_benef, $prenom_benef, $num_ss_benef,  $lien_parente, $adresse,  $telephone, $e_mail)
		{
			$data = array(
			'Id_demande' => (int)$id_demande,
            'Nom_utilisateur_dec' => $nom_dcd,
            'Prenom_utilisateur_dec' => $prenom_dcd,
            'Num_SS_utilisateur_dec' => $num_ss_dcd,
            'Nom_beneficiare' => $nom_benef,
            'Prenom_beneficiare' => $prenom_benef,
            'Num_SS_beneficiare' => $num_ss_benef,
            'Lien_parente' => $lien_parente,
            'Adresse' => $adresse,
            'Telephone' => $telephone,
            'E_mail' => $e_mail
			);
			$this->insert($data);
			
			return true;
		}

	public function getDemande($id_demande)
    {
		return $this->fetchRow($this->select()->where('Id_demande = ?', $id_demande));
	}
}

