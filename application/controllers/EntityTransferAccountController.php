<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property  Master_Model Master_Model
 */
class EntityTransferAccountController extends CI_Controller
{
	public function index()
	{

	}
	public function getEntityTransferDropdownData()
	{
		$company_id=$this->session->userdata('company_id');
		$user_id=$this->session->userdata('user_id');
		$branch_list = $this->Master_Model->_rawQuery(' select * from branch_master where company_id="'.$company_id.'" and status=1');
		$branch_permission = $this->session->userdata('branch_permission');
		$array=array();
		if(!is_null($branch_permission)){
			$array=explode(",",$branch_permission);
		}
		$branch_source = '<option value="">Select Subsidiary</option>';
		if ($branch_list->totalCount > 0) {
			foreach ($branch_list->data as $row) {
//				if(in_array($row->id,$array)) {
					$branch_source .= '<option value="' . $row->id . '">' . $row->name . '</option>';
//				}
			}
		}
		$allGlList = $this->Master_Model->_rawQuery(' select main_gl_number,name from main_account_setup_master where company_id="'.$company_id.'" and status=1 ');

		$MainGlSource = '<option value="">Select GL Account</option>';
		if ($allGlList->totalCount > 0) {

			foreach ($allGlList->data as $row) {
				$MainGlSource.='<option value="'.$row->main_gl_number.'">'.$row->main_gl_number.' - '.$row->name.'</option>';
			}
		}
		$currencySource = '<option value="">Select Currency</option>';
		$country_master = $this->Master_Model->country();
		$countryCurrency = $country_master[0];
		$currency = array_values($countryCurrency);
		foreach ($currency as $crow)
		{
			$currencySource.='<option value="'.$crow.'">'.$crow.'</option>';
		}
		$response['status']=200;
		$response['branchList']=$branch_source;
		$response['glaccountList']=$MainGlSource;
		$response['currencyList']=$currencySource;
		echo json_encode($response);
	}
	public function getTransCompanyGlAccount()
	{
		$branchdata = $this->input->post('branch');
		$branch_currency = $this->Master_Model->get_row_data('currency', array('id' => $branchdata), 'branch_master');
		if (!empty($branch_currency) > 0) {
			$currency = $branch_currency->currency;
			$response['currency'] = $currency;
			$response['status'] = 200;
		} else {
			$response['currency'] = '';
			$response['status'] = 201;
		}
		echo json_encode($response);
	}
	public function uploadIntraTransactionData()
	{
//		print_r($this->input->post());exit();
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		$sheet_master_id = $this->input->post('insertID');
		$updateID = $this->input->post('updateID');
		$transferType = $this->input->post('transferType');
		$loadTransValue = $this->input->post('transactionType');
		//from
		$from_branch_id = $this->input->post('fromSubAccount');
		$from_gl_account = $this->input->post('fromGlAccount');
		$fromDebit = $this->input->post('fromDebit');
		$fromCredit = $this->input->post('fromCredit');
		$fromGivenBy = $this->input->post('fromGivenBy');
		$fromCurrency = $this->input->post('fromCurrency');
		$fromCurrencyRate = $this->input->post('fromCurrencyRate');
		$fromTotalValue = $this->input->post('fromTotalValue');
		//to
		$to_branch_id = $this->input->post('toSubAccount');
		$to_gl_account = $this->input->post('toGlAccount');
		$toDebit = $this->input->post('toDebit');
		$toCredit = $this->input->post('toCredit');
		$toGivenBy = $this->input->post('toGivenBy');
		$toCurrency = $this->input->post('toCurrency');
		$toCurrencyRate = $this->input->post('toCurrencyRate');
		$toTotalValue = $this->input->post('toTotalValue');
		//difference
		$differenceGl = $this->input->post('differenceGl');
		$differenceDebit = $this->input->post('differenceDebit');

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
//			print_r($check_entry);exit();

				if (!empty($check_entry)) {
					$id = $check_entry->id;

					$approve_status = 0;
					if ($user_type == 2) {
						$approve_status = 1;
					}
					$newArray = array();
					$financialData=array();
//						 print_r($item);exit();


							if ($fromCurrency == "") {
								if ($check_entry->holding_type == 1) {
									//company
									if ($company_master[$company_id] != null) {
										$fromCurrency = $company_master[$company_id];
									}

								} else { //branch
									$fromCurrency = $branch_master[$from_branch_id];
								}

							}
							if ($toCurrency == "") {
								if ($check_entry->holding_type == 1) {
									//company
									if ($company_master[$company_id] != null) {
										$toCurrency = $company_master[$company_id];
									}
								} else { //branch
									$toCurrency = $branch_master[$to_branch_id];
								}
							}
							$from = 1;
							$to = 1;
							if ($fromCurrency != "INR") {
								$FromRate = $this->Master_Model->_select('currency_conversion_master', array('company_id' => $company_id, 'year' => $year, 'month' => $month, 'currency' => $fromCurrency), 'rate', true)->data;
								if($FromRate!="") {
									$from = $FromRate->rate;
								}
							}
							if ($toCurrency != "INR") {
								$ToRate = $this->Master_Model->_select('currency_conversion_master', array('company_id' => $company_id, 'year' => $year, 'month' => $month, 'currency' => $toCurrency), 'rate', true)->data;
								if($ToRate!="")
								{
									$to = $ToRate->rate;
								}
							}

							$rateFrom=$fromCurrencyRate; // from currency rate
							if($rateFrom=="")
							{
								$rateFrom=1;
							}
							$rateTo=$toCurrencyRate; // to currency rate
							if($rateTo=="")
							{
								$rateTo=1;
							}
							if($fromDebit=="")
							{
								$fromDebit=0;
							}
							if($fromCredit=="")
							{
								$fromCredit=0;
							}
							if($toDebit=="")
							{
								$toDebit=0;
							}
							if($toCredit=="")
							{
								$toCredit=0;
							}
							$from_debit = ((is_numeric($fromDebit)) ? $fromDebit: 1)  * $rateFrom;
							$from_credit = ((is_numeric($fromCredit)) ? $fromCredit: 1) * $rateFrom;

							$to_debit =  ((is_numeric($toDebit)) ? $toDebit: 1) * $rateTo;
							$to_credit =  ((is_numeric($toCredit)) ? $toCredit: 1) * $rateTo;

							$d1=( ((is_numeric($fromDebit)) ? $fromDebit: 1) - ((is_numeric($fromCredit)) ? $fromCredit: 1))*$rateFrom;
							$d2=(((is_numeric($toDebit)) ? $toDebit: 1) - ((is_numeric($toCredit)) ? $toCredit: 1))*$rateTo;
							// $debit_difference = $from_debit - $to_debit;
							// $credit_difference = $from_credit - $to_credit;
							$debit_difference = $d2 + $d1;
							$credit_difference = 0;
//							$itemfrom=$item[3]-$item[4];
//							$itemto=$item[10]-$item[11];
//							$item[14]=$itemfrom+$itemto;
//
							$diff_gl = $differenceGl;
//							if (count($diff_gl) > 1) {
//								$item[21] = $diff_gl[0];
//							}
							$fromTotal=($fromDebit-$fromCredit)*$rateFrom; // from debit - from credit * from currency_rate
							$toTotal=($toDebit-$toCredit)*$rateTo; // to debit - to credit * to currency_rate
//							$finalValue=(-$fromTotal-$toTotal);//old changes
							$finalValue=-($fromTotal+$toTotal); //changes suggest by bharat
							$data = array(
								"from_branch_id" => $from_branch_id,
								"from_gl_account" => $from_gl_account,
								"from_debit" => $fromDebit,
								"from_credit" => $fromCredit,
								"from_given_by" => $fromGivenBy,
								"from_currency" => $fromCurrency,
								"from_currency_rate"=>$fromCurrencyRate,
								"from_totalValue"=>$fromTotal, //$item[8],
								"to_branch_id" => $to_branch_id,
								"to_gl_account" => $to_gl_account,
								"to_debit" => $toDebit,
								"to_credit" => $toCredit,
								"to_given_by" => $toGivenBy,
								"to_currency" => $toCurrency,
								"to_currency_rate"=>$toCurrencyRate,
								"to_totalValue"=>$toTotal, //$item[17],
								"final_value"=>$finalValue, //$item[20],
								"difference" => $differenceDebit,
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
								"difference_gl" => $differenceGl,
								"trans_type" => $loadTransValue
							);
//							array_push($newArray, $data);
							/*if($transferType == 1){
								$glAct=$IntraGl;
							}else{
								$glAct=$InterGl;
							}*/
//					print_r($data);exit();
					if (!empty($data)) {
						$result = false;
						try {
							$this->db->trans_start();
							if(!empty($updateID))
							{
								$insert_batch=$this->db->set($data)->where(array('id' => $updateID))->update('upload_intra_company_transfer');
							}
							else {
								$insert_batch = $this->db->insert("upload_intra_company_transfer", $data);
							}
							$intra_transfer_id=$updateID;
							if ($insert_batch == true) {
								if(!empty($updateID)) {
									$intra_transfer_id=$updateID;
								}
								else{
									$intra_transfer_id = $this->db->insert_id();
								}
								if (!empty($specialBranch)) {
									if ($finalValue != 0) {
										$finArr = array('gl_ac' => $differenceGl,
											'debit' => $fromTotal, //$item[17],//from total
											'credit' => $toTotal,//$item[8],//to total
											'total' => $finalValue,//$item[20],
											'detail' => '',
											'year' => $check_entry->year,
											'quarter' => $check_entry->quarter,
											'branch_id' => $specialBranch,
											'company_id' => $company_id,
											'user_id' => $user_id,
											'created_by' => $user_id,
											'created_on' => date('Y-m-d H:i:s'),
											'is_transfer' => 1,
											'transfer_type' => $transferType,
											'sheet_master_id' => 0,
											'is_difference_value' => 1,
											'intra_transfer_id' => $intra_transfer_id);
										array_push($financialData, $finArr);
									}
								}
								$resultReturn = $this->uploadConsolidateTransaction($data, $check_entry->year, $check_entry->quarter, $specialBranch, $transferType, $intra_transfer_id);
								if (!empty($financialData)) {
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

			echo json_encode($response);
		}
	}
	function uploadConsolidateTransaction($row, $year, $month,$specialBranch,$transferType,$intra_transfer_id){
		$data1=array();
		$data2=array();
		$company_id = $this->session->userdata('company_id');
		$user_id = $this->session->userdata('user_id');

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
				'intra_transfer_id'=>$intra_transfer_id,
				'created_by' => $user_id,
				'created_on' => date('Y-m-d H:i:s')
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
				'intra_transfer_id'=>$intra_transfer_id,
				'created_by' => $user_id,
				'created_on' => date('Y-m-d H:i:s')
			);
			array_push($data1,$data1_1);
			array_push($data2,$data1_2);

		$twhere = array('quarter' => $month,
			'year' => $year,
			'company_id' => $company_id,
			'is_transfer' => 1,'transfer_type'=>$transferType,
			'intra_transfer_id'=>$intra_transfer_id);
		$delete = $this->Master_Model->_delete('upload_financial_data', $twhere);
		$insert = $this->db->insert_batch('upload_financial_data', $data1);
		$insert2 = $this->db->insert_batch('upload_financial_data', $data2);
		if($insert == true && $insert2 == true){
			return true;
		}
	}
	public function getTransCurrencyAverageValue()
	{
		if(!is_null($this->input->post('currency')) && !is_null($this->input->post('month')))
		{
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
	public function getTransTableData()
	{
		if (!is_null($this->input->post('id'))) {
			$sheet_master_id = $this->input->post('id');
			$transfer_type = $this->input->post('companyType');
			$loadTransValue = $this->input->post('loadTransValue');
			$user_type = $this->session->userdata('user_type');
			$company_id=$this->session->userdata('company_id');
			$where = array('sheet_master_id' => $sheet_master_id,'transfer_type' => $transfer_type,'trans_type'=>$loadTransValue);
			if ($user_type != 2) {
				$where['created_by'] = $this->session->userdata('user_id');
			}
			$branch_id = $this->session->userdata('branch_id');
			$resultObject = $this->Master_Model->_select('upload_intra_company_transfer', $where, array("*", "(select bm.name from branch_master bm where bm.id=from_branch_id) as from_branch", "(select bm.name from branch_master bm where bm.id=to_branch_id) as to_branch",
				"(select bs.name from main_account_setup_master bs where bs.main_gl_number=from_gl_account and bs.company_id=".$company_id.") as from_detail",
				"(select bs.name from main_account_setup_master bs where bs.main_gl_number=difference_gl and bs.company_id=".$company_id.") as difference_details",
				"(select bs.name from main_account_setup_master bs where bs.main_gl_number=to_gl_account and bs.company_id=".$company_id.") as to_detail", "(select bmm.name from branch_master bmm where bmm.id='" . $branch_id . "') as my_branch"), false);
			$response['query'] = $resultObject->last_query;
			if ($resultObject->totalCount > 0) {
				$response['status'] = 200;
				$response['data'] = $resultObject->data;
			} else {
				$response['status'] = 202;
				$response['data'] = 'No data Found';
			}
		} else {
			$response['status'] = 201;
			$response['data'] = 'Required parameter missing';
		}
		echo json_encode($response);
	}
	public function editTransData()
	{
		if (!is_null($this->input->post('id'))) {
			$id = $this->input->post('id');
			$resultObject=$this->Master_Model->_select('upload_intra_company_transfer',array('id'=>$id),'*');
			if($resultObject->totalCount>0)
			{
				$response['status'] = 200;
				$response['data'] = $resultObject->data;
			}
			else{
				$response['status'] = 201;
				$response['data'] = 'No data found';
			}
		} else {
			$response['status'] = 201;
			$response['data'] = 'Required parameter missing';
		}
		echo json_encode($response);
	}
	public function deleteTransdata()
	{
		if (!is_null($this->input->post('id'))) {
			$id = $this->input->post('id');
			$resultObject=$this->Master_Model->_delete('upload_intra_company_transfer',array('id'=>$id));
			if($resultObject)
			{
				$delete=$this->Master_Model->_delete('upload_financial_data',array('intra_transfer_id'=>$id));
				$response['status'] = 200;
				$response['data'] = 'Transaction Deleted Successfully';
			}
			else{
				$response['status'] = 201;
				$response['data'] = 'Transaction Not Deleted';
			}
		} else {
			$response['status'] = 201;
			$response['data'] = 'Required parameter missing';
		}
		echo json_encode($response);
	}
	public function getExcelFormat()
	{
		$this->load->library('excel');
		$transfer_type = $this->input->get('transferType');
		$loadTransValue = $this->input->get('loadTransValue');
		$sheet_master_id=$this->input->get('id');
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');
		$templateName='Report';
		if($transfer_type==1)
		{
			$templateName='Intra Transfer Details';
		}
		else{
			$templateName='Inter Transfer Details';
		}

		$k = 0;
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex();
		$objWorkSheet = $objPHPExcel->createSheet($k);
		$objWorkSheet->setTitle($templateName);
		if($loadTransValue==1)
		{
			$templateName.=' - Balance Sheet';
		}
		else{
			$templateName.=' - Profit & Loss';
		}

		$objWorkSheet->SetCellValue('A' . 1, 'Sr No.');
		$objWorkSheet->SetCellValue('B' . 1, 'Subsidiary Account');
		$objWorkSheet->getStyle(PHPExcel_Cell::stringFromColumnIndex('B') . 1)
			->getAlignment()
			->setWrapText(true);
		$objWorkSheet->SetCellValue('C' . 1, 'GL Account');
		$objWorkSheet->getStyle(PHPExcel_Cell::stringFromColumnIndex('C') . 1)
			->getAlignment()
			->setWrapText(true);
		$objWorkSheet->SetCellValue('D' . 1, 'Debit');
		$objWorkSheet->SetCellValue('E' . 1, 'Credit');
		$objWorkSheet->SetCellValue('F' . 1, 'Given By');
		$objWorkSheet->SetCellValue('G' . 1, 'Currency');
		$objWorkSheet->SetCellValue('H' . 1, 'Currency Rate');
		$objWorkSheet->SetCellValue('I' . 1, 'Total Value');
		$objWorkSheet->SetCellValue('J' . 1, 'Trade Currency Value');

		$where = array('sheet_master_id' => $sheet_master_id,'transfer_type' => $transfer_type,'trans_type'=>$loadTransValue);
		if ($user_type != 2) {
			$where['created_by'] = $this->session->userdata('user_id');
		}
		$branch_id = $this->session->userdata('branch_id');
		$resultObject = $this->Master_Model->_select('upload_intra_company_transfer', $where, array("*", "(select bm.name from branch_master bm where bm.id=from_branch_id) as from_branch", "(select bm.name from branch_master bm where bm.id=to_branch_id) as to_branch",
			"(select bs.name from main_account_setup_master bs where bs.main_gl_number=from_gl_account and bs.company_id=".$company_id.") as from_detail",
			"(select bs.name from main_account_setup_master bs where bs.main_gl_number=difference_gl and bs.company_id=".$company_id.") as difference_details",
			"(select bs.name from main_account_setup_master bs where bs.main_gl_number=to_gl_account and bs.company_id=".$company_id.") as to_detail", "(select bmm.name from branch_master bmm where bmm.id='" . $branch_id . "') as my_branch"), false);
		$response['query'] = $resultObject->last_query;
//		echo '<pre>';
//		print_r($resultObject);exit();
		if ($resultObject->totalCount > 0) {
			$i = 2;
			$indt=1;
			foreach ($resultObject->data as $item) {
				$fromcurr=$item->from_currency_rate;
				if($fromcurr=="" || $fromcurr=="null" || $fromcurr==null)
				{
					$fromcurr=1;
				}
				$trasfeCurrTvalue=($item->to_totalValue/$fromcurr);
				$objWorkSheet->SetCellValue('A' . $i, $indt);
				$objWorkSheet->SetCellValue('B' . $i, 'From - '.$item->from_branch);
				$objWorkSheet->SetCellValue('C' . $i, $item->from_gl_account.'-'.$item->from_detail);
				$objWorkSheet->SetCellValue('D' . $i, round($item->from_debit,2));
				$objWorkSheet->SetCellValue('E' . $i, round($item->from_credit,2));
				$objWorkSheet->SetCellValue('F' . $i, $item->from_given_by);
				$objWorkSheet->SetCellValue('G' . $i, $item->from_currency);
				$objWorkSheet->SetCellValue('H' . $i, $item->from_currency_rate);
				$objWorkSheet->SetCellValue('I' . $i, round($item->from_totalValue,2));
				$objWorkSheet->SetCellValue('J' . $i, '');
				$i=$i+1;
				$objWorkSheet->SetCellValue('A' . $i, '');
				$objWorkSheet->SetCellValue('B' . $i, 'To - '.$item->to_branch);
				$objWorkSheet->SetCellValue('C' . $i, $item->to_gl_account.'-'.$item->to_detail);
				$objWorkSheet->SetCellValue('D' . $i, round($item->to_debit,2));
				$objWorkSheet->SetCellValue('E' . $i, round($item->to_credit,2));
				$objWorkSheet->SetCellValue('F' . $i, $item->to_given_by);
				$objWorkSheet->SetCellValue('G' . $i, $item->to_currency);
				$objWorkSheet->SetCellValue('H' . $i, $item->to_currency_rate);
				$objWorkSheet->SetCellValue('I' . $i, round($item->to_totalValue,2));
				$objWorkSheet->SetCellValue('J' . $i, round($trasfeCurrTvalue,2));
				$i=$i+1;
				$objWorkSheet->SetCellValue('A' . $i, '');
				$objWorkSheet->SetCellValue('B' . $i, 'Difference - ');
				$objWorkSheet->SetCellValue('C' . $i, $item->difference_gl.'-'.$item->difference_details);
				$objWorkSheet->SetCellValue('D' . $i, round($item->final_value,2));
				$objWorkSheet->SetCellValue('E' . $i, '');
				$objWorkSheet->SetCellValue('F' . $i, '');
				$objWorkSheet->SetCellValue('G' . $i, '');
				$objWorkSheet->SetCellValue('H' . $i, '');
				$objWorkSheet->SetCellValue('I' . $i, round($item->final_value,2));
				$objWorkSheet->SetCellValue('J' . $i, '');
				$i++;
				$indt++;
			}
		}

//		$objPHPExcel->removeSheetByIndex($sheetCount);
		ob_end_clean();

		$filename = $templateName.'_'. date("Y-m-d") . ".xls";
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
