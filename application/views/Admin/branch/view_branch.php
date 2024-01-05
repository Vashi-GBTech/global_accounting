<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<style>
	.error{
		color:red;
	}
</style>
<!-- Main Content -->
<div class="content-page">
	<div class="content">

		<div class="container">
			<div class="row">
				<div class="row">
					<div class="col-xs-12">
						<div class="page-title-box">
							<h4 class="page-title">Subsidiary Accounts Details</h4>
							<button class="btn btn-icon btn-primary roundCornerBtn4 xs_btn" style="float: right" onclick="openModal();" data-id="0" id="companyFormButton"><i
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

				<table class="table table-striped" id="BranchTable">
					<thead>
					<tr>
						<td>#</td>
						<td>Name</td>
						<td>Country</td>
						<td>Currency</td>
						<td>Currency Rate</td>
						<td>Type</td>
						<td>Percentage of share holder</td>
						<td>Subsidiary Account ID</td>
						<td>Status</td>
						<td>Action</td>
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
<?php $this->load->view('Admin/branch/branch_form'); ?>
<?php
$this->load->view('_partials/footer');
?>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
<script src="<?=base_url();?>assets/js/module/branch/branch.js" type="text/javascript"></script>
</div>
