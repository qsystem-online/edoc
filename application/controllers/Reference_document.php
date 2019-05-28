<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reference_document extends MY_Controller
{

    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('reference_document_list_model');
        $this->load->model('documents_model');
    }

    public function index(){
        $this->show_list();
    }

    public function show_list(){
        $this->load->library('menus');
        $this->list['page_name'] = "Reference Document";
        $this->list['list_name'] = "Reference Document List";
        $this->list['addnew_ajax_url'] = site_url() . 'reference_document/add';
        $this->list['pKey'] = "id";
        $this->list['fetch_list_data_ajax_url'] = site_url() . 'reference_document/fetch_list_data';
        $this->list['delete_ajax_url'] = site_url() . 'reference_document/delete/';
        $this->list['edit_ajax_url'] = site_url() . 'reference_document/edit/';
        $this->list['arrSearch'] = [
            'fst_reff_source_code' => 'Source Code',
            'fst_reff_no' => 'Reff Number'
        ];

        $this->list['breadcrumbs'] = [
            ['title' => 'Home', 'link' => '#', 'icon' => "<i class='fa fa-dashboard'></i>"],
            ['title' => 'Document', 'link' => '#', 'icon' => ''],
            ['title' => 'Reference Document', 'link' => NULL, 'icon' => ''],
        ];
        $this->list['columns'] = [
            ['title' => 'Source Code', 'width' => '35%', 'data' => 'fst_reff_source_code'],
            ['title' => 'Reff Number', 'width' => '35%', 'data' => 'fst_reff_no'],
            ['title' => 'Action', 'width' => '15%', 'data' => 'action', 'sortable' => false, 'className' => 'dt-body-center text-center']
        ];
        $main_header = $this->parser->parse('inc/main_header', [], true);
        $main_sidebar = $this->parser->parse('inc/main_sidebar', [], true);
        $page_content = $this->parser->parse('template/standardList', $this->list, true);
        $main_footer = $this->parser->parse('inc/main_footer', [], true);
        $control_sidebar = null;
        $this->data['ACCESS_RIGHT'] = "A-C-R-U-D-P";
        $this->data['MAIN_HEADER'] = $main_header;
        $this->data['MAIN_SIDEBAR'] = $main_sidebar;
        $this->data['PAGE_CONTENT'] = $page_content;
        $this->data['MAIN_FOOTER'] = $main_footer;
        $this->parser->parse('template/main', $this->data);
    }

    private function openForm($mode = "ADD", $fin_id = 0){
        $this->load->library("menus");

        if ($this->input->post("submit") != "") {
            $this->add_save();
        }

        $main_header = $this->parser->parse('inc/main_header', [], true);
        $main_sidebar = $this->parser->parse('inc/main_sidebar', [], true);

        $data["mode"] = $mode;
        $data["title"] = $mode == "ADD" ? "Add Reference" : "Update Reference";
        $data["fin_id"] = $fin_id;

        $page_content = $this->parser->parse('pages/reference_document/form', $data, true);
        $main_footer = $this->parser->parse('inc/main_footer', [], true);

        $control_sidebar = NULL;
        $this->data["MAIN_HEADER"] = $main_header;
        $this->data["MAIN_SIDEBAR"] = $main_sidebar;
        $this->data["PAGE_CONTENT"] = $page_content;
        $this->data["MAIN_FOOTER"] = $main_footer;
        $this->data["CONTROL_SIDEBAR"] = $control_sidebar;
        $this->parser->parse('template/main', $this->data);
    }

    public function add(){
        $this->openForm("ADD", 0);
    }

    public function Edit($fin_id){
        $this->openForm("EDIT", $fin_id);
    }

    public function ajx_add_save(){
        $this->load->model('documents_model');
        $details = $this->input->post("detail");
        $details = json_decode($details);
        foreach ($details as $items) {
           $data = [
               "fin_document_id" => $items->fin_document_id
           ];
        }

        $this->load->model('reference_document_list_model');
        $this->form_validation->set_rules($this->reference_document_list_model->getRules("ADD", 0));
        $this->form_validation->set_error_delimiters('<div class="text-danger">* ', '</div>');

        if ($this->form_validation->run() == FALSE) {
            //print_r($this->form_validation->error_array());
            $this->ajxResp["status"] = "VALIDATION_FORM_FAILED";
            $this->ajxResp["message"] = "Error Validation Forms";
            $this->ajxResp["data"] = $this->form_validation->error_array();
            $this->json_output();
            return;
        }

        $data = [
            "fst_reff_source_code" => $this->input->post("fst_reff_source_code"),
            "fst_reff_no" => $this->input->post("fst_reff_no"),
            "fin_document_id" => $items->fin_document_id,
            "fst_active" => 'A'
        ];

        $this->db->trans_start();
        $insertId = $this->reference_document_list_model->insert($data);
        $dbError  = $this->db->error();
        if ($dbError["code"] != 0) {
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
        $this->load->model('documents_model');
        $details = $this->input->post("detail");
        $details = json_decode($details);
        foreach ($details as $items) {
           $data = [
               "fin_document_id" => $items->fin_document_id
           ];
        }

        $this->load->model('reference_document_list_model');
        $fin_id = $this->input->post("fin_id");
        $data = $this->reference_document_list_model->getDataById($fin_id);
        $reference_document_list = $data["referenceDoc"];
        if (!$reference_document_list) {
            $this->ajxResp["status"] = "DATA_NOT_FOUND";
            $this->ajxResp["message"] = "Data id $fin_id Not Found ";
            $this->ajxResp["data"] = [];
            $this->json_output();
            return;
        }

        $this->form_validation->set_rules($this->reference_document_list_model->getRules("EDIT", $fin_id));
        $this->form_validation->set_error_delimiters('<div class="text-danger">* ', '</div>');
        if ($this->form_validation->run() == FALSE) {
            //print_r($this->form_validation->error_array());
            $this->ajxResp["status"] = "VALIDATION_FORM_FAILED";
            $this->ajxResp["message"] = "Error Validation Forms";
            $this->ajxResp["data"] = $this->form_validation->error_array();
            $this->json_output();
            return;
        }

        $data = [
            "fin_id" => $this->input->post("fin_id"),
            "fst_reff_source_code" => $this->input->post("fst_reff_source_code"),
            "fst_reff_no" => $this->input->post("fst_reff_no"),
            "fin_document_id" => $items->fin_document_id,
            "fst_active" => 'A'
        ];

        $this->db->trans_start();

        $this->reference_document_list_model->update($data);
        $dbError  = $this->db->error();
        if ($dbError["code"] != 0) {
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
        $this->ajxResp["data"]["insert_id"] = $fin_id;
        $this->json_output();
    }

    public function fetch_list_data(){
        $this->load->library("datatables");
        $this->datatables->setTableName("(select distinct fin_id,fst_reff_source_code,fst_reff_no,fst_active from reference_document_list where fst_active = 'A') a");

        $selectFields = "fin_id,fst_reff_source_code,fst_reff_no,'action' as action";
        $this->datatables->setSelectFields($selectFields);

        $searchFields =[];
		$searchFields[] = $this->input->get('optionSearch'); //["fin_id","fst_reff_source_code"];
		$this->datatables->setSearchFields($searchFields);
		$this->datatables->activeCondition = "fst_active !='D'";
        
        // Format Data
        $datasources = $this->datatables->getData();
        $arrData = $datasources["data"];
        $arrDataFormated = [];
        foreach ($arrData as $data) {
            //action
            $data["action"]    = "<div style='font-size:16px'>
					<a class='btn-edit' href='#' data-id='" . $data["fin_id"] . "'><i class='fa fa-pencil'></i></a>
					<a class='btn-delete' href='#' data-id='" . $data["fin_id"] . "' data-toggle='confirmation'><i class='fa fa-trash'></i></a>
				</div>";

            $arrDataFormated[] = $data;
        }
        $datasources["data"] = $arrDataFormated;
        $this->json_output($datasources);
    }

    public function fetch_data($fin_id){
        $this->load->model("reference_document_list_model");
        $data = $this->reference_document_list_model->getDataById($fin_id);
    
        $this->load->model("documents_model");
        $this->json_output($data);
    }

    public function delete($id){
        if (!$this->aauth->is_permit("")) {
            $this->ajxResp["status"] = "NOT_PERMIT";
            $this->ajxResp["message"] = "You not allowed to do this operation !";
            $this->json_output();
            return;
        }

        $this->load->model("reference_document_list_model");

        $this->reference_document_list_model->delete($id);
        $this->ajxResp["status"] = "DELETED";
        $this->ajxResp["message"] = "File deleted successfully";
        $this->json_output();
    }
}
