<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class User_group_model extends MY_Model {
	public $tableName = "user_group";

	public $rules = [];			
		
	public function  __construct(){
		parent::__construct();
	}

	public function deleteByUserId($fin_user_id){
		$ssql = "delete from " . $this->tableName  . " where fin_user_id = ?";
		$this->db->query($ssql,[$fin_user_id]);

	}
}
