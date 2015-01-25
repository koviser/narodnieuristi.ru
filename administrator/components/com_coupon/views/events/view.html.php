<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );


class ViewEvents extends JView
{	
	function display($tpl = null)
	{
		global $mainframe, $option;
		$db	=& JFactory::getDBO();				
		$filter_order		= JRequest::getVar('filter_order', 'a.ordering', 'cmd' );
		$filter_order_Dir	= JRequest::getVar('filter_order_Dir',	'desc',	'word' );			
		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
		$status	= JRequest::getVar('status', '0', '', 'int' );
		$catid = JRequest::getVar('catid', '0', '', 'int' );
		//$city = JRequest::getVar('cityid', '0', 'post', 'int' );
				
		$orderby = ' ORDER BY '. $filter_order .' '. $filter_order_Dir;
					
		$where = array();
		if (isset( $search ) && $search!= '')
		{
			$searchEscaped = $db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
			$where[] = 'a.adress LIKE '.$searchEscaped;
		}
		if($catid){
			$where[] = 'a.catid='.(int)$catid;	
		}
		$where[] = 'a.type=0';
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );		
		
		$query = 'SELECT COUNT(a.id)'
		. ' FROM #__mos_event AS a'	
		. $where		
		;		
		
		$db->setQuery( $query );
		$total = $db->loadResult();
		
			

		jimport('joomla.html.pagination');
		$pagination = new JPagination( $total, $limitstart, $limit );

		$query = 'SELECT a.*, c.title AS category'
		. ' FROM #__mos_event AS a'
		. ' LEFT JOIN #__mos_category AS c ON a.catid=c.id' 						
		. $where
		. $orderby
		;
		
		$db->setQuery( $query, $pagination->limitstart, $pagination->limit );
		$rows = $db->loadObjectList();
		
		$lists['order_Dir']	= $filter_order_Dir;
		$lists['order']		= $filter_order;							
		$lists['search']= $search;
		//$lists['status'] 	= JCouponCommon::StatusCombo($status, 'onchange="this.form.submit();"');
		$lists['category'] 	= JCouponCommon::CategoryCombo2($catid, 'onchange="this.form.submit();"');
		//$lists['city'] 	= JCouponCommon::CityCombo2($city, 'onchange="this.form.submit();"');
								
		$this->assignRef('lists',		$lists);		
		$this->assignRef('items',		$rows);
		$this->assignRef('pagination',	$pagination);				
			
		parent::display($tpl);
	}
}
