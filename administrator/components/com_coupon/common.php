<?php
	class JCouponCommon
	{
		function CategoryCombo($value, $onchange = '')

		{

			$db 		=& JFactory::getDBO();

			$query = 'SELECT id AS value, title AS text'
				. ' FROM #__mos_category ORDER BY title'			
				;					

			$db->setQuery( $query );
			$rows = $db->loadObjectList();

			if (count($rows)>0)
			foreach( $rows as $obj )
			{
				$items[] = JHTML::_('select.option',  $obj->value, JText::_( $obj->text ) );
			}
			return JHTML::_('select.genericlist',   $items, 'catid', 'class="inputbox" size="1" '.$onchange, 'value', 'text', "$value" );
		}
		
		function GroupCombo($value, $onchange = '')

		{
			$items[] = JHTML::_('select.option', 1, JText::_('GROUP_1') );
			$items[] = JHTML::_('select.option', 2, JText::_('GROUP_2') );
			
			return JHTML::_('select.genericlist',   $items, 'group', 'class="inputbox" size="1" '.$onchange, 'value', 'text', "$value" );
		}
		
		function peopleMinCombo($value, $onchange = '')
		{
			$item = array('','1 человек','2 человека','3 человека','4 человека','5 человек','6 человек','7 человек','8 человек','9 человек','10 человек');
			for($i=1;$i<=10;$i++){
				$items[] = JHTML::_('select.option', $i, $items[$i]);
			}
			
			return JHTML::_('select.genericlist',   $items, 'min_count', 'class="inputbox" size="1" '.$onchange, 'value', 'text', "$value" );
		}
		function peopleMaxCombo($value, $onchange = '')
		{
			$item = array('','1 человек','2 человека','3 человека','4 человека','5 человек','6 человек','7 человек','8 человек','9 человек','10 человек');
			for($i=1;$i<=10;$i++){
				$items[] = JHTML::_('select.option', $i, $items[$i]);
			}
			
			return JHTML::_('select.genericlist',   $items, 'max_count', 'class="inputbox" size="1" '.$onchange, 'value', 'text', "$value" );
		}
		
		function CityCombo($value, $onchange = '')

		{

			$db 		=& JFactory::getDBO();

			$query = 'SELECT id AS value, title AS text'
				. ' FROM #__mos_city ORDER BY ordering'			
				;					

			$db->setQuery( $query );
			$rows = $db->loadObjectList();

			if (count($rows)>0)
			foreach( $rows as $obj )
			{
				$items[] = JHTML::_('select.option',  $obj->value, JText::_( $obj->text ) );
			}
			return JHTML::_('select.genericlist',   $items, 'city', 'class="inputbox" size="1" '.$onchange, 'value', 'text', "$value" );
		}
		
		function CityCombo2($value, $onchange = '')

		{

			$db 		=& JFactory::getDBO();

			$query = 'SELECT id AS value, title AS text'
				. ' FROM #__mos_city ORDER BY ordering'			
				;					

			$db->setQuery( $query );
			$rows = $db->loadObjectList();
			$items[] = JHTML::_('select.option', 0, JText::_('All') );
			if (count($rows)>0)
			foreach( $rows as $obj )
			{
				$items[] = JHTML::_('select.option',  $obj->value, JText::_( $obj->text ) );
			}
			return JHTML::_('select.genericlist',   $items, 'cityid', 'class="inputbox" size="1" '.$onchange, 'value', 'text', "$value" );
		}
		
		function CategoryCombo2($value, $onchange = '')

		{

			$db 		=& JFactory::getDBO();

			$query = 'SELECT id AS value, title AS text'
				. ' FROM #__mos_category ORDER BY title'			
				;					

			$db->setQuery( $query );
			$rows = $db->loadObjectList();
			$items[] = JHTML::_('select.option', 0, JText::_('All') );
			if (count($rows)>0)
			foreach( $rows as $obj )
			{
				$items[] = JHTML::_('select.option',  $obj->value, JText::_( $obj->text ) );
			}
			return JHTML::_('select.genericlist',   $items, 'catid', 'class="inputbox" size="1" '.$onchange, 'value', 'text', "$value" );
		}
		
		function StatusCombo($value, $onchange = '')

		{
			$items[] = JHTML::_('select.option', 0, JText::_('All') );
			$items[] = JHTML::_('select.option', 1, JText::_('STATUS_1') );
			$items[] = JHTML::_('select.option', 2, JText::_('STATUS_2') );
			$items[] = JHTML::_('select.option', 3, JText::_('STATUS_3') );
			
			return JHTML::_('select.genericlist',   $items, 'status', 'class="inputbox" size="1" '.$onchange, 'value', 'text', "$value" );
		}
		
		function bgHorizontal($value, $onchange = '')

		{
			$items[] = JHTML::_('select.option', 'left', 'left' );
			$items[] = JHTML::_('select.option', 'center', 'center' );
			$items[] = JHTML::_('select.option', 'right', 'right');
			
			return JHTML::_('select.genericlist',   $items, 'horizontal', 'class="inputbox" size="1" '.$onchange, 'value', 'text', "$value" );
		}
		
		function bgVertical($value, $onchange = '')

		{
			$items[] = JHTML::_('select.option', 'top', 'top' );
			$items[] = JHTML::_('select.option', 'center', 'center' );
			$items[] = JHTML::_('select.option', 'bottom', 'bottom');
			
			return JHTML::_('select.genericlist',   $items, 'vertical', 'class="inputbox" size="1" '.$onchange, 'value', 'text', "$value" );
		}
		
		function bgRepeat($value, $onchange = '')

		{
			$items[] = JHTML::_('select.option', 'no-repeat', 'no-repeat' );
			$items[] = JHTML::_('select.option', 'repeat', 'repeat' );
			$items[] = JHTML::_('select.option', 'repeat-x', 'repeat-x');
			$items[] = JHTML::_('select.option', 'repeat-y', 'repeat-y');
			
			return JHTML::_('select.genericlist',   $items, 'bgrepeat', 'class="inputbox" size="1" '.$onchange, 'value', 'text', "$value" );
		}
		
		function TypeCombo($value, $onchange = '')

		{
			$items[] = JHTML::_('select.option', 0, JText::_('All') );
			$items[] = JHTML::_('select.option', 1, JText::_('TYPE_1') );
			$items[] = JHTML::_('select.option', 2, JText::_('TYPE_2') );
			$items[] = JHTML::_('select.option', 3, JText::_('TYPE_3') );
			$items[] = JHTML::_('select.option', 4, JText::_('TYPE_4') );
			$items[] = JHTML::_('select.option', 5, JText::_('TYPE_5') );
			$items[] = JHTML::_('select.option', 6, JText::_('TYPE_6') );
			$items[] = JHTML::_('select.option', 7, JText::_('TYPE_7') );
			$items[] = JHTML::_('select.option', 8, JText::_('TYPE_8') );
			$items[] = JHTML::_('select.option', 9, JText::_('TYPE_9') );
			$items[] = JHTML::_('select.option', 10, JText::_('TYPE_10') );
			$items[] = JHTML::_('select.option', 11, JText::_('TYPE_11') );
			
			return JHTML::_('select.genericlist',   $items, 'type', 'class="inputbox" size="1" '.$onchange, 'value', 'text', "$value" );
		}
		
		function CompetitionTypeCombo($value, $onchange = '')

		{
			$items[] = JHTML::_('select.option', 0, JText::_('FRIENDTYPE') );
			$items[] = JHTML::_('select.option', 1, JText::_('BUYTYPE') );
			$items[] = JHTML::_('select.option', 2, JText::_('PHOTOTYPE') );
			
			return JHTML::_('select.genericlist',   $items, 'type', 'class="inputbox" size="1" '.$onchange, 'value', 'text', "$value" );
		}
		
		function bonusType($value, $onchange = '')

		{
			$items[] = JHTML::_('select.option', 0, JText::_('PRIZE'));
			$items[] = JHTML::_('select.option', 1, JText::_('MONEY') );
			$items[] = JHTML::_('select.option', 2, JText::_('PRIZE Bonus') );
			
			return JHTML::_('select.genericlist',   $items, 'bonusType', 'class="inputbox" size="1" '.$onchange, 'value', 'text', "$value" );
		}	
		
		function multipleSelect($value, $name){
			if(count($value)){
				$value[count($value)]=$value[0];
				unset($value[0]);
			}
			
			$db 		=& JFactory::getDBO();

			$query = 'SELECT id AS value, title AS text'
				. ' FROM #__mos_metro ORDER BY title'			
				;					

			$db->setQuery( $query );
			$rows = $db->loadObjectList();

			if (count($rows)>0)
			foreach( $rows as $obj )
			{
				$items[] = JHTML::_('select.option',  $obj->value, JText::_( $obj->text ) );
			}
			
			$html='<select size="10" name="'.$name.'[]" multiple="multiple" class="inputbox" size="10">';
			for($i=0;$i<count($items);$i++){
				if(array_search($items[$i]->value, $value)) $selected=' selected="selected"';
				else $selected='';
				$html.='<option value="'.$items[$i]->value.'"'.$selected.'>'.$items[$i]->text.'</option>';
			}
			$html.='</select>';
			
			return $html;
		}
		function getOptions($event, $catid){
			$db 		=& JFactory::getDBO();

			$query = 'SELECT a.*, b.title AS options'
				. ' FROM #__mos_option_list AS a'
				. ' LEFT JOIN #__mos_options AS b ON a.option_id=b.id'
				. ' WHERE b.catid='.(int)$catid
				. ' ORDER BY b.title, a.title, a.option_id'			
				;					
			$db->setQuery( $query );
			$rows = $db->loadObjectList();
			$option=0;
			
			for($i=0;$i<count($rows);$i++){
				if($option!=$rows[$i]->option_id){ 
					$items[$rows[$i]->option_id][] = JHTML::_('select.option', 0, JText::_('No') );
					$titles[$rows[$i]->option_id]=$rows[$i]->options; 
				}
				$items[$rows[$i]->option_id][] = JHTML::_('select.option',  $rows[$i]->id, $rows[$i]->title);
				$option=$rows[$i]->option_id;
			}
			$query = 'SELECT a.value_id, b.option_id'
				. ' FROM #__mos_option_values AS a'
				. ' LEFT JOIN #__mos_option_list AS b ON a.value_id=b.id'
				. ' WHERE a.event_id='.(int)$event			
				;					
			$db->setQuery( $query );
			$values = $db->loadObjectList();
			
			for($i=0;$i<count($values);$i++){
				$val[$values[$i]->option_id] = $values[$i]->value_id;
			}
			
			$html .= '<table class="admintable">';
			
			foreach($items as $key=>$value){
				$html .= '<tr><td class="key">'.$titles[$key].'</td><td>'.JHTML::_('select.genericlist',   $value, 'options['.$key.']', 'class="inputbox" size="1" ', 'value', 'text', $val[$key] ).'</td></tr>';
			}
			$html .= '</table>';
			
			return $html;
		}
		function setOptions($event, $values){
			if($event){
				$db 		=& JFactory::getDBO();
	
				$query = 'DELETE FROM #__mos_option_values WHERE event_id='.(int)$event;			
				$db->setQuery($query);
				$db->query();
				
				if(count($values)){
					foreach($values as $key=>$value){
						if($value>0) $sql[] = ' ('.$event.', '.$value.')';
					}
					$sql = implode(',', $sql);
					
					$query = 'INSERT INTO #__mos_option_values VALUES '.$sql;			
					$db->setQuery($query);
					$db->query();
				}
			}
		}
	}
?>