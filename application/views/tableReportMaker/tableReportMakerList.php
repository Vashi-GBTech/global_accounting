<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<style type="text/css">
	.nav-tabs.nav-justified>.active>a, .nav-tabs.nav-justified>.active>a:focus, .nav-tabs.nav-justified>.active>a:hover {
	    border-bottom-color: #fff;
	    background-color: #f7e3ad;
	    color: black;
	    text-shadow: 0px 4px 5px #00000055!important;
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
							<h4 class="page-title">Template List</h4>
							<a href="<?php echo base_url()?>tableReportMaker/0" class="btn btn-icon btn-primary roundCornerBtn4 xs_btn" title="Create Template" style="float: right"
									><i class="fa fa-plus"></i></a>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row bg-white">
					<div class="col-md-12">

						<ul class="nav nav-tabs nav-justified mb-3" id="ex1" role="tablist">
							<li class="nav-item match active" role="presentation">
								<a
										data-toggle="tab" href="#IND"
										class="nav-link active"
										id="IND_data"
										role="tab"
										aria-selected="true" onclick="GetReportView(1,'reportMakerTableIND')">IND</a>
							</li>
							<li class="nav-item unmatch" role="presentation">
								<a
										data-toggle="tab" href="#USD"
										class="nav-link"
										id="USD_data"
										href=""
										role="tab"
										aria-selected="false" onclick="GetReportView(2,'reportMakerTableUSD')">USD</a>
							</li>
							<li class="nav-item unmatch" role="presentation">
								<a
										data-toggle="tab" href="#IFRS"
										class="nav-link"
										id="IFRS_data"
										href=""
										role="tab"
										aria-selected="false" onclick="GetReportView(3,'reportMakerTableIFRS')">IFRS</a>
							</li>
						</ul>
					</div>
				</div>

				<div class="tab-content" style="padding:0;">
					<div id="IND" class="tab-pane active">
						<div class="row">
							<div class="col-lg-12">
								<div class="card-box" style="border: none">
									<table class="table table-striped" id="reportMakerTableIND">
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
					<div id="USD" class="tab-pane">
						<div class="row">
							<div class="col-lg-12">
								<div class="card-box" style="border: none">
									<table class="table table-striped" id="reportMakerTableUSD">
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
					<div id="IFRS" class="tab-pane">
						<div class="row">
							<div class="col-lg-12">
								<div class="card-box" style="border: none">
									<table class="table table-striped" id="reportMakerTableIFRS">
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

	
</div>


</div>
<?php $this->load->view('_partials/footer'); ?>

</div>

<script src="<?php echo base_url(); ?>assets/js/module/reportMaker/table_report_maker.js"></script>
<script type="text/javascript">
	var base_url = '<?php echo base_url(); ?>';
</script>

<script type="text/javascript">
	$(document).ready(function () {
		GetReportView(1,'reportMakerTableIND');
	});
</script>

