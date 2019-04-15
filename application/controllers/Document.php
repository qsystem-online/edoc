<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Document extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
	}

	public function index(){
		$this->list();
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
		

		if($this->input->post("submit") != "" ){
			$this->add_save();
		}

		$main_header = $this->parser->parse('inc/main_header',[],true);
		$main_sidebar = $this->parser->parse('inc/main_sidebar',[],true);

		$data["mode"] = $mode;
		$data["title"] = $mode == "ADD" ? lang("Document Add") : lang("Document Update");
		$data["fin_id"] = $fin_id;
		$data["base_url"] = base_url();
		$data["active_user_id"] = $this->aauth->get_user_id();

		$page_content =$this->parser->parse('pages/document/form',$data,true);
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

	public function fetch_list_data(){
		$this->load->library("datatables");
		$this->datatables->setTableName("documents a inner join users b on a.fin_insert_id = b.fin_user_id ");
		
		$selectFields = "fin_document_id,fst_name,fst_source,fst_memo,a.fin_insert_id,b.fst_username,a.fdt_insert_datetime";
		$this->datatables->setSelectFields($selectFields);
		$searchFields =[];
		$searchFields[] = $this->input->get('optionSearch'); //["fst_fullname","fst_birthplace"];
		$this->datatables->setSearchFields($searchFields);
		$this->datatables->activeCondition = "a.fst_active !='D'";
		// Format Data
		$datasources = $this->datatables->getData();		
		$arrData = $datasources["data"];		
		$arrDataFormated = [];
		foreach ($arrData as $data) {
			$birthdate = strtotime($data["fdt_insert_datetime"]);			
			$data["fdt_insert_datetime"] = date("d-M-Y H:i:s",$birthdate);
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