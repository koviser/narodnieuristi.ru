<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );


class ViewMassmail extends JView
{	
	function display($tpl = null)
	{
		global $mainframe;
		
		//$lists['city'] 	= JCouponCommon::CityCombo($city, '', 1);
		$lists['group'] = JCouponCommon::GroupCombo($group);
								
		$this->assignRef('lists',		$lists);						
			
		parent::display($tpl);
	}
}
