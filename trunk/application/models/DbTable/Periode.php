<?php

class Application_Model_DbTable_Periode extends Zend_Db_Table_Abstract
{

    protected $_name = 'periode';
    
	public function obtenirPeriodes($id_carriere)
    {
		return $this->fetchAll($this->select()->where('Id_carriere = ?', $id_carriere));
	}
	
	public function addPeriode($id_periode, $id_carriere, $date_debut, $date_fin, $nom_ent, $Salaire_percu, $Points_ARRCO, $Points_AGIRC)
		{
			echo $date_fin;
			$data = array(
				'Id_periode' => (int)$id_periode,
				'Id_carriere' => (int)$id_carriere,
				'Date_debut' =>$date_debut,
				'Date_fin' => $date_fin,
				'Nom_Entreprise' => $nom_ent,
				'Salaire_percu' => (int)$Salaire_percu,
				'Points_ARRCO' => (int)$Points_ARRCO,
				'Points_AGIRC' => (int)$Points_AGIRC	
				);
			$this->insert($data);
		}

	public function getDerniereId()
		{
			$row =  $this->fetchRow(
									$this->select(array('MAX(Id_periode)'))
											->order('Id_periode DESC')
								);
			return $row->Id_periode;
		}

}

