<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.controller' );


class ControllerImage extends JController
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
				JRequest::setVar('view', 'image');
				JRequest::setVar('edit', false);
				JRequest::setVar('hidemainmenu', 1);
			} break;
			case 'edit'    :
			{							    
				JRequest::setVar('view', 'image');
				JRequest::setVar('edit', true);		
				JRequest::setVar('hidemainmenu', 1);				
			} break;			
			default : 						   
				JRequest::setVar('view', 'images');			
				break;
		}				
		parent::display();
	}	
	
	function save()
	{
		global $mainframe;		
		
		JRequest::checkToken() or jexit( 'Invalid Token' );				

		$db			= & JFactory::getDBO();		
		 		
		$image	= &new JImage($db);
		
		$post	= JRequest::get( 'post' );
		if (!$image->bind( $post ))
		{
			JError::raiseError(500, $image->getError() );
		}
		
		$isNew = ($image->id == 0);
		
		if ($isNew)
		{
			$query = 'SELECT max(ordering) FROM #__mos_image WHERE id_event='.(int)$post['id_event'];			  		
			$db->setQuery($query);
			$ordering = $db->loadResult() + 1;			
			$image->ordering = $ordering;  
		}		
				
		if (!$image->store())
		{
			JError::raiseError(500, $image->getError() );
		}
		
		$file = JRequest::getVar( 'image', '', 'files', 'array' );		
		$file['name'] = JImageExtend::makeSafe($file['name']);	
		if ($file['name']) 
		{			
			$image->deleteImage($image->id);
			$path = '..'.DS.'images'.DS.'slider';
			$filepath = JPath::clean($path.DS.'big_'.strtolower($file['name']));
			$filepath2 = JPath::clean($path.DS.'thumbbig_'.strtolower($file['name']));
			$int=1;
			while (JImageExtend::exists($filepath))
			{
				$file['name'] = $file['name'];						
				$filepath = JPath::clean($path.DS.'big_'.$int.strtolower($file['name']));
				$filepath2 = JPath::clean($path.DS.'thumbbig_'.$int.strtolower($file['name']));
				$int++;
			}

			if (!JImageExtend::uploadAndResize($file['tmp_name'], $filepath, 500, 317)) 
			{				
				JError::raiseError(100, JText::_('Error. Unable to upload foto'));				
				return false;	
			} 
			else			
			{				
				JImageExtend::copyAndResize($filepath, $filepath2, 75, 40);
				$image->image = strtolower($file['name']);
				$image->store();	
			}
		}
				
		switch ( $this->getTask() )
		{
			case 'apply':
				$msg = JText::sprintf( 'SUCCESSFULLY SAVED CHANGE' );
				$this->setRedirect( 'index.php?option=com_coupon&controller=image&view=image&task=edit&id_event='.(int)$post['id_event'].'&cid[]='. $image->get('id'), $msg );
				break;

			case 'save':
			default:
				$msg = JText::sprintf( 'SUCCESSFULLY SAVED');				
				$this->setRedirect( 'index.php?option=com_coupon&controller=image&view=images&id_event='.(int)$post['id_event'], $msg );
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
		    $image = new JImage($db);		    
			$image->delete($id);
			unset($image);										
			JRequest::setVar( 'task', 'remove' );
			JRequest::setVar( 'cid', $id );								
		}	
		$msg = JText::sprintf( 'SUCCESSFULLY DELETED');
		$id_event = JRequest::getVar('id_event');
		$this->setRedirect( 'index.php?option=com_coupon&controller=image&view=images&id_event='.$id_event, $msg);
	}
	
	function close()
	{			
		$id_event = JRequest::getVar('id_event');
		$db 	=& JFactory::getDBO();
		$event	= &new JEvents($db);
		$event->load($id_event);
		if($event->type==1){
			$this->setRedirect( 'index.php?option=com_coupon&controller=bonus&view=bonus&task=edit&cid[]='.$id_event);
		}else{
			$this->setRedirect( 'index.php?option=com_coupon&controller=event&view=event&task=edit&cid[]='.$id_event);	
		}
	}
	
	function orderup()
	{
		$id_event = JRequest::getVar('id_event');
		$db =& JFactory::getDBO();			
		$cid = JRequest::getVar( 'cid', array(), '', 'array' );
		$image	= new JImage($db);
		$image->load($cid[0]);
		$image->move(-1, 'id_event='.$id_event);	
		$this->setRedirect('index.php?option=com_coupon&controller=image&view=images&id_event='.$id_event);
	}

	function orderdown()
	{
		$id_event = JRequest::getVar('id_event');
		$db =& JFactory::getDBO();			
		$cid = JRequest::getVar( 'cid', array(), '', 'array' );
		$image	= new JImage($db);
		$image->load($cid[0]);
		$image->move(1, 'id_event='.$id_event);
		$this->setRedirect('index.php?option=com_coupon&controller=image&view=images&id_event='.$id_event);
	}

	function saveorder()
	{
		$db =& JFactory::getDBO();			
		$cid = JRequest::getVar( 'cid', array(), '', 'array' );
		$order = JRequest::getVar( 'order', array(), '', 'array' );				
		$image	= new JImage($db);		
		if (is_array($cid))
			for ($i=0; $i<count($cid); $i++)
			{				
				$image->load($cid[$i]);
				$image->ordering = $order[$i];
				$image->store();
			}
		$id_event = JRequest::getVar('id_event');
		$this->setRedirect('index.php?option=com_coupon&controller=image&view=images&id_event='.$id_event);
	}	
}
?>