<?php
defined('_JEXEC') or die('Restricted access');

class JPhoto extends JTable
{
	var $id	= null;	
	var $userid = null;
	var $comid = null;
	var $image = null;
	var $rating = null;	

	function JPhoto (& $db) {			
		parent::__construct('#__mos_photos', 'id', $db);
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
		$dirname = JPATH_SITE.DS.'images'.DS.'userphoto';
		$this->deleteFile($dirname.DS.'original'.DS.$basename);
		$this->deleteFile($dirname.DS.'thumb'.DS.$basename);
	}
	function delete($oid)
	{
		$this->load($oid);
		$basename = basename($this->image);
		$dirname = JPATH_SITE.DS.'images'.DS.'userphoto';
		$this->deleteFile($dirname.DS.'original'.DS.$basename);
		$this->deleteFile($dirname.DS.'thumb'.DS.$basename);
		return parent::delete($oid);
	}	
}