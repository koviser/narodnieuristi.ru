<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );
require_once (JPATH_COMPONENT.DS.'common.php');

class ViewBonuses extends JView
{	
	function display($tpl = null)
	{
		global $mainframe;
		$menus	= &JSite::getMenu();
		$menu   = $menus->getActive();
		$document	= & JFactory::getDocument();
		$pparams = &$mainframe->getParams('com_coupon');	
		
		$month = JRequest::getVar('month', date('m'), '', 'int');

		$db	=& JFactory::getDBO();
		
		$where = array();
		$where[]='a.type=1';
		$where[]='a.published=1';
										
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT a.*'
		. ' FROM #__mos_event AS a'
		. $where
		;
		
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		$pparams->set('page_title',	JText::_('BONUS ACTION'));
		$document->setTitle($pparams->get( 'page_title' ));
		
		$this->assignRef('items',		$rows);
		$this->assignRef('params',		$pparams);		
		parent::display($tpl);
	}
}
?>