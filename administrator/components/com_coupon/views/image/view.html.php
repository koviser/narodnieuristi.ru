<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );


class ViewImage extends JView
{	
	function display($tpl = null)
	{
		$cid		= JRequest::getVar( 'cid', array(0), '', 'array' );				
		$edit		= JRequest::getVar('edit',true);		
		$uid 	= (int) @$cid[0];
		JArrayHelper::toInteger($cid, array(0));
		$db 		=& JFactory::getDBO();
		$image =& new JImage($db);		
		if($edit){				
			$image->load( $uid );
			$image->image ='../images/slider/big_'.$image->image;
		}
						
		$this->assignRef('image',$image);				
		
		parent::display($tpl);
	}
}
?>