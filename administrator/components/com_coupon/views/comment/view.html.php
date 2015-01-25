<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );;

class ViewComment extends JView
{	
	function display($tpl = null)
	{
		$cid		= JRequest::getVar( 'cid', array(0), '', 'array' );				
		$edit		= JRequest::getVar('edit',true);		
		$uid 	= (int) @$cid[0];
		JArrayHelper::toInteger($cid, array(0));
		$db 		=& JFactory::getDBO();
		$comment =& new JComment($db);		
		
		if($edit)			
			$comment->load( $uid );
		
		$lists['published'] = JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $comment->published);
		
		$this->assignRef('lists',$lists);	
		$this->assignRef('item',$comment);			
		
		parent::display($tpl);
	}
}
?>