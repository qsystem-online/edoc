<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {
    public function __construct(){
        parent:: __construct();
		$this->load->library('form_validation');
		$this->load->model('users_model');
    }

    public function getAllList(){
		$result = $this->users_model->getAllList();
		$this->ajxResp["data"] = $result;
        $this->json_output();		
	}
}