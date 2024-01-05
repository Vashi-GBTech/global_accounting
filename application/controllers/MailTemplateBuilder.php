<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MailTemplateBuilder extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index($id=0)
	{
		$data['template_id']=$id;
		$this->load->view('mail_builder/mailTemplateBuilder',$data);
	}
	public function template_view()
	{
		//$this->load->view('mail_builder/mailTemplateBuilder');
	}
	public function addTemplate(){
		//print_r($this->input->post('data'));exit();
		 if (!is_null($this->input->post('data'))) {
           $user_id = $this->session->userdata('user_id');
           $company_id = $this->session->userdata('company_id');
			$template_id = $this->input->post("template_id");
            $temp_name = $this->input->post('temp_name');
			 $temp_url = $this->input->post('temp_url');
            $update_id = $this->input->post('update_id');
            $body = $this->input->post('data');
			$des_path = "uploads";
			 $inputname='file';
			 $combination=1;
			$this->load->model('ReportMakerModel');
            $result = $this->ReportMakerModel->upload_multiple_file($des_path,$inputname);
            if($result['status']==200){
				$path=$des_path."/".$result["body"];
			}else{
				$path="";
			}
			//print_r($company_id);exit();
            $data = array(
              
                "template_name" => $temp_name,
				"side_barID" =>$temp_url,
                "message_body" => $body,
                "created_on" => date('Y-m-d H:i:s'),
                "company_id" => $company_id,
                "file" => $path,
            );
			//print_r($data);exit();
			if($template_id !=0){
				//update
				//echo 1;
				$this->db->where('id',$template_id);
				$result = $this->db->update('mail_draft_template',$data);
				//$result = $this->ReportMakerModel->add_batch_template($data, $update_id);	
				//$result=true;
			}else{
				//echo 3;
			$result = 	$this->db->insert('mail_draft_template',$data);
			// $result = $this->ReportMakerModel->add_batch_template($data, $update_id);
			//$result=true;			
			}
            
            if ($result == TRUE) {
                $response['status'] = true;
                $response['body'] = "Succesfully template added";
            } else {
                $response['status'] = true;
                $response['body'] = "Failed to add template";
            }
        } else {
            $response['status'] = false;
            $response['body'] = "invalid parameter";
        }
        echo json_encode($response);
	}
	
	public function addImage()
	{
		 $company_id = $this->session->userdata('company_id');
		
		//$image = $_FILES['image_data'];
		//print_r($image);
		//$image_data=$img_data['name'];
		//print_r($image);exit();
		$des_path = "uploads";
			 $inputname='image_data';
			 $this->load->model('ReportMakerModel');
			$result = $this->ReportMakerModel->upload_multiple_file($des_path,$inputname);
			//var_dump($result);
			//exit;
			//print_r($inputname);exit();
		   if($result['status']==200){
				$path=$des_path."/".$result["body"];
			}else{
				$path="";
			}
			 $data = array(
                "date" => date('Y-m-d H:i:s'),
                "company_id" => $company_id,
                "image_url" => $path
            );
			//print_r($data);exit();
			$result = $this->db->insert('template_images_table',$data);
			
			 if ($result == TRUE) {
                $response['status'] = true;
                $response['body'] = "Succesfully Image added";
            } else {
                $response['status'] = true;
                $response['body'] = "Failed to add Image";
            }
			echo json_encode($response);
	}
	public function getImage()
	{
		$company_id = $this->session->userdata('company_id');

		$this->db->select();
		$this->db->order_by('id','desc');
		$this->db->where('company_id',$company_id);
		$res=$this->db->get('template_images_table')->result();	
		//print_r($res);exit;
		$a=0;
			      
		$data='';
			  	foreach ($res as $value) {
			  		 
			        $a++;
			        // $image_path="https://survey.docango.com/";
			        $data.='
			         <div class="get-options choose ui-draggable ui-draggable-handle" data-id="image" id="image'.$a.'">
						<img src="'.base_url().$value->image_url.'" class="img-responsive" height="30px"/>
						<input type="text" name="image" value="'.base_url().$value->image_url.'" class="get-options1" style="font-size:15px">
					 </div>
			        ';
			  	}
				
		if ($data== TRUE) {
                $response['status'] = true;
                $response['data'] = $data;
				 $response['body'] = 'Successfully sent';
            } else {
                $response['status'] = true;
                $response['data'] = $data;
				 $response['body'] = 'Successfully not sent';
            }
			echo json_encode($response);
	}
	public function fetch_template_data()
	{
		$temp_id = $this->input->post('template_id');
		//print_r($temp_id);exit();
		$this->load->model('ReportMakerModel');
		$temp_data=$this->ReportMakerModel->get_all_template_data($temp_id);
		//print_r($temp_data);exit();
		if($temp_data != null)
		{
			$response['data'] = $temp_data;
			  $response['status'] = 200;
               
            } else {
				$temp_data=array();
				$response['data'] = $temp_data;
                $response['status'] = 201;
                
            } echo json_encode($response);
		
	}
	
}
