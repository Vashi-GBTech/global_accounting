<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 * @property  Master_Model Master_Model
 */
class ExcelUploadController extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Global_model');
		$this->load->model('AwsModel');
	}

	function SaveExcel()
	{
		if (!is_null($this->input->post('count')) && !is_null($this->input->post('insertID'))) {
			$count = $this->input->post('count');
			$insertID = $this->input->post('insertID');
			$branchID = $this->input->post('branchID');
			$unmatchStatus = $this->input->post('unmatchStatus');
			$mappingArray = array();
			for ($i = 0; $i <= $count; $i++) {
				if (!is_null($this->input->post('databaseColumn' . $i))) {
					if ($this->input->post('databaseColumn' . $i) != "") {
						array_push($mappingArray, $this->input->post('databaseColumn' . $i));
					}
				}
			}
			if ($count != count($mappingArray)) {
				$response['status'] = 201;
				$response['body'] = 'Please Fill All Field';
				$response['type'] = 2;
				echo json_encode($response);
				exit();
			} else {
				$path = $_FILES["userfile"]["tmp_name"][0];
				$this->load->library('excel');
				$object = PHPExcel_IOFactory::load($path);
				$worksheet = $object->getActiveSheet();
				$excelname = $_FILES["userfile"]["name"][0];

				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				$highestColumnNumber = PHPExcel_Cell::columnIndexFromString($highestColumn);
				$check_entry = $this->db->where(array('id' => $insertID))->get('excelsheet_master_data')->row();
				$user_id = $this->session->userdata('user_id');
				$company_id = $this->session->userdata('company_id');
				$branch_id = $this->session->userdata('branch_id');
				// print_r($branch_id);exit();
				$query = $this->Master_Model->_select("upload_column_mapping_rule", array("type" => 1), array("*"), false)->data;
				// print_r($mappingArray);exit();
				$rule_array = array();
				$coulmnName_array = array();
				$mandatory_array = array();
				foreach ($query as $row) {
					$rule_array[$row->id] = $row->rule;
					$coulmnName_array[$row->id] = $row->column_name;
					$mandatory_array[$row->id] = $row->mandatoryRule;
				}
				$company_id = $this->session->userdata('company_id');
				$AccountArrayarray = array();
				$queryGetBranchArray = $this->Master_Model->_select("branch_account_setup", array("parent_account_number !=" => "", "parent_account_number !=" => null, "company_id" => $company_id, 'status' => 1), array("account_number"), false)->data;
				foreach ($queryGetBranchArray as $r1) {
					$AccountArrayarray[] = $r1->account_number;
				}
				$whiteSpaceArray = array();
				$SpecialCharacterArray = array();
				$NoTextArray = array();
				$NoCommaArray = array();
				$blankArray = array();
				$uploadDataArray = array();
				$is_error = false;
				$nonNumeric = 0;
				$umatched = 0;
				$matched = 0;
				$alpha = 'A';
				$table = '<table class="table">
							<thead class="tableHead">
								<tr><th>1</th>';
				foreach ($mappingArray as $columnNumber) {
					$columnName = $coulmnName_array[$columnNumber];
					$table .= '<th>' . $columnName . '(' . $alpha . ')</th>';
					$alpha++;
				}
				$table .= '</tr>
							</thead>
							<tbody>';
				for ($i = 2; $i <= $highestRow; $i++) {

					if (!empty($check_entry)) {
						$batchdata = array("year" => $check_entry->year,
							"quarter" => $check_entry->quarter,
							"user_id" => $user_id,
							"created_by" => $user_id,
							"created_on" => date('Y-m-d H:i:s'),
							"branch_id" => $branchID,
							"company_id" => $company_id,
							"sheet_master_id" => $insertID
						);
					}
					$col = 'A';
					$um = 0;
					$table_td = '';
					$table_td .= '<td>' . $i . '</td>';
					foreach ($mappingArray as $columnNumber) {

						$rule = explode(",", $rule_array[$columnNumber]);
						$columnName = $coulmnName_array[$columnNumber];
						$value = $object->getActiveSheet()->getCell($col . $i)->getValue();
						$color = '';


						if (in_array("1", $rule)) { //NO SPACE
							if (preg_match('/\s/', $value)) {
								array_push($whiteSpaceArray, $col . $i);
								$value = preg_replace('/\s/', '', $value);
							}
						}

						if (in_array("4", $rule)) { //NO COMMA
							$searchForValue = ',';
							if (strpos($value, $searchForValue) !== false) {
								array_push($NoCommaArray, $col . $i);
								$value = str_replace(',', '', $value);
							}
						}
						if (in_array("2", $rule)) { // NO SPECIAL CHARACTER
							if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $value)) {
								array_push($SpecialCharacterArray, $col . $i);
								$value = preg_replace('/[^A-Za-z0-9\-]/', '', $value);
							}
						}
						if (in_array("3", $rule)) { // NO TEXT
							if (!is_numeric($value)) {
								if ($value != "") {
									array_push($NoTextArray, $col . $i);
									$is_error = true;
									$color = 'style="background-color:#f06969;color:black"';
									$nonNumeric++;
								} else {
									$value = '';
								}
							}
						}
						if ($mandatory_array[$columnNumber] == 1 && $value == "") // Mandatory Field
						{
							array_push($blankArray, $col . $i);
							$color = 'style="background-color:#f06969;color:black"';
						}

						$batchdata[$columnName] = $value;//insertdata array
						$col++;

						$table_td .= '<td ' . $color . '>' . $value . '</td>';
						if ($columnNumber == 1) {
							if (!in_array($value, $AccountArrayarray)) {
								$um = 1;
							}
						}
					}
					$rowColor = '';
					if ($um == 1) {
						$umatched++;
						$is_error = true;
						$rowColor = 'style="background-color:#f06969;color:black"';
					} else {
						$matched++;
					}
					$table .= '<tr ' . $rowColor . '>' . $table_td . '</tr>';

					array_push($uploadDataArray, $batchdata);
				}
				$table .= '</tbody>
						</table>';
				if ($unmatchStatus == 0) {
					$is_error = $is_error;
				} else {
					$is_error = false;
				}

				if ($is_error == true) {
					$response['whiteSpace'] = implode(',', array_unique($whiteSpaceArray));
					$response['SpecialCharacter'] = implode(',', array_unique($SpecialCharacterArray));
					$response['NoText'] = implode(',', array_unique($NoTextArray));
					$response['NoComma'] = implode(',', array_unique($NoCommaArray));
					$response['status'] = 201;
					$response['type'] = 1;
					$response['body'] = 'Data not Matched';
					$response['table'] = $table;
					$response['NonNumeric'] = $nonNumeric;//0
					$response['TotalRowUpload'] = $highestRow;
					$response['MatchedData'] = $matched;
					$response['UmatchedData'] = $umatched;
					$response['MandatoryData'] = implode(',', array_unique($blankArray));
				} else {
					//insert Data INTO DATABASE
					$upload_path = "uploads";
					$combination = 2;
					$name_input = "userfile";
					$result = $this->AwsModel->upload_multiple_file_new($upload_path, $name_input, $combination);
//					print_r($result);exit();
					if ($result['status'] == 200) {
						$input_data =$result['body'][0];
						try {
							$this->db->trans_start();
							$master_data = array('name' => $input_data);
							$update = $this->db->update('excelsheet_master_data', $master_data, array('id' => $insertID));
							if ($update) {
								if (!empty($check_entry)) {
									if (!empty($uploadDataArray)) {
										$this->db->where(array('sheet_master_id' => $insertID))->delete('upload_financial_data');
										$this->db->insert_batch('upload_financial_data', $uploadDataArray);
									}
								}
							}
							if ($this->db->trans_status() === FALSE) {
								$this->db->trans_rollback();
								$result = false;
								$body_message = 'something went wrong';
							} else {
								$this->db->trans_commit();
								$result = true;
								$body_message = 'Data Uploaded';
							}
							$this->db->trans_complete();
						} catch (Exception $exc) {
							$result = false;
							$this->db->trans_rollback();
							$this->db->trans_complete();
						}

						if ($result == true) {
							$response['status'] = 200;
							$response['body'] = 'Data Uploaded Successfully';
						} else {
							$response['status'] = 201;
							$response['body'] = 'File Not Uploaded';
							$response['type'] = 2;
						}
					} else {
						$response['status'] = 201;
						$response['body'] = 'File Not Uploaded';
						$response['type'] = 2;
					}
				}
			}
		} else {
			$response['status'] = 201;
			$response['body'] = 'Required Parameter Missing';
			$response['type'] = 2;
		}
		echo json_encode($response);
	}

	function SaveMainExcel()
	{
		$maintype = $this->input->post('main_type');
		$maintype0 = $this->input->post('main_type0');

		if (!is_null($this->input->post('count'))) {
			$count = $this->input->post('count');
			$unmatchStatus = $this->input->post('unmatchStatus');
			$mappingArray = array();
			for ($i = 0; $i <= $count; $i++) {
				if (!is_null($this->input->post('databaseColumn' . $i))) {
					if ($this->input->post('databaseColumn' . $i) != "") {
						array_push($mappingArray, $this->input->post('databaseColumn' . $i));
					}
				}
			}
			if ($count != count($mappingArray)) {
				$response['status'] = 201;
				$response['body'] = 'Please Fill All Field';
				$response['type'] = 2;
				echo json_encode($response);
				exit();
			} else {
				$path = $_FILES["userfile"]["tmp_name"];
				$this->load->library('excel');
				$object = PHPExcel_IOFactory::load($path);
				$worksheet = $object->getActiveSheet();
				$excelname = $_FILES["userfile"]["name"];

				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				$highestColumnNumber = PHPExcel_Cell::columnIndexFromString($highestColumn);
				$user_id = $this->session->userdata('user_id');
				$company_id = $this->session->userdata('company_id');
				$branch_id = $this->session->userdata('branch_id');
				// print_r($branch_id);exit();
				$query = $this->Master_Model->_select("upload_column_mapping_rule", array("type" => 2), array("*"), false)->data;
				// print_r($mappingArray);exit();
				$rule_array = array();
				$coulmnName_array = array();
				$mandatory_array = array();
				foreach ($query as $row) {
					$rule_array[$row->Tablecolumn_name] = $row->rule;
					$coulmnName_array[$row->Tablecolumn_name] = $row->column_name;
					$mandatory_array[$row->Tablecolumn_name] = $row->mandatoryRule;
				}
				$company_id = $this->session->userdata('company_id');

				$whiteSpaceArray = array();
				$SpecialCharacterArray = array();
				$NoTextArray = array();
				$NoCommaArray = array();
				$blankArray = array();
				$uploadDataArray = array();
				$group_unmatch = array();
				$is_error = false;
				$nonNumeric = 0;
				$umatched = 0;
				$matched = 0;
				$alpha = 'A';
				$duplicate_msg = 0;
				$duplicate_main = 0;
				$table = '<table class="table">
							<thead class="tableHead">
								<tr><th>1</th>';
				foreach ($mappingArray as $columnNumber) {
					$columnName = $columnNumber;
					if($columnName == "sequence_number"){
						$columnName = "Group Id";
					}
					$table .= '<th>' . $columnName . '(' . $alpha . ')</th>';
					$alpha++;
				}

				$table .= '</tr>
							</thead>
							<tbody>';
				for ($i = 2; $i <= $highestRow; $i++) {

					$batchdata = array(
						"created_by" => $user_id,
						"created_on" => date('Y-m-d H:i:s'),
						"company_id" => $company_id,
						"type0" => $maintype0
					);
					$col = 'A';
					$um = 0;
					$table_td = '';
					$table_td .= '<td>' . $i . '</td>';
					foreach ($mappingArray as $columnNumber) {

						$rule = explode(",", $rule_array[$columnNumber]);
						$columnName = $columnNumber;
						$value = $object->getActiveSheet()->getCell($col . $i)->getValue();
						$color = '';


						if (in_array("1", $rule)) { //NO SPACE
							if (preg_match('/\s/', $value)) {
								array_push($whiteSpaceArray, $col . $i);
								$value = preg_replace('/\s/', '', $value);
							}
						}

						if (in_array("4", $rule)) { //NO COMMA
							$searchForValue = ',';
							if (strpos($value, $searchForValue) !== false) {
								array_push($NoCommaArray, $col . $i);
								$value = str_replace(',', '', $value);
							}
						}
						if (in_array("2", $rule)) { // NO SPECIAL CHARACTER
							if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $value)) {
								array_push($SpecialCharacterArray, $col . $i);
								$value = preg_replace('/[^A-Za-z0-9\-]/', '', $value);
							}
						}
						if (in_array("3", $rule)) { // NO TEXT
							if (!is_numeric($value)) {
								if ($value != "") {
									array_push($NoTextArray, $col . $i);
									$is_error = true;
									$color = 'style="background-color:#f06969;color:black"';
									$nonNumeric++;
								} else {
									$value = '';
								}
							}
						}


						if ($mandatory_array[$columnNumber] == 1 && $value == "") // Mandatory Field
						{
							array_push($blankArray, $col . $i);
							$color = 'style="background-color:#f06969;color:black"';
						}

						if ($columnNumber == 'main_gl_number') {
							$main_table = "main_account_setup_master";
							if ($maintype == 2) {
								$main_table = "main_account_setup_master_us";
							}
							if ($maintype == 3) {
								$main_table = "main_account_setup_master_ifrs";
							}

							$getAllData = $this->Master_Model->_select($main_table, array('company_id' => $company_id, 'status' => 1), '*', false);
							$main_data_array = array();
							if ($getAllData->totalCount > 0) {
								$mainGl = $getAllData->data;
								foreach ($mainGl as $row) {
									$main_data_array[$row->main_gl_number] = $row->name;
								}
							}
							if (count($uploadDataArray) > 0) {
								foreach ($uploadDataArray as $key => $val) {
									if ($val['main_gl_number'] == $value) {
										$color = 'style="background-color:#f06969;color:black"';
										$is_error = true;
										$duplicate_msg++;
									}
								}
							}
							if(array_key_exists((int)$value,$main_data_array)){
								$color = 'style="background-color:#f2d176;color:black"';
								$is_error = true;
								$duplicate_main++;
							}
						}
						if ($columnName == 'sequence_number') {
							$group_table = "master_account_group_ind";
							if ($maintype == 2) {
								$group_table = "master_account_group_us";
							}
							if ($maintype == 3) {
								$group_table = "master_account_group_ifrs";
							}


							$checkifExists = $this->Master_Model->get_count(array('sequence_no' => $value, 'company_id' => $company_id, 'status' => 1), $group_table);

							if ($checkifExists > 0) {
								$group_data = $this->Master_Model->get_row_data('*', array('sequence_no' => $value, 'company_id' => $company_id, 'status' => 1), $group_table);
								$batchdata['type0'] = $group_data->type0;
								$batchdata['type1'] = $group_data->type1;
								$batchdata['type2'] = $group_data->type2;
								$batchdata['type3'] = $group_data->type3;
								$batchdata['calculation_method'] = $group_data->calculation_method;
								$batchdata['monitory'] = $group_data->monitory_status;
								$batchdata['is_divide'] = $group_data->is_divide;
								$batchdata['group_id'] = $group_data->id;
							} else {
								array_push($group_unmatch, $col . $i);
								$is_error = true;
								$color = 'style="background-color:#f06969;color:black"';
							}
						}
						$batchdata[$columnName] = $value;//insertdata array
						$col++;

						$table_td .= '<td ' . $color . '>' . $value . '</td>';

					}
					$rowColor = '';
					$table .= '<tr ' . $rowColor . '>' . $table_td . '</tr>';

					array_push($uploadDataArray, $batchdata);
				}
				//exit;
				$table .= '</tbody>
						</table>';
				if ($unmatchStatus == 0) {
					$is_error = $is_error;
				} else {
					$is_error = false;
				}
				if ($is_error == true) {
					$response['whiteSpace'] = implode(',', array_unique($whiteSpaceArray));
					$response['SpecialCharacter'] = implode(',', array_unique($SpecialCharacterArray));
					$response['NoText'] = implode(',', array_unique($NoTextArray));
					$response['NoComma'] = implode(',', array_unique($NoCommaArray));
					$response['GroupUnmatch'] = implode(',', array_unique($group_unmatch));
					$response['status'] = 201;
					$response['type'] = 1;
					$response['body'] = 'Data not Matched';
					$response['table'] = $table;
					$response['NonNumeric'] = $nonNumeric;//0
					$response['TotalRowUpload'] = $highestRow;
					$response['MatchedData'] = $matched;
					$response['UmatchedData'] = $umatched;
					if ($duplicate_msg != 0) {
						$duplicate_msg = $duplicate_msg . " (Duplicate GL account number not allowed)";
					}
					if ($duplicate_main != 0) {
						$duplicate_main = $duplicate_main . " (GL account number already exists in the Database)";
					}

					$response['duplicate_msg'] = $duplicate_msg;
					$response['duplicate_main'] = $duplicate_main;
					$response['MandatoryData'] = implode(',', array_unique($blankArray));
				} else {
					//insert Data INTO DATABASE
					$upload_path = "uploads";
					$combination = 2;
					$name_input = "userfile";
					$result = $this->Global_model->upload_multiple_file1($upload_path, $name_input, $combination);
					if ($result['status'] == 200) {
						$input_data = $upload_path . '/' . $result['body'];
						try {
							$this->db->trans_start();
							if (!empty($uploadDataArray)) {
								$table = 'main_account_setup_master';
								if ($maintype == 2) {
									$table = 'main_account_setup_master_us';
								}
								if ($maintype == 3) {
									$table = 'main_account_setup_master_ifrs';
								}
								$this->db->insert_batch($table, $uploadDataArray);
							}
							if ($this->db->trans_status() === FALSE) {
								$this->db->trans_rollback();
								$result = false;
								$body_message = 'something went wrong';
							} else {
								$this->db->trans_commit();
								$result = true;
								$body_message = 'Data Uploaded';
							}
							$this->db->trans_complete();
						} catch (Exception $exc) {
							$result = false;
							$this->db->trans_rollback();
							$this->db->trans_complete();
						}

						if ($result == true) {
							$response['status'] = 200;
							$response['body'] = 'Data Uploaded Successfully';
						} else {
							$response['status'] = 201;
							$response['body'] = 'File Not Uploaded';
							$response['type'] = 2;
						}
					} else {
						$response['status'] = 201;
						$response['body'] = 'File Not Uploaded';
						$response['type'] = 2;
					}
				}
			}
		} else {
			$response['status'] = 201;
			$response['body'] = 'Required Parameter Missing';
			$response['type'] = 2;
		}
		echo json_encode($response);
	}

	function SaveBranchExcel()
	{
		$branch_id = $this->input->post('branch_id');
		if (!is_null($this->input->post('count'))) {
			$count = $this->input->post('count');
			$unmatchStatus = $this->input->post('unmatchStatus');
			$mappingArray = array();
			for ($i = 0; $i <= $count; $i++) {
				if (!is_null($this->input->post('databaseColumn' . $i))) {
					if ($this->input->post('databaseColumn' . $i) != "") {
						array_push($mappingArray, $this->input->post('databaseColumn' . $i));
					}
				}
			}
			if ($count != count($mappingArray)) {
				$response['status'] = 201;
				$response['body'] = 'Please Fill All Field';
				$response['type'] = 2;
				echo json_encode($response);
				exit();
			} else {
				$path = $_FILES["userfile"]["tmp_name"];
				$this->load->library('excel');
				$object = PHPExcel_IOFactory::load($path);
				$worksheet = $object->getActiveSheet();
				$excelname = $_FILES["userfile"]["name"];

				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				$highestColumnNumber = PHPExcel_Cell::columnIndexFromString($highestColumn);
				$user_id = $this->session->userdata('user_id');
				$company_id = $this->session->userdata('company_id');
				// print_r($branch_id);exit();
				$query = $this->Master_Model->_select("upload_column_mapping_rule", array("type" => 3), array("*"), false)->data;
				$branchData = $this->Master_Model->_select('branch_account_setup', array('company_id' => $company_id, 'branch_id' => $branch_id, 'status' => 1), '*', false)->data;
				$rule_array = array();
				$coulmnName_array = array();
				$mandatory_array = array();
				foreach ($query as $row) {
					$rule_array[$row->Tablecolumn_name] = $row->rule;
					$coulmnName_array[$row->Tablecolumn_name] = $row->column_name;
					$mandatory_array[$row->Tablecolumn_name] = $row->mandatoryRule;
				}

				$whiteSpaceArray = array();
				$SpecialCharacterArray = array();
				$NoTextArray = array();
				$NoCommaArray = array();
				$blankArray = array();
				$uploadDataArray = array();
				$insertDataArray = array();
				$batchdataArray = array();
				$is_error = false;
				$nonNumeric = 0;
				$umatched = 0;
				$matched = 0;
				$alpha = 'A';
				$table = '<table class="table">
							<thead class="tableHead">
								<tr><th>1</th>';
				foreach ($mappingArray as $columnNumber) {
					$columnName = $columnNumber;
					$table .= '<th>' . $columnName . '(' . $alpha . ')</th>';
					$alpha++;
				}
				$table .= '</tr>
							</thead>
							<tbody>';
				for ($i = 2; $i <= $highestRow; $i++) {

					$batchdata = array(
						"created_by" => $user_id,
						"created_on" => date('Y-m-d H:i:s'),
						"company_id" => $company_id,
						"branch_id" => $branch_id
					);
					$col = 'A';
					$um = 0;
					$table_td = '';
					$table_td .= '<td>' . $i . '</td>';
					foreach ($mappingArray as $columnNumber) {

						$rule = explode(",", $rule_array[$columnNumber]);
						$columnName = $columnNumber;
						$value = $object->getActiveSheet()->getCell($col . $i)->getValue();
						$color = '';


						if (in_array("1", $rule)) { //NO SPACE
							if (preg_match('/\s/', $value)) {
								array_push($whiteSpaceArray, $col . $i);
								$value = preg_replace('/\s/', '', $value);
							}
						}

						if (in_array("4", $rule)) { //NO COMMA
							$searchForValue = ',';
							if (strpos($value, $searchForValue) !== false) {
								array_push($NoCommaArray, $col . $i);
								$value = str_replace(',', '', $value);
							}
						}
						if (in_array("2", $rule)) { // NO SPECIAL CHARACTER
							if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $value)) {
								array_push($SpecialCharacterArray, $col . $i);
								$value = preg_replace('/[^A-Za-z0-9\-]/', '', $value);
							}
						}
						if (in_array("3", $rule)) { // NO TEXT
							if (!is_numeric($value)) {
								if ($value != "") {
									array_push($NoTextArray, $col . $i);
									$is_error = true;
									$color = 'style="background-color:#f06969;color:black"';
									$nonNumeric++;
								} else {
									$value = '';
								}
							}
						}
						if ($mandatory_array[$columnNumber] == 1 && $value == "") // Mandatory Field
						{
							array_push($blankArray, $col . $i);
							$color = 'style="background-color:#f06969;color:black"';
						}
						$batchdata[$columnName] = $value;//insertdata array
						$col++;

						$table_td .= '<td ' . $color . '>' . $value . '</td>';

					}
					array_push($batchdataArray, $batchdata);
					$rowColor = '';
					$table .= '<tr ' . $rowColor . '>' . $table_td . '</tr>';

				}

				function filter_account_number($data)
				{
					return $data->account_number;
				}

				$branchData = array_map('filter_account_number', $branchData);
				foreach ($batchdataArray as $batch) {

					if ($batch['account_number'] != null) {
						if (in_array($batch['account_number'], $branchData)) {
							array_push($uploadDataArray, $batch);
						} else {
							array_push($insertDataArray, $batch);
						}
					}
				}

				$table .= '</tbody>
						</table>';
				if ($unmatchStatus == 0) {
					$is_error = $is_error;
				} else {
					$is_error = false;
				}

				if ($is_error == true) {
					$response['whiteSpace'] = implode(',', array_unique($whiteSpaceArray));
					$response['SpecialCharacter'] = implode(',', array_unique($SpecialCharacterArray));
					$response['NoText'] = implode(',', array_unique($NoTextArray));
					$response['NoComma'] = implode(',', array_unique($NoCommaArray));
					$response['status'] = 201;
					$response['type'] = 1;
					$response['body'] = 'Data not Matched';
					$response['table'] = $table;
					$response['NonNumeric'] = $nonNumeric;//0
					$response['TotalRowUpload'] = $highestRow;
					$response['MatchedData'] = $matched;
					$response['UmatchedData'] = $umatched;
					$response['MandatoryData'] = implode(',', array_unique($blankArray));
				} else {

					//insert Data INTO DATABASE
					$upload_path = "uploads";
					$combination = 2;
					$name_input = "userfile";
					$result = $this->Global_model->upload_multiple_file1($upload_path, $name_input, $combination);
					if ($result['status'] == 200) {
						$input_data = $upload_path . '/' . $result['body'];
						try {
							$this->db->trans_start();
							if (!empty($uploadDataArray)) {
								$this->db->update_batch('branch_account_setup', $uploadDataArray, 'account_number');
							}
							if (!empty($insertDataArray)) {
								$this->db->insert_batch('branch_account_setup', $insertDataArray);
							}
							if ($this->db->trans_status() === FALSE) {
								$this->db->trans_rollback();
								$result = false;
								$body_message = 'something went wrong';
							} else {
								$this->db->trans_commit();
								$result = true;
								$body_message = 'Data Uploaded';
							}
							$this->db->trans_complete();
						} catch (Exception $exc) {
							$result = false;
							$this->db->trans_rollback();
							$this->db->trans_complete();
						}

						if ($result == true) {
							$response['status'] = 200;
							$response['body'] = 'Data Uploaded Successfully';
						} else {
							$response['status'] = 201;
							$response['body'] = 'File Not Uploaded';
							$response['type'] = 2;
						}
					} else {
						$response['status'] = 201;
						$response['body'] = 'File Not Uploaded';
						$response['type'] = 2;
					}
				}
			}
		} else {
			$response['status'] = 201;
			$response['body'] = 'Required Parameter Missing';
			$response['type'] = 2;
		}
		echo json_encode($response);
	}

	function SaveExcelConsolidate()
	{

		if (!is_null($this->input->post('count'))) {
			$count = $this->input->post('count');
			$insertID = $this->input->post('insertID');
			$branchID = $this->input->post('branchID');
			$year = $this->input->post('year');
			$quarter = $this->input->post('quarter');
			$unmatchStatus = $this->input->post('unmatchStatus');
			$mappingArray = array();
			for ($i = 0; $i <= $count; $i++) {
				if (!is_null($this->input->post('databaseColumn' . $i))) {
					if ($this->input->post('databaseColumn' . $i) != "") {
						array_push($mappingArray, $this->input->post('databaseColumn' . $i));
					}
				}
			}

			if ($count != count($mappingArray)) {
				$response['status'] = 201;
				$response['body'] = 'Please Fill All Field';
				$response['type'] = 2;
				echo json_encode($response);
				exit();
			} else {
				$path = $_FILES["userfile"]["tmp_name"];
				$this->load->library('excel');
				$object = PHPExcel_IOFactory::load($path);
				$worksheet = $object->getActiveSheet();
				$excelname = $_FILES["userfile"]["name"];
				$user_id = $this->session->userdata('user_id');
				$company_id = $this->session->userdata('company_id');
				$branch_id = $this->session->userdata('branch_id');

				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				$highestColumnNumber = PHPExcel_Cell::columnIndexFromString($highestColumn);
				$check_entry = $this->db->where(array('quarter' => $quarter, 'year' => $year, 'company_id' => $company_id))->get('excelsheet_master_data')->row();
				// print_r($branch_id);exit();
				$query = $this->Master_Model->_select("upload_column_mapping_rule", array("type" => 4), array("*"), false)->data;
				// print_r($mappingArray);exit();
				$rule_array = array();
				$coulmnName_array = array();
				$mandatory_array = array();
				foreach ($query as $row) {
					$rule_array[$row->column_name] = $row->rule;
					$coulmnName_array[$row->column_name] = $row->column_name;
					$mandatory_array[$row->column_name] = $row->mandatoryRule;
				}
				$company_id = $this->session->userdata('company_id');
				$AccountArrayarray = array();
				$queryGetBranchArray = $this->Master_Model->_select("branch_account_setup", array("parent_account_number !=" => "", "parent_account_number !=" => null, "company_id" => $company_id), array("account_number"), false)->data;
				foreach ($queryGetBranchArray as $r1) {
					$AccountArrayarray[] = $r1->account_number;
				}

				$whiteSpaceArray = array();
				$SpecialCharacterArray = array();
				$NoTextArray = array();
				$NoCommaArray = array();
				$blankArray = array();
				$uploadDataArray = array();
				$is_error = false;
				$nonNumeric = 0;
				$umatched = 0;
				$matched = 0;
				$alpha = 'A';
				// var_dump($coulmnName_array);
				// exit();
				$table = '<table class="table">
							<thead class="tableHead">
								<tr><th>1</th>';
				foreach ($mappingArray as $columnName) {
					$columnName = $coulmnName_array[$columnName];
					$table .= '<th>' . $columnName . '(' . $alpha . ')</th>';
					$alpha++;
				}
				$data1 = array();
				$data2 = array();
				$data3 = array();
				$data1_a = array();
				$data2_a = array();
				$data3_a = array();


				$arrOB = array();
				$arrDr = array();
				$arrCr = array();
				$arrTotal = array();
				$arrOB2 = array();
				$arrDr2 = array();
				$arrCr2 = array();
				$arrTotal2 = array();

				$glAc_ind = array();
				$glAc_us = array();
				$glAc_ifrs = array();
				// foreach ($AccountArrayarray as $itemData){
				// 	$arrOB[$itemData][]=$itemData[1];
				// 	$arrDr[$itemData][]=$itemData[2];
				// 	$arrCr[$itemData][]=$itemData[3];
				// 	$arrTotal[$itemData][]=$itemData[4];
				// }
				// var_dump($worksheet);exit();
				$glac_mapping = $this->db->query('SELECT main_gl_number,1 as type FROM main_account_setup_master where company_id =' . $company_id . ' union SELECT main_gl_number,2 as type FROM main_account_setup_master_us where company_id = ' . $company_id . ' union SELECT main_gl_number,3 as type FROM main_account_setup_master_ifrs where company_id = ' . $company_id)->result();

				foreach ($glac_mapping as $gl_value) {
					$glAc_ind[$gl_value->main_gl_number][] = $gl_value->type;
				}

				$table .= '</tr>
							</thead>
							<tbody>';
				foreach ($mappingArray as $columnName) {
					$columnName = $coulmnName_array[$columnName];
					$table .= '<th>' . $columnName . '(' . $alpha . ')</th>';
					$alpha++;
				}
				$data1 = array();
				$data2 = array();
				$data3 = array();
				$data1_a = array();
				$data2_a = array();
				$data3_a = array();


				// $arrOB = array();
				// $arrDr = array();
				// $arrCr = array();
				// $arrTotal = array();

				$glAc_ind = array();
				$glAc_us = array();
				$glAc_ifrs = array();
				// foreach ($AccountArrayarray as $itemData){
				// 	$arrOB[$itemData][]=$itemData[1];
				// 	$arrDr[$itemData][]=$itemData[2];
				// 	$arrCr[$itemData][]=$itemData[3];
				// 	$arrTotal[$itemData][]=$itemData[4];
				// }
				// var_dump($worksheet);exit();
				$glac_mapping = $this->db->query('SELECT main_gl_number,1 as type FROM main_account_setup_master where company_id =' . $company_id . ' union SELECT main_gl_number,2 as type FROM main_account_setup_master_us where company_id = ' . $company_id . ' union SELECT main_gl_number,3 as type FROM main_account_setup_master_ifrs where company_id = ' . $company_id)->result();

				foreach ($glac_mapping as $gl_value) {
					$glAc_ind[$gl_value->main_gl_number][] = $gl_value->type;
				}

				$table .= '</tr>
							</thead>
							<tbody>';
				for ($i = 2; $i <= $highestRow; $i++) {

					if (!empty($check_entry)) {
						$batchdata = array("year" => $check_entry->year,
							"quarter" => $check_entry->quarter,
							"user_id" => $user_id,
							"created_by" => $user_id,
							"created_on" => date('Y-m-d H:i:s'),
							"branch_id" => $branchID,
							"company_id" => $company_id,
							"sheet_master_id" => $insertID
						);
					}
					$col = 'A';
					$um = 0;
					$table_td = '';
					$table_td .= '<td>' . $i . '</td>';


					// var_dump($mappingArray);
					foreach ($mappingArray as $columnNumber) {

						$rule = explode(",", $rule_array[$columnName]);
						$columnName = $coulmnName_array[$columnName];
						$value = $object->getActiveSheet()->getCell($col . $i)->getValue();
						$valueForKey = $object->getActiveSheet()->getCell('A' . $i)->getValue();
						$color = '';

						if (in_array("1", $rule)) { //NO SPACE
							if (preg_match('/\s/', $value)) {
								array_push($whiteSpaceArray, $col . $i);
								$value = preg_replace('/\s/', '', $value);
							}
						}

						if (in_array("4", $rule)) { //NO COMMA
							$searchForValue = ',';
							if (strpos($value, $searchForValue) !== false) {
								array_push($NoCommaArray, $col . $i);
								$value = str_replace(',', '', $value);
							}
						}
						if (in_array("2", $rule)) { // NO SPECIAL CHARACTER
							if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $value)) {
								array_push($SpecialCharacterArray, $col . $i);
								$value = preg_replace('/[^A-Za-z0-9\-]/', '', $value);
							}
						}
						if (in_array("3", $rule)) { // NO TEXT
							if (!is_numeric($value)) {
								if ($value != "") {
									array_push($NoTextArray, $col . $i);
									$is_error = true;
									$color = 'style="background-color:#f06969;color:black"';
									$nonNumeric++;
								} else {
									$value = '';
								}
							}
						}
						if ($mandatory_array[$columnNumber] == 1 && $value == "") // Mandatory Field
						{
							array_push($blankArray, $col . $i);
							$color = 'style="background-color:#f06969;color:black"';
						}
						if ($col == 'B') {
							$arrOB[$valueForKey][] = $value;
						}
						if ($col == 'C') {
							$arrDr[$valueForKey][] = $value;
						}
						if ($col == 'D') {
							$arrCr[$valueForKey][] = $value;
						}
						if ($col == 'E') {
							$arrTotal[$valueForKey][] = $value;
						}
						if ($col == 'F') {
							$arrOB2[$valueForKey][] = $value;
						}
						if ($col == 'G') {
							$arrDr2[$valueForKey][] = $value;
						}
						if ($col == 'H') {
							$arrCr2[$valueForKey][] = $value;
						}
						if ($col == 'I') {
							$arrTotal2[$valueForKey][] = $value;
						}

						$batchdata[$columnName] = $value;//insertdata array
						$col++;

						$table_td .= '<td ' . $color . '>' . $value . '</td>';
						if ($columnNumber == 1) {
							if (!in_array($value, $AccountArrayarray)) {
								$um = 1;
							}
						}
					}
					$rowColor = '';
					if ($um == 1) {
						$umatched++;
						$is_error = true;
						$rowColor = 'style="background-color:#f06969;color:black"';
					} else {
						$matched++;
					}
					$table .= '<tr ' . $rowColor . '>' . $table_td . '</tr>';

					array_push($uploadDataArray, $batchdata);
				}
				$table .= '</tbody>
						</table>';

				foreach ($arrOB as $key => $value) {
					if (array_key_exists($key, $glAc_ind)) {

						if (in_array(1, $glAc_ind[$key])) {
							$data1a = array(
								'account_number' => $key,
								'final_total' => array_sum($arrTotal[$key]),
								'opening_balance' => array_sum($arrOB[$key]),
								'debit' => array_sum($arrDr[$key]),
								'credit' => array_sum($arrCr[$key]),
								'total' => array_sum($arrTotal[$key]),

								'opening_balance_1' => array_sum($arrOB2[$key]),
								'debit_1' => array_sum($arrDr2[$key]),
								'credit_1' => array_sum($arrCr2[$key]),
								'total_1' => array_sum($arrTotal2[$key]),

								'year' => $year,
								'month' => $quarter,
								'create_on' => date('Y-m-d H:i:s'),
								'create_by' => $user_id,
								'status' => 1,
								'company_id' => $company_id,
								'consolidation_type' => 2,
							);
							array_push($data1, $data1a);

							$data1b = array(
								'account_number' => $key,
								'final_total' => array_sum($arrTotal[$key]),
								'month' => $quarter,
								'year' => $year,
								'create_on' => date('Y-m-d H:i:s'),
								'create_by' => $user_id,
								'status' => 1,
								'company_id' => $company_id,
								'total' => array_sum($arrTotal[$key]),
							);
							array_push($data1_a, $data1b);
						}
						if (in_array(2, $glAc_ind[$key])) {
							$data1a = array(
								'account_number' => $key,
								'final_total' => array_sum($arrTotal[$key]),
								'opening_balance' => array_sum($arrOB[$key]),
								'debit' => array_sum($arrDr[$key]),
								'credit' => array_sum($arrCr[$key]),
								'total' => array_sum($arrTotal[$key]),

								'opening_balance_1' => array_sum($arrOB2[$key]),
								'debit_1' => array_sum($arrDr2[$key]),
								'credit_1' => array_sum($arrCr2[$key]),
								'total_1' => array_sum($arrTotal2[$key]),

								'year' => $year,
								'month' => $quarter,
								'create_on' => date('Y-m-d H:i:s'),
								'create_by' => $user_id,
								'status' => 1,
								'company_id' => $company_id,
								'consolidation_type' => 2,
							);
							array_push($data2, $data1a);


							$data2b = array(
								'account_number' => $key,
								'final_total' => array_sum($arrTotal[$key]),
								'month' => $quarter,
								'year' => $year,
								'create_on' => date('Y-m-d H:i:s'),
								'create_by' => $user_id,
								'status' => 1,
								'company_id' => $company_id,
								'total' => array_sum($arrTotal[$key]),
							);
							array_push($data2_a, $data2b);
						}
						if (in_array(3, $glAc_ind[$key])) {
							$data1a = array(
								'account_number' => $key,
								'final_total' => array_sum($arrTotal[$key]),
								'opening_balance' => array_sum($arrOB[$key]),
								'debit' => array_sum($arrDr[$key]),
								'credit' => array_sum($arrCr[$key]),
								'total' => array_sum($arrTotal[$key]),

								'opening_balance_1' => array_sum($arrOB2[$key]),
								'debit_1' => array_sum($arrDr2[$key]),
								'credit_1' => array_sum($arrCr2[$key]),
								'total_1' => array_sum($arrTotal2[$key]),

								'year' => $year,
								'month' => $quarter,
								'create_on' => date('Y-m-d H:i:s'),
								'create_by' => $user_id,
								'status' => 1,
								'company_id' => $company_id,
								'consolidation_type' => 2,
							);
							array_push($data3, $data1a);


							$data3b = array(
								'account_number' => $key,
								'final_total' => array_sum($arrTotal[$key]),
								'month' => $quarter,
								'year' => $year,
								'create_on' => date('Y-m-d H:i:s'),
								'create_by' => $user_id,
								'status' => 1,
								'company_id' => $company_id,
								'total' => array_sum($arrTotal[$key]),
							);
							array_push($data3_a, $data3b);
						}
					}
				}
				if (!empty($data1) || !empty($data2) || !empty($data3)) {
					$this->db->where(array('year' => $year, 'month' => $quarter, 'company_id' => $company_id))->delete('consolidate_report_transaction');
					$this->db->where(array('year' => $year, 'month' => $quarter, 'company_id' => $company_id))->delete('consolidate_report_transaction_us');
					$this->db->where(array('year' => $year, 'month' => $quarter, 'company_id' => $company_id))->delete('consolidate_report_transaction_ifrs');


					$this->db->where(array('year' => $year, 'month' => $quarter, 'company_id' => $company_id))->delete('consolidate_report_all_data_ind');
					$this->db->where(array('year' => $year, 'month' => $quarter, 'company_id' => $company_id))->delete('consolidate_report_all_data_us');
					$this->db->where(array('year' => $year, 'month' => $quarter, 'company_id' => $company_id))->delete('consolidate_report_all_data_ifrs');
					if (!empty($data1)) {
						$insert_batch1 = $this->db->insert_batch("consolidate_report_all_data_ind", $data1);
						$insert_batch4 = $this->db->insert_batch("consolidate_report_transaction", $data1_a);
					}
					if (!empty($data2)) {
						$insert_batch2 = $this->db->insert_batch("consolidate_report_all_data_us", $data2);
						$insert_batch5 = $this->db->insert_batch("consolidate_report_transaction_us", $data2_a);
					}
					if (!empty($data3)) {
						$insert_batch3 = $this->db->insert_batch("consolidate_report_all_data_ifrs", $data3);
						$insert_batch6 = $this->db->insert_batch("consolidate_report_transaction_ifrs", $data3_a);
					}
					if ($insert_batch1 == true || $insert_batch2 == true || $insert_batch3 == true) {
						$response['status'] = 200;
						$response['body'] = "Data uploaded Successfully";
					} else {
						$response['status'] = 201;
						$response['body'] = "Failed To uplaod";
					}
				} else {
					$response['status'] = 201;
					$response['body'] = "No GL Account Found";
				}
			}
		} else {
			$response['status'] = 201;
			$response['body'] = 'Required Parameter Missing';
			$response['type'] = 2;
		}
		echo json_encode($response);
	}

	function ClearAllFinancialData()
	{
		$insertID = $this->input->post('insertID');
		$branchID = $this->input->post('branchID');
		if (!empty($insertID) || !is_null($insertID)) {
			$where = array("sheet_master_id" => $insertID, "branch_id" => $branchID);
			$delete = $this->db->delete('upload_financial_data', $where);
			if ($delete == true) {
				$response['status'] = 200;
				$response['body'] = 'Required Parameter Missing';
			}
		} else {
			$response['status'] = 201;
			$response['body'] = 'Required Parameter Missing';
		}
		echo json_encode($response);

	}
	public function uploadAllFiles()
	{
		$this->load->view("user/uploadedAllFiles", array("title" => "User Upload"));
	}
	public function getAllUploadedFiles()
	{
		$branch_permission = $this->session->userdata('branch_permission');
		$company = $this->session->userdata("company_id");
		$array=array();
		if(!is_null($branch_permission)){
			$array=explode(",",$branch_permission);
		}
		$resultObject=$this->Master_Model->_rawQuery('select *,(select name from branch_master where id=branch_id) as branch_name from excelsheet_master_data where company_id="'.$company.'" and name is not null and name!="" and status=1 and branch_id in ('.$branch_permission.')');
//		print_r($resultObject);exit();
		$country_master = $this->Master_Model->getQuarter();
		$tableRows = array();
		$i = 1;
		if ($resultObject->totalCount > 0) {
			foreach ($resultObject->data as $order) {
				$button='<a href="' . base_url('downloadFile') . "?f=" . base64_encode($order->name) . '" class="d-flex flex-fill ml-2" download>
									 						 <i class="fa fa-download btn-icon-wrapper"></i>
									 						 </a> ';
				$fileName=substr($order->name, (strpos($order->name, '_') ?: -1) + 1);

				array_push($tableRows, array($i, $order->branch_name,$fileName, $order->year, $country_master[$order->quarter],$order->id,$button,''));
				$i++;
			}
		}
		$resultObject1=$this->Master_Model->_rawQuery('select *,(select name from branch_master where id=branch_id) as branch_name from other_uploaded_files where company_id="'.$company.'" and file is not null and file!="" and status=1 and branch_id in ('.$branch_permission.')');
		if ($resultObject1->totalCount > 0) {
			foreach ($resultObject1->data as $fileData) {
				$button='<a href="' . base_url('downloadFile') . "?f=" . base64_encode($fileData->file) . '" class="d-flex flex-fill ml-2" download>
									 						 <i class="fa fa-download btn-icon-wrapper"></i>
									 						 </a> ';
				$fileName=substr($fileData->file, (strpos($fileData->file, '_') ?: -1) + 1);
				array_push($tableRows, array($i, $fileData->branch_name,$fileName, $fileData->year, $country_master[$fileData->month],$fileData->id,$button,$fileData->desc));
				$i++;
			}
		}
		$results = array(
			"draw" => 1,
			"recordsTotal" => count($tableRows),
			"recordsFiltered" => count($tableRows),
			"data" => $tableRows
		);

		echo json_encode($results);
	}
	public function ExportToTableDirectValidation()
	{
		$year = $this->input->post('year');
		$quarter = $this->input->post('quarter');
		$fileType = $this->input->post('fileType');
		$company_id = $this->session->userdata('company_id');
		$mimes = array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel', 'text/xls');
		if (!in_array($_FILES['userfile']['type'][0], $mimes)) {
			$response['status'] = 201;
			$response['body'] = "Upload Excel file.";
			echo json_encode($response);
			exit;
		}
		$CheckBlockwhere = array('company_id' => $company_id, 'year' => $year, 'month' => $quarter);
		$checkPermission = $this->Master_Model->checkBlockYearMonth($CheckBlockwhere);
		if ($checkPermission == true) {

			if ($this->session->userdata('user_type') == 2) {
				$branch_id = $this->input->post('branchID');
			} else {
				$branch_id = $this->session->userdata('branch_id');
			}
			$company_id = $this->session->userdata('company_id');
			$check_approve_not_approve = $this->db->where(array('year' => $year, 'quarter' => $quarter, 'branch_id' => $branch_id, 'template_id' => 1, 'approve_status' => 1))->get('excelsheet_master_data')->row();
			$cnt = 1;
			if (empty($check_approve_not_approve)) {
				$response['file_already_exist']=0;
				$check_entry = $this->db->where(array('year' => $year, 'quarter' => $quarter, 'branch_id' => $branch_id, 'template_id' => 1))->get('excelsheet_master_data')->row();
				if (!empty($check_entry)) {
					$id = $check_entry->id;
					$response['status'] = 200;
					$response['id'] = $id;
					$response['branch_id'] = $check_entry->branch_id;
					$response['type'] = 1;
					if($check_entry->name!=null && $check_entry->name !="")
					{
						$response['file_already_exist']=1;
					}
				} else {
					$id = '';
					$master_data = array(
						'created_on' => date('Y-m-d H:i:s'),
						'created_by' => $this->session->userdata('user_id'),
						'status' => 1,
						'year' => $year,
						'quarter' => $quarter,
						'branch_id' => $branch_id,
						'company_id' => $company_id,
						'template_id' => 1);
					$insert = $this->db->insert('excelsheet_master_data', $master_data);
					$insert_id = $this->db->insert_id();
					$id = $insert_id;
				}

					$path = $_FILES["userfile"]["tmp_name"][0];
					$this->load->library('excel');
					$object = PHPExcel_IOFactory::load($path);
					$worksheet = $object->getActiveSheet();
					$excelname = $_FILES["userfile"]["name"][0];

					$highestRow = $worksheet->getHighestRow();
					$highestColumn = $worksheet->getHighestColumn();
					$highestColumnNumber = PHPExcel_Cell::columnIndexFromString($highestColumn);
					// print_r($highestColumn);exit();
					// $options=$this->getExcelDatabaseColumn(1);
					$resultObject = $this->Master_Model->_select('upload_column_mapping_rule', array('type' => 1), array('id', 'column_name'), false);
					$mainArray = array();
					$template = '';
					$cnt = 0;
					for ($i = 'A'; $i <= $highestColumn; $i++) {
						$column = $object->getActiveSheet()->getCell($i . "1")->getValue();
						array_push($mainArray, $column);
						$template .= '<div class="col-md-6 m-t-5">
						<div class="col-md-6">
							<input type="text" readonly name="excelColumn' . $cnt . '" id="excelColumn' . $cnt . '" class="form-control" value="' . $column . '">
						</div>
						<div class="col-md-6">
							<select name="databaseColumn' . $cnt . '" id="databaseColumn' . $cnt . '" class="form-control">';
						if ($resultObject->totalCount > 0) {
							foreach ($resultObject->data as $value) {
								$selected = '';
								if (strpos($value->column_name, $column) !== false) {
									$selected = 'selected';
								}
								$template .= '<option value="' . $value->id . '" ' . $selected . '>' . $value->column_name . '</option>';
							}
						}
						$template .= '</select>
						</div>
				   </div>';
						$cnt++;
					}
						$response['status'] = 200;
						$response['id'] = $id;
						$response['branch_id'] = $branch_id;
						$response['type'] = 2;
						$response['count'] = $cnt;
						$response['body'] = $template;
			} else {
				$response['status'] = 201;
				$response['body'] = 'Already approved. You can not upload again.';
			}
		} else {
			$response['status'] = 201;
			$response['body'] = 'You can not upload data for this year and month.';
		}
		echo json_encode($response);
	}
	public function uploadOtherFiles()
	{
		if(!is_null($this->input->post('branch_id')) && !is_null($this->input->post('year')) && !is_null($this->input->post('quarter'))) {
			$branch_id=$this->input->post('branch_id');
			$desc=$this->input->post('desc');
			$year=$this->input->post('year');
			$month=$this->input->post('quarter');
			$user_id=$this->session->userdata('user_id');
			$company_id=$this->session->userdata('company_id');
			$upload_path = "uploads";
			$combination = 2;
			$name_input = "userfile";
			$result = $this->AwsModel->upload_multiple_file_new($upload_path, $name_input, $combination);
//					print_r($result);exit();
			if ($result['status'] == 200) {
				$input_data = $result['body'][0];
				try {
					$this->db->trans_start();

					$uploadDataArray = array('branch_id' => $branch_id,
										'month'=>$month,
										'year'=>$year,
										'created_by'=>$user_id,
										'created_on'=>date('Y-m-d H:i:s'),
										'desc'=>$desc,
										'company_id'=>$company_id,
										'status'=>1,
										'file'=>$input_data);
					$this->db->insert('other_uploaded_files', $uploadDataArray);


				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					$result = false;
					$body_message = 'something went wrong';
				} else {
					$this->db->trans_commit();
					$result = true;
					$body_message = 'Data Uploaded';
				}
				$this->db->trans_complete();
			} catch (Exception $exc) {
					$result = false;
					$this->db->trans_rollback();
					$this->db->trans_complete();
				}

				if ($result == true) {
					$response['status'] = 200;
					$response['body'] = 'Data Uploaded Successfully';
				} else {
					$response['status'] = 201;
					$response['body'] = 'File Not Uploaded';
					$response['type'] = 2;
				}
			} else {
				$response['status'] = 201;
				$response['body'] = 'File Not Uploaded';
				$response['type'] = 2;
			}
		}
		echo json_encode($response);
	}
}
