<?php
defined('_JEXEC') or die('Restricted access');

class JRoo extends JTable
{
	var $id	= null;	 	 	 	 	 	 
 	var $title = null;
	var $full_title = null;
	var $intro_title = null;
	var $full_adress = null;
	var $doc_number = null;
	var $doc_date = null;
	var $signature = null;
	var $date_procuratory = null;
	var $adress = null; 
	var $director = null;
	var $front_title = null;	 	 	 	 	 	 
 	var $time = null;
	var $phone = null; 
	var $latitude = null; 
	var $longitude = null;  	 	 	 	 	  	 	 	 	 	 		 	 	 	 	 	 	  	 	 	 	 	 	 	 	 	 	 	 	  	 	 	 	 	

	function JRoo(& $db) {			
		parent::__construct('#__7t_doc_roo', 'id', $db);
	}

	function store() {
		return parent::store();
	}
}
?>