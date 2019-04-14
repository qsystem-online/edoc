<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Master_groups_model extends MY_Model {
    public $tableName = "master_groups";
    public $pkey = "fin_group_id";

    public function __construct(){
        parent:: __construct();
    }

    public function getDataById($fin_group_id){
		$ssql = "select * from " . $this->tableName ." where fin_group_id = ?";
		$qr = $this->db->query($ssql,[$fin_group_id]);		
		$rwMasterGroups = $qr->row();
		//if($rwMasterGroups){}
		$data = [
			"master_groups" => $rwMasterGroups
		];
        return $data;
        
        /*$fin_level = '0','1','2','3','4','5';
        switch ($fin_level){
            case "0":
                echo "Top Management";
                break;
            case "1":
                echo "Upper Management";
                break;
            case "2":
                echo "Middle Management";
                break;
            case "3":
                echo "Supervisors";
                break;
            case "4":
                echo "Line Workers";
                break;
            case "5":
                echo "Public";
                break;
        }*/
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

        return $rules;
    }

    // Untuk mematikan fungsi otomatis softdelete dari MY_MODEL
    /*public function delete($key, $softdelete = false){
		parent::delete($key,$softdelete);
	}*/
}