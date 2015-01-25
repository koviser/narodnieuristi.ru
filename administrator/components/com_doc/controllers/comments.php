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
		 		
		$comment	= &new JComments($db);
		
		$text = JRequest::getVar( 'text', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$text = str_replace( '<br>', '<br />', $text);
		
		$post = JRequest::get( 'post' );
		$post['text'] = $text;

		if (!$comment->bind( $post ))
			JError::raiseError(500, $comment->getError() );
			
		if (!$comment->store())
			JError::raiseError(500, $comment->getError() );
		
				
		switch ( $this->getTask() )
		{
			case 'apply':
				$msg = JText::sprintf( 'SUCCESSFULLY SAVED CHANGE' );
				$this->setRedirect( 'index.php?option=com_doc&controller=comments&view=comment&task=edit&cid[]='. $comment->get('id'), $msg );
				break;

			case 'save':
			default:
				$msg = JText::sprintf( 'SUCCESSFULLY SAVED');				
				$this->setRedirect( 'index.php?option=com_doc&controller=comments&view=comments', $msg );
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
			$comment = new JComments($db);		    
			$comment->delete($id);
			unset($comment);
			JRequest::setVar( 'task', 'remove' );
			JRequest::setVar( 'cid', $id );
		}	
			
		$this->setRedirect( 'index.php?option=com_doc&controller=comments&view=comments', $msg);
	}
}

