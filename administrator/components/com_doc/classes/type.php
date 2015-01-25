<?php
defined('_JEXEC') or die('Restricted access');

class JType extends JTable
{
	var $id	= null;	 	 	 	 	 	 
 	var $title = null; 
	var $description = null; 	 	 	 	 	  	 	 	 	 	 		 	 	 	 	 	 	  	 	 	 	 	 	 	 	 	 	 	 	  	 	 	 	 	

	function JType(& $db) {			
		parent::__construct('#__7t_doc_types', 'id', $db);
	}

	function store() {
		return parent::store();
	}
}
?>