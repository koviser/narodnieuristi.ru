<?php
jimport( 'joomla.filesystem.folder' );

function com_install() {

		$db			= &JFactory::getDBO();
		$dbPref 	= $db->getPrefix();
		$msgSQL 	= '';
		$msgFile	= '';
		$msgError	= '';
		//DELETE TABLE
		$query =' DROP TABLE IF EXISTS `'.$dbPref.'bsn_build`;';
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		$query =' DROP TABLE IF EXISTS `'.$dbPref.'bsn_cart`;';
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		$query =' DROP TABLE IF EXISTS `'.$dbPref.'bsn_clients`;';
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		$query =' DROP TABLE IF EXISTS `'.$dbPref.'bsn_image`;';
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		$query =' DROP TABLE IF EXISTS `'.$dbPref.'bsn_metro`;';
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		$query =' DROP TABLE IF EXISTS `'.$dbPref.'bsn_room`;';
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		$query =' DROP TABLE IF EXISTS `'.$dbPref.'bsn_target`;';
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		$query =' DROP TABLE IF EXISTS `'.$dbPref.'bsn_transaction`;';
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		$query =' DROP TABLE IF EXISTS `'.$dbPref.'bsn_type`;';
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		$query =' DROP TABLE IF EXISTS `'.$dbPref.'bsn_realtor`;';
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		if ($msgSQL !='') {
			$msgError .= '<br />' . $msgSQL;
		}
		if ($msgError !='') {
			$msg = JText::_( 'Not successfully uninstalled' ) . ': ' . $msgError;
		} else {
			$msg = JText::_( 'Successfully uninstalled' );
		}
		
		$link = 'index.php';
		$this->setRedirect($link, $msg);
}
?>