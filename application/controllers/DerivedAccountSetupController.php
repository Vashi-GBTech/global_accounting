<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property  Master_Model Master_Model
 */
class DerivedAccountSetupController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}
	public function index()
	{
		$this->load->view('Derived/view_derived_account',array("title"=>"Derived Account","company_id"=>$this->session->userdata('company_id')));
	}
	public function uploadDerivedSetup()
	{
		$derivedGL=$this->input->post('derivedGL');
		$glDetail=$this->input->post('glDetail');
		$derived_formula=$this->input->post('derived_formula');
		$update_id=$this->input->post('update_id');
		$company_id = $this->session->userdata('company_id');
		$user_id = $this->session->userdata('user_id');
		$data=array(
			'company_id'=>$company_id,
			'derived_account_gl'=>$derivedGL,
			'status'=>1,
			'detail'=>$glDetail,
			'formula'=>$derived_formula
		);
		if(isset($update_id) && !empty($update_id)){
			$data['updated_by']=$user_id;
			$data['updated_on']=date('Y-m-d G:i:s');
			$where=array("id"=>$update_id);
			$update=$this->Master_Model->_update('derived_account_setup',$data,$where);
			if($update->status == true){
				$response['status']=200;
				$response['body']="Updated Successfully";
			}else{
				$response['status']=201;
				$response['body']="Something Went Wrong";
			}
		}else{
			$data['created_by']=$user_id;
			$data['created_on']=date('Y-m-d G:i:s');
			$insert=$this->Master_Model->_insert('derived_account_setup',$data);
			if($insert->status == true){
				$response['status']=200;
				$response['body']="Added Successfully";
			}else{
				$response['status']=201;
				$response['body']="Something Went Wrong";
			}
		}echo json_encode($response);
	}
	public function getDerivedGlList()
	{
		$mbData = $this->db
			->select(array("*"))
			->where('company_id',$this->session->userdata('company_id'))
			->order_by('id', 'desc')
			->get("derived_account_setup")->result();
		$tableRows = array();
		if (count($mbData) > 0) {
			$i = 1;
			foreach ($mbData as $order) {
				$country_master = $this->Master_Model->getQuarter();
				array_push($tableRows, array($i, $order->derived_account_gl,  $order->detail, $order->formula, $order->id,$order->status));
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
	public function editDerivedGL()
	{
		if(!is_null($this->input->post('id')))
		{
			$id=$this->input->post('id');
			$resultObject=$this->Master_Model->_select('derived_account_setup',array('id'=>$id),'*',true);
			if($resultObject->totalCount>0)
			{
				$response['status']=200;
				$response['data']=$resultObject->data;
			}
			else{
				$response['status']=201;
				$response['data']='No data found';
			}
		}
		else{
			$response['status']=201;
			$response['data']='Something Went Wrong';
		}
		echo json_encode($response);
	}
	public function deleteDerivedGL()
	{
		if(!is_null($this->input->post('id')))
		{
			$id=$this->input->post('id');
			$resultObject=$this->Master_Model->_delete('derived_account_setup',array('id'=>$id));
			if($resultObject->status>0)
			{
				$response['status']=200;
				$response['data']='Deleted Successfully';
			}
			else{
				$response['status']=201;
				$response['data']='Not Deleted';
			}
		}
		else{
			$response['status']=201;
			$response['data']='Something Went Wrong';
		}
		echo json_encode($response);
	}
	public function derived_report()
	{
		$year = $this->input->get('year');
		$month = $this->input->get('month');
		$country_master = $this->Master_Model->getQuarter();
		$this->load->view("Derived/derived_report", array("title" => "Derived Report", 'year' => $year, 'month' => $country_master[$month]));
	}
	public function setDerivedFormulaData()
	{
		$company_id = $this->session->userdata("company_id");
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		$update = $this->input->post('update');

		$branchData = $this->Master_Model->
		_select("branch_master", array("company_id" => $company_id, "status" => 1), array("id"), false)->data;
		$resultObject = $this->Master_Model->_select('derived_account_setup', array('status' => 1, 'company_id' => $company_id), '*', false);

		if ($resultObject->totalCount > 0) {
			$AllDataArrayIND = $resultObject->data;
			$insertDataArrayIND = array();
			foreach ($AllDataArrayIND as $key => $itemIND) {
				foreach ($branchData as $key_branch => $branchRow) {
						$tableString=$this->getColumnTextData($itemIND->formula,$month,$year,1,$branchRow->id);
						$total_local=0;
						$total_inr=0;
						if($tableString!=null && $tableString!="" & $tableString!='undefined')
						{
							$total_local=$tableString->data_local;
							$total_inr=$tableString->data_inr;
						}
					$data = array(
						"derived_gl" => $itemIND->derived_account_gl,
						"detail" => $itemIND->detail,
						"formula" => $itemIND->formula,
						"month" => $month,
						"year" => $year,
						"branch_id" => $branchRow->id,
						"company_id" => $company_id,
						"formula_value" => '',
						"total_local" => $total_local,
						"total_inr" => $total_inr,
						"created_on" => date('Y-m-d G:i:s'),
						"status" => 1,
						"created_by" => $this->session->userdata("user_id"),
					);
					array_push($insertDataArrayIND, $data);
				}
			}
		}
			$result = FALSE;
			try {
				$this->db->trans_start();
				if (count($insertDataArrayIND) > 0) {
					$this->db->delete("derived_report_transaction", array("month" => $month, "year" => $year, "company_id" => $company_id));
					$this->db->insert_batch('derived_report_transaction', $insertDataArrayIND);
				}
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					log_message('info', "insert user Transaction Rollback");
					$result = FALSE;
				} else {
					$this->db->trans_commit();
					log_message('info', "insert user Transaction Commited");
					$result = TRUE;
				}
				$this->db->trans_complete();
			} catch (Exception $exc) {
				log_message('error', $exc->getMessage());
				$result = FALSE;
			}
			if ($result == TRUE) {
				$response['status'] = 200;
			} else {
				$response['status'] = 201;
			}

		echo json_encode($response);
	}
	function getColumnTextData($html,$month,$year,$type,$branch)
	{
		$textReplaceArray=array();
		$country_master = $this->Master_Model->getQuarter();
		$divide = 1;
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
					$gl_data = $this->getGLAccountData($value2[1], $value2[2], $month, $year, $type, $value2[0],$branch);
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
					$gl_data = $this->getGRAccountDataReport($value2[1], $value2[2], $month, $year, $type, $value2[0],$branch);
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
					$gl_data = $this->getT2AccountDataReport($value2[1], $value2[2], $month, $year, $type, $value2[0],$branch);
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
						$gl_data = $this->getType1AccountDataReport($value2[0], $value2[1], $value2[2], $month, $year, $type,$branch);
					} else {
						$gl_data = $this->getTypeAccountDataReport($value2[0], $value2[1], $value2[2], $month, $year, $type,$branch);
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

		}
		$html = str_replace("<code>","",$html);
		$html = str_replace("</code>","",$html);

		$string_local=$html;
		$string_inr=$html;
		foreach ($textReplaceArray as $fkey => $fvalue) {
				$string_local=str_replace($fkey, $fvalue->data_local, $string_local);
				$string_inr=str_replace($fkey, $fvalue->data_inr, $string_inr);
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

		return $formula_value;
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
	function getGLAccountData($columns, $gl_ac, $month, $year, $type, $attr,$branch)
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
		$data = $this->getGLBalanceQueryData($month, $year, $column, $column2, $gl_ac, $type, $attr,$branch);

		return $data;
	}
	function getGLBalanceQueryData($month, $year, $column, $column2, $gl_ac, $type, $attr,$branch)
	{
		$company_id = $this->session->userdata('company_id');
		$data = new stdClass();
		$data->data_local = 0;
		$data->data_inr = 0;

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
		return $data;
	}
	function getGRAccountDataReport($columns, $gr_id, $month, $year, $type, $attr,$branch)
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

		$data = $this->getGRBalanceQueryData($month, $year, $column,$column2, $gr_id, $type, $attr,$branch);

		return $data;
	}
	function getGRBalanceQueryData($month, $year, $column,$column2, $gr_id, $type, $attr,$branch)
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
		return $data;
	}
	function getT2AccountDataReport($columns, $gr_id, $month, $year, $type, $attr,$branch)
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

		$data = $this->getT2BalanceQueryData($month, $year, $column,$column2, $gr_id, $type, $attr,$branch);

		return $data;
	}

	function getT2BalanceQueryData($month, $year, $column,$column2, $type2, $type, $attr,$branch)
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

		return $data;
	}
	function getType1AccountDataReport($type1, $type2, $columns, $month, $year, $type,$branch)
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
		$data = $this->getType1BalanceQueryData($month, $year, $column,$column2, $type1, $type2, $type,$branch);

		return $data;
	}
	function getType1BalanceQueryData($month, $year, $column,$column2, $type1,$type2, $type,$branch)
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

		return $data;
	}
	function getTypeAccountDataReport($type1, $type2, $columns, $month, $year, $type,$branch)
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

		$data = $this->getTypeBalanceQueryData($month, $year, $column,$column2, $type1, $type2, $type,$branch);

		return $data;
	}
	function getTypeBalanceQueryData($month, $year, $column,$column2, $type1, $type2, $type,$branch)
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

		}

		return $data;
	}
	function getTotalDerivedFormulaReport()
	{
		$company_id = $this->session->userdata('company_id');
		$type = $this->input->post('type');
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		$div = $this->input->post('div');
		$table = '';
		$table2 = '';

		$branchData = $this->Master_Model->
		_select("branch_master", array("company_id" => $company_id, "status" => 1), array("start_with", "id", "name", "currency"), false,null,null,"is_consolidated asc,is_special_branch asc")->data;

		if ($div == 'derviedTable') {
			$table = 'derived_report_transaction cr';
			$table2 = 'derived_account_setup';
		}
		if ($div == 'derviedTableUS') {
			$table = 'consolidate_report_transaction_us cr';
			$table2 = 'main_account_setup_master_us';
		}
		if ($div == 'derviedTableIFRS') {
			$table = 'consolidate_report_transaction_ifrs cr';
			$table2 = 'main_account_setup_master_ifrs';
		}
		$filterArray = array();
		$getTotalData = $this->Master_Model->_select($table,
			array("company_id" => $company_id, "year" => $year, "month" => $month),
			array('*', '(select group_concat(ma.detail,' || ',ma.formula) from ' . $table2 . ' ma where ma.company_id=ct.company_id and ma.derived_account_gl=ct.derived_gl) as main_data'), false)->data;
		$where = array("company_id" => $company_id);

		$getBranchWithMainAccount = $this->Master_Model->_select($table2,
			$where,
			array('*'), false, array('derived_account_gl'))->data;

		if (count($getTotalData) > 0) {
			foreach ($getTotalData as $records) {
				foreach ($getBranchWithMainAccount as $account) {
					if ($account->derived_account_gl === $records->derived_gl) {
						$filterArray[$account->derived_account_gl][$records->branch_id][] = array(
							$records->total_local,
							$records->total_inr,
						);
					}
				}
			}
		}

		$columnHeader = array();
		$source = array(
			array('type' => 'text'),
			array('type' => 'text'),
			array('type' => 'text')

		);
		array_push($columnHeader, 'Detail', 'Derived Code', 'Formula');
		foreach ($branchData as $branch) {
			array_push($columnHeader, $branch->name . "(Local -" . $branch->currency . ")");//column headers
			array_push($source, array('type' => 'numeric'));
			array_push($columnHeader, $branch->name . "(INR)");//column headers
			array_push($source, array('type' => 'numeric'));

		}


		$finalArray = array();
		foreach ($getBranchWithMainAccount as $parent) {
			$main_dataArray = array();
			array_push($main_dataArray, $parent->detail, $parent->derived_account_gl, $parent->formula);
			$allChildRecords = array();
			if (array_key_exists($parent->derived_account_gl, $filterArray)) {


				foreach ($branchData as $branch) {
					$BranchChildRecords = array();
					$BranchOBRecords = array();
					$BranchDrRecords = array();
					$BranchCrRecords = array();
					foreach ($filterArray[$parent->derived_account_gl] as $key => $childRecords) {

						if ($key == $branch->id) {
							foreach ($childRecords as $childvalue) {
								array_push($BranchChildRecords, $childvalue[0]);
								array_push($BranchOBRecords, $childvalue[1]);
							}

						}
					}
					$branch_total = array_sum($BranchChildRecords);
					$ob_total = array_sum($BranchOBRecords);
					// print_r($branch_total);exit();
					array_push($main_dataArray, number_format($branch_total, 2));
					array_push($main_dataArray, number_format($ob_total, 2));


				}
				$finalData = array_sum($allChildRecords);
				/*array_push($main_dataArray, number_format($finalData, 2));*/
				array_push($finalArray, $main_dataArray);
			}


		}


		// print_r($finalArray);exit();
		if (count($getTotalData) > 0) {
			$response['headers'] = $columnHeader;
			$response['data'] = $finalArray;
			$response['status'] = 200;
			$response['columnType'] = $source;
			$response['hideColumn'] = array();
		} else {
			$response['headers'] = array();
			$response['data'] = array();
			$response['status'] = 201;
			$response['columnType'] = array();
			$response['hideColumn'] = array();
		}

		echo json_encode($response);
	}
}
