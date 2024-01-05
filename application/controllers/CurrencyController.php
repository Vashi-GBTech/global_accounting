<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property  Master_Model Master_Model
 */
class CurrencyController extends CI_Controller
{
	public function index()
	{
		$this->load->view("Admin/currency/View_currency", array("title" => "Currency Setup"));
	}

	public function excel()
	{
		$this->load->view("Admin/branch_account/view_excel", array('title' => 'Excel'));
	}
	public function CreateUpdateCurrency(){
		$branch_id=$this->input->post('branch_id');
		$countryNum=$this->input->post('country');
		$currency=$this->input->post('currency');
		$convertRate=$this->input->post('convertRate');
		$quarter=$this->input->post('quarter');
		$year=$this->input->post('year');
		$update_id=$this->input->post('update_id');
		$user_id = $this->session->userdata('user_id');
		$company_id=$this->session->userdata('company_id');

		$data=array(
			'branch_id'=>$branch_id,
			'quarter'=>$quarter,
			'year'=>$year,
			'country'=>$countryNum,
			'currency'=>$currency,
			'rate'=>$convertRate,
			'created_by'=>$user_id,
			'company_id'=>$company_id,
			'month'=>$quarter
		);
		if(isset($update_id) && !empty($update_id)){
			$where=array("id"=>$update_id);
			$update=$this->Master_Model->_update('currency_conversion_master',$data,$where);
			if($update->status == true){
				$response['status']=200;
				$response['body']="Updated Successfully";
			}else{
				$response['status']=201;
				$response['body']="Something Went Wrong";
			}
		}else{
			$insert=$this->Master_Model->_insert('currency_conversion_master',$data);
			if($insert->status == true){
				$response['status']=200;
				$response['body']="Added Successfully";
			}else{
				$response['status']=201;
				$response['body']="Something Went Wrong";
			}
		}echo json_encode($response);
	}
	public function saveCurrencyConversion(){
		$branch_id=$this->session->userdata('branch_id');
		$company_id=$this->session->userdata('company_id');
		$quarter=$this->input->post('month');
		$year=$this->input->post('year');
		$created_on=date('Y-m-d');
		$created_by = $this->session->userdata('user_id');
		$CheckBlockwhere=array('company_id'=>$company_id,'year'=>$year,'month'=>$quarter);
		$checkPermission=$this->Master_Model->checkBlockYearMonth($CheckBlockwhere);
		if($checkPermission==true)
		{
		$data1=array(
			'branch_id'=>$branch_id,
			'month'=>$quarter,
			'year'=>$year,
			'created_by'=>$created_by,
			'status'=>1,
			'created_on'=>$created_on,
			'company_id'=>$company_id
		);
//		$check_exists = $this->Master_Model->get_row_data("*", array("quarter"=>$quarter,"year"=>$year,"branch_id"=>$branch_id), 'currency_conversion_master');
		$check_exists = $this->Master_Model->get_row_data("*", array("month"=>$quarter,"year"=>$year,"company_id"=>$company_id), 'currency_conversion_mt');
			if(!empty($check_exists)){
				$response['status']=201;
				$response['body']="Already Exists";
			}else{
				$insert=$this->Master_Model->_insert('currency_conversion_mt',$data1);
				// $data=array(
				// 	'currency_conversion_mt_id'=>$insert2->inserted_id,
				// 	'branch_id'=>$branch_id,
				// 	'quarter'=>$quarter,
				// 	'year'=>$year,
				// 	'created_by'=>$created_by,
				// 	'created_on'=>$created_on,
				// );

				// $insert=$this->Master_Model->_insert('currency_conversion_master',$data);

				if($insert->status == 200){
					$response['status']=200;
					$response['id']=$insert->inserted_id;
					$response['body']="Added Successfully";
				}else{
					$response['status']=201;
					$response['id']=0;
					$response['body']="Something Went Wrong";
				}
			}
		}
		else
		{
			$response['status']=201;
			$response['id']=0;
			$response['body']="You can not create currency conversion for this year and month";
		}echo json_encode($response);
	}

	function getCurrencyData(){
		$mbData = $this->db
			->select(array("*"))
			->order_by('id','desc')
			->get("currency_conversion_master")->result();
		$tableRows = array();
		if (count($mbData) > 0) {
			$i=1;
			foreach ($mbData as $order) {
				if($order->status == 1){
					$status='Active';
				}else{
					$status='InActive';
				}
				$country_master = $this->Master_Model->country();
				$country=$country_master[1];
				$country_master = $this->Master_Model->getQuarter();
				array_push($tableRows, array($i,$order->id,$country[$order->country],$order->currency,$order->rate,$country_master[$order->quarter],$order->year, $status));
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
	function getCurrencyDataDT(){
		$branch_id = $this->session->userdata('branch_id');
		$company_id = $this->session->userdata('company_id');
		$mbData = $this->db
			->select(array("*"))
			->order_by('id','desc')
			->where(array('company_id'=>$company_id))
			->get("currency_conversion_mt")->result();
		$tableRows = array();
		if (count($mbData) > 0) {
			$i=1;
			foreach ($mbData as $order) {
				if($order->status == 1){
					$status='Active';
				}else{
					$status='InActive';
				}
				$CheckBlockwhere = array('year'=>$order->year,'month'=>$order->month,'company_id'=>$company_id);
				$checkPermission=$this->Master_Model->checkBlockYearMonth($CheckBlockwhere);
				$permission = 0;
				if ($checkPermission == true){
					$permission = 1;
				}
				$country_master = $this->Master_Model->country();
//				if($order->country !=''){
//					$countries = $country_master[1];
//					$country = $countries[$order->country];
//				}else{
//					$country='';
//				}
				$country_master = $this->Master_Model->getQuarter();
				array_push($tableRows, array($i,
					$order->id,
					$country_master[$order->month],
					$order->year,
					$permission,
					$status));
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

	function getDataCurrencyByID(){
		$id = $this->input->post('id');
		$company_master = $this->Master_Model->get_row_data($select="*",$where=array('id'=>$id),$table="currency_conversion_master");
		if (($company_master) != NULL) {
			$response['data'] = $company_master;
			$response['status'] = 200;
		} else {
			$response['comorbidity'] = "";
			$response['status'] = 201;
		}
		echo json_encode($response);
	}
	function getCurrencyCountry(){
		$country_master = $this->Master_Model->country();
		$country=$country_master[1];
		$currency=$country_master[0];
		$option="<option selected disabled>Select Option</option>";
		foreach($country as $key=>$item){
			$option .="<option value='".$key."'>".$item."</option>";
		}
		$response['options']=$option;
		$response['currency']=$currency;
		$response['country']=$country;
		echo json_encode($response);

	}
	function getCurrencyDataH(){
		$company_id = $this->session->userdata('company_id');
		$branch_id = $this->session->userdata('company_id');

		$getDataBranch=$this->Master_Model->order_by_data($select="*,(select default_currency_rate from branch_master b where b.id=branch_id) as default_rate,(select name from branch_master b where b.id=branch_id) as branch_name",$where=array('branch_id'=>$branch_id),$table="currency_conversion_master",$order_by="id",$key="asc");

//		$getDataBranch=$this->Master_Model->order_by_data($select="*,(select default_currency_rate from branch_master b where b.id=branch_id) as branch_name",$where=array(),$table="currency_conversion_master",$order_by="id",$key="asc");
		$dataNew=array();
		if(count($getDataBranch) > 0){
			foreach ($getDataBranch as $row1){
				$country_master = $this->Master_Model->country();
				if ($row1->country !='' ){
					$countries=$country_master[1];
					$country = $countries[$row1->country];
				}else{
					$country = '';
				}
				if ($row1->currency !=''){
					$currencies=$country_master[0];
					$currency = $currencies[$row1->country];
				}else{
					$currency = '';
				}

				$country_master = $this->Master_Model->getQuarter();
				$data1=array($row1->branch_name,
					$country,
					$currency,$row1->rate,$row1->year,$country_master[$row1->quarter],$row1->id);
				array_push($dataNew,$data1);
			}
			$data12=array("","","","");
			array_push($dataNew,$data12);

		}
		$response['data2']=$dataNew;
		echo json_encode($response);
	}

	public function viewCurrencyDetails($cc_id='')
	{
		$company_id = $this->session->userdata('company_id');
		$getCCData = $this->Master_Model->get_row_data("*", array('id' => $cc_id), 'currency_conversion_mt');
		$CheckBlockwhere = array('year' =>$getCCData->year, 'month' => $getCCData->month, 'company_id' => $company_id);
		$checkPermission = $this->Master_Model->checkBlockYearMonth($CheckBlockwhere);

		$this->load->view("Admin/currency/View_currency_conversion", array("title" => "Branch Account Setup","cc_id"=>$cc_id,"checkPermission"=>$checkPermission));
	}

	function getCurrencyDataHCC(){
		$company_id = $this->session->userdata('company_id');
		$branch_id = $this->session->userdata('branch_id');
		$user_id = $this->session->userdata('user_id');
		$cc_id = $this->input->post('cc_id');
		$country_master = $this->Master_Model->country();

		$month_master = $this->Master_Model->getQuarter();
		// $branchData = $this->db->where('id',$branch_id)->get('branch_master')->row();
		$getCurrencyConversion=$this->Master_Model->_select('currency_conversion_mt',array('id'=>$cc_id),"*",true);
		// print_r($getCurrencyConversion);exit();
			$dataNew=array();
		if($getCurrencyConversion->totalCount>0){
			$currencyData=$getCurrencyConversion->data;
			//$getDataBranch=$this->Master_Model->order_by_data($select="*,(select name from branch_master b where b.id=".$branch_id.") as branch_name",$where=array('currency_conversion_mt_id'=>$cc_id,'company_id'=>$company_id),$table="currency_conversion_master",$order_by="id",$key="asc");
			$getDataBranch=$this->Master_Model->_rawQuery("select *,(select group_concat(rate,',',closing_rate)  from currency_conversion_master c where c.currency_conversion_mt_id=".$cc_id." and company_id=".$company_id." and c.currency=b.currency) as rates from branch_master b where company_id=".$company_id." group by currency");
			if($getDataBranch->totalCount > 0){
				foreach ($getDataBranch->data as $row1){

					if ($row1->country !='' && $row1->country!=0){
						$countries=$country_master[1];
						$country = $countries[$row1->country];
					}else{
						$country = '';
					}

					if ($row1->currency !='' && $row1->country!=0){
						$currencies=$country_master[0];
					//	$currency = $currencies[$row1->country];
						$currency = $row1->currency;
					}else{
						$currency = '';
					}
					$rates=$row1->rates;
					if($rates == null){
						$row1->rate=$row1->default_currency_rate;
						$row1->closing_rate=$row1->default_currency_rate;
					}else{
						$exp=explode(",",$rates);
						if(count($exp) > 0){
							$row1->rate=$exp[0];
							if(array_key_exists(1,$exp)){
								$row1->closing_rate=$exp[1];
							}else{
								$row1->closing_rate=$row1->default_currency_rate;
							}
						}
					}

					if($row1->rate !='')
					{
						$rate=$row1->rate;
					}
					else
					{
						$rate=0;
					}


					// $data1=array($row1->branch_name,
					// 	$branchData->country,
					// 	$branchData->currency,$branchData->default_currency_rate,$row1->year,$month_master[$row1->quarter],$row1->id);
					$data1=array($currencyData->branch_id,
						$country,
						$currency,$rate,$currencyData->year,$month_master[$currencyData->month],$cc_id,$currencyData->month,$row1->closing_rate);
					// $data1=array(
					// 	$branchData->country,
					// 	$branchData->currency,$branchData->default_currency_rate);
					array_push($dataNew,$data1);
				}
			}
			else
			{
				$branchData=$this->Master_Model->_select('branch_master',array('company_id'=>$company_id,'status'=>1),"distinct(currency),country,default_currency_rate",false);

				if($branchData->totalCount>0)
				{
					$branchDataInsert=array();
					foreach ($branchData->data as $key => $value) {
						if($value->default_currency_rate!=0 && $value->default_currency_rate!=null)
						{
							$rate=$value->default_currency_rate;
						}
						else
						{
							$rate=0;
						}
						// print_r($value->country);exit();
						$cur=$this->Master_Model->country();
						// $country = array_search($value->country,array_values($country_master[1]));
						$data1=array($currencyData->branch_id,
							$cur[1][$value->country],
						$value->currency,$rate,$currencyData->year,$month_master[$currencyData->month],$cc_id,$currencyData->month);
						$insertdata=array('currency_conversion_mt_id'=>$cc_id,'branch_id'=>$currencyData->branch_id,'quarter'=>$currencyData->month,'year'=>$currencyData->year,'country'=>$value->country,'currency'=>$value->currency,'rate'=>$rate,'created_on'=>date('Y-m-d H:i:s'),'created_by'=>$user_id,'status'=>1,'company_id'=>$company_id,'month'=>$currencyData->month);
						array_push($dataNew,$data1);
						array_push($branchDataInsert,$insertdata);
					}
					if(count($branchDataInsert)>0)
					{
						$this->db->insert_batch('currency_conversion_master',$branchDataInsert);
					}
				}

			}
			$data12=array("","","","","","","","","");

				array_push($dataNew,$data12);
		}

		$source=array(
			array('type'=>'text'),
			array('type'=>'text','readOnly'=>true),
			array('type'=>'text','readOnly'=>true),
			array('type'=>'numeric'),
			array('type'=>'text'),
			array('type'=>'text'),
			array('type'=>'text'),
			array('type'=> 'text'),
			array('type'=> 'numeric')
		);
		$response['source']=$source;
		$response['data2']=$dataNew;
		echo json_encode($response);
	}

	function saveHOSData(){

		$month_array =$this->Master_Model->getQuarter();
		$country_array =$this->Master_Model->country();
		$Data1 = $this->input->post('arrData');
		$cc_id = $this->input->post('cc_id');
		$arrData = json_decode($Data1);

		$user_id = $this->session->userdata('user_id');
		$company_id = $this->session->userdata('company_id');

		$getCurrencyConversionMaster = $this->Master_Model->get_row_data("*", array('id'=>$cc_id), 'currency_conversion_mt');

		$CheckBlockwhere = array('year'=>$getCurrencyConversionMaster->year,'month'=>$getCurrencyConversionMaster->month,'company_id'=>$company_id);
		$checkPermission=$this->Master_Model->checkBlockYearMonth($CheckBlockwhere);
		if ($checkPermission == true){
			$newArray=array();
			$uniqueCountry=array();
				if(!empty($arrData))
				{
					$getCurrencyData=$this->Master_Model->_select('currency_conversion_mt',array('id'=>$cc_id),"*",true);
					if($getCurrencyData->totalCount>0)
					{
						$currencyData=$getCurrencyData->data;

						$where=array("company_id"=>$company_id,"year"=>$currencyData->year,"month"=>$currencyData->month,"currency_conversion_mt_id"=>$cc_id);
							$getCurrencyConversion=$this->Master_Model->_select('currency_conversion_master',$where,array('id'),true);

								$indexArray=array();
								$i=1;
								foreach ($arrData as $item){
									if($item[1]!="" && $item[3]!="" && $item[8]!="")
									{
										$country = array_search($item[1],$country_array[1]);

										if(in_array($country, $uniqueCountry)){
											$response['status']=201;
											$response['body']="Country ".$item[1]." Already added";
											echo json_encode($response);
											exit;
										}
										else
										{

											$month = array_search($currencyData->month,$month_array);
											$data=array(
												"branch_id"=>$currencyData->branch_id,
												"quarter"=>$currencyData->month,
												"year"=>$currencyData->year,
												"month"=>$currencyData->month,
												"country"=>$country,
												"currency"=>$item[2],
												"rate"=>$item[3],
												"created_on"=>date('Y-m-d H:i:s'),
												"created_by"=>$user_id,
												"status"=>1,
												"company_id"=>$company_id,
												"currency_conversion_mt_id"=>$cc_id,
												"closing_rate"=>$item[8],
											);
											array_push($newArray,$data);
											array_push($uniqueCountry, $country);

										}
									}
									else
									{
										$da='';
										if($item[3]=="")
										{
											$da.="A".$i;
										}
										if($item[8]=="")
										{
											$da.="B".$i;
										}
										array_push($indexArray, $da);
									}
									$i++;
								}


							// print_r($newArray);exit();
								if(!empty($indexArray))
								{
									$response['status']=202;
									$response['type']=1;
									$response['body']=implode(',',array_unique($indexArray));
								}
								else
								{
									if(!empty($newArray))
									{
										/*if($getCurrencyConversion->totalCount>0)
										{

										}*/

										$delete=$this->db->delete("currency_conversion_master",$where);
										$insert_batch=$this->db->insert_batch("currency_conversion_master",$newArray);

										if($insert_batch == true){
											$response['status']=200;
											$response['body']="Data uploaded Successfully";
										}else{
											$response['status']=201;
											$response['body']="Failed To uplaod";
										}
									}
									else{
											$response['status']=201;
											$response['body']="No data for add";
										}
								}

					}
					else
					{
						$response['status']=201;
						$response['body']="No Currency Month added";
					}

			}else{
				$response['status']=201;
				$response['body']="No data for add";
			}
		}else{
			$response['status']=201;
			$response['body']="You can not save data for this year and month";
		}
		echo json_encode($response);
	}

	public function getCountryCurrencyData()
	{
		$country = $this->input->post('value');
		$country_array =$this->Master_Model->country();
		$countryIndex = array_search($country,$country_array[1]);
		$currencies=$country_array[0];
		$currency=$currencies[$countryIndex];
		$response['data']=$currency;

		echo json_encode($response);
	}

	///Special Exchange Rate 13/10/2022
	public function spc_exchangeRate()
	{
		$data['title'] = "Special Exchange Rate";
		$this->load->view('Admin/currency/SpecialExchangeRate',$data);
	}

	public function getSubsidiaryData(){
		$query1 = $this->db->query('select id, name as branch_name from branch_master where company_id="'.$this->session->userdata('company_id').'" and status=1')->result();
		if(!empty($query1))
		{
			$html1 ='';
			$html1 .='<option value="">select subsidiary</option>';
			foreach($query1 as $val1)
			{
				$html1 .='<option value="'.$val1->id.'">'.$val1->branch_name.'</option>';
			}
			$response['status'] =200;
			$response['body'] = $html1;
		}else{
			$response['status'] =201;
			$response['body'] = 'Failed';
		}
		echo json_encode($response);
	}

	public function getGlDataByBranchID()
	{
		$branch_id = $this->input->post('branchId');
		$Glnumber = $this->db->query('select account_number,parent_account_number from branch_account_setup where branch_id="'.$branch_id.'"')->result();
		if(!empty($Glnumber)){
			$html ='';
			$html .='<option disabled selected>select GL</option>';
			foreach($Glnumber as $val){
				//print_r($val);
				$html .='<option value="'.$val->account_number.'||'.$val->parent_account_number.'">'.$val->account_number.'</option>';
			}
			$response['status'] =200;
			$response['body'] = $html;

		}else{
			$response['status'] =201;
		}
		echo json_encode($response);
	}

	public function saveGlDataByBranchID()
	{
		if(!is_null($this->input->post('year')) && !is_null($this->input->post('month')) && !is_null($this->input->post('amount')) &&
			!is_null($this->input->post('gl')) && !is_null($this->input->post('subsidiary'))){
			$year=$this->input->post('year');
			$month=$this->input->post('month');
			$gl=$this->input->post('gl');
			$gl_ac=explode('||',$gl);
			$branch=$this->input->post('subsidiary');
			$amount=$this->input->post('amount');
			$resultObject=$this->Master_Model->_rawQuery('select sr.id from special_exchange_rate sr where sr.year="'.$year.'" 
			and sr.month="'.$month.'" and sr.gl_ac="'.$gl_ac[0].'" and sr.branch_id="'.$branch.'"');
			if($resultObject->totalCount>0)
			{
				$data = array(
					'exchange_rate'=>$amount,
					'updated_by'=>$this->session->userdata('user_id'),
					'updated_on'=>date('Y-m-d h:i:s')
				);
				$insert = $this->Master_Model->_update('special_exchange_rate',$data,array('id'=>$resultObject->data[0]->id));
			}
			else{
				$data = array('year'=>$year,
					'month'=>$month,
					'exchange_rate'=>$amount,
					'gl_ac'=>$gl_ac[0],
					'branch_id'=>$branch,
					'parent_account_number'=>$gl_ac[1],
					'created_by'=>$this->session->userdata('user_id'),
					'company_id'=>$this->session->userdata('company_id'),
					'created_on'=>date('Y-m-d h:i:s')
				);
				$insert = $this->Master_Model->_insert('special_exchange_rate',$data);
			}
			if($insert){
				$response['status'] =200;
				$response['body'] = 'Data save successfully';
			}else{
				$response['status'] =201;
				$response['body'] = 'failed';
			}
		}else{
			$response['status'] =201;
			$response['body'] = 'Required parameter missing';
		}
		echo json_encode($response);
	}

	public function getExchangeRateDateList()
	{
		$comapny_id=$this->session->userdata('company_id');
		$mbData = $this->db->query('select id,gl_ac,exchange_rate,year,month,(select name from branch_master where id=spr.branch_id )as subsidiary from special_exchange_rate spr where company_id="'.$comapny_id.'" order by id desc')->result();
		$month_array = $this->Master_Model->getQuarter();
		$tableRows = array();
		if (count($mbData) > 0) {
			$i=1;
			foreach ($mbData as $order) {
				$month1 = '';
				if(array_key_exists($order->month,$month_array)){
					$month1 = $month_array[$order->month];
				}
				array_push($tableRows, array($i,
					$month1,
					$order->year,
					$order->subsidiary,
					$order->gl_ac,
					$order->exchange_rate,
					$order->id
				));
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

	public function delexchangeRate()
	{
		$id = $this->input->post('id');
		if(!empty($id))
		{
			$data = $this->Master_Model->_delete('special_exchange_rate',array('id'=>$id));
			if($data){
				$response['status'] =200;
				$response['body'] = 'Data deleted successfully';
			}else{
				$response['status'] =201;
				$response['body'] = 'failed';
			}
		}else{
			$response['status'] =201;
			$response['body'] = 'failed';
		}
		echo json_encode($response);
	}
	public function saveAdditionGlDataByBranchID()
	{
		if(!is_null($this->input->post('year')) && !is_null($this->input->post('month')) && !is_null($this->input->post('amount')) &&
			!is_null($this->input->post('gl')) && !is_null($this->input->post('subsidiary'))){
			$year=$this->input->post('year');
			$month=$this->input->post('month');
			$gl=$this->input->post('gl');
			$gl_ac=explode('||',$gl);
			$branch=$this->input->post('subsidiary');
			$amount=$this->input->post('amount');
			$addtype=$this->input->post('addtype');
			$comment=$this->input->post('comment');
			$resultObject=$this->Master_Model->_rawQuery('select sr.id from special_additionGL_rate sr where sr.year="'.$year.'" 
			and sr.month="'.$month.'" and sr.gl_ac="'.$gl_ac[0].'" and sr.branch_id="'.$branch.'" and sr.type="'.$addtype.'"');
			if($resultObject->totalCount>0)
			{
				$data = array(
					'exchange_rate'=>$amount,
					'updated_by'=>$this->session->userdata('user_id'),
					'updated_on'=>date('Y-m-d h:i:s')
				);
				$insert = $this->Master_Model->_update('special_additionGL_rate',$data,array('id'=>$resultObject->data[0]->id));
			}
			else{
				$data = array('year'=>$year,
					'month'=>$month,
					'exchange_rate'=>$amount,
					'gl_ac'=>$gl_ac[0],
					'branch_id'=>$branch,
					'type'=>$addtype,
					'comment'=>$comment,
					'parent_account_number'=>$gl_ac[1],
					'created_by'=>$this->session->userdata('user_id'),
					'company_id'=>$this->session->userdata('company_id'),
					'created_on'=>date('Y-m-d h:i:s')
				);
				$insert = $this->Master_Model->_insert('special_additionGL_rate',$data);
			}
			if($insert){
				$response['status'] =200;
				$response['body'] = 'Data save successfully';
			}else{
				$response['status'] =201;
				$response['body'] = 'failed';
			}
		}else{
			$response['status'] =201;
			$response['body'] = 'Required parameter missing';
		}
		echo json_encode($response);
	}
	public function getAdditionGLRateTable()
	{
		$company_id=$this->session->userdata('company_id');
		$mbData = $this->db->query('select id,gl_ac,exchange_rate,year,month,(select name from branch_master where id=spr.branch_id )as subsidiary,type from special_additionGL_rate spr where company_id="'.$company_id.'" order by id desc')->result();
		$month_array = $this->Master_Model->getQuarter();
		$tableRows = array();
		if (count($mbData) > 0) {
			$i=1;
			foreach ($mbData as $order) {
				$month1 = '';
				if(array_key_exists($order->month,$month_array)){
					$month1 = $month_array[$order->month];
				}
				if($order->type==2)
				{
					$type='Adjust by auditor';
				}
				else{
					$type="Default";
				}
				array_push($tableRows, array($i,
					$month1,
					$order->year,
					$order->subsidiary,
					$order->gl_ac,
					$order->exchange_rate,
					$order->id,
					$type
				));
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
	public function deleteAdditionGLRate()
	{
		$id = $this->input->post('id');
		if(!empty($id))
		{
			$data = $this->Master_Model->_delete('special_additionGL_rate',array('id'=>$id));
			if($data){
				$response['status'] =200;
				$response['body'] = 'Data deleted successfully';
			}else{
				$response['status'] =201;
				$response['body'] = 'failed';
			}
		}else{
			$response['status'] =201;
			$response['body'] = 'failed';
		}
		echo json_encode($response);
	}
	////------
	//// Auditor After Adjustment
	public function saveAuditorGlDataByBranchID()
	{
		if(!is_null($this->input->post('year')) && !is_null($this->input->post('month')) && !is_null($this->input->post('amount')) &&
			!is_null($this->input->post('gl')) && !is_null($this->input->post('subsidiary'))){
			$year=$this->input->post('year');
			$month=$this->input->post('month');
			$gl=$this->input->post('gl');
			$gl_ac=explode('||',$gl);
			$branch=$this->input->post('subsidiary');
			$amount=$this->input->post('amount');
			$resultObject=$this->Master_Model->_rawQuery('select sr.id from special_auditorAdjustmentGL_rate sr where sr.year="'.$year.'" 
			and sr.month="'.$month.'" and sr.gl_ac="'.$gl_ac[0].'" and sr.branch_id="'.$branch.'"');
			if($resultObject->totalCount>0)
			{
				$data = array(
					'rate'=>$amount,
					'updated_by'=>$this->session->userdata('user_id'),
					'updated_on'=>date('Y-m-d h:i:s')
				);
				$insert = $this->Master_Model->_update('special_auditorAdjustmentGL_rate',$data,array('id'=>$resultObject->data[0]->id));
			}
			else{
				$data = array('year'=>$year,
					'month'=>$month,
					'rate'=>$amount,
					'gl_ac'=>$gl_ac[0],
					'branch_id'=>$branch,
					'parent_account_number'=>$gl_ac[1],
					'created_by'=>$this->session->userdata('user_id'),
					'company_id'=>$this->session->userdata('company_id'),
					'created_on'=>date('Y-m-d h:i:s')
				);
				$insert = $this->Master_Model->_insert('special_auditorAdjustmentGL_rate',$data);
			}
			if($insert){
				$response['status'] =200;
				$response['body'] = 'Data save successfully';
			}else{
				$response['status'] =201;
				$response['body'] = 'failed';
			}
		}else{
			$response['status'] =201;
			$response['body'] = 'Required parameter missing';
		}
		echo json_encode($response);
	}
	public function getAuditorGLRateTable()
	{
		$company_id=$this->session->userdata('company_id');
		$mbData = $this->db->query('select id,gl_ac,rate,year,month,(select name from branch_master where id=spr.branch_id )as subsidiary from special_auditorAdjustmentGL_rate spr where company_id="'.$company_id.'" order by id desc')->result();
		$month_array = $this->Master_Model->getQuarter();
		$tableRows = array();
		if (count($mbData) > 0) {
			$i=1;
			foreach ($mbData as $order) {
				$month1 = '';
				if(array_key_exists($order->month,$month_array)){
					$month1 = $month_array[$order->month];
				}
				array_push($tableRows, array($i,
					$month1,
					$order->year,
					$order->subsidiary,
					$order->gl_ac,
					$order->rate,
					$order->id
				));
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
	public function deleteAuditorAdjustmnetGLRate()
	{
		$id = $this->input->post('id');
		if(!empty($id))
		{
			$data = $this->Master_Model->_delete('special_auditorAdjustmentGL_rate',array('id'=>$id));
			if($data){
				$response['status'] =200;
				$response['body'] = 'Data deleted successfully';
			}else{
				$response['status'] =201;
				$response['body'] = 'failed';
			}
		}else{
			$response['status'] =201;
			$response['body'] = 'failed';
		}
		echo json_encode($response);
	}
	//// Auditor After Adjustment
}
