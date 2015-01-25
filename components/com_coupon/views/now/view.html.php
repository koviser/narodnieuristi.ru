<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );
require_once (JPATH_COMPONENT.DS.'common.php');

class ViewNow extends JView
{	
	function display($tpl = null)
	{
		global $mainframe;

		$document	= & JFactory::getDocument();
		$pparams = &$mainframe->getParams('com_coupon');
		$category = JRequest::getVar( 'catid', '0', 'get', 'int');
		$options = JRequest::getVar( 'options', '', 'get', 'array');
		// Получение переменных город и избранное
		//$favorite = JRequest::getVar( 'favorite', '0', 'get', 'int');
		//$session  = JFactory::getSession();
		//$city = $session->get('city');
		
		foreach( $options as $key => $value ){
			if($value){
				$search = 1;
				if($key!='metro' && $key!='word') $options_v[] = 'c.value_id='.(int)$value; 
			}
		}
		
		$db	=& JFactory::getDBO();
		if($category){
			$query = 'SELECT a.title'
			. ' FROM #__mos_category AS a'
			. ' WHERE id='.(int)$category;
			
			$db->setQuery( $query );
			$title = $db->loadResult();	
		}
		
		
		// акция дня
		if(!$search){
			$orderby = ' ORDER BY a.day DESC, a.ordering DESC';
			$where = array();
			if($category){
				$where[]='a.catid='.(int)$category;
			}
			$where[]='a.published=1';
											
			$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
	
			$query = 'SELECT COUNT(a.id)'
			. ' FROM #__mos_event AS a'
			. $where;
			
			$db->setQuery( $query );
			$total = $db->loadResult();	
			
			jimport('joomla.html.pagination');
			$pagination = new JPagination( $total, $limitstart, $limit );
			
			$query = 'SELECT a.id, a.title, a.sale, a.intro, b.title AS metro, a.metro_count'
			. ' FROM #__mos_event AS a'
			. ' LEFT JOIN #__mos_metro AS b ON a.metro_id=b.id'
			. $param->join
			. $where
			. $orderby
			;
			
			$db->setQuery($query, 0, 1);
			$day = $db->loadObject();

			if($day->id){
				$orderby = ' ORDER BY a.ordering ASC';
				
				$where = array();
				$where[]='a.id_event='.(int)$day->id;
												
				$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
				
				$query = 'SELECT a.image'
				. ' FROM #__mos_image AS a'
				. $where
				. $orderby
				;
				
				$db->setQuery($query);
				$day->images = $db->loadObjectList();
			}
		}
		//		
		
		// Получение акций
		$limit		= JRequest::getVar('limit', 8);
		$limitstart = JRequest::getVar('limitstart', 0 );
		
		$orderby = ' ORDER BY a.ordering DESC';
		$where = array();
		
		if($search){
			if($category){
				$where[]='a.catid='.(int)$category;
			}
			$where[]='a.published=1';
			
			if(count($options_v)){
				$where[] = implode(' OR ', $options_v);
			}
			if($options['metro']){
				$where[] = 'a.metro_id='.(int)$options['metro'].' OR a.metro LIKE "%,'.$options['metro'].',%"';	
			}
			
			if($options['word']){
				$where[] = 'a.title LIKE "%'.$options['word'].'%" OR a.subtitle LIKE "%'.$options['word'].'%"';	
			}
			
			$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
	
			$query = 'SELECT COUNT(a.id)'
			. ' FROM #__mos_event AS a'
			. ' LEFT JOIN #__mos_option_values AS c ON a.id=c.event_id'
			. $where;
			
			$db->setQuery( $query );
			$total = $db->loadResult();	
			
			$query = 'SELECT a.id, a.image, a.title, a.sale, a.price, a.realPrice, b.title AS metro, a.metro_count, COUNT(a.id) AS total'
			. ' FROM #__mos_event AS a'
			. ' LEFT JOIN #__mos_metro AS b ON a.metro_id=b.id'
			. ' LEFT JOIN #__mos_option_values AS c ON a.id=c.event_id'
			. $where
			. ' GROUP BY a.id'
			. (count($options_v) ? ' HAVING total='.(int)count($options_v) : '')
			. $orderby
			;
		}else{
			$where[]='a.id<>'.(int)$day->id;
			if($category){
				$where[]='a.catid='.(int)$category;
			}
			$where[]='a.published=1';
											
			$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
	
			$query = 'SELECT COUNT(a.id)'
			. ' FROM #__mos_event AS a'
			. $where;
			
			$db->setQuery( $query );
			$total = $db->loadResult();	
			
			$query = 'SELECT a.id, a.image, a.title, a.sale, a.price, a.realPrice, b.title AS metro, a.metro_count'
			. ' FROM #__mos_event AS a'
			. ' LEFT JOIN #__mos_metro AS b ON a.metro_id=b.id'
			. $where
			. $orderby
			;
		};
		//
		jimport('joomla.html.pagination');
		$pagination = new JPagination( $total, $limitstart, $limit );

		$db->setQuery($query, $pagination->limitstart, $pagination->limit);
		$rows = $db->loadObjectList();

		for($i=0;$i<count($rows);$i++){
			$rows[$i]->dateEnds=JEventsCommon::GetDateEndScript($rows[$i]->dateEnd);
		}
		//
		
		
		if(!$category){
			$document->setTitle($pparams->get('meta_title',JText::_('CURRENT STOCK')));
			$document->setDescription($pparams->get('meta_desc',JText::_('CURRENT STOCK')));
			$pparams = &$mainframe->getParams('com_coupon');
		}else{
			$document->setTitle($title);
			if(count($rows)>0){
				$pparams->set('page_title',	$title);
				if($param->title){
					$pparams->set('page_title',$param->title);	
				}
			}else{
				$pparams->set('page_title',	JText::_('No Event'));
			}
		}
		
		$this->assignRef('items',		$rows);
		$this->assignRef('search',		$search);
		$this->assignRef('title',		$title);
		$this->assignRef('day',		$day);
		$this->assignRef('pagination',	$pagination);
		$this->assignRef('params',		$pparams);		
		parent::display($tpl);
	}
}
?>