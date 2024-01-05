<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once 'Master_Model.php';

class ReportMakerModel extends Master_Model
{

	function get_all_template_data($temp_id)
	{
		try {

	            return $this->db->query("select * from mail_draft_template where id='$temp_id'")->row();
	        } catch (Exception $exc) {
	            log_message('error', $exc->getMessage());
	            return null;
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

