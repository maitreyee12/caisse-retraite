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
	
	public function afficherNote($Id_demande){
		$row = $this->fetchRow($this->select()
												->where('Id_demande = ?', $id_demande)
												->order('Date_soumission DESC')
								);
		return $row->toArray();
		
	}

}

