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
			$var = explode('\\', $Lien);
			$Lien = "/caisse-retraite/".$var[4]."/".$var[5];
			
			$data = array(
			'Id_courrier' => $Id_courrier,
            'Id_demande' => $Id_demande,
            'Nom_document' => $Nom_document,
			'Date_ajout' => date("Y-m-d H:i:s"),
            'Lien' => $Lien
			);
			$this->insert($data);
		}
		
	 public function getDdocument($id_document)
    {
		return $this->fetchRow($this->select()->where('Id_document = ?', $id_document));
	}

}

