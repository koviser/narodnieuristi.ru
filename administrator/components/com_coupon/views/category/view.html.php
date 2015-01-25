<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );;

class ViewCategory extends JView
{	
	function display($tpl = null)
	{
		$cid		= JRequest::getVar( 'cid', array(0), '', 'array' );				
		$edit		= JRequest::getVar('edit',true);		
		$uid 	= (int) @$cid[0];
		JArrayHelper::toInteger($cid, array(0));
		$db 		=& JFactory::getDBO();
		$category =& new JCategory($db);		
		
		if($edit){			
			$category->load( $uid );
		}else{
			$category->xml=1;	
		}
		
		$lists['xml'] = JHTML::_('select.booleanlist',  'xml', 'class="inputbox"', $category->xml);	
		$this->assignRef('lists',$lists);	
		$this->assignRef('item',$category);			
		
		parent::display($tpl);
	}
}
?>