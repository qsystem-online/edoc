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

	private function openForm($mode = "ADD",$fin_document_id = ""){
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

	public function approval($fin_document_flow_control_id){		
		$this->load->library("menus");
		$this->load->model("document_flow_control_model");


		$flowControl = $this->document_flow_control_model->getDataById($fin_document_flow_control_id);
		if ($flowControl){
			$fin_document_id = $flowControl->fin_document_id;
		}else{
			show_404();
		}

		$main_header = $this->parser->parse('inc/main_header',[],true);
		$main_sidebar = $this->parser->parse('inc/main_sidebar',[],true);

		$data["title"] = lang("Approval Document");
		$data["fin_document_flow_control_id"] = $fin_document_flow_control_id;
		$data["fin_document_id"] = $fin_document_id;
		$data["base_url"] = base_url();
		$data["active_user_id"] = $this->aauth->get_user_id();

		$page_content =$this->parser->parse('pages/document/form_approval',$data,true);
		$main_footer = $this->parser->parse('inc/main_footer',[],true);
		
		$control_sidebar = NULL;
		$this->data["MAIN_HEADER"] = $main_header;
		$this->data["MAIN_SIDEBAR"] = $main_sidebar;
		$this->data["PAGE_CONTENT"] = $page_content;
		$this->data["MAIN_FOOTER"] = $main_footer;
		$this->data["CONTROL_SIDEBAR"] = $control_sidebar;
		$this->parser->parse('template/main',$this->data);

	}

	public function do_approval_flow_control(){
		$this->load->model("document_flow_control_model");
		$finId = $this->input->post("fin_id");
		$flowControl = $this->document_flow_control_model->getDataById($finId);
		if ($flowControl->fst_control_status != "RA"){
			$this->ajxResp["status"] = "VALIDATION_FORM_FAILED";
			$this->ajxResp["message"] = lang("Invalid Request !");
			$this->ajxResp["data"] = ["errors" =>"Status Not Ready To Approve"];			
			$this->json_output();
			return;
		}
		if ($flowControl->fin_user_id != $this->aauth->get_user_id()){
			$this->ajxResp["status"] = "VALIDATION_FORM_FAILED";
			$this->ajxResp["message"] = lang("Invalid Request !");
			$this->ajxResp["data"] = ["errors" =>"Invalid user to do approval"];			
			$this->json_output();
			return;
		}
		$data = [
			"fin_id"=>$finId,
			"fst_control_status" => $this->input->post("fst_control_status"),
			"fst_memo" => $this->input->post("fst_memo"),
			"fdt_approved_datetime" => date("Y-m-d H:i:s")
		];

		$this->db->trans_start();
		$this->document_flow_control_model->update($data);
		$this->db->trans_complete();

		$this->ajxResp["status"] = "SUCCESS";
		$this->ajxResp["message"] = lang("Document Approved !");
		$this->ajxResp["data"] = ["errors" =>"Invalid user to do approval"];			
		$this->json_output();
		

	}

	public function add(){
		$this->openForm("ADD","");
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
		try{
			$insertId = $this->documents_model->insert($data);			

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
		}catch(Exception $e){
			if ($e->getCode() == 1000){
				$dbError  = $this->db->error();
				$this->ajxResp["status"] = "DB_FAILED";
				$this->ajxResp["message"] = "Insert Failed";
				$this->ajxResp["data"] = $this->db->error();
				$this->ajxResp["debug"] = print_r($e,true);
				$this->json_output();
				$this->db->trans_rollback();
				return;
			}			
		}
		
		$this->db->trans_complete();
		$this->ajxResp["status"] = "SUCCESS";
		$this->ajxResp["message"] = "Data Saved !";
		$this->ajxResp["data"]["insert_id"] = $insertId;
		$this->json_output();		
	}

	public function ajx_edit_save(){
		$this->load->model('documents_model');

		$fin_document_id = $this->input->post("fin_document_id");

		//Cek edit permission
		if(! $this->documents_model->editPermission($fin_document_id)){
			show_404();
			$this->ajxResp["status"] = "NO_PERMISSION";
			$this->ajxResp["message"] = "You dont have permission to do this!";
			$this->ajxResp["data"] = [];
			$this->json_output();
			return;
		}
		
		$existingDoc = $this->documents_model->getDataById($fin_document_id);
		if ($existingDoc == null){
			show_404();
		}

		$docVersion =  $existingDoc->fin_version;

		$realDocumentFileName = "";
		if(!empty($_FILES['fst_file_name']['tmp_name'])) {
			$realDocumentFileName =  $_FILES['fst_file_name']['name'];
			$docVersion++;
		}

		
		$this->form_validation->set_rules($this->documents_model->getRules("ADD",0));
		$this->form_validation->set_error_delimiters('<div class="text-danger">* ', '</div>');
		$data = [
			//"fin_document_id"=>$this->input->post("fst_username"),
			"fin_document_id"=>$fin_document_id,
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
			"fst_active"=>"A",		
		];
		if ($realDocumentFileName != ""){ //dokument pdf di rubah
			// catat versioning
			$data["fin_version"] = $docVersion;
			$data["fst_real_file_name"] = $realDocumentFileName;			
		}
		$this->form_validation->set_data($data);
		if ($this->form_validation->run() == FALSE){
			//print_r($this->form_validation->error_array());
			$this->ajxResp["status"] = "VALIDATION_FORM_FAILED";
			$this->ajxResp["message"] = "Error Validation Forms";
			$this->ajxResp["data"] = $this->form_validation->error_array();
			$this->json_output();
			return;
		}
		
		try{

			$this->db->trans_start();
			
			//save header			
			$this->documents_model->update($data);

			//Save File Document
			if ($realDocumentFileName != ""){ //dokument pdf di rubah				
				$config['upload_path']          = getDbConfig("document_folder");
				$config['file_name']			=  md5('doc_'. $fin_document_id .'_' . $docVersion );  //'doc_'. $insertId .'_0'. '.pdf' ;
				$config['overwrite']			= TRUE;
				$config['file_ext_tolower']		= TRUE;
				$config['allowed_types']        = 'pdf'; //'gif|jpg|png';
				$config['max_size']             = (int) getDbConfig("document_max_size"); //kilobyte
				$config['max_width']            = 0; 
				$config['max_height']           = 0; 
				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload('fst_file_name')){			
					$this->ajxResp["status"] = "VALIDATION_FORM_FAILED";
					$this->ajxResp["message"] = "Failed to upload document";// . $this->upload->display_errors();
					$this->ajxResp["data"] = ["fst_file_name" =>$this->upload->display_errors()];
					$this->json_output();
					$this->db->trans_rollback();
					return;
				}
				$this->ajxResp["data"]["document_upload"] = $this->upload->data();			

				//Add Versioning History
				$this->load->model("document_histories_model");
				$dataHistory = [
					"fin_document_id" => $fin_document_id,
					"fst_memo" => $existingDoc->fst_memo,
					"fin_version" => $existingDoc->fin_version,
					"fst_active" => "A"
				];
				$this->document_histories_model->insert($dataHistory);
			}

			//Save Document Detail;
			$this->load->model('document_details_model');
			$detail_doc_items = $this->input->post("detail_doc_items");
			$detail_doc_items = json_decode($detail_doc_items);
			
			$this->document_details_model->deleteByParentId($fin_document_id);

			foreach ($detail_doc_items as $doc_item) {
				$dataDocDetail = [			
					"fin_id" => $doc_item->fin_id,
					"fin_document_id"=> $fin_document_id,
					"fin_document_item_id" => $doc_item->fin_document_id,
					"fst_active"=>"A"
				];
				$this->form_validation->set_data($dataDocDetail);
				if ($this->form_validation->run() == FALSE){
					//print_r($this->form_validation->error_array());
					$this->ajxResp["status"] = "VALIDATION_FORM_FAILED";
					$this->ajxResp["message"] = "Error Validation Detail Document";
					$this->ajxResp["data"] = $this->form_validation->error_array();
					$this->json_output();
					return;
				}				
				$this->document_details_model->insert($dataDocDetail);				
			}

			
			//Save Flow Control;
			$this->load->model('document_flow_control_model');

			$this->document_flow_control_model->deleteNotApprovedByParentId($fin_document_id);
			$currentSeqNo = $this->document_flow_control_model->getCurrentSeqNo($fin_document_id);


			if ($data["fbl_flow_control"] == 1){				
				$this->form_validation->set_rules($this->document_flow_control_model->getRules("ADD",0));
				$this->form_validation->set_error_delimiters('<div class="text-danger">* ', '</div>');
				$detail_flow_control = $this->input->post("detail_flow_control");
				$detail_flow_control = json_decode($detail_flow_control);
				//print_r($detail_flow_control);
				//echo "<br><br><br>";
				foreach ($detail_flow_control as $flow_control) {
					if ($flow_control->fst_control_status  ==  "AP"){
						continue;
					}

					$dataFlow = [];
					if ($flow_control->fin_id != 0){
						$dataFlow["fin_id"] = $flow_control->fin_id; 
						$dataFlow["fst_control_status"] = $flow_control->fst_control_status;
					}else{
						//"fst_control_status" => $flow_control->fst_control_status,   // NA->Need Approval;RA->Ready to Approve;NR->Need Revision
						if($currentSeqNo >= $flow_control->fin_seq_no ){
							$dataFlow["fst_control_status"] = "RA";
						}else{
							$dataFlow["fst_control_status"] = "NA";
						}
					}

					$dataFlow = [			
						"fin_document_id"=> $fin_document_id,
						"fin_seq_no"=> $flow_control->fin_seq_no,
						"fin_user_id"=> $flow_control->fin_user_id,						
						"fin_version" => $docVersion,
						"fin_document_id"=> $fin_document_id,
						"fst_active" => "A",						
					];

					$this->form_validation->set_data($dataFlow);
					if ($this->form_validation->run() == FALSE){
						//print_r($this->form_validation->error_array());
						$this->ajxResp["status"] = "VALIDATION_FORM_FAILED";
						$this->ajxResp["message"] = "Error Validation Detail Flow";
						$this->ajxResp["data"] = $this->form_validation->error_array();
						$this->json_output();
						return;
					}
					$this->document_flow_control_model->insert($dataFlow);																
				}			
			}

			//Detail Custom Scope
			$this->load->model('document_custom_permission_model');
			
			$this->document_custom_permission_model->deleteByParentId($fin_document_id);

			$detail_custom_scope = $this->input->post("detail_custom_scope");
			$detail_custom_scope = json_decode($detail_custom_scope);
			$this->form_validation->reset_validation();
			$this->form_validation->set_rules($this->document_custom_permission_model->getRules("ADD",0));	
			//print_r($this->document_custom_permission_model->getRules("ADD",0));

			foreach ($detail_custom_scope as $scope) {
				$dataScope = [
					"fin_id"=>$scope->fin_id,
					"fin_document_id"=>$fin_document_id,
					"fst_mode"=> $scope->fst_mode,
					"fin_user_department_id"=> $scope->fin_user_department_id,
					"fbl_view" => ($scope->fbl_view == NULL) ? 0 : 1,
					"fbl_print" => ($scope->fbl_print == NULL) ? 0 : 1,
					"fst_active" => "A"
				];
				$this->form_validation->set_data($dataScope);
				if ($this->form_validation->run() == FALSE){
					$this->ajxResp["status"] = "VALIDATION_FORM_FAILED";
					$this->ajxResp["message"] = "Error Validation Custom Scope";
					$this->ajxResp["data"] = $this->form_validation->error_array();
					$this->json_output();
					return;
				}
				$this->document_custom_permission_model->insert($dataScope);
			}

			$this->db->trans_complete();
			$this->ajxResp["status"] = "SUCCESS";
			$this->ajxResp["message"] = "Data Saved !";
			$this->ajxResp["data"]["insert_id"] = $fin_document_id;
			$this->json_output();

		}catch(Exception $e){
			if ($e->getCode() == 1000){
				$dbError  = $this->db->error();
				$this->ajxResp["status"] = "DB_FAILED";
				$this->ajxResp["message"] = "Update Failed";
				$this->ajxResp["data"] = $this->db->error();
				$this->ajxResp["debug"] = print_r($e,true);
				$this->json_output();
				$this->db->trans_rollback();
				return;
			}
		}
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
					<a class='btn-edit' href='#' data-id='".$data["fin_document_id"]."'><i class='fa fa-pencil' aria-hidden='true'></i></a>
					<a class='btn-delete' href='#' data-id='".$data["fin_document_id"]."' data-toggle='confirmation'><i class='fa fa-trash' aria-hidden='true' ></i></a>
				</div>";
			$arrDataFormated[] = $data;
		}
		$datasources["data"] = $arrDataFormated;
		$this->json_output($datasources);
	}
	
	public function fetch_data($fin_document_id){
		$this->load->model("documents_model");
		$this->load->model("document_details_model");
		$this->load->model("document_flow_control_model");
		$this->load->model("document_custom_permission_model");
		$this->load->model("view_print_token_model");
		

		$data = [];
		$data["header"] = $this->documents_model->getDataById($fin_document_id);
		
		$tmpDocDetails = $this->document_details_model->getRowsByParentId($fin_document_id);
		$docDetails = [];
		foreach($tmpDocDetails as $detail){
			$detail->view_doc = $this->documents_model->scopePermission($detail->fin_document_id,"VIEW");
			$docDetails[] = $detail;
		}
		$data["doc_details"] = $docDetails;
		$data["flow_details"] = $this->document_flow_control_model->getRowsByParentId($fin_document_id);
		$data["custom_details"] = $this->document_custom_permission_model->getRowsByParentId($fin_document_id);
		$data["permission"] = [
			"edit" => $this->documents_model->editPermission($fin_document_id),
			"view_doc" => $this->documents_model->scopePermission($fin_document_id,"VIEW"),
			"print_doc" => $this->documents_model->scopePermission($fin_document_id,"PRINT"),
			"token" => $this->view_print_token_model->generateToken($fin_document_id)
		];
		$this->json_output($data);
	}


	public function test(){
		$this->load->model("view_print_token_model");
		var_dump($this->view_print_token_model->useToken("KEbdAR7wNkZfLd6JyvzUpxWYFCHQLE0XegcIoQzbM1qsVYq38ty1VfaFPTSktxpS"));
		//var_dump($this->view_print_token_model->generateToken());
	}
	public function delete($fin_document_id){
		if(!$this->aauth->is_permit("")){
			$this->ajxResp["status"] = "NOT_PERMIT";
			$this->ajxResp["message"] = "You not allowed to do this operation !";
			$this->json_output();
			return;
		}
		
		$this->load->model("documents_model");

		if ($this->documents_model->canBeDeleted($fin_document_id)){
			$this->documents_model->delete($fin_document_id);
			$this->ajxResp["status"] = "SUCCESS";
			$this->ajxResp["message"] = "";
			$this->json_output();
		}else{
			$this->ajxResp["status"] = "NOT_PERMIT";
			$this->ajxResp["message"] = lang("This document can not be deleted !");
			$this->json_output();
			return;
		}
	}


	public function getDocument($token){
		$this->load->model("view_print_token_model");
		$this->load->model("documents_model");
		
		$docId = $this->view_print_token_model->useToken($token);
		if(! $docId){
			show_404();
		}
		
		//$docId = 45;

		$document = $this->documents_model->getFile($docId);
		header("Content-type:application/pdf");
		header("Content-Disposition:inline;filename=download.pdf");

		
		echo $document;
	}

	public function downloadDocument($fin_document_id){		
		$this->load->model("documents_model");
		
		
		$isPermit = $this->documents_model->scopePermission($fin_document_id,"PRINT");
		if ($isPermit){		
			$document = $this->documents_model->getFile($fin_document_id);
			//header("Content-type:application/pdf");
			header('Content-Type: application/octet-stream');
			header("Content-Transfer-Encoding: Binary"); 				
			echo $document;
		}else{
			show_404();
		}

		/*
		$docId = $this->view_print_token_model->useToken($token);
		if(! $docId){
			show_404();
		}
		*/
		
	}


	public function displayDocument($fin_document_id){
		$this->load->library("menus");
		$this->load->model("view_print_token_model");
		$this->load->model("documents_model");
		$data['base_url'] =  base_url();
		
		
		
		$viewDoc = $this->documents_model->scopePermission($fin_document_id,"VIEW");
		$printDoc = $this->documents_model->scopePermission($fin_document_id,"PRINT");

		if ($viewDoc){
			$viewToken = $this->view_print_token_model->generateToken($fin_document_id);
			$data["fin_document_id"] = $fin_document_id;
			$data["printDoc"] = $printDoc;
			$data['viewToken'] =  $viewToken;

		}else{
			show_404();
		}

		
		$this->parser->parse('pages/document/viewer',$data,false);
		return;

		//$this->data['PAGE_CONTENT']= $page_content;
		//$this->parser->parse('template/main',$this->data);

		$main_header = $this->parser->parse('inc/main_header',[],true);
        $main_sidebar = $this->parser->parse('inc/main_sidebar',[],true);
        $page_content = $this->parser->parse('pages/document/viewer',$data,true);
        $main_footer = $this->parser->parse('inc/main_footer',[],true);
        $control_sidebar=null;
        $this->data['MAIN_HEADER'] = $main_header;
        $this->data['MAIN_SIDEBAR']= $main_sidebar;
        $this->data['PAGE_CONTENT']= $page_content;
        $this->data['MAIN_FOOTER']= $main_footer;        
		$this->parser->parse('template/main',$this->data);


	}


	public function search_list(){

		$this->load->library('menus');
        $this->list['page_name']="Documents";
        $this->list['list_name']="Document List";
        $this->list['addnew_ajax_url']=site_url().'document/add';
        $this->list['pKey']="id";
		$this->list['arrSearch']=[
			'a.fst_name' => 'Document Name',
			'a.fst_search_marks' => 'Search Mark',
			'a.fst_memo' => 'Memo',
		];
		$this->list['breadcrumbs']=[
			['title'=>'Home','link'=>'#','icon'=>"<i class='fa fa-dashboard'></i>"],
			['title'=>'Document','link'=>'#','icon'=>''],
			['title'=>'Search','link'=> NULL ,'icon'=>''],
		];

		
		$this->list['base_url'] =  base_url();

		$main_header = $this->parser->parse('inc/main_header',[],true);
        $main_sidebar = $this->parser->parse('inc/main_sidebar',[],true);
        $page_content = $this->parser->parse('pages/document/search',$this->list,true);
        $main_footer = $this->parser->parse('inc/main_footer',[],true);
        $control_sidebar=null;
        $this->data['ACCESS_RIGHT']="A-C-R-U-D-P";
        $this->data['MAIN_HEADER'] = $main_header;
        $this->data['MAIN_SIDEBAR']= $main_sidebar;
        $this->data['PAGE_CONTENT']= $page_content;
        $this->data['MAIN_FOOTER']= $main_footer;        
		$this->parser->parse('template/main',$this->data);
		
	}


	public function search_list_data(){
		$this->load->library("datatables");
		$this->load->model("documents_model");
		$this->load->model("view_print_token_model");
		

		$this->datatables->setTableName("(select * from documents where fdt_published_date <= CURDATE() and fbl_flow_completed = 1) as a inner join users b on a.fin_insert_id = b.fin_user_id");
		
		$selectFields = "a.fin_document_id,a.fst_name,a.fst_source,a.fst_memo,a.fbl_flow_control,a.fin_insert_id,b.fst_username,a.fdt_insert_datetime";
		$this->datatables->setSelectFields($selectFields);
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

			$data["view_doc"] = $this->documents_model->scopePermission($data["fin_document_id"],"VIEW");
			$data["print_doc"] = $this->documents_model->scopePermission($data["fin_document_id"],"PRINT");
						
			$arrDataFormated[] = $data;
		}
		$datasources["data"] = $arrDataFormated;
		$this->json_output($datasources);
	}
}