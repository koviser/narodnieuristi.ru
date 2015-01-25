<?php
defined('_JEXEC') or die('Restricted access');

class JOrder extends JTable
{
	var $id	= null;	 	 	 	 	 	 
 	var $id_event = null; 	 	 	 	 	  	 	 	 	 	 		 	 	 	 	 	 	 
 	var $email = null;	 	 	 	 	 	 	 
 	var $date = null;
	var $password = null;	 	 	 	 	 	 	 
 	var $status = null;
	var $count = null;
	var $parent = null;	 
	var $use = null;	 	 	 	 	 	 	 	 	 	 	 	 	 	

	function JOrder(& $db) {			
		parent::__construct('#__mos_order', 'id', $db);
	}

	function store() {
		return parent::store();
	}
}
?>