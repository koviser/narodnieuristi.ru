<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.controller' );


class ControllerOrder extends JController
{	
	function __construct()
	{					
		parent::__construct();							
	}
	
	function display()
	{			
		JRequest::setVar('view', 'orders');					
		parent::display();
	}
	
	function publish()
	{		
		$db		=& JFactory::getDBO();		
		$cid     = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		JArrayHelper::toInteger($cid, array(0));
		$publish = ( $this->getTask() == 'publish' ? 1 : 0 );		

		if (count( $cid ) < 1) {
			$action = $publish ? JText::_( 'using' ) : JText::_( 'unusing' );
			JError::raiseError(500, JText::_( 'Select a event to '.$action ) );
		}

		$cids = implode( ',', $cid );

		$query = 'UPDATE #__mos_order SET `use` = '.(int) $publish
			. ' WHERE id IN ( '.$cids.' )'			
			;		
		$db->setQuery( $query );
		if (!$db->query()) {
			JError::raiseError(500, $db->getErrorMsg() );
		}		

		$this->setRedirect( 'index.php?option=com_coupon&controller=order&view=orders');
	}
	
	function unpublish()
	{
		$this->publish();
	}
	
	function moneyback()
	{		
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$db =& JFactory::getDBO();		
		$cid = JRequest::getVar( 'cid', array(), '', 'array' );						
		JArrayHelper::toInteger( $cid );
		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'SELECT MONEBACK COUPON', true ) );
		}
		$msg = JText::sprintf( 'MONEYBACK SUCCESSFULLY');	       
		foreach ($cid as $id)
		{					    			
			$order = new JOrder($db);
			$order->load($id);
			
			$query = 'SELECT a.moneyback'
			. ' FROM #__mos_event AS a'						
			. ' WHERE a.id='.$order->id_event
			;
			$db->setQuery( $query );
			$back = $db->loadResult();		    
			
			if($order->use==0 && $back){
				
				$query = 'SELECT a.id, a.balance'
					. ' FROM #__users AS a'						
					. ' WHERE a.email='.$db->Quote($order->email)
					;
				$db->setQuery( $query );
				$user = $db->loadObject();
				
				$query = 'SELECT a.price'
					. ' FROM #__mos_event AS a'						
					. ' WHERE a.id='.(int)$order->id_event
					;
				$db->setQuery( $query );
				$price = $db->loadResult();
				
				$query = 'UPDATE'
				. ' #__users'
				. ' SET balance='.($user->balance+$price)
				. ' WHERE id='.(int)$user->id
				;
				$db->setQuery( $query );
				$db->query();
				
				$query = 'UPDATE'
				. ' #__mos_order'
				. ' SET `use`=2'
				. ' WHERE id='.(int)$order->id
				;
				$db->setQuery( $query );
				$db->query();
								
				$query = 'INSERT'
				. ' #__mos_transaction (userid, `date`, sum, type, eventid)'
				. ' VALUES ('.(int)$user->id.', NOW(), '.$price.', 6, '.$order->id.')'
				;
				$db->setQuery( $query );
				$db->query();
			}
		}	
			
		$this->setRedirect( 'index.php?option=com_coupon&controller=order&view=orders', $msg);
	}	
}
?>


