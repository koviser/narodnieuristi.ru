<?php
defined('_JEXEC') or die('Restricted access');

class JEvents extends JTable
{
	var $id	= null;
	var $type	= null;
	var $free	= null;
	var $day	= null;	
	var $bonus	= null;	 	 	 	 	 	 
 	var $title = null;
	var $subtitle = null;
	var $subterms = null;
	var $intro = null; 	
	var $catid = null; 	
	var $city = null; 
	var $total = null; 	
	var $advertiser = null;	 	 	 	 	 	  	 	 	 	 	 	 	 	 	 	 	 	 
 	var $sale = null;	 	 	 	 	 	 	 
 	var $price = null;	 	 	 	 	 	 	 
 	var $realPrice = null; 	 	 	 	 	 
 	var $terms = null;	 	 	 	 	 	 
 	var $features = null;
	var $contacts = null;	 	 	 	 	 	 	 
 	var $info = null;
	var $metro_id = null;
	var $metro_count = null;
	var $metro = null;	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 
	var $image = null;	 	 	 	 	 	 	 
 	var $count = null; 
	var $min_count = null; 
	var $max_count = null; 	 	 	 	 
 	var $ordering = null;	 	 	 	 	 	 	 
 	var $published = null;	
	var $send = null;
	var $email = null;	
	var $password = null;
	var $company = null;
	var $phone = null;
	var $url = null;
	var $bgimage = null;
	var $bgcolor = null;
	var $bgrepeat = null;
	var $horizontal = null;	
	var $vertical = null;
	var $meta_title = null;	
	var $meta_desc = null;

	function JEvents(& $db) {			
		parent::__construct('#__mos_event', 'id', $db);
	}

	function store() {
		return parent::store();
	}
	function deleteFile($filename)
	{		
		if (file_exists($filename))
			unlink ($filename);		
	}
	function deleteImage($oid)
	{
		$this->load($oid);
		//$basename = basename($this->image);
		//$dirname = JPATH_SITE.DS.'images'.DS.'events';
		//$this->deleteFile($dirname.DS.$basename);
		//$this->deleteFile($dirname.DS.'thumb_'.$basename);
		//$this->deleteFile($dirname.DS.'med_'.$basename);
	}
	function delete($oid)
	{
		$this->load($oid);
		//$basename = basename($this->image);
		//$dirname = JPATH_SITE.DS.'images'.DS.'events';
		//$this->deleteFile($dirname.DS.$basename);
		//$this->deleteFile($dirname.DS.'thumb_'.$basename);
		//$this->deleteFile($dirname.DS.'med_'.$basename);
		return parent::delete($oid);
	}
}
?>