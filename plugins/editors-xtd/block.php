<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

class plgButtonBlock extends JPlugin
{
	function plgButtonBlock(& $subject, $config)
	{
		parent::__construct($subject, $config);
	}

	function onDisplay($name)
	{
		global $mainframe;

		$doc 		=& JFactory::getDocument();
		$template 	= $mainframe->getTemplate();

		$getContent = $this->_subject->getContent($name);
		$present = JText::_('ALREADY EXISTS', true) ;
		$js = "
			function insertBlock(editor) {
				var content = $getContent
				jInsertEditorText('<hr id=\"sys\" />', editor);
			}
			";

		$doc->addScriptDeclaration($js);

		$button = new JObject();
		$button->set('modal', false);
		$button->set('onclick', 'insertBlock(\''.$name.'\');return false;');
		$button->set('text', JText::_('Spacer'));
		$button->set('name', 'readmore');
		$button->set('link', '#');

		return $button;
	}
}