<?php 
	defined('_JEXEC') or die('Restricted access');
	$item=$this->item;
?>
<?php if($this->user->vip){?> 
<?php defined('_JEXEC') or die('Restricted access');?>
<script type="text/javascript">
	window.addEvent('domready', function() {
		<?php for($i=0;$i<count($this->items);$i++){ ?>
		document.timer<?php echo $i;?> = new JTimer({dateEnd:'<?php echo $this->items[$i]->dateEnds; ?>', target:'endDate<?php echo $this->items[$i]->id; ?>'});
		<?php } ?>
	});
</script>
<?php if(count($this->items)>0){?> 
<div id="eventsList">
	<div class="row_1">
	<?php for($i=0;$i<count($this->items);$i++){ 
    	$row=$this->items[$i];
    ?>
    <div class="nowItem">
        <div class="nowImg">
        	<a href="index.php?option=com_coupon&view=event&id=<?php echo $row->id; ?>"><img src="images/events/med_<?php echo $row->image; ?>" /></a>
            <div class="line">
            	<div class="cloud">
					- <?php echo $row->sale;?>%
                </div>
                <div class="itemInfo">
                	<div id="endDate<?php echo $row->id; ?>" class="endDate"></div>
                </div>
            </div>
        </div>
        <div class="nowDesc">
        	<div class="nowBord">
                <div class="nowPrice">
                    <div><?php echo JText::_('Price'); ?></div>
                    <b><?php echo $row->price; ?></b> <?php echo JText::_('Rub'); ?>
                </div>
                <div class="nowDisc">
                    <div><?php echo JText::_('SAVINGS'); ?></div>
                    <?php if($row->realPrice>0){?>
                        <b><?php echo round($row->realPrice*($row->sale/100));?></b> <?php echo JText::_('Rub'); ?>
                    <?php }else{?>
                        <b><?php echo $row->sale; ?></b> %
                    <?php } ?>
                </div>
                <div class="nowBuy">
                    <a href="index.php?option=com_coupon&view=event&id=<?php echo $row->id; ?>&layout=payment" class="buySmall"><?php echo JText::_('BUY'); ?></a>
                </div>
            </div>
        </div>
        <div class="nowTitle">
        	<a href="index.php?option=com_coupon&view=event&id=<?php echo $row->id; ?>"><?php echo $row->title; ?></a>
        </div>
	</div>
    <?php if($i%3==2 && $i<(count($this->items)-1)){?>
        </div><div class="row_<?php echo $i%6;?>">
    <?php } ?>
	<?php } ?>
    </div>
</div>
<?php echo $this->pagination->getPagesLinks(); ?>
<?php }else{ ?>
	<div id="noevents"><?php echo JText::_('No Event');?></div>
<?php } ?>
<?php }else{ ?>
    <div id="noevents"><?php echo JText::_('YOU NOT VIP');?></div>
<?php } ?>