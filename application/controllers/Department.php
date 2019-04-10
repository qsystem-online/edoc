<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department extends MY_Controller {

    public function __construct(){
        parent:: __construct();
        $this->load->library('form_validation');
    }

    public function index(){
        $this->lizt();
    }

    public function lizt(){
        $this->load->library('menus');
		
        $this->list['page_name']="Department";
        $this->list['list_name']="Department List";
        $this->list['addnew_ajax_url']=site_url().'Department/add';
        $this->list['pKey']="id";
		$this->list['fetch_list_data_ajax_url']=site_url().'pages/department/fetch_list_data';
        $this->list['delete_ajax_url']=site_url().'pages/department/delete/';
        $this->list['edit_ajax_url']=site_url().'pages/department/edit/';
        $this->list['arrSearch']=[
            'a.fin_department_id' => 'ID Department',
            'a.fst_department_name' => 'Department Name'
		];
		
		$this->list['breadcrumbs']=[
			['title'=>'Home','link'=>'#','icon'=>"<i class='fa fa-dashboard'></i>"],
			['title'=>'sample','link'=>'#','icon'=>''],
			['title'=>'Penjualan','link'=> NULL ,'icon'=>''],
		];
		$this->list['columns']=[
			['title' => 'ID Department', 'width'=>'10%', 'data'=>'fin_department_id'],
			['title' => 'Department Name', 'width'=>'25%', 'data'=>'fst_department_name'],
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


    private function openForm($mode = "ADD",$fin_department_id = 0){
		$this->load->library("menus");
		//$this->load->model("groups_model");

		if($this->input->post("submit") != "" ){
			$this->add_save();
		}

		$main_header = $this->parser->parse('inc/main_header',[],true);
		$main_sidebar = $this->parser->parse('inc/main_sidebar',[],true);
	
		$data["mode"] = $mode;
		$data["title"] = $mode == "ADD" ? "ADD Department" : "Update Department";
		$data["fin_department_id"] = $fin_department_id;

		$page_content = $this->parser->parse('pages/department/form',$data,true);
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

	public function Edit($fin_department_id){
		$this->openForm("EDIT",$fin_department_id);
	}


	public function ajx_add_save(){
		$this->load->model('departments_model');
		$this->form_validation->set_rules($this->cm_header_penjualan_model->getRules("ADD",0));
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
			"fst_department_name"=> $this->input->post("fst_department_name"),
			"fst_active"=>'A'
		];

		$this->db->trans_start();
		$insertId = $this->departments_model->insert($data);
		$dbError  = $this->db->error();
		if ($dbError["code"] != 0){			
			$this->ajxResp["status"] = "DB_FAILED";
			$this->ajxResp["message"] = "Insert Failed";
			$this->ajxResp["data"] = $this->db->error();
			$this->json_output();
			$this->db->trans_rollback();
			return;
		}
		
		$this->db->trans_complete();
		$this->ajxResp["status"] = "SUCCESS";
		$this->ajxResp["message"] = "Data Saved !";
		$this->ajxResp["data"]["insert_id"] = $insertId;
		$this->json_output();
	}

	public function ajx_edit_save(){
		$this->load->model('departments_model');

		$fin_department_id = $this->input->post("fin_department_id");
		$data = $this->departments_model->getDataById($fin_department_id);		
		if (!$data){
			$this->ajxResp["status"] = "DATA_NOT_FOUND";
			$this->ajxResp["message"] = "Data id $fin_id Not Found ";
			$this->ajxResp["data"] = [];
			$this->json_output();
			return;
		}
		
		$data = [
			"fin_department_id"=>$fin_department_id,
			"fst_department_name"=> $this->input->post("fst_department_name"),
		];

		$this->form_validation->set_rules($this->departments_model->getRules());
		$this->form_validation->set_error_delimiters('<div class="text-danger">* ', '</div>');		
		$this->form_validation->set_data($data);
		if ($this->form_validation->run() == FALSE){
			$this->ajxResp["status"] = "VALIDATION_FORM_FAILED";
			$this->ajxResp["message"] = "Error Validation Forms";
			$this->ajxResp["data"] = $this->form_validation->error_array();
			$this->json_output();
			return;
		}
	
		$this->db->trans_start();
		$this->departments_model->update($data);
		$dbError  = $this->db->error();
		if ($dbError["code"] != 0){			
			$this->ajxResp["status"] = "DB_FAILED";
			$this->ajxResp["message"] = "Insert Failed";
			$this->ajxResp["data"] = $this->db->error();
			$this->json_output();
			$this->db->trans_rollback();
			return;
		}

		$this->db->trans_complete();
		$this->ajxResp["status"] = "SUCCESS";
		$this->ajxResp["message"] = "Data Saved !";
		$this->ajxResp["data"]["insert_id"] = $fin_department_id;
		$this->json_output();
		
	}

	public function fetch_list_data(){
		$this->load->library("datatables");
		$this->datatables->setTableName("departments_model");
		$this->datatables->activeCondition = "a.fst_active != 'DELETED'";
		
		$selectFields = "a.fin_departmen_id,fst_department_name, 'action' as action";
		$this->datatables->setSelectFields($selectFields);
		
		$selectSearch=$this->input->get('optionSearch');
		//$searchFields = ["fst_customer_name"];
		$searchFields = [$selectSearch];
		$this->datatables->setSearchFields($searchFields);

		// Format Data
		$datasources = $this->datatables->getData();		
		$arrData = $datasources["data"];		
		$arrDataFormated = [];
		foreach ($arrData as $data) {
			//action
			$data["action"]	= "<div style='font-size:16px'>
					<a class='btn-edit' href='#' data-id='".$data["fin_department_id"]."'><i class='fa fa-pencil'></i></a>
					<a class='btn-delete' href='#' data-id='".$data["fin_department_id"]."' data-toggle='confirmation'><i class='fa fa-trash'></i></a>
				</div>";

			$arrDataFormated[] = $data;
		}
		$datasources["data"] = $arrDataFormated;
		$this->json_output($datasources);
	}
	
	public function fetch_data($fin_department_id){
		$this->load->model("departments_model");

		$data = $this->departments_model->getDataById($fin_department_id);

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
		
		$this->load->model("departments_model");
		
		$this->departments_model->delete($id);
		$this->ajxResp["status"] = "SUCCESS";
		$this->ajxResp["message"] = "";
		$this->json_output();
	}
}