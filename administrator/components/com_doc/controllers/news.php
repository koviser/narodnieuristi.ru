<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.controller' );


class ControllerNews extends JController
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
				JRequest::setVar('view', 'new');
				JRequest::setVar('edit', false);
				JRequest::setVar('hidemainmenu', 1);
			} break;
			case 'edit'    :
			{							    
				JRequest::setVar('view', 'new');
				JRequest::setVar('edit', true);		
				JRequest::setVar('hidemainmenu', 1);				
			} break;			
			default : 						   
				JRequest::setVar('view', 'news');			
				break;
		}				
		parent::display();
	}	
	
	function save()
	{
		global $mainframe;		

		JRequest::checkToken() or jexit( 'Invalid Token' );				

		$db	= & JFactory::getDBO();		
		 		
		$new = &new JNews($db);
		
		$full_text = JRequest::getVar( 'full_text', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$full_text = str_replace( '<br>', '<br />', $full_text);
		
		$post = JRequest::get( 'post' );
		$post['full_text'] = $full_text;

		if (!$new->bind( $post ))
			JError::raiseError(500, $new->getError());
			
		if (!$new->store())
			JError::raiseError(500, $new->getError());
				
		switch ( $this->getTask() )
		{
			case 'apply':
				$msg = JText::sprintf( 'SUCCESSFULLY SAVED CHANGE' );
				$this->setRedirect( 'index.php?option=com_doc&controller=news&view=new&task=edit&cid[]='. $new->get('id'), $msg );
				break;

			case 'save':
			default:
				$msg = JText::sprintf( 'SUCCESSFULLY SAVED');				
				$this->setRedirect( 'index.php?option=com_doc&controller=news&view=news', $msg );
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
			$new = new JNews($db);		    
			$new->delete($id);
			unset($new);
			JRequest::setVar( 'task', 'remove' );
			JRequest::setVar( 'cid', $id );
		}	
			
		$this->setRedirect( 'index.php?option=com_doc&controller=news&view=news', $msg);
	}
}

