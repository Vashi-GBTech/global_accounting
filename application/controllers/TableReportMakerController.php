<?php
/*require 'vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;*/
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property  Master_Model Master_Model
 */
// reference the Dompdf namespace

class TableReportMakerController extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Excelsheet_model');
	}

	public function index($template_id)
	{
		$this->load->view("tableReportMaker/tablereportTemplateBuilder", array("title" => "Report View", 'template_id' => $template_id));
	}

	public function tableReportMakerList()
	{
		$this->load->view("tableReportMaker/tableReportMakerList", array("title" => "Report list View"));
	}

	public function GetReportView()
	{
		$type = $this->input->post('type');
		$user_type = $this->session->userdata('user_type');
		$company_id = $this->session->userdata('company_id');
		$mbData = $this->db
			->select(array("*"))
			->where(array('company_id' => $company_id, "status" => 1, "type" => $type,'templateVersion'=>1))
			->order_by('id', 'desc')
			->get("report_maker_master_table")->result();
		//	echo $this->db->last_query();
		$tableRows = array();
		if (count($mbData) > 0) {
			$i = 1;
			foreach ($mbData as $order) {
				if ($order->status == 1) {
					$status = 'Active';
				} else {
					$status = 'InActive';
				}
				array_push($tableRows, array($i,
						$order->id,
						$order->template_name,
						$status,
						$order->created_on)
				);
				$i++;
			}
		}
		$results = array(
			"draw" => 1,
			"recordsTotal" => count($mbData),
			"recordsFiltered" => count($mbData),
			"data" => $tableRows
		);

		echo json_encode($results);
	}

	public function reportMakerByMonth()
	{
		$id = $this->input->get('id');
		$templateName = $this->input->get('templateName');
		$this->load->view("tableReportMaker/tablereportMakerByMonth", array("title" => "Report list View", "id" => $id, "templateName" => $templateName));
	}

	public function createTableReportMonthHandson()
	{
		if (!is_null($this->input->post('month')) && $this->input->post('month') != "" && !is_null($this->input->post('year')) && $this->input->post('year') != "") {
			$month = $this->input->post('month');
			$year = $this->input->post('year');
			$branch = $this->input->post('branch');
			$amount_type = $this->input->post('amount_type');
			$template_id = $this->input->post('template_id');
			$html = '';
			// $html = ob_get_clean();
			$where = array('id' => $template_id,'templateVersion'=>1);
			$number_conversion = 0;
			$resultObject = $this->Master_Model->_select('report_maker_master_table', $where, "*", true);
			if ($resultObject->totalCount > 0) {
				$header=array();
				$columnType=array();
				for ($i=1;$i<=15;$i++)
				{
					array_push($header,'column_'.$i);
					array_push($columnType,array('type'=>'text'));
				}
				$rows=array();

				$type = $resultObject->data->type;
				$number_conversion = $resultObject->data->number_conversion;

				$report_where = array('template_id' => $template_id);
				$reportObject = $this->Master_Model->_select('table_reportmaker_transaction', $report_where, "*", false);
				$output = array_map(function ($object) {
					return $object->column_1.$object->column_2.$object->column_3.$object->column_4.$object->column_5.$object->column_6.$object->column_7.$object->column_8
						.$object->column_9.$object->column_10.$object->column_11.$object->column_12.$object->column_13.$object->column_14.$object->column_15;
					}, $reportObject->data);
				$opt= implode(', ', $output);
				$tableString=$this->getColumnTextData($opt,$month,$year,$number_conversion,$type,$branch,$amount_type);
//				print_r($tableString);

				if($reportObject->totalCount>0)
				{
					$reportData=array();
					$reportdata=$reportObject->data;
					foreach ($reportdata as $rrow)
					{
						$rowdata=array();
						for($i=1;$i<=15;$i++)
						{
							$columnName='column_'.$i;
							$columnText=$rrow->$columnName;
							$columnText = str_replace(",", "", $columnText);
//							$columnText = str_replace(" ", "", $columnText);
//							$columnText = str_replace(";", "", $columnText);
//							$columnText = str_replace("'", "", $columnText);
							if($columnText!="" && $columnText!=null)
							{
								if(array_key_exists($columnText,$tableString))
								{

									$columnText=$tableString[$columnText];
								}
								else{

								}
							}
							array_push($rowdata,$columnText);
						}
						array_push($reportData,$rowdata);
					}

					$response['status'] = 200;
					$response['body'] = $html;
					$response['header'] = $header;
					$response['rows'] = $reportData;
					$response['columnType'] = $columnType;
				}
				else{
					$response['status'] = 201;
					$response['body'] = 'No data found';
				}
			}
			else{
				$response['status'] = 201;
				$response['body'] = 'No data found';
			}
		} else {
			$response['status'] = 201;
			$response['body'] = 'No data found';
		}
		echo json_encode($response);
	}
	function getColumnTextData($html,$month,$year,$number_conversion,$type,$branch,$amount_type)
	{
		$textReplaceArray=array();

		$country_master = $this->Master_Model->getQuarter();
		$divide = 1;
		if ($number_conversion == 1) {
			$divide = 1000;
		}
		if ($number_conversion == 2) {
			$divide = 100000;
		}
		if ($number_conversion == 3) {
			$divide = 10000000;
		}
		$month_name = $country_master[$month];
		//month replace
//		$html = str_replace('#month', $month_name, $html);
		$textReplaceArray['#month']=$month_name;
		//year replace
//		$html = str_replace('#year', $year, $html);
		$textReplaceArray['#year']=$year;
		$html1 = preg_replace("!<span[^>]+>!", '', $html);
		$html = preg_replace("!</span>!", '', $html1);
		$TablematchArray = array('#T_BS_1001', '#T_PL_1001', '#G_BS_1001', '#G_PL_1001');

		//preg_match_all("/#+\w*@+/i", $html, $matchArray);
		preg_match_all("/#+[\w\s\-]*@+/i", $html, $matchArray);

		foreach ($matchArray[0] as $typeIndex => $value) {
			$value = str_replace(",", "", $value);
//			$value = str_replace(" ", "", $value);
//			$value = str_replace(";", "", $value);
//			$value = str_replace("'", "", $value);

			$value1 = str_replace('#', '', $value);

			$value1 = str_replace('@', '', $value1);

			$value2 = explode('_', $value1);
			if (count($value2) > 2) {
				$value2[0]=trim($value2[0]);
				if (strpos($value2[0], 'GL') !== false) {
					$gl_data = $this->getGLAccountData($value2[1], $value2[2], $month, $year, $type, $value2[0],$branch,$amount_type);
					$gl_data = str_replace(',', '', $gl_data);
					$gl_data = $gl_data / $divide;
					$textReplaceArray[$value]=number_format($gl_data,2);
//					$html = str_replace($value, number_format($gl_data,2), $html);
				}
				if (strpos($value2[0], 'GR') !== false) {
					$gl_data = $this->getGRAccountDataReport($value2[1], $value2[2], $month, $year, $type, $value2[0],$branch,$amount_type);
					$gl_data = str_replace(',', '', $gl_data);
					$gl_data = $gl_data / $divide;
//					$html = str_replace($value, number_format($gl_data,2), $html);
					$textReplaceArray[$value]=number_format($gl_data,2);
				}
				if (strpos($value2[0], 'T2') !== false) {
					$gl_data = $this->getT2AccountDataReport($value2[1], $value2[2], $month, $year, $type, $value2[0],$branch,$amount_type);
					$gl_data = str_replace(',', '', $gl_data);
					$gl_data = $gl_data / $divide;
//					$html = str_replace($value, number_format($gl_data,2), $html);
					$textReplaceArray[$value]=number_format($gl_data,2);
				}

				if (strpos($value2[0], 'EQ') !== false || strpos($value2[0], 'AS') !== false || strpos($value2[0], 'EX') !== false || strpos($value2[0], 'RE') !== false) {
					if ($value2[1] == 'T1') {
						$gl_data = $this->getType1AccountDataReport($value2[0], $value2[1], $value2[2], $month, $year, $type,$branch,$amount_type);
					} else {
						$gl_data = $this->getTypeAccountDataReport($value2[0], $value2[1], $value2[2], $month, $year, $type,$branch,$amount_type);
					}
					$gl_data = str_replace(',', '', $gl_data);
					$gl_data = $gl_data / $divide;
//					$html = str_replace($value, number_format($gl_data,2), $html);
					$textReplaceArray[$value]=number_format($gl_data,2);
				}

			}
		}

//		 print_r($textReplaceArray);exit();
		// htmlentities();
		// $html=htmlentities($html);
		// print_r($this->tag_contents1($html , "&lt;f&gt;" , "&lt;/f&gt;"));
		$formulaArray = $this->tag_contents1($html, "<code>", "</code>");
//		print_r($textReplaceArray);exit();
		// preg_match_all("~<f>(.*?)</f>~ &lt;f&gt;(.*?);/f&gt;",$html,$formulaArray);

		foreach ($formulaArray as $fvalue) {

			preg_match_all("/#+[\w\s\-]*@+/i", $fvalue, $matchArray1);
			$string=0;
			foreach ($matchArray1[0] as $typeIndex1 => $tvalue1) {
				$tvalue = str_replace(",", "", $tvalue1);
//				$tvalue = str_replace(" ", "", $tvalue);
//				$tvalue = str_replace(";", "", $tvalue);
//				$tvalue = str_replace("'", "", $tvalue);
				$string=$textReplaceArray[$tvalue];
//				print_r($string);
				 $string=str_replace($fvalue, $tvalue, $string);
			}
			$string2 = strip_tags($string);
			$string = str_replace(",", "", $string2);
//			$string = str_replace(" ", "", $string);
//			$string = str_replace(";", "", $string);
//			$string = str_replace("'", "", $string);
			$result1=0;
			if($string != ""){
				$math_string = "return (" . $string . ");";
				if (strpos($math_string, '/0') !== false) {
					$result1 = "0";
				} else {
					$result1 = eval($math_string);

				}
			}
//			$fvalue1 = str_replace(",", "", $fvalue);
//			$fvalue1 = str_replace(" ", "", $fvalue1);
//			$fvalue1 = str_replace(";", "", $fvalue1);
//			$fvalue1 = str_replace("'", "", $fvalue1);

			$textReplaceArray["<code>" . $fvalue . "</code>"]=number_format($result1,2);

//			$html = str_replace("<code>" . $fvalue . "</code>", number_format($result1,2), $html);
		}
//		foreach ($TablematchArray as $t_value) {
//			switch ($t_value) {
//				case '#T_BS_1001':
//					$data = $this->getBalanceSheetTable($month, $year, $type);
//					$html = str_replace($t_value, $data, $html);
//					break;
//				case '#T_PL_1001':
//					$data = $this->getProfitLossTable($month, $year, $type);
//					$html = str_replace($t_value, $data, $html);
//					break;
//			}
//		}
		return $textReplaceArray;
	}
//	function getWithoutSpacesText($textValue)
//	{
//		$textValue = str_replace(",", "", $textValue);
//		$textValue = str_replace(" ", "", $textValue);
//		$textValue = str_replace(";", "", $textValue);
//		$textValue = str_replace("'", "", $textValue);
//		return $textValue;
//	}
	function tag_contents1($string, $tag_open, $tag_close)
	{
		$result = array();
		foreach (explode($tag_open, $string) as $key => $value) {
			if (strpos($value, $tag_close) !== FALSE) {
				$result[] = substr($value, 0, strpos($value, $tag_close));;
			}
		}
		return $result;
	}

	function getGLAccountData($columns, $gl_ac, $month, $year, $type, $attr,$branch,$amount_type)
	{
		$data = 0;
		$column = 'T';
		switch ($columns) {
			case 'O':
				$column = 'opening_balance';
				break;
			case 'C':
				$column = 'credit';
				break;
			case 'D':
				$column = 'debit';
				break;
			case 'T':
				$column = 'total';
				break;
			case 'O2':
				$column = 'opening_balance_1';
				break;
			case 'C2':
				$column = 'credit_1';
				break;
			case 'D2':
				$column = 'debit_1';
				break;
			case 'T2':
				$column = 'total_1';
				break;
		}
		$data = $this->getGLBalanceQueryData($month, $year, $column, $gl_ac, $type, $attr,$branch,$amount_type);

		return $data;
	}
	function getGRBalanceQueryData($month, $year, $column, $gr_id, $type, $attr,$branch,$amount_type)
	{
		$company_id = $this->session->userdata('company_id');
		$data = 0;
		$columnName = '';

		if($branch == 'All'){
			if ($type == 2)//USD
			{
				$consolidate_table = 'consolidate_report_all_data_us';
				$main_table = 'main_account_setup_master_us';
			} else if ($type == 3)//IRFS
			{
				$consolidate_table = 'consolidate_report_all_data_ifrs';
				$main_table = 'main_account_setup_master_ifrs';
			} else  //IND
			{
				$consolidate_table = 'consolidate_report_all_data_ind';
				$main_table = 'main_account_setup_master';
			}
		}else{
			if ($type == 2)//USD
			{
				$consolidate_table = 'consolidate_report_transaction_us';
				$main_table = 'main_account_setup_master_us';
			} else if ($type == 3)//IRFS
			{
				$consolidate_table = 'consolidate_report_transaction_ifrs';
				$main_table = 'main_account_setup_master_ifrs';
			} else  //IND
			{
				$consolidate_table = 'consolidate_report_transaction';
				$main_table = 'main_account_setup_master';
			}
			$branchName='branch_id';
			$branch_ic=$branch;
			if($amount_type == 2){
				$column= $column.'_2';
			}
		}

		$companyObject = $this->Master_Model->_select('company_master', array('id' => $company_id), array('start_month'), true);
		if ($companyObject->totalCount > 0) {
			if ($attr == 'PGR' || $attr == '-PGR') {
				$year1 = $year - 1;
			} else if ($attr == 'PPGR' || $attr == '-PPGR') {
				$year1 = $year - 2;
			} else {
				$year1 = $year;
			}
			$negative=false;
			if($attr == '-PGR' || $attr == '-PPGR' || $attr == '-GR'){
				$negative =true;
			}
			$companyRow = $companyObject->data;
			// if ($companyRow->start_month == 1) {


			// 	$resultObject=$this->Master_Model->_rawQuery('select sum('.$column.') as data from '.$consolidate_table.' where year=? and month >=? and company_id= ? and account_number in (select main_gl_number from '.$main_table.' where group_id=?)',array((int)$year1,(int)$companyRow->start_month,$company_id,$gr_id));

			// } else {
			// 		if ($month >= $companyRow->start_month) {

			// 		$resultObject=$this->Master_Model->_rawQuery('select sum('.$column.') as data from '.$consolidate_table.' where ((year = ? and month >= ?) or (year=? and month <= ?)) and company_id= ? and account_number in (select main_gl_number from '.$main_table.' where group_id=?)',array((int)$year1,(int)$companyRow->start_month,(int)($year1+1),(int)($companyRow->start_month-1),$company_id,$gr_id));

			// 	} else {
			// 		$resultObject=$this->Master_Model->_rawQuery('select sum('.$column.') as data from '.$consolidate_table.' where ((year = ? and month < ?) or (year=? and month <= ?)) and company_id= ? and account_number in (select main_gl_number from '.$main_table.' where group_id=?)',array((int)$year1,(int)$companyRow->start_month,(int)($year1-1),(int)($companyRow->start_month),$company_id,$gr_id));
			// 	}
			// }
			if($branch == 'All'){
				$resultObject = $this->Master_Model->_rawQuery('select sum(' . $column . ') as data from ' . $consolidate_table . ' where year=? and month =? and company_id= ?  and account_number in (select main_gl_number from ' . $main_table . ' where group_id=?)', array((int)$year1, (int)$month, $company_id, $gr_id));
			}else{
				$resultObject = $this->Master_Model->_rawQuery('select sum(' . $column . ') as data from ' . $consolidate_table . ' where year=? and month =? and company_id= ? and branch_id =? and account_number in (select main_gl_number from ' . $main_table . ' where group_id=?)', array((int)$year1, (int)$month, $company_id,$branch_ic ,$gr_id));
			}

//			print_r($this->db->last_query());exit();
			if ($resultObject->totalCount > 0) {
				if($negative == true){
					if($resultObject->data[0]->data < 0){
						$resultObject->data[0]->data=abs($resultObject->data[0]->data);
					}else{
						$resultObject->data[0]->data=-($resultObject->data[0]->data);
					}
				}
				$data = number_format($resultObject->data[0]->data);

				if ($data == "") {
					$data = 0;
				}
			} else {
				$data = 0;
			}
		}

		return $data;
	}

	function getT2BalanceQueryData($month, $year, $column, $type2, $type, $attr,$branch,$amount_type)
	{
		$company_id = $this->session->userdata('company_id');

		$data = 0;
		$columnName = '';

		if($branch == 'All'){
			if ($type == 2)//USD
			{
				$consolidate_table = 'consolidate_report_all_data_us';
				$main_table = 'main_account_setup_master_us';
				$grp_table = 'master_account_group_us';
			} else if ($type == 3)//IRFS
			{
				$consolidate_table = 'consolidate_report_all_data_ifrs';
				$main_table = 'main_account_setup_master_ifrs';
				$grp_table = 'master_account_group_ifrs';
			} else  //IND
			{
				$consolidate_table = 'consolidate_report_all_data_ind';
				$main_table = 'main_account_setup_master';
				$grp_table = 'master_account_group_ind';
			}
		}else{
			if ($type == 2)//USD
			{
				$consolidate_table = 'consolidate_report_transaction_us';
				$main_table = 'main_account_setup_master_us';
			} else if ($type == 3)//IRFS
			{
				$consolidate_table = 'consolidate_report_transaction_ifrs';
				$main_table = 'main_account_setup_master_ifrs';
			} else  //IND
			{
				$consolidate_table = 'consolidate_report_transaction';
				$main_table = 'main_account_setup_master';
			}
			$branchName='branch_id';
			$branch_ic=$branch;
			if($amount_type == 2){
				$column = $column.'_2';
			}
		}
		$dataArr = array();
		$main_gl_numbers = "";
		$getGroup_id = $this->Master_Model->_rawQuery("select main_gl_number from " . $main_table . " where type2='" . $type2 . "' AND company_id=" . $company_id);

		if ($getGroup_id->totalCount > 0) {
			$res = $getGroup_id->data;
			foreach ($res as $row) {
				$dataArr[] = $row->main_gl_number;
			}
			$main_gl_numbers = implode(",", $dataArr);
		}


		$companyObject = $this->Master_Model->_select('company_master', array('id' => $company_id), array('start_month'), true);
		if ($companyObject->totalCount > 0) {

			if ($attr == 'PT2' || $attr == '-PT2') {
				$year1 = $year - 1;
			} else if ($attr == 'PPT2' || $attr == '-PPT2') {
				$year1 = $year - 2;
			} else {
				$year1 = $year;
			}
			$negative=false;
			if($attr == '-PT2' || $attr == '-PPT2' || $attr == '-T2'){
				$negative =true;
			}

			$companyRow = $companyObject->data;
			if($branch == 'All'){
				$resultObject = $this->Master_Model->_rawQuery('select sum(' . $column . ') as data from ' . $consolidate_table . ' where year=? and month =? and company_id= ? and  find_in_set(account_number,"' . $main_gl_numbers . '")', array((int)$year1, (int)$month, $company_id));
			}else{
				$resultObject = $this->Master_Model->_rawQuery('select sum(' . $column . ') as data from ' . $consolidate_table . ' where year=? and month =? and company_id= ? and branch_id=? and  find_in_set(account_number,"' . $main_gl_numbers . '")', array((int)$year1, (int)$month, $company_id,$branch_ic));
			}

//			 print_r($this->db->last_query());exit();
			if ($resultObject->totalCount > 0) {
				if($negative == true){
					if($resultObject->data[0]->data < 0){
						$resultObject->data[0]->data=abs($resultObject->data[0]->data);
					}else{
						$resultObject->data[0]->data=-($resultObject->data[0]->data);
					}
				}
				$data = number_format($resultObject->data[0]->data);
				if ($data == "") {
					$data = 0;
				}
			} else {
				$data = 0;
			}
		}

		return $data;
	}

	function getGLBalanceQueryData($month, $year, $column, $gl_ac, $type, $attr,$branch,$amount_type)
	{
		$company_id = $this->session->userdata('company_id');
		$data = 0;
		$columnName = '';
		$branchName='';
		$branch_ic='';
		if($branch == 'All'){
			if ($type == 2)//USD
			{
				$columnName = 'parent_account_number_us';
				$consolidate_table = 'consolidate_report_all_data_us';
			} else if ($type == 3)//IRFS
			{
				$columnName = 'parent_account_number_ifrs';
				$consolidate_table = 'consolidate_report_all_data_ifrs';
			} else  //IND
			{
				$columnName = 'parent_account_number';
				$consolidate_table = 'consolidate_report_all_data_ind';
			}
		}else{
			if ($type == 2)//USD
			{
				$consolidate_table = 'consolidate_report_transaction_us';
			} else if ($type == 3)//IRFS
			{
				$consolidate_table = 'consolidate_report_transaction_ifrs';
			} else  //IND
			{
				$consolidate_table = 'consolidate_report_transaction';
			}
			$branchName='branch_id';
			$branch_ic=$branch;
			if($amount_type == 2){
				$column=$column."_2";
			}
		}

		$companyObject = $this->Master_Model->_select('company_master', array('id' => $company_id), array('start_month'), true);
		if ($companyObject->totalCount > 0) {

			if ($attr == 'PGL' || $attr == '-PGL') {
				$year1 = $year - 1;
			} else if ($attr == 'PPGL' || $attr == '-PPGL') {
				$year1 = $year - 2;
			} else {
				$year1 = $year;
			}
			$negative=false;
			if($attr == '-PGL' || $attr == '-PPGL' || $attr == '-GL'){
				$negative =true;
			}
			$companyRow = $companyObject->data;
			// if ($companyRow->start_month == 1) {


			// 	$resultObject=$this->Master_Model->_rawQuery('select sum('.$column.') as data from '.$consolidate_table.' where year=? and month >=? and company_id= ? and account_number = ?',array((int)$year1,(int)$companyRow->start_month,$company_id,$gl_ac));

			// } else {
			// 		if ($month >= $companyRow->start_month) {

			// 		$resultObject=$this->Master_Model->_rawQuery('select sum('.$column.') as data from '.$consolidate_table.' where ((year = ? and month >= ?) or (year=? and month <= ?)) and company_id= ? and account_number = ?',array((int)$year1,(int)$companyRow->start_month,(int)($year1+1),(int)($companyRow->start_month-1),$company_id,$gl_ac));

			// 	} else {
			// 		$resultObject=$this->Master_Model->_rawQuery('select sum('.$column.') as data from '.$consolidate_table.' where ((year = ? and month < ?) or (year=? and month <= ?)) and company_id= ? and account_number = ?',array((int)$year1,(int)$companyRow->start_month,(int)($year1-1),(int)($companyRow->start_month),$company_id,$gl_ac));
			// 	}
			// }

			if($branch == 'All'){
				$resultObject = $this->Master_Model->_rawQuery('select sum(' . $column . ') as data from ' . $consolidate_table . ' where year=? and month =? and company_id= ? and account_number = ? ', array((int)$year1, (int)$month, $company_id, $gl_ac));
			}else{
				$resultObject = $this->Master_Model->_rawQuery('select sum(' . $column . ') as data from ' . $consolidate_table . ' where year=? and month =? and company_id= ? and account_number = ? And branch_id=?', array((int)$year1, (int)$month, $company_id, $gl_ac,$branch_ic));
			}


			// print_r($this->db->last_query());exit();
			if ($resultObject->totalCount > 0) {
				if($negative == true){
					if($resultObject->data[0]->data < 0){
						$resultObject->data[0]->data=abs($resultObject->data[0]->data);
					}else{
						$resultObject->data[0]->data=-($resultObject->data[0]->data);
					}
				}
				$data = number_format($resultObject->data[0]->data);
				if ($data == "") {
					$data = 0;
				}
			} else {
				$data = 0;
			}
		}

		return $data;
	}

	function getGRAccountDataReport($columns, $gr_id, $month, $year, $type, $attr,$branch,$amount_type)
	{
		$data = 0;
		$column = 'T';
		switch ($columns) {

			case 'O':
				$column = 'opening_balance';
				break;
			case 'C':
				$column = 'credit';
				break;
			case 'D':
				$column = 'debit';
				break;
			case 'T':
				$column = 'total';
				break;
			case 'O2':
				$column = 'opening_balance+opening_balance_1';
				break;
			case 'C2':
				$column = 'credit+credit_1';
				break;
			case 'D2':
				$column = 'debit+debit_1';
				break;
			case 'T2':
				$column = 'total+total_1';
				break;
		}

		$data = $this->getGRBalanceQueryData($month, $year, $column, $gr_id, $type, $attr,$branch,$amount_type);

		return $data;
	}

	function getT2AccountDataReport($columns, $gr_id, $month, $year, $type, $attr,$branch,$amount_type)
	{
		$data = 0;
		$column = 'T';
		switch ($columns) {

			case 'O':
				$column = 'opening_balance';
				break;
			case 'C':
				$column = 'credit';
				break;
			case 'D':
				$column = 'debit';
				break;
			case 'T':
				$column = 'total';
				break;
			case 'O2':
				$column = 'opening_balance+opening_balance_1';
				break;
			case 'C2':
				$column = 'credit+credit_1';
				break;
			case 'D2':
				$column = 'debit+debit_1';
				break;
			case 'T2':
				$column = 'total+total_1';
				break;
		}

		$data = $this->getT2BalanceQueryData($month, $year, $column, $gr_id, $type, $attr,$branch,$amount_type);

		return $data;
	}

	function getTypeAccountDataReport($type1, $type2, $columns, $month, $year, $type,$branch,$amount_type)
	{
		$data = 0;
		$column = 'T';
		switch ($columns) {

			case 'O':
				$column = 'opening_balance';
				break;
			case 'C':
				$column = 'credit';
				break;
			case 'D':
				$column = 'debit';
				break;
			case 'T':
				$column = 'total';
				break;
			case 'O2':
				$column = 'opening_balance+opening_balance_1';
				break;
			case 'C2':
				$column = 'credit+credit_1';
				break;
			case 'D2':
				$column = 'debit+debit_1';
				break;
			case 'T2':
				$column = 'total+total_1';
				break;
		}

		$data = $this->getTypeBalanceQueryData($month, $year, $column, $type1, $type2, $type,$branch,$amount_type);

		return $data;
	}

	function getTypeBalanceQueryData($month, $year, $column, $type1, $type2, $type,$branch,$amount_type)
	{
		$company_id = $this->session->userdata('company_id');
		$data = 0;
		$columnName = '';

		if($branch == 'All'){
			if ($type == 2)//USD
			{
				$columnName = 'parent_account_number_us';
				$consolidate_table = 'consolidate_report_all_data_us';
				$main_table = 'main_account_setup_master_us';
			} else if ($type == 3)//IRFS
			{
				$columnName = 'parent_account_number_ifrs';
				$consolidate_table = 'consolidate_report_all_data_ifrs';
				$main_table = 'main_account_setup_master_ifrs';
			} else  //IND
			{
				$columnName = 'parent_account_number';
				$consolidate_table = 'consolidate_report_all_data_ind';
				$main_table = 'main_account_setup_master';
			}
		}else{
			if ($type == 2)//USD
			{
				$consolidate_table = 'consolidate_report_transaction_us';
				$main_table = 'main_account_setup_master_us';
			} else if ($type == 3)//IRFS
			{
				$consolidate_table = 'consolidate_report_transaction_ifrs';
				$main_table = 'main_account_setup_master_ifrs';
			} else  //IND
			{
				$consolidate_table = 'consolidate_report_transaction';
				$main_table = 'main_account_setup_master';
			}
			$branchName='branch_id';
			$branch_ic=$branch;
			if($amount_type == 2){
				$column = $column.'_2';
			}
		}
		$companyObject = $this->Master_Model->_select('company_master', array('id' => $company_id), array('start_month'), true);

		$type1_value = '';
		$type2_value = '';
		if (strpos($type1, 'EQ') !== false) {
			$type1_value = 'EQUITY AND LIABILITIES';
		}
		if (strpos($type1, 'AS') !== false) {
			$type1_value = 'ASSETS';
		}
		if (strpos($type1, 'EX') !== false) {
			$type1_value = 'EXPENSES';
		}
		if (strpos($type1, 'RE') !== false) {
			$type1_value = 'REVENUE';
		}

		if ($type2 == 'SH') {
			$type2_value = 'SHAREHOLDERS FUNDS';
		}
		if ($type2 == 'CL') {
			$type2_value = 'Current Liabilities';
		}
		if ($type2 == 'CA') {
			$type2_value = 'Current Assets';
		}
		if ($type2 == 'NCA') {
			$type2_value = 'NON CURRENT ASSETS';
		}
		if ($type2 == 'NCL') {
			$type2_value = 'NON CURRENT LIABILITIES';
		}
		// $gl_ac = $this->db->select('group_concat(main_gl_number)')->where(array('type1'=>$type1_value,'type2'=>$type2_value))->get('main_account_setup_master')->row()->data;
		if ($companyObject->totalCount > 0) {

			if ($type1 == 'PEQ' || $type1 == 'PAS' || $type1 == 'PEX' || $type1 == 'PRE' || $type1 == '-PEQ' || $type1 == '-PAS' || $type1 == '-PEX' || $type1 == '-PRE') {
				$year1 = $year - 1;
			} else if ($type1 == 'PPEQ' || $type1 == 'PPAS' || $type1 == 'PPEX' || $type1 == 'PPRE' || $type1 == '-PPEQ' || $type1 == '-PPAS' || $type1 == '-PPEX' || $type1 == '-PPRE') {
				$year1 = $year - 2;
			} else {
				$year1 = $year;
			}
			$negative=false;
			if (str_contains($type1, '-')) {
				$negative =true;
			}
			$companyRow = $companyObject->data;
			// if ($companyRow->start_month == 1) {

			// 	$resultObject=$this->Master_Model->_rawQuery('select sum('.$column.') as data from '.$consolidate_table.' where year=? and month >=? and company_id= ? and account_number in (select main_gl_number from '.$main_table.' where company_id=? and type1=? and type2=?)',array((int)$year1,(int)$companyRow->start_month,$company_id,$company_id,$type1_value,$type2_value));

			// } else {
			// 		if ($month >= $companyRow->start_month) {

			// 		$resultObject=$this->Master_Model->_rawQuery('select sum('.$column.') as data from '.$consolidate_table.' where ((year = ? and month >= ?) or (year=? and month <= ?)) and company_id= ? and account_number in (select main_gl_number from '.$main_table.' where company_id=? and type1=? and type2=?)',array((int)$year1,(int)$companyRow->start_month,(int)($year1+1),(int)($companyRow->start_month-1),$company_id,$company_id,$type1_value,$type2_value));

			// 	} else {
			// 		$resultObject=$this->Master_Model->_rawQuery('select sum('.$column.') as data from '.$consolidate_table.' where ((year = ? and month < ?) or (year=? and month <= ?)) and company_id= ? and account_number in (select main_gl_number from '.$main_table.' where company_id=? and type1=? and type2=?)',array((int)$year1,(int)$companyRow->start_month,(int)($year1-1),(int)($companyRow->start_month),$company_id,$company_id,$type1_value,$type2_value));
			// 	}
			// }
			if($branch == 'All'){
				$resultObject = $this->Master_Model->_rawQuery('select sum(' . $column . ') as data from ' . $consolidate_table . ' where year=? and month =? and company_id= ? and account_number in (select main_gl_number from ' . $main_table . ' where company_id=? and type1=? and type2=?)', array((int)$year1, (int)$month, $company_id, $company_id, $type1_value, $type2_value));
			}else{
				$resultObject = $this->Master_Model->_rawQuery('select sum(' . $column . ') as data from ' . $consolidate_table . ' where year=? and month =? and company_id= ? and account_number in (select main_gl_number from ' . $main_table . ' where company_id=? and type1=? and type2=?) and branch_id=?', array((int)$year1, (int)$month, $company_id, $company_id, $type1_value, $type2_value,$branch_ic));
			}

			// print_r($this-->db->last_query());exit();
			if ($resultObject->totalCount > 0) {
				//echo $resultObject->data[0]->data;
				if($negative == true){
					if($resultObject->data[0]->data < 0){
						$resultObject->data[0]->data=abs($resultObject->data[0]->data);
					}else{
						$resultObject->data[0]->data=-($resultObject->data[0]->data);
					}
				}
				$data = number_format($resultObject->data[0]->data);
				if ($data == "") {
					$data = 0;
				}
			} else {
				$data = 0;
			}
		}

		return $data;
	}

	function getType1AccountDataReport($type1, $type2, $columns, $month, $year, $type,$branch,$amount_type)
	{
		$data = 0;
		$column = 'T';
		switch ($columns) {

			case 'O':
				$column = 'opening_balance';
				break;
			case 'C':
				$column = 'credit';
				break;
			case 'D':
				$column = 'debit';
				break;
			case 'T':
				$column = 'total';
				break;
			case 'O2':
				$column = 'opening_balance+opening_balance_1';
				break;
			case 'C2':
				$column = 'credit+credit_1';
				break;
			case 'D2':
				$column = 'debit+debit_1';
				break;
			case 'T2':
				$column = 'total+total_1';
				break;
		}

		$data = $this->getType1BalanceQueryData($month, $year, $column, $type1, $type2, $type,$branch,$amount_type);

		return $data;
	}

	function getType1BalanceQueryData($month, $year, $column, $type1, $type2, $type,$branch,$amount_type)
	{

		$company_id = $this->session->userdata('company_id');
		$data = 0;
		$columnName = '';


		if($branch == 'All'){
			if ($type == 2)//USD
			{
				$columnName = 'parent_account_number_us';
				$consolidate_table = 'consolidate_report_all_data_us';
				$main_table = 'main_account_setup_master_us';
			} else if ($type == 3)//IRFS
			{
				$columnName = 'parent_account_number_ifrs';
				$consolidate_table = 'consolidate_report_all_data_ifrs';
				$main_table = 'main_account_setup_master_ifrs';
			} else  //IND
			{
				$columnName = 'parent_account_number';
				$consolidate_table = 'consolidate_report_all_data_ind';
				$main_table = 'main_account_setup_master';
			}
		}else{
			if ($type == 2)//USD
			{
				$consolidate_table = 'consolidate_report_transaction_us';
				$main_table = 'main_account_setup_master_us';
			} else if ($type == 3)//IRFS
			{
				$consolidate_table = 'consolidate_report_transaction_ifrs';
				$main_table = 'main_account_setup_master_ifrs';
			} else  //IND
			{
				$consolidate_table = 'consolidate_report_transaction';
				$main_table = 'main_account_setup_master';
			}
			$branchName='branch_id';
			$branch_ic=$branch;
			if($amount_type == 2){
				$column = $column.'_2';
			}
		}
		$companyObject = $this->Master_Model->_select('company_master', array('id' => $company_id), array('start_month'), true);

		$type1_value = '';
		$type2_value = '';
		if (strpos($type1, 'EQ') !== false) {
			$type1_value = 'EQUITY AND LIABILITIES';
		}
		if (strpos($type1, 'AS') !== false) {
			$type1_value = 'ASSETS';
		}
		if (strpos($type1, 'EX') !== false) {
			$type1_value = 'EXPENSES';
		}
		if (strpos($type1, 'RE') !== false) {
			$type1_value = 'REVENUE';
		}

		if ($companyObject->totalCount > 0) {

			if ($type1 == 'PEQ' || $type1 == 'PAS' || $type1 == 'PEX' || $type1 == 'PRE' || $type1 == '-PEQ' || $type1 == '-PAS' || $type1 == '-PEX' || $type1 == '-PRE') {
				$year1 = $year - 1;
			} else if ($type1 == 'PPEQ' || $type1 == 'PPAS' || $type1 == 'PPEX' || $type1 == 'PPRE' || $type1 == '-PPEQ' || $type1 == '-PPAS' || $type1 == '-PPEX' || $type1 == '-PPRE') {
				$year1 = $year - 2;
			} else {
				$year1 = $year;
			}
			$negative=false;
			if (strpos($type1, '-') !== false) {
				$negative =true;
			}
			$companyRow = $companyObject->data;
			// if ($companyRow->start_month == 1) {

			// 	$resultObject=$this->Master_Model->_rawQuery('select sum('.$column.') as data from '.$consolidate_table.' where year=? and month >=? and company_id= ? and account_number in (select main_gl_number from '.$main_table.' where company_id=? and type1=?)',array((int)$year1,(int)$companyRow->start_month,$company_id,$company_id,$type1_value));

			// } else {
			// 		if ($month >= $companyRow->start_month) {

			// 		$resultObject=$this->Master_Model->_rawQuery('select sum('.$column.') as data from '.$consolidate_table.' where ((year = ? and month >= ?) or (year=? and month <= ?)) and company_id= ? and account_number in (select main_gl_number from '.$main_table.' where company_id=? and type1=?)',array((int)$year1,(int)$companyRow->start_month,(int)($year1+1),(int)($companyRow->start_month-1),$company_id,$company_id,$type1_value));

			// 	} else {
			// 		$resultObject=$this->Master_Model->_rawQuery('select sum('.$column.') as data from '.$consolidate_table.' where ((year = ? and month < ?) or (year=? and month <= ?)) and company_id= ? and account_number in (select main_gl_number from '.$main_table.' where company_id=? and type1=?)',array((int)$year1,(int)$companyRow->start_month,(int)($year1-1),(int)($companyRow->start_month),$company_id,$company_id,$type1_value));
			// 	}
			// }
			if($branch == 'All'){
				$resultObject = $this->Master_Model->_rawQuery('select sum(' . $column . ') as data from ' . $consolidate_table . ' where year=? and month =? and company_id= ? and account_number in (select main_gl_number from ' . $main_table . ' where company_id=? and type1=?)', array((int)$year1, (int)$month, $company_id, $company_id, $type1_value));
			}else{
				$resultObject = $this->Master_Model->_rawQuery('select sum(' . $column . ') as data from ' . $consolidate_table . ' where year=? and month =? and company_id= ? and account_number in (select main_gl_number from ' . $main_table . ' where company_id=? and type1=?) and branch_id=?', array((int)$year1, (int)$month, $company_id, $company_id, $type1_value,$branch));
			}

			// print_r($this->db->last_query());exit();
			if ($resultObject->totalCount > 0) {
				if($negative == true){
					if($resultObject->data[0]->data < 0){
						$resultObject->data[0]->data=abs($resultObject->data[0]->data);
					}else{
						$resultObject->data[0]->data=-($resultObject->data[0]->data);
					}

				}
				$data = number_format($resultObject->data[0]->data);
				if ($data == "") {
					$data = 0;
				}
			} else {
				$data = 0;
			}
		}

		return $data;
	}

	public function getBalanceSheetTable($month, $year, $btype)
	{
		if ($btype == 2)//USD
		{
			$main_table = 'main_account_setup_master_us';
			$consolidate_table = 'consolidate_report_all_data_us';
		} else if ($btype == 3)//IRFS
		{
			$main_table = 'main_account_setup_master_ifrs';
			$consolidate_table = 'consolidate_report_all_data_ifrs';
		} else  //IND
		{
			$main_table = 'main_account_setup_master';
			$consolidate_table = 'consolidate_report_all_data_ind';
		}
		$country_master = $this->Master_Model->getQuarter();
		$month_name = $country_master[$month];
		$company_id = $this->session->userdata('company_id');
		$company_ = $this->Master_Model->get_row_data(array('name'), array('id' => $company_id), 'company_master');
		$company_name = $company_->name;
		$data_array = array();
		$balance_div = "";
		$type_data = $this->Master_Model->_rawQuery('SELECT * FROM ' . $main_table . ' where company_id ="' . $company_id . '" and type0 = "BS" ')->data;
		if (count($type_data) > 0) {
			foreach ($type_data as $type) {
				$data_array[$type->type1][$type->type2][$type->type3][] = $type;
			}
		}

		$balance_div .= '<style>
							.table{
								width: 100%;max-width: 100%;margin-bottom: 20px;
							}
							.table>tbody>tr>td, .table>tbody>tr>th,.table>thead>tr>td, .table>thead>tr>th{
								line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;
							}
						</style>
						<div class="row company_details">'
			. '</div>'
			. '<table class="table printtable">';
		foreach ($data_array as $key => $value) {
			$grand_total = 0;
			$balance_div .= '<tr>'
				. '<th class="type1" style="font-weight: bolder;font-size: 14px;">' . $key . '</th>'
				. '<th></th>'
				. '</tr>';
			foreach ($value as $k2 => $v2) {
				$grand_total1 = 0;
				$balance_div .= '<tr>'
					. '<td style="font-weight: bold;font-size: 12px;padding-left: 53px;">' . $k2 . '</td>'
					. '<td></td>'
					. '</tr>';
				foreach ($v2 as $k3 => $v3) {
					$mArray = array();
					foreach ($v3 as $mgl_no) {
						array_push($mArray, $mgl_no->main_gl_number);
					}
					$balance_div .= '<tr>'
						. '<td style="padding-left: 100px">' . $k3 . '</td>'
						. '<td class="text-right">';
					$total = $this->db->select('final_total')->where(array('company_id' => $company_id, 'year' => $year, 'month' => $month))->where_in('account_number', $mArray)->from($consolidate_table)->get()->row();
					if ($total != "") {
						$total->final_total = isset($total->final_total) ? $total->final_total : 0;
						if ($key == "EQUITY AND LIABILITIES") {
							$finalTotal = $total->final_total >= 0 ? -$total->final_total : abs($total->final_total);
						} else {
							$finalTotal = $total->final_total;
						}
						$grand_total1 += $finalTotal;
						$balance_div .= '' . number_format($finalTotal) . '	</td>'
							. '</tr>';
					}


				}
				$balance_div .= '<tr>'
					. '<td style="padding-left: 100px;">Total</td>'
					. '<td class="text-right">' . number_format($grand_total1) . '';
				$grand_total += (double)$grand_total1;
				$balance_div .= '</td>'
					. '</tr>';
			}
			$balance_div .= '<tr>'
				. '<td style="font-weight: bold;">Total</td>'
				. '<td class="text-right">' . number_format((double)$grand_total) . '</td>'
				. '</tr>';
		}
		$balance_div .= '</table>'
			. '<div class="row footer">'
			. '</div>';

		return $balance_div;

	}

	public function getProfitLossTable($month, $year, $btype)
	{
		if ($btype == 2)//USD
		{
			$main_table = 'main_account_setup_master_us';
			$consolidate_table = 'consolidate_report_all_data_us';
		} else if ($btype == 3)//IRFS
		{
			$main_table = 'main_account_setup_master_ifrs';
			$consolidate_table = 'consolidate_report_all_data_ifrs';
		} else  //IND
		{
			$main_table = 'main_account_setup_master';
			$consolidate_table = 'consolidate_report_all_data_ind';
		}
		$company_id = $this->session->userdata('company_id');
		$country_master = $this->Master_Model->getQuarter();
		$month_name = $country_master[$month];
		$company_ = $this->Master_Model->get_row_data(array('name'), array('id' => $company_id), 'company_master');
		$company_name = $company_->name;
		$data_array = array();
		$PLData = "";
		$type_data = $this->Master_Model->_rawQuery('SELECT * FROM ' . $main_table . ' where company_id ="' . $company_id . '" and type0 = "PL" ')->data;
		if (count($type_data) > 0) {
			foreach ($type_data as $type) {
				$data_array[$type->type1][$type->type2][$type->name] = $type;
			}
		}

		$PLData .= '<style>
						.table{
							width: 100%;max-width: 100%;margin-bottom: 20px;
						}
						.table>tbody>tr>td, .table>tbody>tr>th,.table>thead>tr>td, .table>thead>tr>th{
							line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;
						}
					</style>
					<div class="row company_details">'
			. '</div>'
			. '<table class="table print_table">';
		foreach ($data_array as $key => $value) {
			$grand_total = 0;
			$PLData .= '<tr>'
				. '<th style="font-weight: bolder;font-size: 14px">' . $key . '</th>'
				. '<th></th>'
				. '</tr>';
			foreach ($value as $k2 => $v2) {
				$grand_total1 = 0;
				$PLData .= '<tr><td style="font-weight: bold;font-size: 12px;padding-left: 53px;">' . $k2 . '</td>'
					. '<td></td></tr>';
				foreach ($v2 as $k3 => $v3) {
					$PLData .= '<tr><td style="padding-left: 100px">' . $k3 . ''
						. '</td>'
						. '<td>';
					$total = $this->db->select('final_total')
						->where(array('company_id' => $company_id, 'year' => $year, 'month' => $month, 'account_number' => $v3->main_gl_number))
						->from($consolidate_table)
						->get()->row();
					if ($total != "") {
						$grand_total1 += isset($total->final_total) ? $total->final_total : 0;
						$PLData .= '' . isset($total->final_total) ? $total->final_total : 0 . '</td></tr>';
					}

				}
				$PLData .= '<tr><td style="padding-left: 100px;">Total</td><td><?php echo $grand_total1; $grand_total += $grand_total1;?></td></tr>';
			}
			$PLData .= '<tr><td style="font-weight: bold;">Total</td><td>' . $grand_total . '</td></tr>';
		}
		$PLData .= '</table>'
			. '<div class="row footer">'
			. '</div>';

		return $PLData;
	}

	function getBalanceSheetGraph($index)
	{
		$cat = array('detail 1', 'detail 2', 'detail 3', 'detail 4');
		$val = array('1000', '2000', '3000', '5000');
		$template = new stdClass();
		$template->data = '<div id="graph_' . $index . '"></div>';
		$template->id = 'graph_' . $index;
		$template->cat = $cat;
		$template->val = $val;
		return $template;
	}

	function getProfitLossGraph($index)
	{
		$cat = array('detail 1', 'detail 2', 'detail 3', 'detail 4');
		$val = array('1000', '2000', '3000', '5000');
		$template = new stdClass();
		$template->data = '<div id="graph_' . $index . '"></div>';
		$template->id = 'graph_' . $index;
		$template->cat = $cat;
		$template->val = $val;
		return $template;
	}

	public function uploadTableTemplateData()
	{
//		 print_r($this->input->post());exit();
		if (!is_null($this->input->post('templateName')) && !is_null($this->input->post('type'))) {
			$template_name = $this->input->post('templateName');
			$type = $this->input->post('type');
			$template_id = $this->input->post('template_id');
			$templateBody = $this->input->post('templateBody');
			$number_conversion = $this->input->post('number_conversion');
			$templateBody=json_decode($templateBody);
			$user_type = $this->session->userdata('user_type');
			$company_id = $this->session->userdata('company_id');

			$data = array(
				'template_name' => $template_name,
				'type' => $type,
				'number_conversion' => $number_conversion,
			);

			if ($template_id != 0) {
				$data['modify_on'] = date('Y-m-d H:i:s');
				$data['modify_by'] = $user_type;
				$where = array('id' => $template_id, 'company_id' => $company_id,'templateVersion'=>1);

				$resultObject = $this->Master_Model->_update('report_maker_master_table', $data, $where);
				if ($resultObject->status == true) {
					$reportdata=array();
					if(!empty($templateBody))
					{
						foreach ($templateBody as $trow)
						{

							$updatedata=array('template_id'=>$template_id,'status'=>1,'created_on'=>date('Y-m-d H:i:s'),'created_by'=>$company_id);
							$m=1;
							for($i=0;$i<15;$i++)
							{

								$updatedata['column_'.$m]=trim($trow[$i]);

								$m++;
							}

								array_push($reportdata,$updatedata);


						}
					}
					$where_report=array('template_id'=>$template_id,'created_by'=>$company_id);
					$reportObjectDelete = $this->Master_Model->_delete('table_reportmaker_transaction',$where_report);
					if(!empty($reportdata))
					{
						$reportObject = $this->Master_Model->_insertBatch('table_reportmaker_transaction', $reportdata);
					}
					$response['status'] = 200;
					$response['body'] = 'Data Updated Successfully';
				} else {
					$response['status'] = 201;
					$response['body'] = 'Data Not Updated';
				}
			} else {
				$data['created_on'] = date('Y-m-d H:i:s');
				$data['created_by'] = $user_type;
				$data['company_id'] = $company_id;
				$data['status'] = 1;
				$resultObject = $this->Master_Model->_insert('report_maker_master_table', $data);
				if ($resultObject->status == true) {
					$template_id=$resultObject->inserted_id;
					$reportdata=array();
					if(!empty($templateBody))
					{
						foreach ($templateBody as $trow)
						{
							$rowdata=array('template_id'=>$template_id,'status'=>1,'created_on'=>date('Y-m-d H:i:s'),'created_by'=>$company_id);
							$m=1;
							for($i=0;$i<15;$i++)
							{
								$rowdata['column_'.$m]=trim($trow[$i]);
								$m++;
							}
							array_push($reportdata,$rowdata);
						}
					}
					if(!empty($reportdata))
					{
						$reportObject = $this->Master_Model->_insertBatch('table_reportmaker_transaction', $reportdata);
					}
					$response['status'] = 200;
					$response['body'] = 'Data Saved Successfully';
				} else {
					$response['status'] = 201;
					$response['body'] = 'Data Not Saved';
				}
			}
		} else {
			$response['status'] = 201;
			$response['body'] = 'Required Parameter Missing';
		}
		echo json_encode($response);
	}

	public function getTableReportTemplateData()
	{
		$header=array();
		$columnType=array();
		for ($i=1;$i<=15;$i++)
		{
			array_push($header,'column_'.$i);
			array_push($columnType,array('type'=>'text'));
		}
		$rows=array();
		$template_id = $this->input->post('template_id');
		$resultObject = $this->Master_Model->_select('report_maker_master_table', array('id' => $template_id,'templateVersion'=>1), "*", true);
		if ($resultObject->totalCount > 0) {
			$trasnsactionObject = $this->Master_Model->_select('table_reportmaker_transaction', array('template_id' => $template_id), "*", false);
			if($trasnsactionObject->totalCount>0)
			{
				foreach ($trasnsactionObject->data as $trow)
				{
					array_push($rows,array($trow->column_1,$trow->column_2,$trow->column_3,$trow->column_4,$trow->column_5,$trow->column_6,$trow->column_7,$trow->column_8,
						$trow->column_9,$trow->column_10,$trow->column_11,$trow->column_12,$trow->column_13,$trow->column_14,$trow->column_15));
				}
			}
			else{
				array_push($rows,array('','','','','','','','','','','','','','',''));
			}
				$response['status'] = 200;
				$response['body'] = $resultObject->data;
		} else {
			array_push($rows,array('','','','','','','','','','','','','','',''));
				$response['status'] = 201;
				$response['body'] = 'Data Not Found';
		}
		$response['header']=$header;
		$response['columnType']=$columnType;
		$response['rows']=$rows;
		echo json_encode($response);
	}

	public function getGlAccountOptions()
	{
		if (!is_null($this->input->post('type'))) {
			$company_id = $this->session->userdata('company_id');
			$type = $this->input->post('type');
			if ($type == 3) {
				$table = 'main_account_setup_master_ifrs';
			} else if ($type == 2) {
				$table = 'main_account_setup_master_us';
			} else {
				$table = 'main_account_setup_master';
			}
			$resultObject = $this->Master_Model->_select($table, array('company_id' => $company_id), array('main_gl_number', 'name', 'is_divide'), false);
			if ($resultObject->totalCount > 0) {
				$options = '';
				// $options='<option selected disabled>Select Gl ACCOUNT</option>';
				foreach ($resultObject->data as $key => $value) {
					// $options.='<option value="'.$value->main_gl_number.'||'.$value->is_divide.'">'.$value->main_gl_number.' - '.$value->name.'</option>';

					$options .= '<tr>
        					<td>' . $value->main_gl_number . '</td>
        					<td>' . $value->name . '</td>';

					if ($value->is_divide == 1) {
						$options .= '<td><span class="gl_divide"><input type="radio" name="gdivide_o' . $value->main_gl_number . '" id="gp1_o_' . $value->main_gl_number . '" value="" onclick="checkTypeRadioCheck(\'gdivide_o' . $value->main_gl_number . '\',\'GopartC' . $value->main_gl_number . '\')" checked> P1 <input type="radio" name="gdivide_o' . $value->main_gl_number . '" id="gp2_o' . $value->main_gl_number . '" value="2" onclick="checkTypeRadioCheck(\'gdivide_o' . $value->main_gl_number . '\',\'GopartC' . $value->main_gl_number . '\')"> P2</span>
        							</td>';
					} else {
						$options .= '<td></td>';
					}

					$options .= '
        					<td><span id="op_c' . $value->main_gl_number . '">#<span class="GyearC"></span>GL_O<span class="GopartC' . $value->main_gl_number . '"></span>_' . $value->main_gl_number . '@</span><button class="btn btn-sm btn-link" onclick="copyText(\'op_c' . $value->main_gl_number . '\')"><i class="fa fa-copy"></i></button></td>
        					<td><span id="dr_c' . $value->main_gl_number . '">#<span class="GyearC"></span>GL_D<span class="GopartC' . $value->main_gl_number . '"></span>_' . $value->main_gl_number . '@</span><button class="btn btn-sm btn-link" onclick="copyText(\'dr_c' . $value->main_gl_number . '\')"><i class="fa fa-copy"></i></button></td>
        					<td><span id="cr_c' . $value->main_gl_number . '">#<span class="GyearC"></span>GL_C<span class="GopartC' . $value->main_gl_number . '"></span>_' . $value->main_gl_number . '@</span><button class="btn btn-sm btn-link" onclick="copyText(\'cr_c' . $value->main_gl_number . '\')"><i class="fa fa-copy"></i></button></td>
        					<td><span id="tl_c' . $value->main_gl_number . '">#<span class="GyearC"></span>GL_T<span class="GopartC' . $value->main_gl_number . '"></span>_' . $value->main_gl_number . '@</span><button class="btn btn-sm btn-link" onclick="copyText(\'tl_c' . $value->main_gl_number . '\')"><i class="fa fa-copy"></i></button></td>
        				</tr>';
				}
				$response['status'] = 200;
				$response['body'] = $options;
			} else {
				$response['status'] = 201;
				$response['body'] = 'Data Not Found';
			}
		} else {
			$response['status'] = 201;
			$response['body'] = 'Required Parameter Missing';
		}
		echo json_encode($response);
	}

	public function createWordFile()
	{
		$template_id = $this->input->get('template_id');
		$year = $this->input->get('year');
		$month = $this->input->get('month');
		$where = array('id' => $template_id);
		$resultObject = $this->Master_Model->_select('report_maker_master', $where, "*", true);
		$fileName = 'report_' . $month . '_' . $year;
		if ($resultObject->totalCount > 0) {
			$fileName = $resultObject->data->template_name . '_' . $month . '_' . $year;
		}

		$phpWord = new PhpWord();
		$section = $phpWord->addSection();
		$htmlString = file_get_contents("htmlToWordConverterDoNotDelete.html");


		Html::addHtml($section, $htmlString, false, true);
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment;filename="test.docx');

		try {

			$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
			$objWriter->save('php://output');
		} catch (\PhpOffice\PhpWord\Exception\Exception $e) {
			var_dump($e);
		}

//		$objWriter->save('helloWorld.docx');
//		$html='htmlToWordConverterDoNotDelete.html';
//		$docx->embedHTML($html, array('isFile' => true));
//		$docx->createDocx($fileName);
	}

	public function addWordFileHtml()
	{
		if (!is_null($this->input->post('data'))) {
			$data = $this->input->post('data');
			file_put_contents('htmlToWordConverterDoNotDelete.html', $data);
			$response['status'] = 200;
			$response['body'] = '';

		} else {
			$response['status'] = 201;
			$response['body'] = 'Required Parameter Missing';
		}
		echo json_encode($response);
	}

	public function getGroupYearData()
	{
		if (!is_null($this->input->post('type'))) {
			$company_id = $this->session->userdata('company_id');
			$type = $this->input->post('type');
			$data = '';
			if ($type == 2) {
				$tableName = 'master_account_group_us';
			} else if ($type == 3) {
				$tableName = 'master_account_group_ifrs';
			} else {
				$tableName = 'master_account_group_ind';
			}
			$resultObject = $this->Master_Model->_rawQuery('select id,type1,type2,type3,is_divide from ' . $tableName . ' where status=1 and company_id=' . $company_id);
			if ($resultObject->totalCount > 0) {
				foreach ($resultObject->data as $value) {
					$value->type3=trim($value->type3);
					$value->type2=trim($value->type2);
					$value->type1=trim($value->type1);
					$data .= '<tr><td style="font-size:9px;">' . $value->type1 . '</td>
            				<td style="font-size:9px;">' . $value->type2 . '</td>
            				<td>' . $value->type3 . '</td>';
					if ($value->is_divide == 1) {
						$data .= '<td><input type="radio" name="divide' . $value->id . '" id="p1' . $value->id . '" value="" onclick="checkRadioCheck(' . $value->id . ')" checked> P1 <input type="radio" name="divide' . $value->id . '" id="p2' . $value->id . '" value="2" onclick="checkRadioCheck(' . $value->id . ')"> P2
            				</td>';
					} else {
						$data .= '<td></td>';
					}

					$data .= '<td><span id="o_cr' . $value->id . '">#<span class="gr_year"></span>GR_O<span class="partC' . $value->id . '"></span>_' . $value->id . '@</span><button class="btn btn-sm btn-link" onclick="copyText(\'o_cr' . $value->id . '\')"><i class="fa fa-copy"></i></button></td>
            				<td><span id="d_cr' . $value->id . '">#<span class="gr_year"></span>GR_D<span class="partC' . $value->id . '"></span>_' . $value->id . '@</span><button class="btn btn-sm btn-link" onclick="copyText(\'d_cr' . $value->id . '\')"><i class="fa fa-copy"></i></button></td>
            				<td><span id="c_cr' . $value->id . '">#<span class="gr_year"></span>GR_C<span class="partC' . $value->id . '"></span>_' . $value->id . '@</span><button class="btn btn-sm btn-link" onclick="copyText(\'c_cr' . $value->id . '\')"><i class="fa fa-copy"></i></button></td>
            				<td><span id="t_cr' . $value->id . '">#<span class="gr_year"></span>GR_T<span class="partC' . $value->id . '"></span>_' . $value->id . '@</span><button class="btn btn-sm btn-link" onclick="copyText(\'t_cr' . $value->id . '\')"><i class="fa fa-copy"></i></button></td></tr>';
				}
				$response['status'] = 200;
				$response['body'] = $data;
			} else {
				$response['status'] = 200;
				$response['body'] = $data;
			}

		} else {
			$response['status'] = 201;
			$response['body'] = 'Required Parameter Missing';
		}
		echo json_encode($response);
	}

	public function getGroupYearData2()
	{
		if (!is_null($this->input->post('type'))) {
			$company_id = $this->session->userdata('company_id');
			$type = $this->input->post('type');
			$data = '';
			if ($type == 2) {
				$tableName = 'master_account_group_us';
			} else if ($type == 3) {
				$tableName = 'master_account_group_ifrs';
			} else {
				$tableName = 'master_account_group_ind';
			}
			$resultObject = $this->Master_Model->_rawQuery('select id,type1,type2,is_divide from ' . $tableName . ' where status=1  and company_id=' . $company_id . " group by type2");
			if ($resultObject->totalCount > 0) {
				foreach ($resultObject->data as $value) {
					$value->type1=trim($value->type1);
					$value->type2=trim($value->type2);
					$data .= '<tr><td style="font-size:9px;">' . $value->type1 . '</td>
            				<td style="font-size:9px;">' . $value->type2 . '</td>';


					$data .= '<td><span id="t2o_cr' . $value->id . '">#<span class="gr_year2"></span>T2_O<span class="type2_partC"></span>_' . $value->type2 . '@</span><button class="btn btn-sm btn-link" onclick="copyText(\'t2o_cr' . $value->id . '\')"><i class="fa fa-copy"></i></button></td>
            				<td><span id="t2d_cr' . $value->id . '">#<span class="gr_year2"></span>T2_D<span class="type2_partC"></span>_' . $value->type2 . '@</span><button class="btn btn-sm btn-link" onclick="copyText(\'t2d_cr' . $value->id . '\')"><i class="fa fa-copy"></i></button></td>
            				<td><span id="t2c_cr' . $value->id . '">#<span class="gr_year2"></span>T2_C<span class="type2_partC"></span>_' . $value->type2 . '@</span><button class="btn btn-sm btn-link" onclick="copyText(\'t2c_cr' . $value->id . '\')"><i class="fa fa-copy"></i></button></td>
            				<td><span id="t2t_cr' . $value->id . '">#<span class="gr_year2"></span>T2_T<span class="type2_partC"></span>_' . $value->type2 . '@</span><button class="btn btn-sm btn-link" onclick="copyText(\'t2t_cr' . $value->id . '\')"><i class="fa fa-copy"></i></button></td></tr>';
				}
				$response['status'] = 200;
				$response['body'] = $data;
			} else {
				$response['status'] = 200;
				$response['body'] = $data;
			}

		} else {
			$response['status'] = 201;
			$response['body'] = 'Required Parameter Missing';
		}
		echo json_encode($response);
	}

	public function getGroupYearData24()
	{
		if (!is_null($this->input->post('type'))) {
			$arrType1 = array('EQUITY AND LIABILITIES', 'ASSETS', 'EXPENSES', 'REVENUE');
			$arrType2 = array(
				'EQUITY AND LIABILITIES' => array('SHAREHOLDERS FUNDS', 'Current Liabilities', 'Current Assets'),
				'ASSETS' => array('SHAREHOLDERS FUNDS', 'Current Liabilities', 'Current Assets'),
				'EXPENSES' => array('Non-Current Assets', 'Non-Current Liabilities'),
				'REVENUE' => array('Non-Current Assets', 'Non-Current Liabilities')
			);


			$data = '';
			if (count($arrType1) > 0) {
				$count = 1;
				foreach ($arrType1 as $value) {
					$type2arr = $arrType2[$value];
					if ($value == 'EQUITY AND LIABILITIES') {
						$type1_key_code = 'EQ';
					}
					if ($value == 'ASSETS') {
						$type1_key_code = 'AS';
					}
					if ($value == 'EXPENSES') {
						$type1_key_code = 'EX';
					}
					if ($value == 'REVENUE') {
						$type1_key_code = 'RE';
					}

					for ($i = 0; $i < count($type2arr); $i++) {
						if ($i == 0) {
							$type1_name = $value;
						} else {
							$type1_name = '';
						}
						if ($type2arr[$i] == 'SHAREHOLDERS FUNDS') {
							$type2_key_code = 'SH';
						}
						if ($type2arr[$i] == 'Current Liabilities') {
							$type2_key_code = 'CL';
						}
						if ($type2arr[$i] == 'Current Assets') {
							$type2_key_code = 'CA';
						}
						if ($type2arr[$i] == 'Non-Current Assets') {
							$type2_key_code = 'NCA';
						}
						if ($type2arr[$i] == 'Non-Current Liabilities') {
							$type2_key_code = 'NCL';
						}

						$data .= '<tr>
										<td>' . $type1_name . '</td>
										<td>' . $type2arr[$i] . '</td>
										<td><span id="' . $type1_key_code . '_' . $type2_key_code . '_O_' . $i . '">#<span class="gr_year2"></span>' . $type1_key_code . '_' . $type2_key_code . '_O<span class="type2_partC"></span>@</span><button class="btn btn-sm btn-link" onclick="copyText(\'' . $type1_key_code . '_' . $type2_key_code . '_O_' . $i . '\')"><i class="fa fa-copy"></i></button></td>
										<td><span id="' . $type1_key_code . '_' . $type2_key_code . '_D_' . $i . '">#<span class="gr_year2"></span>' . $type1_key_code . '_' . $type2_key_code . '_D<span class="type2_partC"></span>@</span><button class="btn btn-sm btn-link" onclick="copyText(\'' . $type1_key_code . '_' . $type2_key_code . '_D_' . $i . '\')"><i class="fa fa-copy"></i></button></td>
										<td><span id="' . $type1_key_code . '_' . $type2_key_code . '_C_' . $i . '">#<span class="gr_year2"></span>' . $type1_key_code . '_' . $type2_key_code . '_C<span class="type2_partC"></span>@</span><button class="btn btn-sm btn-link" onclick="copyText(\'' . $type1_key_code . '_' . $type2_key_code . '_C_' . $i . '\')"><i class="fa fa-copy"></i></button></td>
										<td><span id="' . $type1_key_code . '_' . $type2_key_code . '_T_' . $i . '">#<span class="gr_year2"></span>' . $type1_key_code . '_' . $type2_key_code . '_T<span class="type2_partC"></span>@</span><button class="btn btn-sm btn-link" onclick="copyText(\'' . $type1_key_code . '_' . $type2_key_code . '_T_' . $i . '\')"><i class="fa fa-copy"></i></button></td></tr>
										</tr>';
					}
					$count++;
				}
				$response['status'] = 200;
				$response['body'] = $data;
			} else {
				$response['status'] = 200;
				$response['body'] = $data;
			}

		} else {
			$response['status'] = 201;
			$response['body'] = 'Required Parameter Missing';
		}
		echo json_encode($response);
	}

	public function getGroupYearData1()
	{
		if (!is_null($this->input->post('type'))) {
			$arrType1 = array('EQUITY AND LIABILITIES', 'ASSETS', 'EXPENSES', 'REVENUE');


			$data = '';
			if (count($arrType1) > 0) {
				$count = 1;
				$i = 1;
				foreach ($arrType1 as $value) {
					if ($value == 'EQUITY AND LIABILITIES') {
						$type1_key_code = 'EQ';
					}
					if ($value == 'ASSETS') {
						$type1_key_code = 'AS';
					}
					if ($value == 'EXPENSES') {
						$type1_key_code = 'EX';
					}
					if ($value == 'REVENUE') {
						$type1_key_code = 'RE';
					}


					$data .= '<tr>
										<td>' . $value . '</td>
										<td><span id="' . $type1_key_code . '_O_' . $i . '">#<span class="gr_year1"></span>' . $type1_key_code . '_T1_O<span class="type1_partC"></span>@</span><button class="btn btn-sm btn-link" onclick="copyText(\'' . $type1_key_code . '_O_' . $i . '\')"><i class="fa fa-copy"></i></button></td>
										<td><span id="' . $type1_key_code . '_D_' . $i . '">#<span class="gr_year1"></span>' . $type1_key_code . '_T1_D<span class="type1_partC"></span>@</span><button class="btn btn-sm btn-link" onclick="copyText(\'' . $type1_key_code . '_D_' . $i . '\')"><i class="fa fa-copy"></i></button></td>
										<td><span id="' . $type1_key_code . '_C_' . $i . '">#<span class="gr_year1"></span>' . $type1_key_code . '_T1_C<span class="type1_partC"></span>@</span><button class="btn btn-sm btn-link" onclick="copyText(\'' . $type1_key_code . '_C_' . $i . '\')"><i class="fa fa-copy"></i></button></td>
										<td><span id="' . $type1_key_code . '_T_' . $i . '">#<span class="gr_year1"></span>' . $type1_key_code . '_T1_T<span class="type1_partC"></span>@</span><button class="btn btn-sm btn-link" onclick="copyText(\'' . $type1_key_code . '_T_' . $i . '\')"><i class="fa fa-copy"></i></button></td></tr>
										</tr>';

					$i++;
				}
				$response['status'] = 200;
				$response['body'] = $data;
			} else {
				$response['status'] = 200;
				$response['body'] = $data;
			}

		} else {
			$response['status'] = 201;
			$response['body'] = 'Required Parameter Missing';
		}
		echo json_encode($response);
	}

	public function getConsolidatedMonth(){
		$year=$this->input->post('year');
		$template_id = $this->input->post('template_id');
		$company_id = $this->session->userdata('company_id');
		$where = array('id' => $template_id,'templateVersion'=>1);
		if(!empty($year) && !is_null($year)){
			$resultObject = $this->Master_Model->_select('report_maker_master_table', $where, "*", true);

			if ($resultObject->totalCount > 0) {
				 $type = $resultObject->data->type;
				if ($type == 2) {
					$tableName = 'consolidate_report_transaction_us';
				} else if ($type == 3) {
					$tableName = 'consolidate_report_transaction_ifrs';
				} else {
					$tableName = 'consolidate_report_transaction';
				}
				$resultObject1 = $this->Master_Model->_rawQuery('select month from '.$tableName.' where year='.$year.' AND company_id='.$company_id.' group by month');

				if ($resultObject1->totalCount > 0) {
					$data= $resultObject1->data;
					$option='';
					$months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
					foreach ($data as $month_number){
						$m= $month_number->month;
						$mon= $months[$m];


						$option .='<option value="'.$month_number->month.'">'.$mon.'</option>';
					}
					$response['status'] = 200;
					$response['option'] = $option;
				}else{
					$response['status'] = 201;
					$response['body'] = 'Consolidation Not done for any month';
				}
			}else{
				$response['status'] = 201;
				$response['body'] = 'Something Went Wrong';
			}

		}else{
			$response['status'] = 201;
			$response['body'] = 'Required Parameter Missing';
		}echo json_encode($response);
	}
}

?>
