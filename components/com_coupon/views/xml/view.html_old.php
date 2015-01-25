<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );
require_once (JPATH_COMPONENT.DS.'common.php');

class ViewXml extends JView
{	
	function display($tpl = null)
	{
		global $mainframe;
		$menus	= &JSite::getMenu();
		$menu   = $menus->getActive();
		$document	= & JFactory::getDocument();
		$pparams = &$mainframe->getParams('com_coupon');

		$db	=& JFactory::getDBO();
		
		$root = substr(JURI::root(),0,strlen(JURI::root())-1);
		
		$orderby = ' ORDER BY a.dateEnd ASC';
		
		$where = array();
		$where[]='a.type=0';
		$where[]='c.xml=1';
		$where[]='a.published=1';
		$where[]='a.dateStart<='.$db->Quote(date('Y-m-d'));
		$where[]='a.dateEnd>='.$db->Quote(date('Y-m-d'));								
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		jimport('joomla.html.pagination');
		$pagination = new JPagination( $total, $limitstart, $limit );
		
		$query = 'SELECT a.id, a.image, a.title, a.sale, a.info, a.dateEnd, a.dateStart, a.dateUsed, a.count, a.price, a.realPrice, a.company, a.phone, a.url, b.title AS city'
		. ' FROM #__mos_event AS a'
		. ' LEFT JOIN #__mos_city AS b ON a.city=b.id'
		. ' LEFT JOIN #__mos_category AS c ON a.catid=c.id'
		. $where
		. $orderby
		;
		
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		
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
			$description=str_replace('"', '', str_replace("'",'',strip_tags($row->info)));
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
						'.$row->id.'
					</id>
					<name>
						'.htmlspecialchars(str_replace('"', '', str_replace("'",'',strip_tags($row->title)))).'
					</name>
					<description>
						'.$description.'
					</description>
					<url>
						'.$root.JRoute::_('index.php?option=com_coupon&view=event&id='.$row->id).'
					</url>
					<picture>
						'.JURI::base().'images/events/med_'.$row->image.'
					</picture>
					<region>
						Москва
					</region>
					<beginsell>
						'.$row->dateStart.'T00:00:00
					</beginsell>
					<endsell>
						'.$row->dateEnd.'T23:59:59
					</endsell>
					<beginvalid>
						'.$row->dateStart.'T00:00:00
					</beginvalid>
					<endvalid>
						'.$row->dateUsed.'T23:59:59
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