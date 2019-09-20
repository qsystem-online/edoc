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
	.form-group {
    	margin-bottom: 5px;
	}
	
	
</style>

<section class="content-header">
	 <h1>&nbsp;</h1>
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
			</div>
			<!-- /.box-header -->
			
			
				<div class="box-body">
					
					<hr>	
					<!-- form start -->
					<form id="" class="form-horizontal" action="<?=site_url()?>system/user/add" method="POST" enctype="multipart/form-data">
					
						<div class="nav-tabs-custom" style="display:unset">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#doc_info" data-toggle="tab" aria-expanded="true"><?= lang("Document Info")?></a></li>
								<li class=""><a href="#doc_list" data-toggle="tab" aria-expanded="true"><?= lang("Document List")?></a></li>
								<li class="" id="list_flow" style="display:unset;"><a href="#tab_flow" data-toggle="tab" aria-expanded="false"><?= lang("Flow Control")?></a></li>
								<li class="" id="list_scope" style="display:unset;"><a href="#tab_custom-scope" data-toggle="tab" aria-expanded="false"><?= lang("Custom Scope")?></a></li>
								<li class="doc-viewer" id="tab-doc" ><a href="#doc-viewer" data-toggle="tab" aria-expanded="false"><?= lang("Document Viewer")?></a></li>
							</ul>
							<div class="tab-content">							
								<div class="tab-pane active" id="doc_info">								
									<div class="form-group">
										<label for="fin_document_id" class="col-sm-2 control-label"><?=lang("Document ID")?> :</label>
										<div class="col-sm-10">
											<label for="fin_document_id" class="control-label">{fin_document_id}</label>							
										</div>
									</div>

									<div class="form-group">
										<label for="fst_name" class="col-sm-2 control-label"><?= lang("Name") ?> :</label>
										<div class="col-sm-10">
											<label id="fst_name" class="control-label"><?= lang("Name") ?></label>							
										</div>
									</div>
									<div class="form-group">
										<label for="fst_source" class="col-sm-2 control-label"><?=lang("Document Source")?> :</label>
										<div class="col-sm-3">
											<label id="fst_source" class="control-label"><?=lang("Document Source")?></label>
										</div>

										<label for="fin_confidential_lvl" class="col-sm-2 control-label"><?=lang("Confidential Level")?> :</label>
										<div class="col-sm-3">
											<label id="fin_confidential_lvl" class="control-label"><?=lang("Confidential Level")?></label>
										</div>

									</div>
									<div class="form-group">
										<label for="fst_view_scope" class="col-sm-2 control-label"><?=lang("View Scope")?> :</label>
										<div class="col-sm-3">
											<label id="fst_view_scope" class="scope control-label"><?=lang("View Scope")?></label>
										</div>
										<label for="fst_print_scope" class="col-sm-2 control-label"><?=lang("Print Scope")?> :</label>
										<div class="col-sm-3">
											<label id="fst_print_scope" class="scope control-label"><?=lang("Print Scope")?></label>
										</div>
									</div>

									<div class="form-group">
										<label for="fst_search_marks" class="col-sm-2 control-label"><?= lang("Search Keyword")?> :</label>
										<div class="col-sm-10">
											<label id="fst_search_marks" class="control-label"><?= lang("Search Keyword")?> </label>
										</div>
									</div>

									<div class="form-group">
										<label for="fst_memo" class="col-sm-2 control-label"><?= lang("Notes / Memo")?> :</label>
										<div class="col-sm-10">
											<label id="fst_memo" class="control-label"><?= lang("Notes / Memo")?> </label>
										</div>
									</div>

									<div class="form-group">
										<label for="fdt_published_date" class="col-sm-2 control-label"><?= lang("Publish Date")?> :</label>
										<div class="col-sm-3">
											<label id="fdt_published_date" class=" control-label"><?= lang("Publish Date")?></label>
										</div>
									</div>

									<div class="form-group">
										<label for="fbl_flow_control" class="col-sm-2 control-label"><?= lang("Document Flow Control") ?> :</label>
										<div class="col-sm-3">
											<label id="fbl_flow_control" class=" control-label">True</label>
										</div>
									</div>

									<div class="form-group">
										<label for="creator_by" class="col-sm-2 control-label"><?=lang("Creator")?> : </label>
										<div class="col-sm-3">
											<label id="fst_username" class=" control-label">
												<?php
													$user = $this->aauth->user();
													echo $user->fst_username;
												?>
											</label>
										</div>
									</div>
								</div>
								<div class="tab-pane" id="doc_list">
									<table id="tbl_doc_items" class="table table-bordered table-hover" style="width:100%;"></table>
								</div>
								<!-- /.tab-pane -->
								<div class="tab-pane" id="tab_flow">
									<table id="tbl_flow_control" class="compat hover stripe" style="width:100%" ></table>								
								</div>
								<!-- /.tab-pane -->
								<div class="tab-pane" id="tab_custom-scope">
									<table id="tbl_custom_scope" class="compat hover stripe" style="width:100%" ></table>
								</div>
								<div class="tab-pane doc-viewer" id="doc-viewer" style="text-align:center">
									<iframe id="docViewer" src="" style="width:100%;overflow:scroll;"></iframe>
								</div>
							</div>				
							<!-- /.tab-pane -->
							<!-- /.tab-content -->
						</div>
					</form>		
				</div>				
				<!-- /.box-body -->

				<div class="box-footer">
					<hr style="border:2px solid #3c8dbc">

					<form id="frmApproval" class="form-horizontal" action="" method="POST">

						<input type="hidden" id="fin_document_flow_control_id" name="fin_id" value={fin_document_flow_control_id} readonly/>
						<input type="hidden" name = "<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">

						<div class="form-group">							
							<label for="fbl_flow_control" class="col-sm-2 control-label"><?= lang("Document Flow Control") ?> :</label>
							<div class="col-sm-10">
								<select id="frm_fst_control_status" class="form-control" name="fst_control_status">								
									<option value="AP">Approved</option>
									<option value="NR">Need Revision</option>
									<option value="RJ">Rejected</option>
								</select>
								<div id="frm_fst_control_status_err" class="text-danger"></div>
							</div>

						</div>
						<div class="form-group">
							<label for="fbl_flow_control" class="col-sm-2 control-label"><?= lang("Memo") ?> :</label>
							<div class="col-sm-10">
								<textarea id="frm_fst_memo" class="col-sm-12 form-control" name="fst_memo"></textarea>
							</div>
						</div>
						<div class="form-group">							
							<div class="col-sm-3 col-sm-offset-2">
								<a id="btnSubmit" href="#" class="btn btn-primary"><?= lang("Save") ?></a>
							</div>
						</div>
					</form>					
				</div>
				<!-- /.box-footer -->						
			
		</div>
	</div>
</div>


<script type="text/javascript"> //Document Details
	$(function(){			
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
						action = "";
						if (row.view_doc == true){
							action = "<a class='btn-view-document-items' href='#'><i class='fa fa-search' aria-hidden='true'></i></a>"; 					
						}

						return action;
					},
					"sortable": false,
					"className":"dt-body-center text-center"
				}					  
			],
		});
		$("#tbl_doc_items").on("click",".btn-view-document-items",function(event){
			event.preventDefault();
			var t = $('#tbl_doc_items').DataTable();
			var trRow = $(this).parents('tr');
			dataRow = t.row(trRow).data();
			url = "{base_url}document/displayDocument/" + dataRow.fin_document_id;
			var win = window.open(url, '_blank');
  			win.focus();
		});
	});
</script>


<script type="text/javascript"> //Flow Control
	var tblFlowControl;
	$(function(){
		$(".inputmask").inputmask();

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
				{"title" : "<?= lang("Status") ?>","width": "10%",data:"fst_control_status",
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
				{"title" : "<?= lang("Memo") ?>","width": "45%",data:"fst_memo"},
				{"title" : "<?= lang("approved") ?>","width": "10%",data:"fdt_approved_datetime",
					"className":"dt-body-right text-right"
				},				
			],
		});
	});
</script>


<script src="<?=base_url()?>bower_components/pdfjs/build/pdf.js"></script>
<!-- Select2 -->
<script src="<?=base_url()?>bower_components/select2/dist/js/select2.full.js"></script>
<!-- DataTables -->
<script src="<?=base_url()?>bower_components/datatables.net/datatables.min.js"></script>
<script src="<?=base_url()?>bower_components/datatables.net/dataTables.checkboxes.min.js"></script>


<script type="text/javascript"> //Custom Scope
    $(function(){
		//$(".select2").select2();
        $(".select2-container").addClass("form-control"); 
		
		$("#tbl_custom_scope").DataTable({
			searching: false,
			paging:   false,
			info: false,
			columns:[		
				{"title" : "<?= lang("ID") ?>","width": "10%",data:"fin_id",visible:true,className:"dt-center"},
				{"title" : "<?= lang("Mode") ?>","width": "10%",data:"fst_mode",visible:true},				
				{"title" : "<?= lang("User / Department") ?>","width": "55%",data:"fin_user_department_id",visible:true,
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

<script type="text/javascript"> //Document Viewer
	$(function(){
		$('#docViewer').on("load", function() {
			$('#docViewer').height(800);
			//var iframe = document.getElementById("docViewer");
    		//var doc = iframe.contentDocument;
    		//alert($(doc).find("body").height());
		});		
	});
</script>

<script type="text/javascript"> // Main
	$(function(){			
		init_form();

		$("#btnSubmit").click(function(event){			
			event.preventDefault();
			dataPost = $("#frmApproval").serializeArray();
			$.ajax({
				url:"{base_url}document/do_approval_flow_control",
				data:dataPost,
				type:"POST",
				success: function (resp) {	
					if (resp.message != "")	{
						$.alert({
							title: 'Message',
							content: resp.message,
							buttons: {
								OK : function () {
									if (resp.status == "SUCCESS"){
										window.location ="<?= base_url() ?>document/approval_list";
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
			})
			
		})
	});

	function init_form(){
		//alert("Init Form");

		var url = "{base_url}document/fetch_data/{fin_document_id}";
		$.ajax({
			type: "GET",
			url: url,
			success: function (resp) {				
				$.each(resp.header, function(name, val){
					$("#" + name).html(val);
				});

				$("#fst_source").html( ($("#fst_source").html() == "INT") ? "Internal" : "Eksternal");
				
				switch($("#fin_confidential_lvl").text()) {
					//0=Top management, 1=Upper management, 2=Middle management, 3=Supervisors, 4=Line workers, 5=public
					case "0":
						$("#fin_confidential_lvl").html("Top Management");
						break;
					case "1":
						$("#fin_confidential_lvl").html("Upper Management");
						break;
					case "2":
						$("#fin_confidential_lvl").html("Middle Management");
						break;
					case "3":
						$("#fin_confidential_lvl").html("Supervisor");
						break;
					case "4":
						$("#fin_confidential_lvl").html("Line Workers");
						break;
					case "5":
						$("#fin_confidential_lvl").html("Public");
						break;					
					default:
						$("#fin_confidential_lvl").html("");
				}

				//$("#fst_view_scope").html()
				$(".scope").each(function(index){
					switch ($(this).text()){
						case "PRV":
							$(this).html("Private");
							break;						
						case "GBL":
							$(this).html("Global");
							break;
						case "CST":
							$(this).html("Custom");
							break;						
					}
				});

				$("#fdt_published_date").html(dateFormat(resp.header.fdt_published_date));
				$('#fbl_flow_control').html(resp.header.fbl_flow_control == 1 ? "TRUE" : "FALSE");
				
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
						fdt_insert_datetime : v.fdt_insert_datetime,
						view_doc : v.view_doc
					};
					
					t.row.add(data).draw();
				})
				
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
					console.log(data);
					t.row.add(data);

					if (v.fin_id == $("#fin_document_flow_control_id").val()){
						$("#frm_fst_control_status").val(v.fst_control_status);
						$("#frm_fst_memo").val(v.fst_memo);
						if (v.isEditable == false){
							$("#btnSubmit").hide();
							//$("#frm_fst_memo").attr('readonly', true);
							//$("#frm_fst_control_status").prop('disabled', true);
						}
					}
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
						fbl_view:v.fbl_view,
						fbl_print:v.fbl_print

					}
					t.row.add(data);
				});
				t.draw();
				
				// Show document 
				if (resp.permission.view_doc){
					$("#docViewer").attr("src","{base_url}document/displayDocument/{fin_document_id}");
				}
				
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

</script>
