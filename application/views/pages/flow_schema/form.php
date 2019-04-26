<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link rel="stylesheet" href="<?=base_url()?>bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?=base_url()?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

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
</style>

<section class="content-header">
	<h1><?=lang("Flow Control Schema")?><small><?=lang("form")?></small></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> <?=lang("Home") ?></a></li>
		<li><a href="#"><?=lang("Flow Control Schema")?></a></li>
		<li class="active title"><?=$title?></li>
	</ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-info">
				<div class="box-header with-border">
				<h3 class="box-title title"><?=$title?></h3>
			</div>
			<!-- end box header -->

            <!-- form start -->
            <form id="frmFlowSchema" class="form-horizontal" action="<?=site_url()?>flow_schema/add" method="POST" enctype="multipart/form-data">				
				<div class="box-body">
                    <input type="hidden" name = "<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">
                    <input type="hidden" id="frm-mode" value="<?=$mode?>">

                    <div class='form-group'>
                    <label for="fin_flow_control_schema_id" class="col-sm-2 control-label"><?=lang("FC Schema ID")?> #</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="fin_flow_control_schema_id" placeholder="<?=lang("(Autonumber)")?>" name="fin_flow_control_schema_id" value="<?=$fin_flow_control_schema_id?>" readonly>
							<div id="fin_flow_control_schema_id_err" class="text-danger"></div>
						</div>
					</div>

                    <div class="form-group">
						<label for="fst_name" class="col-sm-2 control-label"><?=lang("Name")?></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="fst_name" placeholder="<?=lang("Name")?>" name="fst_name">
							<div id="fst_name_err" class="text-danger"></div>
						</div>
					</div>

                    <div class="form-group">
						<label for="fst_memo" class="col-sm-2 control-label"><?=lang("Memo")?></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="fst_memo" placeholder="<?=lang("Memo")?>" name="fst_memo">
							<div id="fst_memo_err" class="text-danger"></div>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-12" style='text-align:right'>
							<button id="btn-add-detail" class="btn btn-default btn-sm">
								<i class="fa fa-plus" aria-hidden="true"></i>
								<?=lang("Add Detail")?>
							</button>
						</div>
					</div>

					<table id="tblFlowSchemaDetail" class="table table-bordered table-hover table-striped"></table>
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
<div id="myModal" class="modal fade" role="dialog" >
	<div class="modal-dialog" style="display:table">
		<!-- modal content -->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><?=lang("Add Flow Control Schema Detail")?></h4>
			</div>

			<div class="modal-body">
				<form  class="form-horizontal">				
					<div class="form-group">
						<label for="select-username" class="col-sm-2 control-label"><?=lang("User Name")?></label>
						<div class="col-sm-10">
							<select id="select-username" class="form-control"></select>
							<div id="fst_username_err" class="text-danger"></div>
						</div>
					</div>
					<div class="form-group">
						<label for="fin_seq_no" class="col-sm-2 control-label"><?=lang("Seq No.")?></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="fin_seq_no">
							<div id="fin_seq_no_err" class="text-danger"></div>
						</div>
					</div>
				</form>
			</div>

			<div class="modal-footer">
				<button id="btn-add-schema-detail" type="button" class="btn btn-primary" ><?=lang("Add")?></button>
				<button type="button" class="btn btn-default" data-dismiss="modal"><?=lang("Close")?></button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
    $(function(){
        <?php if($mode == "EDIT"){?>
			init_form($("#fin_flow_control_schema_id ").val());
		<?php } ?>

        $("#btnSubmitAjax").click(function(event){
			event.preventDefault();
			data = $("#frmFlowSchema").serializeArray();
			console.log(data);
			detail = new Array();

			t = $('#tblFlowSchemaDetail').DataTable();
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
				url =  "<?= site_url() ?>flow_schema/ajx_add_save";
			}else{
				url =  "<?= site_url() ?>flow_schema/ajx_edit_save";
			}

            //var formData
            $.ajax({
                type: "POST",
				enctype: 'multipart/form-data',
				url: url,
				data: data,
				//processData: false,
				//contentType: false,
				//cache: false,
				timeout: 600000,
				success: function (resp) {	
					if (resp.message != "")	{
						$.alert({
							title: 'Message',
							content: resp.message,
							onDestroy: function(){
								//alert('the user clicked yes');
								window.location.href = "<?= site_url() ?>flow_schema/lizt";
								return;
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
						$("#fin_flow_control_schema_id ").val(data.insert_id);
						//Clear all previous error
						$(".text-danger").html("");

						// Change to Edit mode
						$("#frm-mode").val("EDIT");  //ADD|EDIT
						$('#fst_name').prop('readonly', true);
						$("#tabs-schema-detail").show();
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

		$("#select-username").select2({
			width: '100%',
			ajax: {
				url: '<?=site_url()?>flow_schema/get_data_username',
				dataType: 'json',
				delay: 250,
				processResults: function (data) {
					data2 = [];
					$.each(data,function(index,value){
						data2.push({
							"id" : value.fin_user_id,
							"text" : value.fst_username
						});	
					});
					console.log(data2);
					return {
						results: data2
					};
				},
				cache: true,
			}
		});

		var selected_username;
		var arrDetail;

		$('#select-username').on('select2:select', function (e) {
			console.log(selected_username);
			var data = e.params.data;
			selected_username = data;
			console.log(selected_username);
		});

		$("#btn-add-detail").click(function(event){
			event.preventDefault();
			
			$("#myModal").modal({
				backdrop:"static",
			});
		})

		$("#btn-add-schema-detail").click(function(event){
			event.preventDefault();
			t = $('#tblFlowSchemaDetail').DataTable();
		
			var action= '<div style="font-size:16px"><a id="btnedit" class="btn-edit" href="#" data-toggle="confirmation" data-original-title="" title=""><i class="fa fa-pencil"></i></a> <a class="btn-delete" href="#" data-toggle="confirmation" data-original-title="" title=""><i class="fa fa-trash"></i></a><button class="btnsubmit" contenteditable="true" style="display: none;">submit</button></div>';
			t.row.add({
				fin_id:0,
				fin_flow_control_schema_id:0,
				fin_user_id:selected_username.id,
				fst_username:selected_username.text,
				fin_seq_no:$("#fin_seq_no").val(),
				action: action
			}).draw(false);
		});

		$('#tblFlowSchemaDetail').on('preXhr.dt', function ( e, settings, data ) {
		 	//add aditional data post on ajax call
		 	data.sessionId = "TEST SESSION ID";
		}).DataTable({
			columns:[
				{"title" : "ID","width": "0%",sortable:false,data:"fin_id",visible:false},
				{"title" : "fin_flow_control_schema_id","width": "0%",sortable:false,data:"fin_flow_control_schema_id",visible:false},
				{"title" : "fin_user_id","width": "0%",sortable:false,data:"fin_user_id",visible:false},
				{"title" : "User Name","width": "20%",sortable:false,data:"fst_username"},
				{"title" : "Sequence No.","width": "15%",sortable:false,data:"fin_seq_no"},
				{"title" : "action","width": "10%",data:"action",sortable:false,className:'dt-center'},
			],
			processing: true,
			serverSide: false,
			searching: false,
			lengthChange: false,
			paging: false,
			info:true,
		}).on('draw',function(){
			$('.btn-delete').confirmation({
				//rootSelector: '[data-toggle=confirmation]',
				rootSelector: '.btn-delete',
				// other options
			});	

			$(".btn-delete").click(function(event){
				t = $('#tblFlowSchemaDetail').DataTable();
				var trRow = $(this).parents('tr');
				t.row(trRow).remove().draw();
			
			});

			$(".btn-edit").click(function(event){
				$('.btnsubmit').toggle();
				$(this).parents('tr').attr({
					"contenteditable": "true",
					"style": "color:#a9a9a9;background:white"
				});			
			});

			$(".btnsubmit").click(function(event){
			//	$(this).toggle();
			});
		});
    });

    function init_form(fin_flow_control_schema_id){
		//alert("Init Form");
		var url = "<?=site_url()?>flow_schema/fetch_data/" + fin_flow_control_schema_id ;
		$.ajax({
			type: "GET",
			url: url,
			success: function (resp) {	
				//console.log(resp.fcsheader);
				//console.log(resp.fcsdetail);

				$.each(resp.fcsheader, function(name, val){
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

				// Schema Detail DataTable
				t = $('#tblFlowSchemaDetail').DataTable();
				$.each(resp.fcsitems, function(name,val){
					console.log(val);
					var action= '<div style="font-size:16px"><a id="btnedit" class="btn-edit" href="#" data-toggle="confirmation" data-original-title="" title=""><i class="fa fa-pencil"></i></a> <a class="btn-delete" href="#" data-toggle="confirmation" data-original-title="" title=""><i class="fa fa-trash"></i></a><button class="btnsubmit" contenteditable="true" style="display: none;">submit</button></div>';
					t.row.add({
						fin_id:val.fin_id,
						fin_flow_control_schema_id:val.fin_flow_control_schema_id,
						fin_user_id:val.fin_user_id,
						fst_username:val.fst_username,
						fin_seq_no:val.fin_seq_no,
						action: action
					}).draw(false);
				});

				// menampilkan data di select2
				//var newOption = new Option(resp.fcsdetail.fst_username, resp.fcsdetail.fin_user_id, true, true);
    			// Append it to the select
    			//$('#select-username').append(newOption).trigger('change');
			},

			error: function (e) {
				$("#result").text(e.responseText);
				console.log("ERROR : ", e);
			}
		});
	}
</script>

<!-- Select2 -->
<script src="<?=base_url()?>bower_components/select2/dist/js/select2.full.js"></script>
<!-- DataTables -->
<script src="<?=base_url()?>bower_components/datatables.net/dataTables.min.js"></script>
<script src="<?=base_url()?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>