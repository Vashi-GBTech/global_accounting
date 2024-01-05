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
							<h4 class="page-title">Derived Account Setup</h4>
							<button class="btn btn-icon btn-primary roundCornerBtn4 xs_btn" style="float: right" onclick="openModal();" data-id="0" id="companyFormButton"><i
									class="fa fa-plus"></i></button>
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
<!--				<li class="nav-item unmatch" role="presentation">-->
<!--					<a-->
<!--						data-toggle="tab" href="#USD"-->
<!--						class="nav-link"-->
<!--						id="USD_data"-->
<!--						href=""-->
<!--						role="tab"-->
<!--						aria-selected="false" onclick="GetReportView(2,'reportMakerTableUSD',1)">US GAAP</a>-->
<!--				</li>-->
<!--				<li class="nav-item unmatch" role="presentation">-->
<!--					<a-->
<!--						data-toggle="tab" href="#IFRS"-->
<!--						class="nav-link"-->
<!--						id="IFRS_data"-->
<!--						href=""-->
<!--						role="tab"-->
<!--						aria-selected="false" onclick="GetReportView(3,'reportMakerTableIFRS',1)">IFRS</a>-->
<!--				</li>-->
			</ul>
		</div>
	</div>

	<div class="tab-content" style="padding:0;">
		<div id="IND" class="tab-pane active">
			<div class="row">

				<div class="col-lg-12">
					<div class="card-box" style="border: none">
					<table class="table table-striped" id="consoldateMonthsForDerivedFormula" style="width: 100%;">
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

<div class="modal fade" tabindex="-1" role="dialog" id="fire-modal-Derived"
	 aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Derived Accounts Details</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>

				<div class="modal-body py-0">
					<div class="card my-0 shadow-none">
						<div class="card-body">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<form id="uploadDerivedSetup" method="post" data-form-valid="uploadDerivedSetup" >
										<input type="hidden" class="form-control" name="update_id" id="update_id" value="">
										<div class="col-md-3 my-0 py-0">
											<label for="">Derived GL</label>
											<input type="text" class="form-control" name="derivedGL" id="derivedGL" value="">
										</div>
										<div class="col-md-3 my-0 py-0">
											<label for="">Detail</label>
											<input type="text" class="form-control" name="glDetail" id="glDetail" value="">
										</div>
										<div class="col-md-4 my-0 py-0">
											<label for="">Formula</label>
											<textarea type="text" class="form-control" name="derived_formula" id="derived_formula" style="min-height: 36px;height: 36px;"></textarea>
										</div>
										<div class="col-md-2 my-0 py-0">
											<button class="btn btn-primary mr-1 roundCornerBtn4 m-t-20" type="submit" >Submit</button>
										</div>
									</form>
								</div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<hr>

									<div class="col-md-12 tabbable-panel" style="padding: 0px !important;height: 70vh;overflow: auto;">
										<div class="tabbable-line">
											<ul class="nav nav-tabs nav-justified m-b-10" id="Alevel" role="tablist">
												<li class="nav-item match active" role="presentation">
													<a data-toggle="tab" href="#queryLevel" class="nav-link active" id="matched_data" role="tab" aria-selected="true" aria-expanded="true" onclick="getDerivedGlList()">Derived Mapping List</a>
												</li>
												<li class="nav-item unmatch" role="presentation">
													<a data-toggle="tab" href="#accLevel" class="nav-link" id="unmatched_data" role="tab" aria-selected="false" aria-expanded="false" onclick="">Formula Maker</a>
												</li>
											</ul>
											<div class="tab-content" style="padding:0;">
												<div id="accLevel" class="card tab-pane">
													<div class="col-md-12">
														<label>Formula Maker</label>
														<div class="col-md-12" style="padding: 0px!important;">

															<div>
																<textarea type="text" name="formulaMaker" id="formulaMaker" class="form-control"></textarea>
															</div>
															<div class=""><button class="btn btn-sm btn-link sign" onclick="pasteText('formulaMaker','+')">+ Addition</button>
																<button class="btn btn-sm btn-link sign" onclick="pasteText('formulaMaker','-')">- Substraction</button>
																<button class="btn btn-sm btn-link sign" onclick="pasteText('formulaMaker','*')">* multiplication</button>
																<button class="btn btn-sm btn-link sign" onclick="pasteText('formulaMaker','/')">/ Division</button> </div>
															<div class="text-right">
																<button class="btn btn-sm btn-link" onclick="copyTextFormula('formulaMaker',1)"><i class="fa fa-copy"> Copy</i></button>
																<button class="btn btn-sm btn-link" onclick="copyTextFormula('formulaMaker',2)"><i class="fa fa-cut"> Clear</i></button>
															</div>

														</div>
													</div>
													<div class="col-md-12 bg-white" style="padding: 0px !important;">
													<ul class="nav nav-tabs justify-content-center" role="tablist">
														<li class="nav-item active">
															<a class="nav-link " data-toggle="tab" href="#typePanel" role="tab">
																<i class="now-ui-icons objects_umbrella-13"></i> Type3
															</a>
														</li>
														<li class="nav-item">
															<a class="nav-link" data-toggle="tab" href="#type2Panel" role="tab">
																<i class="now-ui-icons shopping_cart-simple"></i> Type2
															</a>
														</li>
														<li class="nav-item">
															<a class="nav-link" data-toggle="tab" href="#type1Panel" role="tab">
																<i class="now-ui-icons shopping_shop"></i> Type1
															</a>
														</li>
														<li class="nav-item">
															<a class="nav-link" data-toggle="tab" href="#glPanel" role="tab">
																<i class="now-ui-icons ui-2_settings-90"></i> Gl Account
															</a>
														</li>
													</ul>
												<div class="tab-content" style="padding:0;">
													<div id="typePanel" class="tab-pane active" role="tabpanel">
														<label>Type3 </label>
														<select name="yearWise" class="form-control" onchange="changeYearWise(this.value)">
															<option value="1">Current Year</option>
															<option value="2">Previous Year</option>
															<option value="3">Previous To Previous Year</option>
														</select>
														<div class="">
															<table id="sidebar_group_table" class="table table-bordered" style="font-size: 10px;margin-top: 10px;">
																<thead>
																<tr>
																	<th>Type1</th>
																	<th>Type2</th>
																	<th>Type3</th>
																	<th>Divide</th>
																	<th colspan="4">#

																	</th>
																</tr>

																<tr><th></th>
																	<th></th>
																	<th></th>
																	<th></th>
																	<th>OB</th>
																	<th>Dr</th>
																	<th>Cr</th>
																	<th>Total</th>
																</tr>

																</thead>
																<tbody id="groupYearData">

																</tbody>
															</table>
														</div>
													</div>
													<div id="type2Panel" class="tab-pane">
														<label>Type2 </label>
														<select name="yearWise_table2" class="form-control" onchange="changeYearWise2(this.value)" style="margin-top: 10px;">
															<option value="1">Current Year</option>
															<option value="2">Previous Year</option>
															<option value="3">Previous To Previous Year</option>
														</select>
														<div class="">
															<div>Total of <input type="radio" name="type2PartC" value="" onclick="checkTypeRadioCheck('type2PartC','type2_partC')" checked> Part 1  <input type="radio" name="type2PartC" value="2" onclick="checkTypeRadioCheck('type2PartC','type2_partC')"> Part1+Part 2</div>
															<table id="sidebar_group_table_2" class="table table-bordered" style="font-size: 10px;margin-top: 10px;">
																<thead>
																<tr>
																	<th>Type1</th>
																	<th>Type2</th>
																	<th>OB</th>
																	<th>Dr</th>
																	<th>Cr</th>
																	<th>Total</th>
																</tr>

																</thead>
																<tbody id="groupYearData2">

																</tbody>
															</table>
														</div>
													</div>
													<div id="type1Panel" class="tab-pane">
														<label>Type1 </label>
														<select name="yearWise_table1" class="form-control" onchange="changeYearWise1(this.value)" style="margin-top: 10px;">
															<option value="1">Current Year</option>
															<option value="2">Previous Year</option>
															<option value="3">Previous To Previous Year</option>
														</select>
														<div class="">
															<div>Total of <input type="radio" name="type1PartC" value="" onclick="checkTypeRadioCheck('type1PartC','type1_partC')" checked> Part 1  <input type="radio" name="type1PartC" value="2" onclick="checkTypeRadioCheck('type1PartC','type1_partC')"> Part1+Part 2</div>
															<table id="sidebar_group_table_1" class="table table-bordered" style="font-size: 10px;margin-top: 10px;">
																<thead>
																<tr>
																	<th>Type1</th>
																	<th>OB</th>
																	<th>Dr</th>
																	<th>Cr</th>
																	<th>Total</th>
																</tr>

																</thead>
																<tbody id="groupYearData1">

																</tbody>
															</table>
														</div>
													</div>
													<div id="glPanel" class="tab-pane">
														<div class="col-md-12">
															<label>Gl Account</label>


															<select name="yearWise_table2" class="form-control" onchange="changeYearWiseGL(this.value)" style="margin-top: 10px;">
																<option value="1">Current Year</option>
																<option value="2">Previous Year</option>
																<option value="3">Previous To Previous Year</option>
															</select>
														</div>
														<div class="col-md-12" style="margin-top: 10px;font-size: 10px;" id="tableDiv">
															<table class="table table-bordered">
																<thead>
																<tr>
																	<th>Gl No./Type</th>
																	<th>Detail</th>
																	<th>Divide</th>
																	<th colspan="4">#</th>

																</tr>
																<tr>
																	<th></th>
																	<th></th>
																	<th></th>
																	<th>Ob</th>
																	<th>Dr</th>
																	<th>Cr</th>
																	<th>Total</th>

																</tr>
																</thead>
																<tbody id="gl_table">




																</tbody>
															</table>

														</div>
													</div>

												</div>

											</div>
												</div>
												<div id="queryLevel" class="card tab-pane active">
													<table class="table" id="derivedMappingTable">
														<thead>
														<tr>
															<th>Sr No.</th>
															<th>GL Account</th>
															<th>Detail</th>
															<th>Formula</th>
															<th>Action</th>
														</tr>
														</thead>
														<tbody></tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
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
<script src="<?php echo base_url(); ?>assets/js/module/Derived/derived_setup.js?version=<?=time()?>"></script>
<script type="text/javascript">
	var base_url = '<?php echo base_url(); ?>';
</script>

<script type="text/javascript">
	$(document).ready(function () {
		getConsolidatedMonths();
	});
	function openModal() {
		$("#fire-modal-Derived").modal('show');
	}
	$( "#fire-modal-Derived" ).on('shown.bs.modal', function(){
		getGlAccountData(1);
		groupYearData(1);
		groupYearData2(1);
		groupYearData1(1);
		getDerivedGlList();
	});
</script>

