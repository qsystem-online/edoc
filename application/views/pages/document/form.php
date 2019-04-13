<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link rel="stylesheet" href="<?=base_url()?>bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?=base_url()?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">




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
		<li><a href="#"><?= lang("Document") ?></a></li>
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
			<!-- form start -->
			<form id="frmUser" class="form-horizontal" action="<?=site_url()?>system/user/add" method="POST" enctype="multipart/form-data">
				

				<div class="box-body">
					<input type="hidden" name = "<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">
                    <input type="hidden" id="fin_id" name = "fin_id" value="<?=$fin_id?>">
                    <input type="hidden" id="frm-mode" value="<?=$mode?>">
                    <div class="form-group">
						<label for="fin_document_id" class="col-sm-2 control-label"><?=lang("Document ID")?></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="fin_document_id" placeholder="<?=lang("(Autonumber)")?>" name="fin_document_id" value="">
							<div id="fin_document_id_err" class="text-danger"></div>
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
							<select class="select2 form-control" id="fst_source" name="fst_source">
								<option value='INT'><?= lang("Internal")?></option>
								<option value='EXT'><?= lang("External")?></option>
							</select>
						</div>

                        <label for="fin_confidential_lvl" class="col-sm-2 control-label"><?=lang("Confidential Level")?></label>
						<div class="col-sm-3">
							<select class="select2 form-control" id="fst_source" name="fst_source">
								<option value='0'><?= lang("Top Management")?></option>
								<option value='1'><?= lang("Upper Management")?></option>
                                <option value='2'><?= lang("Middle Management")?></option>
                                <option value='3'><?= lang("Supervisors")?></option>
                                <option value='4'><?= lang("Line Workers")?></option>
                                <option value='5'><?= lang("Public")?></option>
							</select>
						</div>

					</div>
                    <div class="form-group">
						<label for="fst_view_scope" class="col-sm-2 control-label"><?=lang("View Scope")?></label>
						<div class="col-sm-3">
							<select class="select2 form-control" id="fst_view_scope" name="fst_view_scope">
								<option value='PRV'><?= lang("Private")?></option>
								<option value='GBL'><?= lang("Global")?></option>
                                <option value='CST'><?= lang("Custom")?></option>
							</select>
						</div>
                        <label for="fst_print_scope" class="col-sm-2 control-label"><?=lang("Print Scope")?></label>
						<div class="col-sm-3">
							<select class="select2 form-control" id="fst_print_scope" name="fst_print_scope">
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
					</div>

					<div class="form-group">
						<label for="fst_file_name" class="col-sm-2 control-label"><?= lang("File Document")?></label>
						<div class="col-sm-10">
							<input type="file" class="form-control" id="fst_file_name"  name="fst_file_name" accept="application/pdf">
						</div>
					</div>
					<div class="form-group">						
						<div class="col-sm-10 col-sm-offset-2">
							<input type="checkbox" class="minimal form-control" id="fbl_flow_control" name="fbl_flow_control"> &nbsp;
							<label for="fbl_flow_control" class="control-label"> <?= lang("Document Flow Control")?> </label>
						</div>
					</div>
					<hr>
					<?php $displayDetail = ($mode == "ADD") ? "none" : "" ?>
					<div id="tabs-user-detail" class="nav-tabs-custom" style="display:unset">
						<ul class="nav nav-tabs">
							<li class=""><a href="#doc_list" data-toggle="tab" aria-expanded="true"><?= lang("Document List")?></a></li>
                            <li class="active" id="list_flow" style="display:unset;"><a href="#tab_flow" data-toggle="tab" aria-expanded="false"><?= lang("Flow Control")?></a></li>
							<li class=""><a href="#tab_custom-scope" data-toggle="tab" aria-expanded="false"><?= lang("Custom Scope")?></a></li>
							<li class=""><a href="#doc-viwer" data-toggle="tab" aria-expanded="false"><?= lang("Document Viewer")?></a></li>
						</ul>
						<div class="tab-content">							
							<div class="tab-pane " id="doc_list">
								<button class="btn btn-primary btn-sm"><i class="fa fa-plus"></i><?= lang("Add Document")?></button>
								<table id="tbl_doc_list"></table>
							</div>
							<!-- /.tab-pane -->
							<div class="tab-pane active" id="tab_flow">
								<form class="form-horizontal ">	
									<div class="form-group">						
										<label for="select-product" class="col-md-8 control-label">Flow Control</label>
										<div class="col-md-3">
											<select id="select-flow-control" class="select2 form-control" style="width:100%"></select>
										</div>						
										<div class="col-md-1">
											<button id="btn-apply-flow" class="btn btn-sm btn-primary" style="width:100%">Apply</button>
										</div>															
									</div>
								</form>
								<table id="tbl_flow_control" class="compat hover stripe" style="width:100%" ></table>
								
							</div>
							<!-- /.tab-pane -->
							<div class="tab-pane" id="tab_custom-scope">
								<form class="form-horizontal ">	
									<div class="form-group">						
										<label for="select-product" class="col-md-5 control-label"><?= lang("Permission For :")?></label>
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
										<div class="col-md-1">
											<button class="btn btn-sm btn-primary" style="width:100%"><?=lang("Add")?></button>
										</div>						
									
									</div>
								</form>
								<table id="tbl_flow_control"></table>
							</div>
							<div class="tab-pane" id="doc-viwer" style="text-align:center">
								<!--
								<canvas id="the-canvas" style="border:1px solid #00f;width:50%;display:none"></canvas>
								<object id="obj-plugin" data="" type="application/pdf"></object>
								-->
								<embed id="plugin" src="" type="application/pdf" style="width:100%;height:25vw" internalinstanceid="5" />
							</div>
						</div>
						<!-- /.tab-pane -->
					</div>
					<!-- /.tab-content -->
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<a id="btnSubmitAjax" href="#" class="btn btn-primary">Save Ajax</a>
				</div>
				<!-- /.box-footer -->		
			</form>
		</div>
	</div>
</div>

<div id="mdlDocList" class="modala fadea" role="dialog" style="display: unset">
	<div class="modal-dialog" style="display:table;width:80%;min-width:700px;max-width:100%">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title"><?=lang("Add Document")?></h4>
			</div>

			<div class="modal-body">
				<form class="form-horizontal ">	
					<input type="hidden" id="fin-detail-id" value="0">
					<div class="form-group">						
						<label for="select-product" class="col-md-9 control-label">Search By</label>
						<div class="col-md-3">
							<select class="select2 col-md-12" >
								<option>Search mark</option>
								<option>Notes</option>
							</select>														
						</div>						
					
					</div>
				</form>

				<div class="col-md-12">
					<div class="row">
						<table id="tbl_search_doc_list"  class="display compact"></table>
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
			$("#tbl_search_doc_list").DataTable({
				columns:[
					{"title" : "<?= lang("ID") ?>","width": "5%",data:"fin_id",visible:true},
					{"title" : "<?= lang("Document Name") ?>","width": "30%",data:"id_product",visible:true},
					{"title" : "<?= lang("Notes") ?>","width": "35%",data:"product_name"},
					{"title" : "<?= lang("Create By") ?>","width": "15%",data:"fin_qty"},
					{"title" : "<?= lang("Create Date") ?>","width": "15%",data:"fin_qty"}					  
				],
			});
		});
	</script>
</div>
<script src="<?=base_url()?>bower_components/pdfjs/build/pdf.js"></script>





<!-- Select2 -->
<script src="<?=base_url()?>bower_components/select2/dist/js/select2.full.js"></script>
<!-- DataTables -->
<script src="<?=base_url()?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>


<script type="text/javascript">
	
	$(function(){
		// Fill Flow Control
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

		//datatables Flow Control init
		$("#tbl_flow_control").DataTable({
			searching: false,
			paging:   false,
			info: false,
			columns:[
				{"title" : "<?= lang("ID") ?>","width": "5%",data:"fin_id",visible:true},
				{"title" : "<?= lang("User ID") ?>","width": "0%",data:"fin_user_id",visible:false},
				{"title" : "<?= lang("Name") ?>","width": "25%",data:"fin_username",visible:true},
				{"title" : "<?= lang("Order") ?>","width": "10%",data:"fin_seq_no"},
				{"title" : "<?= lang("Status") ?>","width": "20%",data:"fst_control_status",
					visible:true,
					render: function ( data, type, row ) {
						return data +' ('+ row[3]+')';
					}
				},
				{"title" : "<?= lang("Memo") ?>","width": "40%",data:"fst_memo"}					  
			],
		});

		//apply flow
		$("#btn-apply-flow").click(function(event){
			event.preventDefault();
			$.ajax({
				url: '{base_url}flow_schema/getDetailFlow/' + $("#select-flow-control").val(),
				dataType : "json",
				method :"GET",
				success:function(resp){				
				}
			})
		})

		//iCheck for checkbox and radio inputs
		$('#fbl_flow_control').iCheck({
			checkboxClass: 'icheckbox_minimal-blue',
			radioClass   : 'iradio_minimal-blue'
		})

		$('#fbl_flow_control').on('ifChanged', function(event){
			console.log(event);
			//alert(event.type + $('#fbl_flow_control').val() );
			if ($("#fbl_flow_control").is(":checked")){
				$("#list_flow").show();
			}else{
				$("#list_flow").hide();
			};
		});
	})
</script>

<script type="text/javascript">
	//Custom Scope
    $(function(){
		//$(".select2").select2();
        $(".select2-container").addClass("form-control"); 

		//Fill custom scope department as default
		fill_scope_department();

		$('#scope-custom-type').on('select2:select', function (e) {
			console.log(e.params);
  			if ($('#scope-custom-type').val() == "DEPARTMENT"){
				fill_scope_department();
			}else{
				fill_scope_users();
			}
		});	
    });

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
	function fill_scope_users(){
		$.ajax({
			url: '{base_url}users/getAllList',
			dataType : "json",
			method :"GET",
			success:function(resp){
				respData = resp.data;
				selectData = [];
				$.each(respData,function(index,value){
					selectData.push({
						"id" : value.fin_user_id,
						"text" : value.fst_username
					});	
				});
				$('#scope-custom-value').empty();
				$('#scope-custom-value').val(null).trigger('change');
				$("#scope-custom-value").select2({
					data: selectData,
				});
				$("#scope-custom-value").select2();
				console.log(selectData);
				$(".select2-container").addClass("form-control"); 
			}
		})
	}

</script>

<script type="text/javascript">
	//Document Viewer
	$(function(){
		$("#fst_file_name").change(function(event){
			event.preventDefault();
			//$("#plugin").attr("src",URL.createObjectURL($("#fst_file_name").get(0).files[0]) + "#toolbar=0&navpanes=0");
			$("#plugin").attr("src","http://localhost/edoc/test/get_file#toolbar=0&navpanes=0");
			//$("#plugin").attr("src","http://localhost/edoc/assets/sample/test.pdf");
			//$("#obj-plugin").attr("data",URL.createObjectURL($("#fst_file_name").get(0).files[0]) + "#toolbar=0&navpanes=0");
			
			//var url = 'https://raw.githubusercontent.com/mozilla/pdf.js/ba2edeae/examples/learning/helloworld.pdf';
			var url = URL.createObjectURL($("#fst_file_name").get(0).files[0]);		
			console.log(url);
			var pdfjsLib = window['pdfjs-dist/build/pdf'];
			pdfjsLib.GlobalWorkerOptions.workerSrc = '<?=base_url()?>bower_components/pdfjs/build/pdf.worker.js';
			var loadingTask = pdfjsLib.getDocument(url);
			loadingTask.promise.then(function(pdf) {
				// Fetch the first page
				var pageNumber = 1;
				pdf.getPage(pageNumber).then(function(page) {
					// Prepare canvas using PDF page dimensions
					var canvas = $('#the-canvas').get(0); // document.getElementById('the-canvas');
					var context = canvas.getContext('2d');

					// As the canvas is of a fixed width we need to set the scale of the viewport accordingly
					//var scale_required = canvas.width / page.getViewport(1).width;
					var scale_required =1.5;
					var viewport = page.getViewport(scale_required);

					canvas.width = viewport.width;
					canvas.height = viewport.height;
					

					// Render PDF page into canvas context
					var renderContext = {
						canvasContext: context,
						viewport: viewport
					};
					var renderTask = page.render(renderContext);
					renderTask.promise.then(function () {
						console.log('Page rendered');
						//$("#the-canvas").show();
					});
				});
			}, function (reason) {
				// PDF loading error
				console.error(reason);
			});
		});
	});
</script>

<script type="text/javascript">
	$(function(){				
		<?php if($mode == "EDIT"){?>
			init_form($("#fin_id").val());
		<?php } ?>

		$("#btnSubmitAjax").click(function(event){
			event.preventDefault();
			//data = $("#frmUser").serialize();
			data = new FormData($("#frmUser")[0]);
			//data = new FormData($("form")[0]);

			mode = $("#frm-mode").val();
			if (mode == "ADD"){
				url =  "<?= site_url() ?>system/user/ajx_add_save";
			}else{
				url =  "<?= site_url() ?>system/user/ajx_edit_save";
			}

			//var formData = new FormData($('form')[0])
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
							confirm: function(){
								//alert('the user clicked yes');
							}
						});
					}

					if(resp.status == "VALIDATION_FORM_FAILED" ){
						//Show Error
						errors = resp.data;
						for (key in errors) {
							$("#"+key+"_err").html(errors[key]);
						}
					}else if(resp.status == "SUCCESS") {
						data = resp.data;
						$("#fin_id").val(data.insert_id);

						//Clear all previous error
						$(".text-danger").html("");

						// Change to Edit mode
						$("#frm-mode").val("EDIT");  //ADD|EDIT

						$('#fst_username').prop('readonly', true);
						$("#tabs-user-detail").show();
						console.log(data.data_image);

					}


				},
				error: function (e) {
					$("#result").text(e.responseText);
					console.log("ERROR : ", e);
					$("#btnSubmit").prop("disabled", false);
				}
			});

		});

		$('#plugin').click(function(event) {
			alert("TEST MOUSE");
			event.preventDefault();
		})
		
		
		$(".datepicker").datepicker({
			format:"yyyy-mm-dd"
		});
		
	});

	function init_form(fin_id){
		//alert("Init Form");
		var url = "<?=site_url()?>/system/user/fetch_data/" + fin_id;
		$.ajax({
			type: "GET",
			url: url,
			success: function (resp) {	
				console.log(resp.user);
				console.log(resp.list_address);

				$.each(resp.user, function(name, val){
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

				//Image Load 
				$('#imgAvatar').attr("src",resp.user.avatarURL);


				/*
				imgurl = "<?= site_url()?>assets/app/users/avatar/avatar_" + fin_id +".jpg";
				imgurlDefault = "<?= site_url()?>assets/app/users/avatar/default.jpg";

				$('#imgAvatar').load(imgurl, function(response, status, xhr) {
					if (status == "error") 
						$(this).attr('src', imgurlDefault);
					else
						$(this).attr('src', imgurl);
				});
				*/

				//populate Group (select2)
				var groups = [];
				$.each(resp.list_group, function(name, val){
					groups.push(val.fin_group_id);
				})
				$("#fin_group_id").val(groups).trigger("change");

				//populate address
				$.each(resp.list_address, function(name, val){
					console.log(val);
					isPrimary = false;
					if (val.fbl_primary == "1"){
						isPrimary = true;
					}
					add_address(val.fin_id,val.fst_name,val.fst_address,isPrimary);
				})


			},

			error: function (e) {
				$("#result").text(e.responseText);
				console.log("ERROR : ", e);
			}
		});
	}
</script>
