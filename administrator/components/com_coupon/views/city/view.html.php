<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );;

class ViewCity extends JView
{	
	function display($tpl = null)
	{
		$cid		= JRequest::getVar( 'cid', array(0), '', 'array' );				
		$edit		= JRequest::getVar('edit',true);		
		$uid 	= (int) @$cid[0];
		JArrayHelper::toInteger($cid, array(0));
		$db 		=& JFactory::getDBO();
		$city =& new JCity($db);		
		
		if($edit)			
			$city->load( $uid );
		
		$lists['xml'] = JHTML::_('select.booleanlist',  'xml', 'class="inputbox"', $category->xml);	
		$this->assignRef('lists',$lists);	
		$this->assignRef('item',$city);			
		
		parent::display($tpl);
	}
}
?>