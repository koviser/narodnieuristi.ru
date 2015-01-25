<?php

class MY_Behavior
{
	function mootoolsFixScript($debug = null, $version='1.2')
	{
		global $mainframe;
		$document = JFactory::getDocument();
		if ($mainframe->isSite() && $version=='1.2' && $debug===null && JRequest::getCmd( 'option' ) != 'com_virtuemart') {
			$tooltipStr	 = "window.addEvent('domready', function(){ var JTooltips = new Tips($$('.hasTip'), { maxTitleChars: 50, fixed: false}); });";
				if ( strpos($document->_script['text/javascript'],'JTooltips') !== false ) {
					$inline_script_text = <<<EOT
					window.addEvent('domready', function(){
		
					var JTooltips = new Tips($$('.hasTip'), {
					maxTitleChars: 50, 
					title: function (el) {
				if ( (el.get('title') || "").test("::") ) {
					el.set('title', el.get('title').replace(/\\\/g,'') )
					var text = el.get('title').match(/(.*)::(.*)/);
					el.set("rel",text[2]);
					return text[1];
				} else {
					el.set("rel",el.get('title'));
				}
			}
		});
	});
EOT;
					$script = str_replace($tooltipStr,'',$document->_script['text/javascript']);
					$script .= $inline_script_text;
					return $script;
				}
		}
	}
	function mootoolsFix($debug = null, $version='1.2')
	{
		global $mainframe;
		$document = JFactory::getDocument();
		if ($mainframe->isSite() && $version=='1.2' && $debug===null && JRequest::getCmd( 'option' ) != 'com_virtuemart') {
  			$scripts = array();
			foreach ($document->_scripts as $script=>$type) {
				if (strpos($script,'mootools.js') !== false ) {
					$scripts['media/system/js/mootools-1.2.3-core.js'] = 'text/javascript';
					$scripts['media/system/js/mootools-1.2.3.1-more.js'] = 'text/javascript';
					$scripts['media/system/js/mootools-compat-111-12.js'] = 'text/javascript';
				} else if (strpos($script,'modal.js') !== false){
					$scripts['media/system/js/modal-1.2.js'] = 'text/javascript';
				} else {
					$scripts[$script] = $type;
				}
			}
			if (!array_key_exists('media/system/js/mootools-1.2.3-core.js',$scripts)) {
				$scripts['media/system/js/mootools-1.2.3-core.js'] = 'text/javascript';
				$scripts['media/system/js/mootools-1.2.3.1-more.js'] = 'text/javascript';
				$scripts['media/system/js/mootools-compat-111-12.js'] = 'text/javascript';
			}
			$document->_scripts = $scripts;
			return $scripts;
		}
	}
}
?>
