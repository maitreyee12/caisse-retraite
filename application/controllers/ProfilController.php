<?php

class ProfilController extends Zend_Controller_Action
{

	public function init()
	{
		/* Initialize action controller here */
	}

	public function indexAction()
	{
			
	}

	public function afficherProfilAction()
	{
		////////////////////////////////////////Test calcul/////////////////////////////////////////////////

		///Init/////
		$tab_all_adh[0]["SALAIRE"] = 25000;
		$type = "cadre";

		
		/////////////////////////////////////////////////////////////////////////////////////////



		//Récupération des droits de l'utilisateur connecté
		$droit_user = Zend_Auth::getInstance ()->getIdentity()->Droits;

		//Si le formulaire est validé en post
		if ($this->getRequest()->isPost()) {

			//On récupère l'id du profil consulté
			$id = $this->_getParam('id', -1);
			if ($id > -1) {
				//récupération des droist du profil consulté
				$utilisateur = new Application_Model_DbTable_Utilisateur();
				$droits = $utilisateur->obtenirDroits($id);

				//Choix du formulaire en fonction du type de profil consulté

				if($droits == 0 || $droits ==1)
				$form = new Application_Form_ProfilAdherent();
				if($droits == 2)
				$form = new Application_Form_ProfilEntreprise();
				if($droits == 3)
				$form = new Application_Form_ProfilEmployeCaisse();
				if($droits == 4)
				$form = new Application_Form_ProfilCaisse();

				$this->view->form = $form;

				//Récupération des valeurs POST
				$formData = $this->getRequest()->getPost();

				//Si les valeurs sont valides
				if ($form->isValid($formData)) {
					//Cas d'un Salarié / retraité
					if($droits == 0 || $droits == 1){
						$id = $form->getValue('Id_utilisateur');
						$nom = $form->getValue('Nom');
						$prenom = $form->getValue('Prenom');
						$num_SS = $form->getValue('NumSS');
						$telephone = $form->getValue('Telephone');
						$adresse = $form->getValue('Adresse');
						$e_mail = $form->getValue('E_mail');


						//Mise à jour des données du Salarié
						$salarie = new Application_Model_DbTable_Adherent();
						$salarie->modifierAdhérent($id, $nom, $prenom, $num_SS, $telephone, $adresse, $e_mail);

						//Mise à jour de ses informations de connexion
						$this->_helper->redirector('accepte','profil',null,array('id' => $id));

					}

					if($droits == 2){
						$id = $form->getValue('Id_utilisateur');
						$num_siret = $form->getValue('Num_siret');
						$nom_entreprise = $form->getValue('Nom_entreprise');
						$nombre_salarie = $form->getValue('Nombre_salarie');
						$nombre_cadre = $form->getValue('Nombre_cadre');
						$adresse = $form->getValue('Adresse');
						$telephone = $form->getValue('Telephone');
						$e_mail = $form->getValue('E_mail');

						//Mise à jour des données du Salarié
						$entreprise = new Application_Model_DbTable_Entreprise();
						$entreprise->modifierEntreprise($id, $num_siret, $nom_entreprise, $nombre_salarie, $nombre_cadre, $adresse, $telephone, $e_mail);

						//Mise à jour de ses informations de connexion
						$this->_helper->redirector('accepte','profil',null,array('id' => $id));

					}
					if($droits == 3){
						$id = $form->getValue('Id_utilisateur');
						$nom = $form->getValue('Nom');
						$prenom = $form->getValue('Prenom');

						//Mise à jour des données du Salarié
						$employeCaisse = new Application_Model_DbTable_EmployeCaisse();
						$employeCaisse->modifierEmploye($id, $nom, $prenom);

						//Mise à jour de ses informations de connexion
						$this->_helper->redirector('accepte','profil',null,array('id' => $id));

					}
					if($droits == 4){
						$id = $form->getValue('Id_utilisateur');
						$nom = $form->getValue('Nom_caisse');
						$adresse = $form->getValue('Adresse');
						$telephone = $form->getValue('Telephone');

						//Mise à jour des données du Salarié
						$caisse = new Application_Model_DbTable_Caisse();
						$caisse->modifierCaisse($id, $nom, $adresse, $telephone);

						//Mise à jour de ses informations de connexion
						$this->_helper->redirector('accepte','profil',null,array('id' => $id));

					}
				} else {

					$form->populate($formData);
				}
			}
		} else {
			$id = $this->_getParam('id', -1);
			if ($id > -1) {

				$utilisateur = new Application_Model_DbTable_Utilisateur();
				$droits = $utilisateur->obtenirDroits($id);
				$this->view->id =$id;
				$this->view->droit_profil =$droits;
				//Affichage du formulaire correspondant au type d'utilisateur
				if($droits == 0 || $droits ==1){
					//Si l'utilisateur est un adhérent
					$form = new Application_Form_ProfilAdherent();
					$this->view->form = $form;
					$adhérent = new  Application_Model_DbTable_Adherent();
					$form->populate($adhérent->obtenirAdherent($id));
				}elseif($droits == 2){
					//Si l'utilisateur est une entreprise
					$form = new Application_Form_ProfilEntreprise();
					$this->view->form = $form;
					$entreprise = new  Application_Model_DbTable_Entreprise();
					$form->populate($entreprise->obtenirEntreprise($id));
				}elseif($droits == 3){
					//Si l'utilisateur est une Employé caisse
					$form = new Application_Form_ProfilEmployeCaisse();
					$this->view->form = $form;
					$employeCaisse = new  Application_Model_DbTable_EmployeCaisse();
					$form->populate($employeCaisse->obtenirEmployeCaisse($id));
				}elseif($droits == 4){
					//Si l'utilisateur est une autre Caisse
					$form = new Application_Form_ProfilCaisse();
					$this->view->form = $form;
					$caisse = new  Application_Model_DbTable_Caisse();
					$form->populate($caisse->obtenirCaisse($id));
				}
			}

		}
	}

	public function accepteAction()
	{
		$id = $this->_getParam('id', -1);

		if ($id > -1) {
			$this->view->Id_utilisateur = $id;
		}
	}


}





