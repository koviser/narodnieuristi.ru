<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.controller' );


class ControllerEvent extends JController
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
				JRequest::setVar('view', 'event');
				JRequest::setVar('edit', false);
				JRequest::setVar('hidemainmenu', 1);
			} break;
			case 'edit'    :
			{							    
				JRequest::setVar('view', 'event');
				JRequest::setVar('edit', true);		
				JRequest::setVar('hidemainmenu', 1);				
			} break;			
			default : 						   
				JRequest::setVar('view', 'events');			
				break;
		}				
		parent::display();
	}	
	
	function save()
	{
		global $mainframe;		

		JRequest::checkToken() or jexit( 'Invalid Token' );				

		$db			= & JFactory::getDBO();		
		 		
		$event	= &new JEvents($db);

		$info = JRequest::getVar( 'info', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$info = str_replace( '<br>', '<br />', $info);
		//Get terms
		$terms = JRequest::getVar( 'terms', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$terms = str_replace( '<br>', '<br />', $terms);
		//Get contacts
		$contacts = JRequest::getVar( 'contacts', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$contacts = str_replace( '<br>', '<br />', $contacts);
		
		
		$post= JRequest::get( 'post' );
		$post['info'] = $info;
		$post['type'] = 0;
		$post['clock'] = $clock;
		$post['terms'] = $terms;
		$post['contacts'] = $contacts;
		$post['dateStart'] = date("Y-m-d", strtotime($post['dateStart']));
		$post['dateEnd'] = date("Y-m-d", strtotime($post['dateEnd']));
		$post['dateUsed'] = date("Y-m-d", strtotime($post['dateUsed']));
		
		$metro = $post['metro'];
		$post['metro_id'] = $post['metro'][0];
		$post['metro_count'] = count($post['metro']);
		$metro = $post['metro'];
		$post['metro'] = implode(',',$post['metro']).',';
		
		if($post['day']==1){
			$query = 'UPDATE #__mos_event SET day = 0';		
			$db->setQuery( $query );
			if (!$db->query()) {
				JError::raiseError(500, $db->getErrorMsg() );
			}
		}
		
		if($post['max_count']<$post['min_count']) $post['max_count'] = $post['min_count'];

		if (!$event->bind( $post ))
		{
			JError::raiseError(500, $event->getError() );
		}
		
		$isNew = ($event->id == 0);
		
		
		if(!$event->id){
			$query = 'SELECT max(ordering) FROM #__mos_event';			  		
			$db->setQuery($query);
			$ordering = $db->loadResult() + 1;			
			$event->ordering = $ordering;  	
		}else{
			$query = 'DELETE FROM #__mos_metro_value WHERE id_event='.(int)$event->id;			
			$db->setQuery($query);
			$db->query();
			
			foreach($metro as $key=>$value){
				$insert[] = '('.$value.', '.$event->id.')'	;		
				
			}
			if(count($insert)){
				$query = 'INSERT INTO #__mos_metro_value VALUES '.implode(' , ', $insert);
				$db->setQuery($query);
				$db->query();
			}
		}
		
		///////////////////////
		$file = JRequest::getVar( 'image', '', 'files', 'array' );		
		$file['name'] = JImageExtend::makeSafe($file['name']);	
		if ($file['name']) 
		{			
			$event->deleteImage($event->id);
			$path = '..'.DS.'images'.DS.'events';
			$filepath = JPath::clean($path.DS.'med_'.strtolower($file['name']));
			//$filepath2 = JPath::clean($path.DS.'thumb_'.strtolower($file['name']));
			//$filepath3 = JPath::clean($path.DS.strtolower($file['name']));
			$int=1;
			while (JImageExtend::exists($filepath))
			{
				$file['name'] = $int.$file['name'];						
				$filepath = JPath::clean($path.DS.'med_'.strtolower($file['name']));
				//$filepath2 = JPath::clean($path.DS.'thumb_'.strtolower($file['name']));
				//$filepath3 = JPath::clean($path.DS.strtolower($file['name']));
				$int++;
			}

			if (!JImageExtend::uploadAndResize($file['tmp_name'], $filepath, 435, 277)) 
			{				
				JError::raiseError(100, JText::_('Error. Unable to upload foto'));				
				return false;	
			} 
			else			
			{				
				$event->image = strtolower($file['name']);
			}
		}
		///////////////////////
				
		if (!$event->store())
		{
			JError::raiseError(500, $event->getError() );
		}else{
			JCouponCommon::setOptions($event->id, $post['options'])	;
		}
				
		switch ( $this->getTask() )
		{
			case 'apply':
				$msg = JText::sprintf( 'SUCCESSFULLY SAVED CHANGE' );
				$this->setRedirect( 'index.php?option=com_coupon&controller=event&view=event&task=edit&cid[]='. $event->get('id'), $msg );
				break;

			case 'save':
			default:
				$msg = JText::sprintf( 'SUCCESSFULLY SAVED');				
				$this->setRedirect( 'index.php?option=com_coupon&controller=event&view=events', $msg );
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
			$event = new JEvents($db);		    
			$event->delete($id);
			unset($event);
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
			
			$query = 'DELETE FROM #__mos_option_values WHERE event_id='.(int)$id;			
			$db->setQuery($query);
			$db->query();
			
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
			
		$this->setRedirect( 'index.php?option=com_coupon&controller=event&view=events', $msg);
	}
	
	function image()
	{
		$id_event = JRequest::getVar( 'id', '', '', 'int' );	
		$this->setRedirect( 'index.php?option=com_coupon&controller=image&view=images&id_event='.$id_event);
	}
	function preview()
	{
		$id_event = JRequest::getVar( 'id', '', '', 'int' );	
		$this->setRedirect( JURI::root().'component/coupon/demo/'.$id_event);
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

		$this->setRedirect( 'index.php?option=com_coupon&controller=event&view=events');
	}
	
	function unpublish()
	{
		$this->publish();
	}
	
	function update(){
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$db =& JFactory::getDBO();		
		$cid = JRequest::getVar( 'cid', array(), '', 'array' );						
		JArrayHelper::toInteger( $cid );
		if (count( $cid ) < 1) {
			$msg = JText::sprintf( 'SELECT TO UPDATE');
			$this->setRedirect( 'index.php?option=com_coupon&controller=event&view=events', $msg);
		}
		$msg = JText::sprintf( 'SUCCESSFULLY UPDATE');	       
		foreach ($cid as $id)
		{					    						
			$event = new JEvents($db);		    
			$event->load($id);
			
			$daynew = mktime(date("G"),date("i"),date("s"),date("m"),date("d")+2, date("Y"));
			$date=date("Y-m-d", $daynew);
			$event->dateEnd=$date;
			$event->store();
			unset($event);

			JRequest::setVar( 'task', 'update' );
			JRequest::setVar( 'cid', $id );
		}	
			
		$this->setRedirect( 'index.php?option=com_coupon&controller=event&view=events', $msg);
	}
	
	function copyEvent(){
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$db =& JFactory::getDBO();		
		$cid = JRequest::getVar( 'cid', array(), '', 'array' );						
		JArrayHelper::toInteger( $cid );
		if (count( $cid ) < 1) {
			$msg = JText::sprintf( 'SELECT TO COPY');
			$this->setRedirect( 'index.php?option=com_coupon&controller=event&view=events', $msg);
		}
		$msg = JText::sprintf( 'SUCCESSFULLY COPY');	       
		foreach ($cid as $id)
		{					    						
			$event = new JEvents($db);		    
			$event->load($id);
			
			$newEvent=$event;
			$newEvent->id=NULL;
			$newEvent->count=0;
			$newEvent->published=0;
			$newEvent->dateStart=date("Y-m-d");
			$daynew = mktime(date("G"),date("i"),date("s"),date("m"),date("d")+2, date("Y"));
			$newEvent->dateStart=date("Y-m-d", $daynew);
			$newEvent->dateEnd=date("Y-m-d");
			$newEvent->store();
			
			$query = 'SELECT a.id'
				. ' FROM #__mos_image AS a'						
				. ' WHERE a.id_event='.$id
				;
			$db->setQuery( $query );
			$rows = $db->loadObjectList();
			for($i=0;$i<count($rows);$i++)
			{					    			
				$image = new JImage($db);		    
				$image->load($rows[$i]->id);
				$newImage=$image;
				$newImage->id=NULL;
				$newImage->id_event=$newEvent->id;
				$newImage->store();
				unset($image);
				unset($newImage);																	
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
				$map->load($rows[$i]->id);
				$newMap=$map;
				$newMap->id=NULL;
				$newMap->id_event=$newEvent->id;
				$newMap->store();
				unset($map);
				unset($newMap);																	
			}
			
			unset($event);
			unset($newEvent);

			JRequest::setVar( 'task', 'copyEvent' );
			JRequest::setVar( 'cid', $id );
		}	
			
		$this->setRedirect( 'index.php?option=com_coupon&controller=event&view=events', $msg);
	}
	
	function up()
	{
		$id = JRequest::getVar( 'id', '', '', 'int' );
		$cat = JRequest::getVar( 'catid', '', '', 'int' );
		$db			= & JFactory::getDBO();	

		$event = new JEvents($db);
		$event->load($id);
		
		$where[] = 'a.ordering>'.$event->ordering;
		if($cat) $where[] = 'a.catid='.$event->catid;
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT a.id'
			. ' FROM #__mos_event AS a'						
			. $where
			. 'ORDER BY a.ordering ASC'
		;
		$db->setQuery( $query );
		$row = $db->loadObject();
		if($row->id){
			$event_up = new JEvents($db);
			$event_up->load($row->id);
			$neworder=$event_up->ordering;
			$event_up->ordering = $event->ordering;
			$event->ordering=$neworder;
			$event->store();
			$event_up->store();
		}	
		$this->setRedirect( 'index.php?option=com_coupon&controller=event&view=events&catid='.$cat);
	}
	
	function down()
	{
		$id = JRequest::getVar( 'id', '', '', 'int' );
		$cat = JRequest::getVar( 'catid', '', '', 'int' );
		$db			= & JFactory::getDBO();	
		
		$event = new JEvents($db);
		$event->load($id);
		
		$where[] = 'a.ordering<'.$event->ordering;
		if($cat) $where[] = 'a.catid='.$event->catid;
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT a.id'
			. ' FROM #__mos_event AS a'						
			. $where
			. 'ORDER BY a.ordering DESC'
		;
		$db->setQuery( $query );
		$row = $db->loadObject();
		if($row->id){
			$event_up = new JEvents($db);
			$event_up->load($row->id);
			$neworder=$event_up->ordering;
			$event_up->ordering = $event->ordering;
			$event->ordering=$neworder;
			$event->store();
			$event_up->store();
		}	
		$this->setRedirect( 'index.php?option=com_coupon&controller=event&view=events&catid='.$cat);
	}
}
?>


