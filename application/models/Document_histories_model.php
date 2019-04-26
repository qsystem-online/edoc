<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Document_histories_model extends MY_Model {
    public $tableName = "document_histories";
    public $pkey = "fin_id";

    public function __construct(){
        parent:: __construct();
    }

    public function getRules($mode="ADD",$id=0){

        $rules = [];
        $rules[] = [
            'field' => 'fst_memo',
            'label' => 'Memo',
            'rules' => 'required',
            'errors' => array(
                'required' => '%s tidak boleh kosong'
            )
        ];

        $rules[] = [
            'field' => 'fin_version',
            'label' => 'Version',
            'rules' => 'required',
            'errors' => array(
                'required' => '%s tidak boleh kosong'
            )
        ];

        return $rules;
    }
    
}