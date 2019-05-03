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

    public function update($data){
        parent::update($data);
        $ssql = "select * from " . $this->tableName . " where fin_id = ?";
        $qr = $this->db->query($ssql,[$data["fin_id"]]);
        $rw = $qr->row();
        if($rw){
            $fin_document_id = $rw->fin_document_id;
            $currSeqNo = $rw->fin_seq_no;

            // if all flow approved on seq_no level update fst_control_status to next seq_no
            $ssql = "select b.* from 
                (select max(fin_id) as fin_id, fin_user_id from " . $this->tableName . " where fin_document_id = ? and fin_seq_no <= ? group by fin_user_id) a
                inner join " . $this->tableName . " b on a.fin_id = b.fin_id 
                where b.fst_control_status != 'AP' ";
            $qr = $this->db->query($ssql,[$fin_document_id,$currSeqNo]);
            $rw = $qr->row();
            if (!$rw){
                //Data Kosong all Approved ; seq_no < from current seq_no
                //get next seq_no
                $ssql = "select fin_seq_no from " . $this->tableName . " where fin_seq_no > ? and fst_control_status = 'NA' order by fin_seq_no ASC limit 1";
                $qr = $this->db->query($ssql,[$currSeqNo]);
                //echo $this->db->last_query();
                $rw = $qr->row();
                if($rw){
                    $nextSeqNo = $rw->fin_seq_no;
                    $ssql = "update " . $this->tableName . " set fst_control_status = 'RA' where fin_seq_no = ? and fst_control_status = 'NA'";
                    $this->db->query($ssql,[$nextSeqNo]);
                }
            }



            // if all flow approved update fbl_flow_complete on document
            $ssql = "select b.* from 
                (select max(fin_id) as fin_id, fin_user_id from " . $this->tableName . " where fin_document_id = ?  group by fin_user_id) a
                inner join " . $this->tableName . " b on a.fin_id = b.fin_id 
                where b.fst_control_status != 'AP' ";
            $qr = $this->db->query($ssql,[$fin_document_id]);
            $rw = $qr->row();
            if (!$rw){
                // All Document approved
                $ssql = "update documents set fbl_flow_completed = TRUE where fin_document_id = ?";
            }else{
                $ssql = "update documents set fbl_flow_completed = FALSE where fin_document_id = ?";
            }
            $this->db->query($ssql,[$fin_document_id]);
        }
    }
    

    public function getCurrentSeqNo($fin_document_id){
        $ssql = "select fin_seq_no from " . $this->tableName . " where fin_document_id = ? and
            fst_control_status != 'NA' order by fin_seq_no limit 1";
        $qr = $this->db->query($ssql,[$fin_document_id]);
        $rw = $qr->row();
        if($rw){
            return $rw->fin_seq_no;
        }
        return 9999;
    }

    public function getControlStatus($fin_document_id,$fin_seq_no){
        $ssql = "select * from " . $this->tableName . " where fin_document_id = ? and fin_seq_no < ? and fst_control_status != 'AP'";
        $qr = $this->db->query($ssql,[$fin_document_id,$fin_seq_no]);
        $rw = $qr->row();
        if($rw){
            return "NA";
        }else{
            return "RA";
        }
    }
}