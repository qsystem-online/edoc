<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Document_custom_permission_model extends MY_Model {
    public $tableName = "document_custom_permission";
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
            'field' => 'fin_user_department_id',
            'label' => 'User / Department ID',
            'rules' => 'required',
            'errors' => array(
                'required' => '%s tidak boleh kosong'
            )
        ];

        $rules[] = [
            'field' => 'fbl_view',
            'label' => 'View',
            'rules' => 'required',
            'errors' => array(
                'required' => '%s tidak boleh kosong'
            )
        ];

        $rules[] = [
            'field' => 'fbl_print',
            'label' => 'Print',
            'rules' => 'required',
            'errors' => array(
                'required' => '%s tidak boleh kosong'
            )
        ];

        return $rules;
    }

    public function getRowsByParentId($parent_id){

        $fields = "a.fin_id,a.fin_document_id,a.fst_mode,a.fin_user_department_id,a.fbl_view,a.fbl_print";

        $ssql = "select $fields,b.fst_department_name as fst_user_department_name from " . $this->tableName . " a inner join departments b on a.fin_user_department_id = b.fin_department_id
            where a.fin_document_id = ? and a.fst_active = 'A' and a.fst_mode ='DEPARTMENT' UNION
            select $fields,b.fst_username as fst_user_department_name from " . $this->tableName . " a inner join users b on a.fin_user_department_id = b.fin_user_id
            where a.fin_document_id = ? and a.fst_active = 'A' and a.fst_mode ='USER'
            ";
        $qr = $this->db->query($ssql,[$parent_id,$parent_id]);
        //echo $this->db->last_query();
        if($qr){
            return $qr->result();
        }
        return [];
    }
}