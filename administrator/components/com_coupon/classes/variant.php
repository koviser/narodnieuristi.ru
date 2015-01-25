<?php
defined('_JEXEC') or die('Restricted access');

class JVariant extends JTable
{
	var $id	= null;	
	var $option_id = null;
	var $title = null;	


	function JVariant(& $db) {			
		parent::__construct('#__mos_option_list', 'id', $db);
	}


	function store() {
		return parent::store();
	}	
}


?>