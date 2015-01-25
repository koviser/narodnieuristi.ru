<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );
require_once (JPATH_COMPONENT.DS.'common.php');

class ViewVip extends JView
{	
	function display($tpl = null)
	{
		global $mainframe;

		$document	= & JFactory::getDocument();
		$pparams = &$mainframe->getParams('com_coupon');
		
		$session  = JFactory::getSession();
		$user = $session->get('user');

		$db	=& JFactory::getDBO();
		
		$limit		= JRequest::getVar('limit', 20);
		$limitstart = JRequest::getVar('limitstart', 0 );
		$orderby = ' ORDER BY a.id DESC';
		
		$where = array();
		$where[]='a.vip=1';
		$where[]='a.type=0';
		$where[]='a.published=1';
		$where[]='a.dateStart<='.$db->Quote(date('Y-m-d'));
		$where[]='a.dateEnd>='.$db->Quote(date('Y-m-d'));
										
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		/*
		if($param->order){
			$orderby = $param->order;	
		}
		*/
		$query = 'SELECT COUNT(a.id)'
		. ' FROM #__mos_event AS a'
		//. $param->join
		. $where;
		
		$db->setQuery( $query );
		$total = $db->loadResult();	
		
		jimport('joomla.html.pagination');
		$pagination = new JPagination( $total, $limitstart, $limit );
		
		$query = 'SELECT a.id, a.image, a.title, a.sale, a.dateEnd, a.price, a.realPrice, a.count'
		. ' FROM #__mos_event AS a'
		//. $param->join
		. $where
		. $orderby
		;
		
		$db->setQuery($query, $pagination->limitstart, $pagination->limit);
		$rows = $db->loadObjectList();

		for($i=0;$i<count($rows);$i++){
			$rows[$i]->dateEnds=JEventsCommon::GetDateEndScript($rows[$i]->dateEnd);
		}
		//
		$document->setTitle(JText::_('VIP EVENT'));
		if($param->title){
			$document->setTitle($param->title);	
		}

		if(count($rows)>0){
			$pparams->set('page_title',	JText::_('VIP EVENT'));
			if($param->title){
				$pparams->set('page_title',$param->title);	
			}
		}else{
			$pparams->set('page_title',	JText::_('No Event'));
		}
		
		$this->assignRef('items',		$rows);
		$this->assignRef('user',		$user);
		$this->assignRef('pagination',	$pagination);
		$this->assignRef('params',		$pparams);		
		parent::display($tpl);
	}
}
?>