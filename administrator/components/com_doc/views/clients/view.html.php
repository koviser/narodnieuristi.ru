<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );


class ViewClients extends JView
{	
	function display($tpl = null)
	{
		global $mainframe, $option;
		$db	=& JFactory::getDBO();				
		$filter_order		= JRequest::getVar('filter_order', 'a.id', 'cmd' );
		$filter_order_Dir	= JRequest::getVar('filter_order_Dir',	'desc',	'word' );			
		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
		//$city = JRequest::getVar('cityid', '0', 'post', 'int' );
				
		$orderby = ' ORDER BY '. $filter_order .' '. $filter_order_Dir;
					
		$where = array();
		if (isset( $search ) && $search!= '')
		{
			$searchEscaped = $db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
			$where[] = 'a.name_client LIKE '.$searchEscaped;
		}
		
		$user = JFactory::getUser();
		
		if($user->id_roo){
			$where[] = 'a.id_roo='.$user->id_roo;	
		}

		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );		
		
		$query = 'SELECT COUNT(a.id)'
		. ' FROM #__7t_doc_clients AS a'	
		. $where		
		;		
		
		$db->setQuery( $query );
		$total = $db->loadResult();
		
			

		jimport('joomla.html.pagination');
		$pagination = new JPagination( $total, $limitstart, $limit );

		$query = 'SELECT a.*, c.name AS consultant, t.title AS type'
		. ' FROM #__7t_doc_clients AS a'
		. ' LEFT JOIN #__7t_doc_workers AS c ON a.id_consultant=c.id'
		. ' LEFT JOIN #__7t_doc_types AS t ON a.id_type=t.id' 						
		. $where
		. $orderby
		;
		
		$db->setQuery( $query, $pagination->limitstart, $pagination->limit );
		$rows = $db->loadObjectList();
		
		$lists['order_Dir']	= $filter_order_Dir;
		$lists['order']		= $filter_order;							
		$lists['search']= $search;
		//$lists['status'] 	= JCouponCommon::StatusCombo($status, 'onchange="this.form.submit();"');
		//$lists['category'] 	= JCouponCommon::CategoryCombo2($catid, 'onchange="this.form.submit();"');
		//$lists['city'] 	= JCouponCommon::CityCombo2($city, 'onchange="this.form.submit();"');
								
		$this->assignRef('lists',		$lists);		
		$this->assignRef('items',		$rows);
		$this->assignRef('pagination',	$pagination);				
			
		parent::display($tpl);
	}
}
