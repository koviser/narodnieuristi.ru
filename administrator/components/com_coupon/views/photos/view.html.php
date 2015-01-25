<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );


class ViewPhotos extends JView
{	
	function display($tpl = null)
	{
		global $mainframe, $option;
		$db	=& JFactory::getDBO();				
		$filter_order		= JRequest::getVar('filter_order', 'a.id', 'cmd' );
		$filter_order_Dir	= JRequest::getVar('filter_order_Dir',	'DESC',	'word' );				
		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
		
		$id_event = JRequest::getVar('id_event');
		
		jimport('joomla.html.pagination');
		$pagination = new JPagination( $total, $limitstart, $limit );
		
		$query = 'SELECT title FROM #__mos_competition WHERE id='.(int)$id_event;
		$db->setQuery($query);
		$text = $db->loadResult();
				
		$orderby = ' ORDER BY '. $filter_order .' '. $filter_order_Dir;		
		$where = array();
		$where[]= 'comid='.$id_event ;
				
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );		
			
		$query = 'SELECT COUNT(a.id)'
		. ' FROM #__mos_photos AS a'	
		. $where		
		;		
			
		$db->setQuery( $query );
		$total = $db->loadResult();
	
		$query = 'SELECT a.*'
		. ' FROM #__mos_photos AS a'						
		. $where
		. $orderby
		;
			
		$db->setQuery( $query, $pagination->limitstart, $pagination->limit );
		$rows = $db->loadObjectList();
		
		$lists['order_Dir']	= $filter_order_Dir;
		$lists['order']		= $filter_order;							
		$lists['search']= $search;
								
		$this->assignRef('lists',		$lists);
		$this->assignRef('text',		$text);		
		$this->assignRef('items',		$rows);
		$this->assignRef('pagination',	$pagination);				
			
		parent::display($tpl);
	}
}
