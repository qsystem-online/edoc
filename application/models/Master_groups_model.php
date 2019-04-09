<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Master_groups_model extends MY_Model {
    public $tableName = "master_groups";
    public $pkey = "fin_group_id";

    public function __construct(){
        parent:: __construct();
    }

    public function getRules($mode="ADD",$id=0){

        $rules = [];

        $rules[] = [
            'field' => 'fst_group_name',
            'label' => 'Group Name',
            'rules' => 'required',
            'errors' => array(
                'required' => '%s tidak boleh kosong'
            )
        ];

        $rules[] = [
            'field' => 'fin_level',
            'label' => 'Level',
            'rules' => 'required',
            'errors' => array(
                'required' => '%s tidak boleh kosong'
            )
        ]

        return $rules;
    }
}