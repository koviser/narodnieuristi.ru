<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.controller' );

class ControllerComments extends JController
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
				JRequest::setVar('view', 'comment');
				JRequest::setVar('edit', false);
				JRequest::setVar('hidemainmenu', 1);
			} break;
			case 'edit'    :
			{							    
				JRequest::setVar('view', 'comment');
				JRequest::setVar('edit', true);		
				JRequest::setVar('hidemainmenu', 1);				
			} break;		
			default : 						   
				JRequest::setVar('view', 'comments');			
				break;
		}				
		parent::display();
	}	
	
	function save()
	{
		global $mainframe;		

		JRequest::checkToken() or jexit( 'Invalid Token' );				

		$db			= & JFactory::getDBO();		
		 		
		$comment	= &new JComment($db);
		
		$post	= JRequest::get( 'post' );
		$post['dateA']=date('Y-m-d H:i:s');
		/////////////////////////
		if (!$comment->bind( $post ))
		{
			JError::raiseError(500, $sauna->getError() );
		}
			
		if (!$comment->store())
		{
			JError::raiseError(500, $sauna->getError() );
		}
				
		switch ( $this->getTask() )
		{
			case 'apply':
				$msg = JText::sprintf( 'SUCCESSFULLY SAVED CHANGE' );
				$this->setRedirect( 'index.php?option=com_coupon&controller=comments&view=comment&task=edit&cid[]='. $comment->get('id'), $msg );
				break;

			case 'save':
			default:
				$msg = JText::sprintf( 'SUCCESSFULLY SAVED');				
				$this->setRedirect( 'index.php?option=com_coupon&controller=comments&view=comments', $msg );
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
			$comment = new JComment($db);		    
			$comment->delete($id);
			unset($comment);										
			JRequest::setVar( 'task', 'remove' );
			JRequest::setVar( 'cid', $id );								
		}	
		$msg = JText::sprintf( 'SUCCESSFULLY DELETED');		
		$this->setRedirect( 'index.php?option=com_coupon&controller=comments&view=comments', $msg);
	}
	
	function publish()
	{		
		$db		=& JFactory::getDBO();		
		$cid     = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		JArrayHelper::toInteger($cid, array(0));
		$publish = ( $this->getTask() == 'publish' ? 1 : 0 );		

		if (count( $cid ) < 1) {
			$action = $publish ? JText::_( 'publish' ) : JText::_( 'unpublish' );
			JError::raiseError(500, JText::_( 'Select a event to '.$action ) );
		}

		$cids = implode( ',', $cid );

		$query = 'UPDATE #__mos_comment SET published = '.(int) $publish
			. ' WHERE id IN ( '.$cids.' )'			
			;		
		$db->setQuery( $query );
		if (!$db->query()) {
			JError::raiseError(500, $db->getErrorMsg() );
		}		

		$this->setRedirect( 'index.php?option=com_coupon&controller=comments&view=comments');
	}
	
	function unpublish()
	{
		$this->publish();
	}
}
?>


