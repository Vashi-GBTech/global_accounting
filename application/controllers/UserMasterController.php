<?php
require_once 'HexaController.php';

/**
 * @property  Master_Model Master_Model
 */
class UserMasterController extends HexaController
{
	public function  index(){
		$this->load->view('Admin/users/view_user',array('title'=>'Users'));
	}

	public function getUserData()
	{
		$mbData = $this->db
			->select(array("*"))
			->where('user_type',2)
			->order_by('id','desc')
			->get("users_master")->result();
		$tableRows = array();
		if (count($mbData) > 0) {
			$i=1;
			foreach ($mbData as $order) {
				if($order->status == 1){
					$status='Active';
				}else{
					$status='InActive';
				}
				array_push($tableRows, array($i,$order->id,$order->name,
					$status,$order->user_name,$order->user_type,$order->branch_id,));
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
	function getDataUserByID(){
		$id = $this->input->post('id');
		$company_master = $this->Master_Model->get_row_data($select="*",$where=array('id'=>$id),$table="users_master");
		if (($company_master) != NULL) {
			$response['data'] = $company_master;
			$response['status'] = 200;
		} else {
			$response['data'] = "";
			$response['status'] = 201;
		}
		echo json_encode($response);
	}

	function CreateUpdateUsers(){
		$name=$this->input->post('user_name');
		$company_id=$this->input->post('company_id');
		$mail_id=$this->input->post('mail_id');
		$update_id=$this->input->post('update_id');
		$userType=$this->input->post('userType');

		$data=array(
			'name'=>$name,
			'user_name'=>$mail_id,
			'password'=>123,
			'company_id'=>$company_id,
			'user_type'=>2,
			'status' => 1,
			'user_access_type'=>$userType
		);
		if(isset($update_id) && !empty($update_id)){
			$where=array("id"=>$update_id);
			$update=$this->Master_Model->_update('users_master',$data,$where);
			if($update->status == true){
				$response['status']=200;
				$response['body']="Updated Successfully";
			}else{
				$response['status']=201;
				$response['body']="Something Went Wrong";
			}
		}else{
			$insert=$this->Master_Model->_insert('users_master',$data);
			if($insert->status == true){
				$response['status']=200;
				$response['body']="Added Successfully";
			}else{
				$response['status']=201;
				$response['body']="Something Went Wrong";
			}
		}echo json_encode($response);
	}


	public function getBranchList()
	{
		$branch_list = $this->Master_Model->get_all_table_data('branch_master');
		$data=array();
		$option="<option selected disabled>Select Option</option>";
		if(count($branch_list) > 0){
			foreach ($branch_list as $row){
				$option .="<option value='".$row->id."'>".$row->name."</option>";
			}
			$response['data']=$option;
			$response['status']=200;

		}else{
			$response['data']=$option;
			$response['status']=201;
		}echo json_encode($response);
	}
	public function getBranchListCompanyWise($company_id,$branchdata)
	{
		$branch_list = $this->Master_Model->get_all_data(array('company_id'=>$company_id,"status"=>1),'branch_master');

		$data=array();
		$option="";
		if(count($branch_list) > 0){
			foreach ($branch_list as $row){
				$selected="";
				if($branchdata != ""){
					if(in_array($row->id,$branchdata)){
						$selected='selected';
					}
				}
				/*if($row->is_special_branch!=1)
				{*/
					$option .="<option ".$selected." value='".$row->id."'>".$row->name."</option>";
//				}
			}
		}
		return $option;
	}

	public function getAllPermissions(){
		$user_id=$this->input->post('id');
		$company_id = "";
		$company = $this->Master_Model->get_row_data($select="company_id,
		(select menu_permissions from permission_user_transaction p where p.user_id=u.id) as menu_permissions,
		(select branch_permission from permission_user_transaction p where p.user_id=u.id) as branch_permission
		",$where=array('id'=>$user_id),$table="users_master u");
		if($company != null){
			$company_id = $company->company_id;
			$checkeddata = $company->menu_permissions;
			if($checkeddata != null){
				$checkeddata=explode(",",$checkeddata);
			}else{
				$checkeddata=false;
			}
			$branchdata=$company->branch_permission;
			if($branchdata != null){
				$branchdata=explode(",",$branchdata);
			}else{
				$branchdata="";
			}
		}

		$response['branch_options']=$this->getBranchListCompanyWise($company_id,$branchdata);
		$branch_list = $this->Master_Model->get_all_table_data('permission_master');
		$data=array();
		$option="<label class='bold'>Select Permissions</label><br>";
		$option .="<input type='checkbox' id='allCheck' name='allCheck' onclick='checkall()'> All</br>";
		if(count($branch_list) > 0){
			foreach ($branch_list as $row){
				$cheked="";
				if($checkeddata!=false && count($checkeddata) > 0 ){
					if(in_array($row->id,$checkeddata)){
						$cheked="checked";
					}else{
						$cheked="";
					}
				}
				if($row->status == 0){
					$option .="<input type='checkbox' onclick='return false' class='' checked name='checkboxData[]' value='".$row->id."'>  ".$row->permission_name."</br>";
				}else{
					$option .="<input type='checkbox' class='permissionscheck' name='checkboxData[]' ".$cheked." value='".$row->id."'>  ".$row->permission_name."</br>";
				}

			}
			$response['data']=$option;
			$response['status']=200;

		}else{
			$response['data']=$option;
			$response['status']=201;
		}echo json_encode($response);
	}

	function saveUsersPermission(){
		$checkboxData=$this->input->post('checkboxData');
		$userIdPermission=$this->input->post('userIdPermission');
		$branch_id=$this->input->post('branch_id');
		if(count($checkboxData)>0 || count($branch_id) > 0){
			$permission=implode(",",$checkboxData);
			$branch_ids="";
			if(count($branch_id) > 0){
				$branch_ids=implode(",",$branch_id);
			}
			$data=array(
				"menu_permissions"=>$permission,
				"user_id"=>$userIdPermission,
				"branch_permission"=>$branch_ids,
			);
			$where=array('user_id'=>$userIdPermission);
			try {
				$this->db->trans_start();
				if (!empty($data)) {
					$delete = $this->db->delete('permission_user_transaction', $where);
					$insert_batch = $this->db->insert("permission_user_transaction", $data);
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
			if($status == true){
				$response['body']="Added Successfully!";
				$response['status']=200;
			}else{
				$response['body']="Something Went Wrong!";
				$response['status']=201;
			}
		}else{
			$response['body']="Select atleast 1 permission.";
			$response['status']=201;
		}echo json_encode($response);
	}
	function getAllPermissionsCompany(){
		$branch_list = $this->Master_Model->get_all_table_data('permission_master');
		$user_type = $this->session->userdata('user_type');
		$menu_permissions = $this->session->userdata('menu_permissions');
		$array=array();
		if(!is_null($menu_permissions)){
			$array=explode(",",$menu_permissions);
		}
		$html='';
		if(count($branch_list) > 0){
			foreach ($branch_list as $nav){
				if(in_array($nav->id,$array)){
					$html .='<li class="menu_list"><a class="menu_list" href="'.base_url().$nav->route.'"><i class="'.$nav->class.'" style="'.$nav->style.'"></i> <span>'.$nav->permission_name.'</span></a>
					</li>';
				}

			}
		}
		if($user_type == 2){
			$response['html']=$html;
		}else{
			$response['html']="";
		}
		echo json_encode($response);
	}

}
