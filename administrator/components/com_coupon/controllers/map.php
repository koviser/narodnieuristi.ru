<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.controller' );


class ControllerMap extends JController
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
				JRequest::setVar('view', 'map');
				JRequest::setVar('edit', false);
				JRequest::setVar('hidemainmenu', 1);
			} break;
			case 'edit'    :
			{							    
				JRequest::setVar('view', 'map');
				JRequest::setVar('edit', true);		
				JRequest::setVar('hidemainmenu', 1);				
			} break;			
			default : 						   
				JRequest::setVar('view', 'maps');			
				break;
		}				
		parent::display();
	}	
	
	function save()
	{
		global $mainframe;		

		JRequest::checkToken() or jexit( 'Invalid Token' );				

		$db			= & JFactory::getDBO();		
		 		
		$map	= &new JMap($db);
		
		$post= JRequest::get( 'post' );

		if (!$map->bind( $post ))
		{
			JError::raiseError(500, $map->getError() );
		}
				
		if (!$map->store())
		{
			JError::raiseError(500, $map->getError() );
		}			
				
		switch ( $this->getTask() )
		{
			case 'apply':
				$msg = JText::sprintf( 'SUCCESSFULLY SAVED CHANGE' );
				$this->setRedirect( 'index.php?option=com_coupon&controller=map&view=map&task=edit&id_event='.(int)$post['id_event'].'&cid[]='. $map->get('id'), $msg );
				break;

			case 'save':
			default:
				$msg = JText::sprintf( 'SUCCESSFULLY SAVED');				
				$this->setRedirect( 'index.php?option=com_coupon&controller=map&view=maps&id_event='.(int)$post['id_event'], $msg );
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
		$msg = JText::sprintf( 'SUCCESSFULLY DELETED');	       
		foreach ($cid as $id)
		{					    			
			$map = new JMap($db);		    
			$map->delete($id);
			unset($map);										
			JRequest::setVar( 'task', 'remove' );
			JRequest::setVar( 'cid', $id );
		}	
		
		$id_event = JRequest::getVar('id_event');
		$this->setRedirect( 'index.php?option=com_coupon&controller=map&view=maps&id_event='.$id_event, $msg);
	}
	
	function close()
	{			
		$id_event = JRequest::getVar('id_event');
		$db 	=& JFactory::getDBO();
		$event	= &new JEvents($db);
		$event->load($id_event );
		if($event->type==1){
			$this->setRedirect( 'index.php?option=com_coupon&controller=bonus&view=bonus&task=edit&cid[]='.$id_event);
		}else{
			$this->setRedirect( 'index.php?option=com_coupon&controller=event&view=event&task=edit&cid[]='.$id_event);	
		}
	}	
}
?>


