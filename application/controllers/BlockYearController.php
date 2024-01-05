<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property  Master_Model Master_Model
 */
class BlockYearController extends CI_Controller
{
	
	public function block_year()
	{
		$this->load->view("BlockYear/block_year",array("title"=>"Companies"));
	}
	public function blockFormRowUpload()
	{

		if(!is_null($this->input->post('year')) && !is_null($this->input->post('month')))
		{
			$year=$this->input->post('year');
			$month=$this->input->post('month');
			$company_id = $this->session->userdata('company_id');
			$user_id = $this->session->userdata('user_id');
			$checkBlockExists = $this->Master_Model->get_all_data(array('year'=>$year,'month'=>$month,'company_id'=>$company_id),'block_year_data' );
			$data=array(
					'company_id'=>$company_id,
					'month'=>$month,
					'year'=>$year,
					'created_by'=>$user_id,
					'created_on'=>date('Y-m-d H:i:s'),
					'status'=>1
				);
			if(empty($checkBlockExists)){
				$insert=$this->Master_Model->_insert('block_year_data',$data);
				if($insert->status == true){
					$response['status']=200;
					$response['body']="Added Successfully";
				}else{
					$response['status']=201;
					$response['body']="Something Went Wrong";
				}
			}else{
				if(!is_null($checkBlockExists[0]->id))
				{
					$this->db->update('block_year_data',array('status'=>1),array('id'=>$checkBlockExists[0]->id));
				}
				$response['status']=201;
				$response['body']="Block for this year and month is already Exists";
			}
		}
		else
		{
			$response['status']=201;
			$response['body']="Something Went Wrong";
		}
		echo json_encode($response);
	}
	public function getBlockYearList()
	{
		$mbData = $this->db
			->select(array("*"))
			->where('company_id',$this->session->userdata('company_id'))
			->order_by('id', 'desc')
			->group_by(array('year', 'month'))
			->get("block_year_data")->result();
		$tableRows = array();
		if (count($mbData) > 0) {
			$i = 1;
			foreach ($mbData as $order) {
				$country_master = $this->Master_Model->getQuarter();
				array_push($tableRows, array($i, $order->year, $country_master[$order->month], $order->id, $order->month,$order->status));
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
	public function activeInactiveStatus()
	{
		if(!is_null($this->input->post('id')) && !is_null($this->input->post('status')))
		{
			$id=$this->input->post('id');
			$status=$this->input->post('status');

			if($status==1)
			{
				$status=0;
			}
			else
			{
				$status=1;
			}
			
			$company_id = $this->session->userdata('company_id');
			$user_id = $this->session->userdata('user_id');
			$where=array('company_id'=>$company_id,'id'=>$id);
			$data=array(
					'modify_by'=>$user_id,
					'modify_on'=>date('Y-m-d H:i:s'),
					'status'=>$status
				);
			// print_r($where);exit();
			$update=$this->Master_Model->_update('block_year_data',$data,$where);
			if($update->status == true){
				$response['status']=200;
				$response['body']="Updated Successfully";
			}else{
				$response['status']=201;
				$response['body']="Something Went Wrong";
			}
		}
		else
		{
			$response['status']=201;
			$response['body']="Something Went Wrong";
		}
		echo json_encode($response);
	}
	public function getNoBlockMonth()
	{
		if(!is_null($this->input->post('year')))
		{
			$year=$this->input->post('year');
			$company_id = $this->session->userdata('company_id');
			$where=array('year'=>$year,'company_id'=>$company_id,"status"=>1);
			$resultObject=$this->Master_Model->_select('block_year_data',$where,"*",false);
			$blockArray=array();
			if($resultObject->totalCount>0)
			{
				foreach ($resultObject->data as $value) {
					array_push($blockArray, $value->month);
				}
			}
			$monthArray=$this->Master_Model->getQuarter();
			$options='<option disabled selected>select month</option>';
			foreach ($monthArray as $key => $value) {
				if(!in_array($key, $blockArray))
				{
					$options.='<option value="'.$key.'">'.$value.'</option>';
				}
			}
			$response['status']=200;
			$response['body']=$options;
		}
		else
		{
			$response['status']=201;
			$response['body']="Something Went Wrong";
		}
		echo json_encode($response);
	}
	public function defaultFormRowUpload()
	{

		if(!is_null($this->input->post('defaultyear')) && !is_null($this->input->post('defaultmonth')))
		{
			$year=$this->input->post('defaultyear');
			$month=$this->input->post('defaultmonth');
			$company_id = $this->session->userdata('company_id');
			$user_id = $this->session->userdata('user_id');
			$checkBlockExists = $this->Master_Model->get_all_data(array('company_id'=>$company_id),'default_year_data' );
			$data=array(
				'company_id'=>$company_id,
				'month'=>$month,
				'year'=>$year,
				'created_by'=>$user_id,
				'created_on'=>date('Y-m-d H:i:s'),
				'status'=>1
			);
			if(empty($checkBlockExists)){
				$insert=$this->Master_Model->_insert('default_year_data',$data);
				if($insert->status == true){
					$response['status']=200;
					$response['body']="Added Successfully";
				}else{
					$response['status']=201;
					$response['body']="Something Went Wrong";
				}
			}else{
				if(!is_null($checkBlockExists[0]->id))
				{
					$this->db->update('default_year_data',array('status'=>1,'month'=>$month,
						'year'=>$year),array('id'=>$checkBlockExists[0]->id));
				}
				$response['status']=200;
				$response['body']="Added Successfully";
			}
		}
		else
		{
			$response['status']=201;
			$response['body']="Something Went Wrong";
		}
		echo json_encode($response);
	}
	public function getDefaultYearList()
	{
		$mbData = $this->db
			->select(array("*"))
			->where('company_id',$this->session->userdata('company_id'))
			->order_by('id', 'desc')
			->group_by(array('year', 'month'))
			->get("default_year_data")->result();
		$tableRows = array();
		if (count($mbData) > 0) {
			$i = 1;
			foreach ($mbData as $order) {
				$country_master = $this->Master_Model->getQuarter();
				array_push($tableRows, array($i, $order->year, $country_master[$order->month], $order->id, $order->month,$order->status));
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
	public function activeInactiveStatusDefaultYear()
	{
		if(!is_null($this->input->post('id')) && !is_null($this->input->post('status')))
		{
			$id=$this->input->post('id');
			$status=$this->input->post('status');
			if($status==1)
			{
				$status=0;
			}
			else
			{
				$status=1;
			}
			$company_id = $this->session->userdata('company_id');
			$user_id = $this->session->userdata('user_id');
			$where=array('company_id'=>$company_id,'id'=>$id);
			$data=array(
				'modify_by'=>$user_id,
				'modify_on'=>date('Y-m-d H:i:s'),
				'status'=>$status
			);
			$update=$this->Master_Model->_update('default_year_data',$data,$where);
			if($update->status == true){
				$response['status']=200;
				$response['body']="Updated Successfully";
			}else{
				$response['status']=201;
				$response['body']="Something Went Wrong";
			}
		}
		else
		{
			$response['status']=201;
			$response['body']="Something Went Wrong";
		}
		echo json_encode($response);
	}
	public function getDefaultYearMonthDetails()
	{
		$company_id=$this->session->userdata('company_id');
		$resultObject=$this->Master_Model->_select('default_year_data',array('company_id'=>$company_id,'status'=>1),"*",true);
		if($resultObject->totalCount>0)
		{
			$response['year']=$resultObject->data->year;
			$response['month']=$resultObject->data->month;
		}
		else{
			$response['year']="";
			$response['month']="";
		}
		echo json_encode($response);
	}
}
