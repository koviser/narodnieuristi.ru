<?php
defined('_JEXEC') or die('Restricted access');

class JWorker extends JTable
{
	var $id	= null;	 	 	 	 	 	 
 	var $name = null; 	 	 	 	 	  	 	 	 	 	 		 	 	 	 	 	 	  	 	 	 	 	 	 	 	 	 	 	 	  	 	 	 	 	

	function JWorker(& $db) {			
		parent::__construct('#__7t_doc_workers', 'id', $db);
	}

	function store() {
		return parent::store();
	}
}
?>