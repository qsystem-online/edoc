<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {


	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
	}

	public function index(){
		$this->list();
	}


	public function speed_test(){
		$this->load->library("test");

		$url = base_url()."system/user/test";
		$param = array('email' => "anand.abhay1910@gmail.com" );
		//$param1 = array('name' => "Abhay",'email' => "anand.abhay1910@gmail.com" );
		$this->test->do_in_background($url, $param);
		//$this->test->test();

		echo " DONE !!!!";		

	}
	public function test(){
		set_time_limit(0);	
		echo "Session ID: ". session_id();
		session_write_close();	
		echo "after long process";
		echo "start :" .date("H:i:s");
		for($i= 0;$i<20;$i++){
			session_start();
			$this->session->set_userdata("test_progress", $i);
			sleep(1);
			session_write_close();
		}
		echo "Stop :" .date("H:i:s");

	}

	public function get_progress_test(){
		echo "Session ID: ". session_id();
		
		echo "Test Progress :" . $this->session->userdata("test_progress");
		
		//echo time();
	}


	public function list(){
		$this->load->library("menus");
		$main_header = $this->parser->parse('inc/main_header',[],true);
		$main_sidebar = $this->parser->parse('inc/main_sidebar',[],true);
		$page_content = $this->parser->parse('pages/system/user/user_list',[],true);
		$main_footer = $this->parser->parse('inc/main_footer',[],true);
		//$control_sidebar = $this->parser->parse('inc/control_sidebar',[],true);
		$control_sidebar = NULL;
		$this->data["MAIN_HEADER"] = $main_header;
		$this->data["MAIN_SIDEBAR"] = $main_sidebar;
		$this->data["PAGE_CONTENT"] = $page_content;
		$this->data["MAIN_FOOTER"] = $main_footer;
		$this->data["CONTROL_SIDEBAR"] = $control_sidebar;
		$this->parser->parse('template/main',$this->data);
	}


	private function openForm($mode = "ADD",$fin_id = 0){
		$this->load->library("menus");
		$this->load->model("groups_model");

		if($this->input->post("submit") != "" ){
			$this->add_save();
		}

		$main_header = $this->parser->parse('inc/main_header',[],true);
		$main_sidebar = $this->parser->parse('inc/main_sidebar',[],true);

		$data["groups"] = $this->groups_model->get_list_group();	
		$data["mode"] = $mode;
		$data["title"] = $mode == "ADD" ? "User Add" : "User Update";
		$data["fin_id"] = $fin_id;

		$page_content = $this->parser->parse('pages/system/user/user_form',$data,true);
		$main_footer = $this->parser->parse('inc/main_footer',[],true);
		
		$control_sidebar = NULL;
		$this->data["MAIN_HEADER"] = $main_header;
		$this->data["MAIN_SIDEBAR"] = $main_sidebar;
		$this->data["PAGE_CONTENT"] = $page_content;
		$this->data["MAIN_FOOTER"] = $main_footer;
		$this->data["CONTROL_SIDEBAR"] = $control_sidebar;
		$this->parser->parse('template/main',$this->data);
	}


	public function add(){
		$this->openForm("ADD",0);
	}

	public function Edit($fin_id){
		$this->openForm("EDIT",$fin_id);
	}


	public function ajx_add_save(){
		$this->load->model('users_model');
		$this->form_validation->set_rules($this->users_model->getRules("ADD",0));
		$this->form_validation->set_error_delimiters('<div class="text-danger">* ', '</div>');

		if ($this->form_validation->run() == FALSE){
			//print_r($this->form_validation->error_array());
			$this->ajxResp["status"] = "VALIDATION_FORM_FAILED";
			$this->ajxResp["message"] = "Error Validation Forms";
			$this->ajxResp["data"] = $this->form_validation->error_array();
			$this->json_output();
			return;
		}

		$data = [
			"fst_username"=>$this->input->post("fst_username"),
			"fst_password"=> md5("defaultpassword"),//$this->input->post("fst_password"),
			"fst_fullname"=>$this->input->post("fst_fullname"),
			"fdt_birthdate"=>$this->input->post("fdt_birthdate"),
			"fst_gender"=>$this->input->post("fst_gender"),
			"fst_active"=>'ACTIVE',
			"fst_birthplace"=>$this->input->post("fst_birthplace")
		];


		$this->db->trans_start();
		$insertId = $this->users_model->insert($data);
		$dbError  = $this->db->error();
		if ($dbError["code"] != 0){			
			$this->ajxResp["status"] = "DB_FAILED";
			$this->ajxResp["message"] = "Insert Failed";
			$this->ajxResp["data"] = $this->db->error();
			$this->json_output();
			$this->db->trans_rollback();
			return;
		}

		//Save Group
		$this->load->model("user_group_model");		
		$arr_group_id = $this->input->post("fin_group_id");
		if ($arr_group_id){
			foreach ($arr_group_id as $group_id) {
				$data = [
					"fin_group_id"=> $group_id,
					"fin_user_id"=> $insertId,
					"fst_active"=> "ACTIVE"
				];
				$this->user_group_model->insert($data);
			}
		}
		


		//Save File
		if(!empty($_FILES['fst_avatar']['tmp_name'])) {
			$config['upload_path']          = './assets/app/users/avatar';
			$config['file_name']			= 'avatar_'. $insertId . '.jpg' ;
			$config['overwrite']			= TRUE;
			$config['file_ext_tolower']		= TRUE;
			$config['allowed_types']        = 'gif|jpg|png';
			$config['max_size']             = 0; //kilobyte
			$config['max_width']            = 0; //1024; //pixel
			$config['max_height']           = 0; //768; //pixel

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('fst_avatar')){			
				$this->ajxResp["status"] = "IMAGES_FAILED";
				$this->ajxResp["message"] = "Failed to upload images, " . $this->upload->display_errors();
				$this->ajxResp["data"] = $this->upload->display_errors();
				$this->json_output();
				$this->db->trans_rollback();
				return;
			}else{
				//$data = array('upload_data' => $this->upload->data());			
			}
			$this->ajxResp["data"]["data_image"] = $this->upload->data();
		}


		$this->db->trans_complete();

		$this->ajxResp["status"] = "SUCCESS";
		$this->ajxResp["message"] = "Data Saved !";
		$this->ajxResp["data"]["insert_id"] = $insertId;
		$this->json_output();
		
	}

	public function ajx_edit_save(){
		$this->load->model('users_model');

		$fin_id = $this->input->post("fin_id");
		$data = $this->users_model->getDataById($fin_id);
		$user = $data["user"];
		if (!$user){
			$this->ajxResp["status"] = "DATA_NOT_FOUND";
			$this->ajxResp["message"] = "Data id $fin_id Not Found ";
			$this->ajxResp["data"] = [];
			$this->json_output();
			return;
		}

		
		$this->form_validation->set_rules($this->users_model->getRules("EDIT",$fin_id));
		$this->form_validation->set_error_delimiters('<div class="text-danger">* ', '</div>');
		if ($this->form_validation->run() == FALSE){
			//print_r($this->form_validation->error_array());
			$this->ajxResp["status"] = "VALIDATION_FORM_FAILED";
			$this->ajxResp["message"] = "Error Validation Forms";
			$this->ajxResp["data"] = $this->form_validation->error_array();
			$this->json_output();
			return;
		}

		$data = [
			"fin_id"=>$fin_id,
			"fst_username"=>$this->input->post("fst_username"),
			"fst_password"=> md5("defaultpassword"),//$this->input->post("fst_password"),
			"fst_fullname"=>$this->input->post("fst_fullname"),
			"fdt_birthdate"=>$this->input->post("fdt_birthdate"),
			"fst_gender"=>$this->input->post("fst_gender"),
			"fst_active"=>'ACTIVE',
			"fst_birthplace"=>$this->input->post("fst_birthplace")
		];


		$this->db->trans_start();

		$this->users_model->update($data);
		$dbError  = $this->db->error();
		if ($dbError["code"] != 0){			
			$this->ajxResp["status"] = "DB_FAILED";
			$this->ajxResp["message"] = "Insert Failed";
			$this->ajxResp["data"] = $this->db->error();
			$this->json_output();
			$this->db->trans_rollback();
			return;
		}

		//Save Group
		$this->load->model("user_group_model");
		$this->user_group_model->deleteByUserId($fin_id);

		$arr_group_id = $this->input->post("fin_group_id");
		if ($arr_group_id){
			foreach ($arr_group_id as $group_id) {
				$data = [
					"fin_group_id"=> $group_id,
					"fin_user_id"=> $fin_id,
					"fst_active"=> "ACTIVE"
				];
				$this->user_group_model->insert($data);
			}
		}
		


		//Save File
		if(!empty($_FILES['fst_avatar']['tmp_name'])) {
			$config['upload_path']          = './assets/app/users/avatar';
			$config['file_name']			= 'avatar_'. $insertId . '.jpg' ;
			$config['overwrite']			= TRUE;
			$config['file_ext_tolower']		= TRUE;
			$config['allowed_types']        = 'gif|jpg|png';
			$config['max_size']             = 0; //kilobyte
			$config['max_width']            = 0; //1024; //pixel
			$config['max_height']           = 0; //768; //pixel

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('fst_avatar')){			
				$this->ajxResp["status"] = "IMAGES_FAILED";
				$this->ajxResp["message"] = "Failed to upload images, " . $this->upload->display_errors();
				$this->ajxResp["data"] = $this->upload->display_errors();
				$this->json_output();
				$this->db->trans_rollback();
				return;
			}else{
				//$data = array('upload_data' => $this->upload->data());			
			}
			$this->ajxResp["data"]["data_image"] = $this->upload->data();
		}


		$this->db->trans_complete();

		$this->ajxResp["status"] = "SUCCESS";
		$this->ajxResp["message"] = "Data Saved !";
		$this->ajxResp["data"]["insert_id"] = $fin_id;
		$this->json_output();
		
	}




	public function ajx_add_address(){
		//print_r($this->input->post());
		$this->load->model('address_model');
		$this->form_validation->set_rules($this->address_model->rules);
		$this->form_validation->set_error_delimiters('<div class="text-danger">* ', '</div>');
		
		$data = [
			"fst_owner_by"=>"USER",
			"fin_owner_id"=> $this->input->post("fin_owner_id"),
			"fst_name"=>$this->input->post("fst_name"),
			"fst_address"=>$this->input->post("fst_address"),
			"fbl_primary"=>($this->input->post("fbl_primary") == "true") ? 1 : 0,
			"fst_active"=>'ACTIVE',
		];

		$this->form_validation->set_data($data);
		if ($this->form_validation->run() == FALSE){
			//print_r($this->form_validation->error_array());
			$this->ajxResp["status"] = "VALIDATION_FORM_FAILED";
			$this->ajxResp["message"] = "Error Validation Forms";
			$this->ajxResp["data"] = $this->form_validation->error_array();
			$this->json_output();
			return;
		}
		//Tambahan validasi
		$ssql = "select * from address where fst_owner_by = 'USER' and fin_owner_id = ? and fst_name = ?";
		$qr = $this->db->query($ssql,[$data["fin_owner_id"],$data["fst_name"]]);
		if ($qr->row()){
			$this->ajxResp["status"] = "VALIDATION_FORM_FAILED";
			$this->ajxResp["message"] = "Error Validation Forms";
			$this->ajxResp["data"] = ["fst_name"=>"Name already exist"];
			$this->json_output();
			return;	
		}

		$insertId = $this->address_model->insert($data);
		$this->ajxResp["status"] = "SUCCESS";
		$this->ajxResp["message"] = "Data Saved !";
		$this->ajxResp["data"]["insert_id"] = $insertId;
		$this->json_output();
	}

	public function ajx_del_address($fin_id){
		$this->load->model('address_model');
		$this->address_model->delete($fin_id,false);
		$this->ajxResp["status"] = "SUCCESS";
		$this->ajxResp["message"] = "Data Saved !";
		$this->ajxResp["data"]=[];
		$this->json_output();
	}

	public function add_save(){
		$this->load->model('users_model');

		$data=[
			'fst_fullname'=>'Devi Bastian',
			'fdt_insert_datetime'=>'sekarang'
		];
		if ($this->db->insert('users', $data)) {
			echo "insert success";
		}else{
			$error = $this->db->error();
			print_r($error);
		}
		die();

		echo "Table Name :" . $this->users_model->getTableName();
		print_r($this->users_model->getRules());
		
		$this->form_validation->set_rules($this->users_model->rules);
		$this->form_validation->set_error_delimiters('<div class="text-danger">* ', '</div>');
		// $this->form_validation->set_data($data); //set data array instead $_POST


		if ($this->form_validation->run() == FALSE){
			echo form_error();
			//$this->add();

		}else{
			//$this->load->view('formsuccess');
			echo "Success";
		}


		//print_r($_POST);
		$config['allowed_types'] = 'gif|jpg|png'; //Images extensions accepted
        $config['max_size']    = '2048'; 
        $config['max_width']  = '1024'; 
        $config['max_height']  = '768'; 
        $config['overwrite'] = TRUE; 
		$this->load->library('upload',$config);

		$upload_data = $this->upload->data("fst_avatar"); 

		print_r($upload_data);

		print_r($_FILES);
	}

	public function fetch_list_data(){
		$this->load->library("datatables");
		$this->datatables->setTableName("users");
		
		$selectFields = "fin_id,fst_fullname,fst_gender,fdt_birthdate,fst_birthplace,'action' as action";
		$this->datatables->setSelectFields($selectFields);

		$searchFields = ["fst_fullname","fst_birthplace"];
		$this->datatables->setSearchFields($searchFields);

		// Format Data
		$datasources = $this->datatables->getData();		
		$arrData = $datasources["data"];		
		$arrDataFormated = [];
		foreach ($arrData as $data) {
			$birthdate = strtotime($data["fdt_birthdate"]);			
			$data["fdt_birthdate"] = date("d-M-Y",$birthdate);

			//action
			$data["action"]	= "<div style='font-size:16px'>
					<a class='btn-edit' href='#' data-id='".$data["fin_id"]."'><i class='fa fa-pencil'></i></a>
					<a class='btn-delete' href='#' data-id='".$data["fin_id"]."' data-toggle='confirmation'><i class='fa fa-trash'></i></a>
				</div>";

			$arrDataFormated[] = $data;
		}
		$datasources["data"] = $arrDataFormated;
		$this->json_output($datasources);
	}
	
	public function fetch_data($fin_id){
		$this->load->model("users_model");

		$data = $this->users_model->getDataById($fin_id);

		//$this->load->library("datatables");		
		$this->json_output($data);

	}
	public function delete($id){
		if(!$this->aauth->is_permit("")){
			$this->ajxResp["status"] = "NOT_PERMIT";
			$this->ajxResp["message"] = "You not allowed to do this operation !";
			$this->json_output();
			return;
		}
		
		$this->load->model("users_model");
		
		$this->users_model->delete($id);
		$this->ajxResp["status"] = "SUCCESS";
		$this->ajxResp["message"] = "";
		$this->json_output();





	}
}