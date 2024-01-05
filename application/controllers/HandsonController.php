<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property  Excelsheet_model Excelsheet_model
 */
class HandsonController extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Global_model');
		$this->load->model('Excelsheet_model');
	}

	public function handson()
	{
		$this->load->view("user/excel_upload", array("title" => "User Upload"));
	}

	public function uploadIntraCompanyTransfer()
	{
		$this->load->view("user/uploadintracompanytransfer", array("title" => "User Upload"));
	}

	public function viewIntraCompanyDetails($id)
	{
		$branch_id = $this->session->userdata('branch_id');
		$branch = '';
		$branch_name = $this->Master_Model->get_row_data("name", array('id' => $branch_id), 'branch_master');
		if (!empty($branch_name)) {
			$branch = $branch_name->name;
		}
		$this->load->view("user/viewIntraCompanyDetails", array("title" => "User Upload", "id" => $id, "branch_id" => $branch_id, "branch_name" => $branch));
	}

	public function viewIntraCompanyDetailsHandson($id)
	{
		$branch_id = $this->session->userdata('branch_id');
		$branch = '';
		$branch_name = $this->Master_Model->get_row_data("name", array('id' => $branch_id), 'branch_master');
		if (!empty($branch_name)) {
			$branch = $branch_name->name;
		}
		$this->load->view("user/viewIntraCompanyDetailsHandon", array("title" => "User Upload", "id" => $id, "branch_id" => $branch_id, "branch_name" => $branch));
	}

	public function ExportToTable()
	{
		$year = $this->input->post('year');
		$quarter = $this->input->post('quarter');
		$company_id = $this->session->userdata('company_id');

		$CheckBlockwhere = array('company_id' => $company_id, 'year' => $year, 'month' => $quarter);
		$checkPermission = $this->Master_Model->checkBlockYearMonth($CheckBlockwhere);
		if ($checkPermission == true) {

			// $template_id = $this->input->post('select_template');
			if ($this->session->userdata('user_type') == 2) {
				$branch_id = $this->input->post('branch_id');
			} else {
				$branch_id = $this->session->userdata('branch_id');
			}
			$company_id = $this->session->userdata('company_id');
			$check_approve_not_approve = $this->db->where(array('year' => $year, 'quarter' => $quarter, 'branch_id' => $branch_id, 'template_id' => 1, 'approve_status' => 1))->get('excelsheet_master_data')->row();

			// $mimes = array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel', 'text/xls');
			// if (!in_array($_FILES['userfile']['type'], $mimes)) {
			// 	$response['status'] = 201;
			// 	$response['body'] = "Upload Excel file.";
			// 	echo json_encode($response);
			// 	exit;
			// }
			// $path = $_FILES["userfile"]["tmp_name"];
			// $this->load->library('excel');
			// $object = PHPExcel_IOFactory::load($path);
			// $worksheet = $object->getActiveSheet();
			// $excelname = $_FILES["userfile"]["name"];

			// $highestRow = $worksheet->getHighestRow();
			// $highestColumn = $worksheet->getHighestColumn();
			// $highestColumnNumber = PHPExcel_Cell::columnIndexFromString($highestColumn);

			$cnt = 1;
			$dupliacte_array = array();
			$dupliacte_array1 = array();
			$duplicate_count = 0;
			$insert_count = 0;
			$duplicate_table = "";
			$tableObject = 5;
			$result = true;

			$result = false;
			if (empty($check_approve_not_approve)) {
				$check_entry = $this->db->where(array('year' => $year, 'quarter' => $quarter, 'branch_id' => $branch_id, 'template_id' => 1))->get('excelsheet_master_data')->row();
				if (!empty($check_entry)) {
					$id = $check_entry->id;

					$response['status'] = 200;
					$response['body'] = $id;
					$response['branch_id'] = $check_entry->branch_id;
					$response['type'] = 1;
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
					if ($insert == true) {
						$response['status'] = 200;
						$response['body'] = $id;
						$response['branch_id'] = $branch_id;
						$response['type'] = 2;
					} else {
						$response['status'] = 201;
						$response['body'] = 'Data not uploaded';
					}
				}

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
	// public function ExportToTableBackup()
	// {
	// 	$year = $this->input->post('year');
	// 	$quarter = $this->input->post('quarter');
	// 	$template_id = $this->input->post('select_template');
	// 	if ($this->session->userdata('user_type')==2){
	// 		$branch_id = $this->input->post('branch_id');
	// 	}else{
	// 		$branch_id = $this->session->userdata('branch_id');
	// 	}
	// 	$company_id = $this->session->userdata('company_id');
	// 	$check_approve_not_approve = $this->db->where(array('year' => $year, 'quarter' => $quarter, 'branch_id' => $branch_id, 'template_id' => 1,'approve_status'=>1))->get('excelsheet_master_data')->row();
	// 	$check_entry = $this->db->where(array('year' => $year, 'quarter' => $quarter, 'branch_id' => $branch_id, 'template_id' => 1))->get('excelsheet_master_data')->row();
	// 	if (!empty($check_entry)) {
	// 		$id = $check_entry->id;
	// 		$this->db->where(array('year' => $year, 'quarter' => $quarter, 'branch_id' => $branch_id))->delete('upload_financial_data');
	// 	}
	// 	$mimes = array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel', 'text/xls');
	// 	if (!in_array($_FILES['userfile']['type'], $mimes)) {
	// 		$response['status'] = 201;
	// 		$response['body'] = "Upload Excel file.";
	// 		echo json_encode($response);
	// 		exit;
	// 	}
	// 	$path = $_FILES["userfile"]["tmp_name"];
	// 	$this->load->library('excel');
	// 	$object = PHPExcel_IOFactory::load($path);
	// 	$worksheet = $object->getActiveSheet();
	// 	$excelname = $_FILES["userfile"]["name"];

	// 	$highestRow = $worksheet->getHighestRow();
	// 	$highestColumn = $worksheet->getHighestColumn();
	// 	$highestColumnNumber = PHPExcel_Cell::columnIndexFromString($highestColumn);

	// 	$cnt = 1;
	// 	$dupliacte_array = array();
	// 	$dupliacte_array1 = array();
	// 	$duplicate_count = 0;
	// 	$insert_count = 0;
	// 	$duplicate_table = "";
	// 	$tableObject = 5;
	// 	$result = true;

	// 	$result = false;
	// 	if(empty($check_approve_not_approve)){

	// 	if ($tableObject != ($highestColumnNumber)) {
	// 		$response['status'] = 201;
	// 		$response['body'] = "Upload Excel File with " . $tableObject . " columns";
	// 		echo json_encode($response);
	// 		exit();
	// 	} else {
	// 		$upload_path = "uploads";
	// 		$combination = 2;
	// 		$name_input = "userfile";
	// 		$result = $this->Global_model->upload_multiple_file1($upload_path, $name_input, $combination);
	// 		$response['rest'] = $result;
	// 		if ($result['status'] == 200) {
	// 			$input_data = $upload_path . '/' . $result['body'];

	// 			$id = '';
	// 			try {
	// 				$this->db->trans_start();
	// 				$master_data = array('name' => $input_data,
	// 					'created_on' => date('Y-m-d H:i:s'),
	// 					'created_by' => $this->session->userdata('user_id'),
	// 					'status' => 1,
	// 					'year' => $year,
	// 					'quarter' => $quarter,
	// 					'branch_id' => $branch_id,
	// 					'company_id' => $company_id,
	// 					'template_id' => 1);

	// 				$insert = $this->db->insert('excelsheet_master_data', $master_data);
	// 				$insert_id = $this->db->insert_id();

	// 				$id = $insert_id;
	// 				if ($insert == true) {
	// 					$mainArray = array();

	// 					for ($i = 2; $i <= $highestRow; $i++) {
	// 						$data = array("year" => $year,
	// 							"quarter" => $quarter,
	// 							"gl_ac" => $object->getActiveSheet()->getCell("A" . $i)->getValue(),
	// 							"debit" => $object->getActiveSheet()->getCell("C" . $i)->getValue(),
	// 							"credit" => $object->getActiveSheet()->getCell("D" . $i)->getValue(),
	// 							"detail" => $object->getActiveSheet()->getCell("B" . $i)->getValue(),
	// 							"total"=>$object->getActiveSheet()->getCell("E" . $i)->getValue(),
	// 							"user_id" => 1,
	// 							"created_by" => 1,
	// 							"created_on" => date('Y-m-d H:i:s'),
	// 							"branch_id" => $branch_id,
	// 							"company_id" => $company_id,
	// 							"sheet_master_id" => $insert_id
	// 						);


	// 						$mainArray[] = $data;

	// 					}

	// 					if (!empty($mainArray)) {
	// 						$insertdata = $this->db->insert_batch('upload_financial_data', $mainArray);
	// 						$result = true;
	// 						$body_message = 'Data Uploaded';
	// 					}

	// 				}
	// 				if ($this->db->trans_status() === FALSE) {
	// 					$this->db->trans_rollback();
	// 					$result = false;
	// 					$body_message = 'something went wrong';
	// 				} else {
	// 					$this->db->trans_commit();
	// 					$result = true;
	// 					$body_message = 'Data Uploaded';
	// 				}
	// 				$this->db->trans_complete();
	// 			} catch (Exception $exc) {
	// 				$result = false;
	// 				$body_message = 'something went wrong';
	// 				$this->db->trans_rollback();
	// 				$this->db->trans_complete();

	// 			}

	// 		} else {
	// 			$result = false;
	// 			$body_message = 'something went wrong';
	// 		}
	// 	}
	// 	}else{
	// 			$result = false;
	// 			$body_message =  'Already approved. You can not upload again.';
	// 		}

	// 		if ($result == true) {
	// 			$response['status'] = 200;
	// 			$response['body'] = $id;
	// 			$response['branch_id']=$branch_id;
	// 		} else {
	// 			$response['status'] = 201;
	// 			$response['body'] = $body_message;
	// 		}
	// 	echo json_encode($response);
	// }


	public function ExportToTable2()
	{
		$year = $this->input->post('year');
		$quarter = $this->input->post('quarter');
		$holdingType = $this->input->post('holdingType');
		// print_r($this->input->post());exit();
		// $template_id = $this->input->post('select_template');
		// if ($this->session->userdata('user_type')==2){
		// 	$branch_id = $this->input->post('branch_id');
		// }else{
		// 	$branch_id = $this->session->userdata('branch_id');
		// }

		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');
		$CheckBlockwhere = array('company_id' => $company_id, 'year' => $year, 'month' => $quarter);
		$checkPermission = $this->Master_Model->checkBlockYearMonth($CheckBlockwhere);
		if ($checkPermission == true) {

			$cnt = 1;

			$approve_status = 0;
			if ($user_type == 2) {
				$approve_status = 1;
			}
			$insert_count = 0;
			$duplicate_table = "";
			$tableObject = 3;
			$result = true;

			$result = false;
			if (empty($check_approve_not_approve)) {

				$check_entry = $this->db->where(array('year' => $year, 'quarter' => $quarter, 'company_id' => $company_id, 'template_id' => 2))->get('excelsheet_master_data')->row();
				if (!empty($check_entry)) {
					$id = $check_entry->id;
					$response['status'] = 200;
					$response['body'] = $id;
					// $response['branch_id']=$check_entry->branch_id;
				} else {
					$id = '';
					$master_data = array(
						'created_on' => date('Y-m-d H:i:s'),
						'created_by' => $this->session->userdata('user_id'),
						'status' => 1,
						'year' => $year,
						'quarter' => $quarter,
						'company_id' => $company_id,
						'template_id' => 2,
						'user_type' => $user_type,
						'approve_status' => $approve_status,
						'holding_type' => $holdingType); //for financial upload
					$insert = $this->db->insert('excelsheet_master_data', $master_data);
					$insert_id = $this->db->insert_id();

					$id = $insert_id;
					if ($insert == true) {
						$response['status'] = 200;
						$response['body'] = $id;
						$response['year'] = $year;
						$response['quarter'] = $quarter;
					} else {
						$response['status'] = 201;
						$response['body'] = 'Data not uploaded';
					}
				}
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

	// public function ExportToTable2Backup()
	// {
	// 	$year = $this->input->post('year');
	// 	$quarter = $this->input->post('quarter');

	// 	$template_id = $this->input->post('select_template');
	// 	if ($this->session->userdata('user_type')==2){
	// 		$branch_id = $this->input->post('branch_id');
	// 	}else{
	// 		$branch_id = $this->session->userdata('branch_id');
	// 	}
	// 	$company_id = $this->session->userdata('company_id');
	// 	$check_approve_not_approve = $this->db->where(array('year' => $year, 'quarter' => $quarter, 'branch_id' => $branch_id, 'template_id' => 2,'approve_status'=>1))->get('excelsheet_master_data')->row();

	// 	$check_entry = $this->db->where(array('year' => $year, 'quarter' => $quarter, 'branch_id' => $branch_id, 'template_id' => 2))->get('excelsheet_master_data')->row();
	// 	if (!empty($check_entry)) {
	// 		$id = $check_entry->id;
	// 		$this->db->where(array('year' => $year, 'quarter' => $quarter, 'branch_id' => $branch_id))->delete('upload_intra_company_transfer');
	// 	}
	// 	$mimes = array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel', 'text/xls');
	// 	if (!in_array($_FILES['userfile']['type'], $mimes)) {
	// 		$response['status'] = 201;
	// 		$response['body'] = "Upload Excel file.";
	// 		echo json_encode($response);
	// 		exit;
	// 	}
	// 	$path = $_FILES["userfile"]["tmp_name"];
	// 	$this->load->library('excel');
	// 	$object = PHPExcel_IOFactory::load($path);
	// 	$worksheet = $object->getActiveSheet();
	// 	$excelname = $_FILES["userfile"]["name"];

	// 	$highestRow = $worksheet->getHighestRow();
	// 	$highestColumn = $worksheet->getHighestColumn();
	// 	$highestColumnNumber = PHPExcel_Cell::columnIndexFromString($highestColumn);
	// 	$cnt = 1;
	// 	$dupliacte_array = array();
	// 	$dupliacte_array1 = array();
	// 	$duplicate_count = 0;
	// 	$insert_count = 0;
	// 	$duplicate_table = "";
	// 	$tableObject = 3;
	// 	$result = true;

	// 	$result = false;
	// 	if(empty($check_approve_not_approve)) {
	// 		if ($tableObject != $highestColumnNumber) {
	// 			$response['status'] = 201;
	// 			$response['body'] = "Upload Excel File with " . $tableObject . " columns";
	// 			echo json_encode($response);
	// 			exit();
	// 		} else {
	// 			$upload_path = "uploads";
	// 			$combination = 2;
	// 			$name_input = "userfile";
	// 			$result = $this->Global_model->upload_multiple_file1($upload_path, $name_input, $combination);

	// 			if ($result['status'] == 200) {
	// 				$input_data = $upload_path . '/' . $result['body'];

	// 				$id = '';
	// 				try {
	// 					$this->db->trans_start();
	// 					$master_data = array('name' => $input_data,
	// 						'created_on' => date('Y-m-d H:i:s'),
	// 						'created_by' => $this->session->userdata('user_id'),
	// 						'status' => 1,
	// 						'year' => $year,
	// 						'quarter' => $quarter,
	// 						'branch_id' => $branch_id,
	// 						'company_id' => $company_id,
	// 						'template_id' => 2); //for financial upload
	// 					$insert = $this->db->insert('excelsheet_master_data', $master_data);
	// 					$insert_id = $this->db->insert_id();

	// 					$id = $insert_id;
	// 					if ($insert == true) {
	// 						$mainArray = array();

	// 						for ($i = 2; $i <= $highestRow; $i++) {
	// 							$data = array("year" => $year,
	// 								"quarter" => $quarter,
	// 								"branch_company_id" => $object->getActiveSheet()->getCell("A" . $i)->getValue(),
	// 								"name" => $object->getActiveSheet()->getCell("B" . $i)->getValue(),
	// 								"amount" => $object->getActiveSheet()->getCell("C" . $i)->getValue(),
	// 								"user_id" => 1,
	// 								"created_by" => 1,
	// 								"created_on" => date('Y-m-d H:i:s'),
	// 								"branch_id" => $branch_id,
	// 								"company_id" => $company_id,
	// 								"sheet_master_id" => $insert_id
	// 							);


	// 							$mainArray[] = $data;

	// 						}

	// 						if (!empty($mainArray)) {
	// 							$insertdata = $this->db->insert_batch('upload_intra_company_transfer', $mainArray);
	// 							$result = true;
	// 							$body_message = 'Data Uploaded';
	// 						}

	// 					}
	// 					if ($this->db->trans_status() === FALSE) {
	// 						$this->db->trans_rollback();
	// 						$result = false;
	// 						$body_message = 'something went wrong';
	// 					} else {
	// 						$this->db->trans_commit();
	// 						$result = true;
	// 						$body_message = 'Data Uploaded';
	// 					}
	// 					$this->db->trans_complete();
	// 				} catch (Exception $exc) {
	// 					$result = false;
	// 					$body_message = 'something went wrong';
	// 					$this->db->trans_rollback();
	// 					$this->db->trans_complete();

	// 				}
	// 			} else {
	// 				$result = false;
	// 				$body_message = 'something went wrong';
	// 			}
	// 		}
	// 	}else{
	// 		$result = false;
	// 		$body_message =  'Already approved. You can not upload again.';
	// 	}

	// 	if ($result == true) {
	// 		$response['status'] = 200;
	// 		$response['body'] = $id;
	// 		$response['branch_id'] = $branch_id;
	// 	} else {
	// 		$response['status'] = 201;
	// 		$response['body'] = $body_message;
	// 	}
	// 	echo json_encode($response);
	// }

	public function getTemplateDataCount($template_id)
	{
		// return $this->Excelsheet_model->_select('template_column_mapping', array('template_id' => $template_id), '*', false);
		return $this->Excelsheet_model->order_by_data("*", array('template_id' => $template_id), 'template_column_mapping', 'sequence');
	}


	public function getExcelTableColumn($tablename)
	{
		$result = $this->db->list_fields($tablename);

		return $count = $result;
	}


	public function getExportToTableData()
	{
		if (!is_null($this->input->post('id'))) {
			$id = $this->input->post('id');
			$resultObject = $this->Excelsheet_model->getExportToTable($id);
			$nameA = array('supriya', 'pooja', 'narendra');
			$textArray = array('TEXT', 'LONGTEXT', 'VARCHAR', 'SHORTTEXT');
			if ($resultObject->totalCount > 0) {
				$tablename = $resultObject->data->tablename;
				$template_id = $resultObject->data->template_id;
				$columnsObject = $this->getTemplateDataCount($template_id);
				$columnData = array();
				$columnsNamesData = array();
				$columnsTypes = array();
				if (count($columnsObject) > 0) {
					foreach ($columnsObject as $columnDataValue) {
						array_push($columnData, $columnDataValue->attribute_name);
						array_push($columnsNamesData, $columnDataValue->column_name);
						$object = new stdClass();
						$object->type = 'text';
						if (strtolower($columnDataValue->attribute_type) == strtolower("numeric")) {
							$object->type = 'numeric';
						}
						if (strtolower($columnDataValue->attribute_type) == strtolower("date")) {
							$object->type = 'date';
							$object->dateFormat = 'M/D/YYYY';
						}
						if ($columnDataValue->attribute_query != null && $columnDataValue->attribute_query != "") {
							$object->type = 'dropdown';
							$dropdownObject = $this->Excelsheet_model->_rawQuery($columnDataValue->attribute_query);
							if ($dropdownObject->totalCount > 0) {
								$dropObjArray = array();
								foreach ($dropdownObject->data as $dropValue) {
									array_push($dropObjArray, $dropValue->name);
								}
								$object->source = $dropObjArray;
							}

						}
						array_push($columnsTypes, $object);

					}
					array_push($columnData, 'id');
				}
				if ($this->session->userdata('user_type') == 2) {
					$branch_id = $this->input->post('branch_id');
				} else {
					$branch_id = $this->session->userdata('branch_id');
				}

				$company_id = $this->session->userdata('company_id');
				$where = array('branch_id' => $branch_id, 'company_id' => $company_id, 'sheet_master_id' => $id,"is_transfer"=>0);
				// print_r($tablename);exit();
				$rowObject = $this->Excelsheet_model->_select($tablename, $where, '*', false);
				$rowData = array();
				if ($rowObject->totalCount > 0) {
					foreach ($rowObject->data as $rowValue) {
						$rowValueArray = array();
						foreach ($columnsNamesData as $columnvalue) {
							array_push($rowValueArray, $rowValue->$columnvalue);
						}
						array_push($rowValueArray, $rowValue->id);
						array_push($rowData, $rowValueArray);
					}
				}
				// $mainArray=array();
				// foreach ($resultObject->data as $key => $value) {
				//     $childArray=array();

				//     $nameAKey=1;
				//     $name=$value->name;

				//     array_push($childArray, $name);
				//      array_push($childArray, $value->age);
				//      array_push($childArray, $value->dob);
				//      array_push($childArray, $value->contact);
				//      array_push($childArray, $value->gender);
				//    array_push($mainArray, $childArray);
				// }

				$response['status'] = 200;
				$response['columns'] = $columnData;
				$response['rows'] = $rowData;
				$response['types'] = $columnsTypes;
			} else {
				$response['status'] = 201;
				$response['columns'] = '';
				$response['rows'] = '';
			}

		} else {
			$response['status'] = 201;
			$response['columns'] = '';
			$response['rows'] = '';
		}
		echo json_encode($response);
	}


	public function getTemplates()
	{
		$branch_id = $this->session->userdata('branch_id');
		$resultObject = $this->Excelsheet_model->_select('template_master', array('status' => 1, 'branch_id' => $branch_id), array('id', 'template_name'), false);
		if ($resultObject->totalCount > 0) {
			$data = array();
			foreach ($resultObject->data as $key => $value) {

				$data[] = array('id' => $value->id, 'text' => $value->template_name);
			}
			$response['status'] = 200;
			$response['data'] = $data;
		} else {
			$response['status'] = 201;
			$response['data'] = '';
		}
		echo json_encode($response);

	}
function getFinancialData()
	{
		$month = $this->Master_Model->getQuarter();
		$user_type = $this->session->userdata('user_type');
		$filterYear = $this->input->post("year");
		$filterQuarter = $this->input->post("quarter");
		$filterStatus = $this->input->post("status");
		$branch = $this->session->userdata("branch_id");
		$company = $this->session->userdata("company_id");
		$target_quarter = $this->input->post("target_quarter");
		$target_branch = $this->input->post("target_branch");
		$target_year = $this->input->post("target_year");

		$template = '';
		$progress_state = "";
		$where=array("template_id"=>1);
		if(!is_null($filterYear)&& $filterYear !=-1){
			$where["year"]=$filterYear;
		}
		if(!is_null($filterQuarter) && $filterQuarter !=-1){
			$where["quarter"]=$filterQuarter;
		}
		if(!is_null($filterStatus) && $filterStatus !=-1){
			$where["approve_status"]=$filterStatus;
		}
		$branch_permission = $this->session->userdata('branch_permission');
		$array=array();
		if(!is_null($branch_permission)){
			$array=explode(",",$branch_permission);
		}
		if($this->session->userdata('user_type') != 2){
			$where["branch_id"]=$branch;
		}
		$mbData = $this->db
			->select(array("*","(select bm.name from branch_master bm where bm.id=em.branch_id and status=1) as branch","(select cm.name from company_master cm where cm.id=em.company_id) as company","(select tm.template_name from template_master tm where tm.id=em.template_id) as template"))
			->where($where)
			->where('company_id',$company)
			->where_in('branch_id',$array)
			->order_by('quarter', 'asc')
			->get("excelsheet_master_data em")->result();

		$query = $this->db->last_query();
		$tableRows = array();
		$data=array();
		if (count($mbData) > 0) {
			$country_master = $this->Master_Model->country();

				$country = $country_master[1];
			$i = 1;
			foreach ($mbData as $order) {
				if ($order->approve_status == 1) {
					$status = '<span class="badge badge-success m_right">Approved</span>';
				} else {
					$status = '<span class="badge badge-danger m_right">Not Approve</span>';
				}
				if($order->progress == 1)
				{
					$progress_state = '<span class="badge badge-success m_right">Fully Matched</span>';
				}
				else
				{
					$progress_state = '<span class="badge badge-danger m_right">Unmatched</span>';
				}

				$CheckBlockwhere = array('year'=>$order->year,'month'=>$order->quarter,'company_id'=>$order->company_id);
				$checkPermission=$this->Master_Model->checkBlockYearMonth($CheckBlockwhere);
				$permission = 0;
				if ($checkPermission == true){
					$permission = 1;
				}
				$tableRows[$month[$order->quarter].' '.$order->year][]=array($i, $order->id, $order->template, $order->branch, $order->company, $order->name, $order->year, $month[$order->quarter], $status,$progress_state, $user_type,$permission,$order->progress,$filterYear,$filterQuarter,$order->branch_id,$order->template_id);

				$i++;
			}
			uksort($tableRows, function($a1, $a2) {
			        $time1 = strtotime($a1);
			        $time2 = strtotime($a2);

			        return $time1 - $time2;
			    });

//			 print_r($tableRows);exit();
			$t_branch='';
			$t_qua='';
			if($target_quarter!="" && $target_quarter!="select month" && $target_branch!="" && $target_branch!="Select Option" && $target_year!="" && $target_year!="select year")
			{
				$t_branch=$target_branch;
				$t_qua=$target_quarter.' '.$target_year;
			}
			$c=1;
			foreach ($tableRows as $m_key => $m_value) {
				$m_true='false';
				$m_in='';
				if($t_qua==$m_key)
				{
					$m_true='true';
					$m_in='in';
				}
				$template_data=' <div aria-multiselectable="true" class="panel-group" id="monthaccordion'.$c.'" role="tablist">
								<div class="panel panel-default">
								    <div class="panel-heading month_color" id="month_heading'.$c.'" role="tab">
								      <h3 class="panel-title">
								      <a aria-controls="month_panel'.$c.'" aria-expanded="'.$m_true.'" data-parent="#monthaccordion'.$c.'" data-toggle="collapse"
										Triggers the collapsing JavaScript
										 href="#month_panel'.$c.'" role="button" onclick="setarrow(this)">'.$m_key.'<i class="fa fa-chevron-down f_right"></i></a></h3>
								    </div>
								    <div aria-labelledby="month_heading'.$c.'" class="panel-collapse collapse '.$m_in.'" id="month_panel'.$c.'" role="tabpanel">
								      <div class="panel-body">';
								      $b=1;
								      $template_data.='<div aria-multiselectable="true" class="panel-group" id="branchaccordion'.$c.'" role="tablist">';


														      $y=1;
								        					foreach ($m_value as $y_key => $y_value) {
																if($y_value[3]!=null && $y_value[3]!="") {
																	$template_data .= '<div aria-multiselectable="true" class="panel-group" id="yearaccordion' . $c . $y . '" role="tablist">
														      		  <div class="panel panel-default ">
														      		  	<div class="panel-heading year_color" id="year_heading' . $c . $y . '" role="tab">
														      		  		<h3 class="panel-title h3_right">
														      		  		<span class="col-md-4">' . $y_value[3] . '</span> ' . $y_value[8] . $y_value[9] . ' <a href="' . base_url() . 'upload_data?id=' . $y_value[1] . '&amp;template=' . $y_value[16] . '"><i class="fa fa-eye"></i></a> 
																			 <a href="' . base_url() . 'excelUploadValidation?id=' . $y_value[1] . '&amp;branch_id=' . $y_value[15] . '" class="m_left_1"><i class="fa fa-pencil"></i></a>
																			 	
																			 </h3>
														      		  	</div>
														      		  	
																		      ';
																	$template_data .= '
																		 
														      		  </div>
														      		  
														      	</div>';
																	$y++;
																}
								        					}

								      $template_data.='</div></div>
								    </div>
								  </div>
								  </div>';
					  array_push($data, array($template_data));
					  $c++;
			}

			// print_r($tableRows);exit();
		}
		$results = array(
			"draw" => 1,
			"recordsTotal" => count($data),
			"recordsFiltered" => count($data),
			"data" => $data,
			"query"=>$query
		);

		echo json_encode($results);
	}
//match unmatch data
	function getFinancialData_list()
	{
		$month = $this->Master_Model->getQuarter();
		$user_type = $this->session->userdata('user_type');
		$filterYear = $this->input->post("year");
		$filterQuarter = $this->input->post("quarter");
		$filterStatus = $this->input->post("status");
		$branch = $this->session->userdata("branch_id");
		$company = $this->session->userdata("company_id");;
		$template = '';
		$progress_state = "";
		$where = array("template_id" => 1);
		if (!is_null($filterYear) && $filterYear != -1) {
			$where["year"] = $filterYear;
		}
		if (!is_null($filterQuarter) && $filterQuarter != -1) {
			$where["quarter"] = $filterQuarter;
		}
		if (!is_null($filterStatus) && $filterStatus != -1) {
			$where["approve_status"] = $filterStatus;
		}
		if ($this->session->userdata('user_type') != 2) {
			$where["branch_id"] = $branch;
		}
		$branch_permission = $this->session->userdata('branch_permission');
		$array=array();
		if(!is_null($branch_permission)){
			$array=explode(",",$branch_permission);
		}

		$mbData = $this->db
			->select(array("*"))
			->where($where)
			->where('company_id', $company)
			->where_in('branch_id', $array)
			->order_by('id', 'desc')
			->get("excelsheet_master_data")->result();

		$query = $this->db->last_query();
		$tableRows = array();
		if (count($mbData) > 0) {
			$i = 1;
			foreach ($mbData as $order) {
				if ($order->approve_status == 1) {
					$status = '<span class="badge badge-success">Approved</span>';
				} else {
					$status = '<span class="badge badge-danger">Not Approve</span>';
				}
				if ($order->progress == 1) {
					$progress_state = '<span class="badge badge-success">Fully Matched</span>';
				} else {
					$progress_state = '<span class="badge badge-danger">Unmatched</span>';
				}
				$country_master = $this->Master_Model->country();

				$country = $country_master[1];
				$branch_name = $this->Master_Model->get_row_data("name", array('id' => $order->branch_id), 'branch_master');
				if (!empty($branch_name)) {
					$branch = $branch_name->name;
				}
				$company_name = $this->Master_Model->get_row_data("name", array('id' => $order->company_id), 'company_master');
				if (!empty($company_name)) {
					$company = $company_name->name;
				}
				$template_name = $this->Master_Model->get_row_data("template_name", array('id' => $order->template_id), 'template_master');
				if (!empty($template_name)) {
					$template = $template_name->template_name;
				}

				$CheckBlockwhere = array('year' => $order->year, 'month' => $order->quarter, 'company_id' => $order->company_id);
				$checkPermission = $this->Master_Model->checkBlockYearMonth($CheckBlockwhere);
				$permission = 0;
				if ($checkPermission == true) {
					$permission = 1;
				}
				$country_master = $this->Master_Model->getQuarter();

				array_push($tableRows, array($i, $order->id, $template, $branch, $company, $order->name, $order->year, $month[$order->quarter], $status, $progress_state, $user_type, $permission, $order->progress, $filterYear, $filterQuarter, $order->branch_id));

				$i++;
			}
		}
		$results = array(
			"draw" => 1,
			"recordsTotal" => count($mbData),
			"recordsFiltered" => count($mbData),
			"data" => $tableRows,
			"query" => $query
		);

		echo json_encode($results);
	}

	function getIntraCompanyTransfer()
	{
		$month = $this->Master_Model->getQuarter();
		$user_type = $this->session->userdata('user_type');
		$company_id = $this->session->userdata('company_id');
		$branch = '';
		$company = '';
		$template = '';
		$progress_state = "";
		$mbData = $this->db
			->select(array("*"))
			->where('template_id', 2)
			->where('company_id', $company_id)
			->order_by('id', 'desc')
			->get("excelsheet_master_data")->result();
		$tableRows = array();
		if (count($mbData) > 0) {
			$i = 1;
			foreach ($mbData as $order) {
				if ($order->approve_status == 1) {
					$status = '<span class="badge badge-success">Approved</span>';
				} else {
					$status = '<span class="badge badge-danger">Not Approve</span>';
				}
				if ($order->progress == 1) {
					$progress_state = '<span class="badge badge-success">Fully Matched</span>';
				} else {
					$progress_state = '<span class="badge badge-danger">Unmatched</span>';
				}
				$country_master = $this->Master_Model->country();
				$country = $country_master[1];
				$country_master = $this->Master_Model->getQuarter();

				$branch_name = $this->Master_Model->get_row_data("name", array('id' => $order->branch_id), 'branch_master');
				if (!empty($branch_name)) {
					$branch = $branch_name->name;
				}
				$company_name = $this->Master_Model->get_row_data("name", array('id' => $order->company_id), 'company_master');
				if (!empty($company_name)) {
					$company = $company_name->name;
				}
				$template_name = $this->Master_Model->get_row_data("template_name", array('id' => $order->template_id), 'template_master');
				if (!empty($template_name)) {
					$template = $template_name->template_name;
				}

				$CheckBlockwhere = array('year' => $order->year, 'month' => $order->quarter, 'company_id' => $order->company_id);
				$checkPermission = $this->Master_Model->checkBlockYearMonth($CheckBlockwhere);
				$permission = 0;
				if ($checkPermission == true) {
					$permission = 1;
				}

				array_push($tableRows, array($i, $order->id, $template, $branch, $company, $order->name, $order->year, $month[$order->quarter], $status, $progress_state, $user_type, $permission));

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

	public function getMatchUnMatchData()
	{
		$excelSheetMasterID = $this->input->post("id");
		$excelSheetObject = $this->Excelsheet_model->_select("excelsheet_master_data", array("id" => $excelSheetMasterID),
			array("template_id", "year", "quarter", "approve_status", "branch_id", "company_id","(select bm.transfer_type from branch_master bm where bm.id=branch_id) as transfer_type"));
		if ($excelSheetObject->totalCount > 0) {
			$template_id = $excelSheetObject->data->template_id;
			$year = $excelSheetObject->data->year;
			$quarter = $excelSheetObject->data->quarter;
			$branch_id = $excelSheetObject->data->branch_id;
			$company_id = $excelSheetObject->data->company_id;
			$transfer_type = $excelSheetObject->data->transfer_type;
			$response['transfer_type']=$transfer_type;
			$response["year"] = $year;
			$months = $this->Excelsheet_model->getQuarter();
			$response["month"] = $months[$quarter];
			$configurationWhere = array("template_id" => $template_id);
			$configurationSelect = array("attribute_type", "column_name", "table_name", "attribute_name", "attribute_query");
			$configurationRecords = $this->Excelsheet_model
				->_select("template_column_mapping", $configurationWhere, $configurationSelect,
					false, null, null, "sequence");
			$response["query"] = $configurationRecords->last_query;

			$unMatchRecords = array();
			$matchRecords = array();
			$header = array("id");
			if ($configurationRecords->totalCount > 0) {
				$templateTableName = $configurationRecords->data[0]->table_name;

				$objectID = new stdClass();
				$objectID->type = 'numeric';

				$columnsTypes = array($objectID);
				$sourceData = array();
				foreach ($configurationRecords->data as $configuration) {
					array_push($header, $configuration->attribute_name);
					$object = new stdClass();
					$object->type = 'text';
					switch ($configuration->attribute_type) {
						case "numeric":
							$object->type = 'numeric';
							break;
						case "date":
							$object->type = 'date';
							$object->dateFormat = 'M/D/YYYY';
							break;
					}
					if ($configuration->attribute_query != "") {
						$object->type = 'dropdown';
						$dropdownObject = $this->Excelsheet_model->_rawQuery($configuration->attribute_query);
						if ($dropdownObject->totalCount > 0) {
							$dropObjArray = array("");
							foreach ($dropdownObject->data as $dropValue) {
								array_push($dropObjArray, $dropValue->name);
							}
							$sourceData[$configuration->column_name] = $dropObjArray;
							$object->source = $dropObjArray;
						}
					}

					array_push($columnsTypes, $object);
				}

				$where = array(
					'branch_id' => $branch_id,
					'company_id' => $company_id,
					"year" => $year,
					"quarter" => $quarter);
				if($transfer_type==1 || $transfer_type==2)
				{
					$where['is_transfer']=1;
				}
				else{
					$where["sheet_master_id"] = $excelSheetMasterID;
					$where['is_transfer']=0;
				}

				$select = $header;
//				array_push($select,"(select (case when mm.type0='BS' then mm.type3 else mm.type2 end) from main_account_setup_master mm where mm.main_gl_number=gl_ac limit 1) as main_gl_detail");

//				"(select (case when mm.type0='BS' then mm.type3 else mm.type2 end) from main_account_setup_master mm where mm.main_gl_number=gl_ac limit 1) as main_gl_detail"
				$sheetRecords = $this->Excelsheet_model->_select($templateTableName, $where, $select, false);
			
				$mappedAccountNumbers = array();
				$unMappedAccountNumbers = array();
				$mainAccountDetail = array();
				if ($template_id == 1) {
					$mainAccountObjects = $this->Excelsheet_model->_select("main_account_setup_master", array("company_id" => $company_id), array("TRIM(main_gl_number) as main_gl_number", "name"), false);
					array_push($header, "Parent Account");

					if ($mainAccountObjects->totalCount > 0) {
						$object = new stdClass();
						$object->type = 'dropdown';
						$mAccounts = array();
						foreach ($mainAccountObjects->data as $mAccount) {
							array_push($mAccounts, $mAccount->main_gl_number);
							$mainAccountDetail[$mAccount->main_gl_number] = $mAccount->name;
						}
						$object->source = $mAccounts;
						array_push($columnsTypes, $object);
					} else {
						$object = new stdClass();
						$object->type = 'dropdown';
						$mAccounts = array();
						$object->source = $mAccounts;
						array_push($columnsTypes, $object);
					}
					$user_type = $this->session->userdata("user_type");
					if ($user_type == 2) {
						$whereAccount = array("find_in_set(branch_id,(select group_concat(branch_id) from branch_master where company_id = " . $company_id . " and branch_id = " . $branch_id . "))<>" => 0);
					} else {
						$whereAccount = array("find_in_set(branch_id," . $branch_id . ")<>" => 0);
					}
					$checkingResultObject = $this->Excelsheet_model->_select("branch_account_setup", $whereAccount, array("id", "TRIM(account_number) as account_number", "TRIM(parent_account_number) as parent_account_number"), false);
					$response["checkResult"] = $checkingResultObject;
					if ($checkingResultObject->totalCount > 0) {
						foreach ($checkingResultObject->data as $items) {
							if ($items->parent_account_number != null && $items->parent_account_number != "" && in_array($items->parent_account_number, $mAccounts)) {

								$mappedAccountNumbers[$items->account_number] = $items;
							} else {
								$unMappedAccountNumbers[$items->account_number] = $items;
							}
						}
					}


				}
				array_push($header, "Parent Detail");
				$object = new stdClass();
				$object->type = 'text';
				array_push($columnsTypes, $object);

				$openingBalnceSum = 0;
				$DebitSum = 0;
				$creditSum = 0;
				$TotalSum = 0;
				foreach ($sheetRecords->data as $record) {
					$isRowValidated = false;
					$matchParent = null;

					foreach ($configurationRecords->data as $configuration) {

						if (property_exists($record, $configuration->column_name)) {

							$typeCheck = true;
							$recordValue = $record->{$configuration->column_name};
							switch ($configuration->attribute_type) {
								case "numeric":
									$typeCheck = is_numeric($recordValue);
									break;
								case "date":
									$typeCheck = preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $recordValue);
									break;
							}
							if (array_key_exists($configuration->column_name, $sourceData)) {
								$filterSourceData = $sourceData[$configuration->column_name];
								if (array_search($recordValue, $filterSourceData) == false) {
									$typeCheck = false;
								}
							}

							if ($template_id == 1) {
								if ($configuration->column_name == "gl_ac") {
									if (array_key_exists($recordValue, $mappedAccountNumbers)) {
										$typeCheck = true;
										$matchParent = $mappedAccountNumbers[$recordValue]->parent_account_number;
										if (array_key_exists($recordValue, $unMappedAccountNumbers)) {
											$typeCheck = false;
										}
									} else {
										$typeCheck = false;
									}

								}
							}

							// print_r($typeCheck);
							if ($typeCheck) {
								$isRowValidated = true;
								continue;
							} else {
								$record->parentDetail = '';
								array_push($unMatchRecords, array_values((array)$record));
								break;
							}
						}
					}
					$openingBalnceSum += ($record->opening_balance);
					$DebitSum += ($record->debit);
					$creditSum += ($record->credit);
					$TotalSum += ($record->total);

					if ($isRowValidated) {
						$record->parentAccount = $matchParent;
						$record->parentDetail = '';
						if (count($mainAccountDetail) > 0) {
							if (array_key_exists($matchParent, $mainAccountDetail)) {
								$record->parentDetail = $mainAccountDetail[$matchParent];
							}
						}
						array_push($matchRecords, array_values((array)$record));
					}
				}

				$response["sheetData"] = $sheetRecords->data;
				// exit();
				$response["maapingAccount"] = $mappedAccountNumbers;
				$response["unMaapedAccount"] = $unMappedAccountNumbers;
				$response["source"] = $sourceData;
				$response["status"] = 200;
				$response["unMatch"] = $unMatchRecords;
				$response["openingBalnceSum"] = $openingBalnceSum;
				$response["DebitSum"] = $DebitSum;
				$response["creditSum"] = $creditSum;
				$response["TotalSum"] = $TotalSum;
				$response["match"] = $matchRecords;
				$response["types"] = $columnsTypes;
				$response["header"] = $header;
				$response['approve_status'] = $excelSheetObject->data->approve_status;
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


	public function getMatchUnMatchDataUs()
	{
		$excelSheetMasterID = $this->input->post("id");
		$excelSheetObject = $this->Excelsheet_model->_select("excelsheet_master_data", array("id" => $excelSheetMasterID),
			array("template_id", "year", "quarter", "approve_status", "branch_id", "company_id"));

		if ($excelSheetObject->totalCount > 0) {
			$template_id = $excelSheetObject->data->template_id;
			$year = $excelSheetObject->data->year;
			$quarter = $excelSheetObject->data->quarter;
			$branch_id = $excelSheetObject->data->branch_id;
			$company_id = $excelSheetObject->data->company_id;
			$response["year"] = $year;
			$months = $this->Excelsheet_model->getQuarter();
			$response["month"] = $months[$quarter];
			$configurationWhere = array("template_id" => $template_id);
			$configurationSelect = array("attribute_type", "column_name", "table_name", "attribute_name", "attribute_query");
			$configurationRecords = $this->Excelsheet_model
				->_select("template_column_mapping", $configurationWhere, $configurationSelect,
					false, null, null, "sequence");
			$response["query"] = $configurationRecords->last_query;

			$unMatchRecords = array();
			$matchRecords = array();
			$header = array("id");
			if ($configurationRecords->totalCount > 0) {
				$templateTableName = $configurationRecords->data[0]->table_name;

				$objectID = new stdClass();
				$objectID->type = 'numeric';

				$columnsTypes = array($objectID);
				$sourceData = array();
				foreach ($configurationRecords->data as $configuration) {
					array_push($header, $configuration->attribute_name);
					$object = new stdClass();
					$object->type = 'text';
					switch ($configuration->attribute_type) {
						case "numeric":
							$object->type = 'numeric';
							break;
						case "date":
							$object->type = 'date';
							$object->dateFormat = 'M/D/YYYY';
							break;
					}
					if ($configuration->attribute_query != "") {
						$object->type = 'dropdown';
						$dropdownObject = $this->Excelsheet_model->_rawQuery($configuration->attribute_query);
						if ($dropdownObject->totalCount > 0) {
							$dropObjArray = array("");
							foreach ($dropdownObject->data as $dropValue) {
								array_push($dropObjArray, $dropValue->name);
							}
							$sourceData[$configuration->column_name] = $dropObjArray;
							$object->source = $dropObjArray;
						}
					}

					array_push($columnsTypes, $object);
				}

				$where = array(
					'branch_id' => $branch_id,
					'company_id' => $company_id,
					"sheet_master_id" => $excelSheetMasterID,
					"year" => $year,
					"quarter" => $quarter,"is_transfer"=>0);
				$select = $header;

				$sheetRecords = $this->Excelsheet_model->_select($templateTableName, $where, $select, false);

				$mappedAccountNumbers = array();
				$unMappedAccountNumbers = array();
				if ($template_id == 1) {
					$user_type = $this->session->userdata("user_type");
					if ($user_type == 2) {
						$whereAccount = array("find_in_set(branch_id,(select group_concat(branch_id) from branch_master where company_id = " . $company_id . " and branch_id = " . $branch_id . "))<>" => 0);
					} else {
						$whereAccount = array("find_in_set(branch_id," . $branch_id . ")<>" => 0);
					}
					$checkingResultObject = $this->Excelsheet_model->_select("branch_account_setup", $whereAccount, array("id", "TRIM(account_number) as account_number", "TRIM(parent_account_number_us) as parent_account_number_us"), false);
					$response["checkResult"] = $checkingResultObject;
					if ($checkingResultObject->totalCount > 0) {
						foreach ($checkingResultObject->data as $items) {
							if ($items->parent_account_number_us != null || $items->parent_account_number_us != "") {
								$mappedAccountNumbers[$items->account_number] = $items;
							} else {
								$unMappedAccountNumbers[$items->account_number] = $items;
							}
						}
					}
					$mainAccountDetail = array();
					$mainAccountObjects = $this->Excelsheet_model->_select("main_account_setup_master_us", array("company_id" => $company_id), "TRIM(main_gl_number) as main_gl_number,name", false);
					array_push($header, "Parent Account");
					if ($mainAccountObjects->totalCount > 0) {
						$object = new stdClass();
						$object->type = 'dropdown';
						$mAccounts = array();
						foreach ($mainAccountObjects->data as $mAccount) {
							array_push($mAccounts, $mAccount->main_gl_number);
							$mainAccountDetail[$mAccount->main_gl_number] = $mAccount->name;
						}
						$object->source = $mAccounts;
						array_push($columnsTypes, $object);
					} else {
						$object = new stdClass();
						$object->type = 'dropdown';
						$mAccounts = array();
						$object->source = $mAccounts;
						array_push($columnsTypes, $object);
					}

				}
				array_push($header, "Parent Detail");
				$object = new stdClass();
				$object->type = 'text';
				array_push($columnsTypes, $object);

				$openingBalnceSum = 0;
				$DebitSum = 0;
				$creditSum = 0;
				$TotalSum = 0;
				foreach ($sheetRecords->data as $record) {
					$isRowValidated = false;
					$matchParent = null;
					foreach ($configurationRecords->data as $configuration) {

						if (property_exists($record, $configuration->column_name)) {

							$typeCheck = true;
							$recordValue = $record->{$configuration->column_name};
							switch ($configuration->attribute_type) {
								case "numeric":
									$typeCheck = is_numeric($recordValue);
									break;
								case "date":
									$typeCheck = preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $recordValue);
									break;
							}
							if (array_key_exists($configuration->column_name, $sourceData)) {
								$filterSourceData = $sourceData[$configuration->column_name];
								if (array_search($recordValue, $filterSourceData) == false) {
									$typeCheck = false;
								}
							}

							if ($template_id == 1) {
								if ($configuration->column_name == "gl_ac") {
									if (array_key_exists($recordValue, $mappedAccountNumbers)) {
										$typeCheck = true;
										$matchParent = $mappedAccountNumbers[$recordValue]->parent_account_number_us;
										if (array_key_exists($recordValue, $unMappedAccountNumbers)) {
											$typeCheck = false;
										}
									} else {
										$typeCheck = false;
									}

								}
							}
							// print_r($typeCheck);
							if ($typeCheck) {
								$isRowValidated = true;
								continue;
							} else {
								$record->parentDetail = '';
								array_push($unMatchRecords, array_values((array)$record));
								break;
							}
						}
					}
					$openingBalnceSum += ($record->opening_balance);
					$DebitSum += ($record->debit);
					$creditSum += ($record->credit);
					$TotalSum += ($record->total);

					if ($isRowValidated) {
						$record->parentAccount = $matchParent;
						$record->parentDetail = '';
						if (count($mainAccountDetail) > 0) {
							if (array_key_exists($matchParent, $mainAccountDetail)) {
								$record->parentDetail = $mainAccountDetail[$matchParent];
							}
						}
						array_push($matchRecords, array_values((array)$record));
					}
				}
				$response["sheetData"] = $sheetRecords->data;
				// exit();
				$response["maapingAccount"] = $mappedAccountNumbers;
				$response["unMaapedAccount"] = $unMappedAccountNumbers;
				$response["source"] = $sourceData;
				$response["status"] = 200;
				$response["unMatch"] = $unMatchRecords;
				$response["match"] = $matchRecords;
				$response["types"] = $columnsTypes;
				$response["header"] = $header;
				$response['approve_status'] = $excelSheetObject->data->approve_status;
				$response["unMatch"] = $unMatchRecords;
				$response["openingBalnceSum"] = $openingBalnceSum;
				$response["DebitSum"] = $DebitSum;
				$response["creditSum"] = $creditSum;
				$response["TotalSum"] = $TotalSum;
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

	public function getMatchUnMatchDataIfrs()
	{
		$excelSheetMasterID = $this->input->post("id");
		$excelSheetObject = $this->Excelsheet_model->_select("excelsheet_master_data", array("id" => $excelSheetMasterID),
			array("template_id", "year", "quarter", "approve_status", "branch_id", "company_id"));

		if ($excelSheetObject->totalCount > 0) {
			$template_id = $excelSheetObject->data->template_id;
			$year = $excelSheetObject->data->year;
			$quarter = $excelSheetObject->data->quarter;
			$branch_id = $excelSheetObject->data->branch_id;
			$company_id = $excelSheetObject->data->company_id;
			$response["year"] = $year;
			$months = $this->Excelsheet_model->getQuarter();
			$response["month"] = $months[$quarter];
			$configurationWhere = array("template_id" => $template_id);
			$configurationSelect = array("attribute_type", "column_name", "table_name", "attribute_name", "attribute_query");
			$configurationRecords = $this->Excelsheet_model
				->_select("template_column_mapping", $configurationWhere, $configurationSelect,
					false, null, null, "sequence");
			$response["query"] = $configurationRecords->last_query;

			$unMatchRecords = array();
			$matchRecords = array();
			$header = array("id");
			if ($configurationRecords->totalCount > 0) {
				$templateTableName = $configurationRecords->data[0]->table_name;

				$objectID = new stdClass();
				$objectID->type = 'numeric';

				$columnsTypes = array($objectID);
				$sourceData = array();
				foreach ($configurationRecords->data as $configuration) {
					array_push($header, $configuration->attribute_name);
					$object = new stdClass();
					$object->type = 'text';
					switch ($configuration->attribute_type) {
						case "numeric":
							$object->type = 'numeric';
							break;
						case "date":
							$object->type = 'date';
							$object->dateFormat = 'M/D/YYYY';
							break;
					}
					if ($configuration->attribute_query != "") {
						$object->type = 'dropdown';
						$dropdownObject = $this->Excelsheet_model->_rawQuery($configuration->attribute_query);
						if ($dropdownObject->totalCount > 0) {
							$dropObjArray = array("");
							foreach ($dropdownObject->data as $dropValue) {
								array_push($dropObjArray, $dropValue->name);
							}
							$sourceData[$configuration->column_name] = $dropObjArray;
							$object->source = $dropObjArray;
						}
					}

					array_push($columnsTypes, $object);
				}

				$where = array(
					'branch_id' => $branch_id,
					'company_id' => $company_id,
					"sheet_master_id" => $excelSheetMasterID,
					"year" => $year,
					"quarter" => $quarter,"is_transfer"=>0);
				$select = $header;

				$sheetRecords = $this->Excelsheet_model->_select($templateTableName, $where, $select, false);

				$mappedAccountNumbers = array();
				$unMappedAccountNumbers = array();
				if ($template_id == 1) {

					$user_type = $this->session->userdata("user_type");
					if ($user_type == 2) {
						$whereAccount = array("find_in_set(branch_id,(select group_concat(branch_id) from branch_master where company_id = " . $company_id . " and branch_id = " . $branch_id . "))<>" => 0);
					} else {
						$whereAccount = array("find_in_set(branch_id," . $branch_id . ")<>" => 0);
					}
					$checkingResultObject = $this->Excelsheet_model->_select("branch_account_setup", $whereAccount, array("id", "TRIM(account_number) as account_number", "TRIM(parent_account_number_ifrs) as parent_account_number_ifrs"), false);
					$response["checkResult"] = $checkingResultObject;
					if ($checkingResultObject->totalCount > 0) {
						foreach ($checkingResultObject->data as $items) {
							if ($items->parent_account_number_ifrs != null || $items->parent_account_number_ifrs != "") {
								$mappedAccountNumbers[$items->account_number] = $items;
							} else {
								$unMappedAccountNumbers[$items->account_number] = $items;
							}
						}
					}
					$mainAccountDetail = array();
					$mainAccountObjects = $this->Excelsheet_model->_select("main_account_setup_master_ifrs", array("company_id" => $company_id), "TRIM(main_gl_number) as main_gl_number,name", false);
					array_push($header, "Parent Account");
					if ($mainAccountObjects->totalCount > 0) {
						$object = new stdClass();
						$object->type = 'dropdown';
						$mAccounts = array();
						foreach ($mainAccountObjects->data as $mAccount) {
							array_push($mAccounts, $mAccount->main_gl_number);
							$mainAccountDetail[$mAccount->main_gl_number] = $mAccount->name;

						}
						$object->source = $mAccounts;
						array_push($columnsTypes, $object);
					} else {
						$object = new stdClass();
						$object->type = 'dropdown';
						$mAccounts = array();
						$object->source = $mAccounts;
						array_push($columnsTypes, $object);
					}

				}
				array_push($header, "Parent Detail");
				$object1 = new stdClass();
				$object1->type = 'text';
				array_push($columnsTypes, $object1);

				$openingBalnceSum = 0;
				$DebitSum = 0;
				$creditSum = 0;
				$TotalSum = 0;
				foreach ($sheetRecords->data as $record) {
					$isRowValidated = false;
					$matchParent = null;
					foreach ($configurationRecords->data as $configuration) {

						if (property_exists($record, $configuration->column_name)) {

							$typeCheck = true;
							$recordValue = $record->{$configuration->column_name};
							switch ($configuration->attribute_type) {
								case "numeric":
									$typeCheck = is_numeric($recordValue);
									break;
								case "date":
									$typeCheck = preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $recordValue);
									break;
							}
							if (array_key_exists($configuration->column_name, $sourceData)) {
								$filterSourceData = $sourceData[$configuration->column_name];
								if (array_search($recordValue, $filterSourceData) == false) {
									$typeCheck = false;
								}
							}
							if ($template_id == 1) {
								if ($configuration->column_name == "gl_ac") {
									if (array_key_exists($recordValue, $mappedAccountNumbers)) {
										$typeCheck = true;
										$matchParent = $mappedAccountNumbers[$recordValue]->parent_account_number_ifrs;
										if (array_key_exists($recordValue, $unMappedAccountNumbers)) {
											$typeCheck = false;
										}
									} else {
										$typeCheck = false;
									}

								}
							}
							// print_r($typeCheck);
							if ($typeCheck) {
								$isRowValidated = true;
								continue;
							} else {
								$record->parentDetail = '';
								array_push($unMatchRecords, array_values((array)$record));
								break;
							}
						}
					}
					$openingBalnceSum += ($record->opening_balance);
					$DebitSum += ($record->debit);
					$creditSum += ($record->credit);
					$TotalSum += ($record->total);

					if ($isRowValidated) {
						$record->parentAccount = $matchParent;
						$record->parentDetail = '';
						if (count($mainAccountDetail) > 0) {
							if (array_key_exists($matchParent, $mainAccountDetail)) {
								$record->parentDetail = $mainAccountDetail[$matchParent];
							}
						}
						array_push($matchRecords, array_values((array)$record));
					}
				}
				$response["sheetData"] = $sheetRecords->data;
				// exit();
				$response["maapingAccount"] = $mappedAccountNumbers;
				$response["unMaapedAccount"] = $unMappedAccountNumbers;
				$response["source"] = $sourceData;
				$response["status"] = 200;
				$response["unMatch"] = $unMatchRecords;
				$response["match"] = $matchRecords;
				$response["types"] = $columnsTypes;
				$response["header"] = $header;
				$response['approve_status'] = $excelSheetObject->data->approve_status;
				$response["unMatch"] = $unMatchRecords;
				$response["openingBalnceSum"] = $openingBalnceSum;
				$response["DebitSum"] = $DebitSum;
				$response["creditSum"] = $creditSum;
				$response["TotalSum"] = $TotalSum;
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

	public function getCompanyBranchList()
	{
		$array=array();
		$branch_permission = $this->session->userdata('branch_permission');
		if(!is_null($branch_permission)){
			$array=explode(",",$branch_permission);
		}
		$branch_list = $this->Master_Model->get_all_data(array('company_id' => $this->session->userdata('company_id'), 'status' => 1), 'branch_master');
//		get_all_table_data('branch_master');
		$data = array();
		$option = "<option selected disabled>Select Option</option>";
		if (count($branch_list) > 0) {
			foreach ($branch_list as $row) {
				if(in_array($row->id,$array)) {
					$option .= "<option value='" . $row->id . "'>" . $row->name . "</option>";
				}
			}
			$response['data'] = $option;
			$response['status'] = 200;

		} else {
			$response['data'] = $option;
			$response['status'] = 201;
		}
		echo json_encode($response);
	}

	public function saveCopyFiancialData()
	{

		$Data1 = $this->input->post('arrData');
		$sheet_master_id = $this->input->post('insertID');
		$branch_id = $this->input->post('branchID');
		$debitCheck = $this->input->post('debitCheck');
		// $creditCheck = $this->input->post('creditCheck');
		$arrData = json_decode($Data1);
		$user_id = $this->session->userdata('user_id');
		$company_id = $this->session->userdata('company_id');

		$check_entry = $this->db->where(array('id' => $sheet_master_id))->get('excelsheet_master_data')->row();
		$getDetails = $this->Master_Model->_rawQuery("select detail,account_number,parent_account_number,(case when (select id from main_account_setup_master mm where mm.main_gl_number=b.parent_account_number and mm.company_id=b.company_id and mm.type0='PL' limit 1) is not null then 1 else 0 end) as typeINDExists,(case when (select id from main_account_setup_master_us mm where mm.main_gl_number=b.parent_account_number_us and mm.company_id=b.company_id and mm.type0='PL' limit 1) is not null then 1 else 0 end) as typeUSExists,(case when (select id from main_account_setup_master_ifrs mm where mm.main_gl_number=b.parent_account_number_ifrs and mm.company_id=b.company_id and mm.type0='PL' limit 1) is not null then 1 else 0 end) as typeIFRSExists from branch_account_setup b where company_id=" . $company_id . " AND branch_id=" . $branch_id);
		// print_r($this->db);exit();
		$glArray = array();
		$parentArray = array();
		if ($getDetails->totalCount > 0) {
			$result = $getDetails->data;
			foreach ($result as $row) {
				$glArray[$row->account_number] = $row->detail;
				if ($row->parent_account_number != null) {
					$type1 = 0;
					if ($row->typeINDExists == 1 || $row->typeUSExists == 1 || $row->typeIFRSExists == 1) {
						$type1 = 1;
					}
					$parentArray[$row->account_number] = $type1;
				}
			}
		}
		if (!empty($arrData)) {
			if (!empty($check_entry)) {
				$id = $check_entry->id;

				$indexArray = array();
				$newArray = array();
				$openingArray = array();
				$i = 1;
				foreach ($arrData as $item) {
					if ($item[0] != "") {
						if ($debitCheck == 1) {
							$item[2] = 0;
							$item[3] = 0;
							$item[4] = 0;
						}
						// if($creditCheck==1)
						// {
						// 	$item[3]=0;
						// }
						$detail = $item[1];
						if (count($glArray) > 0) {
							if (array_key_exists($item[0], $glArray)) {
								$detail = $glArray[$item[0]];
								if (array_key_exists($item[0], $parentArray)) {
									if ($parentArray[$item[0]] == 1 && $item[2] > 0) {
										$opda = '';
										$opda .= "C" . $i;
										array_push($openingArray, $opda);
									}
								}
							}
						}
						if($item[5] == null){
							$item[5] = 0;
						}
						$data = array(
							"gl_ac" => $item[0],
							"detail" => $detail,
							"opening_balance" => $item[2],
							"debit" => $item[3],
							"credit" => $item[4],
							"total" => $item[5],
							"year" => $check_entry->year,
							"quarter" => $check_entry->quarter,
							"branch_id" => $branch_id,
							"created_on" => date('Y-m-d H:i:s'),
							"created_by" => $user_id,
							"user_id" => $user_id,
							"company_id" => $company_id,
							"sheet_master_id" => $sheet_master_id
						);
						array_push($newArray, $data);
					} else {
						$da = '';
						if ($item[0] == "") {
							$da .= "A" . $i;
						}
//						if ($item[5] == "" || $item[5] != 0) {
//							$da .= "F" . $i;
//						}
						array_push($indexArray, $da);

					}
					$i++;

				}
				// print_r($newArray);exit();
				if (!empty($indexArray) || !empty($openingArray)) {
					if (!empty($indexArray)) {
						$response['type'] = 1;
						$response['body'] = implode(',', array_unique($indexArray));
					} else {
						$response['type'] = 2;
						$response['opening'] = implode(',', array_unique($openingArray));
					}
					$response['status'] = 202;
				} else {
					if (!empty($newArray)) {
						$this->db->where(array('year' => $check_entry->year, 'quarter' => $check_entry->quarter, 'branch_id' => $branch_id,"is_transfer"=>0))->delete('upload_financial_data');
						$insert_batch = $this->db->insert_batch("upload_financial_data", $newArray);
						if ($insert_batch == true) {
							$response['status'] = 200;
							$response['body'] = "Data uploaded Successfully";
						} else {
							$response['status'] = 201;
							$response['body'] = "Failed To uplaod";
						}
					} else {
						$response['status'] = 201;
						$response['body'] = "No data for add";
					}
				}

			} else {
				$response['status'] = 201;
				$response['body'] = "No data for add";
			}
		} else {
			$response['body'] = 'No data for save';
			$response['status'] = 201;
		}
		echo json_encode($response);

	}

	public function saveCopyFiancialDataPrevious()
	{

		$Data1 = $this->input->post('arrData');
		$branch_id = $this->input->post('branchID');
		$debitCheck = $this->input->post('debitCheck');
		$year = $this->input->post('year');
		$quarter = $this->input->post('quarter');
		// $creditCheck = $this->input->post('creditCheck');
		$arrData = json_decode($Data1);
		$user_id = $this->session->userdata('user_id');
		$company_id = $this->session->userdata('company_id');

		if (!empty($arrData)) {
			$indexArray = array();
			$newArray = array();
			$newArray2 = array();
			$i = 1;
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

			foreach ($arrData as $itemData) {
				$arrOB[$itemData[0]][] = $itemData[1];
				$arrDr[$itemData[0]][] = $itemData[2];
				$arrCr[$itemData[0]][] = $itemData[3];
				$arrTotal[$itemData[0]][] = $itemData[4];
				$arrOB2[$itemData[0]][] = $itemData[5];
				$arrDr2[$itemData[0]][] = $itemData[6];
				$arrCr2[$itemData[0]][] = $itemData[7];
				$arrTotal2[$itemData[0]][] = $itemData[8];
			}
			$data1 = array();
			$data2 = array();
			$data3 = array();
			$data1_a = array();
			$data2_a = array();
			$data3_a = array();

			$glac_mapping = $this->db->query('SELECT main_gl_number,1 as type FROM main_account_setup_master where company_id =' . $company_id . ' union SELECT main_gl_number,2 as type FROM main_account_setup_master_us where company_id = ' . $company_id . ' union SELECT main_gl_number,3 as type FROM main_account_setup_master_ifrs where company_id = ' . $company_id)->result();

			foreach ($glac_mapping as $gl_value) {
				$glAc_ind[$gl_value->main_gl_number][] = $gl_value->type;
			}
			foreach ($arrOB as $key => $value) {
				if (array_key_exists($key, $glAc_ind)) {

					if (in_array(1, $glAc_ind[$key])) {
						$data1a = array(
							'account_number' => $key,
							'final_total' => array_sum($arrTotal[$key]),
							'opening_balance' => array_sum($arrOB),
							'debit' => array_sum($arrDr[$key]),
							'credit' => array_sum($arrCr[$key]),
							'total' => array_sum($arrTotal[$key]),

							'opening_balance_1' => array_sum($arrOB2),
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
							'opening_balance' => array_sum($arrOB),
							'debit' => array_sum($arrDr[$key]),
							'credit' => array_sum($arrCr[$key]),
							'total' => array_sum($arrTotal[$key]),

							'opening_balance_1' => array_sum($arrOB2),
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
							'opening_balance' => array_sum($arrOB),
							'debit' => array_sum($arrDr[$key]),
							'credit' => array_sum($arrCr[$key]),
							'total' => array_sum($arrTotal[$key]),

							'opening_balance_1' => array_sum($arrOB2),
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
		} else {
			$response['body'] = 'No data for save';
			$response['status'] = 201;
		}
		echo json_encode($response);

	}
	public function saveCopyIntraData1()
	{
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		$Data1 = $this->input->post('arrData');
		$sheet_master_id = $this->input->post('insertID');
		$transferType = $this->input->post('transferType');
		// $branch_id = $this->input->post('branchID');
		$debitCheck = $this->input->post('debitCheck');
		$creditCheck = $this->input->post('creditCheck');
		$arrData = json_decode($Data1);
//		 print_r($arrData);exit();
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		$company_id = $this->session->userdata('company_id');

		$checKCurrencyConversion = $this->Master_Model->get_count(array('company_id' => $company_id, 'year' => $year, 'month' => $month), 'currency_conversion_master');
		if ($checKCurrencyConversion == 0) {
			$response['status'] = 201;
			$response['body'] = 'Currency Conversion for this Month is not Done';
			echo json_encode($response);
			exit();
		} else {
			$specialBranchIdIntraCompany="";
			$specialBranchIdInterCompany="";
			$specialBranchObject=$this->Master_Model->_select('branch_master b',array('company_id'=>$company_id,'is_special_branch'=>1),'*,
			(select group_concat(intra_gl_account,",",inter_gl_account) from subsidiary_mapping m where m.company_id=b.company_id) as GlMapping',false);

			if($specialBranchObject->totalCount>0)
			{
				$IntraGl="";
				$InterGl="";
				foreach ($specialBranchObject->data as $row){
					if($row->transfer_type == 1){
						$specialBranchIdIntraCompany=$row->id;
					}
					if($row->transfer_type == 2){
						$specialBranchIdInterCompany=$row->id;
					}
					if($row->GlMapping != null){
						$exp=explode(",",$row->GlMapping);
						$IntraGl=$exp[0];
						$InterGl=$exp[1];
					}
				}
			}
			$specialBranch="";
			if($transferType == 1){
				$specialBranch=$specialBranchIdIntraCompany;
			}else{
				$specialBranch=$specialBranchIdInterCompany;
			}
			$check_entry = $this->db->where(array('id' => $sheet_master_id))->get('excelsheet_master_data')->row();
			// print_r($check_entry);exit();
			$company_master = $this->Master_Model->getComapnyCurrency();
			$branch_master = $this->Master_Model->getBranchCurrency();

			if (!empty($arrData)) {
				if (!empty($check_entry)) {
					$id = $check_entry->id;

					$approve_status = 0;
					if ($user_type == 2) {
						$approve_status = 1;
					}
					$newArray = array();
					$financialData=array();
					foreach ($arrData as $item) {
//						 print_r($item);exit();
						if ($item[0] != "" && $item[2] != "" && $item[9] != "" && $item[11] != "") {
							$fromBranch = explode('-', $item[0]);
							if (count($fromBranch) > 1) {
								$item[0] = $fromBranch[0];
							}
							$toBranch = explode('-', $item[9]);
							if (count($toBranch) > 1) {
								$item[9] = $toBranch[0];
							}
							if ($item[6] == "") {
								if ($check_entry->holding_type == 1) {
									//company
									if ($company_master[$company_id] != null) {
										$item[6] = $company_master[$company_id];
									}

								} else { //branch
									$item[6] = $branch_master[$item[0]];
								}

							}
							if ($item[15] == "") {
								if ($check_entry->holding_type == 1) {
									//company
									if ($company_master[$company_id] != null) {
										$item[15] = $company_master[$company_id];
									}
								} else { //branch
									$item[15] = $branch_master[$item[9]];
								}
							}
							$from = 1;
							$to = 1;
							if ($item[6] != "INR") {
								$FromRate = $this->Master_Model->_select('currency_conversion_master', array('company_id' => $company_id, 'year' => $year, 'month' => $month, 'currency' => $item[6]), 'rate', true)->data;
								if($FromRate!="") {
									$from = $FromRate->rate;
								}
							}
							if ($item[15] != "INR") {
								$ToRate = $this->Master_Model->_select('currency_conversion_master', array('company_id' => $company_id, 'year' => $year, 'month' => $month, 'currency' => $item[15]), 'rate', true)->data;
								if($ToRate!="")
								{
									$to = $ToRate->rate;
								}
							}

							$rateFrom=$item[7]; // from currency rate
							if($rateFrom=="")
							{
								$rateFrom=1;
							}
							$rateTo=$item[16]; // to currency rate
							if($rateTo=="")
							{
								$rateTo=1;
							}

							$from_debit = ((is_numeric($item[3])) ? $item[3]: 1)  * $rateFrom;
							$from_credit = ((is_numeric($item[4])) ? $item[4]: 1) * $rateFrom;

							$to_debit =  ((is_numeric($item[12])) ? $item[12]: 1) * $rateTo;
							$to_credit =  ((is_numeric($item[13])) ? $item[13]: 1) * $rateTo;

							$d1=( ((is_numeric($item[3])) ? $item[3]: 1) - ((is_numeric($item[4])) ? $item[4]: 1))*$rateFrom;
							$d2=(((is_numeric($item[12])) ? $item[12]: 1) - ((is_numeric($item[13])) ? $item[13]: 1))*$rateTo;
							// $debit_difference = $from_debit - $to_debit;
							// $credit_difference = $from_credit - $to_credit;
							$debit_difference = $d2 + $d1;
							$credit_difference = 0;
//							$itemfrom=$item[3]-$item[4];
//							$itemto=$item[10]-$item[11];
//							$item[14]=$itemfrom+$itemto;
//
							$diff_gl = explode('-', $item[21]);
							if (count($diff_gl) > 1) {
								$item[21] = $diff_gl[0];
							}
							$fromTotal=($item[3]-$item[4])*$rateFrom; // from debit - from credit * from currency_rate
							$toTotal=($item[12]-$item[13])*$rateTo; // to debit - to credit * to currency_rate
//							$finalValue=(-$fromTotal-$toTotal);//old changes
							$finalValue=-($fromTotal+$toTotal); //changes suggest by bharat
							$data = array(
								"from_branch_id" => $item[0],
								"from_gl_account" => $item[2],
								"from_debit" => $item[3],
								"from_credit" => $item[4],
								"from_given_by" => $item[5],
								"from_currency" => $item[6],
								"from_currency_rate"=>$item[7],
								"from_totalValue"=>$fromTotal, //$item[8],
								"to_branch_id" => $item[9],
								"to_gl_account" => $item[11],
								"to_debit" => $item[12],
								"to_credit" => $item[13],
								"to_given_by" => $item[14],
								"to_currency" => $item[15],
								"to_currency_rate"=>$item[16],
								"to_totalValue"=>$toTotal, //$item[17],
								"final_value"=>$finalValue, //$item[20],
								"difference" => $debit_difference,
								"difference_credit" => $credit_difference,
								"year" => $check_entry->year,
								"quarter" => $check_entry->quarter,
								"created_on" => date('Y-m-d H:i:s'),
								"created_by" => $user_id,
								"user_id" => $user_id,
								"company_id" => $company_id,
								"sheet_master_id" => $sheet_master_id,
								"approve_status" => $approve_status,
								"cur_to_debit" => $to_debit,
								"cur_to_credit" => $to_credit,
								"cur_from_debit" => $from_debit,
								"cur_from_credit" => $from_credit,
								"transfer_type" => $transferType,
								"difference_gl" => $item[21],
							);
							array_push($newArray, $data);
							/*if($transferType == 1){
								$glAct=$IntraGl;
							}else{
								$glAct=$InterGl;
							}*/
							if(!empty($specialBranch))
							{
								if($finalValue!=0)
								{
									$finArr=array('gl_ac'=>$item[21],
										'debit'=>$fromTotal, //$item[17],//from total
										'credit'=>$toTotal,//$item[8],//to total
										'total'=>$finalValue,//$item[20],
										'detail'=>'',
										'year'=>$check_entry->year,
										'quarter'=>$check_entry->quarter,
										'branch_id'=>$specialBranch,
										'company_id'=>$company_id,
										'user_id'=>$user_id,
										'created_by'=>$user_id,
										'created_on'=>date('Y-m-d H:i:s'),
										'is_transfer'=>1,
										'transfer_type'=>$transferType,
										'sheet_master_id'=>0,
										'is_difference_value'=>1);
									array_push($financialData,$finArr);
								}
							}
						}
					}
					print_r($newArray);exit();
					if (!empty($newArray)) {
						$result = false;
						try {
							$this->db->trans_start();
							$this->db->where(array('sheet_master_id' => $sheet_master_id, 'year' => $check_entry->year, 'quarter' => $check_entry->quarter, 'company_id' => $company_id,'transfer_type'=>$transferType))->delete('upload_intra_company_transfer');
							$insert_batch = $this->db->insert_batch("upload_intra_company_transfer", $newArray);
							if($insert_batch == true){
								$resultReturn=$this->uploadConsolidateTransaction($newArray,$check_entry->year,$check_entry->quarter,$specialBranch,$transferType);
								if(!empty($financialData))
								{
									//	$this->db->where(array( 'year' => $check_entry->year, 'quarter' => $check_entry->quarter, 'company_id' => $company_id,'is_transfer'=>1,'transfer_type'=>$transferType,))->delete('upload_financial_data');
									$insertFinancialBatch = $this->db->insert_batch("upload_financial_data", $financialData);
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
							$body_message = 'something went wrong';
							$this->db->trans_rollback();
							$this->db->trans_complete();

						}
						if ($result == true) {
							$response['status'] = 200;
							$response['body'] = "Data uploaded Successfully";
						} else {
							$response['status'] = 201;
							$response['body'] = "Failed To uplaod consolidate data";
						}
					} else {
						$response['status'] = 201;
						$response['body'] = "No data found";
					}
				} else {
					$response['status'] = 201;
					$response['body'] = "No data found";
				}
			} else {
				$response['body'] = 'No data found';
				$response['status'] = 201;
			}
			echo json_encode($response);
		}
	}
	public function saveCopyIntraData()
	{
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		$Data1 = $this->input->post('arrData');
		$sheet_master_id = $this->input->post('insertID');
		$transferType = $this->input->post('transferType');
		// $branch_id = $this->input->post('branchID');
		$debitCheck = $this->input->post('debitCheck');
		$creditCheck = $this->input->post('creditCheck');
		$arrData = json_decode($Data1);
//		 print_r($arrData);exit();
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		$company_id = $this->session->userdata('company_id');

		$checKCurrencyConversion = $this->Master_Model->get_count(array('company_id' => $company_id, 'year' => $year, 'month' => $month), 'currency_conversion_master');
		if ($checKCurrencyConversion == 0) {
			$response['status'] = 201;
			$response['body'] = 'Currency Conversion for this Month is not Done';
			echo json_encode($response);
			exit();
		} else {
			$specialBranchIdIntraCompany="";
			$specialBranchIdInterCompany="";
			$specialBranchObject=$this->Master_Model->_select('branch_master b',array('company_id'=>$company_id,'is_special_branch'=>1),'*,
			(select group_concat(intra_gl_account,",",inter_gl_account) from subsidiary_mapping m where m.company_id=b.company_id) as GlMapping',false);

			if($specialBranchObject->totalCount>0)
			{
				$IntraGl="";
				$InterGl="";
				foreach ($specialBranchObject->data as $row){
					if($row->transfer_type == 1){
						$specialBranchIdIntraCompany=$row->id;
					}
					if($row->transfer_type == 2){
						$specialBranchIdInterCompany=$row->id;
					}
					if($row->GlMapping != null){
						$exp=explode(",",$row->GlMapping);
						$IntraGl=$exp[0];
						$InterGl=$exp[1];
					}
				}
			}
			$specialBranch="";
			if($transferType == 1){
				$specialBranch=$specialBranchIdIntraCompany;
			}else{
				$specialBranch=$specialBranchIdInterCompany;
			}
			$check_entry = $this->db->where(array('id' => $sheet_master_id))->get('excelsheet_master_data')->row();
			// print_r($check_entry);exit();
			$company_master = $this->Master_Model->getComapnyCurrency();
			$branch_master = $this->Master_Model->getBranchCurrency();

			if (!empty($arrData)) {
				if (!empty($check_entry)) {
					$id = $check_entry->id;

					$approve_status = 0;
					if ($user_type == 2) {
						$approve_status = 1;
					}
					$newArray = array();
					$financialData=array();

//					print_r($financialData);exit();

						$result = false;
						try {
							$this->db->trans_start();
							$this->db->where(array('sheet_master_id' => $sheet_master_id, 'year' => $check_entry->year, 'quarter' => $check_entry->quarter, 'company_id' => $company_id,'transfer_type'=>$transferType))->delete('upload_intra_company_transfer');
							foreach ($arrData as $item) {
//						 print_r($item);exit();
								if ($item[0] != "" && $item[2] != "" && $item[9] != "" && $item[11] != "") {
									$fromBranch = explode('-', $item[0]);
									if (count($fromBranch) > 1) {
										$item[0] = $fromBranch[0];
									}
									$toBranch = explode('-', $item[9]);
									if (count($toBranch) > 1) {
										$item[9] = $toBranch[0];
									}
									if ($item[6] == "") {
										if ($check_entry->holding_type == 1) {
											//company
											if ($company_master[$company_id] != null) {
												$item[6] = $company_master[$company_id];
											}

										} else { //branch
											$item[6] = $branch_master[$item[0]];
										}

									}
									if ($item[15] == "") {
										if ($check_entry->holding_type == 1) {
											//company
											if ($company_master[$company_id] != null) {
												$item[15] = $company_master[$company_id];
											}
										} else { //branch
											$item[15] = $branch_master[$item[9]];
										}
									}
									$from = 1;
									$to = 1;
									if ($item[6] != "INR") {
										$FromRate = $this->Master_Model->_select('currency_conversion_master', array('company_id' => $company_id, 'year' => $year, 'month' => $month, 'currency' => $item[6]), 'rate', true)->data;
										if($FromRate!="") {
											$from = $FromRate->rate;
										}
									}
									if ($item[15] != "INR") {
										$ToRate = $this->Master_Model->_select('currency_conversion_master', array('company_id' => $company_id, 'year' => $year, 'month' => $month, 'currency' => $item[15]), 'rate', true)->data;
										if($ToRate!="")
										{
											$to = $ToRate->rate;
										}
									}

									$rateFrom=$item[7]; // from currency rate
									if($rateFrom=="")
									{
										$rateFrom=1;
									}
									$rateTo=$item[16]; // to currency rate
									if($rateTo=="")
									{
										$rateTo=1;
									}

									$from_debit = ((is_numeric($item[3])) ? $item[3]: 1)  * $rateFrom;
									$from_credit = ((is_numeric($item[4])) ? $item[4]: 1) * $rateFrom;

									$to_debit =  ((is_numeric($item[12])) ? $item[12]: 1) * $rateTo;
									$to_credit =  ((is_numeric($item[13])) ? $item[13]: 1) * $rateTo;

									$d1=( ((is_numeric($item[3])) ? $item[3]: 1) - ((is_numeric($item[4])) ? $item[4]: 1))*$rateFrom;
									$d2=(((is_numeric($item[12])) ? $item[12]: 1) - ((is_numeric($item[13])) ? $item[13]: 1))*$rateTo;
									// $debit_difference = $from_debit - $to_debit;
									// $credit_difference = $from_credit - $to_credit;
									$debit_difference = $d2 + $d1;
									$credit_difference = 0;
//							$itemfrom=$item[3]-$item[4];
//							$itemto=$item[10]-$item[11];
//							$item[14]=$itemfrom+$itemto;
//
									$diff_gl = explode('-', $item[21]);
									if (count($diff_gl) > 1) {
										$item[21] = $diff_gl[0];
									}
									$fromTotal=($item[3]-$item[4])*$rateFrom; // from debit - from credit * from currency_rate
									$toTotal=($item[12]-$item[13])*$rateTo; // to debit - to credit * to currency_rate
//							$finalValue=(-$fromTotal-$toTotal);//old changes
									$finalValue=-($fromTotal+$toTotal); //changes suggest by bharat
									$data = array(
										"from_branch_id" => $item[0],
										"from_gl_account" => $item[2],
										"from_debit" => $item[3],
										"from_credit" => $item[4],
										"from_given_by" => $item[5],
										"from_currency" => $item[6],
										"from_currency_rate"=>$item[7],
										"from_totalValue"=>$fromTotal, //$item[8],
										"to_branch_id" => $item[9],
										"to_gl_account" => $item[11],
										"to_debit" => $item[12],
										"to_credit" => $item[13],
										"to_given_by" => $item[14],
										"to_currency" => $item[15],
										"to_currency_rate"=>$item[16],
										"to_totalValue"=>$toTotal, //$item[17],
										"final_value"=>$finalValue, //$item[20],
										"difference" => $debit_difference,
										"difference_credit" => $credit_difference,
										"year" => $check_entry->year,
										"quarter" => $check_entry->quarter,
										"created_on" => date('Y-m-d H:i:s'),
										"created_by" => $user_id,
										"user_id" => $user_id,
										"company_id" => $company_id,
										"sheet_master_id" => $sheet_master_id,
										"approve_status" => $approve_status,
										"cur_to_debit" => $to_debit,
										"cur_to_credit" => $to_credit,
										"cur_from_debit" => $from_debit,
										"cur_from_credit" => $from_credit,
										"transfer_type" => $transferType,
										"difference_gl" => $item[21],
									);
									$insert=$this->db->insert('upload_intra_company_transfer',$data);
									$intra_transfer_id = $this->db->insert_id();
									$data['intra_transfer_id']=$intra_transfer_id;
									array_push($newArray, $data);
									/*if($transferType == 1){
										$glAct=$IntraGl;
									}else{
										$glAct=$InterGl;
									}*/
									if(!empty($specialBranch))
									{
										if($finalValue!=0)
										{
											$finArr=array('gl_ac'=>$item[21],
												'debit'=>$fromTotal, //$item[17],//from total
												'credit'=>$toTotal,//$item[8],//to total
												'total'=>$finalValue,//$item[20],
												'detail'=>'',
												'year'=>$check_entry->year,
												'quarter'=>$check_entry->quarter,
												'branch_id'=>$specialBranch,
												'company_id'=>$company_id,
												'user_id'=>$user_id,
												'created_by'=>$user_id,
												'created_on'=>date('Y-m-d H:i:s'),
												'is_transfer'=>1,
												'transfer_type'=>$transferType,
												'sheet_master_id'=>0,
												'is_difference_value'=>1,
												'intra_transfer_id'=>$intra_transfer_id);
											array_push($financialData,$finArr);
										}
									}
								}
							}
//							$insert_batch = $this->db->insert_batch("upload_intra_company_transfer", $newArray);
							if(!empty($newArray)){

								$resultReturn=$this->uploadConsolidateTransaction($newArray,$check_entry->year,$check_entry->quarter,$specialBranch,$transferType);
								if(!empty($financialData))
								{
								//	$this->db->where(array( 'year' => $check_entry->year, 'quarter' => $check_entry->quarter, 'company_id' => $company_id,'is_transfer'=>1,'transfer_type'=>$transferType,))->delete('upload_financial_data');
									$insertFinancialBatch = $this->db->insert_batch("upload_financial_data", $financialData);
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
							$body_message = 'something went wrong';
							$this->db->trans_rollback();
							$this->db->trans_complete();

						}
						if ($result == true) {
							$response['status'] = 200;
							$response['body'] = "Data uploaded Successfully";
						} else {
							$response['status'] = 201;
							$response['body'] = "Failed To uplaod consolidate data";
						}

				} else {
					$response['status'] = 201;
					$response['body'] = "No data found";
				}
			} else {
				$response['body'] = 'No data found';
				$response['status'] = 201;
			}
			echo json_encode($response);
		}
	}

	function uploadConsolidateTransaction($newArray, $year, $month,$specialBranch,$transferType){
		$data1=array();
		$data2=array();
		$company_id = $this->session->userdata('company_id');
		$user_id = $this->session->userdata('user_id');
		foreach ($newArray as $row){
			$from_debit=$row['from_debit'] == null ? 0 : $row['from_debit'];
			$from_credit=$row['from_credit']== null ? 0 :$row['from_credit'];

			$data1_1=array(
				'branch_id'=>$specialBranch,
				'gl_ac'=>$row['from_gl_account'],
				'debit'=>$from_debit,
				'credit'=>$from_credit,
				'total'=>$from_debit-$from_credit,
				'year'=>$year,
				'quarter'=>$month,
				'company_id'=>$company_id,
				'user_id'=>$user_id,
				'sheet_master_id'=>0,
				'is_transfer'=>1,
				'opening_balance'=>0,
				'transfer_type'=>$transferType,
				'is_difference_value'=>0,
				'intra_transfer_id'=>$row['intra_transfer_id']
			);
			$to_debit=$row['to_debit']== null ? 0 :$row['to_debit'];
			$to_credit=$row['to_credit']== null ? 0 :$row['to_credit'];
			$data1_2=array(
				'branch_id'=>$specialBranch,
				'gl_ac'=>$row['to_gl_account'],
				'debit'=>$to_debit,
				'credit'=>$to_credit,
				'total'=>$to_debit-$to_credit,
				'year'=>$year,
				'quarter'=>$month,
				'company_id'=>$company_id,
				'user_id'=>$user_id,
				'sheet_master_id'=>0,
				'is_transfer'=>1,
				'opening_balance'=>0,
				'transfer_type'=>$transferType,
				'is_difference_value'=>0,
				'intra_transfer_id'=>$row['intra_transfer_id']
			);
			array_push($data1,$data1_1);
			array_push($data2,$data1_2);
		}
		$twhere = array('quarter' => $month,
			'year' => $year,
			'company_id' => $company_id,
			'is_transfer' => 1,'transfer_type'=>$transferType);
		$delete = $this->Master_Model->_delete('upload_financial_data', $twhere);
		$insert = $this->db->insert_batch('upload_financial_data', $data1);
		$insert2 = $this->db->insert_batch('upload_financial_data', $data2);
		if($insert == true && $insert2 == true){
			return true;
		}
	}
	function uploadConsolidateTransaction1($newArray, $year, $month)
	{
		//get sheet master id

		$return = 0;
		$returnData = false;
		$user_id = $this->session->userdata('user_id');
		$company_id = $this->session->userdata('company_id');
		$branch_master = $this->Master_Model->getBranchCompany();
		$count = count($newArray) * 2;
		$insertArray = array();
		foreach ($newArray as $value) {
			$branchSetupCheckArray = array(
				array('branch' => $value['from_branch_id'], 'account_number' => $value['from_gl_account'], 'debit' => $value['from_debit'], 'credit' => $value['from_credit']),
				array('branch' => $value['to_branch_id'], 'account_number' => $value['to_gl_account'], 'debit' => $value['to_debit'], 'credit' => $value['to_credit'])
			);

			foreach ($branchSetupCheckArray as $bvalue) {

				$branch_setup = $this->Master_Model->_select('branch_account_setup', array('branch_id' => $bvalue['branch'], 'account_number' => $bvalue['account_number']), array('parent_account_number', 'parent_account_number_us', 'parent_account_number_ifrs'), true);

				if ($branch_setup->totalCount > 0) {
					$branchSetup = $branch_setup->data;
					$tables = array();
					if ($branchSetup->parent_account_number != null && $branchSetup->parent_account_number != "") {
						array_push($tables, 'consolidate_report_transaction');
					}
					if ($branchSetup->parent_account_number_us != null && $branchSetup->parent_account_number_us != "") {
						array_push($tables, 'consolidate_report_transaction_us');
					}
					if ($branchSetup->parent_account_number_ifrs != null && $branchSetup->parent_account_number_ifrs != "") {
						array_push($tables, 'consolidate_report_transaction_ifrs');
					}
					$company_id = $branch_master[$bvalue['branch']];

					$insertData = array('debit' => $bvalue['debit'],
						'credit' => $bvalue['credit']);

					foreach ($tables as $tvalue) {
						$insertArray[$tvalue][$bvalue['branch']][$branchSetup->parent_account_number][] = $insertData;

					}
				}
			}
		}
		// print_r($insertArray);
		// exit();
		foreach ($insertArray as $key => $in_value)// table array
		{
			$insertGlArray = array();
			foreach ($in_value as $ikey => $branch_value) //branch_array
			{
				foreach ($branch_value as $gkey => $gl_value) //gl_array
				{
					$credit = 0;
					$credit += array_sum(array_column($gl_value, 'credit'));
					$debit = 0;
					$debit += array_sum(array_column($gl_value, 'debit'));
					$insertBranchData = array('account_number' => $gkey,
						'final_total' => 0,
						'month' => $month,
						'year' => $year,
						'create_on' => date('Y-m-d H:i:s'),
						'create_by' => $user_id,
						'status' => 1,
						'branch_id' => $ikey,
						'company_id' => $company_id,
						'total' => 0,
						'debit' => $debit,
						'credit' => $credit,
						'opening_balance' => 0,
						'total_2' => 0,
						'debit_2' => $debit,
						'credit_2' => $credit,
						'opening_balance_2' => 0,
						'is_transfer' => 1);
					array_push($insertGlArray, $insertBranchData);
				}

			}
			// print_r($insertGlArray);exit();
			$twhere = array('month' => $month,
				'year' => $year,
				'company_id' => $company_id,
				'is_transfer' => 1);
			//$delete = $this->Master_Model->_delete($tvalue, $twhere);
			$insert = $this->db->insert_batch($key, $insertGlArray);
			if ($insert == true) {
				$return++;
			}
		}

		if (count($insertArray) == $return) {
			$returnData = true;
		}
		return $returnData;
	}
//	public function getBranchGlAccount()
//	{
//		// print_r($this->input->post());exit();
//		$branch=$this->input->post('branch');
//		$branchdata=explode('-', $branch);
//		$branch_list=array();
//		$data=array();
//		if(count($branchdata)>1)
//		{
//			$branch_list = $this->Master_Model->get_all_data(array('branch_id'=>$branchdata[0]), 'branch_account_setup');
//		}
//
//		if(count($branch_list) > 0){
//			foreach ($branch_list as $row){
//				array_push($data, $row->account_number."-".$row->detail);
//
//			}
//			$response['data']=$data;
//			$response['status']=200;
//
//		}else{
//			$response['data']=$data;
//			$response['status']=201;
//		}echo json_encode($response);
//	}


	public function getBranchGlAccount()
	{
		// print_r($this->input->post());exit();
		$branch = $this->input->post('branch');
		$branchdata = explode('-', $branch);
		$branch_list = array();
		$branch_currency = "";
		$data = array();
		if (count($branchdata) > 1) {
			$branch_list = $this->Master_Model->get_all_data(array('branch_id' => $branchdata[0]), 'branch_account_setup');
			$branch_currency = $this->Master_Model->get_row_data('currency', array('id' => $branchdata[0]), 'branch_master');
		}


		if (count($branch_list) > 0) {
			foreach ($branch_list as $row) {
				array_push($data, $row->account_number . "-" . $row->detail);
			}
			$currency = $branch_currency->currency;
			$response['data'] = $data;
			$response['currency'] = $currency;
			$response['status'] = 200;

		} else {
			$response['data'] = $data;
			$response['status'] = 201;
		}
		echo json_encode($response);
	}
	public function getCompanyGlAccount()
	{
		$company_id = $this->session->userdata('company_id');
		// print_r($this->input->post());exit();
		$branch = $this->input->post('branch');
		$branchdata = explode('-', $branch);
		$branch_list = array();
		$branch_currency = "";
		$data = array();
		if (count($branchdata) > 1) {
			$branch_list = $this->Master_Model->get_all_data(array('status'=>1,'company_id'=>$company_id), 'main_account_setup_master');
			$branch_currency = $this->Master_Model->get_row_data('currency', array('id' => $branchdata[0]), 'branch_master');
		}


		if (count($branch_list) > 0) {
			foreach ($branch_list as $row) {
				array_push($data, $row->main_gl_number . "-" . $row->name);
			}
			$currency = $branch_currency->currency;
			$response['data'] = $data;
			$response['currency'] = $currency;
			$response['status'] = 200;

		} else {
			$response['data'] = $data;
			$response['status'] = 201;
		}
		echo json_encode($response);
	}


	public function getIntraInfoById()
	{

		$id = $this->input->post('insertID');
		$company_id = $this->session->userdata('company_id');
		$IntraData = $this->Master_Model->_select('excelsheet_master_data em', array('id' => $id,'company_id'=>$company_id), array("*","(select group_concat((case when cm.name is not null then cm.name else '' end),'||',(case when cm.currency is not null then cm.currency else '' end)) from company_master cm where cm.id=em.company_id and em.holding_type=1) as holding"), true);
//		 print_r($IntraData);exit();
		if ($IntraData->totalCount > 0) {

			$month = '';
			$country_master = $this->Master_Model->country();
			$months = $this->Excelsheet_model->getQuarter();
			$countries = $country_master[1];
			$year = $IntraData->data->year;
			if ($IntraData->data->quarter != 0) {
				$month = $months[$IntraData->data->quarter];
			}
			$currency='';
			$holdingData='';
			if ($IntraData->data->holding != null && $IntraData->data->holding!="") {
				$holding=explode('||', $IntraData->data->holding);
				if(count($holding)>0)
				{
					$currency=$holding[1];
					$holdingData='<i class="fa fa-building"></i> Holding Company - '.$holding[0].' <i class="fa"> </i> Currency - '.$holding[1];
				}
			}

			$response['data'] = $IntraData->data;
			$response['year'] = $year;
			$response['month'] = $month;
			$response['holding_type'] = $holdingData;
			$response['currency'] = $currency;
			$response['status'] = 200;
			$query3=$this->Master_Model->_rawQuery("select * from block_year_data where status=1 AND company_id=".$company_id." AND year=".$year." AND month=".$IntraData->data->quarter);
			if($query3->totalCount > 0){
				$response['BlockYear'] = 1;
			}else{
				$response['BlockYear'] = 0;
			}

		} else {
			$response['data'] = 'No data found';
			$response['status'] = 201;
		}
		echo json_encode($response);
	}

	public function uploadIntraTransaction()
	{
		if (!is_null($this->input->post('insertID'))) {
			$sheet_master_id = $this->input->post('insertID');
			$from_branch_id = $this->input->post('from_branch_id');
			$from_gl_account = $this->input->post('from_gl_account');
			$to_branch_id = $this->input->post('to_branch_id');
			$to_gl_account = $this->input->post('to_gl_account');
			$amount = $this->input->post('amount');
			$year = $this->input->post('year');
			$month = $this->input->post('month');

			$user_id = $this->session->userdata('user_id');
			$company_id = $this->session->userdata('company_id');
			$user_type = $this->session->userdata('user_type');
			$approve_status = 0;
			if ($user_type == 2) {
				$approve_status = 1;
			}
			if (!empty($from_branch_id)) {

				$data = array(
					"from_branch_id" => $from_branch_id,
					"from_gl_account" => $from_gl_account,
					"to_branch_id" => $to_branch_id,
					"to_gl_account" => $to_gl_account,
					"amount" => $amount,
					"year" => $year,
					"quarter" => $month,
					"created_on" => date('Y-m-d H:i:s'),
					"created_by" => $user_id,
					"user_id" => $user_id,
					"company_id" => $company_id,
					"sheet_master_id" => $sheet_master_id,
					"approve_status" => $approve_status
				);
				// print_r($data);exit();

				$insert = $this->db->insert("upload_intra_company_transfer", $data);
				if ($insert == true) {
					$response['status'] = 200;
					$response['body'] = "Data uploaded Successfully";
				} else {
					$response['status'] = 201;
					$response['body'] = "Failed To uplaod";
				}
			} else {
				$response['body'] = 'No data for save';
				$response['status'] = 201;
			}

		} else {
			$response['status'] = 201;
			$response['body'] = 'Something was wrong';
		}
		echo json_encode($response);
	}

	public function getIntraTransactionTable()
	{
		if (!is_null($this->input->post('insertID'))) {
			$sheet_master_id = $this->input->post('insertID');
			$user_type = $this->session->userdata('user_type');
			$user_id = $this->session->userdata('user_id');
			$mbData = $this->db
				->select(array("*", "(select bm.name from branch_master bm where bm.id=from_branch_id) as from_branch", "(select bm.name from branch_master bm where bm.id=to_branch_id) as to_branch"))
				->where('sheet_master_id', $sheet_master_id)
				->order_by('id', 'desc')
				->get("upload_intra_company_transfer")->result();
			// print_r($user_id);exit();
			$tableRows = array();
			if (count($mbData) > 0) {
				$i = 1;
				foreach ($mbData as $order) {
					$created = 0;
					$approve = 0;
					if ($user_type == 2) {
						$created = 1;
						$approve = 1;
					} else {
						if ($order->created_by == $user_id) {
							$created = 1;
						}
					}

					$country_master = $this->Master_Model->country();
					$country = $country_master[1];
					$country_master = $this->Master_Model->getQuarter();
					array_push($tableRows, array($i, $order->from_branch, $order->from_gl_account, $order->to_branch, $order->to_gl_account, $order->amount, $order->id, $order->approve_status, $created, $approve));
					$i++;
				}
			}
			$response = array(
				"status" => 200,
				"draw" => 1,
				"recordsTotal" => count($mbData),
				"recordsFiltered" => count($mbData),
				"data" => $tableRows
			);

		} else {
			$response['status'] = 201;
			$response['data'] = 'Required parameter missing';
		}

		echo json_encode($response);
	}

	public function deleteIntraTrasaction()
	{
		if (!is_null($this->input->post('id'))) {
			$id = $this->input->post('id');
			$delete = $this->Excelsheet_model->_delete('upload_intra_company_transfer', array("id" => $id));
			if ($delete->status == true) {
				$response['status'] = 200;
				$response['data'] = 'Data Deleted Successfully';
			} else {
				$response['status'] = 201;
				$response['data'] = 'Data Not Deleted';
			}
		} else {
			$response['status'] = 201;
			$response['data'] = 'Required parameter missing';
		}
		echo json_encode($response);
	}

	public function approveIntraStatus()
	{
		if (!is_null($this->input->post('id')) && !is_null($this->input->post('status'))) {
			$id = $this->input->post('id');
			$status = $this->input->post('status');
			$delete = $this->Excelsheet_model->_update('upload_intra_company_transfer', array("approve_status" => $status), array("id" => $id));
			if ($delete->status == true) {
				$response['status'] = 200;
				$response['data'] = 'Data Updated Successfully';
			} else {
				$response['status'] = 201;
				$response['data'] = 'Data Not Updated';
			}
		} else {
			$response['status'] = 201;
			$response['data'] = 'Required parameter missing';
		}
		echo json_encode($response);
	}

	public function getIntraTableData()
	{
		if (!is_null($this->input->post('id'))) {
			$sheet_master_id = $this->input->post('id');
			$transfer_type = $this->input->post('companyType');
			$user_type = $this->session->userdata('user_type');
			$company_id=$this->session->userdata('company_id');
			$user_id=$this->session->userdata('user_id');
//			$branch_list = $this->Master_Model->get_all_data(array('company_id' => $this->session->userdata('company_id'), 'status' => 1), 'branch_master');
			$branch_list = $this->Master_Model->_rawQuery(' select * from branch_master where company_id="'.$company_id.'" and status=1 and find_in_set(id,(select branch_permission from permission_user_transaction where user_id="'.$user_id.'"))');

			$branch_source = array();
			if ($branch_list->totalCount > 0) {

				foreach ($branch_list->data as $row) {
					array_push($branch_source, $row->id . '-' . $row->name);
				}
			}
			$allGlList = $this->Master_Model->_rawQuery(' select main_gl_number,name from main_account_setup_master where company_id="'.$company_id.'" and status=1 ');

			$MainGlSource = array();
			if ($allGlList->totalCount > 0) {

				foreach ($allGlList->data as $row) {
					array_push($MainGlSource, $row->main_gl_number . '-' . $row->name);
				}
			}
			$where = array('sheet_master_id' => $sheet_master_id,'transfer_type' => $transfer_type);
			if ($user_type != 2) {
				$where['created_by'] = $this->session->userdata('user_id');
			}


			$branch_id = $this->session->userdata('branch_id');
			$resultObject = $this->Master_Model->_select('upload_intra_company_transfer', $where, array("*", "(select bm.name from branch_master bm where bm.id=from_branch_id) as from_branch", "(select bm.name from branch_master bm where bm.id=to_branch_id) as to_branch",
				"(select bs.name from main_account_setup_master bs where bs.main_gl_number=from_gl_account and bs.company_id=".$company_id.") as from_detail",
				"(select bs.name from main_account_setup_master bs where bs.main_gl_number=difference_gl and bs.company_id=".$company_id.") as difference_details",
				"(select bs.name from main_account_setup_master bs where bs.main_gl_number=to_gl_account and bs.company_id=".$company_id.") as to_detail", "(select bmm.name from branch_master bmm where bmm.id='" . $branch_id . "') as my_branch"), false);
			$response['query'] = $resultObject->last_query;
			// print_r($user_type);exit();
			$intraArray = array();
			if ($resultObject->totalCount > 0) {
				foreach ($resultObject->data as $key => $value) {
					// print_r($value);exit();
					if ($user_type == 2) {
						$from_branchName = $value->from_branch_id . "-" . $value->from_branch;
					} else {
						$from_branchName = $branch_id . "-" . $value->my_branch;
					}
					$newArray = array(
						$from_branchName,
						$value->from_gl_account . "-" . $value->from_detail,
						$value->from_gl_account,
						$value->from_debit,
						$value->from_credit,
						$value->from_given_by,
						$value->from_currency,
						$value->from_currency_rate,//average rate
						$value->from_totalValue,//from total value
						$value->to_branch_id . "-" . $value->to_branch,
						$value->to_gl_account . "-" . $value->to_detail,
						$value->to_gl_account,
						$value->to_debit,
						$value->to_credit,
						$value->to_given_by,
						$value->to_currency,
						$value->to_currency_rate,//average rate
						$value->to_totalValue,//from total value
						round($value->difference,2),
						$value->difference_credit,
						round($value->final_value,2),
						$value->difference_gl . "-" . $value->difference_details,
					);
					array_push($intraArray, $newArray);
				}
				$rows = $intraArray;
				$response['status'] = 200;
				$response['rows'] = $rows;
			} else {
				$rows = array('', '', '', '', '', '', '', '', '','');

			}
			$columns = array('From Subsidiary Account', 'From Gl Account', 'from_gl_account', 'From debit', 'From credit', 'Given by', 'Currency','Currency rate','Total Value', 'To Subsidiary Account', 'To Gl Account', 'to_gl_account', 'To debit', 'To credit', 'Given by', 'Currency','Currency rate','Total value', 'Difference Debit(original)', 'Difference Credit','Difference Debit','Difference GL'); //Difference Debit-final value
			$branchName = '';
			$dataSchema = array();
			$country_master = $this->Master_Model->country();
			$countryCurrency = $country_master[0];
			$currency = array_values($countryCurrency);
			// print_r($currency);exit();
			if ($user_type == 2) {
				$type = array(
					array('type' => 'dropdown', 'source' => $branch_source),
					array('type' => 'dropdown','source'=>$MainGlSource),
					array('type' => 'text'),
					array('type' => 'numeric'),
					array('type' => 'numeric'),
					array('type' => 'text'),
					array('type' => 'dropdown', 'source' => $currency),
					array('type' => 'numeric'),//currency average
					array('type' => 'numeric'),//total value
					array('type' => 'dropdown', 'source' => $branch_source),
					array('type' => 'dropdown','source'=>$MainGlSource),
					array('type' => 'text'),
					array('type' => 'numeric'),
					array('type' => 'numeric'),
					array('type' => 'text'),
					array('type' => 'dropdown', 'source' => $currency),
					array('type' => 'numeric'),//currency average
					array('type' => 'numeric'),//total value
					array('type' => 'numeric'),
					array('type' => 'numeric'),
					array('type' => 'numeric'),//final value
					array('type' => 'dropdown','source'=>$MainGlSource),//difference GL
				);
			} else {

				$branchObject = $this->Master_Model->_select('branch_master', array('id' => $branch_id), array("name"), true);
				if ($branchObject->totalCount > 0) {
					$branchName = $branch_id . "-" . $branchObject->data->name;
				}
				$data = array();
				$branch_list = array();

				$branch_list = $this->Master_Model->get_all_data(array('branch_id' => $branch_id), 'branch_account_setup');


				if (count($branch_list) > 0) {
					foreach ($branch_list as $row) {
						array_push($data, $row->account_number . "-" . $row->detail);
					}
				}
				$type = array(
					array('type' => 'text', 'readOnly' => 'true'),
					array('type' => 'dropdown', 'source' => $data),
					array('type' => 'dropdown','source'=>$MainGlSource),
					array('type' => 'numeric'),
					array('type' => 'numeric'),
					array('type' => 'text'),
					array('type' => 'dropdown', 'source' => $currency),
					array('type' => 'numeric'),//currency average
					array('type' => 'numeric'),//total value
					array('type' => 'dropdown', 'source' => $branch_source),
					array('type' => 'dropdown','source'=>$MainGlSource),
					array('type' => 'text'),
					array('type' => 'numeric'),
					array('type' => 'numeric'),
					array('type' => 'text'),
					array('type' => 'dropdown', 'source' => $currency),
					array('type' => 'numeric'),//currency average
					array('type' => 'numeric'),//total value
					array('type' => 'numeric'),
					array('type' => 'numeric'),//final value
					array('type' => 'dropdown','source'=>$MainGlSource),//difference GL
				);
				$dataSchema = array('0' => $branchName);
			}


			$response['type'] = $type;
			$response['columns'] = $columns;
			$response['branchName'] = $branchName;
			$response['dataSchema'] = $dataSchema;
		} else {
			$response['status'] = 201;
			$response['data'] = 'Required parameter missing';
		}
		echo json_encode($response);
	}

	function excelUploadValidation()
	{
		$id = $this->input->get('id');
		$branch_id = $this->input->get('branch_id');
		$this->load->view("user/excelUploadValidation", array("title" => "Excel Upload", 'id' => $id, 'branch_id' => $branch_id));
	}

	public function ExportToTableValidation()
	{

		$mimes = array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel', 'text/xls');
//		print_r($_FILES["userfile"]);exit();
		if (!in_array($_FILES['userfile']['type'][0], $mimes)) {
			$response['status'] = 201;
			$response['body'] = "Upload Excel file.";
			echo json_encode($response);
			exit;
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

		// print_r($mainArray);exit();

		$response['count'] = $cnt;
		$response['status'] = 200;
		$response['body'] = $template;

		echo json_encode($response);
	}


	public function ExportToTableValidationConsolidate()
	{

		$mimes = array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel', 'text/xls');
		// print_r($_FILES['userfile']['type']);exit();
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
		$options = $this->getExcelDatabaseColumnConsolidate(4);
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

		// print_r($mainArray);exit();

		$response['count'] = $cnt;
		$response['status'] = 200;
		$response['body'] = $template;

		echo json_encode($response);
	}

	public function getExcelDatabaseColumn($type)
	{
		$options = '<option selected value=""></option>';
		$resultObject = $this->Master_Model->_select('upload_column_mapping_rule', array('type' => $type), array('id', 'column_name'), false);
		if ($resultObject->totalCount > 0) {
			foreach ($resultObject->data as $value) {
				$options .= '<option value="' . $value->id . '">' . $value->column_name . '</option>';
			}
		}
		return $options;
	}


	public function getExcelDatabaseColumnConsolidate($type)
	{
		$options = '<option selected value=""></option>';
		$resultObject = $this->Master_Model->_select('upload_column_mapping_rule', array('type' => $type), array('id', 'column_name'), false);
		if ($resultObject->totalCount > 0) {
			foreach ($resultObject->data as $value) {
				$options .= '<option value="' . $value->column_name . '">' . $value->column_name . '</option>';
			}
		}
		return $options;
	}
	public function getCurrencyAverageValue()
	{
		if(!is_null($this->input->post('currency')) && !is_null($this->input->post('branchId')) && !is_null($this->input->post('month')))
		{
			$branch_id="";
			$branhcdata=explode('-',$this->input->post('branchId'));
			if(count($branhcdata)>1)
			{
				$branch_id=$branhcdata[0];
			}
			$where=array('currency'=>$this->input->post('currency'),'month'=>$this->input->post('month'),'year'=>$this->input->post('year'),'company_id'=>$this->session->userdata('company_id'));
			$resultObject=$this->Master_Model->_select('currency_conversion_master',$where,array('rate','closing_rate'),true);

			if($resultObject->totalCount>0)
			{
				$response['status']=200;
				$response['rate']=$resultObject->data->rate;
			}
			else{
				$response['status']=201;
				$response['rate']="";
			}
		}
		else{
			$response['status']=201;
			$response['rate']="";
		}
		echo json_encode($response);
	}
	function getNameofGlAccount($glAccountNumber){
		$company_id=$this->session->userdata('company_id');
		$query=$this->db->query("select name from main_account_setup_master where main_gl_number='".$glAccountNumber."' AND company_id=".$company_id);
		if($this->db->affected_rows() > 0){
			return $glAccountNumber."-".$query->row()->name;
		}else{
			return false;
		}
	}

	function getdefaultGlAccount(){
		$GlAccount=$this->input->post('GlAccount');
		$company_id=$this->session->userdata('company_id');
		$query=$this->Master_Model->_rawQuery('select *,(select type0 from main_account_setup_master m where main_gl_number="'.$GlAccount.'" AND m.company_id=s.company_id) as type0 from subsidiary_mapping s where company_id='.$company_id);
		if($query->totalCount > 0){
			$result=$query->data[0];
			if($result->type0 == "PL"){
				$intraGlAccount=$result->intra_gl_account_pl;
				$interGlAccount=$result->inter_gl_account_pl;
			}else{
				$intraGlAccount=$result->intra_gl_account;
				$interGlAccount=$result->inter_gl_account;
			}
			$response['IntraGlAccount']=$this->getNameofGlAccount($intraGlAccount);
			$response['InterGlAccount']=$this->getNameofGlAccount($interGlAccount);
			$response['status']=200;
		}else{
			$response['IntraGlAccount']="";
			$response['InterGlAccount']="";
			$response['status']=201;
		}echo json_encode($response);
	}
	public function ClearEntityTransfer(){
		$company_id=$this->session->userdata('company_id');
		$year=$this->input->post('year');
		$month=$this->input->post('month');
		$transferType=$this->input->post('transferType');
		$deleteFromintrasfertTable=$this->db->where(array( 'year' => $year, 'quarter' => $month, 'company_id' => $company_id,'transfer_type'=>$transferType))->delete('upload_intra_company_transfer');
		$twhere = array('quarter' => $month,
			'year' => $year,
			'company_id' => $company_id,
			'is_transfer' => 1,'transfer_type'=>$transferType);
		$deleteFromUpload = $this->Master_Model->_delete('upload_financial_data', $twhere);
		if($deleteFromintrasfertTable && $deleteFromUpload){
			$response['status']=200;
			$response['body']='Data Clear Successfully';
		}else{
			$response['status']=200;
			$response['body']='Something Went Wrong!';
		}echo json_encode($response);
	}
	public function downloadMatchedData($excelSheetMasterID)
	{
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex();
		$k = 0;
		$sheetCount=0;
		$excelSheetObject = $this->Excelsheet_model->_select("excelsheet_master_data", array("id" => $excelSheetMasterID),
			array("template_id", "year", "quarter", "approve_status", "branch_id", "company_id","(select bm.transfer_type from branch_master bm where bm.id=branch_id) as transfer_type"));
		if ($excelSheetObject->totalCount > 0) {

			$template_id = $excelSheetObject->data->template_id;
			$year = $excelSheetObject->data->year;
			$quarter = $excelSheetObject->data->quarter;
			$branch_id = $excelSheetObject->data->branch_id;
			$company_id = $excelSheetObject->data->company_id;
			$transfer_type = $excelSheetObject->data->transfer_type;

			$configurationWhere = array("template_id" => $template_id);
			$configurationSelect = array("attribute_type", "column_name", "table_name", "attribute_name", "attribute_query");
			$configurationRecords = $this->Excelsheet_model
				->_select("template_column_mapping", $configurationWhere, $configurationSelect,
					false, null, null, "sequence");

			$unMatchRecords = array();
			$matchRecords = array();
			$header = array();
			if ($configurationRecords->totalCount > 0) {
				$templateTableName = $configurationRecords->data[0]->table_name;

				$objectID = new stdClass();
				$objectID->type = 'numeric';
				$sourceData = array();
				foreach ($configurationRecords->data as $configuration) {
					array_push($header, $configuration->attribute_name);
				}
				$where = array(
					'branch_id' => $branch_id,
					'company_id' => $company_id,
					"year" => $year,
					"quarter" => $quarter);
				if($transfer_type==1 || $transfer_type==2)
				{
					$where['is_transfer']=1;
				}
				else{
					$where["sheet_master_id"] = $excelSheetMasterID;
					$where['is_transfer']=0;
				}
				$select = $header;
				$sheetRecords = $this->Excelsheet_model->_select($templateTableName, $where, $select, false);
				$mappedAccountNumbers = array();
				$unMappedAccountNumbers = array();
				$mainAccountDetail = array();
				if ($template_id == 1) {
					$mainAccountObjects = $this->Excelsheet_model->_select("main_account_setup_master", array("company_id" => $company_id), array("TRIM(main_gl_number) as main_gl_number", "name"), false);
					array_push($header, "Parent Account");

					if ($mainAccountObjects->totalCount > 0) {
						$mAccounts = array();
						foreach ($mainAccountObjects->data as $mAccount) {
							array_push($mAccounts, $mAccount->main_gl_number);
							$mainAccountDetail[$mAccount->main_gl_number] = $mAccount->name;
						}
					} else {
						$mAccounts = array();
					}
					$user_type = $this->session->userdata("user_type");
					if ($user_type == 2) {
						$whereAccount = array("find_in_set(branch_id,(select group_concat(branch_id) from branch_master where company_id = " . $company_id . " and branch_id = " . $branch_id . "))<>" => 0);
					} else {
						$whereAccount = array("find_in_set(branch_id," . $branch_id . ")<>" => 0);
					}
					$checkingResultObject = $this->Excelsheet_model->_select("branch_account_setup", $whereAccount, array("id", "TRIM(account_number) as account_number", "TRIM(parent_account_number) as parent_account_number"), false);
					$response["checkResult"] = $checkingResultObject;
					if ($checkingResultObject->totalCount > 0) {
						foreach ($checkingResultObject->data as $items) {
							if ($items->parent_account_number != null && $items->parent_account_number != "" && in_array($items->parent_account_number, $mAccounts)) {
								$mappedAccountNumbers[$items->account_number] = $items;
							} else {
								$unMappedAccountNumbers[$items->account_number] = $items;
							}
						}
					}
				}
				array_push($header, "Parent Detail");
				$openingBalnceSum = 0;
				$DebitSum = 0;
				$creditSum = 0;
				$TotalSum = 0;
				$objWorkSheet = $objPHPExcel->createSheet();
				$objWorkSheet->setTitle('Financial Data of '.$quarter.' '.$year);
				$i = 1;
				$char = 'A';
				foreach ($header as $key => $h) {
					$objWorkSheet->SetCellValue($char . $i, $h);
					$char++;
				}
				foreach ($sheetRecords->data as $record) {
					$isRowValidated = false;
					$matchParent = null;
					foreach ($configurationRecords->data as $configuration) {

						if (property_exists($record, $configuration->column_name)) {

							$typeCheck = true;
							$recordValue = $record->{$configuration->column_name};
							switch ($configuration->attribute_type) {
								case "numeric":
									$typeCheck = is_numeric($recordValue);
									break;
								case "date":
									$typeCheck = preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $recordValue);
									break;
							}
							if (array_key_exists($configuration->column_name, $sourceData)) {
								$filterSourceData = $sourceData[$configuration->column_name];
								if (array_search($recordValue, $filterSourceData) == false) {
									$typeCheck = false;
								}
							}

							if ($template_id == 1) {
								if ($configuration->column_name == "gl_ac") {
									if (array_key_exists($recordValue, $mappedAccountNumbers)) {
										$typeCheck = true;
										$matchParent = $mappedAccountNumbers[$recordValue]->parent_account_number;
										if (array_key_exists($recordValue, $unMappedAccountNumbers)) {
											$typeCheck = false;
										}
									} else {
										$typeCheck = false;
									}

								}
							}

							// print_r($typeCheck);
							if ($typeCheck) {
								$isRowValidated = true;
								continue;
							} else {
								$record->parentDetail = '';
								array_push($unMatchRecords, array_values((array)$record));
								break;
							}
						}
					}
					$openingBalnceSum += ($record->opening_balance);
					$DebitSum += ($record->debit);
					$creditSum += ($record->credit);
					$TotalSum += ($record->total);
					if ($isRowValidated) {
						$record->parentAccount = $matchParent;
						$record->parentDetail = '';
						if (count($mainAccountDetail) > 0) {
							if (array_key_exists($matchParent, $mainAccountDetail)) {
								$record->parentDetail = $mainAccountDetail[$matchParent];
							}
						}
						array_push($matchRecords, array_values((array)$record));
					}
				}
				$j = 2;
				foreach ($matchRecords as $r)
				{
					$lchar = 'A';
					for($i=0;$i<count($r);$i++)
					{
						$objWorkSheet->SetCellValue($lchar . $j, $r[$i]);
						$lchar++;
					}
					$j++;
				}
				$objPHPExcel->removeSheetByIndex(0);
			}
		}

		ob_end_clean();
		$filename = "Financial_Data_" . $quarter.'_'.$year.'_' . date("Y-m-d") . ".xls";
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
