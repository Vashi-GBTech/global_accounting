<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 * @property  Master_Model Master_Model
 */
class ConsolidateReport extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}


	public function index()
	{
		$this->load->view("Report/consolidate_balance_sheet", array("title" => "Balance Sheet Report"));
	}


	public function view_consolidate_report()
	{
		$this->load->view("Report/view_report", array("title" => "Balance Sheet Report"));
	}


	public function previousConsolidate()
	{
		$this->load->view("Report/upload_previous_report", array("title" => "Previous Consolidate Upload"));
	}

	public function view_bs()
	{
		$year = $this->input->get('year');
		$month = $this->input->get('month');
		$country_master = $this->Master_Model->getQuarter();
		$this->load->view("Report/view_html", array("title" => "Consolidate Report", 'year' => $year, 'quarter' => $month, 'month' => $country_master[$month]));
	}

	public function create_balanceSheet()
	{
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		$country_master = $this->Master_Model->getQuarter();
		$month_name = $country_master[$month];
		$company_id = $this->session->userdata('company_id');

		$type = $this->input->post('type');
		$table = 'main_account_setup_master';
		$table2 = 'consolidate_report_transaction';
		if ($type == 2) {
			$table = 'main_account_setup_master_us';
			$table2 = 'consolidate_report_transaction_us';
		}
		if ($type == 3) {
			$table = 'main_account_setup_master_ifrs';
			$table2 = 'consolidate_report_transaction_ifrs';
		}
		$company_ = $this->Master_Model->get_row_data(array('name'), array('id' => $company_id), 'company_master');
		$company_name = $company_->name;
		$data_array = array();
		$balance_div = "";
		$type_data = $this->Master_Model->_rawQuery('SELECT * FROM ' . $table . ' where company_id ="' . $company_id . '" and type0 = "BS" ')->data;
		if (count($type_data) > 0) {
			foreach ($type_data as $type) {
				$data_array[$type->type1][$type->type2][$type->type3][] = $type;
			}
		}

		$balance_div .= '<div class="row company_details">'
			. '<div class="col-md-12">'
			. '<h4 style="margin-bottom: 10px;">' . $company_name . '</h4>'
			. '<h4>Consolidate Report of ' . $month_name . ' ' . $year . '</h4>'
			. '</div>'
			. '</div>'
			. '<table class="table printtable">';
		foreach ($data_array as $key => $value) {
			$grand_total = 0;
			$balance_div .= '<tr>'
				. '<th class="type1" style="font-weight: bolder;font-size: 22px;">' . $key . '</th>'
				. '<th></th>'
				. '</tr>';
			foreach ($value as $k2 => $v2) {
				$grand_total1 = 0;
				$balance_div .= '<tr>'
					. '<td style="font-weight: bold;font-size: 18px;padding-left: 53px;">' . $k2 . '</td>'
					. '<td></td>'
					. '</tr>';
				foreach ($v2 as $k3 => $v3) {
					$mArray = array();
					foreach ($v3 as $mgl_no) {
						array_push($mArray, $mgl_no->main_gl_number);
					}
					$balance_div .= '<tr>'
						. '<td style="padding-left: 100px">' . $k3 . '</td>'
						. '<td class="text-right">';
					$total = $this->db->select('sum(total) as final_total')->where(array('company_id' => $company_id, 'year' => $year, 'month' => $month))->where_in('account_number', $mArray)->from($table2)->get()->row();
					$total->final_total = isset($total->final_total) ? $total->final_total : 0;
					if ($key == "EQUITY AND LIABILITIES") {
						$finalTotal = $total->final_total >= 0 ? $total->final_total : abs($total->final_total);
					} else {
						$finalTotal = $total->final_total;
					}
					$grand_total1 += $finalTotal;
					$balance_div .= '' . number_format($finalTotal) . '</td>'
						. '</tr>';
				}
				$balance_div .= '<tr>'
					. '<td style="padding-left: 100px;">Total</td>'
					. '<td class="text-right">' . number_format($grand_total1) . '';
				$grand_total += (double)$grand_total1;
				$balance_div .= '</td>'
					. '</tr>';
			}
			$balance_div .= '<tr>'
				. '<td style="font-weight: bold;">Total</td>'
				. '<td class="text-right">' . number_format((double)$grand_total) . '</td>'
				. '</tr>';
		}
		$balance_div .= '</table>'
			. '<div class="row footer">'
			. '</div>';

		if ($balance_div != null) {
			$response['status'] = 200;
			$response['data'] = $balance_div;
		} else {
			$response['status'] = 201;
			$response['body'] = 'No Data Found';
		}
		echo json_encode($response);
	}

	public function createpl()
	{
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		$company_id = $this->session->userdata('company_id');
		$country_master = $this->Master_Model->getQuarter();
		$month_name = $country_master[$month];

		$type = $this->input->post('type');
		$table = 'main_account_setup_master';
		$table2 = 'consolidate_report_transaction';
		if ($type == 2) {
			$table = 'main_account_setup_master_us';
			$table2 = 'consolidate_report_transaction_us';
		}
		if ($type == 3) {
			$table = 'main_account_setup_master_ifrs';
			$table2 = 'consolidate_report_transaction_ifrs';
		}

		$company_ = $this->Master_Model->get_row_data(array('name'), array('id' => $company_id), 'company_master');
		$company_name = $company_->name;
		$data_array = array();
		$PLData = "";
		$type_data = $this->Master_Model->_rawQuery('SELECT * FROM ' . $table . ' where company_id ="' . $company_id . '" and type0 = "PL" ')->data;
		if (count($type_data) > 0) {
			foreach ($type_data as $type) {
				$data_array[$type->type1][$type->type2][$type->name] = $type;
			}
		}

		$PLData .= '<div class="row company_details">'
			. '<div class="col-md-12">'
			. '<h4 style="margin-bottom: 10px;">' . $company_name . '</h4>'
			. '<h4>Consolidate Report of ' . $month_name . ' ' . $year . '</h4>'
			. '</div>'
			. '</div>'
			. '<table class="table print_table">';
		foreach ($data_array as $key => $value) {
			$grand_total = 0;
			$PLData .= '<tr>'
				. '<th style="font-weight: bolder;font-size: 22px">' . $key . '</th>'
				. '<th></th>'
				. '</tr>';
			foreach ($value as $k2 => $v2) {
				$grand_total1 = 0;
				$PLData .= '<tr><td style="font-weight: bold;font-size: 18px;padding-left: 53px;">' . $k2 . '</td>'
					. '<td></td></tr>';
				foreach ($v2 as $k3 => $v3) {
					$PLData .= '<tr><td style="padding-left: 100px">' . $k3 . ''
						. '</td>'
						. '<td>';
					$total = $this->db->select_sum('final_total')
						->where(array('company_id' => $company_id, 'year' => $year, 'month' => $month, 'account_number' => $v3->main_gl_number))
						->from($table2)
						->get()->row();
					$grand_total1 += isset($total->final_total) ? $total->final_total : 0;
					$PLData .= '' . isset($total->final_total) ? $total->final_total : 0 . '</td></tr>';
				}
				$PLData .= '<tr><td style="padding-left: 100px;">Total</td><td><?php echo $grand_total1; $grand_total += $grand_total1;?></td></tr>';
			}
			$PLData .= '<tr><td style="font-weight: bold;">Total</td><td>' . $grand_total . '</td></tr>';
		}
		$PLData .= '</table>'
			. '<div class="row footer">'
			. '</div>';

		if ($PLData != null) {
			$response['status'] = 200;
			$response['data'] = $PLData;
		} else {
			$response['status'] = 201;
			$response['body'] = 'No Data Found';
		}
		echo json_encode($response);
	}

	public function view_pl()
	{
		$year = $this->input->get('year');
		$month = $this->input->get('month');
		$company_id = $this->session->userdata('company_id');
		$country_master = $this->Master_Model->getQuarter();

		$this->load->view("Report/view_pl", array("title" => "Consolidate Report", 'year' => $year, 'quarter' => $month, 'month' => $country_master[$month]));
	}


	function getReportList()
	{
		$company_id = $this->session->userdata('company_id');
		$mbData = $this->db
			->select(array("*"))
			->where('company_id', $company_id)
			->order_by('id', 'desc')
			->group_by(array('year', 'month'))
			->get("consolidate_report_transaction")->result();
		$tableRows = array();
		if (count($mbData) > 0) {
			$i = 1;
			foreach ($mbData as $order) {
				$country_master = $this->Master_Model->getQuarter();
				if ($order->month != "" && $order->month != NULL && $order->month != 0) {
					array_push($tableRows, array($i, $order->year, $country_master[$order->month], $order->id, $order->month));
				}
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

	public function update_report()
	{
		$year = $this->input->get('year');
		$month = $this->input->get('month');
		$country_master = $this->Master_Model->getQuarter();
		$this->load->view("Report/update_report", array("title" => "Balance Sheet Report", 'year' => $year, 'month' => $country_master[$month]));
	}


	public function getTotalData1()
	{
		$company_id = $this->session->userdata("company_id");
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		$update = $this->input->post('update');
		$country_master = $this->Master_Model->getQuarter();

		$checkConsolidate = $this->Master_Model->get_all_data(array('year' => $year, 'month' => $month, "company_id" => $company_id), "consolidate_report_transaction");

		if (count($checkConsolidate) > 0 && $update != true) {
			$response["status"] = 201;
			$response['message'] = "Data Already Consolidated";
			$response["data"] = 0;
		} else {

//			$getMainAccount = $this->Master_Model->_select('main_account_setup_master',
//				array('company_id' => $company_id), array('*'), false)->data;

			$q = "SELECT *,1 as type FROM main_account_setup_master where company_id=" . $company_id . " union  SELECT *,2 as type FROM main_account_setup_master_us where company_id=" . $company_id . " union SELECT *,3 as type FROM main_account_setup_master_ifrs where company_id=" . $company_id;
			$query = $this->Master_Model->_rawQuery($q, true, 0)->data;
			$array_ind = array();
			$array_us = array();
			$array_ifrs = array();
			foreach ($query as $row) {
				if ($row['type'] == 1) {
					$array_ind[] = $row;
				} elseif ($row['type'] == 2) {
					$array_us[] = $row;
				} else {
					$array_ifrs[] = $row;
				}
			}


			$branchData = $this->Master_Model->
			_select("branch_master", array("company_id" => $company_id, "status" => 1), array("start_with", "id"), false)->data;
			$getTotalData = array();
			$response['branchData'] = $branchData;
			foreach ($branchData as $branchRow) {

				if ($branchRow->start_with == 1) {
					$getTotalData1 = $this->Master_Model
						->_rawQuery('select  total,gl_ac,branch_id,debit,credit,opening_balance from upload_financial_data where year = ? and quarter >= ? and company_id= ? and branch_id=? ',
							array($year, $branchRow->start_with, $company_id, $branchRow->id))->data;

				} else {
					if ($month >= $branchRow->start_with) {
						$getTotalData1 = $this->Master_Model
							->_rawQuery('select  total,gl_ac,branch_id,debit,credit,opening_balance from upload_financial_data

where ((year = ? and quarter >= ?) or (year=? and quarter <= ?)) and company_id= ? and branch_id=?',
								array($year, $branchRow->start_with, ($year + 1), ($branchRow->start_with - 1), $company_id, $branchRow->id))->data;
					} else {
						$getTotalData1 = $this->Master_Model
							->_rawQuery('select  total,gl_ac,branch_id,debit,credit,opening_balance from upload_financial_data
where ((year = ? and quarter < ?) or (year=? and quarter >= ?)) and company_id= ? and branch_id=?',
								array($year, $branchRow->start_with, ($year - 1), ($branchRow->start_with), $company_id, $branchRow->id))->data;
					}

				}

				$getTotalData = array_merge($getTotalData, $getTotalData1);
			}

			$response['Query'] = $this->db->last_query();
			$response['rawData'] = $getTotalData;

//			$getBranchWithMainAccount = $this->Master_Model->_select('branch_account_setup',
//				array("find_in_set(parent_account_number,(select group_concat(main_gl_number) from main_account_setup_master where company_id =" . $company_id . " ))<>"=>0, "company_id" => $company_id),
//				array('trim(account_number) as account_number', 'parent_account_number', 'branch_id'), false)->data;


			$getBranchWithMainAccount = $this->Master_Model->_select('branch_account_setup',
				array("find_in_set(parent_account_number,(select group_concat(main_gl_number) from main_account_setup_master where company_id = " . $company_id . " ))<> 0 
				or find_in_set(parent_account_number_us,(select group_concat(main_gl_number) from main_account_setup_master_us where company_id = " . $company_id . " ))
				or find_in_set(parent_account_number_ifrs,(select group_concat(main_gl_number) from main_account_setup_master_ifrs where company_id = " . $company_id . " ))<>" => 0, "company_id" => $company_id),
				array('trim(account_number) as account_number', 'parent_account_number', 'parent_account_number_us', 'parent_details_ifrs', 'branch_id'), false)->data;


			$filterArray = array();
			$response['branchWith'] = $getBranchWithMainAccount;
			$branchAccount = $this->Master_Model->_select("branch_master b", array("company_id" => $this->session->userdata("company_id"), "status" => 1),
				array("id", "type", "name", "percentage", "currency", "(select rate from currency_conversion_master cc where month=" . $month . " AND year=" . $year . " AND company_id='" . $company_id . " '
					AND cc.currency=b.currency) as currency_rate", "(select closing_rate from currency_conversion_master cc where month=" . $month . " AND year=" . $year . " AND company_id='" . $company_id . " '
					AND cc.currency=b.currency) as closing_rate"), false)->data;

			$branchesCount = count($branchAccount);
			$branch_idscheck = "";

			foreach ($getTotalData as $records) {
//                foreach ($branchAccount as $branch) {
				foreach ($getBranchWithMainAccount as $account) {
					if ($records->gl_ac == $account->account_number && $account->branch_id == $records->branch_id) { // && $branch->id == $records->branch_id
						$filterArray[trim($account->parent_account_number)][$account->account_number][$records->branch_id][] = array(
							'total' => (double)$records->total,
							'debit' => (double)$records->debit,
							'credit' => (double)$records->credit,
							'ob' => (double)$records->opening_balance
						);
					}
				}
//                }
			}


			$transferQuery = $this->Master_Model->_select("upload_intra_company_transfer", array("company_id" => $company_id, "year" => $year, "quarter" => $month),
				array("from_branch_id", "from_gl_account", "to_branch_id", "to_gl_account", "amount", "from_debit", "to_credit",
					"(select parent_account_number from branch_account_setup bac where bac.account_number=from_gl_account AND bac.branch_id=from_branch_id ) as fromParent",
					"(select parent_account_number from branch_account_setup bac where bac.account_number=to_gl_account AND bac.branch_id=to_branch_id ) as ToParent"), false)->data;
//var_dump($transferQuery);
			$response['filter'] = $filterArray;
			$brachData = array();
			foreach ($branchAccount as $branch) {
				$brachData['id'] = $branch->name;
				$branch_idscheck .= $branch->id . ",";
			}
			$response['branchData'] = $brachData;

			$branch_idscheck = rtrim($branch_idscheck, ",");
			$getData = "select distinct branch_id from upload_financial_data where branch_id in(" . $branch_idscheck . ")";
			$branchDataCount = 0;
			$q = $this->db->query($getData)->result();
			if (count($q) > 0) {
				$branchDataCount = count($q);
			}

			$list = "";
			if ($branchesCount != $branchDataCount) {
				foreach ($brachData as $k => $b1) {
					if (!in_array($k, $q)) {
						$list .= $b1 . ",";
					}
				}
				$list = rtrim($list, ",");
				$response["status"] = 201;
				$response['message'] = "Data is not uploaded for following branches :" . $list;
				echo json_encode($response);
				exit;
			}
			$finalRecords_ind = array();
			$finalRecords_us = array();
			$finalRecords_ifrs = array();
			$otherdata = array();
			$headers = array();
			$hideColumn = array();
			$finalTotal = 5;
			$yearColumn = 7;
			$monthColumn = 8;
			$branch_id = 9;
			$name = 0;
			$b = 1;
			$type1 = 1;
			$type2 = 2;
			$type3 = 3;
			$gl = 4;
			foreach ($branchAccount as $branch) {

				$c = $branch->name;
				$headers = array_merge($headers, array("Name", "Type1", "Type2", "Type3", "GL Account Number", "total", $c, "year", "month", "branch_id"));
				if ($b == 1) {
					$hideColumn = array_merge($hideColumn, array($yearColumn, $monthColumn, $branch_id));
					$b++;
				} else {
					$finalTotal = $finalTotal + 10;
					$name = $name + 10;
					$type1 = $type1 + 10;
					$type2 = $type2 + 10;
					$type3 = $type3 + 10;
					$gl = $gl + 10;
					$hideColumn = array_merge($hideColumn, array($finalTotal, $yearColumn, $monthColumn, $branch_id, $name, $type1, $type2, $type3, $gl));
				}

				$yearColumn = 7 + $yearColumn + 3;
				$monthColumn = $yearColumn + 1;
				$branch_id = $yearColumn + 2;


				foreach ($array_ind as $parent) {
					if (array_key_exists($parent['main_gl_number'], $filterArray)) {
						$allChildRecords = array();
						$allChildRecords_debit = array();
						$allChildRecords_credit = array();
						$allChildRecords_ob = array();
						foreach ($filterArray[$parent['main_gl_number']] as $childRecords) {
							if (array_key_exists($branch->id, $childRecords)) {
								foreach ($childRecords as $key => $records) {
									if ($key == $branch->id) {
										foreach ($records as $branchRecords) {
											array_push($allChildRecords, $branchRecords['total']);
											array_push($allChildRecords_debit, $branchRecords['debit']);
											array_push($allChildRecords_credit, $branchRecords['credit']);
											array_push($allChildRecords_ob, $branchRecords['ob']);
										}
									}

								}
							}
						}

						$isIgnore = false;
						$final_value = 0;
						if ($parent['calculation_method'] == 'Addition') {
							$percentage = $branch->percentage;
							$final_value = array_sum($allChildRecords);
//    $final_value = (array_sum($allChildRecords) * $percentage)/100;
							$response['actucalTotal'][$parent['name']][] = $final_value;
						} else if ($parent['calculation_method'] == 'Calculated') {
							$percentage = $branch->percentage;
							$final_value = (array_sum($allChildRecords) * $percentage) / 100;
							$response['actucalTotal'][$parent['name']][$percentage] = $final_value;
						} else if ($parent['calculation_method'] == 'Parent') {
							if ($branch->type == 'parent') {
								$final_value = array_sum($allChildRecords);
							} else {
								$final_value = 0;
							}
						} else {
							$final_value = 0;
							$isIgnore = true;
						}
						if ($branch->currency == "INR") {
							$final_value = $final_value;
						} else {
							if (is_null($branch->currency_rate) && empty($branch->currency_rate)) {
								$response['status'] = 201;
								$response['message'] = "Currency Conversion Pending for " . $branch->currency;
								echo json_encode($response);
								exit;
							} else {

								if ($parent['type0'] == 'PL') {

									$final_value = $final_value * $branch->currency_rate;
								} else if ($parent['type0'] == 'BS' && $parent['monitory'] == 'Yes') {

									$final_value = $final_value * $branch->closing_rate;
								} else {

									$final_value = $final_value * $branch->currency_rate;
								}

							}

						}
						foreach ($transferQuery as $t_data) {

							if ($t_data->from_branch_id == $branch->id && $t_data->fromParent == $parent['main_gl_number']) {
								$final_value = $final_value + ($t_data->from_debit - $t_data->from_debit);
							}
							/*if ($t_data->to_branch_id == $branch->id && $t_data->ToParent == $parent->main_gl_number) {
								$final_value = $final_value + $t_data->to_credit;
							}*/
						}

						$debit = array_sum($allChildRecords_debit);
						$credit = array_sum($allChildRecords_credit);
						$ob = array_sum($allChildRecords_ob);
						if (!$isIgnore) {
							$other_data = array(
								'parent' => $parent['main_gl_number'],
								'debit' => $debit,
								'credit' => $credit,
								'total' => $final_value,
								'opening_balance' => $ob
							);
							array_push($otherdata, $other_data);

							$data = array(
								'name' => $parent['name'],
								'type1' => $parent['type1'],
								'type2' => $parent['type2'],
								'type3' => $parent['type3'],
								'parent' => $parent['main_gl_number'],
								'finalTotal' => 0,
								'total' => round($final_value, 2),
								'year' => $year,
								'month' => $country_master[$month],
								'branch_id' => $branch->id,
							);
							$finalRecords_ind[$branch->id][] = $data;
						}
					} else {
						if ($parent['calculation_method'] != "Ignore") {
							$data = array(
								'name' => $parent['name'],
								'type1' => $parent['type1'],
								'type2' => $parent['type2'],
								'type3' => $parent['type3'],
								'parent' => $parent['main_gl_number'],
								'finalTotal' => 0,
								'total' => 0,
								'year' => $year,
								'month' => $country_master[$month],
								'branch_id' => $branch->id
							);
							$finalRecords_ind[$branch->id][] = $data;
						}
					}
				}

				foreach ($array_us as $parent) {
					if (array_key_exists($parent['main_gl_number'], $filterArray)) {
						$allChildRecords = array();
						$allChildRecords_debit = array();
						$allChildRecords_credit = array();
						$allChildRecords_ob = array();
						foreach ($filterArray[$parent['main_gl_number']] as $childRecords) {
							if (array_key_exists($branch->id, $childRecords)) {
								foreach ($childRecords as $key => $records) {
									if ($key == $branch->id) {
										foreach ($records as $branchRecords) {
											array_push($allChildRecords, $branchRecords['total']);
											array_push($allChildRecords_debit, $branchRecords['debit']);
											array_push($allChildRecords_credit, $branchRecords['credit']);
											array_push($allChildRecords_ob, $branchRecords['ob']);
										}
									}

								}
							}
						}


						$isIgnore = false;
						$final_value = 0;
						if ($parent['calculation_method'] == 'Addition') {
							$percentage = $branch->percentage;
							$final_value = array_sum($allChildRecords);
//    $final_value = (array_sum($allChildRecords) * $percentage)/100;
							$response['actucalTotal'][$parent['name']][] = $final_value;
						} else if ($parent['calculation_method'] == 'Calculated') {
							$percentage = $branch->percentage;
							$final_value = (array_sum($allChildRecords) * $percentage) / 100;
							$response['actucalTotal'][$parent['name']][$percentage] = $final_value;
						} else if ($parent['calculation_method'] == 'Parent') {
							if ($branch->type == 'parent') {
								$final_value = array_sum($allChildRecords);
							} else {
								$final_value = 0;
							}
						} else {
							$final_value = 0;
							$isIgnore = true;
						}
						if ($branch->currency == "INR") {
							$final_value = $final_value;
						} else {
							if (is_null($branch->currency_rate) && empty($branch->currency_rate)) {
								$response['status'] = 201;
								$response['message'] = "Currency Conversion Pending for " . $branch->currency;
								echo json_encode($response);
								exit;
							} else {

								if ($parent['type0'] == 'PL') {

									$final_value = $final_value * $branch->currency_rate;
								} else if ($parent['type0'] == 'BS' && $parent['monitory'] == 'Yes') {

									$final_value = $final_value * $branch->closing_rate;
								} else {

									$final_value = $final_value * $branch->currency_rate;
								}

							}

						}
						foreach ($transferQuery as $t_data) {

							if ($t_data->from_branch_id == $branch->id && $t_data->fromParent == $parent['main_gl_number']) {
								$final_value = $final_value + ($t_data->from_debit - $t_data->from_debit);
							}
							/*if ($t_data->to_branch_id == $branch->id && $t_data->ToParent == $parent->main_gl_number) {
								$final_value = $final_value + $t_data->to_credit;
							}*/
						}
						if (!$isIgnore) {
							$other_data = array(
								'parent' => $parent['main_gl_number'],
								'debit' => $debit,
								'credit' => $credit,
								'total' => $final_value,
								'opening_balance' => $ob
							);
							array_push($otherdata, $other_data);

							$data = array(
								'name' => $parent['name'],
								'type1' => $parent['type1'],
								'type2' => $parent['type2'],
								'type3' => $parent['type3'],
								'parent' => $parent['main_gl_number'],
								'finalTotal' => 0,
								'total' => round($final_value, 2),
								'year' => $year,
								'month' => $country_master[$month],
								'branch_id' => $branch->id
							);
							$finalRecords_us[$branch->id][] = $data;
						}
					} else {
						if ($parent['calculation_method'] != "Ignore") {
							$data = array(
								'name' => $parent['name'],
								'type1' => $parent['type1'],
								'type2' => $parent['type2'],
								'type3' => $parent['type3'],
								'parent' => $parent['main_gl_number'],
								'finalTotal' => 0,
								'total' => 0,
								'year' => $year,
								'month' => $country_master[$month],
								'branch_id' => $branch->id
							);
							$finalRecords_us[$branch->id][] = $data;
						}
					}
				}

				foreach ($array_ifrs as $parent) {
					if (array_key_exists($parent['main_gl_number'], $filterArray)) {
						$allChildRecords = array();
						$allChildRecords_debit = array();
						$allChildRecords_credit = array();
						$allChildRecords_ob = array();
						foreach ($filterArray[$parent['main_gl_number']] as $childRecords) {
							if (array_key_exists($branch->id, $childRecords)) {
								foreach ($childRecords as $key => $records) {
									if ($key == $branch->id) {
										foreach ($records as $branchRecords) {
											array_push($allChildRecords, $branchRecords['total']);
											array_push($allChildRecords_debit, $branchRecords['debit']);
											array_push($allChildRecords_credit, $branchRecords['credit']);
											array_push($allChildRecords_ob, $branchRecords['ob']);
										}
									}

								}
							}
						}


						$isIgnore = false;
						$final_value = 0;
						if ($parent['calculation_method'] == 'Addition') {
							$percentage = $branch->percentage;
							$final_value = array_sum($allChildRecords);
//    $final_value = (array_sum($allChildRecords) * $percentage)/100;
							$response['actucalTotal'][$parent['name']][] = $final_value;
						} else if ($parent['calculation_method'] == 'Calculated') {
							$percentage = $branch->percentage;
							$final_value = (array_sum($allChildRecords) * $percentage) / 100;
							$response['actucalTotal'][$parent['name']][$percentage] = $final_value;
						} else if ($parent['calculation_method'] == 'Parent') {
							if ($branch->type == 'parent') {
								$final_value = array_sum($allChildRecords);
							} else {
								$final_value = 0;
							}
						} else {
							$final_value = 0;
							$isIgnore = true;
						}
						if ($branch->currency == "INR") {
							$final_value = $final_value;
						} else {
							if (is_null($branch->currency_rate) && empty($branch->currency_rate)) {
								$response['status'] = 201;
								$response['message'] = "Currency Conversion Pending for " . $branch->currency;
								echo json_encode($response);
								exit;
							} else {

								if ($parent['type0'] == 'PL') {

									$final_value = $final_value * $branch->currency_rate;
								} else if ($parent['type0'] == 'BS' && $parent['monitory'] == 'Yes') {

									$final_value = $final_value * $branch->closing_rate;
								} else {

									$final_value = $final_value * $branch->currency_rate;
								}

							}

						}
						foreach ($transferQuery as $t_data) {

							if ($t_data->from_branch_id == $branch->id && $t_data->fromParent == $parent['main_gl_number']) {
								$final_value = $final_value + ($t_data->from_debit - $t_data->from_debit);
							}
							/*if ($t_data->to_branch_id == $branch->id && $t_data->ToParent == $parent->main_gl_number) {
								$final_value = $final_value + $t_data->to_credit;
							}*/
						}
						if (!$isIgnore) {
							$other_data = array(
								'parent' => $parent['main_gl_number'],
								'debit' => $debit,
								'credit' => $credit,
								'total' => $final_value,
								'opening_balance' => $ob
							);
							array_push($otherdata, $other_data);
							$data = array(
								'name' => $parent['name'],
								'type1' => $parent['type1'],
								'type2' => $parent['type2'],
								'type3' => $parent['type3'],
								'parent' => $parent['main_gl_number'],
								'finalTotal' => 0,
								'total' => round($final_value, 2),
								'year' => $year,
								'month' => $country_master[$month],
								'branch_id' => $branch->id
							);
							$finalRecords_ifrs[$branch->id][] = $data;
						}
					} else {
						if ($parent['calculation_method'] != "Ignore") {
							$data = array(
								'name' => $parent['name'],
								'type1' => $parent['type1'],
								'type2' => $parent['type2'],
								'type3' => $parent['type3'],
								'parent' => $parent['main_gl_number'],
								'finalTotal' => 0,
								'total' => 0,
								'year' => $year,
								'month' => $country_master[$month],
								'branch_id' => $branch->id
							);
							$finalRecords_ifrs[$branch->id][] = $data;
						}
					}
				}
			}

			$newFinalRarray_ind = array();
			$newFinalRarray_us = array();
			$newFinalRarray_ifrs = array();
			$store_india = array();
			$store_us = array();
			$store_ifrs = array();
			if (count($finalRecords_ind) > 0) {
				foreach ($finalRecords_ind as $key1 => $record) {
					$currentKey = -1;
					foreach ($record as $key => $r1) {
						$ind_data = array(
							"account_number" => $r1['parent'],
							"month" => $month,
							"year" => $year,
							"company_id" => $company_id,
							"branch_id" => $r1['branch_id'],
							"final_total" => $r1['finalTotal'],
							"total" => $r1['total'],
							"particulars" => $r1['name'],
							"create_by" =>  $this->session->userdata("user_id")
						);
						array_push($store_india, $ind_data);
						$currentKey = $key;
						if (array_key_exists($key, $newFinalRarray_ind)) {
							$total = $newFinalRarray_ind[$key][5] + $r1["total"];

							$newFinalRarray_ind[$key] = array_merge($newFinalRarray_ind[$key], array_values($r1));
							$newFinalRarray_ind[$key][5] = round($total, 2);
						} else {
							$total = 0 + $r1["total"];
							$newFinalRarray_ind[$key] = array_values($r1);
							$newFinalRarray_ind[$key][5] = round($total, 2);
						}
					}
				}
			}

			if (count($finalRecords_us) > 0) {
				foreach ($finalRecords_us as $key1 => $record) {
					$currentKey = -1;
					foreach ($record as $key => $r1) {

						$us_data = array(
							"account_number" => $r1['parent'],
							"month" => $month,
							"year" => $year,
							"company_id" => $company_id,
							"branch_id" => $r1['branch_id'],
							"final_total" => $r1['finalTotal'],
							"total" => $r1['total'],
							"particulars" => $r1['name'],
							"create_by" =>  $this->session->userdata("user_id")
						);
						array_push($store_us, $us_data);


						$currentKey = $key;
						if (array_key_exists($key, $newFinalRarray_us)) {
							$total = $newFinalRarray_us[$key][5] + $r1["total"];

							$newFinalRarray_us[$key] = array_merge($newFinalRarray_us[$key], array_values($r1));
							$newFinalRarray_us[$key][5] = round($total, 2);
						} else {
							$total = 0 + $r1["total"];
							$newFinalRarray_us[$key] = array_values($r1);
							$newFinalRarray_us[$key][5] = round($total, 2);
						}
					}
				}
			}

			if (count($finalRecords_ifrs) > 0) {
				foreach ($finalRecords_ifrs as $key1 => $record) {
					$currentKey = -1;
					foreach ($record as $key => $r1) {

						$ifrs_data = array(
							"account_number" => $r1['parent'],
							"month" => $month,
							"year" => $year,
							"company_id" => $company_id,
							"branch_id" => $r1['branch_id'],
							"final_total" => $r1['finalTotal'],
							"total" => $r1['total'],
							"particulars" => $r1['name'],
							"create_by" =>  $this->session->userdata("user_id")
						);
						array_push($store_ifrs, $ifrs_data);


						$currentKey = $key;
						if (array_key_exists($key, $newFinalRarray_ifrs)) {
							$total = $newFinalRarray_ifrs[$key][5] + $r1["total"];

							$newFinalRarray_ifrs[$key] = array_merge($newFinalRarray_ifrs[$key], array_values($r1));
							$newFinalRarray_ifrs[$key][5] = round($total, 2);
						} else {
							$total = 0 + $r1["total"];
							$newFinalRarray_ifrs[$key] = array_values($r1);
							$newFinalRarray_ifrs[$key][5] = round($total, 2);
						}
					}
				}
			}

			if (count($store_india) > 0 || count($store_us) > 0 || count($store_ifrs) > 0) {

				try {
					$this->db->trans_start();
					if (count($store_india) > 0) {
						$this->db->delete("consolidate_report_transaction", array("month" => $month, "year" => $year, "company_id" => $company_id));
						$this->db->insert_batch("consolidate_report_transaction", $store_india);
					}
					if (count($store_us) > 0) {
						$this->db->delete("consolidate_report_transaction_us", array("month" => $month, "year" => $year, "company_id" => $company_id));
						$this->db->insert_batch("consolidate_report_transaction_us", $store_us);
					}
					if (count($store_ifrs) > 0) {
						$this->db->delete("consolidate_report_transaction_ifrs", array("month" => $month, "year" => $year, "company_id" => $company_id));
						$this->db->insert_batch("consolidate_report_transaction_ifrs", $store_ifrs);
					}
					if ($this->db->trans_status() === FALSE) {
						$this->db->trans_rollback();
						log_message('info', "insert user Transaction Rollback");
						$result = FALSE;
					} else {
						$this->db->trans_commit();
						log_message('info', "insert user Transaction Commited");
						$result = TRUE;
					}
					$this->db->trans_complete();
				} catch (Exception $exc) {
					log_message('error', $exc->getMessage());
					$result = FALSE;
				}
			}
			$data_1 = array();
			if (count($otherdata) > 0) {
				foreach ($otherdata as $otherdata) {
					$data_1[$otherdata['parent']][] = array($otherdata['credit'], $otherdata['debit'], $otherdata['opening_balance'], $otherdata['total']);

				}

				$final_array = array();
				foreach ($data_1 as $key => $other) {
					$credit = 0;
					$debit = 0;
					$ob = 0;
					$total = 0;
					foreach ($other as $i) {
						$credit += $i[0];
						$debit += $i[1];
						$ob += $i[2];
						$total += $i[3];
					}
					$data = array(
						"account_number" => $key,
						"month" => $month,
						"year" => $year,
						"company_id" => $company_id,
						"final_total" => $total,
						"total" => $total,
						"debit" => $debit,
						"credit" => $credit,
						"opening_balance" => $ob,
						"create_by" =>  $this->session->userdata("user_id"),
					);
					array_push($final_array, $data);
				}
				$insert_report_data = $this->db->insert_batch('consolidate_report_all_data_ind', $final_array);
			}

//		var_dump($data_1);

			$response['India_finalRecords'] = $finalRecords_ind;
			$response['US_finalRecords'] = $finalRecords_us;
			$response['IFRS_finalRecords'] = $finalRecords_ifrs;
			$response['headers'] = $headers;
			$response['hideColumn'] = $hideColumn;
			$response['status'] = 200;
			$response['data'] = $newFinalRarray_ind;
			$response['data_us'] = $newFinalRarray_us;
			$response['data_ifrs'] = $newFinalRarray_ifrs;
			$response['other'] = $otherdata;

		}
		echo json_encode($response);
	}

	public function getPreviousDataArray($getTotalDataPrev)
	{
		$AllDataArrayPrev = array();

		if (count($getTotalDataPrev) > 0) {
			foreach ($getTotalDataPrev as $item_1) {

				if($item_1 != false){
					foreach ($item_1 as $item) {
						if ($item->account_number != null) {
							$exp=array();
							if(!is_null($item->currencyRate))
							{
								$exp = explode("||", $item->currencyRate); // 0=movingRate 1=ClosingRate
							}
							$exp1 = explode("||", $item->monitory_type1); // 0=monitory 1=type1
							if (array_key_exists(0, $exp1)) {
								$monitory = $exp1[0];
							} else {
								$monitory = "";
							}
							if (array_key_exists(1, $exp1)) {
								$type1 = $exp1[1];
							} else {
								$type1 = "";
							}
							if(!is_null($item->currencyRate)) {
								if (array_key_exists(0, $exp)) {
									$movingRate = $exp[0];
								} else {
									$movingRate = 0;
								}
								if (array_key_exists(1, $exp)) {
									$ClosingRate = $exp[1];
								} else {
									$ClosingRate = 0;
								}
							}
							else{
								$movingRate = 0;
								$ClosingRate = 0;
							}

							$AllDataArrayPrev[$item->account_number][$item->branch_id] =
								array($item->debit, $item->credit, $item->total, $item->opening_balance, $item->StartMonth, $item->SelectedMonth, $monitory, $movingRate, $ClosingRate, $item->total_2, $type1);

						}
					}
				}

			}

			return array($AllDataArrayPrev);
		} else {
			return false;
		}
	}

	public function getDataIntraCompanyTransfer($month, $year)
	{
		$company_id = $this->session->userdata("company_id");
		$checkConsolidateFrom = $this->Master_Model->_rawQuery("select sum(cur_from_credit) as credit,sum(cur_from_debit) as debit,1 as type ,from_gl_account as gl_ac,from_branch_id as branch_id
 from upload_intra_company_transfer u where company_id=" . $company_id . " and quarter=" . $month . " and year=" . $year . " group by from_branch_id,to_gl_account
 UNION
 select sum(cur_to_credit) as credit,sum(cur_to_debit) as debit,2 as type,to_gl_account as gl_ac,to_branch_id as branch_id
 from upload_intra_company_transfer u where company_id=" . $company_id . " and quarter=" . $month . " and year=" . $year . " group by to_branch_id,to_gl_account");
		$fromarrayData = array();
		$toarrayData = array();
		if (($checkConsolidateFrom->totalCount) > 0) {
			foreach ($checkConsolidateFrom->data as $row) {
				if ($row->type == 1) {
					$fromarrayData[$row->gl_ac][$row->branch_id] = array($row->debit, $row->credit);
				} else {
					$toarrayData[$row->gl_ac][$row->branch_id] = array($row->debit, $row->credit);
				}
			}
		}
		return array($fromarrayData, $toarrayData);
	}

	function getPreviousData1($month,$year,$branch_id,$startMonth,$monthArray,$cnt,$country){
		/*if($branch_id == 69){
			//echo $month ."-".$year ."<br>";
		}*/
		//$countAll=count($monthArray);
		$company_id = $this->session->userdata("company_id");
		$getTotalData2 = $this->Master_Model
			->_rawQuery('select account_number,total_2,
(select group_concat(rate,"||",closing_rate) from currency_conversion_master c1 where c1.company_id=c.company_id AND c1.month=' . $month . ' AND c1.year=' . $year . ' AND c1.country=' . $country . ') as currencyRate
,(select group_concat((case when monitory = "Yes" then monitory else "" end),"||",(case when type1 is null then "" else type1 end)) from main_account_setup_master m where m.main_gl_number=c.account_number AND m.company_id = c.company_id limit 1) as monitory_type1,branch_id,opening_balance,debit,credit,total,' . $startMonth . ' as StartMonth ,' . $month . ' as SelectedMonth from consolidate_report_transaction c
where year = ? and month = ? and company_id= ? and branch_id=?',

				array((int)$year, (int)$month, $company_id, $branch_id), 1);
		if($getTotalData2->totalCount > 0){

			return $getTotalData2->data;
		}else{
			if($cnt > 10){
				return false;
			}else{

				if($month == 1){
					$year=$year-1;
				}
				$cnt=$cnt+1; //1
				$month=$monthArray[$cnt];
			return	 $this->getPreviousData($month,$year,$branch_id,$startMonth,$monthArray,$cnt,$country);
			}
		}
	}
	function getPreviousData($month,$year,$branch_id,$startMonth,$country){

		$company_id = $this->session->userdata("company_id");
		$getTotalData2 = $this->Master_Model
			->_rawQuery('select account_number,total_2,
(select group_concat((case when rate is null then 0 else rate end),"||",(case when closing_rate is null  then 0 else closing_rate end)) from currency_conversion_master c1 where c1.company_id=c.company_id AND c1.month=' . $month . ' AND c1.year=' . $year . ' AND c1.country=' . $country . ') as currencyRate
,(select group_concat((case when monitory = "Yes" then monitory else "" end),"||",(case when type1 is null then "" else type1 end)) from main_account_setup_master m where m.main_gl_number=c.account_number AND m.company_id = c.company_id limit 1) as monitory_type1,branch_id,opening_balance,debit,credit,total,' . $startMonth . ' as StartMonth ,' . $month . ' as SelectedMonth from consolidate_report_transaction c
where year = ? and month = ? and company_id= ? and branch_id=?',

				array((int)$year, (int)$month, $company_id, $branch_id), 1);
		if($getTotalData2->totalCount > 0){

			return $getTotalData2->data;
		}else{
			return false;
		}
	}
	//get Schedule Data
	function getScheduleDataOLD($branch_id,$month,$year){
	/*	$month=3;
		$branch_id=9;
		$year=2021;*/
		$company_id = $this->session->userdata("company_id");
		$query=$this->Master_Model->_rawQuery("select * from handson_rupees_conversion_table where branch_id=".$branch_id." and year=".$year." and month=".$month." and column_1 in (select column_1 from handson_prefill_table where branch_id=".$branch_id." and year=".$year." and month=".$month." and value_type='Manual'); ");
		$templateIDS=array();
		$arrayData=array();
		if($query->totalCount > 0){
			foreach ($query->data as $key=>$row){
				$templateIDS[]=$row->template_id;
				for($i=2;$i<=15;$i++){
					$colVal="column_".$i;
					$arrayData[$row->template_id][$colVal][]=$row->$colVal;
				}
			}
		}
		//var_dump($arrayData);
		$templateIDS=array_values(array_unique($templateIDS));
		$implodeArray=implode(",",$templateIDS);
		$columnArray=array();
		if(count($templateIDS) > 0){
			$query2=$this->Master_Model->_rawQuery("select column_value,gl_account,template_id from handson_template_column_master where gl_account != '' and template_id in (".$implodeArray.")");
			if($query2->totalCount > 0){
				foreach ($query2->data as $key=>$row1){
					$columnArray[$row1->gl_account][$row1->template_id][]=$row1->column_value;
				}
			}
			$sumGlAccountwise=array();
			if(count($columnArray) > 0){
				foreach ($columnArray as $keyGL=>$glAccount){
					foreach ($glAccount as $temp_id=>$tempData){
						foreach ($tempData as $colValue){
							if($colValue != 'column_1'){
								$sumGlAccountwise[$keyGL][]=array_sum($arrayData[$temp_id][$colValue]);
							}
						}
					}
				}
			}
			$finalAllGlAccountSum=array();

			if(count($sumGlAccountwise) > 0){
				foreach ($sumGlAccountwise as $gl=>$value){
					$finalAllGlAccountSum[$gl]=array_sum($value);
				}
			}
			return $finalAllGlAccountSum;
		}else{
			return false;
		}


	}

	function getScheduleData($branch_id,$month,$year){
		$company_id = $this->session->userdata("company_id");

		$query=$this->Master_Model->_rawQuery("select * from handson_rupees_conversion_table where branch_id=".$branch_id." and status=1 and year=".$year." and month=".$month." and column_1 in (select column_1 from handson_prefill_table where branch_id=".$branch_id." and year=".$year." and month=".$month.") order by id asc ");
		$arrayData=array();
		if($query->totalCount > 0){
			foreach ($query->data as $key=>$row){
				for($i=2;$i<=15;$i++){
					$colVal="column_".$i;
					if($row->$colVal == null || $row->$colVal==""){
						$row->$colVal=0;
					}
					$arrayData[$row->template_id][$colVal][]=$row->$colVal;
				}
			}
		}
		$queryoLD=$this->Master_Model->_rawQuery("select * from handson_transaction_table where branch_id=".$branch_id." and status=1 and year=".$year." and month=".$month." and column_1 in (select column_1 from handson_prefill_table where branch_id=".$branch_id." and year=".$year." and month=".$month.") order by id asc ");
		$arrayDataOld=array();
		if($queryoLD->totalCount > 0){
			foreach ($queryoLD->data as $rowo){
				for($i=2;$i<=15;$i++){
					$colVal="column_".$i;
					if($rowo->$colVal == null || $rowo->$colVal==""){
						$rowo->$colVal=0;
					}
					$arrayDataOld[$rowo->template_id][$colVal][]=$rowo->$colVal;
				}
			}
		}

		//getGl Accounts
		/*if($branch_id == 78){
			var_dump($arrayData);
		}*/




		$query2=$this->Master_Model->_rawQuery("select * from handson_gl_prefill_table where company_id=".$company_id);

		$arrayGLAccountData=array();
		if($query2->totalCount > 0){
			foreach ($query2->data as $key=>$row2){
				for($i=2;$i<=15;$i++){
					$colVal1="column_".$i;
					if($row2->$colVal1 == null || $row2->$colVal1==""){
						$v=0;
					}else{
						$exp=explode("-",$row2->$colVal1);
						$v=$exp[0];
					}
					$arrayGLAccountData[$row2->template_id][$colVal1][]=$v;

				}
			}
		}
		/*if($branch_id == 78){
			var_dump($arrayData);
			echo "<pre>";
			var_dump($arrayGLAccountData);
			exit;
		}*/
		$indexArray=array();
		$indexArray1=array();
		if(count($arrayGLAccountData) > 0){
			foreach ($arrayGLAccountData as $temp_id=>$columns) {
				foreach ($columns as $col1=>$col){
					foreach ($col as $index => $data1) {
						if(array_key_exists($temp_id,$arrayData)) {
							if(array_key_exists($index,$arrayData[$temp_id][$col1])){
								$indexArray[$data1][] = $arrayData[$temp_id][$col1][$index];

							}else{
								$indexArray[$data1][] = 0;
							}

						}
						if(array_key_exists($temp_id,$arrayDataOld)) {
							if(array_key_exists($index,$arrayDataOld[$temp_id][$col1])){
								$indexArray1[$data1][] = $arrayDataOld[$temp_id][$col1][$index];
							}else{
								$indexArray1[$data1][] = 0;
							}

						}
					}
				}
			}

			if(count($indexArray) > 0 && count($indexArray1)){
				return array($indexArray,$indexArray1);
			}else{
				return array(false,false);
			}
		}else{
			return array(false,false);
		}


	}
	public function getTotalData()
	{
		$company_id = $this->session->userdata("company_id");
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		$update = $this->input->post('update');
		$country_master = $this->Master_Model->getQuarter();
		$getScheduleData=array();
		$BranchType=array();
		$getScheduleDataOld=array();
		$checkConsolidate = $this->Master_Model->get_all_data(array('year' => $year, 'month' => $month, "company_id" => $company_id), "consolidate_report_transaction");
		if (count($checkConsolidate) > 0 && $update != true) {
			$response["status"] = 201;
			$response['message'] = "Data Already Consolidated";
			$response["data"] = 0;
		} else {
			$branchData = $this->Master_Model->
			_select("branch_master", array("company_id" => $company_id, "status" => 1,"is_consolidated"=>0), array("*"), false)->data;
			$getTotalData = array();
			$getTotalDataPrev = array();
			//$response['branchData'] = $branchData;
			foreach ($branchData as $branchRow) {


				if ($branchRow->start_with == 1) {
					$getTotalData1 = $this->Master_Model
						->_rawQuery('select  total,gl_ac,is_transfer,branch_id,debit,credit,opening_balance,branch_id,quarter,' . $branchRow->country . ' as country,"' . $branchRow->currency . '" as currency,' . $branchRow->start_with . ' as start_with,
(select (is_ignore) from branch_account_setup b where b.account_number= u.gl_ac and  b.branch_id=u.branch_id limit 1) as is_ignore,
(case when u.is_transfer=1 then 
(
(select group_concat(main_gl_number,"#",type1,"#",(case when monitory is null then "" else monitory end) )
from main_account_setup_master m where m.main_gl_number=u.gl_ac and m.company_id=u.company_id order by id desc limit 1)
)
else
(

(select group_concat(parent_account_number,"#",(select type1 from main_account_setup_master m where m.main_gl_number=b.parent_account_number AND m.company_id=b.company_id )
,"#",(select (case when monitory is null then "" else monitory end) from main_account_setup_master m where m.main_gl_number=b.parent_account_number AND m.company_id=b.company_id )
) from branch_account_setup b where b.account_number= u.gl_ac and  b.branch_id=u.branch_id order by id desc limit 1) 

) 
 
 end) as parent_account_ind,
(select group_concat(parent_account_number_us,"#",(select type1 from main_account_setup_master_us m where m.main_gl_number=b.parent_account_number_us AND m.company_id=b.company_id )
,"#",(select (case when monitory is null then "" else monitory end) from main_account_setup_master_us m where m.main_gl_number=b.parent_account_number_us AND m.company_id=b.company_id )
) from branch_account_setup b where b.account_number= u.gl_ac and  b.branch_id=u.branch_id order by id desc limit 1) as parent_account_us,
(select group_concat(parent_account_number_ifrs,"#",(select type1 from main_account_setup_master_ifrs m where m.main_gl_number=b.parent_account_number_ifrs AND m.company_id=b.company_id )
,"#",(select (case when monitory is null then "" else monitory end) from main_account_setup_master_ifrs m where m.main_gl_number=b.parent_account_number_ifrs AND m.company_id=b.company_id )
) from branch_account_setup b where b.account_number= u.gl_ac and  b.branch_id=u.branch_id order by id desc limit 1) as parent_account_ifrs,is_difference_value from upload_financial_data u
 where (year = ? and quarter >= ?) AND (year = ? and quarter <= ?) and company_id= ? and branch_id=?  ',
							array((int)$year, (int)$branchRow->start_with, (int)$year, (int)$month, $company_id, $branchRow->id))->data;

				} else {
					if ($month == $branchRow->start_with) {
						$getTotalData1 = $this->Master_Model
							->_rawQuery('select  total,gl_ac,is_transfer,branch_id,debit,credit,opening_balance,branch_id,quarter,' . $branchRow->country . ' as country,"' . $branchRow->currency . '" as currency,' . $branchRow->start_with . ' as start_with,
(select (is_ignore) from branch_account_setup b where b.account_number= u.gl_ac and  b.branch_id=u.branch_id limit 1) as is_ignore,
(case when u.is_transfer=1 then 
(
(select group_concat(main_gl_number,"#",type1,"#",(case when monitory is null then "" else monitory end) )
from main_account_setup_master m where m.main_gl_number=u.gl_ac and m.company_id=u.company_id order by id desc limit 1)
)
else
(

(select group_concat(parent_account_number,"#",(select type1 from main_account_setup_master m where m.main_gl_number=b.parent_account_number AND m.company_id=b.company_id )
,"#",(select (case when monitory is null then "" else monitory end) from main_account_setup_master m where m.main_gl_number=b.parent_account_number AND m.company_id=b.company_id )
) from branch_account_setup b where b.account_number= u.gl_ac and  b.branch_id=u.branch_id order by id desc limit 1) 

) 
 
 end) as parent_account_ind,
(select group_concat(parent_account_number_us,"#",(select type1 from main_account_setup_master_us m where m.main_gl_number=b.parent_account_number_us AND m.company_id=b.company_id )
,"#",(select (case when monitory is null then "" else monitory end) from main_account_setup_master_us m where m.main_gl_number=b.parent_account_number_us AND m.company_id=b.company_id )
) from branch_account_setup b where b.account_number= u.gl_ac and  b.branch_id=u.branch_id order by id desc limit 1) as parent_account_us,
(select group_concat(parent_account_number_ifrs,"#",(select type1 from main_account_setup_master_ifrs m where m.main_gl_number=b.parent_account_number_ifrs AND m.company_id=b.company_id )
,"#",(select (case when monitory is null then "" else monitory end) from main_account_setup_master_ifrs m where m.main_gl_number=b.parent_account_number_ifrs AND m.company_id=b.company_id )
) from branch_account_setup b where b.account_number= u.gl_ac and  b.branch_id=u.branch_id order by id desc limit  1) as parent_account_ifrs,is_difference_value from upload_financial_data u 
where ((year = ? and quarter = ?) ) and company_id= ? and branch_id=? ',
								array((int)($year), (int)($month), $company_id, $branchRow->id))->data;

					} else if ($month > $branchRow->start_with) {

						$getTotalData1 = $this->Master_Model
							->_rawQuery('select  total,gl_ac,branch_id,is_transfer,debit,credit,opening_balance,branch_id,quarter,' . $branchRow->country . ' as country,"' . $branchRow->currency . '" as currency,' . $branchRow->start_with . ' as start_with,
(select (is_ignore) from branch_account_setup b where b.account_number= u.gl_ac and  b.branch_id=u.branch_id limit 1) as is_ignore,
(case when u.is_transfer=1 then 
(
(select group_concat(main_gl_number,"#",type1,"#",(case when monitory is null then "" else monitory end) )
from main_account_setup_master m where m.main_gl_number=u.gl_ac and m.company_id=u.company_id order by id desc limit 1)
)
else
(

(select group_concat(parent_account_number,"#",(select type1 from main_account_setup_master m where m.main_gl_number=b.parent_account_number AND m.company_id=b.company_id )
,"#",(select (case when monitory is null then "" else monitory end) from main_account_setup_master m where m.main_gl_number=b.parent_account_number AND m.company_id=b.company_id )
) from branch_account_setup b where b.account_number= u.gl_ac and  b.branch_id=u.branch_id order by id desc limit 1) 

) 
 
 end) as parent_account_ind,
(select group_concat(parent_account_number_us,"#",(select type1 from main_account_setup_master_us m where m.main_gl_number=b.parent_account_number_us AND m.company_id=b.company_id )
,"#",(select (case when monitory is null then "" else monitory end) from main_account_setup_master_us m where m.main_gl_number=b.parent_account_number_us AND m.company_id=b.company_id )
) from branch_account_setup b where b.account_number= u.gl_ac and  b.branch_id=u.branch_id order by id desc limit 1) as parent_account_us,
(select group_concat(parent_account_number_ifrs,"#",(select type1 from main_account_setup_master_ifrs m where m.main_gl_number=b.parent_account_number_ifrs AND m.company_id=b.company_id )
,"#",(select (case when monitory is null then "" else monitory end) from main_account_setup_master_ifrs m where m.main_gl_number=b.parent_account_number_ifrs AND m.company_id=b.company_id )
) from branch_account_setup b where b.account_number= u.gl_ac and  b.branch_id=u.branch_id order by id desc limit 1) as parent_account_ifrs,is_difference_value from upload_financial_data u 
where ((year = ? and quarter >= ?) AND (year=? and quarter <= ?)) and company_id= ? and branch_id=? ',
								array((int)$year, (int)$branchRow->start_with, (int)($year), (int)($month), $company_id, $branchRow->id))->data;

					} else {

						$getTotalData1 = $this->Master_Model
							->_rawQuery('select  total,gl_ac,branch_id,is_transfer,debit,credit,opening_balance,branch_id,quarter,' . $branchRow->country . ' as country,"' . $branchRow->currency . '" as currency,' . $branchRow->start_with . ' as start_with,
(select (is_ignore) from branch_account_setup b where b.account_number= u.gl_ac and  b.branch_id=u.branch_id limit 1) as is_ignore,
(case when u.is_transfer=1 then 
(
(select group_concat(main_gl_number,"#",type1,"#",(case when monitory is null then "" else monitory end) )
from main_account_setup_master m where m.main_gl_number=u.gl_ac and m.company_id=u.company_id order by id desc limit 1)
)
else
(

(select group_concat(parent_account_number,"#",(select type1 from main_account_setup_master m where m.main_gl_number=b.parent_account_number AND m.company_id=b.company_id )
,"#",(select (case when monitory is null then "" else monitory end) from main_account_setup_master m where m.main_gl_number=b.parent_account_number AND m.company_id=b.company_id )
) from branch_account_setup b where b.account_number= u.gl_ac and  b.branch_id=u.branch_id order by id desc limit 1) 

) 
 
 end) as parent_account_ind,
(select group_concat(parent_account_number_us,"#",(select type1 from main_account_setup_master_us m where m.main_gl_number=b.parent_account_number_us AND m.company_id=b.company_id )
,"#",(select (case when monitory is null then "" else monitory end) from main_account_setup_master_us m where m.main_gl_number=b.parent_account_number_us AND m.company_id=b.company_id )
) from branch_account_setup b where b.account_number= u.gl_ac and  b.branch_id=u.branch_id order by id desc limit 1) as parent_account_us,
(select group_concat(parent_account_number_ifrs,"#",(select type1 from main_account_setup_master_ifrs m where m.main_gl_number=b.parent_account_number_ifrs AND m.company_id=b.company_id )
,"#",(select (case when monitory is null then "" else monitory end) from main_account_setup_master_ifrs m where m.main_gl_number=b.parent_account_number_ifrs AND m.company_id=b.company_id )
) from branch_account_setup b where b.account_number= u.gl_ac and  b.branch_id=u.branch_id order by id desc limit 1) as parent_account_ifrs,is_difference_value from upload_financial_data u 
where ((year = ? and quarter <= ?) or (year=? and quarter >= ?)) and company_id= ? and branch_id=? ',
								array((int)$year, (int)$month, (int)($year - 1), (int)($branchRow->start_with), $company_id, $branchRow->id))->data;

					}

//					exit();
				}

				/*if (count($getTotalData1) <= 0 && $branchRow->is_special_branch != 1) {
					$response["status"] = 201;
					$response['message'] = "Data is not uploaded for following Subsidiary :" . $branchRow->name . " Kindly upload the data or deactivate the branch";
					echo json_encode($response);
					exit;
				}*/
				$BranchType[$branchRow->id]=$branchRow->is_special_branch;
				$getTotalData = array_merge($getTotalData, $getTotalData1);

				//get Previus Year Data
				if ($branchRow->start_with == 1) {
					$yearPrev = $year - 1;
					$monthPrev = 12;
				} else {
					$yearPrev = $year-1;
					$monthPrev = $branchRow->start_with - 1;
				}


				$getTotalData2=$this->getPreviousData($monthPrev,$yearPrev,$branchRow->id,$branchRow->start_with,$branchRow->country);
				if(!is_null($getTotalData2) || $getTotalData2 != false){
					array_push($getTotalDataPrev, $getTotalData2);
				}
				$ar=$this->getScheduleData($branchRow->id,$month,$year);
				$getScheduleData[$branchRow->id]=$ar[0];
				$getScheduleDataOld[$branchRow->id]=$ar[1];

			}
			$AllDataArrayIND = array();
			$AllDataArrayUS = array();
			$AllDataArrayIFRS = array();
			$TypeArrayIND = array();
			$TypeArrayUS = array();
			$TypeArrayIFRS = array();
			$CountryData = array();
			$currencyData = array();
			$isMonitoryIND=array();
			$isMonitoryUS=array();
			$isMonitoryIFRS=array();
			$branchStartWith=array();
			$isDifferenceValue=array();
			foreach ($getTotalData as $item) {
				$exp_ind = explode("#", $item->parent_account_ind);
				$exp_us = explode("#", $item->parent_account_us);
				$exp_ifrs = explode("#", $item->parent_account_ifrs);
				$CountryData[$item->branch_id]=$item->country;
				$currencyData[$item->branch_id]=$item->currency;
				$branchStartWith[$item->branch_id]=$item->start_with;

				if ($exp_ind[0] != null && $item->is_ignore == 0) {
					$typeINDAcc = $exp_ind[1];
					$isMonitoryIND[$exp_ind[0]]=$exp_ind[2];
					$TypeArrayIND[$exp_ind[0]]=$exp_ind[1];
					$total = 0;
					/*if ($typeINDAcc == "EQUITY AND LIABILITIES" || $typeINDAcc == "REVENUE") {
						$total = ($item->credit - $item->debit) + $item->opening_balance;
					}
					if ($typeINDAcc == "ASSETS" || $typeINDAcc == "EXPENSES") {
						$total = ($item->debit - $item->credit) + $item->opening_balance;
					}*/
					$total = $item->opening_balance + $item->debit - $item->credit ;
					if($item->is_difference_value==1)
					{
						$total=$item->total;
					}

					if ($item->quarter == $month) {
						$AllDataArrayIND[$exp_ind[0]][$item->branch_id][] = array($item->debit, $item->credit, $total, $item->opening_balance,$item->total,$item->is_transfer,$item->is_difference_value,$item->gl_ac);
					} else {
						$AllDataArrayIND[$exp_ind[0]][$item->branch_id][] = array(0, 0, 0, 0,0,0,0,0);
					}
				}

				if ($exp_us[0] != null && $item->is_ignore == 0) {
					$typeUSAcc = $exp_us[1];
					$isMonitoryUS[$exp_us[0]]=$exp_us[2];
					$TypeArrayUS[$exp_us[0]]=$exp_us[1];
					/*if ($typeUSAcc == "EQUITY AND LIABILITIES" || $typeUSAcc == "REVENUE") {
						$total = ($item->credit - $item->debit) + $item->opening_balance;
					}
					if ($typeUSAcc == "ASSETS" || $typeUSAcc == "EXPENSES") {
						$total = ($item->debit - $item->credit) + $item->opening_balance;
					}*/
					$total = $item->opening_balance+ $item->debit - $item->credit ;
					if ($item->quarter == $month) {
						$AllDataArrayUS[$exp_us[0]][$item->branch_id][] = array($item->debit, $item->credit, $total, $item->opening_balance,$item->total,$item->is_transfer,$item->is_difference_value,$item->gl_ac);
					} else {
						$AllDataArrayUS[$exp_us[0]][$item->branch_id][] = array(0, 0, 0, 0,0,0,0,0);
					}

				}
				if ($exp_ifrs[0] != null && $item->is_ignore == 0) {
					$typeIFRSAcc = $exp_ifrs[1];
					$isMonitoryIFRS[$exp_ifrs[0]]=$exp_ifrs[2];
					$TypeArrayIFRS[$exp_ifrs[0]]=$exp_ifrs[1];
					/*if ($typeIFRSAcc == "EQUITY AND LIABILITIES" || $typeIFRSAcc == "REVENUE") {
						$total = ($item->credit - $item->debit) + $item->opening_balance;
					}
					if ($typeIFRSAcc == "ASSETS" || $typeIFRSAcc == "EXPENSES") {
						$total = ($item->debit - $item->credit) + $item->opening_balance;
					}*/
					$total = $item->opening_balance+ $item->debit - $item->credit ;
					if ($item->quarter == $month) {
						$AllDataArrayIFRS[$exp_ifrs[0]][$item->branch_id][] = array($item->debit, $item->credit, $total, $item->opening_balance,$item->total,$item->is_transfer,$item->is_difference_value,$item->gl_ac);
					} else {
						$AllDataArrayIFRS[$exp_ifrs[0]][$item->branch_id][] = array(0, 0, 0, 0,0,0,0,0);
					}

				}


			}
			//get Previous Year Data
			if (count($AllDataArrayIND) < 0 && count($AllDataArrayUS) < 0 && count($AllDataArrayIFRS)) {
				$response["status"] = 201;
				$response['message'] = "No Mapping Found of Subsidiary GL Account with Parent Account.Please Check!";
				echo json_encode($response);
				exit;
			}

			$getDataIntraCompanyTransfer = $this->getDataIntraCompanyTransfer($month, $year);
			$fromDataTransfer = $getDataIntraCompanyTransfer[0];
			$toDataTransfer = $getDataIntraCompanyTransfer[1];
			$getPreviousDataArrays=array();

			if($getTotalDataPrev != false){
				$getPreviousDataArrays = $this->getPreviousDataArray($getTotalDataPrev);
			}
			// get special exchnage data
			$getSpecialExchangeData=array();
			$getSpecialExchangeData=$this->getSpecialExchangedata($month,$year);

			// get addition GL data
			$getAdditionGLData=array();
			$getAdditionGLData=$this->getAdditionGLData($month,$year);

			// get auditor adjustment GL data
			$getAuditorAdjustmentGLData=array();
			$getAuditorAdjustmentGLData=$this->getAuditorAdjustmentGLData($month,$year);

			$insertDataArrayIND = array();
			if (count($AllDataArrayIND) > 0) {
				foreach ($AllDataArrayIND as $key => $itemIND) {

					foreach ($itemIND as $key_branch => $i) {

						$debit_prev = 0;
						$credit_prev = 0;
						$total_prev = 0;
						$openingB_prev = 0;
						$Start = $branchStartWith[$key_branch];
						$SelectedMonth = 0;
						$monitory = $isMonitoryIND[$key];
						$Movingrate = 0;
						$ClosingRate = 0;
						$opening_balance_2 = 0;
						$credit_1 = 0;
						$debit_1 = 0;
						$total_1 = 0;
						$total_2 = 0;
						$opening_balance_1 = 0;
						$credit_2 = 0;
						$debit_2 = 0;
						$type1 = $TypeArrayIND[$key];
						$opening_balanceLastYear = 0;
						$is_special=$BranchType[$key_branch];
						$getCurrencyData = $this->Master_Model->_rawQuery("select rate,closing_rate from currency_conversion_master where currency='" . $currencyData[$key_branch] . "' AND company_id=" . $company_id . " AND month=" . $month . " AND year=" . $year);

						if ($getCurrencyData->totalCount > 0) {

							$res = $getCurrencyData->data;
							$Movingrate = $res[0]->rate;
							$ClosingRate = $res[0]->closing_rate;
						} else {
							$response['status']=201;
							$response['message'] = "Currency Conversion is not done for selected month";
							echo json_encode($response);
							exit;
						}

						$preMovingrate = 0;
						$preClosingRate = 0;
//						if (array_key_exists(0, $getPreviousDataArrays)) {
//							if (array_key_exists($key, $getPreviousDataArrays[0])) {
//								if (array_key_exists($key_branch, $getPreviousDataArrays[0][$key])) {
//
//									$previousData = ($getPreviousDataArrays[0][$key][$key_branch]);
//									$debit_prev = $previousData[0];
//									$credit_prev = $previousData[1];
//									$total_prev = $previousData[2];
//									$openingB_prev = $previousData[3];
//									$Start = $previousData[4];
//									$SelectedMonth = $previousData[5];
//									//$monitory = $previousData[6];
//
//									$preMovingrate = $previousData[7];
//									$preClosingRate = $previousData[8];
//									$opening_balanceLastYear = $previousData[9];
//									//$type1 = $previousData[10];
//								}
//							}
//						}
						if($preMovingrate==0 || $preMovingrate==null)
						{
							$Movingrate = $Movingrate;
						}
						else{
							$Movingrate=$preMovingrate;
						}

						if($preClosingRate==0 || $preClosingRate==null)
						{
							$ClosingRate = $ClosingRate;
						}
						else{
							$ClosingRate = $preClosingRate;
						}

						// ----- Calculation Intra company transfer -----
						$transfer_from_debit = 0;
						$transfer_from_credit = 0;
						$transfer_to_debit = 0;
						$transfer_to_credit = 0;
						if (array_key_exists($key, $fromDataTransfer)) {
							if (array_key_exists($key_branch, $fromDataTransfer[$key])) {
								if (count($fromDataTransfer[$key][$key_branch]) > 0) {
									$data = $fromDataTransfer[$key][$key_branch];
									$transfer_from_debit = $data[0];
									$transfer_from_credit = $data[1];
								}
							}
						}
						if (array_key_exists($key, $toDataTransfer)) {
							if (array_key_exists($key_branch, $toDataTransfer[$key])) {
								if (count($toDataTransfer[$key][$key_branch]) > 0) {
									$data = $toDataTransfer[$key][$key_branch];
									$transfer_to_debit = $data[0];
									$transfer_to_credit = $data[1];
								}
							}
						}
						// ----- Calculation Intra company transfer -----

						$credit = 0;
						$debit = 0;
						$opening_balance = 0;
						$Total = 0;
						$TotalNew = 0;
						$diff_debit=0;
						$diff_credit=0;
						$diff_opening_balance=0;
						$diff_total=0;
						$old_total=0;
						$exchange_old_total=0;
						$exchange_debit=0;
						$exchange_credit=0;
						$exchange_opening_balance=0;
						$additionGL_debit=0;
						//Step 1
						foreach ($i as $j) {
							// $j[6] - Differance Value
							if($j[6]==1)
							{
								$Total += $j[4];
								$diff_total += $j[4];
								$diff_opening_balance += $j[3];
								$diff_debit += $j[0];
								$diff_credit += $j[1];
							}
							else{
								$opening_balance += $j[3];
								$debit += $j[0];
								$credit += $j[1];
								$Total += $j[2]; //old data
								$old_total += $j[2]; //old data
//							$Total += $j[4]; //changes suggest by bharat sir

//								//auditor adjustment
								if(is_array($getAuditorAdjustmentGLData))
								{
									if(array_key_exists($key_branch,$getAuditorAdjustmentGLData))
									{
										if(array_key_exists($key,$getAuditorAdjustmentGLData[$key_branch]))
										{
											if(array_key_exists($j[7],$getAuditorAdjustmentGLData[$key_branch][$key]))
											{
												$debit += $getAuditorAdjustmentGLData[$key_branch][$key][$j[7]];
												$Total += $getAuditorAdjustmentGLData[$key_branch][$key][$j[7]];
											}
										}
									}
								}

								//for exchange rate calculation gl_account wise... not parent account wise // added bcoz of ashutosh store gl_account exchange rate
								$exRate=1;//exchange rate
								if(is_array($getSpecialExchangeData))
								{
									if(array_key_exists($key_branch,$getSpecialExchangeData))
									{
										if(array_key_exists($key,$getSpecialExchangeData[$key_branch]))
										{
											if(array_key_exists($j[7],$getSpecialExchangeData[$key_branch][$key]))
											{
												$exRate=$getSpecialExchangeData[$key_branch][$key][$j[7]];
											}
										}
									}
								}
//								if($currencyData[$key_branch]=="INR")
//								{
									$additionRate=0;
									if(is_array($getAdditionGLData))
									{
										if(array_key_exists($key_branch,$getAdditionGLData))
										{
											if(array_key_exists($key,$getAdditionGLData[$key_branch]))
											{
												if(array_key_exists($j[7],$getAdditionGLData[$key_branch][$key]))
												{
													$additionRate=$getAdditionGLData[$key_branch][$key][$j[7]];
												}
											}
										}
									}
//									$debit+=$additionRate;
//									$old_total+=$additionRate;
								$additionGL_debit+=$additionRate;
//								}


								$exchange_old_total+= ($j[2]*$exRate);
								$exchange_debit+= ($j[0]*$exRate);
								$exchange_credit+= ($j[1]*$exRate);
								$exchange_opening_balance+= ($j[3]*$exRate);
							}

							$TotalNew += $j[4];
						}

						if(count($getScheduleDataOld) > 0){
							if(array_key_exists($key_branch,$getScheduleDataOld)){
								$arraVAl=$getScheduleDataOld[$key_branch];
								if($arraVAl != false){
									if(array_key_exists($key,$arraVAl)){
										if(array_sum($arraVAl[$key])!=0)
										{
											$Total=array_sum($arraVAl[$key]);
										}
									}
								}
							}
						}


						/*// -----Intra company Transfer summation and substraction ----- This is done while intra company transfer
						$debit = $debit - $transfer_from_debit;
						$debit = $debit + $transfer_to_debit;

						$credit = $credit - $transfer_from_credit;
						$credit = $credit + $transfer_to_credit;*/
						// -----Intra company Transfer summation and substraction -----
						//Step 2
						$opening_balance_1 = $opening_balance;


						/*if ($Start != $month) {   //bharat sir told to remove this logic
							$debit_1 = $debit - $debit_prev; //current debit - last month debit
							$credit_1 = $credit - $credit_prev; //current debit - last month debit
						} else {
							$debit_1 = $debit;
							$credit_1 = $credit;
						}*/
						$debit_1 = $debit;
						$credit_1 = $credit;

						//Step 3

						if ((is_null($ClosingRate) || $ClosingRate == "") && (is_null($Movingrate) || $Movingrate == "")) {
							$response['status'] = 201;
							$response['message'] = "Currency Conversion is not done for selected month";
							echo json_encode($response);
							exit;
						}
						$total2T=$Total;


						$splExist=0;
						if(is_array($getSpecialExchangeData))
						{
							if(array_key_exists($key_branch,$getSpecialExchangeData))
							{
								if(array_key_exists($key,$getSpecialExchangeData[$key_branch]))
								{
									$splExist=1;
									$exchangeRate=$getSpecialExchangeData[$key_branch][$key];
									$old_total=$exchange_old_total;
									$debit_2 = $exchange_debit;
									$credit_2 = $exchange_credit;
									$opening_balance_2 = $exchange_opening_balance;
								}
							}
						}
						if($splExist==0)
						{
							if ($monitory == 'Yes') {
								$old_total=$old_total* $ClosingRate;
								$debit_2 = $debit_1 * $ClosingRate;
								$credit_2 = $credit_1 * $ClosingRate;
								$opening_balance_2 = $opening_balance * $ClosingRate;
							} else {
								$old_total=$old_total* $Movingrate;
								$debit_2 = $debit_1 * $Movingrate;
								$credit_2 = $credit_1 * $Movingrate;
								//STEP 4
								if ($opening_balanceLastYear != 0 && !is_null($opening_balanceLastYear)) {
//									$opening_balance_2 = $opening_balanceLastYear;
								} else {
									$opening_balance_2 = $opening_balance * $Movingrate;
								}

							}
						}
//						$debit_2=$debit_2+$additionGL_debit;
//						$old_total=$old_total+$additionGL_debit;

						/*if($key_branch == 59){
							echo $ClosingRate."-".$Movingrate."-".$debit_2."-".$debit_prev ."-".$key ."<br>";
						}*/
						//Calculate Total Type1 Wise
						/*if ($type1 == "EQUITY AND LIABILITIES" || $type1 == "REVENUE") {   -- changes told by bharat sir
							$total_1 = ($credit_1 - $debit_1) + $opening_balance_1;
							$total_2 = ($credit_2 - $debit_2) + $opening_balance_2;
						}
						if ($type1 == "ASSETS" || $type1 == "EXPENSES") {
							$total_1 = ($debit_1 - $credit_1) + $opening_balance_1;
							$total_2 = ($debit_2 - $credit_2) + $opening_balance_2;
						}*/
						//Calculate Total Type1 Wise
						$total_1 = ($opening_balance_1+$debit_1 - $credit_1) ;//old data
//						$total_1=$opening_balance+$Total; // value suggest by bharat sir
//						$total_2 = ($opening_balance_2+$debit_2 - $credit_2);//old data
//						$total_2 = (($opening_balance_2+$diff_opening_balance)+($debit_2+$diff_debit) - ($credit_2+$diff_credit));//old data
//						$total_2 = ($opening_balance_2+$total2T);

						$total_2 = ($opening_balance_2+$old_total+$diff_total);

//						if(array_key_exists($key,$isDifferenceValue))
//						{
//							if($isDifferenceValue[$key]==1)
//							{
//								$total_1=$Total;
//								$total_2=($opening_balance_2+$debit_2 - $credit_2);
//							}
//						}

						if(count($getScheduleData) > 0){
							if(array_key_exists($key_branch,$getScheduleData)){
								$arraVAl=$getScheduleData[$key_branch];
								if($arraVAl != false){
									if(array_key_exists($key,$arraVAl)){
										if(array_sum($arraVAl[$key])!=0) {
											$total_2 = array_sum($arraVAl[$key]);
										}
									}
								}
							}
						}
						$total_2=($total_2+$additionGL_debit);

						/*if($is_special == 1){
							$total_1=$TotalNew;
							$total_2=$TotalNew;
							$Total=$TotalNew;
						}*/

						// Step 4
						$data = array(
							"account_number" => $key,
							"branch_id" => $key_branch,
							"final_total" => $Total,
							"total" => $Total,
							"debit" => $debit,
							"credit" => $credit,
							"opening_balance" => $opening_balance,
							"month" => $month,
							"year" => $year,
							"company_id" => $company_id,
							"total_1" => $total_1,
							"debit_1" => $debit_1,
							"credit_1" => $credit_1,
							"opening_balance_1" => $opening_balance_1,
							"total_2" => $total_2,
							"debit_2" => $debit_2,
							"credit_2" => $credit_2,
							"opening_balance_2" => $opening_balance_2,
							"create_by" => $this->session->userdata("user_id"),
						);
						array_push($insertDataArrayIND, $data);
					}
				}
			}
			$insertDataArrayUS = array();
			if (count($AllDataArrayUS) > 0) {
				foreach ($AllDataArrayUS as $key => $itemIND) {
					foreach ($itemIND as $key_branch => $i) {
						$credit = 0;
						$debit = 0;
						$opening_balance = 0;
						$Total = 0;
						foreach ($i as $j) {
							$credit += $j[0];
							$debit += $j[1];
							$opening_balance += $j[2];
							$Total += $j[3];
						}
						$data = array(
							"account_number" => $key,
							"branch_id" => $key_branch,
							"final_total" => $Total,
							"total" => $Total,
							"debit" => $debit,
							"credit" => $credit,
							"opening_balance" => $opening_balance,
							"month" => $month,
							"year" => $year,
							"company_id" => $company_id,
						);
						array_push($insertDataArrayUS, $data);
					}
				}
			}
			$insertDataArrayIFRS = array();
			if (count($AllDataArrayIFRS) > 0) {
				foreach ($AllDataArrayIFRS as $key => $itemIND) {
					foreach ($itemIND as $key_branch => $i) {
						$credit = 0;
						$debit = 0;
						$opening_balance = 0;
						$Total = 0;
						foreach ($i as $j) {
							$credit += $j[0];
							$debit += $j[1];
							$opening_balance += $j[2];
							$Total += $j[3];
						}

						$data = array(
							"account_number" => $key,
							"branch_id" => $key_branch,
							"final_total" => $Total,
							"total" => $Total,
							"debit" => $debit,
							"credit" => $credit,
							"opening_balance" => $opening_balance,
							"month" => $month,
							"year" => $year,
							"company_id" => $company_id,
						);
						array_push($insertDataArrayIFRS, $data);
					}
				}
			}
			$result = FALSE;
			try {
				$this->db->trans_start();
				if (count($insertDataArrayIND) > 0) {
					$this->db->delete("consolidate_report_transaction", array("month" => $month, "year" => $year, "company_id" => $company_id, "is_transfer" => 0, "is_consolidated" => 0));
					$this->db->insert_batch('consolidate_report_transaction', $insertDataArrayIND);
				}
				if (count($insertDataArrayUS) > 0) {
					$this->db->delete("consolidate_report_transaction_us", array("month" => $month, "year" => $year, "company_id" => $company_id, "is_transfer" => 0));
					$this->db->insert_batch('consolidate_report_transaction_us', $insertDataArrayUS);
				}
				if (count($insertDataArrayIFRS) > 0) {
					$this->db->delete("consolidate_report_transaction_ifrs", array("month" => $month, "year" => $year, "company_id" => $company_id, "is_transfer" => 0));
					$this->db->insert_batch('consolidate_report_transaction_ifrs', $insertDataArrayIFRS);
				}
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					log_message('info', "insert user Transaction Rollback");
					$result = FALSE;
				} else {
					$this->db->trans_commit();
					log_message('info', "insert user Transaction Commited");
					$result = TRUE;
				}
				$this->db->trans_complete();
			} catch (Exception $exc) {
				log_message('error', $exc->getMessage());
				$result = FALSE;
			}
			if ($result == TRUE) {
				$response['status'] = 200;
			} else {
				$response['status'] = 201;
			}
		}
		echo json_encode($response);
	}


	public function getUpdateReportData()
	{

		$year = $this->input->post('year');
		$month = $this->input->post('month');
		$data_array = array();
		$country_master = $this->Master_Model->getQuarter();
		$getUpdateData = $this->Master_Model->_select('consolidate_report_transaction', array('year' => $year, 'month' => $month), '*', false)->data;
		if ($getUpdateData) {
			$headers = array();
			foreach ($getUpdateData as $row) {
				$headers = array_merge($headers, array('gl_number', 'total', 'year', 'month'));
				$data = array(
					'gl_number' => $row->account_number,
					'total' => $row->final_total,
					'year' => $row->year,
					'month' => $country_master[$row->month]
				);
				array_push($data_array, $data);
			}
			$response["headers"] = $headers;
			$response["status"] = 200;
			$response["data"] = $data_array;
		} else {
			$data = array('0', '0', '0', '0');
			$response["status"] = 200;
			$response["data"] = array($data);
			$response['message'] = "No Data Found";
		}
		echo json_encode($response);
	}


	public function getUpdatedData()
	{
		$company_id = 2;
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		$country_master = $this->Master_Model->getQuarter();
		$total_array = array();

		$getMainAccount = $this->Master_Model->_select('main_account_setup_master',
			array('company_id' => 2), array('main_gl_number', 'name'), false)->data;

		$this->Master_Model->_select("", array("company_id" => $company_id), array('name', 'start_with'));

		$getTotalData = $this->Master_Model->_rawQuery('select  total,gl_ac,branch_id from upload_financial_data where year = ? and quarter = ?',
			array($year, $month))->data;

		$getBranchWithMainAccount = $this->Master_Model->_select('branch_account_setup',
			array("find_in_set(parent_account_number,(select group_concat(main_gl_number) from main_account_setup_master where company_id =" . $company_id . " ))"),
			array('account_number', 'parent_account_number', 'branch_id'), false)->data;

		$filterArray = array();
		$branchAccount = $this->Master_Model->_select("branch_master", array("company_id" => $this->session->userdata("company_id")), array("id"), false)->data;
		foreach ($getTotalData as $records) {
			foreach ($branchAccount as $branch) {
				foreach ($getBranchWithMainAccount as $account) {
					if ($records->gl_ac == $account->account_number && $branch->id === $records->branch_id) {
						$filterArray[$account->parent_account_number][$account->account_number][$account->branch_id][] = $records->total;
					}
				}
			}
		}

		$finalRecords = array();
		foreach ($branchAccount as $branch) {
			foreach ($getMainAccount as $parent) {

				if (array_key_exists($parent->main_gl_number, $filterArray)) {
					$allChildRecords = array();
					foreach ($filterArray[$parent->main_gl_number] as $childRecords) {

						if (array_key_exists($branch->id, $childRecords)) {
							foreach ($childRecords as $records) {
								foreach ($records as $branchRecords) {
									array_push($allChildRecords, $branchRecords);
								}
							}
						}
					}
//                $finalRecords[$parent->main_gl_number]=array_sum($allChildRecords);
					$data = array(
						'parent' => $parent->main_gl_number,
						'total' => array_sum($allChildRecords),
						'year' => $year,
						'month' => $country_master[$month]
					);
					array_push($finalRecords, $data);
				} else {
					$data = array(
						'parent' => $parent->main_gl_number,
						'total' => 0,
						'year' => $year,
						'month' => $country_master[$month]
					);
					array_push($finalRecords, $data);
//                $finalRecords[$parent->main_gl_number]=0;
				}

			}
		}
		$response['filter'] = $filterArray;
		$response['status'] = 200;
		$response['data'] = $finalRecords;
		echo json_encode($response);
	}

//    public function getSumValues()
//    {
//        $year = $this->input->post('year');
//        $month = $this->input->post('month');
//
//        $checkConsolidate = $this->Master_Model->get_all_data(array('year'=>$year,'month'=>$month),"consolidate_report_transaction");
//        if(count($checkConsolidate)>0)
//        {
//            $response["status"] = 201;
//            $response['message'] = "Data Already Consolidated";
//            $response["data"] = 0;
//        }
//        else
//        {
//            $getDebitSum = $this->Master_Model
//                ->_rawQuery('select "", (select parent_account_number from branch_account_setup where account_number=gl_ac) as parent_account,
//sum(credit),sum(debit),  sum(debit)+sum(credit) as total
// from global_accounting.upload_financial_data where gl_ac
// in (select account_number from branch_account_setup where parent_account_number in (select main_gl_number from main_account_setup_master where company_id =2))  and year = ? and quarter = ?  group by parent_account',
//                    array( $year, $month),2);
//
//            if ($getDebitSum->totalCount > 0) {
//                $array = array();
//                foreach ($getDebitSum->data as $row){
//                    array_push($array,array_values($row));
//                }
//                $response["status"] = 200;
//                $response["data"] = $array;
//            } else {
//                $data = array('','0','0','0','0');
//                $response["status"] = 200;
//                $response["data"] = [$data];
//                $response['message'] = "No Data Found";
//            }
//        }
//        echo json_encode($response);
//    }

	public function saveConsolidationReport()
	{
		$data = $this->input->post("data");
		$month = $this->input->post("month");
		$year = $this->input->post("year");
		$company_id = $this->session->userdata("company_id");
		$tableArray = json_decode($data);
		$array_outside = array();
		foreach ($tableArray as $array) {
			$split_arr = array_chunk($array, 10, false);
			array_push($array_outside, $split_arr);
		}
		$q = "SELECT (main_gl_number),1 as type FROM main_account_setup_master where company_id=" . $company_id . " union  SELECT (main_gl_number),2 as type FROM main_account_setup_master_us where company_id=" . $company_id . " union SELECT (main_gl_number),3 as type FROM main_account_setup_master_ifrs where company_id=" . $company_id;
		$query = $this->Master_Model->_rawQuery($q, true, 0)->data;
		$array_ind = array();
		$array_us = array();
		$array_ifrs = array();
		foreach ($query as $row) {
			if ($row['type'] == 1) {
				$array_ind[] = $row['main_gl_number'];
			} elseif ($row['type'] == 2) {
				$array_us[] = $row['main_gl_number'];
			} else {
				$array_ifrs[] = $row['main_gl_number'];
			}
		}

		$insertData = array();
		$insertDataUS = array();
		$insertDataIFRS = array();
		foreach ($array_outside as $row) {
			foreach ($row as $r1) {
				$data = array(
					"account_number" => $r1[4],
					"month" => $month,
					"year" => $year,
					"company_id" => $company_id,
					"branch_id" => $r1[9],
					"final_total" => $r1[5],
					"total" => $r1[6],
					"particulars" => $r1[0],
				);
				if (in_array($r1[4], $array_ind)) {
					$data['account_number'] = $r1[4];
					array_push($insertData, $data);
				}
				if (in_array($r1[4], $array_us)) {
					$data['account_number'] = $r1[4];
					array_push($insertDataUS, $data);
				}
				if (in_array($r1[4], $array_ifrs)) {
					$data['account_number'] = $r1[4];
					array_push($insertDataIFRS, $data);
				}
			}
		}

		if (count($insertData) > 0 || count($insertDataUS) > 0 || count($insertDataIFRS) > 0) {

			try {
				$this->db->trans_start();
				if (count($insertData) > 0) {
					$this->db->delete("consolidate_report_transaction", array("month" => $month, "year" => $year, "company_id" => $company_id));
					$this->db->insert_batch("consolidate_report_transaction", $insertData);
				}
				if (count($insertDataUS) > 0) {
//					$this->db->delete("consolidate_report_transaction_us", array("month" => $month, "year" => $year,"company_id"=>$company_id));
//					$this->db->insert_batch("consolidate_report_transaction_us", $insertDataUS);
				}
				if (count($insertDataIFRS) > 0) {
//					$this->db->delete("consolidate_report_transaction_ifrs", array("month" => $month, "year" => $year,"company_id"=>$company_id));
//					$this->db->insert_batch("consolidate_report_transaction_ifrs", $insertDataIFRS);
				}
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					log_message('info', "insert user Transaction Rollback");
					$result = FALSE;
				} else {
					$this->db->trans_commit();
					log_message('info', "insert user Transaction Commited");
					$result = TRUE;
				}
				$this->db->trans_complete();
			} catch (Exception $exc) {
				log_message('error', $exc->getMessage());
				$result = FALSE;
			}
			if ($result) {
				$response["status"] = 200;
				$response["body"] = "Save Changes";
			} else {
				$response["status"] = 201;
				$response["body"] = "Failed To Changes";
			}
		} else {
			$response["status"] = 201;
			$response["body"] = "Parameter Missing";
		}

		echo json_encode($response);
	}

	public function update_report_schedule()
	{
		$year = $this->input->get('year');
		$month = $this->input->get('month');
		$country_master = $this->Master_Model->getQuarter();
		$this->load->view("Report/update_report_schedule", array("title" => "Balance Sheet Report", 'year' => $year, 'month' => $country_master[$month]));
	}

	public function getScheduleReportData()
	{
		$company_id = $this->session->userdata('company_id');
		$type = $this->input->post('type');

		$branchData = $this->Master_Model->
		_select("branch_master", array("company_id" => $company_id, "status" => 1), array("start_with", "id", "name"), false)->data;


		$filterArray = array();
		$getTotalData = $this->Master_Model->_select('consolidate_report_transaction cr',
			array("company_id" => $company_id),
			array('*', '(select group_concat(ma.type3,' || ',ma.name) from main_account_setup_master ma where ma.company_id=ct.company_id and ma.main_gl_number=ct.account_number) as main_data'), false)->data;
		$where = array("company_id" => $company_id);
		if ($type == "PL") {
			$where['type0'] = 'PL';
		} else {
			$where['type0'] = 'BS';
		}
		$getBranchWithMainAccount = $this->Master_Model->_select('main_account_setup_master',
			$where,
			array('*'), false, array('main_gl_number'))->data;


		foreach ($getTotalData as $records) {
			foreach ($getBranchWithMainAccount as $account) {
				if ($account->main_gl_number === $records->account_number) {
					$filterArray[$account->main_gl_number][$records->branch_id][] = $records->total;
				}
			}

		}
		$columnHeader = array();
		$source = array(
			array('type' => 'text'),
			array('type' => 'text'),
			array('type' => 'text')

		);
		array_push($columnHeader, 'Type2', 'Type3', 'Type4');
		foreach ($branchData as $branch) {
			array_push($columnHeader, $branch->name);//column headers
			array_push($source, array('type' => 'numeric'));
		}
		array_push($source, array('type' => 'numeric'));
		array_push($columnHeader, 'Total');

		$finalArray = array();
		foreach ($getBranchWithMainAccount as $parent) {
			$main_dataArray = array();
			array_push($main_dataArray, $parent->type2, $parent->type3, $parent->name);
			$allChildRecords = array();
			if (array_key_exists($parent->main_gl_number, $filterArray)) {


				foreach ($branchData as $branch) {
					$BranchChildRecords = array();
					foreach ($filterArray[$parent->main_gl_number] as $key => $childRecords) {

						if ($key == $branch->id) {
							foreach ($childRecords as $childvalue) {
								array_push($BranchChildRecords, $childvalue);
								array_push($allChildRecords, $childvalue);
							}

						}
					}
					$branch_total = array_sum($BranchChildRecords);
// print_r($branch_total);exit();
					array_push($main_dataArray, round($branch_total, 2));

				}

			}
			$finalData = array_sum($allChildRecords);
			array_push($main_dataArray, round($finalData, 2));
			array_push($finalArray, $main_dataArray);

		}


// print_r($finalArray);exit();

		$response['columnHeader'] = $columnHeader;
		$response['columnRows'] = $finalArray;
		$response['columnType'] = $source;
		echo json_encode($response);
	}

	public function scheduleView()
	{
		$year = $this->input->get('year');
		$month = $this->input->get('month');
		$company_id = $this->session->userdata('company_id');
		$country_master = $this->Master_Model->getQuarter();
		$company_ = $this->Master_Model->get_row_data(array('name'), array('id' => $company_id), 'company_master');
		$company_name = $company_->name;

		$this->load->view("Report/view_schedule", array("title" => "Consolidate Schedule", 'company' => $company_name, 'year' => $year, 'quarter' => $month, 'month' => $country_master[$month]));
	}

	public function getScheduleReportDataWithSequence()
	{
		$type = $this->input->post('type');
		$table = 'main_account_setup_master';
		$table2 = 'consolidate_report_transaction';
		if ($type == 2) {
			$table = 'main_account_setup_master_us';
			$table2 = 'consolidate_report_transaction_us';
		}
		if ($type == 3) {
			$table = 'main_account_setup_master_ifrs';
			$table2 = 'consolidate_report_transaction_ifrs';
		}
		$company_id = $this->session->userdata('company_id');
		$branchData = $this->Master_Model->
		_select("branch_master", array("company_id" => $company_id, "status" => 1), array("start_with", "id", "name"), false)->data;

		$filterArray = array();
		$getTotalData = $this->Master_Model->_select('' . $table2 . ' ct',
			array("company_id" => $company_id),
			array('*', '(select group_concat(ma.type3,' || ',ma.name) from ' . $table . ' ma where ma.company_id=ct.company_id and ma.main_gl_number=ct.account_number) as main_data'), false)->data;

		$where = array("company_id" => $company_id);

		$getBranchWithMainAccount = $this->Master_Model->_select('main_account_setup_master mm',
			$where,
			array('*', '(select sum(ud.opening_balance) from upload_financial_data ud where ud.company_id=mm.company_id and ud.gl_ac=mm.main_gl_number) as opening_balance', '(select sum(ud.debit) from upload_financial_data ud where ud.company_id=mm.company_id and ud.gl_ac=mm.main_gl_number) as debit', '(select sum(ud.credit) from upload_financial_data ud where ud.company_id=mm.company_id and ud.gl_ac=mm.main_gl_number) as credit'), false, array('main_gl_number'))->data;
		foreach ($getTotalData as $records) {
			foreach ($getBranchWithMainAccount as $account) {
				if ($account->main_gl_number === $records->account_number) {
					$filterArray[$account->main_gl_number][$records->branch_id][] = $records->total;
				}
			}

		}

		$finalArray = array();
		$cnt = 1;
		foreach ($getBranchWithMainAccount as $parent) {
			$main_dataArray = array();
			if ($parent->type0 == 'PL') {
				$type3 = $parent->type2;
			} else {
				$type3 = $parent->type3;
			}
			array_push($main_dataArray,
				$type3,//type 3

				$parent->name,// type4
				$parent->type0,//shedule
				$parent->sequence_number,//schedule number
				number_format($parent->credit),//credit
				number_format($parent->debit),//debit
				number_format($parent->opening_balance)//debit
			);

			$allChildRecords = array();
			if (array_key_exists($parent->main_gl_number, $filterArray)) {


				foreach ($branchData as $branch) {
					$BranchChildRecords = array();
					foreach ($filterArray[$parent->main_gl_number] as $key => $childRecords) {

						if ($key == $branch->id) {
							foreach ($childRecords as $childvalue) {
								array_push($BranchChildRecords, $childvalue);
								array_push($allChildRecords, $childvalue);
							}

						}
					}
				}

			}
			$finalData = array_sum($allChildRecords);
			array_push($main_dataArray, $finalData);// total
// array_push($finalArray, $main_dataArray);
			$finalArray[$parent->sequence_number][$type3][] = $main_dataArray;
			$cnt++;
		}

// print_r($finalArray);exit();

		$response['columnRows'] = $finalArray;
		echo json_encode($response);
	}

	function getDataConsolidate($month, $year, $company_id, $tableCons)
	{
		$q = $this->db->query("select account_number,total,total_1 from " . $tableCons . " where month=" . $month . " AND year=" . $year . " AND company_id=" . $company_id)->result();
		return $q;
	}

	function RunFinalConsolidation()
	{
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		$company_id = $this->session->userdata('company_id');
		$tableCons = $this->input->post('tableConsolidate');
		$main_account_master = $this->input->post('main_account_master');
		$tableSave = $this->input->post('tableSave');
		$q2 = $this->db->query("select id from branch_master where is_consolidated=1 AND company_id=".$company_id);
		$consolidatedBranch=false;
		if ($this->db->affected_rows() > 0) {
			$consolidatedBranch = $q2->row()->id;
		}
		$q = $this->db->query("select start_month from company_master where id=" . $company_id);
		$data = array();
		$whereMonth="";
		$whereYear="";
		if ($this->db->affected_rows() > 0) {
			$start_month = $q->row()->start_month;
			if ($start_month == 1) {
				$count = 12;
				$yearPrev = $year - 1;
				$data = $this->getDataConsolidate($count, $yearPrev, $company_id, $tableSave);
			} else {
				$yearPrev = $year;
				$count = $start_month - 1;
				$data = $this->getDataConsolidate($count, $yearPrev, $company_id, $tableSave);
			}
			$num=$start_month;
			$prev_array=array();
			$next_array=array();
			for($i=1;$i<=12;$i++){
				if($i<$num){
					$prev_array[]=$i;
				}else{
					$next_array[]=$i;
				}
			}

			$monthArray=(array_merge($next_array,$prev_array));

			$lastind= array_search($month,$monthArray);
			$data1=array_slice($monthArray,0,($lastind)+1);
			$data2=array_slice($monthArray,$lastind+1);
			$whereMonth=implode(",",$data1);
			if($start_month == 1){
				$whereYear=$year;
			}else{
				if($month >= $start_month){
					$whereYear=$year;
				}
				if($month < $start_month){
					$whereYear=$year.",".($year-1);
				}
			}


		}


		$LastYeardata = array();
		foreach ($data as $d) {
			$LastYeardata[$d->account_number] = array($d->total, $d->total_1);
		}
		$where='branch_id!=136';
		if($consolidatedBranch!="" && $consolidatedBranch!=null)
		{
			$where='branch_id!='.$consolidatedBranch;
		}

		$tableName = 'Table_' . $year . $month . $company_id;
		$this->db->query("DROP TABLE IF EXISTS " . $tableName);
		$queryCreateTable = $this->db->query("create table " . $tableName . " select account_number,debit_2,credit_2,opening_balance_2,total_2,branch_id,company_id,month,
(select type1 from " . $main_account_master . " where company_id=" . $company_id . " and main_gl_number =(c.account_number) limit 1 ) as type1,
(select is_divide from " . $main_account_master . " where company_id=" . $company_id . " and main_gl_number =(c.account_number) limit 1 ) as is_divide,
(select calculation_method from " . $main_account_master . " where company_id=" . $company_id . " and main_gl_number =(c.account_number) limit 1 ) as calculation_method,
(select bm.percentage from branch_master bm where bm.id=c.branch_id) as percentage,
(select bm.type from branch_master bm where bm.id=c.branch_id) as branch_type
 from consolidate_report_transaction c where company_id=" . $company_id . " and ".$where." and year = (" . $year . ") and month = (" . $month .")");

		if ($this->db->affected_rows() > 0) {
			$queryGetNewtableData = $this->db->query('select month,total_2,debit_2,credit_2,type1,percentage,opening_balance_2,account_number,branch_id,is_divide,calculation_method,branch_type
 from ' . $tableName . ' group by account_number , branch_id,month')->result();

			$group_Array = array();
			$calculationMethodArray = array();
			$typeArray = array();
			foreach ($queryGetNewtableData as $row) {

				$group_Array[$row->account_number][] = array($row->debit_2, $row->credit_2, $row->opening_balance_2, $row->is_divide, $row->percentage, $row->branch_type,$row->month,$row->total_2);
				$calculationMethodArray[$row->account_number] = $row->calculation_method;
				$typeArray[$row->account_number] = $row->type1;
			}


			/*$getTransferaccountsData=$this->Master_Model->_rawQuery("select *,(select parent_account_number from branch_account_setup where account_number=c.gl_ac and company_id=19 and branch_id=c.branch_id) as parentAct,
(select type1 from " . $main_account_master . "  where company_id=" . $company_id . " and main_gl_number =
(select parent_account_number from branch_account_setup where account_number=c.gl_ac and company_id=" . $company_id . " and branch_id=c.branch_id) limit 1) as type1,
 (select is_divide from " . $main_account_master . "  where company_id=" . $company_id . " and main_gl_number =
 (select parent_account_number from branch_account_setup where account_number=c.gl_ac and company_id=" . $company_id . " and branch_id=c.branch_id) limit 1) as is_divide,
 (select calculation_method from " . $main_account_master . "  where company_id=" . $company_id . " and main_gl_number =
 ((select parent_account_number from branch_account_setup where account_number=c.gl_ac and company_id=" . $company_id . " and branch_id=c.branch_id) limit 1)  ) as calculation_method, 
 (select bm.percentage from branch_master bm where bm.id=c.branch_id) as percentage, 
(select bm.type from branch_master bm where bm.id=c.branch_id) as branch_type from upload_financial_data c where company_id=" . $company_id . " and year = (" . $year . ") and quarter = (" . $month .") and is_transfer=1;");

			if($getTransferaccountsData->totalCount > 0){
				$resultDataTransfer=$getTransferaccountsData->data;
				foreach ($resultDataTransfer as $data1){
					$group_Array[$data1->parentAct][] = array($data1->debit, $data1->credit, 0, $data1->is_divide, $data1->percentage, $data1->branch_type,$data1->quarter);
					$typeArray[$data1->parentAct] = $data1->type1;
				}
			}*/


			$insertDataArray = array();
			$insertDataArrayConsolidated = array();
			if (count($group_Array) > 0) {
				foreach ($group_Array as $key => $item) {

					$debit = 0;
					$credit = 0;
					$openingBal = 0;
					$total = 0;

					$debit_1 = 0;
					$credit_1 = 0;
					$openingBal_1 = 0;
					$total_1 = 0;
					foreach ($item as $i) {

						/*$is_divide = $i[3];
						if ($is_divide == 1) {
							$percentage = $i[4];
							$remainPer = 100 - $percentage;

							if (array_key_exists($key,$calculationMethodArray) && $calculationMethodArray[$key] == 'Parent') {
								if ($i[5] == 'parent') {
									$debit += ($i[0] * $percentage) / 100;
									$credit += ($i[1] * $percentage) / 100;
									$openingBal += ($i[2] * $percentage) / 100;

									$debit_1 += ($i[0] * $remainPer) / 100;
									$credit_1 += ($i[1] * $remainPer) / 100;
									if($month == $i[6]){
										$openingBal_1 += ($i[2] * $remainPer) / 100;
									}

								}
							} else {
								$debit += ($i[0] * $percentage) / 100;
								$credit += ($i[1] * $percentage) / 100;
								$openingBal += ($i[2] * $percentage) / 100;

								$debit_1 += ($i[0] * $remainPer) / 100;
								$credit_1 += ($i[1] * $remainPer) / 100;
								if($month == $i[6]) {
									$openingBal_1 += ($i[2] * $remainPer) / 100;
								}
							}


						} else {

							if (array_key_exists($key,$calculationMethodArray) && $calculationMethodArray[$key] == 'Parent') {
								if ($i[5] == 'parent') {
									$debit += $i[0];
									$credit += $i[1];
									if ($month == $i[6]) {
										$openingBal += $i[2];
									}
								}
							}else{
								$debit += $i[0];
								$credit += $i[1];
								if ($month == $i[6]) {
									$openingBal += $i[2];
								}
							}
						}*/
						$debit += $i[0];
						$credit += $i[1];
						$openingBal += $i[2];
						$total += $i[7];
					}
					$type = $typeArray[$key];
					//if ($type == "EQUITY AND LIABILITIES" || $type == "REVENUE") {


						/*if ($openingBal_1 != 0 || $credit_1 != 0 || $debit_1 != 0) {
							$total_1 = ($openingBal_1 + $debit_1 - $credit_1);
						}
						$total = ($openingBal + $debit- $credit);*/
				//	}
				/*	if ($type == "ASSETS" || $type == "EXPENSES") {

						if ($openingBal_1 != 0 || $credit_1 != 0 || $debit_1 != 0) {
							$total_1 = ($debit_1 - $credit_1) + $openingBal_1;
						}
						$total = ($debit - $credit) + $openingBal;

					}*/

					$data = array(
						"account_number" => $key,
						"month" => $month,
						"year" => $year,
						"company_id" => $company_id,
						"final_total" => $total,
						"total" => $total,
						"debit" => $debit,
						"credit" => $credit,
						"opening_balance" => $openingBal,
						"total_1" => $total_1,
						"debit_1" => $debit_1,
						"credit_1" => $credit_1,
						"opening_balance_1" => $openingBal_1,
						"create_by" =>  $this->session->userdata("user_id")
					);
					array_push($insertDataArray, $data);

					$data_ConsolidationBranch = array(
						"account_number" => $key,
						"branch_id" => $consolidatedBranch,
						"final_total" => $total,
						"total" => $total,
						"debit" => $debit,
						"credit" => $credit,
						"opening_balance" => $openingBal,
						"month" => $month,
						"year" => $year,
						"company_id" => $company_id,
						"total_1" => $total,
						"debit_1" => $debit,
						"credit_1" => $credit,
						"opening_balance_1" => $openingBal_1,
						"total_2" => $total,
						"debit_2" => $debit,
						"credit_2" => $credit,
						"opening_balance_2" => $openingBal,
						"is_consolidated" => 1,
						"create_by" => $this->session->userdata("user_id"),
					);

					array_push($insertDataArrayConsolidated, $data_ConsolidationBranch);
				}
				$result = FALSE;
				if (count($insertDataArray) > 0) {
					try {
						$this->db->trans_start();

						$this->db->delete($tableSave, array("month" => $month, "year" => $year, "company_id" => $company_id));
						$this->db->insert_batch($tableSave, $insertDataArray);
						//$consolidatedBranch
						if($consolidatedBranch != false){
							$this->db->delete('consolidate_report_transaction', array("month" => $month, "year" => $year, "company_id" => $company_id, "branch_id" => $consolidatedBranch,'is_consolidated'=>1));
							$this->db->insert_batch('consolidate_report_transaction', $insertDataArrayConsolidated);
						}
						if ($this->db->trans_status() === FALSE) {
							$this->db->trans_rollback();
							log_message('info', "insert user Transaction Rollback");
							$result = FALSE;
						} else {
							$this->db->trans_commit();
							log_message('info', "insert user Transaction Commited");
							$this->db->query("DROP TABLE IF EXISTS " . $tableName);
							$result = TRUE;
						}
						$this->db->trans_complete();
					} catch (Exception $exc) {
						log_message('error', $exc->getMessage());
						$result = FALSE;
					}
				}
				if ($result == true) {
					$this->db->query("DROP TABLE IF EXISTS " . $tableName);
					$response['status'] = 200;
					$response['body'] = "Consolidated Successfully";

				} else {
					$this->db->query("DROP TABLE IF EXISTS " . $tableName);
					$response['status'] = 201;
					$response['body'] = "Failed to consolidate";
				}
			} else {
				$this->db->query("DROP TABLE IF EXISTS " . $tableName);
				$response['status'] = 201;
				$response['body'] = "Data Not Found";
			}
		} else {
			$this->db->query("DROP TABLE IF EXISTS " . $tableName);
			$response['status'] = 201;
			$response['body'] = "Something went Wrong";
		}
		echo json_encode($response);
	}

	function getFinalTotalDataDB()
	{
		$company_id = $this->session->userdata('company_id');
		$type = $this->input->post('type');
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		$div = $this->input->post('div');
		$table = '';
		$table2 = '';

		if ($div == 'FinalReportSheetIND') {
			$table = 'consolidate_report_all_data_ind cr';
			$table2 = "main_account_setup_master";
		}
		if ($div == 'FinalReportSheetUS') {
			$table = 'consolidate_report_all_data_us cr';
			$table2 = "main_account_setup_master_us";
		}
		if ($div == 'FinalReportSheetIFRS') {
			$table = 'consolidate_report_all_data_ifrs cr';
			$table2 = "main_account_setup_master_ifrs";
		}
		$columnHeader = array("Parent Code","Detail", "Opening_Balance_1", "Debit_1", "Credit_1", "Total_1", "Opening_Balance_2", "Debit_2", "Credit_2", "Total_2");
		$source = array("text","text","Numeric", "Numeric", "Numeric", "Numeric", "Numeric", "Numeric", "Numeric", "Numeric");
		$query = $this->Master_Model->_rawQuery("select * from " . $table . " where month=" . $month . " AND year=" . $year . " AND company_id=" . $company_id);
		$finalArray = array();
		if ($query->totalCount > 0) {
			$result = $query->data;
			foreach ($result as $row) {
				$name = $this->Master_Model->_select($table2,array('company_id'=>$company_id,'main_gl_number'=>$row->account_number,'status'=>1),'name',true)->data;
			//	var_dump($name);
				if(!is_null($name)){
					$data = array(
						$row->account_number,
						isset($name) ? $name->name : "",
						$row->opening_balance,
						$row->debit,
						$row->credit,
						$row->total,
						$row->opening_balance_1,
						$row->debit_1,
						$row->credit_1,
						$row->total_1,
					);
					array_push($finalArray, $data);
				}

			}
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

	public function getErrors()
	{
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$type = $this->input->post('type');
		$company_id = $this->session->userdata('company_id');
		$branchData = $this->Master_Model->_select('branch_master', array('company_id' => $company_id,'status'=>1,'is_special_branch'=>0,'is_consolidated'=>0), '*', false)->data;
		$uploadData = array();
		$parentData = array();
		$is_error = false;
		if ($branchData != null) {
			foreach ($branchData as $branch) {
				$checkifDataUploaded = $this->Master_Model->get_count(array('company_id' => $company_id, 'branch_id' => $branch->id,'quarter' => $month, 'year' => $year,), 'upload_financial_data');
				if ($checkifDataUploaded == 0) {
					$data = array('branch_id' => $branch->id, 'Name' => $branch->name);
					array_push($uploadData, $data);
				}
				$CurrencyConversion = $this->Master_Model->get_count(array('quarter' => $month, 'year' => $year, 'company_id' => $company_id), 'currency_conversion_master');
				if ($CurrencyConversion == 0) {
					$is_error = true;
				}
			}

			$where_parent = '(parent_account_number is null or parent_account_number = "")';
			$where_parent1 = '(parent_account_number is not null and parent_account_number != "")<>0';
			$table = "main_account_setup_master";
			$select = "parent_account_number";
			if($type == 2)
			{
				$where_parent = "(parent_account_number_us is null or parent_account_number_us = '')";
				$where_parent1 = "(parent_account_number_us is not null and parent_account_number_us != '')<>0";
				$table = "main_account_setup_master_us";
				$select = "parent_account_number_us";
			}
			if($type == 3)
			{
				$where_parent = "(parent_account_number_ifrs is null or parent_account_number_ifrs = '')";
				$where_parent1 = "(parent_account_number_ifrs is not null and parent_account_number_ifrs != '')<>0";
				$table = "main_account_setup_master_ifrs";
				$select = "parent_account_number_ifrs";
			}
			$checkParent = $this->Master_Model->_rawQuery("select distinct(select name from branch_master where id = branch_id) as name from branch_account_setup 
				where ".$where_parent." and branch_id in (select id from branch_master where company_id = " . $company_id . " and is_special_branch=0) and company_id = " . $company_id . " AND status=1")->data;

			if (count($checkParent) > 0) {
				foreach ($checkParent as $row) {
					$data = array(
						'branch' => $row->name
					);
					array_push($parentData, $data);
				}
			}


			$branchaccountSetup = $this->Master_Model->
			_rawQuery('select distinct '.$select.' from branch_account_setup where company_id ='.$company_id.' and status = 1 and '.$where_parent1.' and branch_id in (select id from branch_master where company_id = '.$company_id.' and status = 1) ');
			$branchaccount = array();
			if($branchaccountSetup->totalCount > 0)
			{
				$branchaccount = $branchaccountSetup->data;
				$branchaccount = array_column($branchaccount,$select);
			}

			$mainaccounts = array();
			$mainaccounts_array = $this->Master_Model
				->_select($table,array('company_id'=>$company_id,'status'=>1),'main_gl_number',false);
			if($mainaccounts_array->totalCount > 0)
			{
				$mainaccounts_array = $mainaccounts_array->data;
				$mainaccounts = array_column($mainaccounts_array,'main_gl_number');
			}
			$mainMapping = array();
			if(count($branchaccount) > 0  && count($mainaccounts)>0)
			{
				$mainMappingdata = array_diff($branchaccount,$mainaccounts);
				if(count($mainMappingdata)>0)
				{
					foreach($mainMappingdata as $row)
					{
						$data = array(
						'main' => $row,
						);
						array_push($mainMapping,$data);
					}
				}
			}



			$response['status'] = 200;
			if ($is_error == true) {
				$response['Currency'] = 1;
			} else {
				$response['Currency'] = 0;
			}
			if ($uploadData != null) {
				$response['uploadData'] = $uploadData;
			} else {
				$response['uploadData'] = 0;
			}

			if ($parentData != null || !empty($parentData)) {
				$response['parent'] = $parentData;
			} else {
				$response['parent'] = 0;
			}

			if(count($mainMapping)>0 || !empty($mainMapping))
			{
				$response['main'] = $mainMapping;
			}
			else
			{
				$response['main'] = 0;
			}
			$query3=$this->Master_Model->_rawQuery("select * from block_year_data where status=1 AND company_id=".$company_id." AND year=".$year." AND month=".$month);
			if($query3->totalCount > 0){
				$response['BlockYear'] = 1;
			}else{
				$response['BlockYear'] = 0;
			}
			echo json_encode($response);
		} else {
			$response['status'] = 201;
			$response['data'] = "No Branches Found for This Company";
			echo json_encode($response);
		}
	}
	function getSpecialExchangedata($month,$year)
	{
		$data=array();
		$company_id = $this->session->userdata('company_id');
		$query3=$this->Master_Model->_rawQuery("select * from special_exchange_rate where company_id=".$company_id." AND year=".$year." AND month=".$month);
		if($query3->totalCount > 0){
			foreach ($query3->data as $row)
			{
				$data[$row->branch_id][$row->parent_account_number][$row->gl_ac]=$row->exchange_rate;
			}
		}
		return $data;
	}
	function getAdditionGLData($month,$year)
	{
		$data=array();
		$company_id = $this->session->userdata('company_id');
		$query3=$this->Master_Model->_rawQuery("select * from special_additionGL_rate where type=1 AND company_id=".$company_id." AND year=".$year." AND month=".$month);
		if($query3->totalCount > 0){
			foreach ($query3->data as $row)
			{
				$data[$row->branch_id][$row->parent_account_number][$row->gl_ac]=$row->exchange_rate;
			}
		}
		return $data;
	}
	function getAuditorAdjustmentGLData($month,$year)
	{
		$data=array();
		$company_id = $this->session->userdata('company_id');
		$query3=$this->Master_Model->_rawQuery("select * from special_auditorAdjustmentGL_rate where company_id=".$company_id." AND year=".$year." AND month=".$month);
		if($query3->totalCount > 0){
			foreach ($query3->data as $row)
			{
				$data[$row->branch_id][$row->parent_account_number][$row->gl_ac]=$row->rate;
			}
		}
		return $data;
	}
}
