<?php
/**
* @version		$Id: users.class.php 14401 2010-01-26 14:10:00Z louis $
* @package		Joomla
* @subpackage	Users
* @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.html.parameter');

/**
 * Legacy class, use JParameter instead
 * @deprecated As of version 1.5
 */
class mosUserParameters extends JParameter
{
	function __construct($text, $file = '', $type = 'component')
	{
		parent::__construct($text, $file);
	}
}

class JUserCommon{
	function refCombo($value, $onchange = ''){
		$items[] = JHTML::_('select.option', 0, JText::_('NO REF') );
		$items[] = JHTML::_('select.option', 1, JText::_('REF_1') );
		$items[] = JHTML::_('select.option', 2, JText::_('REF_2') );
		$items[] = JHTML::_('select.option', 3, JText::_('REF_3') );
			
		return JHTML::_('select.genericlist',   $items, 'partner', 'class="inputbox" size="1" '.$onchange, 'value', 'text', "$value" );
	}
	
	function rooList($value){

			$db 		=& JFactory::getDBO();

			$query = 'SELECT id AS value, title AS text'
				. ' FROM #__7t_doc_roo ORDER BY title'			
				;					

			$db->setQuery( $query );
			$rows = $db->loadObjectList();
			
			$items[] = JHTML::_('select.option', 0, 'Все' );
			
			if (count($rows)>0)
			foreach( $rows as $obj )
			{
				$items[] = JHTML::_('select.option',  $obj->value, JText::_( $obj->text ) );
			}
			return JHTML::_('select.genericlist',   $items, 'id_roo', 'class="inputbox" size="1"', 'value', 'text', "$value" );
		}
}