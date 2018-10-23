<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminController extends CI_Controller {

	function __construct(){
		parent ::__construct();

		$this->load->helper('email');
		$this->load->helper('file');
		$this->load->model('AdminModel');
	}

	public function index()
	{
    	$this->load->view('login');
	}
	
	public function login(){

		$data = array('success'=>false,'messages'=>array());

		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('pwd','Password','trim|required');
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
		
		if($this->form_validation->run()){
			$filter = array(
				'email' =>$this->input->post('email'),
				'password'=>md5($this->input->post('pwd'))
			);
			
			$data = $this->AdminModel->getUser($filter);
			
			if(!empty($data))
			{
				$userdata = array(
					'id' => $data[0]['id'],
					'email' => $data[0]['email'],
					'password' => $data[0]['password']
				);
				$this->session->set_userdata($userdata);

				$data['success'] = true;
			}else
			{
				$data['success'] = 2;
 			}
		}else
			{
			foreach($_POST as $key=>$value)
				{
					$data['messages'][$key] = form_error($key);
				}
		}
		
		echo json_encode($data);
	}



	public function manufacturerForm()
	{
		$id = $this->uri->segment(3);
		if($id == ''){
			$data['id'] = 'new';
		}else{
			$filter = array('id'=>$id);
			$data['id'] = $id;
			$data['result'] = $this->AdminModel->getManufacturerlist($filter);
		}
		$this->load->view('manufacturerForm',$data);
	}

	public function addManufacturer()
	{
		$data = array('success'=>false,'messages'=>array());

		$this->form_validation->set_rules('mName','Manufacturer Name','trim|required');
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
		
		if($this->form_validation->run()){
			
			$id = $this->input->post('id');
			
			$data1 = array(
				'mName' =>$this->input->post('mName')
			);
			
			if($id == 'new'){
				$filter = NULL;
				$data2 = array(
					'created_date' => date('Y-m-d H:i:s'),
					'updated_date' => date('Y-m-d H:i:s')
				);
						
			}else{	
				$filter = array('id'=>$id);
				$data2 = array(
					'updated_date' => date('Y-m-d H:i:s')
				);
			}

			$data3 = array_merge($data1,$data2);
			$result = $this->AdminModel->insertmName($data3,$filter);
			
			if(!empty($data))
			{
				$data['success'] = true;
			}else
			{
				$data['success'] = 2;
 			}
		}else
			{
			foreach($_POST as $key=>$value)
				{
					$data['messages'][$key] = form_error($key);
				}
		}
		
		echo json_encode($data);
	}

	public function modelForm(){
		$id = $this->uri->segment(3);
		if($id == ''){
			$data['id'] = 'new';
			$data['mList'] = $this->AdminModel->getManufacturerList();
		}else{
			$filter = array('id'=>$id);
			$data['id'] = $id;
			$data['mList'] = $this->AdminModel->getManufacturerList();
			$data['result'] = $this->AdminModel->getModelList($filter);
		}
		$this->load->view('modelForm',$data);
	}

	public function addModel()
	{	
		// echo "<pre>";
		// print_r($_FILES);exit;
		
		$data = array('success'=>false,'messages'=>array());

		$this->form_validation->set_rules('model','Model Name','trim|required');
		$this->form_validation->set_rules('mName','Manufacturer Name','trim|required');
		$this->form_validation->set_rules('color','color','trim|required');
		$this->form_validation->set_rules('mYear','Manufacturer Year','trim|required');
		$this->form_validation->set_rules('rNumber','Registration Number','trim|required');
		$this->form_validation->set_rules('note','Note','trim|required');
		// $this->form_validation->set_rules('image1','image','trim');
		// $this->form_validation->set_rules('image2','image','trim');
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
		
		if($this->form_validation->run()){
			
			$id = $this->input->post('id');

			$file_path_1 = '';
			$file_path_2 = '';

			if(!empty($_FILES['image1']['name'])){
				$inputName = 'image1';
				$file_path_1 = $this->do_upload('image1');
			}

			if(!empty($_FILES['image2']['name'])){
				$inputName = 'image2';
				$file_path_2 = $this->do_upload('image2');
			}
			
			$data1 = array(
				'model' =>$this->input->post('model'),
				'mName' =>$this->input->post('mName'),
				'color' =>$this->input->post('color'),
				'year' =>$this->input->post('mYear'),
				'rNumber' =>$this->input->post('rNumber'),
				'note' =>$this->input->post('note'),
				'image1' =>$file_path_1,
				'image2' =>$file_path_2
			);


			
			if($id == 'new'){
				$filter = NULL;
				$data2 = array(
					'created_date' => date('Y-m-d H:i:s'),
					'updated_date' => date('Y-m-d H:i:s')
				);
						
			}else{	
				$filter = array('id'=>$id);
				$data2 = array(
					'updated_date' => date('Y-m-d H:i:s')
				);
			}

			$data3 = array_merge($data1,$data2);
			$result = $this->AdminModel->insertModel($data3,$filter);
			
			if(!empty($data))
			{
				$data['success'] = true;
			}else
			{
				$data['success'] = 2;
 			}
		}else
			{
			foreach($_POST as $key=>$value)
				{
					$data['messages'][$key] = form_error($key);
				}
		}
		echo json_encode($data);
	}

	public function viewInventory()
	{
		$data['result'] = $this->AdminModel->getModelList();
		$this->load->view('manufacturerList',$data);
	}

	public function modelDetails(){
		
		$id =  $this->input->post('id');
		$filter = array('mo.id'=>$id);
		$data	= $this->AdminModel->getModelList($filter);
		echo json_encode($data);
	}

	public function deleteModel(){
		$data = array('success'=>false);
		$id =  $this->input->post('id');
		$filter = array('id'=>$id);
		$data	= $this->AdminModel->deleteModal($filter);
		
		if($data == 1){
			$data = array('success'=>true);
		}
		echo json_encode($data);
	}

	// function file_check($str){
	// 	$allowed_mime_type_err = array(
	// 		'image/jpeg',
	// 		'image/jpg',
	// 		'image/gif',
	// 		'image/png'
	// 	);
	// 	$mime = get_mime_by_extension($_FILES['image1']['name']);
		
	// 	if(isset($_FILES['image1']['name']) && !empty($_FILES['image1']['name'])){
	// 		if(in_array($mime,$allowed_mime_type_err)){
	// 			return TRUE;
	// 		}else{
	// 			$this->form_validation->set_message('file_check','Please Select only jpeg,jpg,gif,png');
	// 			return FALSE;
	// 		}
	// 	}else{
	// 		$this->form_validation->set_message('file_check','Please choose file to upload');
	// 		return TRUE;
	// 	}
	// }

	public function do_upload($inputName)
	{
			$config['upload_path']          = './assets/image';
			$config['allowed_types']        = 'gif|jpg|png|jpeg';
			$config['max_size']             = 1000;
			$config['max_width']            = 1024;
			$config['max_height']           = 1024;

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('image1'))
			{
					$error = array('error' => $this->upload->display_errors());
					print_r($error);exit;
					return $file_path = '';
			}
			else
			{
				    $upload_data = $this->upload->data();
					$file_path = $config['upload_path'] . '/' . $upload_data['file_name'];
					return $file_path;
					
 			}
	}

}
