<?php defined('_JEXEC') or die('Restricted access');
	$document = &JFactory::getDocument();
	$config = new JConfig();
	//$document->addScript('http://api-maps.yandex.ru/1.1/index.xml?key='.$config->yandex_key);
?>
<script type="text/javascript">
	var loading=0;
	window.addEvent('domready', function () {
		document.payment = new payment({id_event:'<?php echo $this->items->id; ?>', host:'<?php echo JURI::base().'robokassa.php'; ?>',price:'<?php echo $this->items->price; ?>', realPrice:'<?php echo $this->items->realPrice; ?>'});
		popupMap = new MoodalBox("mapWin", "overlay", {allowManualClose:true});
		$$('a.map').each(function(el) { 
			el.addEvent('click', function() {
				popupMap.show();
				return false;
			});
		});
	});
	
	jQuery.noConflict();
	jQuery(document).ready(function(){
		jQuery('.drop-sel-phone').hide();
		jQuery('.semail').addClass('active');
		jQuery('#select-type a').click(function(){
			if ( jQuery(this).hasClass('sphone') ) {
				jQuery('.drop-sel-email').hide();
				jQuery('.drop-sel-phone').show();
				jQuery('#typepayment').attr('value','2');
				jQuery('#typetitle').html('Введите номер моб. телефона');
			}
			if ( jQuery(this).hasClass('semail') ) {
				jQuery('.drop-sel-phone').hide();
				jQuery('.drop-sel-email').show();
				jQuery('#typepayment').attr('value','1');
				jQuery('#typetitle').html('Введите адрес эл. почты');
			}
			jQuery(this).siblings('a').removeClass('active');
			jQuery(this).addClass('active');
			return false;
		});
		jQuery('#select-payment a').click(function(){
			jQuery(this).siblings('a').removeClass('active');
			jQuery(this).addClass('active');
			jQuery('#IncCurrLabel').attr('value',jQuery(this).attr('rel'));
			return false;
		});
		jQuery('#select-count a').click(function(){
			jQuery(this).siblings('a').removeClass('active');
			jQuery(this).addClass('active');
			jQuery('#shpnum').attr('value', jQuery(this).attr('rel'));
			jQuery('#item_price').html(<?php echo $this->items->price; ?>*jQuery(this).attr('rel'));
			return false;
		});
		
						$('shpnum').set('value', this.get('rel'));
				//if(realPrice>0) $('real_price').set('html', realPrice*this.get('rel'));
				$('item_price').set('html', price*this.get('rel'));
				return false;
	});
	
</script>
<?php if($this->back){ ?>
<ul class="breadcrumbs">
   	<li class="active">←<a href="<?php echo $this->back; ?>">Вернуться назад</a></li>
</ul>
<?php } ?>
<div class="action-descr clearfix">
	<h1><?php echo $this->items->title; ?></h1>
	<div class="prod-opt clearfix">
		<ul class="list-descr">
			<?php if($this->items->metro_name){ ?><li><span class="icons-small ico-metro"></span>Метро: <a href="<?php echo JRoute::_('index.php?option=com_coupon&view=now&catid='.$this->items->catid.'&options[metro]='.$this->items->metro_id);?>"><?php echo $this->items->metro_name; ?></a></li><?php } ?>
            <?php for($i=0;$i<count($this->options);$i++){?>
				<li><?php echo $this->options[$i]->title; ?>: <a href="<?php echo JRoute::_('index.php?option=com_coupon&view=now&catid='.$this->items->catid.'&options['.$this->options[$i]->catid.']='.$this->options[$i]->id);?>"><?php echo $this->options[$i]->value; ?></a></li>
            <?php } ?>
		</ul>
	</div>	
    <div class="action-descr-left">
    	<div class="slider-wrapp slider-inside dashed">
        	<div id="slider" class="flexslider">
  				<ul class="slides">
                	<?php for($i=0;$i<count($this->images);$i++){ ?>
                        <li><img src="images/slider/big_<?php echo $this->images[$i]->image; ?>" width="500" height="317" align="middle"/></li>
                    <? } ?>
  				</ul>
			</div>
			<div id="carousel" class="flexslider">
  				<ul class="slides">
                    <?php for($i=0;$i<count($this->images);$i++){ ?>
                        <li><img src="images/slider/big_<?php echo $this->images[$i]->image; ?>" width="500" height="317" align="middle"/></li>
                    <? } ?>
  				</ul>
			</div>
       	</div>
		<div class="recommandet-item">
			<?php echo $this->items->terms; ?>
		</div>
	</div><!--.action-descr-left-->
	<div class="action-descr-right">
    	<div>
			<h3>Немного о заведении</h3>
			<?php echo $this->items->info; ?>
        </div>
        <div class="contact-item clearfix">
        	<h3>Адрес</h3>
			<div class="contact-item-map">
				<a href="#" class="map"><img height="100" width="129" src ="http://static-maps.yandex.ru/1.x/?size=129,100&amp;z=14&amp;l=map&amp;pt=<?php echo $this->maps[0]->longitude; ?>,<?php echo $this->maps[0]->latitude; ?>,pmdom&amp;key=<?php echo $config->yandex_key;?>" /></a>
				<script type="text/javascript">
					function constract_map(ymaps){
						var mapBig = new ymaps.Map("ymaps-map-big", {
							center: [<?php echo $this->params->get( 'y' ); ?>,<?php echo $this->params->get( 'x' ); ?>],
							zoom: <?php echo $this->params->get( 'scale' ); ?>,
							type: "yandex#map"
						});
						mapBig.controls
							.add("zoomControl")
							.add("mapTools")
							.add(new ymaps.control.TypeSelector(["yandex#map", "yandex#satellite", "yandex#hybrid", "yandex#publicMap"]));
						
							<?php
								$maps=count($this->maps);
								for($i=0;$i<$maps;$i++){
							?>
								var marker<?php echo $i;?> = new ymaps.Placemark([<?php echo $this->maps[$i]->longitude; ?>,<?php echo $this->maps[$i]->latitude; ?>], {
									balloonContent: "<?php echo $this->maps[$i]->title; ?>"
								}, {
									preset: "twirl#redDotIcon"
								});
								mapBig.geoObjects.add(marker<?php echo $i;?>);
							<?php } ?>
							marker0.balloon.open();	
					}
					window.onload = function () {
						constract_map(ymaps);
					}
				</script>
				<span class="zoom-bl"><a href="#" class="map"><span></span>Увеличить</a></span>
			</div>
			<div class="contact-item-txt">
				<?php echo $this->items->contacts; ?>
			</div>
		</div>
		<div class="right-inner dashed">
	<!--<?php echo JEventsCommon::peopleCombo($this->items->min_count,$this->items->max_count);?>-->
            <div class="dotted-list">
            	<h3>Купон на скидку</h3> 
            </div>
            <div class="dotted-list">
                <strong><?php echo $this->items->subtitle; ?></strong><br/>
				<?php echo $this->items->subterms; ?>
            </div>
			<div class="dotted-list" id="select-payment">
				<strong>Выберите способ оплаты купона:</strong><br/>
				<a href="#" rel="BANKOCEAN2R" class="active"><span>Банковская карта</span></a>
				<a href="#" rel="YandexMerchantOceanR"><span>Яндекс.Деньги</span></a>
				<a href="#" rel="MobicomMtsR"><span>МТС</span></a>
				<a href="#" rel="MobicomBeelineR"><span>Билайн</span></a>
				<a href="#" rel="MegafonR"><span>Мегафон</span></a>
				<a href="#" rel="WMRM"><span>Вебмани</span></a>
                <a href="#" rel="RapidaOceanEurosetR"><span>Евросеть</span></a>
                <a href="#" rel="RapidaOceanSvyaznoyR"><span>Связной</span></a>
                <a href="#" rel=""><span>Терминалы</span></a>
			</div>
			<div class="dotted-list" id="select-count">
				<strong>Выберите количество человек:</strong><br/>
                <?php echo JEventsCommon::peopleCombo($this->items->min_count,$this->items->max_count);?>
			</div>
			<div class="dotted-list" id="select-type">
				<strong>Выберите куда отправить купон:</strong><br/>
				<a href="#" class="sphone" rel="2"><span>На моб. телефон</span></a>
				<a href="#" class="semail" rel="1"><span>На эл. почту</span></a>
                <input type="hidden" name="typepayment" id="typepayment" value="1" />
			</div>
			<div class="dotted-list">
            	<strong id="typetitle">Введите адрес эл. почты</strong><br/>
				<div class="drop-sel-email">
                	
					<input type="text" class="inputemail" id="inputemail" placeholder="Введите ваш e-mail" />
				</div>
				<div class="drop-sel-phone">
						+7 
					(<input type="text" name="code" id="code" size="3" max="3" class="inputphone" maxlength="3" style="width:30px;" value="">)
					<input type="text" name="phone_1" id="phone_1" size="3" max="3" maxlength="3" class="inputphone" value="***" style="width:30px;">-<input type="text" name="phone_2" id="phone_2" size="2" max="2" maxlength="2" class="inputphone" value="**" style="width:20px;">-<input type="text" name="phone_3" id="phone_3" size="2" max="2" maxlength="2" class="inputphone" value="**" style="width:20px;">	
				</div>
			</div>
			<div class="checkout" id="startpay">
				<p class="wh-sp-nowrpa"><span class="price"><span id="item_price"><?php echo $this->items->price*$this->items->min_count; ?></span><span class="small">руб.</span></span>
				<?php /*if ($this->items->realPrice){ ?><span class="price-old"><b id="real_price"><?php echo $this->items->realPrice; ?></b><span class="ruble">c</span></span><?php } */?>
				<a href="#" class="btn" >Перейти к оплате</a></p>
			</div>
		</div>	
	</div><!--.action-descr-right-->
        </div><!--.action-descr-->
        
        
        <?php if(count($this->optional)>0){ ?>
        <h2>Другие рестораны в нашем каталоге</h2>
        <ul class="list-actions list-act-small">
    	<?php for($i=0;$i<count($this->optional);$i++){ ?>
        	<li>
            	<span class="photo-border"><a href="index.php?option=com_coupon&view=event&id=<?php echo $this->optional[$i]->id; ?>"><img src="images/events/med_<?php echo $this->optional[$i]->image; ?>" /></a></span>
                <a href="index.php?option=com_coupon&view=event&id=<?php echo $this->optional[$i]->id; ?>" class="title-link"><?php echo $this->optional[$i]->title; ?></a>
            </li>
		<?php } ?>
        </ul>
    <?php } ?>
        <form action="<?php echo $this->webmoney->url ;?>" method="post" id="robokassa">
            <input type="hidden" name="InvId" id="InvId" value="" />
            <input type="hidden" name="MrchLogin" value="<?php echo $this->webmoney->login ;?>">
            <input type="hidden" name="OutSum" id="OutSum" value="<?php echo $this->items->price; ?>" />
            <input type="hidden" name="Desc" value="<?php echo $this->escape(strip_tags($this->items->title.($this->items->subtitle ? ', '.$this->items->subtitle : '').($this->items->subterms ? ', '.$this->items->subterms : ''))); ?>">
            <input type="hidden" name="SignatureValue" id="SignatureValue" value="">
            <input type="hidden" name="Shp_item" value="<?php echo $this->items->id ;?>">
            <input type="hidden" name="IncCurrLabel" id="IncCurrLabel"  value="BANKOCEAN2R" />
            <input type="hidden" name="Culture" value="ru">
            <input type="hidden" name="shpnum" id="shpnum" value="<?php echo $this->items->min_count;?>">
            <input type="hidden" name="Email" id="e-mail" value="">
        </form>
   
    <div id="mapWin" class="popup login-f"><a class="close-pop close"></a>
    	<div id="ymaps-map-big" style="width:500px;height:500px;"></div>
    </div>