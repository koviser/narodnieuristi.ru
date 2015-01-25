<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );
require_once (JPATH_COMPONENT.DS.'common.php');

class ViewCompetition extends JView
{	
	function display($tpl = null)
	{
		
		global $mainframe;
		
		$layout	= $this->getLayout();
		if( $layout == 'table' ){
			$this->_displayTable($tpl);
			return;	
		} else if( $layout == 'photo' ){
			$this->_displayPhoto($tpl);
			return;	
		}
		
		$menus	= &JSite::getMenu();
		$menu   = $menus->getActive();
		$document	= & JFactory::getDocument();
		$pparams = &$mainframe->getParams('com_coupon');	
		
		$id = JRequest::getVar('id', '', '', 'int');
		
		if ($id=="")
		{
			return JError::raiseError( 404, JText::sprintf( 'Competition # not found', $id ) );
		}


		$db	=& JFactory::getDBO();
		
		$where = array();
		$where[]='a.id='.(int)$id;
										
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT a.*'
		. ' FROM #__mos_competition AS a'
		. $where
		. $orderby
		;
		
		$db->setQuery($query);
		$row = $db->loadObject();
		
		if ($row->id==""){
			return JError::raiseError( 404, JText::_( 'Competition # not found') );
		}

		if($row->published==0){
			return JError::raiseError( 403, JText::_('Competition # not published') );
		}
		
		$row->dateEnds=JEventsCommon::GetDateEndScript($row->dateEnd);
	
		$document->setTitle( strip_tags($row->title) );
		$document->setDescription( strip_tags($row->title) );
		//
		$this->assignRef('items',		$row);
		$this->assignRef('params',		$pparams);	
		parent::display($tpl);
	}
	
	function _displayTable($tpl = null)
	{
		global $mainframe;
		
		$menus	= &JSite::getMenu();
		$menu   = $menus->getActive();
		$document	= & JFactory::getDocument();
		$pparams = &$mainframe->getParams('com_coupon');	
		
		$id = JRequest::getVar('id', '', '', 'int');
		
		if ($id=="")
		{
			return JError::raiseError( 404, JText::sprintf( 'Competition # not found', $id ) );
		}


		$db	=& JFactory::getDBO();
		
		$where = array();
		$where[]='a.id='.(int)$id;
										
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT a.*'
		. ' FROM #__mos_competition AS a'
		. $where
		. $orderby
		;
		
		$db->setQuery($query);
		$row = $db->loadObject();
		
		if ($row->id==""){
			return JError::raiseError( 404, JText::_( 'Competition # not found') );
		}

		if($row->published==0 || $row->type==2){
			return JError::raiseError( 403, JText::_('Competition # not published') );
		}
		
		$row->dateEnds=JEventsCommon::GetDateEndScript($row->dateEnd);
	
		$document->setTitle( strip_tags($row->title) );
		$document->setDescription( strip_tags($row->title) );
		
		$where = array();
		if($row->type==1){
			$where[]='a.type=2 OR a.type=3';
		}else{
			$where[]='a.type=5';
		}
		$where[]='a.date>='.$db->Quote($row->dateStart);
		$where[]='a.date<='.$db->Quote($row->dateEnd);
										
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );

		if($row->type==1){
			$query = 'SELECT u.name, u.family, u.email, SUM(a.sum) AS total'
			. ' FROM #__mos_transaction AS a'
			. ' LEFT JOIN #__users AS u ON a.userid=u.id' 
			. $where
			. ' GROUP BY a.userid ORDER BY total DESC'
			;
		}else{
			$query = 'SELECT u.name, u.family, u.email, COUNT(a.id) AS total'
			. ' FROM #__mos_transaction AS a'
			. ' LEFT JOIN #__users AS u ON a.userid=u.id' 
			. $where
			. ' GROUP BY a.userid ORDER BY total DESC'
			;
		}
		
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		//
		$this->assignRef('items',		$rows);
		$this->assignRef('item',		$row);
		$this->assignRef('params',		$pparams);	
		parent::display($tpl);
	}
	
	function _displayPhoto($tpl = null)
	{
		global $mainframe;
		
		$menus	= &JSite::getMenu();
		$menu   = $menus->getActive();
		$document	= & JFactory::getDocument();
		$pparams = &$mainframe->getParams('com_coupon');	
		
		$id = JRequest::getVar('id', '', '', 'int');
		
		if ($id=="")
		{
			return JError::raiseError( 404, JText::sprintf( 'Competition # not found', $id ) );
		}


		$db	=& JFactory::getDBO();
		
		$where = array();
		$where[]='a.id='.(int)$id;
										
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT a.*'
		. ' FROM #__mos_competition AS a'
		. $where
		. $orderby
		;
		
		$db->setQuery($query);
		$row = $db->loadObject();
		
		if ($row->id==""){
			return JError::raiseError( 404, JText::_( 'Competition # not found') );
		}

		if($row->published==0 || $row->type!=2){
			return JError::raiseError( 403, JText::_('Competition # not published') );
		}
		
		$row->dateEnds=JEventsCommon::GetDateEndScript($row->dateEnd);
	
		$document->setTitle( strip_tags($row->title) );
		$document->setDescription( strip_tags($row->title) );
		
		$where = array();
		$where[]='a.comid='.(int)$id;
										
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );

		$query = 'SELECT a.*, u.name, u.family, u.email'
		. ' FROM #__mos_photos AS a'
		. ' LEFT JOIN #__users AS u ON u.id=a.userid'
		. $where
		. ' ORDER BY a.raiting DESC'
		;
		
		$db->setQuery($query);
		$rows = $db->loadObjectList();
				
		$user = JFactory::getUser();
		//
		$this->assignRef('items',		$rows);
		$this->assignRef('user',		$user);
		$this->assignRef('item',		$row);
		$this->assignRef('params',		$pparams);	
		parent::display($tpl);
	}
}
?>