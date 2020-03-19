<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Master_groups_model extends MY_Model
{
    public $tableName = "master_groups";
    public $pkey = "fin_group_id";

    public function __construct()
    {
        parent::__construct();
    }

    public function getDataById($fin_group_id)
    {
        $ssql = "select * from " . $this->tableName . " where fin_group_id = ?";
        $qr = $this->db->query($ssql, [$fin_group_id]);
        $rwMasterGroups = $qr->row();
        /*
        switch($rwMasterGroups->fin_level){
            case 0:
                $level_name = "Top Management";
                break;
            case 1:
                $level_name = "Upper Management";
                break;
            case 2:
                $level_name = "Middle Management";
                break;
            case 3:
                $level_name = "Supervisors";
                break;
            case 4:
                $level_name = "Line Workers";
                break;
            case 5:
                $level_name = "Public";
                break:
        }
        $rwMasterGroups->fst_level_name=$level_name;
        /*$ssql = "select fin_group_id, fin_level from master_groups order by
                (case 
                        when fin_level = 0 then "Top Management"
                        when fin_level = 1 then "Upper Management"
                        when fin_level = 2 then "Middle Management"
                        when fin_level = 3 then "Supervisors"
                        when fin_level = 4 then "Line Workers"
                        when fin_level = 5 then "Public"
                end)";
        $qr = $this->db->query($ssql,[$fin_group_id]);*/
        //print_r ($rwMasterGroups);
        $data = [
            "master_groups" => $rwMasterGroups
        ];
        return $data;
    }

    public function getRules($mode = "ADD", $id = 0)
    {
        $rules = [];

        $rules[] = [
            'field' => 'fst_group_name',
            'label' => 'Group Name',
            'rules' => 'required|min_length[5]',
            'errors' => array(
                'required' => '%s tidak boleh kosong',
                'min_length' => 'Panjang %s paling sedikit 5 character'
            )
        ];

        return $rules;
    }

    // Untuk mematikan fungsi otomatis softdelete dari MY_MODEL
    /*public function delete($key, $softdelete = false){
		parent::delete($key,$softdelete);
    }*/

    public function getAllList()
    {
        $ssql = "select fin_group_id,fst_group_name from " . $this->tableName . " where fst_active = 'A'";
        $qr = $this->db->query($ssql, []);
        $rs = $qr->result();
        return $rs;
    }

    public function get_list_group()
    {
        $ssql = "select fin_group_id,fst_group_name from master_groups where fst_active = 'A' order by fst_group_name";
        $query = $this->db->query($ssql, []);
        return $query->result();
    }

    public function get_master_groups(){
        $query = $this->db->get('master_groups');
		return $query->result_array();
    }
}
