<?php
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');

class Controller extends JController
{
	function display()
	{
		if ( ! JRequest::getCmd( 'view' ) ) {
			JRequest::setVar('view', 'front' );
		}
		parent::display();
	}
}