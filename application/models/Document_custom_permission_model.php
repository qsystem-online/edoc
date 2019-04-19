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

}