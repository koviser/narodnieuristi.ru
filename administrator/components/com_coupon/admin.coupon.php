<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.helper');
define('COM_SHOP_BASE', JPath::clean(JPATH_ROOT));
define('COM_SHOP_BASEURL', JURI::root());

require_once (JPATH_COMPONENT.DS.'common.php');
require_once (JPATH_COMPONENT.DS.'classes'.DS.'map.php');
require_once (JPATH_COMPONENT.DS.'classes'.DS.'event.php');
require_once (JPATH_COMPONENT.DS.'classes'.DS.'image.php');
require_once (JPATH_COMPONENT.DS.'classes'.DS.'images.php');
//require_once (JPATH_COMPONENT.DS.'classes'.DS.'comment.php');
require_once (JPATH_COMPONENT.DS.'classes'.DS.'category.php');
require_once (JPATH_COMPONENT.DS.'classes'.DS.'order.php');
//require_once (JPATH_COMPONENT.DS.'classes'.DS.'city.php');
//require_once (JPATH_COMPONENT.DS.'classes'.DS.'competition.php');
require_once (JPATH_COMPONENT.DS.'classes'.DS.'photo.php');
//require_once (JPATH_COMPONENT.DS.'classes'.DS.'bgiftcard.php');
//require_once (JPATH_COMPONENT.DS.'classes'.DS.'giftcard.php');
//require_once (JPATH_COMPONENT.DS.'classes'.DS.'giftcardcsv.php');
require_once (JPATH_COMPONENT.DS.'classes'.DS.'metro.php');
require_once (JPATH_COMPONENT.DS.'helpers'.DS.'media.php');
require_once (JPATH_COMPONENT.DS.'classes'.DS.'option.php');
require_once (JPATH_COMPONENT.DS.'classes'.DS.'variant.php');

$controller = JRequest::getVar('controller');
if(!$controller) {
	$controller= 'event';
}


require_once (JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php');
$classname	= 'Controller'.$controller;


$controller = new $classname( );
$controller->execute( JRequest::getVar('task'));

$controller->redirect();
?>