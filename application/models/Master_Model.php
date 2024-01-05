<?php

/**
 *
 */
class Master_Model extends CI_Model
{


	/**
	 * @param $sql query which you want to execute
	 * @param bool $bindParam default false or array
	 * @return stdClass witch properties of totalCount and data of query result
	 */
	function _rawQuery($sql, $bindParam = FALSE,$type=1)
	{
		$resultObject = new stdClass();
		try {
			$query = $this->db->query($sql, $bindParam);
			if($type!=1){
				$result = $query->result_array();
			}else{
				$result = $query->result();
			}

			if (count($result) > 0) {
				$resultObject->totalCount = count($result);
				$resultObject->data = $result;
			} else {
				$resultObject->totalCount = 0;
				$resultObject->data = array();
			}
			$resultObject->last_query = $this->db->last_query();
		} catch (Exception $ex) {
			$resultObject->totalCount = 0;
			$resultObject->data = array();
		}
		return $resultObject;
	}

	/**
	 * @param $table String table name
	 * @param $data array values
	 * @return stdClass object of status and last insert id
	 */
	function _insert($table, $data)
	{
		$resultObject = new stdClass();
		try {
			$this->db->trans_start();
			$this->db->insert($table, $data);
			$resultObject->inserted_id = $this->db->insert_id();
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$resultObject->status = FALSE;
			} else {
				$this->db->trans_commit();
				$resultObject->status = TRUE;
			}
			$this->db->trans_complete();
			$resultObject->last_query = $this->db->last_query();
		} catch (Exception $ex) {
			$resultObject->status = FALSE;
			$this->db->trans_rollback();
		}
		return $resultObject;
	}
	/**
	 * @param $table String table name
	 * @param $data array values
	 * @return stdClass object of status and last insert id
	 */
	function _insertBatch($table, $data)
	{
		$resultObject = new stdClass();
		try {
			$this->db->trans_start();
			$this->db->insert_batch($table, $data);
//			$resultObject->inserted_id = $this->db->insert_id();
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$resultObject->status = FALSE;
			} else {
				$this->db->trans_commit();
				$resultObject->status = TRUE;
			}
			$this->db->trans_complete();
			$resultObject->last_query = $this->db->last_query();
		} catch (Exception $ex) {
			$resultObject->status = FALSE;
			$this->db->trans_rollback();
		}
		return $resultObject;
	}
	/**
	 * @param $table String the table name
	 * @param $data  array you want to update
	 * @param $where array where update record
	 * @return stdClass object with property of status
	 */
	function _update($table, $data, $where)
	{
		$resultObject = new stdClass();
		try {
			$this->db->trans_start();
			$this->db->set($data)->where($where)->update($table);
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$resultObject->status = FALSE;
			} else {
				$this->db->trans_commit();
				$resultObject->status = TRUE;
			}
			$this->db->trans_complete();
			$resultObject->last_query = $this->db->last_query();
		} catch (Exception $ex) {
			$resultObject->status = FALSE;
			$this->db->trans_rollback();
		}
		return $resultObject;
	}

	/**
	 * @param $table String the table name
	 * @param $data  array you want to update including where column name
	 * @param $key String where column name
	 * @return stdClass object with property of status
	 */
	function _updateBatch($table, $data, $key)
	{
		$resultObject = new stdClass();
		try {
			$this->db->trans_start();
			$this->db->update_batch($table, $data, $key);
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$resultObject->status = FALSE;
			} else {
				$this->db->trans_commit();
				$resultObject->status = TRUE;
			}
			$this->db->trans_complete();
			$resultObject->last_query = $this->db->last_query();
		} catch (Exception $ex) {
			$resultObject->status = FALSE;
			$this->db->trans_rollback();
		}
		return $resultObject;
	}


	/**
	 * @param $table String the table name
	 * @param $where array where delete record
	 * @return stdClass object with property of status
	 */
	function _delete($table, $where)
	{
		$resultObject = new stdClass();
		try {
			$this->db->trans_start();
			$this->db->where($where)->delete($table);
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$resultObject->status = FALSE;
			} else {
				$this->db->trans_commit();
				$resultObject->status = TRUE;
			}
			$this->db->trans_complete();
			$resultObject->last_query = $this->db->last_query();
		} catch (Exception $ex) {
			$resultObject->status = FALSE;
			$this->db->trans_rollback();
		}
		return $resultObject;
	}


	/**
	 * @param $tableName String table name
	 * @param $where array of condition
	 * @param $select array|String of columns
	 * @param $type true for single row and false for multiple rows
	 * @param null $group_by group by value
	 * @return stdClass object with property of totalCount and data
	 */
	function _select($tableName, $where, $select = "*", $type = true, $group_by = null, $where_in = null,$order_by=null)
	{

		$resultObject = new stdClass();
		try {
			if ($type) {
				$this->db->select($select)->where($where);
				if ($where_in != null) {
					$this->db->where($where_in);
				}
				if ($group_by != null) {
					$this->db->group_by($group_by);
				}
				if($order_by !=null){
					$this->db->order_by($order_by);
				}
				$result = $this->db->get($tableName)->row();

				if ($result != null) {
					$resultObject->totalCount = 1;
					$resultObject->data = $result;
				} else {
					$resultObject->totalCount = 0;
					$resultObject->data = $result;
				}
			} else {
				$this->db->select($select)->where($where);
				if ($where_in != null) {
					$this->db->where($where_in);
				}
				if ($group_by != null) {
					$this->db->group_by($group_by);
				}
				if($order_by !=null){
					$this->db->order_by($order_by);
				}
				$result = $this->db->get($tableName)->result();

				$resultObject->totalCount = count($result);
				if (count($result) > 0) {
					$resultObject->data = $result;
				} else {
					$resultObject->data = array();
				}
			}
			$resultObject->last_query = $this->db->last_query();
		} catch (Exception $e) {
			$resultObject->totalCount = 0;
			$resultObject->data = null;
		}
		return $resultObject;
	}

	public function getRows($postData, $where, $select, $table, $column_search, $column_order, $order, $group_by = null, $where_or = null, $having = null, $customWhereCondition = null)
	{

		$this->_get_datatables_query($postData, $table, $column_search, $column_order, $order, $group_by);
		if ($having != null) {
			if (!empty($having)) {
				$this->db->having($having['column'], $having['value']);
			}

		}
		if ($postData['length'] != -1) {
			$this->db->limit($postData['length'], $postData['start']);
		}
//		$this->where = $where;


		if ($where_or != null) {
			$this->db->where($where);
			$this->db->or_where($where_or);
		} else {
			$this->db->where($where);
			if ($customWhereCondition != null)
				$this->db->where($customWhereCondition);
		}

		$query = $this->db->select($select)->get();

		//echo $this->db->last_query();
		return $query->result();
	}

	/*
	 * Count all records
	 */

	public function countAll($table, $where, $customWhereCondition = null)
	{
		if ($customWhereCondition != null) {
			$this->db->where($customWhereCondition);
		}
		$this->db->where($where)->from($table);
		return $this->db->count_all_results();
	}

	public function countFiltered($postData, $table, $where, $column_search, $column_order, $order, $customWhereCondition = null)
	{
		$this->_get_datatables_query($postData, $table, $column_search, $column_order, $order);
		if ($where != null) {
			$this->db->where($where);
		}
		if ($customWhereCondition != null) {
			$this->db->where($customWhereCondition);
		}
		$query = $this->db->get();
		return $query->num_rows();
	}

	/*
	 * Perform the SQL queries needed for an server-side processing requested
	 * @param $_POST filter data based on the posted parameters
	 */

	public function _get_datatables_query($postData, $table, $column_search, $column_order, $order, $group_by = null)
	{

		$this->db->from($table);
		$i = 0;
		// loop searchable columns
		foreach ($column_search as $item) {
			// if datatable send POST for search
			if ($postData['search']['value']) {
				// first loop
				if ($i === 0) {
					// open bracket
					$this->db->group_start();
					$this->db->like($item, $postData['search']['value']);
				} else {
					$this->db->or_like($item, $postData['search']['value']);
				}
				// last loop
				if (count($column_search) - 1 == $i) {
					// close bracket
					$this->db->group_end();
				}
			}
			$i++;
		}
		if ($group_by != null) {
			$this->db->group_by($group_by);
		}
		if (isset($postData['order'])) {
			$column = (int)$postData['order']['0']['column'];
			if (count($column_order) > $column)
				$this->db->order_by($column_order[$column], $postData['order']['0']['dir']);
		} else if (count($order) > 0) {

			$this->db->order_by(key($order), $order[key($order)]);

		}
	}


	public function get_row_data($select = null, $where = null, $table_name = null)
	{
		$this->db->select($select)
				->where($where)
				->from($table_name);
		$query = $this->db->get()->row();
		return $query;
	}

	public function group_by_data($group_by = null, $where = null, $table_name = null)
	{
		$this->db->select("*")
				->where($where)
				->group_by($group_by)
				->from($table_name);
		$query = $this->db->get()->result();
		return $query;
	}

	public function order_by_data($select = "*", $where = null, $table_name = null, $order_by = null, $key = 'ASC', $where_in = null, $limit = null,$type=true)
	{
		$this->db->select($select);
		if ($where != null) {
			$this->db->where($where);
		}
		$this->db->order_by($order_by, $key);
		if ($where_in != null) {
			$this->db->where($where_in);
		}
		if ($limit != null) {
			$this->db->limit($limit);
		}
		$this->db->from($table_name);
		if($type != true)
		{
			$query = $this->db->get()->row();
		}else
		{
			$query = $this->db->get()->result();
		}
		return $query;
	}


	public function get_all_data($where = null, $table_name = null)
	{
		$this->db->select("*")
				->where($where)
				->from($table_name);
		$query = $this->db->get()->result();
		return $query;
	}

	public function get_all_table_data($table_name = null)
	{
		$this->db->select("*")
				->from($table_name);
		$query = $this->db->get()->result();
		return $query;
	}

	public function get_count($where, $table_name)
	{
		$this->db->select('*')
				->where($where)
				->from($table_name);
		$query = $this->db->count_all_results();
		return $query;
	}


	public function get_distinct_count($select, $where, $table_name)
	{
		$this->db->distinct()->select($select)
				->where($where)
				->from($table_name);
		$query = $this->db->count_all_results();
		return $query;
	}

	public function join($select = "*", $where = null, $table = null, $join = null, $condition = null, $type = null, $grpby = null, $order_by = null, $key = "desc")
	{
		$this->db->select($select);
		$this->db->where($where);
		$this->db->join($join, $condition, $type);
		if ($grpby != null) {
			$this->db->group_by($grpby);
		}
		if ($order_by != null) {
			$this->db->order_by($order_by, $key);
		}
		$this->db->from($table);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_all_data_custom_where($table_name = null, $Where = null, $customWhere = null)
	{
		if ($customWhere != null) {
			$this->db->where($customWhere);
		}
		$this->db->select("*")
				->where($Where)
				->from($table_name);
		$query = $this->db->get()->result();
		return $query;
	}


	public function get_select_all_data($select = "*", $table_name = null)
	{
		$this->db->select($select)
				->from($table_name);
		$query = $this->db->get()->result();
		return $query;
	}
	public function getQuarter(){
		$quareter = array(
			"1" => "January",
			"2" => "February",
			"3" => "March",
			"4" => "April",
			"5" => "May",
			"6"=> "June",
			"7" => "July",
			"8" => "August",
			"9" => "September",
			"10" => "October",
			"11" => "November",
			"12" => "December"
		);
		return $quareter;
	}

	public function country()
	{
		$country = array(
				"1" => 'Albania',
				"2" => 'America',
				"3" => 'Afghanistan',
				"4" => 'Argentina',
				"5" => 'Aruba',
				"6" => 'Australia',
				"7" => 'Azerbaijan',
				"8" => 'Bahamas',
				"9" => 'Barbados',
				"10" => 'Belarus',
				"11" => 'Belgium',
				"12" => 'Beliz',
				"13" => 'Bermuda',
				"14" => 'Bolivia',
				"15" => 'Bosnia',
				"16" => 'Botswana',
				"17" => 'Bulgaria',
				"18" => 'Brazil',
				"19" => 'Britain',
				"20" => 'Brunei Darussalam',
				"21" => 'Cambodia',
				"22" => 'Canada',
				"23" => 'Cayman Islands',
				"24" => 'Chile',
				"25" => 'China',
				"26" => 'Colombia',
				"27" => 'Costa Rica',
				"28" => 'Croatia',
				"29" => 'Cuba',
				"30" => 'Cyprus',
				"31" => 'Czech Republic',
				"32" => 'Denmark',
				"33" => 'Dominican Republic',
				"34" => 'East Caribbean',
				"35" => 'Egypt',
				"36" => 'El Salvador',
				"37" => 'England',
				"38" => 'Euro',
				"39" => 'Falkland Islands',
				"40" => 'Fiji',
				"41" => 'France',
				"42" => 'Ghana',
				"43" => 'Gibraltar',
				"44" => 'Greece',
				"45" => 'Guatemala',
				"46" => 'Guernsey',
				"47" => 'Guyana',
				"48" => 'Holland',
				"49" => 'Honduras',
				"50" => 'Hong Kong',
				"51" => 'Hungary',
				"52" => 'Iceland',
				"53" => 'India',
				"54" => 'Indonesia',
				"55" => 'Iran',
				"56" => 'Ireland',
				"57" => 'Isle of Man',
				"58" => 'Israel',
				"59" => 'Italy',
				"60" => 'Jamaica',
				"61" => 'Japan',
				"62" => 'Jersey',
				"63" => 'Kazakhstan',
				"64" => 'Korea (North)',
				"65" => 'Korea (South)',
				"66" => 'Kyrgyzstan',
				"67" => 'Laos',
				"68" => 'Latvia',
				"69" => 'Lebanon',
				"70" => 'Liberia',
				"71" => 'Liechtenstein',
				"72" => 'Lithuania',
				"73" => 'Luxembourg',
				"74" => 'Macedonia',
				"75" => 'Malaysia',
				"76" => 'Malta',
				"77" => 'Mauritius',
				"78" => 'Mexico',
				"79" => 'Mongolia',
				"80" => 'Mozambique',
				"81" => 'Namibia',
				"82" => 'Nepal',
				"83" => 'Netherlands Antilles',
				"84" => 'Netherlands',
				"85" => 'New Zealand',
				"86" => 'Nicaragua',
				"87" => 'Nigeria',
				"88" => 'North Korea',
				"89" => 'Norway',
				"90" => 'Oman',
				"91" => 'Pakistan',
				"92" => 'Panama',
				"93" => 'Paraguay',
				"94" => 'Peru',
				"95" => 'Philippines',
				"96" => 'Poland',
				"97" => 'Qatar',
				"98" => 'Romania',
				"99" => 'Russia',
				"100" => 'Saint Helena',
				"101" => 'Saudi Arabia',
				"102" => 'Serbia',
				"103" => 'Seychelles',
				"104" => 'Singapore',
				"105" => 'Slovenia',
				"106" => 'Solomon Islands',
				"107" => 'Somalia',
				"108" => 'South Africa',
				"109" => 'South Korea',
				"110" => 'Spain',
				"111" => 'Sri Lanka',
				"112" => 'Sweden',
				"113" => 'Switzerland',
				"114" => 'Suriname',
				"115" => 'Syria',
				"116" => 'Taiwan',
				"117" => 'Thailand',
				"118" => 'Trinidad',
				"119" => 'Turkey',
				"120" => 'Turkey',
				"121" => 'Tuvalu',
				"122" => 'Ukraine',
				"123" => 'United Kingdom',
				"124" => 'United States',
				"125" => 'United Arab Emirates',
				"126" => 'Uruguay',
				"127" => 'Uzbekistan',
				"128" => 'Vatican City',
				"129" => 'Venezuela',
				"130" => 'Vietnam',
				"131" => 'Yemen',
				"132" => 'Zimbabwe',
				"133"=>'Germany',
				"134"=>'Ecuador',
				"135"=>'Kenya'
		);


		$currency = array(
				"1" => "ALL",
				"2" => "USD",
				"3" => "AFN",
				"4" => "ARS",
				"5" => 'AWG',
				"6" => 'AUD',
				"7" => 'AZN',
				"8" => 'BSD',
				"9" => 'BBD',
				"10" => 'BYR',
				"11" => 'EUR',
				"12" => 'BZD',
				"13" => 'BMD',
				"14" => 'BOB',
				"15" => 'BAM',
				"16" => 'BWP',
				"17" => 'BGN',
				"18" => 'BRL',
				"19" => 'GBP',
				"20" => 'BND',
				"21" => 'KHR',
				"22" => 'CAD',
				"23" => 'KYD',
				"24" => 'CLP',
				"25" => 'CNY',
				"26" => 'COP',
				"27" => 'CRC',
				"28" => 'HRK',
				"29" => 'CUP',
				"30" => 'EUR',
				"31" => 'CZK',
				"32" => 'DKK',
				"33" => 'DOP',
				"34" => 'XCD',
				"35" => 'EGP',
				"36" => 'SVC',
				"37" => 'GBP',
				"38" => 'EUR',
				"39" => 'FKP',
				"40" => 'FJD',
				"41" => 'EUR',
				"42" => 'GHC',
				"43" => 'GIP',
				"44" => 'EUR',
				"45" => 'GTQ',
				"46" => 'GGP',
				"47" => 'GYD',
				"48" => 'EUR',
				"49" => 'HNL',
				"50" => 'HKD',
				"51" => 'HUF',
				"52" => 'ISK',
				"53" => 'INR',
				"54" => 'IDR',
				"55" => 'IRR',
				"56" => 'EUR',
				"57" => 'IMP',
				"58" => 'ILS',
				"59" => 'EUR',
				"60" => 'JMD',
				"61" => 'JPY',
				"62" => 'JEP',
				"63" => 'KZT',
				"64" => 'KPW',
				"65" => 'KRW',
				"66" => 'KGS',
				"67" => 'LAK',
				"68" => 'LVL',
				"69" => 'LBP',
				"70" => 'LRD',
				"71" => 'CHF',
				"72" => 'LTL',
				"73" => 'EUR',
				"74" => 'MKD',
				"75" => 'MYR',
				"76" => 'EUR',
				"77" => 'MUR',
				"78" => 'MXN',
				"79" => 'MNT',
				"80" => 'MZN',
				"81" => 'NAD',
				"82" => 'NPR',
				"83" => 'ANG',
				"84" => 'EUR',
				"85" => 'NZD',
				"86" => 'NIO',
				"87" => 'NGN',
				"88" => 'KPW',
				"89" => 'NOK',
				"90" => 'OMR',
				"91" => 'PKR',
				"92" => 'PAB',
				"93" => 'PYG',
				"94" => 'PEN',
				"95" => 'PHP',
				"96" => 'PLN',
				"97" => 'QAR',
				"98" => 'RON',
				"99" => 'RUB',
				"100" => 'SHP',
				"101" => 'SAR',
				"102" => 'RSD',
				"103" => 'SCR',
				"104" => 'SGD',
				"105" => 'EUR',
				"106" => 'SBD',
				"107" => 'SOS',
				"108" => 'ZAR',
				"109" => 'KRW',
				"110" => 'EUR',
				"111" => 'LKR',
				"112" => 'SEK',
				"113" => 'CHF',
				"114" => 'SRD',
				"115" => 'SYP',
				"116" => 'TWD',
				"117" => 'THB',
				"118" => 'TTD',
				"119" => 'TRY',
				"120" => 'TRL',
				"121" => 'TVD',
				"122" => 'UAH',
				"123" => 'GBP',
				"124" => 'USD',
				"125" => 'AED',
				"126" => 'UYU',
				"127" => 'UZS',
				"128" => 'EUR',
				"129" => 'VEF',
				"130" => 'VND',
				"131" => 'YER',
				"132" => 'ZWD',
				"133"=>'DEM',
				"134"=>'USD',
				"135"=>'Kenyan shilling',
		);
		return array($currency,$country);
	}

	public function UploadExcelData($data,$table,$key)
	{
		try {
			$this->db->trans_start();
			$this->db->update_batch($table, $data,$key);

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
		return $result;
	}

	public function checkBlockYearMonth($where)
	{
		$result= $this->get_row_data("*", $where, 'block_year_data');
		$check = false;
		if(!empty($result))
		{
			if($result->status == 0){
				$check=true;
			}
		}else{
			$check=true;
		}
		return $check;
	}

	public function getBranchCurrency()
	{
		$branchCurrency=array();
		$resultObject=$this->get_all_table_data('branch_master');
		if(count($resultObject)>0)
		{
			foreach ($resultObject as $key => $value) {
				$branchCurrency[$value->id]=$value->currency;
			}
		}
		return $branchCurrency;
	}
	public function getComapnyCurrency()
	{
		$branchCurrency=array();
		$resultObject=$this->get_all_table_data('company_master');
		if(count($resultObject)>0)
		{
			foreach ($resultObject as $key => $value) {
				$branchCurrency[$value->id]=$value->currency;
			}
		}
		return $branchCurrency;
	}
	public function getBranchCompany()
	{
		$branchCompany=array();
		$resultObject=$this->get_all_table_data('branch_master');
		if(count($resultObject)>0)
		{
			foreach ($resultObject as $key => $value) {
				$branchCompany[$value->id]=$value->company_id;
			}
		}
		return $branchCompany;
	}

}

?>


