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
			JError::raiseError( 403, JText::_('Access Forbidden') );
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
		}else if( $layout == 'password') {
			$this->_displayPassword($tpl);
			return;
		}else if( $layout == 'subscribe') {
			$this->_displaySubscribe($tpl);
			return;
		}

		if ( $layout == 'login' ) {
			parent::display($tpl);
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
		
		$month = JRequest::getVar('m', date('m'), 'get', 'int');
		$status = JRequest::getVar('status', 1, '', 'int');
		$params->set('month', $month);
		
		$orderby = ' ORDER BY a.date ASC';
		
		$start  = mktime(0, 0, 0, date("m")-11  , 1, date("Y"));
		
		$where = array();
		$where[]='a.email="'.$user->email.'"';
		$where[]='a.status='.(int)$status;
		$where[]='MONTH(a.date)='.(int)$month;
		$where[]='a.date>='.date('Y-m-d',$start);
										
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT a.date, a.password, b.title, b.sale, b.id, b.dateUsed, DAY(a.date) AS day, a.id AS coupon, b.type'
		. ' FROM #__mos_order AS a'
		. ' LEFT JOIN #__mos_event AS b ON a.id_event = b.id'
		. $where
		. $orderby
		;
		
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		
		//
		$where = array();
		$where[]='a.email="'.$user->email.'"';
		$where[]='a.status='.(int)$status;
		$where[]='a.date>='.date('Y-m-d',$start);
										
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT MONTH(a.date) AS month, COUNT(*) AS count'
		. ' FROM #__mos_order AS a'
		. $where
		. ' GROUP BY MONTH(a.date)'
		;
		$db->setQuery($query);
		$month = $db->loadObjectList();
		
		for($i=0;$i<count($month);$i++){
			$count[$month[$i]->month]->count=$month[$i]->count;
		}
		//

		// Set pathway information
		$this->assignRef('user'   , $user);
		$this->assignRef('items',		$rows);
		$this->assignRef('month',		$count);
		$this->assignRef('params',		$params);

		parent::display($tpl);
	}

	function _displayEdit($tpl = null)
	{
		global $mainframe;

		//JHTML::_('behavior.formvalidation');

		$user     =& JFactory::getUser();
		$params = &$mainframe->getParams();

		$document	= &JFactory::getDocument();
		$params->set('page_title',	JText::_( 'Edit Your Details' ));
		$document->setTitle( $params->get( 'page_title' ) );
		
		$lists['gender'] 	= JEventsCommon::GenderCombo($user->gender);
		
		$time_day = substr($user->birthDay, 8, 2);
		$time_month = substr($user->birthDay, 5, 2);
		$time_year = substr($user->birthDay, 0, 4);
		if($time_year==0)$time_year=1980;
		
		if($user->name==$user->email) $user->name="";
			
		$lists['birthDay'] 	= JHTML::_('select.datelist', $time_day, $time_month, $time_year);

		$this->assignRef('user'  , $user);
		$this->assignRef('lists'  , $lists);
		$this->assignRef('params', $params);

		parent::display($tpl);
	}
	function _displayPassword($tpl = null)
	{
		global $mainframe;

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
}
