<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Document_inout_model extends MY_Model {
    public $tableName = "document_inout";
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
    
    public function getDataById($id){
        $ssql="SELECT a.*,b.fst_name, b.fst_document_no FROM document_inout a 
            INNER JOIN documents b on a.fin_document_id = b.fin_document_id 
            WHERE a.fin_id = ? and a.fst_active ='A'";
        $qr = $this->db->query($ssql,[$id]);
        return $qr->row();
    }

    public function parentGetDataById($id){
        return parent::getDataById($id);
    }

    public function posting($id){
        $docIO = $this->getDataById($id);
        $ssql = "UPDATE documents set fst_io_status = ? where fin_document_id = ?";
        $this->db->query($ssql,[$docIO->fst_io_status,$docIO->fin_document_id]);
    }

    public function isLastId($id){

        $data = parent::getDataById($id);
        if ($data == null){
            return true;
        }

        $ssql = "SELECT * FROM document_inout where fin_id > ? and fin_document_id  = ? and fst_active = 'A'";
        $qr = $this->db->query($ssql,[$id,$data->fin_document_id]);
        $rw = $qr->row();
        if($rw == null){
            return true;
        }
        return false;
    }

    public function getList($finDocId){
        $ssql ="SELECT a.*,b.fst_fullname FROM document_inout a 
            INNER JOIN users b on a.fin_by_id = b.fin_user_id 
            where a.fin_document_id = ? and a.fst_active = 'A' order by a.fin_id";
        $qr = $this->db->query($ssql,[$finDocId]);
        $rs = $qr->result();
        return $rs;
    }
    
}