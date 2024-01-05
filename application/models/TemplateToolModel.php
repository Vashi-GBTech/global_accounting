<?php
require_once 'Master_Model.php';

class TemplateToolModel extends Master_Model
{

	function __construct()
	{
		parent::__construct();
	}
	public function fetchAllCreatedTemplatesTool($board_id=null)
	{
		// if($board_id==null)
		// {
		//     $query = $this->db->query("SELECT template_id, template_name, access_mode FROM handson_template_master");
		// }
		// else
		// {
		//     $query = $this->db->query("SELECT template_id, template_name, access_mode FROM template_question_master where template_id in (select template_id from board_access_template where user_id='" . $this->session->user_session->user_id . "' and board_id='".$board_id."') group by template_id order by access_mode");
		// }
		$query = $this->db->query("SELECT id, template_name FROM handson_template_master where status=1");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}



}

?>
