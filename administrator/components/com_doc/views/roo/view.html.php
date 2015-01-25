<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );;

class ViewRoo extends JView
{	
	function display($tpl = null)
	{
		$cid		= JRequest::getVar( 'cid', array(0), '', 'array' );				
		$edit		= JRequest::getVar('edit',true);		
		$uid 	= (int) @$cid[0];
		JArrayHelper::toInteger($cid, array(0));
		$db 		=& JFactory::getDBO();
		$item =& new JRoo($db);		

		if($edit){				
			$item->load( $uid );
		}else{
			$item->latitude=51.768099;
			$item->longitude=55.09735;
		}
		
		if($item->doc_date=='0000-00-00')
			$item->doc_date='';
		if($item->date_procuratory=='0000-00-00')
			$item->date_procuratory='';
		
		$lists['doc_date'] = JHTML::_('calendar', $item->doc_date, 'doc_date', 'doc_date', $format = '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'20',  'maxlength'=>'19'));
		
		$this->assignRef('lists',$lists);	
		$this->assignRef('item',$item);			
		
		parent::display($tpl);
	}
}
?>