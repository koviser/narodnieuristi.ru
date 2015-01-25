<?php

defined('_JEXEC') or die;

jimport('joomla.application.component.model');

class ModelXls extends JModel
{
	function getXls()
	{	
		$config = &JFactory::getConfig();
 		$db = &JFactory::getDBO();
		
		jimport( 'excel.PHPExcel' );
		jimport( 'excel.PHPExcel.Writer.Excel5' );
		jimport( 'joomla.filesystem.file' );
		
		$orderby = ' ORDER BY a.id';

		$query = 'SELECT a.*'
		. ' FROM #__7t_doc_types AS a'			
		. $orderby
		;
		
		$db->setQuery($query);
		$tabs = $db->loadObjectList();
		
		
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator( $config->getValue('sitename') );
		$objPHPExcel->getProperties()->setLastModifiedBy( $config->getValue('sitename') );
		$objPHPExcel->getProperties()->setTitle('Журнал учета дел');
		$objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(10);
		
		for($i=0;$i<count($tabs);$i++){
			if($i>0) $objPHPExcel->createSheet($i);
			$objPHPExcel->setActiveSheetIndex($i);
 			$objPHPExcel->getActiveSheet()->setTitle($tabs[$i]->title);
			
			$objPHPExcel->getActiveSheet()->mergeCells('A1:A2');
			$objPHPExcel->getActiveSheet()->mergeCells('B1:B2');
			$objPHPExcel->getActiveSheet()->mergeCells('C1:C2');
			$objPHPExcel->getActiveSheet()->mergeCells('D1:D2');
			$objPHPExcel->getActiveSheet()->mergeCells('E1:E2');
			$objPHPExcel->getActiveSheet()->mergeCells('F1:F2');
			$objPHPExcel->getActiveSheet()->mergeCells('G1:G2');
			$objPHPExcel->getActiveSheet()->mergeCells('H1:H2');
			$objPHPExcel->getActiveSheet()->mergeCells('I1:I2');
			$objPHPExcel->getActiveSheet()->mergeCells('J1:J2');
			$objPHPExcel->getActiveSheet()->mergeCells('K1:K2');
			$objPHPExcel->getActiveSheet()->mergeCells('L1:L2');
			$objPHPExcel->getActiveSheet()->mergeCells('M1:M2');
			$objPHPExcel->getActiveSheet()->mergeCells('N1:N2');
			$objPHPExcel->getActiveSheet()->mergeCells('O1:O2');
			$objPHPExcel->getActiveSheet()->mergeCells('P1:P2');
			$objPHPExcel->getActiveSheet()->mergeCells('Q1:Q2');
			$objPHPExcel->getActiveSheet()->mergeCells('R1:R2');
			
			$objPHPExcel->getActiveSheet()->mergeCells('S1:T1');
			$objPHPExcel->getActiveSheet()->mergeCells('U1:V1');
			
			$objPHPExcel->getActiveSheet()->mergeCells('W1:W2');
			$objPHPExcel->getActiveSheet()->mergeCells('X1:X2');
			$objPHPExcel->getActiveSheet()->mergeCells('Y1:Y2');
			$objPHPExcel->getActiveSheet()->mergeCells('Z1:Z2');
			$objPHPExcel->getActiveSheet()->mergeCells('AA1:AA2');
			$objPHPExcel->getActiveSheet()->mergeCells('AB1:AB2');
			$objPHPExcel->getActiveSheet()->mergeCells('AC1:AC2');
			$objPHPExcel->getActiveSheet()->mergeCells('AD1:AD2');
			
			$objPHPExcel->getActiveSheet()->mergeCells('AE1:AG1');
			
			$objPHPExcel->getActiveSheet()->mergeCells('AH1:AH2');
			$objPHPExcel->getActiveSheet()->mergeCells('AI1:AI2');
			
			$objPHPExcel->getActiveSheet()->mergeCells('AJ1:AL1');
			$objPHPExcel->getActiveSheet()->mergeCells('AM1:AM2');
			$objPHPExcel->getActiveSheet()->mergeCells('AN1:AN2');
			
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AN')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AM')->setWidth(20);
			//
			$objPHPExcel->getActiveSheet()->SetCellValue('A3', '1');
			$objPHPExcel->getActiveSheet()->SetCellValue('B3', '2');
			$objPHPExcel->getActiveSheet()->SetCellValue('C3', '3');
			$objPHPExcel->getActiveSheet()->SetCellValue('D3', '4');
			$objPHPExcel->getActiveSheet()->SetCellValue('E3', '5');
			$objPHPExcel->getActiveSheet()->SetCellValue('F3', '6');
			$objPHPExcel->getActiveSheet()->SetCellValue('G3', '7');
			$objPHPExcel->getActiveSheet()->SetCellValue('H3', '8');
			$objPHPExcel->getActiveSheet()->SetCellValue('I3', '9');
			$objPHPExcel->getActiveSheet()->SetCellValue('J3', '10');
			$objPHPExcel->getActiveSheet()->SetCellValue('K3', '11');
			$objPHPExcel->getActiveSheet()->SetCellValue('L3', '12');
			$objPHPExcel->getActiveSheet()->SetCellValue('M3', '13');
			$objPHPExcel->getActiveSheet()->SetCellValue('N3', '14');
			$objPHPExcel->getActiveSheet()->SetCellValue('O3', '15');
			$objPHPExcel->getActiveSheet()->SetCellValue('P3', '16');
			$objPHPExcel->getActiveSheet()->SetCellValue('Q3', '17');
			$objPHPExcel->getActiveSheet()->SetCellValue('R3', '18');
			$objPHPExcel->getActiveSheet()->SetCellValue('S3', '19');
			$objPHPExcel->getActiveSheet()->SetCellValue('T3', '20');
			$objPHPExcel->getActiveSheet()->SetCellValue('U3', '21');
			$objPHPExcel->getActiveSheet()->SetCellValue('V3', '22');
			$objPHPExcel->getActiveSheet()->SetCellValue('W3', '23');
			$objPHPExcel->getActiveSheet()->SetCellValue('X3', '24');
			$objPHPExcel->getActiveSheet()->SetCellValue('Y3', '25');
			$objPHPExcel->getActiveSheet()->SetCellValue('Z3', '26');
			$objPHPExcel->getActiveSheet()->SetCellValue('AA3', '27');
			$objPHPExcel->getActiveSheet()->SetCellValue('AB3', '28');
			$objPHPExcel->getActiveSheet()->SetCellValue('AC3', '29');
			$objPHPExcel->getActiveSheet()->SetCellValue('AD3', '30');
			$objPHPExcel->getActiveSheet()->SetCellValue('AE3', '31');
			$objPHPExcel->getActiveSheet()->SetCellValue('AF3', '32');
			$objPHPExcel->getActiveSheet()->SetCellValue('AG3', '33');
			$objPHPExcel->getActiveSheet()->SetCellValue('AH3', '34');
			$objPHPExcel->getActiveSheet()->SetCellValue('AI3', '35');
			$objPHPExcel->getActiveSheet()->SetCellValue('AJ3', '36');
			$objPHPExcel->getActiveSheet()->SetCellValue('AK3', '37');
			$objPHPExcel->getActiveSheet()->SetCellValue('AL3', '38');
			$objPHPExcel->getActiveSheet()->SetCellValue('AM3', '39');
			$objPHPExcel->getActiveSheet()->SetCellValue('AN3', '40');
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A1', '№ п/п');
			$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Ф.И.О. клиента');
			$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Номер телефона клиента');
			$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Дата приема клиента');
			$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Ф.И.О. сотрудника, проконсультировавшего клиента и принявшего у него документы');
			$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Наименование ответчика по делу');
			$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Дата подачи претензии');
			$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Ф.И.О. сотрудника, написавшего претензию');
			$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Дата получения ответа на претензию от организации ');
			$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Отметка о добровольном возврате клиенту сумм по поданной претензии (полностью / частично)');
			$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Ф.И.О. сотрудника, написавшего исковое заявление в суд');
			$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Дата подачи искового заявления в суд');
			$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'цена иска');
			$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'заявленные судебные издержки');
			$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Наименование суда');
			$objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Дата назначения суда');
			$objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Ф.И.О. сотрудника, представляющего интересы клиента в суде');
			$objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Номер дела');
			$objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Отметка об отложенных делах в суде');
			$objPHPExcel->getActiveSheet()->SetCellValue('S2', 'Дата');
			$objPHPExcel->getActiveSheet()->SetCellValue('T2', 'Причина');
			$objPHPExcel->getActiveSheet()->SetCellValue('U1', 'Решение суда 1-ой инстанции');
			$objPHPExcel->getActiveSheet()->SetCellValue('U2', 'Дата');
			$objPHPExcel->getActiveSheet()->SetCellValue('V2', 'удовлетворено/ частично удовлетворено/отказано');
			$objPHPExcel->getActiveSheet()->SetCellValue('W1', 'комментарий решения суда');
			$objPHPExcel->getActiveSheet()->SetCellValue('X1', 'Взыскано в пользу клиента');
			$objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'взыскно штрафа в пользу РОО ЗПП');
			$objPHPExcel->getActiveSheet()->SetCellValue('Z1', 'судебные издержки в пользу РОО ЗПП');
			$objPHPExcel->getActiveSheet()->SetCellValue('AA1', 'Дата получения исполнительного листа');
			$objPHPExcel->getActiveSheet()->SetCellValue('AB1', 'Номер исполнительного листа');
			$objPHPExcel->getActiveSheet()->SetCellValue('AC1', 'Исполнительный лист подан в (ответчику лично, предъвлен к счету ответчика (банк или ГРКЦ), ФССП)');
			$objPHPExcel->getActiveSheet()->SetCellValue('AD1', 'Дата подачи исполнительного листа ');
			$objPHPExcel->getActiveSheet()->SetCellValue('AE1', 'Информация о подаче апелляционной жалобы');
			$objPHPExcel->getActiveSheet()->SetCellValue('AE2', 'Дата подачи');
			$objPHPExcel->getActiveSheet()->SetCellValue('AF2', 'Дата получения');
			$objPHPExcel->getActiveSheet()->SetCellValue('AG2', 'Кем подана (РОО, ответчик)');
			$objPHPExcel->getActiveSheet()->SetCellValue('AH1', 'Дата рассмотрения дела в суде апелляционного слушания');
			$objPHPExcel->getActiveSheet()->SetCellValue('AI1', 'Результат рассмотрения дела в апелляционной инстанции (кратко)');
			$objPHPExcel->getActiveSheet()->SetCellValue('AJ1', 'Информация о подаче кассационной жалобы');
			$objPHPExcel->getActiveSheet()->SetCellValue('AJ2', 'Дата подачи');
			$objPHPExcel->getActiveSheet()->SetCellValue('AK2', 'Дата получения');
			$objPHPExcel->getActiveSheet()->SetCellValue('AL2', 'Кем подана (РОО, ответчик)');
			$objPHPExcel->getActiveSheet()->SetCellValue('AM1', 'Дата рассмотрения дела в кассационной инстанции');
			$objPHPExcel->getActiveSheet()->SetCellValue('AN1', 'Результат рассмотрения дела в кассационной инстанции (кратко)');
			////
			$orderby = ' ORDER BY a.client_name';
			
			$user=JFactory::getUser();
					
			$where = array();
			if($user->id_roo){
				$where[] = 'a.id_roo='.(int)$user->id_roo;
			}
			$where[] = 'a.id_type='.(int)$tabs[$i]->id;
	
			$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );	
		
			$query = 'SELECT a.*, c_1.name AS name_1, c_2.name AS name_2, c_3.name AS name_3, c_4.name AS name_4'
			. ' FROM #__7t_doc_clients AS a'
			. ' LEFT JOIN #__7t_doc_workers AS c_1 ON a.id_consultant=c_1.id'	
			. ' LEFT JOIN #__7t_doc_workers AS c_2 ON a.id_wrote_complaint=c_2.id'	
			. ' LEFT JOIN #__7t_doc_workers AS c_3 ON a.id_wrote_petition_court=c_3.id'	
			. ' LEFT JOIN #__7t_doc_workers AS c_4 ON a.id_representing_court=c_4.id'	
			. $where
			. $orderby
			;
			
			$db->setQuery( $query, $pagination->limitstart, $pagination->limit );
			$rows = $db->loadObjectList();
			
			for($j=0;$j<count($rows);$j++){
				$row=$rows[$j];	
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.(4+$j), $j+1);
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.(4+$j), $row->client_name);
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.(4+$j), $row->client_phone);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.(4+$j), $row->date_admission!='0000-00-00' ? $row->date_admission : '');
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.(4+$j), $row->name_1);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.(4+$j), $row->defendant);
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.(4+$j), $row->date_filing!='0000-00-00' ? $row->date_filing : '');
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.(4+$j), $row->name_2);
				$objPHPExcel->getActiveSheet()->SetCellValue('I'.(4+$j), $row->date_response!='0000-00-00' ? $row->date_response : '');
				$objPHPExcel->getActiveSheet()->SetCellValue('J'.(4+$j), $row->note_returned_sums);
				$objPHPExcel->getActiveSheet()->SetCellValue('K'.(4+$j), $row->name_3);
				$objPHPExcel->getActiveSheet()->SetCellValue('L'.(4+$j), $row->date_filling_court!='0000-00-00' ? $row->date_filling_court : '');
				$objPHPExcel->getActiveSheet()->SetCellValue('M'.(4+$j), $row->cost_action);
				$objPHPExcel->getActiveSheet()->SetCellValue('N'.(4+$j), $row->claimed_legal_costs);
				$objPHPExcel->getActiveSheet()->SetCellValue('O'.(4+$j), $row->name_court);
				$objPHPExcel->getActiveSheet()->SetCellValue('P'.(4+$j), $row->date_court!='0000-00-00' ? $row->date_court : '');
				$objPHPExcel->getActiveSheet()->SetCellValue('Q'.(4+$j), $row->name_4);
				$objPHPExcel->getActiveSheet()->SetCellValue('R'.(4+$j), $row->file_number);
				$objPHPExcel->getActiveSheet()->SetCellValue('S'.(4+$j), $row->date_pending_cases!='0000-00-00' ? $row->date_pending_cases : '');
				$objPHPExcel->getActiveSheet()->SetCellValue('T'.(4+$j), $row->pending_cases_court);
				$objPHPExcel->getActiveSheet()->SetCellValue('U'.(4+$j), $row->date_first_instance!='0000-00-00' ? $row->date_first_instance : '');
				$objPHPExcel->getActiveSheet()->SetCellValue('V'.(4+$j), $row->decision_first_instance);
				$objPHPExcel->getActiveSheet()->SetCellValue('W'.(4+$j), $row->comment_judgment);
				$objPHPExcel->getActiveSheet()->SetCellValue('X'.(4+$j), $row->collected_client);
				$objPHPExcel->getActiveSheet()->SetCellValue('Y'.(4+$j), $row->collected_roo);
				$objPHPExcel->getActiveSheet()->SetCellValue('Z'.(4+$j), $row->legal_costs_roo);
				$objPHPExcel->getActiveSheet()->SetCellValue('AA'.(4+$j), $row->date_receipt_writ!='0000-00-00' ? $row->date_receipt_writ : '');
				$objPHPExcel->getActiveSheet()->SetCellValue('AB'.(4+$j), $row->number_writ);
				$objPHPExcel->getActiveSheet()->SetCellValue('AC'.(4+$j), $row->writ_filed);
				$objPHPExcel->getActiveSheet()->SetCellValue('AD'.(4+$j), $row->date_filing_writ!='0000-00-00' ? $row->date_filing_writ : '');
				$objPHPExcel->getActiveSheet()->SetCellValue('AE'.(4+$j), $row->date_filing_appeal!='0000-00-00' ? $row->date_filing_appeal : '');
				$objPHPExcel->getActiveSheet()->SetCellValue('AF'.(4+$j), $row->date_receipt_appeal!='0000-00-00' ? $row->date_receipt_appeal : '');
				$objPHPExcel->getActiveSheet()->SetCellValue('AG'.(4+$j), $row->appeal_who);
				$objPHPExcel->getActiveSheet()->SetCellValue('AH'.(4+$j), $row->date_case!='0000-00-00' ? $row->date_case : '');
				$objPHPExcel->getActiveSheet()->SetCellValue('AI'.(4+$j), $row->appeal_result);
				$objPHPExcel->getActiveSheet()->SetCellValue('AJ'.(4+$j), $row->date_filing_cassation!='0000-00-00' ? $row->date_filing_cassation : '');
				$objPHPExcel->getActiveSheet()->SetCellValue('AK'.(4+$j), $row->date_receipt_cassation!='0000-00-00' ? $row->date_receipt_cassation : '');
				$objPHPExcel->getActiveSheet()->SetCellValue('AL'.(4+$j), $row->cass_who);
				$objPHPExcel->getActiveSheet()->SetCellValue('AM'.(4+$j), $row->date_case_appeal!='0000-00-00' ? $row->date_case_appeal : '');
				$objPHPExcel->getActiveSheet()->SetCellValue('AN'.(4+$j), $row->cass_result);
			}
			
			///
			$objPHPExcel->getActiveSheet()->getStyle('A1:AN'.(3+$j))->applyFromArray(
				array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					),
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						)
					)
				)
			);
			$objPHPExcel->getActiveSheet()->getStyle('A1:AN'.(3+$j))->getAlignment()->setWrapText(true);

		}
		$objPHPExcel->setActiveSheetIndex(0);
		$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
 		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="report'.rand(1000,9999).'.xls"');
		header('Cache-Control: max-age=0');
		$objWriter->save('php://output');
 		die();
	}
}