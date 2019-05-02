<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style>
	td.details-control {
		background: url('{base_url}assets/system/icons/details_open.png') no-repeat center center;
		cursor: pointer;
	}
	tr.shown td.details-control {
		background: url('{base_url}assets/system/icons/details_close.png') no-repeat center center;
	}

</style>
<link rel="stylesheet" href="<?=base_url()?>bower_components/datatables.net/datatables.min.css">

<section class="content-header">
	<h1><?=$page_name?><small>List</small></h1>
	<ol class="breadcrumb">
		<?php 
			foreach($breadcrumbs as $breadcrumb){
				if ($breadcrumb["link"] == NULL){
					echo "<li class='active'>".$breadcrumb["title"]."</li>";
				}else{
					echo "<li><a href='".$breadcrumb["link"]."'>".$breadcrumb["icon"].$breadcrumb["title"]."</a></li>";
				}
				
			} 
		?>
	</ol>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-header with-border">
				<h3 class="box-title"><?=$list_name?></h3>
				<div class="box-tools">
					<a id="btnNew" data-toggle="confirmation" href="<?=$addnew_ajax_url?>" class="btn btn-primary btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> New Record</a>
				</div>

			</div>			
			<!-- /.box-header -->
			<div class="box-body">
				<div align="right">
					<span>Search on:</span>
					<span>
                        <select id="selectSearch" name="selectSearch" style="width: 148px;background-color:#e6e6ff;padding:8px;margin-left:6px;margin-bottom:6px">                            
                            <?php
                                foreach($arrSearch as $key => $value){ ?>
                                    <option value=<?=$key?>><?=$value?></option>
                                <?php
                                }
                            ?>
						</select>
					</span>
				</div>
				<table id="tblList" class="table table-bordered table-hover table-striped"></table>
			</div>
			<!-- /.box-body -->
			<div class="box-footer">
			</div>
			<!-- /.box-footer -->		
		</div>
	</div>
</div>

<script type="text/javascript">
	function formatSubList(data){

		var result = "";
		result = "<div><label>Memo : </label>" + data.fst_memo + "</div>";
		return result;
	}


	$(function(){	     
		$('#tblList').on('preXhr.dt', function ( e, settings, data ) {
		 	//add aditional data post on ajax call
			 //data.sessionId = "TEST SESSION ID";
			 data.optionSearch = $('#selectSearch').val();
		}).DataTable({
			columns:[
				{"className":'details-control',"orderable":false,"data":null,"defaultContent": '',width:"5%"},
				{"title" : "<?= lang("ID") ?>","width": "5%",data:"fin_document_id",visible:false},
				{"title" : "<?= lang("Document Name") ?>","width": "45%",data:"fin_document_id",visible:true,
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
				{"title" : "<?= lang("Create By") ?>","width": "15%",data:"fin_insert_id",
					render : function(data,type,row){
						return row.fst_username;
					}
				},
				{"title" : "<?= lang("Create Date") ?>","width": "15%",data:"fdt_insert_datetime"},
				{"title" : "<?= lang("Action") ?>","width": "10%",
					render:function(data,type,row){	
						action ="";
						if (row.view_doc){
							action = "<a class='btn-view-document edit-mode' href='#'><i class='fa fa-search'></i></a>&nbsp;";
						}
						if (row.print_doc){
							action += "<a class='btn-download-document' href='#'><i class='fa fa-download' aria-hidden='true'></i></a>"; 					
						}												
						return action;
					},
					"sortable": false,
					"className":"dt-body-center text-center"
				}					  
			],
			order: [[ 1, 'asc' ]],
			dataSrc:"data",
			processing: true,
			serverSide: true,
			ajax: "{base_url}document/search_list_data",
		}).on('draw',function(){					
		});

		// Add event listener for opening and closing details
		$('#tblList tbody').on('click', 'td.details-control', function () {
			table = $('#tblList ').DataTable();			
			var tr = $(this).closest('tr');
			var row = table.row( tr );

			if ( row.child.isShown() ) {
				// This row is already open - close it
				console.log("child close");
				row.child.hide();
				tr.removeClass('shown');
			}else {
				// Open this row
				console.log("child show");
				row.child( formatSubList(row.data()) ).show();
				tr.addClass('shown');
			}
		});

		$('#tblList').on("click",".btn-view-document", function (event) {
			event.preventDefault();
			var t = $('#tblList').DataTable();
			var trRow = $(this).parents('tr');
			dataRow = t.row(trRow).data();
			url = "{base_url}document/displayDocument/" + dataRow.fin_document_id;
			var win = window.open(url, '_blank');
  			win.focus();
		});
		$('#tblList').on("click",".btn-download-document", function (event) {
			event.preventDefault();
			var t = $('#tblList').DataTable();
			var trRow = $(this).parents('tr');
			dataRow = t.row(trRow).data();
			url = "{base_url}document/downloadDocument/" + dataRow.fin_document_id;
			var win = window.open(url, '_blank');
  			win.focus();			
		});




	});
</script>
<!-- DataTables -->
<script src="<?=base_url()?>bower_components/datatables.net/datatables.min.js"></script>
