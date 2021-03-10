<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Document_io extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('document_inout_model');
		$this->load->model('users_model');
		$this->load->model("documents_model");

	}

	public function index()
	{
		$this->lizt();
	}

	public function lizt()
	{
		$this->load->library('menus');
		$this->list['page_name'] = "Document In Out";
		$this->list['list_name'] = "Document In Out List";
		$this->list['addnew_ajax_url'] = site_url() . 'document_io/add';
		$this->list['pKey'] = "id";
		$this->list['fetch_list_data_ajax_url'] = site_url() . 'document_io/fetch_list_data';
		$this->list['delete_ajax_url'] = site_url() . 'document_io/delete/';
		$this->list['edit_ajax_url'] = site_url() . 'document_io/edit/';
		$this->list['arrSearch'] = [
			'fst_document_name' => 'Document',
		];

		$this->list['breadcrumbs'] = [
			['title' => 'Home', 'link' => '#', 'icon' => "<i class='fa fa-dashboard'></i>"],
			['title' => 'Document In Out', 'link' => '#', 'icon' => ''],
			['title' => 'List', 'link' => NULL, 'icon' => ''],
		];
		$this->list['columns'] = [
			['title' => 'ID', 'width' => '10%', 'data' => 'fin_id'],
			['title' => 'Document', 'width' => '25%', 'data' => 'fst_document_name'],
			['title' => 'In - Out', 'width' => '25%', 'data' => 'fst_io_status'],
			['title' => 'IO Datetime', 'width' => '25%', 'data' => 'fdt_io_datetime'],
			['title' => 'IO User', 'width' => '25%', 'data' => 'fst_by_user'],
			['title' => 'Action', 'width' => '10%', 'data' => 'action', 'sortable' => false, 'className' => 'dt-body-center text-center']
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

	public function fetch_list_data(){
		$this->load->library("datatables");
		$this->datatables->setTableName("(
			SELECT a.fin_id,b.fst_name as fst_document_name , a.fst_io_status, a.fdt_io_datetime , c.fst_fullname as fst_by_user,a.fst_active FROM document_inout a 
			INNER JOIN documents b on a.fin_document_id = b.fin_document_id 
			INNER JOIN users c on a.fin_by_id = c.fin_user_id
		) a");
		
		$selectFields = "a.*,'action' as action";
		$this->datatables->setSelectFields($selectFields);
		
		$searchFields =[];
		$searchFields[] = $this->input->get('optionSearch'); //["fst_fullname","fst_birthplace"];
		$this->datatables->setSearchFields($searchFields);
		$this->datatables->activeCondition = "fst_active !='D'";
		
		// Format Data
		$datasources = $this->datatables->getData();
		$arrData = $datasources["data"];
		$arrDataFormated = [];
		foreach ($arrData as $data) {
			//action
			$data["action"]	= "<div style='font-size:16px'>
					<a class='btn-edit' href='#' data-id='" . $data["fin_id"] . "'><i class='fa fa-pencil'></i></a>
				</div>";
			$arrDataFormated[] = $data;
		}
		$datasources["data"] = $arrDataFormated;
		$this->json_output($datasources);
	}

	public function list_out()
	{
		$this->load->library('menus');
		$this->list['page_name'] = "Document Out";
		$this->list['list_name'] = "Document Out List";
		$this->list['addnew_ajax_url'] = site_url() . 'document_io/add';
		$this->list['pKey'] = "id";
		$this->list['fetch_list_data_ajax_url'] = site_url() . 'document_io/fetch_list_out_data';
		$this->list['delete_ajax_url'] = site_url() . 'document_io/delete/';
		$this->list['edit_ajax_url'] = site_url() . 'document_io/edit/';
		$this->list['arrSearch'] = [
			'fst_document_name' => 'Document',
		];

		$this->list['breadcrumbs'] = [
			['title' => 'Home', 'link' => '#', 'icon' => "<i class='fa fa-dashboard'></i>"],
			['title' => 'Document In Out', 'link' => '#', 'icon' => ''],
			['title' => 'List', 'link' => NULL, 'icon' => ''],
		];
		$this->list['columns'] = [
			['title' => 'ID', 'width' => '5%', 'data' => 'fin_document_id'],
			['title' => 'Document', 'width' => '70%', 'data' => 'fst_name',
				'render'=>"function(data,type,row){
					var sstr=data;
					sstr += '<br>';
					sstr += row.fst_notes;
					return sstr;
				}"
			],
			['title' => 'IO Datetime', 'width' => '15%', 'data' => 'fdt_io_datetime'],
			['title' => 'IO User', 'width' => '10%', 'data' => 'fst_by_user'],
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

	public function fetch_list_out_data(){
		$this->load->library("datatables");
		$this->datatables->setTableName("(
			SELECT a.*,c.fdt_io_datetime,c.fin_by_id,c.fst_notes,d.fst_fullname as fst_by_user FROM documents a 
			INNER JOIN (
				SELECT fin_document_id,MAX(fin_id) AS fin_last_id FROM document_inout WHERE fst_active ='A' GROUP BY fin_document_id
			) b ON a.fin_document_id = b.fin_document_id 
			INNER JOIN document_inout c ON b.fin_last_id = c.fin_id
			INNER JOIN users d ON c.fin_by_id = d.fin_user_id
			WHERE a.fst_io_status = 'OUT' 
		) a");
		
		$selectFields = "a.*";
		$this->datatables->setSelectFields($selectFields);
		
		$searchFields =[];
		$searchFields[] = $this->input->get('optionSearch'); //["fst_fullname","fst_birthplace"];
		$this->datatables->setSearchFields($searchFields);
		$this->datatables->activeCondition = "fst_active !='D'";
		
		// Format Data
		$datasources = $this->datatables->getData();
		$arrData = $datasources["data"];
		$arrDataFormated = [];
		foreach ($arrData as $data) {
			//action
			$data["action"]	= "<div style='font-size:16px'>
					<a class='btn-edit' href='#' data-id='" . $data["fin_document_id"] . "'><i class='fa fa-pencil'></i></a>
				</div>";
			$arrDataFormated[] = $data;
		}
		$datasources["data"] = $arrDataFormated;
		$this->json_output($datasources);
	}
	

	public function fetch_data($id)
	{
		$data = $this->document_inout_model->getDataById($id);
		$this->json_output([
			"status"=>"SUCCESS",
			"messages"=>"",
			"data"=>$data
		]);
	}

	public function add(){
		$this->openForm("ADD", 0);
	}

	public function Edit($id){
		$this->openForm("EDIT", $id);
	}

	public function Print($id){
		$ssql ="SELECT a.*,b.fst_fullname AS fst_user_name,c.fst_name AS fst_document_name FROM document_inout a 
			INNER JOIN users b ON a.fin_by_id = b.fin_user_id
			INNER JOIN documents c ON a.fin_document_id = c.fin_document_id
			WHERE a.fin_id  = ?";

		$qr = $this->db->query($ssql,[$id]);
		
		//$data["data"] = $qr->row_array();
		$data = $qr->row_array();
		$this->parser->parse('pages/document_io/print', $data);

	}

	private function openForm($mode = "ADD", $id = 0)
	{
		$this->load->library("menus");

		if ($this->input->post("submit") != "") {
			$this->add_save();
		}

		$main_header = $this->parser->parse('inc/main_header', [], true);
		$main_sidebar = $this->parser->parse('inc/main_sidebar', [], true);

		$data["mode"] = $mode;
		$data["title"] = $mode == "ADD" ? "Add Document IO" : "Update Document IO";
		$data["fin_id"] = $id;

		$page_content = $this->parser->parse('pages/document_io/form', $data, true);
		$main_footer = $this->parser->parse('inc/main_footer', [], true);

		$control_sidebar = NULL;
		$this->data["MAIN_HEADER"] = $main_header;
		$this->data["MAIN_SIDEBAR"] = $main_sidebar;
		$this->data["PAGE_CONTENT"] = $page_content;
		$this->data["MAIN_FOOTER"] = $main_footer;
		$this->data["CONTROL_SIDEBAR"] = $control_sidebar;
		$this->parser->parse('template/main', $this->data);
	}

	


	public function ajx_add_save()
	{

		/*
		$this->form_validation->set_rules($this->departments_model->getRules("ADD", 0));
		$this->form_validation->set_error_delimiters('<div class="text-danger">* ', '</div>');

		if ($this->form_validation->run() == FALSE) {
			//print_r($this->form_validation->error_array());
			$this->ajxResp["status"] = "VALIDATION_FORM_FAILED";
			$this->ajxResp["message"] = "Error Validation Forms";
			$this->ajxResp["data"] = $this->form_validation->error_array();
			$this->json_output();
			return;
		}
		*/

		$finDocId = $this->input->post("fin_document_id");

		$doc = $this->documents_model->getDataById($finDocId);

		$data = [
			"fdt_io_datetime" => dBDateFormat($this->input->post("fdt_io_datetime")),
			"fin_document_id" => $this->input->post("fin_document_id"),
			"fin_by_id" =>  $this->input->post("fin_by_id"),
			"fst_io_status" => null,			
			"fst_notes"=> $this->input->post("fst_notes"),
			"fst_active" => 'A'
		];

		if ($doc->fst_io_status == "IN"){
			//Add As Document OUT
			$data["fst_io_status"] = "OUT";
		}else{
			//Add As Document IN
			$data["fst_io_status"] = "IN";			
		}
		

		$this->db->trans_start();
		$insertId = $this->document_inout_model->insert($data);
		$this->document_inout_model->posting($insertId);

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
		$finId = $this->input->post("fin_id");
		$dataOld = $this->document_inout_model->getDataById($finId);
		if ($dataOld == null) {
			$this->ajxResp["status"] = "DATA_NOT_FOUND";
			$this->ajxResp["message"] = "Data ID Not Found ";
			$this->ajxResp["data"] = [];
			$this->json_output();
			return;
		}

		/*
		$this->form_validation->set_rules($this->departments_model->getRules("EDIT", $fin_department_id));
		$this->form_validation->set_error_delimiters('<div class="text-danger">* ', '</div>');
		if ($this->form_validation->run() == FALSE) {
			//print_r($this->form_validation->error_array());
			$this->ajxResp["status"] = "VALIDATION_FORM_FAILED";
			$this->ajxResp["message"] = "Error Validation Forms";
			$this->ajxResp["data"] = $this->form_validation->error_array();
			$this->json_output();
			return;
		}
		*/

		$data = [
			"fin_id"=>$finId,
			"fdt_io_datetime" => dBDateFormat($this->input->post("fdt_io_datetime")),
			"fin_by_id" =>  $this->input->post("fin_by_id"),
			"fst_notes"=> $this->input->post("fst_notes"),
			"fst_active" => 'A'
		];

		$this->db->trans_start();

		$this->document_inout_model->update($data);
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
		$this->ajxResp["data"]["insert_id"] = $finId;
		$this->json_output();
	}


	public function ajxGetDocumentList(){
		$term = $this->input->get("term");
		$this->load->model("documents_model");
		$list = $this->documents_model->getDocumentList($term);
		$this->json_output([
			"status"=>"SUCCESS",
			"messages"=>"",
			"data"=>$list
		]);
	}
	
	public function delete($id){
		if (!$this->aauth->is_permit("")) {
			$this->ajxResp["status"] = "NOT_PERMIT";
			$this->ajxResp["message"] = "You not allowed to do this operation !";
			$this->json_output();
			return;
		}

		$data = $this->document_inout_model->parentGetDataById($id);
		if ($data == null){
			$this->json_output([
				"status"=>"FAILED",
				"messages"=>"Invalid ID",
				"data"=>[]
			]);
		}


		if($this->document_inout_model->isLastId($id)){
			
			$lastIOStatus ="IN";
			if ($data->fst_io_status == "IN"){
				$lastIOStatus ="OUT";
			}

			$ssql = "Update documents set fst_io_status = ? where fin_document_id = ?";
			$this->db->query($ssql,[$lastIOStatus,$data->fin_document_id]);			
			$this->document_inout_model->delete($id);

			//var_dump($this->db->error());
			//die();

			$this->ajxResp["status"] = "SUCCESS";
			$this->ajxResp["message"] = "Data deleted !";
			$this->json_output();
		}else{
			$this->ajxResp["status"] = "FAILED";
			$this->ajxResp["message"] = "Data transaksi tidak dapat dihapus !";
			$this->json_output();
		}
		
		
	}




















	











	

	

	

	
	public function getAllList()
	{
		$result = $this->departments_model->getAllList();
		$this->ajxResp["data"] = $result;
		$this->json_output();
	}

	public function report_departments(){
        $this->load->library('pdf');
        //$customPaper = array(0,0,381.89,595.28);
        //$this->pdf->setPaper($customPaper, 'landscape');
        $this->pdf->setPaper('A4', 'portrait');
		//$this->pdf->setPaper('A4', 'landscape');
		
		$this->load->model("departments_model");
		$listDepartment = $this->departments_model->get_departments();
        $data = [
			"datas" => $listDepartment
		];
			
        $this->pdf->load_view('report/departments_pdf', $data);
        $this->Cell(30,10,'Percobaan Header Dan Footer With Page Number',0,0,'C');
        $this->Cell(0,10,'Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
    }
}
