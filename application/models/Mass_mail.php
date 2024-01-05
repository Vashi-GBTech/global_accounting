<?php

class Mass_mail extends CI_model
{
	
	public function add_batch_template($data, $update_id){
		//echo $update_id;exit();
		try {
            $this->db->trans_start();
			if($update_id=='0'){
            $this->db->insert('mail_draft_template', $data);
			} else {
			
				$this->db->set($data);
				$this->db->where('id',$update_id);
				$this->db->update('mail_draft_template');//update query..
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
        } catch (Exception $e) {
            $result = FALSE;
        }
        return $result;
	}
	function getTemplate($company_id){
	 try {

            return $this->db->query("select * from mail_draft_template where company_id='$company_id'")->result();
        } catch (Exception $exc) {
            log_message('error', $exc->getMessage());
            return null;
        }
	
}function GetGroups($company_id){
	 try {

            return $this->db->query("select * from mail_group_table where company_id='$company_id'")->result();
        } catch (Exception $exc) {
            log_message('error', $exc->getMessage());
            return null;
        }
	
}function Get_SentMail_data($company_id){
	 try {

            return $this->db->query("select subject,transaction_date,id,
			(select template_name from mail_draft_template where mail_draft_template.id=mail_transaction_table.template_id)as template_name,
			(select group_name from mail_group_table where mail_group_table.id=mail_transaction_table.group_id)as group_name,
			(select mail_id from company_mail_info where company_mail_info.id=mail_transaction_table.email_id)as email_id
			from mail_transaction_table where company_id='$company_id' order by mail_transaction_table.id DESC")->result();
        } catch (Exception $exc) {
            log_message('error', $exc->getMessage());
            return null;
        }
	
}function GetMail($company_id){
	 try {

            return $this->db->query("select * from company_mail_info where company_id='$company_id'")->result();
        } catch (Exception $exc) {
            log_message('error', $exc->getMessage());
            return null;
        }
	
}
function get_mailIds($groupid_mail){
	
	try {

            return $this->db->query("select * from group_employee_combination where group_id='$groupid_mail'")->result();
        } catch (Exception $exc) {
            log_message('error', $exc->getMessage());
            return null;
        }
}
function get_temp_body($temp_id){
	  try {

            return $this->db->query("select message_body from mail_draft_template where id='$temp_id'")->row();
        } catch (Exception $exc) {
            log_message('error', $exc->getMessage());
            return null;
        }
}

function Get_Groups_data($company_id){
	try {

            return $this->db->query("select group_name,id,file
			from mail_group_table where company_id='$company_id'")->result();
        } catch (Exception $exc) {
            log_message('error', $exc->getMessage());
            return null;
        }
}
function Get_Templates_data($company_id){
	try {

            return $this->db->query("select *
			from mail_draft_template where company_id='$company_id'")->result();
        } catch (Exception $exc) {
            log_message('error', $exc->getMessage());
            return null;
        }
}
function Get_MailSetup_data($company_id){
	try {

            return $this->db->query("select *
			from company_mail_info where company_id='$company_id'")->result();
        } catch (Exception $exc) {
            log_message('error', $exc->getMessage());
            return null;
        }
}function GetMailSetupdataByID($id){
	try {

            return $this->db->query("select *
			from company_mail_info where id='$id'")->row();
        } catch (Exception $exc) {
            log_message('error', $exc->getMessage());
            return null;
        }
}
function get_all_template_data($temp_id)
{
	try {

            return $this->db->query("select * from mail_draft_template where id='$temp_id'")->row();
        } catch (Exception $exc) {
            log_message('error', $exc->getMessage());
            return null;
        }
}
public function delete_temp_data($temp_id)
	{
		$condition=array('id'=>$temp_id);
		$table_name="mail_draft_template";
			$this->db->where($condition);
		    $result=$this->db->delete($table_name);
			
		if($result){
			return $result;

		}
		else
		{
			return FALSE;
		}
	}
public function delete_group_data($grp_id)
	{
		$condition=array('id'=>$grp_id);
		$table_name="mail_group_table";
			$this->db->where($condition);
		    $result=$this->db->delete($table_name);
			
		if($result){
			$condition1=array('group_id'=>$grp_id);
			$table_name1="group_employee_combination";
			$this->db->where($condition1);
		    $result1=$this->db->delete($table_name1);
			return $result1;

		}
		else
		{
			return FALSE;
		}
	}
	public function delete_setup_data($setup_id)
	{
		$condition=array('id'=>$setup_id);
		$table_name="company_mail_info";
			$this->db->where($condition);
		    $result=$this->db->delete($table_name);
			
		if($result){
			return $result;

		}
		else
		{
			return FALSE;
		}
	}
	function check_file_exist($upload_path) {
        $filesnames = array();

        foreach (glob('./' . $upload_path . '/*.*') as $file_NAMEEXISTS) {
            $file_NAMEEXISTS;
            $filesnames[] = str_replace("./" . $upload_path . "/", "", $file_NAMEEXISTS);
        }
        return $filesnames;
    }
	function upload_multiple_file_new($upload_path, $inputname, $combination = "") {

        $combination = (explode(",", $combination));
	
		
        $check_file_exist = $this->check_file_exist($upload_path);
        if (isset($_FILES[$inputname]) && $_FILES[$inputname]['error'] != '4') {
            $files = $_FILES;
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = '*';
//            $config['max_size'] = '20000000';    //limit 10000=1 mb
            $config['remove_spaces'] = true;
            $config['overwrite'] = false;

            $this->load->library('upload', $config);

            if (is_array($_FILES[$inputname]['name'])) {
				
                $count = count($_FILES[$inputname]['name']); // count element
                $files = $_FILES[$inputname];
                $images = array();
                $dataInfo = array();

                if (in_array("1", $combination)) {
                    for ($j = 0; $j < $count; $j++) {
                        $fileName = $files['name'][$j];
                        if (in_array($fileName, $check_file_exist)) {
                            $response['status'] = 201;
                            $response['body'] = $fileName . " Already exist";
                            return $response;
                        }
                    }
                }
                $inputname = $inputname . "[]";
                for ($i = 0; $i < $count; $i++) {
                    $_FILES[$inputname]['name'] = $files['name'][$i];
                    $_FILES[$inputname]['type'] = $files['type'][$i];
                    $_FILES[$inputname]['tmp_name'] = $files['tmp_name'][$i];
                    $_FILES[$inputname]['error'] = $files['error'][$i];
                    $_FILES[$inputname]['size'] = $files['size'][$i];
                    $fileName = $files['name'][$i];
                    //get system generated File name CONCATE datetime string to Filename
                    if (in_array("2", $combination)) {
                        $date = date('Y-m-d H:i:s');
                        $randomdata = strtotime($date);
                        $fileName = $randomdata . $fileName;
                    }
                    $images[] = $fileName;

                    $config['file_name'] = $fileName;

                    $this->upload->initialize($config);
                    $up = $this->upload->do_upload($inputname);
                    //var_dump($up);
                    $dataInfo[] = $this->upload->data();
                }
                //var_dump($dataInfo);

                $file_with_path = array();
                foreach ($dataInfo as $row) {
                    $raw_name = $row['raw_name'];
                    $file_ext = $row['file_ext'];
                    $file_name = $raw_name . $file_ext;
                    $file_with_path[] = $upload_path . "/" . $file_name;
                }
                $response['status'] = 200;
                $response['body'] = $file_with_path;
				
                return $response;
            }
        } else {
            $response['status'] = 201;
            $response['body'] = array();
            return $response;
        }
    }
	
	 function upload_multiple_file($upload_path,$inputname) {

        if (isset($_FILES[$inputname]) && $_FILES[$inputname]['error'] != '4') {
            $files = $_FILES;
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = '*';
            $config['max_size'] = '50000000';    //limit 10000=1 mb
            $config['remove_spaces'] = true;
            $config['overwrite'] = false;

            $this->load->library('upload', $config);

            if (is_array($_FILES[$inputname]['name'])) {
                $count = count($_FILES[$inputname]['name']); // count element
                $files = $_FILES['userfile'];
                $images = array();
				$inputname = $inputname . "[]";

                foreach ($files['name'] as $key => $image) {
                    $_FILES[$inputname]['name'] = $files['name'][$key];
                    $_FILES[$inputname]['type'] = $files['type'][$key];
                    $_FILES[$inputname]['tmp_name'] = $files['tmp_name'][$key];
                    $_FILES[$inputname]['error'] = $files['error'][$key];
                    $_FILES[$inputname]['size'] = $files['size'][$key];

                    $fileName = $image;

                    $images[] = $fileName;

                    $config['file_name'] = $fileName;

                    $this->upload->initialize($config);

                    if ($this->upload->do_upload($inputname)) {
                        $this->upload->data();
                    } else {
                        return false;
                    }
                }

                return $images;
            } else {

                $this->upload->initialize($config);
                $_FILES[$inputname]['name'] = $files[$inputname]['name'];
                $_FILES[$inputname]['type'] = $files[$inputname]['type'];
                $_FILES[$inputname]['tmp_name'] = $files[$inputname]['tmp_name'];
                $_FILES[$inputname]['error'] = $files[$inputname]['error'];
                $_FILES[$inputname]['size'] = $files[$inputname]['size'];

                $fileName = preg_replace('/\s+/', '_', str_replace(' ', '_', $_FILES[$inputname]['name']));
                $data = array('upload_data' => $this->upload->data());
                if (empty($fileName)) {
                    $response['status'] = 203;
                    $response['body'] = "file is empty";
                    return false;
                } else {
                    $file = $this->upload->do_upload($inputname);
                    if (!$file) {
                        $error = array('upload_error' => $this->upload->display_errors());
                        $response['status'] = 204;
                        $response['body'] = $files[$inputname]['name'] . ' ' . $error['upload_error'];
                        return $response;
                    } else {
                        $response['status'] = 200;
                        $response['body'] = $fileName;
                        return $response;
                    }
                }
            }
        } else {
            $response['status'] = 200;
            $response['body'] = "";
            return $response;
        }
    }



}