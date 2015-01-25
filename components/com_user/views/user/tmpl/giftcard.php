<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="round">
	<div id="rt"><div id="rb">
	<div class="paymentTitle"><?php echo $this->escape($this->params->get('page_title')); ?></div>
    <div id="tabPanel">
    	<a href="index.php?option=com_user"><?php echo JText::_( 'My coupons' ); ?></a>
        <a href="index.php?option=com_user&layout=billing"><?php echo JText::_( 'Billing' ); ?></a>
        <a href="index.php?option=com_user&layout=edit"><?php echo JText::_( 'Personal info' ); ?></a>
		<span><?php echo JText::_('Gift card');?></span>
        <?php if($this->user->advertiser==1){ ?>
        <a href="index.php?option=com_user&layout=myevents"><?php echo JText::_( 'My events' ); ?></a>
        <?php } ?><?php if($this->user->partner){ ?>
         <a href="index.php?option=com_user&layout=partner"><?php echo JText::_( 'My partner' ); ?></a>
        <?php } ?>
    </div>
	<div id="personalText">
				<div class="enter-sum">
                <form action="<?php echo JURI::base(); ?>" method="post">
					<div><strong><?php echo JText::_('ACTIVE GIFT CARD'); ?></strong></div><br/>
                    <label><?php echo JText::_('Enter gift card number'); ?>:</label>
					<input type="text" class="inputbox" name="code" />
                    <input type="button" class="Submit" value="<?php echo JText::_( 'Apply' ); ?>" onclick="this.form.submit();" />
                    <input type="hidden" name="option" value="com_coupon" />
                    <input type="hidden" name="task" value="giftcard" />
				</form>
                </div>
                <br/><br/><br/>
                <div class="enter-sum">
                <form action="<?php echo JURI::base(); ?>" method="post">
					<div><strong><?php echo JText::_('ACTIVE BONUS GIFT CARD'); ?></strong></div><br/>
                    <label><?php echo JText::_('Enter gift card number'); ?>:</label>
					<input type="text" class="inputbox" name="code" />
                    <input type="button" class="Submit" value="<?php echo JText::_( 'Apply' ); ?>" onclick="this.form.submit();" />
                    <input type="hidden" name="option" value="com_coupon" />
                    <input type="hidden" name="task" value="bgiftcard" />
				</form>
				</div>	
</div></div></div></div>