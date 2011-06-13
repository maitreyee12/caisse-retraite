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
    public function afficherDroitAction(){
    	
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
}









