<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.controller' );


class ControllerMassmail extends JController
{	
	function __construct()
	{					
		parent::__construct();							
	}
	
	function display()
	{									   
		JRequest::setVar('view', 'massmail');			
		parent::display();
	}

	function send(){
		global $mainframe;
		
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		$db =& JFactory::getDBO();		
		$subject		= JRequest::getVar('mm_subject', '', 'string' );
		$message		= JRequest::getVar('mm_message','', 'post',	'string', JREQUEST_ALLOWRAW);
		$group			= JRequest::getVar('group','', 'post',	'int');
		$test			= JRequest::getVar('test', '0', 'post', 'int' );	
		
		if($subject=="" || $message==""){
			$mainframe->redirect('index.php?option=com_coupon&controller=massmail&view=massmail', JText::_('NOT ALL FIELD INPUT'));
			return false;	
		}
		
		require_once ('..'.DS.'components'.DS.'com_coupon'.DS.'common.php');
		
		$message=JEventsCommon::getMailTemplate($message, 1);
		
		$where = array();
		
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
		}
		$mainframe->redirect('index.php?option=com_coupon&controller=massmail&view=massmail', JText::_('SEND OK'));
	}
	
	function test(){
		JRequest::setVar('test', '1');
		$this->send();	
	}
}
?>


