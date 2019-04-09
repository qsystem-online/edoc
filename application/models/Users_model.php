<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Users_model extends MY_Model {
	public $tableName = "users";
	public $pkey = "fin_user_id";
	
	public function  __construct(){
		parent::__construct();
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

		$rules[] = [
			'field' => 'fin_department_id',
			'label' => 'Department ID',
			'rules' => 'required',
			'errors' => array(
				'required' => '%s tidak boleh kosong',
			)
		];

		$rules[] = [
			'field' => 'fbl_admin',
			'label' => 'Admin',
			'rules' => 'required',
			'errors' =>array(
				'required' => '%s tidak boleh kosong'
			)
		];

		return $rules;
		
	}

}
