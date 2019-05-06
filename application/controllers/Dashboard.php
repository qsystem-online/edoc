<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('dashboard_model');
    }

    public function index(){
        $this->load->library("menus");


        $main_header = $this->parser->parse('inc/main_header', [], true);
        $main_sidebar = $this->parser->parse('inc/main_sidebar', [], true);


        $this->data["title"] = "Dashboard";
        //echo "Format Number:". formatNumber("100000");
        //
        $this->data["ttlDocReadyApprove"] = formatNumber($this->dashboard_model->getTtlDocReadyToApprove());
        $this->data["ttlDocNeedRevision"] = formatNumber($this->dashboard_model->getTtlDocNeedToRevision());
        $this->data["ttlDocChangeAfterApproved"] = formatNumber($this->dashboard_model->getTtlDocHasRevision());
        

        $page_content = $this->parser->parse('pages/dashboard/index', $this->data, true);
        $main_footer = $this->parser->parse('inc/main_footer', [], true);

        $control_sidebar = NULL;
        $this->data["MAIN_HEADER"] = $main_header;
        $this->data["MAIN_SIDEBAR"] = $main_sidebar;
        $this->data["PAGE_CONTENT"] = $page_content;
        $this->data["MAIN_FOOTER"] = $main_footer;
        $this->data["CONTROL_SIDEBAR"] = $control_sidebar;
        $this->parser->parse('template/main', $this->data);
        
    }
}
