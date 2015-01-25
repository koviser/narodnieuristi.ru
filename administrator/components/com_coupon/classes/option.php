<?php
defined('_JEXEC') or die('Restricted access');

class JOption extends JTable
{
	var $id	= null;	 	 	 	 	 	 
 	var $title = null;
	var $catid = null;	 	 	 	 	 	  	 	 	 	 	 		 	 	 	 	 	 	  	 	 	 	 	 	 	 	 	 	 	 	  	 	 	 	 	

	function JOption(& $db) {			
		parent::__construct('#__mos_options', 'id', $db);
	}

	function store() {
		return parent::store();
	}
}
?>