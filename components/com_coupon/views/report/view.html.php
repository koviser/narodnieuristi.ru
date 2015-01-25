<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );
require_once (JPATH_COMPONENT.DS.'common.php');

class ViewReport extends JView
{	
	function display($tpl = null)
	{
		
		global $mainframe;
		
		$params = &$mainframe->getParams('com_coupon');	
		
		$params->set('page_title',	JText::_( 'Report' ));
		$document	= &JFactory::getDocument();
		$document->setTitle( $params->get( 'page_title' ) );
		//
		$this->assignRef('params', $params);	
		parent::display($tpl);
	}
}
?>