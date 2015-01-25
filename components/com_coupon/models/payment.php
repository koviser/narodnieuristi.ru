<?php

defined('_JEXEC') or die;

jimport('joomla.application.component.model');


class ModelPayment extends JModel
{
	function updateBalance($number, $id, $count)//Оплата купона с платежного сайта
	{
		require_once ('administrator'.DS.'components'.DS.'com_coupon'.DS.'classes'.DS.'order.php');
		require_once ('administrator'.DS.'components'.DS.'com_coupon'.DS.'classes'.DS.'event.php');
		require_once ('components'.DS.'com_coupon'.DS.'common.php');
		
		global $mainframe;
			
		$post['id']=$number;
		$post['status']=1;
			
		$db = & JFactory::getDBO();	
			
		$order = &new JOrder($db);
			
		if (!$order->bind( $post )){exit;}
			
		if (!$order->store()){exit;}
		
		$order->load( $order->id );
		
		$password=array();
		$password[]=$order->password;
		
		$event = &new JEvents($db);
		$event->load( $order->id_event );
		if($event->type==1){
			exit();	
		}
		
		$get['count']=$event->count+$count;
		
		if($get['count']>=$event->total && $event->total>0){
			$get['dateEnd']=date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1));
		}
		
		if (!$event->bind( $get )){exit;}
			
		if (!$event->store()){exit;}
		/*
		if($count>1){
			require_once (JPATH_COMPONENT.DS.'common.php');
			$new['email'] = $order->email;
			$new['parent'] = $order->id;
			$new['id_event'] = $order->id_event;
			$new['count'] = 0;
			$new['date']= $order->date;
			$new['status']=1;
			for($i=0;$i<($count-1);$i++){
				$new['password']=JEventsCommon::GetPassword();
				
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
		*/

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
		/*
		$query = 'SELECT name, family, id, friend, friendS, bonus, phone, ref'
			. ' FROM #__users '
			. ' WHERE email = '.$db->Quote($email)
			;
		
		$db->setQuery( $query );
		$user = $db->loadObject();
		*/
		$totalPrice=$count*$event->price;
		$totalBonus=$count*$event->bonus;
		/*
		$query = 'INSERT'
		. ' #__mos_buy_com (userid, price, `date`)'
		. ' VALUES ('.(int)$user->id.', '.$db->Quote($totalPrice).', NOW())'
		;
		$db->setQuery( $query );
		$db->query();
		*/
		/*
		$query = 'INSERT'
		. ' #__mos_transaction (userid, `date`, sum, type, eventid)'
		. ' VALUES ('.(int)$user->id.', NOW(), '.$db->Quote($totalPrice).', 2, '.$event->id.')'
		;
		$db->setQuery( $query );
		$db->query();
		
		if($totalBonus>0){
			$query = 'INSERT'
			. ' #__mos_transaction (userid, `date`, sum, type, eventid)'
			. ' VALUES ('.(int)$user->id.', NOW(), '.$db->Quote($totalBonus).', 11, '.$event->id.')'
			;
			$db->setQuery( $query );
			$db->query();
		}
		*/
		$coupon->title=$event->title.', '.$event->subtitle;
		$coupon->terms='<strong>'.$event->subterms.'</strong><br/><br/>'.$event->info;
		$coupon->image=$event->image;
		//$coupon->name=$order->email;
		$coupon->contacts= $event->contacts;
		$coupon->count=$count;
		$coupon->map='<img height="350" src="http://static-maps.yandex.ru/1.x/?key='.$mainframe->getCfg('yandex_key').'&amp;l=map&amp;zoom='.$map->scale.'&amp;size=650,350&amp;ll='.$map->y.','.$map->x.'&amp;pt='.$map->map.'" width="650" />';
		
		jimport( 'joomla.mail.helper' );
		for($i=0;$i<count($password);$i++){
			$coupon->password=$password[$i];
			if(JMailHelper::isEmailAddress($order->email)){
				// Если введен e-mail
				$coupon->name='Номер '.$password[$i].'<br/><strong>'.$count.' чел.</strong><br/>действует до '.date("d.m.Y",mktime(0,0,0,date("m"),date("d")+5));
				$message=JEventsCommon::getCouponTemplate($coupon);
				JUtility::sendMail($mailfrom, $fromname, $email, $subject, $message, 1);
			}else{
				// Если введен телефон
				if($mainframe->getCfg('sms_login')){
					jimport('smsapi.transport');
					$smsApi = new Transport();
					$text = 'Номер '.$password[$i].', '.$event->title.', '.$event->subtitle.',  '.$count.' чел., действует до '.date("d.m.Y",mktime(0,0,0,date("m"),date("d")+5));
					
					$translit = array(
						"А"=>"A","Б"=>"B","В"=>"V","Г"=>"G",
						"Д"=>"D","Е"=>"E","Ж"=>"J","З"=>"Z","И"=>"I",
						"Й"=>"Y","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N",
						"О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T",
						"У"=>"U","Ф"=>"F","Х"=>"H","Ц"=>"TS","Ч"=>"CH",
						"Ш"=>"SH","Щ"=>"SCH","Ъ"=>"","Ы"=>"YI","Ь"=>"",
						"Э"=>"E","Ю"=>"YU","Я"=>"YA","а"=>"a","б"=>"b",
						"в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
						"з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
						"м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
						"с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
						"ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
						"ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya"
					);
					$text = strtr($text, $translit);
					
					$params = array("text" => $text);
					$phones = array($order->email);
					$send = $smsApi->send($params,$phones);
				}
			}
		}
		//Referal
		/*
			if($user->ref>0){
				$query = 'SELECT balance, partner, reward, id'
				. ' FROM #__users '
				. ' WHERE id = '.(int)$user->ref
				;
			
				$db->setQuery( $query );
				$partner = $db->loadObject();
				if($partner->partner==2){
					JEventsCommon::partnerBonus($user->id, $totalPrice, $partner, 0);
				}else if($partner->partner==3){
					if(!$user->refUse){
						 JEventsCommon::partnerBonus($user->id, $totalPrice, $partner, 1);
					}
				}	
			}
		*/
		//
		/*
		if($user->friend>0 && $user->friendS<1 && $mainframe->getCfg('limit_price')<=($count*$event->price)){
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
}