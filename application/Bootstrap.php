﻿<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initViewHelpers()
		{
			$this->bootstrap('layout');
			$layout = $this->getResource('layout');
			$view = $layout->getView();
			
			$view->setHelperPath(APPLICATION_PATH.'/helpers', '');
			ZendX_jQuery::enableView($view);
			
			// Initialize view
			//$view->headMeta()->appendHttpEquiv('Content-Type',
											   'text/html; charset=utf-8');
			//$view->addHelperPath('Zend/Dojo/View/Helper/', 'Zend_Dojo_View_Helper');
			//$view->addHelperPath('application/views/helpers/', 'App_View_Helper');
			//$view->addHelperPath('ZendX/JQuery/View/Helper', 'ZendX_JQuery_View_Helper');
			//Zend_Dojo::enableView($view);
			//Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');
			// Add it to the ViewRenderer
			$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
			$viewRenderer->setView($view);
			//seulement si on utilise d'autres frameworks ajax
			//ZendX_JQuery_View_Helper_JQuery::enableNoConflictMode();
			// Return it, so that it can be stored by the bootstrap
			return $view;
		} 

}

