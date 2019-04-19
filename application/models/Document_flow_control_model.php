<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Document_flow_control_model extends MY_Model {
    public $tableName = "document_flow_control";
    public $pkey = "fin_id";

    public function __construct(){
        parent:: __construct();
    }

    public function getRules($mode="ADD",$id=0){

        $rules = [];

        $rules[] = [
            'field' => 'fin_document_id',
            'label' => 'Document ID',
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

}