<?php
	class JEventsCommon
	{
		function GetDate($date, $endDate, $short=null)
		{
			$strtotime=strtotime($date);
			$strtotimeEnd=strtotime($endDate);
			$month=JText::_(date('F', $strtotime).'_ext');
			if(date('Y', $strtotime)!=date('Y', $strtotimeEnd)){
				$year=date('Y', $strtotime).'/'.date('Y', $strtotimeEnd);
			}else{
				$year=date('Y', $strtotimeEnd);
			}
			if($strtotime==$strtotimeEnd){
				if($short==1){
					$result = date('j', $strtotime).' '.$month.' '.date('Y', $strtotime).' '.JText::_('Years');
				}else{
					$result = JText::_('Only').' <span>'.date('j', $strtotime).' '.$month.' '.date('Y', $strtotime).' '.JText::_('Years').'</span>'; 
				}
			}else{
				if(date('m', $strtotime)==date('m', $strtotimeEnd)){
					$result = JText::_('Only').' <span>'.date('j', $strtotime).'-'.date('j', $strtotimeEnd).' '.$month.' '.$year.' '.JText::_('Years').'</span>'; 
				}else{
					$monthEnd=JText::_(date('F', $strtotimeEnd));
					$result = JText::_('Only').' <span>'.date('j', $strtotime).' '.$month.' - '.date('j', $strtotimeEnd).' '.$monthEnd.' '.$year.' '.JText::_('Years').'</span>';
				}
			}
			return $result;
		}
		function GetTime($date)
		{
			$strtotime=strtotime($date);
			$month=JText::_(date('F', $strtotime));
			$result = date('j', $strtotime).' '.$month.' '.date('Y', $strtotime).' '.JText::_('Years').' '.date('H', $strtotime).':'.date('i', $strtotime);
			return $result;
		}
		function GetDateEnd($date)
		{
			$strtotime=strtotime($date);
			$month=JText::_(date('F', $strtotime).'_ext');
			$result = JText::_('You can use the coupon to').' '.date('j', $strtotime).' '.$month.' '.date('Y', $strtotime).' '.JText::_('Years'); 
			return $result;
		}
		function GetDateEndHistory($date)
		{
			$strtotime=strtotime($date);
			$month=JText::_(date('F', $strtotime));
			$result = JText::_('Acts').' '.date('j', $strtotime).' '.$month; 
			return $result;
		}
		function GetDatePaid($date)
		{
			$strtotime=strtotime($date);
			$month=JText::_(date('F', $strtotime));
			$result = JText::_('Paid').' '.date('j', $strtotime).' '.$month.' '.JText::_('in').' '.date('H:i', $strtotime); 
			return $result;
		}
		function GetBirthDay($date)
		{
			if($date!='0000-00-00'){
				$strtotime=strtotime($date);
				$month=JText::_(date('F', $strtotime));
				$result = date('j', $strtotime).' '.$month.' '.date('Y', $strtotime).' '.JText::_('Years'); 
				return $result;
			}
		}
		function Gender($value)
		{
			if($value==1){
				return JText::_('Man');
			}else if($value==2){
				return JText::_('Girl');
			}
		}
		function Subscribe($value)
		{
			if($value==1){
				return JText::_('SUBSCRIBE_YES');
			}else{
				return JText::_('SUBSCRIBE_NO');
			}
		}
		function EventsTitle($value)
		{
			if($value>date("m")){
				$year=date("Y")-1;
			}else{
				$year=date("Y");
			}
			return JText::_('Past actions of the').' <span>'.JText::_('Month_'.$value).' '.$year.' '.JText::_('Years').'</span>';
		}
		function ArhiveTitle($value)
		{
			if($value>date("m")){
				$year=date("Y")-1;
			}else{
				$year=date("Y");
			}
			return sprintf(JText::_( 'User statistic' ), JText::_('Month_'.$value).' '.$year);
		}
		function GetMonth($month)
		{
			switch($month){
				case 1:
					$result = 'JAN';
					break;
				case 2:
					$result = 'FEB';
					break;
				case 3:
					$result = 'MAR';
					break;
				case 4:
					$result = 'APR';
					break;
				case 5:
					$result = 'MAY';
					break;
				case 6:
					$result = 'JUN';
					break;
				case 7:
					$result = 'JUL';
					break;
				case 8:
					$result = 'AUG';
					break;
				case 9:
					$result = 'SEP';
					break;
				case 10:
					$result = 'OCT';
					break;
				case 11:
					$result = 'NOV';
					break;
				case 12:
					$result = 'DEC';
					break;
			}
			return JText::_($result);
		}
		function GetDateEndScript($date)
		{
			$strtotime=strtotime($date." 23:59:59");
			$result = date('M,d,Y,H:m:s', $strtotime); 
			return $result;
		}
		function GetCount($value)
		{
			if($value%100>10 && $value%100<15){
				$result = '<span>'.$value.'</span> '.JText::_('Coupon_ov');
			}else{
				if($value%10==1){
					$result = '<span>'.$value.'</span> '.JText::_('Coupon_n');
				}else if($value%10>4 || $value%10==0){
					$result = '<span>'.$value.'</span> '.JText::_('Coupon_ov');
				}else{
					$result = '<span>'.$value.'</span> '.JText::_('Coupon_na');	
				}
			}
			return $result;
		}
		function GetMetro($value)
		{
			$value = $value-1;
			if($value){
				if($value%100>10 && $value%100<15){
					$result = $value.' '.JText::_('st_1');
				}else{
					if($value%10==1){
						$result = $value.' '.JText::_('st_2');
					}else if($value%10>4 || $value%10==0){
						$result = $value.' '.JText::_('st_1');
					}else{
						$result = $value.' '.JText::_('st_3');	
					}
					 
				}
				$result = '<a href="#">и еще '.$result.'</a>';
			}
			return $result;
		}
		function GetCountCoupon($count)
		{
			if($value%100>10 && $value%100<15){
				$result = '<span>'.$count.'</span> '.JText::_('Coupon_ov').' '.JText::_('buy_no');
			}else{
				if($value%10==1){
					$result = '<span>'.$count.'</span> '.JText::_('Coupon_n').' '.JText::_('buy_n');
				}else if($value%10>4 || $value%10==0){
					$result = '<span>'.$count.'</span> '.JText::_('Coupon_ov').' '.JText::_('buy_no');
				}else{
					$result = '<span>'.$count.'</span> '.JText::_('Coupon_na').' '.JText::_('buy_no');	
				}
			}
			return $result;
		}
		function GetMap($maps)
		{
			$x=array();
			$y=array();
			$countMaps=count($maps);
			$lastMaps=$countMaps-1;
			
			for($i=0;$i<$countMaps;$i++){
				$x[$i]=$maps[$i]->latitude;
			}
			
			sort($x);
			$def_x=$x[$lastMaps]-$x[0];
			$x = $def_x/2+$x[0];
	
			for($i=0;$i<$countMaps;$i++){
				$y[$i]=$maps[$i]->longitude;
			}
			
			sort($y);
			$def_y=$y[$lastMaps]-$y[0];
			$y = $def_y/2+$y[0];
			
			$result['x']=$x;
			$result['y']=$y;
			
			if($def_y<0.006){
				$scale_y=17;
			}else if($def_y>0.006 && $def_y<0.012){
				$scale_y=16;
			}else if($def_y>0.012 && $def_y<0.025){
				$scale_y=15;
			}else if($def_y>0.025 && $def_y<0.05){
				$scale_y=14;
			}else if($def_y>0.05 && $def_y<0.1){
				$scale_y=13;
			}else if($def_y>0.1 && $def_y<0.25){
				$scale_y=12;
			}else if($def_y>0.25 && $def_y<0.5){
				$scale_y=11;
			}else if($def_y>0.5 && $def_y<1){
				$scale_y=10;
			}else{
				$scale_y=9;	
			}
			
			if($def_x<0.003){
				$scale_x=17;
			}else if($def_x>0.003 && $def_x<0.004){
				$scale_x=16;
			}else if($def_x>0.004 && $def_x<0.008){
				$scale_x=15;
			}else if($def_x>0.008 && $def_x<0.015){
				$scale_x=14;
			}else if($def_x>0.015 && $def_x<0.03){
				$scale_x=13;
			}else if($def_x>0.03 && $def_x<0.06){
				$scale_x=12;
			}else if($def_x>0.06 && $def_x<0.012){
				$scale_x=11;
			}else if($def_x>0.12 && $def_x<0.25){
				$scale_x=10;
			}else{
				$scale_x=19;	
			}
			if($scale_y<=$scale_x){
				$result['scale']=$scale_y;
			}else{
				$result['scale']=$scale_x;
			}
			return $result;
		}
		function GetPassword()
		{
			$arr = array('1','2','3','4','5','6',  
                 '7','8','9','0');  
    		$pass = "";  
    		for($i = 0; $i < 6; $i++)  
    		{  
      			$index = rand(0, count($arr) - 1);  
      			$pass .= $arr[$index];  
    		}  
   			return $pass;	
		}
		
		function GenderCombo($value, $onchange = '')
		{

			$item=array();
			$item[] 		= JHTML::_('select.option',  '0', '- '. JText::_( 'Select gender' ) .' -' );
			$item[] 		= JHTML::_('select.option',  '1', JText::_( 'Male' ) );
			$item[] 		= JHTML::_('select.option',  '2', JText::_( 'Female' ) );

			return JHTML::_('select.genericlist',   $item, 'gender', 'class="inputbox required" size="1" ', 'value', 'text', "$value" );
		}
		function peopleCombo($value_min=1, $value_max=10)
		{
			$items = array('','1 человек','2 человека','3 человека','4 человека','5 человек','6 человек','7 человек','8 человек','9 человек','10 человек');
			/*
			$html ='<div class="drop-down-box one">
						<div class="dropdown-sel drop-sel-quant quant-man">
							<span class="icons-small ico-man"></span>
							<span class="dropd-select">
							<i id="select_count">'.$items[$value_min].'</i><em></em></span>
							<ul>';
			for($i=$value_min;$i<=$value_max;$i++){
				$html .='<li rel="'.$i.'">'.$items[$i].'</li>';
			}
			$html .='</ul>
						</div>
					</div>';
			*/
			$html ='';
			for($i=$value_min;$i<=$value_max;$i++){
				$html .='<a href="#" rel="'.$i.'"'.($i==$value_min ? ' class="active"' : '').'><span>'.$items[$i].'</span></a> ';
			}
			$html .='';
			return $html;
		}
		function SubscribeCombo($value, $onchange = '')
		{

			$item=array();
			$item[] 		= JHTML::_('select.option',  '0', JText::_( 'SUBSCRIBE_NO_SEND' ));
			$item[] 		= JHTML::_('select.option',  '1', JText::_( 'SUBSCRIBE_YES_SEND' ) );

			return JHTML::_('select.genericlist',   $item, 'sendEmail', 'class="inputbox required" size="1" ', 'value', 'text', "$value" );
		}
		
		function SendFriend($text, $id)
		{
			$user 		= JFactory::getUser();
			$uri = &JFactory::getURI();
			$url = $uri->toString( array('scheme', 'host', 'port'));
			$result='<div style="float:left;"><script type="text/javascript">
			<!--
			document.write(VK.Share.button(false,{type: "custom", text: "<span id=\"sVkontakte\" class=\"sBlock\">&nbsp;</span>"}));
			-->
			</script></div>';
			$result.='<a id="sOdnoklassniki" class="sBlock" href="'.$url.JRoute::_('index.php?option=com_coupon&view=event&id='.$id).'" onclick="ODKL.Share(this);return false;" title="'.JText::_('Send odnoklassniki').'">&nbsp;</a>
			<script type="text/javascript">
				window.addEvent(\'domready\', function() {
					ODKL.init();	
				});
			</script>
			';
			$result.='<a id="sTwitter" class="sBlock" href="http://twitter.com/share?text='.urlencode(strip_tags($text)).'&amp;url='.$url.JRoute::_('index.php?option=com_coupon&view=event&id='.$id).'" target="_blank" title="'.JText::_('Send Twitter').'">&nbsp;</a>';
			$result.='<a id="sFacebook" class="sBlock" href="http://www.facebook.com/share.php?src=bm&t='.urlencode(strip_tags($text)).'&v=3&u='.urlencode($url.JRoute::_('index.php?option=com_coupon&view=event&id='.$id)).'" target="page" onclick="window.open(\'\',\'page\',\'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=500,height=500,left=150,top=150,titlebar=yes\')" title="'.JText::_('Send Facebook').'">&nbsp;</a>';
			$result.='<a href="http://connect.mail.ru/share?share_url='.urlencode($url.JRoute::_('index.php?option=com_coupon&view=event&id='.$id)).'" id="sMail" target="_blank" class="sBlock" title="'.JText::_('Send MAILRU').'">&nbsp;</a>';
			if($user->guest!=1){
            	//$result.='<a href="'.JRoute::_('index.php?option=com_coupon&view=friend').'" id="sSend" class="sBlock" title="'.JText::_('Send friend').'">&nbsp;</a>';
			}
            $result.='<a href="javascript:void((function(){var%20u=\'http://www.livejournal.com/\',w=window.open(\'\',\'\',\'toolbar=0,resizable=1,scrollbars=1,status=1,left=150,top=150,width=730,height=800\');if(window.LJ_bookmarklet){return%20LJ_bookmarklet(w,u)};var%20e=document.createElement(\'script\');e.setAttribute(\'type\',\'text/javascript\');e.onload=function(){LJ_bookmarklet(w,u)};e.setAttribute(\'src\',u+\'js/bookmarklet.js\');document.getElementsByTagName(\'head\').item(0).appendChild(e)})())" id="sLivejornal" class="sBlock" title="'.JText::_('Send Livejornal').'">&nbsp;</a>';
			return $result;
		}
		
		function InviteFriend($value)
		{
			$uri = &JFactory::getURI();
			$url = $uri->toString( array('scheme', 'host', 'port'));
			$result='<a href="http://connect.mail.ru/share?url='.urlencode($url.JRoute::_('index.php?option=com_coupon&view=registration&friend='.$value)).'&title='.urlencode(JText::_('Invite for site')).'&description='.urlencode(JText::_('site slogan')).'&imageurl='.urlencode(JURI::root().'images/logo.png').'" id="sMail" target="_blank" class="sBlock" title="'.JText::_('Send MAILRU').'">&nbsp;</a>';
			$result.='<div style="float:left;"><script type="text/javascript">
			<!--
			document.write(VK.Share.button(
				{url: \''.$url.JRoute::_('index.php?option=com_coupon&view=registration&friend='.$value).'\', title: \''.JText::_('Invite for site').'\', description: "'.JText::_('site slogan').'", image: "'.JURI::root().'images/logo.png"}, 
				{type: \'custom\', text: \'<span id=\"sVkontakte\" class=\"sBlock\">&nbsp;</span>\'}
			));
			-->
			</script></div>';
			$result.='<a id="sOdnoklassniki" class="sBlock" href="'.$url.JRoute::_('index.php?option=com_coupon&view=event&id='.$id).'" onclick="ODKL.Share(this);return false;" title="'.JText::_('Send odnoklassniki').'">&nbsp;</a>
			<script type="text/javascript">
				window.addEvent(\'domready\', function() {
					ODKL.init();	
				});
			</script>
			';
            $result.='<a id="sTwitter" class="sBlock" href="http://twitter.com/share?text='.urlencode(JText::_('Invite for site')).'&amp;url='.$url.JRoute::_('index.php?option=com_coupon&view=registration&friend='.$value).'" target="_blank" title="'.JText::_('Send Twitter').'">&nbsp;</a>';
            $result.='<a id="sFacebook" class="sBlock" href="http://www.facebook.com/share.php?&t='.urlencode(JText::_('Invite for site')).'&u='.urlencode($url.JRoute::_('index.php?option=com_coupon&view=registration&friend='.$value)).'" target="page" onclick="window.open(\'\',\'page\',\'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=500,height=500,left=150,top=150,titlebar=yes\')" title="'.JText::_('Send Facebook').'">&nbsp;</a>';
			$result.='<a target="_blank" href="http://www.livejournal.com/update.bml?event='.urlencode('<a href="'.$url.JRoute::_('index.php?option=com_coupon&view=registration&friend='.$value).'">'.JText::_('site slogan').'</a>').'&subject='.urlencode(JText::_('Invite for site')).'" id="sLivejornal" class="sBlock" title="'.JText::_('Send Livejornal').'"></a>';
			return $result;
		}
		
		function getParam(){
			$session  = JFactory::getSession();
			//$city = $session->get('city');	
			//$area = $session->get('area');	
			$category = $session->get('category');
			
			$where = array();
			/*
			$where[]='a.city='.(int)$city;
			
			if($area>0){
				$where[]='a.area='.(int)$area;
			}
			*/
			echo $category.'--'; 	
			if($category>0){
				$where[]='a.catid='.(int)$category;
			}
									
			$where = ( count( $where ) ? ' (' . implode( ') AND (', $where ) . ')' : '' );
			
			return $where;
		}
		
		function getModule($position){
			$document = &JFactory::getDocument();
			$renderer = $document->loadRenderer('module');
			foreach (JModuleHelper::getModules($position) as $mod)  {
				echo $renderer->render($mod, $params);
			}
		}
		
		function partnerBonus($id, $totalPrice, $partner, $one=0){
			$db	=& JFactory::getDBO();
			
			$bonus = $totalPrice/100*$partner->reward;
			$bonus = number_format($bonus,2,'.','');
			
			$balance = $partner->balance + $bonus;
			
			$query = 'UPDATE #__users'
			. ' SET balance='.$db->Quote($balance)
			. ' WHERE id='.(int)$partner->id;
			;
						
			$db->setQuery($query);
			$db->query();
							
			$query = 'INSERT #__mos_partner_trans'
			. ' (userid, `date`, type, summ)'
			. ' VALUES ('.(int)$partner->id.', NOW(), '.(int)$partner->partner.', '.$db->Quote($bonus).')';
			;
			$db->setQuery($query);
			$db->query();
			
			if($one){			
				$query = 'UPDATE'
				. ' #__users'
				. ' SET refUse=1'
				. ' WHERE id='.(int)$id
				;
				$db->setQuery( $query );
				$db->query();
			}
		}
		
		function getCouponTemplate($coupon){
			global $mainframe;
			
			$result = '
<html>
<body>
<center>
	<div style="width:650px;font:normal 13px Tahoma, Geneva, sans-serif;color:#000;text-align:left;padding:20px 50px 30px 50px;border:2px #ccc solid;">
    	<div style="height:130px;">
			<div style="float:left;"><img src="'.JURI::root().'images/logo.png" /></div>
            <div style="float:right;font-size:14px;padding:10px 30px 0 0;">
            	<div>'.$coupon->name.'</div>
            </div>
        </div>
        <div style="padding:10px 0 10px 0;border-top:1px #e5e5e5 solid;border-bottom:1px #e5e5e5 solid;margin:0 0 15px 0;">
        	<table cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                	<td width="1%">
                    	<img src="'.JURI::root().'images/events/med_'.$coupon->image.'" style="padding:2px;border:1px #cdcdcd solid;" width="150px" />
                    </td>
                    <td style="font-size:24px;padding:0 0 0 10px;">
                    	'.$coupon->title.'
                    </td>
                </tr>
            </table>
        </div>
        <div>
        	'.$coupon->terms.'
        </div>
    	<div id="main">
			<div style="font-size:15px;font-weight:bold;padding:0 0 15px 0;">Контакты</div>
            <div>
				'.$coupon->contacts.'
            </div>
			<div style="font-size:15px;font-weight:bold;padding:0 0 15px 0;">'.JText::_('Map').'</div>
            <div>
				'.$coupon->map.'
            </div>
		</div>
    </div>
</center>
</body>
</html>
			';
			return $result;
		}
		
		function getMailTemplate($message, $type=0){
			global $mainframe;
			
			$result = '<table cellpadding="5" cellspacing="0" width="100%" bgcolor="#CCCCCC">
				<tr>
					<td align="center">
						<table cellpadding="8" cellspacing="0" width="600px" style="text-align:left;background:#fff;">
							<tr>
								<td align="center" colspan="2"><img src="'.JURI::base().'/images/logo.jpg"/></td>
							</tr>
							<tr>
								<td>
									'.$message.'
								</td>
							</tr>
							<tr>
								<td height="50px" style="background:#000;color:#fff000;font:normal 12px Tahoma, Geneva, sans-serif;">'.JText::_('team site').' <a href="'.JURI::base().'" target="_blank" style="color:#fff000;">'.JText::_('Site name2').'</a></td>
							</tr>
						</table>
					</td>
				</tr>
				</table>';
$result .= '';
			return $result;
		}
		function metroList($value){
			$db 		=& JFactory::getDBO();

			$query = 'SELECT DISTINCT a.id AS value, a.title AS text'
				. ' FROM #__mos_metro AS a'
				. ' LEFT JOIN #__mos_metro_value AS b ON a.id=b.id_metro'
				. ' WHERE b.id_event <>0'
				. ' ORDER BY a.title'			
				;					
			$db->setQuery( $query );
			$rows = $db->loadObjectList();
			for($i=0;$i<count($rows);$i++){
				$row = $rows[$i];
				$options[$row->value] = $row->text;
			}
			if($value>0 && $options[$value]){
				$html = '<li><span class="icons-small ico-metro"></span><a href="#">'.$options[$value].'<em></em></a>';
				$html .= '<input type="hidden" id="option_metro" name="options[metro]" value="'.$value.'"/>';
				$html .= '<ul rel="metro">';
				$html .= '<li><a href="#" rel="">Метро</a></li>';
			}else{
				$html = '<li><span class="icons-small ico-metro"></span><a href="#">Метро<em></em></a>';
				$html .= '<input type="hidden" id="option_metro" name="options[metro]" value=""/>';
				$html .= '<ul rel="metro">';
			}
			
			
			
			foreach( $rows as $obj )
			{
				$html .= '<li><a href="#" rel="'.$obj->value.'">'.$obj->text.'</a></li>';
			}
			$html .= '</ul></li>';
			return $html;
		}
		function optionsList($values, $catid){
			$db 		=& JFactory::getDBO();

			$query = 'SELECT DISTINCT a.id, a.title, b.title AS cat, b.id AS catid'
				. ' FROM #__mos_option_list AS a'
				. ' LEFT JOIN #__mos_options AS b ON a.option_id=b.id'
				. ' LEFT JOIN #__mos_option_values AS c ON a.id = c.value_id'
				. ' LEFT JOIN #__mos_event AS f ON f.id = c.event_id'
				. ' WHERE b.catid='.(int)$catid.' AND c.event_id <>0 AND f.published=1'
				. ' ORDER BY b.id ASC, a.title ASC'			
				;			
			$db->setQuery( $query );
			$rows = $db->loadObjectList();
			$category = '';
			for($i=0;$i<count($rows);$i++){
				$row = $rows[$i];
				$options[$row->id] = $row->title;
			}
			
			for($i=0;$i<count($rows);$i++){
				$row = $rows[$i];
				if($category!=$row->cat){
					if($i!=0){$html .= '</ul></li>';}
					if($values[$row->catid]>0 && $options[$values[$row->catid]]){
						$html .= '<input type="hidden" id="option_'.$row->catid.'" name="options['.$row->catid.']" value="'.$values[$row->catid].'"/>';
						$html .= '<li><a href="#">'.$options[$values[$row->catid]].'<em></em></a><ul rel="'.$row->catid.'">';
						$html .= '<li><a href="#" rel="">'.$row->cat.'</a></li>';
					}else{
						$html .= '<input type="hidden" id="option_'.$row->catid.'" name="options['.$row->catid.']" value=""/>';
						$html .= '<li><a href="#">'.$row->cat.'<em></em></a><ul rel="'.$row->catid.'">';
					}
				}
				$html .= '<li><a href="#" rel="'.$row->id.'">'.$row->title.'</a></li>';
				$category=$row->cat;
			}
			$html .= '</ul></li>';
			return $html;
		}
	}
	
?>