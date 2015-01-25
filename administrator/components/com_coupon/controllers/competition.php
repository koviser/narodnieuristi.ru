<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.controller' );


class ControllerCompetition extends JController
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
				JRequest::setVar('view', 'competition');
				JRequest::setVar('edit', false);
				JRequest::setVar('hidemainmenu', 1);
			} break;
			case 'edit'    :
			{							    
				JRequest::setVar('view', 'competition');
				JRequest::setVar('edit', true);		
				JRequest::setVar('hidemainmenu', 1);				
			} break;			
			default : 						   
				JRequest::setVar('view', 'competitions');			
				break;
		}				
		parent::display();
	}	
	
	function save()
	{
		global $mainframe;		

		JRequest::checkToken() or jexit( 'Invalid Token' );				

		$db			= & JFactory::getDBO();		
		 		
		$competition	= &new JCompetition($db);

		$desc = JRequest::getVar( 'description', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$desc = str_replace( '<br>', '<br />', $desc);
		
		$post= JRequest::get( 'post' );
		$post['description'] = $desc;

		if (!$competition->bind( $post ))
		{
			JError::raiseError(500, $competition->getError() );
		}
		
		///////////////////////
		$file = JRequest::getVar( 'image', '', 'files', 'array' );		
		$file['name'] = JImageExtend::makeSafe($file['name']);	
		if ($file['name']) 
		{			
			$competition->deleteImage($competition->id);
			$path = '..'.DS.'images'.DS.'competitions';
			$filepath = JPath::clean($path.DS.strtolower($file['name']));
			$int=1;
			while (JImageExtend::exists($filepath))
			{
				$file['name'] = $int.$file['name'];						
				$filepath = JPath::clean($path.DS.strtolower($file['name']));
				$int++;
			}

			if (!JImageExtend::uploadAndResize($file['tmp_name'], $filepath, 310, 170)) 
			{				
				JError::raiseError(100, JText::_('Error. Unable to upload foto'));				
				return false;	
			}else{
				$competition->image=$file['name'];
			}
		}
		///////////////////////
				
		if (!$competition->store())
		{
			JError::raiseError(500, $competition->getError() );
		}			
				
		switch ( $this->getTask() )
		{
			case 'apply':
				$msg = JText::sprintf( 'SUCCESSFULLY SAVED CHANGE' );
				$this->setRedirect( 'index.php?option=com_coupon&controller=competition&view=competition&task=edit&cid[]='. $competition->get('id'), $msg );
				break;

			case 'save':
			default:
				$msg = JText::sprintf( 'SUCCESSFULLY SAVED');				
				$this->setRedirect( 'index.php?option=com_coupon&controller=competition&view=competitions', $msg );
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
			$competition = new JCompetition($db);		    
			$competition->delete($id);
			unset($competition);
			
			JRequest::setVar( 'task', 'remove' );
			JRequest::setVar( 'cid', $id );
		}	
			
		$this->setRedirect( 'index.php?option=com_coupon&controller=competition&view=competitions', $msg);
	}
	
	function publish()
	{		
		$db		=& JFactory::getDBO();		
		$cid     = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		JArrayHelper::toInteger($cid, array(0));
		$publish = ( $this->getTask() == 'publish' ? 1 : 0 );		

		if (count( $cid ) < 1) {
			$action = $publish ? JText::_( 'publish' ) : JText::_( 'unpublish' );
			JError::raiseError(500, JText::_( 'Select a competition to '.$action ) );
		}

		$cids = implode( ',', $cid );

		$query = 'UPDATE #__mos_competition SET published = '.(int) $publish
			. ' WHERE id IN ( '.$cids.' )'			
			;		
		$db->setQuery( $query );
		if (!$db->query()) {
			JError::raiseError(500, $db->getErrorMsg() );
		}		

		$this->setRedirect( 'index.php?option=com_coupon&controller=competition&view=competitions');
	}
	
	function unpublish()
	{
		$this->publish();
	}
	
	function pay(){
		global $mainframe;		

		JRequest::checkToken() or jexit( 'Invalid Token' );				

		$db			= & JFactory::getDBO();		
		
		$post['status']=1;
		$id     = JRequest::getVar( 'id', '', 'post', 'int' );
		 		
		$competition	= &new JCompetition($db);
		$competition->load($id);
		
		if($competition->dateEnd<date('Y-m-d') && $competition->status==0 && $competition->bonusType==1 && $competition->id>0){
			
			if($competition->bonusType>0){
				$where = array();
				if($row->type==1){
					$where[]='a.type=2 OR a.type=3';
				}else if($row->type==0){
					$where[]='a.type=5';
				}
				$where[]='a.date>='.$db->Quote($competition->dateStart);
				$where[]='a.date<='.$db->Quote($competition->dateEnd);
											
				$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
				
				$bonus = explode(',',$competition->bonus);
				if(count($bonus)>0){
					if($competition->type==1){
						$query = 'SELECT u.id, u.balanse, u.bonus, SUM(a.sum) AS total'
						. ' FROM #__mos_transaction AS a'
						. ' LEFT JOIN #__users AS u ON a.userid=u.id' 
						. $where
						. ' GROUP BY a.userid ORDER BY total DESC'
						;
					}else if($competition->type==2){
						$query = 'SELECT u.id, u.balance'
						. ' FROM #__mos_photos AS a'
						. ' LEFT JOIN #__users AS u ON a.userid=u.id'
						. ' WHERE a.comid='.(int)$competition->id 
						. ' ORDER BY a.raiting DESC'
						;
					}else{
						$query = 'SELECT u.id, u.balanse, u.bonus, COUNT(a.id) AS total'
						. ' FROM #__mos_transaction AS a'
						. ' LEFT JOIN #__users AS u ON a.userid=u.id' 
						. $where
						. ' GROUP BY a.userid ORDER BY total DESC'
						;
					}
						
					$db->setQuery($query);
					$rows = $db->loadObjectList();

					for($i=0;$i<count($bonus);$i++){
						if($rows[$i]->id>0){
							if($competition->bonusType==1){
								$query = 'UPDATE'
								. ' #__users'
								. ' SET balance='.($rows[$i]->balance+$bonus[$i])
								. ' WHERE id='.(int)$rows[$i]->id
								;
								$db->setQuery( $query );
								$db->query();
								
								$query = 'INSERT'
								. ' #__mos_transaction (userid, `date`, sum, type, eventid)'
								. ' VALUES ('.(int)$rows[$i]->id.', NOW(), '.$bonus[$i].', 4, '.$competition->id.')'
								;
								$db->setQuery( $query );
								$db->query();
							}else{
								$query = 'UPDATE'
								. ' #__users'
								. ' SET bonus='.($rows[$i]->bonus+$bonus[$i])
								. ' WHERE id='.(int)$rows[$i]->id
								;
								$db->setQuery( $query );
								$db->query();
								
								$query = 'INSERT'
								. ' #__mos_transaction (userid, `date`, sum, type, eventid)'
								. ' VALUES ('.(int)$rows[$i]->id.', NOW(), '.$bonus[$i].', 10, '.$competition->id.')'
								;
								$db->setQuery( $query );
								$db->query();	
							}
						}
					}
				}
			}
			
			if (!$competition->bind( $post ))
			{
				JError::raiseError(500, $competition->getError() );
			}
			if (!$competition->store())
			{
				JError::raiseError(500, $competition->getError() );
			}
			$msg = JText::sprintf( 'SUCCESSFULLY PAY' );
			$this->setRedirect( 'index.php?option=com_coupon&controller=competition&view=competition&task=edit&cid[]='. $competition->get('id'), $msg );	
		}else{
			$msg = JText::sprintf( 'COMPETITION NOT END' );
			$this->setRedirect( 'index.php?option=com_coupon&controller=competition&view=competition&task=edit&cid[]='. $competition->get('id'), $msg );
		}
	}
	
	function image()
	{
		$id_event = JRequest::getVar( 'id', '', '', 'int' );
		$this->setRedirect( 'index.php?option=com_coupon&controller=photo&view=photos&id_event='.$id_event);
	}
}
?>


