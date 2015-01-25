<?php
defined('_JEXEC') or die('Restricted access');

class JImage extends JTable
{
	var $id	= null;	
	var $id_event = null;
	var $image = null;
	var $ordering = null;
	var $published = null;	

	function JImage(& $db) {			
		parent::__construct('#__mos_image', 'id', $db);
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
		//$this->deleteFile($dirname.DS.'big_'.$basename);
		//$this->deleteFile($dirname.DS.'thumbbig_'.$basename);
	}
	function delete($oid)
	{
		$this->load($oid);
		//$basename = basename($this->image);
		//$dirname = JPATH_SITE.DS.'images'.DS.'events';
		//$this->deleteFile($dirname.DS.'big_'.$basename);
		//$this->deleteFile($dirname.DS.'thumbbig_'.$basename);
		return parent::delete($oid);
	}	
}