<?php defined('_JEXEC') or die('Restricted access'); ?>
<script type="text/javascript">
window.addEvent('domready',function() { 
	document.order = new order();
});

</script>
<form id="moneybackWinform">
	<div class="select">
		<?php echo $list['type'];?>
	</div>

    <div class="select">
		<?php echo $list['roo'];?>
	</div>					
	<p><input type="text" name="client_name" id="client_name" placeholder="Введите имя" class="inpstyle required"></p>
	<p><input type="text" name="client_phone" id="client_phone" placeholder="Введите телефон" class="inpstyle required"></p>
	<div class="submit">
		<input type="submit"  id="moneyback" value="Отправить заявку" />
	</div>
</form>
<p id="mb_result"></p>