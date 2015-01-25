<?php

defined('_JEXEC') or die;

jimport('joomla.application.component.model');

class ModelInvite extends JModel
{
	function Invite($email, $friend)
	{
		global $mainframe;
		
		$id=substr(base64_decode($friend), 4);
		
		$db	=& JFactory::getDBO();
		$query = 'SELECT id FROM #__users WHERE email="'.$email.'"';	
		$db->setQuery($query);
		$old_user = $db->loadResult();
	
		if ( $old_user!="" ){
			$mainframe->redirect(JRoute::_('index.php?option=com_coupon&view=friend'),JText::_('User already exist'));
			return false;
		}else{
			$user	=& JFactory::getUser();

			$uri = &JFactory::getURI();
			$url = $uri->toString( array('scheme', 'host', 'port'));
			
			$mailfrom = $user->email;
			$fromname = $user->name;
			$subject2=JText::_('Invite for site');
			$message2='
				<table cellpadding="5" cellspacing="0" width="100%" bgcolor="#CCCCCC">
				<tr>
					<td align="center">
						<table cellpadding="8" cellspacing="0" width="600px" style="text-align:left;background:#fff;">
							<tr>
								<td align="center" colspan="2"><img src="'.JURI::base().'/images/logo.jpg"/></td>
							</tr>
							<tr>
								<td align="center" style="color:#00a0e3;font:bold 18px Tahoma, Geneva, sans-serif;">'.$mailfrom.' '.JText::_('invite for').' <a href="'.JURI::base().'" target="_blank">'.JText::_('Site name').'</a></td>
							</tr>
							<tr>
								<td align="center" style="color:#444;font:bold 18px Tahoma, Geneva, sans-serif;"><br/><br/>'.JText::_('site slogan').'<br/><br/><br/></td>
							</tr>
							<tr>
								<td align="center"><br/><br/><a href="'.$url.JRoute::_('index.php?option=com_coupon&view=registration&friend='.$friend).'" title="'.JText::_('registration').'"><img src="'.JURI::base().'images/registration.jpg" alt="'.JText::_('registration').'"/></a><br/><br/><br/><br/></td>
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
			$mainframe->redirect(JRoute::_('index.php?option=com_coupon&view=friend'),JText::_('Invite send'));
			return false;
		}
	}
}
