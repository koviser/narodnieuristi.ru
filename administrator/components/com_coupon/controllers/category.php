<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.controller' );


class ControllerCategory extends JController
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
				JRequest::setVar('view', 'category');
				JRequest::setVar('edit', false);
				JRequest::setVar('hidemainmenu', 1);
			} break;
			case 'edit'    :
			{							    
				JRequest::setVar('view', 'category');
				JRequest::setVar('edit', true);		
				JRequest::setVar('hidemainmenu', 1);				
			} break;			
			default : 						   
				JRequest::setVar('view', 'categories');			
				break;
		}				
		parent::display();
	}	
	
	function save()
	{
		global $mainframe;		
		
		JRequest::checkToken() or jexit( 'Invalid Token' );				

		$db			= & JFactory::getDBO();		
		 		
		$category	= &new JCategory($db);
		
		$post	= JRequest::get( 'post' );
		if (!$category->bind( $post ))
		{
			JError::raiseError(500, $category->getError() );
		}
		
		$isNew = ($category->id == 0);
		
		if ($isNew)
		{
			$query = 'SELECT max(ordering) FROM #__mos_categoty';			  		
			$db->setQuery($query);
			$ordering = $db->loadResult() + 1;			
			$category->ordering = $ordering;  
		}
				
				
		if (!$category->store())
		{
			JError::raiseError(500, $category->getError() );
		}

				
		switch ( $this->getTask() )
		{
			case 'apply':
				$msg = JText::sprintf( 'SUCCESSFULLY SAVED CHANGE' );
				$this->setRedirect( 'index.php?option=com_coupon&controller=category&view=category&task=edit&cid[]='.$category->get('id'), $msg );
				break;

			case 'save':
			default:
				$msg = JText::sprintf( 'SUCCESSFULLY SAVED');				
				$this->setRedirect( 'index.php?option=com_coupon&controller=category&view=categories', $msg );
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
			. ' FROM #__mos_event WHERE catid='.(int)$id;		
			$db->setQuery( $query );
			$total = $db->loadResult();
			if($total>0){
				$msg = JText::sprintf( 'EVENT USE THIS CATEGORY');	
			}else{
				$category = new JCategory($db);		    
				$category->delete($id);
				unset($category);										
				JRequest::setVar( 'task', 'remove' );
				JRequest::setVar( 'cid', $id );	
			}							
		}	
		$msg = JText::sprintf( 'SUCCESSFULLY DELETED');
		$this->setRedirect( 'index.php?option=com_coupon&controller=category&view=categories', $msg);
	}
	
	function orderup()
	{
		$db =& JFactory::getDBO();			
		$cid = JRequest::getVar( 'cid', array(), '', 'array' );
		$category	= new JCategory($db);
		$category->load($cid[0]);
		$category->move(-1);	
		$this->setRedirect('index.php?option=com_coupon&controller=category&view=categories');
	}

	function orderdown()
	{
		$db =& JFactory::getDBO();			
		$cid = JRequest::getVar( 'cid', array(), '', 'array' );
		$category	= new JCategory($db);
		$category->load($cid[0]);
		$category->move(1);
		$this->setRedirect('index.php?option=com_coupon&controller=category&view=categories');
	}

	function saveorder()
	{
		$db =& JFactory::getDBO();			
		$cid = JRequest::getVar( 'cid', array(), '', 'array' );
		$order = JRequest::getVar( 'order', array(), '', 'array' );				
		$category	= new JCategory($db);		
		if (is_array($cid))
			for ($i=0; $i<count($cid); $i++)
			{				
				$category->load($cid[$i]);
				$category->ordering = $order[$i];
				$category->store();
			}
		$this->setRedirect('index.php?option=com_coupon&controller=category&view=categories');
	}	
}
?>