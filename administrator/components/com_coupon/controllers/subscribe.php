<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.controller' );


class ControllerSubscribe extends JController
{	
	function __construct()
	{					
		parent::__construct();							
	}
	
	function display()
	{									   
		JRequest::setVar('view', 'subscribe');				
		parent::display();
	}

	function send(){
		
		global $mainframe;
		
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$db =& JFactory::getDBO();		
		$cid = JRequest::getVar( 'cid', array(), '', 'array' );		
		$test	= JRequest::getVar('test', '0', 'post', 'int' );
		$group	= JRequest::getVar('group', '1', 'post', 'int' );						
		JArrayHelper::toInteger( $cid );
		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'SELECT SUBSCRIBE', true ) );
		}
 
		foreach ($cid as $id)
		{	
			$in[] = $id;
		}
		$in=implode(',',$in);
		
		$orderby = ' ORDER BY a.default DESC, a.dateStart ASC';	
		
		$where = ' WHERE a.id IN('.$in.')';
		$query = 'SELECT a.id, a.sale, a.title, a.image, a.features'
		. ' FROM #__mos_event AS a'						
		. $where
		. $orderby
		;
		
		$db->setQuery( $query);
		$rows = $db->loadObjectList();
		
		if($mainframe->getCfg('sef_rewrite') == 1){
			$url = JURI::root().'component/coupon/event/';
		}else{
			$url = JURI::root().'index.php?option=com_coupon&view=event&id=';
		}

		$result='<table cellpadding="8" cellspacing="0" width="100%">';
		for($i=0;$i<count($rows);$i++){
			$result.= '<tr>';
			$result.= '<td valign="top">';
			$result.='<img src="'.JURI::root().'images/events/thumb_'.$rows[$i]->image.'" />';
			$result.= '</td>';
			$result.= '<td>';
			$result.= '<div style="font:bold 18px Tahoma, Geneva, sans-serif;color:#00a0e3;">'.$rows[$i]->title.'</div>';
			$result.= '<div style="font:bold 18px Tahoma, Geneva, sans-serif;color:#000;">'.JText::_('Sale').': '.$rows[$i]->sale.'%</div>';
			$result.= '<div style="font:normal 14px Tahoma, Geneva, sans-serif;color:#4b4b4b;"><ul>'.$rows[$i]->features.'</ul></div>';
			$result.= '<div><a href="'.$url.$rows[$i]->id.'"><img src="'.JURI::root().'images/more.jpg" border="0" alt="'.JText::_('More').'" /></a></div>';
			$result.= '</td>';
			$result.= '</tr>';
		}
		$result.='</table>';
		
		global $mainframe;
		
		if(count($rows)==1){
			$subject=$rows[0]->title;
		}else{
			$subject= $rows[0]->title.' '.JText::_('AND MORE');
		}
		$message=$result;
	
		$where = ' WHERE a.sendEmail=1 AND a.gid=18';
		$query = 'SELECT a.email'
		. ' FROM #__users AS a'						
		. $where
		;
		
		if($test){
			$where[] = 'a.gid=25';
			$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );		
			
			$query = 'SELECT a.email'
			. ' FROM #__users AS a'						
			. $where
			;
			
			$db->setQuery( $query);
			$users = $db->loadObjectList();
			
			for($i=0;$i<count($users);$i++){
				JUtility::sendMail($mainframe->getCfg('mailfrom'), $mainframe->getCfg('fromname'), $users[$i]->email, strip_tags($subject), $message, 1);
			}
		}else{		
			switch($group){
				case 1:
					break;
				case 2:
					break;
				case 3:
					break;
				case 4:
					$query = 'UPDATE'
					. ' #__users SET lider=0'
					;
					$db->setQuery( $query );
					$db->query();
				
					$pparams = JComponentHelper::getParams ('com_coupon');
				
					$query = 'SELECT SUM(a.sum) AS summa, a.userid'
					. ' FROM #__mos_transaction AS a'
					. ' WHERE a.type=3 OR a.type=2'
					. ' GROUP BY a.userid'
					. ' ORDER BY summa DESC'						
					;
					
					$db->setQuery( $query, 0, $pparams->def('lider_count','10'));
					$lider = $db->loadObjectList();
					
					$count=count($lider);
					if($count>0){
						$whereIn = array();
						for($i=0;$i<$count;$i++){
							$whereIn[] = $lider[$i]->userid;	
						}
						
						$query = 'UPDATE'
						. ' #__users SET lider=1'
						. ' WHERE id IN('.implode(',',$whereIn).')';
						;
						$db->setQuery( $query );
						$db->query();
					}
					break;
				case 5:
					$query = 'UPDATE'
					. ' #__users SET frequent=0'
					;
					$db->setQuery( $query );
					$db->query();
				
					$pparams = JComponentHelper::getParams ('com_coupon');
					
					$day = date("Y-m-d", mktime(0, 0, 0, date("m")  , date("d")-$pparams->def('guest_day','10'), date("Y")));
					
					$query = 'SELECT COUNT(a.userid) AS frequent, a.userid'
					. ' FROM #__mos_visit AS a'
					. ' WHERE a.date>='.$db->Quote($day)
					. ' GROUP BY a.userid'
					. ' ORDER BY frequent DESC'						
					;
					
					$db->setQuery( $query, 0, $pparams->def('guest_count','10'));
					$frequent = $db->loadObjectList();
					
					$count=count($frequent);
					if($count>0){
						$whereIn = array();
						for($i=0;$i<$count;$i++){
							$whereIn[] = $frequent[$i]->userid;	
						}
						
						$query = 'UPDATE'
						. ' #__users SET frequent=1'
						. ' WHERE id IN('.implode(',',$whereIn).')';
						;
						$db->setQuery( $query );
						$db->query();
					}
					break;	
			}
			
			$query = 'INSERT'
			. ' #__mos_maillist (`group`, lastId, `date`, title, message, status)'
			. ' VALUES ('.$group.', 0, NOW(), '.$db->Quote(strip_tags($subject)).', '.$db->Quote($message).', 0)'
			;
			$db->setQuery( $query );
			if (!$db->query()) {
				JError::raiseError(500, $db->getErrorMsg() );
			}
			
			$query = 'UPDATE #__mos_event SET `send_'.$group.'`=1 WHERE id IN ('.$in.')';	
			
			$db->setQuery($query);
			if (!$db->query()) {
				JError::raiseError(500, $db->getErrorMsg() );
			}
		}
		
		$mainframe->redirect('index.php?option=com_coupon&controller=subscribe&view=subscribe', JText::_('SEND OK'));
	}
	
	function test(){
		JRequest::setVar('test', '1');
		$this->send();	
	}
}
?>