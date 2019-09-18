<?php
	defined('BASEPATH') or exit('No direct script access allowed');
	$cekAvatar = APPPATH . '../assets/app/users/avatar/avatar_' . $this->aauth->get_user_id() . '.jpg';
	if (file_exists($cekAvatar)){
		$avatar = base_url() . 'assets/app/users/avatar/avatar_' . $this->aauth->get_user_id() . '.jpg';
	}else{
		$avatar = base_url() . 'assets/app/users/avatar/default.jpg';
	}
?>

<header class="main-header">
	<!-- Logo -->
	<a href="/edoc/home" class="logo">
		<!-- mini logo for sidebar mini 50x50 pixels -->
		<!-- <span class="alogo-mini"><b>Q</b>doc</span> -->
		<!-- logo for regular state and mobile devices -->
		<span class="alogo-lg"><b>Q</b>doc</span>
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
					<img src="<?=$avatar?>" class="user-image" alt="User Image">
						<span class="hidden-xs"> Halo,
							<?php
							$active_user = $this->session->userdata("active_user");
							echo $active_user->fst_fullname;
							?>
						</span>
					</a>
					<ul class="dropdown-menu">
						<!-- User image -->
						<li class="user-header" style="height:110px">
							
							<img src="<?=$avatar?>" class="user-image" alt="User Image">
							<?php 
								$activeUser = $this->aauth->user();								
								//print_r($activeUser);
							?>
							<p><?= $activeUser->fst_department_name ?> <small> <?= $activeUser->fst_group_name ?></small> </p>
						</li>
						<!-- Menu Body -->
						<li class="user-body" style="display:none"></li>

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
</script>