<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );
require_once (JPATH_COMPONENT.DS.'common.php');

class ViewCompetitions extends JView
{	
	function display($tpl = null)
	{
		global $mainframe;

		$document	= & JFactory::getDocument();
		$pparams = &$mainframe->getParams('com_coupon');

		$db	=& JFactory::getDBO();
		
		$limit		= JRequest::getVar('limit', 30);
		$limitstart = JRequest::getVar('limitstart', 0 );
		
		$orderby = ' ORDER BY a.id DESC';
		
		$where = array();
		$where[]='a.published=1';
										
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		if($param->order){
			$orderby = $param->order;	
		}
		
		$query = 'SELECT COUNT(a.id)'
		. ' FROM #__mos_competition AS a'
		. $param->join
		. $where;
		
		$db->setQuery( $query );
		$total = $db->loadResult();	
		
		jimport('joomla.html.pagination');
		$pagination = new JPagination( $total, $limitstart, $limit );
		
		$query = 'SELECT a.*'
		. ' FROM #__mos_competition AS a'
		. $where
		. $orderby
		;
		
		$db->setQuery($query, $pagination->limitstart, $pagination->limit);
		$rows = $db->loadObjectList();

		//
		if($param->title){
			$document->setTitle($param->title);	
		}else{
			$document->setTitle(JText::_('COMPETITIONS'));
		}

		
		$this->assignRef('items',		$rows);
		$this->assignRef('user',		$user);
		$this->assignRef('pagination',	$pagination);
		$this->assignRef('params',		$pparams);		
		parent::display($tpl);
	}
}
?>