<?php
//require '/var/www/act/vendor/autoload.php';

//require 'vendor/autoload.php';
use Dompdf\Dompdf;

class TemplateToolController extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('TemplateToolModel');
		$this->session->user_session = (object)$this->session->userdata();
	}

	public function index()
	{
		if (!isset($this->session->user_session)) {
			redirect("login");
		} else {
			$data['basePath'] = array('load_view' => array('template_tool/template_tool'));
			$this->load->view("Admin/template_tool/template_tool", array("title" => "SpreadSheet"));
		}
	}

	public function CompanySpreadsheet()
	{
		if (!isset($this->session->user_session)) {
			redirect("login");
		} else {
			$data['basePath'] = array('load_view' => array('template_tool/Spreasheet'));
			$this->load->view("Admin/template_tool/template_view", array("title" => "SpreadSheet"));
		}
	}

	public function addHandsonTemplate()
	{
		if (!is_null($this->input->post('template_name')) && $this->input->post('template_name') != "" && !is_null($this->input->post('attribute_name')) && $this->input->post('attribute_name') != "") {
			$user_id = $this->session->user_session->user_id;
			$template_name = $this->input->post('template_name');
			$template_id = $this->input->post('template_id');
			$prefill = $this->input->post('prefill');
			$company_id = $this->input->post('company_id');
			$month = $this->input->post('monthCre');
			$year = $this->input->post('yearCre');
//			$valueSignIN = $this->input->post('valueSignIN');
			$insert_id = '';
			try {
				$this->db->trans_start();
				$status = 201;
				$body = 'Data Not Saved';
				if (!empty($template_id)) {
					$updatetemplateMaster = array('template_name' => $template_name, 'prefill' => $prefill,'company_id' => $company_id, 'modify_by' => $user_id, 'modify_on' => date('Y-m-d H:i:s'));
					$where = array('id' => $template_id);
					if ($this->db->set($updatetemplateMaster)->where($where)->update('handson_template_master')) {
						if ($this->db->delete('handson_template_column_master', array('template_id' => $template_id))) {
							$insert_id = $template_id;
						}
					}
				} else {
					$templateMaster = array('template_name' => $template_name, 'user_id' => $user_id, 'created_by' => $user_id, 'company_id' => $company_id, 'created_on' => date('Y-m-d H:i:s'), 'status' => 1, 'prefill' => $prefill,'year'=>$year,'month'=>$month);
					if ($this->db->insert('handson_template_master', $templateMaster)) {
						$insert_id = $this->db->insert_id();
					}
				}
				if (!empty($insert_id)) {
					$attribute_name = $this->input->post('attribute_name');
					$attribute_type = $this->input->post('attribute_type');
					$attribute_query = $this->input->post('attribute_query');
					$valueSignIN = $this->input->post('valueSignIN');
					$GlAccount = $this->input->post('GlAccount');

					$valueType = $this->input->post('valueType');
					$formulaMaker = $this->input->post('formulaMaker');
					$formulaMakerINR = $this->input->post('formulaMakerINR');


					// $sequence = $this->input->post('sequence');
					$template_name_length = count($this->input->post('attribute_name'));
					$columnMaster = array();
					$c = 1;
					for ($i = 0; $i < $template_name_length; $i++) {
						$formulaColumns = $this->input->post('formulaColumns' . $c);
						$branchSum = $this->input->post('branchSum' . $c);
						if ($attribute_type[$i] == "") {
							$attribute_type[$i] = 'text';
						}

						if (is_null($GlAccount) || empty($GlAccount)) {
							$GlAccount1 = '';
						} else {
							if (array_key_exists($i, $GlAccount)) {
								$GlAccount1 = $GlAccount[$i];
							} else {
								$GlAccount1 = '';
							}
						}
						if (is_null($valueType) || empty($valueType)) {
							$valueType1 = '';
						} else {
							$valueType1 = $valueType[$i];
						}
						if (is_null($formulaColumns) || empty($formulaColumns)) {
							$formulaColumns1 = '';
						} else {
							$formulaColumns1 = implode(",", $formulaColumns);
						}
						$templateDetails = array('template_id' => $insert_id,
							'column_name' => $attribute_name[$i],
							'column_type' => $attribute_type[$i],
							'option_data' => $attribute_query[$i],
							'value_sign' => $valueSignIN[$i],
							'sequence' => $i,
							'user_id' => $user_id,
							'created_by' => $user_id,
							'gl_account' => $GlAccount1,
							'value_type' => $valueType1,
							'formula' => $formulaColumns1,
							'formula_maker' => $formulaMaker[$i],
							'formula_maker_inr' => $formulaMakerINR[$i],
							'inlcude_branch_sum' => $branchSum,
							'created_on' => date('Y-m-d H:i:s'),
							'column_value' => 'column_' . $c);
						array_push($columnMaster, $templateDetails);
						$c++;
					}
					if (count($columnMaster) > 0) {
						$this->db->insert_batch('handson_template_column_master', $columnMaster);
					}
				}

				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					$status = 201;
					$body = 'something went wrong';
				} else {
					$this->db->trans_commit();
					$status = 200;
					$body = 'Data Uploaded';
				}
				$this->db->trans_complete();
			} catch (Exception $exc) {
				$status = 201;
				$body = 'something went wrong';
				$this->db->trans_rollback();
				$this->db->trans_complete();
			}

			$response['status'] = $status;
			$response['body'] = $body;
			$response['prefill'] = $prefill;
			$response['temp_id'] = $insert_id;
			$response['temp_name'] = $template_name;
		} else {
			$response['status'] = 201;
			$response['body'] = 'Parameter missing';
		}
		echo json_encode($response);
	}

	function copyHandsonTemplate(){
//handson_template_master
		//handson_template_column_master
		//handson_prefill_table
		$year=$this->input->post('yearCopy');
		$month=$this->input->post('monthCopy');
		$template_id_copy=$this->input->post('template_id_copy');

		$getDataTemplateMaster=$this->db->query('select * from handson_template_master where id='.$template_id_copy);
		if($this->db->affected_rows() > 0){
			$dataMaster=$getDataTemplateMaster->result_array(); //template_id
			$insert_id=1;
			$dataMaster[0]['year']=$year;
			$dataMaster[0]['month']=$month;
			unset($dataMaster[0]['id']);
			$insertMaster=$this->db->insert('handson_template_master',$dataMaster[0]);
			$insert_id=$this->db->insert_id();
			$getDataColumnMaster=$this->db->query('select * from handson_template_column_master where template_id='.$template_id_copy);
			if($this->db->affected_rows() > 0){
				$dataColumnMaster=$getDataColumnMaster->result_array();
				$datacol=array();
				foreach ($dataColumnMaster as $row){

					$row['template_id']=$insert_id;
					unset($row['id']);
					array_push($datacol,$row);
				}
				$insertMasterCol=$this->db->insert_batch('handson_template_column_master',$datacol);

			}
			$getDataPrefillMaster=$this->db->query('select * from handson_prefill_table where template_id='.$template_id_copy);
			if($this->db->affected_rows() > 0){
				$dataPrefillMaster=$getDataPrefillMaster->result_array();
				$datapre=array();
				foreach ($dataPrefillMaster as $row_1){
					$row_1['template_id']=$insert_id;
					unset($row_1['id']);
					array_push($datapre,$row_1);
				}
				$insertMasterPref=$this->db->insert_batch('handson_prefill_table',$datapre);
			}
			$getDataScheduleMapping=$this->db->query('select * from handson_subsidiary_account_table where template_id='.$template_id_copy);
			if($this->db->affected_rows() > 0){
				$dataScheduleMapping=$getDataScheduleMapping->result_array();
				$dataScheduleMapp=array();
				foreach ($dataScheduleMapping as $row_1){
					$row_1['template_id']=$insert_id;
					$row_1['year']=$year;
					$row_1['month']=$month;
					unset($row_1['id']);
					array_push($dataScheduleMapp,$row_1);
				}
				$insertMasterScheduleMapp=$this->db->insert_batch('handson_subsidiary_account_table',$dataScheduleMapp);
			}
			if($insertMaster == true){
				$response['status'] = 200;
				$response['body'] = 'Added Successfully!';

			}else{
				$response['status'] = 201;
				$response['body'] = 'Something Went	Wrong!';
			}

		}else{
			$response['status'] = 201;
			$response['body'] = 'Something Went	Wrong!';
		}echo json_encode($response);

	}

	public function getTablesList()
	{
		$user_id = $this->session->user_session->user_id;
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		if ($this->input->post('company_id') == 'all') {
			$company_id = $this->input->post('company_id');
			$where = array('status' => 1,'year'=>$year,'month'=>$month);
			$where_in = null;
		} else {
			$company_id = $this->session->user_session->company_id;
			$branch_id = $this->session->user_session->branch_id;
			$where = array('status' => 1, 'company_id' => $company_id,'year'=>$year,'month'=>$month);
		}
		$tables = $this->TemplateToolModel->_select('handson_template_master', $where, array('id', 'template_name', 'status', 'prefill','year','month','value_sign_in'), false);

		// print_r($tables);exit();
		$tableRows = array();
		if ($tables->totalCount > 0) {
			$i = 1;
			foreach ($tables->data as $row) {
				// print_r($row);exit();
				array_push($tableRows, array($i, $row->template_name, $row->id, $row->status, $row->prefill, $row->year,$row->month,$row->value_sign_in));
				$i++;
			}
			rsort($tableRows);
		}
		$results = array(
			"draw" => 1,
			"recordsTotal" => count($tableRows),
			"recordsFiltered" => count($tableRows),
			"data" => $tableRows
		);
		echo json_encode($results);
	}

	public function getTablesList1()
	{
		$user_id = $this->session->user_session->user_id;
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		if ($this->input->post('company_id') == 'all') {
			$company_id = $this->input->post('company_id');
			$where = array('status' => 1,'year'=>$year,'month'=>$month);
			$where_in = null;
		} else {
			$company_id = $this->session->user_session->company_id;
			$branch_id = $this->session->user_session->branch_id;
			$where = array('status' => 1, 'company_id' => $company_id,'year'=>$year,'month'=>$month);
		}
		$tables = $this->TemplateToolModel->_select('handson_template_master', $where, array('id', 'template_name', 'status', 'prefill','value_sign_in'), false);

		// print_r($tables);exit();
		$tableRows = array();
		if ($tables->totalCount > 0) {
			$tableRows = $tables->data;
			rsort($tableRows);
		} else {
			$tableRows = array();
		}
		$response['status'] = 200;
		$response['data'] = $tableRows;
		echo json_encode($response);
	}

	public function edithandsontemplate()
	{
		// print_r($this->input->post());exit();
		if (!is_null($this->input->post('id')) && !is_null($this->input->post('template_name'))) {
			$company_id = '';
			$template_id = $this->input->post('id');
			$template_name = $this->input->post('template_name');
			$resultObject = $this->TemplateToolModel->_select('handson_template_column_master ht', array('template_id' => $template_id), "*,(select company_id from handson_template_master hm where hm.id=ht.template_id) as company_id", false);
			// print_r($resultObject);exit();
			$attributeRows = array();
			if ($resultObject->totalCount > 0) {

				foreach ($resultObject->data as $row) {
					array_push($attributeRows, $row);
					$company_id = $row->company_id;
				}
				$response['status'] = 200;
				$response['template_name'] = $template_name;
				$response['company_id'] = $company_id;
				$response['body'] = $attributeRows;
			} else {
				$response['status'] = 200;
				$response['template_name'] = $template_name;
				$response['company_id'] = $company_id;
				$response['body'] = $attributeRows;
			}

		} else {
			$response['status'] = 201;
			$response['body'] = 'Parameter missing';
		}
		echo json_encode($response);
	}

	public function changeHandsonTemplateStatus()
	{
		if (!is_null($this->input->post('template_id')) && !is_null($this->input->post('status'))) {
			$template_id = $this->input->post('template_id');
			$status = $this->input->post('status');
			if ($status == 1) {
				$status = 0;
			} else {
				$status = 1;
			}
			$resultObject = $this->TemplateToolModel->_update('handson_template_master', array('status' => $status), array('id' => $template_id));
			if ($resultObject->status == true) {
				$response['status'] = 200;
				$response['body'] = 'Changes Saved';
			} else {
				$response['status'] = 201;
				$response['body'] = 'Changes not Saved';
			}
		} else {
			$response['status'] = 201;
			$response['body'] = 'Parameter missing';
		}
		echo json_encode($response);
	}

	public function fetchAllCreatedTemplatesTool()
	{
		$board_id = $this->input->get_post('board_id');
		$result = $this->TemplateToolModel->fetchAllCreatedTemplatesTool($board_id);

		if ($result != false) {
			$displayResult = '<option disabled value="">Select SpreadSheet</option>';

			foreach ($result as $row) {
				$displayResult .= '<option value="' . $row->id . '">' . $row->template_name . '</option>';
			}
			$response['status'] = 200;
			$response['body'] = $displayResult;
		} else {
			$response['status'] = 202;
			$response['body'] = 'No Template Found';
		}
		echo json_encode($response);
	}

	public function fetch_templatesTool()
	{
		$temp_id = $this->input->post("temp_id");
		$item_id = $this->input->post("item_id");
		$board_list = $this->input->post("board_list");
		$user_type = $this->session->user_session->user_type;
		$user_id = $this->session->user_session->user_id;

		$order_by = array();
		foreach (explode(",", $temp_id) as $temp) {
			array_push($order_by, "'" . $temp . "'");
		}
		$data1 = $this->TemplateToolModel->_rawQuery('select * from handson_template_master where find_in_set(id,"' . $temp_id . '") ORDER BY FIELD(id,' . implode(",", $order_by) . ')');
		// print_r($data1);exit();
		$response['query'] = $data1->last_query;
		if ($data1->totalCount > 0) {
			$response['status'] = 200;
			$response['body'] = $data1->data;
		} else {
			$response['status'] = 201;
			$response['body'] = array();
		}
		echo json_encode($response);
	}

	public function fetch_templatesHandonData()
	{
		if (!is_null($this->input->post("temp_id"))) {
			$temp_id = $this->input->post("temp_id");
			$branch_id = $this->input->post("branch_id");
			$year = $this->input->post("year");
			$month = $this->input->post("month");
			$value_sign_in = $this->input->post("value_sign_in");
			$number_conversion = $this->input->post("valuesIn");
			$user_type = $this->session->user_session->user_type;
			$user_id = $this->session->user_session->user_id;
			$company_id = $this->session->user_session->company_id;
			// $columnObject = $this->TemplateToolModel->_select('handson_template_column_master',array('template_id'=>$temp_id),'*',false);
			$columnObject = $this->TemplateToolModel->_rawQuery('select *
from handson_template_column_master hm where template_id="' . $temp_id . '" order by sequence asc');
			$branchObject = $this->TemplateToolModel->_select('branch_master',array('company_id'=>$company_id,'id'=>$branch_id),'*');
			$is_consolidate=0;
			if($branchObject->totalCount>0)
			{
				if($branchObject->data->is_consolidated==1)
				{
					$is_consolidate=1;
				}
			}
			$columnHeaders = array('id', 'created_by');
			$columnTypes = array();
			$hideColumns = array();
			$columnData = array();
			$columnValueSign = array();
			$object1 = new stdClass();
			$object1->type = 'text';
			$rowsCol = "";
			$readonlyArray = array();
			$columnSummary = array();
			$hideColumns = array(0, 1);
			$formulaMaker=array();
			array_push($columnTypes, $object1, $object1);
			$divide = 1;
			if (!is_null($number_conversion)) {
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
			}
			if ($columnObject->totalCount > 0) {
				foreach ($columnObject->data as $key => $value) {
					array_push($columnHeaders, $value->column_name);

					$object = new stdClass();
					$object->type = $value->column_type;

					if ($value->column_type == 'dropdown') {
						if ($value->option_data != '') {
							$object->source = explode(',', $value->option_data);
						}
					}
					if ($value->column_value == "column_1") {
						$object->readOnly = true;
					}

					array_push($columnTypes, $object);
					array_push($columnData, $value->column_value);
					array_push($formulaMaker, $value->formula_maker);
							$columnValueSign[$value->column_value]=$value->value_sign;
				}

				if($is_consolidate==1)
				{
					$rowsObject=$this->TemplateToolModel->_select('handson_transaction_table hm', array('template_id' => $temp_id, 'company_id' => $company_id,'year' => $year, 'month' => $month, 'status' => 1,'branch_id!='=>$branch_id),
					'id, template_id, user_id, column_1,sum(column_2) as column_2,sum(column_3) as column_3,sum(column_4) as column_4,sum(column_5) as column_5,sum(column_6) as column_6,
					sum(column_7) as column_7,sum(column_8) as column_8,sum(column_9) as column_9,sum(column_10) as column_10,sum(column_11) as column_11,sum(column_12) as column_12,sum(column_13) as column_13
					,sum(column_14) as column_14,sum(column_15) as column_15,created_by, created_on, modify_by, modify_at, user_type, status, branch_id, company_id, year, month, is_opening_balance, closing_balance_column,
					(select group_concat((case when hp.value_type is null then "" else hp.value_type end), "#", 
					(case when hp.formula is null then "" else hp.formula end), "#", (case when hp.formula_minus is null then "" else hp.formula_minus end)) 
					from handson_prefill_table hp where hp.template_id=hm.template_id and hp.column_1=hm.column_1) as PrefillData',false,'column_1');
				}
				else{
					$rowsObject = $this->TemplateToolModel->_select('handson_transaction_table hm', array('template_id' => $temp_id, 'company_id' => $company_id, 'branch_id' => $branch_id, 'year' => $year, 'month' => $month, 'status' => 1),
						'*,(select group_concat((case when hp.value_type is null then "" else hp.value_type end),"#",
					(case when hp.formula is null then "" else hp.formula end),"#",
					(case when hp.formula_minus is null then "" else hp.formula_minus end)) from handson_prefill_table hp where hp.template_id=hm.template_id and hp.column_1=hm.column_1) as PrefillData', false);
				}
				if ($rowsObject->totalCount > 0) {
					$rowsCol = array();
					$r = 0;
					foreach ($rowsObject->data as $rkey => $rvalue) {
						if($is_consolidate==1)
						{
							$data = array('', $rvalue->created_by);
						}
						else{
							$data = array($rvalue->id, $rvalue->created_by);
						}


						if (trim($rvalue->created_by) != trim($user_id)) {
							array_push($readonlyArray, $r);
						}
						$a = 2;
						$char = 'C';

						foreach ($columnData as $ckey => $cvalue) {
							$PrefillData = $rvalue->PrefillData;

							$colOBj = new stdClass();
							if ($a != 2) {
								if (!is_null($PrefillData)) {
									$arr = explode("#", $PrefillData);
									$value_type = $arr[0];
									$formula = $arr[1];
									$formula_minus = $arr[2];
									if ($value_type == 'Calculated') {
										$formula = rtrim($formula, ",");
										$arr1 = explode(',', $formula);
										$a1 = array();
										foreach ($arr1 as $a2) {
											if ($a2 != "") {
												$a1[] = $char . $a2;

											}
										}

										$formula_minus = rtrim($formula_minus, ",");
										$arr2 = explode(',', $formula_minus);
										$a3 = array();
										foreach ($arr2 as $a_minus) {
											if ($a_minus != "") {
												$a3[] = $char . $a_minus;

											}
										}
										$text1 = "";
										$formulaExcel = "";
										if (count($a1)) {
											$formulaplus = implode(",", $a1);
											$text1 = "sum(" . $formulaplus . ")";

										}
										$text2 = "";
										if (count($a3) > 0) {
											$formulaminus = implode(",", $a3);
											$text2 = "sum(" . $formulaminus . ")";
										}
										if ($text1 == "" && $text2 == "") {
											$formulaExcel = "";
										} else if ($text1 != "" && $text2 == "") {
											$formulaExcel = "=round(" . $text1 . ",2)";
										} else if ($text1 == "" && $text2 != "") {
											$formulaExcel = "=round(" . $text2 . ",2)";
										} else {
											$formulaExcel = "=round(" . $text1 . "-" . $text2 . ",2)";
										}
										array_push($data, $formulaExcel);
										//$arr1=array_map('intval', explode(',', $formula));
										//$arrayNew = array();
										//$arrayNew = array_pop($sports);

										/*$colOBj->ranges = $arrayNew;
										$colOBj->destinationRow = $rkey;
										$colOBj->destinationColumn = $a;
										$colOBj->reversedRowCoords = false;
										$colOBj->type = 'sum';
										$colOBj->forceNumeric = true;
										array_push($columnSummary, $colOBj);*/
									} else {
										if (is_numeric($rvalue->$cvalue)) {
											$rvalue->$cvalue = round($rvalue->$cvalue / $divide, 2);
										}
										if($formulaMaker[$ckey]!="" && $formulaMaker[$ckey]!=null && $formulaMaker[$ckey]!='null')
										{
											$formulaDta=$formulaMaker[$ckey];
											$formulaDta=str_replace('#',$r+1,$formulaDta);
											$rvalue->$cvalue="=".$formulaDta."";
										}
										array_push($data, $rvalue->$cvalue);
									}
								} else {
									if (is_numeric($rvalue->$cvalue)) {
										$rvalue->$cvalue = round($rvalue->$cvalue / $divide, 2);
									}
									if($formulaMaker[$ckey]!="" && $formulaMaker[$ckey]!=null && $formulaMaker[$ckey]!='null')
									{
										$formulaDta=$formulaMaker[$ckey];
										$formulaDta=str_replace('#',$r+1,$formulaDta);
										$rvalue->$cvalue="=".$formulaDta."";
									}
									array_push($data, $rvalue->$cvalue);
								}
							} else {
								if (is_numeric($rvalue->$cvalue)) {
									$rvalue->$cvalue = round($rvalue->$cvalue / $divide, 2);
								}
								array_push($data, $rvalue->$cvalue);
							}

							$a++;
							$char++;
						}
						array_push($data, $rvalue->is_opening_balance);
						array_push($data, $rvalue->closing_balance_column);
						array_push($rowsCol, $data);
						$r++;
					}
				} else {
					$rowsObject1 = $this->TemplateToolModel->_select('handson_prefill_table', array('template_id' => $temp_id, 'status' => 1), '*', false);
					if ($rowsObject1->totalCount > 0) {
						$arrayGLAccountData=array();
						$subsidiaryAccount=$this->TemplateToolModel->_select('handson_subsidiary_account_table hm', array('template_id' => $temp_id, 'company_id' => $company_id, 'status' => 1,'year'=>$year,'month'=>$month),'*', false);
						if($subsidiaryAccount->totalCount>0)
						{
							foreach ($subsidiaryAccount->data as $key=>$row2){
								for($i=2;$i<=15;$i++){
									$colVal1="column_".$i;
									$v=0;
									if($row2->$colVal1 == null || $row2->$colVal1==""){
										$v=0;
									}else{
										$exp=explode("-",$row2->$colVal1);
										if($exp[0]!="")
										{
											$v=$this->getColumnTextData($month,$year,$branch_id,$exp[0],$temp_id,$row2->$colVal1,$value_sign_in);
										}
									}
									$arrayGLAccountData[$colVal1][]=$v;
								}
							}
						}
						$rowsCol = array();
						$r = 0;
						foreach ($rowsObject1->data as $rkey => $rvalue) {
							$data = array('', '');
							if ($rvalue->value_type == 'Calculated') {

							}
							if (trim($rvalue->created_by) != trim($user_id) || $rvalue->value_type == 'Calculated') {
								array_push($readonlyArray, $r);
							}
							foreach ($columnData as $ckey => $cvalue) {
								if (is_numeric($rvalue->$cvalue)) {
									$rvalue->$cvalue = round($rvalue->$cvalue / $divide, 2);
								}
								$returnData=$this->getGLDataExist($rkey,$cvalue,$divide,$arrayGLAccountData);
								if($returnData!="" && $returnData!=0) {
									if ($columnValueSign[$cvalue] == 1)
									{
										$returnData=abs($returnData);
									}
									else if($columnValueSign[$cvalue]==2)
								{
										$returnData= -abs($returnData);
									}
									else if($columnValueSign[$cvalue]==3)
									{
										$returnData= $returnData <= 0 ? abs($returnData) : -$returnData ;
									}
									$rvalue->$cvalue=$returnData;
								}
								array_push($data, $rvalue->$cvalue);
							}
							array_push($data, $rvalue->is_opening_balance);
							array_push($data, $rvalue->closing_balance_column);
							array_push($rowsCol, $data);
							$r++;
						}
					} else {
						$data = array('', '');
						$rowsCol = array();
						foreach ($columnData as $ckey => $cvalue) {
							array_push($data, '');
						}
						array_push($rowsCol, $data);
					}

				}
			}
			$query3=$this->Master_Model->_rawQuery("select * from block_year_data where status=1 AND company_id=".$company_id." AND year=".$year." AND month=".$month);
			if($query3->totalCount > 0){
				$response['BlockYear'] = 1;
			}else{
				$response['BlockYear'] = 0;
			}
			$response['status'] = 200;
			$response['columnHeaders'] = $columnHeaders;
			$response['columnTypes'] = $columnTypes;
			$response['columnSummary'] = $columnSummary;
			$response['hideArra'] = $hideColumns;
			$response['columnRows'] = $rowsCol;
			$response['readonlyArray'] = $readonlyArray;
		} else {
			$response['status'] = 201;
			$response['body'] = 'Required Parameter Missing';
		}
		echo json_encode($response);
	}
	function getGLDataExist($rkey,$cvalue,$divide,$arrayGLAccountData)
	{
		$value=0;
		if(count($arrayGLAccountData)>0)
		{
			if(array_key_exists($cvalue,$arrayGLAccountData))
			{
				if(array_key_exists($rkey,$arrayGLAccountData[$cvalue]))
				{
					if($arrayGLAccountData[$cvalue][$rkey]!="" && $arrayGLAccountData[$cvalue][$rkey]!=0)
					{
						$value= round($arrayGLAccountData[$cvalue][$rkey]/ $divide, 2);
					}
				}
			}
		}
		return $value;
	}

	public function saveSpreadSheetTool()
	{
		if (!is_null($this->input->post('arrData'))) {
			$temp_id = $this->input->post('temp_id');
			$Data1 = $this->input->post('arrData');
			$branch_id = $this->input->post('branch_id');
			$year = $this->input->post('year');
			$month = $this->input->post('month');
			$arrData = json_decode($Data1);
			// print_r($arrData);exit();
			$user_type = $this->session->user_session->user_type;
			$user_id = $this->session->user_session->user_id;
			$company_id = $this->session->user_session->company_id;
			$columnObject = $this->TemplateToolModel->_rawQuery('select *,
(select group_concat(hp.value_type,"#",hp.formula) from handson_prefill_table hp where hp.template_id=hm.template_id and hp.column_1=hm.column_name) as PrefillData
 from handson_template_column_master hm where template_id="' . $temp_id . '" order by sequence asc');

			$columnData = array();
			$column_name = array();
			$valueType = array();
			$formula = array();
			$value_typeRow = array();
			$formulaRow = array();
			$glAccounts = array();
			if ($columnObject->totalCount > 0) {
				$c = 1;
				foreach ($columnObject->data as $key => $value) {
					array_push($columnData, $value->column_value);
					array_push($column_name, $value->column_name);
					array_push($valueType, $value->value_type);
					array_push($formula, $value->formula);
					$c++;
					$PrefillData = $value->PrefillData;
					$gl_account = $value->gl_account;
					array_push($glAccounts, $gl_account);

					if (!is_null($PrefillData)) {
						$arr = explode('#', $PrefillData);

						$value_typeRow[$value->column_name] = $arr[0];
						$formulaRow[$value->column_name] = $arr[1];
					}
				}
			}
			//get All row name
			$prefillCol1Array = array();
			$resulObjectData = $this->Master_Model->_rawQuery("select column_1 from handson_prefill_table where template_id=" . $temp_id);
			if ($resulObjectData->totalCount > 0) {
				$resultArray = $resulObjectData->data;
				foreach ($resultArray as $item1) {
					$prefillCol1Array[] = $item1->column_1;
				}
			}
			$rowsId = array();
			$rowsObject = $this->TemplateToolModel->_select('handson_transaction_table', array('template_id' => $temp_id, 'company_id' => $company_id, 'branch_id' => $branch_id, 'year' => $year, 'month' => $month), '*', false);
			if ($rowsObject->totalCount > 0) {

				foreach ($rowsObject->data as $rkey => $rvalue) {
					array_push($rowsId, $rvalue->id);
				}
			}
			//get GL Accounts Data
			$arrGL = array();
			$newArray = array();
			$updateArray = array();
			foreach ($arrData as $item) {
				if (array_filter($item)) {
					if ($item[2] != "" && $item[2] != "null" && $item[2] != null) {
						$lastData = count($item) - 1;
						$secondlastData = $lastData - 1;
						if ($item[0] == "") {
							$data = array(
								"template_id" => $temp_id,
								"company_id" => $company_id,
								"branch_id" => $branch_id,
								"user_id" => $user_id,
								"user_type" => $user_type,
								"month" => $month,
								"year" => $year,
								"created_by" => $user_id,
								"created_on" => date('Y-m-d H:i:s')
							);
							$i = 2;
							$j = 0;
							$prevYear = false;
							if ($item[$secondlastData] == "Yes") {
								$rowNum = $item[$lastData];
								if (array_key_exists($rowNum, $prefillCol1Array)) {
									$colNAme = $prefillCol1Array[$rowNum];
									$getPreviousYearValue = $this->getPreviousYearValue($colNAme, $year, $temp_id, $branch_id, $company_id);
									if ($getPreviousYearValue != false) {
										$prevYear = $getPreviousYearValue;
									}
								}
							}

							foreach ($columnData as $cvalue) {
								//check row is opening balance $prefillCol1Array
								if ($item[$secondlastData] == "Yes" && $prevYear != false) {
									if ($cvalue == 'column_1') {
										$data[$cvalue] = $item[$i];
									} else {
										$data[$cvalue] = $prevYear->$cvalue;
									}

									$data['is_opening_balance'] = $item[$secondlastData];
									$data['closing_balance_column'] = $item[$lastData];
									$i++;
									$j++;
								} else {

									if ($valueType[$j] == 2) { //if type is calculated then take sum of given columns
										$formulaSqnce = explode(",", $formula[$j]);

										$addition = 0;
										foreach ($formulaSqnce as $seq) {
											$seq = $seq + 1;
											if (is_numeric($item[$seq])) {
												$addition += $item[$seq];
											}

										}
										$data[$cvalue] = $addition;
									} else {
											$data[$cvalue] = $item[$i];
									}
									$data['is_opening_balance'] = $item[$secondlastData];
									$data['closing_balance_column'] = $item[$lastData];
									$i++;
									$j++;
								}


							}
							array_push($newArray, $data);
						} else {

							$update_data = array('id' => $item[0], 'modify_by' => $user_id, 'modify_at' => date('Y-m-d H:i:s'),'branch_id'=>$branch_id);
							if (in_array($item[0], $rowsId)) {
								$pos = array_search($item[0], $rowsId);
								unset($rowsId[$pos]);
							}
							$i = 2;
							$j = 0;
							foreach ($columnData as $cvalue) {
								if ($valueType[$j] == 2) { //if type is calculated then take sum of given columns
									$formulaSqnce = explode(",", $formula[$j]);
									$addition = 0;
									foreach ($formulaSqnce as $seq) {
										$seq = $seq + 1;
										if (is_numeric($item[$seq])) {
											$addition += $item[$seq];
										}
									}
									$update_data[$cvalue] = $addition;

								} else {
										$update_data[$cvalue] = $item[$i];
								}
								$update_data['is_opening_balance'] = $item[$secondlastData];
								$update_data['closing_balance_column'] = $item[$lastData];
								$i++;
								$j++;
							}
							array_push($updateArray, $update_data);
						}
					}
				}
			}
			if (!empty($rowsId)) {
				$names = $rowsId;
				$this->db->where_in('id', $names);
				$this->db->update('handson_transaction_table', array('status' => 0, 'modify_by' => $user_id, 'modify_at' => date('Y-m-d H:i:s')));
			}
			$status = FALSE;
			try {
				$this->db->trans_start();
				if (!empty($newArray)) {
					$insert_batch = $this->db->insert_batch("handson_transaction_table", $newArray);
				}
				if (!empty($updateArray)) {
					$update_batch = $this->db->update_batch("handson_transaction_table", $updateArray, 'id');
				}
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					$status = FALSE;
				} else {
					$this->db->trans_commit();
					$status = TRUE;
				}
				$this->db->trans_complete();
				$last_query = $this->db->last_query();
			} catch (Exception $ex) {
				$status = FALSE;
				$this->db->trans_rollback();
			}
			if ($status == true) {
				$response['status'] = 200;
				$response['body'] = "Data uploaded Successfully";
			} else {
				$response['status'] = 201;
				$response['body'] = "Failed To uplaod";
			}
		} else {
			$response['status'] = 201;
			$response['body'] = "Failed To uplaod";
		}
		echo json_encode($response);
	}

	function getPreviousYearValue($colNAme, $year, $temp_id, $branch_id, $company_id)
	{
		$year = $year - 1;
		$query = $this->db->query("Select * from handson_transaction_table where template_id=" . $temp_id . " AND branch_id=" . $branch_id . " AND company_id=" . $company_id . " AND year=" . $year . " AND month=3 AND column_1='" . $colNAme . "'");
		if ($this->db->affected_rows() > 0) {
			$row = $query->row();
			return $row;
		} else {
			return false;
		}
	}

	public function saveCurrencyConversion()
	{
		if (!is_null($this->input->post('arrData'))) {
			$temp_id = $this->input->post('temp_id');
			$Data1 = $this->input->post('arrData');
			$branch_id = $this->input->post('branch_id');
			$year = $this->input->post('year');
			$month = $this->input->post('month');
			$arrData = json_decode($Data1);
			// print_r($arrData);exit();
			$user_type = $this->session->user_session->user_type;
			$user_id = $this->session->user_session->user_id;
			$company_id = $this->session->user_session->company_id;
			$columnObject = $this->TemplateToolModel->_rawQuery('select * from handson_template_column_master hm where template_id="' . $temp_id . '" order by sequence asc');

			$columnData = array();
			$column_name = array();
			$glAccounts = array();
			if ($columnObject->totalCount > 0) {
				$c = 1;
				foreach ($columnObject->data as $key => $value) {
					array_push($columnData, $value->column_value);
					array_push($column_name, $value->column_name);
					$c++;
					$gl_account = $value->gl_account;
					array_push($glAccounts, $gl_account);
				}
			}
			$rowsId = array();
			$rowsObject = $this->TemplateToolModel->_select('handson_currency_rate_table', array('template_id' => $temp_id, 'company_id' => $company_id, 'branch_id' => $branch_id, 'year' => $year, 'month' => $month), '*', false);
			if ($rowsObject->totalCount > 0) {

				foreach ($rowsObject->data as $rkey => $rvalue) {
					array_push($rowsId, $rvalue->id);
				}
			}
			//get GL Accounts Data
			$arrGL = array();
			$newArray = array();
			$updateArray = array();

			foreach ($arrData as $item) {
				if (array_filter($item)) {
					if ($item[2] != "" && $item[2] != "null" && $item[2] != null) {
						if ($item[0] == "") {
							$data = array(
								"template_id" => $temp_id,
								"company_id" => $company_id,
								"branch_id" => $branch_id,
								"user_id" => $user_id,
								"user_type" => $user_type,
								"month" => $month,
								"year" => $year,
								"created_by" => $user_id,
								"created_on" => date('Y-m-d H:i:s')
							);
							$i = 2;
							$j = 0;

							foreach ($columnData as $cvalue) {
								$data[$cvalue] = $item[$i];
								$i++;
								$j++;
							}
							array_push($newArray, $data);
						} else {

							$update_data = array('id' => $item[0], 'modify_by' => $user_id, 'modify_at' => date('Y-m-d H:i:s'));
							if (in_array($item[0], $rowsId)) {
								$pos = array_search($item[0], $rowsId);
								unset($rowsId[$pos]);
							}
							$i = 2;
							foreach ($columnData as $cvalue) {
								$update_data[$cvalue] = $item[$i];
								$i++;
							}
							array_push($updateArray, $update_data);
						}
					}
				}
			}
			if (!empty($rowsId)) {
				$names = $rowsId;
				$this->db->where_in('id', $names);
				$this->db->update('handson_currency_rate_table', array('status' => 0, 'modify_by' => $user_id, 'modify_at' => date('Y-m-d H:i:s')));
			}
			$status = FALSE;
			try {
				$this->db->trans_start();
				if (!empty($newArray)) {
					$insert_batch = $this->db->insert_batch("handson_currency_rate_table", $newArray);
				}
				if (!empty($updateArray)) {
					$update_batch = $this->db->update_batch("handson_currency_rate_table", $updateArray, 'id');
				}
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					$status = FALSE;
				} else {
					$this->db->trans_commit();
					$status = TRUE;
				}
				$this->db->trans_complete();
				$last_query = $this->db->last_query();
			} catch (Exception $ex) {
				$status = FALSE;
				$this->db->trans_rollback();
			}
			if ($status == true) {
				$response['status'] = 200;
				$response['body'] = "Data uploaded Successfully";
			} else {
				$response['status'] = 201;
				$response['body'] = "Failed To uplaod";
			}
		} else {
			$response['status'] = 201;
			$response['body'] = "Failed To uplaod";
		}
		echo json_encode($response);
	}

	public function saveRupeesData()
	{
		if (!is_null($this->input->post('arrData'))) {
			$temp_id = $this->input->post('temp_id');
			$Data1 = $this->input->post('arrData');
			$branch_id = $this->input->post('branch_id');
			$year = $this->input->post('year');
			$month = $this->input->post('month');
			$id = $this->input->post('id');
			$arrData = json_decode($Data1);
			// print_r($arrData);exit();
			$user_type = $this->session->user_session->user_type;
			$user_id = $this->session->user_session->user_id;
			$company_id = $this->session->user_session->company_id;
			if ($id == 1) {
				$columnObject = $this->TemplateToolModel->_rawQuery('select * from handson_template_column_master hm where template_id="' . $temp_id . '" order by sequence asc');

				$columnData = array();
				$column_name = array();
				$glAccounts = array();
				if ($columnObject->totalCount > 0) {
					$c = 1;
					foreach ($columnObject->data as $key => $value) {
						array_push($columnData, $value->column_value);
						array_push($column_name, $value->column_name);
						$c++;
					}
				}
				$arrGL = array();
				$newArray = array();
				$insertData = array();

				foreach ($arrData as $item) {
					if (array_filter($item)) {
						if ($item[2] != "" && $item[2] != "null" && $item[2] != null) {
							$data = array(
								"template_id" => $temp_id,
								"company_id" => $company_id,
								"branch_id" => $branch_id,
								"user_id" => $user_id,
								"user_type" => $user_type,
								"month" => $month,
								"year" => $year,
								"created_by" => $user_id,
								"created_on" => date('Y-m-d H:i:s')
							);
							$i = 2;
							$j = 0;

							foreach ($columnData as $cvalue) {
								$data[$cvalue] = $item[$i];
								$i++;
								$j++;
							}
							array_push($insertData, $data);
						}
					}
				}
			} else {
				$TransactionData = array();
				$CurrencyData = array();
				//get Data from transaction Table
				$branchtransactionData = $this->TemplateToolModel->_rawQuery("Select *,(select group_concat((case when hp.value_type is null then '' else hp.value_type end), '#', 
 (case when hp.formula is null then '' else hp.formula end), '#', (case when hp.formula_minus is null then '' else hp.formula_minus end)) 
 from handson_prefill_table hp where hp.template_id=hm.template_id and hp.column_1=hm.column_1 and hp.formula_in_rupee='Yes') as PrefillData from handson_transaction_table hm where status=1 AND month=" . $month . " AND year=" . $year . " AND template_id=" . $temp_id . " AND branch_id=" . $branch_id);
				if ($branchtransactionData->totalCount > 0) {
					$TransactionData = $branchtransactionData->data;
				}
				//get Data from Currency Table
				$branchCurrencyData = $this->TemplateToolModel->_rawQuery("Select * from handson_currency_rate_table where status=1 AND  month=" . $month . " AND year=" . $year . " AND template_id=" . $temp_id . " AND branch_id=" . $branch_id);
				if ($branchCurrencyData->totalCount > 0) {
					$CurrencyData = $branchCurrencyData->data;
				}
				//get data from additional gl rate
				$arrayGLAccountData=array();
				$arrayPreviousRupeesData=array();
				$subsidiaryAccount=$this->TemplateToolModel->_select('handson_subsidiary_account_table hm', array('template_id' => $temp_id, 'company_id' => $company_id, 'status' => 1,'year'=>$year,'month'=>$month),'*', false);
				if($subsidiaryAccount->totalCount>0)
				{
					foreach ($subsidiaryAccount->data as $key=>$row2){
						for($i=2;$i<=15;$i++){
							$colVal1="column_".$i;
							$v=0;
							$previous_v=0;
							if($row2->$colVal1 == null || $row2->$colVal1==""){
								$v=0;
							}else{
								$exp=explode("-",$row2->$colVal1);
								if($exp[0]!="")
								{
									$prevData=$this->getColumnAdditionalGLData($month,$year,$branch_id,$exp[0],$temp_id,$row2->$colVal1);
									$v=$prevData->additional;
									$previous_v=$prevData->rupeesdata;

								}
							}
							$arrayGLAccountData[$colVal1][]=$v;
							$arrayPreviousRupeesData[$colVal1][]=$previous_v;
						}
					}
				}
//				print_r($arrayGLAccountData);exit();
				$columnObject = $this->TemplateToolModel->_rawQuery('select * from handson_template_column_master hm where template_id="' . $temp_id . '" order by sequence asc');

				$insertData = array();
				$insertData1 = array();
				if ($columnObject->totalCount > 0) {
					$rowValue=array();
					$calculationColumn=array();
					foreach ($TransactionData as $key1 => $row) {

						$data = array(
							"template_id" => $temp_id,
							"company_id" => $company_id,
							"branch_id" => $branch_id,
							"user_id" => $user_id,
							"user_type" => $user_type,
							"month" => $month,
							"year" => $year,
							"created_by" => $user_id,
							"created_on" => date('Y-m-d H:i:s')
						);
						$PrefillData = $row->PrefillData;
						if (!is_null($PrefillData)) {
							$arr = explode("#", $PrefillData);
							$value_type = $arr[0];
							$formula = $arr[1];
							$formula_minus = $arr[2];
							if ($value_type == 'Calculated') {
								$formula = rtrim($formula, ",");
								$arr1 = explode(',', $formula);
								$a1 = array();
								foreach ($arr1 as $a2) {
									if ($a2 != "") {
										$a1[] = $a2;

									}
								}

								$formula_minus = rtrim($formula_minus, ",");
								$arr2 = explode(',', $formula_minus);
								$a3 = array();
								foreach ($arr2 as $a21) {
									if ($a21 != "") {
										$a3[] = $a21;

									}
								}

								$formulaValue[0]=$a1;
								$formulaValue[1]=$a3;

								$calculationColumn[$key1]=$formulaValue;
							}
						}
						$columnArr=array();
						foreach ($columnObject->data as $key => $value) {
							$val = $value->column_value;
							if ($value->column_value == 'column_1') {
								$data[$value->column_value] = $row->$val;
							} else {
								if (array_key_exists($key1, $CurrencyData)) {
									$currency = $CurrencyData[$key1]->$val;
								} else {
									$currency = null;
								}

								if ($currency == null) {
									$currency = 1;
								}
								$transval = $row->$val;
								if ($transval == null) {
									$transval = 0;
								}
								$currencyValue=0;
								if($value->value_type==2)
								{
									if($value->inlcude_branch_sum==1)
									{
										$addition=0;
										if($value->formula!=null && $value->formula!="")
										{
										$formulaSqnce = explode(",", $value->formula);

										foreach ($formulaSqnce as $seq) {
											$columnSeq='column_'.$seq;
												if(array_key_exists($columnSeq,$columnArr))
												{
											if (is_numeric($columnArr[$columnSeq])) {
												$addition += $columnArr[$columnSeq];
											}
										}
											}
										}
										$currencyValue = $addition;
									}
									else{
										$currencyValue = $currency * $transval;
									}
								}
								else{
									$currencyValue = $currency * $transval;
								}
								$returnData=$this->getGLDataExist($key1,$value->column_value,1,$arrayGLAccountData);
								if($returnData!="" && $returnData!=0)
								{
									$currencyValue=$currencyValue+$returnData;
								}
								if(array_key_exists($value->column_value,$arrayPreviousRupeesData))
								{
									if($arrayPreviousRupeesData[$value->column_value][$key1]!=0)
									{
										$currencyValue=$arrayPreviousRupeesData[$value->column_value][$key1];
									}
								}
								$data[$value->column_value]=$currencyValue;
								$columnArr[$value->column_value]=$currencyValue;
								$rowValue[$key1]=$currency * $transval;
							}
						}
						array_push($insertData1, $data);
					}

					foreach ($insertData1 as $inskey => $insRow)
					{
						if(array_key_exists($inskey,$calculationColumn))
						{
							$a1=$calculationColumn[$inskey][0];
							$a3=$calculationColumn[$inskey][1];
							$text1 = "";
								$formulaExcel = 0;
								if (count($a1)>0) {
									foreach ($a1 as $a1key=> $a1Row)
									{
										if(array_key_exists($a1Row-1,$rowValue))
										{
											$a1[$a1key]=$rowValue[$a1Row-1];
										}
									}
									$text1 = array_sum($a1);
								}
								$text2 = "";
								if (count($a3) > 0) {

									foreach ($a3 as $a3key=> $a3Row)
									{
										if(array_key_exists($a3Row-1,$rowValue))
										{
											$a3[$a3key]=$rowValue[$a3Row-1];
										}
									}
									$text2 = array_sum($a3);
								}

								if ($text1 == "" && $text2 == "") {
									$formulaExcel = 0;
								} else if ($text1 != "" && $text2 == "") {
									$formulaExcel = round($text1,2);
								} else if ($text1 == "" && $text2 != "") {
									$formulaExcel = round($text2,2);
								} else {
									$formulaExcel = round(($text1-$text2)*1,2);
								}
								$rowValue[$inskey]=$formulaExcel;
								$insRow['column_2']=$formulaExcel;
						}
						array_push($insertData,$insRow);
					}
//
				}
			}

			$where = array(
				"template_id" => $temp_id,
				"company_id" => $company_id,
				"branch_id" => $branch_id,
				"month" => $month,
				"year" => $year,
			);
			$status = FALSE;
			try {
				$this->db->trans_start();
				if (!empty($insertData)) {
					$delete = $this->db->delete('handson_rupees_conversion_table', $where);
					$insert_batch = $this->db->insert_batch("handson_rupees_conversion_table", $insertData);
				}
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					$status = FALSE;
				} else {
					$this->db->trans_commit();
					$status = TRUE;
				}
				$this->db->trans_complete();
				$last_query = $this->db->last_query();
			} catch (Exception $ex) {
				$status = FALSE;
				$this->db->trans_rollback();
			}
			if ($status == true) {
				$response['status'] = 200;
				$response['body'] = "Data uploaded Successfully";
			} else {
				$response['status'] = 201;
				$response['body'] = "Failed To uplaod";
			}
		} else {
			$response['status'] = 201;
			$response['body'] = "Failed To uplaod";
		}
		echo json_encode($response);
	}

	public function fetch_templatesToolHandsonData()
	{
		if (!is_null($this->input->post("temp_id"))) {
			$temp_id = $this->input->post("temp_id");
			$user_type = $this->session->user_session->user_type;
			$user_id = $this->session->user_session->user_id;
			// $columnObject = $this->TemplateToolModel->_select('handson_template_column_master',array('template_id'=>$temp_id),'*',false);
			$columnObject = $this->TemplateToolModel->_rawQuery('select * from handson_template_column_master where template_id="' . $temp_id . '" order by sequence asc');
			$columnHeaders = array('id', 'created_by');
			$columnTypes = array();
			$hideColumns = array();
			$columnData = array();
			$source = array();
			$object1 = new stdClass();
			$object1->type = 'text';
			$rowsCol = "";
			$readonlyArray = array();
			$hideColumns = array(0, 1);
			array_push($columnTypes, $object1, $object1);
			if ($columnObject->totalCount > 0) {
				foreach ($columnObject->data as $key => $value) {
					array_push($columnHeaders, $value->column_name);

					$object = new stdClass();
					$object->type = $value->column_type;
					if ($value->column_type == 'dropdown') {
						if ($value->option_data != '') {
							$object->source = explode(',', $value->option_data);
						}
					}
					array_push($columnTypes, $object);
					array_push($columnData, $value->column_value);
				}
				$rowsObject = $this->TemplateToolModel->_select('handson_prefill_table', array('template_id' => $temp_id, 'status' => 1), '*', false);
				if ($rowsObject->totalCount > 0) {
					$rowsCol = array();
					$r = 0;
					foreach ($rowsObject->data as $rkey => $rvalue) {
						$data = array($rvalue->id, $rvalue->created_by);

						if (trim($rvalue->created_by) != trim($user_id)) {
							array_push($readonlyArray, $r);
						}
						foreach ($columnData as $ckey => $cvalue) {
							array_push($data, $rvalue->$cvalue);
						}
						array_push($data, $rvalue->value_type);
						array_push($data, $rvalue->formula);
						array_push($data, $rvalue->formula_minus);
						array_push($data, $rvalue->is_opening_balance);
						array_push($data, $rvalue->closing_balance_column);
						array_push($data, $rvalue->formula_in_rupee);
						array_push($rowsCol, $data);
						$r++;
					}
				} else {
					$data = array('', '');
					$rowsCol = array();
					foreach ($columnData as $ckey => $cvalue) {
						array_push($data, '');
					}
					array_push($rowsCol, $data);
				}
			}
			// print_r($readonlyArray);exit();
			$response['status'] = 200;
			$response['columnHeaders'] = $columnHeaders;
			$response['columnTypes'] = $columnTypes;
			$response['hideArra'] = $hideColumns;
			$response['columnRows'] = $rowsCol;
			$response['readonlyArray'] = $readonlyArray;
		} else {
			$response['status'] = 201;
			$response['body'] = 'Required Parameter Missing';
		}
		echo json_encode($response);
	}

	public function savePrefillTemplateTool()
	{
		if (!is_null($this->input->post('arrData'))) {
			$temp_id = $this->input->post('temp_id');
			$Data1 = $this->input->post('arrData');
			$arrData = json_decode($Data1);
			$user_type = $this->session->user_session->user_type;
			$user_id = $this->session->user_session->user_id;
			$main_array = array_column($arrData, 2);
			$unique = array_unique($main_array);
			$duplicates = array_diff_assoc($main_array, $unique);
			if ($duplicates != null || !empty($duplicates)) {
				$response['status'] = 201;
				$response['body'] = "Check First Column. Duplicate values are not allowed.";
				$response['duplicate'] = $duplicates;
				echo json_encode($response);
				exit();
			}
			$columnObject = $this->TemplateToolModel->_rawQuery('select * from handson_template_column_master where template_id="' . $temp_id . '" order by sequence asc');
			$columnData = array();
			if ($columnObject->totalCount > 0) {
				$c = 1;
				foreach ($columnObject->data as $key => $value) {
					array_push($columnData, $value->column_value);
					$c++;
				}
				array_push($columnData, 'value_type');
				array_push($columnData, 'formula');
				array_push($columnData, 'formula_minus');
				array_push($columnData, 'is_opening_balance');
				array_push($columnData, 'closing_balance_column');
				array_push($columnData, 'formula_in_rupee');

			}
			$rowsId = array();
			$rowsObject = $this->TemplateToolModel->_select('handson_prefill_table', array('template_id' => $temp_id), '*', false);
			if ($rowsObject->totalCount > 0) {

				foreach ($rowsObject->data as $rkey => $rvalue) {
					array_push($rowsId, $rvalue->id);
				}

			}
			$newArray = array();
			$updateArray = array();
			foreach ($arrData as $item) {

//				if($item[2]!="")
//				{
				/*if($item[0]=="")
				{
					$data = array(
						"template_id" => $temp_id,
						"user_id" => $user_id,
						"user_type" => $user_type,
						"created_by" => $user_id,
						"created_on" => date('Y-m-d H:i:s')
					);
					$i = 2;
					foreach ($columnData as $cvalue) {

						$data[$cvalue]=$item[$i];
						$i++;
					}
					array_push($newArray, $data);
				}
				else
				{

					$update_data=array('id'=>$item[0],'modify_by'=>$user_id,'modify_at'=>date('Y-m-d H:i:s'));
					if(in_array($item[0], $rowsId))
					{
						$pos = array_search($item[0], $rowsId);
						unset($rowsId[$pos]);
					}
					$i = 2;
					foreach ($columnData as $cvalue) {
						$update_data[$cvalue]=$item[$i];
						$i++;
					}
					array_push($updateArray, $update_data);
				}*/
//				}
				if ($item[2] != "" && $item[2] != null && $item[2] != "null") {
					$data = array(
						"template_id" => $temp_id,
						"user_id" => $user_id,
						"user_type" => $user_type,
						"created_by" => $user_id,
						"created_on" => date('Y-m-d H:i:s')
					);
					$i = 2;
					foreach ($columnData as $cvalue) {
						$data[$cvalue] = $item[$i];
						$i++;
					}
					array_push($newArray, $data);
				}
			}
			if (!empty($rowsId)) {
				$names = $rowsId;
				$this->db->where_in('id', $names);
				$this->db->update('handson_prefill_table', array('status' => 0, 'modify_by' => $user_id, 'modify_at' => date('Y-m-d H:i:s')));
			}
//			print_r($newArray);exit();
			$status = FALSE;
			try {
				$this->db->trans_start();
				if (!empty($newArray)) {
					$delete = $this->db->delete('handson_prefill_table', array("template_id" => $temp_id));
					$insert_batch = $this->db->insert_batch("handson_prefill_table", $newArray);
				}
				/*if (!empty($updateArray)) {
					$update_batch = $this->db->update_batch("handson_prefill_table", $updateArray,'id');
				}*/
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					$status = FALSE;
				} else {
					$this->db->trans_commit();
					$status = TRUE;
				}
				$this->db->trans_complete();
				$last_query = $this->db->last_query();
			} catch (Exception $ex) {
				$status = FALSE;
				$this->db->trans_rollback();
			}
			if ($status == true) {
				$response['status'] = 200;
				$response['body'] = "Data uploaded Successfully";
			} else {
				$response['status'] = 201;
				$response['body'] = "Failed To uplaod";
			}
		} else {
			$response['status'] = 201;
			$response['body'] = "Failed To uplaod";
		}
		echo json_encode($response);
	}

	function SaveSpreadSheetAssignment()
	{
		$company_id = $this->input->post('company_id');
		$branch_id = $this->input->post('branch_id');
		$sheet_id = $this->input->post('sheet_id');
		$user_id = $this->session->user_session->user_id;
		$checkAlreadyAssign = $this->checkAlreadyAssign($company_id, $branch_id, $sheet_id);
		if ($checkAlreadyAssign == true) {
			$response['status'] = 201;
			$response['body'] = "Already Assign";
		} else {
			$data = array(
				'branch_id' => $branch_id,
				'company_id' => $company_id,
				'template_id' => $sheet_id,
				'created_by' => $user_id,
			);
			$insert = $this->db->insert('branch_spreadsheet_assignment', $data);
			if ($insert == true) {
				$response['status'] = 200;
				$response['body'] = "Assign Successfully";
			} else {
				$response['status'] = 201;
				$response['body'] = "Failed To Assign";
			}
		}
		echo json_encode($response);
	}

	function checkAlreadyAssign($company_id, $branch_id, $sheet_id)
	{
		$where = array(
			'branch_id' => $branch_id,
			'company_id' => $company_id,
			'template_id' => $sheet_id,
		);
		$query = $this->db->query('select * from branch_spreadsheet_assignment where branch_id=' . $branch_id . ' AND company_id=' . $company_id . ' AND template_id=' . $sheet_id);

		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	function getListsheet()
	{
		$company = $this->Master_Model->order_by_data($select = "*", $where = array("status" => '1'), $table = "handson_template_master", $order_by = "id", $key = "desc");
		$data = array();
		$option = "<option selected disabled>Select Option</option>";
		if (count($company) > 0) {
			foreach ($company as $row) {
				$option .= "<option value='" . $row->id . "'>" . $row->template_name . "</option>";
			}
			$response['data'] = $option;
			$response['status'] = 200;

		} else {
			$response['data'] = $option;
			$response['status'] = 201;
		}
		echo json_encode($response);
	}

	function getGlAccountList()
	{
		$company_id = $this->input->post('company_id');
		$query = $this->Master_Model->_rawQuery("select * from  main_account_setup_master where company_id=" . $company_id);
		//echo $this->db->last_query();
		$option = '';
		if ($query->totalCount > 0) {
			$result = $query->data;
			/*var_dump($result);
			exit;*/
			$option .= "<option value='' selected disabled>Select Gl Number</option>";
			foreach ($result as $row) {
				$option .= "<option value='" . $row->main_gl_number . "'>" . $row->main_gl_number . "-" . $row->name . "</option>";
			}
			$response['data'] = $option;
			$response['status'] = 200;
		} else {
			$option .= "<option value='' selected disabled>Not Found</option>";
			$response['data'] = $option;
			$response['status'] = 201;
		}
		echo json_encode($response);
	}

	function ClearTemplateData()
	{
		$temp_id = $this->input->post('temp_id');
		$branch_id = $this->input->post('branch_id');
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$where = array(
			"template_id" => $temp_id,
			"branch_id" => $branch_id,
			"year" => $year,
			"month" => $month,
		);
		try {
			$this->db->trans_start();
			$response['status'] = 201;
			$body = 'Data Not Saved';
			$query = $this->db->delete('handson_transaction_table', $where);
			$queryCurrency = $this->db->delete('handson_currency_rate_table', $where);
			$queryRupees = $this->db->delete('handson_rupees_conversion_table', $where);
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$response['status'] = 201;
				$body = 'something went wrong';
			} else {
				$this->db->trans_commit();
				$response['status'] = 200;
				$body = 'Data Uploaded';
			}
			$this->db->trans_complete();
		} catch (Exception $exc) {
			$response['status'] = 201;
			$body = 'something went wrong';
			$this->db->trans_rollback();
			$this->db->trans_complete();
		}
		echo json_encode($response);
	}
	function ClearTemplateTransactionData()
	{
		$temp_id = $this->input->post('temp_id');
		$branch_id = $this->input->post('branch_id');
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$where = array(
			"template_id" => $temp_id,
			"branch_id" => $branch_id,
			"year" => $year,
			"month" => $month,
		);
		try {
			$this->db->trans_start();
			$response['status'] = 201;
			$body = 'Data Not Saved';
			$query = $this->db->delete('handson_transaction_table', $where);
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$response['status'] = 201;
				$body = 'something went wrong';
			} else {
				$this->db->trans_commit();
				$response['status'] = 200;
				$body = 'Data Uploaded';
			}
			$this->db->trans_complete();
		} catch (Exception $exc) {
			$response['status'] = 201;
			$body = 'something went wrong';
			$this->db->trans_rollback();
			$this->db->trans_complete();
		}
		echo json_encode($response);
	}


	function DownloadAllScheduleForBranchEXCL()
	{
		$this->load->library('excel');

		$month = $this->input->get('month');
		$year = $this->input->get('year');
		$branch_id = $this->input->get('branch_id');
		//$temp_id=$this->input->get('temp_id');
		$company_id = $this->session->userdata('company_id');
		//getAllTemplates $company_id
		$branchNameSelect = "";
		if (!is_null($branch_id)) {
			$branchNameSelect = ",(select name from branch_master where id=" . $branch_id . ') as branch_name';
		}
		$getTemplates = $this->Master_Model->_rawQuery("select id,template_name" . $branchNameSelect . " from handson_template_master where status=1 AND  company_id=" . $company_id);

		$sheetCount = 0;
		$branchName = "";
		if ($getTemplates->totalCount > 0) {
			$resulObject = $getTemplates->data;

			if (!is_null($branch_id)) {
				$branchName = $resulObject[0]->branch_name;
			}
			$k = 0;

			$objPHPExcel = new PHPExcel();
			$objPHPExcel->setActiveSheetIndex();
//			$objPHPExcel->removeSheetByIndex(0);

			//$objWorkSheet->getSheetByName('Worksheet')
			foreach ($resulObject as $item) {
				$temp_id = $item->id;
				$template_name = $item->template_name;
				//array of column include value or not
				$allColumns = array();
				$allColumnsName = array();
				$header = array();
				//get template view
				$templateqr = $this->Master_Model->_rawQuery("select column_name from handson_template_column_master where column_value='column_1' AND  template_id=" . $temp_id);
				if ($templateqr->totalCount > 0) {
					$resDatatemp = $templateqr->data;
					$header[] = $resDatatemp[0]->column_name;
				}
				$branchWhere1 = "";
				if (is_null($branch_id)) {
					$branchWhere1 = "inlcude_branch_sum=1 and ";
				}
				$yeasCol = $this->Master_Model->_rawQuery('select column_value,column_name from handson_template_column_master where ' . $branchWhere1 . '  value_type!=2 and template_id=' . $temp_id);
				if ($yeasCol->totalCount > 0) {
					$resData = $yeasCol->data;
					foreach ($resData as $r1) {
						$allColumns[] = $r1->column_value;
						$header[] = $r1->column_name;
					}
				}

				$alldataArray = array();
				$branchWhere = "";
				if (!is_null($branch_id)) {
					$branchWhere = "and branch_id=" . $branch_id;
				}
				foreach ($allColumns as $row) {

					$quer = $this->Master_Model->_rawQuery("select sum(" . $row . ") as sumColumn,column_1 from handson_transaction_table where company_id=" . $company_id . " and template_id=" . $temp_id . " and year=" . $year . " and month=" . $month . " " . $branchWhere . "  Group by column_1 order by id asc");
					//echo $this->db->last_query();
					if ($quer->totalCount > 0) {
						$array = array();
						$data = $quer->data;
						foreach ($data as $row1) {
							$array[$row1->column_1] = $row1->sumColumn;
						}
						array_push($alldataArray, $array);
					}
				}

				$objWorkSheet = $objPHPExcel->createSheet($k);
				$objWorkSheet->setTitle($template_name);
				$i = 1;
				$char = 'A';
				foreach ($header as $key => $h) {
					$objWorkSheet->SetCellValue($char . $i, $h);
					$char++;
				}

				$getTransactiondata = $this->Master_Model->_rawQuery("select column_1 from handson_transaction_table where company_id=" . $company_id . " and template_id=" . $temp_id . " and year=" . $year . " and month=" . $month . " " . $branchWhere . " Group by column_1 order by id asc");

				if ($getTransactiondata->totalCount > 0) {
					$resultTrans = $getTransactiondata->totalCount;
					$char = 'A';
					$j = 2;
					foreach ($getTransactiondata->data as $r) {
						$objWorkSheet->SetCellValue($char . $j, $r->column_1);
						$j++;
					}
				}
				if (count($alldataArray) > 0) {
					$c = 'B';
					foreach ($alldataArray as $value) {
						$m = 2;
						foreach ($value as $key => $d) {
							if($d < 0){
								$d= "(".abs($d).")";
							}
							$objWorkSheet->SetCellValue($c . $m, $d);


							$m++;
						}
						$c++;
					}
				}
				$sheetCount++;
			}

		}
		$objPHPExcel->removeSheetByIndex($sheetCount);
		ob_end_clean();

		$filename = "All_Schedule_Of_Transaction" . $branchName . date("Y-m-d") . ".xls";
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

	function DownloadAllScheduleForBranch()
	{
		//	$this->load->library('excel');

		$month = $this->input->get('month');
		$year = $this->input->get('year');
		$branch_id = $this->input->get('branch_id');
		$number_conversion = $this->input->get('valuesIn');
		$divide=1;
		if (!is_null($number_conversion)) {
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
		}
		//$temp_id=$this->input->get('temp_id');
		$company_id = $this->session->userdata('company_id');
		//getAllTemplates $company_id
		$branchNameSelect = "";
		if (!is_null($branch_id)) {
			$branchNameSelect = ",(select name from branch_master where id=" . $branch_id . ') as branch_name';
		}
		$getTemplates = $this->Master_Model->_rawQuery("select id,template_name" . $branchNameSelect . " from handson_template_master where status=1 AND  company_id=" . $company_id);

		$sheetCount = 0;
		$branchName = "";
		if ($getTemplates->totalCount > 0) {
			$resulObject = $getTemplates->data;

			if (!is_null($branch_id)) {
				$branchName = $resulObject[0]->branch_name;
			}
			$k = 0;
			$html = '';
			$html .= '<style>
			.gutter
  {
  width: 10px;
  } 
  .table,th,td{
  	border:1px solid grey;
  	border-collapse: collapse;
  }
  th{
  background-color: lightgrey;
  }
  </style>
  ';
			foreach ($resulObject as $item) {

				$temp_id = $item->id;

				//array of column include value or not
				$allColumns = array();
				$allColumnsName = array();
				$header = array();
				//get template view
				$templateqr = $this->Master_Model->_rawQuery("select column_name from handson_template_column_master where column_value='column_1' AND  template_id=" . $temp_id);
				if ($templateqr->totalCount > 0) {
					$resDatatemp = $templateqr->data;
					$header[] = $resDatatemp[0]->column_name;
				}
				$branchWhere1 = "";
				if (is_null($branch_id)) {
					$branchWhere1 = "inlcude_branch_sum=1 and ";
				}
				$yeasCol = $this->Master_Model->_rawQuery('select column_value,column_name from handson_template_column_master where ' . $branchWhere1 . '  value_type!=2 and template_id=' . $temp_id);

				if ($yeasCol->totalCount > 0) {
					$resData = $yeasCol->data;
					foreach ($resData as $r1) {
						$allColumns[] = $r1->column_value;
						$header[] = $r1->column_name;
					}
				}

				$alldataArray = array();
				$branchWhere = "";
				if (!is_null($branch_id)) {
					$branchWhere = "and branch_id=" . $branch_id;
				}

				foreach ($allColumns as $row) {
					$quer = $this->Master_Model->_rawQuery("select sum(" . $row . ") as sumColumn,column_1 from handson_transaction_table where company_id=" . $company_id . " and template_id=" . $temp_id . " and year=" . $year . " and month=" . $month . " " . $branchWhere . "  Group by column_1 order by id asc");


					if ($quer->totalCount > 0) {
						$array = array();
						$data = $quer->data;
						foreach ($data as $row1) {
							$array[$row1->column_1] = $row1->sumColumn;
						}
						array_push($alldataArray, $array);
					}
				}



				$i = 1;
				$char = 'A';

				if (count($alldataArray) > 0) {
					$template_name = $item->template_name;
					$html .= '<h4>' . $template_name . '</h4>';
					$html .= '<table class="table" style=""><thead><tr>';
					foreach ($header as $key => $h) {

						$html .= '<th  style="font-size: 12px;width: 10%!important;">' . $h . '</th>';
						//$objWorkSheet->SetCellValue($char . $i, $h);
						$char++;
					}
					$html .= '</tr></thead>';
					$html .= '<tbody>';
					$finalArray = array();
					foreach ($alldataArray as $value) {

						foreach ($value as $key => $d) {
							$finalArray[$key][] = $d;


						}
					}


					foreach ($finalArray as $key1 => $rowR) {
						$html .= '<tr>';
						$html .= '<td style="font-size: 11px;width: 10%">' . $key1 . '</td>';
						foreach ($rowR as $r1) {
							if($r1 < 0){
								$r1= "(".$r1.")";
							}
							$html .= '<td style="font-size: 11px;text-align:right;width: 10%">' .round($r1, 2)/$divide  . '</td>';
						}
						$html .= '</tr>';
					}
					$html .= '</tbody>';
				}


				$html .= '</table>';
			}

			$dompdf = new DOMPDF();
			$dompdf->loadhtml($html);
			$dompdf->render();
			$customPaper = array(1000, 1000, 1000, 1000);
			//$dompdf->setPaper($customPaper);
			$dompdf->setPaper('legal', 'landscape');


//$output = $dompdf->output();
			$file_to_save = 'uploads/All_Subsidiaries_Schedule.pdf';
//save the pdf file on the server
			file_put_contents($file_to_save, $dompdf->output());

//print the pdf file to the screen for saving
			header('Content-type: application/pdf');
			header('Content-Disposition: inline; filename="All_Subsidiaries_Schedule.pdf"');
			header('Content-Transfer-Encoding: binary');
			//header('Content-Length: ' . filesize($file_to_save));
			header('Accept-Ranges: bytes');
			readfile($file_to_save);

		};

	}

	public function getTableDatafromHashKey1()
	{
		$hashKey = $this->input->post('data');
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		$branch_id = $this->input->post('branch');
		$hashKey1 = str_replace('#', '', $hashKey);
		$hashKey1 = str_replace('@', '', $hashKey1);
		$hashKey1 = str_replace('(', '', $hashKey1);
		$hashKey1 = str_replace(')', '', $hashKey1);
		$hashKey1 = html_entity_decode($hashKey1);
		$hashKey1 = strtoupper($hashKey1);
		$arr = explode("_", $hashKey1);
		$arr[0]=ltrim($arr[0],"-");
		//$arr[0] = str_replace("-", "", $arr[0]);
		$htmlTable = '';
		if (count($arr) > 0) {
			$company_id = $this->session->userdata('company_id');
			$template_id = $this->input->post('template_id');
			$type = '';
			// $html = ob_get_clean();
			$where = array('id' => $template_id);
			$number_conversion = 0;
			$resultObject = $this->Master_Model->_select('report_maker_master', $where, "*", true);
			if ($resultObject->totalCount > 0) {
				$type = $resultObject->data->type;
			}
			if ($type == 2)//USD
			{
				$parentTable = 'main_account_setup_master_us';
				$parentColumn = 'parent_account_number_us';
			} else if ($type == 3)//IRFS
			{
				$parentTable = 'main_account_setup_master_ifrs';
				$parentColumn = 'parent_account_number_ifrs';
			} else  //IND
			{
				$parentTable = 'main_account_setup_master';
				$parentColumn = 'parent_account_number';
			}
			if ($arr[0] == 'GR' || $arr[0] == 'PGR' || $arr[0] == 'PPGR') {
				$str = substr($arr[0], 0, 2);
				$value = $arr[2];
				$mainGLNumber = array();
				$qr = $this->Master_Model->_rawQuery("select main_gl_number from " . $parentTable . " where group_id='" . $value . "' and company_id=" . $company_id);
				if ($qr->totalCount > 0) {
					$result = $qr->data;
					foreach ($result as $row) {
						$mainGLNumber[] = "'" . $row->main_gl_number . "'";
					}
				}
				$glNumbers = implode(",", $mainGLNumber);

				$resultObject = $this->Master_Model->_rawQuery("select gl_ac,debit,credit,total,detail,opening_balance,(select " . $parentColumn . " from branch_account_setup b where b.account_number=u.gl_ac and b.branch_id=u.branch_id and b.company_id=u.company_id) as parent_gl from upload_financial_data u where year=" . $year . " AND quarter=" . $month . " AND company_id=" . $company_id . " AND branch_id=" . $branch_id . " AND gl_ac in(select account_number from branch_account_setup where " . $parentColumn . " in (" . $glNumbers . ") and branch_id=" . $branch_id . ")");
				if ($resultObject->totalCount > 0) {
					$result = $resultObject->data;
					$htmlTable = $this->getTable($result);
				} else {
					$htmlTable = "";
				}
			} elseif ($arr[0] == 'GL' || $arr[0] == 'PGL' || $arr[0] == 'PPGL') {
				$str = substr($arr[0], 0, 2);
				$resultObject = $this->Master_Model->_rawQuery("select gl_ac,debit,credit,total,detail,opening_balance,(select " . $parentColumn . " from branch_account_setup b where b.account_number=u.gl_ac and b.branch_id=u.branch_id and b.company_id=u.company_id) as parent_gl from upload_financial_data u where year=" . $year . " AND quarter=" . $month . " AND company_id=" . $company_id . " AND branch_id=" . $branch_id . " AND gl_ac in(select account_number from branch_account_setup where " . $parentColumn . "='" . $arr[2] . "' and branch_id=" . $branch_id . ")");
				if ($resultObject->totalCount > 0) {
					$result = $resultObject->data;
					$htmlTable = $this->getTable($result);
				} else {
					$htmlTable = "";
				}
			} elseif ($arr[0] == 'T2' || $arr[0] == 'PT2' || $arr[0] == 'PPT2') {
				$value = $arr[2];
				$mainGLNumber = array();
				$qr = $this->Master_Model->_rawQuery("select main_gl_number from " . $parentTable . " where type2='" . $value . "'");
				if ($qr->totalCount > 0) {
					$result = $qr->data;
					foreach ($result as $row) {
						$mainGLNumber[] = "'" . $row->main_gl_number . "'";
					}
				}
				$glNumbers = implode(",", $mainGLNumber);

				$resultObject = $this->Master_Model->_rawQuery("select gl_ac,debit,credit,total,detail,opening_balance,(select " . $parentColumn . " from branch_account_setup b where b.account_number=u.gl_ac and b.branch_id=u.branch_id and b.company_id=u.company_id) as parent_gl from upload_financial_data u where year=" . $year . " AND quarter=" . $month . " AND company_id=" . $company_id . " AND branch_id=" . $branch_id . " AND gl_ac in(select account_number from branch_account_setup where " . $parentColumn . " in (" . $glNumbers . ") and branch_id=" . $branch_id . ")");

				if ($resultObject->totalCount > 0) {
					$result = $resultObject->data;
					$htmlTable = $this->getTable($result);
				} else {
					$htmlTable = "";
				}
			} else {
				if ($arr[0] == 'EQ' || $arr[0] == 'PEQ' || $arr[0] == 'PPEQ') {
					$type = 'EQUITY AND LIABILITIES';
				} else if ($arr[0] == 'AS' || $arr[0] == 'PAS' || $arr[0] == 'PPAS') {
					$type = 'ASSETS';
				} else if ($arr[0] == 'EX' || $arr[0] == 'PEX' || $arr[0] == 'PPEX') {
					$type = 'EXPENSES';
				} else {
					$type = 'REVENUE';
				}
				$value = $arr[2];
				$mainGLNumber = array();
				$qr = $this->Master_Model->_rawQuery("select main_gl_number from " . $parentTable . " where type1='" . $type . "'");
				if ($qr->totalCount > 0) {
					$result = $qr->data;
					foreach ($result as $row) {
						$mainGLNumber[] = "'" . $row->main_gl_number . "'";
					}
				}
				$glNumbers = implode(",", $mainGLNumber);
				$resultObject = $this->Master_Model->_rawQuery("select gl_ac,debit,credit,total,detail,opening_balance,(select " . $parentColumn . " from branch_account_setup b where b.account_number=u.gl_ac and b.branch_id=u.branch_id and b.company_id=u.company_id) as parent_gl from upload_financial_data u where year=" . $year . " AND quarter=" . $month . " AND company_id=" . $company_id . " AND branch_id=" . $branch_id . " AND gl_ac in(select account_number from branch_account_setup where " . $parentColumn . " in (" . $glNumbers . ") and branch_id=" . $branch_id . ")");

				if ($resultObject->totalCount > 0) {
					$result = $resultObject->data;
					$htmlTable = $this->getTable($result);
				} else {
					$htmlTable = "";
				}
			}
		}
		if ($htmlTable == "") {
			$htmlTable = "No Data Found";
		}

		$response['status'] = '200';
		$response['body'] = $htmlTable;
		echo json_encode($response);
	}

	public function getTableDatafromHashKey()
	{
		$reportScheduleID = $this->input->post('reportScheduleID'); // 1=template 2=schedule
		$is_report_Schedule = $this->input->post('is_report_Schedule');
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		$branch_id = $this->input->post('branch');
		if ($reportScheduleID == 1) { //template

		} else { //schedule

		}
	}

	function getTable($result)
	{
		if (count($result) > 0) {
			$a_opening_bal = array();
			$a_debit = array();
			$a_credit = array();
			$a_total = array();
			$html = '
			<table class="table table-bordered ">
			<thead style="font-size: 11px;">
			<tr>
			<th>Gl Number</th>
			<th>Detail</th>
			<th>Parent Gl Account Number</th>
			<th>Opening Balance</th>
			<th>Debit</th>
			<th>Credit</th>
			<th>Total</th>
			</tr>
			</thead>
			<tbody>
			';
			foreach ($result as $row) {
				$a_opening_bal[] = $row->opening_balance;
				$a_debit[] = $row->debit;
				$a_credit[] = $row->credit;
				$a_total[] = $row->total;
				$html .= "<tr style='font-size: 11px;'>
						<td>" . $row->gl_ac . "</td>
						<td>" . $row->detail . "</td>
						<td>" . $row->parent_gl . "</td>
						<td>" . number_format($row->opening_balance) . "</td>
						<td>" . number_format($row->debit) . "</td>
						<td>" . number_format($row->credit) . "</td>
						<td>" . number_format($row->total) . "</td>
						</tr>";
			}
			$html .= "<tr>
<td style='color: black;font-weight: bold'>Total</td>
<td></td>
<td></td>
<td style='color: black;font-weight: bold'>" . number_format(array_sum($a_opening_bal)) . "</td>
<td style='color: black;font-weight: bold'> " . number_format(array_sum($a_debit)) . "</td>
<td style='color: black;font-weight: bold'>" . number_format(array_sum($a_credit)) . "</td>
<td style='color: black;font-weight: bold'>" . number_format(array_sum($a_total)) . "</td>
</tr>";
			$html .= "</tbody></table>";
		} else {
			$html = '';
		}
		return $html;
	}

	function getCurrencyData()
	{
		if (!is_null($this->input->post("temp_id"))) {
			$temp_id = $this->input->post("temp_id");
			$branch_id = $this->input->post("branch_id");
			$year = $this->input->post("year");
			$month = $this->input->post("month");
			$user_type = $this->session->user_session->user_type;
			$user_id = $this->session->user_session->user_id;
			$company_id = $this->session->user_session->company_id;
			// $columnObject = $this->TemplateToolModel->_select('handson_template_column_master',array('template_id'=>$temp_id),'*',false);
			$columnObject = $this->TemplateToolModel->_rawQuery('select *
from handson_template_column_master hm where template_id="' . $temp_id . '" order by sequence asc');
			$columnHeaders = array('id', 'created_by');
			$response['is_prefill'] = 0;
			$columnTypes = array();
			$hideColumns = array();
			$columnData = array();
			$object1 = new stdClass();
			$object1->type = 'text';
			$rowsCol = "";
			$readonlyArray = array();
			$columnSummary = array();
			$hideColumns = array(0, 1);
			array_push($columnTypes, $object1, $object1);
			//get Average Rate
			$rate = null;
			$closingrate = null;
			$queryAvg = $this->Master_Model->_rawQuery("select rate,closing_rate from currency_conversion_master where quarter=" . $month . " AND year=" . $year . " AND company_id=" . $company_id . " AND currency=(select currency from branch_master where id=" . $branch_id . ")");
//			print_r($queryAvg);exit();
			if ($queryAvg->totalCount > 0) {
				$res = $queryAvg->data;
				$rate = $res[0]->rate;
				$closingrate = $res[0]->closing_rate;
			} else {
				$rate = null;
			}

			if ($columnObject->totalCount > 0) {
				foreach ($columnObject->data as $key => $value) {
					array_push($columnHeaders, $value->column_name);

					$object = new stdClass();
					$object->type = $value->column_type;

					if ($value->column_type == 'dropdown') {
						if ($value->option_data != '') {
							$object->source = explode(',', $value->option_data);
						}
					}
					if ($value->column_value == "column_1") {
						$object->readOnly = true;
					}
					array_push($columnTypes, $object);
					array_push($columnData, $value->column_value);
				}


				$rowsObject = $this->TemplateToolModel->_select('handson_currency_rate_table hm', array('template_id' => $temp_id, 'company_id' => $company_id, 'branch_id' => $branch_id, 'year' => $year, 'month' => $month, 'status' => 1),
					'*', false);
				if ($rowsObject->totalCount > 0) {
					$rowsCol = array();
					$r = 0;
					foreach ($rowsObject->data as $rkey => $rvalue) {
						$data = array($rvalue->id, $rvalue->created_by);

						if (trim($rvalue->created_by) != trim($user_id)) {
							array_push($readonlyArray, $r);
						}
						$a = 2;
						foreach ($columnData as $ckey => $cvalue) {
							array_push($data, $rvalue->$cvalue);
							$a++;
						}
						array_push($rowsCol, $data);
						$r++;
					}
					$response['is_prefill'] = 0;
				} else {
					$currencyMapp=array();
					$currencyRateMapp=$this->TemplateToolModel->_select('handson_currency_rate_account_table',array('template_id' => $temp_id, 'status' => 1,'company_id'=>$company_id), '*', false);
					if($currencyRateMapp->totalCount>0)
					{
						foreach ($currencyRateMapp->data as $currrow)
						{
							for($i=2;$i<=15;$i++){
								$colVal1="column_".$i;
								$currencyMapp[$colVal1][]=$currrow->$colVal1;
							}
						}
					}
//					print_r($currencyMapp);exit();

					$rowsObject1 = $this->TemplateToolModel->_select('handson_prefill_table', array('template_id' => $temp_id, 'status' => 1), '*', false);
					if ($rowsObject1->totalCount > 0) {
						$rowsCol = array();
						$r = 0;
						foreach ($rowsObject1->data as $rkey => $rvalue) {
							$data = array('', '');
							if (trim($rvalue->created_by) != trim($user_id) || $rvalue->value_type == 'Calculated') {
								array_push($readonlyArray, $r);
							}
							foreach ($columnData as $ckey => $cvalue) {
								if ($cvalue == 'column_1' && $rvalue->$cvalue == "") {
									break;
								} else {
									if ($cvalue == 'column_1') {
										array_push($data, $rvalue->$cvalue);
									} else {
										if(count($currencyMapp)>0)
										{
											if(array_key_exists($cvalue,$currencyMapp)){
												if(array_key_exists($rkey,$currencyMapp[$cvalue]))
												{
													if($currencyMapp[$cvalue][$rkey]=="1-closing_rate")
													{
														array_push($data, $closingrate);
													}
													else if($currencyMapp[$cvalue][$rkey]=="2-average_rate")
													{
										array_push($data, $rate);
									}
													else
													{
														array_push($data, null);
													}
												}
												else{
													array_push($data, null);
												}
											}
											else{
												array_push($data, null);
											}
										}
										else{
											array_push($data, null);
										}
									}
								}
							}
							array_push($rowsCol, $data);
							$r++;
						}
					} else {
						$data = array('', '');
						$rowsCol = array();
						foreach ($columnData as $ckey => $cvalue) {
							array_push($data, '');
						}
						array_push($rowsCol, $data);
					}
					if ($rate == null) {
						$response['is_prefill'] = 0;
					} else {
						$response['is_prefill'] = 1;
					}

				}
			}
			// print_r($rowsCol);exit();
			$response['status'] = 200;
			$response['columnHeaders'] = $columnHeaders;
			$response['rate'] = $rate;
			$response['columnTypes'] = $columnTypes;
			$response['columnSummary'] = $columnSummary;
			$response['hideArra'] = $hideColumns;
			$response['columnRows'] = $rowsCol;
			$response['readonlyArray'] = $readonlyArray;
		} else {
			$response['status'] = 201;
			$response['body'] = 'Required Parameter Missing';
		}
		echo json_encode($response);
	}

	function getRupeesData()
	{
		if (!is_null($this->input->post("temp_id"))) {
			$temp_id = $this->input->post("temp_id");
			$branch_id = $this->input->post("branch_id");
			$year = $this->input->post("year");
			$month = $this->input->post("month");
			$number_conversion = $this->input->post("valuesIn");
			$user_type = $this->session->user_session->user_type;
			$user_id = $this->session->user_session->user_id;
			$company_id = $this->session->user_session->company_id;
			// $columnObject = $this->TemplateToolModel->_select('handson_template_column_master',array('template_id'=>$temp_id),'*',false);
			$columnObject = $this->TemplateToolModel->_rawQuery('select *,(select template_name from handson_template_master where id=template_id) as template_name
from handson_template_column_master hm where template_id="' . $temp_id . '" order by sequence asc');
//			print_r($columnObject);exit();
			$columnHeaders = array('id', 'created_by');
			$columnTypes = array();
			$hideColumns = array();
			$columnData = array();
			$object1 = new stdClass();
			$object1->type = 'text';
			$rowsCol = "";
			$readonlyArray = array();
			$columnSummary = array();
			$hideColumns = array(0, 1);
			$formulaMaker=array();

			$divide = 1;
			if (!is_null($number_conversion)) {
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
			}
			array_push($columnTypes, $object1, $object1);
			if ($columnObject->totalCount > 0) {
				$response['template_name'] = $columnObject->data[0]->template_name;
				foreach ($columnObject->data as $key => $value) {
					array_push($columnHeaders, $value->column_name);

					$object = new stdClass();
					$object->type = $value->column_type;
					/*if($value->column_type == "numeric"){

					}*/

					if ($value->column_type == 'dropdown') {
						if ($value->option_data != '') {
							$object->source = explode(',', $value->option_data);
						}
					}
					if ($value->column_value == "column_1") {
						$object->readOnly = true;
					}
					array_push($columnTypes, $object);
					array_push($columnData, $value->column_value);
					array_push($formulaMaker, $value->formula_maker_inr);
				}


				/*	$rowsObject = $this->TemplateToolModel->_select('handson_rupees_conversion_table hm', array('template_id' => $temp_id, 'company_id' => $company_id, 'branch_id' => $branch_id, 'year' => $year, 'month' => $month, 'status' => 1),
						'*', false,null,null,"id asc");*/
				/*$rowsObject = $this->TemplateToolModel->_select('handson_rupees_conversion_table hm', array('template_id' => $temp_id, 'company_id' => $company_id, 'branch_id' => $branch_id, 'year' => $year, 'month' => $month, 'status' => 1),
					'*,(select group_concat(hp.value_type,"#",hp.formula,"#",hp.formula_minus) from handson_prefill_table hp where hp.template_id=hm.template_id and hp.column_1=hm.column_1) as PrefillData', false,null,null,"id asc");*/
				if($branch_id==136) {
					$rowsObject = $this->TemplateToolModel->_select('handson_rupees_conversion_table hm', array('template_id' => $temp_id, 'company_id' => $company_id, 'year' => $year, 'month' => $month, 'status' => 1,'branch_id!='=>136),
						'id, template_id, user_id, column_1, sum(column_2) as column_2,sum(column_3) as column_3,sum(column_4) as column_4,sum(column_5) as column_5,sum(column_6) as column_6,
sum(column_7) as column_7,sum(column_8) as column_8,sum(column_9) as column_9,sum(column_10) as column_10,sum(column_11) as column_11,sum(column_12) as column_12,
sum(column_13) as column_13,sum(column_14) as column_14,sum(column_15) as column_15, created_by, created_on, modify_by, modify_at, user_type, status, branch_id, company_id, year, month, (select group_concat((case when hp.value_type is null then "" else hp.value_type end), "#", (case when hp.formula is null then "" else hp.formula end), "#",
 (case when hp.formula_minus is null then "" else hp.formula_minus end)) from handson_prefill_table hp 
 where hp.template_id=hm.template_id and hp.column_1=hm.column_1 and hp.formula_in_rupee="Yes") as PrefillData', false, 'column_1', null, "id asc");
				}
				else{
					$rowsObject = $this->TemplateToolModel->_select('handson_rupees_conversion_table hm', array('template_id' => $temp_id, 'company_id' => $company_id, 'branch_id' => $branch_id, 'year' => $year, 'month' => $month, 'status' => 1),
						'*,(select group_concat((case when hp.value_type is null then "" else hp.value_type end),"#",
					(case when hp.formula is null then "" else hp.formula end),"#",
					(case when hp.formula_minus is null then "" else hp.formula_minus end)) from handson_prefill_table hp where hp.template_id=hm.template_id and hp.column_1=hm.column_1 and hp.formula_in_rupee="Yes") as PrefillData', false, null, null, "id asc");
				}
				if ($rowsObject->totalCount > 0) {
					$rowsCol = array();
					$r = 0;
					foreach ($rowsObject->data as $rkey => $rvalue) {
						$data = array($rvalue->id, $rvalue->created_by);

						if (trim($rvalue->created_by) != trim($user_id)) {
							array_push($readonlyArray, $r);
						}
						$a = 2;
						/*foreach ($columnData as $ckey => $cvalue) {
							array_push($data, $rvalue->$cvalue);

							$a++;
						}*/
						$char = 'C';
						foreach ($columnData as $ckey => $cvalue) {

							$PrefillData = $rvalue->PrefillData;
							$colOBj = new stdClass();
							if ($a != 2) {

								if (!is_null($PrefillData) && $PrefillData!="") {

									$arr = explode("#", $PrefillData);
									$value_type = $arr[0];
									$formula = $arr[1];
									$formula_minus = $arr[2];
									if ($value_type == 'Calculated') {
										$formula = rtrim($formula, ",");
										$arr1 = explode(',', $formula);
										$a1 = array();
										foreach ($arr1 as $a2) {
											if ($a2 != "") {
												$a1[] = $char . $a2;

											}
										}
										$formula_minus = rtrim($formula_minus, ",");
										$arr2 = explode(',', $formula_minus);
										$a3 = array();
										foreach ($arr2 as $a21) {
											if ($a21 != "") {
												$a3[] = $char . $a21;

											}
										}
										/*$formulaplus=implode(",",$a1);
										$formulaminus=implode(",",$a3);
										$formulaExcel="=sum(".$formulaplus.")-sum(".$formulaminus.")";
										array_push($data, $formulaExcel);*/

										$text1 = "";
										$formulaExcel = "";
										if (count($a1)) {
											$formulaplus = implode(",", $a1);
											$text1 = "sum(" . $formulaplus . ")";

										}
										$text2 = "";
										if (count($a3) > 0) {
											$formulaminus = implode(",", $a3);
											$text2 = "sum(" . $formulaminus . ")";
										}

										if ($text1 == "" && $text2 == "") {
											$formulaExcel = "";
										} else if ($text1 != "" && $text2 == "") {
											$formulaExcel = "=round(" . $text1 . ",2)";
										} else if ($text1 == "" && $text2 != "") {
											$formulaExcel = "=round(" . $text2 . ",2)";
										} else {
											$formulaExcel = "=round(" . $text1 . "-" . $text2 . ",2)";
										}
										array_push($data, $formulaExcel);
										//$arr1=array_map('intval', explode(',', $formula));
										//$arrayNew = array();
										//$arrayNew = array_pop($sports);

										/*$colOBj->ranges = $arrayNew;
										$colOBj->destinationRow = $rkey;
										$colOBj->destinationColumn = $a;
										$colOBj->reversedRowCoords = false;
										$colOBj->type = 'sum';
										$colOBj->forceNumeric = true;
										array_push($columnSummary, $colOBj);*/
									} else {
										if (is_numeric($rvalue->$cvalue)) {
											$rvalue->$cvalue = round($rvalue->$cvalue / $divide, 2);
										}
										if($formulaMaker[$ckey]!="" && $formulaMaker[$ckey]!=null && $formulaMaker[$ckey]!='null')
										{

											$formulaDta=$formulaMaker[$ckey];
											$formulaDta=str_replace('#',$r+1,$formulaDta);
											$rvalue->$cvalue="=".$formulaDta."";
										}
										array_push($data, $rvalue->$cvalue);
									}

								} else {
									if (is_numeric($rvalue->$cvalue)) {
										$rvalue->$cvalue = round($rvalue->$cvalue / $divide, 2);
									}
									if($formulaMaker[$ckey]!="" && $formulaMaker[$ckey]!=null && $formulaMaker[$ckey]!='null')
									{

										$formulaDta=$formulaMaker[$ckey];
										$formulaDta=str_replace('#',$r+1,$formulaDta);
										$rvalue->$cvalue="=".$formulaDta."";
									}
									array_push($data, $rvalue->$cvalue);
								}
							} else {
								if (is_numeric($rvalue->$cvalue)) {
									$rvalue->$cvalue = round($rvalue->$cvalue / $divide, 2);
								}
								array_push($data, $rvalue->$cvalue);
							}

							$a++;
							$char++;
						}

						array_push($rowsCol, $data);
						$r++;
					}

				} else {
					$rowsObject1 = $this->TemplateToolModel->_select('handson_prefill_table', array('template_id' => $temp_id, 'status' => 1), '*', false);
					if ($rowsObject1->totalCount > 0) {
						$rowsCol = array();
						$r = 0;
						foreach ($rowsObject1->data as $rkey => $rvalue) {
							$data = array('', '');
							if ($rvalue->value_type == 'Calculated') {

							}
							if (trim($rvalue->created_by) != trim($user_id) || $rvalue->value_type == 'Calculated') {
								array_push($readonlyArray, $r);
							}
							foreach ($columnData as $ckey => $cvalue) {
								if (is_numeric($rvalue->$cvalue)) {
									$rvalue->$cvalue = round($rvalue->$cvalue / $divide, 2);
								}
								array_push($data, $rvalue->$cvalue);
							}
							array_push($rowsCol, $data);
							$r++;
						}
					} else {
						$data = array('', '');
						$rowsCol = array();
						foreach ($columnData as $ckey => $cvalue) {
							array_push($data, '');
						}
						array_push($rowsCol, $data);
					}

				}
			}

			$response['status'] = 200;
			$response['columnHeaders'] = $columnHeaders;
			$response['columnTypes'] = $columnTypes;
			$response['columnSummary'] = $columnSummary;
			$response['hideArra'] = $hideColumns;
			$response['columnRows'] = $rowsCol;
			$response['readonlyArray'] = $readonlyArray;
		} else {
			$response['status'] = 201;
			$response['body'] = 'Required Parameter Missing';
		}
		echo json_encode($response);
	}

	public function getGlAccountMappingData()
	{
		if (!is_null($this->input->post("temp_id"))) {
			$temp_id = $this->input->post("temp_id");
			$branch_id = $this->input->post("branch_id");
			$year = $this->input->post("year");
			$month = $this->input->post("month");
			$user_type = $this->session->user_session->user_type;
			$user_id = $this->session->user_session->user_id;
			$company_id = $this->session->user_session->company_id;
			$columnObject = $this->TemplateToolModel->_rawQuery('select * from handson_template_column_master hm where template_id="' . $temp_id . '" order by sequence asc');
			$columnHeaders = array('id', 'created_by');
			$columnTypes = array();
			$hideColumns = array();
			$columnData = array();
			$object1 = new stdClass();
			$object1->type = 'text';
			$rowsCol = "";
			$readonlyArray = array();
			$columnSummary = array();
			$hideColumns = array(0, 1);
			array_push($columnTypes, $object1, $object1);
			$source = array();
			$prefillValueType = array();
//			$prefillColumnObject = $this->TemplateToolModel->_rawQuery('select * from handson_prefill_table hm where template_id="' . $temp_id . '" order by id asc');
//			if($prefillColumnObject->totalCount>0)
//			{
//				foreach ($prefillColumnObject->data as $pkey=> $prow)
//				{
//					if($prow->value_type=="Calculated")
//					{
//						array_push($prefillValueType,$pkey);
//					}
//				}
//			}
			$GlAccountsObject = $this->TemplateToolModel->_select('main_account_setup_master', array('company_id' => $company_id, 'status' => 1), "*", false);
			if ($GlAccountsObject->totalCount > 0) {
				foreach ($GlAccountsObject->data as $oprow) {
					array_push($source, $oprow->main_gl_number . "-" . $oprow->name);
				}
			}
			if ($columnObject->totalCount > 0) {
				foreach ($columnObject->data as $key => $value) {
					array_push($columnHeaders, $value->column_name);
					$object = new stdClass();
					if ($value->value_type == 1) {
						if ($value->column_value != "column_1") {
							$object->type = 'dropdown';
							$object->source = $source;
						} else {
							$object->type = $value->column_type;
							$object->readOnly = true;
						}
					} else {
						$object->type = $value->column_type;
					}

					array_push($columnTypes, $object);
					array_push($columnData, $value->column_value);
				}


				$rowsObject = $this->TemplateToolModel->_select('handson_gl_prefill_table hm', array('template_id' => $temp_id, 'company_id' => $company_id, 'status' => 1),
					'*', false);
				if ($rowsObject->totalCount > 0) {
					$rowsCol = array();
					$r = 0;
					foreach ($rowsObject->data as $rkey => $rvalue) {
						$data = array($rvalue->id, $rvalue->created_by);

						if (trim($rvalue->created_by) != trim($user_id)) {
							array_push($readonlyArray, $r);
						}
						$a = 2;
						foreach ($columnData as $ckey => $cvalue) {
							array_push($data, $rvalue->$cvalue);
							$a++;
						}

						array_push($rowsCol, $data);
						$r++;
					}
				} else {
					$rowsObject1 = $this->TemplateToolModel->_select('handson_prefill_table', array('template_id' => $temp_id, 'status' => 1), '*', false);
					if ($rowsObject1->totalCount > 0) {
						$rowsCol = array();
						$r = 0;
						foreach ($rowsObject1->data as $rkey => $rvalue) {
							$data = array('', '');
							if ($rvalue->value_type == 'Calculated') {

							}
							if (trim($rvalue->created_by) != trim($user_id) || $rvalue->value_type == 'Calculated') {
								array_push($readonlyArray, $r);
							}
							foreach ($columnData as $ckey => $cvalue) {
								array_push($data, $rvalue->$cvalue);
							}
							array_push($rowsCol, $data);
							$r++;
						}
					} else {
						$data = array('', '');
						$rowsCol = array();
						foreach ($columnData as $ckey => $cvalue) {
							array_push($data, '');
						}
						array_push($rowsCol, $data);
					}

				}
			}
			$response['status'] = 200;
			$response['columnHeaders'] = $columnHeaders;
			$response['columnTypes'] = $columnTypes;
			$response['columnSummary'] = $columnSummary;
			$response['hideArra'] = $hideColumns;
			$response['columnRows'] = $rowsCol;
			$response['readonlyArray'] = $readonlyArray;
			$response['prefillValueType'] = $prefillValueType;
		} else {
			$response['status'] = 201;
			$response['body'] = 'Required Parameter Missing';
		}
		echo json_encode($response);
	}

	public function saveGlMappData()
	{
		if (!is_null($this->input->post('arrData')) && $this->input->post('branch_id') != "") {
			$temp_id = $this->input->post('temp_id');
			$Data1 = $this->input->post('arrData');
			$branch_id = $this->input->post('branch_id');
			$year = $this->input->post('year');
			$month = $this->input->post('month');
			$arrData = json_decode($Data1);
//			 print_r($arrData);exit();
			$user_type = $this->session->user_session->user_type;
			$user_id = $this->session->user_session->user_id;
			$company_id = $this->session->user_session->company_id;
			$TransactionData = array();
			$CurrencyData = array();
			//get Data from transaction Table


//			$columnObject = $this->TemplateToolModel->_rawQuery('select * from handson_template_column_master hm where template_id="' . $temp_id . '" order by sequence asc');
//			print_r($TransactionData);exit();
			$insertData = array();
			if (!empty($arrData)) {
				foreach ($arrData as $key1 => $row) {
					if ($row[2] != "" && $row[2] != "null" && $row[2] != null) {

						$data = array(
							"template_id" => $temp_id,
							"company_id" => $company_id,
							"user_id" => $user_id,
							"user_type" => $user_type,
							"created_by" => $user_id,
							"created_on" => date('Y-m-d H:i:s')
						);
						$m = 1;
						for ($i = 2; $i < 17; $i++) {
							$columnName = 'column_' . $m;
							if (isset($row[$i])) {
								$data[$columnName] = $row[$i];
							} else {
								$data[$columnName] = '';
							}
							$m++;
						}

						array_push($insertData, $data);
					}
				}
			}
//			print_r($insertData);exit();
			$where = array(
				"template_id" => $temp_id,
				"company_id" => $company_id,
			);
			$status = FALSE;
			try {
				$this->db->trans_start();
				if (!empty($insertData)) {
					$delete = $this->db->delete('handson_gl_prefill_table', $where);
					$insert_batch = $this->db->insert_batch("handson_gl_prefill_table", $insertData);
				}
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					$status = FALSE;
				} else {
					$this->db->trans_commit();
					$status = TRUE;
				}
				$this->db->trans_complete();
				$last_query = $this->db->last_query();
			} catch (Exception $ex) {
				$status = FALSE;
				$this->db->trans_rollback();
			}
			if ($status == true) {
				$response['status'] = 200;
				$response['body'] = "Data uploaded Successfully";
			} else {
				$response['status'] = 201;
				$response['body'] = "Failed To uplaod";
			}
		} else {
			$response['status'] = 201;
			$response['body'] = "Failed To uplaod";
		}
		echo json_encode($response);
	}

	function DownloadAllRupeesScheduleForBranchEXCl()
	{
		$this->load->library('excel');

		$month = $this->input->get('month');
		$year = $this->input->get('year');
		$branch_id = $this->input->get('branch_id');
		//$temp_id=$this->input->get('temp_id');
		$company_id = $this->session->userdata('company_id');
		//getAllTemplates $company_id
		$branchNameSelect = "";
		if (!is_null($branch_id)) {
			$branchNameSelect = ",(select name from branch_master where id=" . $branch_id . ') as branch_name';
		}
		$getTemplates = $this->Master_Model->_rawQuery("select id,template_name" . $branchNameSelect . " from handson_template_master where status=1 AND  company_id=" . $company_id);
		$sheetCount = 0;
		$branchName = "";
		if ($getTemplates->totalCount > 0) {
			$resulObject = $getTemplates->data;
			if (!is_null($branch_id)) {
				$branchName = $resulObject[0]->branch_name;
			}
			$k = 0;

			$objPHPExcel = new PHPExcel();
			$objPHPExcel->setActiveSheetIndex();
//			$objPHPExcel->removeSheetByIndex(0);

			//$objWorkSheet->getSheetByName('Worksheet')
			foreach ($resulObject as $item) {
				$temp_id = $item->id;
				$template_name = $item->template_name;
				//array of column include value or not
				$allColumns = array();
				$allColumnsName = array();
				$header = array();
				//get template view
				$templateqr = $this->Master_Model->_rawQuery("select column_name from handson_template_column_master where column_value='column_1' AND  template_id=" . $temp_id);
				if ($templateqr->totalCount > 0) {
					$resDatatemp = $templateqr->data;
					$header[] = $resDatatemp[0]->column_name;
				}
				$branchWhere1 = "";
				if (is_null($branch_id)) {
					$branchWhere1 = "inlcude_branch_sum=1 and ";
				}
				$yeasCol = $this->Master_Model->_rawQuery('select column_value,column_name from handson_template_column_master where ' . $branchWhere1 . '  value_type!=2 and template_id=' . $temp_id);
				if ($yeasCol->totalCount > 0) {
					$resData = $yeasCol->data;
					foreach ($resData as $r1) {
						$allColumns[] = $r1->column_value;
						$header[] = $r1->column_name;
					}

				}
				$alldataArray = array();
				$branchWhere = "";
				if (!is_null($branch_id)) {
					$branchWhere = "and branch_id=" . $branch_id;
				}

				foreach ($allColumns as $row) {
					$quer = $this->Master_Model->_rawQuery("select sum(" . $row . ") as sumColumn,column_1 from handson_rupees_conversion_table where company_id=" . $company_id . " and template_id=" . $temp_id . " and year=" . $year . " and month=" . $month . " " . $branchWhere . "  Group by column_1 order by id asc");
					/*if($temp_id == 60){
						echo $quer->last_query;
						exit;
					}*/
					if ($quer->totalCount > 0) {
						$array = array();
						$data = $quer->data;
						foreach ($data as $row1) {
							$array[$row1->column_1] = $row1->sumColumn;
						}
						array_push($alldataArray, $array);
					}
				}

				$objWorkSheet = $objPHPExcel->createSheet($k);
				$objWorkSheet->setTitle($template_name);
				$i = 1;
				$char = 'A';
				foreach ($header as $key => $h) {
					$objWorkSheet->SetCellValue($char . $i, $h);
					$char++;
				}

				$getTransactiondata = $this->Master_Model->_rawQuery("select column_1 from handson_rupees_conversion_table where company_id=" . $company_id . " and template_id=" . $temp_id . " and year=" . $year . " and month=" . $month . " " . $branchWhere . " Group by column_1 order by id asc");

				if ($getTransactiondata->totalCount > 0) {
					$resultTrans = $getTransactiondata->totalCount;
					$char = 'A';
					$j = 2;
					foreach ($getTransactiondata->data as $r) {
						$objWorkSheet->SetCellValue($char . $j, $r->column_1);
						$j++;
					}
				}
				if (count($alldataArray) > 0) {
					$c = 'B';
					foreach ($alldataArray as $value) {
						$m = 2;
						foreach ($value as $key => $d) {
							if($d < 0){
								$d= "(".abs($d).")";
							}
							$objWorkSheet->SetCellValue($c . $m, $d);


							$m++;
						}
						$c++;
					}
				}
				$sheetCount++;
			}

		}
		$objPHPExcel->removeSheetByIndex($sheetCount);
		ob_end_clean();

		$filename = "All_Schedule_Of_Rupees_Conversion" . $branchName . date("Y-m-d") . ".xls";
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
	function DownloadAllRupeesScheduleForBranch()
	{
		//	$this->load->library('excel');

		$month = $this->input->get('month');
		$year = $this->input->get('year');
		$branch_id = $this->input->get('branch_id');
		//$temp_id=$this->input->get('temp_id');
		$company_id = $this->session->userdata('company_id');
		//getAllTemplates $company_id
		$branchNameSelect = "";
		if (!is_null($branch_id)) {
			$branchNameSelect = ",(select name from branch_master where id=" . $branch_id . ') as branch_name';
		}
		$getTemplates = $this->Master_Model->_rawQuery("select id,template_name" . $branchNameSelect . " from handson_template_master where status=1 AND  company_id=" . $company_id);

		$sheetCount = 0;
		$branchName = "";
		if ($getTemplates->totalCount > 0) {
			$resulObject = $getTemplates->data;

			if (!is_null($branch_id)) {
				$branchName = $resulObject[0]->branch_name;
			}
			$k = 0;
			$html = '';
			$html .= '<style>
			.gutter
  {
  width: 10px;
  } 
  table, th, td {
  	border: 1px solid grey;
   border-collapse: collapse;
}
  th{
  background-color: lightgrey;
  }
  </style>
  ';
			foreach ($resulObject as $item) {

				$temp_id = $item->id;
				$template_name = $item->template_name;
				$html .= '<h4>' . $template_name . '</h4>';
				//array of column include value or not
				$allColumns = array();
				$allColumnsName = array();
				$header = array();
				//get template view
				$templateqr = $this->Master_Model->_rawQuery("select column_name from handson_template_column_master where column_value='column_1' AND  template_id=" . $temp_id);
				if ($templateqr->totalCount > 0) {
					$resDatatemp = $templateqr->data;
					$header[] = $resDatatemp[0]->column_name;
				}
				$branchWhere1 = "";
				if (is_null($branch_id)) {
					$branchWhere1 = "inlcude_branch_sum=1 and ";
				}
				$yeasCol = $this->Master_Model->_rawQuery('select column_value,column_name from handson_template_column_master where ' . $branchWhere1 . '  value_type!=2 and template_id=' . $temp_id);
				if ($yeasCol->totalCount > 0) {
					$resData = $yeasCol->data;
					foreach ($resData as $r1) {
						$allColumns[] = $r1->column_value;
						$header[] = $r1->column_name;
					}
				}

				$alldataArray = array();
				$branchWhere = "";
				if (!is_null($branch_id)) {
					$branchWhere = "and branch_id=" . $branch_id;
				}
				foreach ($allColumns as $row) {

					$quer = $this->Master_Model->_rawQuery("select sum(" . $row . ") as sumColumn,column_1 from handson_rupees_conversion_table where company_id=" . $company_id . " and template_id=" . $temp_id . " and year=" . $year . " and month=" . $month . " " . $branchWhere . "  Group by column_1 order by id asc");
					//echo $this->db->last_query();
					if ($quer->totalCount > 0) {
						$array = array();
						$data = $quer->data;
						foreach ($data as $row1) {
							$array[$row1->column_1] = $row1->sumColumn;
						}
						array_push($alldataArray, $array);
					}
				}


				$i = 1;
				$char = 'A';
				$html .= '<table class="table" border="1" style=""><thead><tr>';
				foreach ($header as $key => $h) {

					$html .= '<th  style="font-size: 12px;width: 10%!important;">' . $h . '</th>';
					//$objWorkSheet->SetCellValue($char . $i, $h);
					$char++;
				}
				$html .= '</tr></thead>';

				$getTransactiondata = $this->Master_Model->_rawQuery("select column_1 from handson_transaction_table where company_id=" . $company_id . " and template_id=" . $temp_id . " and year=" . $year . " and month=" . $month . " " . $branchWhere . " Group by column_1 order by id asc");

				if ($getTransactiondata->totalCount > 0) {
					$resultTrans = $getTransactiondata->totalCount;
					$char = 'A';
					$j = 2;

					foreach ($getTransactiondata->data as $r) {
						//$objWorkSheet->SetCellValue($char . $j, $r->column_1);

						$j++;
					}

				}


				if (count($alldataArray) > 0) {
					$html .= '<tbody>';
					$finalArray = array();
					foreach ($alldataArray as $value) {

						foreach ($value as $key => $d) {
							$finalArray[$key][] = $d;
						}
					}
					foreach ($finalArray as $key1 => $rowR) {
						$html .= '<tr>';
						$m1 = 0;
						$html .= '<td style="font-size: 11px;width: 10%">' . $key1 . '</td>';
						foreach ($rowR as $r1) {
							if ($m1 == 0) {

							} else {

							}
							$html .= '<td style="font-size: 11px;width: 10%;text-align: right;">' . round($r1,2) . '</td>';

							$m1++;
						}
						$html .= '</tr>';
					}
					$html .= '</tbody>';
				}

				$html .= '</table>';
				$sheetCount++;
			}
			/*echo $html;
				exit;*/
			//$html='Pooja';
			$dompdf = new DOMPDF();
			$dompdf->loadhtml($html);
			$dompdf->render();
			$customPaper = array(1000, 1000, 1000, 1000);
			//$dompdf->setPaper($customPaper);
			$dompdf->setPaper('legal', 'landscape');


//$output = $dompdf->output();
			$file_to_save = 'uploads/All_Subsidiaries_Schedule(Rupees Conversion).pdf';
//save the pdf file on the server
			file_put_contents($file_to_save, $dompdf->output());

//print the pdf file to the screen for saving
			header('Content-type: application/pdf');
			header('Content-Disposition: inline; filename="All_Subsidiaries_Schedule(Rupees Conversion).pdf"');
			header('Content-Transfer-Encoding: binary');
			//header('Content-Length: ' . filesize($file_to_save));
			header('Accept-Ranges: bytes');
			readfile($file_to_save);

		};

	}
	////subsidiary account mapping
	public function getSubsidiaryAccountMappingData()
	{
		if (!is_null($this->input->post("temp_id"))) {
			$temp_id = $this->input->post("temp_id");
			$month = $this->input->post("month");
			$year = $this->input->post("year");
//			print_r($month);exit();
			$user_type = $this->session->user_session->user_type;
			$user_id = $this->session->user_session->user_id;
			$company_id = $this->input->post("company_id");
			if(is_null($company_id))
			{
				$company_id = $this->session->user_session->company_id;
			}
			$columnObject = $this->TemplateToolModel->_rawQuery('select * from handson_template_column_master hm where template_id="' . $temp_id . '" order by sequence asc');

			$columnHeaders = array('id', 'created_by');
			$columnTypes = array();
			$hideColumns = array();
			$columnData = array();
			$object1 = new stdClass();
			$object1->type = 'text';
			$rowsCol = "";
			$readonlyArray = array();
			$columnSummary = array();
			$hideColumns = array(0, 1);
			array_push($columnTypes, $object1, $object1);
			$source = array();
			$prefillValueType = array();

			$GlAccountsObject = $this->TemplateToolModel->_select('main_schedule_account_setup_master', array('company_id' => $company_id, 'status' => 1), "*", false);
			$derivedGlAccountsObject = $this->TemplateToolModel->_select('derived_account_setup', array('company_id' => $company_id, 'status' => 1), "*", false);
			if ($GlAccountsObject->totalCount > 0) {
				foreach ($GlAccountsObject->data as $oprow) {
					array_push($source, $oprow->schedule_account . "-" . $oprow->name);
				}
			}
			if ($derivedGlAccountsObject->totalCount > 0) {
				foreach ($derivedGlAccountsObject->data as $oprow) {
					array_push($source, 'D_'.$oprow->derived_account_gl . "-" . $oprow->detail);
				}
			}
			if ($columnObject->totalCount > 0) {
				foreach ($columnObject->data as $key => $value) {
					array_push($columnHeaders, $value->column_name);
					$object = new stdClass();
					if ($value->value_type == 1) {
						if ($value->column_value != "column_1") {
							if(!is_null($this->input->post("company_id")))
							{
								$object->type = 'dropdown';
								$object->source = $source;
							}
							else{
								$object->type = 'text';
								$object->readOnly = true;
							}
						} else {
							$object->type = $value->column_type;
							$object->readOnly = true;
						}
					} else {
						$object->type = $value->column_type;
					}

					array_push($columnTypes, $object);
					array_push($columnData, $value->column_value);
				}


				$rowsObject = $this->TemplateToolModel->_select('handson_subsidiary_account_table hm', array('template_id' => $temp_id, 'company_id' => $company_id, 'status' => 1,'month'=>$month,'year'=>$year),
					'*', false);
				if ($rowsObject->totalCount > 0) {
					$rowsCol = array();
					$r = 0;
					foreach ($rowsObject->data as $rkey => $rvalue) {
						$data = array($rvalue->id, $rvalue->created_by);

						if (trim($rvalue->created_by) != trim($user_id)) {
							array_push($readonlyArray, $r);
						}
						$a = 2;
						foreach ($columnData as $ckey => $cvalue) {
							array_push($data, $rvalue->$cvalue);
							$a++;
						}

						array_push($rowsCol, $data);
						$r++;
					}
				} else {
					$rowsObject1 = $this->TemplateToolModel->_select('handson_prefill_table', array('template_id' => $temp_id, 'status' => 1), '*', false);
					if ($rowsObject1->totalCount > 0) {
						$rowsCol = array();
						$r = 0;
						foreach ($rowsObject1->data as $rkey => $rvalue) {
							$data = array('', '');
							if ($rvalue->value_type == 'Calculated') {

							}
							if (trim($rvalue->created_by) != trim($user_id) || $rvalue->value_type == 'Calculated') {
								array_push($readonlyArray, $r);
							}
							foreach ($columnData as $ckey => $cvalue) {
								array_push($data, $rvalue->$cvalue);
							}
							array_push($rowsCol, $data);
							$r++;
						}
					} else {
						$data = array('', '');
						$rowsCol = array();
						foreach ($columnData as $ckey => $cvalue) {
							array_push($data, '');
						}
						array_push($rowsCol, $data);
					}

				}
			}
			$response['status'] = 200;
			$response['columnHeaders'] = $columnHeaders;
			$response['columnTypes'] = $columnTypes;
			$response['columnSummary'] = $columnSummary;
			$response['hideArra'] = $hideColumns;
			$response['columnRows'] = $rowsCol;
			$response['readonlyArray'] = $readonlyArray;
			$response['prefillValueType'] = $prefillValueType;
		} else {
			$response['status'] = 201;
			$response['body'] = 'Required Parameter Missing';
		}
		echo json_encode($response);
	}
	public function saveSubMappData()
	{
		if (!is_null($this->input->post('arrData'))) {
			$temp_id = $this->input->post('temp_id');
			$Data1 = $this->input->post('arrData');
			$year = $this->input->post('year');
			$month = $this->input->post('month');
			$arrData = json_decode($Data1);
//			 print_r($arrData);exit();
			$user_type = $this->session->user_session->user_type;
			$user_id = $this->session->user_session->user_id;
			$company_id = $this->input->post("company_id");
			if(is_null($company_id))
			{
				$company_id = $this->session->user_session->company_id;
			}
			$TransactionData = array();
			$CurrencyData = array();
			//get Data from transaction Table


//			$columnObject = $this->TemplateToolModel->_rawQuery('select * from handson_template_column_master hm where template_id="' . $temp_id . '" order by sequence asc');
//			print_r($TransactionData);exit();
			$insertData = array();
			if (!empty($arrData)) {
				foreach ($arrData as $key1 => $row) {
					if ($row[2] != "" && $row[2] != "null" && $row[2] != null) {

						$data = array(
							"template_id" => $temp_id,
							"company_id" => $company_id,
							"user_id" => $user_id,
							"user_type" => $user_type,
							"created_by" => $user_id,
							"month" => $month,
							"year" => $year,
							"created_on" => date('Y-m-d H:i:s')
						);
						$m = 1;
						for ($i = 2; $i < 17; $i++) {
							$columnName = 'column_' . $m;
							if (isset($row[$i])) {
								$data[$columnName] = $row[$i];
							} else {
								$data[$columnName] = '';
							}
							$m++;
						}

						array_push($insertData, $data);
					}
				}
			}
//			print_r($insertData);exit();
			$where = array(
				"template_id" => $temp_id,
				"company_id" => $company_id,
				"year"=>$year,
				"month"=>$month
			);
			$status = FALSE;
			try {
				$this->db->trans_start();
				if (!empty($insertData)) {
					$delete = $this->db->delete('handson_subsidiary_account_table', $where);
					$insert_batch = $this->db->insert_batch("handson_subsidiary_account_table", $insertData);
				}
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					$status = FALSE;
				} else {
					$this->db->trans_commit();
					$status = TRUE;
				}
				$this->db->trans_complete();
				$last_query = $this->db->last_query();
			} catch (Exception $ex) {
				$status = FALSE;
				$this->db->trans_rollback();
			}
			if ($status == true) {
				$response['status'] = 200;
				$response['body'] = "Data uploaded Successfully";
			} else {
				$response['status'] = 201;
				$response['body'] = "Failed To uplaod";
			}
		} else {
			$response['status'] = 201;
			$response['body'] = "Failed To uplaod";
		}
		echo json_encode($response);
	}
	function getColumnTextData($month,$year,$branch_id,$schedule_account,$temp_id,$scheduleAccountWithName,$value_sign_in)
	{
		$search='#';
		$year1 = $year;
		$month1=$month;
		$value=array();
		$company_id = $this->session->userdata('company_id');
		if(preg_match("/{$search}/i", $scheduleAccountWithName)) {
			$splithash=explode('_',$scheduleAccountWithName);
			if(count($splithash)>1)
			{
				$previousData=$splithash[0];
				$scheduleAccount=$splithash[1];
				$previousData=str_replace('#', '', $previousData);
				$companyObject = $this->Master_Model->_select('branch_master', array('id' => $branch_id), array('start_with as start_month'), true);
				if ($companyObject->totalCount > 0) {
					if($companyObject->data->start_month <= $month & $companyObject->data->start_month != 1)
					{
						if('p'==strtolower($previousData))
						{
							$year1 = $year;
						}
						else if('pp'==strtolower($previousData))
						{
							$year1 = $year - 1;
						}
					}
					else{
						if('p'==strtolower($previousData))
						{
							$year1 = $year - 1;
						}
						else if('pp'==strtolower($previousData))
						{
							$year1 = $year - 2;
						}
					}
					if($companyObject->data->start_month!=1)
					{
						$month1=$companyObject->data->start_month-1;
					}
					else{
						if($companyObject->data->start_month==1)
						{
							$month1=12;
						}
					}
				}
				$schedule_account=$splithash[1];
			}
			$dataArray=array();
				$groupByTemplateIDs=array();
				$handsonSubresultObject = $this->Master_Model->_rawQuery('select * from handson_subsidiary_account_table where company_id="' . $company_id . '" and status=1 and year="'.$year1.'" and month="'.$month1.'"');
				if ($handsonSubresultObject->totalCount > 0) {
					foreach ($handsonSubresultObject->data as $hkey => $hrow) {
//						foreach ($columnObject->data as $crow)
//						{
							$groupByTemplateIDs[$hrow->template_id][]=$hrow;
//							$columnName=$crow->column_value;
//							if($hrow->$columnName==$scheduleAccountWithName)
//							{

//								if(array_key_exists($columnName,$rupeesConversionArray))
//								{
//									if(array_key_exists($hkey,$rupeesConversionArray[$columnName]))
//									{
//										$dataArray[$scheduleAccountWithName][]=$rupeesConversionArray[$columnName][$hkey];
//									}
//								}
//							}
//						}
					}
				}

			foreach ($groupByTemplateIDs as $grpKey => $grpRows) {
				foreach ($grpRows as $tempKey => $tempRows)
				{
					for($i=2;$i<=15;$i++){
						$columnName="column_".$i;
						if ($tempRows->$columnName == $scheduleAccount)
						{
							$dataArray=array('column'=>$columnName,'row'=>$tempKey,'template'=>$grpKey);
							break;
						}
					}
				}
			}
			$rvalue=0;
			if(count($dataArray)>0)
			{
				$rupeesConversionData=$this->Master_Model->_rawQuery('select '.$dataArray['column'].' as column_value from handson_transaction_table where template_id="'.$dataArray['template'].'" and company_id="'.$company_id.'" and status=1 and branch_id="'.$branch_id.'" and year="'.$year1.'" and month="'.$month1.'" order by id asc');

				if($rupeesConversionData->totalCount>0)
				{
					$rvalue=$rupeesConversionData->data[$dataArray['row']]->column_value;
				}
			}
			array_push($value,$rvalue);
//			$resultObject = $this->Master_Model->_rawQuery('select group_concat(total,"#",opening_balance,"#",debit,"#",credit) as data_local from upload_financial_data where year=? and quarter =? and company_id= ? and branch_id=? and is_transfer=0 and gl_ac in
//		(select account_number from branch_account_setup where company_id=? and branch_id=? and schedule_account_number=?) ', array((int)$year1, (int)$month1, $company_id, $branch_id, $company_id, $branch_id, $schedule_account1));
//				if ($resultObject->totalCount > 0) {
//				$data_local = $resultObject->data[0]->data_local;
//				if ($data_local != "") {
//					// 0#0#37293.86#0,0#0#163983.2#0 //0-total,1-opening balance,2-debit,3-credit
//					$datalocalArr = explode(',', $data_local);
//					if (count($datalocalArr) > 0) {
//						foreach ($datalocalArr as $datalocalRow) {
//							$singleGlData = explode('#', $datalocalRow);
//							if (count($singleGlData) > 3) {
//								$total = $singleGlData[0];
//								if ($total == 0) {
//									array_push($value, ($singleGlData[1] + $singleGlData[2] - $singleGlData[3]));
//								} else {
//									array_push($value, $total);
//								}
//							}
//						}
//					}
//				}
//			}
		}
		else{
			$splithash=explode('_',$scheduleAccountWithName);
			if('d'==strtolower($splithash[0])) {
				$previousData = $splithash[0];
				$splitHashExp=explode('-',$splithash[1]);
				$scheduleAccount = $splitHashExp[0];
				$handsonSubresultObject = $this->Master_Model->_rawQuery('select total_local as data_local from derived_report_transaction where derived_gl="'.$scheduleAccount.'" and  company_id="' . $company_id . '" and status=1 and year="'.$year1.'" and month="'.$month1.'" and branch_id="'.$branch_id.'"');
				if ($handsonSubresultObject->totalCount > 0) {
					$data_local = $handsonSubresultObject->data[0]->data_local;
					array_push($value, $data_local);
				}
		}
		else{
			$resultObject = $this->Master_Model->_rawQuery('select group_concat(total,"#",opening_balance,"#",debit,"#",credit) as data_local from upload_financial_data where year=? and quarter =? and company_id= ? and branch_id=? and is_transfer=0 and gl_ac in 
		(select account_number from branch_account_setup where company_id=? and branch_id=? and schedule_account_number=?) ', array((int)$year1, (int)$month1, $company_id, $branch_id, $company_id,$branch_id,$schedule_account));
			if($resultObject->totalCount>0)
			{
				$data_local=$resultObject->data[0]->data_local;
				if($data_local!="")
				{
					// 0#0#37293.86#0,0#0#163983.2#0 //0-total,1-opening balance,2-debit,3-credit
					$datalocalArr=explode(',',$data_local);
					if(count($datalocalArr)>0)
					{
						foreach ($datalocalArr as $datalocalRow)
						{
							$singleGlData=explode('#',$datalocalRow);
							if(count($singleGlData)>3)
							{
								$total=$singleGlData[0];
								if($total==0)
								{
									array_push($value,($singleGlData[1]+$singleGlData[2]-$singleGlData[3]));
								}
								else{
									array_push($value,$total);
								}
							}
						}
					}
				}
			}
		}
		}
//		if($value_sign_in==1)
//		{
//			return	abs(array_sum($value));
//		}
//		else if($value_sign_in==2)
//		{
//			return -abs(array_sum($value));
//		}
//		else if($value_sign_in==3)
//		{
//			return  array_sum($value) <= 0 ? abs(array_sum($value)) : -array_sum($value) ;
//		}
//		else
//		{
			return array_sum($value);
//		}
	}
	public function getScheduleCompany()
	{
		$result = $this->Master_Model->_select('company_master',array('status'=>1),'id,name',false);

		if ($result->totalCount>0) {
			$displayResult = '<option disabled value="">Select Company</option>';

			foreach ($result->data as $row) {
				$displayResult .= '<option value="' . $row->id . '">' . $row->name . '</option>';
			}
			$response['status'] = 200;
			$response['body'] = $displayResult;
		} else {
			$response['status'] = 202;
			$response['body'] = 'No Template Found';
		}
		echo json_encode($response);
	}
	function getColumnAdditionalGLData($month,$year,$branch_id,$schedule_account,$temp_id,$scheduleAccountWithName)
	{
		$search='#';
		$year1 = $year;
		$month1=$month;
		$previousAdd=new stdClass();
		$value=array();
		$rupeesvalue=array();
		$company_id = $this->session->userdata('company_id');
		if(preg_match("/{$search}/i", $scheduleAccountWithName)) {
			$splithash=explode('_',$scheduleAccountWithName);
			if(count($splithash)>1)
			{
				$previousData=$splithash[0];
				$scheduleAccount=$splithash[1];
				$previousData=str_replace('#', '', $previousData);
				$companyObject = $this->Master_Model->_select('branch_master', array('id' => $branch_id), array('start_with as start_month'), true);
				if ($companyObject->totalCount > 0) {
					if($companyObject->data->start_month <= $month)
					{
						if('p'==strtolower($previousData))
						{
							$year1 = $year;
						}
						else if('pp'==strtolower($previousData))
						{
							$year1 = $year - 1;
						}
					}
					else{
						if('p'==strtolower($previousData))
						{
							$year1 = $year - 1;
						}
						else if('pp'==strtolower($previousData))
						{
							$year1 = $year - 2;
						}
					}
					if($companyObject->data->start_month!=1)
					{
						$month1=$companyObject->data->start_month-1;
					}
					else{
						if($companyObject->data->start_month==1)
						{
							$month1=12;
						}
					}
				}
				$schedule_account=$splithash[1];
			}
			$dataArray=array();
			$groupByTemplateIDs=array();
			$handsonSubresultObject = $this->Master_Model->_rawQuery('select * from handson_subsidiary_account_table where company_id="' . $company_id . '" and status=1 and year="'.$year1.'" and month="'.$month1.'"');
			if ($handsonSubresultObject->totalCount > 0) {
				foreach ($handsonSubresultObject->data as $hkey => $hrow) {
					$groupByTemplateIDs[$hrow->template_id][]=$hrow;
				}
			}
			foreach ($groupByTemplateIDs as $grpKey => $grpRows) {
				foreach ($grpRows as $tempKey => $tempRows)
				{
					for($i=2;$i<=15;$i++){
						$columnName="column_".$i;
						if ($tempRows->$columnName == $scheduleAccount)
						{
							$dataArray=array('column'=>$columnName,'row'=>$tempKey,'template'=>$grpKey);
							break;
						}
					}
				}
			}
			$rvalue=0;
			if(count($dataArray)>0)
			{
				$rupeesConversionData=$this->Master_Model->_rawQuery('select '.$dataArray['column'].' as column_value from handson_rupees_conversion_table where template_id="'.$dataArray['template'].'" and company_id="'.$company_id.'" and status=1 and branch_id="'.$branch_id.'" and year="'.$year1.'" and month="'.$month1.'" order by id asc');

				if($rupeesConversionData->totalCount>0)
				{
					$rvalue=$rupeesConversionData->data[$dataArray['row']]->column_value;
				}
			}
			array_push($rupeesvalue,$rvalue);
		}
		else{
			$company_id = $this->session->userdata('company_id');
			$resultObject = $this->Master_Model->_rawQuery('select sum(exchange_rate) as data_local from special_additionGL_rate where year=? and month =? and company_id= ? and branch_id=? and type=1 and gl_ac in 
			(select account_number from branch_account_setup where company_id=? and branch_id=? and schedule_account_number=?) ', array((int)$year1, (int)$month1, $company_id, $branch_id, $company_id,$branch_id,$schedule_account));
			if($resultObject->totalCount>0)
			{
				$data_local=$resultObject->data[0]->data_local;
				if($data_local!="")
				{
					array_push($value,$data_local);
				}
			}

		}
		$previousAdd->additional=array_sum($value);
		$previousAdd->rupeesdata=array_sum($rupeesvalue);
		return $previousAdd;
	}
	public function downloadTableDatafromHashKey1()
	{
		$hashKey=base64_decode($this->input->get('dataHash'));
		$year=$this->input->get('year');
		$month=$this->input->get('month');
		$branch_id=$this->input->get('branch');
		$template_id = $this->input->get('template_id');
		$hashKey1 = str_replace('#', '', $hashKey);
		$hashKey1 = str_replace('@', '', $hashKey1);
		$hashKey1 = str_replace('(', '', $hashKey1);
		$hashKey1 = str_replace(')', '', $hashKey1);
		$hashKey1 = html_entity_decode($hashKey1);
		$hashKey1 = strtoupper($hashKey1);
		$arr = explode("_", $hashKey1);
		$arr[0]=ltrim($arr[0],"-");
		//$arr[0] = str_replace("-", "", $arr[0]);
		$quater=$this->Master_Model->getQuarter();
		$quater=$quater[$month];
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex();
		$objWorkSheet = $objPHPExcel->createSheet(0);
		$objWorkSheet->setTitle('Particular Report Data of '.$quater.' '.$year);
		$objWorkSheet->SetCellValue('A' . 1, 'Gl Number');
		$objWorkSheet->SetCellValue('B' . 1, 'Detail');
		$objWorkSheet->SetCellValue('C' . 1, 'Parent Gl Account Number');
		$objWorkSheet->SetCellValue('D' . 1, 'Opening Balance');
		$objWorkSheet->SetCellValue('E' . 1, 'Debit');
		$objWorkSheet->SetCellValue('F' . 1, 'Credit');
		$objWorkSheet->SetCellValue('G' . 1, 'Total');

		$htmlData=array();
		if (count($arr) > 0) {
			$company_id = $this->session->userdata('company_id');

			$type = '';
			// $html = ob_get_clean();
			$where = array('id' => $template_id);
			$number_conversion = 0;
			$template_name='Report';
			$resultObject = $this->Master_Model->_select('report_maker_master_table', $where, "*", true);
			if ($resultObject->totalCount > 0) {
				$type = $resultObject->data->type;
				$template_name=$resultObject->data->template_name;
			}
			if ($type == 2)//USD
			{
				$parentTable = 'main_account_setup_master_us';
				$parentColumn = 'parent_account_number_us';
			} else if ($type == 3)//IRFS
			{
				$parentTable = 'main_account_setup_master_ifrs';
				$parentColumn = 'parent_account_number_ifrs';
			} else  //IND
			{
				$parentTable = 'main_account_setup_master';
				$parentColumn = 'parent_account_number';
			}

			if ($arr[0] == 'GR' || $arr[0] == 'PGR' || $arr[0] == 'PPGR') {
				$str = substr($arr[0], 0, 2);
				$value = $arr[2];
				$mainGLNumber = array();
				$qr = $this->Master_Model->_rawQuery("select main_gl_number from " . $parentTable . " where group_id='" . $value . "' and company_id=" . $company_id);
				if ($qr->totalCount > 0) {
					$result = $qr->data;
					foreach ($result as $row) {
						$mainGLNumber[] = "'" . $row->main_gl_number . "'";
					}
				}
				$glNumbers = implode(",", $mainGLNumber);

				$resultObject = $this->Master_Model->_rawQuery("select gl_ac,debit,credit,total,detail,opening_balance,(select " . $parentColumn . " from branch_account_setup b where b.account_number=u.gl_ac and b.branch_id=u.branch_id and b.company_id=u.company_id) as parent_gl from upload_financial_data u where year=" . $year . " AND quarter=" . $month . " AND company_id=" . $company_id . " AND branch_id=" . $branch_id . " AND gl_ac in(select account_number from branch_account_setup where " . $parentColumn . " in (" . $glNumbers . ") and branch_id=" . $branch_id . ")");
				if ($resultObject->totalCount > 0) {
					$result = $resultObject->data;
					$htmlData = $result;
				}
			} elseif ($arr[0] == 'GL' || $arr[0] == 'PGL' || $arr[0] == 'PPGL') {
				$str = substr($arr[0], 0, 2);
				$resultObject = $this->Master_Model->_rawQuery("select gl_ac,debit,credit,total,detail,opening_balance,(select " . $parentColumn . " from branch_account_setup b where b.account_number=u.gl_ac and b.branch_id=u.branch_id and b.company_id=u.company_id) as parent_gl from upload_financial_data u where year=" . $year . " AND quarter=" . $month . " AND company_id=" . $company_id . " AND branch_id=" . $branch_id . " AND gl_ac in(select account_number from branch_account_setup where " . $parentColumn . "='" . $arr[2] . "' and branch_id=" . $branch_id . ")");
				if ($resultObject->totalCount > 0) {
					$result = $resultObject->data;
					$htmlData = $result;
				}
			} elseif ($arr[0] == 'T2' || $arr[0] == 'PT2' || $arr[0] == 'PPT2') {
				$value = $arr[2];
				$mainGLNumber = array();
				$qr = $this->Master_Model->_rawQuery("select main_gl_number from " . $parentTable . " where type2='" . $value . "'");
				if ($qr->totalCount > 0) {
					$result = $qr->data;
					foreach ($result as $row) {
						$mainGLNumber[] = "'" . $row->main_gl_number . "'";
					}
				}
				$glNumbers = implode(",", $mainGLNumber);

				$resultObject = $this->Master_Model->_rawQuery("select gl_ac,debit,credit,total,detail,opening_balance,(select " . $parentColumn . " from branch_account_setup b where b.account_number=u.gl_ac and b.branch_id=u.branch_id and b.company_id=u.company_id) as parent_gl from upload_financial_data u where year=" . $year . " AND quarter=" . $month . " AND company_id=" . $company_id . " AND branch_id=" . $branch_id . " AND gl_ac in(select account_number from branch_account_setup where " . $parentColumn . " in (" . $glNumbers . ") and branch_id=" . $branch_id . ")");

				if ($resultObject->totalCount > 0) {
					$result = $resultObject->data;
					$htmlData = $result;
				}
			} else {
				if ($arr[0] == 'EQ' || $arr[0] == 'PEQ' || $arr[0] == 'PPEQ') {
					$type = 'EQUITY AND LIABILITIES';
				} else if ($arr[0] == 'AS' || $arr[0] == 'PAS' || $arr[0] == 'PPAS') {
					$type = 'ASSETS';
				} else if ($arr[0] == 'EX' || $arr[0] == 'PEX' || $arr[0] == 'PPEX') {
					$type = 'EXPENSES';
				} else {
					$type = 'REVENUE';
				}
				$value = $arr[2];
				$mainGLNumber = array();
				$qr = $this->Master_Model->_rawQuery("select main_gl_number from " . $parentTable . " where type1='" . $type . "'");
				if ($qr->totalCount > 0) {
					$result = $qr->data;
					foreach ($result as $row) {
						$mainGLNumber[] = "'" . $row->main_gl_number . "'";
					}
				}
				$glNumbers = implode(",", $mainGLNumber);
				$resultObject = $this->Master_Model->_rawQuery("select gl_ac,debit,credit,total,detail,opening_balance,(select " . $parentColumn . " from branch_account_setup b where b.account_number=u.gl_ac and b.branch_id=u.branch_id and b.company_id=u.company_id) as parent_gl from upload_financial_data u where year=" . $year . " AND quarter=" . $month . " AND company_id=" . $company_id . " AND branch_id=" . $branch_id . " AND gl_ac in(select account_number from branch_account_setup where " . $parentColumn . " in (" . $glNumbers . ") and branch_id=" . $branch_id . ")");
				if ($resultObject->totalCount > 0) {
					$result = $resultObject->data;
					$htmlData = $result;
				}
			}
		}
		$j = 2;
		$totalOP=0;
		$totalDP=0;
		$totalCP=0;
		$totalTO=0;
		foreach ($htmlData as $hrow)
		{
			$totalOP+=$hrow->opening_balance;
			$totalDP+=$hrow->debit;
			$totalCP+=$hrow->credit;
			$totalTO+=$hrow->total;
			$objWorkSheet->SetCellValue('A' . $j, $hrow->gl_ac);
			$objWorkSheet->SetCellValue('B' . $j, $hrow->detail);
			$objWorkSheet->SetCellValue('C' . $j, $hrow->parent_gl);
			$objWorkSheet->SetCellValue('D' . $j, $hrow->opening_balance);
			$objWorkSheet->SetCellValue('E' . $j, $hrow->debit);
			$objWorkSheet->SetCellValue('F' . $j, $hrow->credit);
			$objWorkSheet->SetCellValue('G' . $j, $hrow->total);
			$j++;
		}
		$objWorkSheet->SetCellValue('A' . $j, 'Total');
		$objWorkSheet->SetCellValue('B' . $j, '');
		$objWorkSheet->SetCellValue('C' . $j, '');
		$objWorkSheet->SetCellValue('D' . $j, $totalOP);
		$objWorkSheet->SetCellValue('E' . $j, $totalDP);
		$objWorkSheet->SetCellValue('F' . $j, $totalCP);
		$objWorkSheet->SetCellValue('G' . $j, $totalTO);
		ob_end_clean();

		$filename = $template_name." Particular" . $quater.'_'.$year.'_' . date("Y-m-d") . ".xls";
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
	public function getTemplateListOFMonthYear()
	{
		if(!is_null($this->input->post('month')) && !is_null($this->input->post('year')))
		{
			$company_id = $this->session->userdata('company_id');
			$month=$this->input->post('month');
			$year=$this->input->post('year');
			$getTemplates = $this->Master_Model->_rawQuery("select id,template_name from handson_template_master where status=1 AND  company_id=" . $company_id." and month=".$month." and year=".$year);
			$optionData='<option value="">Select Template</option>';
			if($getTemplates->totalCount>0)
			{
				foreach ($getTemplates->data as $row)
				{
					$optionData.='<option value="'.$row->id.'">'.$row->template_name.'</option>';
				}
				$response['status']=200;
				$response['body']=$optionData;
			}
			else{
				$response['status']=200;
				$response['body']=$optionData;
			}
		}
		else{
			$response['status']=201;
			$response['body']='Select month and year';
		}
		echo json_encode($response);
	}
	public function downlodRupeesConversionAllbranch()
	{
		$this->load->library('excel');
		$month = $this->input->get('month');
		$year = $this->input->get('year');
		$temp_id=$this->input->get('temp_id');
		$number_conversion=$this->input->get('valuesIn');
		$company_id = $this->session->userdata('company_id');
		//getAllTemplates $company_id
		$sheetCount = 0;
		$branchName = "";
		$k = 0;
		$divide = 1;
		if (!is_null($number_conversion)) {
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
		}
		$quater=$this->Master_Model->getQuarter();
		$quater=$quater[$month];
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex();
		$objWorkSheet = $objPHPExcel->createSheet($k);
//		$objPHPExcel->removeSheetByIndex(0);
		$template_name='Template';
		$templateData = $this->Master_Model->_rawQuery("select template_name from handson_template_master where  id=" . $temp_id);
		if ($templateData->totalCount > 0) {
			$template_name=$templateData->data[0]->template_name;
		}
		$objWorkSheet->setTitle($template_name.'_'.$quater.'_'.$year);
		$header = array();
		$allColumns = array();
		$templateqr = $this->Master_Model->_rawQuery("select column_name,column_value from handson_template_column_master where  template_id=" . $temp_id);
		if ($templateqr->totalCount > 0) {
			$resDatatemp = $templateqr->data;
			foreach ($resDatatemp as $rowDtaa)
			{
				array_push($header,$rowDtaa->column_name);
				array_push($allColumns,$rowDtaa->column_value);
			}
		}
			$resulObject=$this->Master_Model->_rawQuery("select id,name,country from branch_master where company_id=".$company_id." and status=1 order by is_consolidated asc");
			//$objWorkSheet->getSheetByName('Worksheet')
			$countryList=$this->Master_Model->country();

			$i = 1;
			$char = 'A';
			foreach ($resulObject->data as $item) {

				$branch_id=$item->id;
				$branch_name = $item->name;
				$countryName=$countryList[0][$item->country];

				$allColumnsName = array();

				//get template view
				$objWorkSheet->SetCellValue($char . $i, $branch_name);
				$objWorkSheet->getStyle(PHPExcel_Cell::stringFromColumnIndex($char) . $i)
					->getAlignment()
					->setWrapText(true);
				$objWorkSheet->getStyle(PHPExcel_Cell::stringFromColumnIndex($char) . $i)
					->getFont()
					->setBold(true);
				$objWorkSheet->SetCellValue('B' . $i, $countryName);
				$objWorkSheet->getStyle(PHPExcel_Cell::stringFromColumnIndex('B') . $i)
					->getAlignment()
					->setWrapText(true);
				$objWorkSheet->getStyle(PHPExcel_Cell::stringFromColumnIndex('B') . $i)
					->getFont()
					->setBold(true);
				$i=$i+2;
				$branchWhere1 = "";
				$newChar='A';
				foreach ($header as $headRow)
				{
					$objWorkSheet->SetCellValue($newChar . $i, $headRow);
					$newChar++;
				}

				$allCol=implode(',',$allColumns);
				$quer = $this->Master_Model->_rawQuery("select " . $allCol . " from handson_rupees_conversion_table where status=1 and company_id=" . $company_id . " and template_id=" . $temp_id . " and year=" . $year . " and month=" . $month . " and branch_id=" . $branch_id . " Group by column_1 order by id asc");
				$i=$i+1;
				if ($quer->totalCount > 0) {
					$array = array();
					$data = $quer->data;

					foreach ($data as $row1) {
						$c = 'A';
						foreach ($allColumns as $allKey=> $row) {
							if($c=='A')
							{
								$value=$row1->$row;
							}
							else{
								$value=(int)$row1->$row/$divide;
							}
							$objWorkSheet->SetCellValue($c . $i, $value);
							$c++;
						}
						$i++;
					}
				}
				$i=$i+1;
				$i++;
			}
//		$objPHPExcel->removeSheetByIndex($sheetCount);
		ob_end_clean();

		$filename = $template_name."_".$quater.'_'.$year.'_'. date("Y-m-d") . ".xls";
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
	public function clearScheduleSubsidiaryMapp()
	{
		$temp_id = $this->input->post('temp_id');
		$company_id = $this->input->post('company_id');
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$where = array(
			"template_id" => $temp_id,
			"company_id" => $company_id,
			"year" => $year,
			"month" => $month,
		);
		try {
			$this->db->trans_start();
			$response['status'] = 201;
			$body = 'Data Not Cleared';
			$query = $this->db->delete('handson_subsidiary_account_table', $where);
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$response['status'] = 201;
				$body = 'something went wrong';
			} else {
				$this->db->trans_commit();
				$response['status'] = 200;
				$body = 'Data Clear Successfully';
			}
			$this->db->trans_complete();
		} catch (Exception $exc) {
			$response['status'] = 201;
			$body = 'something went wrong';
			$this->db->trans_rollback();
			$this->db->trans_complete();
		}
		$response['body']=$body;
		echo json_encode($response);
	}
	 ////currency rate mapping
	public function getCurrencyRateMapping()
{
	if (!is_null($this->input->post("temp_id"))) {
		$temp_id = $this->input->post("temp_id");
		$month = $this->input->post("month");
		$year = $this->input->post("year");
//			print_r($month);exit();
		$user_type = $this->session->user_session->user_type;
		$user_id = $this->session->user_session->user_id;
		$company_id = $this->input->post("company_id");
		if(is_null($company_id))
		{
			$company_id = $this->session->user_session->company_id;
		}
		$columnObject = $this->TemplateToolModel->_rawQuery('select * from handson_template_column_master hm where template_id="' . $temp_id . '" order by sequence asc');
		$columnHeaders = array('id', 'created_by');
		$columnTypes = array();
		$hideColumns = array();
		$columnData = array();
		$object1 = new stdClass();
		$object1->type = 'text';
		$rowsCol = "";
		$readonlyArray = array();
		$columnSummary = array();
		$hideColumns = array(0, 1);
		array_push($columnTypes, $object1, $object1);
		$source = array();
		$prefillValueType = array();


		if ($columnObject->totalCount > 0) {
			foreach ($columnObject->data as $key => $value) {
				array_push($columnHeaders, $value->column_name);
				$object = new stdClass();
				if ($value->value_type == 1) {
					if ($value->column_value != "column_1") {
						$object->type = 'dropdown';
						$object->source = array('1-closing_rate','2-average_rate');
					} else {
						$object->type = $value->column_type;
						$object->readOnly = true;
					}
				} else {
					$object->type = $value->column_type;
				}

				array_push($columnTypes, $object);
				array_push($columnData, $value->column_value);
			}


			$rowsObject = $this->TemplateToolModel->_select('handson_currency_rate_account_table hm', array('template_id' => $temp_id,'company_id' => $company_id, 'status' => 1,'month'=>$month,'year'=>$year),
				'*', false);
			if ($rowsObject->totalCount > 0) {
				$rowsCol = array();
				$r = 0;
				foreach ($rowsObject->data as $rkey => $rvalue) {
					$data = array($rvalue->id, $rvalue->created_by);

					if (trim($rvalue->created_by) != trim($user_id)) {
						array_push($readonlyArray, $r);
					}
					$a = 2;
					foreach ($columnData as $ckey => $cvalue) {
						array_push($data, $rvalue->$cvalue);
						$a++;
					}

					array_push($rowsCol, $data);
					$r++;
				}
			} else {
				$rowsObject1 = $this->TemplateToolModel->_select('handson_prefill_table', array('template_id' => $temp_id, 'status' => 1), '*', false);
				if ($rowsObject1->totalCount > 0) {
					$rowsCol = array();
					$r = 0;
					foreach ($rowsObject1->data as $rkey => $rvalue) {
						$data = array('', '');
						if ($rvalue->value_type == 'Calculated') {

						}
						if (trim($rvalue->created_by) != trim($user_id) || $rvalue->value_type == 'Calculated') {
							array_push($readonlyArray, $r);
						}
						foreach ($columnData as $ckey => $cvalue) {
							array_push($data, $rvalue->$cvalue);
						}
						array_push($rowsCol, $data);
						$r++;
					}
				} else {
					$data = array('', '');
					$rowsCol = array();
					foreach ($columnData as $ckey => $cvalue) {
						array_push($data, '');
					}
					array_push($rowsCol, $data);
				}

			}
		}
		$response['status'] = 200;
		$response['columnHeaders'] = $columnHeaders;
		$response['columnTypes'] = $columnTypes;
		$response['columnSummary'] = $columnSummary;
		$response['hideArra'] = $hideColumns;
		$response['columnRows'] = $rowsCol;
		$response['readonlyArray'] = $readonlyArray;
		$response['prefillValueType'] = $prefillValueType;
	} else {
		$response['status'] = 201;
		$response['body'] = 'Required Parameter Missing';
	}
	echo json_encode($response);
}
	public function saveCurrencyRateMappData()
	{
		if (!is_null($this->input->post('arrData'))) {
			$temp_id = $this->input->post('temp_id');
			$Data1 = $this->input->post('arrData');
			$year = $this->input->post('year');
			$month = $this->input->post('month');
			$arrData = json_decode($Data1);
//			 print_r($arrData);exit();
			$user_type = $this->session->user_session->user_type;
			$user_id = $this->session->user_session->user_id;
			$company_id = $this->input->post("company_id");
			if(is_null($company_id))
			{
				$company_id = $this->session->user_session->company_id;
			}
			$TransactionData = array();
			$CurrencyData = array();
			//get Data from transaction Table


//			$columnObject = $this->TemplateToolModel->_rawQuery('select * from handson_template_column_master hm where template_id="' . $temp_id . '" order by sequence asc');
//			print_r($TransactionData);exit();
			$insertData = array();
			if (!empty($arrData)) {
				foreach ($arrData as $key1 => $row) {
					if ($row[2] != "" && $row[2] != "null" && $row[2] != null) {

						$data = array(
							"template_id" => $temp_id,
							"company_id" => $company_id,
							"user_id" => $user_id,
							"user_type" => $user_type,
							"created_by" => $user_id,
							"month" => $month,
							"year" => $year,
							"created_on" => date('Y-m-d H:i:s')
						);
						$m = 1;
						for ($i = 2; $i < 17; $i++) {
							$columnName = 'column_' . $m;
							if (isset($row[$i])) {
								$data[$columnName] = $row[$i];
							} else {
								$data[$columnName] = '';
							}
							$m++;
						}

						array_push($insertData, $data);
					}
				}
			}
//			print_r($insertData);exit();
			$where = array(
				"template_id" => $temp_id,
				"company_id" => $company_id,
				"year"=>$year,
				"month"=>$month
			);
			$status = FALSE;
			try {
				$this->db->trans_start();
				if (!empty($insertData)) {
					$delete = $this->db->delete('handson_currency_rate_account_table', $where);
					$insert_batch = $this->db->insert_batch("handson_currency_rate_account_table", $insertData);
				}
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					$status = FALSE;
				} else {
					$this->db->trans_commit();
					$status = TRUE;
				}
				$this->db->trans_complete();
				$last_query = $this->db->last_query();
			} catch (Exception $ex) {
				$status = FALSE;
				$this->db->trans_rollback();
			}
			if ($status == true) {
				$response['status'] = 200;
				$response['body'] = "Data uploaded Successfully";
			} else {
				$response['status'] = 201;
				$response['body'] = "Failed To uplaod";
			}
		} else {
			$response['status'] = 201;
			$response['body'] = "Failed To uplaod";
		}
		echo json_encode($response);
	}
	public function clearCurrencyRateMapp()
	{
		$temp_id = $this->input->post('temp_id');
		$company_id = $this->input->post('company_id');
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$where = array(
			"template_id" => $temp_id,
			"company_id" => $company_id,
			"year" => $year,
			"month" => $month,
		);
		try {
			$this->db->trans_start();
			$response['status'] = 201;
			$body = 'Data Not Cleared';
			$query = $this->db->delete('handson_currency_rate_account_table', $where);
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$response['status'] = 201;
				$body = 'something went wrong';
			} else {
				$this->db->trans_commit();
				$response['status'] = 200;
				$body = 'Data Clear Successfully';
			}
			$this->db->trans_complete();
		} catch (Exception $exc) {
			$response['status'] = 201;
			$body = 'something went wrong';
			$this->db->trans_rollback();
			$this->db->trans_complete();
		}
		$response['body']=$body;
		echo json_encode($response);
	}
	function ClearTemplateCurrencyRateData()
	{
		$temp_id = $this->input->post('temp_id');
		$branch_id = $this->input->post('branch_id');
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$where = array(
			"template_id" => $temp_id,
			"branch_id" => $branch_id,
			"year" => $year,
			"month" => $month,
		);
		try {
			$this->db->trans_start();
			$response['status'] = 201;
			$body = 'Data Not Saved';
			$query = $this->db->delete('handson_currency_rate_table', $where);
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$response['status'] = 201;
				$body = 'something went wrong';
			} else {
				$this->db->trans_commit();
				$response['status'] = 200;
				$body = 'Data Uploaded';
			}
			$this->db->trans_complete();
		} catch (Exception $exc) {
			$response['status'] = 201;
			$body = 'something went wrong';
			$this->db->trans_rollback();
			$this->db->trans_complete();
		}
		echo json_encode($response);
	}
	function getTemplateListDropdown()
	{
		$getTemplates = $this->Master_Model->_select("template_master_dropdown",array('status'=>1),'*',false);
		$optionData='<option value="">Select SpreadSheet Name</option>';
		if($getTemplates->totalCount>0)
		{
			foreach ($getTemplates->data as $row)
			{
				$optionData.='<option value="'.$row->name.'">'.$row->name.'</option>';
			}
			$response['status']=200;
			$response['body']=$optionData;
		}
		else{
			$response['status']=200;
			$response['body']=$optionData;
		}
		echo json_encode($response);
	}
	public function getscheduleTrnsactionsTemplateId()
	{
		if(!is_null($this->input->post('month')) && !is_null($this->input->post('year')))
		{
			$tempName=$this->input->post('temp_name');
			$year=$this->input->post('year');
			$month=$this->input->post('month');
			$company_id = $this->session->user_session->company_id;
//			$getTemplates = $this->Master_Model->_select("handson_template_master",array('status'=>1,'template_name'=>$tempName,'company_id'=>$company_id,'year'=>'','month'=>''),'*');
			$getTemplates = $this->Master_Model->_rawQuery('select id from handson_template_master where status=1 and template_name="'.$tempName.'" and company_id='.$company_id.' and year='.$year.' and month='.$month.' order by id desc limit 1');
//			print_r($getTemplates);exit();
			if($getTemplates->totalCount>0)
			{
				$response['status']=200;
				$response['body']=$getTemplates->data[0]->id;
			}
			else{
				$response['status']=201;
				$response['body']="No Template Found";
			}
		}
		else{
			$response['status']=201;
			$response['body']="Something Went Wrong";
		}
		echo json_encode($response);
	}
}
