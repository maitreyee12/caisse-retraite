<?php

class Application_Model_DbTable_Carriere extends Zend_Db_Table_Abstract
{

    protected $_name = 'carriere';
    
	public function getCarriere($id_utilisateur)
	{
		return $this->fetchRow($this->select()->where('Id_utilisateur = ?', $id_utilisateur));
	}
	public function getPlanCarriere($Id_utilisateur)
	{
		
	}
	public function addcarriere($Id_carriere, $Id_utilisateur, $Trimestre_cumul, $Points_cumul)
		{
			$data = array(
				'Id_carriere' => $Id_carriere,
				'Id_utilisateur' => $Id_utilisateur,
				'Trimestre_cumul' => $Trimestre_cumul,
				'Points_cumul' => $Points_cumul,
				'Date_depart_retraite' => null,
				'Id_retraite' => null
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
	public function modifierCarriereEnFonctionDesPerdiodes($id_carriere, $trimestre_cumul, $points_cumul)
		{
			$data = array(	'Trimestre_cumul' => (int)$trimestre_cumul,
							'Points_cumul' => (int)$points_cumul);
			$this->update($data, 'Id_carriere = '. (int)$id_carriere);
		}


	public function departRetraite($Id_utilisateur, $Date_depart, $Id_retraite)
	{
		$data = array(
			'Date_depart_retraite' => $Date_depart,
			'Id_retraite' => $Id_retraite,
		);
		
		$this->update($data, 'Id_utilisateur = '. (int)$Id_utilisateur);
	}


}

