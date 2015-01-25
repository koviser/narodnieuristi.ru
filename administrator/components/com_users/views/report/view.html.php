<?php
/**
* @version		$Id: view.html.php 14401 2010-01-26 14:10:00Z louis $
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

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the Users component
 *
 * @static
 * @package		Joomla
 * @subpackage	Users
 * @since 1.0
 */
class UsersViewReport extends JView
{
	function display($tpl = null)
	{
		$id	= JRequest::getVar( 'id', '0', '', 'int');
		$datestart	= JRequest::getVar( 'dateStart', '', '', 'string');
		$dateend	= JRequest::getVar( 'dateEnd', '', '', 'string');
		$report	= JRequest::getVar( 'report', '0', '', 'int');
		
		if ($datestart){		
			$dateStart = strtotime($datestart);					
		}else{		
			$dateStart = strtotime(date("Y-m-d"));
		}
		
		if ($dateend){		
			$dateEnd = strtotime($dateend);					
		}else{		
			$dateEnd = strtotime(date("Y-m-d"));
		}	
		
		require_once (JPATH_COMPONENT.DS.'users.class.php');

		$db 		=& JFactory::getDBO();

		if ( $id )
		{
			$query = 'SELECT a.partner, a.id,a.reward'
			. ' FROM #__users AS a'
			. ' WHERE a.id = '.(int)$id
			;
			$db->setQuery( $query );
			$user = $db->loadObject();
			
			if(!$user->id){
				exit;	
			}
			
			if($report){
				if($user->partner==1){
					$query = 'SELECT COUNT(a.id) AS total, SUM(a.summ) AS summ'
					. ' FROM #__mos_partner_trans AS a'
					. ' WHERE a.userid = '.(int)$id.' AND a.type = 1 AND a.date>='.$db->Quote($datestart.' 00:00:00').' AND a.date<='.$db->Quote($dateend.' 23:59:59')
					;
					$db->setQuery( $query );
					$row = $db->loadObject();
				}else if($user->partner==2){
					$query = 'SELECT COUNT(a.id) AS total, SUM(a.summ) AS summ'
					. ' FROM #__mos_partner_trans AS a'
					. ' WHERE a.userid = '.(int)$id.' AND a.type = 2 AND a.date>='.$db->Quote($datestart.' 00:00:00').' AND a.date<='.$db->Quote($dateend.' 23:59:59')
					;
					$db->setQuery( $query );
					$row = $db->loadObject();
				}else if($user->partner==3){
					$query = 'SELECT COUNT(a.id) AS total, SUM(a.summ) AS summ'
					. ' FROM #__mos_partner_trans AS a'
					. ' WHERE a.userid = '.(int)$id.' AND a.type = 3 AND a.date>='.$db->Quote($datestart.' 00:00:00').' AND a.date<='.$db->Quote($dateend.' 23:59:59')
					;
					$db->setQuery( $query );
					$row = $db->loadObject();
					
					$query = 'SELECT COUNT(a.id) AS users'
					. ' FROM #__users AS a'
					. ' WHERE a.ref = '.(int)$id.' AND a.refUse=0'
					;
					$db->setQuery( $query );
					$row->users = $db->loadResult();
				}
			}
		}else{
			exit;	
		}
		
		$lists['dateStart'] = JHTML::_('calendar', date('Y-m-d', $dateStart), 'dateStart', 'dateStart', $format = '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'20',  'maxlength'=>'19'));
		$lists['dateEnd'] = JHTML::_('calendar', date('Y-m-d', $dateEnd), 'dateEnd', 'dateEnd', $format = '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'20',  'maxlength'=>'19'));
		$this->assignRef('user',$user);
		$this->assignRef('row',$row);
		$this->assignRef('report',$report);
		$this->assignRef('lists',$lists);	

		parent::display($tpl);
	}
}
