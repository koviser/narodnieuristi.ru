<?php
defined('_JEXEC') or die('Restricted access');

class JComments extends JTable
{
	var $id	= null;	 	 	 	 	 	 
 	var $name = null;
	var $text = null; 
	var $image = null;  	 	 	 	 	  	 	 	 	 	 		 	 	 	 	 	 	  	 	 	 	 	 	 	 	 	 	 	 	  	 	 	 	 	

	function JComments(& $db) {			
		parent::__construct('#__7t_doc_comments', 'id', $db);
	}

	function store() {
		return parent::store();
	}
}
?>