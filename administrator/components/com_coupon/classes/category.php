<?php
defined('_JEXEC') or die('Restricted access');

class JCategory extends JTable
{
	var $id	= null;	 	 	 	 	 	 
 	var $title = null;
	var $xml = null;
	var $ordering = null; 	 	 	 	 	 	  	 	 	 	 	 		 	 	 	 	 	 	  	 	 	 	 	 	 	 	 	 	 	 	  	 	 	 	 	

	function JCategory(& $db) {			
		parent::__construct('#__mos_category', 'id', $db);
	}

	function store() {
		return parent::store();
	}
}
?>