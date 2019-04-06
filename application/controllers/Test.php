<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends MY_Controller {

	
	public function test1($var){
		echo "uri string : ". uri_string();
		echo "<br>";
		echo "site_url : ". site_url();
		echo "<br>";
		echo "site_url (uri_string) : ". site_url(uri_string());
		echo "<br>";
	}


	public function index(){
		$this->load->library('unit_test');
		$test = 1 + 1;
		$expected_result = 2;
		$test_name = 'Adds one plus one';
		$this->unit->run($test, $expected_result, $test_name,"ini 1 + 1");

		$test = 1 + 3;
		$expected_result = 5;
		$test_name = 'Adds one plus three';
		$this->unit->run($test, $expected_result, $test_name);

		echo $this->unit->report();

	}


	public function test_page(){
		$this->parser->parse('pages/sample/test',[]);
	}


	public function test_ajax(){
		//echo "AJAX REQUEST :" .$this->input->is_ajax_request();
		$this->ajxResp["status"] = AJAX_STATUS_SESSION_EXPIRED;
		$this->json_output(403);
	}

}
