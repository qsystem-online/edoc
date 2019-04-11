<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Departments_model extends MY_Model {
    public $tableName = "departments";
    public $pkey = "fin_department_id";

    public function __construct(){
        parent:: __construct();
    }

    public function getDataById($fin_department_id){
		$ssql = "select * from departments where fin_department_id = ?";
		$qr = $this->db->query($ssql,[$fin_department_id]);		
		$rwDepartments = $qr->row();
		//if($rwDepartments){}
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
}