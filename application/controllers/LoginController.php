<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property  Master_Model Master_Model
 */
class LoginController extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		//$this->load->model('Master_Model');
	}
	public function index(){
		$this->load->view('Admin/login');
	}
	public function go_login(){
		$username=$this->input->post('username');
		$password=$this->input->post('password');
		$login = $this->Master_Model->get_row_data($select="*,
		(select menu_permissions from permission_user_transaction p where p.user_id=u.id) as menu_permissions,
		(select branch_permission from permission_user_transaction p where p.user_id=u.id) as branch_permission",
			$where=array('user_name'=>$username,'password'=>$password),$table="users_master u");
		if($login != NULL){
			$response['status']= 200;
			$response['user_type']= $login->user_type;
			$data = array(
				'username' => $login->name,
				'company_id' => $login->company_id,
				'branch_id' => $login->branch_id,
				'user_id' => $login->id,
				'user_type' => $login->user_type,
				'menu_permissions' => $login->menu_permissions,
				'branch_permission' => $login->branch_permission,
				'user_access_type' => $login->user_access_type,
			);
			$this->session->set_userdata($data);
		}else{
			$response['status']= 201;
			$response['message'] = "Enter Correct Username or Password";
		}
		echo json_encode($response);
	}
}
