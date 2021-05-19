<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link rel="stylesheet" href="<?=base_url()?>bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?=base_url()?>bower_components/datatables.net/datatables.min.css">
<link rel="stylesheet" href="<?=base_url()?>bower_components/datatables.net/dataTables.checkboxes.css">
<style type="text/css">
	.border-0{
		border: 0px;
	}
	td{
		padding: 2px; !important 		
	}

    .nav-tabs-custom>.nav-tabs>li.active>a{
        font-weight:bold;
        border-left-color: #3c8dbc;
        border-right-color: #3c8dbc;
        border-style:fixed;
    }
    .nav-tabs-custom>.nav-tabs{
        border-bottom-color: #3c8dbc;        
        border-bottom-style:fixed;
    }

	.select2-container--default .select2-selection--single {
		border: unset;
		padding:0px 0px 0px 0px;
		border-radius: 0px;
	}
	
	
</style>

<section class="content-header">
	<h1><?=lang("Document")?><small><?=lang("form")?></small></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> <?= lang("Home") ?></a></li>
		<li><a href="{base_url}document"><?= lang("Document") ?></a></li>
		<li class="active title"><?=$title?></li>
	</ol>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-header with-border">
				<h3 class="box-title title"><?=$title?></h3>
				<div class="btn-group btn-group-sm  pull-right">					
					<a id="btnPrint" class="btn btn-primary" href="#" title="<?=lang("Cetak")?>"><i class="fa fa-print" aria-hidden="true"></i></a>
				</div>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			<form id="frmDocument" class="form-horizontal" action="<?=site_url()?>system/user/add" method="POST" enctype="multipart/form-data">
				<div class="box-body">
					<input type="hidden" name = "<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">
					
					<div class="form-group">
						<label  class="col-sm-10 control-label"><?=lang("Creator")?> : </label>
						<label  id="creator_by" class="col-sm-2 control-label">
							<?php
								$user = $this->aauth->user();
								echo $user->fst_username;
							?>
						</label>						
					</div>

                    <div class="form-group">
						<label for="fin_document_id" class="col-sm-2 control-label"><?=lang("Document ID")?></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="fin_document_id" placeholder="<?=lang("(Autonumber)")?>" name="fin_document_id" value="{fin_document_id}" readonly>
						</div>
					</div>

					<div class="form-group">
						<label for="fst_document_no" class="col-sm-2 control-label"><?=lang("Document No")?></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="fst_document_no" placeholder="<?=lang("(Autonumber)")?>" name="fst_document_no" value="" readonly>
						</div>
					</div>

					<div class="form-group">
						<label for="fin_document_group_id" class="col-sm-2 control-label"><?=lang("Document Group")?></label>
						<div class="col-sm-10">
							<select class="form-control" id="fin_document_group_id" placeholder="<?=lang("(Autonumber)")?>" name="fin_document_group_id">
								<?php
									$groupList = $this->document_groups_model->getAllListByDept();
									
									foreach($groupList as $docGroup){
										echo "<option value='$docGroup->fin_id'>$docGroup->fst_group_code - $docGroup->fst_group_name</option>";
									}
								?>
							</select>
						</div>
					</div>
					

					<div class="form-group">
						<label for="fst_name" class="col-sm-2 control-label"><?= lang("Name") ?> * </label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="fst_name" placeholder="<?= lang("Document Name")?>" name="fst_name" value="">
							<div id="fst_name_err" class="text-danger"></div>
						</div>
					</div>

                    <div class="form-group">
						<label for="fst_source" class="col-sm-2 control-label"><?=lang("Document Source")?></label>
						<div class="col-sm-3">
							<select class="form-control" id="fst_source" name="fst_source">
								<option value='INT' selected><?= lang("Internal")?></option>
								<!-- <option value='EXT'><= lang("External")?></option> -->
							</select>
						</div>

                        <label for="fin_confidential_lvl" class="col-sm-2 control-label"><?=lang("Confidential Level")?></label>
						<div class="col-sm-3">
							<select class="select2 form-control" id="fin_confidential_lvl" name="fin_confidential_lvl">
								<option value='0'><?= lang("Top Management")?></option>
								<option value='1'><?= lang("Upper Management")?></option>
                                <option value='2'><?= lang("Middle Management")?></option>
                                <option value='3'><?= lang("Supervisors")?></option>
                                <option value='4'><?= lang("Line Workers")?></option>
                                <option value='5' selected><?= lang("Public")?></option>
							</select>
						</div>

					</div>

                    <div class="form-group">
						<label for="fst_view_scope" class="col-sm-2 control-label"><?=lang("View Scope")?></label>
						<div class="col-sm-3">
							<select class="select2 form-control scope-control" id="fst_view_scope" name="fst_view_scope">
								<option value='PRV'><?= lang("Private")?></option>
								<option value='GBL'><?= lang("Global")?></option>
                                <option value='CST'><?= lang("Custom")?></option>
							</select>
						</div>
                        <label for="fst_print_scope" class="col-sm-2 control-label"><?=lang("Print Scope")?></label>
						<div class="col-sm-3">
							<select class="select2 form-control scope-control" id="fst_print_scope" name="fst_print_scope">
                                <option value='PRV'><?= lang("Private")?></option>
								<option value='GBL'><?= lang("Global")?></option>
                                <option value='CST'><?= lang("Custom")?></option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="fst_search_marks" class="col-sm-2 control-label"><?= lang("Search Keyword")?> </label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="fst_search_marks" placeholder="<?= lang("search mark") ?>" name="fst_search_marks" />
							<div id="fst_search_marks_err" class="text-danger"></div>
						</div>
					</div>

					<div class="form-group">
						<label for="fst_memo" class="col-sm-2 control-label"><?= lang("Notes / Memo")?> </label>
						<div class="col-sm-10">
                            <textarea class="form-control" id="fst_memo" placeholder="<?= lang("Notes / Memo") ?>" name="fst_memo"></textarea>
							<div id="fst_memo_err" class="text-danger"></div>
						</div>
					</div>
					

					<div class="form-group">
						<label for="fdt_published_date" class="col-sm-2 control-label"><?= lang("Publish Date")?> *</label>
						<div class="col-sm-3">
							<div class="input-group date">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
								<input type="text" class="form-control pull-right datepicker" id="fdt_published_date" name="fdt_published_date"/>								
							</div>
							<div id="fdt_published_date_err" class="text-danger"></div>
							<!-- /.input group -->
						</div>
						<label for="fdt_expired_date" class="col-sm-2 control-label"><?= lang("Expired Date")?> *</label>
						<div class="col-sm-3">
							<div class="input-group date">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
								<input type="text" class="form-control pull-right datepicker" id="fdt_expired_date" name="fdt_expired_date"/>								
							</div>
							<div id="fdt_expired_date_err" class="text-danger"></div>
							<!-- /.input group -->
						</div>
						
					</div>


					<div class="form-group">
						<label for="fst_file_name" class="col-sm-2 control-label"><?= lang("File Document")?></label>
						<div class="col-sm-10">
							<input type="file" class="form-control" id="fst_file_name"  name="fst_file_name" accept="application/pdf">
							<div id="fst_file_name_err" class="text-danger"></div>
						</div>
					</div>

					<div class="form-group">						
						<div class="col-sm-10 col-sm-offset-2">							
							<input type="checkbox" class="minimal form-control icheck" id="fbl_flow_control" name="fbl_flow_control"> &nbsp;
							<label for="fbl_flow_control" class="control-label"> <?= lang("Document Flow Control")?> </label>
						</div>
					</div>
					<hr>
					<?php $displayDetail = ($mode == "ADD") ? "none" : "" ?>
					<div class="nav-tabs-custom" style="display:unset">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#doc_list" data-toggle="tab" aria-expanded="true"><?= lang("Document List")?></a></li>
                            <li class="" id="list_flow" style="display:none;"><a href="#tab_flow" data-toggle="tab" aria-expanded="false"><?= lang("Flow Control")?></a></li>
							<li class="" id="list_scope" style="display:none;"><a href="#tab_custom-scope" data-toggle="tab" aria-expanded="false"><?= lang("Custom Scope")?></a></li>
							<li class="" id="doc_io"><a href="#tab_doc_io" data-toggle="tab" aria-expanded="false"><?= lang("Document In Out")?></a></li>
							<li class="doc-viewer" id="tab-doc" ><a href="#doc-viewer" data-toggle="tab" aria-expanded="false"><?= lang("Document Viewer")?></a></li>
						</ul>
						<div class="tab-content">							
							<div class="tab-pane active" id="doc_list">
								<button id="btn-open-list-doc" class="btn btn-primary btn-sm pull-right edit-mode" style="margin-bottom:20px"><i class="fa fa-plus"></i>&nbsp;&nbsp;<?= lang("Add Document")?></button>
								<div>
									<table id="tbl_doc_items" class="table table-bordered table-hover" style="width:100%;"></table>
								</div>
							</div>
							<!-- /.tab-pane -->
							<div class="tab-pane" id="tab_flow">
								<form class="form-horizontal edit-mode">	
									<div class="form-group edit-mode">						
										<label for="select-product" class="col-md-8 control-label">Flow Control</label>
										<div class="col-md-3">
											<select id="select-flow-control" class="select2 form-control" style="width:100%"></select>
										</div>						
										<div class="col-md-1">
											<button id="btn-apply-flow" class="btn btn-sm btn-primary" style="width:100%">Apply</button>
										</div>															
									</div>
									<div class="form-group edit-mode">
										<div class="col-md-12">
											<button id="btn-open-flow-doc" class="btn btn-primary btn-sm pull-right" style="margin-bottom:20px"><i class="fa fa-plus"></i><?= lang("Add Flow")?></button>
										</div>
									</div>
									
								</form>
								<table id="tbl_flow_control" class="compat hover stripe" style="width:100%" ></table>
								
							</div>
							<!-- /.tab-pane -->
							<div class="tab-pane" id="tab_custom-scope">
								<form class="form-horizontal edit-mode ">	
									<div class="form-group">
										<div class="col-md-10">				
											<label for="select-product" class="col-md-3 control-label"><?= lang("Permission For :")?></label>
											<div class="col-md-3">
												<select id="scope-custom-branch" class="select2 form-control" style="width:100%"></select>
											</div>		
											<div class="col-md-3">
												<select id="scope-custom-type" class="select2 form-control" style="width:100%">
													<option value="DEPARTMENT"><?= lang("Department")?></option>
													<option value="USER"><?= lang("User")?></option>
												</select>
											</div>						
											<div class="col-md-3">
												<select id="scope-custom-value" class="select2" style="width:100%">
												</select>
											</div>
										</div>				
										<div class="col-md-1">
											<div>
												<input type="checkbox" class="minimal form-control icheck" id="fbl_scope_view" name="fbl_scope_view"> &nbsp;
												<label for="fbl_scope_view" class=""> <?= lang("View")?> </label>
											</div>
											<div>
												<input type="checkbox" class="minimal form-control icheck" id="fbl_scope_print" name="fbl_scope_print"> &nbsp;
												<label for="fbl_scope_print" class=""> <?= lang("Print")?> </label>
											</div>

										</div>
										
										<div class="col-md-1">
											<button id="btn-custom-scope" class="btn btn-sm btn-primary" style="width:100%"><?=lang("Add")?></button>
										</div>						
									
									</div>
								</form>
								<table id="tbl_custom_scope" class="compat hover stripe" style="width:100%" ></table>
							</div>

							<div class="tab-pane" id="tab_doc_io">							
								<table id="tbl_doc_io" class="table table-bordered table-hover" style="width:100%" ></table>
							</div>

							<div class="tab-pane doc-viewer" id="doc-viewer" style="text-align:center">											
								<embed id="plugin" src="" type="application/pdf" style="width:100%;height:25vw" internalinstanceid="5"/>
							</div>
						</div>
						<!-- /.tab-pane -->
					</div>
					<!-- /.tab-content -->
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<a id="btnSubmitAjax" href="#" class="btn btn-primary pull-right edit-mode">Save Document</a>
					<a id="btnNewDoc" href="#" class="btn btn-primary pull-right" style="margin-right:10px">New Doc</a>
				</div>
				<!-- /.box-footer -->		
			</form>
		</div>
	</div>
</div>

<div id="mdlDocList" class="modal fadein" role="dialog" style="display: none">
	<div class="modal-dialog" style="display:table;width:90%;min-width:700px;max-width:100%">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title"><?=lang("Add Document")?></h4>
			</div>

			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<form>	
							<input type="hidden" id="fin-detail-id" value="0">
							<div class="form-group">						
								<label for="select-product" class="col-md-10 control-label text-right">Search By</label>
								<div class="col-md-2 text-right" style="padding:0px;margin-bottom:10px">
									<select class="select2" style="width:100%" id="doc-search-by"  data-minimumResultsForSearch = 'Infinity' >
										<option value="fst_search_marks">Search mark</option>
										<option value="fst_memo">Notes</option>
									</select>														
								</div>						
								
							</div>
						</form>
					</div>
				</div>
				<div class="row">
				
					<div class="col-md-12">
						
						<table id="tbl_search_doc_list"  class="table table-bordered table-hover" style="width:100%"></table>
										
					</div>
						
				</div>	
			</div>
			<div class="modal-footer">
				<button id="btn-add-product-detail" type="button" class="btn btn-primary">Add</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
	
	<script type="text/javascript">
		$(function(){
			
			$("#btn-open-list-doc").click(function(event){
				event.preventDefault();
				$("#mdlDocList").modal('show');
			});			
			$("#tbl_doc_items").DataTable({
				searching: false,
				paging:   false,
				info: false,				
				columns:[										
					{"title" : "<?= lang("ID") ?>","width": "5%",data:"fin_id",visible:false},
					{"title" : "<?= lang("Document Name") ?>","width": "25%",data:"fin_document_id",visible:true,
						render:function(data,type,row){
							//console.log(row);
							return row.fst_name;
						}
					},
					{"title" : "<?= lang("Source") ?>","width": "10%",data:"fst_source",visible:true,
						render: function(data,type,row){
							if(data == "INT"){
								return "INTERNAL";
							}else{
								return "EXTERNAL";
							}
						}
					},
					{"title" : "<?= lang("Notes") ?>","width": "25%",data:"fst_memo"},
					{"title" : "<?= lang("Create By") ?>","width": "15%",data:"fin_insert_id",
						render : function(data,type,row){
							return row.fst_username;
						}
					},
					{"title" : "<?= lang("Create Date") ?>","width": "15%",data:"fdt_insert_datetime"},
					{"title" : "<?= lang("Action") ?>","width": "10%",
						render:function(data,type,row){	
							action = "<a class='btn-delete-document-items edit-mode' href='#'><i class='fa fa-trash'></i></a>&nbsp;";
							action += "<a class='btn-view-document-items' href='#'><i class='fa fa-folder-open' aria-hidden='true'></i></a>"; 					
							return action;
						},
						"sortable": false,
						"className":"dt-body-center text-center"
					}					  
				],
			});

			$("#tbl_search_doc_list").on('preXhr.dt', function ( e, settings, data ) {
        		data.optionSearch = $('#doc-search-by').val();
    		} ).DataTable({
				ajax: {
					url: '<?= base_url() ?>document/fetch_list_data',
					//dataSrc: 'data'
					dataSrc: function(json){
						console.log(json.data);
						data = [];
						$.each(json.data,function(index,value){
							value.fbl_check = 1;
							data.push(value);
						});
						return data;
					}
				},
				processing: true,
				serverSide: true,
				select: {
					'style': 'multi'
				},
				order: [[1, 'asc']],
				columns:[
					{
						width: "10%",
						checkboxes : {
							'selectRow': true
						},
						data:"fbl_check",						
					},									
					{"title" : "<?= lang("ID") ?>","width": "5%",data:"fin_document_id",visible:true},
					{"title" : "<?= lang("Document Name") ?>","width": "25%",data:"fst_name",visible:true},
					{"title" : "<?= lang("Source") ?>","width": "10%",data:"fst_source",visible:true},
					{"title" : "<?= lang("Notes") ?>","width": "20%",data:"fst_memo"},
					{"title" : "<?= lang("Create By") ?>","width": "15%",data:"fin_insert_id",
						render : function(data,type,row){
							return row.fst_username;
						}
					},
					{"title" : "<?= lang("Create Date") ?>","width": "15%",data:"fdt_insert_datetime"},
					{"title" : "<?= lang("Action") ?>","width": "10%",
						render:function(data,type,row){							
							return "<a class='btn-add-document-items' href='#'><i class='fa fa-plus'></i></a> <a class='btn-add-document-items' href='#'><i class='fa fa-folder-open' aria-hidden='true'></i></a>";
						},
						"sortable": false,
						"className":"dt-center"
					}					  
				]				
			});

			$("#btn-add-product-detail").click(function(event){
				event.preventDefault();
				t = $("#tbl_search_doc_list").DataTable();
				//console.log(t.rows('.selected').data());

				//arrData = [];
				var t2 = $("#tbl_doc_items").DataTable();

				$.each(t.rows('.selected').data(),function(i,v){
					
					v.fin_id =0;
					//arrData.push(v);
					t2.row.add(v);	
				});
				t2.draw();
			});


			$('#tbl_doc_items').on('click','.btn-delete-document-items',function(event){
				event.preventDefault();
				var t = $('#tbl_doc_items').DataTable();
				var trRow = $(this).parents('tr');
				t.row(trRow).remove().draw();
								
			});

			$(document).on('click','.btn-add-document-items', function(event){
				event.preventDefault();
				var t = $('#tbl_search_doc_list').DataTable();
				var trRow = $(this).parents('tr');
				selectedData = t.row(trRow).data();
				selectedData.fin_id = 0;
				console.log(selectedData);

				var t2 = $("#tbl_doc_items").DataTable();
				t2.row.add(selectedData).draw();
				//t.row(trRow).remove().draw();
			});

		});
	</script>
</div>

<div id="mdlFlowControl" class="modal fade in" role="dialog" style="display: none">
	<div class="modal-dialog" style="display:table;width:35%;min-width:350px;max-width:100%">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title"><?=lang("Add Flow Control User")?></h4>
			</div>

			<div class="modal-body">
				<form class="form-horizontal ">	
					<div class="form-group">						
						<label for="fin-flow-control-user" class="col-md-3 control-label"><?= lang("User")?></label>
						<div class="col-md-9">
							<select class="select2 form-control" id="fin-flow-control-user" style="width:100%"></select>
						</div>											
					</div>
					<div class="form-group">						
						<label for="fst-flow-control-order" class="col-md-3 control-label"><?= lang("Order")?> </label>
						<div class="col-md-9">							
							<input type="TEXT" class="form-control inputmask" id="fin-flow-control-order" value="1" data-inputmask="'alias': 'numeric'" im-insert="true" style="text-align: right;" />
						</div>											
					</div>
				</form>				
			</div>
			<div class="modal-footer">
				<button id="btn-add-flow-control-user" type="button" class="btn btn-primary">Add</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
	
	<script type="text/javascript">
		var tblFlowControl;

		function getControlStatus(fin_document_id,fin_seq_no){
			if (fin_seq_no == 1){
				return "RA";
			}

			if (fin_document_id == ""){ //New Document
				controlStatus = (fin_seq_no == 1) ? "RA" : "NA";
				return controlStatus;
			}
			
			//cek ajax to get control Status		
			t = $("#tbl_flow_control").DataTable();
			data = t.rows().data();
			console.log(data);
			var readyToApproveLevel = 0;
			$.each(data,function (i,row){
				if (row.fst_control_status == "RA"){
					readyToApproveLevel = parseInt(row.fin_seq_no);
				}
			});

			if (readyToApproveLevel == 0 ){
				return "RA";
			}

			if (readyToApproveLevel >= parseInt(fin_seq_no) ){
				return "RA";
			}else{
				return "NA";
			}


		}

		$(function(){
			// Fill Flow Control select2
			$.ajax({
				url: '{base_url}flow_schema/getFlow/{active_user_id}',
				dataType : "json",
				method :"GET",
				success:function(resp){
					respData = resp.data;
					selectData = [];
					$.each(respData,function(index,value){
						selectData.push({
							"id" : value.fin_flow_control_schema_id,
							"text" : value.fst_name
						});	
					});
					$("#select-flow-control").select2({
						data: selectData,
					});
					$(".select2-container").addClass("form-control"); 

				}
			});
			
			fill_selec2_users("fin-flow-control-user");

			$(".inputmask").inputmask();

			$("#btn-add-flow-control-user").click(function(){
				selectedUser = $('#fin-flow-control-user').select2('data')[0];				
				tblFlowControl = $("#tbl_flow_control").DataTable();

				data = {
					fin_id : 0,
					fin_user_id : selectedUser.id,
					fst_username : selectedUser.text,
					fin_seq_no : $("#fin-flow-control-order").val(),
					fst_control_status: getControlStatus(  $("#fin_document_id").val() , $("#fin-flow-control-order").val() ),
					fst_memo:'',
					fdt_approved_datetime:null
				}
				tblFlowControl.row.add(data).order([2,'asc'],[1,'asc']).draw();
			});

			$("#btn-open-flow-doc").click(function(event){
				event.preventDefault();
				$("#mdlFlowControl").modal('show');
			});	

			//datatables Flow Control init
			tblFlowControl = $("#tbl_flow_control").DataTable({
				searching: false,
				paging:   false,
				info: false,
				columns:[
					{"title" : "<?= lang("ID") ?>","width": "0%",data:"fin_id",visible:false},
					{"title" : "<?= lang("User") ?>","width": "20%",data:"fin_user_id",
						visible:true,
						render: function ( data, type, row ) {
							return row.fst_username;
						}
					},
					{"title" : "<?= lang("Order") ?>","width": "5%",data:"fin_seq_no"},
					{"title" : "<?= lang("Status") ?>","width": "20%",data:"fst_control_status",
						render:function(data,type,row){
							switch (data){
								case "NA" :
									return "Need Approval";
								case "RA" :
									return "Ready To Approve";
								case "NR" :
									return "Need Revision";
								case "AP" :
									return "Approved";
								case "RJ" :
									return "Rejected";

							}
						}
					},
					{"title" : "<?= lang("Memo") ?>","width": "35%",data:"fst_memo"},
					{"title" : "<?= lang("approved") ?>","width": "10%",data:"fdt_approved_datetime"},
					{"title" : "<?= lang("Action") ?>","width": "10%",data:"action",
						render: function ( data, type, row ) {
							if (row.fst_control_status == "NA" || row.fst_control_status == "RA" ){
								return "<a class='btn-delete-flow-detail' href='#'><i class='fa fa-trash'></i></a>";
							}
							return "";						
						},
						"sortable": false,
						"className":"dt-body-center text-center edit-mode"
					},
				],
			});

			//apply flow
			$("#btn-apply-flow").click(function(event){
				event.preventDefault();
				var table = $('#tbl_flow_control').DataTable();
				dataFlow = table.rows().data();
				exitNow = false;

				$.each(dataFlow,function(i,v){
					if(v.fst_control_status == "AP"){
						alert("Data already to approved, you can not apply new schema !");
						exitNow = true;
						return;
					}
				});
				if (exitNow){
					return;
				}

				$.ajax({
					url: '{base_url}flow_schema/getFlowDetail/' + $("#select-flow-control").val(),
					dataType : "json",
					method :"GET",
					success:function(resp){	
						data = resp.data;
						dataFlow = [];
						$.each(data,function(index,value){
							console.log(value);
							var controlStatus = 'NA';

							if (value.fin_seq_no == 1){
								controlStatus = 'RA';
							}
							dataFlow.push({							
								fin_id: 0,
								fin_user_id: value.fin_user_id,
								fst_username: value.fst_username,
								fin_seq_no: value.fin_seq_no,
								fst_control_status: controlStatus,
								fst_memo:'',
								fdt_approved_datetime:null,
							});
						});
						
						var table = $('#tbl_flow_control').DataTable();
						table.clear();
						table.rows.add(dataFlow).order([2,'asc'],[1,'asc']).draw();
					}
				})

			});

			//delete detail
			$(document).on('click','.btn-delete-flow-detail', function(event){
				event.preventDefault();
				var t = $('#tbl_flow_control').DataTable();
				var trRow = $(this).parents('tr');
				t.row(trRow).remove().draw();
			});



		});
	</script>
</div>


<script src="<?=base_url()?>bower_components/pdfjs/build/pdf.js"></script>
<!-- Select2 -->
<script src="<?=base_url()?>bower_components/select2/dist/js/select2.full.js"></script>
<!-- DataTables -->
<script src="<?=base_url()?>bower_components/datatables.net/datatables.min.js"></script>
<script src="<?=base_url()?>bower_components/datatables.net/dataTables.checkboxes.min.js"></script>

<script type="text/javascript">
	var tblDocIO;
</script>

<script type="text/javascript"> //Custom Scope
    $(function(){
		//$(".select2").select2();
        $(".select2-container").addClass("form-control"); 

		//fill custom branch
		fill_scope_branch();
		
		//Fill custom scope department as default
		fill_scope_department();

		$('#scope-custom-type').on('select2:select', function (e) {
			console.log(e.params);
  			if ($('#scope-custom-type').val() == "DEPARTMENT"){
				fill_scope_department();
			}else{
				fill_selec2_users("scope-custom-value");
			}
		});

		$("#tbl_custom_scope").DataTable({
			searching: false,
			paging:   false,
			info: false,
			columns:[		
				{"title" : "<?= lang("ID") ?>","width": "10%",data:"fin_id",visible:true,className:"dt-center"},
				{"title" : "<?= lang("Branch") ?>","width": "10%",data:"fin_branch_id",visible:true,
					render: function(data,type,row){
						if (row.fin_branch_id ==0 ){
							return "All Branches";
						}
						return row.fst_branch_name;
					},
				},
				{"title" : "<?= lang("Mode") ?>","width": "20%",data:"fst_mode",visible:true},				
				{"title" : "<?= lang("User / Department") ?>","width": "25%",data:"fin_user_department_id",visible:true,
					render: function(data, type, row) {											
						return row.fst_user_department_name;
					},
				},
				{"title" : "<?= lang("View") ?>","width": "10%",data:"fbl_view",
					render: function(data, type, row) {						
						if (data == true) {
							return '<input type="checkbox" class="editor-active" onclick="return false" checked>';
						} else {
							return '<input type="checkbox" class="editor-active">';
						}
						return data;
					},
					className: "dt-body-center text-center",
					"sortable": false,
				},
				{"title" : "<?= lang("Print") ?>","width": "10%",data:"fbl_print",
					render: function(data, type, row) {						
						if (data == true) {
							return '<input type="checkbox" class="editor-active" onclick="return false" checked>';
						} else {
							return '<input type="checkbox" class="editor-active" onclick="return false">';
						}
						return data;
					},
					className: "dt-body-center text-center ",
					"sortable": false,
				},

				{"title" : "<?= lang("Action") ?>","width": "10%",
					render:function(data,type,row){	
						action = "<a class='btn-delete-document-scope' href='#'><i class='fa fa-trash'></i></a>&nbsp;";
						return action;
					},
					"sortable": false,
					"className":"dt-body-center text-center edit-mode"
				}					  
			],
		});

		$("#tbl_custom_scope").on("click",".btn-delete-document-scope",function(event){
			event.preventDefault();
			t = $("#tbl_custom_scope").DataTable();
			var trRow = $(this).parents('tr');
			t.row(trRow).remove().draw();
		});

		$("#btn-custom-scope").click(function(event){
			event.preventDefault();
			data = {
				fbl_check: 1,
				fin_id: 0,
				fin_branch_id: $("#scope-custom-branch").val(),
				fst_branch_name: $("#scope-custom-branch :selected").text(),
				fst_mode: $("#scope-custom-type").val(),
				fin_user_department_id: $("#scope-custom-value").val(),
				fst_user_department_name: $("#scope-custom-value :selected").text(),
				fbl_view: $("#fbl_scope_view").prop("checked"),
				fbl_print:$("#fbl_scope_print").prop("checked")
			}
			t = $("#tbl_custom_scope").DataTable();
			t.row.add(data).draw();
		});

		$(".scope-control").change(function(event){
			event.preventDefault();
			$("#list_scope").hide();

			$(".scope-control").each(function(index){				
				if ($(this).val() == "CST"){
					$("#list_scope").show();
				} 
			});
		});

		$(".scope-control").each(function(index){
			$( this ).change(function(event){
				event.preventDefault();
				console.log($(".scope-control").val());
			});
		});
    });
</script>

<script type="text/javascript" info="document_io">
	$(function(){
		$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
			var target = $(e.target).attr("href") // activated tab
			if (target == "#tab_doc_io"){
				tblDocIO.columns.adjust().draw();		
			}
		});

		tblDocIO = $("#tbl_doc_io").DataTable({
			searching: false,
			paging:   false,
			info: false,
			columns:[		
				{"title" : "id","width": "0%",data:"fin_id",visible:false,className:"dt-center"},
				{"title" : "Date","width": "20%",data:"fdt_io_datetime",visible:true,className:"text-right"},				  
				{"title" : "By","width": "70%",data:"fst_fullname",visible:true,
					render:function(data,type,row){
						var sstr = data ;
						sstr += "<br> <i>Notes:" + row.fst_notes + "</i>";
						return sstr;
					}
				},
				{"title" : "In / Out","width": "10%",data:"fst_io_status"},
				
				
			],
		});
	});
</script>
<script type="text/javascript"> //Document Viewer
	
	function showDocument(viewDoc,printDoc,token){
		//resp.permission.view_doc,resp.permission.print_doc,resp.permission.token
		$("#plugin").attr("src","{base_url}document/getDocument/" + token + "#toolbar=0&navpanes=0");

	}
	$(function(){
		$("#fst_file_name").change(function(event){
			event.preventDefault();
			$("#plugin").attr("src",URL.createObjectURL($("#fst_file_name").get(0).files[0]) + "#toolbar=0&navpanes=0");
			$('.nav-tabs a[href="#doc-viewer"]').tab('show');
		});
	});
</script>

<script type="text/javascript"> // Main
	$(function(){	

		$("#fdt_published_date").datepicker('update', dateFormat("<?= date("Y-m-d")?>"));

		$("#btnSubmitAjax").click(function(event){ //Submit AJAX
			event.preventDefault();
			$(".text-danger").html("");
			data = new FormData($("#frmDocument")[0]);

			//detail Document
			t = $('#tbl_doc_items').DataTable();
			detail = new Array();			
			$.each(t.data(),function(i,v){
				console.log(v);
				detail.push({
					fin_id : v.fin_id,
					fin_document_id : v.fin_document_id
				});
			});
			data.append("detail_doc_items", JSON.stringify(detail));


			//Detail Flow
			detail = new Array();
			if ($("#fbl_flow_control").is(":checked")){
				t = $('#tbl_flow_control').DataTable();
				$.each(t.data(),function(i,v){
					detail.push(v);
				});
			}
			data.append("detail_flow_control", JSON.stringify(detail));
			

			//Scope Permission
			detail = new Array();
			t = $('#tbl_custom_scope').DataTable();
			$.each(t.data(),function(i,v){
				detail.push(v);
			});
			data.append("detail_custom_scope", JSON.stringify(detail));
			//console.log(data);

			if ($("#fin_document_id").val() == ""){
				url =  "<?= site_url() ?>document/ajx_add_save";
			}else{
				url =  "<?= site_url() ?>document/ajx_edit_save";
			}

			App.blockUIOnAjaxRequest("<h5>Save Document....</h5>");
			$.ajax({
				type: "POST",
				enctype: 'multipart/form-data',
				url: url,
				data: data,
				processData: false,
				contentType: false,
				cache: false,
				timeout: 600000,
				success: function (resp) {	
					if (resp.message != "")	{
						$.alert({
							title: 'Message',
							content: resp.message,
							buttons: {
								OK : function () {
									if (resp.status == "SUCCESS"){
            							location.reload();
									}
        						},
							}
						});
					}

					if (typeof resp.debug !== "undefined"){
						$("debug").html(resp.debug);
					}

					if(resp.status == "VALIDATION_FORM_FAILED" ){
						//Show Error
						errors = resp.data;
						for (key in errors) {
							$("#"+key+"_err").html(errors[key]);
						}
					}else if(resp.status == "SUCCESS") {
						data = resp.data;
						$("#fin_document_id").val(data.insert_id);
						//Clear all previous error
						$(".text-danger").html("");
					}
				},
				error: function (e) {
					$("#result").text(e.responseText);
					console.log("ERROR : ", e);
					$("#btnSubmit").prop("disabled", false);
				}
			});
		});

		$("#btnNewDoc").click(function(event){		
			window.location.replace("{base_url}document/add");
		});

		// Document Flow Control Checked
		$('#fbl_flow_control').on('ifChanged', function(event){
			console.log(event);
			//alert(event.type + $('#fbl_flow_control').val() );
			if ($("#fbl_flow_control").is(":checked")){
				$("#list_flow").show();
			}else{
				$("#list_flow").hide();
			};
		});


		$('#plugin').click(function(event) {
			alert("TEST MOUSE");
			event.preventDefault();
		})

		if ($("#fin_document_id").val() != ""){
			init_form();
		}

		$("#btnPrint").click(function(e){
			e.preventDefault();
			window.open("<?= site_url() ?>document/print/" +$("#fin_document_id").val() ,"_blank","menubar=0,resizable=0,scrollbars=0,status=0");
			//alert("PRINT");
		})
	});

	function init_form(){
		//alert("Init Form");
		var url = "{base_url}document/fetch_data/" + $("#fin_document_id").val();
		$.ajax({
			type: "GET",
			url: url,
			success: function (resp) {	

				$.each(resp.header, function(name, val){
					var $el = $('[name="'+name+'"]'),
					type = $el.attr('type');
					switch(type){
						case 'checkbox':
							$el.attr('checked', 'checked');
							break;
						case 'radio':
							$el.filter('[value="'+val+'"]').attr('checked', 'checked');
							break;
						default:
							$el.val(val);
					}
				});


				App.addOptionIfNotExist("<option value='"+ resp.header.fin_document_group_id +"' selected>"+resp.header.fst_group_name +"</option>","fin_document_group_id");
				$("#fin_document_group_id").prop( "disabled", true );
				
				$("#creator_by").text(resp.header.fst_username);

				$("#fst_source").trigger('change');
				$("#fst_view_scope").trigger('change');
				$("#fst_print_scope").trigger('change');
				$("#fin_confidential_lvl").trigger('change');
				$("#fdt_published_date").datepicker('update', dateFormat(resp.header.fdt_published_date));
				$("#fdt_expired_date").datepicker('update', dateFormat(resp.header.fdt_expired_date));

				if (resp.header.fbl_flow_control == 1){
					//alert("check");
					$('#fbl_flow_control').iCheck('check');
					$('#fbl_flow_control').iCheck('update');
					$('#list_flow').show();
					
				}else{
					//alert("uncheck");
					$('#fbl_flow_control').iCheck('uncheck');
				}
				$(".scope-control").each(function( index ) {
					//console.log( index + ": " + $( this ).text() );
					if ($(this).val() == 'CST'){
						$('#list_scope').show();
					}
				});
				
				//Fill Document Detail
				t = $("#tbl_doc_items").DataTable();
				$.each(resp.doc_details,function(i,v){					
					data = {
						fin_id: v.fin_id,
						fin_document_id : v.fin_document_id,
						fst_name: v.fst_name,
						fst_source : v.fst_source,
						fst_memo : v.fst_memo,
						fin_insert_id : v.fin_insert_id,
						fst_username : v.fst_username,
						fdt_insert_datetime : v.fdt_insert_datetime
					};
					
					t.row.add(data).draw();
				});
				
				//Fill Document Flow
				t = $("#tbl_flow_control").DataTable();
				$.each(resp.flow_details,function(i,v){
					data = {
						fin_id:v.fin_id,
						fin_user_id:v.fin_user_id,
						fst_username: v.fst_username,
						fin_seq_no: v.fin_seq_no,
						fst_control_status :v.fst_control_status,
						fdt_approved_datetime :v.fdt_approved_datetime,
						fst_memo : v.fst_memo
					}
					t.row.add(data);
				});
				t.draw();
				
				//Fill custom scope
				t = $("#tbl_custom_scope").DataTable();
				$.each(resp.custom_details,function(i,v){
					data = {
						fin_id:v.fin_id,
						fst_mode:v.fst_mode,
						fin_user_department_id: v.fin_user_department_id,
						fst_user_department_name:v.fst_user_department_name,
						fin_branch_id: v.fin_branch_id,
						fst_branch_name: v.fst_branch_name,
						fbl_view:v.fbl_view,
						fbl_print:v.fbl_print

					}
					
					t.row.add(data);
				});
				t.draw();
				
				//Fill History IO
				$.each(resp.io_details,function(i,v){					
					data = {
						fin_id: v.fin_id,
						fst_io_status:v.fst_io_status,
						fst_fullname: v.fst_fullname,
						fst_notes : v.fst_notes,
						fdt_io_datetime : v.fdt_io_datetime
					};					
					tblDocIO.row.add(data).draw();
				});


				// Show document 
				showDocument(resp.permission.view_doc,resp.permission.print_doc,resp.permission.token);


				//Hiden Button Save when no edit permition
				if (resp.permission.edit == true){
					$(".edit-mode").show();
				}else{
					$(".edit-mode").hide();
				}
			},

			error: function (e) {
				$("#result").text(e.responseText);
				console.log("ERROR : ", e);
			}
		});
	}

	function fill_selec2_users(element_id){
		$.ajax({
			url: '{base_url}user/getAllList',
			dataType : "json",
			method :"GET",
			success:function(resp){
				respData = resp.data;
				selectData = [];
				$.each(respData,function(index,value){
					selectData.push({
						"id" : value.fin_user_id,
						//"text" : "<span style='display:inline-block;width:100px'>" + value.fst_username + "</span><span style='display:inline-block;width:200px'>" + value.fst_fullname + "</span>" 
						"text" :  value.fst_fullname + " - " + value.fst_department_name
					});	
				});
				$('#' + element_id).empty();
				$('#' + element_id).val(null).trigger('change');
				$("#" + element_id).select2({
					data: selectData,
				});
				$("#" + element_id).select2();
				$(".select2-container").addClass("form-control"); 
			}
		})
	}
	function fill_scope_department(){
		$.ajax({
			url: '{base_url}department/getAllList',
			dataType : "json",
			method :"GET",
			success:function(resp){
				respData = resp.data;
				selectData = [];
				$.each(respData,function(index,value){
					selectData.push({
						"id" : value.fin_department_id,
						"text" : value.fst_department_name
					});	
				});
				//$("#scope-custom-value").select2("destroy");
				$('#scope-custom-value').empty();
				$('#scope-custom-value').val(null).trigger('change');
				$("#scope-custom-value").select2({
					data: selectData,
				});
				console.log(selectData);
				$(".select2-container").addClass("form-control"); 
			}
		})
	}

	function fill_scope_branch(){
		$.ajax({
			url: '{base_url}branch/getAllList',
			dataType : "json",
			method :"GET",
			success:function(resp){
				respData = resp.data;
				selectData = [];

				selectData.push({
					"id" : 0,
					"text" : "All Branch"
				});	

				$.each(respData,function(index,value){
					selectData.push({
						"id" : value.fin_branch_id,
						"text" : value.fst_branch_name
					});	
				});
				
				$('#scope-custom-branch').empty();
				$('#scope-custom-branch').val(null).trigger('change');
				$("#scope-custom-branch").select2({
					data: selectData,
				});
				console.log(selectData);
				$(".select2-container").addClass("form-control"); 
			}
		})
	}
	
</script>

<script type="text/javascript" info="Main-event"> // Main
	$(function(){
		$("#fin_document_group_id").val(null);

		$("#fin_document_group_id").change(function(e){
			//Get Document No
			$.ajax({
				url:"{base_url}document/ajxGetNoDoc/" +$ ("#fin_document_group_id").val(),
				method:"GET",
			}).done(function(resp){
				if (resp.status =="SUCCESS"){
					$("#fst_document_no").val(resp.data);
				}				
			})
		});
	});
</script>