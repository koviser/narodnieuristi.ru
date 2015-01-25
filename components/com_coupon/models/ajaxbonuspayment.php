<?php

defined('_JEXEC') or die;

jimport('joomla.application.component.model');


class ModelAjaxBonusPayment extends JModel
{
	function updateBalance($post)//Функция покупки купона за бонусы
	{
		global $mainframe;
		$db = & JFactory::getDBO();	
		
		require_once ('administrator'.DS.'components'.DS.'com_coupon'.DS.'classes'.DS.'order.php');
		require_once ('administrator'.DS.'components'.DS.'com_coupon'.DS.'classes'.DS.'event.php');
		require_once ('components'.DS.'com_coupon'.DS.'common.php');
		
		$user	=& JFactory::getUser();
		
		$event = &new JEvents($db);
		$event->load( $post['id_event']);
		
		if($event->id=="" || $event->type==0){
			$html='
			<div class="modalTop">
				<a class="close"></a>
				<div class="modalheading">'.JText::_('Transfer error').'</div>
			</div>
			<div class="modalText">
				'.JText::_('Transfer error desc').'
			</div>';
			return array('block'=>$html);	
		}
		
		$totalPrice = $event->price;
		
		$query = 'SELECT a.bonus'
		. ' FROM #__users AS a'
		. ' WHERE a.id='.(int)$user->id
		;
		
		$db->setQuery($query);
		$bonus = $db->loadResult();
		$user->set('bonus', $bonus);
		
		if($totalPrice>$user->bonus){
			$html='
			<div class="modalTop">
				<a class="close"></a>
				<div class="modalheading">'.JText::_('not enough bonus').'</div>
			</div>
			<div class="modalText">
				'.JText::_('You not enough bonus').'
			</div>';
			return array('block'=>$html);	
		}else{
			$user->set('bonus', ($user->bonus-$totalPrice))	;
			$query = 'UPDATE'
				. ' #__users'
				. ' SET bonus='.$user->bonus
				. ' WHERE id='.(int)$user->id
				;
				$db->setQuery( $query );
				$db->query();
				
			$query = 'INSERT'
				. ' #__mos_transaction (userid, `date`, sum, type, eventid)'
				. ' VALUES ('.(int)$user->id.', NOW(), '.$db->Quote($totalPrice).', 7, '.$event->id.')'
				;
				$db->setQuery( $query );
				$db->query();
			/*
			if($user->friend>0 && $user->friendS<1 && $mainframe->getCfg('limit_price')<=($totalPrice)){
				$query = 'SELECT balance'
				. ' FROM #__users '
				. ' WHERE id = '.(int)$user->friend
				;
			
				$db->setQuery( $query );
				$balance = $db->loadResult();
				$balance = $balance + $mainframe->getCfg('friend_bonus');
				
				$query = 'UPDATE'
				. ' #__users'
				. ' SET friendS=1'
				. ' WHERE id='.(int)$user->id
				;
				$db->setQuery( $query );
				$db->query();
				
				$query = 'UPDATE'
				. ' #__users'
				. ' SET balance='.$balance
				. ' WHERE id='.(int)$user->friend
				;
				$db->setQuery( $query );
				$db->query();
				
				$query = 'INSERT'
				. ' #__mos_transaction (userid, `date`, sum, type)'
				. ' VALUES ('.(int)$user->friend.', NOW(), '.$mainframe->getCfg('friend_bonus').', 5)'
				;
				$db->setQuery( $query );
				$db->query();
					
			}
			*/
		}

		$post['status']=1;
		$post['date']=date("Y-m-d H:i:s");
		$post['email']=$user->email;
		$post['password']=JEventsCommon::GetPassword($post['id_event']);
		
		$count=1;
			
		$order = &new JOrder($db);
			
		if (!$order->bind( $post )){exit;}
			
		if (!$order->store()){exit;}
		
		$order->load( $order->id );
		
		$password=array();
		$password[]=$order->password;

		$get['count']=$event->count+$count;
		if (!$event->bind( $get )){exit;}
			
		if (!$event->store()){exit;}
		if($count>1){
			require_once (JPATH_COMPONENT.DS.'common.php');
			$new['email'] = $order->email;
			$new['parent'] = $order->id;
			$new['id_event'] = $order->id_event;
			$new['count'] = 0;
			$new['date']= $order->date;
			$new['status']=1;
			for($i=0;$i<($count-1);$i++){
				$new['password']=JEventsCommon::GetPassword($post['id_event']);
				
				$orderNew = &new JOrder($db);
			
				if (!$orderNew->bind( $new ))
				{
					exit;
				}
			
				if (!$orderNew->store())
				{
					exit;
				}
				$password[]=$new['password'];
			}
		}
	
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
		$coupon->name=$user->name;
		$coupon->family=$user->family;
		$coupon->map='<img height="350" src="http://static-maps.yandex.ru/1.x/?key='.$mainframe->getCfg('yandex_key').'&amp;l=map&amp;zoom='.$map->scale.'&amp;size=650,350&amp;ll='.$map->y.','.$map->x.'&amp;pt='.$map->map.'" width="650" />';
		
		for($i=0;$i<count($password);$i++){
			$coupon->password=$password[$i];
			$message=JEventsCommon::getCouponTemplate($coupon);
			
			JUtility::sendMail($mailfrom, $fromname, $email, $subject, $message, 1);
			
			if($user->phone && $mainframe->getCfg('sms_login')){
				jimport('smsapi.transport');
				$smsApi = new Transport();
				$params = array("text" => JText::sprintf('Coupon password', $password[$i]));
				$phones = array($user->phone);
				$send = $smsApi->send($params,$phones);
			}
		}
		$html='
			<div class="modalTop">
				<a class="close"></a>
				<div class="modalheading">'.JText::_('Coupon payment').'</div>
			</div>
			<div class="modalText">
				'.JText::_('Coupon buy desc').'
			</div>';
			return array('block'=>$html, 'balance'=>$user->balance);
	}
}