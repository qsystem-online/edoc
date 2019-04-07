<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Users_model extends MY_Model {
	public $tableName = "users";	
	public function  __construct(){
		parent::__construct();
	}

	public function getDataById($fin_id){
		$ssql = "select * from " . $this->tableName ." where fin_id = ?";
		$qr = $this->db->query($ssql,[$fin_id]);		
		$rwUser = $qr->row();
		if($rwUser){
			//echo FCPATH . 'assets/app/users/avatar/avatar_' . $rwUser->fin_id . '.jpg not exist';
			
			if (file_exists(FCPATH . 'assets/app/users/avatar/avatar_' . $rwUser->fin_id . '.jpg')) {
				$avatarURL = site_url() . 'assets/app/users/avatar/avatar_' . $rwUser->fin_id . '.jpg';
			}else{
				
				$avatarURL = site_url() . 'assets/app/users/avatar/default.jpg';
			}
			$rwUser->avatarURL = $avatarURL;
		}

		//address
		$ssql = "select * from address where fst_owner_by = 'USER' and fin_owner_id = ? ";
		$qr = $this->db->query($ssql,[$fin_id]);
		$rsAddress = $qr->result();

		//Groups
		$ssql = "select * from user_group where fin_user_id = ? ";
		$qr = $this->db->query($ssql,[$fin_id]);
		$rsGroup = $qr->result();


		$data = [
			"user" => $rwUser,
			"list_address" => $rsAddress,
			"list_group" => $rsGroup
		];
		return $data;
	}


	public function getRules($mode="ADD",$id=0){

		$rules = [];

		$rules[] = [
			'field' => 'fst_username',
			'label' => 'Username',
			'rules' => array(
				'required',
				'is_unique[users.fst_username.fin_id.'. $id .']'
			),
				//array('custom_unique',array("table"=>"users","column"=>"fst_username","key"=>"fin_id","id"=>$id))
			//'rules' => 'required|is_unique[users.fst_username]',			
			/*
			'rules' => array(
				'required',
				array('is_unique',array("table"=>"users","column"=>"fst_username","key"=>"fin_id","id"=>$id))
			),
			*/
			'errors' => array(
				'required' => '%s tidak boleh kosong',
				'is_unique' => '%s harus unik',
			),
		];

		$rules[] = [
			'field' => 'fst_fullname',
			'label' => 'Full Name',
			'rules' => 'required|min_length[5]',
			'errors' => array(
				'required' => '%s tidak boleh kosong',
				'min_length' => 'Panjang %s paling sedikit 5 character'
			)
		];

		$rules[] = [
			'field' => 'fdt_birthdate',
			'label' => 'Birth date',
			'rules' => 'required',
			'errors' => array(
				'required' => '%s tidak boleh kosong',
			)
		];

		$rules[] =[
			'field' => 'fst_birthplace',
			'label' => 'Birth Place',
			'rules' => 'required',
			'errors' => array(
				'required' => '%s tidak boleh kosong',
			)
		];

		return $rules;
		
	}

}
