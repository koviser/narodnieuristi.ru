<?php defined('_JEXEC') or die('Restricted access');?>
<?php if(date('Y-m-d')<=$this->item->dateEnd){ ?>
<script type="text/javascript">
	window.addEvent('domready', function() {
		document.timer = new JTimer({dateEnd:'<?php echo $this->item->dateEnds; ?>', target:'dateEnd'});
	});
</script>
<?php } ?>
<div id="round">
	<div id="rt"><div id="rb">
	<div class="paymentTitle"><?php echo $this->item->title; ?></div>
    <?php if(date('Y-m-d')>$this->item->dateEnd){ ?>
    	<div id="dateEnds"><?php echo JText::_('COMPETITION END');?></div>
    <?php }else{ ?>
    	<div id="dateEnds"><?php echo JText::_('to complete the remaining');?> <span id="dateEnd"></span></div>
    <?php } ?>
    <div>
    	<?php if(count($this->items)>0){ ?>
        	<table border="0" cellpadding="5" cellspacing="0" class="table-with-head mnone" width="100%" id="historyTable">
            	<tr class="head">
                	<td width="30px" align="center">
                    	#
                    </td>
                    <td>
                    	<?php echo JText::_('COMPETITION USER'); ?>
                    </td>
                    <td width="150px" align="center">
                    	<?php if($this->item->type==1){ ?>
                            <?php echo JText::_('TOTAL SUM'); ?>
                        <?php }else{ ?>
                            <?php echo JText::_('TOTAL FRIEND'); ?>
                        <?php } ?>
                    </td>
                </tr>
			<?php $k=1;for($i=0;$i<count($this->items);$i++){ ?>
                <tr class="row<?php echo $k%2; ?>">
                	<td align="center">
                    	<?php echo $k++; ?>
                    </td>
                    <td style="text-align:left;">
                    	<?php 
							if($this->items[$i]->name!="" && $this->items[$i]->name!=$this->items[$i]->email){
								echo $this->items[$i]->name.' '.$this->items[$i]->family;
							}else{
								$name=explode('@', $this->items[$i]->email);
								echo substr($name[0], 0, 3).'***@'.$name[1];
							}
						?>
                    </td>
                    <td align="center">
                    	<strong><?php echo $this->items[$i]->total; ?></strong>
                    </td>
                </tr>
            <?php } ?>
            </table>
        <?php }else{ ?>
        	<div class="war"><?php echo JText::_('COMPETITION NO USER'); ?></div>
        <?php } ?>
    </div>
    <div id="comLink">
    	<a href="<?php echo JRoute::_('index.php?option=com_coupon&view=competition&id='.$this->item->id);?>"><?php echo JText::_('COMPETITION INFO');?></a>
    </div>
</div></div></div>