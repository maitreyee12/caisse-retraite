<?php

class Application_Model_DbTable_News extends Zend_Db_Table_Abstract
{

    protected $_name = 'news';

	public function getNews($categorie)
		{
			return $this->fetchAll(
									$this->select()
										 ->where('Valide = ?', true)
										 ->where('Categorie  = ?', $categorie));
		}
		
	public function addNews($categorie, $date, $titre, $resume, $texte, $lien)
		{
			$data = array(
			'Categorie' => $categorie,
            'Date_publication' => $date,
            'Titre' => $titre,
            'Resume' => $resume,
            'Image_lien' => $lien,
            'Texte' => $texte,
            'Valide' => true
			);
			$this->insert($data);
		}
}

