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
	.tabClass
	{
		width: 100%;
		text-align: left;
	}
	.collapse
	{
		background-color: #f3f3f3;
	}
	.btn-success:hover,.btn-success:active,.btn-success:focus {
		background-color: #c4d792 !important;
		border: 1px solid #c4d792 !important;
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
							<h4 class="page-title">Financial Report</h4>
							<a href="<?php echo base_url()?>tableReportMakerVarsion3/0" class="btn btn-icon btn-primary roundCornerBtn4 xs_btn" title="Create Template" style="float: right"
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
						aria-selected="true" onclick="GetReportView(1,'reportMakerTableIND',1)">IND AS</a>
				</li>
				<li class="nav-item unmatch" role="presentation">
					<a
						data-toggle="tab" href="#USD"
						class="nav-link"
						id="USD_data"
						href=""
						role="tab"
						aria-selected="false" onclick="GetReportView(2,'reportMakerTableUSD',1)">US GAAP</a>
				</li>
				<li class="nav-item unmatch" role="presentation">
					<a
						data-toggle="tab" href="#IFRS"
						class="nav-link"
						id="IFRS_data"
						href=""
						role="tab"
						aria-selected="false" onclick="GetReportView(3,'reportMakerTableIFRS',1)">IFRS</a>
				</li>
			</ul>
		</div>
	</div>

	<div class="tab-content" style="padding:0;">
		<div id="IND" class="tab-pane active">
			<div class="row">

				<div class="col-lg-12">
					<div class="card-box" style="border: none">
						<div class="row m-b-10">
							<div class="col-md-4" >
							</div>
							<div class="col-md-4" >
							</div>
							<div class="col-md-4" >
								<select name="filterIND" id="filterIND" class="form-control" onchange="GetReportView(1,'reportMakerTableIND',1);GetReportView(1,'reportMakerTableIND2',2);">
									<option value="1" selected>Active</option>
									<option value="2">Inactive</option>
									<option value="0">All</option>
								</select>
							</div>
						</div>

						<button type="button" class="btn btn-info tabClass" data-toggle="collapse" data-target="#mainReportIND" id="" onclick="GetReportView(1,'reportMakerTableIND',1)">Main Report</button>
						<div id="mainReportIND" class="collapse p-20 in">
								<table class="table table-striped" id="reportMakerTableIND" style="width: 100%;">
									<thead>
									<tr>
										<td>#</td>
										<td>Template Name</td>
										<td>View</td>
										<!--<td>Edit</td>
										<td>Action</td>-->
									</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
						</div>

						<button type="button" class="btn btn-success tabClass m-t-5" data-toggle="collapse" data-target="#scheduleReportIND" id="" onclick="GetReportView(1,'reportMakerTableIND2',2)">Schedule Report</button>
						<div id="scheduleReportIND" class="collapse p-20">
							<table class="table table-striped" id="reportMakerTableIND2" style="width: 100%;">
								<thead>
								<tr>
									<td>#</td>
									<td>Template Name</td>
									<td>View</td>
									<!--<td>Edit</td>
									<td>Action</td>-->
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
		<div id="USD" class="tab-pane">
			<div class="row">
				<div class="col-lg-12">
					<div class="card-box" style="border: none">
						<div class="row m-b-10">
							<div class="col-md-4" >
							</div>
							<div class="col-md-4" >
							</div>
							<div class="col-md-4" >
								<select name="filterUSD" id="filterUSD" class="form-control" onchange="GetReportView(2,'reportMakerTableUSD2',1);GetReportView(2,'reportMakerTableUSD',2);">
									<option value="1" selected>Active</option>
									<option value="2">Inactive</option>
									<option value="0" >All</option>
								</select>
							</div>
						</div>
						<button type="button" class="btn btn-info tabClass" data-toggle="collapse" data-target="#mainReportUSD" id="" onclick="GetReportView(2,'reportMakerTableUSD2',1)">Main Report</button>
						<div id="mainReportUSD" class="collapse p-20 in">
							<table class="table table-striped" id="reportMakerTableUSD2">
								<thead>
								<tr>
									<td>#</td>
									<td>Template Name</td>
									<td>View</td>
									<!--<td>Edit</td>
									<td>Action</td>-->
								</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
						<button type="button" class="btn btn-success tabClass m-t-5" data-toggle="collapse" data-target="#scheduleReportUSD" id="" onclick="GetReportView(2,'reportMakerTableUSD',2)">Schedule Report</button>
						<div id="scheduleReportUSD" class="collapse p-20">
							<table class="table table-striped" id="reportMakerTableUSD">
								<thead>
								<tr>
									<td>#</td>
									<td>Template Name</td>
									<td>View</td>
									<!--<td>Edit</td>
									<td>Action</td>-->
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
		<div id="IFRS" class="tab-pane">
			<div class="row">
				<div class="col-lg-12">
					<div class="card-box" style="border: none">
						<div class="row m-b-10">
							<div class="col-md-4" >
							</div>
							<div class="col-md-4" >
							</div>
							<div class="col-md-4" >
								<select name="filterIFRS" id="filterIFRS" class="form-control" onchange="GetReportView(3,'reportMakerTableIFRS',1);GetReportView(3,'reportMakerTableIFRS2',2);">
									<option value="1" selected>Active</option>
									<option value="2">Inactive</option>
									<option value="0" >All</option>
								</select>
							</div>
						</div>
						<button type="button" class="btn btn-info tabClass" data-toggle="collapse" data-target="#mainReportIFRS" id="" onclick="GetReportView(3,'reportMakerTableIFRS',1)">Main Report</button>
						<div id="mainReportIFRS" class="collapse p-20 in">
							<table class="table table-striped" id="reportMakerTableIFRS">
								<thead>
								<tr>
									<td>#</td>
									<td>Template Name</td>
									<td>View</td>
									<!--<td>Edit</td>
									<td>Action</td>-->
								</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
						<button type="button" class="btn btn-success tabClass m-t-5" data-toggle="collapse" data-target="#scheduleReportIFRS" id="" onclick="GetReportView(3,'reportMakerTableIFRS2',2)">Schedule Report</button>
						<div id="scheduleReportIFRS" class="collapse p-20">
							<table class="table table-striped" id="reportMakerTableIFRS2">
								<thead>
								<tr>
									<td>#</td>
									<td>Template Name</td>
									<td>View</td>
									<!--<td>Edit</td>
									<td>Action</td>-->
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


</div>
<?php $this->load->view('_partials/footer'); ?>

</div>

<script src="<?php echo base_url(); ?>assets/js/module/reportMaker/reportVersion3.js?version=<?=time()?>"></script>
<script type="text/javascript">
	var base_url = '<?php echo base_url(); ?>';
</script>

<script type="text/javascript">
	$(document).ready(function () {
		GetReportView(1,'reportMakerTableIND',1);
	});

</script>

