<?php defined('_JEXEC') or die('Restricted access');?>

<div class="componentheading"><?php echo $this->params->get( 'page_title' ); ?></div>

<div id="bonusList">
		<?php for($i=0;$i<count($this->items);$i++){ 
            $row=$this->items[$i];
        ?>
        	<div class="bonus row<?php echo $i%3 ?>">
            	<img src="images/events/<?php echo $row->image; ?>" class="imgEvent" />
                <div class="bonusTop">
                	<div class="bonusPrice">
                    	<?php echo $row->price; ?> 
						<span><?php echo JText::_('bon');?></span>
                    </div>
                    <div>
                    <div class="bonusLabel">
                    	<?php echo $row->sale; ?>%
                    </div>
                    </div>
                    <div class="bonusTitle">
                    	<a href="index.php?option=com_coupon&view=bonus&id=<?php echo $row->id; ?>"><?php echo $row->title; ?></a>
                    </div>
                </div>
            </div>
        <?php } ?>
</div>