<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );;

class ViewOption extends JView
{	
	function display($tpl = null)
	{
		$cid		= JRequest::getVar( 'cid', array(0), '', 'array' );				
		$edit		= JRequest::getVar('edit',true);		
		$uid 	= (int) @$cid[0];
		JArrayHelper::toInteger($cid, array(0));
		$db 		=& JFactory::getDBO();
		$option =& new JOption($db);		
		
		if($edit){				
			$option->load( $uid );
			
			$where = array();
			$where[] = 'option_id='.$option->id;
			$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );	
			
			$query = 'SELECT COUNT(a.id)'
			. ' FROM #__mos_option_list AS a'	
			. $where		
			;		
			
			$db->setQuery( $query );
			$total = $db->loadResult();
			if($total==""){
				$total=0;	
			}
		}
		
		$lists['category'] 	= JCouponCommon::CategoryCombo($option->catid);
		
		$this->assignRef('lists',$lists);	
		$this->assignRef('item',$option);
		$this->assignRef('total', $total);			
		
		parent::display($tpl);
	}
}
?>