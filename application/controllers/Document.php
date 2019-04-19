<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Document extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
	}

	public function index(){

		$this->load->library('menus');
        $this->list['page_name']="Documents";
        $this->list['list_name']="Document List";
        $this->list['addnew_ajax_url']=site_url().'document/add';
        $this->list['pKey']="id";
		$this->list['fetch_list_data_ajax_url']=site_url().'document/fetch_list_data';
        $this->list['delete_ajax_url']=site_url().'document/delete/';
        $this->list['edit_ajax_url']=site_url().'document/edit/';
        $this->list['arrSearch']=[
			'a.fst_name' => 'Document Name',
			'a.fst_search_marks' => 'Search Mark',
			'a.fst_memo' => 'Memo',
		];
		
		$this->list['breadcrumbs']=[
			['title'=>'Home','link'=>'#','icon'=>"<i class='fa fa-dashboard'></i>"],
			['title'=>'Document','link'=>'#','icon'=>''],
			['title'=>'List','link'=> NULL ,'icon'=>''],
		];

		
		$this->list['columns']=[
			['title' => 'ID', 'width'=>'10%', 'data'=>'fin_document_id'],
			['title' => 'Name', 'width'=>'35%', 'data'=>'fst_name'],
			['title' => 'memo', 'width'=>'30%', 'data'=>'fst_memo'],
			['title' => 'Source', 'width'=>'5%', 'data'=>'fst_source',
				'render'=>"function(data, type, row) {
					if (data == 'INT'){
						return 'INTERNAL';
					}else{
						return 'EXTERNAL';
					}
				}",
			],			
			['title' => 'Flow', 'width'=>'5%', 'data'=>'fbl_flow_control',
				'render'=> "function(data, type, row) {						
					if (data == 1) {
						return \"<input type='checkbox' class='editor-active' onclick='return false' checked>\";
					} else {
						return \"<input type='checkbox' class='editor-active' onclick='return false'>\";
					}
					return data;
				}",
			],					
			['title' => 'Action', 'width'=>'15%', 'data'=>'action','sortable'=>false, 'className'=>'dt-body-center text-center']
		];
        $main_header = $this->parser->parse('inc/main_header',[],true);
        $main_sidebar = $this->parser->parse('inc/main_sidebar',[],true);
        $page_content = $this->parser->parse('template/standardList',$this->list,true);
        $main_footer = $this->parser->parse('inc/main_footer',[],true);
        $control_sidebar=null;
        $this->data['ACCESS_RIGHT']="A-C-R-U-D-P";
        $this->data['MAIN_HEADER'] = $main_header;
        $this->data['MAIN_SIDEBAR']= $main_sidebar;
        $this->data['PAGE_CONTENT']= $page_content;
        $this->data['MAIN_FOOTER']= $main_footer;        
		$this->parser->parse('template/main',$this->data);
		
	}

	private function openForm($mode = "ADD",$fin_document_id = 0){
		$this->load->library("menus");
		

		if($this->input->post("submit") != "" ){
			$this->add_save();
		}

		$main_header = $this->parser->parse('inc/main_header',[],true);
		$main_sidebar = $this->parser->parse('inc/main_sidebar',[],true);

		$data["mode"] = $mode;
		$data["title"] = $mode == "ADD" ? lang("Document Add") : lang("Document Update");
		$data["fin_document_id"] = $fin_document_id;
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

	public function Edit($fin_document_id){
		$this->openForm("EDIT",$fin_document_id);
	}


	public function ajx_add_save(){

		//Harus ada File di Upload
		$realDocumentFileName = "";
		if(!empty($_FILES['fst_file_name']['tmp_name'])) {
			$realDocumentFileName =  $_FILES['fst_file_name']['name'];
		}else{
			$this->ajxResp["status"] = "VALIDATION_FORM_FAILED";
			$this->ajxResp["message"] = "Error Validation Forms";
			$this->ajxResp["data"] = ["fst_file_name" =>"Harus ada document yang di upload"];			
			$this->json_output();
			return;
		}

		$this->load->model('documents_model');
		$this->form_validation->set_rules($this->documents_model->getRules("ADD",0));
		$this->form_validation->set_error_delimiters('<div class="text-danger">* ', '</div>');

		$data = [
			//"fin_document_id"=>$this->input->post("fst_username"),
			"fst_name"=>$this->input->post("fst_name"),
			"fst_source"=>$this->input->post("fst_source"),
			"fst_created_via"=>"MANUAL",
			"fin_confidential_lvl"=>$this->input->post("fin_confidential_lvl"),
			"fst_view_scope"=>$this->input->post("fst_view_scope"),
			"fst_print_scope"=>$this->input->post("fst_print_scope"),
			"fbl_flow_control"=> ($this->input->post("fbl_flow_control") == NULL) ? 0 : 1,
			//"fin_flow_control_schema"=>$this->input->post(""),
			"fst_search_marks"=>$this->input->post("fst_search_marks"),
			"fst_memo"=>$this->input->post("fst_memo"),
			"fdt_published_date"=> dBDateFormat($this->input->post("fdt_published_date")),
			"fbl_flow_completed"=>0,
			"fin_version"=>0,
			"fst_real_file_name"=> $realDocumentFileName,
			"fst_active"=>"A",		
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

		$this->db->trans_start();
		$insertId = $this->documents_model->insert($data);
		$dbError  = $this->db->error();
		if ($dbError["code"] != 0){			
			$this->ajxResp["status"] = "DB_FAILED";
			$this->ajxResp["message"] = "Insert Failed";
			$this->ajxResp["data"] = $this->db->error();
			$this->json_output();
			$this->db->trans_rollback();
			return;
		}

		//Save File & cek revision and rule when flow control
		//print_r($_FILES);
		/*Array ( [name] => helloworld.pdf 
			[type] => application/pdf 
			[tmp_name] => D:\xampp\tmp\php9974.tmp
			[error] => 0 
			[size] => 678 ) 
			)
		//size in byte
		*/
		if(!empty($_FILES['fst_file_name']['tmp_name'])) {
			$config['upload_path']          = getDbConfig("document_folder");
			$config['file_name']			=  md5('doc_'. $insertId .'_0');  //'doc_'. $insertId .'_0'. '.pdf' ;
			//$config['encrypt_name'] 		= TRUE;
			$config['overwrite']			= TRUE;
			$config['file_ext_tolower']		= TRUE;
			$config['allowed_types']        = 'pdf'; //'gif|jpg|png';
			$config['max_size']             = (int) getDbConfig("document_max_size"); //kilobyte
			$config['max_width']            = 0; //1024; //pixel
			$config['max_height']           = 0; //768; //pixel

			

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('fst_file_name')){			
				$this->ajxResp["status"] = "VALIDATION_FORM_FAILED";
				$this->ajxResp["message"] = "Failed to upload document";// . $this->upload->display_errors();
				$this->ajxResp["data"] = ["fst_file_name" =>$this->upload->display_errors()];
				$this->json_output();
				$this->db->trans_rollback();
				return;
			}else{
				//$data = array('upload_data' => $this->upload->data());			
			}
			//print_r($this->upload->data());
			$this->ajxResp["data"]["document_upload"] = $this->upload->data();
		}
		
		//Detail Document
		$this->load->model('document_details_model');
		$this->form_validation->set_rules($this->document_details_model->getRules("ADD",0));
		$this->form_validation->set_error_delimiters('<div class="text-danger">* ', '</div>');
		$detail_doc_items = $this->input->post("detail_doc_items");
		$detail_doc_items = json_decode($detail_doc_items);
		//print_r($detail_doc_items);
		//echo "<br><br><br>";
		foreach ($detail_doc_items as $doc_item) {
			$dataTmp = [			
				//fin_id
				"fin_document_id"=> $insertId,
				"fin_document_item_id" => $doc_item->fin_document_id,
				"fst_active"=>"A"
			];
			$this->form_validation->set_data($dataTmp);
			if ($this->form_validation->run() == FALSE){
				//print_r($this->form_validation->error_array());
				$this->ajxResp["status"] = "VALIDATION_FORM_FAILED";
				$this->ajxResp["message"] = "Error Validation Detail Document";
				$this->ajxResp["data"] = $this->form_validation->error_array();
				$this->json_output();
				return;
			}
			$this->document_details_model->insert($dataTmp);
		}


		//Detail Flow
		if ($data["fbl_flow_control"] == 1){
			$this->load->model('document_flow_control_model');
			$this->form_validation->set_rules($this->document_flow_control_model->getRules("ADD",0));
			$this->form_validation->set_error_delimiters('<div class="text-danger">* ', '</div>');
			$detail_flow_control = $this->input->post("detail_flow_control");
			$detail_flow_control = json_decode($detail_flow_control);
			//print_r($detail_flow_control);
			//echo "<br><br><br>";
			foreach ($detail_flow_control as $flow_control) {
				$dataTmp = [			
					"fin_document_id"=> $insertId,
					"fin_seq_no"=> $flow_control->fin_seq_no,
					"fin_user_id"=> $flow_control->fin_user_id,
					"fst_control_status " => "NA",   // NA->Need Approval;RA->Ready to Approve;NR->Need Revision
					"fst_memo" => NULL,
					"fdt_approved_datetime" => NULL,
					"fin_version" => 0,
					"fst_active" => "A",
					"fin_document_id"=> $insertId,
					"fin_document_item_id" => $doc_item->fin_document_id,
					"fst_active"=>"A"
				];
				$this->form_validation->set_data($dataTmp);
				if ($this->form_validation->run() == FALSE){
					//print_r($this->form_validation->error_array());
					$this->ajxResp["status"] = "VALIDATION_FORM_FAILED";
					$this->ajxResp["message"] = "Error Validation Detail Flow";
					$this->ajxResp["data"] = $this->form_validation->error_array();
					$this->json_output();
					return;
				}
				$this->document_flow_control_model->insert($dataTmp);
			}			
		}

		
		//Detail Custom Scope
		$this->load->model('document_custom_permission_model');
		$this->form_validation->set_rules($this->document_custom_permission_model->getRules("ADD",0));
		$detail_custom_scope = $this->input->post("detail_custom_scope");
		$detail_custom_scope = json_decode($detail_custom_scope);
		//print_r($detail_custom_scope);

		foreach ($detail_custom_scope as $scope) {
			$dataTmp = [
				"fin_document_id"=>$insertId,
				"fst_mode"=> $scope->fst_mode,
				"fin_user_department_id"=> $scope->fin_user_department_id,
				"fbl_view" => ($scope->fbl_view == NULL) ? 0 : 1,
				"fbl_print" => ($scope->fbl_print == NULL) ? 0 : 1,
				"fst_active" => "A"
			];
			$this->form_validation->set_data($dataTmp);
			if ($this->form_validation->run() == FALSE){
				$this->ajxResp["status"] = "VALIDATION_FORM_FAILED";
				$this->ajxResp["message"] = "Error Validation Custom Scope";
				$this->ajxResp["data"] = $this->form_validation->error_array();
				$this->json_output();
				return;
			}
			$this->document_custom_permission_model->insert($dataTmp);
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
		
		$selectFields = "a.fin_document_id,a.fst_name,a.fst_source,a.fst_memo,a.fbl_flow_control,a.fin_insert_id,b.fst_username,a.fdt_insert_datetime";
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
			$insertDateTime = strtotime($data["fdt_insert_datetime"]);						
			$data["fdt_insert_datetime"] = date("d-M-Y H:i:s",$insertDateTime);

			$data["action"]	= "<div style='font-size:16px'>
					<a class='btn-view' href='#' data-id='".$data["fin_document_id"]."'><i class='fa fa-search-plus' aria-hidden='true'></i></a>
					<a class='btn-edit' href='#' data-id='".$data["fin_document_id"]."'><i class='fa fa-pencil' aria-hidden='true'></i></a>
					<a class='btn-delete' href='#' data-id='".$data["fin_document_id"]."' data-toggle='confirmation'><i class='fa fa-trash' aria-hidden='true' ></i></a>
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