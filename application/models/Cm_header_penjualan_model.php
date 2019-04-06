<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Cm_header_penjualan_model extends MY_Model {
	public $tableName = "cm_header_penjualan";	
	public function  __construct(){
		parent::__construct();
	}

	public function getDataById($fin_id){

		//get Header
		$ssql = "select * from " . $this->tableName ." where fin_id = ?";
		$qr = $this->db->query($ssql,[$fin_id]);
		$rwHPenjualan = $qr->row();
		
		if ($rwHPenjualan){
			//get Detail
			$this->load->model("cm_detail_penjualan_model");		
			$dPenjualan = $this->cm_detail_penjualan_model->getDataByHeaderId($fin_id);
			$data = [
				"HPenjualan" => $rwHPenjualan,
				"DPenjualan" => $dPenjualan
			];
			return $data;
		}else{
			return false;
		}
	}



	public function getRules($mode="ADD",$id=0){

		$rules = [];
		$rules[] = [
			'field' => 'fdt_date',
			'label' => 'Tanggal Penjualan',
			'rules' => array(
				'required'				
			),
			'errors' => array(
				'required' => '%s tidak boleh kosong',
			),
		];

		$rules[] = [
			'field' => 'fst_customer_name',
			'label' => 'Customer',
			'rules' => 'required|min_length[5]',
			'errors' => array(
				'required' => '%s tidak boleh kosong',
				'min_length' => 'Panjang %s paling sedikit 5 character'
			)
		];

		$rules[] =[
			'field' => 'fdc_disc',
			'label' => 'Diskon',
			'rules' => 'numeric',
			'errors' => array(
				'numeric' => '%s harus berupa angka',
			)
		];

		return $rules;
		
	}

}
