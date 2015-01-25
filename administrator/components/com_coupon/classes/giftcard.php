<?php
defined('_JEXEC') or die('Restricted access');

class JGiftcard extends JTable
{
	var $id	= null;	 	 	 	 	 
 	var $title = null;   	 	 	 	 	  	 	 	 	 	  	 	 	 	 	 	  	 	 	 	 	 	 
 	var $price = null;	 	 	 	 	 	 	 	 	 	 	  	 	 	 	 	 	 
 	var $info = null;	 	 	 	 	  	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 
	var $image = null;	 	 	 	 	 	 	 
 	var $count = null;
	var $published = null;			

	function JGiftcard(& $db) {			
		parent::__construct('#__mos_giftcard', 'id', $db);
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
		$basename = basename($this->image);
		$dirname = JPATH_SITE.DS.'images'.DS.'events';
		$this->deleteFile($dirname.DS.$basename);
		$this->deleteFile($dirname.DS.'thumb_'.$basename);
		$this->deleteFile($dirname.DS.'big_'.$basename);
		$this->deleteFile($dirname.DS.'original_'.$basename);
	}
	function delete($oid)
	{
		$this->load($oid);
		$basename = basename($this->image);
		$dirname = JPATH_SITE.DS.'images'.DS.'events';
		$this->deleteFile($dirname.DS.$basename);
		$this->deleteFile($dirname.DS.'thumb_'.$basename);
		$this->deleteFile($dirname.DS.'big_'.$basename);
		$this->deleteFile($dirname.DS.'original_'.$basename);
		return parent::delete($oid);
	}
}
?>