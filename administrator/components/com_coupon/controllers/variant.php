<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.controller' );


class ControllerVariant extends JController
{	
	function __construct()
	{					
		parent::__construct();							
	}
	
	function display()
	{			
		switch($this->getTask())
		{			
			case 'add'     :
			{					
				JRequest::setVar('view', 'variant');
				JRequest::setVar('edit', false);
				JRequest::setVar('hidemainmenu', 1);
			} break;
			case 'edit'    :
			{							    
				JRequest::setVar('view', 'variant');
				JRequest::setVar('edit', true);		
				JRequest::setVar('hidemainmenu', 1);				
			} break;			
			default : 						   
				JRequest::setVar('view', 'variants');			
				break;
		}				
		parent::display();
	}	
	
	function save()
	{
		global $mainframe;		

		JRequest::checkToken() or jexit( 'Invalid Token' );				

		$db			= & JFactory::getDBO();		
		 		
		$variant	= &new JVariant($db);
		
		$post	= JRequest::get( 'post' );

		if (!$variant->bind( $post ))
		{
			JError::raiseError(500, $variant->getError() );
		}		
				
		if (!$variant->store())
		{
			JError::raiseError(500, $variant->getError() );
		}			
				
		switch ( $this->getTask() )
		{
			case 'apply':
				$msg = JText::sprintf( 'SUCCESSFULLY SAVED CHANGE' );
				$this->setRedirect( 'index.php?option=com_coupon&controller=variant&view=variant&task=edit&cid[]='. $variant->get('id').'&tmpl=component&option_id='.$post['option_id'], $msg );
				break;

			case 'save':
			default:
				$msg = JText::sprintf( 'SUCCESSFULLY SAVED');				
				$this->setRedirect( 'index.php?option=com_coupon&controller=variant&view=variants&tmpl=component&option_id='.$post['option_id'], $msg );
				break;
		}
	}


	function apply()
	{
		$this->save();
	}
	
	function remove()
	{			
        JRequest::checkToken() or jexit( 'Invalid Token' );
		$db =& JFactory::getDBO();		
		$cid = JRequest::getVar( 'cid', array(), '', 'array' );
		$option_id = JRequest::getVar( 'option_id', '', 'int' );						
		JArrayHelper::toInteger( $cid );
		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'SELECT DELETE', true ) );
		}
		$msg = JText::sprintf( 'SUCCESSFULLY DELETED');	        
		foreach ($cid as $id)
		{					    			
		    $query = 'DELETE FROM #__mos_option_values WHERE value_id='.(int)$id;			
			$db->setQuery($query);
			$db->query();
			
			$variant = new JVariant($db);		    
			$variant->delete($id);
			unset($variant);										
			JRequest::setVar( 'task', 'remove' );
			JRequest::setVar( 'cid', $id );
		}
		$this->setRedirect( 'index.php?option=com_coupon&controller=variant&view=variants&tmpl=component&option_id='.$option_id, $msg);
	}		
}
?>