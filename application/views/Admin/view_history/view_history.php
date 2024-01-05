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
							<h4 class="page-title">View History</h4>
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
				<table class="table table-striped" id="HistoryTable">
					<thead>
					<tr>
						<td>#</td>
						<td>Template Name</td>
						<td>Subsidiary Account </td>
						<td>Company </td>
						<!-- <td>File</td> -->
						<td>Year</td>
						<td>Month</td>
						<td>Approve Status</td>
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
<script type="text/javascript">
	var base_url='<?php echo base_url(); ?>';
</script>
<script src="<?php echo base_url();?>assets/js/module/history/history.js"></script>
</div>
