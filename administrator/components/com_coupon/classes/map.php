<?php
defined('_JEXEC') or die('Restricted access');

class JMap extends JTable
{
	var $id	= null;	
	var $id_event = null;
	var $title = null;
	var $latitude = null;
	var $longitude = null;	

	function JMap(& $db) {			
		parent::__construct('#__mos_map', 'id', $db);
	}

	function store() {
		return parent::store();
	}
}