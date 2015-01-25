<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );
jimport('joomla.html.pane');


class ViewEvent extends JView
{	
	function display($tpl = null)
	{	
		$cid		= JRequest::getVar( 'cid', array(0), '', 'array' );				
		$edit		= JRequest::getVar('edit',true);		
		$uid 	= (int) @$cid[0];
		JArrayHelper::toInteger($cid, array(0));
		$db 		=& JFactory::getDBO();
		$event =& new JEvents($db);		
		
		if($edit){			
			$event->load( $uid );
			
			if($event->advertiser>0){
				$query = 'SELECT a.id , a.name, a.family, a.username'
				. ' FROM #__users AS a'
				. ' WHERE a.id='.(int)$event->advertiser;
				
				$db->setQuery( $query );
				$user = $db->loadObject();
			}
		}
			
		if ($event->dateStart){		
			$dateStart = strtotime($event->dateStart);					
		}else{		
			$dateStart = strtotime(date("Y-m-d"));
		}
		
		if ($event->dateEnd){		
			$dateEnd = strtotime($event->dateEnd);					
		}else{		
			$dateEnd = strtotime(date("Y-m-d"));
		}
		
		if ($event->dateUsed){		
			$dateUsed = strtotime($event->dateUsed);					
		}else{		
			$dateUsed = strtotime(date("Y-m-d"));
		}	
			
		//$lists['dateStart'] = JHTML::_('calendar', date('Y-m-d', $dateStart), 'dateStart', 'dateStart', $format = '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'20',  'maxlength'=>'19'));
		//$lists['dateEnd'] = JHTML::_('calendar', date('Y-m-d', $dateEnd), 'dateEnd', 'dateEnd', $format = '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'20',  'maxlength'=>'19'));
		//$lists['dateUsed'] = JHTML::_('calendar', date('Y-m-d', $dateUsed), 'dateUsed', 'dateUsed', $format = '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'20',  'maxlength'=>'19'));
		$lists['published'] = JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $event->published);
		$lists['free'] = JHTML::_('select.booleanlist',  'free', 'class="inputbox"', $event->free);
		$lists['day'] = JHTML::_('select.booleanlist',  'day', 'class="inputbox"', $event->day);
		$lists['type'] = JHTML::_('select.booleanlist',  'type', 'class="inputbox"', $event->type);	
		$lists['category'] 	= JCouponCommon::CategoryCombo($event->catid);
		$lists['min'] 	= JCouponCommon::peopleMinCombo($event->min_count);
		$lists['max'] 	= JCouponCommon::peopleMaxCombo($event->max_count);
		if($event->id && $event->catid){
			$lists['options'] 	= JCouponCommon::getOptions($event->id, $event->catid);
		}
		//$lists['city'] 	= JCouponCommon::CityCombo($event->city);
		//$lists['vip'] = JHTML::_('select.booleanlist',  'vip', 'class="inputbox"', $event->vip);
		//$lists['moneyback'] = JHTML::_('select.booleanlist',  'moneyback', 'class="inputbox"', $event->moneyback);
		//$lists['horizontal']=JCouponCommon::bgHorizontal($event->horizontal);	
		//$lists['vertical']=JCouponCommon::bgVertical($event->vertical);	
		//$lists['repeat']=JCouponCommon::bgRepeat($event->bgrepeat);
		$lists['metro']=JCouponCommon::multipleSelect(explode(',',$event->metro), 'metro');
		$this->assignRef('lists',$lists);	
		$this->assignRef('event',$event);
		$this->assignRef('user',$user);				
		
		parent::display($tpl);
	}
}
?>