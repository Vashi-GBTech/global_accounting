<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<!-- Main Content -->
<div class="content-page">
	<div class="content">

		<div class="container">
			<div class="row">
				<div class="row">
					<div class="col-xs-12">
						<div class="page-title-box">
							<h4 class="page-title">Users</h4>
<!--							<button class="btn btn-icon btn-primary" style="float: right" data-toggle="modal"-->
<!--									data-target="#fire-modal-users" onclick="openModal()" data-id="0" id="UserFormButton"><i-->
<!--										class="fa fa-plus"></i></button>-->
							<button class="btn btn-icon btn-primary roundCornerBtn4 xs_btn" style="float: right" onclick="openModal()" data-id="0" id="UserFormButton"><i
										class="fa fa-plus"></i></button>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="card-box">
				<table class="table table-striped" id="UserTable">
					<thead>
					<tr>
						<td>#</td>
						<td>Name</td>
						<td>Status</td>
						<td>Edit</td>
						<td>Permissions</td>
					</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>


</div>
<?php
$this->load->view('Admin/users/user_form');
$this->load->view('_partials/footer'); ?>
<script src="<?php echo base_url();?>assets/js/module/user/user.js"></script>
</div>
