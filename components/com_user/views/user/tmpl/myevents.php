<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="round">
	<div id="rt"><div id="rb">
	<div class="paymentTitle"><?php echo $this->escape($this->params->get('page_title')); ?></div>
    <div id="tabPanel">
    	<a href="index.php?option=com_user"><?php echo JText::_( 'My coupons' ); ?></a>
        <a href="index.php?option=com_user&layout=billing"><?php echo JText::_( 'Billing' ); ?></a>
        <a href="index.php?option=com_user&layout=edit"><?php echo JText::_( 'Personal info' ); ?></a>
        
<a href="index.php?option=com_user&layout=giftcard"><?php echo JText::_('Gift card');?></a>
        <?php if($this->user->advertiser==1){ ?>
        <span><?php echo JText::_( 'My events' ); ?></span>
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
        <div id="noCoupon"><?php echo JText::_('No my events');?></div>
    <?php }else{ ?>
        	<table cellpadding="8" cellspacing="0" width="100%" id="historyTable">
            	<tr>
                    <th width="30px" style="text-align:center;">#</th>
                    <th width="*"><?php echo JText::_('Event');?></th>
                </tr> 
			<?php for($i=0;$i<count($this->items);$i++){ 
                $row=$this->items[$i];
            ?>
                <tr>
                	<td align="center">
                    	<?php echo $j=$i+1;?>
                    </td>
                    <td>
                    	<a href="index.php?option=com_user&layout=event&id=<?php echo $row->id; ?>"><?php echo $row->title; ?></a>
                    </td>
            	</tr>
            <?php } ?>
            </table>
    	<?php } ?>
	</div>
</div></div></div>