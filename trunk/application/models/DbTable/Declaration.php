<?php

class Application_Model_DbTable_Declaration extends Zend_Db_Table_Abstract
{

    protected $_name = 'declaration';

	public function getDeclarationByIdUtilisateur($id_utilisateur)
		{
			$query = $this->select()
			->from(array('de'=>'declaration'), 
			  array('Id_declaration', 'Id_document'))
			->where('Id_utilisateur = ?', $id_utilisateur)
			->join(array('do'=>'documents'), 'de.Id_document=do.Id_document',
			  array('Nom_document', 'Lien', 'Date_ajout'))
			->order('Date_ajout DESC')
			->setIntegrityCheck(false);
		
		return $this->fetchAll($query);
		}
		
	public function addDeclaration($Id_utilisateur, $Id_document)
		{
		
			$data = array(
				'Id_utilisateur' => $Id_utilisateur,
				'Id_document' => $Id_document
				);
			$this->insert($data);
		}
		
}

