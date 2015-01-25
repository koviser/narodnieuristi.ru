<?php

defined('JPATH_BASE') or die();

class JDocumentRendererMessage extends JDocumentRenderer
{
	function render($name = null, $params = array (), $content = null)
	{
		global $mainframe;
		
		$contents	= null;
		$lists		= null;

		$messages = $mainframe->getMessageQueue();
	
		if (is_array($messages) && count($messages)) {
			foreach ($messages as $msg)
			{
				if (isset($msg['type']) && isset($msg['message'])) {
					$lists[$msg['type']][] = $msg['message'];
				}
			}
		}

		if(!isset($mainframe->setTemplate)){
			if (is_array($lists))
			{
				$contents .= "\n<dl id=\"system-message\">";
				foreach ($lists as $type => $msgs)
				{
					if (count($msgs)) {
						$contents .= "\n<dt class=\"".strtolower($type)."\">".JText::_( $type )."</dt>";
						$contents .= "\n<dd class=\"".strtolower($type)." message fade\">";
						$contents .= "\n\t<ul>";
						foreach ($msgs as $msg)
						{
							$contents .="\n\t\t<li>".$msg."</li>";
						}
						$contents .= "\n\t</ul>";
						$contents .= "\n</dd>";
					}
				}
				$contents .= "\n</dl>";
			}
		}else{
			if (is_array($lists))
			{
				$contents="
					<script type=\"text/javascript\">
						window.addEvent('domready', function() {
							$('system-message').set('opacity',0);
							$('system-message').setStyle('display','block');
							var messageFx = new Fx.Tween($(\"system-message\"), {
								property: 'opacity',
								duration: 1000, 
								transition: Fx.Transitions.Quart.easeInOut
							});
							messageFx.start.pass([0,1], messageFx).delay(500);
							messageFx.start.pass([1,0], messageFx).delay(3000);
						});
					</script>";
				$contents .= '<div class="sys-message">';
				foreach ($lists as $type => $msgs)
				{
					if (count($msgs)) {
						foreach ($msgs as $msg)
						{
							$contents .="<div>".$msg."</div>";
						}
					}
				}
				$contents .= "</div>";
			}
		}
		return $contents;
	}
}
