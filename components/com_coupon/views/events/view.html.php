<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );
require_once (JPATH_COMPONENT.DS.'common.php');

class ViewEvents extends JView
{	
	function display($tpl = null)
	{
		global $mainframe;
		$menus	= &JSite::getMenu();
		$menu   = $menus->getActive();
		$document	= & JFactory::getDocument();
		$pparams = &$mainframe->getParams('com_coupon');	
		$session  = JFactory::getSession();
		$city = $session->get('city');
		
		$month = JRequest::getVar('month', date('m'), '', 'int');
		$pparams->set('type', $type);
		$pparams->set('month', $month);

		$db	=& JFactory::getDBO();
		
		$start  = mktime(0, 0, 0, date("m")-11  , 1, date("Y"));
		
		$orderby = ' ORDER BY a.dateStart ASC';
		
		$where = array();
		$where[]='a.city='.(int)$city;
		$where[]='a.type=0';
		$where[]='a.vip=0';
		$where[]='a.published=1';
		$where[]='MONTH(a.dateStart)='.(int)$month;
		$where[]='a.dateEnd>='.date('Y-m-d',$start);
		$where[]='a.dateEnd<"'.date("Y-m-d").'"';
										
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT a.*, DAY(a.dateStart) AS start'
		. ' FROM #__mos_event AS a'
		. $where
		. $orderby
		;
		
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		
		//
		$orderby = ' ORDER BY a.dateStart ASC';
		
		$where = array();
		$where[]='a.city='.(int)$city;
		$where[]='a.type=0';
		$where[]='a.vip=0';
		$where[]='a.dateEnd>='.date('Y-m-d',$start);
		$where[]='a.published=1';
		$where[]='a.dateEnd<"'.date("Y-m-d").'"';
										
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT MONTH(a.dateStart) AS month, COUNT(*) AS count'
		. ' FROM #__mos_event AS a'
		. $where
		. ' GROUP BY MONTH(a.dateStart)'
		;
		
		$db->setQuery($query);
		$month = $db->loadObjectList();
		for($i=0;$i<count($month);$i++){
			$count[$month[$i]->month]->count=$month[$i]->count;
		}
		//

		$pparams->set('page_title',	JText::_('FINISHED ACTION'));
		$document->setTitle($pparams->get( 'page_title' ));
		
		$this->assignRef('items',		$rows);
		$this->assignRef('month',		$count);
		$this->assignRef('params',		$pparams);		
		parent::display($tpl);
	}
}
?>