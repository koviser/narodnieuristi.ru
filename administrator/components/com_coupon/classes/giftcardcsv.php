<?php
defined('_JEXEC') or die('Restricted access');

class JGiftcardCSV extends JTable
{
	var $id	= null;	 	 	 	 	 
 	var $password = null;   	 	 	 	 	  	 	 	 	 	  	 	 	 	 	 	  	 	 	 	 	 	 
 	var $nominal = null;	 	 	 	 	 	 	 	 	 	 	  	 	 	 	 	 	 	 	 	 	 	 	 	 
	var $published = null;	
	var $used = null;			

	function JGiftcardCSV(& $db) {			
		parent::__construct('#__mos_giftcard_csv', 'id', $db);
	}

	function store() {
		return parent::store();
	}
}
?>