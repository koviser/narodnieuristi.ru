<?php
defined('_JEXEC') or die('Restricted access');

class JComment extends JTable
{
	var $id	= null;	 	 	 	 	 	 
 	var $id_event = null; 	 	 	 	 	 	  	 	 	 	 	 		 	 	 	 	 	 	 
 	var $dateQ = null;	 	 	 	 	 	 	 
 	var $dateA = null;	 	 	 	 	 	 	 
 	var $user = null;	 	 	 	 	 	 	 
 	var $message = null;	 	 	 	 	 	 	 
 	var $answer = null; 	 	 	 	 	 
 	var $published = null;	 	 	 	 	 	 	

	function JComment(& $db) {			
		parent::__construct('#__mos_comment', 'id', $db);
	}

	function store() {
		return parent::store();
	}
}
?>