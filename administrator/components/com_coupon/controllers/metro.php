<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.controller' );


class ControllerMetro extends JController
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
				JRequest::setVar('view', 'metro');
				JRequest::setVar('edit', false);
				JRequest::setVar('hidemainmenu', 1);
			} break;
			case 'edit'    :
			{							    
				JRequest::setVar('view', 'metro');
				JRequest::setVar('edit', true);		
				JRequest::setVar('hidemainmenu', 1);				
			} break;			
			default : 						   
				JRequest::setVar('view', 'metros');			
				break;
		}				
		parent::display();
	}	
	
	function save()
	{
		global $mainframe;		
		
		JRequest::checkToken() or jexit( 'Invalid Token' );				

		$db			= & JFactory::getDBO();		
		 		
		$metro	= &new JMetro($db);
		
		$post	= JRequest::get( 'post' );
		if (!$metro->bind( $post ))
		{
			JError::raiseError(500, $metro->getError() );
		}
				
				
		if (!$metro->store())
		{
			JError::raiseError(500, $metro->getError() );
		}

				
		switch ( $this->getTask() )
		{
			case 'apply':
				$msg = JText::sprintf( 'SUCCESSFULLY SAVED CHANGE' );
				$this->setRedirect( 'index.php?option=com_coupon&controller=metro&view=metro&task=edit&cid[]='.$metro->get('id'), $msg );
				break;

			case 'save':
			default:
				$msg = JText::sprintf( 'SUCCESSFULLY SAVED');				
				$this->setRedirect( 'index.php?option=com_coupon&controller=metro&view=metros', $msg );
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
		    $query = 'SELECT COUNT(id)'
			. ' FROM #__mos_event WHERE metro_id='.(int)$id;		
			$db->setQuery( $query );
			$total = $db->loadResult();
			if($total>0){
				$msg = JText::sprintf( 'METRO USE THIS CATEGORY');	
			}else{
				$metro = new JMetro($db);		    
				$metro->delete($id);
				unset($metro);										
				JRequest::setVar( 'task', 'remove' );
				JRequest::setVar( 'cid', $id );	
			}							
		}	
		$msg = JText::sprintf( 'SUCCESSFULLY DELETED');
		$this->setRedirect( 'index.php?option=com_coupon&controller=metro', $msg);
	}
}
?>