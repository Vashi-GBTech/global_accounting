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
							<h4 class="page-title">Subsidiary Accounts Setup</h4>
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
				<table class="table table-striped table-responsive table-bordered" id="BranchTable">
					<thead>
					<tr>
						<td>#</td>
						<td>Name</td>
						<td>Country</td>
						<td>Currency</td>
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
<?php $this->load->view('_partials/footer'); ?>
<script src="<?php echo base_url();?>assets/js/module/Branch_Setup/branch_setup.js"></script>
</div>
