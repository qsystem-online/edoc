<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Reference_document_list_model extends MY_Model {
    public $tableName = "reference_document_list";
    public $pkey = "fin_id";

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

        $rules[] = [
            'field' => 'fin_document_id',
            'label' => 'Document ID',
            'rules' => 'required',
            'errors' => array(
                'required' => '%s tidak boleh kosong'
            )
        ];

        return $rules;
    }

    public function getDataById($fin_branch_id){
        $ssql = "select * from " . $this->tableName ." where fin_id = ? and fst_active = 'A'";
		$qr = $this->db->query($ssql,[$fin_branch_id]);
        $rwReferenceDoc = $qr->row();
        
		$data = [
            "referenceDoc" => $rwReferenceDoc
		];

		return $data;
	}
}
