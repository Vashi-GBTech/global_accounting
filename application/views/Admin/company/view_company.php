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
								<h4 class="page-title">Company Details</h4>
								<button class="btn btn-icon btn-primary xs_btn roundCornerBtn4" style="float: right" data-toggle="modal"
										data-target="#fire-modal-company" data-id="0" onclick="openModal()" id="companyFormButton"><i
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
					<table class="table table-striped" id="companyTable">
						<thead>
						<tr>
							<td>#</td>
							<td>Name</td>
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

<?php $this->load->view('Admin/company/company_form'); ?>
</div>
<?php $this->load->view('_partials/footer'); ?>
<script src="<?=base_url();?>assets/js/module/company/company.js" type="text/javascript"></script>
</div>
