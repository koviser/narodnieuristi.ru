<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );;

class ViewMetro extends JView
{	
	function display($tpl = null)
	{
		$cid		= JRequest::getVar( 'cid', array(0), '', 'array' );				
		$edit		= JRequest::getVar('edit',true);		
		$uid 	= (int) @$cid[0];
		JArrayHelper::toInteger($cid, array(0));
		$db 		=& JFactory::getDBO();
		$metro =& new JMetro($db);		
		
		if($edit) $metro->load( $uid );
		
		$this->assignRef('lists',$lists);	
		$this->assignRef('item',$metro);			
		
		parent::display($tpl);
	}
}
?>