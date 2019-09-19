<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard_model extends CI_Model {
    //Get Doc Flow Control Need Approval
    public function getTtlDocReadyToApprove(){
        $tbl = "";
        $ssql = "select count(*) as ttl_ready_approve from document_flow_control a
            inner join documents b on a.fin_document_id = b.fin_document_id 
            where a.fin_user_id = ? and a.fst_control_status = 'RA' and b.fst_active = 'A'"; 
        $query = $this->db->query($ssql,$this->aauth->get_user_id());
        $row = $query->row();
        return $row->ttl_ready_approve;
    }

    // Get Doc Flow Control has revision - info document yang telah di revisi cuma belum di lihat user
    public function getTtlDocHasRevision(){
        $tbl = "";

        $ssql = "SELECT COUNT(*) AS ttl_doc_revised 
            FROM documents a
            INNER JOIN (
		        SELECT fin_document_id, MAX(fin_version) AS fin_version FROM document_flow_control 
                WHERE fin_user_id = ? AND fst_control_status = 'AP' GROUP BY fin_document_id 
	        ) b  ON a.fin_document_id = b.fin_document_id
            AND b.fin_version < a.fin_version";

        $query = $this->db->query($ssql,[$this->aauth->get_user_id()]);
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

    public function getTotalRejected(){
        $tbl = "";
        $ssql = "select count(*) as ttl_rejected from document_flow_control a
            left join documents b on a.fin_document_id = b.fin_document_id 
            where a.fst_control_status = 'RJ' and b.fst_active = 'A' and b.fin_insert_id = ?";
        $query = $this->db->query($ssql,$this->aauth->get_user_id());
        $row = $query->row();
        return $row->ttl_rejected;
    }
}