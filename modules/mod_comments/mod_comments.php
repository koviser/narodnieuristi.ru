<?php
defined('_JEXEC') or die('Restricted access');

$db =& JFactory::getDBO();

$query = 'SELECT a.*'
. ' FROM #__7t_doc_comments AS a ORDER BY a.id DESC'			
;					
$db->setQuery( $query );
$rows = $db->loadObjectList();

require(JModuleHelper::getLayoutPath('mod_comments'));