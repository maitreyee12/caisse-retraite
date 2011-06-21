<?php

class CarriereController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function afficherCarriereAction()
    {
        $id_utilisateur = $this->_getParam('id',-1);
        
        if($id_utilisateur != -1){
           	$carriere = new Application_Model_DbTable_Carriere();
        	$this->view->carriere = $carriere->getCarriere($id_utilisateur);
        
        }	
    }

    public function afficherDroitAction()
    {
    	
    	//Ouverture du fichier de configuration pour validation des paramètres
    	$dom = new DomDocument;
  		$dom->load(APPLICATION_PATH."/configs/param.xml");
  		
  		//On récupère les paramètes légauc: Age minimum et nombre de trimestres
  		$legalAgeMin = $dom->getElementsByTagName('agemin')->item(0)->nodeValue;
  		$legalNombreTrimestre = $dom->getElementsByTagName('trimestre')->item(0)->nodeValue;
     		
    	$id_utilisateur = $this->_getParam('id',-1);
        
        if($id_utilisateur != -1){
        	//On récupère les informations de l'adhérent
        	$adhérent = new Application_Model_DbTable_Adherent();
        	$carriere = new Application_Model_DbTable_Carriere();
        	$demande = new Application_Model_DbTable_Demande();
        	
            $age = $adhérent->getAge($id_utilisateur);
            $trimestres = $carriere->getNombreTrimestre($id_utilisateur);
            $demande_depart = $demande->getDemandeDepart($id_utilisateur);
            
            
            if ($age >= $legalAgeMin)
            	$this->view->validAge = true;
            else 
            	$this->view->validAge = false;
            	
            if($trimestres >= $legalNombreTrimestre)
            	$this->view->validTrim = true;
            else
            	$this->view->validTrim = false;
            	
            if($demande_depart != null){
            	$this->view->validDemande = true;
            	$this->view->dateDemande = $demande_depart->Date_demande;
            }else{
            	$this->view->validDemande = false;
            	$this->view->dateDemande = null;
            }
        }
    	
    }

    public function afficherPlanAction()
    {
    	
    //Ouverture du fichier de configuration pour validation des paramètres
    	$dom = new DomDocument;
  		$dom->load(APPLICATION_PATH."/configs/param.xml");
  		
  		//On récupère les paramètes légauc: Age minimum et nombre de trimestres
  		$legalAgeMin = $dom->getElementsByTagName('agemin')->item(0)->nodeValue;
  		$legalNombreTrimestre = $dom->getElementsByTagName('trimestre')->item(0)->nodeValue;
     	$plafond_secu = $dom->getElementsByTagName('plafond')->item(0)->nodeValue;
     	
     	
    	$id_utilisateur = $this->_getParam('id',-1);
        
        if($id_utilisateur != -1){
        	//On récupère les informations de l'adhérent
        	$adhérent = new Application_Model_DbTable_Adherent();
        	$carriere = new Application_Model_DbTable_Carriere();
        	$demande = new Application_Model_DbTable_Demande();
        	
            $age = $adhérent->getAge($id_utilisateur);
            $trimestres = $carriere->getNombreTrimestre($id_utilisateur);
            $demande_depart = $demande->getDemandeDepart($id_utilisateur);
            
            $this->view->Id_utilisateur = $id_utilisateur;
            
            if ($age >= $legalAgeMin)
            	$this->view->validAge = true;
            else 
            	$this->view->validAge = false;
            	
            if($trimestres >= $legalNombreTrimestre)
            	$this->view->validTrim = true;
            else
            	$this->view->validTrim = false;
            	
            if($demande_depart != null){
            	$this->view->validDemande = true;
            	$this->view->demande_depart = $demande_depart;
            }else{
            	$this->view->validDemande = false;
            	$this->view->demande_depart = null;
            }
            if($age >= $legalAgeMin && $trimestres >= $legalNombreTrimestre && $demande_depart != null){
            	//Récupération infos carrière
            	$this->view->adherent = $adhérent->obtenirAdherent($id_utilisateur);
        		$info_carriere = $carriere->getCarriere($id_utilisateur);
        		$this->view->plancarriere = $info_carriere;
        			
            	//Récupération meilleures années
            	$periode = new Application_Model_DbTable_Periode();
            	$annees = $periode->getAnneePlanRetraite($info_carriere->Id_carriere);
            	$this->view->annees = $annees;
            	
            	//Récupération des Points ARRCO/AGIRC de l'adhérent
            	$points_ARRCO = $periode->getSommeARRCO($info_carriere->Id_carriere);
            	$this->view->points_ARRCO = $points_ARRCO;
            	$points_AGIRC = $periode->getSommeAGIRC($info_carriere->Id_carriere);
            	$this->view->points_AGIRC = $points_AGIRC;
            	
            	//Récupération de la valeur des points ARRCO/AGIRC
            	$arrco = $dom->getElementsByTagName('point_arrco')->item(0)->nodeValue;
            	$this->view->arrco = $arrco;
            	$agirc = $dom->getElementsByTagName('point_agirc')->item(0)->nodeValue;
            	$this->view->agirc = $agirc;
            	
            	//Calcul salaire moyen
            	$salaire_total=0;
            	foreach($annees as $keys => $value):
            		$salaire_total +=$value;
            	endforeach;
            	$salaire_moyen = $salaire_total/25/12;
            	
            	$this->view->salaire_moyen = round($salaire_moyen,2);
            	if($salaire_moyen <= $plafond_secu){
            		$this->view->salaire_plafonne = round($salaire_moyen,2);
            	}else{
            		$this->view->salaire_plafonne = round($plafond_secu,2);
            	}
            	
        		 
            }
        }
        
    }

    public function departRetraiteAction()
    {
    	$Id_utilisateur = $this->_getParam('id',-1);
        
        if($Id_utilisateur != -1){
        	//Changer Statut salarié
        	$adherent = new Application_Model_DbTable_Adherent();
        	$adherent->retraiteAdherent($Id_utilisateur);
	        
        	//Calcul du montant retraite
        	//Récupération des Points ARRCO/AGIRC de l'adhérent
        	$carriere = new Application_Model_DbTable_Carriere();
        	$info_carriere = $carriere->getCarriere($Id_utilisateur);
        	$periode = new Application_Model_DbTable_Periode();
           	$points_ARRCO = $periode->getSommeARRCO($info_carriere->Id_carriere);
            $points_AGIRC = $periode->getSommeAGIRC($info_carriere->Id_carriere);

            
            //Récupération de la valeur des points ARRCO/AGIRC
            //Ouverture du fichier de configuration pour validation des paramètres
    		$dom = new DomDocument;
  			$dom->load(APPLICATION_PATH."/configs/param.xml");
  		    $arrco = $dom->getElementsByTagName('point_arrco')->item(0)->nodeValue;
            $agirc = $dom->getElementsByTagName('point_agirc')->item(0)->nodeValue;
            
            //Montant et date de début
            $Montant = round($arrco*$points_ARRCO+$agirc*$points_AGIRC,2);
        	$date = mktime(0,0,0,date("m")+6,date("d"),date("Y"));
        	$Date_debut = date('Y-m-d',$date);
        	            
        	//Créer retraite
        	$retraite = new Application_Model_DbTable_Retraite();
        	$retraite->addRetraite($Montant, $Date_debut);
        	
        	//Modifier carrière
        	$Id_retraite = $retraite->getDerniereRetraite();
        	$carriere->departRetraite($Id_utilisateur, $Date_debut, $Id_retraite);
        	
        	//Changer Etat demande départ en retraite
        	$demande = new Application_Model_DbTable_Demande();
        	$demande_depart = $demande->getDemandeDepart($Id_utilisateur);
        	$Id_demande = $demande_depart->Id_demande;
        	$demande->modifierEtatDemande($Id_demande, 2);
        	
        	//Modification droit utilisateur
        	$utilisateur = new Application_Model_DbTable_Utilisateur();
        	$utilisateur->editDroit($Id_utilisateur, 1);
        }
    }


}













