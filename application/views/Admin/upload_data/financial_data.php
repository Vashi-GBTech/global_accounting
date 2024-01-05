<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<div class="content-page">
	<div class="content">
		<div class="container">
			<div class="row">
				<div class="row">
					<div class="col-xs-12">
						<div class="page-title-box">
							<h4 class="page-title">Financial Data</h4>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="card-box">
					<table class="table table-striped" id="FinancialTable">
						<thead>
						<tr>
							<td>#</td>
							<td>Template Id</td>
							<td>Subsidiary Account Id</td>
							<td>Company Id</td>
							<td>Name</td>
							<td>Year</td>
							<td>Month</td>
							<td>Approve Status</td>
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
</div>
<script src="<?php echo base_url();?>assets/js/module/upload_data/financial_data.js"></script>
