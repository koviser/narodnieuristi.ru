<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );


class ViewSubscribe extends JView
{	
	function display($tpl = null)
	{
		global $mainframe, $option;
		$db	=& JFactory::getDBO();				
		
		//$city	= JRequest::getVar('city', '0', 'post', 'int' );
		$group	= JRequest::getVar('group', '1', 'post', 'int' );
		$filter_order		= JRequest::getVar('filter_order', 'a.dateStart', 'cmd' );
		$filter_order_Dir	= JRequest::getVar('filter_order_Dir',	'desc',	'word' );				
		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
				
		$orderby = ' ORDER BY '. $filter_order .' '. $filter_order_Dir;		
		$where = array();
		if (isset( $search ) && $search!= '')
		{
			$searchEscaped = $db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
			$where[] = 'a.adress LIKE '.$searchEscaped;
		}
			
		$where[] = 'a.type=0';
		//$where[] = 'a.city='.(int)$city;
		$where[] = 'a.published=1';
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );		
		
		$query = 'SELECT COUNT(a.id)'
		. ' FROM #__mos_event AS a'	
		. $where		
		;		
		
		$db->setQuery( $query );
		$total = $db->loadResult();		

		jimport('joomla.html.pagination');
		$pagination = new JPagination( $total, $limitstart, $limit );

		$query = 'SELECT a.*'
		. ' FROM #__mos_event AS a'						
		. $where
		. $orderby
		;
		
		$db->setQuery( $query, $pagination->limitstart, $pagination->limit );
		$rows = $db->loadObjectList();
		
		$lists['order_Dir']	= $filter_order_Dir;
		$lists['order']		= $filter_order;							
		$lists['search']= $search;
		//$lists['city'] 	= JCouponCommon::CityCombo($city, 'onchange="this.form.submit();"');
		$lists['group'] = JCouponCommon::GroupCombo($group);
								
		$this->assignRef('lists',		$lists);		
		$this->assignRef('items',		$rows);
		$this->assignRef('pagination',	$pagination);				
			
		parent::display($tpl);
	}
}
