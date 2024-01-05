<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property  Master_Model Master_Model
 */
class MainAccountSetup extends CI_Controller
{
	public function index()
	{
		$this->load->view("Admin/main_account/view_main_account", array("title" => "Main Account Setup"));
	}

	/////////INDIA DATA FUNCTIONS/////////////////
	public function getMainSetupData()
	{
		$mbData = $this->db
			->select(array("*"))
			->order_by('id', 'desc')
			->get("main_account_setup_master")->result();
		$tableRows = array();
		if (count($mbData) > 0) {
			$i = 1;
			foreach ($mbData as $order) {
				array_push($tableRows, array($i, $order->id, $order->name, $order->main_gl_number, $order->company_id, $order->type1, $order->type2, $order->type3, $order->calculation_method));
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

	function getMainSetupbyId()
	{
		$id = $this->input->post('id');
		$company_master = $this->Master_Model->get_row_data($select = "*", $where = array('id' => $id), $table = "main_account_setup_master");
		if (($company_master) != NULL) {
			$response['data'] = $company_master;
			$response['status'] = 200;
		} else {
			$response['data'] = "";
			$response['status'] = 201;
		}
		echo json_encode($response);
	}

	function CreateUpdateMainSetup()
	{
		$name = $this->input->post('main_name');
		$gl_no = $this->input->post('gl_no');
		$sequence_number = $this->input->post('sequence_number');
		$calculation_method = $this->input->post('calculation_method');
		$type1 = $this->input->post('type1');
		$type2 = $this->input->post('type2');
		$type3 = $this->input->post('type3');
		$update_id = $this->input->post('update_id');
		$company_id = $this->session->userdata('company_id');
		$data = array(
			'name' => $name,
			'main_gl_number' => $gl_no,
			'calculation_method' => $calculation_method,
			'type1' => $type1,
			'type2' => $type2,
			'type3' => $type3,
			'sequence_number' => $sequence_number,
			'company_id' => $company_id,
		);
		if (isset($update_id) && !empty($update_id)) {
			$where = array("id" => $update_id);
			$update = $this->Master_Model->_update('main_account_setup_master', $data, $where);
			if ($update->status == true) {
				$response['status'] = 200;
				$response['body'] = "Updated Successfully";
			} else {
				$response['status'] = 201;
				$response['body'] = "Something Went Wrong";
			}
		} else {
			$insert = $this->Master_Model->_insert('main_account_setup_master', $data);
			if ($insert->status == true) {
				$response['status'] = 200;
				$response['body'] = "Added Successfully";
			} else {
				$response['status'] = 201;
				$response['body'] = "Something Went Wrong";
			}
		}
		echo json_encode($response);
	}

	public function getDataMain()
	{
		$company_id = $this->session->userdata('company_id');
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		$branch_id = $this->input->post('branch_id');
		$CheckBlockwhere = array('year' => $year, 'month' => $month, 'company_id' => $company_id);
		$checkPermission = $this->Master_Model->checkBlockYearMonth($CheckBlockwhere);
//		$permission = 0;
		if ($checkPermission == true) {
			$company = $this->Master_Model->order_by_data($select = "trim(main_gl_number) as main_gl_number", $where = array("company_id" => $company_id, 'status' => 1), $table = "main_account_setup_master", $order_by = "id", $key = "desc");
			$data = array();
			if (count($company)) {
				foreach ($company as $row) {
					$data[] = $row->main_gl_number;
				}
			}
			$scheduleParentMapp=array();
			$gl_data=$this->Master_Model->_select('main_schedule_account_setup_master',array('company_id'=>$company_id,'status'=>1),'account_gl_number,schedule_account',false);
			if($gl_data->totalCount>0)
			{
				foreach($gl_data->data as $glRow)
				{
					$scheduleParentMapp[]=$glRow->schedule_account;
				}
			}
			$getDataBranch = $this->Master_Model->order_by_data($select = "*", $where = array("company_id" => $company_id, 'branch_id' => $branch_id, 'status' => 1), $table = "branch_account_setup", $order_by = "id", $key = "asc");
			$dataNew = array();
			if (count($getDataBranch) > 0) {
				foreach ($getDataBranch as $row1) {
					if ($row1->is_ignore == 1) {
						$is_ignore = 'Yes';
					} else {
						$is_ignore = 'No';
					}
					$data1 = array($row1->id, $row1->account_number, $row1->detail, $row1->parent_account_number, $row1->parent_details, $is_ignore,$row1->schedule_account_number,$row1->schedule_details);
					array_push($dataNew, $data1);
				}
				$data12 = array("", "", "", "", "", "","","");
				array_push($dataNew, $data12);

			}
			$response['status'] = 200;
			$response['data2'] = $dataNew;
			$response['data'] = $data;
			$response['scheduleParentMapp'] = $scheduleParentMapp;
		} else {
			$response['status'] = 201;
			$response['message'] = 'You can not view for this year and month';
		}
		echo json_encode($response);
	}

	public function getMainAccountData()
	{
		$company_id = $this->session->userdata('company_id');
		$type = $this->input->post('type');
		$getDataBranch = $this->Master_Model->order_by_data($select = "*", $where = array("company_id" => $company_id, "type0" => $type, 'status' => 1), $table = "main_account_setup_master", $order_by = "id", $key = "asc");
		$getgroupIds = $this->Master_Model->_select('master_account_group_ind', array('company_id' => $company_id, "type0" => $type, 'status' => 1), '*', false, null, null, 'sequence_no asc')->data;
		$dataNew = array();
		$group_array = array();
		if (count($getgroupIds) > 0) {
			foreach ($getgroupIds as $row) {
				array_push($group_array, $row->id . "-" . $row->sequence_no . "-" . $row->type1 . "-" . $row->type2 . "-" . $row->type3);
			}
		}
		if (count($getDataBranch) > 0) {
			foreach ($getDataBranch as $row1) {
				$group_data = $this->Master_Model->get_row_data('*', array('id' => $row1->group_id), 'master_account_group_ind');
				$group_id = "";
				if ($group_data != null) {
					$group_id = $group_data->id . "-" . $group_data->sequence_no . "-" . $group_data->type1 . "-" . $group_data->type2 . "-" . $group_data->type3;
				}

				$divide = "No";
				if ($row1->is_divide == 1) {
					$divide = "Yes";
				}
				$data1 = array($row1->main_gl_number,
					$row1->name,
					$group_id,
					$row1->type0,
					$row1->type1,
					$row1->type2,
					$row1->type3,
					$row1->calculation_method, $row1->sequence_number, $row1->monitory, $divide);
				array_push($dataNew, $data1);
			}
			$data12 = array("", "", "", "");
			array_push($dataNew, $data12);
		}

		$response['data2'] = $dataNew;
		$response['group'] = $group_array;
		echo json_encode($response);
	}

	public function getIndGroupData()
	{
		$company_id = $this->session->userdata('company_id');
		$id = $this->input->post('id');
		$type = $this->input->post('type');
		$where = array('id' => $id, 'type0' => 'BS', 'company_id' => $company_id);
		if ($type == 2) {
			$where = array('id' => $id, 'type0' => 'PL', 'company_id' => $company_id);
		}
		$group_data = $this->Master_Model->get_row_data('*', $where, 'master_account_group_ind');
		if ($group_data != null) {
			$divide = "No";
			if ($group_data->is_divide == 1) {
				$divide = "Yes";
			}
			$data = array(
				"id" => $group_data->id,
				"type0" => $group_data->type0,
				"type1" => $group_data->type1,
				"type2" => $group_data->type2,
				"type3" => $group_data->type3,
				"calculation_method" => $group_data->calculation_method,
				'monitory_status' => $group_data->monitory_status,
				'is_divide' => $divide
			);
			$response['status'] = 200;
			$response['data'] = $data;
		} else {
			$response['status'] = 201;
			$response['data'] = "No Data Found";
		}
		echo json_encode($response);
	}

	public function getIndiaGroupData()
	{
		$company_id = $this->session->userdata('company_id');
		$type = $this->input->post('type');
		$type0 = "BS";
		if ($type == 2) {
			$type0 = "PL";
		}
		$group_data = $this->Master_Model->order_by_data('*', array('type0' => $type0, 'company_id' => $company_id, 'status' => 1), 'master_account_group_ind', 'id', 'ASC');
		$data_array = array();
		if ($group_data != null) {
			foreach ($group_data as $row) {
				$divide = "No";
				if ($row->is_divide == 1) {
					$divide = "Yes";
				}
				$data = array(
					$row->id,
					$row->sequence_no,
					$row->type0,
					$row->type1,
					$row->type2,
					$row->type3,
					$row->calculation_method,
					$row->monitory_status,
					$divide
				);
				array_push($data_array, $data);
			}
			$response['status'] = 200;
			$response['data'] = $data_array;
			$response['query'] = $this->db->last_query();
		} else {
			$data = array();
			$response['status'] = 201;
			$response['data'] = $data;
			$response['body'] = "No Data Found";
		}
		echo json_encode($response);
	}

	public function InsertIndGroupData()
	{
		if (!is_null($this->input->post('value'))) {
			$value = $this->input->post('value');
			$type = $this->input->post('type');
			$user_id = $this->session->userdata('user_id');
			$company_id = $this->session->userdata('company_id');
			$newArray = array();
			$newArrayInsert = array();
			$main_branch_array = array();
			$type0 = "BS";
			if ($type == 2) {
				$type0 = "PL";
			}

			$getAllData = $this->Master_Model->_select('master_account_group_ind', array('company_id' => $company_id, 'status' => 1), '*', false);
			$main_data_bs = array();
			$main_data_pl = array();
			if ($getAllData->totalCount > 0) {
				$mainGl = $getAllData->data;
				foreach ($mainGl as $row) {
					if ($row->type0 == "BS") {
						$main_data_bs[$row->sequence_no] = $row->type1;
					} else {
						$main_data_pl[$row->sequence_no] = $row->type1;
					}
				}
			}
			$main_array = array_column($value, 1);
			$main_array = array_filter($main_array);
			$unique = array_unique($main_array);
			$duplicates = array_diff_assoc($main_array, $unique);
			if ($duplicates != null || !empty($duplicates)) {
				$duplicate_data = implode(",", $duplicates);
				$response['status'] = 201;
				$response['body'] = "Group Id " . $duplicate_data . " Already Exists in the List";
				echo json_encode($response);
				exit();
			} else {
				foreach ($value as $item) {
					$monitory = $item[7];
					if ($type == 2) {
						$monitory = 'No';
					}
					else{

						if($monitory ==null || empty($monitory) || $monitory=="null")
						{
							$monitory ='Yes';
						}
					}
					if ($item[3] != null && $item[3] != "") {


						$divide = 0;
						if ($item[8] == "Yes") {
							$divide = 1;
						}

						if ($type == 1) {
							if (array_key_exists($item[1], $main_data_pl)) {
								$response['status'] = 201;
								$response['body'] = $item[1] . " Already Exists in P&L";
								echo json_encode($response);
								exit();
							}
						} else {
							if (array_key_exists($item[1], $main_data_bs)) {
								$response['status'] = 201;
								$response['body'] = $item[1] . " Already Exists in Balance Sheet";
								echo json_encode($response);
								exit();
							}
						}


						if ($item[0] != null && $item[0] != "") {
							$data = array(
								"id" => $item[0],
								"sequence_no" => $item[1],
								"type0" => $type0,
								"type1" => $item[3],
								"type2" => $item[4],
								"type3" => $item[5],
								"calculation_method" => $item[6],
								"monitory_status" => $monitory,
								"is_divide" => $divide,
								"company_id" => $company_id,
								"created_by" => $user_id,
							);
							array_push($newArray, $data);
							$data1 = array(
								"group_id" => $item[0],
								"sequence_number" => $item[1],
								"type0" => $type0,
								"type1" => $item[3],
								"type2" => $item[4],
								"type3" => $item[5],
								"calculation_method" => $item[6],
								"monitory" => $monitory,
								"is_divide" => $divide,
							);
							array_push($main_branch_array, $data1);
						} else {
							$data = array(
								"type0" => $type0,
								"sequence_no" => $item[1],
								"type1" => $item[3],
								"type2" => $item[4],
								"type3" => $item[5],
								"calculation_method" => $item[6],
								"monitory_status" => $monitory,
								"is_divide" => $divide,
								"company_id" => $company_id,
								"created_by" => $user_id,
							);
							array_push($newArrayInsert, $data);
						}
					}
				}
			}

			if (count($newArray) > 0 || count($newArrayInsert) > 0) {

				$update_batch = false;
				$insert_batch = false;
				if (count($newArray) > 0) {
					$update_batch = $this->db->update_batch("master_account_group_ind", $newArray, "id");
					if ($update_batch) {
						if (count($main_branch_array) > 0) {
							$update = $this->db->update_batch('main_account_setup_master', $main_branch_array, 'group_id');
						}
					}
				}

				if (count($newArrayInsert) > 0) {
					$insert_batch = $this->db->insert_batch("master_account_group_ind", $newArrayInsert);
				}
				if ($update_batch == true || $insert_batch == true) {
					$response['status'] = 200;
					$response['body'] = "Data uploaded Successfully";
				} else {
					$response['status'] = 201;
					$response['body'] = "Failed To upload in DB";
				}
			} else {
				$response['status'] = 201;
				$response['body'] = "Failed To upload";
			}

		} else {
			$response['status'] = 201;
			$response['body'] = "Required Parameter Missing";
		}
		echo json_encode($response);
	}

	public function CheckIndGroup()
	{
		$data = $this->input->post('data');
		$company_id = $this->session->userdata('company_id');
		if (count($data) > 0) {
			if ($data[3] != "" && $data[3] != null && $data[4] != "" && $data[4] != null && $data[5] != "" && $data[5] != null) {
				$checkifExists = $this->Master_Model->get_count(array('type1' => $data[3], 'type2' => $data[4], 'type3' => $data[5], 'company_id' => $company_id, 'status' => 1), 'master_account_group_ind');
				if ($checkifExists == 0) {
					$response['status'] = 200;
					$response['data'] = 0;
				} else {
					$response['status'] = 201;
					$response['data'] = 1;
				}
			} else {
				$response['status'] = 201;
				$response['data'] = 'Required Parameter Missing';
			}
		} else {
			$response['status'] = 201;
			$response['data'] = "No Data Found";
		}
		echo json_encode($response);
	}

	public function UpdateIndGroup()
	{
		$id = $this->input->post('id');
		$type3 = $this->input->post('type3');
		$cm = $this->input->post('cm');
		$monitory = $this->input->post('monitory');
		$divide = $this->input->post('divide');
		$company_id = $this->session->userdata('company_id');
		$is_divide = 0;
		if ($divide == 'Yes') {
			$is_divide = 1;
		}
		$set = array(
			'type3' => $type3,
			'calculation_method' => $cm,
			'monitory_status' => $monitory,
			'is_divide' => $is_divide
		);
		$set1 = array(
			'type3' => $type3,
			'calculation_method' => $cm,
			'monitory' => $monitory,
			'is_divide' => $is_divide
		);
		if ($id != null && $type3 != null && $id != "" && $type3 != "") {
			$update = $this->Master_Model->_update('master_account_group_ind', $set, array('id' => $id, 'company_id' => $company_id));
			$update_main = $this->Master_Model->_update('main_account_setup_master', $set1, array('group_id' => $id, 'company_id' => $company_id));
			if ($update == true && $update_main == true) {
				$response['status'] = 200;
				$response['body'] = 'Data Updated';
			} else {
				$response['status'] = 201;
				$response['body'] = 'Failed To Upload Data';
			}
		}
		echo json_encode($response);
	}

	public function InsertMainAccountData()
	{
		if (!is_null($this->input->post('value'))) {
			$value = $this->input->post('value');
			$type = $this->input->post('type');
			$user_id = $this->session->userdata('user_id');
			$company_id = $this->session->userdata('company_id');
			$newArray = array();
			$newArrayInsert = array();
			$getAllData = $this->Master_Model->_select('main_account_setup_master', array('company_id' => $company_id, 'status' => 1), '*', false);
			$main_data_bs = array();
			$main_data_pl = array();
			if ($getAllData->totalCount > 0) {
				$mainGl = $getAllData->data;
				foreach ($mainGl as $row) {
					if ($row->type0 == "BS") {
						$main_data_bs[$row->main_gl_number] = $row->name;
					} else {
						$main_data_pl[$row->main_gl_number] = $row->name;
					}
				}
			}
			$main_array = array_column($value, 0);
			$main_array = array_filter($main_array);
			$unique = array_unique($main_array);
			$duplicates = array_diff_assoc($main_array, $unique);

			if ($duplicates != null || !empty($duplicates)) {
				$duplicate_data = implode(",", $duplicates);
				$response['status'] = 201;
				$response['body'] = "Main Gl Number " . $duplicate_data . " Already Exists in the List";
				echo json_encode($response);
				exit();
			} else {
				foreach ($value as $item) {
					if ($item[0] != "0" && $item[0] != "") {
						if ($item[2] != "" && $item[2] != null) {

							$group_data_ids = explode('-', $item[2]);
							$group_id = 0;
							if (count($group_data_ids) > 0) {
								$group_id = $group_data_ids[0];
							}

							$where = array('id' => $group_id, 'type0' => 'BS', 'company_id' => $company_id);
							if ($type == "PL") {
								$where = array('id' => $group_id, 'type0' => 'PL', 'company_id' => $company_id);
							}
							$group_data = $this->Master_Model->get_row_data('*', $where, 'master_account_group_ind');
							if ($group_data != null) {
								if ($type == "BS") {
									if (array_key_exists($item[0], $main_data_pl)) {
										$response['status'] = 201;
										$response['body'] = $item[0] . " Already Exists in P&L";
										echo json_encode($response);
										exit();
									}
								} else {
									if (array_key_exists($item[0], $main_data_bs)) {
										$response['status'] = 201;
										$response['body'] = $item[0] . " Already Exists in Balance Sheet";
										echo json_encode($response);
										exit();
									}
								}

								$data = array(
									"main_gl_number" => $item[0],
									"name" => $item[1],
									"group_id" => $group_data->id,
									"type0" => $type,
									"type1" => $group_data->type1,
									"type2" => $group_data->type2,
									"type3" => $group_data->type3,
									"calculation_method" => $group_data->calculation_method,
									"sequence_number" => $group_data->sequence_no,
									"company_id" => $company_id,
									"created_by" => $user_id,
									"monitory" => $group_data->monitory_status,
									"is_divide" => $group_data->is_divide,
									"status" => 1
								);
								array_push($newArrayInsert, $data);
							}
						}
					}
				}
			}
			$delete_main = $this->Master_Model->_delete('main_account_setup_master', array('company_id' => $company_id, 'type0' => $type));
			if (count($newArrayInsert) > 0) {
				$insert_batch = true;
				if (count($newArrayInsert) > 0) {
					$insert_batch = $this->db->insert_batch("main_account_setup_master", $newArrayInsert);
				}
				if ($insert_batch == true) {
					$response['status'] = 200;
					$response['insert'] = $newArrayInsert;
					$response['body'] = "Data uploaded Successfully";
				} else {
					$response['status'] = 201;
					$response['body'] = "Failed To upload in DB";
				}
			} else {
				$response['status'] = 201;
				$response['body'] = "Failed To upload";
			}
		} else {
			$response['status'] = 201;
			$response['body'] = "Required Parameter Missing";
		}
		echo json_encode($response);
	}


	///////US DATA FUNCTIONS///////////////////

	public function getUSMainAccountData()
	{
		$company_id = $this->session->userdata('company_id');
		$type = $this->input->post('type');
		$getDataBranch = $this->Master_Model->order_by_data($select = "*", $where = array("company_id" => $company_id, "type0" => $type, 'status' => 1), $table = "main_account_setup_master_us", $order_by = "id", $key = "desc");
		$getgroupIds = $this->Master_Model->_select('master_account_group_us', array('company_id' => $company_id, "type0" => $type, 'status' => 1), '*', false, null, null, 'sequence_no asc')->data;
		$dataNew = array();
		$group_array = array();
		if (count($getgroupIds) > 0) {
			foreach ($getgroupIds as $row) {
				array_push($group_array, $row->id . "-" . $row->sequence_no . "-" . $row->type1 . "-" . $row->type2 . "-" . $row->type3);
			}
		}
		if (count($getDataBranch) > 0) {
			foreach ($getDataBranch as $row1) {
				$group_data = $this->Master_Model->get_row_data('*', array('id' => $row1->group_id), 'master_account_group_us');
				$group_id = "";
				if ($group_data != null) {
					$group_id = $group_data->id . "-" . $group_data->sequence_no . "-" . $group_data->type1 . "-" . $group_data->type2 . "-" . $group_data->type3;
				}

				$divide = "No";
				if ($row1->is_divide == 1) {
					$divide = "Yes";
				}
				$data1 = array($row1->main_gl_number,
					$row1->name,
					$group_id,
					$row1->type0,
					$row1->type1,
					$row1->type2,
					$row1->type3,
					$row1->calculation_method, $row1->sequence_number, $row1->monitory, $divide);
				array_push($dataNew, $data1);
			}
			$data12 = array("", "", "", "");
			array_push($dataNew, $data12);

		}
		$response['data2'] = $dataNew;
		$response['group'] = $group_array;
		echo json_encode($response);
	}

	public function InsertUSAccountData()
	{
		if (!is_null($this->input->post('value'))) {
			$value = $this->input->post('value');
			$type = $this->input->post('type');
			$user_id = $this->session->userdata('user_id');
			$company_id = $this->session->userdata('company_id');
			$newArrayInsert = array();
			$getAllData = $this->Master_Model->_select('main_account_setup_master_us', array('company_id' => $company_id, 'status' => 1), '*', false);
			$main_data_bs = array();
			$main_data_pl = array();
			if ($getAllData->totalCount > 0) {
				$mainGl = $getAllData->data;
				foreach ($mainGl as $row) {
					if ($row->type0 == "BS") {
						$main_data_bs[$row->main_gl_number] = $row->name;
					} else {
						$main_data_pl[$row->main_gl_number] = $row->name;
					}
				}
			}
			$main_array = array_column($value, 0);
			$main_array = array_filter($main_array);
			$unique = array_unique($main_array);
			$duplicates = array_diff_assoc($main_array, $unique);
			if ($duplicates != null || !empty($duplicates)) {
				$duplicate_data = implode(",", $duplicates);
				$response['status'] = 201;
				$response['body'] = "Main Gl Number " . $duplicate_data . " Already Exists in the List";
				echo json_encode($response);
				exit();
			} else {
				foreach ($value as $item) {
					if ($item[0] != "0" && $item[0] != "") {
						if ($item[2] != "" && $item[2] != null) {
							$group_data_ids = explode('-', $item[2]);
							$group_id = 0;
							if (count($group_data_ids) > 0) {
								$group_id = $group_data_ids[0];
							}

							$where = array('id' => $group_id, 'type0' => 'BS', 'company_id' => $company_id);
							if ($type == "PL") {
								$where = array('id' => $group_id, 'type0' => 'PL', 'company_id' => $company_id);
							}
							$group_data = $this->Master_Model->get_row_data('*', $where, 'master_account_group_us');
							if ($group_data != null) {
								if ($type == "BS") {
									if (array_key_exists($item[0], $main_data_pl)) {
										$response['status'] = 201;
										$response['body'] = $item[0] . " Already Exists in P&L";
										echo json_encode($response);
										exit();
									}
								} else {
									if (array_key_exists($item[0], $main_data_bs)) {
										$response['status'] = 201;
										$response['body'] = $item[0] . " Already Exists in Balance Sheet";
										echo json_encode($response);
										exit();
									}
								}
								$data = array(
									"main_gl_number" => $item[0],
									"name" => $item[1],
									"group_id" => $group_data->id,
									"type0" => $type,
									"type1" => $group_data->type1,
									"type2" => $group_data->type2,
									"type3" => $group_data->type3,
									"calculation_method" => $group_data->calculation_method,
									"sequence_number" => $group_data->sequence_no,
									"company_id" => $company_id,
									"created_by" => $user_id,
									"monitory" => $group_data->monitory_status,
									"is_divide" => $group_data->is_divide,
									"status" => 1
								);
								array_push($newArrayInsert, $data);
							}
						}
					}
				}
			}
			$delete_main = $this->Master_Model->_delete('main_account_setup_master_us', array('company_id' => $company_id, 'type0' => $type));
			if (count($newArrayInsert) > 0) {
				$insert_batch = false;
				if (count($newArrayInsert) > 0) {
					$insert_batch = $this->db->insert_batch("main_account_setup_master_us", $newArrayInsert);
				}
				if ($insert_batch == true) {
					$response['status'] = 200;
					$response['insert'] = $newArrayInsert;
					$response['body'] = "Data uploaded Successfully";
				} else {
					$response['status'] = 201;
					$response['body'] = "Failed To upload in DB";
				}
			} else {
				$response['status'] = 201;
				$response['body'] = "Failed To upload";
			}
		} else {
			$response['status'] = 201;
			$response['body'] = "Required Parameter Missing";
		}
		echo json_encode($response);
	}

	public function getUSData()
	{
		$company_id = $this->session->userdata('company_id');
		$branch_id = $this->input->post('branch_id');
		$year = $this->input->post('year');
		$month = $this->input->post('month');

		$CheckBlockwhere = array('year' => $year, 'month' => $month, 'company_id' => $company_id);
		$checkPermission = $this->Master_Model->checkBlockYearMonth($CheckBlockwhere);
//		$permission = 0;
		if ($checkPermission == true) {
			$company = $this->Master_Model->order_by_data($select = "trim(main_gl_number) as main_gl_number", $where = array("company_id" => $company_id, 'status' => 1), $table = "main_account_setup_master_us", $order_by = "id", $key = "desc");
			$data = array();
			if (count($company)) {
				foreach ($company as $row) {
					$data[] = $row->main_gl_number;
				}
			}
			$getDataBranch = $this->Master_Model->order_by_data($select = "*", $where = array("company_id" => $company_id, 'branch_id' => $branch_id, 'status' => 1), $table = "branch_account_setup", $order_by = "id", $key = "asc");
			$dataNew = array();
			if (count($getDataBranch) > 0) {
				foreach ($getDataBranch as $row1) {
					if ($row1->is_ignore == 1) {
						$is_ignore = 'Yes';
					} else {
						$is_ignore = 'No';
					}
					$data1 = array($row1->id, $row1->account_number, $row1->detail, $row1->parent_account_number_us, $row1->parent_details_us, $is_ignore,$row1->schedule_account_number,$row1->schedule_details);
					array_push($dataNew, $data1);
				}
				$data12 = array("", "", "", "", "", "","","");
				array_push($dataNew, $data12);

			}
			$response['status'] = 200;
			$response['data2'] = $dataNew;
			$response['data'] = $data;
		} else {
			$response['status'] = 201;
			$response['message'] = 'You can not view for this year and month';
		}
		echo json_encode($response);
	}

	public function getUSGroupData()
	{
		$id = $this->input->post('id');
		$type = $this->input->post('type');
		$company_id = $this->session->userdata('company_id');
		$where = array('id' => $id, 'type0' => 'BS', 'company_id' => $company_id);
		if ($type == 2) {
			$where = array('id' => $id, 'type0' => 'PL', 'company_id' => $company_id);
		}
		$group_data_array = $this->Master_Model->order_by_data('*', $where, 'master_account_group_us', 'id', 'DESC');
		if ($group_data_array != null) {
			$group_data = $group_data_array[0];
			$divide = "No";
			if ($group_data->is_divide == 1) {
				$divide = "Yes";
			}
			$data = array(
				"id" => $group_data->id,
				"type0" => $group_data->type0,
				"type1" => $group_data->type1,
				"type2" => $group_data->type2,
				"type3" => $group_data->type3,
				"calculation_method" => $group_data->calculation_method,
				'monitory_status' => $group_data->monitory_status,
				'is_divide' => $divide
			);
			$response['status'] = 200;
			$response['data'] = $data;
		} else {
			$response['status'] = 201;
			$response['data'] = "No Data Found";
		}
		echo json_encode($response);
	}

	public function getUSGroupingData()
	{
		$company_id = $this->session->userdata('company_id');
		$type = $this->input->post('type');
		$type0 = "BS";
		if ($type == 2) {
			$type0 = "PL";
		}
		$group_data = $this->Master_Model->order_by_data('*', array('type0' => $type0, 'company_id' => $company_id, 'status' => 1), 'master_account_group_us', 'sequence_no', 'ASC');
		$data_array = array();
		if ($group_data != null) {
			foreach ($group_data as $row) {
				$divide = "No";
				if ($row->is_divide == 1) {
					$divide = "Yes";
				}
				$data = array(
					$row->id,
					$row->sequence_no,
					$row->type0,
					$row->type1,
					$row->type2,
					$row->type3,
					$row->calculation_method,
					$row->monitory_status,
					$divide
				);
				array_push($data_array, $data);
			}

			$response['status'] = 200;
			$response['data'] = $data_array;
		} else {
			$data = array();
			$response['status'] = 201;
			$response['data'] = $data;
			$response['body'] = "No Data Found";
		}
		echo json_encode($response);
	}

	public function InsertUSGroupData()
	{
		if (!is_null($this->input->post('value'))) {
			$value = $this->input->post('value');
			$type = $this->input->post('type');
			$user_id = $this->session->userdata('user_id');
			$company_id = $this->session->userdata('company_id');
			$newArray = array();
			$newArrayInsert = array();
			$main_branch_array = array();
			$type0 = "BS";
			if ($type == 2) {
				$type0 = "PL";
			}

			$getAllData = $this->Master_Model->_select('master_account_group_us', array('company_id' => $company_id, 'status' => 1), '*', false);
			$main_data_bs = array();
			$main_data_pl = array();
			if ($getAllData->totalCount > 0) {
				$mainGl = $getAllData->data;
				foreach ($mainGl as $row) {
					if ($row->type0 == "BS") {
						$main_data_bs[$row->sequence_no] = $row->type1;
					} else {
						$main_data_pl[$row->sequence_no] = $row->type1;
					}
				}
			}
			$main_array = array_column($value, 1);
			$main_array = array_filter($main_array);
			$unique = array_unique($main_array);
			$duplicates = array_diff_assoc($main_array, $unique);
			if ($duplicates != null || !empty($duplicates)) {
				$duplicate_data = implode(",", $duplicates);
				$response['status'] = 201;
				$response['body'] = "Group Id " . $duplicate_data . " Already Exists in the List";
				echo json_encode($response);
				exit();
			} else {

				foreach ($value as $item) {
					$monitory = $item[7];
					if ($type == 2) {
						$monitory = 'Yes';
					}
					if ($item[3] != null && $item[3] != "") {
						$divide = 0;
						if ($item[8] == "Yes") {
							$divide = 1;
						}

						if ($type == 1) {
							if (array_key_exists($item[1], $main_data_pl)) {
								$response['status'] = 201;
								$response['body'] = $item[1] . " Already Exists in P&L";
								echo json_encode($response);
								exit();
							}
						} else {
							if (array_key_exists($item[1], $main_data_bs)) {
								$response['status'] = 201;
								$response['body'] = $item[1] . " Already Exists in Balance Sheet";
								echo json_encode($response);
								exit();
							}
						}

						if ($item[0] != null && $item[0] != "") {
							$data = array(
								"id" => $item[0],
								"sequence_no" => $item[1],
								"type0" => $type0,
								"type1" => $item[3],
								"type2" => $item[4],
								"type3" => $item[5],
								"calculation_method" => $item[6],
								"monitory_status" => $monitory,
								"is_divide" => $divide,
								"company_id" => $company_id,
								"created_by" => $user_id,
							);
							array_push($newArray, $data);
							$data1 = array(
								"group_id" => $item[0],
								"sequence_number" => $item[1],
								"type0" => $type0,
								"type1" => $item[3],
								"type2" => $item[4],
								"type3" => $item[5],
								"calculation_method" => $item[6],
								"monitory" => $monitory,
								"is_divide" => $divide,
							);
							array_push($main_branch_array, $data1);
						} else {
							$data = array(
								"type0" => $type0,
								"sequence_no" => $item[1],
								"type1" => $item[3],
								"type2" => $item[4],
								"type3" => $item[5],
								"calculation_method" => $item[6],
								"monitory_status" => $monitory,
								"is_divide" => $divide,
								"company_id" => $company_id,
								"created_by" => $user_id,
							);
							array_push($newArrayInsert, $data);
						}
					}
				}
			}
			if (count($newArray) > 0 || count($newArrayInsert) > 0) {
				$update_batch = false;
				$insert_batch = false;
				if (count($newArray) > 0) {
					$update_batch = $this->db->update_batch("master_account_group_us", $newArray, "id");
					if ($update_batch) {
						if (count($main_branch_array) > 0) {
							$update = $this->db->update_batch('main_account_setup_master_us', $main_branch_array, 'group_id');
						}
					}
				}
				if (count($newArrayInsert) > 0) {
					$insert_batch = $this->db->insert_batch("master_account_group_us", $newArrayInsert);
				}
				if ($update_batch > 0 || $insert_batch > 0) {
					$response['status'] = 200;
					$response['body'] = "Data uploaded Successfully";
				} else {
					$response['status'] = 201;
					$response['body'] = "No Data Updated";
				}
			} else {
				$response['status'] = 201;
				$response['body'] = "Failed To upload";
			}

		} else {
			$response['status'] = 201;
			$response['body'] = "Required Parameter Missing";
		}
		echo json_encode($response);
	}

	public function CheckUSGroup()
	{
		$data = $this->input->post('data');
		$company_id = $this->session->userdata('company_id');
		if (count($data) > 0) {
			if ($data[3] != "" && $data[3] != null && $data[4] != "" && $data[4] != null && $data[5] != "" && $data[5] != null) {
				$checkifExists = $this->Master_Model->get_count(array('type1' => $data[3], 'type2' => $data[4], 'type3' => $data[5], 'company_id' => $company_id, 'status' => 1), 'master_account_group_us');
				if ($checkifExists == 0) {
					$response['status'] = 200;
					$response['data'] = 0;
				} else {
					$response['status'] = 201;
					$response['data'] = 1;
				}
			} else {
				$response['status'] = 201;
				$response['data'] = 'Required Parameter Missing';
			}
		} else {
			$response['status'] = 201;
			$response['data'] = "No Data Found";
		}
		echo json_encode($response);
	}

	public function UpdateUSGroup()
	{
		$id = $this->input->post('id');
		$type3 = $this->input->post('type3');
		$cm = $this->input->post('cm');
		$monitory = $this->input->post('monitory');
		$divide = $this->input->post('divide');
		$company_id = $this->session->userdata('company_id');
		$is_divide = 0;
		if ($divide == 'Yes') {
			$is_divide = 1;
		}
		$set = array(
			'type3' => $type3,
			'calculation_method' => $cm,
			'monitory_status' => $monitory,
			'is_divide' => $is_divide
		);
		$set1 = array(
			'type3' => $type3,
			'calculation_method' => $cm,
			'monitory' => $monitory,
			'is_divide' => $is_divide
		);
		if ($id != null && $type3 != null && $id != "" && $type3 != "") {
			$update = $this->Master_Model->_update('master_account_group_us', $set, array('id' => $id, 'company_id' => $company_id));
			$update_main = $this->Master_Model->_update('main_account_setup_master_us', $set1, array('group_id' => $id, 'company_id' => $company_id));
			if ($update == true && $update_main == true) {
				$response['status'] = 200;
				$response['body'] = 'Data Updated';
			} else {
				$response['status'] = 201;
				$response['body'] = 'Failed To Upload Data';
			}
		}
		echo json_encode($response);
	}


	/////////IFRS DATA FUNCTIONS/////////////////
	public function getIFRSMainAccountData()
	{
		$company_id = $this->session->userdata('company_id');
		$type = $this->input->post('type');
		$getDataBranch = $this->Master_Model->order_by_data($select = "*", $where = array("company_id" => $company_id, "type0" => $type, 'status' => 1), $table = "main_account_setup_master_ifrs", $order_by = "id", $key = "desc");
		$getgroupIds = $this->Master_Model->_select('master_account_group_ifrs', array('company_id' => $company_id, "type0" => $type, 'status' => 1), '*', false, null, null, 'sequence_no asc')->data;
		$dataNew = array();
		$group_array = array();
		if (count($getgroupIds) > 0) {
			foreach ($getgroupIds as $row) {
				array_push($group_array, $row->id . "-" . $row->sequence_no . "-" . $row->type1 . "-" . $row->type2 . "-" . $row->type3);
			}
		}
		if (count($getDataBranch) > 0) {
			foreach ($getDataBranch as $row1) {
				$group_data = $this->Master_Model->get_row_data('*', array('id' => $row1->group_id), 'master_account_group_ifrs');
				$group_id = "";
				if ($group_data != null) {
					$group_id = $group_data->id . "-" . $group_data->sequence_no . "-" . $group_data->type1 . "-" . $group_data->type2 . "-" . $group_data->type3;
				}

				$divide = "No";
				if ($row1->is_divide == 1) {
					$divide = "Yes";
				}
				$data1 = array($row1->main_gl_number,
					$row1->name,
					$group_id,
					$row1->type0,
					$row1->type1,
					$row1->type2,
					$row1->type3,
					$row1->calculation_method, $row1->sequence_number, $row1->monitory, $divide);
				array_push($dataNew, $data1);
			}
			$data12 = array("", "", "", "");
			array_push($dataNew, $data12);

		}
		$response['data2'] = $dataNew;
		$response['group'] = $group_array;
		echo json_encode($response);
	}

	public function InsertIFRSAccountData()
	{
		if (!is_null($this->input->post('value'))) {
			$value = $this->input->post('value');
			$type = $this->input->post('type');
			$user_id = $this->session->userdata('user_id');
			$company_id = $this->session->userdata('company_id');
			$newArrayInsert = array();
			$getAllData = $this->Master_Model->_select('main_account_setup_master_ifrs', array('company_id' => $company_id, 'status' => 1), '*', false);
			$main_data_bs = array();
			$main_data_pl = array();
			if ($getAllData->totalCount > 0) {
				$mainGl = $getAllData->data;
				foreach ($mainGl as $row) {
					if ($row->type0 == "BS") {
						$main_data_bs[$row->main_gl_number] = $row->name;
					} else {
						$main_data_pl[$row->main_gl_number] = $row->name;
					}
				}
			}
			$main_array = array_column($value, 0);
			$main_array = array_filter($main_array);
			$unique = array_unique($main_array);
			$duplicates = array_diff_assoc($main_array, $unique);
			if ($duplicates != null || !empty($duplicates)) {
				$duplicate_data = implode(",", $duplicates);
				$response['status'] = 201;
				$response['body'] = "Main Gl Number " . $duplicate_data . " Already Exists in the List";
				echo json_encode($response);
				exit();
			} else {
				foreach ($value as $item) {
					if ($item[0] != "0" && $item[0] != "") {
						if ($item[2] != "" && $item[2] != null) {
							$group_data_ids = explode('-', $item[2]);
							$group_id = 0;
							if (count($group_data_ids) > 0) {
								$group_id = $group_data_ids[0];
							}
							$where = array('id' => $group_id, 'type0' => 'BS', 'company_id' => $company_id);
							if ($type == "PL") {
								$where = array('id' => $group_id, 'type0' => 'PL', 'company_id' => $company_id);
							}
							$group_data = $this->Master_Model->get_row_data('*', $where, 'master_account_group_ifrs');
							if ($group_data != null) {
								if ($type == "BS") {
									if (array_key_exists($item[0], $main_data_pl)) {
										$response['status'] = 201;
										$response['body'] = $item[0] . " Already Exists in P&L";
										echo json_encode($response);
										exit();
									}
								} else {
									if (array_key_exists($item[0], $main_data_bs)) {
										$response['status'] = 201;
										$response['body'] = $item[0] . " Already Exists in Balance Sheet";
										echo json_encode($response);
										exit();
									}
								}
								$data = array(
									"main_gl_number" => $item[0],
									"name" => $item[1],
									"group_id" => $group_data->id,
									"type0" => $type,
									"type1" => $group_data->type1,
									"type2" => $group_data->type2,
									"type3" => $group_data->type3,
									"calculation_method" => $group_data->calculation_method,
									"sequence_number" => $group_data->sequence_no,
									"company_id" => $company_id,
									"created_by" => $user_id,
									"monitory" => $group_data->monitory_status,
									"is_divide" => $group_data->is_divide,
									"status" => 1
								);
								array_push($newArrayInsert, $data);
							}
						}
					}
				}
			}
			$delete_main = $this->Master_Model->_delete('main_account_setup_master_ifrs', array('company_id' => $company_id, 'type0' => $type));
			if (count($newArrayInsert) > 0) {
				$insert_batch = false;
				if (count($newArrayInsert) > 0) {
					$insert_batch = $this->db->insert_batch("main_account_setup_master_ifrs", $newArrayInsert);
				}
				if ($insert_batch == true) {
					$response['status'] = 200;
					$response['insert'] = $newArrayInsert;
					$response['body'] = "Data uploaded Successfully";
				} else {
					$response['status'] = 201;
					$response['body'] = "Failed To upload in DB";
				}
			} else {
				$response['status'] = 201;
				$response['body'] = "Failed To upload";
			}
		} else {
			$response['status'] = 201;
			$response['body'] = "Required Parameter Missing";
		}
		echo json_encode($response);
	}

	public function getIFRSData()
	{
		$company_id = $this->session->userdata('company_id');
		$branch_id = $this->input->post('branch_id');
		$year = $this->input->post('year');
		$month = $this->input->post('month');

		$CheckBlockwhere = array('year' => $year, 'month' => $month, 'company_id' => $company_id);
		$checkPermission = $this->Master_Model->checkBlockYearMonth($CheckBlockwhere);
//		$permission = 0;
		if ($checkPermission == true) {
			$company = $this->Master_Model->order_by_data($select = "trim(main_gl_number) as main_gl_number", $where = array("company_id" => $company_id, 'status' => 1), $table = "main_account_setup_master_ifrs", $order_by = "id", $key = "desc");
			$data = array();
			if (count($company)) {
				foreach ($company as $row) {
					$data[] = $row->main_gl_number;
				}
			}
			$getDataBranch = $this->Master_Model->order_by_data($select = "*", $where = array("company_id" => $company_id, 'branch_id' => $branch_id, 'status' => 1), $table = "branch_account_setup", $order_by = "id", $key = "asc");
			$dataNew = array();
			if (count($getDataBranch) > 0) {
				foreach ($getDataBranch as $row1) {
					if ($row1->is_ignore == 1) {
						$is_ignore = 'Yes';
					} else {
						$is_ignore = 'No';
					}
					$data1 = array($row1->id, $row1->account_number, $row1->detail, $row1->parent_account_number_ifrs, $row1->parent_details_ifrs, $is_ignore,$row1->schedule_account_number,$row1->schedule_details);
					array_push($dataNew, $data1);
				}
				$data12 = array("", "", "", "", "", "","","");
				array_push($dataNew, $data12);

			}
			$response['status'] = 200;
			$response['data2'] = $dataNew;
			$response['data'] = $data;
		} else {
			$response['status'] = 201;
			$response['message'] = 'You can not view for this year and month';
		}
		echo json_encode($response);
	}

	public function getIfrsGroupData()
	{
		$id = $this->input->post('id');
		$type = $this->input->post('type');
		$company_id = $this->session->userdata('company_id');
		$where = array('id' => $id, 'type0' => 'BS', 'company_id' => $company_id);
		if ($type == 2) {
			$where = array('id' => $id, 'type0' => 'PL', 'company_id' => $company_id);
		}
		$group_data_array = $this->Master_Model->order_by_data('*', $where, 'master_account_group_ifrs', 'id', 'ASC');
		if ($group_data_array != null) {
			$group_data = $group_data_array[0];
			$divide = "No";
			if ($group_data->is_divide == 1) {
				$divide = "Yes";
			}
			$data = array(
				"id" => $group_data->id,
				"type0" => $group_data->type0,
				"type1" => $group_data->type1,
				"type2" => $group_data->type2,
				"type3" => $group_data->type3,
				"calculation_method" => $group_data->calculation_method,
				'monitory_status' => $group_data->monitory_status,
				'is_divide' => $divide
			);
			$response['status'] = 200;
			$response['data'] = $data;
		} else {
			$response['status'] = 201;
			$response['data'] = "No Data Found";
		}
		echo json_encode($response);
	}

	public function getIfrsGroupingData()
	{
		$type = $this->input->post('type');
		$company_id = $this->session->userdata('company_id');
		$type0 = "BS";
		if ($type == 2) {
			$type0 = "PL";
		}
		$group_data = $this->Master_Model->order_by_data('*', array('type0' => $type0, 'company_id' => $company_id, 'status' => 1), 'master_account_group_ifrs', 'sequence_no', 'ASC');
//		$group_data = $this->Master_Model->get_all_data(array('type0' => $type0, 'company_id' => $company_id,'status'=>1), 'master_account_group_ifrs');
		$data_array = array();
		if ($group_data != null) {
			foreach ($group_data as $row) {
				$divide = "No";
				if ($row->is_divide == 1) {
					$divide = "Yes";
				}
				$data = array(
					$row->id,
					$row->sequence_no,
					$row->type0,
					$row->type1,
					$row->type2,
					$row->type3,
					$row->calculation_method,
					$row->monitory_status,
					$divide
				);
				array_push($data_array, $data);
			}

			$response['status'] = 200;
			$response['data'] = $data_array;
		} else {
			$data = array();
			$response['status'] = 201;
			$response['data'] = $data;
			$response['body'] = "No Data Found";
		}
		echo json_encode($response);
	}

	public function InsertIfrsGroupData()
	{
		if (!is_null($this->input->post('value'))) {
			$value = $this->input->post('value');
			$type = $this->input->post('type');
			$user_id = $this->session->userdata('user_id');
			$company_id = $this->session->userdata('company_id');
			$newArray = array();
			$newArrayInsert = array();
			$main_branch_array = array();
			$type0 = "BS";
			if ($type == 2) {
				$type0 = "PL";
			}
			$getAllData = $this->Master_Model->_select('master_account_group_ifrs', array('company_id' => $company_id, 'status' => 1), '*', false);
			$main_data_bs = array();
			$main_data_pl = array();
			if ($getAllData->totalCount > 0) {
				$mainGl = $getAllData->data;
				foreach ($mainGl as $row) {
					if ($row->type0 == "BS") {
						$main_data_bs[$row->sequence_no] = $row->type1;
					} else {
						$main_data_pl[$row->sequence_no] = $row->type1;
					}
				}
			}
			$main_array = array_column($value, 1);
			$main_array = array_filter($main_array);
			$unique = array_unique($main_array);
			$duplicates = array_diff_assoc($main_array, $unique);
			if ($duplicates != null || !empty($duplicates)) {
				$duplicate_data = implode(",", $duplicates);
				$response['status'] = 201;
				$response['body'] = "Group Id " . $duplicate_data . " Already Exists in the List";
				echo json_encode($response);
				exit();
			} else {
				foreach ($value as $item) {
					$monitory = $item[7];
					if ($type == 2) {
						$monitory = 'Yes';
					}
					if ($item[3] != null && $item[3] != "") {
						$divide = 0;
						if ($item[8] == "Yes") {
							$divide = 1;
						}

						if ($type == 1) {
							if (array_key_exists($item[1], $main_data_pl)) {
								$response['status'] = 201;
								$response['body'] = $item[1] . " Already Exists in P&L";
								echo json_encode($response);
								exit();
							}
						} else {
							if (array_key_exists($item[1], $main_data_bs)) {
								$response['status'] = 201;
								$response['body'] = $item[1] . " Already Exists in Balance Sheet";
								echo json_encode($response);
								exit();
							}
						}

						if ($item[0] != null && $item[0] != "") {
							$data = array(
								"id" => $item[0],
								"sequence_no" => $item[1],
								"type0" => $type0,
								"type1" => $item[3],
								"type2" => $item[4],
								"type3" => $item[5],
								"calculation_method" => $item[6],
								"monitory_status" => $monitory,
								"is_divide" => $divide,
								"company_id" => $company_id,
								"created_by" => $user_id,
							);
							array_push($newArray, $data);
							$data1 = array(
								"group_id" => $item[0],
								"sequence_number" => $item[1],
								"type0" => $type0,
								"type1" => $item[3],
								"type2" => $item[4],
								"type3" => $item[5],
								"calculation_method" => $item[6],
								"monitory" => $monitory,
								"is_divide" => $divide,
							);
							array_push($main_branch_array, $data1);
						} else {
							$data = array(
								"type0" => $type0,
								"sequence_no" => $item[1],
								"type1" => $item[3],
								"type2" => $item[4],
								"type3" => $item[5],
								"calculation_method" => $item[6],
								"monitory_status" => $monitory,
								"is_divide" => $divide,
								"company_id" => $company_id,
								"created_by" => $user_id,
							);
							array_push($newArrayInsert, $data);
						}
					}
				}
			}
			if (count($newArray) > 0 || count($newArrayInsert) > 0) {
				$update_batch = false;
				$insert_batch = false;
				if (count($newArray) > 0) {
					$update_batch = $this->db->update_batch("master_account_group_ifrs", $newArray, "id");
					if ($update_batch) {
						if (count($main_branch_array) > 0) {
							$update = $this->db->update_batch('main_account_setup_master_ifrs', $main_branch_array, 'group_id');
						}
					}
				}
				if (count($newArrayInsert) > 0) {
					$insert_batch = $this->db->insert_batch("master_account_group_ifrs", $newArrayInsert);
				}
				if ($update_batch == true || $insert_batch == true) {
					$response['status'] = 200;
					$response['body'] = "Data uploaded Successfully";
				} else {
					$response['status'] = 201;
					$response['body'] = "Failed To upload in DB";
				}
			} else {
				$response['status'] = 201;
				$response['body'] = "Failed To upload";
			}

		} else {
			$response['status'] = 201;
			$response['body'] = "Required Parameter Missing";
		}
		echo json_encode($response);
	}

	public function CheckIfrsGroup()
	{
		$data = $this->input->post('data');
		$company_id = $this->session->userdata('company_id');
		if (count($data) > 0) {
			if ($data[3] != "" && $data[3] != null && $data[4] != "" && $data[4] != null && $data[5] != "" && $data[5] != null) {
				$checkifExists = $this->Master_Model->get_count(array('type1' => $data[3], 'type2' => $data[4], 'type3' => $data[5], 'company_id' => $company_id, 'status' => 1), 'master_account_group_ifrs');
				if ($checkifExists == 0) {
					$response['status'] = 200;
					$response['data'] = 0;
				} else {
					$response['status'] = 201;
					$response['data'] = 1;
				}
			} else {
				$response['status'] = 201;
				$response['data'] = 'Required Parameter Missing';
			}
		} else {
			$response['status'] = 201;
			$response['data'] = "No Data Found";
		}
		echo json_encode($response);
	}

	public function UpdateIfrsGroup()
	{
		$id = $this->input->post('id');
		$type3 = $this->input->post('type3');
		$cm = $this->input->post('cm');
		$monitory = $this->input->post('monitory');
		$divide = $this->input->post('divide');
		$company_id = $this->session->userdata('company_id');
		$is_divide = 0;
		if ($divide == 'Yes') {
			$is_divide = 1;
		}
		$set = array(
			'type3' => $type3,
			'calculation_method' => $cm,
			'monitory_status' => $monitory,
			'is_divide' => $is_divide
		);
		$set1 = array(
			'type3' => $type3,
			'calculation_method' => $cm,
			'monitory' => $monitory,
			'is_divide' => $is_divide
		);
		if ($id != null && $type3 != null && $id != "" && $type3 != "") {
			$update = $this->Master_Model->_update('master_account_group_ifrs', $set, array('id' => $id, 'company_id' => $company_id));
			$update_main = $this->Master_Model->_update('main_account_setup_master_ifrs', $set1, array('group_id' => $id, 'company_id' => $company_id));
			if ($update == true && $update_main == true) {
				$response['status'] = 200;
				$response['body'] = 'Data Updated';
			} else {
				$response['status'] = 201;
				$response['body'] = 'Failed To Upload Data';
			}
		}
		echo json_encode($response);
	}


	function getTotalDataDB()
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

		if ($div == 'ReportSheet') {
			$table = 'consolidate_report_transaction cr';
			$table2 = 'main_account_setup_master';
		}
		if ($div == 'ReportSheetUS') {
			$table = 'consolidate_report_transaction_us cr';
			$table2 = 'main_account_setup_master_us';
		}
		if ($div == 'ReportSheetIFRS') {
			$table = 'consolidate_report_transaction_ifrs cr';
			$table2 = 'main_account_setup_master_ifrs';
		}
		$filterArray = array();
		$getTotalData = $this->Master_Model->_select($table,
			array("company_id" => $company_id, "year" => $year, "month" => $month,"is_transfer"=>0),
			array('*', '(select group_concat(ma.type3,' || ',ma.name) from ' . $table2 . ' ma where ma.company_id=ct.company_id and ma.main_gl_number=ct.account_number) as main_data'), false)->data;
		$where = array("company_id" => $company_id);

		$getBranchWithMainAccount = $this->Master_Model->_select($table2,
			$where,
			array('*'), false, array('main_gl_number'))->data;

		if (count($getTotalData) > 0) {
			foreach ($getTotalData as $records) {
				foreach ($getBranchWithMainAccount as $account) {
					if ($account->main_gl_number === $records->account_number) {
						$filterArray[$account->main_gl_number][$records->branch_id][] = array(
							$records->total,
							$records->opening_balance,
							$records->debit,
							$records->credit,

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
		array_push($columnHeader, 'Name', 'Type1', 'Type2', 'Type3', 'Parent Code');
		foreach ($branchData as $branch) {
			array_push($columnHeader, $branch->name . "(Opening Balance)");//column headers
			array_push($source, array('type' => 'numeric'));
			array_push($columnHeader, $branch->name . "(Debit)");//column headers
			array_push($source, array('type' => 'numeric'));
			array_push($columnHeader, $branch->name . "(Credit)");//column headers
			array_push($source, array('type' => 'numeric'));
			array_push($columnHeader, $branch->name . "(Total-" . $branch->currency . ")");//column headers
			array_push($source, array('type' => 'numeric'));
		}


		$finalArray = array();
		foreach ($getBranchWithMainAccount as $parent) {
			$main_dataArray = array();
			array_push($main_dataArray, $parent->name, $parent->type1, $parent->type2, $parent->type3, $parent->main_gl_number);
			$allChildRecords = array();
			if (array_key_exists($parent->main_gl_number, $filterArray)) {


				foreach ($branchData as $branch) {
					$BranchChildRecords = array();
					$BranchOBRecords = array();
					$BranchDrRecords = array();
					$BranchCrRecords = array();
					foreach ($filterArray[$parent->main_gl_number] as $key => $childRecords) {

						if ($key == $branch->id) {
							foreach ($childRecords as $childvalue) {
								array_push($BranchChildRecords, $childvalue[0]);
								array_push($BranchOBRecords, $childvalue[1]);
								array_push($BranchDrRecords, $childvalue[2]);
								array_push($BranchCrRecords, $childvalue[3]);
								array_push($allChildRecords, $childvalue);
							}

						}
					}
					$branch_total = array_sum($BranchChildRecords);
					$ob_total = array_sum($BranchOBRecords);
					$dr_total = array_sum($BranchDrRecords);
					$cr_total = array_sum($BranchCrRecords);
					// print_r($branch_total);exit();
					array_push($main_dataArray, number_format($ob_total, 2));
					array_push($main_dataArray, number_format($dr_total, 2));
					array_push($main_dataArray, number_format($cr_total, 2));
					array_push($main_dataArray, number_format($branch_total, 2));


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

	public function excelupload()
	{

		$mimes = array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel', 'text/xls');
//		var_dump($_FILES);
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
		$options = $this->getExcelDatabaseColumn(2);
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
		$response['type'] = $this->input->post('main_type');

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

	public function getValueDetail()
	{
		$company_id = $this->session->userdata('company_id');
		$master_id = $this->input->post('value');
		$type = $this->input->post('type');
		$table = "main_account_setup_master";
		if ($type == 2) {
			$table = "main_account_setup_master_us";
		}
		if ($type == 3) {
			$table = "main_account_setup_master_ifrs";
		}
		$company = $this->Master_Model->
		get_row_data('*', array("company_id" => $company_id, "main_gl_number" => $master_id), $table);
		$data = $company->name;

		if ($data != "") {
			$response['status'] = 200;
			$response['data'] = $data;
		} else {
			$response['status'] = 201;
		}
		echo json_encode($response);
	}


	public function RemoveGroupData()
	{
		$id = $this->input->post('id');
		$type = $this->input->post('type');
		if ($id != null && !empty($id)) {
			$table = "master_account_group_ind";
			if ($type == 2) {
				$table = "master_account_group_us";
			}
			if ($type == 3) {
				$table = "master_account_group_ifrs";
			}
			$update_status = $this->Master_Model->_update($table, array('status' => 0), array('id' => $id));
			if ($update_status == true) {
				$response['status'] = 200;
				$response['data'] = "Data Removed";
			} else {
				$response['status'] = 201;
				$response['data'] = "Something Went Wrong";
			}
		} else {
			$response['status'] = 201;
			$response['data'] = "No Data Found";
		}
		echo json_encode($response);
	}

	public function MainMapping()
	{
		$id = $this->input->get('id');
		$type = $this->input->get('type');
		$result['id'] = $id;
		$result['type'] = $type;
		$result['title'] = "Main Account Mapping";
		$this->load->view('Admin/main_account/MainMapping', $result);
	}

	public function getMainMapData()
	{
		$company_id = $this->session->userdata('company_id');
		$id = $this->input->post('id');
		$type = $this->input->post('type');
		$table = 'master_account_group_ind';
		$table2 = "main_account_setup_master";
		if ($id == 2) {
			$table = 'master_account_group_us';
			$table2 = "main_account_setup_master_us";

		}
		if ($id == 3) {
			$table = 'master_account_group_ifrs';
			$table2 = "main_account_setup_master_ifrs";
		}

		$where = 'company_id = "' . $company_id . '" and status = 1';
		$type0 = "BS";
		if ($type == 1) {
			$type0 = "BS";
			$where .= ' and type0 = "BS"';
		}
		if ($type == 2) {
			$type0 = "PL";
			$where .= ' and type0 = "PL"';
		}

		$group_data = array();
		$GroupData = $this->Master_Model->_select($table, $where, array('id', 'type1', 'type2', 'type3'), false, null, null, 'id asc')->data;
		$mainData = $this->Master_Model->_select($table2, array('company_id' => $company_id, 'status' => 1, 'group_id!=' => null, 'type0' => $type0), array('*'), false)->data;
		$unmatched_data = $this->Master_Model->_select($table2, array('group_id' => null, 'status' => 1, 'company_id' => $company_id, 'type0' => $type0), array('main_gl_number', 'name'), false)->data;
		if ($GroupData != null) {
			foreach ($GroupData as $group) {
				if ($mainData != null) {
					foreach ($mainData as $main) {
						$parent = $main->group_id;
						if ($parent == $group->id) {
							$group_data[$group->id . "||" . $group->type1 . "||" . $group->type2 . "||" . $group->type3][] = $main->main_gl_number . "||" . $main->name;
						} else {
							$group_data[$group->id . "||" . $group->type1 . "||" . $group->type2 . "||" . $group->type3][] = array();
						}
					}
				} else {
					$group_data[$group->id . "||" . $group->type1 . "||" . $group->type2 . "||" . $group->type3][] = array();
				}
			}
		}

		$group_div = "";
		$main_div = "";

		foreach ($group_data as $key => $main) {
			$main_account = explode("||", $key);
			if (count($main_account) >= 2) {
				$main_id = $main_account[0];
				$main_name = $main_account[1] . '-' . $main_account[2] . '-' . $main_account[3];
				$name1 = ucwords(strtolower($main_name));
				$group_div .= '<div class="col-md-4 col_type1">'
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
							$group_div .= '<div id="' . $branch_id . '" data-branch_id="' . $branch_id . '" class="child_list childlist">' . $branch_name . '</div>';
						}
					}
				}
				$group_div .= '</div>'
					. '</div>'
					. '</div>';
			}
		}

		if ($unmatched_data != null) {
			foreach ($unmatched_data as $main) {
				if ($main->main_gl_number != null && $main->main_gl_number != "" && $main->name != null && $main->name != "") {
					$branch_no = $main->main_gl_number;
					$detail = $main->name;
					$main_div .= '<div id ="' . $branch_no . '" data-branch_id ="' . $branch_no . '" class="child_list">' . $detail . '</div>';
				}
			}
		}
		if ($group_div != "" || $main_div != "") {
			$result['GroupDiv'] = $group_div;
			$result['MainDiv'] = $main_div;
			$result['status'] = 200;
		} else {
			$result['status'] = 201;
			$result['body'] = "No Data Found";
		}
		echo json_encode($result);
	}

	public function UpdateMainGroupMap()
	{
		$company_id = $this->session->userdata('company_id');
		$id = $this->input->post('id');
		$type = $this->input->post('type');
		$group_id = $this->input->post('group_id');
		$main_ids = $this->input->post('main_id');
		$main_id = json_decode($main_ids);
		$table = "main_account_setup_master";
		$table2 = "master_account_group_ind";
		if ($id == 2) {
			$table = "main_account_setup_master_us";
			$table2 = "master_account_group_us";
		}
		if ($id == 3) {
			$table = "main_account_setup_master_ifrs";
			$table2 = "master_account_group_ifrs";
		}
		$type0 = "BS";
		if ($type == 1) {
			$type0 = "BS";
		} else {
			$type0 = "PL";
		}
		if (!empty($main_id)) {
			$update_main = false;
			foreach ($main_id as $row) {
				if ($group_id == 'sortable1') {
					$data = array(
						"group_id" => null,
						"type0" => $type0,
						"type1" => "",
						"type2" => "",
						"type3" => "",
						"calculation_method" => "",
						'monitory' => "",
						'is_divide' => ""
					);
					$update_main = $this->Master_Model->_update($table, $data, array('main_gl_number' => $row, 'company_id' => $company_id));
				} else {
					$data = array();
					$group_data = $this->Master_Model->get_row_data('*', array('id' => $group_id, 'company_id' => $company_id), $table2);
					if ($group_data != null) {
						$data = array(
							"group_id" => $group_data->id,
							"type0" => $type0,
							"type1" => $group_data->type1,
							"type2" => $group_data->type2,
							"type3" => $group_data->type3,
							"calculation_method" => $group_data->calculation_method,
							'monitory' => $group_data->monitory_status,
							'is_divide' => $group_data->is_divide
						);
					}
					$update_main = $this->Master_Model->_update($table, $data, array('main_gl_number' => $row, 'company_id' => $company_id));
				}
			}
			if ($update_main) {
				$response['status'] = 200;
				$response['message'] = 'Main Account Mapped';
			} else {
				$response['status'] = 201;
				$response['message'] = 'Main Account Not Mapped';
			}
		} else {
			$response['status'] = 201;
			$response['message'] = 'No Main Account to Map';
		}
		echo json_encode($response);
	}
	public function getMainScheduleAccountData()
	{
		$company_id = $this->session->userdata('company_id');
		$type = $this->input->post('type');
		$countryType = $this->input->post('countryType');
		if($countryType==2)
		{
			$scheduleAccount='main_schedule_account_setup_master_us';
		}
		else if($countryType==3)
		{
			$scheduleAccount='main_schedule_account_setup_master_ifrs';
		}
		else
		{
			$scheduleAccount='main_schedule_account_setup_master';
		}
		$getDataBranch = $this->Master_Model->order_by_data($select = "*", $where = array("company_id" => $company_id, 'status' => 1), $table = $scheduleAccount, $order_by = "id", $key = "asc");
		$dataNew = array();
		if (count($getDataBranch) > 0) {
			foreach ($getDataBranch as $row1) {
				$data1 = array($row1->schedule_account,
					$row1->name);
				array_push($dataNew, $data1);
			}
			$data12 = array("", "");
			array_push($dataNew, $data12);
		}

		$response['data2'] = $dataNew;
		echo json_encode($response);
	}
	public function getIndSchedulingData()
	{
		$company_id = $this->session->userdata('company_id');
		$id = $this->input->post('id');
		$type = $this->input->post('type');
		$grp_id = $this->input->post('grp_id');
		$where = array('main_gl_number' => $id,'group_id'=>$grp_id,'company_id' => $company_id);

		$group_data = $this->Master_Model->get_row_data('*', $where, 'main_account_setup_master');
		if ($group_data != null) {
			$divide = "No";
			if ($group_data->is_divide == 1) {
				$divide = "Yes";
			}
			$data = array(
				"id" => $group_data->id,
				"type0" => $group_data->type0,
				"calculation_method" => $group_data->calculation_method,
				'monitory_status' => $group_data->monitory,
				'sequence_no' => $group_data->sequence_number,
				'is_divide' => $divide
			);
			$response['status'] = 200;
			$response['data'] = $data;
		} else {
			$response['status'] = 201;
			$response['data'] = "No Data Found";
		}
		echo json_encode($response);
	}
	public function InsertMainScheduleAccountData()
	{
		if (!is_null($this->input->post('value'))) {
			$value = $this->input->post('value');
			$type = $this->input->post('type');
			$user_id = $this->session->userdata('user_id');
			$company_id = $this->session->userdata('company_id');
			$countryType = $this->input->post('countryType');
			if($countryType==2)
			{
				$scheduleAccount='main_schedule_account_setup_master_us';
				$mainSetup='main_account_setup_master_us';
				$groupTable='master_account_group_us';
			}
			else if($countryType==3)
			{
				$scheduleAccount='main_schedule_account_setup_master_ifrs';
				$mainSetup='main_account_setup_master_ifrs';
				$groupTable='master_account_group_ifrs';
			}
			else
			{
				$scheduleAccount='main_schedule_account_setup_master';
				$mainSetup='main_account_setup_master';
				$groupTable='master_account_group_ind';
			}
			$newArray = array();
			$newArrayInsert = array();
			$getAllData = $this->Master_Model->_select($scheduleAccount, array('company_id' => $company_id, 'status' => 1), '*', false);
			$main_data_bs = array();
			$main_data_pl = array();
			if ($getAllData->totalCount > 0) {
				$mainGl = $getAllData->data;
				foreach ($mainGl as $row) {
					if ($row->type0 == "BS") {
						$main_data_bs[$row->schedule_account] = $row->name;
					} else {
						$main_data_pl[$row->schedule_account] = $row->name;
					}
				}
			}

			$main_array = array_column($value, 0);
			$main_array = array_filter($main_array);
			$unique = array_unique($main_array);
			$duplicates = array_diff_assoc($main_array, $unique);
			if ($duplicates != null || !empty($duplicates)) {
				$duplicate_data = implode(",", $duplicates);
				$response['status'] = 201;
				$response['body'] = "Main Gl Number " . $duplicate_data . " Already Exists in the List";
				echo json_encode($response);
				exit();
			} else {
				foreach ($value as $item) {
					if ($item[0] != "0" && $item[0] != "") {
								$data = array(
									"schedule_account" => $item[0],
									"name" => $item[1],
									"company_id" => $company_id,
									"created_by" => $user_id,
									"created_on" => date('Y-m-d H:i:s'),
									"status" => 1
								);
								array_push($newArrayInsert, $data);
					}
				}
			}
			$delete_main = $this->Master_Model->_delete($scheduleAccount, array('company_id' => $company_id));
			if (count($newArrayInsert) > 0) {
				$insert_batch = true;
				if (count($newArrayInsert) > 0) {
					$insert_batch = $this->db->insert_batch($scheduleAccount, $newArrayInsert);
				}
				if ($insert_batch == true) {
					$response['status'] = 200;
					$response['insert'] = $newArrayInsert;
					$response['body'] = "Data uploaded Successfully";
				} else {
					$response['status'] = 201;
					$response['body'] = "Failed To upload in DB";
				}
			} else {
				$response['status'] = 201;
				$response['body'] = "Failed To upload";
			}
		} else {
			$response['status'] = 201;
			$response['body'] = "Required Parameter Missing";
		}
		echo json_encode($response);
	}
	public function getParentSchedulingAccount()
	{
		$company_id = $this->session->userdata('company_id');
		$id = $this->input->post('id');
		$account_array=array();
		$where = array('account_gl_number' => $id,'company_id' => $company_id);
		$getAccountIds = $this->Master_Model->_select('main_schedule_account_setup_master', $where,'*',false );
		if ($getAccountIds->totalCount > 0) {
			foreach ($getAccountIds->data as $row) {
				array_push($account_array, $row->schedule_account);
			}
			$response['status'] = 200;
			$response['data'] = $account_array;
		}else {
			$response['status'] = 201;
			$response['data'] = "No Data Found";
		}
		echo json_encode($response);
	}
	public function getScheduleDataSet()
	{
		$company_id = $this->session->userdata('company_id');
		$master_id = $this->input->post('value');
		$type = $this->input->post('type');
		$table = "main_schedule_account_setup_master";
		if ($type == 2) {
			$table = "main_schedule_account_setup_master_us";
		}
		if ($type == 3) {
			$table = "main_schedule_account_setup_master_ifrs";
		}
		$company = $this->Master_Model->
		get_row_data('*', array("company_id" => $company_id, "schedule_account" => $master_id), $table);
		$data = $company->name;

		if ($data != "") {
			$response['status'] = 200;
			$response['data'] = $data;
		} else {
			$response['status'] = 201;
		}
		echo json_encode($response);
	}
}

?>
