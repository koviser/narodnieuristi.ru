<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );
jimport('joomla.html.pane');


class ViewBonus extends JView
{	
	function display($tpl = null)
	{
		$cid		= JRequest::getVar( 'cid', array(0), '', 'array' );				
		$edit		= JRequest::getVar('edit',true);		
		$uid 	= (int) @$cid[0];
		JArrayHelper::toInteger($cid, array(0));
		$db 		=& JFactory::getDBO();
		$bonus =& new JEvents($db);		
		
		if($edit){			
			$bonus->load( $uid );
			
			if($bonus->advertiser>0){
				$query = 'SELECT a.id , a.name, a.family, a.username'
				. ' FROM #__users AS a'
				. ' WHERE a.id='.(int)$bonus->advertiser;
				
				$db->setQuery( $query );
				$user = $db->loadObject();
			}
		}
			
		if ($bonus->dateStart){		
			$dateStart = strtotime($bonus->dateStart);					
		}else{		
			$dateStart = strtotime(date("Y-m-d"));
		}
		
		if ($bonus->dateUsed){		
			$dateUsed = strtotime($bonus->dateUsed);					
		}else{		
			$dateUsed = strtotime(date("Y-m-d"));
		}	
		
		$bonus->clock=str_replace("</li>","\n",$bonus->clock);
		$bonus->clock=str_replace("<li>","",$bonus->clock);
		
		$bonus->terms=str_replace("</li><li>",'<hr id="sys" />',$bonus->terms);
		$bonus->terms=str_replace("</li>","",$bonus->terms);
		$bonus->terms=str_replace("<li>","",$bonus->terms);	
		
		$bonus->features=str_replace("</li><li>",'<hr id="sys" />',$bonus->features);
		$bonus->features=str_replace("</li>","",$bonus->features);
		$bonus->features=str_replace("<li>","",$bonus->features);
		
		$bonus->contacts=str_replace("</li><li>",'<hr id="sys" />',$bonus->contacts);
		$bonus->contacts=str_replace("</li>","",$bonus->contacts);
		$bonus->contacts=str_replace("<li>","",$bonus->contacts);
		
		$bonus->title=str_replace("</span>","",$bonus->title);
		$bonus->title=str_replace("<span>","",$bonus->title);			
			
		$lists['dateStart'] = JHTML::_('calendar', date('Y-m-d', $dateStart), 'dateStart', 'dateStart', $format = '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'20',  'maxlength'=>'19'));
		$lists['dateUsed'] = JHTML::_('calendar', date('Y-m-d', $dateUsed), 'dateUsed', 'dateUsed', $format = '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'20',  'maxlength'=>'19'));
		$lists['published'] = JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $bonus->published);
		$lists['horizontal']=JCouponCommon::bgHorizontal($event->horizontal);	
		$lists['vertical']=JCouponCommon::bgVertical($event->vertical);	
		$lists['repeat']=JCouponCommon::bgRepeat($event->bgrepeat);
		$this->assignRef('lists',$lists);	
		$this->assignRef('event',$bonus);			
		
		parent::display($tpl);
	}
}
?>