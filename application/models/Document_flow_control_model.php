<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Document_flow_control_model extends MY_Model {
    public $tableName = "document_flow_control";
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
            'field' => 'fin_seq_no',
            'label' => 'Sequence No',
            'rules' => 'required',
            'errors' => array(
                'required' => '%s tidak boleh kosong'
            )
        ];

        
        return $rules;
    }

    public function getRowsByParentId($parent_id){
        $ssql = "select a.*,b.fst_username from " . $this->tableName . " a
            inner join users b on a.fin_user_id = b.fin_user_id
            where a.fin_document_id = ? and a.fst_active = 'A'";
        $qr = $this->db->query($ssql,[$parent_id]);
        if($qr){
            return $qr->result();
        }
        return [];
    }

    public function deleteByParentId($fin_document_id){
        $this->db->where("fin_document_id",$fin_document_id);
        $this->db->delete($this->tableName);
    }

    public function deleteNotApprovedByParentId($fin_document_id){
        $this->db->where("fin_document_id",$fin_document_id);
        $this->db->where("fst_control_status != ","AP");
        $this->db->delete($this->tableName);
    }
}