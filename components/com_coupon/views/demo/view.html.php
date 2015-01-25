<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );
require_once (JPATH_COMPONENT.DS.'common.php');

class ViewDemo extends JView
{	
	function display($tpl = null)
	{	
		global $mainframe;
		$menus	= &JSite::getMenu();
		$menu   = $menus->getActive();
		$document	= & JFactory::getDocument();
		$pparams = &$mainframe->getParams('com_coupon');
		
		$session  = JFactory::getSession();
		$user = $session->get('user');		
		
		$id = JRequest::getVar('id', '', '', 'int');
		
		if ($id=="") return JError::raiseError( 404, JText::sprintf( 'Event # not found', $id ) );

		$db	=& JFactory::getDBO();
		
		$where = array();
		$where[]='a.id='.(int)$id;
										
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT a.*, b.title AS metro_name'
		. ' FROM #__mos_event AS a'
		. ' LEFT JOIN #__mos_metro AS b ON a.metro_id=b.id'
		//. ' LEFT JOIN #__mos_favorite AS c ON c.idevent=a.id AND c.iduser='.(int)$user->id
		. $where
		. $orderby
		;
		
		$db->setQuery($query);
		$row = $db->loadObject();
		
		if ($row->id==""){
			return JError::raiseError( 404, JText::_( 'Event # not found') );
		}
		
		//$row->dateStarts=JEventsCommon::GetDate($row->dateStart, $row->dateEnd);
		//$row->dateEnds=JEventsCommon::GetDateEndScript($row->dateEnd);
		//$row->count=JEventsCommon::GetCount($row->count);
		
		if($row->dateEnd<date("Y-m-d")){
			$row->end=1;
		}
		/*
		//Repeat
		$query = 'SELECT a.iduser'
		. ' FROM #__mos_repeat AS a'
		. ' WHERE a.iduser='.(int)$user->id.' AND a.idevent='.(int)$id 
		;
		
		$db->setQuery($query);
		$repeat = $db->loadResult();
		//
		*/
		//
		$where = array();
		$where[]='a.type=0';
		$where[]='a.id<>'.(int)$row->id;
		$where[]='a.published=1';
		//$where[]='a.city='.$session->get('city');
		//$where[]='a.dateStart<="'.date('Y-m-d').'" AND a.dateEnd>="'.date('Y-m-d').'"';
										
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT a.*'
		. ' FROM #__mos_event AS a'
		. $where
		. ' ORDER BY RAND()'
		;
		
		$db->setQuery($query, 0 , 6);
		$optional = $db->loadObjectList();
		//				
		$orderby = ' ORDER BY a.ordering ASC';	
		
		$where = array();
		$where[]='a.id_event='.(int)$row->id;
										
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT a.image'
		. ' FROM #__mos_image AS a'
		. $where
		. $orderby
		;
		
		$db->setQuery($query);
		$images = $db->loadObjectList();
		//
				//
		$db	=& JFactory::getDBO();
		
		$where = array();
		$where[]='a.id_event='.(int)$row->id;
										
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT a.*'
		. ' FROM #__mos_map AS a'
		. $where
		;
		
		$db->setQuery($query);
		$maps = $db->loadObjectList();

		if(count($maps)>1){
			$mapsParam=JEventsCommon::GetMap($maps);
			$pparams->set('x',	$mapsParam['x']);
			$pparams->set('y',	$mapsParam['y']);
			$pparams->set('scale', $mapsParam['scale']);	
		}else{
			$pparams->set('x',	$maps[0]->latitude);
			$pparams->set('y',	$maps[0]->longitude);
			$pparams->set('scale',15);		
		}
		// Получение опций
		$db	=& JFactory::getDBO();
		
		$where = array();
		$where[]='a.event_id='.(int)$row->id;
										
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT c.title AS title, b.title AS value, b.id, c.id AS catid'
				. ' FROM #__mos_option_values AS a'
				. ' LEFT JOIN #__mos_option_list AS b ON a.value_id=b.id'
				. ' LEFT JOIN #__mos_options AS c ON b.option_id=c.id'
		. $where
		;
		
		$db->setQuery($query);
		$options = $db->loadObjectList();
		
		//
		
		$pparams->set('page_title',	$row->dateStarts);
		$document->setTitle( strip_tags( ($row->meta_title ? $row->meta_title :$row->title)) );
		$document->setDescription( $row->meta_desc );
		
		// Sey background
		/*
		if($row->bgcolor!="" || $row->bgimage!=""){
			$background = ' style="background:';
			if ($row->bgimage!=""){
				$background .= 'url('.JURI::base().$row->bgimage.')';
			}
			if ($row->bgcolor!=""){
				$background .= ' #'.$row->bgcolor;
			}
			if ($row->bgimage!=""){
				$background .= ' '.$row->horizontal.' '.$row->vertical.' '.$row->bgrepeat;
			}
			$background .= ';"';	
			$document->set('background',$background);
		}
		*/
		//
		if(str_replace('skidking','', $_SERVER['HTTP_REFERER'])){
			$back = $_SERVER['HTTP_REFERER'];
		}
		
		$webmoney->login = $mainframe->getCfg('wm_login');
		$webmoney->url = $mainframe->getCfg('wm_url');
		//
		$this->assignRef('webmoney',	$webmoney);	
		$this->assignRef('items',		$row);
		//$this->assignRef('repeat',		$repeat);
		//$this->assignRef('user',		$user);
		$this->assignRef('images',		$images);
		$this->assignRef('options',		$options);
		$this->assignRef('maps',		$maps);
		$this->assignRef('params',		$pparams);
		$this->assignRef('optional',	$optional);	
		$this->assignRef('back',	$back);		
		parent::display($tpl);
	}
	
	function _displayPayment($tpl = null)
	{	
		global $mainframe;
		$menus	= &JSite::getMenu();
		$menu   = $menus->getActive();
		$document	= & JFactory::getDocument();
		$pparams = &$mainframe->getParams('com_coupon');
		
		$id = JRequest::getVar('id', '', '', 'int');
		
		if ($id=="")
		{
			return JError::raiseError( 404, JText::sprintf( 'Event # not found', $id ) );
		}

		$db	=& JFactory::getDBO();
		
		$where = array();
		$where[]='a.id='.(int)$id;
										
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT a.*'
		. ' FROM #__mos_event AS a'
		. $where
		;
		
		$db->setQuery($query);
		$row = $db->loadObject();
		
		if ($row->id==""){
			return JError::raiseError( 404, JText::_( 'Event # not found') );
		}

		if($row->published==0 || $row->type==1 || $row->dateEnd<date('Y-m-d')){
			return JError::raiseError( 403, JText::_('Event not published') );
		}
		
		if(!$user->vip && $row->vip==1){
			 $mainframe->redirect(JRoute::_('index.php?option=com_coupon&view=vip'));
		}
		
		$row->dateStarts=JEventsCommon::GetDate($row->dateStart, $row->dateEnd);
		$row->dateEnds=JEventsCommon::GetDateEndScript($row->dateEnd);
		$row->count=JEventsCommon::GetCount($row->count);
		if($row->dateEnd<date("Y-m-d")){
			$row->end=1;
		}
		
		$pparams->set('page_title',	JText::_('Purchase Coupon'));
		$document->setTitle( strip_tags($row->title) );
		$document->setDescription( str_replace("\n", " ", strip_tags($row->features)) );
		$webmoney->login = $mainframe->getCfg('wm_login');
		$webmoney->url = $mainframe->getCfg('wm_url');
		//
		$this->assignRef('items',		$row);
		$this->assignRef('webmoney',	$webmoney);	
		$this->assignRef('params',		$pparams);		
		parent::display($tpl);
	}
	
	function _displayCoupon($tpl = null)
	{
		global $mainframe;
		$document	= & JFactory::getDocument();
		$pparams = &$mainframe->getParams('com_coupon');	
		
		$id = JRequest::getVar('id', '', '', 'int');
		
		if ($id=="")
		{
			return JError::raiseError( 404, JText::sprintf( 'Coupon # not found', $id ) );
		}


		$db	=& JFactory::getDBO();
		
		$where = array();
		$where[]='a.id='.(int)$id;
										
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT a.password, a.email, a.status, a.id, b.published, b.dateUsed, b.title, b.terms, b.features, a.id_event, b.contacts, b.type, b.image'
		. ' FROM #__mos_order AS a'
		. ' LEFT JOIN #__mos_event AS b ON a.id_event=b.id'
		. $where
		;
		
		
		$db->setQuery($query);
		$row = $db->loadObject();

		$user =& JFactory::getUser();
		
		if ($row->id==""){
			return JError::raiseError( 404, JText::_( 'Coupon # not found') );
		}

		if($row->status==0 || $row->email!=$user->email || $row->published==0){
			return JError::raiseError( 403, JText::_('Coupon # not found') );
		}
		//
		
		$where = array();
		$where[]='a.id_event='.(int)$row->id_event;
										
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT a.*'
		. ' FROM #__mos_map AS a'
		. $where
		;
		
		$db->setQuery($query);
		$maps = $db->loadObjectList();

		if(count($maps)>1){
			$mapsParam=JEventsCommon::GetMap($maps);
			$pparams->set('x',	$mapsParam['x']);
			$pparams->set('y',	$mapsParam['y']);
			$pparams->set('scale', $mapsParam['scale']);	
		}else{
			$pparams->set('x',	$maps[0]->latitude);
			$pparams->set('y',	$maps[0]->longitude);
			$pparams->set('scale',15);		
		}
		$map=array();
		for($i=0;$i<count($maps);$i++){
			$map[]=$maps[$i]->longitude.','.$maps[$i]->latitude.',pmblm';
		}
		$map=implode("~", $map);
		//
		$document->setTitle( strip_tags($row->title) );
		//
		$orderby = ' ORDER BY a.dateEnd DESC';
		
		$user=JFactory::getUser();	
		//
		$this->assignRef('items',		$row);
		$this->assignRef('user',		$user);
		$this->assignRef('map',		$map);
		$this->assignRef('params',		$pparams);		
		parent::display($tpl);
	}
}
?>