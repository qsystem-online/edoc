<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Departments_model extends MY_Model {
    public $tableName = "departments";
    public $pkey = "fin_department_id";

    public function __construct(){
        parent:: __construct();
    }

    public function getDataById($fin_department_id){
		$ssql = "select * from " . $this->tableName ." where fin_department_id = ?";
		$qr = $this->db->query($ssql,[$fin_department_id]);		
		$rwDepartments = $qr->row();
        $data = [
            "departments" => $rwDepartments
        ];
        return $data;
    }
    
    public function getRules($mode="ADD",$id=0){
        $rules = [];

        $rules[] = [
            'field' => 'fst_department_name',
            'label' => 'Department Name',
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
    
    public function getAllList(){
        $ssql = "select fin_department_id,fst_department_name from " . $this->tableName ." where fst_active = 'A' order by fst_department_name";
        $qr = $this->db->query($ssql,[]);		
        $rs = $qr->result();		
		return $rs;

    }
}