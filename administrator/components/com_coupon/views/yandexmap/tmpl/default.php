<?php defined('_JEXEC') or die('Restricted access'); 
	$document = &JFactory::getDocument();
	$document->addScript(JURI::root(true).'/administrator/components/com_coupon/js/coordinates.js');
	$config = new JConfig();
	$document->addScript('http://api-maps.yandex.ru/1.1/index.xml?key='.$config->yandex_key);
?>

<script xmlns:str="http://exslt.org/strings" type="text/javascript"><!--
	var map, placemark;
            
            window.onload = function init () {
				var y = window.top.document.forms.adminForm.getElementById('longitude').value;
				var x = window.top.document.forms.adminForm.getElementById('latitude').value;
                var pointCenter = new YMaps.GeoPoint( y, x);
                map = new YMaps.Map(document.getElementById("YMapsID"));
                map.setCenter(pointCenter, 13);
                map.addControl(new YMaps.TypeControl());
                map.enableScrollZoom();
                
                placemark = new YMaps.Placemark(pointCenter, {draggable: true, hideIcon: false});
                setBalloonInfo(placemark, pointCenter);
                map.addOverlay(placemark);
                
                YMaps.Events.observe(placemark, placemark.Events.Drag, function (mEvent) {
                    setBalloonInfo(placemark, mEvent.getGeoPoint());
                })
                
                YMaps.Events.observe(map, map.Events.Click, function (mEvent) {
                    var newGeoPoint = mEvent.getGeoPoint();
                    placemark.setGeoPoint(newGeoPoint);
                    setBalloonInfo(placemark, newGeoPoint);
                })
            }
            
            function showAddress (value) {
                var geocoder = new YMaps.Geocoder(value, {results: 1, boundedBy: map.getBounds()});
                
                YMaps.Events.observe(geocoder, geocoder.Events.Load, function () {
                    if (this.length()) {
                        var geoResult = this.get(0);
                        map.setBounds(geoResult.getBounds());
                        
                        placemark.setGeoPoint(geoResult.getGeoPoint());
                        setBalloonInfo(placemark, geoResult.getGeoPoint(), geoResult.text);
                        placemark.openBalloon();
						
                    }else {
                        alert("<?php echo JText::_('No find'); ?>")
                    }
                });
            }
            
            function setBalloonInfo (placemark, geoPoint, text) {
                var content = '';
                if (text) {
                content += '<div class="title">' + text + '</div>';
                }
                content += '<span class="coords-title"> <?php echo JText::_('XY'); ?>: </span>' + geoPoint.toString();
                placemark.setBalloonContent(content);
                document.getElementById('coords').value = geoPoint.getLng();
				document.getElementById('coords2').value = geoPoint.getLat();	
				
				window.top.document.forms.adminForm.getElementById('longitude').value = geoPoint.getLng();
				window.top.document.forms.adminForm.getElementById('latitude').value = geoPoint.getLat();
				
				
            }
            --></script>

<div>
  <form action="#" onsubmit="showAddress(this.address.value);return false;">
    <table>
      <tr>
        <td><input name=""  type="text" id="address" value="" size="50" />
          </input></td>
        <td><input class="find-button" type="submit" value="<?php echo JText::_('Find button'); ?>">
          </input>
        </td>
      </tr>
      <tr>
        <td colspan="2"><p>
        	<?php echo JText::_('X'); ?>:<input name="" type="text" id="coords2" size="30" /></input>&nbsp;
            <?php echo JText::_('Y'); ?>:<input name="" type="text" id="coords" size="30" />       
            </input>
          </p></td>
      </tr>
    </table>
    <div style="margin:0;padding:0;text-align:center;">
      <div id="YMapsID" style="margin:0;padding:0;width:600px;height:520px;margin-bottom:5px;"></div>
    </div>
  </form>
</div>