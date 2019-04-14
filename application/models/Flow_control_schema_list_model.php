<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Flow_control_schema_list_model extends MY_Model {
    public $tableName = "flow_control_schema_list";
    public $pkey = "fin_id";

    public function __construct(){
        parent:: __construct();
    }

    public function getRules($mode="ADD",$id=0){

        $rules = [];

        $rules[] = [
            'field' => 'fin_flow_control',
            'label' => 'Flow Control',
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
        $ssql = "select * from ". $this->tableName . " where fin_flow_control_schema_id = ? and fst_active = 'A'";
        $qr = $this->db->query($ssql,[$fin_flow_control_schema_id]);
        return $qr->result();
    }
}