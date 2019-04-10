<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

	
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
		$test = dBDateFormat("20-04-2019");
		$expected_result = "2019-04-20";
		$test_name = 'Test dBdateFormat';
		$this->unit->run($test, $expected_result, $test_name,$test);
		

		$test = parseNumber("200.000.000,15",",");
		$expected_result = (float) 200000000.15;
		$test_name = 'Test parseNumber';
		$this->unit->run($test, $expected_result, $test_name,$test ." vs " .$expected_result);
		
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
