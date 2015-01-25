<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.controller' );


class ControllerImage extends JController
{	
	function __construct()
	{					
		parent::__construct();							
	}
	
    function display()
	{
		global $mainframe;

		$vName = JRequest::getCmd('view', 'images');
		switch ($vName)
		{
			case 'images':
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
		if ($file['name']) {			
			$path = "../images/";
			$filepath = JPath::clean($path.strtolower($file['name']));
			$i=1;
			while (JFile::exists($filepath)){
				$file['name'] = $i.$file['name'];						
				$filepath = JPath::clean($path.strtolower($file['name']));
				$i++;
			}
			
			if (!JFile::upload($file['tmp_name'], $filepath)) {				
				JError::raiseError(100, JText::_('Error. Unable to upload foto'));				
				return false;	
			}
		}
		$msg = JText::sprintf( 'SUCCESSFULLY SAVED');	
					
		$this->setRedirect( 'index.php?option=com_doc&controller=image&view=images&tmpl=component', $msg );
	}
}
?>