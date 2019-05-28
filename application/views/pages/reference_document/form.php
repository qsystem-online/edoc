<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link rel="stylesheet" href="<?=base_url()?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<style type="text/css">
	.border-0 {
		border: 0px;
	}

	td {
		padding: 2px;
		 !important
	}

	.nav-tabs-custom>.nav-tabs>li.active>a {
		font-weight: bold;
		border-left-color: #3c8dbc;
		border-right-color: #3c8dbc;
		border-style: fixed;
	}

	.nav-tabs-custom>.nav-tabs {
		border-bottom-color: #3c8dbc;
		border-bottom-style: fixed;
	}
</style>

<section class="content-header">
	<h1><?=lang("Reference Document")?><small><?=lang("form")?></small></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> <?=lang("Home") ?></a></li>
		<li><a href="#"><?=lang("Reference Document")?></a></li>
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
			<!-- end box header -->

            <!-- form start -->
            <form id="frmReference" class="form-horizontal" action="<?=site_url()?>reference_document/add" method="POST" enctype="multipart/form-data">				
				<div class="box-body">
                    <input type="hidden" name = "<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">
					<input type="hidden" id="frm-mode" value="<?=$mode?>">

					<div class="form-group hidden">
                    	<label for="fin_id" class="col-md-2 control-label"><?=lang("ID")?> #</label>
						<div class="col-md-10">
							<input type="text" class="form-control" id="fin_id" placeholder="<?=lang("Autonumber")?>" name="fin_id" value="<?=$fin_id?>" readonly>
							<div id="fin_id_err" class="text-danger"></div>
						</div>
					</div>

					<div class="form-group">
                    	<label for="fst_reff_source_code" class="col-md-2 control-label"><?=lang("Reference Source")?> #</label>
						<div class="col-md-10">
							<input type="text" class="form-control" id="fst_reff_source_code" placeholder="<?=lang("reff source code")?>" name="fst_reff_source_code" >
							<div id="fst_reff_source_code_err" class="text-danger"></div>
						</div>
					</div>

                    <div class="form-group">
						<label for="fst_reff_no" class="col-md-2 control-label"><?=lang("Reff No")?></label>
						<div class="col-md-10">
							<input type="text" class="form-control" id="fst_reff_no" placeholder="<?=lang("Reff No")?>" name="fst_reff_no">
							<div id="fst_name_err" class="text-danger"></div>
						</div>
					</div>

                   <div class="form-group">
						<div class="col-md-12" style='text-align:right'>
							<button id="btn-add-detail" class="btn btn-default btn-sm">
								<i class="fa fa-plus" aria-hidden="true"></i>
								<?=lang("Add Detail")?>
							</button>
						</div>
					</div>

					<table id="tblReferenceDetail" class="table table-bordered table-hover table-striped"></table>
				</div>
                <!-- end box body -->

                <div class="box-footer text-right">
					<a id="btnSubmitAjax" href="#" class="btn btn-primary"><?=lang("Save")?> Ajax</a>
				</div>
				<!-- end box-footer -->	
            </form>
        </div>
    </div>
</section>

<!-- modal atau popup "ADD" -->
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog" style="display:table;width:80%;min-width:800px">
		<!-- modal content -->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><?=lang("Add Document")?></h4>
			</div>

			<div class="modal-body">
				<form  class="form-horizontal">
					<table id="tblDocList" style="width:100%"></table>
				</form>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?=lang("Close")?></button>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	var action = '<a class="btn-edit" href="#" data-original-title="" title=""><i class="fa fa-pencil"></i></a>&nbsp;<a class="btn-delete" href="#" data-toggle="confirmation" data-original-title="" title=""><i class="fa fa-trash"></i></a>';
    $(function(){
        <?php if($mode == "EDIT"){?>
			init_form($("#fin_id").val());
		<?php } ?>

		availableTags = [
			"Puchasing",
			"Sales",
			"HRD",
			"Accounting"
		];

		$("#fst_reff_source_code").autocomplete({
			source: availableTags
		});

		var edited_reference_detail= null;
		var mode_reference_detail = "ADD";

        $("#btnSubmitAjax").click(function(event){
			event.preventDefault();
			data = $("#frmReference").serializeArray();
			//console.log(data);
			detail = new Array();

			t = $('#tblReferenceDetail').DataTable();
			datas = t.data();
			$.each(datas,function(i,v){
				detail.push(v);
			});
			data.push({
				name:"detail",
				value: JSON.stringify(detail)
			});

			//console.log(data);
			//return;*/

			mode = $("#frm-mode").val();
			if (mode == "ADD"){
				url =  "<?= site_url() ?>reference_document/ajx_add_save";
			}else{
				url =  "<?= site_url() ?>reference_document/ajx_edit_save";
			}

            //var formData
            $.ajax({
                type: "POST",
				enctype: 'multipart/form-data',
				url: url,
				data: data,
				timeout: 600000,
				success: function (resp) {	
					if (resp.message != "")	{
						$.alert({
							title: 'Message',
							content: resp.message,
							buttons : {
								OK : function(){
									if(resp.status == "SUCCESS"){
										window.location.href = "<?= site_url() ?>reference_document/show_list";
										return;
									}
								},
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
						//redirect to list
						data = resp.data;
						$("#fin_id ").val(data.insert_id);

						//Clear all previous error
						$(".text-danger").html("");

						// Change to Edit mode
						$("#frm-mode").val("EDIT");  //ADD|EDIT
						$('#fst_reff_source_code').prop('readonly', true);
						$("#tabs-reference-detail").show();
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

		var arrDetail;

		$("#btn-add-detail").click(function(event){
			event.preventDefault();
			mode_reference_detail = "ADD";
			$("#myModal").modal({
				backdrop:"static",
			});
		})

		$('#tblReferenceDetail').on('preXhr.dt', function ( e, settings, data ) {
		 	//add aditional data post on ajax call
		 	data.sessionId = "TEST SESSION ID";
		}).DataTable({
			columns:[
				{"title" : "ID","width": "10%",sortable:true,data:"fin_document_id",visible:true},
				{"title" : "Name","width": "30%",sortable:true,data:"fst_name",visible:true},
				{"title" : "Creator","width": "20%",sortable:true,data:"fin_insert_id",
					"render" :function(data,type,row){
						return row.fin_insert_id;
					}
				},
				{"title" : "action","width": "10%",sortable:false,data:"action",className:'dt-center'},
			],
			processing: true,
			serverSide: false,
			searching: false,
			lengthChange: false,
			paging: false,
			info:false,
		}).on('draw',function(){
			$('.btn-delete').confirmation({
				//rootSelector: '[data-toggle=confirmation]',
				rootSelector: '.btn-delete',
				// other options
			});	

			$(".btn-delete").click(function(event){
				t = $('#tblReferenceDetail').DataTable();
				var trRow = $(this).parents('tr');
				t.row(trRow).remove().draw();
			});

			$(".btn-edit").click(function(event){
				event.preventDefault();
				$("#myModal").modal({
					backdrop:"static",
				});

				t = $('#tblReferenceDetail').DataTable();
				var trRow = $(this).parents('tr');

				mode_reference_detail = "EDIT";
				edited_reference_detail = t.row(trRow);
				row = edited_reference_detail.data();	

				$("#fin_id").val(row.fin_id);
			});
		});

		$('#tblDocList').on('preXhr.dt', function ( e, settings, data ) {
			data.optionSearch = "fst_name";
		}).DataTable({
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
				{"title" : "<?= lang("ID") ?>","width": "15%",data:"fin_document_id",visible:true},
				{"title" : "<?= lang("Document Name") ?>","width": "45%",data:"fst_name",visible:true},
				{"title" : "<?= lang("Source") ?>","width": "10%",data:"fst_source",visible:true},
				{"title" : "<?= lang("Notes") ?>","width": "40%",data:"fst_memo"},
				{"title" : "<?= lang("Create By") ?>","width": "35%",data:"fin_insert_id",
					render : function(data,type,row){
						return row.fin_insert_id;
					}
				},
				{"title" : "<?= lang("Create Date") ?>","width": "35%",data:"fdt_insert_datetime"},
				{"title" : "<?= lang("Action") ?>","width": "10%",
					render:function(data,type,row){							
						return "<a class='btn-add-document-items' href='#'><i class='fa fa-plus'></i></a> <a class='btn-view-document-items' href='#'><i class='fa fa-search' aria-hidden='true'></i></a>";
					},
					"sortable": false,
					"className":"dt-center"
				}					  
			]				
		});

		$('#tblDocList').on('click','.btn-add-document-items',function(event){
			t = $('#tblDocList').DataTable();
			var trRow = $(this).parents('tr');
			data = t.row(trRow).data();
			t2 = $('#tblReferenceDetail').DataTable();
			data.fin_id = 0;			
			t2.row.add(data).draw();
		});

    });


	// Menampilkan Data Form Edit
    function init_form(fin_id){
		//alert("Init Form");
		var url = "<?=site_url()?>reference_document/fetch_data/" + fin_id ;
		$.ajax({
			type: "GET",
			url: url,
			success: function (resp) {

				$.each(resp.referenceDoc, function(name, val){
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
							console.log(val);
					}
				});

				Documents = resp.documents;
				$.each(Documents, function(idx, detail){
					data = {
						fin_document_id:detail.fin_document_id,
						fst_name:detail.fst_name,
						fin_insert_id:detail.fin_insert_id,
						action: action
					}
					t = $('#tblReferenceDetail').DataTable();			
					t.row.add(data).draw(false);	
				});
			},
			error: function (e) {
				$("#result").text(e.responseText);
				//console.log("ERROR : ", e);
			}
		});
	}
</script>

<!-- DataTables -->
<script src="<?=base_url()?>bower_components/datatables.net/dataTables.min.js"></script>
<script src="<?=base_url()?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>