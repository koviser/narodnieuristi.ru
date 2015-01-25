<?php
defined('_JEXEC') or die('Restricted access');

class JCity extends JTable
{
	var $id	= null;	 	 	 	 	 	 
 	var $title = null; 
	var $xml = null; 		 	 	 	 	 	  	 	 	 	 	 		 	 	 	 	 	 	 
 	var $ordering = null;	 	 	 	 	 	 	 	 	 	 	 	 	 	  	 	 	 	 	

	function JCity(& $db) {			
		parent::__construct('#__mos_city', 'id', $db);
	}

	function store() {
		return parent::store();
	}
}
?>