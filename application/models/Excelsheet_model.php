<?php

require_once 'Master_Model.php';

class Excelsheet_model extends Master_Model
{


	/**
	 * Board_model constructor.
	 */
	public function __construct()
	{
		parent::__construct();
	}

	public function getExportToTable($id)
	{
		return $this->_select('excelsheet_master_data em',array('id'=>$id),array('(select Template_table_name from template_master where id=em.template_id) as tablename','em.template_id'));
	}


	
}