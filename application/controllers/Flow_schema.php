<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Flow_schema extends MY_Controller {
    public function getFlow($fin_user_id){
        $this->load->model("Flow_control_schema_header_model");
        $result = $this->Flow_control_schema_header_model->getFlow($fin_user_id);
        $this->ajxResp["data"] = $result;
        $this->json_output();

    }
}