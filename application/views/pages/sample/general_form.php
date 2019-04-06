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

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-header with-border">
				<h3 class="box-title">Horizontal Form</h3>
			</div>
			<!-- /.box-header -->

			<!-- form start -->
			<form class="form-horizontal">
				<div class="box-body">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
						<div class="col-sm-10">
							<input type="email" class="form-control" id="inputEmail3" placeholder="Email">
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-2 control-label">Password</label>
						<div class="col-sm-10">
							<input type="password" class="form-control" id="inputPassword3" placeholder="Password">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<div class="checkbox">
								<label>
									<input type="checkbox"> Remember me
								</label>
							</div>
						</div>
					</div>
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<button type="submit" class="btn btn-default">Cancel</button>
					<button type="submit" class="btn btn-info pull-right">Sign in</button>
				</div>
				<!-- /.box-footer -->
			</form>
		</div>
	</div>
</div>