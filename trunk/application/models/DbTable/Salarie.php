<?php

class Application_Model_DbTable_Salarie extends Zend_Db_Table_Abstract
{

    protected $_name = 'salarie';

	public function addSalarie($Id_utilisateur, $Id_entreprise, $Salaire, $Nb_trimestres)
		{
			$data = array(
				'Id_utilisateur' => $Id_utilisateur,
				'Id_entreprise' => $Id_entreprise,
				'Salaire' => $Salaire,	
				'Nombre_trimestre' => $Nb_trimestres	
				);
			$this->insert($data);
		}
		
	

}

