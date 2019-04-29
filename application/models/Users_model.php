<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends MY_Model
{
	public $tableName = "users";
	public $pkey = "fin_user_id";

	public function  __construct()
	{
		parent::__construct();
	}

	public function getDataById($fin_user_id)
	{
		//$ssql = "select * from " . $this->tableName ." where fin_user_id = ?";
		$ssql = "select a.*,b.fst_department_name,c.fst_group_name from " . $this->tableName . " a left join departments b on a.fin_department_id = b.fin_department_id left join master_groups c on a.fin_group_id = c.fin_group_id where a.fin_user_id = ?";
		$qr = $this->db->query($ssql, [$fin_user_id]);
		$rwUser = $qr->row();
		if ($rwUser) {
			if (file_exists(FCPATH . 'assets/app/users/avatar/avatar_' . $rwUser->fin_user_id . '.jpg')) {
				$avatarURL = site_url() . 'assets/app/users/avatar/avatar_' . $rwUser->fin_user_id . '.jpg';
			} else {

				$avatarURL = site_url() . 'assets/app/users/avatar/default.jpg';
			}
			$rwUser->avatarURL = $avatarURL;
		}


		$data = [
			"user" => $rwUser
		];

		return $data;
	}

	public function getRules($mode = "ADD", $id = 0)
	{

		$rules = [];

		$rules[] = [
			'field' => 'fst_username',
			'label' => 'Username',
			'rules' => array(
				'required',
				'is_unique[users.fst_username.fin_user_id.' . $id . ']'
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
			'label' => 'Birth Date',
			'rules' => 'required',
			'errors' => array(
				'required' => '%s tidak boleh kosong',
			)
		];

		$rules[] = [
			'field' => 'fst_birthplace',
			'label' => 'Birth Place',
			'rules' => 'required',
			'errors' => array(
				'required' => '%s tidak boleh kosong',
			)
		];

		/*$rules[] = [
			'field' => 'fbl_admin',
			'label' => 'Admin',
			'rules' => 'required',
			'errors' =>array(
				'required' => '%s tidak boleh kosong'
			)
		];*/

		return $rules;
	}

	public function getAllList()
	{
		$ssql = "select fin_user_id,fst_username from " . $this->tableName . " where fst_active = 'A' order by fst_username";
		$qr = $this->db->query($ssql, []);
		$rs = $qr->result();
		return $rs;
	}

	public function getRulesCp()
	{
		$activeUser = $this->aauth->user();
		$password = $activeUser->fst_password;
		$CurrentPassword = $this->input->post("current_password");

		$rules = [];

		if (md5($CurrentPassword) != $password) {

			$rules[] =
				[
					'field' => 'current_password',
					'label' => 'Current Password',
					'rules' => 'matches[' . $password . ']',
					'errors' => array(
						'matches' => 'Wrong password'
					)
				];
		} else { }

		$rules[] = [
			'field' => 'new_password1',
			'label' => 'New Password',
			'rules' => 'required|min_length[3]|matches[new_password2]',
			'errors' => array(
				'required' => '%s tidak boleh kosong',
				'min_length' => 'Panjang %s paling sedikit 3 character',
				'matches' => 'not matches with Repeat password'
			)
		];

		$rules[] = [
			'field' => 'new_password2',
			'label' => 'Repeat Password',
			'rules' => 'required|min_length[3]',
			'errors' => array(
				'required' => '%s tidak boleh kosong',
				'min_length' => 'Panjang %s paling sedikit 3 character'
			)
		];


		return $rules;
	}
}
