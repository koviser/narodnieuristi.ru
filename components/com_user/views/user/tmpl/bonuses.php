<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="round">
	<div id="rt"><div id="rb">
	<div class="paymentTitle"><?php echo $this->escape($this->params->get('page_title')); ?></div>
    <div id="tabPanel">
    	<a href="index.php?option=com_user"><?php echo JText::_( 'My coupons' ); ?></a>
        <a href="index.php?option=com_user&layout=billing"><?php echo JText::_( 'Billing' ); ?></a>
        <a href="index.php?option=com_user&layout=edit"><?php echo JText::_( 'Personal info' ); ?></a>
        <span><?php echo JText::_( 'Bonuses' ); ?></a></span>
        <a href="index.php?option=com_user&layout=friends"><?php echo JText::_( 'Friends' ); ?></a>
<a href="index.php?option=com_user&layout=giftcard"><?php echo JText::_('Gift card');?></a>
        <?php if($this->user->advertiser==1){ ?>
        <a href="index.php?option=com_user&layout=myevents"><?php echo JText::_( 'My events' ); ?></a>
        <?php } ?>
        <?php if($this->user->partner){ ?>
         <a href="index.php?option=com_user&layout=partner"><?php echo JText::_( 'My partner' ); ?></a>
        <?php } ?>
    </div>
	<div id="personalText">
    	<div class="bonusPage">
			<?php echo JText::_('You have bonus');?>: <b><?php echo  $this->user->bonus;?></b> <?php echo JText::_('bon');?><br />
        	<a href="<?php echo JRoute::_('index.php?option=com_coupon&view=friend');?>"><?php echo JText::_('Invite friends');?></a>
        </div>
	</div>
</div></div></div>