<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Document_details_model extends MY_Model {
    public $tableName = "document_details";
    public $pkey = "fin_id";

    public function __construct(){
        parent:: __construct();
    }

    public function getRules($mode="ADD",$id=0){

        $rules = [];

        $rules[] = [
            'field' => 'fin_document_id',
            'label' => 'Document_ID',
            'rules' => 'required',
            'errors' => array(
                'required' => '%s tidak boleh kosong'
            )
        ];

        return $rules;
    }

    public function getRowsByParentId($parent_id){
        $ssql = "select a.fin_id,b.fin_document_id,b.fst_name,b.fst_source,b.fst_memo,b.fin_insert_id,b.fdt_insert_datetime,c.fst_username from " . $this->tableName . " a 
            inner join documents b on a.fin_document_item_id = b.fin_document_id
            inner join users c on b.fin_insert_id = c.fin_user_id
            where a.fin_document_id = ? and b.fst_active = 'A'";

        $qr = $this->db->query($ssql,[$parent_id]);
        if($qr){
            return $qr->result();
        }
        return [];
    }
}