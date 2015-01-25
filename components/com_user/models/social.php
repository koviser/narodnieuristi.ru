<?php

defined('_JEXEC') or die;

jimport('joomla.application.component.model');

class UserModelSocial extends JModel
{
	function vkontakte($post)
	{
		global $mainframe;
		
		if (!isset($_COOKIE['vk_app_'.$mainframe->getCfg( 'vk_id' )])){
			$mainframe->redirect(JRoute::_('index.php?option=com_coupon&view=registration'));
		}

		$vk_cookie = $_COOKIE['vk_app_'.$mainframe->getCfg( 'vk_id' )];

		if (!empty($vk_cookie)) {
			$cookie_data = array();

			foreach (explode('&', $vk_cookie) as $item) {
				$item_data = explode('=', $item);
				$cookie_data[$item_data[0]] = $item_data[1];
			}

			$string = sprintf("expire=%smid=%ssecret=%ssid=%s%s", $cookie_data['expire'], $cookie_data['mid'], $cookie_data['secret'], $cookie_data['sid'], $mainframe->getCfg( 'vk_password' ));

			if (md5($string) == $cookie_data['sig']) {
				$db		=& JFactory::getDBO();
				
				$query = 'SELECT userid' .
				' FROM #__mos_social' .
				' WHERE username='.$db->Quote($post['login']).' AND type='.(int)$post['type'];
				$db->setQuery( $query );
				$userid = $db->loadResult();
				
				$session = JFactory::getSession();
				
				if($userid>0){
					$credentials = array();
					$credentials['id'] = $userid;
					$error = $mainframe->login($credentials, $options);
	
					if(!JError::isError($error))
					{
						$user=$session->get('user');
						$return	= JURI::root();
						$session->set('city', $user->city);
			
						$mainframe->redirect( $return );
					}
					else
					{
						$return	= 'index.php?option=com_coupon&view=registration';
						$mainframe->redirect( $return );
					}
				}else{
					$session->set('socType',1);
					$session->set('socLogin',$post['login']);
					$session->set('socName',$post['name']);
					$session->set('socFamily',$post['family']);
					$bithday = explode('.', $post['bithday']); 
					$session->set('socDay',$bithday[0]);
					$session->set('socMonth',$bithday[1]);
					$session->set('socFriend',$post['friend']);
					
					$mainframe->redirect(JRoute::_('index.php?option=com_coupon&view=registration&social=1'));
				}
			}else{
				$mainframe->redirect(JRoute::_('index.php?option=com_coupon&view=registration'));
			}
		}
		
	}
	
	function mail($post)
	{
		global $mainframe;
		
		if (!isset($_COOKIE['mrc'])){
			$mainframe->redirect(JRoute::_('index.php?option=com_coupon&view=registration'));
		}

		$data = array();
		parse_str(urldecode($_COOKIE['mrc']), $data);
		
		$path = 'http://www.appsmail.ru/platform/api';
		
		$method = 'method=users.getInfo';
		$app_id = 'app_id='.$mainframe->getCfg( 'mail_ru_id' );
		$session_key = 'session_key=' . $data['session_key'];
		$secure = 'secure=1';
		$uids = 'uids='.$post['login'];
		
		$params = $app_id . $method . $secure . $session_key . $uids;
		$sid_to_encode = $params.$mainframe->getCfg( 'mail_ru_password' );
		$sig = md5($sid_to_encode);
		
		$api_uri = sprintf('%s&%s&%s&%s&%s&sig=%s', $method, $app_id, $session_key, $secure, $uids, $sig);
		$uri = $path . '?' . $api_uri;
		
		$api_result = UserModelSocial::http_request($uri);
		
		if($api_result->status_message!="OK"){
			$mainframe->redirect(JRoute::_('index.php?option=com_coupon&view=registration'));
		}
		
		$result = json_decode($api_result->data);
		
		$res = $result[0];
		
		if($res->link) {
			$db		=& JFactory::getDBO();
			$session = JFactory::getSession();
				
			$query = 'SELECT userid' .
			' FROM #__mos_social' .
			' WHERE username='.$db->Quote($res->uid).' AND type='.(int)$post['type'];
			$db->setQuery( $query );
			$userid = $db->loadResult();
			
			if($userid>0){
				$credentials = array();
				$credentials['id'] = $userid;
				$error = $mainframe->login($credentials, $options);
	
				if(!JError::isError($error))
				{
					$user=$session->get('user');
					$return	= JURI::root();
					$session->set('city', $user->city);
		
					$mainframe->redirect( $return );
				}
				else
				{
					$return	= 'index.php?option=com_coupon&view=registration';
					$mainframe->redirect( $return );
				}
			}else{
				$session->set('socType',2);
				$session->set('socLogin',$res->uid);
				$session->set('socName',$res->first_name);
				$session->set('socFamily',$res->last_name);
				$session->set('socEmail',$res->email);
				$birthday = explode('.', $res->birthday); 
				$session->set('socDay',$birthday[0]);
				$session->set('socMonth',$birthday[1]);
				$session->set('socYear',$birthday[2]);
				$session->set('socFriend',$post['friend']);
				
				$mainframe->redirect(JRoute::_('index.php?option=com_coupon&view=registration&social=1'));
			}
		}else{
			$mainframe->redirect(JRoute::_('index.php?option=com_coupon&view=registration'));
		}	
	}
	
	function facebook($post)
	{
		global $mainframe;
		
		jimport('facebook.facebook');
		
		ini_set('display_errors',1);
		
		$facebook = new Facebook(array(
		  'appId'  => $mainframe->getCfg( 'fb_id' ),
		  'secret' => $mainframe->getCfg( 'fb_password'),
		));
		$User = $facebook->getUser();
		
		if ($User) {
		  try {
			$user = $facebook->api('/me');
		  } catch (FacebookApiException $e) {
			$user = null;
		  }
		}
		
		if($user['id']) {
			$db		=& JFactory::getDBO();
			$session = JFactory::getSession();
				
			$query = 'SELECT userid' .
			' FROM #__mos_social' .
			' WHERE username='.$db->Quote($user['id']).' AND type='.(int)$post['type'];
			$db->setQuery( $query );
			$userid = $db->loadResult();
			
			if($userid>0){
				$credentials = array();
				$credentials['id'] = $userid;
				$error = $mainframe->login($credentials, $options);
	
				if(!JError::isError($error))
				{
					$user=$session->get('user');
					$return	= JURI::root();
					$session->set('city', $user->city);
		
					$mainframe->redirect( $return );
				}
				else
				{
					$return	= 'index.php?option=com_coupon&view=registration';
					$mainframe->redirect( $return );
				}
			}else{
				$session->set('socType',3);
				$session->set('socLogin',$user['id']);
				$session->set('socName',$user['first_name']);
				$session->set('socFamily',$user['last_name']);
				$session->set('socEmail',$user['email']);
				$birthday = explode('/', $user['birthday']); 
				$session->set('socDay',$birthday[0]);
				$session->set('socMonth',$birthday[1]);
				$session->set('socYear',$birthday[2]);
				$session->set('socFriend',$post['friend']);
				
				$mainframe->redirect(JRoute::_('index.php?option=com_coupon&view=registration&social=1'));
			}
		}else{
			$mainframe->redirect(JRoute::_('index.php?option=com_coupon&view=registration'));
		}	
	}
	
	function http_request($url, $method = 'GET', $data = NULL, $retry = 3) {
		$result = new stdClass();
		$uri = parse_url($url);
	
		if ($uri == FALSE) {
			$result->error = 'unable to parse URL';
			$result->code = -1001;
			return $result;
	  	}
	
	  	if (!isset($uri['scheme'])) {
			$result->error = 'missing schema';
			$result->code = -1002;
			return $result;
	  	}
	
	  	switch ($uri['scheme']) {
			case 'http':
			case 'feed':
		  		$port = isset($uri['port']) ? $uri['port'] : 80;
		  		$host = $uri['host'] . ($port != 80 ? ':' . $port : '');
		  		$fp = @fsockopen($uri['host'], $port, $errno, $errstr, 15);
		  	break;
			case 'https':
		  		$port = isset($uri['port']) ? $uri['port'] : 443;
		  		$host = $uri['host'] . ($port != 443 ? ':' . $port : '');
		 		 $fp = @fsockopen('ssl://' . $uri['host'], $port, $errno, $errstr, 20);
		  		break;
			default:
		  		$result->error = 'invalid schema ' . $uri['scheme'];
		  		$result->code = -1003;
		  	return $result;
	  	}
	
	  if (!$fp) {
		$result->code = -$errno;
		$result->error = trim($errstr);
	
		variable_set('drupal_http_request_fails', TRUE);
	
		return $result;
	  }
	
	  $path = isset($uri['path']) ? $uri['path'] : '/';
	  if (isset($uri['query'])) {
		$path .= '?' . $uri['query'];
	  }
	
	  $defaults = array(
		'Host' => "Host: $host", 
		'User-Agent' => 'User-Agent: Joomla (+http://joomla.org/)',
	  );
	
	  $content_length = strlen($data);
	  if ($content_length > 0 || $method == 'POST' || $method == 'PUT') {
		$defaults['Content-Length'] = 'Content-Length: ' . $content_length;
	  }
	
	  if (isset($uri['user'])) {
		$defaults['Authorization'] = 'Authorization: Basic ' . base64_encode($uri['user'] . (!empty($uri['pass']) ? ":" . $uri['pass'] : ''));
	  }
	
	  $request = $method . ' ' . $path . " HTTP/1.0\r\n";
	  $request .= implode("\r\n", $defaults);
	  $request .= "\r\n\r\n";
	  $request .= $data;
	
	  $result->request = $request;
	
	  fwrite($fp, $request);
	
	  $response = '';
	  while (!feof($fp) && $chunk = fread($fp, 1024)) {
		$response .= $chunk;
	  }
	  fclose($fp);
	
	  list($split, $result->data) = explode("\r\n\r\n", $response, 2);
	  $split = preg_split("/\r\n|\n|\r/", $split);
	
	  list($protocol, $code, $status_message) = explode(' ', trim(array_shift($split)), 3);
	  $result->protocol = $protocol;
	  $result->status_message = $status_message;
	
	  $result->headers = array();
	
	  while ($line = trim(array_shift($split))) {
		list($header, $value) = explode(':', $line, 2);
		if (isset($result->headers[$header]) && $header == 'Set-Cookie') {
		  $result->headers[$header] .= ',' . trim($value);
		}
		else {
		  $result->headers[$header] = trim($value);
		}
	  }
	
	  $responses = array(
		100 => 'Continue', 
		101 => 'Switching Protocols', 
		200 => 'OK', 
		201 => 'Created', 
		202 => 'Accepted', 
		203 => 'Non-Authoritative Information', 
		204 => 'No Content', 
		205 => 'Reset Content', 
		206 => 'Partial Content', 
		300 => 'Multiple Choices', 
		301 => 'Moved Permanently', 
		302 => 'Found', 
		303 => 'See Other', 
		304 => 'Not Modified', 
		305 => 'Use Proxy', 
		307 => 'Temporary Redirect', 
		400 => 'Bad Request', 
		401 => 'Unauthorized', 
		402 => 'Payment Required', 
		403 => 'Forbidden', 
		404 => 'Not Found', 
		405 => 'Method Not Allowed', 
		406 => 'Not Acceptable', 
		407 => 'Proxy Authentication Required', 
		408 => 'Request Time-out', 
		409 => 'Conflict', 
		410 => 'Gone', 
		411 => 'Length Required', 
		412 => 'Precondition Failed', 
		413 => 'Request Entity Too Large', 
		414 => 'Request-URI Too Large', 
		415 => 'Unsupported Media Type', 
		416 => 'Requested range not satisfiable', 
		417 => 'Expectation Failed', 
		500 => 'Internal Server Error', 
		501 => 'Not Implemented', 
		502 => 'Bad Gateway', 
		503 => 'Service Unavailable', 
		504 => 'Gateway Time-out', 
		505 => 'HTTP Version not supported',
	  );
	  if (!isset($responses[$code])) {
		$code = floor($code / 100) * 100;
	  }
	
	  switch ($code) {
		case 200: // OK
		case 304: // Not modified
		  break;
		case 301: // Moved permanently
		case 302: // Moved temporarily
		case 307: // Moved temporarily
		  $location = $result->headers['Location'];
		  $result->redirect_url = $location;
	
		  break;
		default:
		  $result->error = $status_message;
	  }
	
	  $result->code = $code;
	  return $result;
	}
}
?>