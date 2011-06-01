<?php

class Application_Model_DbTable_Documents extends Zend_Db_Table_Abstract
{

    protected $_name = 'documents';
	
	function ajouterDocument($Id_courrier, $Id_demande, $Nom_document, $Lien)
		{
			$data = array(
			'Id_courrier' => $Id_courrier,
            'Id_demande' => $Id_demande,
            'Nom_document' => $Nom_document,
            'Lien' => $Lien
			);
			$this->insert($data);
		}


}

