<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property  Master_Model Master_Model
 */
class CompanyController extends CI_Controller
{
	public function view_companies()
	{
		$this->load->view("Admin/company/view_company",array("title"=>"Companies"));
	}

	function CreateUpdateCompany(){
		$name=$this->input->post('company_name');
		$type=$this->input->post('type');
		$mail_id=$this->input->post('mail_id');
		$update_id=$this->input->post('update_id');
		$start_month = $this->input->post('month');
		$country = $this->input->post('country');
		$currency = $this->input->post('currency');
		$user_id = $this->session->userdata('user_id');
		$data=array(
			'name'=>$name,
			'type'=>$type,
			'email_id'=>$mail_id,
			'start_month' => $start_month,
			'country' => $country,
			'currency' => $currency
		);
		$branchData=array('name'=>'Special Subsidiary',
						'status'=>1,
						'create_on'=>date('Y-m-d H:i:s'),
						'create_by'=>$user_id,
						'country'=>$country,
						'currency'=>$currency,
						'type'=>'subsidiary',
						'branch_Userid'=>'',
						'percentage'=>100,
						'default_currency_rate'=>1,
						'start_with'=>$start_month,
						'is_special_branch'=>1);
		$resultStatus=false;
		try {
				if(isset($update_id) && !empty($update_id)){
					$branchData['company_id']=$update_id;
					$where=array("id"=>$update_id);
					$update=$this->Master_Model->_update('company_master',$data,$where);
					if($update->status == true){
						$this->createUpdateBranch($branchData);
						$resultStatus = TRUE;
					}else{
						$resultStatus = FALSE;
					}
				}else{
					$insert=$this->Master_Model->_insert('company_master',$data);
					if($insert->status == true){
						$inserted_id=$insert->inserted_id;
						$branchData['company_id']=$inserted_id;
						$loginData=array(
							'name'=>$name,
							'user_name'=>$mail_id,
							'password'=>123,
							'company_id'=>$inserted_id,
							'user_type'=>2,);
						$this->Master_Model->_insert('users_master',$loginData);
						$this->createUpdateBranch($branchData);
						$resultStatus = TRUE;
					}else{
						$resultStatus = FALSE;
					}
				}
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$resultStatus = FALSE;
			} else {
				$this->db->trans_commit();
				$resultStatus = TRUE;
			}
			$this->db->trans_complete();

		} catch (Exception $ex) {
			$resultStatus = FALSE;
			$this->db->trans_rollback();
		}
		if($resultStatus==true)
		{
			$response['status']=200;
			$response['body']='Changes Saved Successfully';
		}
		else{
			$response['status']=201;
			$response['body']='Something Went wrong';
		}
		echo json_encode($response);
	}
	function createUpdateBranch($branchData)
	{
		//to create special branch
		$result=$this->Master_Model->_select('branch_master',array('company_id'=>$branchData['company_id'],'is_special_branch'=>1),'id');
		if($result->totalCount>0)
		{
			$branchlist_id=$result->data->id;
			$this->Master_Model->_update('branch_master',$branchData,array('company_id'=>$branchData['company_id'],'is_special_branch'=>1,'id'=>$branchlist_id));
		}
		else{
			$this->Master_Model->_insert('branch_master',$branchData);

		}

		// to create special group
		$mainGroupData=array('type1'=>'SPECIAL TYPE1',
							'type2'=>'Special type 2',
							'type3'=>'Special type 3',
							'calculation_method'=>'Addition',
							'monitory_status'=>'Yes',
							'type0'=>'BS',
							'created_on'=>date('Y-m-d H:i:s'),
							'created_by'=>$this->session->userdata('user_id'),
							'company_id'=>$branchData['company_id'],
							'status'=>1,
							'is_divide'=>1,
							'sequence_no'=>'SP1001');
		$mainGroupWhere=array('company_id'=>$branchData['company_id'],'sequence_no'=>'SP1001');
		//insert Group for IND
		$group_id="";
		$resultSpecialGroup=$this->Master_Model->_select('master_account_group_ind',$mainGroupWhere,'id');
		if($resultSpecialGroup->totalCount>0)
		{
			$group_id=$resultSpecialGroup->data->id;
			$mainGroupWhere['id']=$group_id;
			$this->Master_Model->_update('master_account_group_ind',$mainGroupData,$mainGroupWhere);
		}
		else{
			$groupInsert=$this->Master_Model->_insert('master_account_group_ind',$mainGroupData);
			if($groupInsert->status)
			{
				$group_id=$groupInsert->inserted_id;
			}
		}
		//insert main account setup
		if(!empty($group_id))
		{
			$mainAccountSetup=array('company_id'=>$branchData['company_id'],
									'main_gl_number'=>'SP1001',
									'name'=>'Special Account',
									'created_by'=>$this->session->userdata('user_id'),
									'created_on'=>date('Y-m-d H:i:s'),
									'calculation_method'=>'Addition',
									'type1'=>'SPECIAL TYPE1',
									'sequence_number'=>'SP1001',
									'type2'=>'Special type 2',
									'type3'=>'Special type 3',
									'type0'=>'BS',
									'monitory'=>'Yes',
									'group_id'=>$group_id,
									'is_divide'=>0,
									'status'=>1);
			$mainAccountSetupWhere=array('company_id'=>$branchData['company_id'],'main_gl_number'=>'SP1001','group_id'=>$group_id);
			// insert main acciunt setup for IND
			$resultMainAccountSetup=$this->Master_Model->_select('main_account_setup_master',$mainAccountSetupWhere,'id');
			if($resultMainAccountSetup->totalCount>0)
			{
				$this->Master_Model->_update('main_account_setup_master',$mainAccountSetup,$mainAccountSetupWhere);
			}
			else{
				$this->Master_Model->_insert('main_account_setup_master',$mainAccountSetup);
			}
		}
	}
	function MainAccountSetup(){
		$gl_numebr=$this->input->post('gl_number');
		$name=$this->input->post('name');
		$company_id = $this->session->userdata('company_id');
		$update_id=$this->input->post('update_id');
		$data=array(
			'main_gl_number'=>$gl_numebr,
			'name'=>$name,
			'created_by'=>1,
			'company_id'=>$company_id,
		);
		if(isset($update_id) && !empty($update_id)){
			$where=array("id"=>$update_id);
			$update=$this->Master_Model->_update('main_account_setup_master',$data,$where);
			if($update->status == true){
				$response['status']=200;
				$response['body']="Updated Successfully";
			}else{
				$response['status']=201;
				$response['body']="Something Went Wrong";
			}
		}else{
			$insert=$this->Master_Model->_insert('main_account_setup_master',$data);

			if($insert->status == true){
				$response['status']=200;
				$response['body']="Added Successfully";
			}else{
				$response['status']=201;
				$response['body']="Something Went Wrong";
			}
		}echo json_encode($response);
	}

	function getCompanyData(){
		$mbData = $this->db
			->select(array("*"))
			->order_by('id','desc')
			->get("company_master")->result();
		$tableRows = array();
		if (count($mbData) > 0) {
			$i=1;
			foreach ($mbData as $order) {
				if($order->status == 1){
					$status='Active';
				}else{
					$status='InActive';
				}
				array_push($tableRows, array($i,$order->id,$order->name, $status));
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
	function getDataCompanyByID(){
		$id = $this->input->post('id');
		$company_master = $this->Master_Model->get_row_data($select="*",$where=array('id'=>$id),$table="company_master");
		if (($company_master) != NULL) {
			$response['data'] = $company_master;
			$response['status'] = 200;
		} else {
			$response['comorbidity'] = "";
			$response['status'] = 201;
		}
		echo json_encode($response);
	}
	function getLisCompany(){
		$company = $this->Master_Model->order_by_data($select="*",$where=array("status"=>'1'),$table="company_master",$order_by="id",$key="desc");
		$data=array();
		$option="<option selected disabled>Select Option</option>";
		if(count($company) > 0){
			foreach ($company as $row){
				$option .="<option value='".$row->id."'>".$row->name."</option>";
			}
			$response['data']=$option;
			$response['status']=200;

		}else{
			$response['data']=$option;
			$response['status']=201;
		}echo json_encode($response);
	}

	public function block_year()
	{
		$this->load->view("BlockYear/block_year",array("title"=>"Companies"));
	}
}
