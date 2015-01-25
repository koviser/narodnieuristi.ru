<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.controller' );


class ControllerWorker extends JController
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
				JRequest::setVar('view', 'worker');
				JRequest::setVar('edit', false);
				JRequest::setVar('hidemainmenu', 1);
			} break;
			case 'edit'    :
			{							    
				JRequest::setVar('view', 'worker');
				JRequest::setVar('edit', true);		
				JRequest::setVar('hidemainmenu', 1);				
			} break;			
			default : 						   
				JRequest::setVar('view', 'workers');			
				break;
		}				
		parent::display();
	}	
	
	function save()
	{
		global $mainframe;		
		
		JRequest::checkToken() or jexit( 'Invalid Token' );				

		$db			= & JFactory::getDBO();		
		 		
		$worker	= &new JWorker($db);
		
		$post	= JRequest::get( 'post' );
		
		if (!$worker->bind( $post )) JError::raiseError(500, $worker->getError() );		
		if (!$worker->store()) JError::raiseError(500, $worker->getError() );

				
		switch ( $this->getTask() )
		{
			case 'apply':
				$msg = JText::sprintf( 'SUCCESSFULLY SAVED CHANGE' );
				$this->setRedirect( 'index.php?option=com_doc&controller=worker&view=worker&task=edit&cid[]='.$worker->get('id'), $msg );
				break;

			case 'save':
			default:
				$msg = JText::sprintf( 'SUCCESSFULLY SAVED');				
				$this->setRedirect( 'index.php?option=com_doc&controller=worker&view=workers', $msg );
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
		    $worker = new JWorker($db);		    
			$worker->delete($id);
			unset($worker);										
			JRequest::setVar( 'task', 'remove' );
			JRequest::setVar( 'cid', $id );								
		}	
		$msg = JText::sprintf( 'SUCCESSFULLY DELETED');
		$this->setRedirect( 'index.php?option=com_doc&controller=worker&view=workers', $msg);
	}	
}
?>