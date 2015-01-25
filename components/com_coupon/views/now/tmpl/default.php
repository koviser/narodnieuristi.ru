<?php 
	defined('_JEXEC') or die('Restricted access');
	$options = JRequest::getVar( 'options', '', 'get', 'array');
?>

	<div class="<?php if(!$this->search){?>action-day <?php } ?>clearfix">
    	<?php if(JRequest::getVar( 'catid', '0', 'get', 'int')){?>
        	<form method="get" id="sorting">
            	<input type="hidden" name="catid" value="<?php echo JRequest::getVar( 'catid', '0', 'get', 'int');?>" />
                <h2><?php echo $this->title;?></h2>
                <div class="prod-opt clearfix">
                    <ul class="sorting">
                        <?php echo JEventsCommon::metroList($options['metro']);?>
                        <?php echo JEventsCommon::optionsList($options, JRequest::getVar( 'catid', '0', 'get', 'int'));?>
                    </ul>
                    <div class="search">
                        <input type="text" name="options[word]" placeholder="Введите слова для поиска" value="<?php echo $options['word'];?>"><input type="submit" value="">
                    </div>
                </div>
            </form>
            <?php if($this->day->id){?>
            <div class="slider-wrapp slider-inside dashed">
            	<img src="images/slider/big_<?php echo $this->day->images[0]->image; ?>" width="500" height="317" align="middle"/>
            </div><!--.slider-wrapp-->
            <div class="action-detalies">
                <p><a href="<?php echo JRoute::_('index.php?option=com_coupon&amp;view=event&amp;id='.$this->day->id.'&amp;Itemid='.ITEMID);?>" class="title-link"><?php echo $this->day->title; ?></a></p>
                <p><?php echo $this->day->intro; ?></p>
                <?php if($this->day->metro){ ?><p class="adr-metro"><span class="icons-small ico-metro"></span><span class="adrs-name"><?php echo $this->day->metro; ?> <?php echo JEventsCommon::GetMetro($this->day->metro_count);?></span></p><?php } ?>
            </div>
            <?php } ?>
       <?php }else{ ?>
        	<h2>Дело месяца!</h2>
      
       	<?php if($this->day->id){?>
        	<div class="slider-wrapp">
            	<div id="slider" class="flexslider">
  					<ul class="slides">
                    	<?php for($i=0;$i<count($this->day->images);$i++){ ?>
                        	<li><img src="images/slider/big_<?php echo $this->day->images[$i]->image; ?>" width="500" height="317" align="middle"/></li>
                   		<? } ?>
  					</ul>
				</div>
				<div id="carousel" class="flexslider">
  					<ul class="slides">
                    	<?php for($i=0;$i<count($this->day->images);$i++){ ?>
                        	<li><img src="images/slider/big_<?php echo $this->day->images[$i]->image; ?>" /></li>
                   		<? } ?>
  					</ul>
				</div>
            </div><!--.slider-wrapp-->
            <div class="action-detalies">
            	<span class="discount">738 000 руб.<!-- Скидка <b><?php echo $this->day->sale; ?>%</b> --><span></span></span>
                <p><a href="<?php echo JRoute::_('index.php?option=com_coupon&amp;view=event&amp;id='.$this->day->id.'&amp;Itemid='.ITEMID);?>" class="title-link"><?php echo $this->day->title; ?></a></p>
                <?php echo $this->day->intro; ?>
                <?php if($this->day->metro){ ?><p class="adr-metro"><span class="icons-small ico-metro"></span><span class="adrs-name"><?php echo $this->day->metro; ?> <?php echo JEventsCommon::GetMetro($this->day->metro_count);?></span></p><?php } ?>
            </div>
        	<?php } ?>
        <?php } ?>
        </div><!--.action-day-->
<?php if($this->items[0]){?>   
 		<?php if($this->search){?>
        	<h2 class="none-pad">Результаты поиска</h2>
        <?php }else{ ?>
        	<?php if(!JRequest::getVar( 'catid', '0', 'get', 'int')){?> 
        		<h2 class="none-pad">Новые заведения</h2>
       		<?php }else{ ?>
            	<div style="height:25px;"></div>
            <?php } ?>
     	<?php } ?>
        <ul class="list-actions">
	<?php for($i=0;$i<count($this->items);$i++){ 
    	$row=$this->items[$i];
    ?>
    	<li>
            <span class="photo-border"><a href="index.php?option=com_coupon&view=event&id=<?php echo $row->id; ?>"><img src="images/events/med_<?php echo $row->image; ?>" /></a></span>
            <a href="index.php?option=com_coupon&view=event&id=<?php echo $row->id; ?>" class="title-link"><?php echo $row->title; ?></a>
        	<?php if($row->metro){ ?><p class="adr-metro"><span class="icons-small ico-metro"></span><span class="adrs-name"><?php echo $row->metro; ?> <?php echo JEventsCommon::GetMetro($row->metro_count);?></span></p><?php } ?>
        </li>
	<?php } ?>
    	</ul>
<?php echo $this->pagination->getPagesLinks(); ?>
<?php }else{ ?>
	<div id="noevents"><?php echo JText::_('No Event');?></div>
<?php } ?>