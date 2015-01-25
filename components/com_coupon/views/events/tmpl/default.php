<?php defined('_JEXEC') or die('Restricted access');?>
<div class="f">
<div class="componentheading"><?php echo $this->params->get( 'page_title' ); ?></div>
<div id="leftCalendar">
	<?php 
		$month="&month=".$this->params->get( 'month' );
		$monthTitle=JEventsCommon::GetMonth($this->params->get('month'));
		$start=date("n", mktime(0, 0, 0, date("m")-11  , 1, date("Y")));
		for($i=$start;$i<($start+12);$i++){
			$j=$i%12;
			if($j==0)$j=12;
			if($j==$this->params->get( 'month' )){
				$class=' class="activeM"';
			}else{
				$class="";
			}
			$count = $this->month[$j]->count ? $this->month[$j]->count : 0;
	?>
        <?php if($count>0){ ?>
        	<a href="index.php?option=com_coupon&view=events&month=<?php echo $j;?>"<?php echo $class;?>><?php echo JText::_('Month_'.$j);?> (<?php echo $count; ?>)</a>
        <?php }else{ ?>
        	<span><?php echo JText::_('Month_'.$j);?></span>
        <?php } ?>
        <?php if($i!=($start+11)){ ?>
        	<div class="spacerM"></div>
        <?php } ?>
    <?php } ?>
</div>
<div id="rightBlock">
	<div class="h2"><?php echo JEventsCommon::EventsTitle($this->params->get( 'month' ));?></div>
    <div id="eventsList">
		<?php for($i=0;$i<count($this->items);$i++){ 
            $row=$this->items[$i];
        ?>
        	<div class="event row<?php echo $i%2 ?>">
            	<img src="images/events/<?php echo $row->image; ?>" class="imgEvent" />
                <div class="eventTop">
                	<div class="eventLeft">
                    	<div class="eventLabel">
                        	<?php echo JText::_('Coupon buy');?>
                        	<span><?php echo $row->count; ?></span>
                        </div>
                        <div class="eventDesc">
                            <div class="eventSav">
                                <?php echo JText::_('Savings');?><br/>
                                <span>
                                <?php if($row->realPrice!=0){ ?>
                               		<?php echo round(($row->realPrice*$row->sale)/100); ?> <?php echo JText::_('Rub'); ?>
                                <?php }else{ ?>
                                	<?php echo JText::_('Unlimited'); ?>
								<?php } ?>
                                </span>
                            </div>
                            <div class="eventDis">
                                <?php echo JText::_('Discount');?><br/>
                                <span><?php echo $row->sale; ?> %</span>
                            </div>
						</div>
                        <div class="eventDate">
                        	<?php echo $row->start; ?> <?php echo $monthTitle; ?>
                        </div>
                    </div>            
                    <div class="eventRight">
                    	<a href="index.php?option=com_coupon&view=event&id=<?php echo $row->id; ?>"><?php echo $row->title; ?></a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
</div>