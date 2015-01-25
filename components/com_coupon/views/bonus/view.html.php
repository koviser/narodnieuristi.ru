<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );
require_once (JPATH_COMPONENT.DS.'common.php');

class ViewBonus extends JView
{	
	function display($tpl = null)
	{
		$layout	= $this->getLayout();
		if( $layout == 'comments') {
			$this->_displayComments($tpl);
			return;
		}else if( $layout == 'payment' ){
			$this->_displayPayment($tpl);
			return;	
		}
		
		global $mainframe;
		$menus	= &JSite::getMenu();
		$menu   = $menus->getActive();
		$document	= & JFactory::getDocument();
		$pparams = &$mainframe->getParams('com_coupon');	
		
		$id = JRequest::getVar('id', '', '', 'int');
		
		if ($id=="")
		{
			return JError::raiseError( 404, JText::sprintf( 'Event # not found', $id ) );
		}


		$db	=& JFactory::getDBO();
		
		$where = array();
		$where[]='a.id='.(int)$id;
										
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT a.*'
		. ' FROM #__mos_event AS a'
		. $where
		. $orderby
		;
		
		$db->setQuery($query);
		$row = $db->loadObject();
		
		if ($row->id==""){
			return JError::raiseError( 404, JText::_( 'Event # not found') );
		}

		if($row->published==0 || $row->type==0){
			return JError::raiseError( 403, JText::_('Event not published') );
		}
		
		$row->count=JEventsCommon::GetCount($row->count);
		
		//
		$where = array();
		$where[]='a.type=0';
		$where[]='a.default=0';
		$where[]='a.published=1';
		$where[]='a.dateStart<="'.date('Y-m-d').'" AND a.dateEnd>="'.date('Y-m-d').'"';
										
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT a.*'
		. ' FROM #__mos_event AS a'
		. $where
		;
		
		$db->setQuery($query);
		$optional = $db->loadObjectList();
		//
		$db	=& JFactory::getDBO();
				
		$orderby = ' ORDER BY a.ordering ASC';	
		
		$where = array();
		$where[]='a.id_event='.(int)$row->id;
										
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT a.image'
		. ' FROM #__mos_image AS a'
		. $where
		. $orderby
		;
		
		$db->setQuery($query);
		$images = $db->loadObjectList();
		//
				//
		$db	=& JFactory::getDBO();
		
		$where = array();
		$where[]='a.id_event='.(int)$row->id;
										
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT a.*'
		. ' FROM #__mos_map AS a'
		. $where
		;
		
		$db->setQuery($query);
		$maps = $db->loadObjectList();

		if(count($maps)>1){
			$mapsParam=JEventsCommon::GetMap($maps);
			$pparams->set('x',	$mapsParam['x']);
			$pparams->set('y',	$mapsParam['y']);
			$pparams->set('scale', $mapsParam['scale']);	
		}else{
			$pparams->set('x',	$maps[0]->latitude);
			$pparams->set('y',	$maps[0]->longitude);
			$pparams->set('scale',15);		
		}
		//
		
		$pparams->set('page_title',	JText::_('Bonus'));
		$document->setTitle( strip_tags($row->title) );
		if($row->bgcolor!="" || $row->bgimage!=""){
			$background = ' style="background:';
			if ($row->bgimage!=""){
				$background .= 'url('.JURI::base().$row->bgimage.')';
			}
			if ($row->bgcolor!=""){
				$background .= ' #'.$row->bgcolor;
			}
			if ($row->bgimage!=""){
				$background .= ' '.$row->horizontal.' '.$row->vertical.' '.$row->bgrepeat;
			}
			$background .= ';"';	
			$document->set('background',$background);
		}
		//
		$user 		= JFactory::getUser();
		$pparams->set('user', $user->guest);
		//
		$this->assignRef('items',		$row);
		$this->assignRef('user',		$user);
		$this->assignRef('images',		$images);
		$this->assignRef('maps',		$maps);
		$this->assignRef('params',		$pparams);
		$this->assignRef('optional',	$optional);			
		parent::display($tpl);
	}
	function _displayComments($tpl = null)
	{
		global $mainframe;
		$menus	= &JSite::getMenu();
		$menu   = $menus->getActive();
		$document	= & JFactory::getDocument();
		$pparams = &$mainframe->getParams('com_coupon');	
		
		$id = JRequest::getVar('id', '', '', 'int');
		
		if ($id=="")
		{
			return JError::raiseError( 404, JText::sprintf( 'Event # not found', $id ) );
		}


		$db	=& JFactory::getDBO();
		
		$where = array();
		$where[]='a.id='.(int)$id;
										
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT a.*'
		. ' FROM #__mos_event AS a'
		. $where
		. $orderby
		;
		
		$db->setQuery($query);
		$row = $db->loadObject();
		
		if ($row->id==""){
			return JError::raiseError( 404, JText::_( 'Event # not found') );
		}

		if($row->published==0 || $row->type==0){
			return JError::raiseError( 403, JText::_('Event not published') );
		}
		
		$row->dateStarts=JEventsCommon::GetDate($row->dateStart, $row->dateEnd);
		$row->dateEnds=JEventsCommon::GetDateEndScript($row->dateEnd);
		$row->count=JEventsCommon::GetCount($row->count);
		if($row->dateEnd<date("Y-m-d")){
			$row->end=1;
		}
		//
		$where = array();
		$where[]='a.type=0';
		$where[]='a.default=0';
		$where[]='a.published=1';
		$where[]='a.dateStart<="'.date('Y-m-d').'" AND a.dateEnd>="'.date('Y-m-d').'"';
										
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT a.*'
		. ' FROM #__mos_event AS a'
		. $where
		;
		
		$db->setQuery($query);
		$optional = $db->loadObjectList();
		//
		$orderby = ' ORDER BY a.ordering ASC';	
		
		$where = array();
		$where[]='a.id_event='.(int)$row->id;
										
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT a.image'
		. ' FROM #__mos_image AS a'
		. $where
		. $orderby
		;
		
		$db->setQuery($query);
		$images = $db->loadObjectList();
		//
				//
		$db	=& JFactory::getDBO();
		
		$where = array();
		$where[]='a.id_event='.(int)$row->id;
										
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT a.*'
		. ' FROM #__mos_map AS a'
		. $where
		;
		
		$db->setQuery($query);
		$maps = $db->loadObjectList();

		if(count($maps)>1){
			$mapsParam=JEventsCommon::GetMap($maps);
			$pparams->set('x',	$mapsParam['x']);
			$pparams->set('y',	$mapsParam['y']);
			$pparams->set('scale', $mapsParam['scale']);	
		}else{
			$pparams->set('x',	$maps[0]->latitude);
			$pparams->set('y',	$maps[0]->longitude);
			$pparams->set('scale',15);		
		}
		//
		
		$pparams->set('page_title',	JText::_('Bonus'));
		$document->setTitle( strip_tags($row->title) );
		//
		$where = array();
		$where[]='a.id_event='.(int)$row->id;
		$where[]='a.published=1';
										
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT a.*'
		. ' FROM #__mos_comment AS a'
		. $where
		. ' ORDER BY a.id DESC'
		;
		
		$db->setQuery($query);
		$comment = $db->loadObjectList();
		//
		$user 		= JFactory::getUser();
		$this->assignRef('user',		$user);
		$this->assignRef('items',		$row);
		$this->assignRef('comment',		$comment);
		$this->assignRef('images',		$images);
		$this->assignRef('maps',		$maps);
		$this->assignRef('params',		$pparams);
		$this->assignRef('optional',	$optional);			
		parent::display($tpl);
	}
}
?>