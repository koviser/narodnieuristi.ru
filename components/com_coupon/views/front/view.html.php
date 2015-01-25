<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );
require_once (JPATH_COMPONENT.DS.'common.php');

class ViewFront extends JView
{	
	function display($tpl = null)
	{
		global $mainframe;
		
		$layout	= $this->getLayout();
		if( $layout == 'comments') {
			$this->_displayComments($tpl);
			return;
		}
		
		$menus	= &JSite::getMenu();
		$menu   = $menus->getActive();
		$document	= & JFactory::getDocument();
		$pparams = &$mainframe->getParams('com_mocskidka');	

		$db	=& JFactory::getDBO();
				
		$orderby = ' ORDER BY a.dateStart ASC';	
		
		$where = array();
		$where[]='a.type=0';
		$where[]='a.default=1';
		$where[]='a.published=1';
		$where[]='a.dateStart>="'.date('Y-m-d').'" OR a.dateEnd>="'.date('Y-m-d').'"';
										
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT a.*'
		. ' FROM #__mos_event AS a'
		. $where
		. $orderby
		;
		
		$db->setQuery($query, 0, 1);
		$row = $db->loadObject();
		if($row==""){
			$orderby = ' ORDER BY a.dateStart DESC';	
		
			$where = array();
			$where[]='a.type=0';
			$where[]='a.default=1';
			$where[]='a.published=1';
											
			$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
			
			$query = 'SELECT a.*'
			. ' FROM #__mos_event AS a'
			. $where
			. $orderby
			;
			
			$db->setQuery($query, 0, 1);
			$row = $db->loadObject();
		}
		
		$row->dateStarts=JEventsCommon::GetDate($row->dateStart, $row->dateEnd);
		$row->dateEnds=JEventsCommon::GetDateEndScript($row->dateEnd);
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
		
		$pparams->set('page_title',	$row->dateStarts);
		$document->setTitle( strip_tags($row->title) );
		$document->setDescription( str_replace("\n", " ", strip_tags($row->features)) );
		//
		$this->assignRef('items',		$row);
		$this->assignRef('images',		$images);
		$this->assignRef('maps',		$maps);
		$this->assignRef('optional',	$optional);	
		$this->assignRef('params',		$pparams);		
		parent::display($tpl);
	}
	
	function _displayComments($tpl = null){
		global $mainframe;
		
		$menus	= &JSite::getMenu();
		$menu   = $menus->getActive();
		$document	= & JFactory::getDocument();
		$pparams = &$mainframe->getParams('com_mocskidka');	

		$db	=& JFactory::getDBO();
				
		$orderby = ' ORDER BY a.dateStart ASC';	
		
		$where = array();
		$where[]='a.type=0';
		$where[]='a.default=1';
		$where[]='a.published=1';
		$where[]='a.dateStart>="'.date('Y-m-d').'" OR a.dateEnd>="'.date('Y-m-d').'"';
										
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT a.*'
		. ' FROM #__mos_event AS a'
		. $where
		. $orderby
		;
		
		$db->setQuery($query, 0, 1);
		$row = $db->loadObject();
		
		if($row==""){
			$orderby = ' ORDER BY a.dateStart DESC';	
		
			$where = array();
			$where[]='a.type=0';
			$where[]='a.default=1';
			$where[]='a.published=1';
											
			$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
			
			$query = 'SELECT a.*'
			. ' FROM #__mos_event AS a'
			. $where
			. $orderby
			;
			
			$db->setQuery($query, 0, 1);
			$row = $db->loadObject();
		}
		
		$row->dateStarts=JEventsCommon::GetDate($row->dateStart, $row->dateEnd);
		$row->dateEnds=JEventsCommon::GetDateEndScript($row->dateEnd);
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
		
		$pparams->set('page_title',	$row->dateStarts);
		$document->setTitle( strip_tags($row->title) );
		$document->setDescription( str_replace("\n", " ", strip_tags($row->features)) );
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
		$this->assignRef('items',		$row);
		$this->assignRef('comment',		$comment);
		$this->assignRef('images',		$images);
		$this->assignRef('maps',		$maps);
		$this->assignRef('optional',	$optional);	
		$this->assignRef('params',		$pparams);		
		parent::display($tpl);		
	}
	
}
?>