<?php defined('_JEXEC') or die('Restricted access');
	$document = &JFactory::getDocument();
	$config = new JConfig();
	$document->addScript('http://api-maps.yandex.ru/1.1/index.xml?key='.$config->yandex_key);
?>

<script type="text/javascript">
	window.addEvent('domready', function() {
		document.tabs = new JFormTabs();
		document.timer = new JTimer({dateEnd:'<?php echo $this->items->dateEnds; ?>'});
		document.comments = new JComments({eventID:'<?php echo $this->items->id; ?>'});
	});
</script>
<div id="left">
	<div class="componentheading"> </div>
    <div id="tabs">
    	<a href="#" class="active" id="tabsMain"><?php echo JText::_('Main'); ?></a>
        <a href="#" id="tabsMap"><?php echo JText::_('Map'); ?></a>
    </div>
    <div id="sliderTab">
        <div id="slideshow-container">
        	<?php for($i=0;$i<count($this->images);$i++){ ?>
        		<img src="images/events/big_<?php echo $this->images[$i]->image; ?>" width="750px" height="396px" align="middle"/>
            <? } ?>
        </div>   
    </div>
    <div id="titleTab">
    	<?php echo $this->items->title; ?>
    </div>
    <div id="mapTab">
		<script type="text/javascript">// <![CDATA[
            window.onload = function () {
                var map = new YMaps.Map(document.getElementById("YMapsID"));
				map.setCenter(new YMaps.GeoPoint(<?php echo $this->params->get( 'y' ); ?>,<?php echo $this->params->get( 'x' ); ?>), <?php echo $this->params->get( 'scale' ); ?>);
                var toolBar = new YMaps.ToolBar();
                var s = new YMaps.Style();
                var zoomControl = new YMaps.Zoom();
				
				<?php
					$maps=count($this->maps);
					for($i=0;$i<$maps;$i++){
				?>
				var point<?php echo $i;?> = new YMaps.Placemark(new YMaps.GeoPoint(<?php echo $this->maps[$i]->longitude; ?>,<?php echo $this->maps[$i]->latitude; ?>), {style: "default#lightblueSmallPoint", balloonOptions: {maxWidth: 200}});
					point<?php echo $i;?>.setIconContent();
					map.addOverlay(point<?php echo $i;?>);
					point<?php echo $i;?>.setBalloonContent('<?php echo $this->maps[$i]->title; ?>');
					<?php if($maps==1){ ?>
						point<?php echo $i;?>.openBalloon();
					<?php } ?>
				<?php } ?>

                map.addControl(toolBar);
                map.addControl(zoomControl);
                map.enableScrollZoom();
            }
        
		// ]]></script>
		<div id="YMapsID" style="width:100%;height:100%;">&nbsp;</div>
    </div>
    <div id="description">
    	<div id="terms">
        	<table cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                	<td class="title" width="50%"><?php echo JText::_('Terms'); ?></td>
                    <td class="title" width="50%"><?php echo JText::_('Features'); ?></td>
                </tr>
                <tr>
                	<td><ul><?php echo $this->items->terms; ?></ul></td>
                    <td><ul><?php echo $this->items->features; ?></ul></td>
                </tr>
            </table>
        </div>
       	<div id="info">
        	<span><?php echo JText::_('Information'); ?></span><span><a href="index.php?option=com_coupon&view=front&layout=comments"><?php echo JText::_('Comments'); ?></a></span>
            <span>
            	<a class="share-comment"><?php echo JText::_('Add comment'); ?></a>
                <div class="share-comment-hover">
					<textarea id="comment" name="comment" rows="7" cols="40"></textarea>
                    <div id="commentB">
                    	<a href="index.php#top" id="addComment" ><?php echo JText::_('Send'); ?></a>
                    </div>
                </div>
            </span>
        </div>
        <div id="infotext">
        	<?php echo $this->items->info; ?>
        </div>
        <div id="contacts">
        	<?php if($this->items->contacts!=""){?>
        	<ul>
                <?php echo $this->items->contacts; ?>
            </ul>
            <?php } ?>
        </div>
        <?php if($this->items->clock!=""){ ?>
        <div id="clock">
        	<?php echo $this->items->clock; ?>
        </div>
        <?php } ?>
        <?php if($this->items->dateEnd>=date('Y-m-d')){ ?>
            <a href="index.php?option=com_coupon&view=event&id=<?php echo $this->items->id; ?>&layout=payment" id="banner"><?php echo JText::_('BUY COUPON'); ?></a>
		<?php } ?> 
    </div>
</div>
<div id="right">
	<div class="titleBlack"> </div>
    <div id="panel">
    	<div id="price"><?php echo $this->items->price; ?> <?php echo JText::_('Rub'); ?></div>
        <?php if($this->items->dateEnd>=date('Y-m-d')){ ?>
           <div id="buy"> 
        		<a href="index.php?option=com_coupon&view=event&id=<?php echo $this->items->id; ?>&layout=payment"><?php echo JText::_('BUY COUPON'); ?></a>
        <?php }else{ ?>
        	<div id="nobuy">
            	<a><?php echo JText::_('BUY COUPON'); ?></a>
        <?php } ?> 
        </div>
        <div class="spacer"></div>
        	<table cellpadding="2" cellspacing="0" width="100%" id="saleInfo">
            	<?php if($this->items->realPrice!=0){ ?>
                <tr>
                	<th><?php echo JText::_('Cost'); ?></th>
                    <th><?php echo JText::_('Discount'); ?></th>
					<th><?php echo JText::_('Savings'); ?></th>
                </tr>
                <tr>
                	<td><?php echo $this->items->realPrice; ?> <?php echo JText::_('Rub'); ?></td>
                    <td><?php echo $this->items->sale; ?>%</td>
                    <td><?php echo round(($this->items->realPrice*$this->items->sale)/100); ?> <?php echo JText::_('Rub'); ?></td>
                </tr>
                <?php }else{ ?>
                <tr>
                	<th><?php echo JText::_('Cost'); ?></th>
                    <th><?php echo JText::_('Discount'); ?></th>
                </tr>
                <tr>
                	<td><?php echo JText::_('Unlimited'); ?></td>
                    <td><?php echo $this->items->sale; ?>%</td>
                </tr>
                <?php } ?>
            </table>
        <div class="spacer"></div>
        	<div id="timer">
            	<div class="yellow"><?php echo JText::_('PRIOR TO COMPLETING THE REMAINING'); ?></div>
                <div id="endDate"></div>
            </div>
        <div class="spacer"></div>
        	<div id="count">
            	<?php if($this->items->dateEnd>=date('Y-m-d')){ ?>
        			<?php echo sprintf(JText::_('ACTION WILL TAKE PLACE A'), $this->items->count, '<a href="index.php?option=com_coupon&view=event&id='.$this->items->id.'&layout=payment">'); ?>
				<?php }else{ ?>
        			<?php echo sprintf(JText::_('ACTION FINISHED'), $this->items->count); ?>
				<?php } ?>
            </div>
        <div class="spacer"></div>
        	<div class="yellow"><?php echo JText::_('Tell a friend'); ?></div>
            <?php echo JEventsCommon::SendFriend($this->items->title, $this->items->id); ?>
    </div>
    <?php if(count($this->optional)>0){ ?>
    <div id="optional">
    	<h2><?php echo JText::_('Optional actions'); ?></h2>
    	<?php for($i=0;$i<count($this->optional);$i++){ ?>
			<div class="optionalB">
            	<a href="index.php?option=com_coupon&view=event&id=<?php echo $this->optional[$i]->id; ?>"><img src="images/events/<?php echo $this->optional[$i]->image; ?>" /></a>
                <?php echo $this->optional[$i]->title; ?>
            </div>
            <div class="optionalC">
            	 <table cellpadding="2" cellspacing="0" width="100%">
                 	<tr>
                        <td><?php echo JText::_('Price'); ?>:</td>
                        <td class="orange"><?php echo $this->optional[$i]->price; ?> <?php echo JText::_('Rub'); ?></td>
                        <td><?php echo JText::_('Discount'); ?></td>
                        <td class="orange"><?php echo $this->optional[$i]->sale; ?> %</td>
                	</tr>
            	</table>
            </div>
            <div class="optionalF">
            	<a href="index.php?option=com_coupon&view=event&id=<?php echo $this->optional[$i]->id; ?>"><?php echo JText::_('More'); ?></a>
            </div>
		<?php } ?>
    </div>
    <?php } ?>
</div>