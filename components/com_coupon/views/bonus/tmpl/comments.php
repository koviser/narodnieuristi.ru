<?php defined('_JEXEC') or die('Restricted access');
	$document = &JFactory::getDocument();
	$config = new JConfig();
	$document->addScript('http://api-maps.yandex.ru/1.1/index.xml?key='.$config->yandex_key);
?>

<script type="text/javascript">
	window.addEvent('domready', function() {
		document.tabs = new JFormTabs();
		document.comments = new JComments({eventID:'<?php echo $this->items->id; ?>'});
		document.bonus = new JBonus({userID:<?php echo $this->user->id; ?>});
	});
</script>
<div id="left">
	<div class="componentheading"><?php echo $this->params->get( 'page_title' ); ?></div>
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
        	<span><a href="index.php?option=com_coupon&view=bonus&id=<?php echo $this->items->id; ?>"><?php echo JText::_('Information'); ?></span></a><span><?php echo JText::_('Comments'); ?></span>
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
		<div id="comments">
        	<?php for($i=0;$i<count($this->comment);$i++){ ?>
            	<div class="comment">
                	<div class="commentTitle">
                    	<?php echo $this->comment[$i]->user; ?> <span><b>[</b> <?php echo JEventsCommon::GetTime($this->comment[$i]->dateQ); ?> <b>]</b></span>
                    </div>
                	<div class="commentD">
						<?php echo $this->comment[$i]->message; ?>
                    </div>
                </div>
                <?php if($this->comment[$i]->answer!=""){ ?>
                    <div class="comment answer">
                        <div class="commentTitle">
                            <?php echo JText::_('ADMIN NAME'); ?> <span><b>[</b> <?php echo JEventsCommon::GetTime($this->comment[$i]->dateA); ?> <b>]</b></span>
                        </div>
                        <div class="commentD">
                            <?php echo $this->comment[$i]->answer; ?>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>
<div id="right">
	<div class="titleBlack"><?php echo JText::_('Price'); ?></div>
    <div id="panel">
    	<div id="price"><?php echo $this->items->price; ?> <?php echo JText::_('Bon'); ?></div>
        <div id="buyB">
                <div id="buy">
                	<a href="#" class="buyBonus" rel="<?php echo $this->items->id; ?>"><?php echo JText::_('BUY'); ?></a>
            	</div>
        </div>
        <div class="spacer"></div>
        	<div id="count2">
            	<?php echo sprintf(JText::_('ACTION WILL TAKE PLACE'), $this->items->count); ?>
            </div>
        <div class="spacer"></div>
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
<div id="modalWin">
	<div class="modalTop">
    	<a class="close"></a>
    	<div class="modalheading"><?php echo JText::_('Action payment');?></div>
    </div>
    <div class="modalText">
    	<?php echo JText::_('Do you want pay bonus');?>
        <div id="payModal"><a class="button" id="payBonusButton"><?php echo JText::_('Checkout'); ?></a></div>
    </div> 
</div>