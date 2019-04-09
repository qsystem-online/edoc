<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Flow_control_schema_header_model extends MY_Model {
    public $tableName = "flow_control_schema_header";
    public $pkey = "fin_flow_control_schema_id";

    public function __construct(){
        parent:: __construct();
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
}