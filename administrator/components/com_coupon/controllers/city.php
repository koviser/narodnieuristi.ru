<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.controller' );


class ControllerCity extends JController
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
				JRequest::setVar('view', 'city');
				JRequest::setVar('edit', false);
				JRequest::setVar('hidemainmenu', 1);
			} break;
			case 'edit'    :
			{							    
				JRequest::setVar('view', 'city');
				JRequest::setVar('edit', true);		
				JRequest::setVar('hidemainmenu', 1);				
			} break;			
			default : 						   
				JRequest::setVar('view', 'cites');			
				break;
		}				
		parent::display();
	}	
	
	function save()
	{
		global $mainframe;		
		
		JRequest::checkToken() or jexit( 'Invalid Token' );				

		$db			= & JFactory::getDBO();		
		 		
		$city	= &new JCity($db);
		
		$post	= JRequest::get( 'post' );
		if (!$city->bind( $post ))
		{
			JError::raiseError(500, $city->getError() );
		}
		
		$isNew = ($city->id == 0);
		
		if ($isNew)
		{
			$query = 'SELECT max(ordering) FROM #__mos_city';			  		
			$db->setQuery($query);
			$ordering = $db->loadResult() + 1;			
			$city->ordering = $ordering;  
		}		
				
		if (!$city->store())
		{
			JError::raiseError(500, $city->getError() );
		}

				
		switch ( $this->getTask() )
		{
			case 'apply':
				$msg = JText::sprintf( 'SUCCESSFULLY SAVED CHANGE' );
				$this->setRedirect( 'index.php?option=com_coupon&controller=city&view=city&task=edit&cid[]='.$city->get('id'), $msg );
				break;

			case 'save':
			default:
				$msg = JText::sprintf( 'SUCCESSFULLY SAVED');				
				$this->setRedirect( 'index.php?option=com_coupon&controller=city&view=cites', $msg );
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
			. ' FROM #__mos_event WHERE city='.(int)$id;		
			$db->setQuery( $query );
			$total = $db->loadResult();
			
			$query = 'SELECT COUNT(id)'
			. ' FROM #__mos_area WHERE city='.(int)$id;		
			$db->setQuery( $query );
			$area = $db->loadResult();
			if($total>0){
				$msg = JText::sprintf( 'EVENT USE THIS CITY');
			}else if($area>0){
				$msg = JText::sprintf( 'AREA USE THIS CITY');	
			}else{
				$query = 'UPDATE #__users SET city=0 WHERE city='.(int)$id;	
				$db->setQuery( $query );
				$db->query();
				$city = new JCity($db);		    
				$city->delete($id);
				unset($city);										
				JRequest::setVar( 'task', 'remove' );
				JRequest::setVar( 'cid', $id );	
			}							
		}	
		$msg = JText::sprintf( 'SUCCESSFULLY DELETED');
		$this->setRedirect( 'index.php?option=com_coupon&controller=city&view=cites', $msg);
	}
	
	function orderup()
	{
		$db =& JFactory::getDBO();			
		$cid = JRequest::getVar( 'cid', array(), '', 'array' );
		$city	= new JCity($db);
		$city->load($cid[0]);
		$city->move(-1);	
		$this->setRedirect('index.php?option=com_coupon&controller=city&view=cites');
	}

	function orderdown()
	{
		$db =& JFactory::getDBO();			
		$cid = JRequest::getVar( 'cid', array(), '', 'array' );
		$city	= new JCity($db);
		$city->load($cid[0]);
		$city->move(1);
		$this->setRedirect('index.php?option=com_coupon&controller=city&view=cites');
	}

	function saveorder()
	{
		$db =& JFactory::getDBO();			
		$cid = JRequest::getVar( 'cid', array(), '', 'array' );
		$order = JRequest::getVar( 'order', array(), '', 'array' );				
		$city	= new JCity($db);		
		if (is_array($cid))
			for ($i=0; $i<count($cid); $i++)
			{				
				$city->load($cid[$i]);
				$city->ordering = $order[$i];
				$city->store();
			}
		$this->setRedirect('index.php?option=com_coupon&controller=city&view=city');
	}	
}
?>