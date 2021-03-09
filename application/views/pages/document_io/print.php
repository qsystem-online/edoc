<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//var_dump($data);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<!-- Bootstrap 3.3.7 -->
		<link rel="stylesheet" href="<?=base_url()?>bower_components/bootstrap/dist/css/bootstrap.min.css">
		<!-- jQuery 3 -->			
		<script src="<?=base_url()?>bower_components/jquery/dist/jquery.min.js"></script>				
		<!-- CONFIG JS -->
		<script src="<?=base_url()?>assets/system/js/config.js"></script>
		<!-- APP JS -->
		<script src="<?=base_url()?>assets/system/js/app.js"></script>
		<style>
			.print-label{
				color:#000;
				font-size:10pt;
				float:left;
				width:100px;
				font-weight:bold;
			}
			.print-content{
				color:#000;
				font-size:10pt;
				float:left;
				width:500px;
			}
			hr{
				border:1px solid #000 ;
			}
		</style>
	</head>
	<body style="width:800px">
		<div class="container" style="width:800px">
			<h3>Document Out</h3>
			<hr>
			<div class="row">
				<div class="col-md-2 print-label">Document</div>
				<div class="col-md-10 print-content">: <?=$fst_document_name?></div>
			</div>
			<div class="row">
				<div class="col-md-2 print-label">Peminjam </div>
				<div class="col-md-3 print-content">: <?=$fst_user_name?></div>
			</div>
			<div class="row">
				<div class="col-md-2 print-label">Tanggal</div>
				<div class="col-md-3 print-content">: <?=$fdt_io_datetime?></div>
			</div>
			<div class="row">
				<div class="col-md-2 print-label">Notes</div>
				<div class="col-md-10 print-content">: <?=$fst_notes?></div>
			</div>
			<div style="clear:both"></div>
			<hr>
			
			<div class="" style="text-decoration:underline">Tanda Tangan</div>
			
			<div class="" style="margin-top:60px;font-weight:bold" ><i><?=$fst_user_name?></i></div>
			<div class="" style=""><i><?=date("d-m-Y") ?></i></div>
			

		</div>
		

		<script type="text/javascript" info="define">
		</script>

		<script type="text/javascript" info="init">
			$(function(){				
			});
		</script>

		<script type="text/javascript" info="event">
			$(function(){
				
			});
		</script>

		<script type="text/javascript" info="function">
			
			
			
		</script>
	</body>
	<!-- Bootstrap 3.3.7 -->
	<script src="<?=base_url()?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
</html>
