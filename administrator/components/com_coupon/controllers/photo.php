<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.controller' );


class ControllerPhoto extends JController
{	
	function __construct()
	{					
		parent::__construct();							
	}
	
	function display()
	{			
		JRequest::setVar('view', 'photos');				
		parent::display();
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
		    $image = new JPhoto($db);		    
			$image->delete($id);
			unset($image);										
			JRequest::setVar( 'task', 'remove' );
			JRequest::setVar( 'cid', $id );								
		}	
		$msg = JText::sprintf( 'SUCCESSFULLY DELETED');
		$id_event = JRequest::getVar('id_event');
		$this->setRedirect( 'index.php?option=com_coupon&controller=photo&view=photos&id_event='.$id_event, $msg);
	}
	
	function close()
	{			
		$id_event = JRequest::getVar('id_event');
		$this->setRedirect( 'index.php?option=com_coupon&controller=competition&view=event&task=edit&cid[]='.$id_event);	
	}
}
?>