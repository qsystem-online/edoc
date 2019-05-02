<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<header class="main-header">
	<!-- Logo -->
	<a href="/edoc/home" class="logo">
		<!-- mini logo for sidebar mini 50x50 pixels -->
		<span class="logo-mini"><b>A</b>LT</span>
		<!-- logo for regular state and mobile devices -->
		<span class="logo-lg"><b>Admin</b>LTE</span>
	</a>

	<!-- Header Navbar: style can be found in header.less -->
	<nav class="navbar navbar-static-top">
		<!-- Sidebar toggle button-->
		<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>

		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<!-- User Account: style can be found in dropdown.less -->
				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<span class="hidden-xs"> Halo,
							<?php
							$active_user = $this->session->userdata("active_user");
							echo $active_user->fst_fullname;
							?>
						</span>
					</a>
					<ul class="dropdown-menu">
						<!-- User image -->
						<li class="user-header">
							<img src="<?php $rs = $this->session->userdata('active_user');
										echo base_url() . 'assets/app/users/avatar/avatar_' . $rs->fin_user_id . '.jpg'; ?>" class="user-image" alt="User Image">
							<?php
							$active_user->fst_fullname ?> - Web Developer <small>Member since Nov. 2012</small></p>
						</li>
						<!-- Menu Body -->
						<li class="user-body">
							<p><i class="fa fa-circle text-success"></i>
								<?php
								$active_user = $this->session->userdata("active_user");
								echo $active_user->ActiveBranch;
								?>
							</p>
							<a href="<?= site_url() ?>/Change_branch"><i> Change Branch</i></a>
						</li>
						<!-- Menu Footer-->
						<li class="user-footer">
							<div class="pull-left"><a href="<?= site_url() ?>user/changepassword" class="btn btn-default btn-flat">Change Password</a></div>
							<div class="pull-right"><a href="<?= site_url() ?>signout" class="btn btn-default btn-flat">Sign out</a></div>
						</li>
					</ul>
				</li>

				<!-- Control Sidebar Toggle Button -->
				<li style="display:none;">
					<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
				</li>

			</ul>
		</div>
	</nav>
</header>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog" style="display:table">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Change Branch</h4>
			</div>

			<div class="modal-body">
				<form class="form-horizontal">
					<div class="form-group">
						<label for="select-branchname" class="col-md-2 control-label">Branch</label>
						<div class="col-md-10">
							<select id="select-branchname" class="form-control"></select>
						</div>
					</div>

				</form>

			</div>
			<div class="modal-footer">
				<button id="btn-change-branch" type="button" class="btn btn-primary">Change</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(function() {
		$(".sidebar-toggle").click(function() {
			if ($("body").hasClass("sidebar-collapse")) {
				setValue = 0;
			} else {
				setValue = 1;
			}

			$.ajax({
				url: "<?= site_url() ?>setting/set_sidebar_collapse/" + setValue
			});

		});
	});

	function changeBranch() {

		$("#myModal").modal({
			backdrop: 'dinamic',
		});

		$("#select-branchname").select2({
			width: '100%',
			ajax: {
				url: '<?= site_url() ?>user/get_branch',
				dataType: 'json',
				delay: 250,
				processResults: function(data) {
					data2 = [];
					$.each(data, function(index, value) {
						data2.push({
							"id": value.fin_branch_id,
							"text": value.fst_branch_name
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

	}
</script>