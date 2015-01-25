<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class UserViewUser extends JView
{
	function display( $tpl = null)
	{
		global $mainframe;
		
		$user	=& JFactory::getUser();
		if ($user->get('id') == 0) {
			$mainframe->redirect(JRoute::_('index.php?option=com_user&view=login'));
			return;
		}
		
		require_once ('components'.DS.'com_coupon'.DS.'common.php');

		$layout	= $this->getLayout();
		if( $layout == 'form') {
			$this->_displayForm($tpl);
			return;
		}else if( $layout == 'edit') {
			$this->_displayEdit($tpl);
			return;
		}else if( $layout == 'billing') {
			$this->_displayBilling($tpl);
			return;
		}else if( $layout == 'myevents') {
			$this->_displayMyevents($tpl);
			return;
		}else if( $layout == 'bonuses') {
			$this->_displayBonuses($tpl);
			return;
		}else if( $layout == 'friends') {
			$this->_displayFriends($tpl);
			return;
		}else if( $layout == 'event') {
			$this->_displayEvent($tpl);
			return;
		}else if( $layout == 'partner') {
			$this->_displayPartner($tpl);
			return;
		}else if( $layout == 'giftcard') {
			$this->_displayGiftcard($tpl);
			return;
		}else if( $layout == 'transaction') {
			$this->_displayTransaction($tpl);
			return;
		}

		$params = &$mainframe->getParams();

		$menus	= &JSite::getMenu();
		$menu	= $menus->getActive();

		if (is_object( $menu )) {
			$menu_params = new JParameter( $menu->params );
			if (!$menu_params->get( 'page_title')) {
				$params->set('page_title',	JText::_( 'Personal information' ));
			}
		} else {
			$params->set('page_title',	JText::_( 'Personal information' ));
		}
		$document	= &JFactory::getDocument();
		$document->setTitle( $params->get( 'page_title' ) );
		
		//NEW
		$db	=& JFactory::getDBO();
		
		$status = JRequest::getVar('status', 1, '', 'int');
		$use = JRequest::getVar('use', 0, '', 'int');
		
		$orderby = ' ORDER BY a.date DESC';
		
		$start  = mktime(0, 0, 0, date("m")-11  , 1, date("Y"));
		/*
		$where = array();
		$where[]='a.email='.$db->Quote($user->email);
		$where[]='a.status='.(int)$status;
		$where[]='a.use<2';
										
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT COUNT(a.id)'
		. ' FROM #__mos_order AS a'
		. $where
		;
		
		$db->setQuery($query);
		$total = $db->loadResult();
		
		$query = 'SELECT SUM(b.sale/100*b.realPrice) AS summa'
		. ' FROM #__mos_order AS a'
		. ' LEFT JOIN #__mos_event AS b ON a.id_event = b.id'
		. $where
		;
		
		$db->setQuery($query);
		$summa = number_format($db->loadResult(),0,',', ' ' );
		*/
		$where = array();
		$where[]='a.email='.$db->Quote($user->email);
		$where[]='a.status='.(int)$status;
		$where[]='a.use='.(int)$use;
										
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT a.date, a.password, b.title, b.price, b.id, b.dateUsed, a.id AS coupon, b.type, b.sale, b.image'
		. ' FROM #__mos_order AS a'
		. ' LEFT JOIN #__mos_event AS b ON a.id_event = b.id'
		. $where
		. $orderby
		;
		
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		// Set pathway information
		$this->assignRef('user'   , $user);
		$this->assignRef('total'   , $total);
		$this->assignRef('summa'   , $summa);
		$this->assignRef('status'   , $use);
		$this->assignRef('items',		$rows);
		$this->assignRef('params',		$params);

		parent::display($tpl);
	}

	function _displayEdit($tpl = null)
	{
		global $mainframe;

		//JHTML::_('behavior.formvalidation');

		$user     =& JFactory::getUser();
		$params = &$mainframe->getParams();
		
		$user	=& JFactory::getUser();
		if ($user->get('id') == 0) {
			$mainframe->redirect(JRoute::_('index.php?option=com_user&view=login'));
			return;
		}

		$document	= &JFactory::getDocument();
		$params->set('page_title',	JText::_( 'Personal information' ));
		$document->setTitle( $params->get( 'page_title' ) );
		
		$lists['gender'] 	= JEventsCommon::GenderCombo($user->gender);
		
		$time_day = substr($user->birthDay, 8, 2);
		$time_month = substr($user->birthDay, 5, 2);
		$time_year = substr($user->birthDay, 0, 4);
		if($time_year==0)$time_year=1980;
		
		if($user->name==$user->email) $user->name="";
			
		require_once ('administrator'.DS.'components'.DS.'com_coupon'.DS.'common.php');
		$lists['birthDay'] 	= JHTML::_('select.datelist', $time_day, $time_month, $time_year);
		$lists['subscribe'] 	= JEventsCommon::SubscribeCombo($user->sendEmail);
		$lists['city'] 	= JCouponCommon::CityCombo($user->city);

		$this->assignRef('user'  , $user);
		$this->assignRef('lists'  , $lists);
		$this->assignRef('params', $params);

		parent::display($tpl);
	}
	function _displayPassword($tpl = null)
	{
		global $mainframe;
		
		$user	=& JFactory::getUser();
		if ($user->get('id') == 0) {
			$mainframe->redirect(JRoute::_('index.php?option=com_user&view=login'));
			return;
		}

		//JHTML::_('behavior.formvalidation');

		$user     =& JFactory::getUser();
		$params = &$mainframe->getParams();

		$document	= &JFactory::getDocument();
		$params->set('page_title',	JText::_( 'Edit Your Details' ));
		$document->setTitle( $params->get( 'page_title' ) );
		
		$this->assignRef('user'  , $user);
		$this->assignRef('params', $params);

		parent::display($tpl);
	}
	function _displaySubscribe($tpl = null)
	{
		global $mainframe;

		//JHTML::_('behavior.formvalidation');

		$user     =& JFactory::getUser();
		$params = &$mainframe->getParams();

		$document	= &JFactory::getDocument();
		$params->set('page_title',	JText::_( 'Edit Your Subscribe' ));
		$document->setTitle( $params->get( 'page_title' ) );
		
		$lists['subscribe'] 	= JEventsCommon::SubscribeCombo($user->sendEmail);
		
		$this->assignRef('user'  , $user);
		$this->assignRef('lists'  , $lists);
		$this->assignRef('params', $params);

		parent::display($tpl);
	}
	function _displayBilling($tpl = null)
	{
		global $mainframe;

		$user     =& JFactory::getUser();
		$params = &$mainframe->getParams();

		$document	= &JFactory::getDocument();
		$params->set('page_title',	JText::_( 'Update Balance' ));
		$document->setTitle( $params->get( 'page_title' ) );
		
		$webmoney->login = $mainframe->getCfg('wm_login');
		$webmoney->url = $mainframe->getCfg('wm_url');
		$webmoney->password = $mainframe->getCfg('wm_password_1');

		$this->assignRef('webmoney',	$webmoney);
		$this->assignRef('user'  , $user);
		$this->assignRef('params', $params);

		parent::display($tpl);
	}
	
	function _displayMyevents($tpl = null)
	{
		global $mainframe;

		$user     =& JFactory::getUser();
		if($user->advertiser!=1){
			$mainframe->redirect(JRoute::_('index.php?option=com_user'), JText::_('You dont have permission'));
			return;
		}
		$params = &$mainframe->getParams();

		$document	= &JFactory::getDocument();
		$params->set('page_title',	JText::_( 'My events' ));
		$document->setTitle( $params->get( 'page_title' ) );
		
		$orderby = ' ORDER BY a.id ASC';
		
		$db	=& JFactory::getDBO();
		
		$where = array();
		$where[]='a.advertiser='.(int)$user->id;
		$where[]='a.published=1';
										
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT a.title, a.id, a.dateStart, a.dateEnd'
		. ' FROM #__mos_event AS a'
		. $where
		. $orderby
		;
		
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		
		$this->assignRef('user'  , $user);
		$this->assignRef('items'  , $rows);
		$this->assignRef('params', $params);

		parent::display($tpl);
	}
	
	function _displayEvent($tpl = null)
	{
		global $mainframe;
		
		$id = JRequest::getVar('id', 0, '', 'int');
				
		$db	=& JFactory::getDBO();
		
		$query = 'SELECT a.advertiser, a.title, a.id'
		. ' FROM #__mos_event AS a'
		. ' WHERE a.id='.(int)$id.' AND a.published=1'
		;
		
		$db->setQuery($query);
		$event = $db->loadObject();

		$user     =& JFactory::getUser();
		if($user->advertiser!=1 || $event->advertiser!=$user->id){
			$mainframe->redirect(JRoute::_('index.php?option=com_user'), JText::_('You dont have permission'));
			return;
		}
		$params = &$mainframe->getParams();

		$document	= &JFactory::getDocument();
		$params->set('page_title',	strip_tags(JText::_( 'STATISTIC FOR EVENT' ).' '.$event->title));
		$document->setTitle( strip_tags($params->get( 'page_title' )) );
						
		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
				
		$orderby = ' ORDER BY a.id ASC';	
		$where = array();
		
		$search				= JRequest::getVar('search', '', 'string' );
		$search				= JString::strtolower( $search );
		
		if (isset( $search ) && $search!= '')
		{
			$searchEscaped = $db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
			$where[] = 'a.password LIKE '.$searchEscaped;
		}
			
		$where[] = 'a.id_event='.$event->id;
		$where[] = 'a.status=1';
		$where[] = 'a.use<2';
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );		
		
		$query = 'SELECT COUNT(a.id)'
		. ' FROM #__mos_order AS a'
		. $where		
		;		
		
		$db->setQuery( $query );
		$total = $db->loadResult();		

		jimport('joomla.html.pagination');
		$pagination = new JPagination( $total, $limitstart, $limit );

		$query = 'SELECT a.*'
		. ' FROM #__mos_order AS a'
		. $where
		. $orderby
		;
		
		$db->setQuery( $query, $pagination->limitstart, $pagination->limit );
		$rows = $db->loadObjectList();
		
		$lists['search']= $search;
		
		$this->assignRef('user'  , $user);
		$this->assignRef('lists'  , $lists);
		$this->assignRef('items'  , $rows);
		$this->assignRef('event'  , $event);
		$this->assignRef('params', $params);

		parent::display($tpl);
	}
	
	function _displayFriends($tpl = null)
	{
		global $mainframe;

		$user     =& JFactory::getUser();
		$params = &$mainframe->getParams();

		$document	= &JFactory::getDocument();
		$params->set('page_title',	JText::_( 'My friends' ));
		$document->setTitle( $params->get( 'page_title' ) );
		
		$orderby = ' ORDER BY a.name ASC';
		
		$db	=& JFactory::getDBO();
		
		$where = array();
		$where[]='a.friend='.(int)$user->id;
		$where[]='a.lastvisitDate<>"0000-00-00 00:00:00"';
										
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT a.*'
		. ' FROM #__users AS a'
		. $where
		. $orderby
		;
		
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		
		$this->assignRef('user'  , $user);
		$this->assignRef('items'  , $rows);
		$this->assignRef('params', $params);

		parent::display($tpl);
	}
	
	function _displayBonuses($tpl = null)
	{
		global $mainframe;

		$user     =& JFactory::getUser();
		$params = &$mainframe->getParams();

		$document	= &JFactory::getDocument();
		$params->set('page_title',	JText::_( 'Bonuses' ));
		$document->setTitle( $params->get( 'page_title' ) );
		
		$this->assignRef('user'  , $user);
		$this->assignRef('params', $params);

		parent::display($tpl);
	}
	
	function _displayGiftCard($tpl = null)
	{
		global $mainframe;

		$params = &$mainframe->getParams();

		$document	= &JFactory::getDocument();
		$params->set('page_title',	JText::_( 'Gift Card' ));
		$document->setTitle( $params->get( 'page_title' ) );
		
		//$this->assignRef('user'  , $user);
		$this->assignRef('params', $params);

		parent::display($tpl);
	}
	
	function _displayPartner($tpl = null)
	{
		global $mainframe;

		$user     =& JFactory::getUser();
		if(!$user->partner){
			$mainframe->redirect(JRoute::_('index.php?option=com_user'), JText::_('You dont have permission'));
			return;
		}
		$params = &$mainframe->getParams();

		$document	= &JFactory::getDocument();
		$params->set('page_title',	JText::_( 'My partner' ));
		$document->setTitle( $params->get( 'page_title' ) );
		
		$db	=& JFactory::getDBO();
		
		$datestart	= JRequest::getVar( 'dateStart', '', '', 'string');
		$dateend	= JRequest::getVar( 'dateEnd', '', '', 'string');
		$report	= JRequest::getVar( 'report', '0', '', 'int');
		
		if ($datestart){		
			$dateStart = strtotime($datestart);					
		}else{		
			$dateStart = strtotime(date("Y-m-d"));
		}
		
		if ($dateend){		
			$dateEnd = strtotime($dateend);					
		}else{		
			$dateEnd = strtotime(date("Y-m-d"));
		}	
			
		if($report){
			if($user->partner==1){
				$query = 'SELECT COUNT(a.id) AS total, SUM(a.summ) AS summ'
				. ' FROM #__mos_partner_trans AS a'
				. ' WHERE a.userid = '.(int)$user->id.' AND a.type = 1 AND a.date>='.$db->Quote($datestart.' 00:00:00').' AND a.date<='.$db->Quote($dateend.' 23:59:59')
				;
				$db->setQuery( $query );
				$row = $db->loadObject();
			}else if($user->partner==2){
				$query = 'SELECT COUNT(a.id) AS total, SUM(a.summ) AS summ'
				. ' FROM #__mos_partner_trans AS a'
				. ' WHERE a.userid = '.(int)$user->id.' AND a.type = 2 AND a.date>='.$db->Quote($datestart.' 00:00:00').' AND a.date<='.$db->Quote($dateend.' 23:59:59')
				;
				$db->setQuery( $query );
				$row = $db->loadObject();
			}else if($user->partner==3){
				$query = 'SELECT COUNT(a.id) AS total, SUM(a.summ) AS summ'
				. ' FROM #__mos_partner_trans AS a'
				. ' WHERE a.userid = '.(int)$user->id.' AND a.type = 3 AND a.date>='.$db->Quote($datestart.' 00:00:00').' AND a.date<='.$db->Quote($dateend.' 23:59:59')
				;
				$db->setQuery( $query );
				$row = $db->loadObject();
					
				$query = 'SELECT COUNT(a.id) AS users'
				. ' FROM #__users AS a'
				. ' WHERE a.ref = '.(int)$user->id.' AND a.refUse=0'
				;
				$db->setQuery( $query );
				$row->users = $db->loadResult();
			}
		}
		
		$lists['dateStart'] = JHTML::_('calendar', date('Y-m-d', $dateStart), 'dateStart', 'dateStart', $format = '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'20',  'maxlength'=>'19'));
		$lists['dateEnd'] = JHTML::_('calendar', date('Y-m-d', $dateEnd), 'dateEnd', 'dateEnd', $format = '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'20',  'maxlength'=>'19'));
		$this->assignRef('user',$user);
		$this->assignRef('row',$row);
		$this->assignRef('report',$report);
		$this->assignRef('lists',$lists);	
		$this->assignRef('params', $params);

		parent::display($tpl);
	}
	
	function _displayTransaction($tpl = null)
	{
		global $mainframe;

		$user     =& JFactory::getUser();
		$params = &$mainframe->getParams();

		$document	= &JFactory::getDocument();

		$params->set('page_title',	JText::_( 'PAYMENTS HISTORY' ));
		$document->setTitle( $params->get( 'page_title' ) );
		
		$db	=& JFactory::getDBO();
		
		$where = array();
		$where[]='a.email='.$db->Quote($user->email);
		$where[]='a.status=1';
		$where[]='a.use<2';
										
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT COUNT(a.id)'
		. ' FROM #__mos_order AS a'
		. $where
		;
		
		$db->setQuery($query);
		$total = $db->loadResult();
		
		$query = 'SELECT SUM(b.sale/100*b.realPrice) AS summa'
		. ' FROM #__mos_order AS a'
		. ' LEFT JOIN #__mos_event AS b ON a.id_event = b.id'
		. $where
		;
		
		$db->setQuery($query);
		$summa = number_format($db->loadResult(),0,',', ' ' );
		
		$where = array();
		$where[]='a.userid='.(int)$user->id;
										
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		$orderby = ' ORDER BY a.date DESC';
		
		$query = 'SELECT a.*'
		. ' FROM #__mos_transaction AS a'
		. $where
		. $orderby
		;
		
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		// Set pathway information
		$this->assignRef('user'   , $user);
		$this->assignRef('total'   , $total);
		$this->assignRef('summa'   , $summa);
		$this->assignRef('items',		$rows);
		$this->assignRef('params',		$params);

		parent::display($tpl);
	}
}
