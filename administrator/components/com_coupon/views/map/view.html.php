<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );


class ViewMap extends JView
{	
	function display($tpl = null)
	{
		$cid		= JRequest::getVar( 'cid', array(0), '', 'array' );				
		$edit		= JRequest::getVar('edit',true);		
		$uid 	= (int) @$cid[0];
		JArrayHelper::toInteger($cid, array(0));
		$db 		=& JFactory::getDBO();
		$map =& new JMap($db);		
		if($edit){				
			$map->load( $uid );
		}else{
			$map->latitude=55.754592892624366;
			$map->longitude=37.622854453921626;
		}
						
		$this->assignRef('map',$map);				
		
		parent::display($tpl);
	}
}
?>