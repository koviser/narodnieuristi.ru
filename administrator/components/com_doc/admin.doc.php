<?php
defined('_JEXEC') or die('Restricted access');
define('COM_SHOP_BASE', JPath::clean(JPATH_ROOT));
define('COM_SHOP_BASEURL', JURI::root());

require_once (JPATH_COMPONENT.DS.'common.php');
require_once (JPATH_COMPONENT.DS.'classes'.DS.'client.php');
require_once (JPATH_COMPONENT.DS.'classes'.DS.'type.php');
require_once (JPATH_COMPONENT.DS.'classes'.DS.'worker.php');
require_once (JPATH_COMPONENT.DS.'classes'.DS.'roo.php');
require_once (JPATH_COMPONENT.DS.'classes'.DS.'news.php');
require_once (JPATH_COMPONENT.DS.'classes'.DS.'comments.php');
require_once (JPATH_COMPONENT.DS.'classes'.DS.'media.php');
jimport('joomla.filesystem.file');

$controller = JRequest::getVar('controller');
if(!$controller) {
	$controller= 'client';
}
require_once (JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php');
$classname	= 'Controller'.$controller;


$controller = new $classname( );
$controller->execute( JRequest::getVar('task'));

$controller->redirect();
?>