<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.controller' );


class ControllerBonus extends JController
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
				JRequest::setVar('view', 'bonus');
				JRequest::setVar('edit', false);
				JRequest::setVar('hidemainmenu', 1);
			} break;
			case 'edit'    :
			{							    
				JRequest::setVar('view', 'bonus');
				JRequest::setVar('edit', true);		
				JRequest::setVar('hidemainmenu', 1);				
			} break;			
			default : 						   
				JRequest::setVar('view', 'bonuses');			
				break;
		}				
		parent::display();
	}	
	
	function save()
	{
		global $mainframe;		

		JRequest::checkToken() or jexit( 'Invalid Token' );				

		$db			= & JFactory::getDBO();		
		 		
		$bonus	= &new JEvents($db);

		$info = JRequest::getVar( 'info', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$info = str_replace( '<br>', '<br />', $info);
		//Get clock
		$clock = JRequest::getVar( 'clock', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$clockArray = explode("\n", $clock);
		$clock="";
		
		for($i=0;$i<count($clockArray);$i++){
			$clock.='<li>'.$clockArray[$i].'</li>';
		}
		$clock = str_replace( "\n", "", $clock);
		//Get terms
		$terms = JRequest::getVar( 'terms', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$termsArray = explode('<hr id="sys" />', $terms);
		$terms="";
		
		for($i=0;$i<count($termsArray);$i++){
			$terms.='<li>'.$termsArray[$i].'</li>';
		}

		//Get features
		$features = JRequest::getVar( 'features', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$featuresArray = explode('<hr id="sys" />', $features);
		$features="";
		
		for($i=0;$i<count($featuresArray);$i++){
			$features.='<li>'.$featuresArray[$i].'</li>';
		}
		
		//Get contacts
		$contacts = JRequest::getVar( 'contacts', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$contactsArray = explode('<hr id="sys" />', $contacts);
		$contacts="";
		
		for($i=0;$i<count($contactsArray);$i++){
			$contacts.='<li>'.$contactsArray[$i].'</li>';
		}
		
		$title = JRequest::getVar( 'title', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$bonus->title=str_replace("</span>","",$bonus->title);
		
		$post= JRequest::get( 'post' );
		$post['type'] = 1;
		$post['title'] = str_replace($post['sale']."%", "<span>".$post['sale']."%</span>" ,$post['title']);
		$post['info'] = $info;
		$post['clock'] = $clock;
		$post['terms'] = $terms;
		$post['features'] = $features;
		$post['contacts'] = $contacts;
		$post['dateStart'] = date("Y-m-d", strtotime($post['dateStart']));
		$post['dateUsed'] = date("Y-m-d", strtotime($post['dateUsed']));

		if (!$bonus->bind( $post ))
		{
			JError::raiseError(500, $bonus->getError() );
		}
		
		$query = 'SELECT max(kuponator) FROM #__mos_event';			  		
		$db->setQuery($query);
		$ordering = $db->loadResult() + 1;			
		$bonus->kuponator = $ordering;  
		
		///////////////////////
		$file = JRequest::getVar( 'image', '', 'files', 'array' );		
		$file['name'] = JImageExtend::makeSafe($file['name']);	
		if ($file['name']) 
		{			
			$bonus->deleteImage($bonus->id);
			$path = '..'.DS.'images'.DS.'events';
			$filepath = JPath::clean($path.DS.strtolower($file['name']));
			$filepath2 = JPath::clean($path.DS.'thumb_'.strtolower($file['name']));
			$int=1;
			while (JImageExtend::exists($filepath))
			{
				$file['name'] = $int.$file['name'];						
				$filepath = JPath::clean($path.DS.strtolower($file['name']));
				$filepath2 = JPath::clean($path.DS.'thumb_'.strtolower($file['name']));
				$int++;
			}

			if (!JImageExtend::uploadAndResize($file['tmp_name'], $filepath, 228, 125)) 
			{				
				JError::raiseError(100, JText::_('Error. Unable to upload foto'));				
				return false;	
			} 
			else			
			{				
				
				JImageExtend::copyAndResize($filepath, $filepath2, 228, 125, "../images/corner_small.png");
				$bonus->image = strtolower($file['name']);
			}
		}
		///////////////////////
				
		if (!$bonus->store())
		{
			JError::raiseError(500, $bonus->getError() );
		}			
				
		switch ( $this->getTask() )
		{
			case 'apply':
				$msg = JText::sprintf( 'SUCCESSFULLY SAVED CHANGE' );
				$this->setRedirect( 'index.php?option=com_coupon&controller=bonus&view=bonus&task=edit&cid[]='. $bonus->get('id'), $msg );
				break;

			case 'save':
			default:
				$msg = JText::sprintf( 'SUCCESSFULLY SAVED');				
				$this->setRedirect( 'index.php?option=com_coupon&controller=bonus&view=bonuses', $msg );
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
			$bonus = new JEvents($db);		    
			$bonus->delete($id);
			unset($bonus);
			
			$query = 'SELECT a.id'
				. ' FROM #__mos_image AS a'						
				. ' WHERE a.id_event='.$id
				;
			$db->setQuery( $query );
			$rows = $db->loadObjectList();
			for($i=0;$i<count($rows);$i++)
			{					    			
				$image = new JImage($db);		    
				$image->delete($rows[$i]->id);
				unset($image);																	
			}
			
			$query = 'SELECT a.id'
				. ' FROM #__mos_map AS a'						
				. ' WHERE a.id_event='.$id
				;
			$db->setQuery( $query );
			$rows = $db->loadObjectList();
			for($i=0;$i<count($rows);$i++)
			{					    			
				$map = new JMap($db);		    
				$map->delete($rows[$i]->id);
				unset($map);																	
			}
			JRequest::setVar( 'task', 'remove' );
			JRequest::setVar( 'cid', $id );
		}	
			
		$this->setRedirect( 'index.php?option=com_coupon&controller=bonus&view=bonuses', $msg);
	}
	
	function image()
	{
		$id_event = JRequest::getVar( 'id', '', '', 'int' );	
		$this->setRedirect( 'index.php?option=com_coupon&controller=image&view=images&id_event='.$id_event);
	}
	function map()
	{
		$id_event = JRequest::getVar( 'id', '', '', 'int' );	
		$this->setRedirect( 'index.php?option=com_coupon&controller=map&view=maps&id_event='.$id_event);
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

		$query = 'UPDATE #__mos_event SET published = '.(int) $publish
			. ' WHERE id IN ( '.$cids.' )'			
			;		
		$db->setQuery( $query );
		if (!$db->query()) {
			JError::raiseError(500, $db->getErrorMsg() );
		}		

		$this->setRedirect( 'index.php?option=com_coupon&controller=bonus&view=bonuses');
	}
	
	function unpublish()
	{
		$this->publish();
	}
}
?>


