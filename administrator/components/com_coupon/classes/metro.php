<?php
defined('_JEXEC') or die('Restricted access');

class JMetro extends JTable
{
	var $id	= null;	
	var $title = null;

	function JMetro(& $db) {			
		parent::__construct('#__mos_metro', 'id', $db);
	}

	function store() {
		return parent::store();
	}
}