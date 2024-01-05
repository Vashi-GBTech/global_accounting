<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property  Master_Model Master_Model
 */
class UploadDataController extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Excelsheet_model');
	}


	public function index()
	{
		$id = $this->input->get('id', TRUE);

		$company_id = $this->session->userdata('company_id');
		$getUploadData = $this->Master_Model->get_row_data("*", array('id' => $id), 'excelsheet_master_data');
		$CheckBlockwhere = array('year' => $getUploadData->year, 'month' => $getUploadData->quarter, 'company_id' => $company_id);
		$checkPermission = $this->Master_Model->checkBlockYearMonth($CheckBlockwhere);

		$ApproveOrNot = $this->Master_Model->get_row_data("*", array('id' => $id), 'excelsheet_master_data');
//		if ($checkPermission == true) {
//
//		}
		$this->load->view("Admin/upload_data/view_upload_data", array("title" => "User View", "checkPermission" => $checkPermission));
	}

	public function user_excel_view()
	{
		$this->load->view('Admin/upload_data/user_view', array('title' => "User View"));
	}

	public function getUserViewData()
	{
		$excelSheetMasterID = $this->input->post("id");
		$excelSheetObject = $this->Excelsheet_model->_select("excelsheet_master_data", array("id" => $excelSheetMasterID),
			array("template_id", "year", "quarter", "approve_status"));

		if ($excelSheetObject->totalCount > 0) {
			$template_id = $excelSheetObject->data->template_id;
			$year = $excelSheetObject->data->year;
			$quarter = $excelSheetObject->data->quarter;
			$configurationWhere = array("template_id" => $template_id);
			$configurationSelect = array("attribute_type", "column_name", "table_name", "attribute_name", "attribute_query");
			$configurationRecords = $this->Excelsheet_model->_select("template_column_mapping", $configurationWhere, $configurationSelect, false);


			$unMatchRecords = array();
			$matchRecords = array();
			$header = array();
			if ($configurationRecords->totalCount > 0) {
				$templateTableName = $configurationRecords->data[0]->table_name;
				foreach ($configurationRecords->data as $configuration) {
					array_push($header, $configuration->attribute_name);
				}
				$where = array(
//					'branch_id' => $this->session->userdata("branch_id"),
//					'company_id' => $this->session->userdata("company_id"),
					"sheet_master_id" => $excelSheetMasterID,
					"year" => $year,
					"quarter" => $quarter);
				$select = $header;
				$sheetRecords = $this->Excelsheet_model->_select($templateTableName, $where, $select, false);
				$response["status"] = 200;
				$response['data'] = $sheetRecords->data;
				$response["header"] = $header;
			} else {
				$response["status"] = 201;
				$response["body"] = "Configuration Not Found";
			}
		} else {
			$response["status"] = 201;
			$response["body"] = "Not Found";
		}

		echo json_encode($response);
	}


	public function SaveData()
	{
		$data = $this->input->post('data');
		$table_array = json_decode($data);
		$template = $this->input->post('template');
		$id = $this->input->post('id');
		$acType = $this->input->post('acType');
		$queryGetBarnch_id = $this->Master_Model->get_row_data(array("branch_id"), array("id" => $id), 'excelsheet_master_data');
		if (!is_null($queryGetBarnch_id)) {
			$branch_id = $queryGetBarnch_id->branch_id;
		} else {
			$branch_id = $this->session->userdata('branch_id');
		}
		$update_array = array();

		if ($data != null && $data != "") {
			if ($template == 1) {
				$columns = array("id", 'gl_ac', 'detail','opening_balance', 'debit', 'credit');
				$table = "upload_financial_data";
			} else {
				$columns = array("id", "branch_company_id", "name", "amount");
				$table = "upload_intra_company_transfer";
			}
			$glAccounts = array();
			$response["code"] = false;

			foreach ($table_array as $rows) {
				$data_item = array();
				foreach ($columns as $index => $columnvalue) {
					$data_item[$columnvalue] = $rows[$index];
					if ($columnvalue == "gl_ac") {
						// echo 1;
						// exit();
						$checkifglexists = $this->Master_Model->_select('branch_account_setup',
							array('account_number' => $rows[1], "branch_id" => $branch_id), '*', true)->data;
						if ($checkifglexists != null) {
							/*if ($checkifglexists->parent_account_number == null && $checkifglexists->parent_account_number == "") {
								$response['update'][] = array('account_number' => $rows[1]);
								$this->Master_Model->_update('branch_account_setup', array('parent_account_number' => $rows[7]), array('account_number' => $rows[$index]));
							} else {
								$response["code"] = true;
								$response['message'] = $rows[1] . " Account is already mapped with" . $checkifglexists->parent_account_number . " parent account";
							}*/
							$response['update'][] = array('account_number' => $rows[1]);
							if($rows[7] != null){
								if($acType == 1){
									$this->Master_Model->_update('branch_account_setup', array('parent_account_number' => $rows[7]), array('account_number' => $rows[$index]));
								}else if($acType == 2){
									$this->Master_Model->_update('branch_account_setup', array('parent_account_number_us' => $rows[7]), array('account_number' => $rows[$index]));
								}else{
									$this->Master_Model->_update('branch_account_setup', array('parent_account_number_ifrs' => $rows[7]), array('account_number' => $rows[$index]));
								}
							}

						} else {
							if ($rows[7] != null) {
								if($acType == 1){
									$insert_array = array(
										'branch_id' => $branch_id,
										'account_number' => $rows[$index],
										'detail' => $rows[2],
										'parent_account_number' => $rows[7],
										'created_by' => $this->session->userdata('user_id')
									);
								}else if($acType == 2){
									$insert_array = array(
										'branch_id' => $branch_id,
										'account_number' => $rows[$index],
										'detail' => $rows[2],
										'parent_account_number_us' => $rows[7],
										'created_by' => $this->session->userdata('user_id')
									);
								}else{
									$insert_array = array(
										'branch_id' => $branch_id,
										'account_number' => $rows[$index],
										'detail' => $rows[2],
										'parent_account_number_ifrs' => $rows[7],
										'created_by' => $this->session->userdata('user_id')
									);
								}
								
								$response['insert'] = $insert_array;
								$this->Master_Model->_insert('branch_account_setup', $insert_array);
							}
						}

					}
				}
				array_push($update_array, $data_item);
			}
			$updateExcel = $this->Master_Model->UploadExcelData($update_array, $table, "id");
			if ($updateExcel) {
				if ($response["code"] == false) {
					$response['status'] = 200;
					$response['message'] = "Data Updated";
				} else {
					$response['status'] = 201;
				}
			} else {
				$response['status'] = 201;
				$response['message'] = "Data Not Updated";
			}
		} else {
			$response['status'] = 201;
			$response['message'] = "No Data Found";
		}
		echo json_encode($response);
	}

	public function approveData()
	{

		$excelSheet_id = $this->input->post("excelSheet_id");
		$unmatch = $this->input->post('unmatch');
		$approve_status = $this->input->post('approve_status');
		if ($unmatch == 1) {
			$unmatch = 1;
		} else {
			$unmatch = 0;
		}
		if (!is_null($excelSheet_id)) {

			$updateDataResult = $this->Master_Model->_update("excelsheet_master_data", array("approve_status" => $approve_status, 'progress' => $unmatch), array("id" => $excelSheet_id));
			if ($updateDataResult->status) {
				$response["status"] = 200;
				$response["body"] = "Approved Data";
			} else {
				$response["status"] = 201;
				$response["body"] = "Failed To Approved Data";
			}
		} else {
			$response["status"] = 200;
			$response["body"] = "Invalid Request";
		}

		echo json_encode($response);

	}
}

?>
