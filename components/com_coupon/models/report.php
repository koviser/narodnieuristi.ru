<?php

defined('_JEXEC') or die;

jimport('joomla.application.component.model');

class ModelReport extends JModel
{
	function Send($email, $password)
	{
		global $mainframe;
		
		$db	=& JFactory::getDBO();
		$query = 'SELECT id, title FROM #__mos_event WHERE email="'.$email.'" AND password="'.$password.'"';	
		$db->setQuery($query);
		$event = $db->loadObject();
	
		if ( $event->id=="" || $email=="" || $password=="" ){
			$mainframe->redirect(JRoute::_('index.php?option=com_coupon&view=report'),JText::_('Password or login incorrect'));
			return false;
		}else{
			
			$report='<table cellspacing="0" cellpadding="5" width="100%" border="1px">
			  <tr>
				<td colspan="4">'.JText::_('Date created').' '.date("Y-m-d H:j:s").'</td>
			  </tr>
			  <tr>
				<td colspan="4"></td>
			  </tr>
			  <tr>
				<td colspan="4" align="center"><strong>'.JText::_('Sale report').' '.JText::_('on event').' "'.$event->title.'"</strong></td>
			  </tr>
			  <tr>
				<td colspan="4"></td>
			  </tr>
			  <tr>
				<td align="center">'.JText::_('NN').'</td>
				<td align="center">'.JText::_('Date payment').'</td>
				<td align="center">'.JText::_('Email saler').'</td>
				<td align="center">'.JText::_('Coupon code').'</td>
			  </tr>';
			  
			$query = 'SELECT date, email, password FROM #__mos_order WHERE id_event="'.(int)$event->id.'" AND status=1';	
			$db->setQuery($query);
			$order = $db->loadObjectList();
			
			$n=count($order);
			
			if($n==0){
				$report.='<tr>
					<td align="center" colspan="4">'.JText::_('No coupon').'</td>
				</tr>';
			}else{
				for($i=0;$i<$n;$i++){
					$j=$i+1;
					$report.='<tr>
						<td align="center">'.$j.'</td>
						<td align="center">'.$order[$i]->date.'</td>
						<td>'.$order[$i]->email.'</td>
						<td align="center">'.$order[$i]->password.'</td>
					  </tr>';
				}
			}
			  
			$report .= '</table><br/><br/>';
			
			
			$mailfrom = $mainframe->getCfg('mailfrom');
			$fromname = $mainframe->getCfg('fromname');;
			$subject=JText::_('Sale report');
			$message='
				<table cellpadding="5" cellspacing="0" width="100%" bgcolor="#CCCCCC">
				<tr>
					<td align="center">
						<table cellpadding="8" cellspacing="0" width="600px" style="text-align:left;background:#fff;">
							<tr>
								<td align="center" colspan="2"><img src="'.JURI::base().'/images/logo.jpg"/></td>
							</tr>
							<tr>
								<td>'.$report.'</td>
							</tr>
							<tr>
								<td height="50px" style="background:#000;color:#fff000;font:normal 12px Tahoma, Geneva, sans-serif;">'.JText::_('team site').' <a href="'.JURI::base().'" target="_blank" style="color:#fff000;">'.JText::_('Site name2').'</a></td>
							</tr>
						</table>
					</td>
				</tr>
				</table>
			';

			JUtility::sendMail($mailfrom, $fromname, $email, $subject, $message, 1);
			$mainframe->redirect(JRoute::_('index.php'),JText::_('Report send'));
			return false;
		}
	}
}
