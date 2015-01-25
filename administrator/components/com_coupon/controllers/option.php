<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.controller' );


class ControllerOption extends JController
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
				JRequest::setVar('view', 'option');
				JRequest::setVar('edit', false);
				JRequest::setVar('hidemainmenu', 1);
			} break;
			case 'edit'    :
			{							    
				JRequest::setVar('view', 'option');
				JRequest::setVar('edit', true);		
				JRequest::setVar('hidemainmenu', 1);				
			} break;			
			default : 						   
				JRequest::setVar('view', 'options');			
				break;
		}				
		parent::display();
	}	
	
	function save()
	{
		global $mainframe;		
		
		JRequest::checkToken() or jexit( 'Invalid Token' );				

		$db			= & JFactory::getDBO();		
		 		
		$option	= &new JOption($db);
		
		$post	= JRequest::get( 'post' );
		if (!$option->bind( $post ))
		{
			JError::raiseError(500, $option->getError() );
		}
				
		if (!$option->store())
		{
			JError::raiseError(500, $option->getError() );
		}

				
		switch ( $this->getTask() )
		{
			case 'apply':
				$msg = JText::sprintf( 'SUCCESSFULLY SAVED CHANGE' );
				$this->setRedirect( 'index.php?option=com_coupon&controller=option&view=option&task=edit&cid[]='.$option->get('id'), $msg );
				break;

			case 'save':
			default:
				$msg = JText::sprintf( 'SUCCESSFULLY SAVED');				
				$this->setRedirect( 'index.php?option=com_coupon&controller=option&view=options', $msg );
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
		JArrayHelper::toInteger( $cid );
		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'SELECT DELETE', true ) );
		}        
		foreach ($cid as $id)
		{					    			
		    $query = 'DELETE a FROM #__mos_option_values a'
			. ' LEFT JOIN #__mos_option_list b ON a.value_id=b.id'
			. ' LEFT JOIN #__mos_options c ON b.option_id=c.id'
			. ' WHERE c.id='.(int)$id;			
			$db->setQuery($query);
			$db->query();
			
			$query = 'DELETE FROM #__mos_option_list WHERE option_id='.(int)$id;			
			$db->setQuery($query);
			$db->query();
			
			$option = new JOption($db);		    
			$option->delete($id);
			unset($option);										
			JRequest::setVar( 'task', 'remove' );
			JRequest::setVar( 'cid', $id );								
		}	
		$msg = JText::sprintf( 'SUCCESSFULLY DELETED');
		$this->setRedirect( 'index.php?option=com_coupon&controller=option&view=options', $msg);
	}
}
?>