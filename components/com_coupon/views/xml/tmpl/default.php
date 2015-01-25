<?php defined('_JEXEC') or die('Restricted access');?>
<script type="text/javascript">
	window.addEvent('domready', function() {
		document.bonus = new JBonus();
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
        	<a href="index.php?option=com_coupon&view=event&id=<?php echo $row->id; ?>"><img src="images/events/<?php echo $row->image; ?>" /></a>
            <div class="line">
            	<div class="cloud">
					- <?php echo $row->sale;?>%
                </div>
                <div class="itemInfo">
                	<div class="endDate"><?php echo JEventsCommon::GetDateEndHistory($row->dateEnd, 1); ?></div>
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
                    <a class="nobuySmall"><?php echo JText::_('BUY'); ?></a>
                </div>
            </div>
        </div>
        <div class="nowTitle">
        	<a href="index.php?option=com_coupon&view=event&id=<?php echo $row->id; ?>"><?php echo $row->title; ?></a>
        </div>
	</div>
    <?php if($i%3==2 && $i<(count($this->items)-1)){?>
    	<div class="spacer"></div>
        </div><div class="row_<?php echo $i%6;?>">
    <?php } ?>
	<?php } ?>
    </div>
</div>
<?php echo $this->pagination->getPagesLinks(); ?>
<?php }else{ ?>
	<div id="noevents"><?php echo JText::_('No Event');?></div>
<?php } ?>