<?php
require_once 'HexaController.php';

/**
 * @property  Master_Model Master_Model
 */
class BranchController extends HexaController
{
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 *        http://example.com/index.php/welcome
	 *    - or -
	 *        http://example.com/index.php/welcome/index
	 *    - or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{

		parent::__construct();


		$this->load->helper('url');

	}

	public function index()
	{
		$this->load->view('Admin/branch/view_branch',array("title"=>"Subsidiary Account","company_id"=>$this->session->userdata('company_id')));
	}
	public function SpecialSubsidiaryMapping()
	{
		$this->load->view('Admin/branch/SpecialSubsidiaryMapping',array("title"=>"Subsidiary Account","company_id"=>$this->session->userdata('company_id')));
	}
	public function companybranch()
	{
		$id = $this->session->userdata('company_id');
		$month = "";
		$year = "(No Consolidated Data)";
		$month_array = $this->Master_Model->getQuarter();
		$company = $this->Master_Model->_rawQuery('SELECT * ,(select count(*) from branch_master where company_id = ?) as total FROM company_master where id = ?',array($id,$id))->data;
		$consolidate  = $this->Master_Model->order_by_data(array('month','year'),array('company_id'=>$id),'consolidate_report_transaction','id','desc',null,1,false);
		if($consolidate != null)
		{
			$month = $consolidate->month;
			$year = $consolidate->year;
		}
		$data = array(
			'name' => $company[0]->name,
			'email' => $company[0]->email_id,
			'start' => $month_array[$company[0]->start_month],
			'total' => isset($company[0]->total) ? $company[0]->total : 0,
			'consolidate_month' => isset($month_array[$month]) ? $month_array[$month] : "" ,
			'consolidate_year' => isset($year) ? $year : "",
			'title'=>'Subsidiary Account',
			"company_id"=>$id
			);
		$this->load->view('CompanyBranch/view_companybranch',$data);
	}
	function CreateUpdateBranch(){
		$name=$this->input->post('branch_name');
		$country=$this->input->post('country');
		$currency=$this->input->post('currency');
		$default_currency_rate=$this->input->post('default_currency_rate');
		$percentage=$this->input->post('percentage');
		$company_id=$this->input->post('dcompany_id');
		$branch_user_id=$this->input->post('branch_user_id');
		$status=$this->input->post('status');
		$type=$this->input->post('type');
		$month=$this->input->post('month');
		$update_id=$this->input->post('update_id');
		$isSpecialSub=$this->input->post('isSpecialSub');
		$transferType=$this->input->post('transferType');
//		if($isSpecialSub==1)
//		{
//			$status=0;
//		}
		$data=array(
			'name'=>$name,
			'type'=>$type,
			'status'=>$status,
			'create_by'=>1,
			'company_id'=>$company_id,
			'country'=>$country,
			'currency'=>$currency,
			'start_with'=>$month,
			'default_currency_rate'=>$default_currency_rate,
			'branch_Userid'=>$branch_user_id,
			'percentage'=>$percentage,
			'is_special_branch'=>$isSpecialSub,
			'transfer_type'=>$transferType,
		);
		if(isset($update_id) && !empty($update_id)){
			$where=array("id"=>$update_id);
			$update=$this->Master_Model->_update('branch_master',$data,$where);
			if($update->status == true){
				$response['status']=200;
				$response['body']="Updated Successfully";
			}else{
				$response['status']=201;
				$response['body']="Something Went Wrong";
			}
		}else{
			$insert=$this->Master_Model->_insert('branch_master',$data);
			if($insert->status == true){
				$response['status']=200;
				$response['body']="Added Successfully";
			}else{
				$response['status']=201;
				$response['body']="Something Went Wrong";
			}
		}echo json_encode($response);
	}


	function getBranchData(){
		$user_type = $this->session->userdata('user_type');
		$company_id = $this->session->userdata('company_id');
		$type = $this->input->post('type');
		$country_array = $this->Master_Model->country();
		$month_array = $this->Master_Model->getQuarter();
		$country_name = $country_array[1];
		$branch_permission = $this->session->userdata('branch_permission');
		$array=array();
		if(!is_null($branch_permission)){
			$array=explode(",",$branch_permission);
		}
		if ($user_type != 1){
			$this->db->where('company_id',$company_id);
			$this->db->where_in('id',$array);
		}
		if($type != "" && $type != null && $type != -1)
		{
			$this->db->where('type',$type);
		}

		$mbData = $this->db
			->select(array("*"))
			->where('is_special_branch','0')
			->order_by('id','desc')
			->get("branch_master")->result();
	//	echo $this->db->last_query();
		$tableRows = array();
		if (count($mbData) > 0) {
			$i=1;
			foreach ($mbData as $order) {
				if($order->status == 1){
					$status='Active';
				}else{
					$status='InActive';
				}
				array_push($tableRows, array($i,
											$order->id,
											$order->name,
											$status,
											$country_name[$order->country],
											$order->currency,
											$order->default_currency_rate,
											$order->type,
											$order->branch_Userid,
											$order->percentage,
											$month_array[$order->start_with])
						);
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
	function getDataBranchByID(){
		$id = $this->input->post('id');
		$company_master = $this->Master_Model->get_row_data($select="*",$where=array('id'=>$id),$table="branch_master");
		if (($company_master) != NULL) {
			$response['data'] = $company_master;
			$response['status'] = 200;
		} else {
			$response['data'] = "";
			$response['status'] = 201;
		}
		echo json_encode($response);
	}
	function getSpecialSubsidiaries(){
		$company_id = $this->input->post('company_id');
		$query=$this->Master_Model->_rawQuery("select * from branch_master where status=1 AND is_special_branch=1 AND company_id=".$company_id);
		$intraSubs=array();
		$interSubs=array();
		if($query->totalCount > 0){
			foreach ($query->data as $row){
				if($row->transfer_type == 1){
					$intraSubs=array($row->name,$row->id);
				}
				if($row->transfer_type == 2){
					$interSubs=array($row->name,$row->id);
				}
			}
		}
		$response['intra']=$intraSubs;
		$response['inter']=$interSubs;
		echo json_encode($response);
	}
	function getParentGlAccounts(){
		$company_id = $this->input->post('company_id'); //
		$query=$this->Master_Model->_rawQuery('select main_gl_number,name,(select group_concat(intra_gl_account,",",inter_gl_account,",",intra_gl_account_pl,",",inter_gl_account_pl) from subsidiary_mapping m where m.company_id=b.company_id) as MappedGL from main_account_setup_master b where status=1 AND company_id='.$company_id);
		$option='<option selected="" disabled="" value="">Select Main Account</option>';
		$IntraGl="";
		$InterGl="";
		if($query->totalCount > 0){

			foreach ($query->data as $row){
				if($row->MappedGL != null){
					$exp=explode(",",$row->MappedGL);
					$IntraGlBS=$exp[0];
					$InterGlBS=$exp[1];
					$IntraGlPL=$exp[2];
					$InterGlPL=$exp[3];
				}
				$option .= '<option  value="'.$row->main_gl_number.'">'.$row->main_gl_number."-".$row->name.'</option>';
			}
		}
		$response['option']=$option;
		$response['IntraGl']=$IntraGlBS;
		$response['InterGl']=$InterGlBS;
		$response['IntraGlPL']=$IntraGlPL;
		$response['InterGlPL']=$InterGlPL;
		echo json_encode($response);
	}
	function SaveMapping(){
		$company_id = $this->input->post('company_id');
		$subsidiaryIntra = $this->input->post('subsidiaryIntra');
		$subsidiaryInter = $this->input->post('subsidiaryInter');
		$Intra_ParentBS = $this->input->post('Intra_ParentBS');
		$Inter_ParentBS = $this->input->post('Inter_ParentBS');
		$Intra_ParentPL = $this->input->post('Intra_ParentPL');
		$Inter_ParentPL = $this->input->post('Inter_ParentPL');
		$this->db->delete('subsidiary_mapping',array('company_id'=>$company_id));
		$data=array(
			"company_id"=>$company_id,
			"intra_branch_id"=>$subsidiaryIntra,
			"inter_branch_id"=>$subsidiaryInter,
			"intra_gl_account"=>$Intra_ParentBS,
			"inter_gl_account"=>$Inter_ParentBS,
			"intra_gl_account_pl"=>$Intra_ParentPL,
			"inter_gl_account_pl"=>$Inter_ParentPL,
		);
		$insert=$this->db->insert('subsidiary_mapping',$data);
		if($insert){
			$response['status']=200;
		}else{
			$response['status']=201;
		}echo json_encode($response);
	}

}
