<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Document_groups_model extends MY_Model
{
    public $tableName = "document_groups";
    public $pkey = "fin_id";

    public function __construct()
    {
        parent::__construct();
    }

    public function getDataById($finId)
    {
        $ssql = "select * from " . $this->tableName . " where fin_id = ?";
        $qr = $this->db->query($ssql, [$finId]);
        $data = [
            "document_groups" => $qr->row()
        ];
        return $data;
    }

    public function getRules($mode = "ADD", $id = 0)
    {
        $rules = [];

        $rules[] = [
            'field' => 'fst_group_code',
            'label' => 'Group Code',
            //'rules' => 'required|min_length[5]',
            'rules' => 'required',
            'errors' => array(
                'required' => '%s tidak boleh kosong',
               // 'min_length' => 'Panjang %s paling sedikit 5 character'
            )
        ];


        $rules[] = [
            'field' => 'fst_group_name',
            'label' => 'Group Name',
            //'rules' => 'required|min_length[5]',
            'rules' => 'required',
            'errors' => array(
                'required' => '%s tidak boleh kosong',
               // 'min_length' => 'Panjang %s paling sedikit 5 character'
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
        $ssql = "select fin_id,fst_group_code,fst_group_name from " . $this->tableName . " where fst_active = 'A'";
        $qr = $this->db->query($ssql,[]);        
        $rs = $qr->result();
        return $rs;
    }

    public function get_list_group()
    {
        $ssql = "select fin_group_id,fst_group_name from master_groups where fst_active = 'A' order by fst_group_name";
        $query = $this->db->query($ssql, []);
        return $query->result();
    }   
}
