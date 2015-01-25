<?php defined('_JEXEC') or die('Restricted access');?>
<script type="text/javascript">
	var loading=0;
	window.addEvent('domready', function () {
		document.upDown = new upDown({price:'<?php echo $this->items->price; ?>'}); 
		document.payment = new payment({id_event:'<?php echo $this->items->id; ?>', host:'<?php echo JURI::base().'robokassa.php'; ?>',price:'<?php echo $this->items->price; ?>'}); 
	});
</script>


<ul class="breadcrumbs">
        	<li class="active">←<a href="index.php?option=com_coupon&view=event&id=<?php echo $this->items->id; ?>">Вернуться назад</a></li>
        </ul>
        <div class="clearfix">
			<div class="orders">
				<h2>Выбранные купоны:</h2>	
				<table>
					<tr>
						<td>
							<img width="140px" src="images/events/med_<?php echo $this->items->image; ?>" />
						</td>
						<td><a href="index.php?option=com_coupon&view=event&id=<?php echo $this->items->id; ?>" class="order-title"><?php echo $this->items->title; ?></a></td>
						<td>
							<div class="selecter">
								<a href="" id="down" class="left-select"></a>
								<a href="" id="up" class="right-select"></a>
								<input type="text" name="num" id="num" value="1" readonly="true" />
							</div>
						</td>
						<td>
							<div class="sum"><?php echo $this->items->price; ?> <span class="ruble">r</span></div>
						</td>
					</tr>
				</table>
				<div class="order-result">Итого: <span id="total"><?php echo $this->items->price; ?></span> <span class="ruble">r</span></div>
			</div>
            <div class="buy-data">
				<h2>Ваши данные:</h2>
				<div>
					<p>Номер телефона&nbsp;</p>
					<span>(в формате +7XXXXXXXXXX)</span>
				</div>
                <a href="#" id="payButton"><span>Банковская карта</span></a>
			</div>
			<div class="buy-method">
				<table>
					<tr>
						<td><a href="#" class="buy-method-link payment-link method-card" rel="BANKOCEAN2R"><span>Банковская карта</span></a></td>
						<td><a href="#" class="buy-method-link payment-link method-money" rel="WMRM"><span>Электронные деньги</span></a></td>
						<td><a href="#" class="buy-method-link payment-link method-terminal" rel="ElecsnetR"><span>Терминалы оплаты</span></a></td>
						<td><a href="#" class="buy-method-link payment-link method-phone" rel="MtsR"><span>Мобильный телефон</span></a></td>
					</tr>
				</table>
			</div>
        </div>
        <form action="<?php echo $this->webmoney->url ;?>" method="post" id="robokassa">
            <input type="hidden" name="InvId" id="InvId" value="" />
            <input type="hidden" name="MrchLogin" value="<?php echo $this->webmoney->login ;?>">
            <input type="hidden" name="OutSum" id="OutSum" value="<?php echo $this->items->price; ?>" />
            <input type="hidden" name="Desc" value="<?php echo $this->escape(strip_tags($this->items->title)); ?>">
            <input type="hidden" name="SignatureValue" id="SignatureValue" value="">
            <input type="hidden" name="Shp_item" value="<?php echo $this->items->id ;?>">
            <input type="hidden" name="IncCurrLabel" id="IncCurrLabel"  value="" />
            <input type="hidden" name="Culture" value="ru">
            <input type="hidden" name="shpnum" id="shpnum" value="">
            <input type="hidden" name="Email" id="e-mail" value="">
        </form>
    <div id="modalWin" class="popup login-f"><a href="#" class="close-pop close"></a>
    	<span class="title2">Введите номер телефона</span>
            <p>+7 - <input type="text" name="code" id="code" class="inpstyle s3" size="3" max="3" maxlength="3"> - <input type="text" name="phone" class="inpstyle s7" id="phone" size="7" max="7" maxlength="7"></p>
            <p id="start_pay"><input type="submit" class="btn payment-link btn-medium" value="Оплатить"></p>
            <p style="display:none;" id="forwarding">
            	<?php echo JText::_('forwarding to seller');?>
            	<div id="loading"></div>
            </p>
    </div>