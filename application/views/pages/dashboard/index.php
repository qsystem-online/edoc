<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<section class="content-header">
	<h1><?= lang("Dashboard") ?></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> <?= lang("Home") ?></a></li>
		<li><a href="#"><?= lang("Menus") ?></a></li>
		<li class="active title"><?= $title ?></li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<h3>Documents</h3>
		</div>
	</div>

	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12">
		  <div class="info-box">
			<span class="info-box-icon bg-aqua"><i class="fa fa-check" aria-hidden="true"></i></span>
			<div class="info-box-content">
			  <span class="info-box-text"><label><?= lang("Ready to approve")?></label></span>
			  <span class="info-box-number">{ttlDocReadyApprove}</span>
			  <span class="info-box-more"><a href="{base_url}document/approval_list">more...</a></span>
			</div>
			<!-- /.info-box-content -->
		  </div>
		  <!-- /.info-box -->
		</div>
		<!-- /.col -->
		<div class="col-md-3 col-sm-6 col-xs-12">
		  <div class="info-box">
			<span class="info-box-icon bg-green"><i class="fa fa-pencil" aria-hidden="true"></i></span>
			<div class="info-box-content">
			  <span class="info-box-text"><label><?= lang("Need revision")?></label></span>
			  <span class="info-box-number">{ttlDocNeedRevision}</span>
			  <span class="info-box-more"><a href="{base_url}document/approval_list">more...</a></span>
			</div>
			<!-- /.info-box-content -->
		  </div>
		  <!-- /.info-box -->
		</div>
		<!-- /.col -->
		<div class="col-md-3 col-sm-6 col-xs-12">
		  <div class="info-box">
			<span class="info-box-icon bg-yellow"><i class="fa fa-files-o"></i></span>

			<div class="info-box-content">
			  <span class="info-box-text">Uploads</span>
			  <span class="info-box-number">13,648</span>
			</div>
			<!-- /.info-box-content -->
		  </div>
		  <!-- /.info-box -->
		</div>
		<!-- /.col -->
		<div class="col-md-3 col-sm-6 col-xs-12">
		  <div class="info-box">
			<span class="info-box-icon bg-red"><i class="fa fa-star-o"></i></span>

			<div class="info-box-content">
			  <span class="info-box-text">Likes</span>
			  <span class="info-box-number">93,139</span>
			</div>
			<!-- /.info-box-content -->
		  </div>
		  <!-- /.info-box -->
		</div>
		<!-- /.col -->
	</div>
</section>