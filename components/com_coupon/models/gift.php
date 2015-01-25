<?php

defined('_JEXEC') or die;

jimport('joomla.application.component.model');


class ModelGift extends JModel
{
	function send($data)//Функция получение бесплатного купона
	{
		global $mainframe;
		$db = & JFactory::getDBO();
		
		require_once ('administrator'.DS.'components'.DS.'com_coupon'.DS.'classes'.DS.'order.php');
		require_once ('administrator'.DS.'components'.DS.'com_coupon'.DS.'classes'.DS.'event.php');
		require_once ('components'.DS.'com_coupon'.DS.'common.php');
		
		$me	=& JFactory::getUser();
		
		$order = &new JOrder($db);
		$order->load( $data['id']);
		
		$event = &new JEvents($db);
		$event->load( $order->id_event);
		
		if(!$order->id || $order->email!=$me->email || !$order->status || $order->use){
			$mainframe->redirect(JRoute::_('index.php?option=com_user&view=user'), JText::_('ERROR GIFT COUPON'));	
		}
		
		$post['id']=$data['id'];
		$post['email']=$data['email'];
			
		if (!$order->bind( $post )){exit;}
			
		if (!$order->store()){exit;}
		
		$order->load( $order->id );
	
		$fromname = $mainframe->getCfg('fromname');
		$mailfrom = $mainframe->getCfg('mailfrom');
		$email=$order->email;
		$subject=JText::_('Coupon to the').' '.strip_tags($event->title);
		//Email
		require_once (JPATH_COMPONENT.DS.'common.php');
		if($event->realPrice!=0){
			$coupon->cost = $event->realPrice.' '.JText::_('Rub');
		}else{
			$coupon->cost = JText::_('Unlimited');
		}
		///
		$where = array();
		$where[]='a.id_event='.(int)$event->id;
											
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT a.*'
		. ' FROM #__mos_map AS a'
		. $where
		;
		
		$db->setQuery($query);
		$maps = $db->loadObjectList();
	
		if(count($maps)>1){
			$mapsParam=JEventsCommon::GetMap($maps);
			$map->x=$mapsParam['x'];
			$map->y=$mapsParam['y'];
			$map->scale=$mapsParam['scale'];
		}else{
			$map->x=$maps[0]->latitude;
			$map->y=$maps[0]->longitude;
			$map->scale=17;
		}
		$coords=array();
		for($j=0;$j<count($maps);$j++){
			$coords[]=$maps[$j]->longitude.','.$maps[$j]->latitude.',pmblm';
		}
		$map->map=implode("~", $coords);
		///
		$coupon->title=$event->title;
		$coupon->terms=$event->terms;
		$coupon->features=$event->features;
		$coupon->image=$event->image;
		$coupon->name=$data['email'];
		$coupon->family='';
		$coupon->map='<img height="350" src="http://static-maps.yandex.ru/1.x/?key='.$mainframe->getCfg('yandex_key').'&amp;l=map&amp;zoom='.$map->scale.'&amp;size=650,350&amp;ll='.$map->y.','.$map->x.'&amp;pt='.$map->map.'" width="650" />';
		
		$coupon->password=$order->password;
		$message=JEventsCommon::getCouponTemplate($coupon);
		JUtility::sendMail($mailfrom, $fromname, $email, $subject, $message, 1);
		
		$query = 'SELECT a.id'
		. ' FROM #__users AS a'
		. ' WHERE a.email='.$db->Quote($data['email']);
		
		$db->setQuery($query);
		$id = $db->loadResult();
		
		if(!$id){
			$session  = JFactory::getSession();
		
			$email = $data['email'];
			$password = JEventsCommon::GetPassword();
			$password2 = $password;
			$subscribe = 1;
			
			unset($_POST);
			$name=$email;
			
			$_POST['username']=$email;
			$_POST['name']=$name;
			$_POST['email']=$email;
			$_POST['password']=$password;
			$_POST['password2']=$password2;
			$_POST['sendEmail']=$subscribe;
				
			$user 		= new JUser(0);
			$pathway 	=& $mainframe->getPathway();
			$config		=& JFactory::getConfig();
			$authorize	=& JFactory::getACL();
			$document   =& JFactory::getDocument();
		
			if (!$newUsertype) {
				$newUsertype = 'Registered';
			}
		
			if (!$user->bind( JRequest::get('post'), 'usertype' )) {
				$mainframe->redirect(JURI::base(), $user->getError());
				return false;
			}
		
			$user->set('id', 0);
			$user->set('usertype', $newUsertype);
			$user->set('gid', $authorize->get_group_id( '', $newUsertype, 'ARO' ));
		
			$date =& JFactory::getDate();
			$user->set('registerDate', $date->toMySQL());
		
			if ( !$user->save() ){
				$mainframe->redirect(JURI::base(), $user->getError());
				return false;
			}else{
				$fromname = $mainframe->getCfg('fromname');
				$mailfrom = $mainframe->getCfg('mailfrom');
				$subject2=JText::_('ACOUNT DETAILS');
				require_once (JPATH_COMPONENT.DS.'common.php');
				$message2='
					<p style="margin:0px 0px 20px 0px;font-size:18px;line-height:22px;font-weight:bold;">'.JText::_('Welcome to site').' '.$mainframe->getCfg('sitename').'</p>';
				if($user->family!="" || $user->name!=""){
					$message2.='<p style="margin:0px 0px 10px 0px;">'.JText::_('HI').' <b>'.$user->family.' '.$user->name.'</b>!'.JText::sprintf('USER GIFT YOU COUPON', $me->email, $mainframe->getCfg('sitename')).'</p>';
				}
				$message2.='<p style="margin:0px 0px 10px 0px;">'.JText::_('congratulate').' '.$mainframe->getCfg('sitename').'<br/>
					'.JText::_('you Password').' <b>'.$password.'</b>
					</p>
					<p style="margin:0px 0px 10px 0px;">'.JText::_('THANKS YOU').'</p>
					<p style="margin:20px 0px 20px 0px;font-size:18x;line-height:22px;font-weight:bold;">'.JText::_('SITE TEAM').' '.$mainframe->getCfg('sitename').'</p>
				';
				$message2=JEventsCommon::getMailTemplate($message2, 1);
				JUtility::sendMail($mailfrom, $fromname, $email, $subject2, $message2, 1);
			}
		}
		
		$mainframe->redirect(JRoute::_('index.php?option=com_user'), JText::_('GIFT COUPON OK'));
	}
}