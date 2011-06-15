<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
		$model_news = new Application_Model_DbTable_News();
		
		$this->view->news_adherent_employe = $model_news->getNews("adherent_employe");
		$this->view->news_adherent_retraite = $model_news->getNews("adherent_retraite");
		$this->view->news_entreprise = $model_news->getNews("entreprise");
		$this->view->news_groupe = $model_news->getNews("groupe");
    }

    public function mainAdherentEmployeAction()
    {
        // action body
    }

    public function mainAdherentRetraiteAction()
    {
        // action body
    }

    public function mainEntrepriseAction()
    {
        // action body
    }

    public function mainEmployeCaisseAction()
    {
        // action body
    }

    public function mainAutreCaisseAction()
    {
        // action body
    }

    public function mainCnavAction()
    {
        // action body
    }


}

























