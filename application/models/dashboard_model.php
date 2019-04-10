<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class dashboard_model extends CI_Model {
    //Get Doc Flow Control Need Approval
    public function getTtlDocReadyToApprove($fin_user_id){
        $tbl = "";
        $ssql = "select count(*) as ttl_ready_approve from document_flow_control where fin_user_id = ? and fst_control_status = 'RA'"; 
        $query = $this->db->query($ssql,[$fin_user_id]);
        $row = $query->row();
        return $row->ttl_ready_approve;
    }

    // Get Doc Flow Control has revision
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
}