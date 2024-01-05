<?php
//require 'vendor/autoload.php';
/*use Dompdf\Dompdf;
use Dompdf\Options;*/
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property  Master_Model Master_Model
 */
// reference the Dompdf namespace

class ReportVersion3Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Excelsheet_model');
	}

	public function index($template_id)
	{
		$this->load->view("version3/tablereportVersion3TemplateBuilder", array("title" => "Report View", 'template_id' => $template_id));
	}

	public function version3Report()
	{
		$this->load->view("version3/version3Report", array("title" => "Report list View"));
	}
	public function version3reportMaker()
	{
		$this->load->view("version3/version3reportMaker", array("title" => "Report list View"));
	}

	public function GetReportView()
	{
		$type = $this->input->post('type');
		$reportType = $this->input->post('reportType');
		$filter = $this->input->post('filter');
		$user_type = $this->session->userdata('user_type');
		$company_id = $this->session->userdata('company_id');
		$where=array('company_id' => $company_id, "type" => $type,"templateVersion"=>2,"report_type"=>$reportType);
		if($filter!=0)
		{
			$where['status']=$filter;
		}
		$mbData = $this->db
			->select(array("*"))
			->where($where)
			->order_by('id', 'desc')
			->get("report_maker_master_table")->result();
		//	echo $this->db->last_query();
		$tableRows = array();
		if (count($mbData) > 0) {
			$i = 1;
			foreach ($mbData as $order) {
//				if ($order->status == 1) {
//					$status = 'Active';
//				} else {
//					$status = 'InActive';
//				}
				array_push($tableRows, array(
						$i,
						$order->id,
						$order->template_name,
						$order->status,
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
		$this->load->view("version3/tablereportMakerByMonthVersion3", array("title" => "Report list View", "id" => $id, "templateName" => $templateName));
	}

	public function createTableReportMonthHandson()
	{
		if (!is_null($this->input->post('month')) && $this->input->post('month') != "" && !is_null($this->input->post('year')) && $this->input->post('year') != "") {
			$month = $this->input->post('month');
			$year = $this->input->post('year');
			 $branch = $this->input->post('branch');
//			$amount_type = $this->input->post('amount_type');
			$template_id = $this->input->post('template_id');
			$tempName = $this->input->post('tempName');
			$html = '';
			// $html = ob_get_clean();
			$where = array('id' => $template_id,'templateVersion'=>2);
			$number_conversion = 0;
			$resultObject = $this->Master_Model->_select('report_maker_master_table', $where, "*", true);
			if ($resultObject->totalCount > 0) {
				$header=array();
				$columnType=array();
				$hideColumns=array(2,3,4,10,11);
				$columnSummary=array();
				for ($i=1;$i<=10;$i++)
				{
					array_push($header,'column_'.$i);
					array_push($columnType,array('type'=>'text'));
				}
				array_push($header,'is_report_template','report_id');
				array_push($columnType,array('type'=>'text'),array('type'=>'text'));
				$rows=array();

				$type = $resultObject->data->type;
				$currency_type = $resultObject->data->currency_type;
				$number_conversion = $resultObject->data->number_conversion;
				$response['style'] = json_decode($resultObject->data->style);
				$response['template_name'] =  $resultObject->data->template_name;

				$report_where = array('template_id' => $template_id);
				$reportObject = $this->Master_Model->_select('table_reportmaker_transaction', $report_where, "*", false);
				if($branch == 'All'){
					$currency='LOCAL';
				}else{
					$currencyObject = $this->Master_Model->_select('branch_master', array('id'=>$branch), "currency", false);
					$currency='LOCAL';
					if($currencyObject->totalCount>0)
					{
						$currency=$currencyObject->data[0]->currency;
					}
				}

				$output = array_map(function ($object) {
					return $object->column_1.$object->column_2.$object->column_3.$object->column_4.$object->column_5.$object->column_6.$object->column_7.$object->column_8
						.$object->column_9.$object->column_10;
				}, $reportObject->data);
				$opt= implode(', ', $output);

				$tableString=$this->getColumnTextData($opt,$month,$year,$number_conversion,$type,$branch,$currency_type);
				if($currency_type==1)
				{
					array_push($hideColumns,6);
				}else if($currency_type==3)
				{
					array_push($hideColumns,5);
				}
				if($reportObject->totalCount>0)
				{
					$reportData=array();
					$reportdata=$reportObject->data;

					foreach ($reportdata as $rkey=> $rrow)
					{
						$rowdata=array();
						for($i=1;$i<=10;$i++)
						{
							$columnName='column_'.$i;
							if($rkey==6 && $i==6)
							{
								$columnText=$currency;
							}
							else{
								$columnText=$rrow->$columnName;
							}
							if($currency_type==2 || $currency_type==3)
							{
								if($rkey==6 && $i==7)
								{
									$columnText='INR';
								}
							}
							if($i==1 && $rkey==0) {
								$columnText=$tempName;
							}
							if($i==1 && $rkey==1) {
								$columnText="Month -".$month;
							}
							if($i==2 && $rkey==1){
								$columnText="Year -".$year;
							}

							$columnText = str_replace(",", "", $columnText);

							if($columnText!="" && $columnText!=null)
							{
								if(array_key_exists($columnText,$tableString))
								{
//									print_r($columnText);
									$columnText=$columnText;
								}
							}
							else{
								$col_5=$rrow->column_5;
								if(array_key_exists($col_5,$tableString))
								{
									if($i==6)
									{
										$columnText=number_format($tableString[$col_5]->data_local,2);
									}
									if($i==7)
									{
										$columnText=number_format($tableString[$col_5]->data_inr,2);
									}

								}
							}
							array_push($rowdata,$columnText);
//							if($columnText == 'CALCULATED'){
//								$arrayNew=array();
//								$formula=rtrim($rrow->column_4,",");
//								//$arr1=array_map('intval', explode(',', $formula));
//								$arr1=explode(',', $formula);
//								foreach ($arr1 as $a2){
//									if($a2 !=""){
//										$a1=array($a2);
//										array_push($arrayNew,$a1);
//									}
//								}
//								$a=5;
//								$colOBj=new stdClass();
//								$colOBj->ranges=$arrayNew;
//								$colOBj->destinationRow=$rkey;
//								$colOBj->destinationColumn=$a;
//								$colOBj->reversedRowCoords=false;
//								$colOBj->type='sum';
//								$colOBj->forceNumeric=true;
//								array_push($columnSummary, $colOBj);
//							}
						}
						array_push($rowdata,$rrow->is_report_template,$rrow->report_id);
						array_push($reportData,$rowdata);
					}

					$response['status'] = 200;
					$response['body'] = $html;
					$response['header'] = $header;
					$response['rows'] = $reportData;
					$response['columnType'] = $columnType;
					$response['hideColumns'] = $hideColumns;
					$response['columnSummary'] = $columnSummary;
					$response['number_conversion'] = $number_conversion;
				}
				else{
					$response['status'] = 201;
					$response['body'] = 'No data found';
					$response['number_conversion'] = $number_conversion;
				}
			}
			else{
				$response['status'] = 201;
				$response['body'] = 'No data found';
				$response['number_conversion'] = $number_conversion;
			}
		} else {
			$response['status'] = 201;
			$response['body'] = 'No data found';
		}
		echo json_encode($response);
	}
	function getColumnTextData($html,$month,$year,$number_conversion,$type,$branch,$currency_type)
	{
		if($currency_type==3)
		{
			$currency_type=2;
		}
		$textReplaceArray=array();

		$country_master = $this->Master_Model->getQuarter();
		$divide = 1;
		if ($number_conversion == 1) { //thousand
			$divide = 1000;
		}
		if ($number_conversion == 2) { //lakhs
			$divide = 100000;
		}
		if ($number_conversion == 3) { //crores
			$divide = 10000000;
		}
		if ($number_conversion == 4) { //millions
			$divide = 1000000;
		}
		$month_name = $country_master[$month];
		//month replace
		$textReplaceArray['#month']=$month_name;

		//year replace
		$textReplaceArray['#year']=$year;

		$html1 = preg_replace("!<span[^>]+>!", '', $html);
		$html = preg_replace("!</span>!", '', $html1);

		preg_match_all("/#+[\w\s\-]*@+/i", $html, $matchArray);
		foreach ($matchArray[0] as $typeIndex => $value) {
			$value = str_replace(",", "", $value);

			$value1 = str_replace('#', '', $value);

			$value1 = str_replace('@', '', $value1);

			$value2 = explode('_', $value1);
			if (count($value2) > 2) {
				$value2[0]=trim($value2[0]);
				if (strpos($value2[0], 'GL') !== false) {
					$gl_data = $this->getGLAccountData($value2[1], $value2[2], $month, $year, $type, $value2[0],$branch,$currency_type);
					$gl_value=new stdClass();
					$gl_data->data_local =str_replace(',', '', $gl_data->data_local);
					$gl_value->data_local = $gl_data->data_local / $divide;
//					$gl_value->data_local = number_format($gl_value->data_local,2);
					$gl_data->data_inr =str_replace(',', '', $gl_data->data_inr);
					$gl_value->data_inr = $gl_data->data_inr / $divide;
//					$gl_value->data_inr = number_format($gl_value->data_inr,2);
					$textReplaceArray[$value]=$gl_value;
				}
				if (strpos($value2[0], 'GR') !== false) {
					$gl_data = $this->getGRAccountDataReport($value2[1], $value2[2], $month, $year, $type, $value2[0],$branch,$currency_type);
					$gl_value=new stdClass();
					$gl_data->data_local =str_replace(',', '', $gl_data->data_local);
					$gl_value->data_local = $gl_data->data_local / $divide;
//					$gl_value->data_local = number_format($gl_value->data_local,2);
					$gl_data->data_inr =str_replace(',', '', $gl_data->data_inr);
					$gl_value->data_inr = $gl_data->data_inr / $divide;
//					$gl_value->data_inr = number_format($gl_value->data_inr,2);
					$textReplaceArray[$value]=$gl_value;
				}
				if (strpos($value2[0], 'T2') !== false) {
					$gl_data = $this->getT2AccountDataReport($value2[1], $value2[2], $month, $year, $type, $value2[0],$branch,$currency_type);
					$gl_value=new stdClass();
					$gl_data->data_local =str_replace(',', '', $gl_data->data_local);
					$gl_value->data_local = $gl_data->data_local / $divide;
//					$gl_value->data_local = number_format($gl_value->data_local,2);
					$gl_data->data_inr =str_replace(',', '', $gl_data->data_inr);
					$gl_value->data_inr = $gl_data->data_inr / $divide;
//					$gl_value->data_inr = number_format($gl_value->data_inr,2);
					$textReplaceArray[$value]=$gl_value;
				}

				if (strpos($value2[0], 'EQ') !== false || strpos($value2[0], 'AS') !== false || strpos($value2[0], 'EX') !== false || strpos($value2[0], 'RE') !== false) {
					if ($value2[1] == 'T1') {
						$gl_data = $this->getType1AccountDataReport($value2[0], $value2[1], $value2[2], $month, $year, $type,$branch,$currency_type);
					} else {
						$gl_data = $this->getTypeAccountDataReport($value2[0], $value2[1], $value2[2], $month, $year, $type,$branch,$currency_type);
					}
					$gl_value=new stdClass();
					$gl_data->data_local =str_replace(',', '', $gl_data->data_local);
					$gl_value->data_local = $gl_data->data_local / $divide;
//					$gl_value->data_local = number_format($gl_value->data_local,2);
					$gl_data->data_inr =str_replace(',', '', $gl_data->data_inr);
					$gl_value->data_inr = $gl_data->data_inr / $divide;
//					$gl_value->data_inr = number_format($gl_value->data_inr,2);
					$textReplaceArray[$value]=$gl_value;
				}
			}
			else{
				$value2[0]=trim($value2[0]);
				if (strpos($value2[0], 'DF') !== false) {
					$gl_data = $this->getDFAccountData($value2[1],$type, $value2[0],$branch,$currency_type);
					$gl_value=new stdClass();
					$gl_data->data_local =str_replace(',', '', $gl_data->data_local);
					$gl_value->data_local = $gl_data->data_local / $divide;
//					$gl_value->data_local = number_format($gl_value->data_local,2);
					$gl_data->data_inr =str_replace(',', '', $gl_data->data_inr);
					$gl_value->data_inr = $gl_data->data_inr / $divide;
//					$gl_value->data_inr = number_format($gl_value->data_inr,2);
					$textReplaceArray[$value]=$gl_value;
				}
			}

		}
		$formulaArray = $this->tag_contents1($html, "<code>", "</code>");
		foreach ($formulaArray as $fvalue) {

			preg_match_all("/#+[\w\s\-]*@+/i", $fvalue, $matchArray1);
			$string_local=$fvalue;
			$string_inr=$fvalue;
			foreach ($matchArray1[0] as $typeIndex1 => $tvalue1) {

				$tvalue = str_replace(",", "", $tvalue1);
				$string=$textReplaceArray[$tvalue];
				$string_local=str_replace($tvalue1, $string->data_local, $string_local);
				$string_inr=str_replace($tvalue1, $string->data_inr, $string_inr);
			}

			$string_local=strip_tags($string_local);
			$string_local = str_replace(",", "", $string_local);
			$result_local=0;
			if($string_local != ""){
				$math_string_local = "return (" . $string_local . ");";
				if (strpos($math_string_local, '/0') !== false) {
					$result_local = "0";
				} else {
					$result_local = eval($math_string_local);
				}
			}
			$result_inr=0;
			if($string_inr != ""){
				$math_string_inr = "return (" . $string_inr . ");";
				if (strpos($math_string_inr, '/0') !== false) {
					$result_inr = "0";
				} else {
					$result_inr = eval($math_string_inr);
				}
			}
			$formula_value=new stdClass();
			$formula_value->data_local=$result_local;
			$formula_value->data_inr=$result_inr;
//			$string2 = strip_tags($string);
//			$string = str_replace(",", "", $string2);
//			$result1=0;
//			if($string != ""){
//				$math_string = "return (" . $string . ");";
//				if (strpos($math_string, '/0') !== false) {
//					$result1 = "0";
//				} else {
//					$result1 = eval($math_string);
//
//				}
//			}
			$textReplaceArray["<code>" . $fvalue . "</code>"]=$formula_value;
		}
		return $textReplaceArray;
	}

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

	function getGLAccountData($columns, $gl_ac, $month, $year, $type, $attr,$branch,$currency_type)
	{
		$data = 0;
		$column = 'T';
		$column2='';

		switch ($columns) {
			case 'O':
				$column = 'opening_balance';
				$column2='opening_balance_2';
				break;
			case 'C':
				$column = 'credit';
				$column2='credit_2';
				break;
			case 'D':
				$column = 'debit';
				$column2 = 'debit_2';
				break;
			case 'T':
				$column = 'total';
				$column2 = 'total_2';
				break;
			case 'O2':
				$column = 'opening_balance_1';
				$column2 = 'opening_balance_2';
				break;
			case 'C2':
				$column = 'credit_1';
				$column2 = 'credit_2';
				break;
			case 'D2':
				$column = 'debit_1';
				$column2 = 'debit_2';
				break;
			case 'T2':
				$column = 'total_1';
				$column2 = 'total_2';
				break;
		}
		$data = $this->getGLBalanceQueryData($month, $year, $column, $column2, $gl_ac, $type, $attr,$branch,$currency_type);

		return $data;
	}
	function getGRBalanceQueryData($month, $year, $column,$column2, $gr_id, $type, $attr,$branch,$currency_type)
	{
		$company_id = $this->session->userdata('company_id');
//		$data = 0;
		$data = new stdClass();
		$data->data_local=0;
		$data->data_inr=0;
		$columnName = '';



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
			if($currency_type==2)
			{
				if($branch_ic == 'All'){
					$resultObject = $this->Master_Model->_rawQuery('select sum(' . $column . ') as data_local,sum('.$column2.') as data_inr from ' . $consolidate_table . ' where year=? and month =? and company_id= ?  and account_number in (select main_gl_number from ' . $main_table . ' where group_id=?)', array((int)$year1, (int)$month, $company_id ,$gr_id));
				}else{
					$resultObject = $this->Master_Model->_rawQuery('select sum(' . $column . ') as data_local,sum('.$column2.') as data_inr from ' . $consolidate_table . ' where year=? and month =? and company_id= ? and branch_id =? and account_number in (select main_gl_number from ' . $main_table . ' where group_id=?)', array((int)$year1, (int)$month, $company_id,$branch_ic ,$gr_id));
				}

				if ($resultObject->totalCount > 0) {
					if($negative == true){
						if($resultObject->data[0]->data_local < 0){
							$resultObject->data[0]->data_local=abs($resultObject->data[0]->data_local);
						}else{
							$resultObject->data[0]->data_local=-($resultObject->data[0]->data_local);
						}
						if($resultObject->data[0]->data_inr < 0){
							$resultObject->data[0]->data_inr=abs($resultObject->data[0]->data_inr);
						}else{
							$resultObject->data[0]->data_inr=-($resultObject->data[0]->data_inr);
						}
					}
					$data->data_local = number_format($resultObject->data[0]->data_local);
					if ($data->data_local == "") {
						$data->data_local = 0;
					}
					$data->data_inr = number_format($resultObject->data[0]->data_inr);
					if ($data->data_inr == "") {
						$data->data_inr = 0;
					}
				}
			}
			else{
				if($branch_ic == 'All'){
					$resultObject = $this->Master_Model->_rawQuery('select sum(' . $column . ') as data from ' . $consolidate_table . ' where year=? and month =? and company_id= ? and account_number in (select main_gl_number from ' . $main_table . ' where group_id=?)', array((int)$year1, (int)$month, $company_id ,$gr_id));
				}else{
					$resultObject = $this->Master_Model->_rawQuery('select sum(' . $column . ') as data from ' . $consolidate_table . ' where year=? and month =? and company_id= ? and branch_id =? and account_number in (select main_gl_number from ' . $main_table . ' where group_id=?)', array((int)$year1, (int)$month, $company_id,$branch_ic ,$gr_id));
				}

				if ($resultObject->totalCount > 0) {
					if($negative == true){
						if($resultObject->data[0]->data < 0){
							$resultObject->data[0]->data=abs($resultObject->data[0]->data);
						}else{
							$resultObject->data[0]->data=-($resultObject->data[0]->data);
						}
					}
					$data->data_local = number_format($resultObject->data[0]->data);
					if ($data->data_local == "") {
						$data->data_local= 0;
					}
				}
			}

		}

		return $data;
	}

	function getT2BalanceQueryData($month, $year, $column,$column2, $type2, $type, $attr,$branch,$currency_type)
	{
		$company_id = $this->session->userdata('company_id');

		$data = new stdClass();
		$data->data_local = 0;
		$data->data_inr = 0;
		$columnName = '';


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
			if($currency_type==2) {
				if($branch_ic == 'All'){
					$resultObject = $this->Master_Model->_rawQuery('select sum(' . $column . ') as data_local,sum(' . $column2 . ') as data_inr from ' . $consolidate_table . ' where year=? and month =? and company_id= ?  and  find_in_set(account_number,"' . $main_gl_numbers . '")', array((int)$year1, (int)$month, $company_id));
				}else{
					$resultObject = $this->Master_Model->_rawQuery('select sum(' . $column . ') as data_local,sum(' . $column2 . ') as data_inr from ' . $consolidate_table . ' where year=? and month =? and company_id= ? and branch_id=? and  find_in_set(account_number,"' . $main_gl_numbers . '")', array((int)$year1, (int)$month, $company_id,$branch_ic));
				}
				if ($resultObject->totalCount > 0) {
					if($negative == true){
						if($resultObject->data[0]->data_local < 0){
							$resultObject->data[0]->data_local=abs($resultObject->data[0]->data_local);
						}else{
							$resultObject->data[0]->data_local=-($resultObject->data[0]->data_local);
						}
						if($resultObject->data[0]->data_inr < 0){
							$resultObject->data[0]->data_inr=abs($resultObject->data[0]->data_inr);
						}else{
							$resultObject->data[0]->data_inr=-($resultObject->data[0]->data_inr);
						}
					}
					$data->data_local = number_format($resultObject->data[0]->data_local);
					if ($data->data_local == "") {
						$data->data_local = 0;
					}
					$data->data_inr = number_format($resultObject->data[0]->data_inr);
					if ($data->data_inr == "") {
						$data->data_inr = 0;
					}
				}
			}
			else{
				if($branch_ic == 'All'){
					$resultObject = $this->Master_Model->_rawQuery('select sum(' . $column . ') as data from ' . $consolidate_table . ' where year=? and month =? and company_id= ? and find_in_set(account_number,"' . $main_gl_numbers . '")', array((int)$year1, (int)$month, $company_id));
				}else{
					$resultObject = $this->Master_Model->_rawQuery('select sum(' . $column . ') as data from ' . $consolidate_table . ' where year=? and month =? and company_id= ? and branch_id=? and  find_in_set(account_number,"' . $main_gl_numbers . '")', array((int)$year1, (int)$month, $company_id,$branch_ic));
				}

				if ($resultObject->totalCount > 0) {
					if($negative == true){
						if($resultObject->data[0]->data < 0){
							$resultObject->data[0]->data=abs($resultObject->data[0]->data);
						}else{
							$resultObject->data[0]->data=-($resultObject->data[0]->data);
						}
					}
					$data->data_local = number_format($resultObject->data[0]->data);
					if ($data->data_local == "") {
						$data->data_local= 0;
					}
				}
			}


		}

		return $data;
	}

	function getGLBalanceQueryData($month, $year, $column, $column2, $gl_ac, $type, $attr,$branch,$currency_type)
	{
		$company_id = $this->session->userdata('company_id');
		$data = new stdClass();
		$data->data_local = 0;
		$data->data_inr = 0;
		$columnName = '';
		$branchName='';
		$branch_ic='';

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

			if($currency_type==2)
			{
				if($branch_ic == "All"){
					$resultObject = $this->Master_Model->_rawQuery('select sum(' . $column . ') as data_local,sum(' . $column2 . ') as data_inr from ' . $consolidate_table . ' where year=? and month =? and company_id= ? and account_number = ? ', array((int)$year1, (int)$month, $company_id, $gl_ac));
				}else{
					$resultObject = $this->Master_Model->_rawQuery('select sum(' . $column . ') as data_local,sum(' . $column2 . ') as data_inr from ' . $consolidate_table . ' where year=? and month =? and company_id= ? and account_number = ? And branch_id=?', array((int)$year1, (int)$month, $company_id, $gl_ac,$branch_ic));
				}


				if ($resultObject->totalCount > 0) {
					if($negative == true){
						if($resultObject->data[0]->data_local < 0){
							$resultObject->data[0]->data_local=abs($resultObject->data[0]->data_local);
						}else{
							$resultObject->data[0]->data_local=-($resultObject->data[0]->data_local);
						}
						if($resultObject->data[0]->data_inr < 0){
							$resultObject->data[0]->data_inr=abs($resultObject->data[0]->data_inr);
						}else{
							$resultObject->data[0]->data_inr=-($resultObject->data[0]->data_inr);
						}
					}
					$data->data_local = number_format($resultObject->data[0]->data_local);
					if ($data->data_local == "") {
						$data->data_local = 0;
					}
					$data->data_inr = number_format($resultObject->data[0]->data_inr);
					if ($data->data_inr == "") {
						$data->data_inr = 0;
					}
				}
			}
			else{
				if($branch_ic == "All"){
					$resultObject = $this->Master_Model->_rawQuery('select sum(' . $column . ') as data from ' . $consolidate_table . ' where year=? and month =? and company_id= ? and account_number = ?', array((int)$year1, (int)$month, $company_id, $gl_ac));
				}else{
					$resultObject = $this->Master_Model->_rawQuery('select sum(' . $column . ') as data from ' . $consolidate_table . ' where year=? and month =? and company_id= ? and account_number = ? And branch_id=?', array((int)$year1, (int)$month, $company_id, $gl_ac,$branch_ic));
				}

				if ($resultObject->totalCount > 0) {
					if($negative == true){
						if($resultObject->data[0]->data < 0){
							$resultObject->data[0]->data=abs($resultObject->data[0]->data);
						}else{
							$resultObject->data[0]->data=-($resultObject->data[0]->data);
						}
					}
					$data->data_local = number_format($resultObject->data[0]->data);
					if ($data->data_local == "") {
						$data->data_local= 0;
					}
				}
			}


//			print_r($resultObject);exit();
//			if ($resultObject->totalCount > 0) {
//				if($negative == true){
//					if($resultObject->data[0]->data < 0){
//						$resultObject->data[0]->data=abs($resultObject->data[0]->data);
//					}else{
//						$resultObject->data[0]->data=-($resultObject->data[0]->data);
//					}
//				}
//				$data = number_format($resultObject->data[0]->data);
//				if ($data == "") {
//					$data = 0;
//				}
		}

		return $data;
	}

	function getGRAccountDataReport($columns, $gr_id, $month, $year, $type, $attr,$branch,$currency_type)
	{
		$data = 0;
		$column = 'T';
		$column2='';
		switch ($columns) {

			case 'O':
				$column = 'opening_balance';
				$column2 = 'opening_balance_2';
				break;
			case 'C':
				$column = 'credit';
				$column2 = 'credit_2';
				break;
			case 'D':
				$column = 'debit';
				$column2 = 'debit_2';
				break;
			case 'T':
				$column = 'total';
				$column2 = 'total_2';
				break;
			case 'O2':
				$column = 'opening_balance+opening_balance_1';
				$column2 = 'opening_balance_2';
				break;
			case 'C2':
				$column = 'credit+credit_1';
				$column2 = 'credit_2';
				break;
			case 'D2':
				$column = 'debit+debit_1';
				$column2 = 'debit_2';
				break;
			case 'T2':
				$column = 'total+total_1';
				$column2 = 'total_2';
				break;
		}

		$data = $this->getGRBalanceQueryData($month, $year, $column,$column2, $gr_id, $type, $attr,$branch,$currency_type);

		return $data;
	}

	function getT2AccountDataReport($columns, $gr_id, $month, $year, $type, $attr,$branch,$currency_type)
	{
		$data = 0;
		$column = 'T';
		$column2='';
		switch ($columns) {

			case 'O':
				$column = 'opening_balance';
				$column2 = 'opening_balance_2';
				break;
			case 'C':
				$column = 'credit';
				$column2 = 'credit_2';
				break;
			case 'D':
				$column = 'debit';
				$column2 = 'debit_2';
				break;
			case 'T':
				$column = 'total';
				$column2 = 'total_2';
				break;
			case 'O2':
				$column = 'opening_balance+opening_balance_1';
				$column2 = 'opening_balance_2';
				break;
			case 'C2':
				$column = 'credit+credit_1';
				$column2 = 'credit_2';
				break;
			case 'D2':
				$column = 'debit+debit_1';
				$column2 = 'debit_2';
				break;
			case 'T2':
				$column = 'total+total_1';
				$column2 = 'total_2';
				break;
		}

		$data = $this->getT2BalanceQueryData($month, $year, $column,$column2, $gr_id, $type, $attr,$branch,$currency_type);

		return $data;
	}

	function getTypeAccountDataReport($type1, $type2, $columns, $month, $year, $type,$branch,$currency_type)
	{
		$data = 0;
		$column = 'T';
		$column2 = '';
		switch ($columns) {

			case 'O':
				$column = 'opening_balance';
				$column2 = 'opening_balance_2';
				break;
			case 'C':
				$column = 'credit';
				$column2 = 'credit_2';
				break;
			case 'D':
				$column = 'debit';
				$column2 = 'debit_2';
				break;
			case 'T':
				$column = 'total';
				$column2 = 'total_2';
				break;
			case 'O2':
				$column = 'opening_balance+opening_balance_1';
				$column2 = 'opening_balance_2';
				break;
			case 'C2':
				$column = 'credit+credit_1';
				$column2 = 'credit_2';
				break;
			case 'D2':
				$column = 'debit+debit_1';
				$column2 = 'debit_2';
				break;
			case 'T2':
				$column = 'total+total_1';
				$column2 = 'total_2';
				break;
		}

		$data = $this->getTypeBalanceQueryData($month, $year, $column,$column2, $type1, $type2, $type,$branch,$currency_type);

		return $data;
	}

	function getTypeBalanceQueryData($month, $year, $column,$column2, $type1, $type2, $type,$branch,$currency_type)
	{
		$company_id = $this->session->userdata('company_id');
		$data = new stdClass();
		$data->data_local = 0;
		$data->data_inr = 0;
		$columnName = '';


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
			if($currency_type==2){
				$resultObject = $this->Master_Model->_rawQuery('select sum(' . $column . ') as data_local,sum(' . $column2 . ') as data_inr from ' . $consolidate_table . ' where year=? and month =? and company_id= ? and account_number in (select main_gl_number from ' . $main_table . ' where company_id=? and type1=? and type2=?) and branch_id=?', array((int)$year1, (int)$month, $company_id, $company_id, $type1_value, $type2_value,$branch_ic));
				if ($resultObject->totalCount > 0) {
					if($negative == true){
						if($resultObject->data[0]->data_local < 0){
							$resultObject->data[0]->data_local=abs($resultObject->data[0]->data_local);
						}else{
							$resultObject->data[0]->data_local=-($resultObject->data[0]->data_local);
						}
						if($resultObject->data[0]->data_inr < 0){
							$resultObject->data[0]->data_inr=abs($resultObject->data[0]->data_inr);
						}else{
							$resultObject->data[0]->data_inr=-($resultObject->data[0]->data_inr);
						}
					}
					$data->data_local = number_format($resultObject->data[0]->data_local);
					if ($data->data_local == "") {
						$data->data_local = 0;
					}
					$data->data_inr = number_format($resultObject->data[0]->data_inr);
					if ($data->data_inr == "") {
						$data->data_inr = 0;
					}
				}
			}else{
				if($branch_ic == 'All'){
					$resultObject = $this->Master_Model->_rawQuery('select sum(' . $column . ') as data from ' . $consolidate_table . ' where year=? and month =? and company_id= ? and account_number in (select main_gl_number from ' . $main_table . ' where company_id=? and type1=? and type2=?) ', array((int)$year1, (int)$month, $company_id, $company_id, $type1_value, $type2_value));
				}else{
					$resultObject = $this->Master_Model->_rawQuery('select sum(' . $column . ') as data from ' . $consolidate_table . ' where year=? and month =? and company_id= ? and account_number in (select main_gl_number from ' . $main_table . ' where company_id=? and type1=? and type2=?) and branch_id=?', array((int)$year1, (int)$month, $company_id, $company_id, $type1_value, $type2_value,$branch_ic));
				}

				if ($resultObject->totalCount > 0) {
					if($negative == true){
						if($resultObject->data[0]->data < 0){
							$resultObject->data[0]->data=abs($resultObject->data[0]->data);
						}else{
							$resultObject->data[0]->data=-($resultObject->data[0]->data);
						}
					}
					$data->data_local = number_format($resultObject->data[0]->data);
					if ($data->data_local == "") {
						$data->data_local= 0;
					}
				}
			}
		}

		return $data;
	}

	function getType1AccountDataReport($type1, $type2, $columns, $month, $year, $type,$branch,$currency_type)
	{
		$data = 0;
		$column = 'T';
		$column2 = '';
		switch ($columns) {

			case 'O':
				$column = 'opening_balance';
				$column2 = 'opening_balance_2';
				break;
			case 'C':
				$column = 'credit';
				$column2 = 'credit_2';
				break;
			case 'D':
				$column = 'debit';
				$column2 = 'debit_2';
				break;
			case 'T':
				$column = 'total';
				$column2 = 'total_2';
				break;
			case 'O2':
				$column = 'opening_balance+opening_balance_1';
				$column2 = 'opening_balance_2';
				break;
			case 'C2':
				$column = 'credit+credit_1';
				$column2 = 'credit_2';
				break;
			case 'D2':
				$column = 'debit+debit_1';
				$column2 = 'debit_2';
				break;
			case 'T2':
				$column = 'total+total_1';
				$column2 = 'total_2';
				break;
		}

		$data = $this->getType1BalanceQueryData($month, $year, $column,$column2, $type1, $type2, $type,$branch,$currency_type);

		return $data;
	}

	function getType1BalanceQueryData($month, $year, $column,$column2, $type1, $type2, $type,$branch,$currency_type)
	{

		$company_id = $this->session->userdata('company_id');
		$data = new stdClass();
		$data->data_local = 0;
		$data->data_inr = 0;
		$columnName = '';

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
			if($currency_type==2)
			{
				$resultObject = $this->Master_Model->_rawQuery('select sum(' . $column . ') as data_local,sum(' . $column2 . ') as data_inr from ' . $consolidate_table . ' where year=? and month =? and company_id= ? and account_number in (select main_gl_number from ' . $main_table . ' where company_id=? and type1=?) and branch_id=?', array((int)$year1, (int)$month, $company_id, $company_id, $type1_value,$branch));
				if ($resultObject->totalCount > 0) {
					if($negative == true){
						if($resultObject->data[0]->data_local < 0){
							$resultObject->data[0]->data_local=abs($resultObject->data[0]->data_local);
						}else{
							$resultObject->data[0]->data_local=-($resultObject->data[0]->data_local);
						}
						if($resultObject->data[0]->data_inr < 0){
							$resultObject->data[0]->data_inr=abs($resultObject->data[0]->data_inr);
						}else{
							$resultObject->data[0]->data_inr=-($resultObject->data[0]->data_inr);
						}
					}
					$data->data_local = number_format($resultObject->data[0]->data_local);
					if ($data->data_local == "") {
						$data->data_local = 0;
					}
					$data->data_inr = number_format($resultObject->data[0]->data_inr);
					if ($data->data_inr == "") {
						$data->data_inr = 0;
					}
				}
			}
			else{
				if($branch == 'All' ){
					$resultObject = $this->Master_Model->_rawQuery('select sum(' . $column . ') as data_local from ' . $consolidate_table . ' where year=? and month =? and company_id= ? and account_number in (select main_gl_number from ' . $main_table . ' where company_id=? and type1=?) ', array((int)$year1, (int)$month, $company_id, $company_id, $type1_value));
				}else{
					$resultObject = $this->Master_Model->_rawQuery('select sum(' . $column . ') as data_local from ' . $consolidate_table . ' where year=? and month =? and company_id= ? and account_number in (select main_gl_number from ' . $main_table . ' where company_id=? and type1=?) and branch_id=?', array((int)$year1, (int)$month, $company_id, $company_id, $type1_value,$branch));
				}

				if ($resultObject->totalCount > 0) {
					if($negative == true){
						if($resultObject->data[0]->data_local < 0){
							$resultObject->data[0]->data_local=abs($resultObject->data[0]->data_local);
						}else{
							$resultObject->data[0]->data_local=-($resultObject->data[0]->data_local);
						}
					}
					$data->data_local = number_format($resultObject->data[0]->data_local);
					if ($data->data_local == "") {
						$data->data_local= 0;
					}
				}
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
			$currencytype = $this->input->post('currencytype');
			$reporttype = $this->input->post('reportSection');
			$template_id = $this->input->post('template_id');
			$templateBody = $this->input->post('templateBody');
			$number_conversion = $this->input->post('number_conversion');
			$templateBody=json_decode($templateBody);
			$StyleArray = $this->input->post('StyleArray');
//			$StyleArray=json_decode($StyleArray);
			$user_type = $this->session->userdata('user_type');
			$company_id = $this->session->userdata('company_id');
//			print_r($templateBody);exit();
			$ReportArray = $this->input->post('ReportArray');
			$reportData=json_decode($ReportArray);

			$data = array(
				'template_name' => $template_name,
				'type' => $type,
				'number_conversion' => $number_conversion,
				'templateVersion' => 2,
				'currency_type'=>$currencytype,
				'style'=>$StyleArray,
				'report_type'=>$reporttype
			);
			$reportRowArray=array();
			if(!empty($reportData))
			{
				foreach($reportData as $r_row)
				{
					$rowData=explode(',',$r_row->RowCol);
					if(count($rowData)>1)
					{
						$reportRowArray[$rowData[0]]=$r_row;
					}
				}
			}

			if ($template_id != 0) {
				$data['modify_on'] = date('Y-m-d H:i:s');
				$data['modify_by'] = $user_type;
				$where = array('id' => $template_id, 'company_id' => $company_id);

				$resultObject = $this->Master_Model->_update('report_maker_master_table', $data, $where);
				if ($resultObject->status == true) {
					$reportdata=array();
					if(!empty($templateBody))
					{
						foreach ($templateBody as $rkey=> $trow)
						{
							$updatedata=array('template_id'=>$template_id,'status'=>1,'created_on'=>date('Y-m-d H:i:s'),'created_by'=>$company_id,'templateVersion' => 2);

							$m=1;

							for($i=0;$i<10;$i++)
							{
								$updatedata['column_'.$m]=trim($trow[$i]);

								$m++;
							}
							if(array_key_exists($rkey,$reportRowArray))
							{
								$updatedata['is_report_template']=$reportRowArray[$rkey]->reportType;
								$updatedata['report_id']=$reportRowArray[$rkey]->reportTemp;
							}
							else{
								$updatedata['is_report_template']="";
								$updatedata['report_id']="";
							}

							array_push($reportdata,$updatedata);

						}
					}
//					print_r($reportdata);exit();
					$where_report=array('template_id'=>$template_id);
					$reportObjectDelete = $this->Master_Model->_delete('table_reportmaker_transaction',$where_report);
					if(!empty($reportdata) && $reportObjectDelete== true)
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
						foreach ($templateBody as $tkey=> $trow)
						{
							$rowdata=array('template_id'=>$template_id,'status'=>1,'created_on'=>date('Y-m-d H:i:s'),'created_by'=>$company_id,'templateVersion' => 2);
							$m=1;
							for($i=0;$i<10;$i++)
							{
								$rowdata['column_'.$m]=trim($trow[$i]);
								$m++;
							}
							if(array_key_exists($tkey,$reportRowArray))
							{
								$rowdata['is_report_template']=$reportRowArray[$tkey]->reportType;
								$rowdata['report_id']=$reportRowArray[$tkey]->reportTemp;
							}
							else{
								$rowdata['is_report_template']="";
								$rowdata['report_id']="";
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
		for ($i=1;$i<=10;$i++)
		{
			array_push($header,'column_'.$i);
			array_push($columnType,array('type'=>'text'));
		}
		$rows=array();
		$reportArray=array();
		$template_id = $this->input->post('template_id');
		$resultObject = $this->Master_Model->_select('report_maker_master_table', array('id' => $template_id,'templateVersion'=>2), "*", true);
		if ($resultObject->totalCount > 0) {
//			$trasnsactionObject = $this->Master_Model->_select('table_reportmaker_transaction', array('template_id' => $template_id), array("*",'(case when is_report_template=2 then (select template_name from handson_template_master where id=report_id) else (select template_name from report_maker_master_table where id="report_id) end) as template_name'), false);
			$trasnsactionObject = $this->Master_Model->_rawQuery('select *,(case when is_report_template=2 then (select template_name from handson_template_master where id=report_id) else (select template_name from report_maker_master_table where id=report_id) end) as template_name from table_reportmaker_transaction where template_id="'.$template_id.'"');
//			print_r($trasnsactionObject);exit();
			if($trasnsactionObject->totalCount>0)
			{
				foreach ($trasnsactionObject->data as $tkey=> $trow)
				{
					$rowcol=$tkey.',1';
					if($trow->is_report_template!=null && $trow->is_report_template!=0 && $trow->is_report_template!="" && $trow->report_id!=null && $trow->report_id!="" && $trow->report_id!=0)
					{
						array_push($reportArray,array('RowCol'=>$rowcol,'reportType'=>$trow->is_report_template,'reportTemp'=>$trow->report_id));
						if($trow->is_report_template==1)
						{
							$trow->column_3='Template';
						}
						if($trow->is_report_template==2)
						{
							$trow->column_3='Schedule';
						}
						$trow->column_4=$trow->template_name;
					}
					array_push($rows,array($trow->column_1,$trow->column_2,$trow->column_3,$trow->column_4,$trow->column_5,$trow->column_6,$trow->column_7,$trow->column_8,
						$trow->column_9,$trow->column_10));
				}
			}
			else{
				for ($i=1;$i<=6;$i++) {
					array_push($rows,array('','','','','','','','','',''));
				}
				array_push($rows,array('Particular','Other details','Report Type','Report Name','Account Type','','','','',''));
			}
			$response['status'] = 200;
			$response['body'] = $resultObject->data;
			$response['style'] = json_decode($resultObject->data->style);
			$response['reportArray'] = $reportArray;
		} else {
			for ($i=1;$i<=6;$i++) {
				array_push($rows,array('','','','','','','','','',''));
			}
			array_push($rows,array('Particular','Other details','Report Type','Report Name','Account Type','','','','',''));
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
		$where = array('id' => $template_id,'templateVersion'=>2);
		if(!empty($year) && !is_null($year)){
			$resultObject = $this->Master_Model->_select('report_maker_master_table', $where, array("*","(select month from default_year_data where company_id='".$company_id."' limit 1) as default_month"), true);

			if ($resultObject->totalCount > 0) {
				$type = $resultObject->data->type;

				$default_month=$resultObject->data->default_month;

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
						$selected='';
						$m= $month_number->month;
						$mon= $months[$m];
						if(!is_null($default_month))
						{
							if($default_month==$month_number->month)
							{
								$selected='selected';
							}
						}

						$option .='<option value="'.$month_number->month.'" '.$selected.'>'.$mon.'</option>';
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

	public function CreateExcelForAllBranch($month,$year,$branch,$template_id,$currency,$resultObject,$reportObject)
	{
			$html = '';
			$number_conversion = 0;
			if ($resultObject->totalCount > 0) {
				$type = $resultObject->data->type;
				$currency_type = $resultObject->data->currency_type;
				$number_conversion = $resultObject->data->number_conversion;
				$output = array_map(function ($object) {
					return $object->column_1.$object->column_2.$object->column_3.$object->column_4.$object->column_5.$object->column_6.$object->column_7.$object->column_8
						.$object->column_9.$object->column_10;
				}, $reportObject->data);
				$opt= implode(', ', $output);
				$tableString=$this->getColumnTextData($opt,$month,$year,$number_conversion,$type,$branch,$currency_type);
				if($reportObject->totalCount>0)
				{
					$reportData=array();
					$reportdata=$reportObject->data;

					foreach ($reportdata as $rkey => $rrow)
					{
						$rowdata=array();
						for($i=1;$i<=10;$i++)
						{
							$columnName='column_'.$i;
							if($rkey==6 && $i==6)
							{
								$columnText=$currency;
							}
							else{
								$columnText=$rrow->$columnName;
							}
							if($currency_type==2 || $currency_type==3)
							{
								if($rkey==6 && $i==7)
								{
									$columnText='INR';
								}
							}
							$columnText = str_replace(",", "", $columnText);

							if($columnText!="" && $columnText!=null)
							{
								if(array_key_exists($columnText,$tableString))
								{
//									print_r($columnText);
									$columnText=$columnText;
								}
							}
							else{
								$col_5=$rrow->column_5;
								if(array_key_exists($col_5,$tableString))
								{
									if($i==6)
									{
										$columnText=number_format($tableString[$col_5]->data_local,2);
									}
									if($i==7)
									{
										$columnText=number_format($tableString[$col_5]->data_inr,2);
									}

								}
							}
							array_push($rowdata,$columnText);

						}
						array_push($reportData,$rowdata);
					}
					$response['status'] = 200;
					$response['body'] = $reportData;
					$response['currency_type'] = $currency_type;
				}
				else{
					$response['status'] = 201;
					$response['body'] = 'No data found';
				}
			}else{
				$response['status'] = 201;
				$response['body'] = 'No data found1';
			}
		return $response;
	}

	function createExcel(){
		$this->load->library('excel');

		$month=$this->input->get('month');
		$year=$this->input->get('year');
		$template_id=$this->input->get('template_id');
		$company_id = $this->session->userdata('company_id');
		$result=$this->Master_Model->_rawQuery('select id,name,currency from branch_master where company_id='.$company_id.' and status=1 order by is_consolidated,is_special_branch asc');
		if($result->totalCount >0){
			$arrayDataBranch=array();
			$arrayDataAll=array();
			$branchArray=array();
			$currencyType=1;
			$a=1;

			$reportMakerwhere = array('id' => $template_id,'templateVersion'=>2);
			$number_conversion = 0;
			$resultObject = $this->Master_Model->_select('report_maker_master_table', $reportMakerwhere, "*", true);
			$report_where = array('template_id' => $template_id);
			$reportObject = $this->Master_Model->_select('table_reportmaker_transaction', $report_where, "*", false);

			foreach ($result->data as $row){
				if($row->currency=="" || $row->currency==null)
				{
					$currency='LOCAL';
				}
				$resultData=$this->CreateExcelForAllBranch($month,$year,$row->id,$template_id,$row->currency,$resultObject,$reportObject);

				if($resultData['status'] == 200){
					$arrayDataBranch[$row->name]=$resultData['body'];
					$currencyType=$resultData['currency_type'];
					if($a==1)
					{
						$arrayDataAll=$resultData['body'];
					}
					array_push($branchArray,$row->name);
				}
				$a++;
			}

			$mainArray=array();
			foreach ($arrayDataBranch as $bkey => $brow)//all array
			{
				foreach ($brow as $rkey => $rrow)
				{
					$mainArray[$rrow[0]."||".$rrow[1]."||".$rkey][$bkey]=array($rrow[5],$rrow[6]);
				}
			}

			if(count($mainArray)>0){
				$objPHPExcel = new PHPExcel();

				$objPHPExcel->setActiveSheetIndex(0);
				$b=6;
				$ch='C';
				foreach ($branchArray as $branchName)
				{
					$objPHPExcel->getActiveSheet()->SetCellValue($ch.$b, $branchName);
					if($currencyType==2)
					{
						$ch++;
					}
					$ch++;
				}
				$i=1;
				$objPHPExcel->getActiveSheet()->setTitle("Subsidiary Report");
				foreach ($mainArray as $mkey => $mrow)
				{
					if($i!=6)
					{
						$col1='';
						$col2='';
						$colData=explode('||',$mkey);
						if(count($colData)>2)
						{
							$col1=$colData[0];
							$col2=$colData[1];
						}

						$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, $col1);
						$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $col2);
						$char='C';
						foreach ($mrow as $bbkey => $bbrow)
						{
//							if($bbrow[0]==0)
//							{
//								$bbrow[0]="";
//							}
//							if($bbrow[1]==0)
//							{
//								$bbrow[1]="";
//							}
							if($currencyType==1 || $currencyType==2)
							{
								$objPHPExcel->getActiveSheet()->SetCellValue($char.$i, $bbrow[0]);
								$objPHPExcel->getActiveSheet()->getStyle($char.$i)
									->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$char++;
							}
//							else{
//								$objPHPExcel->getActiveSheet()->SetCellValue($char.$i, '');
//								$char++;
//							}
							if($currencyType==2 || $currencyType==3) {
								$objPHPExcel->getActiveSheet()->SetCellValue($char . $i, $bbrow[1]);
								$objPHPExcel->getActiveSheet()->getStyle($char.$i)
									->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$char++;
							}
						}
					}
						$i++;
				}
//				exit();



				ob_end_clean();

				$filename = "SUBSIDIARY_DATA" . date("Y-m-d") . ".xls";

				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="' . $filename . '"');
				header('Cache-Control: max-age=0');
				foreach (range('A', $objPHPExcel->getActiveSheet()->getHighestDataColumn()) as $col) {
					$objPHPExcel->getActiveSheet()
						->getColumnDimension($col)
						->setAutoSize(true);
				}
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

				$objWriter->save('php://output');

			}

		}
	}
	public function getReportTemplateList()
	{
		$data='<option value=""></option>';
		if(!is_null($this->input->post('type')))
		{
			$type=$this->input->post('type');
			$company_id = $this->session->userdata('company_id');
			$where=array('status'=>1);
			if($type==1)
			{
				$tableName='report_maker_master_table';
			}
			else{
				$tableName='handson_template_master';

			}
			$where['company_id']=$company_id;
			$resultObject=$this->Master_Model->_select($tableName,$where,array('id','template_name'),false);
			if($resultObject->totalCount>0)
			{
				foreach ($resultObject->data as $row)
				{
					$data.='<option value="'.$row->id.'">'.$row->template_name.'</option>';
				}
				$response['status']=200;
				$response['data']=$data;
			}
			else{
				$response['status']=201;
				$response['data']=$data;
			}
		}
		else{
			$response['status']=201;
			$response['data']=$data;
		}
		echo json_encode($response);
	}
	public function changeStatusOfReport()
	{
		if(!is_null($this->input->post('id')) && !is_null($this->input->post('status')))
		{
			$id=$this->input->post('id');
			$status=$this->input->post('status');
			$resultObject=$this->Master_Model->_update('report_maker_master_table',array('status'=>$status),array('id'=>$id));
			if($resultObject->status==true)
			{
				$response['status']=200;
				$response['body']="Changes Updated";
			}
			else{
				$response['status']=201;
				$response['body']="Changes Not Updated";
			}
		}
		else{
			$response['status']=201;
			$response['body']='Required Parameter Missing';
		}
		echo json_encode($response);
	}
	function getDFAccountData($gl_ac,$type, $attr,$branch,$currency_type)
	{
		$company_id = $this->session->userdata('company_id');
		$data = new stdClass();
		$data->data_local = 0;
		$data->data_inr = 0;
		$column='total_local';
		$column2='total_inr';

		if ($type == 2)//USD
		{
			$consolidate_table = 'derived_report_transaction';
		} else if ($type == 3)//IRFS
		{
			$consolidate_table = 'derived_report_transaction';
		} else  //IND
		{
			$consolidate_table = 'derived_report_transaction';
		}
		$branch_ic=$branch;

			$negative=false;
			if($attr == '-DF'){
				$negative =true;
			}

			if($currency_type==2)
			{
				if($branch_ic == "All"){
					$resultObject = $this->Master_Model->_rawQuery('select sum(' . $column . ') as data_local,sum(' . $column2 . ') as data_inr from ' . $consolidate_table . ' where company_id= ? and derived_gl = ? ', array( $company_id, $gl_ac));
				}else{
					$resultObject = $this->Master_Model->_rawQuery('select sum(' . $column . ') as data_local,sum(' . $column2 . ') as data_inr from ' . $consolidate_table . ' where company_id= ? and derived_gl = ? And branch_id=?', array($company_id, $gl_ac,$branch_ic));
				}


				if ($resultObject->totalCount > 0) {
					if($negative == true){
						if($resultObject->data[0]->data_local < 0){
							$resultObject->data[0]->data_local=abs($resultObject->data[0]->data_local);
						}else{
							$resultObject->data[0]->data_local=-($resultObject->data[0]->data_local);
						}
						if($resultObject->data[0]->data_inr < 0){
							$resultObject->data[0]->data_inr=abs($resultObject->data[0]->data_inr);
						}else{
							$resultObject->data[0]->data_inr=-($resultObject->data[0]->data_inr);
						}
					}
					$data->data_local = number_format($resultObject->data[0]->data_local);
					if ($data->data_local == "") {
						$data->data_local = 0;
					}
					$data->data_inr = number_format($resultObject->data[0]->data_inr);
					if ($data->data_inr == "") {
						$data->data_inr = 0;
					}
				}
			}
			else{
				if($branch_ic == "All"){
					$resultObject = $this->Master_Model->_rawQuery('select sum(' . $column . ') as data from ' . $consolidate_table . ' where company_id= ? and derived_gl = ?', array( $company_id, $gl_ac));
				}else{
					$resultObject = $this->Master_Model->_rawQuery('select sum(' . $column . ') as data from ' . $consolidate_table . ' where company_id= ? and derived_gl = ? And branch_id=?', array($company_id, $gl_ac,$branch_ic));
				}

				if ($resultObject->totalCount > 0) {
					if($negative == true){
						if($resultObject->data[0]->data < 0){
							$resultObject->data[0]->data=abs($resultObject->data[0]->data);
						}else{
							$resultObject->data[0]->data=-($resultObject->data[0]->data);
						}
					}
					$data->data_local = number_format($resultObject->data[0]->data);
					if ($data->data_local == "") {
						$data->data_local= 0;
					}
				}
			}

		return $data;
	}
}


