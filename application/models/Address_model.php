<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Address_model extends MY_Model {
	public $tableName = "address";

	public $rules = [
		[
			'field' => 'fst_name',
			'label' => 'Address Name',
			'rules' => 'required',
			'errors' => '',
		],			
		[
			'field' => 'fst_address',
			'label' => 'Address',
			'rules' => 'required|min_length[10]',
			'errors' => array(
				'required' => '%s tidak boleh kosong',
				'min_length' => 'Panjang %s paling sedikit 10 character'
			)
		],	
	];
	

	


	public function  __construct(){
		parent::__construct();
	}

	public function insert($data){
		$id = parent::insert($data);
		//echo $this->db->last_query();

		//Set only one data can be a primary
		if ($data["fbl_primary"] == true){
			$ssql = "update address set fbl_primary = false where fst_owner_by = ? and fin_owner_id = ? and fin_id <> ?";

			$this->db->query($ssql,[$data["fst_owner_by"],$data["fin_owner_id"],$id] );

			//echo $this->db->last_query();

		}

		return $id;

	}

	public function update($data){
		parent::update($data);

		//Set only one data can be a primary
		if ($data["fbl_primary"] == true){
			$ssql = "update address set fbl_primary = false where fst_owner_by = ? and fin_owner_id = ? and fin_id <> ?";
			$this->db->query($ssql,[$data["fst_owner_by"],$data["fin_owner_id"],$data["fin_id"]]);
		}

		
	}

}
