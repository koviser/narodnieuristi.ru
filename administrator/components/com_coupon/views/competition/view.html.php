<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );
jimport('joomla.html.pane');


class ViewCompetition extends JView
{	
	function display($tpl = null)
	{
		$cid		= JRequest::getVar( 'cid', array(0), '', 'array' );				
		$edit		= JRequest::getVar('edit',true);		
		$uid 	= (int) @$cid[0];
		JArrayHelper::toInteger($cid, array(0));
		$db 		=& JFactory::getDBO();
		$competition =& new JCompetition($db);		
		
		if($edit){			
			$competition->load( $uid );
		}
			
		if ($competition->dateStart){		
			$dateStart = strtotime($competition->dateStart);					
		}else{		
			$dateStart = strtotime(date("Y-m-d"));
		}
		
		if ($competition->dateEnd){		
			$dateEnd = strtotime($competition->dateEnd);					
		}else{		
			$dateEnd = strtotime(date("Y-m-d"));
		}
		if(!$competition->status){
			$lists['dateStart'] = JHTML::_('calendar', date('Y-m-d', $dateStart), 'dateStart', 'dateStart', $format = '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'20',  'maxlength'=>'19'));
			$lists['dateEnd'] = JHTML::_('calendar', date('Y-m-d', $dateEnd), 'dateEnd', 'dateEnd', $format = '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'20',  'maxlength'=>'19'));
		}
		$lists['published'] = JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $competition->published);
		$lists['type'] = JCouponCommon::CompetitionTypeCombo($competition->type);	
		$lists['bonuslist'] = JCouponCommon::bonusType($competition->bonusType);
		$this->assignRef('lists',$lists);	
		$this->assignRef('competition',$competition);			
		
		parent::display($tpl);
	}
}
?>