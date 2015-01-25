<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );
require_once (JPATH_COMPONENT.DS.'common.php');

class ViewFriend extends JView
{	
	function display($tpl = null)
	{
		
		global $mainframe;
		
		$user 		= JFactory::getUser();
		$params = &$mainframe->getParams('com_coupon');	
		
		if ($user->guest==1){
			return JError::raiseError( 403, JText::_( 'Access Forbidden') );
		}
		
		$params->set('page_title',	JText::_( 'Invite friend' ));
		$document	= &JFactory::getDocument();
		$document->setTitle( $params->get( 'page_title' ) );
		//
		$this->assignRef('user', $user);
		$this->assignRef('params', $params);	
		parent::display($tpl);
	}
}
?>