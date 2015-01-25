<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );


class ViewTransaction extends JView
{	
	function display($tpl = null)
	{
		global $mainframe, $option;
		$db	=& JFactory::getDBO();				
		
		$filter_order		= JRequest::getVar('filter_order', 'a.id', 'cmd' );
		$filter_order_Dir	= JRequest::getVar('filter_order_Dir',	'desc',	'word' );				
		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
		$search				= JRequest::getVar('search', '', 'string' );
		$search				= JString::strtolower( $search );
				
		$orderby = ' ORDER BY '. $filter_order .' '. $filter_order_Dir;		
		$where = array();
		if (isset( $search ) && $search!= '')
		{
			$searchEscaped = $db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
			$where[] = 'a.userid LIKE '.$searchEscaped.' OR u.email LIKE '.$searchEscaped;
		}
		
		$type	= JRequest::getVar('type', '0', 'post', 'int' );
		if($type){
			$where[] = 'a.type='.(int)$type;
		}
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );		
		
		$query = 'SELECT COUNT(a.id)'
		. ' FROM #__mos_transaction AS a'	
		. $where		
		;		
		
		$db->setQuery( $query );
		$total = $db->loadResult();		

		jimport('joomla.html.pagination');
		$pagination = new JPagination( $total, $limitstart, $limit );

		$query = 'SELECT a.*, u.email'
		. ' FROM #__mos_transaction AS a'	
		. ' LEFT JOIN #__users AS u ON u.id=a.userid'						
		. $where
		. $orderby
		;
		
		$db->setQuery( $query, $pagination->limitstart, $pagination->limit );
		$rows = $db->loadObjectList();
		
		$lists['order_Dir']	= $filter_order_Dir;
		$lists['order']		= $filter_order;							
		$lists['search']= $search;
		$lists['type'] 	= JCouponCommon::TypeCombo($type, 'onchange="this.form.submit();"');
								
		$this->assignRef('lists',		$lists);		
		$this->assignRef('items',		$rows);
		$this->assignRef('pagination',	$pagination);				
			
		parent::display($tpl);
	}
}
