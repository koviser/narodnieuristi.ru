<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );


class ViewOptions extends JView
{	
	function display($tpl = null)
	{
		global $mainframe, $option;
		$db	=& JFactory::getDBO();				
		$filter_order		= JRequest::getVar('filter_order', 'a.title', 'cmd' );
		$filter_order_Dir	= JRequest::getVar('filter_order_Dir',	'',	'word' );				
		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
				
		$orderby = ' ORDER BY '. $filter_order .' '. $filter_order_Dir;		
	
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );	
		
		$query = 'SELECT COUNT(a.id)'
		. ' FROM #__mos_options AS a'	
		. $where		
		;		
		
		$db->setQuery( $query );
		$total = $db->loadResult();		

		jimport('joomla.html.pagination');
		$pagination = new JPagination( $total, $limitstart, $limit );

		$query = 'SELECT a.*, b.title AS category'
		. ' FROM #__mos_options AS a'
		. ' LEFT JOIN #__mos_category AS b ON a.catid=b.id'			
		. $where
		. $orderby
		;
		
		$db->setQuery( $query, $pagination->limitstart, $pagination->limit );
		$rows = $db->loadObjectList();
		
		$lists['order_Dir']	= $filter_order_Dir;
		$lists['order']		= $filter_order;							
								
		$this->assignRef('lists',		$lists);		
		$this->assignRef('items',		$rows);
		$this->assignRef('pagination',	$pagination);				
			
		parent::display($tpl);
	}
}
