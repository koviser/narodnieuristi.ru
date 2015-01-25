<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.controller' );


class ControllerModImage extends JController
{	
	function __construct()
	{					
		parent::__construct();							
	}
	
    function display()
	{
		global $mainframe;

		$vName = JRequest::getCmd('view', 'modimages');
		switch ($vName)
		{
			case 'modimages':
				default:
				$mName = 'list';
				$vLayout = $mainframe->getUserStateFromRequest('media.list.layout', 'layout', 'thumbs', 'word');
				break;
		}

		$document = &JFactory::getDocument();
		$vType		= $document->getType();

		// Get/Create the view
		$view = &$this->getView( $vName, $vType);

		// Get/Create the model
		if ($model = &$this->getModel($mName)) {
			// Push the model into the view (as default)
			$view->setModel($model, true);
		}

		// Set the layout
		$view->setLayout($vLayout);

		// Display the view
		$view->display();
	}	
	
	function save()
	{
		global $mainframe;		
		
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$post	= JRequest::get( 'post' );
		
		$file = JRequest::getVar( 'image', '', 'files', 'array' );		
		$file['name'] = JFile::makeSafe($file['name']);	
		if(JFile::format($file['name'])){
			$path = '..'.DS.'images'.DS.'bg';			
			$filename = JFile::getFileName(1, $file['name']);
			$filepath = JPath::clean($path.DS.$filename);
			$filepath2 = JPath::clean($path.DS.'thumb'.DS.$filename);
			while (JFile::exists($filepath)){
				$filename = $int.$filename;						
				$filepath = JPath::clean($path.DS.$filename);
				$filepath2 = JPath::clean($path.DS.'thumb'.DS.$filename);
				$int++;
			}
			
			if (JFile::upload($file['tmp_name'], $filepath)){				
				JFile::copyAndResize($filepath, $filepath2, 100, 100);
			}
			$msg = JText::sprintf( 'SUCCESSFULLY SAVED');	
					
			$this->setRedirect( 'index.php?option=com_coupon&controller=modimage&view=modimages&tmpl=component', $msg );
		}
	}
}
?>