<?php
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');
class UserController extends JController
{
	function display()
	{
		parent::display();
	}

	function edit()
	{
		global $mainframe, $option;

		$db		=& JFactory::getDBO();
		$user	=& JFactory::getUser();

		if ( $user->get('guest')) {
			JError::raiseError( 403, JText::_('Access Forbidden') );
			return;
		}

		JRequest::setVar('layout', 'form');

		parent::display();
	}

	function save()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$user	 =& JFactory::getUser();
		$userid = JRequest::getVar( 'id', 0, 'post', 'int' );

		if ($user->get('id') == 0 || $userid == 0 || $userid <> $user->get('id')) {
			JError::raiseError( 403, JText::_('Access Forbidden') );
			return;
		}

		$post['name']	= JRequest::getVar('name', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$post['family']	= JRequest::getVar('family', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$post['sendEmail']	= JRequest::getVar('sendEmail', '0', 'post', 'int');
		$post['city']	= JRequest::getVar('city', '0', 'post', 'int');
		$post['password']	= JRequest::getVar('password', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$post['password2']	= JRequest::getVar('password2', '', 'post', 'string', JREQUEST_ALLOWRAW);
		if($post['name']=="") $post['name']=$user->email;
		$day	= JRequest::getVar('day', '', 'post', 'int');
		$month	= JRequest::getVar('month', '', 'post', 'int');
		$year	= JRequest::getVar('year', '', 'post', 'int');
		$post['gender']	= JRequest::getVar('gender', '', 'post', 'int');
		$post['birthDay']= date("Y-m-d", strtotime($year.'-'.$month.'-'.$day));
		$model = $this->getModel('user');

		if ($model->store($post)) {
			JError::raiseNotice('', JText::_( 'Your settings have been saved.' ));
			
			$session  = JFactory::getSession();
			$session->set( 'city', $user->city);
		
			$this->display();
		} else {
			JError::raiseWarning('', $model->getError());
			$this->setRedirect(JRoute::_('index.php?option=com_user&view=user&layout=profile_edit'));
		}
		
		$this->setRedirect( $return, $msg );
	}
	function saveSubscribe()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$user	 =& JFactory::getUser();
		$userid = JRequest::getVar( 'id', 0, 'post', 'int' );

		if ($user->get('id') == 0 || $userid == 0 || $userid <> $user->get('id')) {
			JError::raiseError( 403, JText::_('Access Forbidden') );
			return;
		}
		
		$post['sendEmail']	= JRequest::getVar('sendEmail', '', 'post', 'int');
	
		$model = $this->getModel('user');

		if ($model->store($post)) {
			JError::raiseNotice('', JText::_( 'Your settings have been saved.' ));
			$this->display();
		} else {
			JError::raiseWarning('', $model->getError());
			$this->setRedirect(JRoute::_('index.php?option=com_user&view=user&layout=profile_edit'));
		}
		
		$this->setRedirect( $return, $msg );
	}
	function savePassword()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$user	 =& JFactory::getUser();
		$userid = JRequest::getVar( 'id', 0, 'post', 'int' );

		if ($user->get('id') == 0 || $userid == 0 || $userid <> $user->get('id')) {
			JError::raiseError( 403, JText::_('Access Forbidden') );
			return;
		}
		
		$post['password']	= JRequest::getVar('password', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$post['password2']	= JRequest::getVar('password2', '', 'post', 'string', JREQUEST_ALLOWRAW);
		
		$return = JURI::base().'index.php?option=com_user';
		
		if(strlen($post['password']) || strlen($post['password2'])) {
			if($post['password'] != $post['password2']) {
				$msg	= JText::_('PASSWORDS_DO_NOT_MATCH');
				$return = str_replace(array('"', '<', '>', "'"), '', @$_SERVER['HTTP_REFERER']);
				if (empty($return) || !JURI::isInternal($return)) {
					$return = JURI::base();
				}
				$this->setRedirect($return, $msg, 'error');
				return false;
			}
		}
		
		$model = $this->getModel('user');
		
		if ($model->store($post)) {
			JError::raiseNotice('', JText::_( 'Your settings have been saved.' ));
			$this->display();
		} else {
			JError::raiseWarning('', $model->getError());
			$this->setRedirect(JRoute::_('index.php?option=com_user&view=user&layout=profile_edit'));
		}
		
		$this->setRedirect( $return, $msg );
	}

	function cancel()
	{
		$this->setRedirect( 'index.php' );
	}

	function login()
	{
		// Check for request forgeries
		JRequest::checkToken('request') or jexit( 'Invalid Token' );

		global $mainframe;

		if ($return = JRequest::getVar('return', '', 'method', 'base64')) {
			$return = base64_decode($return);
			if (!JURI::isInternal($return)) {
				$return = '';
			}
		}

		$options = array();
		$options['remember'] = JRequest::getBool('remember', false);
		$options['return'] = $return;

		$credentials = array();
		$credentials['username'] = JRequest::getVar('username', '', 'method', 'username');
		$credentials['password'] = JRequest::getString('passwd', '', 'post', JREQUEST_ALLOWRAW);

		//preform the login action
		$error = $mainframe->login($credentials, $options);
		
		$user	=& JFactory::getUser();
		if($user->lastvisitDate=='0000-00-00 00:00:00' && $user->friend!=0){
			$db	=& JFactory::getDBO();
			$query = 'UPDATE #__users SET `bonus`='.(int)$mainframe->getCfg('friend_bonus').' WHERE id='.(int)$user->id;	
			$db->setQuery($query);
			if (!$db->query()) {
				JError::raiseError(500, $db->getErrorMsg() );
			}else{
				$user->set('bonus', $mainframe->getCfg('friend_bonus'));
				$session =& JFactory::getSession();
				$session->set('user', $user);
			}
			$query = 'SELECT bonus FROM #__users WHERE id='.(int)$user->friend;	
			$db->setQuery($query);
			$bonus = $db->loadResult() + $mainframe->getCfg('user_bonus');;
			$query = 'UPDATE #__users SET `bonus`='.(int)$bonus.' WHERE id='.(int)$user->friend;	
			$db->setQuery($query);
			if (!$db->query()) {
				JError::raiseError(500, $db->getErrorMsg() );
			}
			
			$query = 'INSERT'
				. ' #__mos_transaction (userid, `date`, sum, type, eventid)'
				. ' VALUES ('.(int)$user->id.', NOW(), '.$db->Quote((int)$mainframe->getCfg('friend_bonus')).',5, '.$user->friend.')'
				;
				$db->setQuery( $query );
				$db->query();
				
			$query = 'INSERT'
				. ' #__mos_transaction (userid, `date`, sum, type, eventid)'
				. ' VALUES ('.(int)$user->friend.', NOW(), '.$db->Quote($bonus).', 5, '.$user->id.')'
				;
				$db->setQuery( $query );
				$db->query();
		}

		if(!JError::isError($error))
		{
			// Redirect if the return url is not registration or login
			if ( ! $return ) {
				$return	= 'index.php?option=com_user';
			}
			$session =& JFactory::getSession();
			$user	=& $session->get('user');
			if($user->city){
				$session->set('city', $user->city);
			}
			$mainframe->redirect( $return );
		}
		else
		{
			// Facilitate third party login forms
			if ( ! $return ) {
				$return	= 'index.php';
			}

			// Redirect to a login form
			$mainframe->redirect( $return );
		}
	}

	function logout()
	{
		global $mainframe;

		//preform the logout action
		$error = $mainframe->logout();

		if(!JError::isError($error))
		{
			if ($return = JRequest::getVar('return', '', 'method', 'base64')) {
				$return = base64_decode($return);
				if (!JURI::isInternal($return)) {
					$return = '';
				}
			}

			// Redirect if the return url is not registration or login
			if ( $return && !( strpos( $return, 'com_user' )) ) {
				$mainframe->redirect( $return );
			}
		} else {
			parent::display();
		}
	}

	function activate()
	{
		global $mainframe;

		// Initialize some variables
		$db			=& JFactory::getDBO();
		$user 		=& JFactory::getUser();
		$document   =& JFactory::getDocument();
		$pathway 	=& $mainframe->getPathWay();

		$usersConfig = &JComponentHelper::getParams( 'com_users' );
		$userActivation			= $usersConfig->get('useractivation');
		$allowUserRegistration	= $usersConfig->get('allowUserRegistration');

		// Check to see if they're logged in, because they don't need activating!
		if ($user->get('id')) {
			// They're already logged in, so redirect them to the home page
			$mainframe->redirect( 'index.php' );
		}

		if ($allowUserRegistration == '0' || $userActivation == '0') {
			JError::raiseError( 403, JText::_( 'Access Forbidden' ));
			return;
		}

		// create the view
		require_once (JPATH_COMPONENT.DS.'views'.DS.'register'.DS.'view.html.php');
		$view = new UserViewRegister();

		$message = new stdClass();

		// Do we even have an activation string?
		$activation = JRequest::getVar('activation', '', '', 'alnum' );
		$activation = $db->getEscaped( $activation );

		if (empty( $activation ))
		{
			// Page Title
			$document->setTitle( JText::_( 'REG_ACTIVATE_NOT_FOUND_TITLE' ) );
			// Breadcrumb
			$pathway->addItem( JText::_( 'REG_ACTIVATE_NOT_FOUND_TITLE' ));

			$message->title = JText::_( 'REG_ACTIVATE_NOT_FOUND_TITLE' );
			$message->text = JText::_( 'REG_ACTIVATE_NOT_FOUND' );
			$view->assign('message', $message);
			$view->display('message');
			return;
		}

		// Lets activate this user
		jimport('joomla.user.helper');
		if (JUserHelper::activateUser($activation))
		{
			// Page Title
			$document->setTitle( JText::_( 'REG_ACTIVATE_COMPLETE_TITLE' ) );
			// Breadcrumb
			$pathway->addItem( JText::_( 'REG_ACTIVATE_COMPLETE_TITLE' ));

			$message->title = JText::_( 'REG_ACTIVATE_COMPLETE_TITLE' );
			$message->text = JText::_( 'REG_ACTIVATE_COMPLETE' );
		}
		else
		{
			// Page Title
			$document->setTitle( JText::_( 'REG_ACTIVATE_NOT_FOUND_TITLE' ) );
			// Breadcrumb
			$pathway->addItem( JText::_( 'REG_ACTIVATE_NOT_FOUND_TITLE' ));

			$message->title = JText::_( 'REG_ACTIVATE_NOT_FOUND_TITLE' );
			$message->text = JText::_( 'REG_ACTIVATE_NOT_FOUND' );
		}

		$view->assign('message', $message);
		$view->display('message');
	}

	/**
	 * Password Reset Request Method
	 *
	 * @access	public
	 */
	function requestreset()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		// Get the input
		$email		= JRequest::getVar('email', null, 'post', 'string');

		// Get the model
		$model = &$this->getModel('Reset');

		// Request a reset
		if ($model->requestReset($email) === false)
		{
			$message = JText::sprintf('PASSWORD_RESET_REQUEST_FAILED', $model->getError());
			$this->setRedirect('index.php?option=com_user&view=reset', $message);
			return false;
		}

		$this->setRedirect('index.php?option=com_user&view=reset&layout=confirm');
	}

	/**
	 * Password Reset Confirmation Method
	 *
	 * @access	public
	 */
	function confirmreset()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		// Get the input
		$token = JRequest::getVar('token', null, 'post', 'alnum');

		// Get the model
		$model = &$this->getModel('Reset');

		// Verify the token
		if ($model->confirmReset($token) === false)
		{
			$message = JText::sprintf('PASSWORD_RESET_CONFIRMATION_FAILED', $model->getError());
			$this->setRedirect('index.php?option=com_user&view=reset&layout=confirm', $message);
			return false;
		}

		$this->setRedirect('index.php?option=com_user&view=reset&layout=complete');
	}

	/**
	 * Password Reset Completion Method
	 *
	 * @access	public
	 */
	function completereset()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		// Get the input
		$password1 = JRequest::getVar('password1', null, 'post', 'string', JREQUEST_ALLOWRAW);
		$password2 = JRequest::getVar('password2', null, 'post', 'string', JREQUEST_ALLOWRAW);

		// Get the model
		$model = &$this->getModel('Reset');

		// Reset the password
		if ($model->completeReset($password1, $password2) === false)
		{
			$message = JText::sprintf('PASSWORD_RESET_FAILED', $model->getError());
			$this->setRedirect('index.php?option=com_user&view=reset&layout=complete', $message);
			return false;
		}

		$message = JText::_('PASSWORD_RESET_SUCCESS');
		$this->setRedirect('index.php', $message);
	}

	/**
	 * Username Reminder Method
	 *
	 * @access	public
	 */
	function remindusername()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		// Get the input
		$email = JRequest::getVar('email', null, 'post', 'string');

		// Get the model
		$model = &$this->getModel('Remind');

		// Send the reminder
		if ($model->remindUsername($email) === false)
		{
			$message = JText::sprintf('USERNAME_REMINDER_FAILED', $model->getError());
			$this->setRedirect('index.php?option=com_user&view=remind', $message);
			return false;
		}

		$message = JText::sprintf('USERNAME_REMINDER_SUCCESS', $email);
		$this->setRedirect('index.php', $message);
	}

	function _sendMail(&$user, $password)
	{
		global $mainframe;

		$db		=& JFactory::getDBO();

		$name 		= $user->get('name');
		$email 		= $user->get('email');
		$username 	= $user->get('username');

		$usersConfig 	= &JComponentHelper::getParams( 'com_users' );
		$sitename 		= $mainframe->getCfg( 'sitename' );
		$useractivation = $usersConfig->get( 'useractivation' );
		$mailfrom 		= $mainframe->getCfg( 'mailfrom' );
		$fromname 		= $mainframe->getCfg( 'fromname' );
		$siteURL		= JURI::base();

		$subject 	= sprintf ( JText::_( 'Account details for' ), $name, $sitename);
		$subject 	= html_entity_decode($subject, ENT_QUOTES);

		if ( $useractivation == 1 ){
			$message = sprintf ( JText::_( 'SEND_MSG_ACTIVATE' ), $name, $sitename, $siteURL."index.php?option=com_user&task=activate&activation=".$user->get('activation'), $siteURL, $username, $password);
		} else {
			$message = sprintf ( JText::_( 'SEND_MSG' ), $name, $sitename, $siteURL);
		}

		$message = html_entity_decode($message, ENT_QUOTES);

		//get all super administrator
		$query = 'SELECT name, email, sendEmail' .
				' FROM #__users' .
				' WHERE LOWER( usertype ) = "super administrator"';
		$db->setQuery( $query );
		$rows = $db->loadObjectList();

		// Send email to user
		if ( ! $mailfrom  || ! $fromname ) {
			$fromname = $rows[0]->name;
			$mailfrom = $rows[0]->email;
		}

		JUtility::sendMail($mailfrom, $fromname, $email, $subject, $message);

		// Send notification to all administrators
		$subject2 = sprintf ( JText::_( 'Account details for' ), $name, $sitename);
		$subject2 = html_entity_decode($subject2, ENT_QUOTES);

		// get superadministrators id
		foreach ( $rows as $row )
		{
			if ($row->sendEmail)
			{
				$message2 = sprintf ( JText::_( 'SEND_MSG_ADMIN' ), $row->name, $sitename, $name, $email, $username);
				$message2 = html_entity_decode($message2, ENT_QUOTES);
				JUtility::sendMail($mailfrom, $fromname, $row->email, $subject2, $message2);
			}
		}
	}
	
	function social(){
		$post['type'] = JRequest::getVar('socType', '', 'post', 'int');
		$post['name'] = JRequest::getVar('socName', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$post['family'] = JRequest::getVar('socFamily', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$post['login'] = JRequest::getVar('socLogin', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$post['bithday'] = JRequest::getVar('socBdate', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$post['email'] = JRequest::getVar('socEmail', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$post['friend'] = JRequest::getVar('socFriend', '', 'post', 'string', JREQUEST_ALLOWRAW);
		
		if($post['type']>0){
			$model = &$this->getModel('social');
			switch($post['type']){
				case 1:
					$model->vkontakte($post);
					break;	
				case 2:
					$model->mail($post);
					break;	
				case 3:
					$model->facebook($post);
					break;
				default:
					$this->setRedirect(JRoute::_('index.php?option=com_coupon&view=registration'));	
			}
		}else{
			$this->setRedirect(JRoute::_('index.php?option=com_coupon&view=registration'));
		}
	}
	
	function status(){
		global $mainframe;
		
		$id = JRequest::getVar('order', 0, '', 'int');

		$user     =& JFactory::getUser();
		if($user->advertiser!=1 || $id<1){
			$mainframe->redirect(JRoute::_('index.php?option=com_user'), JText::_('You dont have permission'));
			return;
		}else{
			$db	=& JFactory::getDBO();
		
			$query = 'SELECT a.id, a.id_event, a.use'
			. ' FROM #__mos_order AS a'
			. ' LEFT JOIN #__mos_event AS b ON a.id_event=b.id'
			. ' WHERE a.id='.(int)$id.' AND b.advertiser='.(int)$user->id
			;
			
			$db->setQuery($query);
			$order = $db->loadObject();
			
			if($order->id>0 && $order->use==0){
				$query = 'UPDATE'
				. ' #__mos_order'
				. ' SET `use`=1'
				. ' WHERE id='.(int)$order->id
				;
				$db->setQuery( $query );
				$db->query();
				
				$mainframe->redirect(JRoute::_('index.php?option=com_user&layout=event&id='.$order->id_event), JText::_('Status changed'));
				return;
			}else{
				$mainframe->redirect(JRoute::_('index.php?option=com_user'), JText::_('You dont have permission'));
				return;
			}
		}
	}
	
	function useCoupon(){
		global $mainframe;
		
		$id = JRequest::getVar('order', 0, '', 'int');

		$user     =& JFactory::getUser();
		
		if(!$user->id){
			$mainframe->redirect(JRoute::_('index.php?option=com_user'), JText::_('You dont have permission'));
			return;
		}else{
			$db	=& JFactory::getDBO();
			
			$cid = JRequest::getVar( 'coupon', array(), '', 'array' );   
			foreach ($cid as $id){					    			
				$query = 'UPDATE'
				. ' #__mos_order'
				. ' SET `use`=1'
				. ' WHERE id='.(int)$id.' AND email='.$db->Quote($user->email).' AND `use`=0'
				;
				$db->setQuery( $query );
				$db->query();
			}				
			$mainframe->redirect(JRoute::_('index.php?option=com_user'), JText::_('Status changed'));
			return;
		}
	}
}
?>
