<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {
	var $edit_id_hold = '';
	
	var $logged_id = 0;
	var $user_id = 0;
	var $user_full_name = 0;
	var $user_admin_level = 0;
	public $db;
	
	public function __construct(){
		
		parent:: __construct();
		
		if(!$this->session->userdata('user_id')){
			$this->user_id = $this->session->userdata('user_id');
			$this->user_full_name = $this->session->userdata('user_full_name');
			$this->user_admin_level = $this->session->userdata('user_admin_level');
		}
		
		$this->load->model('user_model');
		$this->db = new MysqliDb ();
	}
	
	public function index()
	{
		
		redirect(SITE_ROOT_TWO.'member/login', 'refresh');
		
	}
	
	
	
	function test_upload3(){
		$data=array();
		
		$data['page']="test_upload";
		
		$this->load->view('header_main', $data);
		$this->load->view('upload_test3', $data);
		$this->load->view('footer_main');
	}
	
	function feed_post_upload(){
			
			$upload_success = null;
		  	$upload_error = '';
			$this->load->library('mediauploadclass');
			
			$user_id = $this->session->userdata('user_id');
			
			$mediauploadclass = new mediauploadclass;
			
			$mediauploadclass->setDefaults('media_tbl', MEDIA_DIR, $user_id);
			
			$feed_page_id = $_POST['feed_page_id'];
			//print_r($_POST);
		
		 	 if (!empty($_FILES['files'])) {
				/*
			  	the code for file upload;
			  	$upload_success – becomes "true" or "false" if upload was unsuccessful;
			  	$upload_error – an error message of if upload was unsuccessful;
				*/
				
				for($x=0; $x<count($_FILES["files"]["tmp_name"]); $x++){
					
					
					$the_file["tmp_name"] = $_FILES["files"]["tmp_name"][$x];
					$the_file["name"] = $_FILES["files"]["name"][$x];
					$the_file["type"] = $_FILES["files"]["type"][$x];
					$the_file["size"] = $_FILES["files"]["size"][$x];
					$the_file['error'] = $_FILES["files"]["error"][$x];
					
					$return_array = $mediauploadclass->upload($the_file);
					print_r($return_array);
					
					if($return_array['error']==0){
						
						//$return_array['fileTempName'];
						//$return_array['status'];
						
						$madia_array['error'] = $return_array['error'];
						$madia_array['filename'] = $return_array['newFileName'];
						$madia_array['file_type'] = $return_array['fileType'];
						$madia_array['uploaded_as'] = $return_array['fileName'];
						$madia_array['size'] = $return_array['fileSize'];
						$madia_array['file_ext'] = $return_array['fileExt'];
						$madia_array['media_type_id'] = $return_array['media_type'];
						$madia_array['feed_page_id'] = $feed_page_id;
						$madia_array['uploaded_timestamp'] = time();
						$madia_array['error_msg'] = '';
						$madia_array['user_id'] = $user_id;
						
						if($return_array['media_type']==1){
							$madia_array['width'] = $return_array['width'];
							$madia_array['height'] = $return_array['height'];
						}
						
						$id = $this->db->insert ('media_tbl', $madia_array);
						/*
						*/
					}else{
						//$return_array['fileTempName'];
						//$return_array['status'];
						//echo "Here";
						
						$madia_array['file_type'] = $return_array['fileType'];
						$madia_array['uploaded_as'] = $return_array['fileName'];
						$madia_array['size'] = $return_array['fileSize'];
						$madia_array['file_ext'] = $return_array['fileExt'];
						$madia_array['error_msg'] = $return_array['msg'];
						$madia_array['error'] = $return_array['error'];
						$madia_array['feed_page_id'] = $feed_page_id;
						$madia_array['uploaded_timestamp'] = time();
						$madia_array['user_id'] = $user_id;
						
						$id = $this->db->insert ('media_tbl', $madia_array);
						/*
						*/
					}
				}
				
				
		  	}

			 
	}
	
	function login()
	{
		
		$pageTitle['title'] = "Login";
		$data['title'] = "Login";
		$data['page']='login';
		
	
		
		$this->load->helper(array('form', 'url'));		

		$this->load->library('form_validation');
		

		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('header_main', $data);
			$this->load->view('main_login', $data);
			$this->load->view('footer_main');
		}
		else
		{
			
			$this->load->library('dataconnection');	
			$pass=$_POST['password'];
			$pass=$this->dataconnection->safeInputFunction($pass);
			$userEmail=$_POST['email'];
			
			$this->load->model('user_model');
			

			$returnedData = $this->user_model->validateUser($userEmail, $pass);
			
			if(isset($returnedData[0]['user_id'])){
			
				$this->session->set_userdata('user_id', $returnedData[0]['user_id']);
				$this->session->set_userdata('user_full_name', $returnedData[0]['user_first_name'] . " " . $returnedData[0]['user_last_name']);
				$this->session->set_userdata('user_admin_level', $returnedData[0]['user_type']);
				
				
				redirect(SITE_ROOT_TWO.'feed/', 'refresh');
		
				
			}else{
				$data['fail']=1;
			
				$this->load->view('header_main', $data);
				$this->load->view('main_login', $data);
				$this->load->view('footer_main');
			}

			
		}
		
		
	}
	
	public function dashboard(){
		
		if(!$this->session->userdata('user_id')){
			redirect(SITE_ROOT_TWO.'member/login', 'refresh');
			exit();
		}
		
		$data = array();
		$data['page']="main_dashboard";
		$data['title'] = "My Dashboard";
		$this->load->view('header',$data);
		$this->load->view('main_dashboard',$data);
		$this->load->view('footer',$data);
	}
	
	public function user_list($user_status=1, $sort_option=0){
		
		if(!$this->session->userdata('user_id')){
			redirect(SITE_ROOT_TWO.'member/login', 'refresh');
			exit();
		}
		if($this->session->userdata('user_admin_level')<10){
			redirect(SITE_ROOT_TWO.'error/index/1', 'refresh');
			exit();
		}
		
		$this->load->model('user_model');
		
		$config["base_url"] = SITE_ROOT_TWO . "member/user_list/$user_status/$sort_option/";
        $config["total_rows"] = $this->user_model->userListCount($user_status);
        $config["per_page"] = 25;
        $config["uri_segment"] = 5;
		
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = "<li class='notactive'>";
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='active'>";
		$config['cur_tag_close'] = "</li>";
		$config['next_tag_open'] = "<li class='notactive'>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li class='notactive'>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li class='notactive'>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li class='notactive'>";
		$config['last_tagl_close'] = "</li>";
		
		//print_r($config);
		
		$this->pagination->initialize($config);
		
		$data["links"] = $this->pagination->create_links();
		
		//echo $this->uri->segment(5);
		
		$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		
		$data["employee_basic_list"]=1;
		
		$data['user_list'] = $this->user_model->userList($user_status, $sort_option, $config["per_page"], $page);
		
		$data['title'] = "User List";
		$data['page']='user';
		$this->load->view('header',$data);
		$this->load->view('user_list',$data);
		$this->load->view('footer',$data);
	}
	
	function create_edit_user($user_id=0){
		if(!$this->session->userdata('user_id')){
			redirect(SITE_ROOT_TWO.'member/login', 'refresh');
			exit();
		}
		if($this->session->userdata('user_admin_level')<10){
			redirect(SITE_ROOT_TWO.'error/index/1', 'refresh');
			exit();
		}
		
		$this->edit_id_hold = $user_id;
		
		$this->load->helper('get_state_list');
		$data['statelist'] = stateArray();
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('user_first_name', 'First Name', 'required');
		$this->form_validation->set_rules('user_last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('user_email', 'Email', 'required|valid_email|callback_new_email');
		//$this->form_validation->set_rules('user_password', 'Password', 'required');
		//$this->form_validation->set_rules('user_password_confirm', 'Confirm Password', 'required|matches[user_password]');
		$this->form_validation->set_rules('user_password', 'Password', 'required|matches[user_password_confirm]');
		$this->form_validation->set_rules('user_password_confirm', 'Confirm Password', 'required');
		$this->form_validation->set_rules('address', '', 'callback_return_true_cb');
		$this->form_validation->set_rules('address2', '', 'callback_return_true_cb');
		$this->form_validation->set_rules('city', '', 'callback_return_true_cb');
		$this->form_validation->set_rules('state', '', 'callback_return_true_cb');
		$this->form_validation->set_rules('zip', '', 'callback_return_true_cb');
		$this->form_validation->set_rules('phone1', '', 'callback_return_true_cb');
		$this->form_validation->set_rules('phone2', '', 'callback_return_true_cb');
		$this->form_validation->set_rules('user_status', '', 'callback_return_true_cb');
		$this->form_validation->set_rules('user_admin_level', '', 'callback_return_true_cb');
		$this->form_validation->set_rules('user_id', '', 'callback_return_true_cb');
		
		if($user_id!=0){
			$data['userArray'] = $this->user_model->getUsernfo($user_id);
			$data['userArray'] = $data['userArray'][0];
			//print_r($data['userArray']);
			$data['page_top'] = "Edit ". $data['userArray']->user_full_name;
			$data['user_id'] = $user_id;
		}else{
			$data['userArray'] = array();
			$data['page_top'] = "Create User";
			$data['user_id'] = 0;
		}
		
		$data['title'] = "Create Edit User";
		$data['page']='create_edit_user';
		
		
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('header',$data);
			$this->load->view('user_create_edit',$data);
			$this->load->view('footer',$data);
		}else{
			if(validation_errors()==''){
				
				$aFieldInfo['user_first_name']=$_POST['user_first_name'];
				$aFieldInfo['user_last_name']=$_POST['user_last_name'];
				$aFieldInfo['user_email']=$_POST['user_email'];
				$aFieldInfo['user_password']=$_POST['user_password'];
				$aFieldInfo['address1']=$_POST['address'];
				$aFieldInfo['address2']=$_POST['address2'];
				$aFieldInfo['city']=$_POST['city'];
				$aFieldInfo['state']=$_POST['state'];;
				$aFieldInfo['zip']=$_POST['zip'];
				$aFieldInfo['phone1']=$_POST['phone1'];
				$aFieldInfo['phone2']=$_POST['phone2'];
				$aFieldInfo['user_status']=$_POST['user_status'];
				$aFieldInfo['user_admin_level']=$_POST['user_admin_level'];
										
				
				$this->load->library('dataconnection');
				$sTableName = "user_tbl";
					
				if($_POST['user_id']==0){
					$this->dataconnection->logToDatabaseViaArray($aFieldInfo, $sTableName);
					$user_id = $this->dataconnection->getInsertId();
				}else{
					$this->dataconnection->logToDatabaseViaArray($aFieldInfo, $sTableName, "WHERE user_id = ".$user_id, "UPDATE");
				}
					
							
				redirect(SITE_ROOT_TWO.'member/user_list');  // GO TO User List Page
					
			}else{
					
				$data['db_reply']['error_state']=1;
							
					
				$this->load->view('header',$data);
				$this->load->view('user_create_edit',$data);
				$this->load->view('footer',$data);
				
					
			}
				
			
		}
		
	}
	
	
	
	
	function logout(){
		$this->load->helper('url'); 
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('user_admin_level');
		$this->session->unset_userdata('user_full_name');
		$this->session->sess_destroy();
		redirect(SITE_ROOT_TWO.'member/login/', 'refresh');
	
	}
	
	
	
	public function return_true_cb(){
		return true;
	}
	
	public function new_email($email_address){
		
		$user_id = $this->edit_id_hold;
		
		$this->load->model('user_model');
		
		$number_of_addresses = $this->user_model->checkForExistingEmail($user_id, $email_address);
		
		if($number_of_addresses>0){
			$this->form_validation->set_message('new_email', 'That Email Address Already Exists');
			return false;
		}else{
			return true;
		}
		
	}
	
	public function download_document($media_id){
		
		$this->load->model('media_model');
		
		
		$mediaArray = $this->media_model->getMediaFile($media_id);
		
		$data['mediaArray'] = $mediaArray[0];
		
		$file_type = $data['mediaArray']['file_ext'];
		$old_filename = $data['mediaArray']['uploaded_as'];
		$filename = $data['mediaArray']['filename'];
				
		if($file_type=='doc' || $file_type=='docx'){
			$content_type = 'application/msword';
		}
		if($file_type=='xlsx' || $file_type=='xls' || $file_type=='csv'){
			$content_type = 'application/ms-excel';
		}
		if($file_type=='pdf'){
			$content_type = 'application/pdf';
		}
		if($file_type=='txt'){
			$content_type = 'text/plain';
		}
		if($file_type=='zip'){
			$content_type = 'application/zip';
		}
		if($file_type=='wav'){
			$content_type = 'audio/x-wav';
		}
		if($file_type=='mp3'){
			$content_type = 'audio/mpeg';
		}
		if($file_type=='vsd'){
			$content_type = 'application/x-visio';
		}
		if($file_type=='mpp'){
			$content_type = 'application/vnd.ms-project';
		}
		if($file_type=='jpeg'){
			$content_type = 'image/jpeg';
		}
		if($file_type=='jpg'){
			$content_type = 'image/jpeg';
		}
		if($file_type=='gif'){
			$content_type = 'image/gif';
		}
		if($file_type=='png'){
			$content_type = 'image/png';
		}
		if($file_type=='pub'){
			$content_type = 'application/x-mspublisher';
		}
		if($file_type=='xml'){
			$content_type = 'text/xml';
		}
		if($file_type=='ppt' || $file_type=='pptx'){
			$content_type = 'application/mspowerpoint';
		}
		if($file_type=='psd'){
			$content_type = 'application/photoshop';
		}
		if($file_type=='ai'){
			$content_type = 'application/illustrator';
		}
		if($file_type=='rtf'){
			$content_type = 'application/rtf';
		}
		
		//echo SITE_ROOT . 'media_files/'.$filename;
		
		if(file_exists(MEDIA_DIR . '\\'.$filename)){ 
			header('Content-type: '.$content_type);
			
			header('Content-Disposition: attachment; filename="'.$old_filename.'"');
			
			readfile(MEDIA_DIR . '\\'.$filename);
			
		}else{
			redirect(SITE_ROOT_TWO.'error/index/1/media_files/user_media/'.$filename.'/');
			//echo SITE_ROOT . 'media_files/'.$filename;
		}
		
	}
}

