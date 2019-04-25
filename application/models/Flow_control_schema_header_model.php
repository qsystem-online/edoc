<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Flow_control_schema_header_model extends MY_Model {
    public $tableName = "flow_control_schema_header";
    public $pkey = "fin_flow_control_schema_id";

    public function __construct(){
        parent:: __construct();
    }

    public function getDataById($fin_user_id){
		$ssql = "select * from " . $this->tableName ." where fin_flow_control_schema_id = ?";
		$qr = $this->db->query($ssql,[$fin_user_id]);
        $rwFlowSchemaHeader = $qr->row();
        
        $ssql = "select * from flow_control_schema_detail where fin_id = ?";
		$qr = $this->db->query($ssql,[$fin_id]);
		$rwFlowSchemaDetail = $qr->row();

		$data = [
            "flow_control_schema_header" => $rwFlowSchemaHeader,
            "flow_control_schema_detail" => $rwFlowSchemaDetail
		];

		return $data;
	}

    public function getRules($mode="ADD",$id=0){

        $rules = [];

        $rules[] = [
            'field' => 'fst_name',
            'label' => 'Name',
            'rules' => 'required',
            'errors' => array(
                'required' => '%s tidak boleh kosong'
            )
        ];
        return $rules;
    }

    public function getFlow($fin_user_id){
        $ssql = "select fin_flow_control_schema_id,fst_name from " . $this->tableName ." where fin_insert_id = ? and fst_active = 'A'";
        $qr = $this->db->query($ssql,[$fin_user_id]);
        $rs = $qr->result();
        return $rs;
    }
}