<?php defined('_JEXEC') or die('Restricted access'); ?>
<script type="text/javascript">
window.addEvent('domready',function() { 
	document.moneyback = new moneyback();
});
</script>
<div id="moneybackWin" class="popup login-f"><a class="close-pop close"></a>
	<span class="title2">Возврат денег</span>
	<form>
    	<p><input type="text" name="code" id="mb_code" placeholder="Введите номер купона" size="6" maxlength="6" class="inpstyle"></p>
        <p>Возврат денег за купоны производится на то средство, с которого была произведена оплата. При оплате через терминал происходит возврат на баланс телефона. Деньги возвращаются автоматически в течение 3 &mdash; 5 рабочих дней.</p>
        <p><input type="submit" id="moneyback" class="btn btn-medium" value="Вернуть"></p>
    </form>
    <p id="mb_result"></p>	
</div>