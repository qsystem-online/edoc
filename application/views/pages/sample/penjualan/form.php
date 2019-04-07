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
</style>
<section class="content-header">
	<h1>Penjulan<small>Form</small></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Sample</a></li>
		<li><a href="<?=site_url()?>sample/penjualan">Penjualan</a></li>
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
			<form id="frmPenjualan" class="form-horizontal">				
				<div class="box-body">
					<input type="hidden" name = "<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">

					<div class="form-group">
						<label for="fin_id" class="col-md-2 control-label">Transaction No # </label>
						<div class="col-md-4">
							<input type="text" class="form-control" id="fin_id" placeholder="Transaction No (Autonumber)" name="fin_id">
							<div id="fin_id_err" class="text-danger"></div>
						</div>

						<label for="fdt_date" class="col-md-4 control-label">Transaction Date </label>
						<div class="col-md-2">
							<input type="text" class="form-control datepicker text-right" id="fdt_date" placeholder="Date" name="fdt_date">
							<div id="fdt_date_err" class="text-danger"></div>
						</div>
					</div>

					<div class="form-group">
						<label for="fst_customer_name" class="col-md-2 control-label">Customer Name * </label>
						<div class="col-md-10">
							<input type="text" class="form-control" id="fst_customer_name" placeholder="Customer Name" name="fst_customer_name">
							<div id="fst_customer_name_err" class="text-danger"></div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-12" style='text-align:right'>
							<button id="btn-add-product" class="btn btn-default btn-sm">
								<i class="fa fa-plus" aria-hidden="true"></i>
								Add Product
							</button>
						</div>
					</div>

					<div class="form-group" style="margin-bottom:0px">
						<div class="col-md-12" id="detail_err"></div>
					</div>					

					<table id="tblDetailPenjualan" class="table table-bordered table-hover table-striped"></table>
					
					<div class="form-group">
						<label for="sub-total" class="col-md-10 control-label">Sub total </label>
						<div class="col-md-2" style='text-align:right'>
							<input type="text" class="form-control text-right" id="sub-total" value="0" readonly>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-md-9 control-label">Disc (%) </label>
						<div class="col-md-1" style='text-align:right'>
							<input type="text" class="form-control text-right" id="fdc_disc" name="fdc_disc" style="padding:5px" value=0>
						</div>
						<div class="col-md-2" style='text-align:right'>
							<input type="text" class="form-control text-right" id="disc-val" value="0" readonly>
						</div>
					</div>
					<div class="form-group">
						<label for="total" class="col-md-10 control-label">Total</label>
						<div class="col-md-2" style='text-align:right'>
							<input type="text" class="form-control text-right" id="total" value="0" readonly>
						</div>
					</div>


				</div>
				<!-- /.box-body -->
				<div class="box-footer text-right">
					<button name="submit" value="submit" type="submit" class="btn btn-primary hidden">Submit</button>
					<a id="btnTest" href="#" class="btn btn-primary hidden">test</a>
					<a id="btnTestResult" href="#" class="btn btn-primary hidden">test Result</a>
					<a id="btnSubmitAjax" href="#" class="btn btn-primary">Save Ajax</a>
				</div>
				<!-- /.box-footer -->		
			</form>
			
		</div>
	</div>
</div>


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog" >
	<div class="modal-dialog" style="display:table">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Add Product</h4>
			</div>

			<div class="modal-body">
				<form  class="form-horizontal">	
					<input type='hidden' id='fin-detail-id'/>
					<div class="form-group">
						<label for="select-product" class="col-md-2 control-label">Product</label>
						<div class="col-md-10">
							<select id="select-product" class="form-control" ></select>
							<div id="fst_customer_name_err" class="text-danger"></div>
						</div>
					</div>
					<div class="form-group">
						<label for="fst_customer_name" class="col-md-2 control-label">Qty</label>
						<div class="col-md-10">
							<input type="text" class="form-control numeric" id="product-qty" value="1">
							<div id="fst_customer_name_err" class="text-danger"></div>
						</div>
					</div>
					<div class="form-group">
						<label for="fst_customer_name" class="col-md-2 control-label">Harga</label>
						<div class="col-md-10">
							<input type="text" class="form-control text-right money" id="product-harga" value="0">
							<div id="fst_customer_name_err" class="text-danger"></div>
						</div>
					</div>

				</form>
				
			</div>
			<div class="modal-footer">
				<button id="btn-add-product-detail" type="button" class="btn btn-primary" >Add</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>




<script type="text/javascript">
	var action = '<a class="btn-edit" href="#" data-original-title="" title=""><i class="fa fa-pencil"></i></a>&nbsp;<a class="btn-delete" href="#" data-toggle="confirmation" data-original-title="" title=""><i class="fa fa-trash"></i></a>';
	$(function(){
		<?php if($mode == "EDIT"){?>
			initForm();
		<?php } ?>


		var edited_product_detail = null;
		var mode_product_detail = "ADD";
		$("#btnSubmitAjax").click(function(event){
			event.preventDefault();
			//data = new FormData($("#frmPenjualan")[0]);
			data = $("#frmPenjualan").serializeArray();
			detail = new Array();

			t = $('#tblDetailPenjualan').DataTable();			
			datas = t.data();
			$.each(datas,function(i,v){
				detail.push(v);
			});

			data.push({
				name:"detail",
				value: JSON.stringify(detail)
			});

			//console.log(data);
			//return;
			

			mode = $("#frm-mode").val();
			if (mode == "ADD"){
				url =  "<?= site_url() ?>sample/penjualan/ajx_add_save";
			}else{
				url =  "<?= site_url() ?>sample/penjualan/ajx_edit_save";
			}

			//var formData = new FormData($('form')[0])
			$.ajax({
				type: "POST",
				url: url,
				data: data,
				timeout: 600000,
				success: function (resp) {	
					if (resp.message != "")	{
						$.alert({
							title: 'Message',
							content: resp.message,
							onDestroy: function(){								
								if ( resp.status == "SUCCESS" ){
									window.location.href = "<?= site_url() ?>sample/penjualan";
									return;
								}
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
						$("#fin_id").val(data.insert_id);
						//Clear all previous error
						$(".text-danger").html("");
						// Change to Edit mode
						$("#frm-mode").val("EDIT");  //ADD|EDIT
						
					}


				},
				error: function (e) {
					$("#result").text(e.responseText);
					console.log("ERROR : ", e);
					$("#btnSubmit").prop("disabled", false);
				}
			});

		});
		
		
		

		$("#select-product").select2({
			width: '100%',
			minimumInputLength: 2,
			ajax: {
				url: '<?=site_url()?>sample/penjualan/get_data_product',
				dataType: 'json',
				delay: 250,
				processResults: function (data) {
					data2 = [];
					$.each(data,function(index,value){
						data2.push({
							"id" : value.id_product,
							"price": value.price,
							"text" : value.title
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

		$("#fdc_disc").inputmask({
			alias: 'numeric', 
			allowMinus: false,  
			digits: 2, 
			max: 100
		});

		$(".numeric").inputmask({
			alias: 'numeric', 
			allowMinus: false,  
			digits: 2
		});

		$(".money").inputmask({
			alias: 'numeric', 
			autoGroup: true,
      		groupSeparator: ",",
			allowMinus: false,  
			digits: 2
		});

		
		$('#select-product').on('select2:select', function (e) {			
			var data = e.params.data;
			//selected_product = data;
			$("#product-harga").val(numeral(data.price).format("0,000"));			
		});



		$("#btn-add-product").click(function(event){
			event.preventDefault();
			mode_product_detail = "ADD";
			$("#myModal").modal({
				backdrop:"static",
			});
			
			$('#select-product').val(null).trigger('change');
			$("#fin-detail-id").val(0);
			$("#product-qty").val(1);
			$("#product-harga").val(0);
			
		})

		$("#btn-add-product-detail").click(function(event){
			event.preventDefault();
			selected_product = $("#select-product").select2('data')[0];
			var qty = numeral($("#product-qty").val());
			var harga = numeral($("#product-harga").val());
			var total = qty.value() * harga.value();
			//var action= '<a class="btn-edit" href="#" data-original-title="" title=""><i class="fa fa-pencil"></i></a>&nbsp;<a class="btn-delete" href="#" data-toggle="confirmation" data-original-title="" title=""><i class="fa fa-trash"></i></a>';
			data = {
				fin_id:$("#fin-detail-id").val(),
				id_product:selected_product.id,
				product_name:selected_product.text,
				fin_qty: $("#product-qty").val(),
				fdc_harga: harga.value(),
				total: total,
				action: action
			}

			t = $('#tblDetailPenjualan').DataTable();			
			if(mode_product_detail =="EDIT"){
				edited_product_detail.data(data).draw(false);
			}else{
				t.row.add(data).draw(false);	
			}

			calculateTotal();
		});

		$('#tblDetailPenjualan').on('preXhr.dt', function ( e, settings, data ) {
		 	//add aditional data post on ajax call
		 	data.sessionId = "TEST SESSION ID";
		}).DataTable({
			columns:[
				{"title" : "ID","width": "0%",data:"fin_id",visible:true},
				{"title" : "id_product","width": "0%",data:"id_product",visible:true},
				{"title" : "product","width": "60%",data:"product_name"},
				{"title" : "Qty","width": "10%",data:"fin_qty"},
				{"title" : "Harga","width": "10%",
					data:"fdc_harga",
					render: $.fn.dataTable.render.number( ',', '.', 2 ),
					className:'dt-right'
				},
				{"title" : "Total","width": "10%",
					data:"total",
					render: $.fn.dataTable.render.number( ',', '.', 2 ),
					className:'dt-right'
				},				
				{"title" : "action","width": "10%",data:"action",sortable:false,className:'dt-center'},
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
				t = $('#tblDetailPenjualan').DataTable();
				var trRow = $(this).parents('tr');

				t.row(trRow).remove().draw();
				calculateTotal();

				//trRow.remove();		
				//$('#tblDetailPenjualan').DataTable().row(0).delete();		
			});

			

			$(".btn-edit").click(function(event){
				event.preventDefault();			
				$("#myModal").modal({
					backdrop:"static",
				});
				t = $('#tblDetailPenjualan').DataTable();
				var trRow = $(this).parents('tr');

				mode_product_detail = "EDIT";
				edited_product_detail = t.row(trRow);
				row = edited_product_detail.data();							

				//$("#product-detail-mode").val("EDIT");
				//$("#product-detail-id").val(rowid);
				$("#select-product").val(row.id_product).change();
				$("#fin-detail-id").val(row.fin_id);
				$("#product-qty").val(row.fin_qty);
				$("#product-harga").val(row.fdc_harga);


			});

		});

		$("#fdc_disc").change(function(event){
			event.preventDefault();
			calculateTotal();
		})
	});

	function calculateTotal(){
		t = $('#tblDetailPenjualan').DataTable();
		datas = t.data();

		subTotal =0;
		disc = parseFloat($("#fdc_disc").val());

		$.each(datas,function(i,v){
			subTotal = subTotal + (v.fin_qty * v.fdc_harga);
		})

		$("#sub-total").val(numeral(subTotal).format("0,000"));
		disc_val = subTotal * (disc /100);
		$("#disc-val").val(numeral(disc_val).format("0,000"));
		total = subTotal - disc_val;
		$("#total").val(numeral(total).format("0,000"));
	}

	function initForm(){
		url =  "<?= site_url() ?>sample/penjualan/fetch_data/" + <?= $fin_id ?>;
		$.ajax({
			type: "GET",
			url: url,
			success: function (resp) {	
				
				//Set Header
				hPenjualan = resp.HPenjualan;								
				$.each(hPenjualan, function(name, val){
					var $el = $('[name="'+name+'"]');
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

				$("#fdt_date").datepicker('update', dateFormat(hPenjualan.fdt_date));

				//Set Details
				dPenjualan = resp.DPenjualan;
				$.each(dPenjualan, function(idx, detail){
					data = {
						fin_id:detail.fin_id,
						id_product:detail.id_product,
						product_name:detail.title,
						fin_qty: detail.fin_qty,
						fdc_harga: detail.fdc_harga,
						total: detail.fin_qty * detail.fdc_harga,
						action: action
					}
					t = $('#tblDetailPenjualan').DataTable();			
					t.row.add(data).draw(false);	
					
					//set Data select2		
					var newOption = new Option(detail.title, detail.id_product, false, false);
					$('#select-product').append(newOption);
				});				
				$('#select-product').trigger('change');
				calculateTotal();
			},			
			error: function (e) {
				$("#result").text(e.responseText);
				console.log("ERROR : ", e);
				$("#btnSubmit").prop("disabled", false);
			}
		});
		
	}

</script>
<!-- Select2 -->
<script src="<?=base_url()?>bower_components/select2/dist/js/select2.full.js"></script>
<!-- DataTables -->
<script src="<?=base_url()?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
