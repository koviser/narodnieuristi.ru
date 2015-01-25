<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );


class ViewBGiftcard extends JView
{	
	function display($tpl = null)
	{
		$cid		= JRequest::getVar( 'cid', array(0), '', 'array' );				
		$edit		= JRequest::getVar('edit',true);		
		$uid 	= (int) @$cid[0];
		JArrayHelper::toInteger($cid, array(0));
		$db 		=& JFactory::getDBO();
		$gift =& new JBGiftcard($db);		
		
		if($edit){			
			$gift->load( $uid );
		}
		
		if ($gift->dateStart){		
			$dateStart = strtotime($gift->dateStart);					
		}else{		
			$dateStart = strtotime(date("Y-m-d"));
		}
		if ($gift->dateEnd){		
			$dateEnd = strtotime($gift->dateEnd);					
		}else{		
			$dateEnd = strtotime(date("Y-m-d"));
		}
		
		$lists['dateStart'] = JHTML::_('calendar', date('Y-m-d', $dateStart), 'dateStart', 'dateStart', $format = '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'20',  'maxlength'=>'19'));
		$lists['dateEnd'] = JHTML::_('calendar', date('Y-m-d', $dateEnd), 'dateEnd', 'dateEnd', $format = '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'20',  'maxlength'=>'19'));
		$this->assignRef('lists',$lists);	
		$this->assignRef('gift',$gift);		
		
		parent::display($tpl);
	}
}
?>