<?php

defined('_JEXEC') or die;

jimport('joomla.application.component.model');

class ModelRegistration extends JModel
{
	function registration($email, $friend)
	{
		global $mainframe;
		
		require_once (JPATH_COMPONENT.DS.'common.php');
		unset($_POST);
		if($friend!=""){
			$_POST['friend']=substr(base64_decode($friend), 4);
		}
		$session=JFactory::getSession();
		$password=JEventsCommon::GetPassword();
		$_POST['username']=$email;
		$_POST['name']=$email;
		$_POST['email']=$email;
		$_POST['password']=$password;
		$_POST['password2']=$password;
		$_POST['bonus']=$mainframe->getCfg('start_bonus');
		$_POST['sendEmail']=1;
		$_POST['ref']=$session->get('ref_value');
			
		$user 		= JFactory::getUser();
		$pathway 	=& $mainframe->getPathway();
		$config		=& JFactory::getConfig();
		$authorize	=& JFactory::getACL();
		$document   =& JFactory::getDocument();
	
		if (!$newUsertype) {
			$newUsertype = 'Registered';
		}
	
		if (!$user->bind( JRequest::get('post'), 'usertype' )) {
			JError::raiseError( 500, $user->getError());
		}
	
		$user->set('id', 0);
		$user->set('usertype', $newUsertype);
		$user->set('gid', $authorize->get_group_id( '', $newUsertype, 'ARO' ));
	
		$date =& JFactory::getDate();
		$user->set('registerDate', $date->toMySQL());
	
		if ( !$user->save() ){
			JError::raiseWarning('', JText::_( $user->getError()));
		}else{
			$fromname = $mainframe->getCfg('fromname');
			$mailfrom = $mainframe->getCfg('mailfrom');
			$subject2=JText::_('ACOUNT DETAILS');
			$message2='
				<table cellpadding="5" cellspacing="0" width="100%" bgcolor="#CCCCCC">
				<tr>
					<td align="center">
						<table cellpadding="8" cellspacing="0" width="600px" style="text-align:left;background:#fff;">
							<tr>
								<td align="center" colspan="2"><img src="'.JURI::base().'/images/logo.jpg"/></td>
							</tr>
							<tr>
								<td align="center" style="color:#00a0e3;font:bold 18px Tahoma, Geneva, sans-serif;">'.JText::_('Good afternoon').'</td>
							</tr>
							<tr>
								<td>
									'.JText::_('generate a password').' "<a href="'.JURI::base().'" target="_blank">'.JText::_('Site name').'</a>"<br/><br/>
									'.JText::_('Password').' <b>'.$password.'</b><br/><br/>
									'.JText::_('Recommend that you change it').'<br/><br/><br/><br/>
								</td>
							</tr>
							<tr>
								<td height="50px" style="background:#000;color:#fff000;font:normal 12px Tahoma, Geneva, sans-serif;">'.JText::_('team site').' <a href="'.JURI::base().'" target="_blank" style="color:#fff000;">'.JText::_('Site name2').'</a></td>
							</tr>
						</table>
					</td>
				</tr>
				</table>
			';
			JUtility::sendMail($mailfrom, $fromname, $email, $subject2, $message2, 1);
			
			$session =& JFactory::getSession();
			if($session->get('socType')>0 && $session->get('socLogin')!=""){
				$db		=& JFactory::getDBO();
				
				$query = 'INSERT'
				. ' #__mos_social (username, type, userid)'
				. ' VALUES ('.$db->Quote($session->get('socLogin')).' ,'.(int)$session->get('socType').' ,'.(int)$user->id.')';
				;
				$db->setQuery( $query );
				$db->query();
				
				$session->set('socType', 0);
			}
			
			$mainframe->redirect('index.php',JText::_('View email'));
			return false;
		}
		$mainframe->redirect('index.php');
	}
}
