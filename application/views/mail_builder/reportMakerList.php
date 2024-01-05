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
							<h4 class="page-title">Financial Data</h4>
							<a href="<?php echo base_url()?>reportMaker/0" class="btn btn-icon btn-primary" title="Create Template" style="float: right"
									><i class="fa fa-plus"></i></a>
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
				<table class="table table-striped" id="reportMakerTable">
					<thead>
					<tr>
						<td>#</td>
						<td>Template Name</td>
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

<script src="<?php echo base_url(); ?>assets/js/module/reportMaker/report_maker.js"></script>
<script type="text/javascript">
	var base_url = '<?php echo base_url(); ?>';
</script>

<script type="text/javascript">
	$(document).ready(function () {
		GetReportView();
	});
</script>

