<?php
defined('_JEXEC') or die('Restricted access');

$session  = JFactory::getSession();
$city = $session->get('city');

$db 		=& JFactory::getDBO();

$query = 'SELECT id, title'
. ' FROM #__mos_city ORDER BY ordering'			
;					

$db->setQuery( $query );
$rows = $db->loadObjectList();
if($city){
	for($i=0;$i<count($rows);$i++){
		if($city==$rows[$i]->id){
			$title=$rows[$i]->title;
			break;		
		}
	}
}else{
	$title=$rows[0]->title;	
}
if(!$title){
	$title=$rows[0]->title;	
}

require(JModuleHelper::getLayoutPath('mod_city'));