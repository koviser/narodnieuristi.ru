<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="round">
	<div id="rt"><div id="rb">
	<div class="paymentTitle"><?php echo $this->escape($this->params->get('page_title')); ?></div>
    <div id="tabPanel">
    	<a href="index.php?option=com_user"><?php echo JText::_( 'My coupons' ); ?></a>
        <a href="index.php?option=com_user&layout=billing"><?php echo JText::_( 'Billing' ); ?></a>
        <a href="index.php?option=com_user&layout=edit"><?php echo JText::_( 'Personal info' ); ?></a>
        <a href="index.php?option=com_user&layout=bonuses"><?php echo JText::_( 'Bonuses' ); ?></a>
        <span><?php echo JText::_( 'Friends' ); ?></span>
        <?php if($this->user->advertiser==1){ ?>
        <a href="index.php?option=com_user&layout=myevents"><?php echo JText::_( 'My events' ); ?></a>
        <?php } ?>
        <?php if($this->user->partner){ ?>
         <a href="index.php?option=com_user&layout=partner"><?php echo JText::_( 'My partner' ); ?></a>
        <?php } ?>
    </div>
	<div id="personalText">
		<div id="friendLine">
        	<a href="<?php echo JRoute::_('index.php?option=com_coupon&view=friend');?>" class="buySmall"><?php echo JText::_('Invite friend');?></a>
        </div>
    <?php 
		$count=count($this->items);
		if($count<1){
	?>
        <div id="noCoupon"><?php echo JText::_('No friends');?></div>
    <?php }else{ ?>
        	<table cellpadding="10" cellspacing="0" width="100%" id="historyTable">
			<?php for($i=0;$i<count($this->items);$i++){ 
                $row=$this->items[$i];
            ?>
                <tr>
                	<td align="center" width="50px">
                    	<?php echo $j=$i+1;?>
                    </td>
                    <td>
                    	<?php echo $row->name; ?> <?php echo $row->family; ?> (<?php echo $row->email; ?>)
                    </td>
            	</tr>
            <?php } ?>
            </table>
    	<?php } ?>
	</div>
</div></div></div>