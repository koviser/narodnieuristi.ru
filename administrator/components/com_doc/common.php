<?php
	class JDocCommon
	{
		function WorkerList($value, $name)

		{

			$db 		=& JFactory::getDBO();

			$query = 'SELECT id AS value, name AS text'
				. ' FROM #__7t_doc_workers ORDER BY name'			
				;					

			$db->setQuery( $query );
			$rows = $db->loadObjectList();
			
			$items[] = JHTML::_('select.option',  '---------' );
			
			if (count($rows)>0)
			foreach( $rows as $obj )
			{
				$items[] = JHTML::_('select.option',  $obj->value, JText::_( $obj->text ) );
			}
			return JHTML::_('select.genericlist',   $items, $name, 'class="inputbox" size="1" style="width:98%;"', 'value', 'text', "$value" );
		}
		
		function TypeList($value)

		{

			$db 		=& JFactory::getDBO();

			$query = 'SELECT id AS value, title AS text'
				. ' FROM #__7t_doc_types ORDER BY title'			
				;					

			$db->setQuery( $query );
			$rows = $db->loadObjectList();
			
			if (count($rows)>0)
			foreach( $rows as $obj )
			{
				$items[] = JHTML::_('select.option',  $obj->value, JText::_( $obj->text ) );
			}
			return JHTML::_('select.genericlist',   $items, 'id_type', 'class="inputbox" size="1" style="width:98%;"', 'value', 'text', "$value" );
		}
		
		function CategoryList($value){

			$items[] = JHTML::_('select.option',  1 , JText::_('CATEGORY_1') );
			$items[] = JHTML::_('select.option',  2 , JText::_('CATEGORY_2') );
			
			return JHTML::_('select.genericlist',   $items, 'id_category', 'class="inputbox" size="1" style="width:98%;"', 'value', 'text', "$value" );
		}
		
		function RooList($value, $read=''){
			if($read){
				$db 		=& JFactory::getDBO();
	
				$query = 'SELECT title AS text'
					. ' FROM #__7t_doc_roo WHERE id='.$value			
					;					
	
				$db->setQuery( $query );
				$row = $db->loadResult();
				
				return $row.' <input type="hidden" name="id_roo" value="'.$value.'"/>';
			}else{
				$db 		=& JFactory::getDBO();
	
				$query = 'SELECT id AS value, title AS text'
					. ' FROM #__7t_doc_roo ORDER BY title'			
					;					
	
				$db->setQuery( $query );
				$rows = $db->loadObjectList();
				
				if (count($rows)>0)
				foreach( $rows as $obj )
				{
					$items[] = JHTML::_('select.option',  $obj->value, JText::_( $obj->text ) );
				}
				return JHTML::_('select.genericlist',   $items, 'id_roo', 'class="inputbox" size="1" style="width:98%;"', 'value', 'text', "$value" );
			}
		}
		
		function Calendar($value, $name){
			return JHTML::_(
				'calendar', 
				($value!=='0000-00-00' ? $value : ''), 
				$name, 
				$name, 
				$format = '%Y-%m-%d', 
				array('class'=>'inputbox', 'size'=>'20',  'maxlength'=>'19')
			);	
		}
		
		function ServiceList($value){
			$list =  unserialize($value);
			for($i=1;$i<7;$i++){
				if($list[$i]==1)$check= ' checked="checked"';
				else $check= '';
				$result .= '<input type="checkbox" name="services['.$i.']" value="1"'.$check.'> '.JText::_('SERVICE_'.$i).'<br/>';
			}
			return $result;
		}
		
	}
?>