<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Flow_control_schema_header_model extends MY_Model {
    public $tableName = "flow_control_schema_header";
    public $pkey = "fin_flow_control_schema_id";

    public function __construct(){
        parent:: __construct();
    }

    public function getDataById($fin_flow_control_schema_id){
		$ssql = "select fin_flow_control_schema_id,fin_user_id,fst_name,fst_memo from " . $this->tableName ." where fin_flow_control_schema_id = ? and fst_active = 'A'";
		$qr = $this->db->query($ssql,[$fin_flow_control_schema_id]);
        $rwFlowSchemaHeader = $qr->row();
        
        $ssql = "select a.*,b.fst_username from flow_control_schema_detail a inner join users b on a.fin_user_id = b.fin_user_id where a.fin_flow_control_schema_id = ? and a.fst_active = 'A'";
		$qr = $this->db->query($ssql,[$fin_flow_control_schema_id]);
		$rsFlowSchemaDetail = $qr->result();

		$data = [
            "fcsheader" => $rwFlowSchemaHeader,
            "fcsdetail" => $rsFlowSchemaDetail
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
        $ssql = "select fin_flow_control_schema_id,fst_name from " . $this->tableName ." where fin_user_id = ? and fst_active = 'A'";
        $qr = $this->db->query($ssql,[$fin_user_id]);
        $rs = $qr->result();
        return $rs;
    }
}