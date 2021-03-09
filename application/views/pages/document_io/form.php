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
	<h1><?=lang("Document In-Out")?><small><?=lang("form")?></small></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> <?= lang("Home") ?></a></li>
		<li><a href="#"><?= lang("Document In-Out") ?></a></li>
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
						<?php if ($mode == "EDIT"){ ?>
							<a id="btnPrint" class="btn btn-primary" href="#" title="<?=lang("Cetak")?>"><i class="fa fa-print" aria-hidden="true"></i></a>
						<?php } ?>
						<a id="btnDelete" class="btn btn-primary" href="#" title="<?=lang("Hapus")?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
						<a id="btnList" class="btn btn-primary" href="#" title="<?=lang("Daftar Transaksi")?>"><i class="fa fa-list" aria-hidden="true"></i></a>
					</div>
			</div>
            <!-- end box header -->

            <!-- form start -->
            <form id="frm" class="form-horizontal" method="POST">			
				<div class="box-body">
					<input type="hidden" name = "<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">
					<input type="hidden" class="form-control" id="fin_id" name="fin_id" value="<?=$fin_id?>" readonly>

					


					<div class='form-group'>
                    	<label for="fin_id" class="col-sm-3 control-label"><?=lang("Document")?></label>
						<div class="col-sm-9">
							<select class="select2 form-control" id="fin_document_id" name="fin_document_id" style="width:100%"></select>
							<div id="fin_document_id_err" class="text-danger"></div>
						</div>
					</div>	
					
					<div class='form-group'>
                    	<label for="fin_id" class="col-sm-3 control-label"><?=lang("Mode")?></label>
						<div class="col-sm-9">
							<input readonly class="form-control" id="fst_io_status" value="">
						</div>
					</div>	
									

					<div class="form-group">
                    	<label for="fin_req_by_id" class="col-sm-3 control-label" id="label-req-io"><?=lang("Request By")?> *</label>
						<div class="col-sm-4">
							<select class="form-control" id="fin_by_id" name="fin_by_id" style="width:100%">
								<?php 
									$listUser = $this->users_model->getAllList();
									foreach($listUser as $user){
										echo "<option value='$user->fin_user_id'>$user->fst_fullname - $user->fst_department_name</option>";
									}
								?>
							</select>
							<div id="fin_document_id_err" class="text-danger"></div>
						</div>
						
						<label for="fdt_io_datetime" class="col-sm-3 control-label" id="label-req-dt-io"><?=lang("Request  Datetime")?> *</label>
						<div class="col-sm-2">
							<input type="text" class="form-control datepicker" id="fdt_io_datetime" name="fdt_io_datetime"/>
							<div id="fdt_io_datetime_err" class="text-danger"></div>
						</div>

					</div>				

					<div class="form-group">
                    	<label for="fst_notes" class="col-sm-3 control-label"><?=lang("Notes")?> *</label>
						<div class="col-sm-9">
							<textarea class="form-control" id="fst_notes" name="fst_notes" style="resize:none" rows="10"></textarea>
							<div id="fst_notes_err" class="text-danger"></div>
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

<script type="text/javascript" info="define">
	var selectedDocument =  null;
	var mode = "<?=$mode?>";
</script>

<script type="text/javascript" info="init">
	$(function(){
		$("#fdt_io_datetime").datepicker('update', dateFormat("<?= date("Y-m-d")?>"));


		$("#fin_document_id").select2({
			minimumInputLength:0,
			ajax: {
                url: '<?= site_url() ?>document_io/ajxGetDocumentList',
				data:function(params){
					//params.fin_wo_id = $("#fin_wo_id").val();
					return params;
				},
                dataType: 'json',
                delay: 250,
                processResults: function(resp) {
                    data2 = [];
					if (resp.status == "SUCCESS"){
						$.each(resp.data, function(index, value) {
							console.log(value);
							data2.push({
								"id": value.fin_document_id,
								"text": value.fst_document_no + " - " + value.fst_name,
								"fst_io_status":value.fst_io_status
							});
						});
						
					}                    
                    return {
                        results: data2
                    };
                },
                cache: true,
            }
		}).on("select2:select",function(e){
			selectedDocument = e.params.data;
			setFormByStatusIO();
		});

		init_form();


	});
</script>

<script type="text/javascript" info="event">
	$(function(){

		$("#btnNew").click(function(e){
			e.preventDefault();
			window.location.replace("<?=site_url()?>document_io/add");
		});


		$("#btnSubmitAjax").click(function(event){
			event.preventDefault();
			data = new FormData($("#frm")[0]);

			if (mode == "ADD"){
				url =  "<?= site_url() ?>document_io/ajx_add_save";
			}else{
				url =  "<?= site_url() ?>document_io/ajx_edit_save";
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

		$("#btnPrint").click(function(e){
			e.preventDefault();
			var left = (screen.width - 800) / 2;
			url = "<?=site_url()?>document_io/print/" + $("#fin_id").val();
			window.open(url,"_blank","width=1000,height=550,menubar=0,toolbar=0,top=50,left="+left);
			return;	
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
				url:"<?=site_url()?>document_io/delete/" + $("#fin_id").val(),
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
			window.location.replace("<?=site_url()?>document_io");
		});
	});
</script>

<script type="text/javascript" info="function">
	
	
	function setFormByStatusIO(){				
		if (selectedDocument.fst_io_status == "IN"){
			$("#fst_io_status").val("OUT");			
		}else{
			$("#fst_io_status").val("IN");
		}	
	}
	

	function init_form(){
		//alert("Init Form");
		if (mode != "EDIT"){
			return;
		}
		
		$("#fin_document_id").prop("disabled",true);


		var finId = $("#fin_id").val();
		var url = "<?=site_url()?>document_io/fetch_data/" + finId;
		$.ajax({
			type: "GET",
			url: url,
			success: function (resp) {	
				if(resp.status == "SUCCESS"){
					var data = resp.data;
					$("#fin_id").val(data.fin_id);

					$("#fin_document_id").trigger({
						type: 'select2:select',
						params: {
							data: {
								id:data.fin_document_id,
								text:data.fst_document_no + " - " + data.fst_name,
								fst_io_status: data.fst_io_status
							}
						}
					});
					App.addOptionIfNotExist("<option value='"+data.fin_document_id +"'>"+ data.fst_document_no + " - " + data.fst_name +"</option>","fin_document_id");

					$("#fst_io_status").val(data.fst_io_status);
					$("#fin_by_id").val(data.fin_by_id);
					$("#fdt_io_datetime").datepicker('update', dateFormat(data.fdt_io_datetime));
					$("#fst_notes").val(data.fst_notes);
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