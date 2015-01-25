<?php defined('_JEXEC') or die('Restricted access');?>

<script type="text/javascript">
var loading=0;
window.addEvent('domready', function () {
	var popupFx = null;
	popupFxF = new MoodalBox("forwarding", "overlay"); 
	$$('.payment-link').each(function(el) { 
		el.addEvent('click', function(event) {
			event.stop();
			if(!loading){
				popupFxF.show();
				loading=1;
				$('IncCurrLabel').set('value', el.get('rel'));
				$('robokassa').submit();
			}
		});
	}); 
});   
</script>
<div id="round">
	<div id="rt"><div id="rb">
	<div class="paymentTitle"><?php echo $this->escape($this->params->get('page_title')); ?></div>
    <div id="tabPanel">
    	<a href="index.php?option=com_user"><?php echo JText::_( 'My coupons' ); ?></a>
        <span><?php echo JText::_( 'Billing' ); ?></span>
        <a href="index.php?option=com_user&layout=edit"><?php echo JText::_( 'Personal info' ); ?></a>
        
<a href="index.php?option=com_user&layout=giftcard"><?php echo JText::_('Gift card');?></a>
        <?php if($this->user->advertiser==1){ ?>
        <a href="index.php?option=com_user&layout=myevents"><?php echo JText::_( 'My events' ); ?></a>
        <?php } ?>
        <?php if($this->user->partner){ ?>
         <a href="index.php?option=com_user&layout=partner"><?php echo JText::_( 'My partner' ); ?></a>
        <?php } ?>
    </div>
	<div id="personalText">
        <div class="paymentTitle"><?php echo JText::_('Payment method'); ?></div>
        <div id="metod">
            <a href="#" class="payment-link" id="i1" rel="BANKOCEAN2R"><?php echo JText::_('Банковская<br/>карта'); ?></a>
            <div class="sep"></div>
            <a href="#" class="payment-link" id="i2" rel="ElecsnetR"><?php echo JText::_('Терминалы<br/>оплаты'); ?></a>
            <div class="sep"></div>
            <a href="#" class="payment-link" id="i3" rel="YandexMerchantOceanR"><?php echo JText::_('Yandex-money'); ?></a>
            <div class="sep"></div>
            <a href="#" class="payment-link" id="i4" rel="WMRM"><?php echo JText::_('Web-money'); ?></a>
            <div class="sep"></div>
            <a href="#" class="payment-link" id="i5" rel="QiwiR"><?php echo JText::_('Through QIWI Purse'); ?></a>
        </div>
        <?php echo JText::_('PAY WITH SMS'); ?>
        <a href="#" class="payment-link" id="i6" rel="MegafonR"><?php echo JText::_('Megafon'); ?></a>
        <a href="#" class="payment-link" id="i7" rel="MtsR"><?php echo JText::_('MTS'); ?></a>
	</div>
</div></div></div>

<form action="<?php echo $this->webmoney->url ;?>" method="post" id="robokassa">
	<input type="hidden" name="MrchLogin" value="<?php echo $this->webmoney->login ;?>">
    <input type=hidden name="OutSum" value="">
    <input type=hidden name="InvId" value="0">
    <input type=hidden name="Desc" value="<?php echo JText::_('UPDATE BALANCE');?>">
    <input type=hidden name="SignatureValue" value="<?php echo md5($this->webmoney->login."::0:".$this->webmoney->password.":Shp_item=".$this->user->id.':shpnum=0');?>">
    <input type=hidden name="Shp_item" value="<?php echo $this->user->id;?>">
    <input type=hidden name="IncCurrLabel" id="IncCurrLabel" value="">
    <input type=hidden name="" value="ru">
    <input type="hidden" name="shpnum" id="shpnum" value="0">
</form>
<div id="forwarding">
	<div class="modalTop">
    	<a class="close"></a>
    	<div class="modalheading"><?php echo JText::_('forwarding');?></div>
    </div>
    <div class="modalText">
    	<?php echo JText::_('forwarding to seller');?>
        <div id="loading"></div>
    </div> 
</div>