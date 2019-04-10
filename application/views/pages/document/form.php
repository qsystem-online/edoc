<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link rel="stylesheet" href="<?=base_url()?>bower_components/select2/dist/css/select2.min.css">
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
						<label for="fst_birthplace" class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
							<img id="imgAvatar" style="border:1px solid #999;width:128px;" src="<?=site_url()?>assets/app/users/avatar/default.jpg"/>
						</div>
					</div>
					<div class="form-group">
						<label for="fst_birthplace" class="col-sm-2 control-label">Avatar</label>
						<div class="col-sm-10">
							<input type="file" class="form-control" id="fst_avatar"  name="fst_avatar">
						</div>
					</div>


					<hr>

					<?php $displayDetail = ($mode == "ADD") ? "none" : "" ?>
					<div id="tabs-user-detail" class="nav-tabs-custom" style="display:unset">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#address" data-toggle="tab" aria-expanded="true"><?= lang("Document List")?></a></li>
							<li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false"><?= lang("File List")?></a></li>
                            <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false"><?= lang("Flow Control")?></a></li>
							<li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false"><?= lang("Custom Scope")?></a></li>
						</ul>
						<div class="tab-content">							
							<div class="tab-pane active" id="address">
								<div id="data-address" style="display:none">

								</div>

								<table id="tblAddress" class="table table-bordered table-condensed">
									<thead>
										<tr>
											<form class="form-inline" action="/action_page.php">
												<th style="width:20%;vertical-align: top;">
													<input type="text" class="form-control-sm" id="address_name" autocomplete="name" style="width:100%">
												</th>
												<th style="width:50%">
													<textarea type="text" class="form-control-sm" id="address_address" autocomplete="street-address" style="width:100%"></textarea> 
												</th>
												<th style="width:10%;vertical-align: top;">
													 <label><input type="checkbox"  id="address_primary" > Primary</label>
												</th>
												<th style="width:20%;vertical-align: top;">
													<button id="btnAddAddress" class="btn btn-primary">Add Address</button>
												</th>
											</form>
											
										</tr>
										<tr class="active">
											<th>Name</th>
											<th>Address</th>
											<th>Is Primary</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>

							</div>
							<!-- /.tab-pane -->
							<div class="tab-pane" id="tab_2">
								The European languages are members of the same family. Their separate existence is a myth.
								For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ
								in their grammar, their pronunciation and their most common words. Everyone realizes why a
								new common language would be desirable: one could refuse to pay expensive translators. To
								achieve this, it would be necessary to have uniform grammar, pronunciation and more common
								words. If several languages coalesce, the grammar of the resulting language is more simple
								and regular than that of the individual languages.
							</div>
							<!-- /.tab-pane -->
							<div class="tab-pane" id="tab_3">
								Lorem Ipsum is simply dummy text of the printing and typesetting industry.
								Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
								when an unknown printer took a galley of type and scrambled it to make a type specimen book.
								It has survived not only five centuries, but also the leap into electronic typesetting,
								remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset
								sheets containing Lorem Ipsum passages, and more recently with desktop publishing software
								like Aldus PageMaker including versions of Lorem Ipsum.
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
		$("#btnTestResult").click(function(event){
			event.preventDefault();
			$.ajax({
  				url:"<?= site_url() ?>system/user/get_progress_test",
  				success:function(resp){
					console.log(resp);	
				}
  			})				
		});

		$("#btnTest").click(function(event){
			event.preventDefault();
			$.ajax({
				url:"<?=site_url()?>system/user/test",
				success:function(){
					alert("success");
					clearInterval(myProcess);
				}
			});

			
			myProcess = setInterval(function(){
				var d = new Date();
  				var n = d.getTime();
  				$.ajax({
  					url:"<?= site_url() ?>system/user/get_progress_test",
  					success:function(resp){
						console.log(resp);	
					}
  				})				
			}, 1000);
			


		});

		$("#fst_avatar").change(function(event){
			event.preventDefault();
			var reader = new FileReader();
			reader.onload = function (e) {
               $("#imgAvatar").attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
		});


		var iaddress = 0;

		$("#btnAddAddress").click(function(event){
			//add data to table
			
			event.preventDefault();
			iaddress++;
			
			data = {
				"<?=$this->security->get_csrf_token_name()?>" :  "<?=$this->security->get_csrf_hash()?>",
				"fin_owner_id" : $("#fin_id").val(),
				"fst_name" : $("#address_name").val(),
				"fst_address" : $("#address_address").val(),
				"fbl_primary" : $("#address_primary").is(':checked'),
			}

			$.ajax({
				url:"<?=site_url()?>system/user/ajx_add_address",
				method:"POST",
				data: data,				
				success:function(resp){
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
						console.log(resp.data);
					}else if(resp.status == "SUCCESS") {
						insertId = resp.data.insert_id;
						add_address(insertId,$("#address_name").val(),$("#address_address").val(),$("#address_primary").is(':checked'));
						//clear form

					}

				},

				error: function (e) {
					$("#result").text(e.responseText);
					console.log("ERROR : ", e);
				}
			});
		});


		$('body').on('click', '.del-address', function(event) {
			event.preventDefault();
			id= $(this).data("id");
			url = "<?=site_url()?>system/user/ajx_del_address/" + id;
			$.ajax({
				url: url,
				method: "GET",
				success:function(resp){
					
					$(".data-address-" +id).remove();		
				},
				error: function (e) {
					$("#result").text(e.responseText);
					console.log("ERROR : ", e);
				}
			});
			
		});


		$(".datepicker").datepicker({
			format:"yyyy-mm-dd"
		});

		$(".select2").select2();
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
<!-- Select2 -->
<script src="<?=base_url()?>bower_components/select2/dist/js/select2.full.js"></script>
<script type="text/javascript">
    $(function(){
        $(".select2-container").addClass("form-control"); 
        $(".select2-selection--single , .select2-selection--multiple").css({
            "border":"0px solid #000",
            "padding":"0px 0px 0px 0px"
        });         
        $(".select2-selection--multiple").css({
            "margin-top" : "-5px",
            "background-color":"unset"
        });
    });
</script>
