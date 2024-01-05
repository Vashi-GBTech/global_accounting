<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property  Master_Model Master_Model
 */
class DataAnalyticsController extends CI_Controller
{

	public function DataAnalytics()
	{
		$this->load->view("DataAnalytics/data_analytics",array("title"=>"Data Analytics"));
	}

	public function getDataAnalyticsData()
	{
		if (!is_null($this->input->post('type'))) {
			$type=$this->input->post('type');
			$year=$this->input->post('year');
			$month=$this->input->post('month');
			$number_conversion=$this->input->post('valueIn');
			$company_id = $this->session->userdata('company_id');
			//
			$divide = 1;
			if ($number_conversion == 2) { //Millions
				$divide = 1000000;
			}
			if ($number_conversion == 3) { //Crores
				$divide = 10000000;
			}
			if($type=='TD')
			{
				$resultObject=$this->Master_Model->_rawQuery("SELECT * FROM main_account_setup_master where status=1 and company_id='".$company_id."'");
				$consolidateResult=$this->Master_Model->_rawQuery("select * from upload_intra_company_transfer where company_id=".$company_id." and year='".$year."' and quarter='".$month."' and approve_status=1");
			}
			else{
				$resultObject=$this->Master_Model->_rawQuery("SELECT * FROM main_account_setup_master where status=1 and type0='".$type."' and company_id='".$company_id."'");
				$consolidateResult=$this->Master_Model->_rawQuery("select total as total,branch_id,account_number from consolidate_report_transaction where account_number in 
										(select main_gl_number from main_account_setup_master where type0='".$type."' and company_id=".$company_id." and status=1 and year='".$year."' and month='".$month."')");
			}
			$IntraInterMapping=$this->Master_Model->_select('subsidiary_mapping',array('company_id'=>$company_id),'*');

			$consolidateBranch=array();
			if($consolidateResult->totalCount>0)
			{
				if($type=='BS' || $type=='PL')
				{
					foreach ($consolidateResult->data as $crow)
					{
						$consolidateBranch[$crow->account_number][$crow->branch_id][]=$crow->total;
					}
				}
				else{
					foreach ($consolidateResult->data as $crow)
					{
						$consolidateBranch[$crow->from_gl_account][$crow->from_branch_id][]=$crow->from_totalValue;
						$consolidateBranch[$crow->to_gl_account][$crow->to_branch_id][]=$crow->to_totalValue;
						if($IntraInterMapping->totalCount>0)
						{
							//intra branch account
							if($crow->transfer_type==1)
							{
								if($IntraInterMapping->data->intra_gl_account==$crow->difference_gl || $IntraInterMapping->data->intra_gl_account_pl==$crow->difference_gl)
								{
									$consolidateBranch[$crow->difference_gl][$IntraInterMapping->data->intra_branch_id][]=$crow->final_value;
								}
							}
							else{
								if($IntraInterMapping->data->inter_gl_account==$crow->difference_gl || $IntraInterMapping->data->inter_gl_account_pl==$crow->difference_gl)
								{
									$consolidateBranch[$crow->difference_gl][$IntraInterMapping->data->inter_branch_id][]=$crow->final_value;
								}
							}
						}
					}
				}
			}
			if($resultObject->totalCount>0)
			{
				$type1Array=array();
				$dataAnalyticsArray=array();
				foreach ($resultObject->data as $row)
				{
					if($type=='BS')
					{
						$dataAnalyticsArray[$row->type1][$row->type2][$row->type3][]=$row;
					}
					else if($type=='PL'){
						$dataAnalyticsArray[$row->type1][$row->type2][]=$row;
					}
					else
					{
						$dataAnalyticsArray[$row->type1][$row->type2][$row->type3][]=$row;
					}

				}

				$branchData = $this->Master_Model->_select("branch_master", array("company_id" => $company_id, "status" => 1), array("start_with", "id", "name", "currency"), false,null,null,"is_consolidated asc,is_special_branch asc")->data;
				$table='';
				if(count($dataAnalyticsArray)>0)
				{
				$table.='<table>
						<thead>
							<tr>
								<th class="first_th"></th>';
					$table.=$this->getTdColumns('',1);
					if($type=='TD') {
						$table .= '<th>Transfer Total</th>';
					}
				$table.='	</tr>
						</thead>';
				$table.='<tbody>';
					$t3Cnt=1;
				foreach ($dataAnalyticsArray as $type1Key => $type1Row) {
					$table .= '	<tr>
								<td class="type1">'.$type1Key.'</td>';
					$table.=$this->getTdColumns('type1',2);
					if($type=='TD') {
						$table .= '<td class="type1"></td>';
					}
					$table .= '</tr>';
					if($type=='BS' || $type=='TD')
					{
						foreach ($type1Row as $type2Key => $type2Row)
						{
							$table .= '	<tr>
								<td class="type2">'.$type2Key.'</td>';
							$table.=$this->getTdColumns('type2',2);
							if($type=='TD') {
								$table .= '<td class="type2"></td>';
							}
							$table .= '</tr>';

							foreach ($type2Row as $type3Key => $type3Row)
							{
								$childRowType2='';
								$glBranchTypeCount=array();
								$transferGlBranchTypeCount=array();
								foreach ($type3Row as $glKey => $glRow)
								{

									$childRowType2 .= '	<tr class="GlDiv1'.$t3Cnt.' collapse">
								<td class="glTr">'.$glRow->main_gl_number.' <span class="glDetail">('.$glRow->name.')</span></td>';
//								$table.=$this->getTdColumns('',2);
									$transferAmtArr=array();
									foreach ($branchData as $brow)
									{
										$value=0;
//										print_r($consolidateBranch);exit();
										if(array_key_exists($glRow->main_gl_number,$consolidateBranch))
										{
											$glKey=$consolidateBranch[$glRow->main_gl_number];

											if(array_key_exists($brow->id,$glKey))
											{
												if($type=='BS')
												{
													$value=round(array_sum($glKey[$brow->id]),2);
												}
												else
													{
													$value=round(array_sum($glKey[$brow->id]),2);
												}
											}
										}
										$value=$value/$divide;
										$glBranchTypeCount[$brow->id][]=$value;
										if($type=='TD')
										{
											$childRowType2.='<td>'.round($value,2).' <button class="btn btn-info valueButton ml-2" onclick="showDataAnalyticsTransferTransaction(\''.$brow->id.'\',\''.$glRow->main_gl_number.'\',\''.$brow->name.'\')">
											<i class="fa fa-eye"></i></button></td>';
										}
										else{
											$childRowType2.='<td>'.round($value,2).' <button class="btn btn-info valueButton ml-2" onclick="showDataAnalyticsTransaction(\''.$brow->id.'\',\''.$glRow->main_gl_number.'\',\''.$brow->name.'\')">
											<i class="fa fa-eye"></i></button></td>';
										}
										if($type=='TD')
										{

											array_push($transferAmtArr,$value);

										}

									}
									if($type=='TD') {
										$childRowType2 .= '<td>' . round(array_sum($transferAmtArr), 2) . '</td>';
									}
									$childRowType2 .= '</tr>';
								}
								$table .= '	<tr>
								<td class="type3"><button class="btn btn-info btn-sm plusButton" data-toggle="collapse" data-target=".GlDiv1'.$t3Cnt.'">
											<i class="fa fa-plus"></i>
										</button> '.$type3Key.'</td>';
//							$table.=$this->getTdColumns('',2);
								foreach ($branchData as $brow)
								{
									$type3count=round(array_sum($glBranchTypeCount[$brow->id]),2);
//								print_r($type3count);exit();
									$table .= '<td class="type3value">'.$type3count.'</td>';
									if($type=='TD')
									{
										array_push($transferGlBranchTypeCount,$type3count);

									}
								}
								if($type=='TD') {
									$transfertype3count=round(array_sum($transferGlBranchTypeCount),2);
									$table .= '<td><b>'.$transfertype3count.'</b></td>';
								}
								$table .= '</tr>';
								$table.=$childRowType2;
								$t3Cnt++;
							}
						}
					}
					else if($type=='PL'){
							foreach ($type1Row as $type3Key => $type3Row)
							{
								$childRowType2='';
								$glBranchTypeCount=array();
								foreach ($type3Row as $glKey => $glRow)
								{
									$childRowType2 .= '	<tr class="GlDiv1'.$t3Cnt.' collapse">
								<td class="glTr">'.$glRow->main_gl_number.' <span class="glDetail">('.$glRow->name.')</span></td>';

									foreach ($branchData as $brow)
									{
										$value=0;
										if(array_key_exists($glRow->main_gl_number,$consolidateBranch))
										{
											$glKey=$consolidateBranch[$glRow->main_gl_number];
											if(array_key_exists($brow->id,$glKey))
											{
												$value=round(array_sum($glKey[$brow->id]),2);
											}
										}
										$value=$value/$divide;
										$glBranchTypeCount[$brow->id][]=$value;
										$childRowType2.='<td>'.round($value,2).' <button class="btn btn-info valueButton ml-2" onclick="showDataAnalyticsTransaction(\''.$brow->id.'\',\''.$glRow->main_gl_number.'\',\''.$brow->name.'\')">
											<i class="fa fa-eye"></i></button></td>';
									}
									$childRowType2 .= '</tr>';
								}
								$table .= '	<tr>
								<td><button class="btn btn-info btn-sm plusButton" data-toggle="collapse" data-target=".GlDiv1'.$t3Cnt.'">
											<i class="fa fa-plus"></i>
										</button> '.$type3Key.'</td>';

								foreach ($branchData as $brow)
								{
									$type3count=round(array_sum($glBranchTypeCount[$brow->id]),2);
									$table .= '<td class="type3value">'.$type3count.'</td>';
								}
								$table .= '</tr>';
								$table.=$childRowType2;
								$t3Cnt++;
							}
					}

				}

				$table.='</tbody>';

				$table.='</table>';
				}
//				print_r($dataAnalyticsArray);exit();
				$response['status']=200;
				$response['data']=$table;
			}
			else{
				$response['status']=201;
			}
		}
		else{
			$response['status']=201;
		}
		echo json_encode($response);
	}
	function getTdColumns($classT='',$type=1)
	{

		$table='';
		$company_id = $this->session->userdata('company_id');
		$branchData = $this->Master_Model->_select("branch_master", array("company_id" => $company_id, "status" => 1), array("start_with", "id", "name", "currency"), false,null,null,"is_consolidated asc,is_special_branch asc")->data;
		if($type==1)
		{
			if(count($branchData)>0)
			{
				foreach ($branchData as $brow)
				{
					$table.='<th>'.$brow->name.'</th>';
				}
			}
		}
		if($type==2)
		{
			$class='';
			if($classT!="")
			{
			 	$class='class="'.$classT.'"';
			}
			if (count($branchData) > 0) {
				foreach ($branchData as $brow) {
					$table .= '<td '.$class.'></td>';
				}
			}
		}

		return $table;
	}
	function showDataAnalyticsTransaction()
	{
		$year=$this->input->post('year');
		$month=$this->input->post('month');
		$branchId=$this->input->post('branchId');
		$Gl_number=$this->input->post('Gl_number');
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');
		$month_array = $this->Master_Model->getQuarter();
		$number_conversion=$this->input->post('valueIn');
		$divide = 1;
		if ($number_conversion == 2) { //Millions
			$divide = 1000000;
		}
		if ($number_conversion == 3) { //Crores
			$divide = 10000000;
		}
		$where=array();
//		$resultObject=$this->Master_Model->_rawQuery('select * from upload_financial_data where company_id="'.$company_id.'" and branch_id="'.$branchId.'" and
// 							find_in_set(gl_ac,(select group_concat(account_number) from branch_account_setup where parent_account_number="'.$Gl_number.'"))');
		$mbData = $this->db
			->select(array("*"))
			->where('branch_id',$branchId)
			->where('company_id',$company_id)
			->where('year',$year)
			->where('quarter',$month)
			->where('(find_in_set(gl_ac,(select group_concat(account_number) from branch_account_setup where parent_account_number="'.$Gl_number.'")) or gl_ac="'.$Gl_number.'")')
			->order_by('id','desc')
			->get("upload_financial_data")->result();
		$query=$this->db->last_query();
		$tableRows = array();
		if (count($mbData) > 0) {
			$i=1;
			foreach ($mbData as $order) {
					$total=$order->opening_balance+($order->debit-$order->credit);
					$total=$total/$divide;
				array_push($tableRows, array($i,
						$order->gl_ac,
						$order->opening_balance/$divide,
						$order->debit/$divide,
						$order->credit/$divide,
						$total,
						$month_array[$order->quarter],
						$order->quarter)
				);
				$i++;
			}
		}
		$results = array(
			"draw" => 1,
			"recordsTotal" => count($mbData),
			"recordsFiltered" => count($mbData),
			"data" => $tableRows,
			"query" => $query
		);

		echo json_encode($results);
	}
	function TransferDataTableTransaction()
	{
		$year=$this->input->post('year');
		$month=$this->input->post('month');
		$branchId=$this->input->post('branchId');
		$Gl_number=$this->input->post('Gl_number');
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');
		$month_array = $this->Master_Model->getQuarter();
		$number_conversion=$this->input->post('valueIn');
		$divide = 1;
		if ($number_conversion == 2) { //Millions
			$divide = 1000000;
		}
		if ($number_conversion == 3) { //Crores
			$divide = 10000000;
		}
		$mbData = $this->db
			->select('(select name from branch_master where id= from_branch_id) as from_branch,from_gl_account,
			(select name from branch_master where id= to_branch_id) as to_branch,to_gl_account,final_value,difference_gl')
			->where('company_id',$company_id)
			->where('year',$year)
			->where('quarter',$month)
			->where('((from_branch_id="'.$branchId.'" and from_gl_account="'.$Gl_number.'") or (to_branch_id="'.$branchId.'" and to_gl_account="'.$Gl_number.'"))')
			->order_by('id','desc')
			->get("upload_intra_company_transfer")->result();
		$query=$this->db->last_query();
		$tableRows = array();
		if (count($mbData) > 0) {
			$i=1;
			foreach ($mbData as $order) {
				$order->final_value=$order->final_value/$divide;
				array_push($tableRows, array($i,
						$order->from_branch,
						$order->from_gl_account,
						$order->to_branch,
						$order->to_gl_account,
						$order->final_value,
						$order->difference_gl,
						$month_array[$order->quarter],
						$order->quarter)
				);
				$i++;
			}
		}
		$results = array(
			"draw" => 1,
			"recordsTotal" => count($mbData),
			"recordsFiltered" => count($mbData),
			"data" => $tableRows,
			"query" => $query
		);

		echo json_encode($results);
	}
	public function showDataAnalyticsTransferTransaction()
	{
		$year=$this->input->post('year');
		$month=$this->input->post('month');
		$branchId=$this->input->post('branchId');
		$Gl_number=$this->input->post('Gl_number');
		$transferFilter=$this->input->post('transferFilter');
		$branchName=$this->input->post('branchName');
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');
		$number_conversion=$this->input->post('valueIn');
		$divide = 1;
		if ($number_conversion == 2) { //Millions
			$divide = 1000000;
		}
		if ($number_conversion == 3) { //Crores
			$divide = 10000000;
		}

		$IntraInterMapping=$this->Master_Model->_select('subsidiary_mapping',array('company_id'=>$company_id),'*');
		$diffwhere='';
		if($IntraInterMapping->totalCount>0)
		{
			if($IntraInterMapping->data->intra_branch_id==$branchId || $IntraInterMapping->data->inter_branch_id==$branchId)
			{
				if($IntraInterMapping->data->intra_branch_id==$branchId)
				{
					$diffwhere.=' or (difference_gl="'.$Gl_number.'" and transfer_type=1) or (from_gl_account="'.$Gl_number.'" and transfer_type=1) or (`to_gl_account` = "'.$Gl_number.'" and transfer_type=1)';
				}
				else{
					$diffwhere.='or (difference_gl="'.$Gl_number.'" and transfer_type=2) or (from_gl_account="'.$Gl_number.'" and transfer_type=2) or (`to_gl_account` = "'.$Gl_number.'" and transfer_type=2)';
				}
			}
		}
		$where='((from_branch_id="'.$branchId.'" and from_gl_account="'.$Gl_number.'") or (to_branch_id="'.$branchId.'" and to_gl_account="'.$Gl_number.'") '.$diffwhere.')';

//		if($transferFilter==2)
//		{
//			$where='((from_branch_id="'.$branchId.'" and from_gl_account="'.$Gl_number.'"))';
//		}
//		else if($transferFilter==3)
//		{
//
//			$where='(difference_gl="'.$Gl_number.'" and transfer_type="'.$transferType.'")';
//		}
//		else{
//			$where='((to_branch_id="'.$branchId.'" and to_gl_account="'.$Gl_number.'"))';
//		}
		$mbData = $this->db
			->select('(select name from branch_master where id= from_branch_id) as from_branch,from_gl_account,from_totalValue,from_currency_rate,
			(select name from branch_master where id= to_branch_id) as to_branch,to_gl_account,final_value,to_totalValue,to_currency_rate,difference_gl')
			->where('company_id',$company_id)
			->where('year',$year)
			->where('quarter',$month)
			->where($where)
			->order_by('id','desc')
			->get("upload_intra_company_transfer")->result();

		$query=$this->db->last_query();

//		print_r($query);exit();
		$table='';
		$debcreTable='<table>
							<thead>
								<tr>
									<td colspan="3">
										Credit
									</td>
								</tr>
								<tr>
									<td>Subsidiary</td>
									<td>GL No.</td>
									<td>Amount</td>
								</tr>
								<tr>
									<td colspan="3">
										Debit
									</td>
								</tr>
								<tr>
									<td>Subsidiary</td>
									<td>GL No.</td>
									<td>Amount</td>
								</tr>
								<tr>
									<td colspan="2">
										Total
									</td>
									<td></td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td></td>
								</tr>
							</tbody>
						</table>';
		$debTable="";
		$creTable="";
//		if(count($mbData)>0)
//		{
//			$tableRows = array();
//			foreach ($mbData as $row)
//			{
//				if($row->from_debit!=null && $row->from_debit!=0)
//				{
//					$debTable.='<tr>
//						<td>'.$row->to_branch.'</td>
//						<td>'.$row->to_gl_account.'</td>
//						<td>'.$row->from_totalValue/$divide.'</td>
//					</tr>';
//					array_push($tableRows,$row->from_totalValue);
//				}
//				if($row->to_credit!=null && $row->to_credit=0)
//				{
//					$creTable.='<tr>
//						<td>'.$row->from_branch.'</td>
//						<td>'.$row->from_gl_account.'</td>
//						<td>'.$row->to_totalValue/$divide.'</td>
//					</tr>';
//					array_push($tableRows,$row->to_totalValue);
//				}
//			}
//		}
//		print_r($mbData);exit();
		if(count($mbData)>0)
		{
			$transferFrom='<tr>
						<td colspan="3"><b>Transfer From '.$branchName.'</b></td>
					</tr>';
			$transferTo='<tr>
						<td colspan="3"><b>Transfer To '.$branchName.'</b></td>
					</tr>';
			$differance='<tr>
						<td colspan="3"><b>Differance</b></td>
					</tr>';
			$tableRows = array();
			foreach ($mbData as $row)
			{
				if($Gl_number==$row->difference_gl)
				{
					if($row->final_value!=0)
					{
						$differance.='<tr>
							<td> </td>
							<td>'.$row->difference_gl.'</td>
							<td>'.$row->final_value/$divide.'</td>
						</tr>';
						array_push($tableRows,$row->final_value);
					}
				}
				if($Gl_number==$row->from_gl_account)
				{
					$transferFrom.='<tr>
						<td>'.$row->to_branch.'</td>
						<td>'.$row->to_gl_account.'</td>
						<td>'.$row->from_totalValue/$divide.'</td>
					</tr>';
					array_push($tableRows,$row->from_totalValue);
				}
				if($Gl_number==$row->to_gl_account)
				{
					$transferTo.='<tr>
						<td>'.$row->from_branch.'</td>
						<td>'.$row->from_gl_account.'</td>
						<td>'.$row->to_totalValue/$divide.'</td>
					</tr>';
					array_push($tableRows,$row->to_totalValue);
				}
			}
			$table.=$transferFrom;
			$table.='<tr><td colspan="3"></td></tr>';
			$table.=$transferTo;
			$table.='<tr><td colspan="3"></td></tr>';
			$table.=$differance;

			$results['status']=200;
			$results['data']=$table;
			$results['total']=round(array_sum($tableRows)/$divide,2);
			$results['query']=$query;
		}
		else{
			$results['status']=201;
			$results['data']=$table;
			$results['query']=$query;
		}

		echo json_encode($results);
	}
	public function getscheduleTrnsactions()
	{
		$year=$this->input->post('year');
		$month=$this->input->post('month');
		$branchId=$this->input->post('branchId');
		$Gl_number=$this->input->post('Gl_number');
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');
		$mbData=$this->getScheduleData($branchId,$Gl_number,$year,$month);
		$number_conversion=$this->input->post('valueIn');
		$divide = 1;
		if ($number_conversion == 2) { //Millions
			$divide = 1000000;
		}
		if ($number_conversion == 3) { //Crores
			$divide = 10000000;
		}
		$query=$this->db->last_query();
		$tableRows = array();
		if (count($mbData) > 0) {
			$i=1;
			foreach ($mbData as $order) {
//				print_r($order);exit();
				array_push($tableRows, array($i,
						$order['template_name'],
						$order['paticular'],
						$Gl_number,
						$order['value']/$divide)
				);
				$i++;
			}
		}
		$results = array(
			"draw" => 1,
			"recordsTotal" => count($mbData),
			"recordsFiltered" => count($mbData),
			"data" => $tableRows,
			"query" => $query
		);

		echo json_encode($results);
	}
	function getScheduleData($branch_id,$Gl_number,$year,$month){
		$company_id = $this->session->userdata("company_id");

		$query=$this->Master_Model->_rawQuery("select *,(select template_name from handson_template_master tm where tm.id=template_id) as template_name from handson_rupees_conversion_table where branch_id=".$branch_id." and year=".$year." and month=".$month." and status=1 and column_1 in (select column_1 from handson_prefill_table where branch_id=".$branch_id.") order by id asc ");
		$arrayData=array();
		if($query->totalCount > 0){
			foreach ($query->data as $key=>$row){
//				print_r($row);exit();
				for($i=2;$i<=15;$i++){
					$colVal="column_".$i;
					if($row->$colVal == null || $row->$colVal==""){
						$row->$colVal=0;
					}
					$arrayData[$row->template_id][$colVal][]=array('value'=>$row->$colVal,'particular'=>$row->column_1,'templateName'=>$row->template_name);
				}
			}
		}

		$queryoLD=$this->Master_Model->_rawQuery("select *,(select template_name from handson_template_master tm where tm.id=template_id) as template_name from handson_transaction_table where branch_id=".$branch_id." and year=".$year." and month=".$month." and status=1 and column_1 in (select column_1 from handson_prefill_table where branch_id=".$branch_id.") order by id asc ");
		$arrayDataOld=array();
		if($queryoLD->totalCount > 0){
			foreach ($queryoLD->data as $rowo){
				for($i=2;$i<=15;$i++){
					$colVal="column_".$i;
					if($rowo->$colVal == null || $rowo->$colVal==""){
						$rowo->$colVal=0;
					}
//					$arrayDataOld[$rowo->template_id][$colVal][]=$rowo->$colVal;
					$arrayDataOld[$rowo->template_id][$colVal][]=array('value'=>$rowo->$colVal,'particular'=>$rowo->column_1,'templateName'=>$rowo->template_name);
				}
			}
		}
//		print_r($arrayDataOld);exit();
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
					$particular='';
					if($row2->$colVal1 == null || $row2->$colVal1==""){
						$v=0;
					}else{
						$exp=explode("-",$row2->$colVal1);
						$v=$exp[0];
						$particular=$exp[0];
					}
					$arrayGLAccountData[$row2->template_id][$colVal1][]=$v;

				}
			}
		}
//		print_r($arrayGLAccountData);exit();
		/*if($branch_id == 78){
			var_dump($arrayData);
			echo "<pre>";
			var_dump($arrayGLAccountData);
			exit;
		}*/

		$indexArray=array();
		$indexArray1=array();
		$indexArray2=array();
		if(count($arrayGLAccountData) > 0){
			foreach ($arrayGLAccountData as $temp_id=>$columns) {
				foreach ($columns as $col1=>$col){
					foreach ($col as $index => $data1) {
						if(array_key_exists($temp_id,$arrayData)) {
							if(array_key_exists($index,$arrayData[$temp_id][$col1])){
								$indexArray[$data1][] = $arrayData[$temp_id][$col1][$index];
//								print_r($arrayData[$temp_id][$col1][$index]['value']);exit();
//								$indexArray2[$data1][]=array('temp_id'=>$temp_id,'template_name'=>$arrayData[$temp_id][$col1][$index]['templateName'],
//									'paticular'=>$arrayData[$temp_id][$col1][$index]['particular'],'value'=>$arrayData[$temp_id][$col1][$index]['value']);
							}else{
								$indexArray[$data1][] = 0;
							}

						}
						if(array_key_exists($temp_id,$arrayDataOld)) {
							if(array_key_exists($index,$arrayDataOld[$temp_id][$col1])){
								$indexArray1[$data1][] = $arrayDataOld[$temp_id][$col1][$index];
								$indexArray2[$data1][]=array('temp_id'=>$temp_id,'template_name'=>$arrayData[$temp_id][$col1][$index]['templateName'],
									'paticular'=>$arrayData[$temp_id][$col1][$index]['particular'],'value'=>$arrayData[$temp_id][$col1][$index]['value']);
							}else{
								$indexArray1[$data1][] = 0;
							}

						}
					}
				}
			}

			$scheduleData=array();
			if(array_key_exists($Gl_number,$indexArray2))
			{
				$scheduleData=$indexArray2[$Gl_number];
			}
			//var_dump($indexArray);
//			print_r($scheduleData);exit();
			if(count($indexArray) > 0 && count($indexArray1)){
				return $scheduleData;
			}else{
				return array();
			}
		}else{
			return array();
		}
	}
}
