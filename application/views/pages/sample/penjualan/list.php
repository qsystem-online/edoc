<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link rel="stylesheet" href="<?=base_url()?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
	<h1>Transaksi Penjualan<small>List</small></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Sample</a></li>
		<li class="active">Penjualan</li>
	</ol>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-header with-border">
				<h3 class="box-title"><?= lang("List Penjualan")?></h3>
				<div class="box-tools">
					<a id="btnNewPenjualan" data-toggle="confirmation" href="<?=site_url()?>sample/penjualan/add" class="btn btn-primary btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> New Record</a>
				</div>

			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<table id="tblPenjualan" class="table table-bordered table-hover table-striped"></table>
			</div>
			<!-- /.box-body -->
			<div class="box-footer">
			</div>
			<!-- /.box-footer -->		
		</div>
	</div>
</div>

<script type="text/javascript">
	$(function(){		
		$('#tblPenjualan').on('preXhr.dt', function ( e, settings, data ) {
		 	//add aditional data post on ajax call
		 	data.sessionId = "TEST SESSION ID";
		}).DataTable({
			columns:[
				{"title" : "ID","width": "10%",data:"fin_id"},
				{"title" : "Date","width": "10%",data:"fdt_date"},
				{"title" : "Customer","width": "40%",data:"fst_customer_name"},
				{"title" : "Sub Total","width": "10%",
					data:"subttl_penjualan",
					render: $.fn.dataTable.render.number( ',', '.', 2 ),
					className:'dt-right'
				},
				{"title" : "Disc (%)","width": "10%",data:"fdc_disc"},
				{"title" : "Total","width": "10%",
					data:"ttl_penjualan",
					render: $.fn.dataTable.render.number( ',', '.', 2 ),
					className:'dt-right'
				},
				{"title" : "action","width": "10%",data:"action",sortable:false,className:'dt-center'},
			],
			dataSrc:"data",
			processing: true,
			serverSide: true,
			ajax: "<?=site_url()?>sample/penjualan/fetch_list_data"
		}).on('draw',function(){
			$('.btn-delete').confirmation({
				//rootSelector: '[data-toggle=confirmation]',
				rootSelector: '.btn-delete',
				// other options
			});	

			$(".btn-delete").click(function(event){
				var trRow = $(this).parents('tr');
				$.ajax({
					url:"<?=site_url()?>sample/penjualan/delete/" + $(this).data("id"),
					success:function(resp){
						if (resp.status == "SUCCESS"){
							trRow.remove();
						}
					}
				})
			});

			$(".btn-edit").click(function(event){
				id = $(this).data("id");
				window.location.replace("<?=site_url()?>sample/penjualan/edit/" + id);
			});

		});




	});
</script>
<!-- DataTables -->
<script src="<?=base_url()?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
