<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Flow_control_schema_detail_model extends MY_Model {
    public $tableName = "flow_control_schema_detail";
    public $pkey = "fin_id";

    public function __construct(){
        parent:: __construct();
    }

    public function deleteByDetail($fin_flow_control_schema_id){
		$ssql = "delete from " . $this->tableName  . " where fin_flow_control_schema_id = ?";
		$this->db->query($ssql,[$fin_flow_control_schema_id]);
        /*$qr = $this->db->query($ssql,[$fin_flow_control_schema_id]);
        $rwFlowSchemaDetail = $qr->row();
        
        $data = [
            "fcsdetail" => $rwFlowSchemaDetail
		];

		return $data;*/
	}

    public function getRules($mode="ADD",$id=0){

        $rules = [];

        $rules[] = [
            'field' => 'fin_flow_control_schema_id',
            'label' => 'Flow Schema ID',
            'rules' => 'required',
            'errors' => array(
                'required' => '%s tidak boleh kosong'
            )
        ];

        $rules[] = [
            'field' => 'fin_user_id',
            'label' => 'User ID',
            'rules' => 'required',
            'errors' => array(
                'required' => '%s tidak boleh kosong'
            )
        ];

        $rules[] = [
            'field' => 'fin_seq_no',
            'label' => 'Sequence No',
            'rules' => 'required',
            'errors' => array(
                'required' => '%s tidak boleh kosong'
            )
        ];

        return $rules;
    }

    public function getFlowDetail($fin_flow_control_schema_id){
        $ssql = "select a.*,fst_username from ". $this->tableName .  " a inner join 
        users b on a.fin_user_id = b.fin_user_id  where fin_flow_control_schema_id = ? and a.fst_active = 'A'";        
        $qr = $this->db->query($ssql,[$fin_flow_control_schema_id]);
        return $qr->result();
    }
}