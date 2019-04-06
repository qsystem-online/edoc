<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Groups_model extends MY_Model {
	public $tableName = "groups";

	public $rules = [];			
		
	public function  __construct(){
		parent::__construct();
	}

	public function get_list_group(){
		$ssql = "select fin_id,fst_group_name from groups where fst_active = 'ACTIVE' order by fst_group_name";
		$query = $this->db->query($ssql,[]);
		return $query->result();
	}


}
