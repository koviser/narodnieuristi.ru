<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php
	if (!$_COOKIE["coupon_intro"]) {
	$pparams = &$mainframe->getParams('com_coupon');
	setcookie('coupon_intro', 1, time() + 60*60*24*60, '/');
?>
<script type="text/javascript">
window.addEvent('domready',function() { 
 	popupIntro = new MoodalBox("introWin", "overlay", {allowManualClose:true});
	popupIntro.show();
});
</script>
<div id="introWin" class="popup login-f"><a class="close-pop close"></a>
	<span class="title2"><?php echo $pparams->get('title_intro');?></span>
	<?php echo $pparams->get('text_intro');?>		
</div>
<?php } ?>