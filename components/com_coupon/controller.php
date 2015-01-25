<?php
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');

class Controller extends JController
{
	function display()
	{
		if ( ! JRequest::getCmd( 'view' ) ) {
			JRequest::setVar('view', 'front' );
		}
		parent::display();
	}
	function addComment()
	{
		$post['message'] = JRequest::getVar( 'message', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$post['id_event'] = JRequest::getVar( 'id_event', '', 'post', 'int');
		
		if($post['message']!="" && $post['id_event']!=""){
			
			require_once ('administrator'.DS.'components'.DS.'com_coupon'.DS.'classes'.DS.'comment.php');
			
			$session  = JFactory::getSession();
			$user = $session->get('user');
			
			if($user->name!="" && $user->name!=$user->email){
				$post['user']=$user->name;
			}else if($user->name=="" && $user->email!=""){
				$name=explode('@', $user->email);
				$post['user'] = substr($name[0], 0, 3).'***@'.$name[1];
			}else{
				$post['user']=JText::_('Guest');
			}
			$post['published']=1;
			$post['dateQ']=date("Y-m-d H:i:s");
			
			$db = & JFactory::getDBO();	
			
			$comment = &new JComment($db);
			
			if (!$comment->bind( $post ))
			{
				exit;
			}
			
			if (!$comment->store())
			{
				exit;
			}	
			
			echo '<div class="sys-message">'.JText::_('Comment save').'</div>';
		}else{
			echo '<div class="sys-error">'.JText::_('Enter comment').'</div>';
		}
		
		exit;
	}
	
	function moneyback()
	{
		global $mainframe;
		
		$post['desc'] = JRequest::getVar( 'desc', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$post['code'] = JRequest::getVar( 'code', '', 'post', 'int');
		
		if($post['code']){
			require_once (JPATH_COMPONENT.DS.'common.php');
			$db = & JFactory::getDBO();
			
			$query = 'SELECT a.id'
			. ' FROM #__mos_order AS a'
			. ' WHERE a.status=1 AND a.use=0 AND a.password='.$db->Quote($post['code']);
			;
			
			$db->setQuery($query);
			$id = $db->loadResult();
			if($id){
				$fromname = $mainframe->getCfg('fromname');
				$mailfrom = $mainframe->getCfg('mailfrom');
				$subject = 'Заявка на возврат денег';
				$message='
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
									<strong>Номер транзакции :</strong>'.$id.'<br/>
									<strong>Номер купона :</strong>'.$post['code'].'<br/>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				</table>
			';
			JUtility::sendMail($mailfrom, $fromname, $mailfrom, $subject, $message, 1);
			echo '<span class="red">Деньги отправлены на ваш счет</span>';	
			}else{
				echo '<span class="red">Проверьте, что номер указан правильно</span>';		
			}
		}else{
			echo '<span class="red">Пожалуйста, заполните все поля</span>';	
		}
		
		exit;
	}
	
	function newOrder()
	{
		global $mainframe;
		
		$post= JRequest::get( 'post' );
		
		if($post['id_type'] && $post['client_name'] && $post['client_phone']){
			require_once ('administrator'.DS.'components'.DS.'com_doc'.DS.'classes'.DS.'client.php');
			$db = & JFactory::getDBO();
			
			$post['id_category'] = 2;
			$post['date_admission'] = date("Y-m-d H:i:s");
			
			$order = &new JClient($db);
					
			if (!$order->bind( $post )){exit;}	
			if (!$order->store()){exit;}
			
			$roo = array(17=>'Ижевск', 16=>'Казань', 20=>'Калуга', 13=>'Краснодар',22=>'Нижнекамск',19=>'Орел',21=>'Рязань',18=>'Чебоксары');
			$types = array(4=>'Застройщики',5=>'Иные дела', 3=>'КАСКО',1=>'Комиссии',2=>'ОСАГО');

			$fromname = $mainframe->getCfg('fromname');
			$mailfrom = $mainframe->getCfg('mailfrom');
			$subject = 'Заявка';
			$message='
				<strong>Поступила новая заявка</strong><br/>
				<strong>Ф.И.О.:</strong>'.$post['client_name'].'<br/>
				<strong>Телефон:</strong>'.$post['client_phone'].'<br/>
				<strong>Регион:</strong>'.$roo[$post['id_roo']].'<br/>
				<strong>Тип:</strong>'.$types[$post['id_type']].'<br/>
				
				<a href="http://narodnieuristi.ru/administrator/index.php?option=com_doc&amp;controller=client&amp;view=client&amp;task=edit&amp;cid[]='.$order->id.'">Посмотреть заявку</a>
			';
			JUtility::sendMail($mailfrom, $fromname, $mailfrom, $subject, $message, 1);
			echo '<span class="red">Ваша заявка передана менеджеру</span>';	
		}else{
			echo '<span class="red">Пожалуйста, заполните все поля</span>';	
		}
		
		exit;
	}
	
	function newPayment()
	{	
		$post['email'] = JRequest::getVar( 'email', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$post['id_event'] = JRequest::getVar( 'id_event', '', 'post', 'int');
		$post['count'] = JRequest::getVar( 'count', '', 'post', 'int');

		if($post['id_event']!="" && $post['email']!="" && $post['count']>0){
			
			$db = & JFactory::getDBO();
			
			require_once ('administrator'.DS.'components'.DS.'com_coupon'.DS.'classes'.DS.'order.php');
			require_once (JPATH_COMPONENT.DS.'common.php');
			
			$query = 'SELECT a.count, a.total, a.free'
			. ' FROM #__mos_event AS a'
			. ' WHERE a.id='.(int)$post['id_event']
			;
			
			$db->setQuery($query);
			$event = $db->loadObject();
			
			if($event->total>0 && ($event->total<($event->count+$post['count']))){
				$response = array('error' => '<div class="modalTop"><a class="close"></a><div class="modalheading">'.JText::_('Error').'</div></div><div class="modalText">'. JText::_('coupon limit').'</div>');	
			}else{
				$post['date']=date("Y-m-d H:i:s");
				$post['status']=0;
				$post['password']=JEventsCommon::GetPassword();
					
				$order = &new JOrder($db);
					
				if (!$order->bind( $post )){exit;}
					
				if (!$order->store()){exit;}
				
				if($event->free){
					$model = &$this->getModel('Payment');
					$model->updateBalance($order->id, $post['id_event'], $post['count']);
					$response = array('message' => 'На указанный вами адрес отправлен купон');
				}else{
					$response = array('id' => $order->id);
				}
			}
		}else{
			$response = array('error' => '<div class="modalTop"><a class="close"></a><div class="modalheading">'.JText::_('Error').'</div></div><div class="modalText">'. JText::_('forwarding to seller').'</div>');
		}
		echo json_encode($response);
		exit;
	}
	/*
	function newAjaxPayment()
	{
		$post['id_event'] = JRequest::getVar( 'id_event', '', 'post', 'int');
		$post['count'] = JRequest::getVar( 'count', '', 'post', 'int');
		$user	=& JFactory::getUser();
		
		if($post['id_event']!="" && $post['count']>0 && $user->id>0){
			$db = & JFactory::getDBO();
			
			$query = 'SELECT a.count, a.total'
			. ' FROM #__mos_event AS a'
			. ' WHERE a.id='.(int)$post['id_event']
			;
			
			$db->setQuery($query);
			$event = $db->loadObject();
			
			if($event->total>0 && ($event->total<($event->count+$post['count']))){
				$response = array('block' => '<div class="modalTop"><a class="close"></a><div class="modalheading">'.JText::_('Error').'</div></div><div class="modalText">'. JText::_('coupon limit').'</div>');	
			}else{
				$model = &$this->getModel('ajaxpayment');
				$response = $model->updateBalance($post);
			}
		}else{
			$html='
			<div class="modalTop">
				<a href="#" class="close"></a>
				<div class="modalheading">'.JText::_('Transfer error').'</div>
			</div>
			<div class="modalText">
				'.JText::_('Transfer error desc').'
			</div>';
			$response = array('block'=>$html);
		}
		echo json_encode($response);
		exit();
	}
	
	function newAjaxBonusPayment()
	{
		$post['id_event'] = JRequest::getVar( 'id_event', '', 'post', 'int');
		jimport( 'joomla.mail.helper' );
		$user	=& JFactory::getUser();
		
		if($post['id_event']!="" && $user->id>0){
			$db = & JFactory::getDBO();
			
			$query = 'SELECT a.count, a.total'
			. ' FROM #__mos_event AS a'
			. ' WHERE a.id='.(int)$post['id_event']
			;
			
			$db->setQuery($query);
			$event = $db->loadObject();
			
			if($event->total>0 && ($event->total<($event->count+1))){
				$response = array('block' => '<div class="modalTop"><a class="close"></a><div class="modalheading">'.JText::_('Error').'</div></div><div class="modalText">'. JText::_('coupon limit').'</div>');	
			}else{
				$model = &$this->getModel('ajaxbonuspayment');
				$response = $model->updateBalance($post);
			}
		}else{
			$html='
			<div class="modalTop">
				<a href="#" class="close"></a>
				<div class="modalheading">'.JText::_('Transfer error').'</div>
			</div>
			<div class="modalText">
				'.JText::_('Transfer error desc').'
			</div>';
			$response = array('block'=>$html);
		}

		echo json_encode($response);
		exit();
	}
	*/
	function robokassa()
	{
		global $mainframe;
		
		$webmoneyAnswer->summ = JRequest::getVar( 'OutSum', '', 'post', 'string');
		$webmoneyAnswer->inv = JRequest::getVar( 'InvId', '0', 'post', 'int');//Номер заказа
		$webmoneyAnswer->id = JRequest::getVar( 'Shp_item', '', 'post', 'int');//Позиция заказа
		$webmoneyAnswer->num = JRequest::getVar( 'shpnum', '1', 'post', 'int');
		$webmoneyAnswer->code = JRequest::getVar( 'SignatureValue', '', 'post', 'string');
		$webmoneyAnswer->code = strtoupper($webmoneyAnswer->code);
		$webmoney->password_2 = $mainframe->getCfg('wm_password_2');
		$webmoney->code  = md5($webmoneyAnswer->summ.':'.$webmoneyAnswer->inv.':'.$webmoney->password_2.':Shp_item='.$webmoneyAnswer->id.':shpnum='.$webmoneyAnswer->num);
		
		if ($webmoneyAnswer->code != strtoupper($webmoney->code))
		{
			exit();
		}else{
			if($webmoneyAnswer->num==0){
				$model = &$this->getModel('ajaxpayment');
				$model->balance($webmoneyAnswer->id, $webmoneyAnswer->summ);
			}else{
				$model = &$this->getModel('Payment');
				$model->updateBalance($webmoneyAnswer->inv, $webmoneyAnswer->id, $webmoneyAnswer->num);
			}
			echo 'OK'.$webmoneyAnswer->inv;
			exit;
		}
	}
	function registration()
	{
		global $mainframe;
		
		$email = JRequest::getVar( 'email', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$friend = JRequest::getVar( 'friend', '', 'post', 'string', JREQUEST_ALLOWRAW );
		
		$model = &$this->getModel('Registration');
		$model->registration($email, $friend);
	}
	function bonusPayment()
	{
		global $mainframe;
		
		$post['id_event'] = JRequest::getVar( 'id_event', '', 'post', 'int');
		
		if ($post['id_event']!="")
		{
			$model = &$this->getModel('Payment');
			$model->payment($post);
			$mainframe->redirect('index.php?option=com_user', JText::_('BUY BONUS OK'));
			return false;
		} else {
			$mainframe->redirect('index.php', JText::_('ERROR BUY BONUS'));
		}
	}
	function invite()
	{		
		$email = JRequest::getVar( 'email', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$friend = JRequest::getVar( 'friend', '', 'post', 'string', JREQUEST_ALLOWRAW );
		
		$model = &$this->getModel('Invite');
		$model->invite($email, $friend);
	}
	function report()
	{
		global $mainframe;
		
		$email = JRequest::getVar( 'email', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$password = JRequest::getVar( 'password', '', 'post', 'string', JREQUEST_ALLOWRAW );
		
		$model = &$this->getModel('Report');
		$model->send($email, $password);
	}
	
	function giftcard()
	{
		global $mainframe;
		$user = JFactory::getUser();
		$code = JRequest::getVar( 'code', '', 'post', 'string');
		
		if($user->id && $code){
			$db = & JFactory::getDBO();
			
			$query = 'SELECT a.nominal, a.id'
			. ' FROM #__mos_giftcard_csv AS a'
			. ' WHERE a.password='.$db->Quote($code).' AND published=1 AND used=0';
			;
			
			$db->setQuery($query);
			$row = $db->loadObject();
			
			if($row->nominal){
				$balance=$user->balance+$row->nominal;
		
				$query = 'UPDATE'
				. ' #__mos_giftcard_csv'
				. ' SET used=1'
				. ' WHERE id='.(int)$row->id
				;
				$db->setQuery( $query );
				$db->query();
				
				$query = 'UPDATE'
				. ' #__users'
				. ' SET balance='.$balance
				. ' WHERE id='.(int)$user->id
				;
				$db->setQuery( $query );
				$db->query();
				
				$query = 'INSERT'
				. ' #__mos_transaction (userid, `date`, sum, type, eventid)'
				. ' VALUES ('.(int)$user->id.', NOW(), '.$db->Quote($row->nominal).', 8, '.(int)$row->id.')'
				;
				$db->setQuery( $query );
				$db->query();
				
				$mainframe->redirect(JRoute::_('index.php?option=com_user&view=user&layout=giftcard'), JText::_('CARD USED'));
			}else{
				$mainframe->redirect(JRoute::_('index.php?option=com_user&view=user&layout=giftcard'), JText::_('CARD NOT EXIST'));
			}
		}else{
			$mainframe->redirect(JRoute::_('index.php?option=com_user&view=user&layout=giftcard'), JText::_('CARD NOT EXIST'));
		}
	}
	
	function bgiftcard()
	{
		global $mainframe;
		$user = JFactory::getUser();
		$code = JRequest::getVar( 'code', '', 'post', 'string');
		
		if($user->id && $code){
			$db = & JFactory::getDBO();
			
			$query = 'SELECT a.nominal, a.id, a.count'
			. ' FROM #__mos_bgiftcard AS a'
			. ' WHERE a.password='.$db->Quote($code).' AND dateStart<='.$db->Quote(date('Y-m-d')).' AND dateEnd>='.$db->Quote(date('Y-m-d'));
			;
			
			$db->setQuery($query);
			$row = $db->loadObject();
			
			if($row->nominal){
				$query = 'SELECT a.cardid'
				. ' FROM #__mos_bgiftcard_use AS a'
				. ' WHERE a.cardid='.(int)$row->id.' AND userid='.(int)$user->id;
				;
				
				$db->setQuery($query);
				$id = $db->loadResult();
				
				if($id){
					$mainframe->redirect(JRoute::_('index.php?option=com_user&view=user&layout=giftcard'), JText::_('CARD ALREADY USED'));
					return false;
				}
				
				$balance=$user->bonus+$row->nominal;
				
				$count = $row->count+1;
		
				$query = 'UPDATE'
				. ' #__mos_bgiftcard'
				. ' SET `count`='.$count
				. ' WHERE id='.(int)$row->id
				;
				$db->setQuery( $query );
				$db->query();
				
				$query = 'UPDATE'
				. ' #__users'
				. ' SET bonus='.$balance
				. ' WHERE id='.(int)$user->id
				;
				$db->setQuery( $query );
				$db->query();
				
				$query = 'INSERT'
				. ' #__mos_transaction (userid, `date`, sum, type, eventid)'
				. ' VALUES ('.(int)$user->id.', NOW(), '.$db->Quote($row->nominal).', 9, '.(int)$row->id.')'
				;
				$db->setQuery( $query );
				$db->query();
				
				$query = 'INSERT'
				. ' #__mos_bgiftcard_use'
				. ' VALUES ('.(int)$row->id.', '.(int)$user->id.')'
				;
				$db->setQuery( $query );
				$db->query();
				
				$mainframe->redirect(JRoute::_('index.php?option=com_user&view=user&layout=giftcard'), JText::_('CARD USED'));
			}else{
				$mainframe->redirect(JRoute::_('index.php?option=com_user&view=user&layout=giftcard'), JText::_('CARD NOT EXIST2'));
			}
		}else{
			$mainframe->redirect(JRoute::_('index.php?option=com_user&view=user&layout=giftcard'), JText::_('CARD NOT EXIST2'));
		}
	}
	
	function captcha()
	{
		include("captcha/securimage.php");
				
		$document = &JFactory::getDocument();
		$doc = &JDocument::getInstance('raw');
		$document = $doc;
		$img = new Securimage();
		$img->ttf_file = "captcha/elephant.ttf";
		$img->show();
	}
	
	function gift()
	{
		global $mainframe;
		$post['id'] = JRequest::getVar( 'id', '', 'post', 'int');
		$post['email'] = JRequest::getVar( 'email', '', 'post', 'string');


		if ($post['id'] && $post['email'])
		{
			$model = &$this->getModel('gift');
			$model->send($post);
		} else {
			$mainframe->redirect(JRoute::_('index.php?option=com_user&view=user'), JText::_('ERROR GIFT COUPON'));
		}
	}
	
	function setparam()
	{
		global $mainframe;
		
		$session  = JFactory::getSession();
		$city = JRequest::getVar( 'city', '0', 'get', 'int');
		$session->set('city', $city);
		
		$mainframe->redirect(JURI::base());
	}
	
	function repeat()
	{
		global $mainframe;
		
		$id = JRequest::getVar('id', '', '', 'int');
				
		$session  = JFactory::getSession();
		$user = $session->get('user');
		
		if(!$id){
			exit();
		}

		if(!$user->id){
			$result = array('login'=>1); 
		}else{
			$db = & JFactory::getDBO();
			
			$query = 'SELECT a.iduser'
			. ' FROM #__mos_repeat AS a'
			. ' WHERE a.iduser='.(int)$user->id.' AND a.idevent='.(int)$id 
			;
			
			$db->setQuery($query);
			$vote = $db->loadResult();
			
			if($vote){
				$result = array('result'=>0, 'message'=>'<div class="sys-message">'.JText::_('You already vote').'</div>'); 
			}else{
				$query = 'SELECT a.repeat'
				. ' FROM #__mos_event AS a'
				. ' WHERE a.id='.(int)$id 
				;
				
				$db->setQuery($query);
				$repeat = $db->loadResult();
				
				$repeat++;
				
				$query = 'INSERT'
				. ' #__mos_repeat'
				. ' VALUE ( '.(int)$user->id.', '.(int)$id.')';
				
				$db->setQuery( $query );
				$db->query();
				
				$query = 'UPDATE'
				. ' #__mos_event'
				. ' SET `repeat`='.$repeat
				. ' WHERE id='.(int)$id 
				;
				
				$db->setQuery( $query );
				$db->query();
				
				$result = array('result'=>1, 'message'=>'<div class="sys-message">'.JText::_('VOTE OK').'</div>'); 
			}
		}
		echo json_encode($result);
		exit();
	}
	
	function favorite()
	{
		global $mainframe;
		
		$id = JRequest::getVar('id', '', '', 'int');
				
		$session  = JFactory::getSession();
		$user = $session->get('user');
		
		if(!$id){
			$result = array('message'=>'<div class="sys-message">'.JText::_('SELECT EVENT').'</div>');
		}

		if(!$user->id){
			$result = array('message'=>'<div class="sys-message">'.JText::_('YOU MUST LOGIN').'</div>');
		}else{
			$db = & JFactory::getDBO();
			
			$query = 'SELECT a.iduser'
			. ' FROM #__mos_favorite AS a'
			. ' WHERE a.iduser='.(int)$user->id.' AND a.idevent='.(int)$id 
			;
			
			$db->setQuery($query);
			$favorite = $db->loadResult();
			
			if($favorite){
				$query = 'DELETE'
				. ' FROM #__mos_favorite'
				. ' WHERE iduser='.(int)$user->id.' AND idevent='.(int)$id;
				
				$db->setQuery( $query );
				$db->query();
				
				$result = array('text'=>'<div class="fav"></div>');
			}else{
				$query = 'INSERT'
				. ' #__mos_favorite'
				. ' VALUE ( '.(int)$user->id.', '.(int)$id.')';
				
				$db->setQuery( $query );
				$db->query();
				
				$result = array('text'=>'<div class="unfav"></div>');
			}
		}
		echo json_encode($result);
		exit();
	}
}