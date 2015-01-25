<?php 
	defined('_JEXEC') or die('Restricted access');
	JHTML::_('behavior.modal', 'a.modal-button');
	if(date('Y-m-d')<=$this->item->dateEnd){
		$published=1;	
	}
?>
<?php if($published){ ?>
<script type="text/javascript">
	window.addEvent('domready', function() {
		document.timer = new JTimer({dateEnd:'<?php echo $this->item->dateEnds; ?>', target:'dateEnd'});
	});
</script>
<?php if($this->user->id>0){ ?> 
<script>
window.addEvent('domready', function(){
	working = false; 
	$$('a.rater').each(function(el) { 
		el.addEvent('click', function() {
			var id = $(this).getParent('div').get('rel');
			var raiting = $(this).get('rel');
			if(!working){
				working = true;
				var req = new Request.JSON({ 
					method: 'post',
					url: 'index.php', 
					data: {'option':'com_coupon', 'task':'raiting', 'raiting':raiting, 'id':id}, 
					onComplete: function(response) {
						$('id_'+id).setHTML(response.message);
						working = false; 
					}
				}).send();
			}
			return false;
		}); 
	});
});
</script>
<?php } ?>
<?php } ?>
<div id="round">
	<div id="rt"><div id="rb">
	<div class="paymentTitle"><?php echo $this->item->title; ?></div>
    <?php if(!$published){ ?>
    	<div id="dateEnds"><?php echo JText::_('COMPETITION END');?></div>
    <?php }else{ ?>
    	<div id="dateEnds"><?php echo JText::_('to complete the remaining');?> <span id="dateEnd"></span></div>
    <?php } ?>
    <div>
    <?php if($this->user->id && date('Y-m-d')<=$this->item->dateEnd){ ?>
    	<div class="pItem">
            <form action="<?php echo JURI::base();?>" method="post" enctype="multipart/form-data" name="photoForm" id="photoForm">
            	<div class="pTitle">
                	<?php echo JText::_('LOAD IMAGE')?>
                </div>
                <div class="pBody" id="photoupload">
                	<input type="file" name="image" class="photoupload" />
                </div>
                <div>
                    <input type="submit" value="<?php echo JText::_('Send'); ?>" class="Submit"/>
                </div>
                <input type="hidden" name="option" value="com_coupon" />
                <input type="hidden" name="task" value="addPhoto" />
                <input type="hidden" name="comid" value="<?php echo $this->item->id;?>" />
            </form>
        </div>
    <?php } ?>
			<?php $k=1;for($i=0;$i<count($this->items);$i++){ ?>
            <div class="pItem">
            	<div class="pTitle">
                	<?php echo $k+$i.' '.JText::_('RAITING PLACE')?>
                </div>
                <div class="pBody">
                	<a href="images/photo/original/<?php echo $this->items[$i]->image; ?>" class="modal-button"><img src="images/photo/thumb/<?php echo $this->items[$i]->image; ?>" /></a>
                </div>
                <div>
                	<?php 
							if($this->items[$i]->name!="" && $this->items[$i]->name!=$this->items[$i]->email){
								echo $this->items[$i]->name.' '.$this->items[$i]->family;
							}else{
								$name=explode('@', $this->items[$i]->email);
								echo substr($name[0], 0, 3).'***@'.$name[1];
							}
						?>
                	<?php if($published){ ?>
                    	<div class="rat" id="id_<?php echo $this->items[$i]->id; ?>" rel="<?php echo $this->items[$i]->id; ?>">
                            <ul class="ur">
                                <li><a href="#" rel="1" title="<?php echo JText::_('Very bad'); ?>" class="r1-unit rater"><?php echo JText::_('Very bad'); ?></a></li>
                                <li><a href="#" rel="2" title="<?php echo JText::_('Poor'); ?>" class="r2-unit rater"><?php echo JText::_('Poor'); ?></a></li>
                                <li><a href="#" rel="3" title="<?php echo JText::_('Medium'); ?>" class="r3-unit rater"><?php echo JText::_('Medium'); ?></a></li>
                                <li><a href="#" rel="4" title="<?php echo JText::_('Well'); ?>" class="r4-unit rater"><?php echo JText::_('Well'); ?></a></li>
                                <li><a href="#" rel="5" title="<?php echo JText::_('Excellent'); ?>" class="r5-unit rater"><?php echo JText::_('Excellent'); ?></a></li>
                            </ul>
                        </div>
                    <?php } ?>
                    <strong><?php echo JText::_('RAITING')?> <?php echo $this->items[$i]->raiting; ?></strong>
                </div>
            </div>
            <?php } ?>
    </div>
    <div id="comLink">
    	<a href="<?php echo JRoute::_('index.php?option=com_coupon&view=competition&id='.$this->item->id);?>"><?php echo JText::_('COMPETITION INFO');?></a>
    </div>
</div></div></div>