<?php
jimport( 'joomla.filesystem.folder' );

function com_install() {

		$db			= &JFactory::getDBO();
		$dbPref 	= $db->getPrefix();
		$msgSQL 	= '';
		$msgFile	= '';
		$msgError	= '';
		//DELETE TABLE
		$query =' DROP TABLE IF EXISTS `'.$dbPref.'bsn_build`;';
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		$query =' DROP TABLE IF EXISTS `'.$dbPref.'bsn_cart`;';
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		$query =' DROP TABLE IF EXISTS `'.$dbPref.'bsn_clients`;';
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		$query =' DROP TABLE IF EXISTS `'.$dbPref.'bsn_image`;';
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		$query =' DROP TABLE IF EXISTS `'.$dbPref.'bsn_metro`;';
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		$query =' DROP TABLE IF EXISTS `'.$dbPref.'bsn_room`;';
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		$query =' DROP TABLE IF EXISTS `'.$dbPref.'bsn_target`;';
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		$query =' DROP TABLE IF EXISTS `'.$dbPref.'bsn_transaction`;';
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		$query =' DROP TABLE IF EXISTS `'.$dbPref.'bsn_type`;';
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		$query =' DROP TABLE IF EXISTS `'.$dbPref.'bsn_realtor`;';
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		$query =' DROP TABLE IF EXISTS `'.$dbPref.'bsn_plan`;';
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		
		//CREATE TABLE
		
		$query=' CREATE TABLE `'.$dbPref.'bsn_build` (';
  		$query.='`id` int(11) NOT NULL auto_increment,';
 	 	$query.='`id_metro` int(11) NOT NULL,';
  		$query.='`adress` varchar(255) NOT NULL,';
  		$query.='`needtime` int(11) NOT NULL,';
 		$query.=' `id_type` int(11) NOT NULL,';
  		$query.='`parking` int(1) NOT NULL,';
  		$query.='`floors` int(11) NOT NULL,';
  		$query.='`describe` text NOT NULL,';
  		$query.='PRIMARY KEY  (`id`),';
  		$query.='KEY `id_metro` (`id_metro`),';
  		$query.='KEY `id_type` (`id_type`)';
		$query.=') ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1';
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		$query='CREATE TABLE `'.$dbPref.'bsn_cart` (';
	  	$query.='`id` int(11) NOT NULL auto_increment,';
	  	$query.='`id_client` int(11) NOT NULL,';
	  	$query.='`id_room` int(11) NOT NULL,';
	  	$query.='PRIMARY KEY  (`id`)';
		$query.=') ENGINE=MyISAM 
		 DEFAULT CHARSET=utf8 AUTO_INCREMENT=1';
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		$query='CREATE TABLE `'.$dbPref.'bsn_clients` (';
  		$query.='`id` int(11) NOT NULL auto_increment,';
  		$query.='`date` date NOT NULL,';
  		$query.='PRIMARY KEY  (`id`)';
		$query.=') ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1';
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		$query='CREATE TABLE `'.$dbPref.'bsn_image` (';
  		$query.='`id` int(11) NOT NULL auto_increment,';
  		$query.='`type` int(1) NOT NULL,';
  		$query.='`id_parent` int(11) NOT NULL,';
 		$query.='`image` varchar(255) NOT NULL,';
  		$query.='`ordering` int(11) NOT NULL,';
  		$query.='PRIMARY KEY  (`id`)';
		$query.=') ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1';
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		$query='CREATE TABLE `'.$dbPref.'bsn_realtor` (';
  		$query.='`id` int(11) NOT NULL auto_increment,';
  		$query.='`name` varchar(255) NOT NULL,';
  		$query.='PRIMARY KEY  (`id`)';
		$query.=') ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1';
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		$query='CREATE TABLE `'.$dbPref.'bsn_plan` (';
  		$query.='`id` int(11) NOT NULL auto_increment,';
  		$query.='`title` varchar(255) NOT NULL,';
  		$query.='PRIMARY KEY  (`id`)';
		$query.=') ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1';
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		$query='CREATE TABLE `'.$dbPref.'bsn_metro` (';
  		$query.='`id` int(11) NOT NULL auto_increment,';
  		$query.='`title` varchar(255) NOT NULL,';
  		$query.='PRIMARY KEY  (`id`)';
		$query.=') ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1';
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}

		$query="INSERT INTO `".$dbPref."bsn_metro` (`id`, `title`) VALUES";
		$query.="(1, 'Авиамоторная'),";
		$query.="(2, 'Автозаводская'),";
		$query.="(3, 'Академическая'),";
		$query.="(4, 'Библиотека им. Ленина, Боровицкая, Арбатская, Александровский сад'),";
		$query.="(5, 'Алексеевская'),";
		$query.="(6, 'Алтуфьево'),";
		$query.="(7, 'Аннино'),";
		$query.="(8, 'Аэропорт'),";
		$query.="(9, 'Бабушкинская'),";
		$query.="(10, 'Багратионовская'),";
		$query.="(11, 'Баррикадная, Краснопресненская'),";
		$query.="(12, 'Бауманская'),";
		$query.="(13, 'Беговая'),";
		$query.="(14, 'Белорусская'),";
		$query.="(15, 'Беляево'),";
		$query.="(16, 'Бибирево'),";
		$query.="(17, 'Новоясеневская'),";
		$query.="(18, 'Ботанический сад'),";
		$query.="(19, 'Братиславская'),";
		$query.="(20, 'Бульвар Адмирала Ушакова'),";
		$query.="(21, 'Бульвар Дмитрия Донского, Ул. Старокачаловская'),";
		$query.="(22, 'Бунинская аллея'),";
		$query.="(23, 'Варшавская'),";
		$query.="(24, 'ВДНХ'),";
		$query.="(25, 'Владыкино'),";
		$query.="(26, 'Водный стадион'),";
		$query.="(27, 'Войковская'),";
		$query.="(28, 'Волгоградский проспект'),";
		$query.="(29, 'Волжская'),";
		$query.="(30, 'Воробьевы горы'),";
		$query.="(31, 'Марьина роща'),";
		$query.="(32, 'Выхино'),";
		$query.="(33, 'Динамо'),";
		$query.="(34, 'Дмитровская'),";
		$query.="(35, 'Добрынинская, Серпуховская'),";
		$query.="(36, 'Домодедовская'),";
		$query.="(37, 'Дубровка'),";
		$query.="(38, 'Измайловская'),";
		$query.="(39, 'Партизанская'),";
		$query.="(40, 'Калужская'),";
		$query.="(41, 'Кантемировская'),";
		$query.="(42, 'Каховская, Севастопольская'),";
		$query.="(43, 'Каширская'),";
		$query.="(44, 'Киевская'),";
		$query.="(45, 'Китай-город'),";
		$query.="(46, 'Кожуховская'),";
		$query.="(47, 'Коломенская'),";
		$query.="(48, 'Комсомольская'),";
		$query.="(49, 'Коньково'),";
		$query.="(50, 'Красногвардейская'),";
		$query.="(51, 'Красносельская'),";
		$query.="(52, 'Красные ворота'),";
		$query.="(53, 'Крестьянская застава, Пролетарская'),";
		$query.="(54, 'Кропоткинская'),";
		$query.="(55, 'Крылатское'),";
		$query.="(56, 'Кузнецкий мост, Лубянка'),";
		$query.="(57, 'Кузьминки'),";
		$query.="(58, 'Кунцевская'),";
		$query.="(59, 'Курская, Чкаловская'),";
		$query.="(60, 'Кутузовская'),";
		$query.="(61, 'Ленинский проспект'),";
		$query.="(62, 'Люблино'),";
		$query.="(63, 'Марксистская, Таганская'),";
		$query.="(64, 'Марьино'),";
		$query.="(65, 'Маяковская'),";
		$query.="(66, 'Медведково'),";
		$query.="(67, 'Менделеевская, Новослободская'),";
		$query.="(68, 'Молодежная'),";
		$query.="(69, 'Нагатинская'),";
		$query.="(70, 'Нагорная'),";
		$query.="(71, 'Нахимовский проспект'),";
		$query.="(72, 'Новогиреево'),";
		$query.="(73, 'Новокузнецкая, Третьяковская'),";
		$query.="(74, 'Новые Черемушки'),";
		$query.="(75, 'Октябрьская'),";
		$query.="(76, 'Октябрьское поле'),";
		$query.="(77, 'Орехово'),";
		$query.="(78, 'Отрадное'),";
		$query.="(79, 'Площадь Революции, Театральная,Охотный ряд'),";
		$query.="(80, 'Павелецкая'),";
		$query.="(81, 'Парк Культуры'),";
		$query.="(82, 'Парк Победы'),";
		$query.="(83, 'Первомайская'),";
		$query.="(84, 'Перово'),";
		$query.="(85, 'Петровско-Разумовская'),";
		$query.="(86, 'Печатники'),";
		$query.="(87, 'Пионерская'),";
		$query.="(88, 'Планерная'),";
		$query.="(89, 'Площадь Ильича, Римская'),";
		$query.="(90, 'Полежаевская'),";
		$query.="(91, 'Полянка'),";
		$query.="(92, 'Пражская'),";
		$query.="(93, 'Преображенская площадь'),";
		$query.="(94, 'Проспект Вернадского'),";
		$query.="(95, 'Проспект Мира'),";
		$query.="(96, 'Профсоюзная'),";
		$query.="(97, 'Тверская, Чеховская, Пушкинская'),";
		$query.="(98, 'Речной вокзал'),";
		$query.="(99, 'Рижская'),";
		$query.="(100, 'Рязанский проспект'),";
		$query.="(101, 'Савеловская'),";
		$query.="(102, 'Свиблово'),";
		$query.="(103, 'Семеновская'),";
		$query.="(104, 'Смоленская'),";
		$query.="(105, 'Сокол'),";
		$query.="(106, 'Сокольники'),";
		$query.="(107, 'Спортивная'),";
		$query.="(108, 'Студенческая'),";
		$query.="(109, 'Сухаревская'),";
		$query.="(110, 'Сходненская'),";
		$query.="(111, 'Текстильщики'),";
		$query.="(112, 'Славянский бульвар'),";
		$query.="(113, 'Теплый стан'),";
		$query.="(114, 'Тимирязевская'),";
		$query.="(115, 'Тульская'),";
		$query.="(116, 'Тургеневская, Чистые пруды, Сретенский бульвар'),";
		$query.="(117, 'Тушинская'),";
		$query.="(118, 'Ул. 1905 года'),";
		$query.="(119, 'Международная'),";
		$query.="(120, 'Ул. Академика Янгеля'),";
		$query.="(121, 'Ул. Горчакова'),";
		$query.="(122, 'Выставочная'),";
		$query.="(123, 'Ул. Подбельского'),";
		$query.="(124, 'Ул. Скобелевская'),";
		$query.="(125, 'Университет'),";
		$query.="(126, 'Филевский парк'),";
		$query.="(127, 'Фили'),";
		$query.="(128, 'Фрунзенская'),";
		$query.="(129, 'Царицыно'),";
		$query.="(130, 'Трубная, Цветной бульвар'),";
		$query.="(131, 'Черкизовская'),";
		$query.="(132, 'Чертановская'),";
		$query.="(133, 'Шаболовская'),";
		$query.="(134, 'Шоссе Энтузиастов'),";
		$query.="(135, 'Щелковская'),";
		$query.="(136, 'Щукинская'),";
		$query.="(137, 'Электрозаводская'),";
		$query.="(138, 'Юго-Западная'),";
		$query.="(139, 'Южная'),";
		$query.="(140, 'Ясенево'),";
		$query.="(143, 'Братеево'),";
		$query.="(146, 'Останкино'),";
		$query.="(147, 'Достоевская'),";
		$query.="(148, 'Жулебино (р-н)'),";
		$query.="(152, 'Новокосино'),";
		$query.="(156, 'Строгино'),";
		$query.="(151, 'Мякинино, Волоколамская, Митино')";
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		$query='CREATE TABLE `'.$dbPref.'bsn_room` (';
	  	$query.='`id` int(11) NOT NULL auto_increment,';
	  	$query.='`id_build` int(11) NOT NULL,';
	  	$query.='`id_target` int(11) NOT NULL,';
	 	$query.='`id_transaction` int(11) NOT NULL,';
		$query.='`id_realtor` int(11) NOT NULL,';
	  	$query.='`service` varchar(255) NOT NULL,';
	  	$query.='`floor` int(3) NOT NULL,';
	  	$query.='`price` int(11) NOT NULL,';
	  	$query.='`area` int(11) NOT NULL,';
		$query.='`maxarea` int(11) NOT NULL,';
	  	$query.='`id_plan` int(255) NOT NULL,';
	 	$query.='`internet` int(1) NOT NULL,';
	 	$query.='`protection` int(1) NOT NULL,';
	 	$query.='`commission` int(1) NOT NULL,';
	  	$query.='`describe` text NOT NULL,';
	  	$query.='`date_created` date NOT NULL,';
	 	$query.='PRIMARY KEY  (`id`),';
	  	$query.='KEY `id_build` (`id_build`),';
	  	$query.='KEY `id_target` (`id_target`),';
		$query.='KEY `id_plan` (`id_plan`),';
	  	$query.='KEY `id_transaction` (`id_transaction`),';
		$query.='KEY `id_realtor` (`id_realtor`)';
		$query.=') ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1';
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}

		$query='CREATE TABLE `'.$dbPref.'bsn_target` (';
  		$query.='`id` int(11) NOT NULL auto_increment,';
  		$query.='`title` varchar(255) NOT NULL,';
 		$query.=' PRIMARY KEY  (`id`)';
		$query.=') ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1';
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		$query='CREATE TABLE `'.$dbPref.'bsn_transaction` (';
  		$query.='`id` int(11) NOT NULL auto_increment,';
  		$query.='`title` varchar(255) NOT NULL,';
  		$query.='PRIMARY KEY  (`id`)';
		$query.=') ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1';
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		$query='CREATE TABLE `'.$dbPref.'bsn_type` (';
  		$query.='`id` int(11) NOT NULL auto_increment,';
  		$query.='`title` varchar(255) NOT NULL,';
  		$query.='PRIMARY KEY  (`id`)';
		$query.=') ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1';
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		if ($msgSQL !='') {
			$msgError .= '<br />' . $msgSQL;
		}
		if ($msgError !='') {
			$msg = JText::_( 'Not successfully installed' ) . ': ' . $msgError;
		} else {
			$msg = JText::_( 'Successfully installed' );
		}
		
		$link = 'index.php?option=com_build';
		//$this->setRedirect($link, $msg);
}
?>