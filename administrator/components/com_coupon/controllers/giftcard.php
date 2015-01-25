<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.controller' );


class ControllerGiftcard extends JController
{	
	function __construct()
	{					
		parent::__construct();							
	}
	
	function advertiser()
	{
		JRequest::setVar('view', 'advertiser');
		parent::display();
	}
	
	function display()
	{			
		switch($this->getTask())
		{			
			case 'add'     :
			{					
				JRequest::setVar('view', 'giftcard');
				JRequest::setVar('edit', false);
				JRequest::setVar('hidemainmenu', 1);
			} break;
			case 'edit'    :
			{							    
				JRequest::setVar('view', 'giftcard');
				JRequest::setVar('edit', true);		
				JRequest::setVar('hidemainmenu', 1);				
			} break;			
			default : 						   
				JRequest::setVar('view', 'giftcards');			
				break;
		}				
		parent::display();
	}	
	
	function save()
	{
		global $mainframe;		

		JRequest::checkToken() or jexit( 'Invalid Token' );				

		$db			= & JFactory::getDBO();		
		 		
		$giftcard	= &new JGiftcard($db);

		$info = JRequest::getVar( 'info', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$info = str_replace( '<br>', '<br />', $info);
		
		$post= JRequest::get( 'post' );
		$post['info'] = $info;

		if (!$giftcard->bind( $post ))
		{
			JError::raiseError(500, $giftcard->getError() );
		}
		
		///////////////////////
		$file = JRequest::getVar( 'image', '', 'files', 'array' );		
		$file['name'] = JImageExtend::makeSafe($file['name']);	
		if ($file['name']) 
		{			
			$giftcard->deleteImage($giftcard->id);
			$path = '..'.DS.'images'.DS.'events';
			$filepath = JPath::clean($path.DS.strtolower($file['name']));
			$filepath2 = JPath::clean($path.DS.'thumb_'.strtolower($file['name']));
			$filepath3 = JPath::clean($path.DS.'big_'.strtolower($file['name']));
			$filepath4 = JPath::clean($path.DS.'original_'.strtolower($file['name']));
			$int=1;
			while (JImageExtend::exists($filepath))
			{
				$file['name'] = $int.$file['name'];						
				$filepath = JPath::clean($path.DS.strtolower($file['name']));
				$filepath2 = JPath::clean($path.DS.'thumb_'.strtolower($file['name']));
				$filepath3 = JPath::clean($path.DS.'big_'.strtolower($file['name']));
				$filepath4 = JPath::clean($path.DS.'original_'.strtolower($file['name']));
				$int++;
			}

			if (!JImageExtend::uploadAndResize($file['tmp_name'], $filepath4, 0, 0)) 
			{				
				JError::raiseError(100, JText::_('Error. Unable to upload foto'));				
				return false;	
			} 
			else			
			{				
				JImageExtend::copyAndResize($filepath4, $filepath3, 450, 240);
				JImageExtend::copyAndResize($filepath4, $filepath, 320, 177);
				JImageExtend::copyAndResize($filepath4, $filepath2, 169, 94);
				$giftcard->image = strtolower($file['name']);
			}
		}
		///////////////////////
				
		if (!$giftcard->store())
		{
			JError::raiseError(500, $giftcard->getError() );
		}			
				
		switch ( $this->getTask() )
		{
			case 'apply':
				$msg = JText::sprintf( 'SUCCESSFULLY SAVED CHANGE' );
				$this->setRedirect( 'index.php?option=com_coupon&controller=giftcard&view=giftcard&task=edit&cid[]='. $giftcard->get('id'), $msg );
				break;

			case 'save':
			default:
				$msg = JText::sprintf( 'SUCCESSFULLY SAVED');				
				$this->setRedirect( 'index.php?option=com_coupon&controller=giftcard&view=giftcards', $msg );
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
			$giftcard = new JGiftcard($db);		    
			$giftcard->delete($id);
			unset($giftcard);
			JRequest::setVar( 'task', 'remove' );
			JRequest::setVar( 'cid', $id );
		}	
			
		$this->setRedirect( 'index.php?option=com_coupon&controller=giftcard&view=giftcards', $msg);
	}
	
	function publish()
	{		
		$db		=& JFactory::getDBO();		
		$cid     = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		JArrayHelper::toInteger($cid, array(0));
		$publish = ( $this->getTask() == 'publish' ? 1 : 0 );		

		if (count( $cid ) < 1) {
			$action = $publish ? JText::_( 'publish' ) : JText::_( 'unpublish' );
			JError::raiseError(500, JText::_( 'Select a giftcard to '.$action ) );
		}

		$cids = implode( ',', $cid );

		$query = 'UPDATE #__mos_giftcard SET published = '.(int) $publish
			. ' WHERE id IN ( '.$cids.' )'			
			;		
		$db->setQuery( $query );
		if (!$db->query()) {
			JError::raiseError(500, $db->getErrorMsg() );
		}		

		$this->setRedirect( 'index.php?option=com_coupon&controller=giftcard&view=giftcards');
	}
	
	function unpublish()
	{
		$this->publish();
	}
}
?>


