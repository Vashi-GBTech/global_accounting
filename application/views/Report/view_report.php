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
							<a href="<?php echo base_url();?>previousConsolidate" class="btn btn-icon btn-primary roundCornerBtn4" style="float: right" id="">Upload Previous</a>
							<a href="<?php echo base_url();?>consolidate" class="btn btn-icon btn-primary roundCornerBtn4" style="float: right;margin-right: 5px;" id=""><i
									class="fa fa-plus"></i></a>
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
				<table class="table table-striped" id="ReportTable">
					<thead>
					<tr>
						<td>#</td>
						<td>Year</td>
						<td>Month</td>
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
<script src="<?php echo base_url();?>assets/js/module/report/report.js"></script>
