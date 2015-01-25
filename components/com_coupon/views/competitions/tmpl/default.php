<?php defined('_JEXEC') or die('Restricted access');?>
<script type="text/javascript">
	window.addEvent('domready', function() {
		<?php for($i=0;$i<count($this->items);$i++){ ?>
		document.timer<?php echo $i;?> = new JTimer({dateEnd:'<?php echo $this->items[$i]->dateEnd; ?>', target:'endDate<?php echo $this->items[$i]->id; ?>'});
		<?php } ?>
	});
</script>
<?php echo JEventsCommon::getModule('category'); ?>	
<?php if(count($this->items)>0){?> 
<div id="eventsList">
	<div class="row_1">
	<?php for($i=0;$i<count($this->items);$i++){ 
    	$row=$this->items[$i];
    ?>
    <div class="nowItem">
        <div class="nowImg">
        	<a href="index.php?option=com_coupon&view=competition&id=<?php echo $row->id; ?>"><img src="images/competitions/<?php echo $row->image; ?>" alt="" width="310" height="170" /></a>
            <div class="line">
            	<div class="cloud">
					<span><?php echo JText::_('COMPETITION'); ?></span>
                </div>
                <div class="itemInfo">
                	<div id="endDate<?php echo $row->id; ?>" class="endDate"></div>
                </div>
            </div>
        </div>
        <div class="nowDesc">
        	<div class="nowBord">
                <div class="nowBuy" style="float:right;margin:0 5px 0 0;">
                    <a href="index.php?option=com_coupon&view=competition&id=<?php echo $row->id; ?>" class="buySmall"><?php echo JText::_('MORE'); ?></a>
                </div>
            </div>
        </div>
        <div class="nowTitle">
        	<a href="index.php?option=com_coupon&view=competition&id=<?php echo $row->id; ?>"><?php echo $row->title; ?></a>
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
	<div id="noevents"><?php echo JText::_('No competition');?></div>
<?php } ?>