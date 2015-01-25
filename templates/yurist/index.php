<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="templates/<?php echo $this->template;?>/css/template_css.css" />
	<link rel="stylesheet" href="templates/<?php echo $this->template;?>/css/jquery.fancybox.css" />
	<script type="text/javascript" src="templates/<?php echo $this->template;?>/js/jquery.js"></script>
	<script type="text/javascript" src="templates/<?php echo $this->template;?>/js/select.js"></script>
	<script type="text/javascript">
		jQuery.noConflict();
	</script>
	<script type="text/javascript" src="templates/<?php echo $this->template;?>/js/cycle.js"></script>
	<script type="text/javascript" src="templates/<?php echo $this->template;?>/js/html5shiv.js"></script>
	<script type="text/javascript" src="templates/<?php echo $this->template;?>/js/jquery.fancybox.pack.js"></script>
	<script type="text/javascript" src="templates/<?php echo $this->template;?>/js/scripts.js"></script>
	<link href="favicon.ico" rel="shortcut icon" type="image/x-icon" />
	<?php
		JHTML::_("behavior.mootools");
		JHTML::_('behavior.formvalidation');
		$document = &JFactory::getDocument();
		$document->addScript('components/com_coupon/js/main.js');
	?>
<jdoc:include type="head" />
</head>
<body>
	<!--<div id="overlay" style="height: 1118px; visibility: hidden; zoom: 1; opacity: 0;"></div>-->
		<header>
			<section>
				<a href="<?php echo JURI::base();?>" class="logo"></a>
				<jdoc:include type="modules" name="header" />
			</section>
		</header>
		<div class="we-can-help">
			<section>
				<jdoc:include type="modules" name="center" />
			</section>
		</div>
		<jdoc:include type="modules" name="main" />
		<div class="request-block">
			<section>
				<jdoc:include type="component" />
			</section>
		</div>
        <jdoc:include type="modules" name="bottom" />
		<footer>
			<section>
            	<jdoc:include type="modules" name="footer" />
			</section>
		</footer>
        <!-- Yandex.Metrika counter -->
        	<script type="text/javascript">
        		(function (d, w, c) {
        			 (w[c] = w[c] || []).push(function() { 
        			 	try { 
        			 		w.yaCounter22996822 = new Ya.Metrika({id:22996822, 
        			 									webvisor:true, 
        			 									clickmap:true, 
        			 									trackLinks:true, 
        			 									accurateTrackBounce:true}); 

        			 		 w.yaCounter27961860 = new Ya.Metrika({id:27961860,
									                    webvisor:true,
									                    clickmap:true,
									                    trackLinks:true,
									                    accurateTrackBounce:true});
        			 		} catch(e) { } 
        			 }); 
        			 var n = d.getElementsByTagName("script")[0], 
        			 	s = d.createElement("script"), 
        			 	f = function () { n.parentNode.insertBefore(s, n); }; 
        			 s.type = "text/javascript"; 
        			 s.async = true; 
        			 s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; 

        			 if (w.opera == "[object Opera]") { 
        			 	d.addEventListener("DOMContentLoaded", f, false); 
        			 } else { f(); } 
        		})(document, window, "yandex_metrika_callbacks");
        	</script>
        	<noscript><div>
        		<img src="//mc.yandex.ru/watch/22996822" style="position:absolute; left:-9999px;" alt="" />
        		<img src="//mc.yandex.ru/watch/27961860" style="position:absolute; left:-9999px;" alt="" />
        	</div></noscript>
        <!-- /Yandex.Metrika counter -->
</body>
</html>
	