<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );

class ViewMap extends JView
{	
	function display($tpl = null)
	{
		$db =& JFactory::getDBO();
		$id = JRequest::getVar('id', '', '', 'int');
		require_once ('administrator'.DS.'components'.DS.'com_doc'.DS.'classes'.DS.'roo.php');
		$item =& new JRoo($db);		
		$item->load($id);
		
		$this->assignRef('item',$item);	
			
		parent::display($tpl);
	}
}
?>