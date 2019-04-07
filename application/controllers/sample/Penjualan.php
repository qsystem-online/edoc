<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan extends MY_Controller {


	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
	}

	public function index(){
		$this->lizt();
	}

	public function lizt(){
		/*
		$this->load->library("menus");
		$main_header = $this->parser->parse('inc/main_header',[],true);
		$main_sidebar = $this->parser->parse('inc/main_sidebar',[],true);
		$page_content = $this->parser->parse('pages/sample/penjualan/list',[],true);
		$main_footer = $this->parser->parse('inc/main_footer',[],true);
		//$control_sidebar = $this->parser->parse('inc/control_sidebar',[],true);
		$control_sidebar = NULL;
		$this->data["MAIN_HEADER"] = $main_header;
		$this->data["MAIN_SIDEBAR"] = $main_sidebar;
		$this->data["PAGE_CONTENT"] = $page_content;
		$this->data["MAIN_FOOTER"] = $main_footer;
		$this->data["CONTROL_SIDEBAR"] = $control_sidebar;
		$this->parser->parse('template/main',$this->data);
		*/
		$this->load->library('menus');
        
        $this->list['page_name']="Transaksi Penjualan";
        $this->list['list_name']="Daftar Transaksi Penjualan";
        $this->list['addnew_ajax_url']=site_url().'SalesOrder/add';
        $this->list['pKey']="id";
		$this->list['fetch_list_data_ajax_url']=site_url().'sample/penjualan/fetch_list_data';
        $this->list['delete_ajax_url']=site_url().'sample/penjualan/delete/';
        $this->list['edit_ajax_url']=site_url().'sample/penjualan/edit/';
        $this->list['arrSearch']=[
            'a.fdt_date' => 'Date',
            'a.fin_id' => 'Transcation No',
            'a.fst_customer_name' => 'Customer Name'
		];
		
		$this->list['columns']=[
			['title' => 'ID', 'width'=>'10%', 'data'=>'fin_id'],
			['title' => 'Date', 'width'=>'10%', 'data'=>'fdt_date',
				'render'=>"$.fn.dataTable.render.moment('" . DATE_DATATABLES_FORMAT ."')",
			],
			['title' => 'Customer', 'width'=>'25%', 'data'=>'fst_customer_name'],
			['title' => 'SubTotal', 'width'=>'10%', 'data'=>'subttl_penjualan',
				'render'=>"$.fn.dataTable.render.number( ',', '.', 2 )",
				'className'=>'dt-right'],
			['title' => 'Disc (%)', 'width'=>'10%', 'data'=>'fdc_disc',
				'render'=>"$.fn.dataTable.render.number( ',', '.', 2 )",'className'=>'dt-center'],
			['title' => 'Total', 'width'=>'10%', 'data'=>'ttl_penjualan',
				'render'=>"$.fn.dataTable.render.number( ',', '.', 2 )",
				'className'=>'dt-right'],
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
		$data["title"] = $mode == "ADD" ? "Tambah Penjualan" : "Update Penjualan";
		$data["fin_id"] = $fin_id;
		$data["fdt_date"] = date("Y-m-d");

		$page_content = $this->parser->parse('pages/sample/penjualan/form',$data,true);
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

		$this->load->model('cm_header_penjualan_model');
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
			"fdt_date"=>dBDateFormat($this->input->post("fdt_date")),
			"fst_customer_name"=> $this->input->post("fst_customer_name"),
			"fdc_disc"=> $this->input->post("fdc_disc"),
			"fst_active"=>'ACTIVE',	
		];

		$this->db->trans_start();
		$insertId = $this->cm_header_penjualan_model->insert($data);
		$dbError  = $this->db->error();
		if ($dbError["code"] != 0){			
			$this->ajxResp["status"] = "DB_FAILED";
			$this->ajxResp["message"] = "Insert Failed";
			$this->ajxResp["data"] = $this->db->error();
			$this->json_output();
			$this->db->trans_rollback();
			return;
		}

		//Save Detail
		$this->load->model("cm_detail_penjualan_model");	
		
		$this->form_validation->set_rules($this->cm_detail_penjualan_model->getRules("ADD",0));
		$this->form_validation->set_error_delimiters('<div class="text-danger">* ', '</div>');
		
		$details = $this->input->post("detail");
		$details = json_decode($details);
		foreach ($details as $item) {
			$data = [
				"fin_penjualan_id"=> $insertId,
				"id_product"=> $item->id_product,
				"fin_qty"=> $item->fin_qty,
				"fdc_harga"=> $item->fdc_harga
			];

			//validate data detail
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

			$this->cm_detail_penjualan_model->insert($data);
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
		$this->load->model('cm_header_penjualan_model');

		$fin_id = $this->input->post("fin_id");
		$data = $this->cm_header_penjualan_model->getDataById($fin_id);		
		if (!$data){
			$this->ajxResp["status"] = "DATA_NOT_FOUND";
			$this->ajxResp["message"] = "Data id $fin_id Not Found ";
			$this->ajxResp["data"] = [];
			$this->json_output();
			return;
		}

		
		$data = [
			"fin_id"=>$fin_id,
			"fdt_date"=>dBDateFormat($this->input->post("fdt_date")),
			"fst_customer_name"=> $this->input->post("fst_customer_name"),
			"fdc_disc"=>$this->input->post("fdc_disc")	
		];

		$this->form_validation->set_rules($this->cm_header_penjualan_model->getRules());
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
		$this->cm_header_penjualan_model->update($data);
		$dbError  = $this->db->error();
		if ($dbError["code"] != 0){			
			$this->ajxResp["status"] = "DB_FAILED";
			$this->ajxResp["message"] = "Insert Failed";
			$this->ajxResp["data"] = $this->db->error();
			$this->json_output();
			$this->db->trans_rollback();
			return;
		}

		//Save Details
		$this->load->model("cm_detail_penjualan_model");	
		
		$this->form_validation->set_rules($this->cm_detail_penjualan_model->getRules("ADD",0));
		$this->form_validation->set_error_delimiters('<div class="text-danger">* ', '</div>');		
		$details = $this->input->post("detail");
		$details = json_decode($details);
		
		$this->cm_detail_penjualan_model->deleteByHeaderId($fin_id);

		foreach ($details as $item) {
			$data = [
				"fin_id" => $item->fin_id,
				"fin_penjualan_id"=> $fin_id,
				"id_product"=> $item->id_product,
				"fin_qty"=> $item->fin_qty,
				"fdc_harga"=> $item->fdc_harga
			];

			//validate data detail
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

			$this->cm_detail_penjualan_model->insert($data);
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
		$this->ajxResp["data"]["insert_id"] = $fin_id;
		$this->json_output();
		
	}

	public function fetch_list_data(){
		$this->load->library("datatables");
		$this->datatables->setTableName("cm_header_penjualan a left join cm_detail_penjualan b on a.fin_id = b.fin_penjualan_id");
		$this->datatables->setGroupBy("b.fin_penjualan_id");
		$this->datatables->setCountTableName("cm_header_penjualan a");
		$this->datatables->activeCondition = "a.fst_active != 'DELETED'";
		
		$selectFields = "a.fin_id,fdt_date,fst_customer_name,sum(b.fin_qty*b.fdc_harga) as subttl_penjualan,fdc_disc,sum(b.fin_qty*b.fdc_harga) - (sum(b.fin_qty*b.fdc_harga) * (fdc_disc/100))  as ttl_penjualan, 'action' as action";
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
			//$birthdate = strtotime($data["fdt_birthdate"]);			
			//$data["fdt_birthdate"] = date("d-M-Y",$birthdate);

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
		$this->load->model("cm_header_penjualan_model");

		$data = $this->cm_header_penjualan_model->getDataById($fin_id);

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
		
		$this->load->model("cm_header_penjualan_model");
		
		$this->cm_header_penjualan_model->delete($id);
		$this->ajxResp["status"] = "SUCCESS";
		$this->ajxResp["message"] = "";
		$this->json_output();
	}

	public function get_data_product(){
		$term = $this->input->get("term");
		$ssql = "select * from cm_products where title like ? order by title";
		$qr = $this->db->query($ssql,['%'.$term.'%']);
		$rs = $qr->result();
		
		$this->json_output($rs);


	}
}