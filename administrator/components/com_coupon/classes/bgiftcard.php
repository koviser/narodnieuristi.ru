<?php
defined('_JEXEC') or die('Restricted access');

class JBGiftcard extends JTable
{
	var $id	= null;	 	 	 	 	 
 	var $password = null;   	 	 	 	 	  	 	 	 	 	  	 	 	 	 	 	  	 	 	 	 	 	 
 	var $nominal = null;	 	 	 	 	 	 	 	 	 	 	  	 	 	 	 	 	 
 	var $dateStart = null;	 	 	 	 	  	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 
	var $dateEnd = null;	 	 	 	 	 	 	 
	var $count = null;			

	function JBGiftcard(& $db) {			
		parent::__construct('#__mos_bgiftcard', 'id', $db);
	}

	function store() {
		return parent::store();
	}
}
?>