<?php
defined('_JEXEC') or die('Restricted access');

$db =& JFactory::getDBO();

$query = 'SELECT id AS value, title AS text'
. ' FROM #__7t_doc_types ORDER BY title'			
;					

$db->setQuery( $query );
$rows = $db->loadObjectList();

$items[] = JHTML::_('select.option',  0, '-Выберите тему-');

if (count($rows)>0)
	foreach( $rows as $obj )
		$items[] = JHTML::_('select.option',  $obj->value, JText::_( $obj->text ) );
$list['type'] = JHTML::_('select.genericlist',   $items, 'id_type', 'class="inputbox" size="1"', 'value', 'text', "" );

$query = 'SELECT id AS value, title AS text'
. ' FROM #__7t_doc_roo ORDER BY title'			
;					

$db->setQuery( $query );
$rows = $db->loadObjectList();

$items = array();
$items[] = JHTML::_('select.option',  0, '-Выберите регион-');

if (count($rows)>0)
	foreach( $rows as $obj )
		$items[] = JHTML::_('select.option',  $obj->value, JText::_( $obj->text ) );
$list['roo'] = JHTML::_('select.genericlist',   $items, 'id_roo', 'class="inputbox" size="1"', 'value', 'text', "" );
				

require(JModuleHelper::getLayoutPath('mod_order'));