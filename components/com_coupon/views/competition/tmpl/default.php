<?php defined('_JEXEC') or die('Restricted access');?>
<?php if(date('Y-m-d')<=$this->items->dateEnd){ ?>
<script type="text/javascript">
	window.addEvent('domready', function() {
		document.timer = new JTimer({dateEnd:'<?php echo $this->items->dateEnds; ?>', target:'dateEnd'});
	});
</script>
<?php } ?>
<div id="round">
	<div id="rt"><div id="rb">
	<div class="paymentTitle"><?php echo $this->items->title; ?></div>
    <?php if(date('Y-m-d')>$this->items->dateEnd){ ?>
    	<div id="dateEnds"><?php echo JText::_('COMPETITION END');?></div>
    <?php }else{ ?>
    	<div id="dateEnds"><?php echo JText::_('to complete the remaining');?> <span id="dateEnd"></span></div>
    <?php } ?>
    <div>
    	<?php echo $this->items->description; ?>
    </div>
    <div id="comLink">
    	<?php if($this->items->type==2){ ?>
    		<a href="<?php echo JRoute::_('index.php?option=com_coupon&view=competition&layout=photo&id='.$this->items->id);?>"><?php echo JText::_('to participate');?></a>
        <?php }else{ ?>
        	<a href="<?php echo JRoute::_('index.php?option=com_coupon&view=competition&layout=table&id='.$this->items->id);?>"><?php echo JText::_('COMPETITION TABLE');?></a>
        <?php } ?>
    </div>
</div></div></div>