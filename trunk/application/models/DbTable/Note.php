<?php

class Application_Model_DbTable_Note extends Zend_Db_Table_Abstract
{

    protected $_name = 'note';
	protected $_primary = 'Id_note';

	public function ajouterDemande($id_demande, $id_utilisateur, $date_soumission, $contenu)
    {
		$data = array(
			'Id_demande' => $id_demande,
            'Id_utilisateur' => $id_utilisateur,
            'Date_soumission' => $date_soumission,
            'Contenu' => $contenu
        );
        $this->insert($data);

	}
	
	public function afficherNote($id_demande)
	{
	
		$query = $this->select()
			->from(array('n'=>'note'), 
			  array('Id_note', 'Date_soumission', 'Contenu'))
			->where('Id_demande = ?', $id_demande)
			->join(array('u'=>'utilisateur'), 'n.Id_utilisateur=u.Id_utilisateur',
			  array('Login'))
			->order('Date_soumission DESC')
			->setIntegrityCheck(false);
		
		return $this->fetchAll($query);
		
	}

}

