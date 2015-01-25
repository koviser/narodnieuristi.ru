<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );
jimport('joomla.html.pane');


class ViewClient extends JView
{	
	function display($tpl = null)
	{	
		global $mainframe;
		
		$cid		= JRequest::getVar( 'cid', array(0), '', 'array' );				
		$edit		= JRequest::getVar('edit',true);		
		$uid 	= (int) @$cid[0];
		JArrayHelper::toInteger($cid, array(0));
		$db 		=& JFactory::getDBO();
		$item =& new JClient($db);		
		
		
		$user = JFactory::getUser();
		if($edit){ 
			$item->load( $uid );
			if($user->id_roo && $user->id_roo!=$item->id_roo){
				$mainframe->redirect('index.php?option=com_doc', JText::_('ACCESS ERROR'));
			}
		}
		
		//Календари
		//$lists['date_contract'] = JDocCommon::Calendar($item->date_contract, 'date_contract');
		$lists['date_admission'] = JDocCommon::Calendar($item->date_admission, 'date_admission');
		$lists['date_filing'] = JDocCommon::Calendar($item->date_filing, 'date_filing');
		$lists['date_response'] = JDocCommon::Calendar($item->date_response, 'date_response');
		$lists['date_filling_court'] = JDocCommon::Calendar($item->date_filling_court, 'date_filling_court');
		$lists['date_court'] = JDocCommon::Calendar($item->date_court, 'date_court');
		$lists['date_pending_cases'] = JDocCommon::Calendar($item->date_pending_cases, 'date_pending_cases');
		$lists['date_first_instance'] = JDocCommon::Calendar($item->date_first_instance, 'date_first_instance');
		$lists['date_receipt_writ'] = JDocCommon::Calendar($item->date_receipt_writ, 'date_receipt_writ');
		$lists['date_filing_writ'] = JDocCommon::Calendar($item->date_filing_writ, 'date_filing_writ');
		$lists['date_filing_appeal'] = JDocCommon::Calendar($item->date_filing_appeal, 'date_filing_appeal');
		$lists['date_receipt_appeal'] = JDocCommon::Calendar($item->date_receipt_appeal, 'date_receipt_appeal');
		$lists['date_case'] = JDocCommon::Calendar($item->date_case, 'date_case');
		$lists['date_filing_cassation'] = JDocCommon::Calendar($item->date_filing_cassation, 'date_filing_cassation');
		$lists['date_receipt_cassation'] = JDocCommon::Calendar($item->date_receipt_cassation, 'date_receipt_cassation');
		$lists['date_case_appeal'] = JDocCommon::Calendar($item->date_case_appeal, 'date_case_appeal');
		//Списки для работников 
		$lists['consultant'] = JDocCommon::WorkerList($item->id_consultant, 'id_consultant');
		$lists['wrote_complaint'] = JDocCommon::WorkerList($item->id_wrote_complaint, 'id_wrote_complaint');
		$lists['wrote_petition_court'] = JDocCommon::WorkerList($item->id_wrote_petition_court, 'id_wrote_petition_court');
		$lists['representing_court'] = JDocCommon::WorkerList($item->id_representing_court, 'id_representing_court');
		
		$lists['service'] = JDocCommon::ServiceList($item->service);
		
		$lists['type'] = JDocCommon::TypeList($item->id_type);
		$lists['category'] = JDocCommon::CategoryList($item->id_category);
		
		if($user->id_roo){
			$lists['roo'] = JDocCommon::RooList($user->id_roo, 'readonly');
		}else{
			$lists['roo'] = JDocCommon::RooList($item->id_roo);
		}
		
		//$lists['published'] = JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $item->published);
		
		$this->assignRef('lists',$lists);	
		$this->assignRef('item',$item);			
		
		parent::display($tpl);
	}
}
?>