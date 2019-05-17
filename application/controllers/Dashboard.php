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
        $this->data["ttlDocRejected"] = formatNumber($this->dashboard_model->getTotalRejected());
        

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

    public function test_report(){
        $this->load->library('pdf');
        //$customPaper = array(0,0,381.89,595.28);
        //$this->pdf->setPaper($customPaper, 'landscape');
        $this->pdf->setPaper('A4', 'portrait');
        //$this->pdf->setPaper('A4', 'landscape');
        $this->pdf->load_view('report/laporan_pdf', $data);
        $this->Cell(30,10,'Percobaan Header Dan Footer With Page Number',0,0,'C');
        $this->Cell(0,10,'Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
    }
}
