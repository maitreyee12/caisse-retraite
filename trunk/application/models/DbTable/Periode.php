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
public function getAnneePlanRetraite($id_carriere)
	{
		//Récupération de la date du début de carrière et fin de carrière
		$row =  $this->fetchRow($this->select(array('MIN(Date_debut)'))->where('Id_carriere = ?', $id_carriere)->order('Date_debut ASC'));
		$date_debut = $row->Date_debut;
		$row =  $this->fetchRow($this->select(array('MAX(Date_fin)'))->where('Id_carriere = ?', $id_carriere)->order('Date_fin DESC'));
		$date_fin = $row->Date_fin;
		
		//Boucle debut while(date début< date fin dernière période)
		while($date_debut < $date_fin){
			
			
			//On fabrique la première date
			$temp_date = explode('-',$date_debut);
			$date_debut_temp = $temp_date[0].'-01-01';
			//On récupère l'année courante
			$annee = $temp_date[0];
			//On créé la date de fin de la première année
			$temp_date[0]=$temp_date[0]+1;
			$date_fin_temp = $temp_date[0].'-01-01';
			
			
						
			//->Calculer salaire
			//-->1)Trouver toutes les périodes where dd<Date début<df || dd<date fin<df
			$row = $this->getPeriodeByDate($id_carriere,$date_debut_temp,$date_fin_temp);
			
			//-->2)Somme (salaire*prorata couverture)
			$salaire_annee = 0;
			foreach($row as $periode) :
				
				if($date_debut_temp <= $periode->Date_debut && $periode->Date_debut < $date_fin_temp)
				{
					$salaire = floatval($periode->Salaire_percu);
					$nombre_jour = round((strtotime($date_fin_temp)-strtotime($periode->Date_debut))/(60*60*24));
					$prorata = 100*$nombre_jour/365;	
					//echo "</br>Cas 1 = Salaire de :".$salaire." pour ".$nombre_jour." jours avec un prorata de ".$prorata;
						
				}elseif ($date_debut_temp <= $periode->Date_fin && $periode->Date_fin < $date_fin_temp)
				{
					$salaire = floatval($periode->Salaire_percu);
					$nombre_jour = round((strtotime($periode->Date_fin)-strtotime($date_debut_temp))/(60*60*24));
					$prorata = 100*$nombre_jour/365;	
					//echo "</br>Cas 2 = Salaire de :".$salaire." pour ".$nombre_jour." jours avec un prorata de ".$prorata;		
				}
				//On calcul le salaire de la période concernant l'année et on l'ajoute au salaire déjà existant
				$salaire_annee += $salaire*$prorata/100;
				$liste_annee[$annee] = floatval($salaire_annee);
				//echo print_r($liste_annee)." ";
			endforeach;
			
			//->Date début = date début + 1 ans
			$date_debut = $date_fin_temp;
		}
		
		//On trie le tableau par ordre décroissant de salaire perçu
		//echo "</br>Liste_anne: ".print_r($liste_annee);
		arsort($liste_annee);
		//echo "</br>Asort: ".print_r($liste_annee);
		for($i=0;$i<25;$i++){
			list($key,$val) = each($liste_annee);
			if($key !="" && $val !="")
				$cinq_annee[$key] = round($val,2);
		}
		return $cinq_annee;
		
	}
	public function getPeriodeByDate($id_carriere,$date_debut,$date_fin)
	{
		return $this->fetchAll($this->select()
									->where('Id_carriere = ?', $id_carriere)
									->where("Date_debut >= '$date_debut' AND Date_debut <= '$date_fin'")
									->orwhere("Date_fin >= '$date_debut' AND Date_fin <= '$date_fin'")
		);
		
	}
	public function getSommeARRCO($id_carriere){
		$liste = $this->fetchAll($this->select()
									->where('Id_carriere = ?', $id_carriere));
		$somme= 0;
		
		foreach ($liste as $elem){
			
			$somme+=$elem->Points_ARRCO;
		}
		return $somme;
		
	}
	public function getSommeAGIRC($id_carriere){
		$liste = $this->fetchAll($this->select()
									->where('Id_carriere = ?', $id_carriere));
		$somme= 0;
		
		foreach ($liste as $elem){
			
			$somme+=$elem->Points_AGIRC;
		}
		return $somme;
	}


	public function getDerniereId()
		{
			$row =  $this->fetchRow(
									$this->select(array('MAX(Id_periode)'))
											->order('Id_periode DESC')
								);
			return $row->Id_periode;
		}
		
	public function getPeriode($id_periode)
		{
			return $this->fetchRow($this->select()->where('Id_periode = ?', $id_periode));
		}

}

