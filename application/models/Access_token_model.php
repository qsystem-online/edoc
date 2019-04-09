<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Cm_header_sales_model extends MY_Model {
    public $tableName = "access_token";
    public $pkey = "fin_user_id";
    
    public function __construct(){
        parent:: __construct();
    }

    public function getRules($mode="ADD",$id=0){

        $rules = [];

        $rules[] = [
            'field' => 'fst_reff_source_code',
            'label' => 'Reff Source Code',
            'rules' => 'required',
            'errors' => array(
                'required' => '%s tidak boleh kosong'
            )
        ];

        $rules[] = [
            'field' => 'fst_reff_no',
            'label' => 'Reff No',
            'rules' => 'required',
            'errors' => array(
                'required' => '%s tidak boleh kosong'
            )
        ];

        $rules[] => [
            'field' => 'fst_token',
            'label' => 'Token',
            'rules' => 'required',
            'errors' => array(
                'required' => '%s tidak boleh kosong'
            )
        ];

        $rules[] => [
            'field' => 'fst_session_id',
            'label' => 'Session ID',
            'rules' => 'required',
            'errors' => array(
                'required' => '%s tidak boleh kosong'
            )
        ];

        $rules[] => [
            'field' => 'fdt_expiration_datetime',
            'label' => 'Expiration Datetime'
            'rules' => 'required',
            'errors' => array(
                'required' => '%s tidak boleh kosong'
            )
        ];

        return $rules;
    }