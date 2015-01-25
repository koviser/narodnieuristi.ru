<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.controller' );

class ControllerGiftCardCSV extends JController
{	
	function __construct()
	{					
		parent::__construct();							
	}
	
	function display()
	{						
		JRequest::setVar('view', 'giftcardcsv');
		parent::display();
	}
	
	function save()
	{
		global $mainframe;		

		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );				


		// Initialize some variables
		$db	= & JFactory::getDBO();		;
		
		$file = JRequest::getVar( 'file', '', 'files', 'array' );
		if ($file['name']) 
		{			

			jimport( 'excel.excel' );
			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('UTF-8');
			$data->read($file['tmp_name']);
			
			$xml = array();
			
			for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
				for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
					$xml[$i][] = $data->sheets[0]['cells'][$i][$j];
				}
			}

			for($i=1;$i<(count($xml)+1);$i++){
				$obj=$xml[$i];
				$element = new JGiftcardCSV($db);
				$post['password']=$obj[0];
				$post['nominal']=(float)$obj[1];
				$post['published']=1;
				
				if (!$element->bind( $post )){
					JError::raiseError(500, $element->getError() );
				}
				
				if (!$element->store()){
					JError::raiseError(500, $element->getError() );
				}
				
				unset($element);
				unset($post);
			}
			$msg = JText::_('FILE UPLOAD');	
		}else{
			$msg = JText::_('UPLOAD ERROR');	
		}	
		$this->setRedirect( 'index.php?option=com_coupon&controller=giftcardcsv', $msg );
	}	
	
	function remove()
	{			
        JRequest::checkToken() or jexit( 'Invalid Token' );
		$db =& JFactory::getDBO();		
		$cid = JRequest::getVar( 'cid', array(), '', 'array' );						
		JArrayHelper::toInteger( $cid );
		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'SELECT DELETE', true ) );
		}        
		foreach ($cid as $id)
		{					    				
			$gift = new JGiftcardCSV($db);		    
			$gift->delete($id);
			unset($gift);										
			JRequest::setVar( 'task', 'remove' );
			JRequest::setVar( 'cid', $id );								
		}	
		$msg = JText::sprintf( 'SUCCESSFULLY DELETED');		
		$this->setRedirect( 'index.php?option=com_coupon&controller=giftcardcsv', $msg);
	}
	
	function publish()
	{		
		$db		=& JFactory::getDBO();		
		$cid     = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		JArrayHelper::toInteger($cid, array(0));
		$publish = ( $this->getTask() == 'publish' ? 1 : 0 );		

		if (count( $cid ) < 1) {
			$action = $publish ? JText::_( 'publish' ) : JText::_( 'unpublish' );
			JError::raiseError(500, JText::_( 'Select a event to '.$action ) );
		}

		$cids = implode( ',', $cid );

		$query = 'UPDATE #__mos_giftcard_csv SET published = '.(int) $publish
			. ' WHERE id IN ( '.$cids.' )'			
			;		
		$db->setQuery( $query );
		if (!$db->query()) {
			JError::raiseError(500, $db->getErrorMsg() );
		}		

		$this->setRedirect( 'index.php?option=com_coupon&controller=giftcardcsv');
	}
	
	function unpublish()
	{
		$this->publish();
	}
}
?>


