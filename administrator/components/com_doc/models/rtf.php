<?php

defined('_JEXEC') or die;

jimport('joomla.application.component.model');


class ModelRTF extends JModel
{
	function getDoc($file_name)
	{
		global $mainframe;
		$db = & JFactory::getDBO();
		$post = JRequest::get( 'post' );
		
		jimport( 'names.names' );
		// Получение всех входных данных
		$client	= &new JClient($db);
		$client->load($post['id']);
		
		$roo	= &new JRoo($db);
		$roo->load($client->id_roo);
		
		$type	= &new JType($db);
		$type->load($client->id_type);
		
		// Формирование списка данных
		$data['ROO_CITY'] = iconv('utf-8', 'windows-1251' , $roo->title); //город  РОО
		$data['DATE_TODAY'] = iconv('utf-8', 'windows-1251' , '"'.date('d').'" '.JText::_('MONTH_'.date('m')).' '.date('Y').' г.'); //текущая дата
		$data['ROO_FULL_TITLE'] = iconv('utf-8', 'windows-1251' , $roo->full_title); //полное название РОО
		$data['ROO_TITLE'] = iconv('utf-8', 'windows-1251' , $roo->intro_title); //название РОО
		//доверенное лицов родительном падеже
		$signature = new RussianNameProcessor(iconv('utf-8', 'windows-1251', $roo->signature));
		$data['SIGNATURE_NAME'] = $signature->fullName($signature->gcaseRod); 
		//доверенное лицов сокращеное
		$name = explode(' ', $roo->signature);
		$small_name = $name[0].' '.mb_substr($name[1],0,1,"UTF-8").'. '.mb_substr($name[2],0,1,"UTF-8").'.';
		$data['SIGNATURE_NAME_SMALL'] = iconv('utf-8', 'windows-1251', $small_name);
		 
		$data['PROCUTAION'] = iconv('utf-8', 'windows-1251', $roo->date_procuratory); //Доверенность
		$data['DOC_ROO_NUMBER'] = iconv('utf-8', 'windows-1251', $roo->doc_number); //Номер договора с РОО
		//Дата заключения договора
		$strtotime=strtotime($roo->doc_date);
		$date = iconv('utf-8', 'windows-1251' , '"'.date('d', $strtotime).'" '.JText::_('MONTH_'.date('m', $strtotime)).' '.date('Y', $strtotime).' г.');
		$data['DATE_DOC_ROO'] = $date;
		
		$data['AP_NUMBER'] = $client->id.'-'.iconv('utf-8', 'windows-1251',mb_strtoupper(mb_substr($roo->title, 0, 2,"utf8"),"utf8")); //Номер заявки
		//Дата заявки
		$strtotime=strtotime($client->date_admission);
		$date = iconv('utf-8', 'windows-1251' , '"'.date('d', $strtotime).'" '.JText::_('MONTH_'.date('m', $strtotime)).' '.date('Y', $strtotime).' г.');
		$data['AP_DATE'] = $date;
		//Список документов
		$docs=explode("\n", $client->docs);
		if(count($docs)){
			for($i=0;$i<count($docs);$i++){
				$newdoc .= ($i+1).'. '.$docs[$i].'\line ';
			}
		}
		$data['DOCS_LIST'] = iconv('utf-8', 'windows-1251' , $newdoc ); 
		
		//Список документов передоваемых по акту
		$adocs=explode("\n", $client->adocs);
		if(count($adocs)){
			for($i=0;$i<count($adocs);$i++){
				$anewdoc .= ($i+1).'. '.$adocs[$i].'\line ';
			}
		}
		$data['AKT_DOCS_LIST'] = iconv('utf-8', 'windows-1251' , $naewdoc ); 
		//Список документов в таблице
		$table='
			{\rtlch\fcs1 \af0\afs18 \ltrch\fcs0 \fs18\lang1033\langfe1049\langnp1033\insrsid8460730\charrsid8003941 
			\par \par \ltrrow}
			\trowd \irow0\irowband0\ltrrow\ts11\trgaph108\trrh739\trleft-108\trbrdrt\brdrs\brdrw10 \trbrdrl\brdrs\brdrw10 \trbrdrb\brdrs\brdrw10 \trbrdrr\brdrs\brdrw10 \trbrdrh\brdrs\brdrw10 \trbrdrv\brdrs\brdrw10 \trftsWidth3\trwWidth10699\trftsWidthB3\trftsWidthA3\trautofit1\trpaddl108\trpaddr108\trpaddfl3\trpaddft3\trpaddfb3\trpaddfr3\tblrsid15088294\tbllkhdrrows\tbllklastrow\tbllkhdrcols\tbllklastcol\tblind0\tblindtype3 \clvertalc\clbrdrt\brdrs\brdrw10 \clbrdrl
			\brdrs\brdrw10 \clbrdrb\brdrs\brdrw10 \clbrdrr\brdrs\brdrw10 \cltxlrtb\clftsWidth3\clwWidth746\clshdrawnil \cellx638\clvertalc\clbrdrt\brdrs\brdrw10 \clbrdrl\brdrs\brdrw10 \clbrdrb\brdrs\brdrw10 \clbrdrr\brdrs\brdrw10 
			\cltxlrtb\clftsWidth3\clwWidth9953\clshdrawnil \cellx10591\pard \ltrpar\qc \li0\ri0\widctlpar\intbl\wrapdefault\aspalpha\aspnum\faauto\adjustright\rin0\lin0\pararsid15088294 
			{\rtlch\fcs1 \af0 \ltrch\fcs0 \b\insrsid15088294 № п}
			{\rtlch\fcs1 \af0 \ltrch\fcs0 \b\lang1033\langfe1049\langnp1033\insrsid15088294 /}
			{\rtlch\fcs1 \af0 \ltrch\fcs0 \b\insrsid15088294 п}
			{\rtlch\fcs1 \af0 \ltrch\fcs0 \b\lang1033\langfe1049\langnp1033\insrsid8460730\charrsid8003941 \cell }
			{\rtlch\fcs1 \af0 \ltrch\fcs0 \b\insrsid15088294 Наименование документа}
			{\rtlch\fcs1 \af0 \ltrch\fcs0 \b\lang1033\langfe1049\langnp1033\insrsid8460730\charrsid8003941 \cell }
			\pard \ltrpar\ql \li0\ri0\sa200\sl276\slmult1
			\widctlpar\intbl\wrapdefault\aspalpha\aspnum\faauto\adjustright\rin0\lin0 
			
			{\rtlch\fcs1 \af0 \ltrch\fcs0 \b\lang1033\langfe1049\langnp1033\insrsid8460730\charrsid8003941 \trowd \irow0\irowband0\ltrrow\ts11\trgaph108\trrh739\trleft-108\trbrdrt
			\brdrs\brdrw10 \trbrdrl\brdrs\brdrw10 \trbrdrb\brdrs\brdrw10 \trbrdrr\brdrs\brdrw10 \trbrdrh\brdrs\brdrw10 \trbrdrv\brdrs\brdrw10 
			\trftsWidth3\trwWidth10699\trftsWidthB3\trftsWidthA3\trautofit1\trpaddl108\trpaddr108\trpaddfl3\trpaddft3\trpaddfb3\trpaddfr3\tblrsid15088294\tbllkhdrrows\tbllklastrow\tbllkhdrcols\tbllklastcol\tblind0\tblindtype3 \clvertalc\clbrdrt\brdrs\brdrw10 \clbrdrl
			\brdrs\brdrw10 \clbrdrb\brdrs\brdrw10 \clbrdrr\brdrs\brdrw10 \cltxlrtb\clftsWidth3\clwWidth746\clshdrawnil \cellx638\clvertalc\clbrdrt\brdrs\brdrw10 \clbrdrl\brdrs\brdrw10 \clbrdrb\brdrs\brdrw10 \clbrdrr\brdrs\brdrw10 
			\cltxlrtb\clftsWidth3\clwWidth9953\clshdrawnil \cellx10591\row \ltrrow}';
			$docs=explode("\n", $client->docs);
			for($i=0;$i<count($docs);$i++){
				$table.='
			\trowd \irow1\irowband1\lastrow \ltrrow\ts11\trgaph108\trrh428\trleft-108\trbrdrt\brdrs\brdrw10 \trbrdrl\brdrs\brdrw10 \trbrdrb\brdrs\brdrw10 \trbrdrr\brdrs\brdrw10 \trbrdrh
			\brdrs\brdrw10 \trbrdrv\brdrs\brdrw10 \trftsWidth3\trwWidth10699\trftsWidthB3\trftsWidthA3\trautofit1\trpaddl108\trpaddr108\trpaddfl3\trpaddft3\trpaddfb3\trpaddfr3\tblrsid15088294\tbllkhdrrows\tbllklastrow\tbllkhdrcols\tbllklastcol\tblind0\tblindtype3 
			\clvertalc\clbrdrt\brdrs\brdrw10 \clbrdrl\brdrs\brdrw10 \clbrdrb\brdrs\brdrw10 \clbrdrr\brdrs\brdrw10 \cltxlrtb\clftsWidth3\clwWidth746\clshdrawnil \cellx638\clvertalc\clbrdrt\brdrs\brdrw10 \clbrdrl\brdrs\brdrw10 \clbrdrb\brdrs\brdrw10 \clbrdrr
			\brdrs\brdrw10 \cltxlrtb\clftsWidth3\clwWidth9953\clshdrawnil \cellx10591\pard \ltrpar\qc \li0\ri0\widctlpar\intbl\wrapdefault\aspalpha\aspnum\faauto\adjustright\rin0\lin0\pararsid15088294
			
			{\rtlch\fcs1 \af0 \ltrch\fcs0 \lang1033\langfe1049\langnp1033\insrsid7831032\charrsid15088294 '.($i+1).'}
			{\rtlch\fcs1 \af0 \ltrch\fcs0 \lang1033\langfe1049\langnp1033\insrsid8460730\charrsid15088294 \cell }
			\pard \ltrpar \ql \li0\ri0\widctlpar\intbl\wrapdefault\aspalpha\aspnum\faauto\adjustright\rin0\lin0\pararsid10255866
			{\rtlch\fcs1 \af0 \ltrch\fcs0 \lang1033\langfe1049\langnp1033\insrsid7831032\charrsid15088294 '.$docs[$i].'}
			{\rtlch\fcs1 \af0 \ltrch\fcs0 \lang1033\langfe1049\langnp1033\insrsid8460730\charrsid15088294 \cell }
			\pard \ltrpar\ql \li0\ri0\sa200\sl276\slmult1\widctlpar\intbl\wrapdefault\aspalpha\aspnum\faauto\adjustright\rin0\lin0
			
			{\rtlch\fcs1 \af0 \ltrch\fcs0 \lang1033\langfe1049\langnp1033\insrsid8460730\charrsid8003941 \trowd \irow1\irowband1\lastrow \ltrrow\ts11\trgaph108\trrh428\trleft-108\trbrdrt\brdrs\brdrw10 \trbrdrl\brdrs\brdrw10 \trbrdrb\brdrs\brdrw10 \trbrdrr\brdrs\brdrw10 \trbrdrh\brdrs\brdrw10 
			\trbrdrv\brdrs\brdrw10 \trftsWidth3\trwWidth10699\trftsWidthB3\trftsWidthA3\trautofit1\trpaddl108\trpaddr108\trpaddfl3\trpaddft3\trpaddfb3\trpaddfr3\tblrsid15088294\tbllkhdrrows\tbllklastrow\tbllkhdrcols\tbllklastcol\tblind0\tblindtype3 \clvertalc\clbrdrt
			\brdrs\brdrw10 \clbrdrl\brdrs\brdrw10 \clbrdrb\brdrs\brdrw10 \clbrdrr\brdrs\brdrw10 \cltxlrtb\clftsWidth3\clwWidth746\clshdrawnil \cellx638\clvertalc\clbrdrt\brdrs\brdrw10 \clbrdrl\brdrs\brdrw10 \clbrdrb\brdrs\brdrw10 \clbrdrr\brdrs\brdrw10 
			\cltxlrtb\clftsWidth3\clwWidth9953\clshdrawnil \cellx10591\row }';
			}
			$table.='\pard \ltrpar\ql \li0\ri0\widctlpar\wrapdefault\aspalpha\aspnum\faauto\adjustright\rin0\lin0\itap0\pararsid8460730';
		$data['DOCS_TABLE_LIST'] = iconv('utf-8', 'windows-1251' , $table ); 
		//Общая сумма услуг
		$price = $client->price.' '.$this->morph($client->price, 'рубль', 'рубля', 'рублей').' ( '.$this->num2str($client->price).' ) ';
		$data['TOTAL_PRICE'] = iconv('utf-8', 'windows-1251' , $price ); 
		//Список услуг
		$list =  unserialize($client->service);
		for($i=1;$i<7;$i++){
			if($list[$i]==1){
				$j++;
				$servses .= $j.'. '.JText::_('SERVICE_'.$i).'\line ';
			}
		}
		$data['SERVICE'] = iconv('utf-8', 'windows-1251' , $servses );
		//Директор РОО в родительном падеже
		$director = new RussianNameProcessor(iconv('utf-8', 'windows-1251', $roo->director));
		$data['ROO_DIRECTOR'] = $director->fullName($director->gcaseRod);
		//адрес РОО
		$data['ROO ADRESS'] = iconv('utf-8', 'windows-1251', $roo->full_adress); 
		//имя заявителя в родительном падеже
		$client_name = $client->client_name;
		$client_n = new RussianNameProcessor(iconv('utf-8', 'windows-1251', $client->client_name));
		$data['CLIENT_NAME'] = $client_n->fullName($client_n->gcaseRod);
		//имя заявителя в именительном падеже
		$data['CLIENT_NAME_IM'] = iconv('utf-8', 'windows-1251', $client_name);
		//сокращеннок имя клиента 
		$name = explode(' ', $client_name);
		$small_name = $name[0].' '.mb_substr($name[1],0,1,"UTF-8").'. '.mb_substr($name[2],0,1,"UTF-8").'.'; 
		$data['CLIENT_NAME_SMALL'] = iconv('utf-8', 'windows-1251', $small_name);
		//данные паспорта клиента
		$passport = $client->client_passport.' выдан '.$client->client_issued;
		$data['CLIENT_PASSPORT'] = iconv('utf-8', 'windows-1251', $passport);
		
		$data['CLIENT_ADRESS'] = iconv('utf-8', 'windows-1251', $client->client_registration); //адрес клиента
		$data['CLIENT_PHONE'] = iconv('utf-8', 'windows-1251', $client->client_phone); //телефон клиента
		$data['DATE_DOC'] = iconv('utf-8', 'windows-1251', '#из какого поля брать дату?#'); //дата заключения договора с ответчиком
		$data['DEFENDANT'] = iconv('utf-8', 'windows-1251', $client->defendant); //ответчик
		$data['NUMBER_DOC'] = iconv('utf-8', 'windows-1251', '#где взять этот номер?#'); //номер договора с ответчиком
		//Дата заключения договора
		$strtotime=strtotime($client->date_admission);
		$date = iconv('utf-8', 'windows-1251' , '"'.date('d', $strtotime).'" '.JText::_('MONTH_'.date('m', $strtotime)).' '.date('Y', $strtotime).' г.');
		$data['DOGOVOR_DATE'] = $date;
		
		$data['DOGOVOR_NUMBER'] = iconv('utf-8', 'windows-1251', $client->number); //Номер заключенного договора
		
		// Загрузка шаблона документа
		$rtf = new RTF_Template($file_name);
		//print_r($rtf);
		//exit;
		// Подстановка данных в шаблон
		foreach($data as $key=>$value){
			$rtf->parse($key, $value);
		}
		// Выгрузка документа
		echo $rtf->out_h(time().'.rtf'); //вывод в текущий viewport
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
}
?>
<?php
class RTF_Template{

    private $content;

    public function __construct($filename){
        $this->content = file_get_contents($filename);
    }//construct

    public function parse($block_name, $value, $start_tag = '\{', $end_tag = '\}'){
       $this->content = str_ireplace($start_tag.$block_name.$end_tag, $value, $this->content);
    }//

    public function out_f($filename){
        file_put_contents($filename, $this->content);
    }//

    public function out_h($filename){
        ob_clean();
        header("Content-type: plaintext/rtf");
        header("Content-Disposition: attachment; filename=$filename");
        echo $this->content;
    }//

    public function out(){
        return $this->content;
    }//
}//class
?>