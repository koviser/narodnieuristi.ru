<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.controller' );


class ControllerClient extends JController
{	
	function __construct()
	{					
		parent::__construct();							
	}
	
	function display()
	{			
		switch($this->getTask())
		{			
			case 'add'     :
			{					
				JRequest::setVar('view', 'client');
				JRequest::setVar('edit', false);
				JRequest::setVar('hidemainmenu', 1);
			} break;
			case 'edit'    :
			{							    
				JRequest::setVar('view', 'client');
				JRequest::setVar('edit', true);		
				JRequest::setVar('hidemainmenu', 1);				
			} break;			
			default : 						   
				JRequest::setVar('view', 'clients');			
				break;
		}				
		parent::display();
	}	
	
	function save()
	{
		global $mainframe;		

		JRequest::checkToken() or jexit( 'Invalid Token' );				

		$db			= & JFactory::getDBO();		
		 		
		$client	= &new JClient($db);
		
		
		$post = JRequest::get( 'post' );
		$post['service'] = serialize($post['services']);
		
		//$post['dateStart'] = date("Y-m-d", strtotime($post['dateStart']));

		if (!$client->bind( $post ))
		{
			JError::raiseError(500, $client->getError() );
		}
		/*
		///////////////////////
		$file = JRequest::getVar( 'image', '', 'files', 'array' );		
		$file['name'] = JImageExtend::makeSafe($file['name']);	
		if ($file['name']) 
		{			
			$client->deleteImage($client->id);
			$path = '..'.DS.'images'.DS.'clients';
			$filepath = JPath::clean($path.DS.'med_'.strtolower($file['name']));
			//$filepath2 = JPath::clean($path.DS.'thumb_'.strtolower($file['name']));
			//$filepath3 = JPath::clean($path.DS.strtolower($file['name']));
			$int=1;
			while (JImageExtend::exists($filepath))
			{
				$file['name'] = $int.$file['name'];						
				$filepath = JPath::clean($path.DS.'med_'.strtolower($file['name']));
				//$filepath2 = JPath::clean($path.DS.'thumb_'.strtolower($file['name']));
				//$filepath3 = JPath::clean($path.DS.strtolower($file['name']));
				$int++;
			}

			if (!JImageExtend::uploadAndResize($file['tmp_name'], $filepath, 435, 277)) 
			{				
				JError::raiseError(100, JText::_('Error. Unable to upload foto'));				
				return false;	
			} 
			else			
			{				
				$client->image = strtolower($file['name']);
			}
		}
		///////////////////////
		*/
		if(!$client->id && !$client->number){
			$gen_number = 1;
		}
			
		if (!$client->store())
		{
			JError::raiseError(500, $client->getError() );
		}
		
		if($gen_number){
			$user=JFactory::getUser();
			$client->number =date('Y').'-'.sprintf("%03d",$client->id_roo).'-'.sprintf("%03d",$user->id).'-'.sprintf("%03d",$client->id);
			if (!$client->store())
			{
				JError::raiseError(500, $client->getError() );
			}
		}
		
				
		switch ( $this->getTask() )
		{
			case 'apply':
				$msg = JText::sprintf( 'SUCCESSFULLY SAVED CHANGE' );
				$this->setRedirect( 'index.php?option=com_doc&controller=client&view=client&task=edit&cid[]='. $client->get('id'), $msg );
				break;

			case 'save':
			default:
				$msg = JText::sprintf( 'SUCCESSFULLY SAVED');				
				$this->setRedirect( 'index.php?option=com_doc&controller=client&view=clients', $msg );
				break;
		}
	}


	function apply()
	{
		$this->save();
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
		$msg = JText::sprintf( 'SUCCESSFULLY DELETED');	       
		foreach ($cid as $id)
		{					    			
			$client = new JClient($db);		    
			$client->delete($id);
			unset($client);
			JRequest::setVar( 'task', 'remove' );
			JRequest::setVar( 'cid', $id );
		}	
			
		$this->setRedirect( 'index.php?option=com_doc&controller=client&view=clients', $msg);
	}
	
	function xls()
	{
		global $mainframe;
		$model = &$this->getModel('xls');
		$model->getXls();
		exit;	
	}
	
	function doc()
	{
		global $mainframe;
		$model = &$this->getModel('doc');
		$model->getDoc();
		exit;	
	}
	
	function doc2()
	{
		global $mainframe;
		$model = &$this->getModel('doc');
		$model->getDoc_2();
		exit;	
	}
	
	function doc3()
	{
		global $mainframe;
		$model = &$this->getModel('doc');
		$model->getDoc_3();
		exit;	
	}
	
	function doc4()
	{
		global $mainframe;
		$model = &$this->getModel('doc');
		$model->getDoc_4();
		exit;	
	}
	
	function doc5()
	{
		global $mainframe;
		$model = &$this->getModel('doc');
		$model->getDoc_5();
		exit;	
	}
	
	function doc6()
	{
		global $mainframe;
		$model = &$this->getModel('doc');
		$model->getDoc_6();
		exit;	
	}
	
	function doc7()
	{
		global $mainframe;
		$model = &$this->getModel('doc');
		$model->getDoc_7();
		exit;	
	}
	// НОВЫЕ ФУНКЦИИ ГЕНЕРАЦИИ ДОКУМЕНТОВ
	function akt_free()
	{
		$model = &$this->getModel('rtf');
		$model->getDoc('docs/akt_free.rtf');
	}
	function akt_pay()
	{
		$model = &$this->getModel('rtf');
		$model->getDoc('docs/akt_pay.rtf');	
	}
	function application_commission()
	{
		$model = &$this->getModel('rtf');
		$model->getDoc('docs/application_commission.rtf');
	}
	function application_developers()
	{
		$model = &$this->getModel('rtf');
		$model->getDoc('docs/application_developers.rtf');	
	}
	function application_osago()
	{
		$model = &$this->getModel('rtf');
		$model->getDoc('docs/application_osago.rtf');
	}
	function complaint_commission()
	{
		$model = &$this->getModel('rtf');
		$model->getDoc('docs/complaint_commission.rtf');
	}
	function complaint_developers()
	{
		$model = &$this->getModel('rtf');
		$model->getDoc('docs/complaint_developers.rtf');
	}
	function complaint_osago()
	{
		$model = &$this->getModel('rtf');
		$model->getDoc('docs/complaint_osago.rtf');
	}
	function forma_free()
	{
		$model = &$this->getModel('rtf');
		$model->getDoc('docs/forma_free.rtf');
	}
	function forma_pay()
	{
		$model = &$this->getModel('rtf');
		$model->getDoc('docs/forma_pay.rtf');
	}
	function receipt()
	{
		$model = &$this->getModel('rtf');
		$model->getDoc('docs/receipt.rtf');
	}
	function statement_absence_free()
	{
		$model = &$this->getModel('rtf');
		$model->getDoc('docs/statement_absence_free.rtf');
		$model->getDoc('docs/statement_absence_pay.rtf');	
	}
	function statement_absence_pay()
	{
		$model = &$this->getModel('rtf');
		$model->getDoc('docs/statement_absence_pay.rtf');	
	}
	//
	function bill()
	{
		global $mainframe;
		$model = &$this->getModel('pdf');
		$model->getBill();
		exit;	
	}
	
	function zip()
	{
		jimport( 'zip.zipstream' );
		
		$zip = new ZipStream('example.zip');

		// Добавить первый файл
		$data = $this->xls();
		$zip->add_file('report.xls', $data);
		
		$data = file_get_contents('index.php?option=com_doc&task=xls');
		$zip->add_file('report_2.xls', $data);
		/*
		// добавить второй файл
		$data = file_get_contents('some_file.gif');
		$zip->add_file('another_file.png', $data);	
		*/
		$zip->finish();
	}
}

