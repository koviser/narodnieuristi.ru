<?php
defined('_JEXEC') or die('Restricted access');

$category = JRequest::getVar( 'catid', '0', 'get', 'string');

$db 		=& JFactory::getDBO();

$query = 'SELECT *'
. ' FROM #__mos_category ORDER BY ordering'			
;					

$db->setQuery( $query );
$rows = $db->loadObjectList();

$view = JRequest::getVar('view', '', 'request', 'string');
$component = JRequest::getVar('option', '', 'request', 'string');

$session  = JFactory::getSession();
$user = $session->get('user');

require(JModuleHelper::getLayoutPath('mod_cat_event'));