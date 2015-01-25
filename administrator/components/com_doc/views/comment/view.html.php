<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );


class ViewComment extends JView
{	
	function display($tpl = null)
	{
		$cid		= JRequest::getVar( 'cid', array(0), '', 'array' );				
		$edit		= JRequest::getVar('edit',true);		
		$uid 	= (int) @$cid[0];
		JArrayHelper::toInteger($cid, array(0));
		$db 		=& JFactory::getDBO();
		$item =& new JComments($db);		
		if($edit)				
			$item->load( $uid );					
		
		$this->assignRef('item',$item);
		$this->assignRef('lists',$lists);				
		
		parent::display($tpl);
	}
}
?>