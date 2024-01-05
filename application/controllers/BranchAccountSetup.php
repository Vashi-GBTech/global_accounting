<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property  Master_Model Master_Model
 * @property BranchAccountSetup_Model BranchAccountSetup_Model
 */
class BranchAccountSetup extends CI_Controller
{
	public function index()
	{
		$this->load->view("Admin/branch_account/view_branch_account", array("title" => "Subsidiary Account Setup"));
	}

	public function excel()
	{
		$this->load->view("Admin/branch_account/view_excel", array('title' => 'Excel'));
	}

	public function DragDrop()
	{
		$branch_id = $this->input->get('id');
		$result['branch_id'] = $branch_id;
		$result['title'] = "Map Accounts";
		$this->load->view('Admin/branch_account/Mapping', $result);
	}

	public function getParentMappingData()
	{
		$company_id = $this->session->userdata('company_id');
		$branch_id = $this->input->post('branch_id');
		$type = $this->input->post('type');
		$type0 = $this->input->post('type0');
		$type1 = $this->input->post('type1');
		$table = 'main_account_setup_master';
		$branch_where = array('company_id' => $company_id, 'branch_id' => $branch_id, 'status' => 1, '(parent_account_number = "" or  parent_account_number IS NULL)<>' => 0, 'is_ignore' => 0);
		$unmatch_where = array('company_id' => $company_id, 'branch_id' => $branch_id, 'is_ignore' => 1, 'status' => 1);
		if ($type == 2) {
			$table = 'main_account_setup_master_us';
			$branch_where = array('company_id' => $company_id, 'branch_id' => $branch_id, 'status' => 1, '(parent_account_number_us = "" or  parent_account_number_us IS NULL)<>' => 0, 'is_ignore' => 0);
			$unmatch_where = array('company_id' => $company_id, 'branch_id' => $branch_id, 'is_ignore' => 1, 'status' => 1);

		}
		if ($type == 3) {
			$table = 'main_account_setup_master_ifrs';
			$branch_where = array('company_id' => $company_id, 'branch_id' => $branch_id, 'status' => 1, '(parent_account_number_ifrs = "" or  parent_account_number_ifrs IS NULL)<>' => 0, 'is_ignore' => 0);
			$unmatch_where = array('company_id' => $company_id, 'branch_id' => $branch_id, 'status' => 1, 'is_ignore' => 1);
		}
		$where = 'company_id = "' . $company_id . '" and status = 1';
		$option = "";
		if ($type0 != -1) {
			$where .= ' AND type0 = "' . $type0 . '"';
		}
		if ($type1 != -1 && $type1 != "" && $type1 != 'null') {
			$where .= ' AND type1 = "' . $type1 . '"';
		}

		if ($type0 == 'BS') {
			$option = '<option value="-1" selected>Select Type</option>'
				. '<option value="EQUITY AND LIABILITIES">Equity & Liability</option>'
				. '<option value="ASSETS">Assets</option>';
		}
		if ($type0 == 'PL') {
			$option = '<option value="-1" selected>Select Type</option>'
				. '<option value="Revenue">Revenue</option>'
				. '<option value="Expenses">Expenses</option>';
		}
		$main_data = array();
		$mainData = $this->Master_Model->_select($table, $where, array('main_gl_number', 'name'), false, null, null, 'id asc')->data;
		$branchData = $this->Master_Model->_select('branch_account_setup', array('company_id' => $company_id, 'branch_id' => $branch_id, 'is_ignore' => 0, 'status' => 1), array('*'), false)->data;
		$unmatched_data = $this->Master_Model->_select('branch_account_setup', $branch_where, array('detail', 'account_number'), false)->data;
		$ignore_data = $this->Master_Model->_select('branch_account_setup', $unmatch_where, array('detail', 'account_number'), false)->data;
		if ($mainData != null) {
			foreach ($mainData as $main) {
				if ($branchData != null) {
					foreach ($branchData as $branch) {
						$parent = $branch->parent_account_number;
						if ($type == 2) {
							$parent = $branch->parent_account_number_us;
						}
						if ($type == 3) {
							$parent = $branch->parent_account_number_ifrs;
						}
						if ($parent == $main->main_gl_number) {
							$main_data[$main->main_gl_number . "||" . $main->name][] = $branch->account_number . "||" . $branch->detail;
						} else {
							$main_data[$main->main_gl_number . "||" . $main->name][] = array();
						}
					}
				} else {
					$main_data[$main->main_gl_number . "||" . $main->name][] = array();
				}
			}
		}
		asort($main_data);
		$branch_div = "";
		$ignore_div = "";
		$main_div = "";

		foreach ($main_data as $key => $main) {
			$main_account = explode("||", $key);
			if (count($main_account) >= 2) {
				$main_id = $main_account[0];
				$main_name = $main_account[1];
				$name1 = ucwords(strtolower($main_name));
				$main_div .= '<div class="col-md-4 col_type1">'
					. '<div class="parent_list">'
					. '<div class="row main_child_div"><div class="col-md-12 col_type01">'
					. '<div class="col-md-9"><label>' . $name1 . '</label></div>'
					. '<div class="col-md-3"><span onclick="minimize(' . $main_id . ')" style="float: right"><i class="fa fa-window-minimize"></i></span></div></div></div>'
					. '<div id="' . $main_id . '" style="height: 200px;overflow-y: auto;scrollbar-gutter:stable;" class="droptrue ui-sortable parent' . $main_id . ' p-0">';

				foreach ($main as $value) {
					if ($value != null) {
						$branch_account = explode("||", $value);
						if (count($branch_account) >= 2) {
							$branch_id = $branch_account[0];
							$branch_name = $branch_account[1];
							$main_div .= '<div id="' . $branch_id . '" data-branch_id="' . $branch_id . '" class="child_list childlist">' . $branch_name . '</div>';
						}
					}
				}
				$main_div .= '</div>'
					. '</div>'
					. '</div>';
			}
		}

		if ($unmatched_data != null) {
			foreach ($unmatched_data as $branch) {
				if ($branch->account_number != null && $branch->account_number != "" && $branch->detail != null && $branch->detail != "") {
					$branch_no = $branch->account_number;
					$detail = $branch->detail;
					$branch_div .= '<div id ="' . $branch_no . '" data-branch_id ="' . $branch_no . '" class="child_list">' . $detail . '</div>';
//
				}
			}
		}

		if ($ignore_data != null) {
			foreach ($ignore_data as $ignore) {
				$ignore_div .= '<div id="' . $ignore->account_number . '" data-branch_id="' . $ignore->account_number . '" class="child_list childlist">' . $ignore->detail . '</div>';

			}
		}
		$result['mainData'] = $main_div;
		$result['branchData'] = $branch_div;
		$result['ignoreData'] = $ignore_div;
		$result['option'] = $option;
		$result['type1'] = $type1;
		$result['status'] = 200;
		// print_r($main_div);exit();
		echo json_encode($result);
	}

	public function UpdateParentBranch()
	{
		$company_id = $this->session->userdata('company_id');
		$branch_no = $this->input->post('branch_no');
		$type = $this->input->post('type');
		$main_id = $this->input->post('main_id');
		$branchids = $this->input->post('branch_id');
		$branch_id = json_decode($branchids);
		$set = array('parent_account_number' => null, 'is_ignore' => 0);
		$set1 = array('parent_account_number' => $main_id, 'is_ignore' => 0);
		if ($type == 2) {
			$set = array('parent_account_number_us' => null, 'is_ignore' => 0);
			$set1 = array('parent_account_number_us' => $main_id, 'is_ignore' => 0);
		}
		if ($type == 3) {
			$set = array('parent_account_number_ifrs' => null, 'is_ignore' => 0);
			$set1 = array('parent_account_number_ifrs' => $main_id, 'is_ignore' => 0);
		}
		// print_r($set1);exit();
		if (!empty($branch_id)) {
			foreach ($branch_id as $row) {
				if ($main_id == 'sortable1') {
					$update_branch = $this->Master_Model->_update('branch_account_setup', $set, array('account_number' => $row, 'company_id' => $company_id, 'branch_id' => $branch_no));
				} else if ($main_id == 'ignore') {
					$update_branch = $this->Master_Model->_update('branch_account_setup', array('is_ignore' => 1), array('account_number' => $row, 'company_id' => $company_id, 'branch_id' => $branch_no));
				} else {
					$update_branch = $this->Master_Model->_update('branch_account_setup', $set1, array('account_number' => $row, 'company_id' => $company_id, 'branch_id' => $branch_no));
				}
			}
			if ($update_branch) {
				$response['status'] = 200;
				$response['data'] = $update_branch;
				$response['message'] = 'Branch Account Mapped';
			} else {
				$response['status'] = 201;
				$response['message'] = 'Branch Account Not Mapped';
			}
		} else {
			$response['status'] = 201;
			$response['message'] = 'No Branches to Map';
		}
		echo json_encode($response);
	}

	public function saveExcelData()
	{
		$branch_id = $this->input->get('id');
		$acc_no = $this->input->post('account_no');
		$acc_details = $this->input->post('account_details');
		$parent_acc_no = $this->input->post('parent_account_no');
		$parent_details = $this->input->post('parent_details');
	}

	public function InsertDataBranchSetup()
	{
		$value = $this->input->post('value');
		$user_id = $this->session->userdata('user_id');
		$company_id = $this->session->userdata('company_id');
		$branch_id = $this->input->post('branch_id');
		$updateArray = array();
		$insertArray = array();
		$insert_batch = "";
		$update_batch = "";
		$where = array("branch_id" => $branch_id);
		$indexArray = array();
		$i = 1;
		$main_array = array_column($value, 1);
		$unique = array_unique($main_array);
		$duplicates = array_diff_assoc($main_array, $unique);
		if ($duplicates != null || !empty($duplicates)) {
			$response['status'] = 201;
			$response['body'] = "Account Number Already Exists in the List";
			$response['duplicate'] = $duplicates;
			echo json_encode($response);
			exit();
		} else {
			foreach ($value as $item) {
				if ($item[0] != "" && $item[3] == "") {
					$updateStatus = $this->Master_Model->
					_select('branch_account_setup', array('id' => $item[0], '(parent_account_number_us = "" or parent_account_number_us IS NULL) <>' => 0, '(parent_account_number_ifrs = "" or parent_account_number_ifrs IS NULL) <>' => 0, 'company_id' => $company_id, 'branch_id' => $branch_id), 'count(*) as count', true)->data;
					if ($updateStatus->count > 0) {
						$update_status = $this->Master_Model->_update('branch_account_setup', array('status' => 0), array('id' => $item[0]));
					}
				}
				if($item[3] != "")
				{
					$where = array('company_id' => $company_id,'status'=>1, 'main_gl_number' => $item[3]);
					$resultO = $this->Master_Model->_select('main_account_setup_master', $where, array("name"), true);
					if ($resultO->totalCount > 0) {
						if ($item[4] == "") {
							$item[4] = $resultO->data->name;
						}
					} else {
						$response['status'] = 201;
						$response['body'] = "Parent Account Number ".$item[3]." Does not Exists";
						echo json_encode($response);
						exit();
					}
				}
				if ($item[1] !== "" && $item[2] !== "") {
					if ($item[5] == "Yes") {
						$is_ignore = 1;
					} else {
						$is_ignore = 0;
					}
					if ($item[0] !== "") {
						$data = array(
							"id" => $item[0],
							"account_number" => $item[1],
							"detail" => $item[2],
							"parent_account_number" => $item[3],
							"parent_details" => $item[4],
							"branch_id" => $branch_id,
							"created_by" => $user_id,
							"company_id" => $company_id,
							"is_ignore" => $is_ignore,
							"schedule_account_number" => $item[6],
							"schedule_details" => $item[7],
						);
						array_push($updateArray, $data);
					} else {
						$data = array(
							"account_number" => $item[1],
							"detail" => $item[2],
							"parent_account_number" => $item[3],
							"parent_details" => $item[4],
							"branch_id" => $branch_id,
							"created_by" => $user_id,
							"company_id" => $company_id,
							"is_ignore" => $is_ignore,
							"schedule_account_number" => $item[6],
							"schedule_details" => $item[7],
						);
						array_push($insertArray, $data);
					}
				}
			}
		}
		$response['update'] = $updateArray;
		$response['insert'] = $insertArray;
		if (!empty($updateArray)) {
			$update_batch = $this->db->update_batch('branch_account_setup', $updateArray, 'id');
		}
		if (!empty($insertArray)) {
			$insert_batch = $this->db->insert_batch("branch_account_setup", $insertArray);
		}
		$response['updatests'] = $update_batch;
		$response['insertsts'] = $insert_batch;
		if ($insert_batch == true || $update_batch == true) {
			$response['status'] = 200;
			$response['body'] = "Data uploaded Successfully";
		} else {
			$response['status'] = 200;
			$response['body'] = "No new Entry Found.";
		}

		echo json_encode($response);

	}

	public function InsertUSBranchSetup()
	{
		$value = $this->input->post('value');
		$user_id = $this->session->userdata('user_id');
		$company_id = $this->session->userdata('company_id');
		$branch_id = $this->input->post('branch_id');
		$updateArray = array();
		$insertArray = array();
		$insert_batch = "";
		$update_batch = "";
		$where = array("branch_id" => $branch_id);
		$indexArray = array();
		$i = 1;
		$main_array = array_column($value, 1);
		$unique = array_unique($main_array);
		$duplicates = array_diff_assoc($main_array, $unique);
		if ($duplicates != null || !empty($duplicates)) {
			$response['status'] = 201;
			$response['body'] = "Account Number Already Exists in the List";
			$response['duplicate'] = $duplicates;
			echo json_encode($response);
			exit();
		} else {
			foreach ($value as $item) {
				if ($item[0] != "" && $item[3] == "") {
					$updateStatus = $this->Master_Model->
					_select('branch_account_setup', array('id' => $item[0], '(parent_account_number = "" or parent_account_number IS NULL) <>' => 0, '(parent_account_number_ifrs = "" or parent_account_number_ifrs IS NULL) <>' => 0, 'company_id' => $company_id, 'branch_id' => $branch_id), 'count(*) as count', true)->data;
					if ($updateStatus->count > 0) {
						$update_status = $this->Master_Model->_update('branch_account_setup', array('status' => 0), array('id' => $item[0]));
					}
				}
				if($item[3] != "")
				{
					$where = array('company_id' => $company_id,'status'=>1, 'main_gl_number' => $item[3]);
					$resultO = $this->Master_Model->_select('main_account_setup_master_us', $where, array("name"), true);
					if ($resultO->totalCount > 0) {
						if ($item[4] == "") {
							$item[4] = $resultO->data->name;
						}
					} else {
						$response['status'] = 201;
						$response['body'] = "Parent Account Number ".$item[3]." Does not Exists";
						echo json_encode($response);
						exit();
					}
				}
				if ($item[1] !== "" && $item[2] !== "") {
					if ($item[5] == "Yes") {
						$is_ignore = 1;
					} else {
						$is_ignore = 0;
					}
					if ($item[0] !== "") {
						$data = array(
							"id" => $item[0],
							"account_number" => $item[1],
							"detail" => $item[2],
							"parent_account_number_us" => $item[3],
							"parent_details_us" => $item[4],
							"branch_id" => $branch_id,
							"created_by" => $user_id,
							"company_id" => $company_id,
							"is_ignore" => $is_ignore,
							"schedule_account_number" => $item[6],
							"schedule_details" => $item[7],
						);
						array_push($updateArray, $data);
					} else {
						$data = array(
							"account_number" => $item[1],
							"detail" => $item[2],
							"parent_account_number_us" => $item[3],
							"parent_details_us" => $item[4],
							"branch_id" => $branch_id,
							"created_by" => $user_id,
							"company_id" => $company_id,
							"is_ignore" => $is_ignore,
							"schedule_account_number" => $item[6],
							"schedule_details" => $item[7],
						);
						array_push($insertArray, $data);
					}
				}
			}
		}
		if (!empty($updateArray)) {
			$update_batch = $this->db->update_batch('branch_account_setup', $updateArray, 'id');
		}
		if (!empty($insertArray)) {
			$insert_batch = $this->db->insert_batch("branch_account_setup", $insertArray);
		}
		if ($insert_batch == true || $update_batch == true) {
			$response['status'] = 200;
			$response['body'] = "Data uploaded Successfully";
		} else {
			$response['status'] = 201;
			$response['body'] = "Failed To uplaod";
		}
		echo json_encode($response);
	}

	public function InsertIFRSBranchSetup()
	{
		$value = $this->input->post('value');
		$user_id = $this->session->userdata('user_id');
		$company_id = $this->session->userdata('company_id');
		$branch_id = $this->input->post('branch_id');
		$updateArray = array();
		$insertArray = array();
		$insert_batch = "";
		$update_batch = "";
		$where = array("branch_id" => $branch_id);
		$indexArray = array();
		$i = 1;
		$main_array = array_column($value, 1);
		$unique = array_unique($main_array);
		$duplicates = array_diff_assoc($main_array, $unique);
		if ($duplicates != null || !empty($duplicates)) {
			$response['status'] = 201;
			$response['body'] = "Account Number Already Exists in the List";
			$response['duplicate'] = $duplicates;
			echo json_encode($response);
			exit();
		} else {
			foreach ($value as $item) {
				if ($item[0] != "" && $item[3] == "") {
					$updateStatus = $this->Master_Model->
					_select('branch_account_setup', array('id' => $item[0], '(parent_account_number = "" or parent_account_number IS NULL) <>' => 0, '(parent_account_number_us = "" or parent_account_number_us IS NULL) <>' => 0, 'company_id' => $company_id, 'branch_id' => $branch_id), 'count(*) as count', true)->data;
					if ($updateStatus->count > 0) {
						$update_status = $this->Master_Model->_update('branch_account_setup', array('status' => 0), array('id' => $item[0]));
					}
				}
				if($item[3] != "")
				{
					$where = array('company_id' => $company_id,'status'=>1, 'main_gl_number' => $item[3]);
					$resultO = $this->Master_Model->_select('main_account_setup_master_ifrs', $where, array("name"), true);
					if ($resultO->totalCount > 0) {
						if ($item[4] == "") {
							$item[4] = $resultO->data->name;
						}
					} else {
						$response['status'] = 201;
						$response['body'] = "Parent Account Number ".$item[3]." Does not Exists";
						echo json_encode($response);
						exit();
					}
				}
				if ($item[1] !== "" && $item[2] !== "") {
					if ($item[5] == "Yes") {
						$is_ignore = 1;
					} else {
						$is_ignore = 0;
					}
					if ($item[0] !== "") {
						$data = array(
							"id" => $item[0],
							"account_number" => $item[1],
							"detail" => $item[2],
							"parent_account_number_ifrs" => $item[3],
							"parent_details_ifrs" => $item[4],
							"branch_id" => $branch_id,
							"created_by" => $user_id,
							"company_id" => $company_id,
							"is_ignore" => $is_ignore,
							"schedule_account_number" => $item[6],
							"schedule_details" => $item[7],
						);
						array_push($updateArray, $data);
					} else {
						$data = array(
							"account_number" => $item[1],
							"detail" => $item[2],
							"parent_account_number_ifrs" => $item[3],
							"parent_details_ifrs" => $item[4],
							"branch_id" => $branch_id,
							"created_by" => $user_id,
							"company_id" => $company_id,
							"is_ignore" => $is_ignore,
							"schedule_account_number" => $item[6],
							"schedule_details" => $item[7],
						);
						array_push($insertArray, $data);
					}
				}
			}
		}
		if (!empty($updateArray)) {
			$update_batch = $this->db->update_batch('branch_account_setup', $updateArray, 'id');
		}
		if (!empty($insertArray)) {
			$insert_batch = $this->db->insert_batch("branch_account_setup", $insertArray);
		}
		if ($insert_batch == true || $update_batch == true) {
			$response['status'] = 200;
			$response['body'] = "Data uploaded Successfully";
		} else {
			$response['status'] = 200;
			$response['body'] = "Failed To uplaod";
		}

		echo json_encode($response);

	}

	public function branch_excelupload()
	{

		$mimes = array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel', 'text/xls');

		if (!in_array($_FILES['userfile']['type'], $mimes)) {
			$response['status'] = 201;
			$response['body'] = "Upload Excel file.";
			echo json_encode($response);
			exit;
		}
		$path = $_FILES["userfile"]["tmp_name"];
		$this->load->library('excel');
		$object = PHPExcel_IOFactory::load($path);
		$worksheet = $object->getActiveSheet();
		$excelname = $_FILES["userfile"]["name"];

		$highestRow = $worksheet->getHighestRow();
		$highestColumn = $worksheet->getHighestColumn();
		$highestColumnNumber = PHPExcel_Cell::columnIndexFromString($highestColumn);
		// print_r($highestColumn);exit();
		$options = $this->getExcelDatabaseColumn(3);
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
							<select name="databaseColumn' . $cnt . '" id="databaseColumn' . $cnt . '" class="form-control">
								' . $options . '
							</select>
						</div>
				   </div>';
			$cnt++;
		}

		$response['count'] = $cnt;
		$response['status'] = 200;
		$response['body'] = $template;

		echo json_encode($response);
	}

	public function getExcelDatabaseColumn($type)
	{
		$options = '<option selected value=""></option>';
		$resultObject = $this->Master_Model->_select('upload_column_mapping_rule', array('type' => $type), array('id', 'Tablecolumn_name', 'column_name'), false);
		if ($resultObject->totalCount > 0) {
			foreach ($resultObject->data as $value) {
				$options .= '<option value="' . $value->Tablecolumn_name . '">' . $value->column_name . '</option>';
			}
		}
		return $options;
	}

	public function RemoveSubsidiaryData()
	{
		$id = $this->input->post('id');
		$type = $this->input->post('type');
		$company_id = $this->session->userdata('company_id');
		$branch_id = $this->input->post('branch_id');
		$set = array('parent_account_number' => null, 'parent_details' => "");
		$where = array('id' => $id, '(parent_account_number_us = "" or parent_account_number_us IS NULL) <>' => 0, '(parent_account_number_ifrs = "" or parent_account_number_ifrs IS NULL) <>' => 0, 'company_id' => $company_id, 'branch_id' => $branch_id);
		if ($type == 2) {
			$set = array('parent_account_number_us' => null, 'parent_details_us' => "");
			$where = array('id' => $id, '(parent_account_number = "" or parent_account_number IS NULL) <>' => 0, '(parent_account_number_ifrs = "" or parent_account_number_ifrs IS NULL) <>' => 0, 'company_id' => $company_id, 'branch_id' => $branch_id);
		}
		if ($type == 3) {
			$set = array('parent_account_number_ifrs' => null, 'parent_details_ifrs' => "");
			$where = array('id' => $id, '(parent_account_number = "" or parent_account_number IS NULL) <>' => 0, '(parent_account_number_us = "" or parent_account_number_us IS NULL) <>' => 0, 'company_id' => $company_id, 'branch_id' => $branch_id);
		}
		$updateRow = $this->Master_Model->_update('branch_account_setup', $set, array('id' => $id));

		$updateStatus = $this->Master_Model->_select('branch_account_setup', $where, 'count(*) as count', true)->data;
		if ($updateStatus->count > 0) {
			$update_status = $this->Master_Model->_update('branch_account_setup', array('status' => 0), array('id' => $id));
		}
		if ($updateRow == true) {
			$response['status'] = 200;
			$response['data'] = "Data Updated";
		} else {
			$response['status'] = 201;
			$response['data'] = "Data not Updated";
		}
		echo json_encode($response);
	}

	public function ClearData()
	{
		$company_id = $this->session->userdata('company_id');
		$branch_id = $this->input->post('branch_id');
		if ($branch_id != null && $branch_id != "") {
			$deleteData = $this->Master_Model->_delete('branch_account_setup', array('company_id' => $company_id, 'branch_id' => $branch_id));
			if ($deleteData->status == TRUE) {
				$response['status'] = 200;
				$response['body'] = "Data Cleared";
			} else {
				$response['status'] = 201;
				$response['body'] = "Something Went Wrong";
			}
		} else {
			$response['status'] = 201;
			$response['body'] = "Branch Not Found";
		}
		echo json_encode($response);
	}
	public function getPercentageHoldingData()
	{
		$company_id = $this->session->userdata('company_id');
		$branch_id = $this->input->post('branch_id');
		$company = $this->Master_Model->order_by_data($select = "trim(main_gl_number) as main_gl_number", $where = array("company_id" => $company_id, 'status' => 1), $table = "main_account_setup_master", $order_by = "id", $key = "desc");
		$data = array();
		if (count($company)) {
			foreach ($company as $row) {
				$data[] = $row->main_gl_number;
			}
		}
		$getDataBranch = $this->Master_Model->order_by_data($select = "*", $where = array('branch_id' => $branch_id, 'status' => 1), $table = "branch_percentage_holding_gl_data", $order_by = "id", $key = "desc");
		$dataNew = array();
		if (count($getDataBranch) > 0) {
			foreach ($getDataBranch as $row1) {
				$data1 = array($row1->gl_number, $row1->detail, $row1->type);
				array_push($dataNew, $data1);
			}
			$data12 = array("", "", "", "",);
			array_push($dataNew, $data12);
		}
		$response['status'] = 200;
		$response['data2'] = $dataNew;
		$response['data'] = $data;
		echo json_encode($response);
	}
	public function InsertPercentageHoldData()
	{
		$value = $this->input->post('value');
		$user_id = $this->session->userdata('user_id');
		$company_id = $this->session->userdata('company_id');
		$branch_id = $this->input->post('branch_id');
		$insertArray=array();
		foreach ($value as $item) {
			if ($item[0] !== "") {
				$data=array('branch_id'=>$branch_id,'gl_number'=>$item[0],'detail'=>$item[1],'type'=>$item[2],'status'=>1);
					array_push($insertArray, $data);
			}
		}
		if(count($insertArray)>0)
		{
			$delete=$this->Master_Model->_delete('branch_percentage_holding_gl_data',array('branch_id'=>$branch_id,'status'=>1));
			$insert=$this->Master_Model->_insertBatch('branch_percentage_holding_gl_data',$insertArray);
			if($insert->status)
			{
				$response['status']=200;
				$response['data']='Data Uploaded Successfully';
			}
			else{
				$response['status']=201;
				$response['data']='No data for uploaded';
			}
		}
		else{
			$response['status']=201;
			$response['data']='No data for uploaded';
		}
		echo  json_encode($response);
	}
	public function clearPercentageHoldData()
	{
		$branch_id = $this->input->post('branch_id');
		if ($branch_id != null && $branch_id != "") {
			$deleteData = $this->Master_Model->_delete('branch_percentage_holding_gl_data', array('branch_id' => $branch_id));
			if ($deleteData->status == TRUE) {
				$response['status'] = 200;
				$response['body'] = "Data Cleared";
			} else {
				$response['status'] = 201;
				$response['body'] = "Something Went Wrong";
			}
		} else {
			$response['status'] = 201;
			$response['body'] = "Branch Not Found";
		}
		echo json_encode($response);
	}
}

?>
