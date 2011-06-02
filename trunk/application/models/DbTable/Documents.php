<?php

class Application_Model_DbTable_Documents extends Zend_Db_Table_Abstract
{

    protected $_name = 'documents';
	protected $_primary = 'Id_document';

	
	function afficherDocumentsParDemande($id_demande)
		{
			return $this->fetchAll($this->select()->where('Id_demande = ?', $id_demande));
		}
	
	function ajouterDocument($Id_courrier, $Id_demande, $Nom_document, $Lien)
		{
			$data = array(
			'Id_courrier' => $Id_courrier,
            'Id_demande' => $Id_demande,
            'Nom_document' => $Nom_document,
			'Date_ajout' => date("Y-m-d H:i:s"),
            'Lien' => $Lien
			);
			$this->insert($data);
		}
}

