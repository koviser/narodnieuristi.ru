<?php
defined('_JEXEC') or die('Restricted access');

class JCompetition extends JTable
{
	var $id = null; 	 	 	 	 	 	 
 	var $type = null;		 	 	 	 	 	 	 
 	var $title = null;			 	 	 	 	 	 	 
 	var $description = null;		 	 	 	 	 	 	 
 	var $dateStart = null;			 	 	 	 	 	 	 
 	var $dateEnd = null;		 	 	 	 	 	 	 
 	var $bonusType = null;		 	 	 	 	 	 	 
 	var $bonus = null;			 	 	 	 	 	 	 
 	var $image = null;		 	 	 	 	 	 	 
 	var $published = null; 	 	 	 	 	 	 
 	var $status = null;

	function JCompetition(& $db) {			
		parent::__construct('#__mos_competition', 'id', $db);
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
		$dirname = JPATH_SITE.DS.'images'.DS.'competitions';
		$this->deleteFile($dirname.DS.$basename);
	}
	function delete($oid)
	{
		$this->load($oid);
		$basename = basename($this->image);
		$dirname = JPATH_SITE.DS.'images'.DS.'competitions';
		$this->deleteFile($dirname.DS.$basename);
		return parent::delete($oid);
	}
}
?>