<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<link rel="stylesheet" href="<?= base_url() ?>bower_components/select2/dist/css/select2.min.css">
<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
	<!-- Sidebar user panel -->
	<div class="user-panel">
		<div class="pull-left image">
			<img src="<?= base_url() ?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
		</div>
		<div class="pull-left info">
			<?php
			$active_user = $this->session->userdata("active_user");
			$branchs = $this->branch_model->getAllList();

			if ($active_user->fbl_central) { ?>
				<select id="active_branch_id" style="color:#000;width:150px">
					<?php
					print_r($branchs);
					$activeBranchId = $this->session->userdata("active_branch_id");
					foreach ($branchs as $branch) {
						$isActive = ($branch->fin_branch_id == $activeBranchId) ? "selected" : "";

						echo "<option value=" . $branch->fin_branch_id . " $isActive >" . $branch->fst_branch_name . "</option>";
					}
					?>
				</select>
			<?php
		}
		//echo $this->session->userdata("active_branch_id");
		//echo $active_user->fst_branch_name;
		?>
		</div>
		<div style="clear:both"></div>
		<div>

		</div>
	</div>
	<!-- sidebar menu: : style can be found in sidebar.less -->
	<ul class="sidebar-menu" data-widget="tree">
		<?= $this->menus->build_menu(); ?>
	</ul>
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
							<label for="select-branchname1" class="col-md-2 control-label">Branch</label>
							<div class="col-md-10">
								<select id="select-branchname1" class="form-control"></select>
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
</section>
<!-- /.sidebar -->
<script type="text/javascript">
	$(function() {
		$("#active_branch_id").change(function(event) {
			event.preventDefault();
			window.location = "<?= site_url() ?>user/change_branch/" + $("#active_branch_id").val();
		});
	});
</script>
<!-- Select2 -->
<script src="<?= base_url() ?>bower_components/select2/dist/js/select2.full.js"></script>