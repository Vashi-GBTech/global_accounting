<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('Admin/Template/template',array('title'=>'Template'));
	}
	public function getTablesList(){

		$tables = $this->Master_Model->get_select_all_data('id,Template_table_name,template_name,year,month','template_master');
		$key = "";

		$tableRows = array();
		if (count($tables) > 0) {
			$i = 1;
			foreach ($tables as $row) {
				array_push($tableRows, array($i, $row->template_name,$row->id,$row->year,$row->month));
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

	public function addTemplate(){
//		`template_master` ADD `created_by` INT(10) NOT NULL AFTER `Template_table_name`, ADD `created_date` VARCHAR(100) NOT NULL AFTER `created_by`, ADD `updated_by` INT(10) NOT NULL AFTER `created_date`, ADD `updated_date` VARCHAR(100) NOT NULL AFTER `updated_by`, ADD `status` INT(10) NOT NULL AFTER `updated_date`;
		$table_last_id = $this->db->select('id')->order_by('id','DESC')->limit(1)->get('template_master')->row();
		$table_name = 'table_template_'.intval($table_last_id->id+1);
		$template_data['template_name'] = $this->input->post('template_name');
		$template_data['Template_table_name'] = $table_name;
//		'table_'.str_replace(' ', '_', $this->input->post('template_name'));
		$template_data['created_by'] = 1;
		$template_data['created_date'] = date('Y-m-d H:i:s');
		$template_data['status'] = 1;
		$add_template = $this->db->insert('template_master', $template_data);
		$last_template_id = $this->db->insert_id();

		$attribute_name = $this->input->post('attribute_name');
		$attribute_type = $this->input->post('attribute_type');
		$attribute_query = $this->input->post('attribute_query');
		$sequence = $this->input->post('sequence');
		$template_name_length = count($this->input->post('attribute_name'));

		$table_string = 'id INT(10) NOT NULL PRIMARY KEY, ';
		if ($add_template){
			for ($i = 0;$i < $template_name_length ; $i++){
				$column_name = $table_name.'_col_'.intval($i+1);

				$template_details['template_id'] = $last_template_id;
				$template_details['attribute_name'] = $attribute_name[$i];
				$template_details['attribute_type'] = $attribute_type[$i];
				$template_details['attribute_query'] = $attribute_query[$i];
				$template_details['column_name'] = $column_name;
				$template_details['sequence'] = $sequence[$i];
				$template_details['table_name'] = $table_name;//'table_'.$this->input->post('template_name');
				$this->db->insert('template_column_mapping', $template_details);
				$table_string .= $column_name.' text,';
			}
			$this->db->query('CREATE TABLE '.$table_name.'('.rtrim($table_string,',').',branch_id text,company_id text, year text,quarter text,user_id text, created_by text, created_date text, sheet_master_id int(10))');
//			echo json_encode(array('message'=>"Successfully inserted.","last_q"=>$this->db->last_query()));
			$status = 200;
			$message = "Added Successfuly";
		}else{
//			echo json_encode(array('error'=>"something went wrong."));

			$status = 201;
			$message = "Something went wrong";
		}
		$tables = $this->Master_Model->get_select_all_data('id,Template_table_name','template_master');
		$key = "";

		$tableRows = array();
		if (count($tables) > 0) {
			$i = 1;
			foreach ($tables as $row) {
				array_push($tableRows, array($i, $row->Template_table_name,$row->id));
				$i++;
			}
		}

		$results = array(
			"status" => $status,
			"body" => $message,
			"data" => $tableRows
		);
		echo json_encode($results);
	}

	public function editTemplate(){
		$template = $this->Master_Model->get_row_data("*",array('id'=>$this->input->post('id')),'template_master');
		$template_columns = $this->Master_Model->get_all_data(array('template_id'=>$this->input->post('id')),'template_column_mapping');
		if (!empty($template)){
			$tableRows = array();
			if (!empty($template_columns)) {
//				$i = 1;
				foreach ($template_columns as $row) {
					array_push($tableRows, $row);
//					$i++;
				}
			}

			$status = 200;
			$message = 'Record Found';
//			$tableRows =
		}
		$results = array(
			"status" => $status,
			"body" => $message,
			"template_master"=>array('id'=>$template->id,'template_name'=>$template->template_name,'Template_table_name'=>$template->Template_table_name),
			"data" => $tableRows
		);
		echo json_encode($results);
	}

	public function updateTemplate(){
		$template_mapping_rows = $this->Master_Model->get_all_data(array('template_id'=>$this->input->post('hdn_template_id')),'template_column_mapping');
//		var_dump($template_mapping_rows);
//		var_dump($this->input->post());
//		exit();

		$template_data['template_name'] = $this->input->post('template_name');
		$template_data['updated_by'] = 1;
		$template_data['updated_date'] = date('Y-m-d H:i:s');
		$add_template = $this->db->where(array('id'=>$this->input->post('temp_id')))->update('template_master', $template_data);

		$last_template_id = $this->input->post('hdn_template_id');
		$table_name = $this->input->post('hdn_table_name');

		$update_id = $this->input->post('hdn_update_id');
		$attribute_name = $this->input->post('attribute_name');
		$attribute_type = $this->input->post('attribute_type');
		$attribute_query = $this->input->post('attribute_query');
		$sequence = $this->input->post('sequence');
		$template_name_length = count($this->input->post('attribute_name'));

//		$table_string = 'id INT(10) NOT NULL PRIMARY KEY AUTO INCREMENT, ';
		if ($add_template){
			for ($i = 0;$i < $template_name_length ; $i++){
//				$table_name = $template_mapping_rows[$i]->table_name;
				if($update_id[$i] != 0){
					$update_row = 0;
					if ($template_mapping_rows[$i]->attribute_name != $attribute_name[$i]){
						$template_details['attribute_name'] = $attribute_name[$i];
						$update_row = 1;
					}
					if ($template_mapping_rows[$i]->attribute_type != $attribute_type[$i]){
						$template_details['attribute_type'] = $attribute_type[$i];
						$update_row = 1;
					}
					if($template_mapping_rows[$i]->attribute_query != $attribute_query[$i]){
						$template_details['attribute_query'] = $attribute_query[$i];
						$update_row = 1;
					}
					if($template_mapping_rows[$i]->sequence != $sequence[$i]){
						$template_details['sequence'] = $sequence[$i];
						$update_row = 1;
					}
					if ($update_row == 1){
						$update_template_mapping = $this->db->where(array('id'=>$update_id[$i]))->update('template_column_mapping', $template_details);
					}

				}else{
					$column_name = $table_name.'_col_'.intval($i+1);
					$template_details['template_id'] = $last_template_id;
					$template_details['attribute_name'] = $attribute_name[$i];
					$template_details['attribute_type'] = $attribute_type[$i];
					$template_details['attribute_query'] = $attribute_query[$i];
					$template_details['column_name'] = $column_name;
					$template_details['sequence'] = $sequence[$i];
					$template_details['table_name'] = $table_name;
					$this->db->insert('template_column_mapping', $template_details);
//					$table_string = $column_name.' text';
					$this->db->query('ALTER TABLE '.$table_name.' ADD '.$column_name.' text');
				}

			}
//			echo json_encode(array('message'=>"Successfully inserted.","last_q"=>$this->db->last_query()));
			$status = 200;
			$message = "Added Successfuly";
		}else{
//			echo json_encode(array('error'=>"something went wrong."));

			$status = 201;
			$message = "Something went wrong";
		}
		$tables = $this->Master_Model->get_select_all_data('id,Template_table_name','template_master');
		$key = "";

		$tableRows = array();
		if (count($tables) > 0) {
			$i = 1;
			foreach ($tables as $row) {
				array_push($tableRows, array($i, $row->Template_table_name,$row->id));
				$i++;
			}
		}

		$results = array(
			"status" => $status,
			"body" => $message,
			"data" => $tableRows
		);
		echo json_encode($results);
	}

	public function assignTemplate(){
		$this->load->view('Admin/Template/assigntemplate',array('title'=>'Assign Template'));
	}
	public function getCompanyData(){
		$company = $this->Master_Model->get_select_all_data('id,name','company_master');
		$key = "";

		$companyRows = array();
		if (!empty($company)) {
			$i = 1;
			foreach ($company as $row) {
				array_push($companyRows, array("id"=>$row->id,"name"=>$row->name));
				$i++;
			}
		}
		$results = array(
			"draw" => 1,
			"recordsTotal" => count($companyRows),
			"recordsFiltered" => count($companyRows),
			"data" => $companyRows
			,"last_query"=>$this->db->last_query()
		);
		echo json_encode($results);
	}

	public function getBranchData(){
		$user_type=$this->session->userdata('user_type');
		if($user_type==1)
		{
			$where=array('status'=>1);
		}
		else{
			$where=array('company_id'=>$this->input->post('company_id'),'status'=>1);
		}
		$branch = $this->Master_Model->get_all_data($where, 'branch_master');
		$key = "";
		$array=array();
		$branch_permission = $this->session->userdata('branch_permission');
		if(!is_null($branch_permission)){
			$array=explode(",",$branch_permission);
		}
		$branchRows = array();
		if (!empty($branch)) {
			$i = 1;
			foreach ($branch as $row) {
				if(in_array($row->id,$array)) {
					array_push($branchRows, array("id" => $row->id, "name" => $row->name));
					$i++;
				}
			}

			$status = 200;
		}else{
			$status = 201;
		}
		$results = array(
			"status"=>$status,
			"draw" => 1,
			"recordsTotal" => count($branchRows),
			"recordsFiltered" => count($branchRows),
			"data" => $branchRows
		);
		echo json_encode($results);
	}

	public function getTemplateData(){
		$template_master = $this->Master_Model->get_select_all_data('id,template_name','template_master');
		$key = "";

		$templateRows = array();
		if (!empty($template_master)) {
			$i = 1;
			foreach ($template_master as $row) {
				array_push($templateRows, array("id"=>$row->id,"name"=>$row->template_name));
				$i++;
			}
		}
		$results = array(
			"draw" => 1,
			"recordsTotal" => count($templateRows),
			"recordsFiltered" => count($templateRows),
			"data" => $templateRows
		,"last_query"=>$this->db->last_query()
		);
		echo json_encode($results);
	}

	public function assignTemplateToBranch(){
		$branch_id = $this->input->post("branch_id");
		$assignBranch['branch_id'] =  $branch_id;
		$assignBranch['company_id'] = $this->input->post("company_name");
		$assignBranch['template_id'] =  $this->input->post("template_id");
		$assignBranch['status'] =  1;
		$assignBranch['created_by'] = $this->session->userdata('user_id');
		$assignBranch['created_date'] = date('Y-m-d');
		$req = $this->Master_Model->_insert('template_branch_mapping', $assignBranch);
		if($req){
			$results = array(
				"status" => 200,
				"body" => 'Template successfuly assign to branch.'
			);
		}else{
			$results = array(
				"status" => 201,
				"body" => 'Something went wrong.'
			);
		}
		echo json_encode($results);
//		var_dump($this->input->post());
//		exit();
//		$template_details['template_id'] = $last_template_id;
//		$template_details['attribute_name'] = $attribute_name[$i];
//		$template_details['attribute_type'] = $attribute_type[$i];
//		$template_details['attribute_query'] = $attribute_query[$i];
	}
	public function getTemplateBranchAssignList(){
		$branch = '';
		$company = '';
		$template = '';
		$mbData = $this->db
			->select(array("*"))
			->order_by('id', 'desc')
			->get("template_branch_mapping")->result();
		$tableRows = array();
		if (count($mbData) > 0) {
			$i = 1;
			foreach ($mbData as $order) {
				$branch_where = 'id IN('.$order->branch_id.')';
				$branch_name = $this->db->where($branch_where)->get('branch_master')->result();
//				get_row_data("name", array('id' => $order->branch_id), 'branch_master');
				if (!empty($branch_name)) {
					$branches = '';
					foreach ($branch_name as $branch_row){
						$branches .= $branch_row->name.',';
					}
					$branch = rtrim($branches);
				}
				$company_name = $this->Master_Model->get_row_data("name", array('id' => $order->company_id), 'company_master');
				if (!empty($company_name)) {
					$company = $company_name->name;
				}
				$template_name = $this->Master_Model->get_row_data("template_name", array('id' => $order->template_id), 'template_master');
				if (!empty($template_name)) {
					$template = $template_name->template_name;
				}
//				echo $this->db->last_query();
				$country_master = $this->Master_Model->getQuarter();

				array_push($tableRows, array($i, $order->id, $template, $branch, $company));

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

}



