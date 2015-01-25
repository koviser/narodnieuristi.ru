<?php defined('_JEXEC') or die('Restricted access'); ?>
<script type="text/javascript">
	window.addEvent('domready', function () {
		document.gift = new JGift(); 
	});
</script>
<div id="round">
	<div id="rt"><div id="rb">
	<div class="paymentTitle"><?php echo $this->escape($this->params->get('page_title')); ?></div>
    <div id="tabPanel">
    	<span><?php echo JText::_( 'My coupons' ); ?></span>
        <a href="index.php?option=com_user&layout=billing"><?php echo JText::_( 'Billing' ); ?></a>
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
    <?php 
		$count=count($this->items);
		if($count<1){
	?>
        <div id="noCoupon"><?php echo JText::_('No my coupon');?></div>
    <?php }else{ ?>
                <table cellpadding="0" cellspacing="0" width="100%" id="historyTable"> 
                <?php for($i=0;$i<count($this->items);$i++){ 
                    $row=$this->items[$i];
                ?>
                    <tr>
                        <td class="hDate">
                            <img src="images/events/<?php echo $row->image; ?>" style="padding:2px;border:1px #cdcdcd solid;" />
                        </td>
                        <td class="hTitle">
                            <?php if($row->type==1){ ?>
                                <a href="index.php?option=com_coupon&view=bonus&id=<?php echo $row->id; ?>"><?php echo $row->title; ?></a>
                            <?php }else{ ?>
                                <a href="index.php?option=com_coupon&view=event&id=<?php echo $row->id; ?>"><?php echo $row->title; ?></a>
                            <?php } ?>
                            <div><?php echo JEventsCommon::GetDatePaid($row->date); ?> | <?php echo JEventsCommon::GetDateEndHistory($row->dateUsed); ?></div>
                            <?php if($row->type==1){ ?>
                                <div class="bonusA"><?php echo JText::_('Bonus Actions');?></div>
                            <?php } ?>
                        </td>
                        <td class="hSale">
                            <?php echo JText::_('Discount');?><br/>
                            <span><?php echo $row->sale; ?> %</span>
                        </td>
                        <td class="hCoupon">
                            <?php echo JText::_('Coupon');?><br/>
                            <div id="couponN"><?php echo $row->password; ?></div>
                            <img src="templates/skidking/images/print.jpg" align="absmiddle" alt="<?php echo JText::_('Print');?>" />
                            <a href="index.php?option=com_coupon&view=event&tmpl=component&layout=coupon&id=<?php echo $row->coupon; ?>"><?php echo JText::_('Print Coupon');?></a>
                        </td>
                        <td class="hSale">
                            <input type="button" class="Submit giftButton" value="<?php echo JText::_('Gift'); ?>" rel="<?php echo $row->coupon; ?>" />
                        </td>
                    </tr>
                <?php } ?>
                </table>
    	<?php } ?>
	</div>
</div>
</div></div>
<div id="modalWin">
	<div class="modalTop">
    	<a class="close"></a>
    	<div class="modalheading"><?php echo JText::_('Gift coupon');?></div>
    </div>
    <div class="modalText">
    	<form action="<?php echo JURI::base();?>" name="giftForm" id="giftForm" method="post">
            <div align="center">
				<?php echo JText::_('GIFT COUPON YOU FRIEND');?><br/><br/>
                <input type="text" id="email" name="email" value="" class="txt-field" />
                <br/><br/>
                <input type="button" id="giftButton" class="Submit" value="<?php echo JText::_('Gift'); ?>" />
            </div>
            <input type="hidden" name="option" value="com_coupon" />
            <input type="hidden" name="task" value="gift" />
            <input type="hidden" name="id" id="idcoupon" value="" />
        </form>
    </div> 
</div>