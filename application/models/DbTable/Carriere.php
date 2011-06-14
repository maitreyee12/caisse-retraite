<?php

class Application_Model_DbTable_Carriere extends Zend_Db_Table_Abstract
{

    protected $_name = 'carriere';
    
	public function getCarriere($id_utilisateur)
		{
			return $this->fetchRow($this->select()->where('Id_utilisateur = ?', $id_utilisateur));
		}
	
	public function addcarriere($Id_carriere, $Id_utilisateur, $Trimestre_cumul, $Points_cumul)
		{
			$data = array(
				'Id_carriere' => $Id_carriere,
				'Id_utilisateur' => $Id_utilisateur,
				'Trimestre_cumul' => $Trimestre_cumul,
				'Points_cumul' => $Points_cumul,
				'Droit_depart' => null
			);
			$this->insert($data);
		}
	
	public function getDerniereId()
		{
			$row =  $this->fetchRow(
									$this->select(array('MAX(Id_carriere)'))
											->order('Id_carriere DESC')
								);
			return $row->Id_carriere;
		}
	public function getNombreTrimestre($Id_utilisateur)
	{
		$row = $this->fetchRow($this->select(array('Trimestre_cumul'))->where('Id_utilisateur = ?', $Id_utilisateur));
		return $row->Trimestre_cumul;
	}


}

