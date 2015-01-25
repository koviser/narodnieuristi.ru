<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );
require_once (JPATH_COMPONENT.DS.'common.php');

class ViewXml extends JView
{	
	function display($tpl = null)
	{
		global $mainframe;
		$root = substr(JURI::root(),0,strlen(JURI::root())-1);
		
		$db	=& JFactory::getDBO();
		
		$where = array();
		$where[]='a.id=1';
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT a.*'
		. ' FROM #__mos_kuponator AS a'
		. $where
		;
		
		$db->setQuery($query);
		$kuponator = $db->loadObject();
		
		$where = array();
		$where[]='a.type=0';
		$where[]='c.xml=1';
		$where[]='a.published=1';

		if($kuponator->date+(3600*23)<time()){
			$orderby = ' ORDER BY a.id ASC';
			$update = 1;
			$where[]='a.id>'.$kuponator->id_event;							
		}else{
			$orderby = ' ORDER BY a.id DESC';
			$where[]='a.id<='.$kuponator->id_event;								
		}
		
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT a.id, a.image, a.subtitle, a.sale, a.info, a.count, a.price, a.realPrice, a.company, a.phone, a.url, b.title AS city, a.subterms'
		. ' FROM #__mos_event AS a'
		. ' LEFT JOIN #__mos_city AS b ON a.city=b.id'
		. ' LEFT JOIN #__mos_category AS c ON a.catid=c.id'
		. $where
		. $orderby
		;
		
		$db->setQuery($query, 0, 7);
		$rows = $db->loadObjectList();
		
		if(!count($rows)){
			$orderby = ' ORDER BY a.id ASC';
			$where = array();
			$where[]='a.type=0';
			$where[]='c.xml=1';
			$where[]='a.published=1';
			$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
			$query = 'SELECT a.id, a.image, a.subtitle, a.sale, a.info, a.count, a.price, a.realPrice, a.company, a.phone, a.url, b.title AS city, a.subterms'
			. ' FROM #__mos_event AS a'
			. ' LEFT JOIN #__mos_city AS b ON a.city=b.id'
			. ' LEFT JOIN #__mos_category AS c ON a.catid=c.id'
			. $where
			. $orderby
			;
			
			$db->setQuery($query, 0, 7);
			$rows = $db->loadObjectList();
			
			$update = 1;
		}
		
		if($update){
			$query = 'UPDATE'
			. ' #__mos_kuponator'
			. ' SET id_event='.$rows[(count($rows)-1)]->id.', date='.time()
			. ' WHERE id=1'
			;
			$db->setQuery( $query );
			$db->query();	
		}
		
		header('Content-type: text/xml; charset=utf8', true);
		
		$xml='<discounts>
			<operator>
				<name>
					Скидкинг
				</name>
				<url>
					'.JURI::base().'
				</url>
				<logo>
					'.JURI::base().'images/logo.jpg
				</logo>
				<logo264>
					'.JURI::base().'images/logo264.jpg
				</logo264>
				<logo88>
					'.JURI::base().'images/logo88.jpg
				</logo88>
				<logo16>
					'.JURI::base().'images/logo16.gif
				</logo16>
			</operator>
			<offers>
		';
		
		for($i=0;$i<count($rows);$i++){
			$row=$rows[$i];
			$description=str_replace('"', '', str_replace("'",'',strip_tags($row->subterms)));
			$description=htmlspecialchars(str_replace('&nbsp;', ' ', $description));
			if($row->realPrice){
				$realPrice=number_format( $row->realPrice, 2, '.', '' );
				$discountprice=number_format( round($row->realPrice*((100-$row->sale)/100)), 2, '.', '' );	
			}else{
				$realPrice=0;
				$discountprice=0;
			}
			$price=number_format( $row->price, 2, '.', '' );
			if($price==$discountprice){
				$price=0;
			}
			
			$query = 'SELECT a.*'
			. ' FROM #__mos_map AS a'
			. ' WHERE a.id_event='.(int)$row->id
			;
			
			$db->setQuery($query);
			$maps = $db->loadObjectList();
			
			$xml.='
				<offer>
					<id>
						'.$row->id.date("d").date("m").'
					</id>
					<name>
						'.htmlspecialchars(str_replace('"', '', str_replace("'",'',strip_tags($row->subtitle)))).'
					</name>
					<description>
						'.$description.'
					</description>
					<url>
						'.$root.JRoute::_('index.php?option=com_coupon&view=event&id='.$row->id.'&alias='.$row->id.date("d").date("m")).'
					</url>
					<picture>
						'.JURI::base().'images/events/med_'.$row->image.'
					</picture>
					<region>
						Москва
					</region>
					<beginsell>
						'.date("Y-m-d", (!$update ? $kuponator->date+3600*24 : time()+3600*24)).'T00:00:00
					</beginsell>
					<endsell>
						'.date("Y-m-d", (!$update ? $kuponator->date+3600*24 : time()+3600*24)).'T23:59:59
					</endsell>
					<beginvalid>
						'.date("Y-m-d", (!$update ? $kuponator->date+3600*24 : time()+3600*24)).'T00:00:00
					</beginvalid>
					<endvalid>
						'.date("Y-m-d", (!$update ? $kuponator->date+3600*72 : time()+3600*72)).'T23:59:59
					</endvalid>
					<price>
						'.$realPrice.'
					</price>
					<discount>
						'.$row->sale.'
					</discount>
					<discountprice>
						'.$discountprice.'
					</discountprice>
					<pricecoupon>
						'.$price.'
					</pricecoupon>
			';
			if(count($maps)>0){
				$xml.='
					<supplier>
						<name>'.str_replace('"', '', str_replace("'",'',strip_tags($row->company))).'</name>'
						.'<url>'.$row->url.'</url>';
						if($row->phone) $xml.='
						<tel>'.$row->phone.'</tel>';
				$xml.='
						<addresses>';
				for($j=0;$j<count($maps);$j++){
					$map=$maps[$j];
					$xml.='
							<address>
								<name>
								'.$map->title.'
								</name>
								<coordinates>'.$map->longitude.','.$map->latitude.'</coordinates>
							</address>
					';
				}
				$xml.='
						</addresses>
					</supplier>
				';
			}
				
			$xml.='
				</offer>
			';
		}
		
		$xml.='
			</offers>
		</discounts>
		';
		
		echo $xml;
		exit;

	}
}
?>