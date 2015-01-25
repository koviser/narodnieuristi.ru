<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );


class ViewVariant extends JView
{	
	function display($tpl = null)
	{
		$cid		= JRequest::getVar( 'cid', array(0), '', 'array' );				
		$edit		= JRequest::getVar('edit',true);
		$option_id   = JRequest::getVar('option_id', '',	'int');	
		$uid 	= (int) @$cid[0];
		JArrayHelper::toInteger($cid, array(0));
		$db 		=& JFactory::getDBO();
		$variant =& new JVariant($db);		
		if($edit)				
			$variant->load( $uid );
			
		$where = array();
		$where[] = 'option_id='.$option_id;
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );		
		
		$query = 'SELECT COUNT(a.id)'
		. ' FROM #__mos_option_list AS a'	
		. $where		
		;
		
		$db->setQuery( $query );
		$total = $db->loadResult();					
						
		$this->assignRef('item',$variant);
		$this->assignRef('total',$total);
		$this->assignRef('option_id',$option_id);			
		
		parent::display($tpl);
	}
}
?>