<?php
defined('_JEXEC') or die('Restricted access');
define('ITEMID', '14');
require_once (JPATH_COMPONENT.DS.'controller.php');
$controller = new Controller();
// Perform the Request task

$controller->execute(JRequest::getCmd('task'));

// Redirect if set by the controller
$controller->redirect();

