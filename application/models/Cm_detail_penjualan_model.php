<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Cm_detail_penjualan_model extends MY_Model {
	public $tableName = "cm_detail_penjualan";	
	public function  __construct(){
		parent::__construct();
	}

	public function getRules($mode="ADD",$id=0){

		$rules = [];

		$rules[] = [
			'field' => 'fin_qty',
			'label' => 'qty',
			'rules' => array(
				'required',
				'greater_than[0]',
				'numeric'
			),
			'errors' => array(
				'required' => '%s tidak boleh kosong',
				'greater_than' => '%s tidak boleh kurang dari 1',
				'numeric' => '%s harus berupa angka',
			),
		];

		$rules[] = [
			'field' => 'fdc_harga',
			'label' => 'Harga',
			'rules' => 'required|numeric|greater_than[0]',
			'errors' => array(
				'required' => '%s tidak boleh kosong',
				'numeric' => '%s harus berupa angka',
				'greater_than' => '%s tidak boleh 0',
			)
		];

		return $rules;
		
	}

	public function getDataByHeaderId($fin_id){
		$ssql = "select a.*,b.title,b.price from " . $this->tableName ." a inner join cm_products b on a.id_product = b.id_product where a.fin_penjualan_id = ?";
		$qr = $this->db->query($ssql,[$fin_id]);		
		return $qr->result();
	}
	public function deleteByHeaderId($fin_header_id){
		$ssql = "delete from " . $this->tableName  . " where fin_penjualan_id = ?";
		$this->db->query($ssql,[$fin_header_id]);
	}
}
