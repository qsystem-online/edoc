<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="content-header">
	<h1>General Form Elements<small>Preview</small></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Forms</a></li>
		<li class="active">General Elements</li>
	</ol>
</section>

<?= $pagination ?>


<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-header with-border">
				<h3 class="box-title">Horizontal Form</h3>
			</div>
			<!-- /.box-header -->		
		
			<div class="box-body">
				<?= $pagination ?>
			</div>
			<!-- /.box-body -->
			<div class="box-footer">
				<button type="submit" class="btn btn-default">Cancel</button>
				<button type="submit" class="btn btn-info pull-right">Sign in</button>
			</div>
			<!-- /.box-footer -->
		
		</div>
	</div>
</div>