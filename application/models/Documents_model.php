<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Documents_model extends MY_Model {
	public $tableName = "documents";
	public $pkey = "fin_document_id";

	public function __construct(){
		parent:: __construct();
	}



	public function getRules($mode="ADD",$id=0){

		$rules = [];

		$rules[] = [
			'field' => 'fst_name',
			'label' => 'Name',
			'rules' => 'required',
			'errors' => array(
				'required' => '%s tidak boleh kosong'
			)
		];

		return $rules;
	}


	public function getDataById($id){
		$ssql = "select a.*,fst_username from ". $this->tableName . " a 
			inner join users b on a.fin_insert_id = b.fin_user_id 
			where " . $this->pkey ." = ?";

		$qr = $this->db->query($ssql,[$id]);
		if ($qr){
			return $qr->row();
		}
		return NULL;
	}

	public function getDocumentNo($docGroupId){
		$ssql = "SELECT * FROM document_groups where fin_id = ? and fst_active = 'A'";
		$qr =$this->db->query($ssql,[$docGroupId]);
		$rw = $qr->row();
		$groupCode = $rw->fst_group_code;

		//MTPJKT/21/02/00001
		$branch = $this->aauth->getActiveBranch();
		if ($branch == null){
			return  "";
		}
		$prefix = $groupCode . $branch->fst_branch_code . "/" . date("y") . "/" . date("M"). "/";
		$ssql ="SELECT * FROM documents where fst_document_no like ? order by fst_document_no desc limit 1";
		$qr = $this->db->query($ssql,[$prefix . "%"]);
		$lastRw = $qr->row();
		if ($lastRw == null){
			return $prefix . "00001";
		}

		$tmp = explode("/",$lastRw->fst_document_no);
		$lastNo = $tmp[sizeof($tmp) -1];
		$lastNo = (int) $lastNo;
		$newNo = "0000".$lastNo + 1;
		$newNo = substr($newNo,strlen($newNo)-5);
		return $prefix . $newNo;

		


	}

	public function editPermission($fin_document_id){
		//return false;
		$this->load->model("users_model");
		//only same user or other user with same department and have a higher level group get permit
		$ssql = "select b.fin_user_id,b.fin_department_id,c.fin_level from " . $this->tableName . " a 
			inner join users b on a.fin_insert_id = b.fin_user_id
			inner join master_groups c on b.fin_group_id = c.fin_group_id
			where a.fin_document_id = ?";
		$qr = $this->db->query($ssql,[$fin_document_id]);

		if($qr){
			$rwDoc = $qr->row();
			// echo $this->db->last_query();
			// print_r($rwDoc);
			// die();

			$activeUserId = $this->aauth->get_user_id();
			//echo $activeUserId;
			

			if ($rwDoc->fin_user_id == $activeUserId){
				return true;
			}
			$userActive = $this->users_model->getDataById($activeUserId)["user"];
			
			if ($rwDoc->fin_department_id == $userActive->fin_department_id){
				if ($userActive->fin_level < $rwDoc->fin_level ){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}


	public function scopePermission($fin_document_id,$scopeMode = "VIEW"){
		$this->load->model("users_model");
		$activeUserId = $this->aauth->get_user_id();

		$fst_scope = ($scopeMode == "VIEW" ) ? "fst_view_scope" : "fst_print_scope";

		//Get Scope
		$ssql = "select a.fst_view_scope,a.fst_print_scope,a.fin_confidential_lvl,b.fin_user_id,b.fin_department_id,c.fin_level from " . $this->tableName . " a 
			inner join users b on a.fin_insert_id = b.fin_user_id
			inner join master_groups c on b.fin_group_id = c.fin_group_id
			where a.fin_document_id = ?";

		$qr = $this->db->query($ssql,[$fin_document_id]);
		//echo $this->db->last_query();
		if ($qr){
			$rwDoc = $qr->row();            
			if ($rwDoc->fin_user_id == $activeUserId){
				return true;
			}
			$userActive = $this->users_model->getDataById($activeUserId)["user"];


			//PRV, GBL, CST
			if($rwDoc->$fst_scope == "PRV"){ // only user same department can view document
				if ($rwDoc->fin_department_id  != $userActive->fin_department_id){
					return false;
				}
			}

			if ($rwDoc->$fst_scope == "CST"){
				$this->load->model("document_custom_permission_model");
				if ($this->document_custom_permission_model->isPermit("USER",$scopeMode,$fin_document_id,$userActive->fin_user_id)){
					return true;
				}

				if (! $this->document_custom_permission_model->isPermit("DEPARTMENT",$scopeMode,$fin_document_id,$userActive->fin_department_id)){
					return false;
				}               
			}
			// Cek Level
			if ($rwDoc->fin_confidential_lvl >= $userActive->fin_level  ){
				return true;
			}else{
				return false;
			}

			return false;
		}else{
			show_404();
		}
	}


	public function getFile($fin_document_id){
		$this->load->helper('download');
		$this->load->helper('file');

		$ssql = "select * from " .$this->tableName . " where fin_document_id = ? and fst_active = 'A'";
		$qr = $this->db->query($ssql,[$fin_document_id]);
		$rw = $qr->row();
		if ($rw){
			$uploadPath = getDbConfig("document_folder");
			$fileName	=  md5('doc_'. $rw->fin_document_id) . ".pdf"; 

			$fileLoc = $uploadPath . $fileName;
			
			$string = read_file($fileLoc);
			//header("Content-type:application/pdf");
			//header("Content-Disposition:inline;filename=download.pdf");
			header("Content-Disposition:inline;filename=". $rw->fst_real_file_name);
			return $string;
		}
		return NULL;
	}


	public function canBeDeleted($fin_document_id){
		//apakah terdaftar didokumen detail (dokumen lain menjadikan dokumen ini sebagai referensi)
		$ssql = "select b.* from document_details a 
			inner join documents b on a.fin_document_id = b.fin_document_id
			where fin_document_item_id = ?";

		$qr = $this->db->query($ssql,[$fin_document_id]);
		$rw = $qr->row();
		if ($rw){	
			$result = [
				"status"=>"FAILED",
				"message"=>"Document is used by another document, " . $rw->fst_name ."(".$rw->fin_document_id.")"
			];	
			return $result;
		}
		

		//cek if owner or department same with owner and level more high		
		$activeUser = $this->aauth->user();
		$ssql = "select * from documents where fin_document_id = ?";
		$qr = $this->db->query($ssql,[$fin_document_id]);
		$rw = $qr->row();
		if (!$rw){
			show_404();
			die();
		}

		if($rw->fin_insert_id == $activeUser->fin_user_id){
			$result = [
				"status"=>"SUCCESS",
				"message"=>""
			];	
			return $result;
		}else{
			$this->load->model("master_groups_model");
			$this->load->model("users_model");

			$dept = $activeUser->fin_department_id;
			$group = $this->master_groups_model->getDataById($activeUser->fin_group_id);
			$level = $group->fin_level;

			$owner = $this->users_model->getDataById($rw->fin_insert_id);
			$deptOwner = $owner->fin_department_id;
			$levelOwner = $this->master_groups_model->getDataById($owner->fin_group_id);

			if ($dept == $deptOwner && $level < $levelOwner){
				$result = [
					"status"=>"SUCCESS",
					"message"=>""
				];	
				return $result;
			}else{
				$result = [
					"status"=>"FAILED",
					"message"=>"Only owner can delete this document !"
				];	
				return $result;
			}
		}


		/*
		//cek Flow control and  Allready Approved
		$ssql = "select * from documents where fin_document_id = ?";
		$qr = $this->db->query($ssql,[$fin_document_id]);
		$rw = $qr->row();
		if ($rw){			
			if($rw->fbl_flow_control){
				// Cek apakah document sudah pernah di approved
				$ssql = "select * from document_flow_control where fin_document_id = ? and fst_control_status = 'AP'";
				$qr = $this->db->query($ssql,[$fin_document_id]);
				$rw = $qr->row();
				if ($rw){	
					$result = [
						"status"=>"FAILED",
						"message"=>"Document is already approved"
					];	
					return $result;							
				}
			}
		}
		*/


		$result = [
			"status"=>"SUCCESS",
			"message"=>""
		];
		return $result;
	}
	

	public function renewStatusDocument($fin_document_id){
		//Flow control rejected
		$ssql = "select * from document_flow_control where fst_control_status = 'RJ' and fin_document_id = ?";
		$qr = $this->db->query($ssql,[$fin_document_id]);
		$rw = $qr->row();
		if($rw){
			$data = [
				"fin_document_id"=>$fin_document_id,
				"fst_active"=>"R",
			];			
			parent::update($data);
			return "R";
		}

		//Flow Uncompleted / Completed

		//Status Rejected tidak membuat fbl_completed menjadi true, tapi akan di munculkan di dashboard 
		//tentang dokumen yg direjected, setelah creator melihat document tsb baru fbl_flow_completednya di buat true
		//sehingga hilang dari dashboard
		
		$ssql = "select * from document_flow_control a
			inner join (
				select max(fin_id) as fin_id , fin_user_id from document_flow_control 
				where fin_document_id = ? group by fin_user_id
			)  b on a.fin_id = b.fin_id 
			where a.fst_control_status != 'AP' 
			and a.fin_document_id = ?";


		$qr = $this->db->query($ssql,[$fin_document_id,$fin_document_id]);

		$rw = $qr->row();
		if($rw){
			$data = [
				"fin_document_id"=>$fin_document_id,
				"fbl_flow_completed"=> FALSE,
			];			
		}else{
			$data = [
				"fin_document_id"=>$fin_document_id,
				"fbl_flow_completed"=> true,
			];
		}
		parent::update($data);
	}

	
	public function completedFlowIfRejected($fin_document_id){
		$ssql = "update documents set fbl_flow_completed = true where fst_active = 'R' and fin_document_id = ?";
		$this->db->query($ssql,[$fin_document_id]);
	}

	public function getDocumentList($keyword){
		$ssql = "SELECT fin_document_id,fst_document_no,fst_name,fst_io_status FROM documents WHERE MATCH(fst_search_marks,fst_memo,fst_document_no,fst_name) AGAINST (? IN BOOLEAN MODE)";
		$qr = $this->db->query($ssql,[$keyword]);
		$rs = $qr->result();
		return $rs;

	}
}