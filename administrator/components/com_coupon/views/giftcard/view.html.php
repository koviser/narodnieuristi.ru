<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );


class ViewGiftcard extends JView
{	
	function display($tpl = null)
	{
		$cid		= JRequest::getVar( 'cid', array(0), '', 'array' );				
		$edit		= JRequest::getVar('edit',true);		
		$uid 	= (int) @$cid[0];
		JArrayHelper::toInteger($cid, array(0));
		$db 		=& JFactory::getDBO();
		$gift =& new JGiftcard($db);		
		
		if($edit){			
			$gift->load( $uid );
		}
		
		if ($gift->dateUsed){		
			$dateUsed = strtotime($gift->dateUsed);					
		}else{		
			$dateUsed = strtotime(date("Y-m-d"));
		}		
			
		$lists['published'] = JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $gift->published);
		$this->assignRef('lists',$lists);	
		$this->assignRef('gift',$gift);		
		
		parent::display($tpl);
	}
}
?>