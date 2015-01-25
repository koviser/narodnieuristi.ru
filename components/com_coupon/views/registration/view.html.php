<?php
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

class ViewRegistration extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		
		$params = &$mainframe->getParams('com_coupon');	
		
		$params->set('page_title',	JText::_( 'Registration2' ));
		$document	= &JFactory::getDocument();
		$document->setTitle( $params->get( 'page_title' ) );
		
		$session=JFactory::getSession();
		
		if($session->get('socType')>0 && $_GET['social']==1){
			$social=1;
			$post['email']= $session->get('socEmail');
			$post['friend']= $session->get('socFriend');
		}
		//
		$this->assignRef('params', $params);
		$this->assignRef('social', $social);	
		$this->assignRef('post', $post);	
		parent::display($tpl);
	}
}
