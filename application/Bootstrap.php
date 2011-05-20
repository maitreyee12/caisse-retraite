<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	protected function _initView()
		{
			// Initialize view
			$view = new Zend_View();
			$view->doctype('XHTML1_STRICT');
			$view->headMeta()->appendHttpEquiv('Content-Type','text/html; charset=utf-8');
			$view->addHelperPath('ZendX/JQuery/View/Helper', 'ZendX_JQuery_View_Helper');
			$viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
			$viewRenderer->setView($view);
			Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
			//ZendX_JQuery::enableView($view);
			// Add it to the ViewRenderer
			//$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
			//$viewRenderer->setView($view);
			//seulement si on utilise d'autres frameworks ajax
			//ZendX_JQuery_View_Helper_JQuery::enableNoConflictMode();
			// Return it, so that it can be stored by the bootstrap
			//return $view;
		} 

	
}
