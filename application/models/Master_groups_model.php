<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Master_groups_model extends MY_Model {
    public $tableName = "master_groups";
    public $pkey = "fin_group_id";

    public function __construct(){
        parent:: __construct();
    }

    public function getDataById($fin_group_id){
		$ssql = "select * from master_groups where fin_group_id = ?";
		$qr = $this->db->query($ssql,[$fin_group_id]);		
		$rwMasterGroups = $qr->row();
		//if($rwMasterGroups){}
		$data = [
			"master_groups" => $rwMasterGroups
		];
		return $data;
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
        ];

        return $rules;
    }
}