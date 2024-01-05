<?php


/**
 * @property  AwsModel AwsModel
 */
class AwsController extends CI_Controller
{


	function __construct()
	{
		parent::__construct();
		$this->load->model("AwsModel");
	}


	function login(){
		$this->load->view("round-login");
	}

	function sendSMS(){
		error_reporting(E_ALL);
		ini_set("display_errors",1);
		echo "Start Process For SMS";
		$this->AwsModel->sendSMS();
	}

	function downloadList()
	{
		$this->AwsModel->getObjectList();
	}


	function viewFile()
	{
		$fileName = $this->input->get("f");
		$type = $this->input->get("t");
		if (!is_null($fileName) && $fileName != "") {
			if(!is_null($type)){
				$type=2;
			}else{
				$type=1;
			}
			$this->AwsModel->viewFile(base64_decode($fileName),$type);
		} else {
			echo 'Invalid Request';
		}

	}
	function preURLFile()
	{
		$fileName = $this->input->get("f");
		$type = $this->input->get("t");
		if (!is_null($fileName) && $fileName != "") {
			if(!is_null($type)){
				$type=2;
			}else{
				$type=1;
			}
			$this->AwsModel->download(base64_decode($fileName),$type);
		} else {
			echo 'Invalid Request';
		}

	}

	function downloadFile()
	{
		$fileName = $this->input->get("f");
		$type = $this->input->get("t");
		if (!is_null($fileName) && $fileName != "") {
			if(!is_null($type)){
				$type=2;
			}else{
				$type=1;
			}
			redirect($this->AwsModel->getPreAssignURL(base64_decode($fileName),$type));
		} else {
			echo 'Invalid Request';
		}

	}
	function test(){
		$fileName="https://aws-drive-project.s3.ap-south-1.amazonaws.com/Suraj/1636463676_1636380665_matthew-t-rader-YAh2Ty8fSYA-unsplash%20%281%29.jpg";
		$array = explode(".", basename($fileName));
		$ext=end($array);
		$types = array("png","jpeg","jpg","gif","svg","ico","bmp");
		if(array_search($ext,$types)){
			return  "image/".$ext;
		}

	}

}
