<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Flow_schema extends MY_Controller {
    public function __construct(){
        parent:: __construct();
        $this->load->library('form_validation');
    }

    public function index(){
        $this->lizt();
    }

    public function lizt(){
        $this->load->library('menus');
        $this->list['page_name']="Flow Schema";
        $this->list['list_name']="Flow Control Schema List";
        $this->list['addnew_ajax_url']=site_url().'flow_schema/add';
        $this->list['pKey']="id";
		$this->list['fetch_list_data_ajax_url']=site_url().'flow_schema/fetch_list_data';
        $this->list['delete_ajax_url']=site_url().'flow_schema/delete/';
        $this->list['edit_ajax_url']=site_url().'flow_schema/edit/';
        $this->list['arrSearch']=[
            'a.fin_flow_control_schema_id ' => 'Flow Schema ID',
            'a.fst_name' => 'Name'
		];
		$this->list['breadcrumbs']=[
			['title'=>'Home','link'=>'#','icon'=>"<i class='fa fa-dashboard'></i>"],
			['title'=>'Flow Schema','link'=>'#','icon'=>''],
			['title'=>'List','link'=> NULL ,'icon'=>''],
		];
		$this->list['columns']=[
			['title' => 'Flow Control Schema ID', 'width'=>'20%', 'data'=>'fin_flow_control_schema_id'],
            ['title' => 'Name', 'width'=>'20%', 'data'=>'fst_name'],
            ['title' => 'Memo', 'width'=>'20%', 'data'=>'fst_memo'],
			['title' => 'Action', 'width'=>'10%', 'data'=>'action','sortable'=>false, 'className'=>'dt-center']
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

    private function openForm($mode="ADD",$fin_flow_control_schema_id=0){
		$this->load->library("menus");

		if($this->input->post("submit") != "" ){
			$this->add_save();
		}

		$main_header = $this->parser->parse('inc/main_header',[],true);
		$main_sidebar = $this->parser->parse('inc/main_sidebar',[],true);

		$data["mode"] = $mode;
		$data["title"] = $mode == "ADD" ? "Add Flow Control Schema" : "Update Flow Control Schema";
		$data["fin_flow_control_schema_id"] = $fin_flow_control_schema_id;

		$page_content = $this->parser->parse('pages/flow_schema/form',$data,true);
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

    public function Edit($fin_flow_control_schema_id){
        $this->openForm("EDIT",$fin_flow_control_schema_id);
    }

    public function ajx_add_save(){
		$this->load->model('flow_control_schema_header_model');
		$this->form_validation->set_rules($this->flow_control_schema_header_model->getRules("ADD",0));
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
			"fin_flow_control_schema_id"=>$this->input->post("fin_flow_control_schema_id"),
			"fst_name"=>$this->input->post("fst_name"),
			"fst_memo"=>$this->input->post("fst_memo"),
			"fst_active"=>'A'
		];

		$this->db->trans_start();
		$insertId = $this->flow_control_schema_header_model->insert($data);
		$dbError  = $this->db->error();
		if ($dbError["code"] != 0){			
			$this->ajxResp["status"] = "DB_FAILED";
			$this->ajxResp["message"] = "Insert Failed";
			$this->ajxResp["data"] = $this->db->error();
			$this->json_output();
			$this->db->trans_rollback();
			return;
		}

        // Save Schema Items
		$this->load->model("flow_control_schema_items_model");
		
		$this->form_validation->set_rules($this->flow_control_schema_items_model->getRules("ADD",0));
		$this->form_validation->set_error_delimiters('<div class="text-danger">* ', '</div>');

		$details = $this->input->post("detail");
		$details = json_decode($details);
		foreach ($details as $item) {
			$data = [
				"fin_flow_control_schema_id"=> $insertId,
				"fin_user_id"=> $item->fin_user_id,
				"fin_seq_no"=> $item->fin_seq_no
			];

			// Validate Data Items
			$this->form_validation->set_data($data);
			if ($this->form_validation->run() == FALSE){
				$this->ajxResp["status"] = "VALIDATION_FORM_FAILED";
				$this->ajxResp["message"] = "Error Validation Forms";
				$error = [
					"detail"=> $this->form_validation->error_string(),
				];
				$this->ajxResp["data"] = $error;
				$this->json_output();
				return;	
			}
			
			$this->flow_control_schema_items_model->insert($data);
			$dbError  = $this->db->error();
			if ($dbError["code"] != 0){			
				$this->ajxResp["status"] = "DB_FAILED";
				$this->ajxResp["message"] = "Insert Failed";
				$this->ajxResp["data"] = $this->db->error();
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
        $this->load->model('flow_control_schema_header_model');		
		$fin_flow_control_schema_id = $this->input->post("fin_flow_control_schema_id");
		$data = $this->flow_control_schema_header_model->getDataById($fin_flow_control_schema_id);
		$flow_control_schema_header = $data["fcsHeader"];
		if (!$flow_control_schema_header){
			$this->ajxResp["status"] = "DATA_NOT_FOUND";
			$this->ajxResp["message"] = "Data id $fin_flow_control_schema_id Not Found ";
			$this->ajxResp["data"] = [];
			$this->json_output();
			return;
		}

		$this->form_validation->set_rules($this->flow_control_schema_header_model->getRules("EDIT",$fin_flow_control_schema_id));
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
			"fin_flow_control_schema_id"=>$fin_flow_control_schema_id,
            "fst_name"=>$this->input->post("fst_name"),
            "fst_memo"=>$this->input->post("fst_memo"),
			"fst_active"=>'A'
		];

		$this->db->trans_start();
		$this->flow_control_schema_header_model->update($data);
		$dbError  = $this->db->error();
		if ($dbError["code"] != 0){			
			$this->ajxResp["status"] = "DB_FAILED";
			$this->ajxResp["message"] = "Insert Failed";
			$this->ajxResp["data"] = $this->db->error();
			$this->json_output();
			$this->db->trans_rollback();
			return;
		}

		// Save Items
		$this->load->model("flow_control_schema_items_model");

		$this->form_validation->set_rules($this->flow_control_schema_items_model->getRules("ADD",0));
		$this->form_validation->set_error_delimiters('<div class="text-danger">* ', '</div>');

		$this->flow_control_schema_items_model->deleteByDetail($fin_flow_control_schema_id);

		//$this->load->model("flow_control_schema_items_model");		
		$details = $this->input->post("detail");
		$details = json_decode($details);
		foreach ($details as $item) {
			$data = [
				"fin_flow_control_schema_id"=> $fin_flow_control_schema_id,
				"fin_user_id"=> $item->fin_user_id,
				"fin_seq_no"=> $item->fin_seq_no
			];

			// Validate Data Items
			$this->form_validation->set_data($data);
			if ($this->form_validation->run() == FALSE){
				$this->ajxResp["status"] = "VALIDATION_FORM_FAILED";
				$this->ajxResp["message"] = "Error Validation Forms";
				$error = [
					"detail"=> $this->form_validation->error_string(),
				];
				$this->ajxResp["data"] = $error;
				$this->json_output();
				return;	
			}
			
			$this->flow_control_schema_items_model->insert($data);
			$dbError  = $this->db->error();
			if ($dbError["code"] != 0){			
				$this->ajxResp["status"] = "DB_FAILED";
				$this->ajxResp["message"] = "Insert Failed";
				$this->ajxResp["data"] = $this->db->error();
				$this->json_output();
				$this->db->trans_rollback();
				return;
			}
		}
		
		$this->db->trans_complete();

		$this->ajxResp["status"] = "SUCCESS";
		$this->ajxResp["message"] = "Data Saved !";
		$this->ajxResp["data"]["insert_id"] = $fin_flow_control_schema_id;
		$this->json_output();
	}
	
    public function fetch_list_data(){
		$this->load->library("datatables");
		$useractive = $this->aauth->get_user_id();
		$this->datatables->setTableName("(SELECT * from flow_control_schema_header WHERE fin_insert_id = $useractive) a");

		$selectFields = "fin_flow_control_schema_id,fin_insert_id,fst_name,fst_memo,'action' as action";
		$this->datatables->setSelectFields($selectFields);

		$searchFields = ["fin_flow_control_schema_id","fst_name"];
		$this->datatables->setSearchFields($searchFields);

		// Format Data
        $datasources = $this->datatables->getData();
        $arrData = $datasources["data"];		
		$arrDataFormated = [];
		foreach ($arrData as $data) {
			//action
			$data["action"]	= "<div style='font-size:16px'>
					<a class='btn-edit' href='#' data-id='".$data["fin_flow_control_schema_id"]."'><i class='fa fa-pencil'></i></a>
					<a class='btn-delete' href='#' data-id='".$data["fin_flow_control_schema_id"]."' data-toggle='confirmation'><i class='fa fa-trash'></i></a>
				</div>";

			$arrDataFormated[] = $data;
		}
		$datasources["data"] = $arrDataFormated;
		$this->json_output($datasources);
    }

    public function fetch_data($fin_flow_control_schema_id){
		$this->load->model("flow_control_schema_header_model");
		$data = $this->flow_control_schema_header_model->getDataById($fin_flow_control_schema_id);

		// Detail Schema
		$this->load->model("flow_control_schema_items_model");		
		$this->json_output($data);
	}

	public function delete($id){
		if(!$this->aauth->is_permit("")){
			$this->ajxResp["status"] = "NOT_PERMIT";
			$this->ajxResp["message"] = "You not allowed to do this operation !";
			$this->json_output();
			return;
		}
		
		$this->load->model("flow_control_schema_header_model");
		$this->flow_control_schema_header_model->delete($id);
		$this->ajxResp["status"] = "DELETED";
		$this->ajxResp["message"] = "File deleted successfully";
		$this->json_output();
	}

	public function get_data_username(){
		$term = $this->input->get("term");
		$ssql = "select fin_user_id, fst_username from users where fst_username like ? order by fst_username";
		$qr = $this->db->query($ssql,['%'.$term.'%']);
		$rs = $qr->result();
		
		$this->json_output($rs);
	}

    public function getFlow($fin_user_id){
        $this->load->model("Flow_control_schema_header_model");
        $result = $this->Flow_control_schema_header_model->getFlow($fin_user_id);
        $this->ajxResp["data"] = $result;
        $this->json_output();
    }

    public function getFlowDetail($fin_flow_control_schema_id){
        $this->load->model("flow_control_schema_items_model");
        $result = $this->flow_control_schema_items_model->getFlowDetail($fin_flow_control_schema_id);
        $this->ajxResp["data"] = $result;
        $this->json_output();
    }
}