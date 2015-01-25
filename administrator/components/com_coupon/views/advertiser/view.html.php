<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );


class ViewAdvertiser extends JView
{	
	function display($tpl = null)
	{
		global $mainframe, $option;
		$db	=& JFactory::getDBO();				
		$filter_order		= JRequest::getVar('filter_order', 'a.username', 'cmd' );
		$filter_order_Dir	= JRequest::getVar('filter_order_Dir',	'desc',	'word' );					
		$search				= $mainframe->getUserStateFromRequest( "$option.search",			'search', 			'',			'string' );
		$search				= JString::strtolower( $search );
		
		$orderby = ' ORDER BY '. $filter_order .' '. $filter_order_Dir;		
		$where = array();
		if (isset( $search ) && $search!= '')
		{
			$searchEscaped = $db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
			$where[] = 'a.name LIKE '.$searchEscaped.' OR a.family LIKE '.$searchEscaped.' OR a.username LIKE '.$searchEscaped.' OR a.email LIKE '.$searchEscaped;
		}
		
		$where[] = 'a.advertiser=1';
			
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );		
		
		$limit		= JRequest::getVar('limit', 20 );
		$limitstart = JRequest::getVar('limitstart', 0 );
		$query = 'SELECT COUNT(a.id)'
		. ' FROM #__users AS a'	
		. $where		
		;		
		
		$db->setQuery( $query );
		$total = $db->loadResult();	

		jimport('joomla.html.pagination');
		$pagination = new JPagination( $total, $limitstart, $limit );
		
		$query = 'SELECT a.id , a.name, a.family, a.username'
		. ' FROM #__users AS a'		
		. $where
		. $orderby
		;
		
		$db->setQuery( $query, $pagination->limitstart, $pagination->limit );
		$rows = $db->loadObjectList();
		
		
		$lists['order_Dir']	= $filter_order_Dir;
		$lists['order']		= $filter_order;							
		$lists['search']= $search;
		JHTML::_('behavior.modal');
		JHTML::_('behavior.tooltip');
		
		$this->assignRef('lists',		$lists);		
		$this->assignRef('items',		$rows);
		$this->assignRef('pagination',	$pagination);				
			
		parent::display($tpl);
	}
}
