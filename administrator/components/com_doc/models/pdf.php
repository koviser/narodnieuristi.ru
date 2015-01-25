<?php

defined('_JEXEC') or die;

jimport('joomla.application.component.model');


class ModelPdf extends JModel
{
	function getBill()
	{
		global $mainframe;
		$db = & JFactory::getDBO();
		$post = JRequest::get( 'post' );
		
		jimport( 'tcpdf.tcpdf' );
		jimport( 'names.names' );
		
		$client	= &new JClient($db);
		$client->load($post['id']);
		
		$roo	= &new JRoo($db);
		$roo->load($client->id_roo);
		
		$date=strtotime($roo->doc_date);
		
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Народные юристы');
			$pdf->SetTitle('Счет на оплату');
			$pdf->SetSubject('Счет на оплату');
			//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
			
			$pdf->setPrintHeader(false);
			$pdf->setPrintFooter(false);
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			$pdf->setLanguageArray($l);
			$pdf->SetFont('freesans', '', 8);
			$pdf->AddPage();
			$html = '
			<p align="center"><strong>Образец заполнения платежного поручения</strong></p>
			<table cellpadding="5" cellspacing="0" border="0" width="100%">
				<tr>
					<td colspan="2" width="60%" style="border-top:1px #000 solid;border-left:1px #000 solid;">ООО КБ "МЕГАПОЛИС" Г.ЧЕБОКСАРЫ</td>
					<td width="20%" style="border-top:1px #000 solid;border-left:1px #000 solid;border-bottom:1px #000 solid;">БИK</td>
					<td width="20%" style="border-top:1px #000 solid;border-left:1px #000 solid;border-right:1px #000 solid;">049706723</td>
				</tr>
				<tr>
					<td colspan="2" style="border-bottom:1px #000 solid;border-left:1px #000 solid;"><small>Банк получателя</small></td>
					<td style="border-bottom:1px #000 solid;border-left:1px #000 solid;">Сч. №</td>
					<td style="border-bottom:1px #000 solid;border-left:1px #000 solid;border-right:1px #000 solid;">30101810600000000723</td>
				</tr>
				<tr>
					<td width="30%" style="border-top:1px #000 solid;border-left:1px #000 solid;">ИНН 2130091429</td>
					<td width="30%" style="border-top:1px #000 solid;border-left:1px #000 solid;">КПП 213001001</td>
					<td rowspan="2" style="border-top:1px #000 solid;border-left:1px #000 solid;border-bottom:1px #000 solid;">Сч. №</td>
					<td rowspan="2" style="border-top:1px #000 solid;border-left:1px #000 solid;border-bottom:1px #000 solid;border-right:1px #000 solid;">40702810100000006892</td>
				</tr>
				<tr>
					<td colspan="2" style="border-top:1px #000 solid;border-left:1px #000 solid;border-bottom:1px #000 solid;">ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "СОБЫТИЕ"<br/>Получатель</td>
				</tr>
			</table>
			<p><h2>Счет № '.$client->id.'-'.mb_strtoupper(mb_substr($roo->title, 0, 2,"utf8"),"utf8").' от '.date('d').'.'.date('m').'.'.date('Y').'</h2></p>
			<hr/>
			<table cellpadding="5" cellspacing="0" border="0" width="100%">
				<tr>
					<td width="15%">Исполнитель:</td>
					<td width="85%"><strong>ООО "СОБЫТИЕ"</strong></td>
				</tr>
				<tr>
					<td>Заказчик:</td>
					<td>'.$roo->intro_title.'</td>
				</tr>
			</table>
			<br/>
			<table cellpadding="5" cellspacing="0" border="1" width="100%">
				<tr>
					      
					<td width="10%" align="center"><strong>№</strong></td>
					<td width="15%" align="center"><strong>Код</strong></td>
					<td width="35%" align="center"><strong>Товар</strong></td>
					<td width="10%" align="center"><strong>Кол-во</strong></td>
					<td width="10%" align="center"><strong>Ед.</strong></td>
					<td width="10%" align="center"><strong>Цена</strong></td>
					<td width="10%" align="center"><strong>Сумма</strong></td>
				</tr>
				<tr>
					<td align="center">1</td>
					<td align="center"></td>
					<td>Оказание юридических услуг по Договору № '.$roo->doc_number.' от '.date('d', $date).'.'.date('m', $date).'.'.date('Y', $date).'г., заявка № '.$client->id.'</td>
					<td align="center">1</td>
					<td align="center">шт.</td>
					<td align="right">'.number_format($client->price, 2, '.', '').'</td>
					<td align="right">'.number_format($client->price, 2, '.', '').'</td>
				</tr>
			</table>
			<table cellpadding="5" cellspacing="0" border="0" width="100%">
				<tr>
					      
					<td width="80%"> </td>
					<td width="10%" align="right"><strong>Итого:</strong></td>
					<td width="10%" align="right"><strong>'.number_format($client->price, 2, '.', '').'</strong></td>
				</tr>
			</table>
			<p>Всего наименований 1 на сумму '.number_format($client->price, 2, '.', '').' '.$this->morph($client->price, 'рубль', 'рубля', 'рублей').'</p>
			<p>'.$this->num2str($client->price).'</p>
			<hr/>
			<p> </p>
			<p>Руководитель ______________________ (Терехов А.Н.)</p>
			<p>Главный бухгалтер ______________________ (Скворцова О.Н.)</p>
			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;М.П.</p>
			<p> </p>
			<hr/>
			';

			
			$name = $client->id.'-'.time().'.pdf';
			
			$pdf->writeHTML($html, true, false, true, false, '');
			$pdf->lastPage();
			$pdf->Output('pdf/'.$name, 'F');
			
			$fromname = $mainframe->getCfg('fromname');
			$mailfrom = $mainframe->getCfg('mailfrom');
			
			$message = 'Скачать счет можно <a href="'.JURI::base().'pdf/'.$name.'">здесь</a>';
			
			//JUtility::sendMail($mailfrom, $fromname, 'ovevil@gmail.com', 'Новый счет', $message, 1);
			JUtility::sendMail($mailfrom, $fromname, 'ooosobytie@yandex.ru', 'Новый счет', $message, 1);
			
			$mainframe->Redirect('pdf/'.$name);
			
			exit;
	}
	function num2str($num) {
		$nul='ноль';
		$ten=array(
			array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
			array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
		);
		$a20=array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
		$tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
		$hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
		$unit=array( // Units
			array('копейка' ,'копейки' ,'копеек',	 1),
			array('рубль'   ,'рубля'   ,'рублей'    ,0),
			array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
			array('миллион' ,'миллиона','миллионов' ,0),
			array('миллиард','милиарда','миллиардов',0),
		);
		//
		list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
		$out = array();
		if (intval($rub)>0) {
			foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
				if (!intval($v)) continue;
				$uk = sizeof($unit)-$uk-1; // unit key
				$gender = $unit[$uk][3];
				list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
				// mega-logic
				$out[] = $hundred[$i1]; # 1xx-9xx
				if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
				else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
				// units without rub & kop
				if ($uk>1) $out[]= $this->morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
			} //foreach
		}
		else $out[] = $nul;
		$out[] = $this-> morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
		$out[] = $kop.' '.$this->morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
		return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
	}
	
	/**
	 * Склоняем словоформу
	 * @ author runcore
	 */
	function morph($n, $f1, $f2, $f5) {
		$n = abs(intval($n)) % 100;
		if ($n>10 && $n<20) return $f5;
		$n = $n % 10;
		if ($n>1 && $n<5) return $f2;
		if ($n==1) return $f1;
		return $f5;
	}
}//class
?>