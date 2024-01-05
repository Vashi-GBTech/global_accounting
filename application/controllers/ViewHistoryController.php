<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property  Master_Model Master_Model
 */
class ViewHistoryController extends CI_Controller
{
	public function index()
	{
		$this->load->view("Admin/view_history/view_history",array("title"=>"View History"));
	}


	function getViewHistory()
	{
		$month = $this->Master_Model->getQuarter();
		$user_type = $this->session->userdata('user_type');
		$company_id = $this->session->userdata('company_id');
		$branch = '';
		$company = '';
		$template = '';
		$mbData = $this->db
			->select(array("*"))
			->where('company_id',$company_id)
			->order_by('id','desc')
			->get("excelsheet_master_data")->result();
		$tableRows = array();
		if (count($mbData) > 0) {
			$i=1;
			foreach ($mbData as $order) {
				if ($order->approve_status == 1) {
					$status = '<span class="badge badge-success">Approved</span>';
				} else {
					$status = '<span class="badge badge-danger">Not Approve</span>';
				}
				$country_master = $this->Master_Model->country();
				$country=$country_master[1];
				$branch_name = $this->Master_Model->get_row_data("name",array('id'=>$order->branch_id),'branch_master');
				if (!empty($branch_name)){
					$branch = $branch_name->name;
				}
				$company_name = $this->Master_Model->get_row_data("name",array('id'=>$order->company_id),'company_master');
				if (!empty($company_name)){
					$company = $company_name->name;
				}
				$template_name = $this->Master_Model->get_row_data("template_name",array('id'=>$order->template_id),'template_master');
				if (!empty($template_name)){
					$template = $template_name->template_name;
				}
				array_push($tableRows, array($i,$order->id,$template,$branch,$company,$order->name,$order->year,$month[$order->quarter], $status,$user_type));
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
?>
