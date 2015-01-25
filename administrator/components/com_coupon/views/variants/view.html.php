<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );

class ViewVariants extends JView
{	
	function display($tpl = null)
	{
		global $mainframe, $option;
		$db	=& JFactory::getDBO();				
		$filter_order		= JRequest::getVar('filter_order', 'a.title', 'cmd' );
		$filter_order_Dir	= JRequest::getVar('filter_order_Dir',	'',	'word' );
		$option_id = JRequest::getVar('option_id',	'',	'int');
		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
				
		$orderby = ' ORDER BY '. $filter_order .' '. $filter_order_Dir;		
		$where = array();
		$where[] = 'option_id='.$option_id;
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );		
		
		$query = 'SELECT COUNT(a.id)'
		. ' FROM #__mos_option_list AS a'	
		. $where		
		;		
		
		$db->setQuery( $query );
		$total = $db->loadResult();		

		jimport('joomla.html.pagination');
		$pagination = new JPagination( $total, $limitstart, $limit );

		$query = 'SELECT a.*'
		. ' FROM #__mos_option_list AS a'						
		. $where
		. $orderby
		;
		
		$db->setQuery( $query, $pagination->limitstart, $pagination->limit );
		$rows = $db->loadObjectList();
		
		$lists['order_Dir']	= $filter_order_Dir;
		$lists['order']		= $filter_order;							
		$lists['search']= $search;
								
		$this->assignRef('lists',		$lists);
		$this->assignRef('option_id',		$option_id);		
		$this->assignRef('items',		$rows);
		$this->assignRef('pagination',	$pagination);				
			
		parent::display($tpl);
	}
}
