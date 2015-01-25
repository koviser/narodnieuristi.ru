<?php	                                       			
defined('_JEXEC') or die();
jimport( 'joomla.application.component.controller' );


class ControllerYandexmap extends JController
{	
	function __construct()
	{					
		parent::__construct();							
	}
	
	function display()
	{			
		JRequest::setVar('view', 'yandexmap');			
		parent::display();
	}	
}