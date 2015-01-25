<?php
defined('_JEXEC') or die('Restricted access');

class JNews extends JTable
{
	var $id	= null;	 	 	 	 	 	 
 	var $title = null;
	var $full_text = null; 
	var $image = null;  	 	 	 	 	  	 	 	 	 	 		 	 	 	 	 	 	  	 	 	 	 	 	 	 	 	 	 	 	  	 	 	 	 	

	function JNews(& $db) {			
		parent::__construct('#__7t_doc_news', 'id', $db);
	}

	function store() {
		return parent::store();
	}
}
?>