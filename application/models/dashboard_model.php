<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class dashboard_model extends CI_Model {
    //Get Doc Flow Control Need Approval
    public function getTtlDocReadyToApprove(){
        $tbl = "";
        $ssql = "select count(*) as ttl_ready_approve from document_flow_control where fin_user_id = ? and fst_control_status = 'RA'"; 
        $query = $this->db->query($ssql,$this->aauth->get_user_id());
        $row = $query->row();
        return $row->ttl_ready_approve;
    }

    // Get Doc Flow Control has revision - info document yang telah di revisi cuma belum di lihat user
    public function getTtlDocHasRevision($fin_user_id){
        $tbl = "";
        $ssql = "select count(*) as ttl_doc_revised 
        from document_flow_control a
        inner join (select fin_document_id, max(fin_version) as fin_version from document_files group by fin_document_id ) b  on a.fin_document_id = b.fin_document_id
        where fin_user_id = ? 
        and a.fin_version < b.fin_version
        and fst_control_status = 'AP'";
        $query = $this->db->query($ssql,[$fin_user_id]);
        $row = $query->row();
        return $row->ttl_doc_revised;
    }


    //Get Total Document yang harus di revisi user
    public function getTtlDocNeedToRevision(){
        $ssql = "select count(*) as ttl_doc_need_revision from 
            (
                select a.fin_user_id,a.fin_document_id,max(a.fin_id) as fin_id from document_flow_control a 
                inner join documents b on a.fin_document_id = b.fin_document_id
                where b.fin_insert_id = ? 
                group by a.fin_user_id,a.fin_document_id
            ) a 
            inner join document_flow_control b on a.fin_id = b.fin_id 
            where b.fst_control_status = 'NR'
        ";
        $query = $this->db->query($ssql,$this->aauth->get_user_id());
        $row = $query->row();
        return $row->ttl_doc_need_revision;
    }
}