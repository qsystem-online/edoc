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

    .nav-tabs-custom>.nav-tabs{
        border-bottom-color: #3c8dbc;        
        border-bottom-style:fixed;
    }
	.form-group{
		margin-bottom: 10px;
	}
</style>

<section class="content-header">
	<h1><?=lang("Document Group")?><small><?=lang("form")?></small></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> <?= lang("Home") ?></a></li>
		<li><a href="#"><?= lang("Document Group") ?></a></li>
		<li class="active title"><?=$title?></li>
	</ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
				<div class="box-header with-border">
				<h3 class="box-title title pull-left"><?=$title?></h3>
					<div class="btn-group btn-group-sm pull-right">
						<a id="btnNew" class="btn btn-primary" href="#" title="<?=lang("Tambah Baru")?>"><i class="fa fa-plus" aria-hidden="true"></i></a>
						<a id="btnSubmitAjax" class="btn btn-primary" href="#" title="<?=lang("Simpan")?>"><i class="fa fa-floppy-o" aria-hidden="true"></i></a>
						<a id="btnDelete" class="btn btn-primary" href="#" title="<?=lang("Hapus")?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
						<a id="btnList" class="btn btn-primary" href="#" title="<?=lang("Daftar Transaksi")?>"><i class="fa fa-list" aria-hidden="true"></i></a>
					</div>
			</div>
            <!-- end box header -->

            <!-- form start -->
            <form id="frm" class="form-horizontal" method="POST">			
				<div class="box-body">
					<input type="hidden" name = "<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">
					<div class='form-group'>
                    <label for="fin_id" class="col-sm-3 control-label"><?=lang("Group ID")?></label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="fin_id" placeholder="<?=lang("(Autonumber)")?>" name="fin_id" value="<?=$fin_id?>" readonly>
							<div id="fin_id_err" class="text-danger"></div>
						</div>
					</div>

					<div class="form-group">
                    	<label for="fst_group_code" class="col-sm-3 control-label"><?=lang("Group Code")?> *</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="fst_group_code" placeholder="<?=lang("Group Code")?>" name="fst_group_code">
							<div id="fst_group_code_err" class="text-danger"></div>
						</div>
					</div>

					<div class="form-group">
                    	<label for="fst_group_name" class="col-sm-3 control-label"><?=lang("Group Name")?> *</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="fst_group_name" placeholder="<?=lang("Group Name")?>" name="fst_group_name">
							<div id="fst_group_name_err" class="text-danger"></div>
						</div>
					</div>

					<div class="form-group">
                    	<label for="fst_desc" class="col-sm-3 control-label"><?=lang("Department")?> *</label>
						<div class="col-sm-9">
							<select class="form-control select2" id="fst_list_department_id" name="fst_list_department_id[]" style="width:100%" multiple="multiple">
							<?php
								$deptList = $this->departments_model->getAllList();
								foreach($deptList as $dept){
									echo "<option value='$dept->fin_department_id'>$dept->fst_department_name</option>";
								}
							?>
							</select>
							<div id="fst_list_department_id_err" class="text-danger"></div>
						</div>
					</div>

					<div class="form-group">
                    	<label for="fst_desc" class="col-sm-3 control-label"><?=lang("Description")?> *</label>
						<div class="col-sm-9">
							<textarea class="form-control" id="fst_desc" name="fst_desc" style="resize:none"></textarea>
							<div id="fst_desc_err" class="text-danger"></div>
						</div>
					</div>
                </div>
				<!-- end box body -->

                <div class="box-footer">
                    <!--<a id="btnSubmitAjax" href="#" class="btn btn-primary">Save Ajax</a>-->
                </div>
                <!-- end box-footer -->
            </form>
        </div>
    </div>
</section>

<script type="text/javascript">
	var mode = "<?=$mode?>";
	$(function(){
		if (mode == "EDIT"){
			init_form($("#fin_id").val());
		}

		$("#btnSubmitAjax").click(function(event){
			event.preventDefault();
			data = new FormData($("#frm")[0]);

			if (mode == "ADD"){
				url =  "<?= site_url() ?>doc_groups/ajx_add_save";
			}else{
				url =  "<?= site_url() ?>doc_groups/ajx_edit_save";
			}

			//var formData = new FormData($('form')[0])
			$.ajax({
				type: "POST",
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
							buttons : {
								OK : function(){
									if(resp.status == "SUCCESS"){
										$("#btnNew").trigger("click");
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
						data = resp.data;
						$("#fin_id").val(data.insert_id);
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

		$("#btnNew").click(function(e){
			e.preventDefault();
			window.location.replace("<?=site_url()?>doc_groups/add");
		});

		$("#btnDelete").confirmation({
			title: "<?=lang("Hapus data ini ?")?>",
			rootSelector: '#btnDelete',
			placement: 'left',
		});

		$("#btnDelete").click(function(e){
			e.preventDefault();
			blockUIOnAjaxRequest("<h5>Deleting ....</h5>");
			$.ajax({
				url:"<?=site_url()?>doc_groups/delete/" + $("#fin_id").val(),
			}).done(function(resp){
				//consoleLog(resp);
				$.unblockUI();
				if (resp.message != ""){
					$.alert({
						title: 'Message',
						content: resp.message,
						buttons: {
							OK : function() {
								if (resp.status == "SUCCESS") {
									$("#btnList").trigger("click");
								}
							},
						}
					});
				}
			});
		});

		$("#btnList").click(function(e){
			e.preventDefault();
			window.location.replace("<?=site_url()?>doc_groups");
		});

		//App.fixedSelect2();
	});

	function init_form(finId){
		//alert("Init Form");
		var url = "<?=site_url()?>doc_groups/fetch_data/" + finId;
		$.ajax({
			type: "GET",
			url: url,
			success: function (resp) {	
				if(resp.status == "SUCCESS"){
					var data = resp.data;
					$("#fin_id").val(data.fin_id);
					$("#fst_group_code").val(data.fst_group_code);					
					$("#fst_group_name").val(data.fst_group_name);

					//var res = str.split(" ");

					var fstListDept = data.fst_list_department_id;
					arrFstListDept = fstListDept.split(",");
					console.log(arrFstListDept);
					//$("#fst_list_department_id").select2('val', arrFstListDept);
					$("#fst_list_department_id").val(arrFstListDept).trigger("change");
					/*
					$.each(arrFstListDept,function(i,v){
						$("#fst_list_department_id").select2('val', v);
					});
					*/
					

					$("#fst_desc").val(data.fst_desc);
				}
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