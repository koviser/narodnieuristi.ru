<?php defined('_JEXEC') or die('Restricted access');?>
<script type="text/javascript" src="http://api-maps.yandex.ru/2.0-stable/?lang=ru-RU&coordorder=longlat&load=package.full&wizard=constructor"></script>
<script type="text/javascript">
	function constract_map(ymaps){
		var mapBig = new ymaps.Map("ymaps", {
			center: [<?php echo $this->item->longitude; ?>, <?php echo $this->item->latitude; ?>],
			zoom: 14,
			type: "yandex#map"
		});
		mapBig.controls
			.add("zoomControl")
			.add("mapTools")
			.add(new ymaps.control.TypeSelector(["yandex#map", "yandex#satellite", "yandex#hybrid", "yandex#publicMap"]));
		var marker = new ymaps.Placemark([<?php echo $this->item->longitude; ?>, <?php echo $this->item->latitude; ?>], {
			balloonContent: "<?php echo $this->item->adress; ?>"
		}, {
			preset: "twirl#redDotIcon"
		});
		mapBig.geoObjects.add(marker);
		marker.balloon.open();	
	}
	window.onload = function () {
		constract_map(ymaps);
	}
</script>
<div id="ymaps" style="width:500px;height:500px;"></div>