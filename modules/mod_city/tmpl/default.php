<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="menu">
	<a id="city"><?php echo $title;?> <img src="images/triangle.png" align="absmiddle" alt=" " /></a>
</div>
<div id="cityModul">
	<div>
    	<?php for($i=0;$i<count($rows);$i++){?>
		<a href="<?php echo JRoute::_('index.php?option=com_coupon&task=setparam&city='.$rows[$i]->id);?>" class="scity"><?php echo $rows[$i]->title;?></a>
        <?php } ?>
 	</div>
</div>
<script type="text/javascript">
window.addEvent('domready',function() { 
 	var myAccordion = new Accordion($$("a#city"),$$("#cityModul"),{
 		alwaysHide: true,
 		opacity: true,
 		display: 1
 	});
});
</script>