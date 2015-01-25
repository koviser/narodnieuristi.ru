<?php
defined('_JEXEC') or die('Restricted access');

class JClient extends JTable
{
	var $id	= null; //
	var $number = null; // № договора
	var $id_type  = null; // Тип заявления
	var $id_category  = null; // Тип заявления
	var $id_roo  = null; // 
	var $client_name	= null; // ФИО клиента
	var $client_registration	= null; // Регистрация клиента
	var $client_phone	= null; // Номер телефона клиента
	var $client_passport	= null; // Номер и серия паспорта клиента
	var $client_issued	= null; // Кем выдан паспорт клиента
	var $client_bithday	= null; // Дата рождения клиента
	var $date_contract	= null; // Дата договора
	var $date_admission	= null; // Дата приема
	var $date_filing	= null; // Дата подачи претензии
	var $date_response	= null; // Дата получения ответа на претензию от организации  	 	  	
 	var $date_filling_court = null; // Дата подачи искового заявления в суд
	var $date_court = null; // Дата назначения суда
	var $date_pending_cases = null; // Дата Отметка об отложенных делах в суде
	var $date_first_instance = null; // Дата Решения суда 1-ой инстанции
	var $date_receipt_writ = null; // Дата получения исполнительного листа	
	var $date_filing_writ = null; // Дата подачи исполнительного листа  
	var $date_filing_appeal = null; // Дата подачи Информация о подаче апелляционной жалобы
	var $date_receipt_appeal = null; // Дата получения подачи Информация о подаче апелляционной жалобы	 	 	 	 	 	 	 	 
 	var $date_case = null; // Дата рассмотрения дела в суде апелляционного слушания 	 
	var $date_filing_cassation = null; // Дата подачи Информация о подаче кассационной жалобы	 
 	var $date_receipt_cassation = null; // Дата получения Информация о подаче кассационной жалобы 	
 	var $date_case_appeal = null; // Дата рассмотрения дела в кассационной инстанции	 	 	 
 	var $id_consultant = null; // Ф.И.О. сотрудника, проконсультировавшего клиента и принявшего у него документы
	var $id_wrote_complaint = null; // Ф.И.О. сотрудника, написавшего претензию	 
 	var $id_wrote_petition_court = null; // Ф.И.О. сотрудника, написавшего исковое заявление в суд
	var $id_representing_court = null; // Ф.И.О. сотрудника, представляющего интересы клиента в суде 
	var $note_returned_sums = null; // Отметка о добровольном возврате клиенту сумм по поданной претензии (полностью / частично)	 	 	 
	var $cost_action = null; // цена иска 	 	 	 	 	 	 
 	var $claimed_legal_costs = null; // заявленные судебные издержки
	var $file_number = null; // Номер дела 	 	 	 	 
 	var $pending_cases_court = null; // Причина Отметка об отложенных делах в суде	  	
 	var $decision_first_instance = null; // Решение суда 1-ой инстанции	
	var $comment_judgment = null; // комментарий решения суда
	var $collected_client = null; // Взыскано в пользу клиента	
	var $collected_roo = null; // взыскно штрафа в пользу РОО ЗПП
	var $legal_costs_roo = null; // судебные издержки в пользу РОО ЗПП
	var $number_writ = null; // Номер исполнительного листа
	var $writ_filed = null; // Исполнительный лист подан в (ответчику лично, предъвлен к счету ответчика (банк или ГРКЦ), ФССП)
	var $appeal_who = null; // Кем подана (РОО, ответчик)
	var $appeal_result = null; // Результат рассмотрения дела в апелляционной инстанции (кратко)
	var $cass_who = null; // Кем подана (РОО, ответчик)
	var $cass_result = null; // Результат рассмотрения дела в кассационной инстанции (кратко)
	var $defendant = null; // Ответчик по делу
	var $docs = null; // Перечень принятых документов (от 1 до 10 наименований)
	var $adocs = null; // Перечень принятых документов (от 1 до 10 наименований)
	var $service = null; //Перечень услуг 
	var $price = null; //Сумма услуг
	var $name_court = null; // Наименование суда
	var $details = null; // Наименование суда

	function JClient(& $db) {			
		parent::__construct('#__7t_doc_clients', 'id', $db);
	}

	function store() {
		return parent::store();
	}
}
?>