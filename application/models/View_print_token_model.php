<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class View_print_token_model extends MY_Model {
	public $tableName = "view_print_token";
	public $pkey = "fin_id";

	public function __construct(){
		parent:: __construct();
	}

	public function getRules($mode="ADD",$id=0){

		$rules = [];

		
		return $rules;
	}

    public function generateToken($fin_document_id){
        $this->load->helper('string');
        //Generate token
        $token = random_string("alnum",64);
        $data = [
            "fin_document_id"=> $fin_document_id,
            "fst_token"=> $token,
            "fst_session_id" => $this->session->session_id,
            "fst_active"=> "A"
        ];
        $this->insert($data);
        return $token;
    }


    public function useToken($token){

        $ssql = "select * from " . $this->tableName . " where fst_token = ? and fst_session_id = ? and fin_insert_id = ? ";
        $qr = $this->db->query($ssql, [$token,$this->session->session_id,$this->aauth->get_user_id()]);
        if ($qr){
            $rw = $qr->row();  
            if ($rw){
                var_dump($rw);
                $dteStart = new DateTime($rw->fdt_insert_datetime); 
                $dteEnd   = new DateTime(date("Y-m-d H:i:s")); 
                $interval = $dteEnd->getTimestamp() - $dteStart->getTimestamp(); // seconds
                $validToken = false;
                if ($interval > 60){ // token expired                    
                    $validToken = false;
                }else{
                    $validToken = $rw->fin_document_id;
                }                
                $this->delete($rw->fin_id,true);

                return $validToken;
            }else{
                
                return false;
            }
        }else{            
            return false;
        }

       

    }


}