<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- <link rel="stylesheet" href="<?=base_url()?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css"> -->
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
				
			</div>			
			<!-- /.box-header -->
			<div class="box-body">
				<form class="form-inline">
					<div class="form-group col-sm-5">
						<label for="start-from"><?= lang("Start From")?>: &nbsp;</label>
						<input type="text" class="form-control datepicker filterData" id="start-date">
						<label for="end-to" style="margin-left:20px"><?= lang("Until")?>: &nbsp;</label>
						<input type="text" class="form-control datepicker filterData" id="end-date">
					</div>
					
					<div class="form-group col-sm-4" style= "">
						<label for="end-to"><?= lang("Status")?>: &nbsp;</label>							
						<select id="selectStatus" class="form-control filterData" name="selectStatus" style="width: 148px;padding:8px;margin-left:6px;margin-bottom:6px">                            
							<option value="">ALL</option>
							<option value="NA">Need Approval</option>
							<option value="RA">Ready To Approve</option>
							<option value="NR">Need Revision</option>
							<option value="AP">Approved</option>
							<option value="RJ">Rejected</option>
							
						</select>
					
					</div>

					<div class="form-group col-sm-3 text-right" style="padding-right:0px">
						
							
							<span>Search on:</span>
							<span>
								<select id="selectSearch" class="filterData" name="selectSearch" style="width: 148px;background-color:#e6e6ff;padding:8px;margin-left:6px;margin-bottom:6px">
									<?php
										foreach($arrSearch as $key => $value){ ?>
											<option value=<?=$key?>><?=$value?></option>
										<?php
										}
									?>
								</select>
							</span>

						
					</div>
					
				</form>
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
	$(function(){

		$(".filterData").change(function(event){
			event.preventDefault();
			$('#tblList').DataTable().ajax.reload();
		});
		

		$('#tblList').on('preXhr.dt', function ( e, settings, data ) {
		 	//add aditional data post on ajax call
			//data.sessionId = "TEST SESSION ID";
			data.optionSearch = $('#selectSearch').val();
			data.startDate = $('#start-date').val();
			data.endDate = $('#end-date').val();
			data.optionStatus = $('#selectStatus').val();

		}).DataTable({
			columns:[
                <?php
                    foreach($columns as $col){?>
                        {"title" : "<?=$col['title']?>","width": "<?=$col['width']?>","data":"<?=$col['data']?>"
                            <?php if(isset($col['render'])){?>
                                ,"render":<?php echo $col['render'] ?>
                            <?php } ?>
                            <?php if(isset($col['sortable'])){
                                if ($col['sortable']){ ?>
                                    ,"sortable": true
                                <?php }else
                                {?>
                                    ,"sortable": false
                                <?php }
                                
                            } ?>
                            <?php if(isset($col['className'])){?>
                                ,"className":"<?=$col['className']?>"
                            <?php } ?>
                        },
                    <?php }
                ?>
			],
			dataSrc:"data",
			processing: true,
			serverSide: true,
			ajax: "<?=$fetch_list_data_ajax_url?>"
		}).on('draw',function(){			
		});

		$('#tblList').on('click','.btn-view',function(event){
			event.preventDefault();
			//alert("test");
			t = $('#tblList').DataTable();			
            var trRow = $(this).parents('tr');
			data = t.row(trRow).data();
			window.location = "<?= base_url() ?>document/approval/" + data.fin_document_flow_control_id; 
		});
		




	});
</script>
<?php
	if (isset($script)){
		echo $script;
	}
?>
<!-- DataTables -->
<script src="<?=base_url()?>bower_components/datatables.net/datatables.min.js"></script>
<!--
<script src="<?=base_url()?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>bower_components/datatables.net/js/datetime.js"></script>
<script src="<?=base_url()?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
-->
